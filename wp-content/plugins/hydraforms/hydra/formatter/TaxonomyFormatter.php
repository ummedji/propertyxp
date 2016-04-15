<?php

namespace Hydra\Formatter;

use Hydra\Builder;

class TaxonomyFormatter extends BasicFormatter {

    public function __construct() {
        $this->name = 'taxonomy';
    }

    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }

        $meta->taxonomy = $view->field->attributes['taxonomy'];
        foreach ($items as $delta => $item) {
            $itemOutput = $this->renderItem($meta, $delta, $settings, $item);
            if($itemOutput) {
                $output .= $itemOutput;
            }
        }

        return $output;
    }


    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        $term = get_term($item['value'], $meta->taxonomy);

        if(is_wp_error($term) || $term == null) {
            return '';
        }

        $output = "<div class=\"field-item field-item-$delta\">";
        if ($meta->prefix) {
            $output .= "<div class=\"field-prefix\" >" . $meta->prefix . "</div>";
        }

        if(!empty($settings['link_bool'])) {
            $link = get_term_link($term, $meta->taxonomy);
            $output .= "<a href=$link>" . $term->name . "</a>";
        } else {
            $output .= "<div class=field-value>" . $term->name . "</div>";
        }

        if ($meta->suffix) {
            $output .= "<div class=\"field-suffix\">" . $meta->suffix . "</div>";
        }
        $output .= '</div>';

        return $output;
    }


    public function getSettingsForm($parentElement, $settings, $field) {
        parent::getSettingsForm($parentElement, $settings, $field);
        $parentElement->addField('checkbox', array('link_bool', __('Link to taxonomy page', 'hydraforms')))
            ->setDefaultValue(FALSE);
    }
}