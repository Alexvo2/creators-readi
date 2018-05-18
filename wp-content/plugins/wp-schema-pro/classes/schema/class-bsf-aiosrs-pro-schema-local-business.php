<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Local_Business' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Local_Business {

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
			$schema['@type']    = 'LocalBusiness';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['telephone'] ) && ! empty( $data['telephone'] ) ) {
				$schema['telephone'] = wp_strip_all_tags( $data['telephone'] );
			}

			if ( isset( $data['url'] ) && ! empty( $data['url'] ) ) {
				$schema['url'] = wp_strip_all_tags( $data['url'] );
			}

			if ( ( isset( $data['location-street'] ) && ! empty( $data['location-street'] ) ) ||
				( isset( $data['location-locality'] ) && ! empty( $data['location-locality'] ) ) ||
				( isset( $data['location-postal'] ) && ! empty( $data['location-postal'] ) ) ||
				( isset( $data['location-region'] ) && ! empty( $data['location-region'] ) ) ||
				( isset( $data['location-country'] ) && ! empty( $data['location-country'] ) ) ) {

				$schema['address']['@type'] = 'PostalAddress';

				if ( isset( $data['location-street'] ) && ! empty( $data['location-street'] ) ) {
					$schema['address']['streetAddress'] = wp_strip_all_tags( $data['location-street'] );
				}
				if ( isset( $data['location-locality'] ) && ! empty( $data['location-locality'] ) ) {
					$schema['address']['addressLocality'] = wp_strip_all_tags( $data['location-locality'] );
				}
				if ( isset( $data['location-postal'] ) && ! empty( $data['location-postal'] ) ) {
					$schema['address']['postalCode'] = wp_strip_all_tags( $data['location-postal'] );
				}
				if ( isset( $data['location-region'] ) && ! empty( $data['location-region'] ) ) {
					$schema['address']['addressRegion'] = wp_strip_all_tags( $data['location-region'] );
				}
				if ( isset( $data['location-country'] ) && ! empty( $data['location-country'] ) ) {
					$schema['address']['addressCountry'] = wp_strip_all_tags( $data['location-country'] );
				}
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

			if ( isset( $data['price-range'] ) && ! empty( $data['price-range'] ) ) {
				$schema['priceRange'] = wp_strip_all_tags( $data['price-range'] );
			}

			if ( isset( $data['hours-specification'] ) && ! empty( $data['hours-specification'] ) ) {
				foreach ( $data['hours-specification'] as $key => $value ) {
					$schema['openingHoursSpecification'][ $key ]['@type'] = 'OpeningHoursSpecification';
					$days = explode( ',', $value['days'] );
					$days = array_map( 'trim', $days );
					$schema['openingHoursSpecification'][ $key ]['dayOfWeek'] = $days;
					$schema['openingHoursSpecification'][ $key ]['opens']     = $value['opens'];
					$schema['openingHoursSpecification'][ $key ]['closes']    = $value['closes'];
				}
			}

			return apply_filters( 'wp_schema_pro_schema_local_business', $schema, $data, $post );
		}

	}
}
