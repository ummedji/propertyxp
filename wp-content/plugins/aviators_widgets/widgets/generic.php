<?php

class Aviators_Widget extends WP_Widget {

    public function __construct( $id_base, $name, $widget_options = array(), $control_options = array() ) {
        parent::__construct( $id_base, $name, $widget_options, $control_options);
    }

    public function isSubmitted() {
        $values = $_POST;

        if($values['id_base'] == $this->id_base) {
            if($values['widget_identifier'] == $this->id_base . '-' . $this->number) {
                return TRUE;
            }
        }
    }

    public function getTranslation($element = array(), $instance, $language = null) {
        global $sitepress;
        if($sitepress) {
            $defaultLanguage = $sitepress->get_default_language();
            $currentLanguage = $sitepress->get_current_language();

            if($language) {
                $currentLanguage = $language;
            }

            if(isset($instance['translations'])) {
                $translations = $instance['translations'];

                if($currentLanguage != $defaultLanguage) {
                    foreach($element as $nestedItem) {
                        if(end($element) == $nestedItem) {
                            if(isset($translations[$nestedItem][$currentLanguage])) {
                                return $translations[$nestedItem][$currentLanguage];
                            }
                        } elseif(isset($translations[$nestedItem])) {
                            $translations = $translations[$nestedItem];
                        }
                    }
                }
            }
        }

        $values = $instance;
        foreach($element as $nestedItem) {
            if(end($element) == $nestedItem) {
                if(isset($values[$nestedItem])) {
                    return $values[$nestedItem];
                }
            } elseif(isset($values[$nestedItem])) {
                $values = $values[$nestedItem];
            }
        }

        return null;
    }

    public function saveBasicSettings(&$new_instance, $values) {
        $new_instance['image_url'] = $values['image_url'];
        $new_instance['background_color'] = $values['background_color'];
        $new_instance['fullwidth'] = $values['fullwidth'];
        $new_instance['padding'] = $values['padding'];
        $new_instance['title_position'] = $values['title_position'];
        $new_instance['title_color'] = $values['title_color'];
    }

    public function basicSettings($form, $instance) {
        $form->addField('text', array('image_url', __('Image Url', 'aviators')))
            ->addAttribute('class', 'hydra-image-url');

        $form->addField('button', array('add_image', __('Add image', 'aviators')))
            ->addAttribute('class', 'hydra-add-image');

        $form->addField('select', array('background_color', __('Background Color', 'aviators')))
            ->setOptions(array(
                'background-transparent' => __('Transparent', 'aviators'),
                'background-primary' => __('Primary', 'aviators'),
            ));

        $form->addField('select', array('fullwidth', __('Use Fullwidth Background', 'aviators')))
            ->setOptions(array(
                'boxed' => __('No', 'aviators'),
                'fullwidth' => __('Yes', 'aviators'),
            ));

        $form->addField('select', array('padding', __('Increase Top/Bottom padding', 'aviators')))
            ->setOptions(array(
                '' => __('No', 'aviators'),
                'block-content-small-padding' => __('Small padding', 'aviators'),
                'block-padding' => __('Large padding', 'aviators'),
            ));

        $form->addField('select', array('title_position', __('Title position', 'aviators')))
            ->setOptions(array(
                'left' => __('Left', 'aviators'),
                'center' => __('Center', 'aviators'),
                'right' => __('Right', 'aviators'),
            ));

        $form->addField('select', array('title_color', __('Title color', 'aviators')))
            ->setOptions(array(
                'color-default' => __('Default Color', 'aviators'),
                'color-primary' => __('Primary Color', 'aviators'),
            ));

        $form->setValues($instance);
    }
}