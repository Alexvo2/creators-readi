<?php
/**
 * Brainstorm_Update_AIOSRS_Pro initial setup
 *
 * @package Schema Pro
 * @since 1.0.0
 */

if ( ! class_exists( 'Brainstorm_Update_AIOSRS_Pro' ) ) :

	/**
	 * Brainstorm Update
	 */
	class Brainstorm_Update_AIOSRS_Pro {

		/**
		 * Instance
		 *
		 * @var object Class object.
		 * @access private
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;

		}

		/**
		 * Constructor
		 */
		public function __construct() {

			self::version_check();
			add_action( 'init', array( $this, 'load' ), 999 );
			add_filter( 'bsf_get_license_message_wp-schema-pro', array( $this, 'license_message_aiosrs_pro' ), 10, 2 );
			add_filter( 'bsf_skip_braisntorm_menu', array( $this, 'skip_menu' ) );
			add_filter( 'bsf_skip_author_registration', array( $this, 'skip_menu' ) );
			add_filter( 'bsf_registration_page_url_wp-schema-pro', array( $this, 'get_registration_page_url' ) );
			add_filter( 'bsf_remove_wp-schema-pro_from_registration_listing', '__return_true' );
		}

		/**
		 * Get registration page url for aiosrs pro.
		 *
		 * @since  1.0.0
		 * @return String URL of the licnense registration page.
		 */
		public function get_registration_page_url() {
			$admin_url = BSF_AIOSRS_Pro_Admin::$default_menu_position . '?page=' . BSF_AIOSRS_Pro_Admin::$plugin_slug;
			$url       = admin_url( $admin_url );

			return $url;
		}

		/**
		 * Skip Menu.
		 *
		 * @param array $products products.
		 * @return array $products updated products.
		 */
		function skip_menu( $products ) {
			$products[] = 'wp-schema-pro';

			return $products;
		}

		/**
		 * Update brainstorm product version and product path.
		 *
		 * @return void
		 */
		public static function version_check() {

			$bsf_core_version_file = realpath( BSF_AIOSRS_PRO_DIR . '/admin/bsf-core/version.yml' );

			// Is file 'version.yml' exist?
			if ( is_file( $bsf_core_version_file ) ) {
				global $bsf_core_version, $bsf_core_path;
				$bsf_core_dir = realpath( BSF_AIOSRS_PRO_DIR . '/admin/bsf-core/' );
				$version      = file_get_contents( $bsf_core_version_file );

				// Compare versions.
				if ( version_compare( $version, $bsf_core_version, '>' ) ) {
					$bsf_core_version = $version;
					$bsf_core_path    = $bsf_core_dir;
				}
			}
		}

		/**
		 * Add Message for license.
		 *
		 * @param  string $content       get the link content.
		 * @param  string $purchase_url  purchase_url.
		 * @return string                output message.
		 */
		function license_message_aiosrs_pro( $content, $purchase_url ) {
			$message = "<p><a target='_blank' href='" . esc_url( $purchase_url ) . "'>" . esc_html__( 'Get the license >>', 'wp-schema-pro' ) . '</a></p>';
			return $message;
		}

		/**
		 * Load the brainstorm updater.
		 *
		 * @return void
		 */
		function load() {
			global $bsf_core_version, $bsf_core_path;
			if ( is_file( realpath( $bsf_core_path . '/index.php' ) ) ) {
				include_once realpath( $bsf_core_path . '/index.php' );
			}
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Brainstorm_Update_AIOSRS_Pro::get_instance();

endif;
