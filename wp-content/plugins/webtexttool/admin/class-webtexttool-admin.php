<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Webtexttool
 * @subpackage Webtexttool/admin
 */
class Webtexttool_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * @var  array  Array of defaults for the option
     */
    protected $defaults = array();

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the menu item and its submenus into the WordPress dashboard menu.
     *
     **/
    public function add_plugin_admin_menu()
    {
        $publish_posts_cap = 'publish_posts';

        add_menu_page('Webtexttool for Wordpress', 'Webtexttool', $publish_posts_cap, 'wtt_dashboard', null,
            plugin_dir_url(__FILE__) . 'images/webtexttool-16.png', '99.5');
        add_submenu_page(
            'wtt_dashboard',
            'Webtexttool for Wordpress',
            'Dashboard',
            $publish_posts_cap,
            'wtt_dashboard',
            array($this, 'display_plugin_setup_page')
        );
        add_submenu_page(
            'wtt_dashboard',
            'Settings',
            'Settings',
            'manage_options',
            'wtt_settings',
            array($this, 'display_plugin_settings_page')
        );
        add_submenu_page(
            'wtt_dashboard',
            'Social',
            'Social',
            'manage_options',
            'wtt_social',
            array($this, 'display_plugin_social_page')
        );
        add_submenu_page(
            'wtt_dashboard',
            'Tools',
            'Tools',
            'manage_options',
            'wtt_tools',
            array($this, 'display_plugin_tools_page')
        );
    }

    /**
     * Register the settings
     */
    public function wtt_register_settings()
    {
        register_setting('wtt_options', 'wtt_options');
    }

    /**
     * Register the social settings
     */
    public function wtt_register_social_settings()
    {
        register_setting('wtt_social', 'wtt_social');
    }

    /**
     * Render the admin page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page()
    {
        require_once('partials/dashboard/wtt-admin-display.php');
    }

    /**
     * Render the social page for this plugin.
     *
     * @since    1.2.4
     */
    public function display_plugin_social_page()
    {
        require_once('partials/social/wtt-social-settings-display.php');
    }

    /**
     * Includes the settings html page.
     */
    public function display_plugin_settings_page()
    {
        require_once('partials/settings/wtt-settings.php');
    }

    /**
     * Includes the tools page
     */
    public function display_plugin_tools_page()
    {
        require plugin_dir_path(__FILE__) . '/partials/tools/wtt-tools-import.php';
        require_once('partials/tools/wtt-tools.php');
    }

    /**
     * Enqueues custom CSS file for admin screen
     *
     * @since   1.1.2
     * @param   $hook String used to target a specific admin page
     */
    public function enqueue_custom_wtt_css($hook)
    {
        if ('edit.php' != $hook) {
            return;
        }

        wp_enqueue_style('wtt_custom_stylesheet', plugins_url('css/wtt-edit-page.min.css', __FILE__));
    }

    /**
     * Adds a Webtexttool Page Score column to the admin page
     *
     * @param array $columns Current set columns.
     *
     * @return array
     */
    public function set_custom_wtt_columns($columns)
    {
        return array_merge($columns,
            array('wttPageScore' => __('WTT Score')));
    }

    /**
     * Parses the column.
     *
     * @param string $column The current column.
     * @param integer $post_id ID of requested post.
     *
     * @return string
     */
    public function fill_custom_wtt_columns($column, $post_id)
    {
        switch ($column) {

            /* If displaying the 'wttPageScore' column. */
            case 'wttPageScore' :

                /* Get the post meta. */
                $pageScore = get_post_meta($post_id, '_wtt_page_score', true);
                $wttKeyword = get_post_meta($post_id, '_wtt_post_keyword', true);

                /* If no pageScore is found and no keyword, output a default message. */
                if (empty($pageScore) && empty($wttKeyword)) {
                    echo('<div class="wtt-score-text"><a href="' . get_edit_post_link($post_id) . '">Set your keyword</a></div>');
                } else if (empty($pageScore) && !empty($wttKeyword)) {
                    echo('<div class="wtt-score-text"><a href="' . get_edit_post_link($post_id) . '">Resave this page</a></div>');
                } else {
                    echo($this->create_score_color($pageScore));
                }

                break;

            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }

    /**
     * Hooks into admin_init, saves wtt_options for the first time
     *
     */
    public function update_wtt_settings()
    {
        $post_type_names = get_post_types(array('public' => true), 'names');

        if ($post_type_names !== array()) {
            foreach ($post_type_names as $pt) {
                $this->defaults['hidemetabox-' . $pt] = "off";
            }
            unset($pt);
        }

        if (!get_option('wtt_options')) {
            update_option('wtt_options', $this->defaults);
        }
    }

    /**
     * Hooks into admin_init, saves social options for the first time
     *
     */
    public function update_wtt_social_options()
    {
        $site_locale = get_locale();

        $options = array(
            'socialmetabox' => "on",
            'canonical_url' => "off",
            'show_meta_desc' => "on",
            'opengraph_image' => "",
            'og_image_use_specific' => "on",
            'og_image_use_featured' => "on",
            'og_image_use_default' => "on",
            'facebook-site' => "",
            'twitter-site' => "",
            'opengraph' => "on",
            'twitter' => "on",
            'twitter_card_type' => "summary_large_image",
            'wtt_og_locale' => $site_locale
        );

        if (!get_option('wtt_social')) {
            update_option('wtt_social', $options);
        }
    }

    /**
     * Creates the HTML and colors by the given values.
     *
     * @param $pageScore string The page score.
     *
     * @return string The HTML for a score color.
     */
    private function create_score_color($pageScore)
    {
        if ($pageScore < "35") {
            $cssClass = "bad";
        } else if ($pageScore >= "35" && $pageScore < "80") {
            $cssClass = "ok";
        } else {
            $cssClass = "good";
        }
        return '<div class="wtt-score-color ' . esc_attr($cssClass) . '">' . esc_attr($pageScore) . '%' . '</div>';
    }

    /**
     * Webtexttool nonce action
     *
     * @return string The nonce action
     */
    public function get_webtexttoolnonce_action()
    {
        return 'my_super_event';
    }

    /**
     * Saves the wtt access token in the WP User Meta table
     *
     */
    public function webtexttool_ajax()
    {
        $output = array("message" => 'server ajax failed'); // set default output message
        $action = $this->get_webtexttoolnonce_action(); // text used to generate or check the nonce.
        $option_key = "webtexttool_auth";
        if (array_key_exists('nonce', $_POST) && array_key_exists('data', $_POST)) {
            $nonce = htmlentities($_POST['nonce']);
            if (wp_verify_nonce($nonce, $action)) {
                $code = $_POST['data'];
                $user_id = get_current_user_id();

                // check if already exists, replaces update_user_meta
                if (get_user_meta($user_id, $option_key, true) !== false) {
                    $output['message'] = 'success';
                    delete_user_meta($user_id, $option_key);
                }

                //add the user meta
                add_user_meta($user_id, $option_key, $code);
                $output['message'] = 'success';
            }
        }

        header("Content-Type: application/json");
        echo json_encode($output);
        die();
    }

    /**
     * Adds a localized script to jQuery so it gets auto added to the page on Admin pages,
     * provides ajax url, ajax action, ajax nonce
     *
     */
    public function webtexttoolnonce()
    {
        $objectContent = array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce($this->get_webtexttoolnonce_action()),
            'action' => 'webtexttool'
        );

        wp_localize_script('jquery', 'webtexttoolnonce', $objectContent);
    }

    /**
     * Localizes plugin globals for the dashboard
     */
    public function wtt_admin_plugin_data() {
        global $current_screen;

        if ($current_screen->base == 'toplevel_page_wtt_dashboard') {
            $objectContent = array(
                'pluginsUrl' => plugin_dir_url(__FILE__),
                'wtt_base_api_url' => WTT_BASE_API_URL,
                'authcode' => get_user_meta(get_current_user_id(), "webtexttool_auth", true),
                'wtt_short_url' => WTT_SHORT_URL
            );

            wp_localize_script('jquery', 'wtt_admin_globals', $objectContent);
        }
    }

    /**
     * Add wp notice if other plugins are detected
     */
    public function wtt_plugin_notices()
    {
        $screen = get_current_screen();

        if (($screen->parent_base == 'edit' && $screen->base == 'post')) {

            wp_enqueue_script('wtt_custom_script', plugins_url('js/wtt-edit-page.min.js', __FILE__), array(), $this->version);

            if ($this->is_wp_seo_active()) {
                ?>
                <div style="position: relative; padding-right: 38px;"
                     class="notice notice-warning wtt-plugin-notice is-dismissable">
                    <p>
                        <img style="margin-bottom: -2px;"
                             src="<?php echo plugin_dir_url(__FILE__) . 'images/webtexttool-16.png' ?>"
                             alt="webtexttool logo">
                        <strong>The Yoast SEO plugin has been detected.</strong> The meta description will not be used
                        in the header.
                        Do you want to <a href="<?php echo esc_url(admin_url('admin.php?page=wtt_tools')) ?>"
                                          target="_blank">import its SEO data?</a>
                    </p>
                    <button type="button" class="wtt-notice notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span>
                    </button>
                </div>
                <?php
            }
        }
    }

    /**
     * If wp seo is active, return true
     *
     * @return bool
     */
    public function is_wp_seo_active()
    {
        if (defined('WPSEO_VERSION')) {
            return true;
        }
        return false;
    }

    /**
     * Dismiss the plugin notice
     */
    function dismiss_wtt_plugin_notice()
    {
        $output = array("message" => 'server ajax failed');
        $action = $this->get_webtexttoolnonce_action();
        if (array_key_exists('nonce', $_POST) && array_key_exists('data', $_POST)) {
            $nonce = htmlentities($_POST['nonce']);
            if (wp_verify_nonce($nonce, $action)) {
                $code = $_POST['data'];

                update_option('wtt-plugin-notice-dismissed', $code);
                $output['message'] = 'success';
            }
        }

        header("Content-Type: application/json");
        echo json_encode($output);
        die();
    }
}
