<?php

/**
 * BBSUIAdmin class.
 *
 * @subpackage  classes
 * @package     bb-smart-settings-ui
 *
 * @author      WP Beaver World
 * @link        https://www.wpbeaverworld.com
 * @copyright   Copyright (c) 2017 WP Beaver World.
 *
 * @since       1.0
 */
class BBSUIAdmin {

	/**
	 * Options.
	 *
	 * @author    WP Beaver World
	 * @var       array
	 * @access    public
	 */
	static public $options;

	/**
	 * Get license key data
	 * Create admin menu pages
	 * Create a settings page
	 *
	 * @author  WP Beaver World
	 * @since   1.0
	 *
	 * @access  public
	 * @return  void
	 */
	function __construct()
	{
		self::$options = get_option( 'bbsui_options' );

		add_action( 'admin_menu', array( $this, 'bbsui_register_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'bbsui_activate_license_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'bbsui_admin_enqueue_scripts' ) );
	}

	/**
	 * Register sub menu page
	 *
	 * @author  WP Beaver World
	 * @since   1.0
	 *
	 * @access  public
	 * @return  void
	 */
	public function bbsui_register_admin_menu()
	{
		add_submenu_page( 'options-general.php', __( 'License Key Settings', 'bb-smart-settings-ui' ) , __( 'Smart Settings UI', 'bb-smart-settings-ui' ), 'manage_options', 'bbsui-activate-key', array( $this, 'render_options_form' ) );
	}

	/**
	 * Action on admin_init hook
	 *
	 * @author  WP Beaver World
	 * @since   1.0
	 *
	 * @access  public
	 * @return  void
	 */
	function bbsui_activate_license_settings()
	{
		
		register_setting( 'bbsui_activate_license', 'bbsui_license' );

		add_settings_section(
			'bbsui_license_key_section', 
			'<span class="bbsui-lkey-heading">' . __( 'License Settings', 'bb-smart-settings-ui' ) . '</span>', 
			array( $this, 'bbsui_license_callback' ), 
			'bbsui_activate_license'
		);

		add_settings_field( 
			'bbsui_license_key', 
			__( 'License Key', 'bb-smart-settings-ui' ), 
			array( $this, 'bbsui_license_key' ), 
			'bbsui_activate_license', 
			'bbsui_license_key_section' 
		);
	}

	/** 
	 * Callback function
	 *
	 * @author  WP Beaver World
	 *
	 * @since   1.0
	 * @access  public
	 * @return  void    
	 */
	function bbsui_license_callback() {
		echo '<p class="description desc">' . "\n";
		echo __( 'The license key is used for automatic upgrades and support.', 'bb-smart-settings-ui');
		echo '</p>' . "\n";
	}

	/**
	 * Activate the plugin for auto update & support
	 * Create settings form fields
	 *
	 * @author  WP Beaver World
	 * @since   1.0
	 *
	 * @access  public
	 * @return  void
	 */
	function bbsui_license_key() {
		$options      = self::$options;
		$license_key  = $options['bbsui_license_key'];
		$bbsui_nonce    = wp_create_nonce( 'bbsui-activate-key' );
		$class= $style = '';
	?>
		<input type="password" class="regular-text code" id="bbsui_license_key" name='bbsui_options[bbsui_license_key]' value="<?php echo esc_attr( $license_key ); ?>" />
		<?php if( ( get_option('bbsui_plugin_activate') == 'no' ) || ( get_option('bbsui_plugin_activate') == '' ) ) { $class=''; $style=' style="display:none;"'; ?>
			<input type="button" class="button" id="btn-activate-license" value="<?php _e( 'Activate', 'bb-smart-settings-ui' ); ?>" onclick="JavaScript: ActivateBBSUIPlugin( 'bbsui_license_key', 'activate', '<?php echo $bbsui_nonce; ?>');" />
			<div class="spinner" id="actplug"></div>
		<?php } ?> 
		<?php if( get_option('bbsui_plugin_activate') == 'expired' ) { $class=' error'; $style=' style="display:none;"'; ?>
			<input type="button" class="button" id="btn-reactivate-license" value="<?php _e( 'Reactivate', 'bb-smart-settings-ui' ); ?>" onclick="JavaScript: ActivateBBSUIPlugin( 'bbsui_license_key', 'reactivate', '<?php echo $bbsui_nonce; ?>');" />
			<div class="spinner"></div>
		<?php } ?>                                              
		<span class="bbsui-response<?php echo $class; ?>"<?php echo $style; ?>></span>
		<?php if( get_option('bbsui_plugin_activate') == 'expired' ) { ?>
			<div class="update-nag" style="color: #900"> <?php _e( 'Invalid or Expired Key : Please make sure you have entered the correct value and that your key is not expired.', 'bb-smart-settings-ui'); ?></div>
	<?php }
	}

	/**  
	 * Render options form
	 *
	 * @author  WP Beaver World
	 * @since   1.0
	 *
	 * @access  public
	 * @return  void
	 */
	function render_options_form() {
	?>
		<div class="wrap bbsui-options">
			<div id="icon-options-general" class="icon32"><br></div>
			<h2><?php _e( 'Smart Settings UI', 'bb-smart-settings-ui' ); ?> v<?php echo BBSUI_VERSION; ?></h2>
			<form action='options.php' method='post' class="bbsui-options-form" id="bbsui-options-form">
				<?php
					settings_fields( 'bbsui_activate_license' );
					do_settings_sections( 'bbsui_activate_license' );
				?>
			</form>
		</div>
	<?php
	}

	/**
	 * Enqueue scripts and styles
	 *
	 * @author  WP Beaver World
	 * @since   1.0
	 *
	 * @access  public
	 * @return  void
	 */
	function bbsui_admin_enqueue_scripts( $hook ) {
		if( $hook !== 'settings_page_bbsui-activate-key' )
			return;

		wp_register_style( 'bbsui-admin-css', BBSUI_URL . 'assets/css/bbsui-admin.css', array() );
		wp_enqueue_style( 'bbsui-admin-css'   );
		wp_enqueue_script( 'bbsui-admin-script', BBSUI_URL . 'assets/js/activate-plugin.js', array(), '1.0', true );
	}
}