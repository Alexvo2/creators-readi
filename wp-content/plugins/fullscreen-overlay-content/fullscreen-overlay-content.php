<?php

/**
 * Full Screen Overlay Content Plugin for Beaver Builder Plugin.
 * 
 * @wordpress-plugin
 * Plugin Name: 	Full Screen Overlay Content
 * Plugin URI: 		https://www.wpbeaverworld.com/full-screen-overlay-content/
 * Description: 	A Beaver Builder module which is displaying a row on full screen overlay modal box.
 * Author: 			WP Beaver World
 * Author URI: 		https://www.wpbeaverworld.com/
 *
 * Version: 		1.2.1
 *
 * License: 		GPLv2 or later
 * License URI: 	http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: 	fullscreen-overlay-content
 * Domain Path: 	languages  
 */

/**
 * Copyright (c) 2017 WP Beaver World. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 */

//* Prevent direct access to the plugin
if ( !defined( 'ABSPATH' ) ) {
  wp_die( __( "Sorry, you are not allowed to access this page directly.", 'fullscreen-overlay-content' ) );
}

//* Define constants
define( 'FSOC_VERSION', 	'1.2.1' );
define( 'FSOC_FILE', 		trailingslashit( dirname( __FILE__ ) ) . 'fullscreen-overlay-content.php' );
define( 'FSOC_DIR', 		plugin_dir_path( FSOC_FILE ) );
define( 'FSOC_URL', 		plugins_url( '/', FSOC_FILE ) );

//* Activate plugin
register_activation_hook( __FILE__, 'fsoc_activate' );
		
add_action( 'admin_init', 			'fsoc_plugin_deactivate' );
add_action( 'switch_theme', 		'fsoc_plugin_deactivate' );
add_action( 'plugins_loaded', 		'fsoc_load_textdomain' );
add_action( 'after_setup_theme', 	'fsoc_load_files' );
add_action( 'init', 				'fsoc_load_module', 2003 );

/**
 * Callback function
 */ 
function fsoc_activate()
{
	if ( ! class_exists('FLBuilder') )
	{
		//* Deactivate ourself
		deactivate_plugins( __FILE__ );
		add_action( 'admin_notices', 'fsoc_admin_notice_message' );
		add_action( 'network_admin_notices', 'fsoc_admin_notice_message' );
		return;	
	}
}

/**
 * This function is triggered when the WordPress theme is changed.
 * It checks if the Beaver Builder Plugin is active. If not, it deactivates itself.
 */
function fsoc_plugin_deactivate()
{
	if ( ! class_exists('FLBuilder') )
	{
		//* Deactivate ourself
		deactivate_plugins( __FILE__ );
		add_action( 'admin_notices', 'fsoc_admin_notice_message' );
		add_action( 'network_admin_notices', 'fsoc_admin_notice_message' );
	}
}

/**
 * Shows an admin notice if you're not using the Beaver Builder Theme and Plugin.
 */
function fsoc_admin_notice_message()
{
	if ( ! is_admin() ) {
		return;
	}
	else if ( ! is_user_logged_in() ) {
		return;
	}
	else if ( ! current_user_can( 'update_core' ) ) {
		return;
	}

	$error = __( 'Sorry, you can\'t use the Full Screen Overlay Content Plugin unless the Beaver Builder Plugin is active. The plugin has been deactivated.', 'fullscreen-overlay-content' );

	echo '<div class="error"><p>' . $error . '</p></div>';

	if ( isset( $_GET['activate'] ) )
	{
		unset( $_GET['activate'] );
	}
}

/**
 * Loads plugin.
 */ 
function fsoc_load_textdomain()
{
	//* Load textdomain for translation 
	load_plugin_textdomain( 'fullscreen-overlay-content', false, basename( FSOC_DIR ) . '/languages' );
}

/**
 * Loads files.
 */ 
function fsoc_load_files()
{
	if( ! class_exists('FLBuilder') )
		return;

	// Classes
	require_once FSOC_DIR . 'classes/class-fullscreen-overlay-content.php';

	if( is_admin() )
	{
		require_once FSOC_DIR . 'classes/class-fsoc-admin.php';
		new FSOCAdmin;

		require_once FSOC_DIR . 'classes/class-fsoc-updater.php';
		new FSOC_Plugin_Updater( 'https://www.wpbeaverworld.com/update-api/', FSOC_VERSION );
	}
}

/**
 * Loads module.
 */ 
function fsoc_load_module()
{
	if( ! class_exists('FLBuilder') )
		return;

	require_once FSOC_DIR . 'module/fullscreen-overlay-content/fullscreen-overlay-content.php';
}