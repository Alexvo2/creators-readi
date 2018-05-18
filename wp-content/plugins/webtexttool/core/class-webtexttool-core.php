<?php

/**
 * The core functionality of the plugin.
 *
 * @link       http://webtexttool.com
 * @since      1.0.0
 *
 * @package    Webtexttool
 * @subpackage Webtexttool/core
 */
class Webtexttool_Core
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

    protected $fields = array();

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
     * Renders the seo meta box on selected post types
     *
     */
    public function add_wtt_meta_box()
    {
        $post_types = get_post_types(array('public' => true));

        if (is_array($post_types) && $post_types !== array()) {
            foreach ($post_types as $post_type) {
                if ($this->wtt_metabox_hide($post_type) === false) {

                    add_meta_box('postwebtexttool', 'Webtexttool', array(
                        $this,
                        'inner_custom_box_wtt',
                    ), $post_type, 'side', 'high');
                }
            }
        }
    }

    /**
     * Renders the wtt social meta box on selected post types
     *
     */
    public function add_wtt_social_meta_box()
    {
        $post_types = get_post_types(array('public' => true), 'names');
        $wtt_social = get_option('wtt_social');

        if ($wtt_social['socialmetabox'] == "on") {
            add_meta_box('postwebtexttool-social', 'Webtexttool Social Meta Tags', array(
                $this,
                'wtt_social_meta_box',
            ), $post_types, 'normal', 'high');
        }
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
     * Require the html for the social metabox
     */
    public function wtt_social_meta_box()
    {
        require_once('partials/WTT_Social.php');
    }

    /**
     * Renders the core of the plugin and the hidden input fields
     *
     * @param array $post The post object
     */
    public function inner_custom_box_wtt($post)
    {
        ?>
        <script type="text/javascript">
            (function () {
                var existingWindowDotAngular = window.angular;
                var angular = (window.angular = {});

                <?php
                include dirname(__FILE__) . "/js/wtt-core.min.js";
                ?>

                angular.element(document).ready(function () {
                    angular.bootstrap(document.getElementById('wtt-dashboard'), ['wttDashboard']);
                    window.angular = existingWindowDotAngular;
                });
            })();
        </script>

        <?php

        include_once("partials/WTT_Core.php");

        wp_nonce_field('wttcallback', 'wttcontent');

        $keyword = get_post_meta($post->ID, '_wtt_post_keyword', true);
        $languageCode = get_post_meta($post->ID, '_wtt_post_languageCode', true);
        $tags = get_post_meta($post->ID, '_wtt_post_synonyms', true);

        echo '<input type="hidden" id="wtt-keyword-field" name="wtt_keyword_field"';
        echo ' value="' . sanitize_text_field($keyword) . '"/>';
        echo '<input type="hidden" id="wtt-language-code-field" name="wtt_language_code_field"';
        echo ' value="' . sanitize_text_field($languageCode) . '"/>';
        echo '<ul id="wttSynonymTags" name="wttSynonymTags" style="list-style:none;">';
        if(!empty($tags)) {
            foreach ($tags as $key => $n) : ?>
                <li><input type="hidden" id="wtt-synonym-tags" name="wtt_synonym_tags[]" value="<?php echo esc_attr($n); ?>"/></li>
                <?php
            endforeach;
        }
        echo '</ul>';
    }

    /**
     * Renders the seo description field on the edit page of a post type
     *
     * @param array $post The post object
     */
    function wtt_add_description_field($post)
    {
        $post_types = get_post_types(array('public' => true));
        $scr = get_current_screen();
        $unusedPostTypes = array("csshortcode", "acf", "acf-field-group", "vc_grid_item");

        if (is_array($post_types) && $post_types !== array()) {
            if ($this->wtt_metabox_hide($scr->post_type) === false && !in_array($scr->post_type, $unusedPostTypes)) {
                wp_nonce_field('wttcallback', 'wttcontent');

                $description = get_post_meta($post->ID, '_wtt_post_description', true);

                echo '<div id="descriptiondiv">';
                echo '<label for="wtt_post_description">';
                echo 'Add a page description';
                echo '</label>';
                echo '<button type="button" class="btn-info-d" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="This is the summary of your page that will be shown in the search results and what a potential visitor of your page will see. So it’s important to create a catchy description of your page."><i class="fa fa-question-circle"></i></button>';
                echo '<textarea id="wtt_description" placeholder="Page Description" name="wtt_post_description">' . $description . '</textarea>';
                echo '</div>';
            }
        }
    }

    /**
     * Hooks into the save post function and saves wtt seo fields
     *
     */
    function wtt_save_postdata($post_id)
    {
        // Check if our nonce is set.
        if (!isset($_POST['wttcontent']))
            return $post_id;

        $nonce = $_POST['wttcontent'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'wttcallback'))
            return $post_id;

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;

        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        // Sanitize user input.
        $keyword = stripslashes($_POST['wtt_keyword_field']);
        $description = stripslashes(str_replace(array("\r\n", "\r", "\n"), '', $_POST['wtt_post_description']));
        $languageCode = $_POST['wtt_language_code_field'];
        $pageScore = str_replace("%", '', $_POST['wtt_page_score_field']);
        $synonyms = isset($_POST['wtt_synonym_tags']) ? $_POST['wtt_synonym_tags'] : '';

        // Update the meta field in the database.
        if (isset($_POST['wtt_keyword_field']) && ($_POST['wtt_keyword_field']) <> "") {
            update_post_meta($post_id, '_wtt_post_keyword', $keyword);
        } else {
            delete_post_meta($post_id, '_wtt_post_keyword', $keyword);
        }

        if (isset($_POST['wtt_post_description']) && ($_POST['wtt_post_description']) <> "") {
            update_post_meta($post_id, '_wtt_post_description', $description);
        } else {
            delete_post_meta($post_id, '_wtt_post_description', $description);
        }

        if (isset($_POST['wtt_page_score_field']) && ($_POST['wtt_page_score_field']) <> "") {
            update_post_meta($post_id, '_wtt_page_score', $pageScore);
        } else {
            delete_post_meta($post_id, '_wtt_page_score', $pageScore);
        }

        if (isset($_POST['wtt_language_code_field']) && ($_POST['wtt_language_code_field']) <> "") {
            update_post_meta($post_id, '_wtt_post_languageCode', $languageCode);
        } else {
            delete_post_meta($post_id, '_wtt_post_languageCode', $languageCode);
        }

        if (isset($_POST['wtt_synonym_tags']) && ($_POST['wtt_synonym_tags']) <> "") {
            update_post_meta($post_id, '_wtt_post_synonyms', $synonyms);
        } else {
            delete_post_meta($post_id, '_wtt_post_synonyms', $synonyms);
        }

        return $post_id;
    }

    public function get_webtexttoolnonce_action()
    {
        return 'my_super_event';
    }

    /**
     * Saves the page settings in the WP Post Meta table
     *
     */
    public function wtt_process_ajax()
    {
        $output = array("message" => 'process server ajax failed'); // set default output message
        $action = $this->get_webtexttoolnonce_action(); // text used to generate or check the nonce.
        $option_key = "wtt_process_page_title";
        // check if the nonce and data exist, otherwise exit
        if (array_key_exists('nonce', $_POST) && array_key_exists('data', $_POST) && array_key_exists('postId', $_POST)) {
            $nonce = htmlentities($_POST['nonce']);
            if (wp_verify_nonce($nonce, $action)) {
                $data = $_POST['data'];
                $pageid = $_POST['postId'];

                // check if already exists, replaces update_post_meta
                if (get_post_meta($pageid, $option_key, true) !== false) {
                    $output['message'] = 'success update';
                    delete_post_meta($pageid, $option_key);
                }

                //add the post meta
                add_post_meta($pageid, $option_key, $data);
                $output['message'] = 'success add';
            }
        }

        header("Content-Type: application/json");
        echo json_encode($output);
        die();
    }

    /**
     * Ajax save call for content quality suggestions
     */
    public function wtt_save_content_quality_suggestions() {
        $output = array("message" => 'server ajax failed'); // set default output message
        $action = $this->get_webtexttoolnonce_action(); // text used to generate or check the nonce.
        $option_key = "wtt_content_quality_suggestions";

        // check if the nonce and data exist, otherwise exit
        if (array_key_exists('nonce', $_POST) && array_key_exists('data', $_POST) && array_key_exists('postId', $_POST)) {
            $nonce = htmlentities($_POST['nonce']);
            if (wp_verify_nonce($nonce, $action)) {
                $data = $_POST['data'];
                $pageid = $_POST['postId'];

                // check if already exists, replaces update_post_meta
                if (get_post_meta($pageid, $option_key, true) !== false) {
                    $output['message'] = $data;
                    delete_post_meta($pageid, $option_key);
                }

                //add the post meta
                add_post_meta($pageid, $option_key, $data);
                $output['message'] = $data;
            }
        }

        header("Content-Type: application/json");
        echo json_encode($output);
        die();
    }

    /**
     * Ajax save call for content quality settings
     */
    public function wtt_save_content_quality_settings() {
        $output = array("message" => 'server ajax failed'); // set default output message
        $action = $this->get_webtexttoolnonce_action(); // text used to generate or check the nonce.
        $option_key = "wtt_content_quality_settings";

        // check if the nonce and data exist, otherwise exit
        if (array_key_exists('nonce', $_POST) && array_key_exists('data', $_POST) && array_key_exists('postId', $_POST)) {
            $nonce = htmlentities($_POST['nonce']);
            if (wp_verify_nonce($nonce, $action)) {
                $data = $_POST['data'];
                $pageid = $_POST['postId'];

                // check if already exists, replaces update_post_meta
                if (get_post_meta($pageid, $option_key, true) !== false) {
                    $output['message'] = $data;
                    delete_post_meta($pageid, $option_key);
                }

                //add the post meta
                add_post_meta($pageid, $option_key, $data);
                $output['message'] = $data;
            }
        }

        header("Content-Type: application/json");
        echo json_encode($output);
        die();
    }

    /**
     * Converts Divi shortcodes from the editor content to html content
     */
    public function wtt_process_divi_shortcodes()
    {
        if (!wp_verify_nonce($_POST['nonce'], $this->get_webtexttoolnonce_action())) {
            die(-1);
        }

        $unprocessed_data = str_replace('\\', '', $_POST['unprocessed_data']);

        echo do_shortcode($unprocessed_data);

        die();
    }

    /**
     * Converts shortcodes for different plugins
     */
    public function wtt_process_shortcodes() {
        if (!wp_verify_nonce($_POST['nonce'], $this->get_webtexttoolnonce_action())) {
            die(-1);
        }

        $shortcodes = filter_input( INPUT_POST, 'data', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );

        $parsed_shortcodes = array();

        foreach ($shortcodes as $shortcode) {
            $parsed_shortcodes[] = array(
                'shortcode' => $shortcode,
                'output' => do_shortcode($shortcode),
            );
        }

        wp_die(wp_json_encode($parsed_shortcodes));
    }

    /**
     * Returns the TCB-saved post content, stripped of tags
     *
     * @return void
     */
    public function wtt_tve_editor_content()
    {
        $id = filter_input(INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT);

        global $post;
        $post = get_post($id);

        ob_start();
        $all_content = tve_editor_content($post->post_content, 'tcb_content');
        ob_end_clean();

        wp_send_json(array(
            'post_id' => $post->ID,
            'content' => $all_content,
        ));
    }

    /**
     * Ajax search for all the posts and returns the post data (label, link and type)
     *
     */
    public function wtt_ajax_search_posts()
    {
        $term = strtolower($_GET['term']);
        $suggestions = array();

        $loop = new WP_Query('s=' . $term);

        while ($loop->have_posts()) {
            $loop->the_post();
            $suggestion = array();
            $suggestion['label'] = get_the_title();
            $suggestion['link'] = get_permalink();
            $suggestion['type'] = get_post_type();

            $suggestions[] = $suggestion;
        }

        wp_reset_query();

        $response = json_encode($suggestions);
        echo $response;
        exit();
    }

    /**
     * Localizes plugin globals for the edit post page
     */
    public function wtt_core_plugin_data()
    {
        global $post;
        global $current_screen;
        $wtt_options = get_option('wtt_options');

        if ($current_screen->parent_base == 'edit' || $current_screen->base == 'post') {
            $objectContent = array(
                'siteUrl' => get_home_url(),
                'pluginsUrl' => plugin_dir_url(__FILE__),
                'postId' => $post->ID,
                'wtt_base_api_url' => WTT_BASE_API_URL,
                'authcode' => get_user_meta(get_current_user_id(), "webtexttool_auth", true),
                'permalink' => esc_url(get_permalink($post->ID)),
                'processPageTitleAsH1' => get_post_meta($post->ID, 'wtt_process_page_title', true),
                'pageScore' => get_post_meta($post->ID, '_wtt_page_score', true),
                'tve_updated_post' => preg_replace("/[\n\r]/", "", get_post_meta($post->ID, "tve_updated_post", true)),
                'wtt_short_url' => WTT_SHORT_URL,
                'fieldSelectorsACF' => $this->get_acf_field_selectors(),
                'blacklistTypeACF' => $this->get_acf_blacklist_type(),
                'wtt_shortcode_tags' => $this->get_shortcode_tags(),
                'vc_enabled' => get_post_meta($post->ID, '_wpb_vc_js_status', true) === 'true',
                'avia_enabled' => get_post_meta($post->ID, '_aviaLayoutBuilder_active', true) === 'active',
                'tcb_editor_enabled' => (int)get_post_meta($post->ID, 'tcb_editor_enabled', true) === 1,
                'acfVersion' => get_option('acf_version'),
                'acfOptionEnabled' => isset($wtt_options['enable-acf']) && $wtt_options['enable-acf'] === "on",
                'rwmbEnabled' => isset($wtt_options['enable-rwmb']) && $wtt_options['enable-rwmb'] === "on",
                'getLastSuggestions' => get_post_meta($post->ID, 'wtt_content_quality_suggestions', true),
                'getCQSettings' => get_post_meta($post->ID, 'wtt_content_quality_settings', true),
                'rwmbFields' => $this->fields
            );

            wp_localize_script('jquery', 'wtt_globals', $objectContent);
        }
    }

    /**
     * Returns all available shortcodes from wordpress
     * @return array
     */
    private function get_shortcode_tags() {
        $shortcode_tags = array();

        foreach ( $GLOBALS['shortcode_tags'] as $tag => $description ) {
            array_push( $shortcode_tags, $tag );
        }

        return $shortcode_tags;
    }

    private function get_acf_field_selectors()
    {
        if(class_exists('acf')) {
            return array(
                ".acf-taxonomy-field",
                "input[type=email][id^=acf]",
                "input[type=hidden].acf-image-value",
                "input[type=text][id^=acf]",
                "input[type=url][id^=acf]",
                "textarea[id^=acf]",
                "textarea[id^=wysiwyg-acf]"
            );
        }
        return "";
    }

    private function get_acf_blacklist_type() {
        if(class_exists('acf')) {
            return array(
                'number',
                'password',
                'file',
                'select',
                'checkbox',
                'radio',
                'true_false',
                'post_object',
                'page_link',
                'relationship',
                'user',
                'date_picker',
                'color_picker',
                'message',
                'tab',
                'repeater',
                'flexible_content',
                'group',
            );
        }
        return "";
    }

    public function enqueueRWMBFields( RW_Meta_Box $meta_box ) {
        // Only for posts.
        $screen = get_current_screen();
        if ( 'post' !== $screen->base ) {
            return;
        }

        // Get all field IDs that adds content.
        $this->add_fields( $meta_box->fields );

        if ( empty( $this->fields ) ) {
            return;
        }

        // Send list of fields to fields variable.
        return $this->fields;
    }

    protected function add_fields( $fields ) {
        array_walk( $fields, array( $this, 'add_field' ) );
    }

    protected function add_field( $field ) {
        // Add sub-fields recursively.
        if ( isset( $field['fields'] ) ) {
            $this->add_fields( $field['fields'] );
        }

        // Add the single field.
        if ( $this->is_analyzable( $field ) ) {
            $this->fields[] = $field['id'];
        }
    }

    protected function is_analyzable( $field ) {
        return ! in_array( $field['id'], $this->fields, true );
    }
}