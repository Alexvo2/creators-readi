<?php

class WTT_Form {

    /**
     * @var object    Instance of this class
     */
    public static $instance;

    /**
     * Get the singleton instance of this class
     *
     * @return WTT_Form
     */
    public static function get_instance() {
        if ( ! ( self::$instance instanceof self ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Handles the switch field for the settings page
     *
     * @param string $var the variable
     * @param array $values the options to choose from
     * @param string $type the type of wp option to save
     */
    public function switch_field($var, $values, $type)
    {

        $option_name = '';

        switch ($type) {
            case 'options':
                $option_name = 'wtt_options';
                $options = get_option($option_name);
                break;
            case 'social':
                $option_name = 'wtt_social';
                $options = get_option($option_name);
                break;
        }

        if (!is_array($values) || $values === array()) {
            return;
        }
        if (!isset($options[$var])) {
            $options[$var] = false;
        }
        if ($options[$var] === true) {
            $options[$var] = 'on';
        }
        if ($options[$var] === false) {
            $options[$var] = 'off';
        }

        $var_esc = esc_attr($var);

        echo '<div class="wtt-switch-container">';
        echo '<div id="' . $var_esc . '"><div class="wtt-switch-field">';

        foreach ($values as $key => $value) {
            $key_esc = esc_attr($key);
            $for = $var_esc . '-' . $key_esc;
            echo '<input type="radio" id="' . $for . '" name="' . esc_attr($option_name) . '[' . $var_esc . ']" value="' . $key_esc . '" ' . checked($options[$var], $key_esc, false) . ' />',
            '<label for="', $for, '">', $value, '</label>';
        }

        echo '<a></a></div></div><div class="clear"></div></div>' . "\n\n";
    }

    /**
     * Handles the text input fields
     *
     * @param string $var the variable
     * @param string $label the label of the text input field
     * @param string $url_example the url example
     */
    public function text_input_field($var, $label, $url_example)
    {
        $option_name = "wtt_social";
        $options = get_option($option_name);

        $val = (isset($options[$var])) ? $options[$var] : '';

        $this->label($label . ':', array('for' => $var));

        echo '<div class="wtt-input-group">';
        if(!empty($url_example)) {
            echo '<span class="wtt-input-group-addon">', $url_example, '</span>';
        }
        echo '<input class="wtt-form-control" type="text" id="', esc_attr($var), '" name="', esc_attr($option_name), '[', esc_attr($var), ']" value="', esc_attr($val), '"/>', '<br class="clear" />';
        echo '</div>';
    }

    /**
     * Displays a label
     *
     * @param string $text the text to diplay for the label
     * @param array $attr attribute for which label
     */
    public function label($text, $attr)
    {
        $attr = wp_parse_args($attr, array(
                'for' => '',
            )
        );
        echo "<label for='" . esc_attr($attr['for']) . "'>$text" . '</label>';
    }

    /**
     * @param $field_name
     * @param $field_options
     */
    public function select_option_field($field_name, $field_options)
    {
        $option_name = "wtt_social";
        $options = get_option($option_name);

        if (empty($options)) {
            return;
        }

        $select_name = esc_attr($option_name) . '[' . esc_attr($field_name) . ']';
        $active_option = (isset($options[$field_name])) ? $options[$field_name] : '';

        echo '<select name="', esc_attr($select_name), '" id="', esc_attr($field_name), '">';
        foreach ($field_options as $option_attr_value => $option_html_value) : ?>
            <option value="<?php echo esc_attr($option_attr_value); ?>"<?php echo selected($active_option, $option_attr_value, false); ?>><?php echo esc_html($option_html_value); ?></option>
            <?php
        endforeach;
        echo '</select>';
    }


    /**
     * @param $var
     * @param $name
     */
    public function checkbox($var, $name)
    {
        $option_name = "wtt_social";
        $options = get_option($option_name);

        if ( ! isset( $options[ $var ] ) ) {
            $options[ $var ] = false;
        }

        if ( $options[ $var ] === true ) {
            $options[ $var ] = 'on';
        }

        echo '<input class="checkbox" type="checkbox" id="', esc_attr( $var ), '" name="', esc_attr( $option_name ), '[', esc_attr( $var ), ']" value="on"', checked( $options[ $var ], 'on', false ), '/>';
        echo '<small>'. $name . '</small>';
    }
}