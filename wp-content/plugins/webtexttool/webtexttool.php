<?php

/**
 * @link              https://webtexttool.com
 * @since             1.0.0
 * @package           Webtexttool
 *
 * @wordpress-plugin
 * Plugin Name:       Webtexttool
 * Plugin URI:        https://webtexttool.com
 * Description:       Webtexttool is the easiest way to create SEO proof content to rank higher and get more traffic. Realtime optimization, keyword research and more.
 * Version:           1.8.2
 * Author:            Webtexttool
 * Author URI:        https://webtexttool.com
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       webtexttool
 * Domain Path:       /languages
 */

define('WTT_VERSION', '1.8.2');
define('WTT_SHORT_URL', "app.webtexttool.com");
define('WTT_BASE_API_URL', 'https://app.webtexttool.com/api/');

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_webtexttool()
{

}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_webtexttool()
{

}

register_activation_hook(__FILE__, 'activate_webtexttool');
register_deactivation_hook(__FILE__, 'deactivate_webtexttool');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and core specific hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-webtexttool.php';
require plugin_dir_path(__FILE__) . 'admin/class-webtexttool-form.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_webtexttool()
{
    new Webtexttool(WTT_VERSION);
}

run_webtexttool();
