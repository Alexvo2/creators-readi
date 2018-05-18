<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Webtexttool_Social
{

    /**
     * The ID of this plugin.
     *
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

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
     * Set the start string
     *
     * @return string
     */
    public function set_start()
    {
        return "\n<!-- Webtexttool WordPress Plugin v" . WTT_VERSION . " - https://www.webtexttool.com/ -->\n";
    }

    /**
     * Set the end string
     *
     * @return string
     */
    public function set_end()
    {
        return "<!-- / Webtexttool WordPress Plugin -->\n\n";
    }

    /**
     * Insert the meta tags in the header
     */
    public function set_header_meta()
    {
        $data = "";
        $data .= $this->set_start();
        $wtt_social = get_option("wtt_social");

        if (isset($wtt_social['canonical_url']) && $wtt_social['canonical_url'] == "on") {
            remove_action('wp_head', 'rel_canonical');
            $data .= $this->get_canonical_url();
        }

        if (isset($wtt_social['show_meta_desc']) && $wtt_social['show_meta_desc'] == "on" && $this->get_other_plugin_description()) {
            $data .= $this->get_description_meta() . "\n";
        }

        if (isset($wtt_social['socialmetabox']) && $wtt_social['socialmetabox'] == "on") {
            if (isset($wtt_social['opengraph']) && $wtt_social['opengraph'] == "on") {
                $data .= $this->get_opengraph_meta() . "\n";
            }

            if (isset($wtt_social['twitter']) && $wtt_social['twitter'] == "on") {
                $data .= $this->get_twittercard_meta() . "\n";
            }
        }

        $data .= $this->set_end();
        echo $data;
    }

    /**
     * Default get_post_meta function
     *
     * @param $meta
     * @return bool|string
     */
    private function getPostMeta($meta)
    {
        global $post;
        $postMeta = htmlspecialchars(get_post_meta($post->ID, $meta, true), ENT_QUOTES);

        if (empty($postMeta)) {
            return false;
        } else {
            return $postMeta;
        }
    }

    /**
     * Get the meta description
     *
     */
    private function get_description_meta()
    {
        $meta = "";
        $metaDescription = self::getPostMeta('_wtt_post_description');

        $meta .= (($metaDescription <> '') ? sprintf('<meta name="description" content="%s" />', $metaDescription) . "\n" : '');

        return $meta;
    }

    /**
     * Get the Open Graph Meta
     */
    private function get_opengraph_meta()
    {
        global $post;
        $meta = "";
        $wtt_social = get_option("wtt_social");

        $openGraphTitle = $this->get_custom_title();
        $openGraphImage = $this->get_custom_image();

        $meta .= sprintf('<meta property="og:url" content="%s" />', get_permalink($post->ID)) . "\n";

        $meta .= (($wtt_social['facebook-site'] <> '') ? sprintf('<meta property="article:publisher" content="https://facebook.com/%s" />', $wtt_social['facebook-site']) . "\n" : '');
        $meta .= (($openGraphImage <> '') ? sprintf('<meta property="og:image" content="%s" />', $openGraphImage) . "\n" : '');
        $meta .= (($openGraphTitle <> '') ? sprintf('<meta property="og:title" content="%s" />', $openGraphTitle) . "\n" : '');
        $meta .= sprintf('<meta property="og:description" content="%s" />', $this->get_custom_description()) . "\n";

        $meta .= ((get_bloginfo('name') <> '') ? sprintf('<meta property="og:site_name" content="%s" />', get_bloginfo('name')) . "\n" : '');

        $meta .= sprintf('<meta property="og:locale" content="%s" />', $wtt_social['wtt_og_locale']) . "\n";

        if (is_author()) {
            $author = get_queried_object();

            $meta .= sprintf('<meta property="og:type" content="%s" />', 'profile') . "\n";
            $meta .= sprintf('<meta property="profile:first_name" content="%s" />', get_the_author_meta('first_name', $author->ID)) . "\n";
            $meta .= sprintf('<meta property="profile:last_name" content="%s" />', get_the_author_meta('last_name', $author->ID)) . "\n";
        } else if (function_exists('is_product') && is_product()) {
            $meta .= sprintf('<meta property="og:type" content="%s" />', 'product') . "\n";

            $cat = get_the_terms($post->ID, 'product_cat');
            if (!empty($cat) && count($cat) > 0) {
                $meta .= sprintf('<meta property="product:category" content="%s" />', $cat[0]->name) . "\n";
            }
        } else if (!$this->check_if_home_page() && (is_single() || is_page())) {

            $meta .= sprintf('<meta property="og:type" content="%s" />', 'article') . "\n";
            $meta .= sprintf('<meta property="article:published_time" content="%s" />', get_the_time('c', $post->ID)) . "\n";
            $meta .= (($wtt_social['facebook-site'] <> '') ? sprintf('<meta property="article:author" content="https://facebook.com/%s" />', $wtt_social['facebook-site']) . "\n" : '');

            $category = get_the_category($post->ID);
            if (!empty($category) && $category[0]->cat_name <> 'Uncategorized') {
                $meta .= sprintf('<meta property="article:section" content="%s" />', $category[0]->cat_name) . "\n";
            }
            if (self::getPostMeta("_wtt_post_keyword") <> '') {
                $keywords = preg_split('/[,]+/', self::getPostMeta("_wtt_post_keyword"));
                if (is_array($keywords) && !empty($keywords)) {
                    foreach ($keywords as $keyword) {
                        $meta .= sprintf('<meta property="article:tag" content="%s" />', $keyword) . "\n";
                    }
                }
            }
        } else {
            $meta .= sprintf('<meta property="og:type" content="%s" />', 'website') . "\n";
        }

        return $meta;
    }

    /**
     * Get the Twitter Card Meta
     */
    private function get_twittercard_meta()
    {
        global $post;
        $meta = "";
        $wtt_social = get_option("wtt_social");

        $openGraphTitle = $this->get_custom_title();
        $openGraphImage = $this->get_custom_image();

        if (isset($wtt_social['twitter_card_type']) && $wtt_social['twitter_card_type'] <> '') {
            $meta .= sprintf('<meta name="twitter:card" content="%s" />', $wtt_social['twitter_card_type']) . "\n";
        }

        $meta .= (($wtt_social['twitter-site'] <> '') ? sprintf('<meta name="twitter:creator" content="%s" />', $this->get_twitter_account($wtt_social['twitter-site'])) . "\n" : '');
        $meta .= (($wtt_social['twitter-site'] <> '') ? sprintf('<meta name="twitter:site" content="%s" />', $this->get_twitter_account($wtt_social['twitter-site'])) . "\n" : '');

        $meta .= sprintf('<meta name="twitter:url" content="%s" />', get_permalink($post->ID)) . "\n";

        $meta .= (($openGraphImage <> '') ? sprintf('<meta name="twitter:image" content="%s" />', $openGraphImage) . "\n" : '');
        $meta .= (($openGraphTitle <> '') ? sprintf('<meta name="twitter:title" content="%s" />', $openGraphTitle) . "\n" : '');

        $meta .= sprintf('<meta name="twitter:description" content="%s" />', $this->get_custom_description()) . "\n";

        $meta .= ((get_bloginfo('name') <> '') ? sprintf('<meta name="twitter:domain" content="%s" />', get_bloginfo('name')) : '');

        return $meta;
    }

    /**
     * Checks if the page is a homepage
     *
     * @return bool
     */
    private function check_if_home_page()
    {
        global $wp_query;
        global $post;

        if (isset($wp_query->queried_object_id)) {
            $post = get_post($wp_query->queried_object_id);
        }

        if (is_home() && $wp_query->is_posts_page) {
            return false;
        }

        return (is_home() || (isset($wp_query->query) && empty($wp_query->query) && !is_preview()));
    }

    /**
     * Get the twitter account from the database
     *
     * @param string $twitterAccount
     * @return bool|string
     */
    private function get_twitter_account($twitterAccount)
    {
        if ($twitterAccount <> '') {
            if (strpos($twitterAccount, 'twitter.com') !== false) {
                preg_match('/twitter.com\/([@1-9a-z_-]+)/i', $twitterAccount, $matchResult);
                if (isset($matchResult[1]) && !empty($matchResult[1])) {
                    return '@' . str_replace('@', '', $matchResult[1]);
                }
            } else {
                preg_match('/([@1-9a-z_-]+)/i', $twitterAccount, $matchResult);
                if (isset($matchResult[1]) && !empty($matchResult[1])) {
                    return '@' . str_replace('@', '', $matchResult[1]);
                }
            }
        } else {
            return '';
        }
        return false;
    }

    /**
     * Checks if other plugins have description enabled
     *
     * @return bool
     */
    private function get_other_plugin_description()
    {
        if ($this->is_wp_seo_active()) {
            $wpseo = WPSEO_Frontend::get_instance();

            if ($wpseo->metadesc(false) !== '') {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Return part of a text based on min and max value
     *
     * @param $text
     * @param $min
     * @param $max
     * @return string
     */

    private function truncateDesc($text, $min, $max)
    {
        $text = str_replace(']]>', ']]&gt;', $text);
        $text = @preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $text);
        $text = strip_tags($text);

        $text = substr($text, $min, $max);
        return trim(stripcslashes($text));
    }

    /**
     * Return the default meta description from the post if open graph description field is empty
     * If both description fields are empty, post excerpt or post content overwrites the description tag
     *
     * @return string
     */
    private function get_custom_description()
    {
        global $post;
        $description = '';

        if ($post) {
            $description = $this->truncateDesc($post->post_excerpt, 0, 200);
            if (!$description) {
                $description = $this->truncateDesc($post->post_content, 0, 200);
            }

            if ($ogdescription = self::getPostMeta('_wtt_opengraph-description')) {
                $description = $ogdescription;
            } else if ($wtt_description = self::getPostMeta('_wtt_post_description')) {
                $description = $wtt_description;
            }
        }

        $description = preg_replace("/\s\s+/u", " ", $description);

        return $description;
    }

    /**
     * Return the default canonical url from the post if canonical field is empty
     *
     * @return string
     */
    private function get_canonical_url()
    {
        global $post;

        $meta = "";
        $url = self::getPostMeta('_wtt_canonical-link');

        if ($url <> '') {
            $meta .= sprintf('<link rel="canonical" href="%s" />', $url) . "\n";
        } else {
            $url = wp_get_canonical_url($post->ID);
            $meta .= sprintf('<link rel="canonical" href="%s" />', $url) . "\n";
        }

        return $meta;
    }


    /**
     * Return the default title from the post if og title is empty
     *
     * @return string
     */
    private function get_custom_title()
    {
        global $post;
        $title = '';

        if ($post) {
            $title = $post->post_title;

            if ($ogtitle = self::getPostMeta('_wtt_opengraph-title')) {
                $title = $ogtitle;
            }
        }

        return $title;
    }

    /**
     * Get image for meta data
     *
     * @return false|mixed|string
     */
    private function get_custom_image()
    {
        global $post;
        $imageisDone = false;
        $openGraphImage = '';
        $wtt_social = get_option("wtt_social");

        /**
         * If page is attachment
         */
        if (is_attachment()) {
            if ($temp = wp_get_attachment_image_src(null, 'full')) {
                $openGraphImage = trim($temp[0]);
                if (trim($openGraphImage) != '') {
                    $imageisDone = true;
                }
            }
        }

        /**
         * If specific image from post
         */
        if (!$imageisDone) {
            if (!empty($wtt_social['og_image_use_specific']) && $wtt_social['og_image_use_specific'] == "on") {
                if ($openGraphImage = self::getPostMeta('_wtt_opengraph-image')) {
                    if ($openGraphImage != '') {
                        $imageisDone = true;
                    }
                }
            }
        }

        /**
         * If featured image from post is active
         */
        if (!$imageisDone) {
            if (function_exists('get_post_thumbnail_id')) {
                if (!empty($wtt_social['og_image_use_featured']) && $wtt_social['og_image_use_featured'] == "on") {
                    if ($id_attachment = get_post_thumbnail_id($post->ID)) {
                        $openGraphImage = wp_get_attachment_url($id_attachment);
                        $imageisDone = true;
                    }
                }
            }
        }

        /**
         * If use default image specified in the settings screen
         */
        if (!$imageisDone) {
            if (!empty($wtt_social['og_image_use_default']) && $wtt_social['og_image_use_default'] == "on") {
                $openGraphImage = $wtt_social['opengraph_image'];
            } else {
                $openGraphImage = '';
            }
        }

        return $openGraphImage;
    }

    /**
     * Hooks into the save post function and saves wtt social meta tags
     *
     * @param $post_id
     * @return mixed
     */
    function wtt_save_social_meta($post_id)
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
        $openGraphTitle = stripslashes($_POST['wtt_opengraph-title']);
        $openGraphDescription = stripslashes(str_replace(array("\r\n", "\r", "\n"), '', $_POST['wtt_opengraph-description']));
        $openGraphImage = sanitize_text_field($_POST['wtt_opengraph-image']);
        $canonicalLink = sanitize_text_field($_POST['wtt_canonical-link']);

        // Update the meta field in the database if the field is not empty.
        if (isset($_POST['wtt_opengraph-title']) && ($_POST['wtt_opengraph-title']) <> "") {
            update_post_meta($post_id, '_wtt_opengraph-title', $openGraphTitle);
        } else {
            delete_post_meta($post_id, '_wtt_opengraph-title', $openGraphTitle);
        }

        if (isset($_POST['wtt_opengraph-description']) && ($_POST['wtt_opengraph-description']) <> "") {
            update_post_meta($post_id, '_wtt_opengraph-description', $openGraphDescription);
        } else {
            delete_post_meta($post_id, '_wtt_opengraph-description', $openGraphDescription);
        }

        if (isset($_POST['wtt_opengraph-image']) && ($_POST['wtt_opengraph-image']) <> "") {
            update_post_meta($post_id, '_wtt_opengraph-image', $openGraphImage);
        } else {
            delete_post_meta($post_id, '_wtt_opengraph-image', $openGraphImage);
        }

        if (isset($_POST['wtt_canonical-link']) && ($_POST['wtt_canonical-link']) <> "") {
            update_post_meta($post_id, '_wtt_canonical-link', $canonicalLink);
        } else {
            delete_post_meta($post_id, '_wtt_canonical-link', $canonicalLink);
        }

        return $post_id;
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
}