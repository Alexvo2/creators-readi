<?php
/**
 * Schemas Template.
 *
 * @package Schema Pro
 * @since 1.1.0
 */

if ( ! class_exists( 'BSF_AIOSRS_Pro_Schema_Site_Navigation_Element' ) ) {

	/**
	 * AIOSRS Schemas Initialization
	 *
	 * @since 1.1.0
	 */
	class BSF_AIOSRS_Pro_Schema_Site_Navigation_Element {

		/**
		 * Render Schema.
		 *
		 * @param  array $post Current Post Array.
		 * @return array
		 */
		public static function render( $post ) {
			$schema = array();

			$schema['@context'] = 'https://schema.org';
			$schema['@type']    = 'SiteNavigationElement';

			$names = array();
			$urls  = array();

			$settings = BSF_AIOSRS_Pro_Admin::get_options( 'wp-schema-pro-global-schemas' );
			if ( isset( $settings['site-navigation-element'] ) && ! empty( $settings['site-navigation-element'] ) ) {
				$navigation_links = wp_get_nav_menu_items( $settings['site-navigation-element'] );

				if ( $navigation_links ) {
					foreach ( $navigation_links as $link ) {
						$names[] = wp_strip_all_tags( $link->title );
						$urls[]  = esc_url( $link->url );
					}
				}
			}

			$schema['name'] = $names;
			$schema['url']  = $urls;

			return apply_filters( 'wp_schema_pro_global_schema_site_navigation_element', $schema, $post );
		}

	}
}
