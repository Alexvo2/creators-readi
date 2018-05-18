<?php

/**
 * FSOCAdmin class.
 *
 * @subpackage  classes
 * @package     fullscreen-overlay-content
 *
 * @author      WP Beaver World
 * @link        https://www.wpbeaverworld.com
 * @copyright   Copyright (c) 2016 WP Beaver World.
 *
 * @since       1.0
 */
class FSOCAdmin {

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
		self::$options = get_option( 'fsoc_options' );

		add_action( 'admin_menu', array( $this, 'fsoc_register_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'fsoc_activate_license_settings' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'fsoc_admin_enqueue_scripts' ) );
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
	public function fsoc_register_admin_menu()
	{
		add_submenu_page( 'options-general.php', __( 'License Key Settings', 'fullscreen-overlay-content' ) , __( 'FSOC License Key', 'fullscreen-overlay-content' ), 'manage_options', 'fsoc-activate-key', array( $this, 'render_options_form' ) );
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
	function fsoc_activate_license_settings()
	{
		
		register_setting( 'fsoc_activate_license', 'fsoc_license' );

		add_settings_section(
			'fsoc_license_key_section', 
			'<span class="fsoc-lkey-heading">' . __( 'License Settings', 'fullscreen-overlay-content' ) . '</span>', 
			array( $this, 'fsoc_license_callback' ), 
			'fsoc_activate_license'
		);

		add_settings_field( 
			'fsoc_license_key', 
			__( 'License Key', 'fullscreen-overlay-content' ), 
			array( $this, 'fsoc_license_key' ), 
			'fsoc_activate_license', 
			'fsoc_license_key_section' 
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
	function fsoc_license_callback() {
		echo '<p class="description desc">' . "\n";
		echo __( 'The license key is used for automatic upgrades and support.', 'fullscreen-overlay-content');
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
	function fsoc_license_key() {
		$options      = self::$options;
		$license_key  = $options['fsoc_license_key'];
		$fsoc_nonce    = wp_create_nonce( 'fsoc-activate-key' );
		$class= $style = '';
	?>
		<input type="password" class="regular-text code" id="fsoc_license_key" name='fsoc_options[fsoc_license_key]' value="<?php echo esc_attr( $license_key ); ?>" />
		<?php if( ( get_option('fsoc_plugin_activate') == 'no' ) || ( get_option('fsoc_plugin_activate') == '' ) ) { $class=''; $style=' style="display:none;"'; ?>
			<input type="button" class="button" id="btn-activate-license" value="<?php _e( 'Activate', 'fullscreen-overlay-content' ); ?>" onclick="JavaScript: ActivateFSOCPlugin( 'fsoc_license_key', 'activate', '<?php echo $fsoc_nonce; ?>');" />
			<div class="spinner" id="actplug"></div>
		<?php } ?> 
		<?php if( get_option('fsoc_plugin_activate') == 'expired' ) { $class=' error'; $style=' style="display:none;"'; ?>
			<input type="button" class="button" id="btn-reactivate-license" value="<?php _e( 'Reactivate', 'fullscreen-overlay-content' ); ?>" onclick="JavaScript: ActivateFSOCPlugin( 'fsoc_license_key', 'reactivate', '<?php echo $fsoc_nonce; ?>');" />
			<div class="spinner"></div>
		<?php } ?>                                              
		<span class="fsoc-response<?php echo $class; ?>"<?php echo $style; ?>></span>
		<?php if( get_option('fsoc_plugin_activate') == 'expired' ) { ?>
			<div class="update-nag" style="color: #900"> <?php _e( 'Invalid or Expired Key : Please make sure you have entered the correct value and that your key is not expired.', 'fullscreen-overlay-content'); ?></div>
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
		<div class="wrap fsoc-options">
			<div id="icon-options-general" class="icon32"><br></div>
			<h2><?php _e( 'FUll Screen Overlay Content Module (FSOCM)', 'fullscreen-overlay-content' ); ?> v<?php echo FSOC_VERSION; ?></h2>
			<form action='options.php' method='post' class="fsoc-options-form" id="fsoc-options-form">
				<?php
					settings_fields( 'fsoc_activate_license' );
					do_settings_sections( 'fsoc_activate_license' );
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
	function fsoc_admin_enqueue_scripts( $hook ) {
		if( $hook !== 'settings_page_fsoc-activate-key' )
			return;

		wp_register_style( 'fsoc-admin-css', FSOC_URL . 'assets/css/fsoc-admin.css', array() );
		wp_enqueue_style( 'fsoc-admin-css'   );
		wp_enqueue_script( 'fsoc-admin-script', FSOC_URL . 'assets/js/activate-plugin.js', array(), '1.0', true );
	}
}