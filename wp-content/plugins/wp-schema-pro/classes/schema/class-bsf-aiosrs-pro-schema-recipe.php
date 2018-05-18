<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Recipe' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Recipe {

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
			$schema['@type']    = 'Recipe';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['author'] ) && ! empty( $data['author'] ) ) {
				$schema['author']['@type'] = 'Person';
				$schema['author']['name']  = wp_strip_all_tags( $data['author'] );
			}

			if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
				$schema['description'] = wp_strip_all_tags( $data['description'] );
			}

			if ( isset( $data['preperation-time'] ) && ! empty( $data['preperation-time'] ) ) {
				$schema['prepTime'] = wp_strip_all_tags( $data['preperation-time'] );
			}

			if ( isset( $data['cook-time'] ) && ! empty( $data['cook-time'] ) ) {
				$schema['cookTime'] = wp_strip_all_tags( $data['cook-time'] );
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

			if ( isset( $data['nutrition'] ) && ! empty( $data['nutrition'] ) ) {
				$schema['nutrition']['@type']    = 'NutritionInformation';
				$schema['nutrition']['calories'] = wp_strip_all_tags( $data['nutrition'] );
			}

			if ( isset( $data['ingredients'] ) && ! empty( $data['ingredients'] ) ) {
				$schema['recipeIngredient'] = wp_strip_all_tags( $data['ingredients'] );
			}

			return apply_filters( 'wp_schema_pro_schema_recipe', $schema, $data, $post );
		}

	}
}
