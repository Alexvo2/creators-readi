<?php

/**
 * Smart Settings UI for Beaver Builder Plugin.
 * 
 * @wordpress-plugin
 * Plugin Name: 	Smart Settings UI
 * Plugin URI: 		https://www.wpbeaverworld.com/smart-settings-ui/
 * Description: 	Smartly control the row, column and module settings
 * Author: 			WP Beaver World
 * Author URI: 		https://www.wpbeaverworld.com/
 *
 * Version: 		1.1.1
 *
 * License: 		GPLv2 or later
 * License URI: 	http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Text Domain: 	bb-smart-settings-ui
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
  wp_die( __( "Sorry, you are not allowed to access this page directly.", 'bb-smart-settings-ui' ) );
}

//* Define constants
define( 'BBSUI_VERSION', 	'1.1.1' );
define( 'BBSUI_FILE', 		trailingslashit( dirname( __FILE__ ) ) . 'bb-smart-settings-ui.php' );
define( 'BBSUI_DIR', 		plugin_dir_path( BBSUI_FILE ) );
define( 'BBSUI_URL', 		plugins_url( '/', BBSUI_FILE ) );

//* Activate plugin
register_activation_hook( __FILE__, 'bbsui_activate' );
		
add_action( 'admin_init', 			'bbsui_plugin_deactivate' );
add_action( 'switch_theme', 		'bbsui_plugin_deactivate' );
add_action( 'plugins_loaded', 		'bbsui_load_textdomain' );
add_action( 'init', 				'bbsui_load_files' );
add_action( 'after_setup_theme', 	'bbsui_extender' );

/**
 * Callback function
 */ 
function bbsui_activate()
{
	if ( ! class_exists('FLBuilder') )
	{
		//* Deactivate ourself
		deactivate_plugins( __FILE__ );
		add_action( 'admin_notices', 'bbsui_admin_notice_message' );
		add_action( 'network_admin_notices', 'bbsui_admin_notice_message' );
		return;	
	}
}

/**
 * This function is triggered when the WordPress theme is changed.
 * It checks if the Beaver Builder Plugin is active. If not, it deactivates itself.
 */
function bbsui_plugin_deactivate()
{
	if ( ! class_exists('FLBuilder') )
	{
		//* Deactivate ourself
		deactivate_plugins( __FILE__ );
		add_action( 'admin_notices', 'bbsui_admin_notice_message' );
		add_action( 'network_admin_notices', 'bbsui_admin_notice_message' );
	}
}

/**
 * Shows an admin notice if you're not using the Beaver Builder Plugin.
 */
function bbsui_admin_notice_message()
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

	$error = __( 'Sorry, you can\'t use the Smart Settings UI add-on unless the Beaver Builder Plugin is active. The plugin has been deactivated.', 'bb-smart-settings-ui' );

	echo '<div class="error"><p>' . $error . '</p></div>';

	if ( isset( $_GET['activate'] ) )
	{
		unset( $_GET['activate'] );
	}
}

/**
 * Loads plugin.
 */ 
function bbsui_load_textdomain()
{
	//* Load textdomain for translation 
	load_plugin_textdomain( 'bb-smart-settings-ui', false, basename( BBSUI_DIR ) . '/languages' );
}

/**
 * Loads files.
 */ 
function bbsui_load_files()
{
	if( ! class_exists('FLBuilder') )
		return;

	// Classes
	require_once BBSUI_DIR . 'classes/class-bb-nodes-settings.php';
	require_once BBSUI_DIR . 'classes/class-bb-nodes-visibility.php';
	require_once BBSUI_DIR . 'classes/class-bb-nodes-code.php';
	
	if( is_admin() )
	{
		require_once BBSUI_DIR . 'classes/class-bbsui-admin.php';
		new BBSUIAdmin;

		require_once BBSUI_DIR . 'classes/class-bbsui-updater.php';
		new BBSUI_Plugin_Updater( 'https://www.wpbeaverworld.com/update-api/', BBSUI_VERSION );
	}
}

function bbsui_extender()
{
	if( ! class_exists('FLBuilder') )
		return;
	
	include_once BBSUI_DIR . 'includes/ui-extender.php';
}