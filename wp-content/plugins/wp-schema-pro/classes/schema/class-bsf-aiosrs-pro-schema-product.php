<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Product' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Product {

		/**
		 * Render Schema.
		 *
		 * @param  array $data Meta Data.
		 * @param  array $post Current Post Array.
		 * @return array
		 */
		public static function render( $data, $post ) {
			$schema = array();

			$schema['@context'] = 'https://schema.org';
			$schema['@type']    = 'Product';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
				$schema['description'] = wp_strip_all_tags( $data['description'] );
			}

			if ( isset( $data['brand-name'] ) && ! empty( $data['brand-name'] ) ) {
				$schema['brand']['@type'] = 'Thing';
				$schema['brand']['name']  = wp_strip_all_tags( $data['brand-name'] );
			}

			if ( ( isset( $data['rating'] ) && ! empty( $data['rating'] ) ) ||
				( isset( $data['review-count'] ) && ! empty( $data['review-count'] ) ) ) {

				$schema['aggregateRating']['@type'] = 'AggregateRating';

				if ( isset( $data['rating'] ) && ! empty( $data['rating'] ) ) {
					$schema['aggregateRating']['ratingValue'] = wp_strip_all_tags( $data['rating'] );
				}
				if ( isset( $data['review-count'] ) && ! empty( $data['review-count'] ) ) {
					$schema['aggregateRating']['reviewCount'] = wp_strip_all_tags( $data['review-count'] );
				}
			}

			$schema['offers']['@type'] = 'Offer';
			$schema['offers']['price'] = '0';
			if ( isset( $data['price'] ) && ! empty( $data['price'] ) ) {
				$schema['offers']['price'] = wp_strip_all_tags( $data['price'] );
			}

			if ( ( isset( $data['currency'] ) && ! empty( $data['currency'] ) ) ||
				( isset( $data['avail'] ) && ! empty( $data['avail'] ) ) ) {

				if ( isset( $data['currency'] ) && ! empty( $data['currency'] ) ) {
					$schema['offers']['priceCurrency'] = wp_strip_all_tags( $data['currency'] );
				}
				if ( isset( $data['avail'] ) && ! empty( $data['avail'] ) ) {
					$schema['offers']['availability'] = wp_strip_all_tags( $data['avail'] );
				}
			}

			return apply_filters( 'wp_schema_pro_schema_product', $schema, $data, $post );
		}

	}
}
