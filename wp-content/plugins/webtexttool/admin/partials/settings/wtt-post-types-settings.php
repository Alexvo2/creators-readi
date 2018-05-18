<?php
$post_types = get_post_types(array('public' => true), 'objects');

if (is_array($post_types) && $post_types !== array()) {
    foreach ($post_types as $post_type) {
        $name = $post_type->name;
        echo "<div id='" . esc_attr($name) . "-titles-settings'>";
        echo '<h3 id="' . esc_attr($name) . '">' . esc_html(ucfirst($post_type->labels->name)) . '</h3>';

        $wttform = WTT_Form::get_instance();
        $wttform->switch_field('hidemetabox-' . $name, array('off' => 'Show', 'on' => 'Hide'), 'options');

        echo '</div>';

    }
    unset($post_type);
}
unset($post_types);