<?php 
defined( 'ABSPATH' ) || exit;
define( 'BREEZE_ADVANCED_CACHE', true );
if ( is_admin() ) { return; }
if ( ! @file_exists( '/home/172179.cloudwaysapps.com/axevaajjyu/public_html/wp-content/plugins/breeze/breeze.php' ) ) { return; }
if ( ! @file_exists( '/home/172179.cloudwaysapps.com/axevaajjyu/public_html/wp-content/breeze-config/breeze-config.php' ) ) { return; }
$GLOBALS['breeze_config'] = include('/home/172179.cloudwaysapps.com/axevaajjyu/public_html/wp-content/breeze-config/breeze-config.php' );
if ( empty( $GLOBALS['breeze_config'] ) || empty( $GLOBALS['breeze_config']['cache_options']['breeze-active'] ) ) { return; }
if ( @file_exists( '/home/172179.cloudwaysapps.com/axevaajjyu/public_html/wp-content/plugins/breeze/inc/cache/execute-cache.php' ) ) { include_once( '/home/172179.cloudwaysapps.com/axevaajjyu/public_html/wp-content/plugins/breeze/inc/cache/execute-cache.php' ); }
