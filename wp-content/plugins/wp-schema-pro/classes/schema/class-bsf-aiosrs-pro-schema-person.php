<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Person' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.0.0
	 */
	class BSF_AIOSRS_Pro_Schema_Person {

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
			$schema['@type']    = 'Person';

			if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
				$schema['name'] = wp_strip_all_tags( $data['name'] );
			}

			if ( isset( $data['image'] ) && ! empty( $data['image'] ) ) {
				$schema['image'] = BSF_AIOSRS_Pro_Schema_Template::get_image_schema( $data['image'] );
			}

			if ( isset( $data['job-title'] ) && ! empty( $data['job-title'] ) ) {
				$schema['jobTitle'] = wp_strip_all_tags( $data['job-title'] );
			}

			if ( isset( $data['telephone'] ) && ! empty( $data['telephone'] ) ) {
				$schema['telephone'] = wp_strip_all_tags( $data['telephone'] );
			}

			if ( isset( $data['homepage-url'] ) && ! empty( $data['homepage-url'] ) ) {
				$schema['url'] = esc_url( $data['homepage-url'] );
			}

			return apply_filters( 'wp_schema_pro_schema_person', $schema, $data, $post );
		}

	}
}
