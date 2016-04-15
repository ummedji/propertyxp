<?php

namespace Hydra\Formatter;

use Hydra\Builder;


/**
 * Class GroupFormatter
 * @package Hydra\Formatter
 */
class GroupFormatter {

    public function __construct() {
        $this->name = 'group';
    }


    /**
     * Making this public in case someone wants to pull the rendered fields.
     * But want to do custom GROUP rendering in template
     * Very smart
     */
    public function preRenderFields($fieldViews, $post) {
        $renderableFields = array();

        /**
         * $field->value
         * $field->prefix
         * $field->suffix
         * $field->attributes
         * $field->formatter
         */
        foreach ($fieldViews as $fieldView) {
            $formatter = Formatter::getFormatter($fieldView->formatter, false);

            $output = true;
            if ($formatter) {
                /** @var $formatter Formatter */
                $fieldView->field->meta->output = $formatter->render($fieldView, $post);
                // no output provided - no values found, skipping
                if(!$fieldView->field->meta->output) {
                   continue;
                }

                $fieldView->field->meta->markup = $formatter->renderItems($fieldView, $fieldView->field->meta, $fieldView->settings, $formatter->getValues($fieldView));
                $fieldView->field->meta->label = $formatter->renderLabel($fieldView, $fieldView->field->meta, $fieldView->settings);
                if(!$fieldView->field->meta->markup) {
                    $output = false;
                }
            }
            else {
                // we need to provide some markup
                continue;
            }

            if (!$fieldView->field->hidden && $output) {
                $renderableFields[] = $fieldView;
            }
        }


        return $renderableFields;
    }


    public function render($groupFieldView, $fields, $post) {
        $fields = $this->preRenderFields($fields, $post);
    }

    public function getSettingsForm($parentForm) {
        $fields = array();

        $parentForm->addField('text', array('class', __('Class', 'hydraforms')));
        $parentForm->addField('checkbox', array('hide_label', __('Hide label', 'hydraforms')));
        $parentForm->addField('checkbox', array('display_title', __('Display title', 'hydraforms')))
            ->setDefaultValue(1);

        $parentForm->removeField('hide_label');
        $parentForm->removeField('label_below');
    }


    /**
     * Returns default settings configuration
     * Configuration to be created upon first saving
     * @return array
     */
    public function getDefaultSettings() {
        return array(
            'class' => '',
        );
    }

    /**
     * Print attributes which are pulled from field instance and settings
     * @param $view
     * @return string
     */
    protected function printAttributes($view) {
        $output = '';

        $attributes = array();
        if (isset($view->attributes)) {
            if ($view->attributes) {
                $attributes = $view->attributes;
                $class = $attributes['class'];
                $attributes['class'] = array($class);
            }
        }

        if (isset($view->settings['class'])) {
            $attributes['class'][] = $view->settings['class'];
        }
        if (isset($view->settings['columns'])) {
            $attributes['class'][] = $view->settings['columns'];
        }

        $attributes['class'][] = $this->name;
        $attributes['class'][] = strtolower(str_replace('_', '-', $view->field_label));
        $attributes['class'][] = str_replace('_', '-', $view->field_name);


        foreach ($attributes as $attribute => $values) {
            $value = implode(" ", $values);
            $output .= "$attribute=\"$value\"";
        }

        return trim($output);
    }
}