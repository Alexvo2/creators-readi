<?php
//set_site_transient( 'update_plugins', null );
/**
 * Allows plugins to use their own update API.
 *
 * @subpackage  classes
 * @package     bb-smart-settings-ui
 * 
 * @author  WP Beaver World
 * @since   1.0
 */
class BBSUI_Plugin_Updater {
	private $api_url   = '';
	private $name      = '';
	private $slug      = '';
	private $options   = '';
	private $item_id   = '';

	/**
	 * Class constructor.
	 *
	 * @uses plugin_basename()
	 * @uses hook()
	 *
	 * @param   string    $_api_url       The URL pointing to the custom API endpoint.
	 * @param   string    $_plugin_file   Path to the plugin file.
	 * @param   float     $version        version of the plugin.   
	 * @return  void
	 */
	function __construct( $_api_url, $version ) {  
		$this->api_url  = trailingslashit( $_api_url );
		$this->name     = plugin_basename( BBSUI_FILE );
		$this->slug     = basename( dirname( $this->name ) );
		$this->version  = $version;
		$this->item_id  = 1021;
		$this->options  = get_option( 'bbsui_options' );

		// Set up hooks.
		$this->init();

		add_action( 'admin_footer', array( $this, 'bbsui_hide_message' ) );
		add_action( 'admin_init', array( $this, 'bbsui_show_changelog' ) );

		add_action('wp_ajax_bbsui_activate_plugin', array( $this, 'bbsui_activate_plugin' ) );
		add_action('wp_ajax_bbsui_reactivate_plugin', array( $this, 'bbsui_reactivate_plugin' ) );
	} 
  
	/**
	 * Set up WordPress filters to hook into WP's update process.
	 *
	 * @uses add_filter()
	 *
	 * @return void
	 */
	public function init() {    
		//* Plugin update actions
		add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_bbsui_plugin_update' ) );
		add_filter( 'plugins_api', array( $this, 'bbsui_plugin_api_call' ), 10, 3 );

		add_action( 'after_plugin_row_' . $this->name, array( $this, 'bbsui_show_update_notification' ), 10, 2 );
	}
  
	/**
	* Take over the update check
	*
	* @author  WP Beaver World
	* @since   1.0
	*/ 
	function check_bbsui_plugin_update( $checked_data ) {
		global $wp_version;

		//Comment out these two lines during testing.
		if ( empty( $checked_data->checked ) )
			return $checked_data;

		if( empty( $checked_data->checked[$this->slug .'/'. $this->slug .'.php'] ) )
			$version = $this->version;
		else
			$version = $checked_data->checked[$this->slug .'/'. $this->slug .'.php'];

		$args = array(
			'slug'    		=> $this->slug,
			'version' 		=> $version,
			'license_key' 	=> base64_encode( $this->options['bbsui_license_key'] )
		);

		$request_string = array(
			'body' => array(
				'action'  => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url')),
				'item_id' => $this->item_id
			),
		'	user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

		// Start checking for an update
		$raw_response = wp_remote_post( $this->api_url, $request_string );
		$response = '';

		if ( ! is_wp_error($raw_response) && ( $raw_response['response']['code'] == 200 ) ) {
			$response = unserialize($raw_response['body']);

			if ( is_object( $response ) && ! empty( $response ) ) {
				$checked_data->response[$this->slug .'/'. $this->slug .'.php'] = $response;

			if( $response->expired == 'yes' )
				update_option( 'bbsui_plugin_activate', 'expired' );
			}
		}

		return $checked_data;
	}
  
	/**
	 * Take over the Plugin info screen
	 *  
	 * @author  WP Beaver World
	 * @since   1.0
	 */ 
	function bbsui_plugin_api_call( $def, $action, $args )
	{
		global $wp_version;

		if ( $action != 'plugin_information' ) {
			return $def;                       
		}

		if (!isset($args->slug) || ($args->slug != $this->slug))
			return false;

		//* Get the current version
		$plugin_info     = get_site_transient('update_plugins');
		$current_version = $plugin_info->checked[$this->slug .'/'. $this->slug .'.php'];
		$args->slug      = $this->slug;
		$args->version   = $current_version;

		$request_string = array(
			'body' => array(
				'action'  => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url')),
				'item_id' => $this->item_id
			),
			'user-agent'     => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

		$request = wp_remote_post($this->api_url, $request_string);

		if ( is_wp_error( $request ) ) {
			$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request', 'bb-smart-settings-ui' ), $request->get_error_message());
		} else {
			$res = unserialize($request['body']);

			if ($res === false)
				$res = new WP_Error('plugins_api_failed', __( 'An unknown error occurred', 'bb-smart-settings-ui' ), $request['body']);
		}

		return $res;
	}
  
	/**
	 * Show update message and download now button
	 *  
	 * @author  WP Beaver World
	 * @since   1.0
	 */
	function bbsui_show_update_notification( $file, $plugin ) {
		global $wp_version;

		$bbsui_p_activate = get_option( 'bbsui_plugin_activate' );

		if( ! current_user_can( 'update_plugins' ) ) {
			return;
		}

		if ( $this->name != $file ) {
			return;
		}

		if( ! array_key_exists( 'new_version', $plugin ) )
			return;

		if ( version_compare( $this->version, $plugin['new_version'], '<' ) )
		{

			// build a plugin list row, with update notification
			$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
			echo '<tr id="' . $this->slug . '-update-row" class="plugin-update-tr active" data-plugin="' . $this->slug . '/' . $this->slug . '.php" data-slug="' . $this->slug . '"><td colspan="' . $wp_list_table->get_column_count() . '" class="plugin-update colspanchange"><div class="update-message">';

			$changelog_link = self_admin_url( 'index.php?bbsui_action=view_plugin_changelog&plugin=' . $this->name . '&slug=' . $this->slug . '&TB_iframe=true&width=772&height=911' );
			if( $bbsui_p_activate == 'expired' ) 
			{
				printf(
				__( 'There is a new version of %1$s available. <a target="_blank" class="thickbox" href="%2$s">View version %3$s details</a>. Your license key is expired. <a href="//www.wpbeaverworld.com/contact/">Contact here</a> to renew the license key.', 'bb-smart-settings-ui' ),
				esc_html( $plugin['Title'] ),
				esc_url( $changelog_link ),
				esc_html( $plugin['new_version'] )
				);
			}
			elseif( $bbsui_p_activate == 'no' || empty( $bbsui_p_activate ) )
			{
				printf(
				__( 'There is a new version of %1$s available. <a target="_blank" class="thickbox" href="%2$s">View version %3$s details</a>. Activate your license key to receive access to automatic updates and support. Need a license key? <a href="//www.wpbeaverworld.com/smart-settings-ui/">Purchase one now</a>.', 'bb-smart-settings-ui' ),
				esc_html( $plugin['Title'] ),
				esc_url( $changelog_link ),
				esc_html( $plugin['new_version'] )
				);
			} 
			else
			{
				printf(
				__( 'There is a new version of %1$s available. <a target="_blank" class="thickbox" href="%2$s">View version %3$s details</a> or <a href="%4$s">update now</a>.', 'bb-smart-settings-ui' ),
				esc_html( $plugin['Title'] ),
				esc_url( $changelog_link ),
				esc_html( $plugin['new_version'] ),
				esc_url( wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $this->name, 'upgrade-plugin_' . $this->name ) )
				);
			}

			echo '</div></td></tr>';
		}
	} 
  
	/**
	 * Display changelog info
	 *  
	 * @author  WP Beaver World
	 * @since   1.0
	 */
	function bbsui_show_changelog() {
		if( empty( $_REQUEST['bbsui_action'] ) || 'view_plugin_changelog' != $_REQUEST['bbsui_action'] ) {
			return;
		}

		if( empty( $_REQUEST['plugin'] ) ) {
			return;
		}

		if( empty( $_REQUEST['slug'] ) ) {
			return;
		}

		if( ! current_user_can( 'update_plugins' ) ) {
			wp_die( __( 'You do not have permission to install plugin updates', 'bb-smart-settings-ui' ), __( 'Error', 'bb-smart-settings-ui' ), array( 'response' => 403 ) );
		}

		$response = file_get_contents( '//www.wpbeaverworld.com/changelog/bbsui/changelog.txt' );

		if( $response ) {
			echo '<div style="background:#fff;padding:10px;">' . str_replace( "\n", "<br/>", $response ) . '</div>';
		}

		exit;
	}

	function bbsui_hide_message() {
		echo '<style type="text/css">#'. $this->slug .'-update{ display: none;}</style>';
	}
  
	/**
	 * Activate the plugin for support and updates
	 *  
	 * @author  WP Beaver World
	 * @since   1.0
	 */
	public function bbsui_activate_plugin() {

		check_ajax_referer( 'bbsui-activate-key', 'security' );

		$key = trim( esc_attr( $_POST['license_key'] ) );
		$msg = array( 
			'error_1' => __( 'You entered an invalid license key.', 'bb-smart-settings-ui' ),
			'error_2' => __( 'This key is already activated. Try a new license key.', 'bb-smart-settings-ui' ),
			'error_3' => __( 'This key is expired. Renew or purchase a new license key.', 'bb-smart-settings-ui' ),
			'success' => 200 
		);

		if( ! empty( $key ) ) {
			$details = $this->get_key_details( $key, 'check-license-key' );

			if( is_object( $details ) && ( ! empty( $details->error ) ) ) {

				if( $details->error == 'error_3')
					$status = 'expired';
				else
					$status = 'no';

				update_option('bbsui_plugin_activate', $status);        
				echo $msg[$details->error];

			} elseif( is_object( $details ) && ( isset( $details->success ) ) ) {

				update_option('bbsui_plugin_activate', 'yes');
				update_option("bbsui_options", array( 'bbsui_license_key' => $key ) );

				echo $msg[$details->success];

			} else {

				update_option('bbsui_plugin_activate', 'no');
				echo $details;

			}   
		}

		exit();
	}

	/**
	 * Reactivate the plugin if the license key is expired
	 *  
	 * @author  WP Beaver World
	 * @since   1.0
	 */
	public function bbsui_reactivate_plugin() {

		check_ajax_referer( 'bbsui-activate-key', 'security' );

		$key = trim( esc_attr( $_POST['license_key'] ) );
		$msg = array( 
			'error_1' => __( 'You entered an invalid license key or did not renew it.', 'bb-smart-settings-ui' ),
			'success' => 200 
		);

		if( ! empty( $key ) ) {
			$details = $this->get_key_details( $key, 'reactivate-key' );
			if( is_object( $details ) && ( ! empty( $details->error ) ) ) {

				update_option('bbsui_plugin_activate', 'expired');
				echo $msg[$details->error];

			} elseif( is_object( $details ) && ( isset( $details->success ) ) ) {

				update_option('bbsui_plugin_activate', 'yes');
				update_option("bbsui_options", array( 'bbsui_license_key' => $key ) );
				echo $msg[$details->success];

			} else {

				update_option('bbsui_plugin_activate', 'expired');
				echo $details;

			}
		}

		exit();
	}

	/**
	 * Checking the license key
	 *  
	 * @author  WP Beaver World
	 * @since   1.0
	 */  
	public function get_key_details( $key, $action ) {
		global $wp_version;

		$api_url = $this->api_url . 'check-key.php';    
		$request_string = array(
			'body' => array(
				'action'  => $action, 
				'request' => serialize($key),
				'api-key' => md5(get_bloginfo('url')),
				'item_id' => $this->item_id
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);

		$request = wp_remote_post($api_url, $request_string);

		if (is_wp_error($request)) {
			$res = new WP_Error('plugins_api_failed', __('<p>An Unexpected HTTP Error occurred during the API request.</p>'), $request->get_error_message());
			return $res->errors['plugins_api_failed'][0];
		} else {
			$res = unserialize($request['body']);

			if ($res === false) {
				$res = new WP_Error('plugins_api_failed', __( 'An unknown error occurred', 'bb-smart-settings-ui' ), $request['body']);
				return $res->errors['plugins_api_failed'][0];
			}
		}

		return $res;
	}
}