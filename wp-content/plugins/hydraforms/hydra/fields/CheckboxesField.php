<?php

namespace Hydra\Fields;

use Hydra\Builder;

class CheckboxesField extends Field {
    private $options;

    public function setOptions($options) {
        $this->options = $options;
        return $this;
    }

    public function __construct($name, $label = '', $options = array()) {
        $this->options = $options;
        $this->addAttribute('class', 'list-unstyled');
        parent::__construct($name, 'checkbox', $label);
    }

    public function renderInputElement($name = NULL, $value = NULL) {
        $output = '';

        $defaultValue = $this->getValue();
        if (!$name) {
            $name = $this->name;
        }

        // @TODO - unite handling of multiple values forms - like checkboxes, multiselect..
        $output .= "<ul " . $this->printAttributes() . ">";
        foreach ($this->options as $key => $option) {
            $attr = '';
            if (is_array($defaultValue)) {
                if (isset($defaultValue[$key]) && $defaultValue[$key]) {
                    $attr = 'checked="checked"';
                }
            }
            elseif ($key == $this->getValue()) {
                $attr = 'checked="checked"';
            }

            $output .= "<li>";

            if ($src = aviators_items_get_term_image($key)) {
                $output .= "<div class=icon>" . aviators_items_get_term_image($key) . "</div>";
            }
            $output .= "<div class=checkbox>";
            $output .= "<label>";
            $optionName = $name . "[" . $key . "]";
            $output .= "<input type=\"$this->type\" value=\"" . $key . "\" name=\"$optionName\" $attr>" . $option;
            $output .= "</label>";
            $output .= "</div>";
            $output .= "</li>";
        }
        $output .= "</ul>";

        return $output;
    }
}


/**
 * Get image by term ID
 *
 * @return string
 */
function aviators_items_get_term_image( $term_id ) {

    if (!function_exists('aviators_taxonomy_get')) {
        return false;
    }

    require_once ABSPATH . 'wp-admin/includes/plugin.php';

    if ( is_plugin_active( 'aviators_taxonomy/aviators_taxonomy.php' ) != true ) {
        return null;
    }


    return aviators_taxonomy_get_image($term_id);
}
