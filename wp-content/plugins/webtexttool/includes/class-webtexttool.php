<?php

/**
 * The core plugin class.
 *
 * Maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Webtexttool
 * @subpackage Webtexttool/includes
 */
class Webtexttool
{

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the core side of the plugin.
     *
     * @since    1.0.0
     * @param $version
     */
    public function __construct($version)
    {

        $this->plugin_name = 'webtexttool';
        $this->version = $version;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_core_hooks();
        $this->define_social_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Webtexttool_i18n. Defines internationalization functionality.
     * - Webtexttool_Admin. Defines all hooks for the admin area.
     * - Webtexttool_Core. Defines all hooks for the core side of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-webtexttool-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-webtexttool-admin.php';

        /**
         * The class responsible for defining all actions that occur in the core of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'core/class-webtexttool-core.php';

        /**
         * The class responsible for rendering the social meta on the front-end
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'core/class-webtexttool-social.php';
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Webtexttool_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {

        $plugin_i18n = new Webtexttool_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());

        add_action('plugins_loaded', array($plugin_i18n, 'load_plugin_textdomain'));

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Webtexttool_Admin($this->get_plugin_name(), $this->get_version());
        $post_types = get_post_types(array('public' => true), 'names');

        add_action('admin_menu', array($plugin_admin, 'add_plugin_admin_menu'), 5);

        add_action('wp_ajax_webtexttool', array($plugin_admin, 'webtexttool_ajax'));

        add_action('admin_print_scripts', array($plugin_admin, 'webtexttoolnonce'));

        add_action('admin_print_scripts', array($plugin_admin, 'wtt_admin_plugin_data'));

        if (is_array($post_types) && $post_types !== array()) {
            foreach ($post_types as $type) {
                if ($this->wtt_metabox_hide($type) === false) {
                    add_filter('manage_' . $type . '_posts_columns', array($plugin_admin, 'set_custom_wtt_columns'), 10, 1);
                    add_action('manage_' . $type . '_posts_custom_column', array($plugin_admin, 'fill_custom_wtt_columns'), 10, 2);
                }
            }
            unset($pt);
        }

        add_action('admin_enqueue_scripts', array($plugin_admin, 'enqueue_custom_wtt_css'));

        add_action('init', array($plugin_admin, 'update_wtt_settings'), 99);
        add_action('init', array($plugin_admin, 'update_wtt_social_options'), 98);

        add_action('admin_init', array($plugin_admin, 'wtt_register_settings'));
        add_action('admin_init', array($plugin_admin, 'wtt_register_social_settings'));

        if (!get_option("wtt-plugin-notice-dismissed")) {
            add_action('admin_notices', array($plugin_admin, 'wtt_plugin_notices'));
        }

        add_action('wp_ajax_webtexttool_dismiss_wtt_notice', array($plugin_admin, 'dismiss_wtt_plugin_notice'));
    }

    /**
     * Register all of the hooks related to the core of the plugin
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_core_hooks()
    {

        $plugin_core = new Webtexttool_Core($this->get_plugin_name(), $this->get_version());

        add_action('admin_print_scripts', array($plugin_core, 'wtt_core_plugin_data'));

        // Add meta boxes
        add_action('add_meta_boxes', array($plugin_core, 'add_wtt_meta_box'));
        add_action('add_meta_boxes', array($plugin_core, 'add_wtt_social_meta_box'));

        // Add description field (after title)
        add_action('edit_form_after_title', array($plugin_core, 'wtt_add_description_field'));

        // Save post data
        add_action('save_post', array($plugin_core, 'wtt_save_postdata'));

        // Ajax
        add_action('wp_ajax_webtexttool_process_page_title', array($plugin_core, 'wtt_process_ajax'));
        add_action('wp_ajax_webtexttool_convert_divi_shortcodes', array($plugin_core, 'wtt_process_divi_shortcodes'));
        add_action('wp_ajax_webtexttool_search_posts', array($plugin_core, 'wtt_ajax_search_posts'));
        add_action('wp_ajax_webtexttool_convert_shortcodes', array($plugin_core, 'wtt_process_shortcodes'));
        add_action('wp_ajax_webtexttool_tve_editor_content', array($plugin_core, 'wtt_tve_editor_content'));
        add_action('wp_ajax_webtexttool_content_quality_suggestions', array($plugin_core, 'wtt_save_content_quality_suggestions'));
        add_action('wp_ajax_webtexttool_content_quality_settings', array($plugin_core, 'wtt_save_content_quality_settings'));
        add_action('rwmb_enqueue_scripts', array( $plugin_core, 'enqueueRWMBFields'));

    }

    /**
     * Register all of the hooks related to the social meta of the plugin
     *
     * @since    1.3.0
     * @access   private
     */
    private function define_social_hooks()
    {

        $plugin_social = new Webtexttool_Social($this->get_plugin_name(), $this->get_version());

        add_action('wp_head', array($plugin_social, 'set_header_meta'));
        add_action('save_post', array($plugin_social, 'wtt_save_social_meta'));

    }

    /**
     * Checks if the webtexttool seo metabox is hidden or not
     *
     * @param  string $post_type (optional) The post type to test
     *
     * @return  bool        True or false
     */
    function wtt_metabox_hide($post_type = null)
    {
        if (!isset($post_type) && (isset($GLOBALS['post']) && (is_object($GLOBALS['post']) && isset($GLOBALS['post']->post_type)))) {
            $post_type = $GLOBALS['post']->post_type;
        }

        if (isset($post_type)) {
            $post_types = get_post_types(array('public' => true), 'names');
            $options = get_option('wtt_options');

            return ((isset($options['hidemetabox-' . $post_type]) && $options['hidemetabox-' . $post_type] === "on") || in_array($post_type, $post_types) === "off");
        }
        return false;
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

}
