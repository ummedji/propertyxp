<?php

class Aviators_Widget_Hexagon extends Aviators_Widget {
    function __construct() {
        parent::__construct( 'Aviators_Widget_Hexagon', __( 'Aviators: Hexagons', 'aviators' ));
    }

    function widget( $args, $instance ) {
        extract($args);

        $title_color = $background_color = 'transparent';
        $padding = $fullwidth = '';
        extract($instance);

        $title_position = '';

        $title_classes_variables = array($title_position, $title_color);
        $title_classes = implode(' ', $title_classes_variables);

        $classes_variables = array($background_color, $fullwidth, $padding);
        $classes = implode(' ', $classes_variables);
        $style = "";

        $button_class = 'btn-primary';
        if($background_color == 'background-primary') {
            $button_class = 'btn-white';
        }

        if($image_url) {
            $style='style="background-image: url(' .$image_url.');"';
        }

        echo $before_widget;
        include "templates/hexagons.php";
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $values = $_POST;
        if($this->isSubmitted()) {
            $new_instance['title'] = $values['title'];
            $new_instance['text'] = stripslashes($values['text']);

            $this->saveBasicSettings($new_instance, $values);

            for($i = 1; $i <= 3; $i++) {
                $new_instance[$i] = $values[$i];
            }
        }

        return $new_instance;
    }


    function form($instance) {
        $form = new \Hydra\Builder($this->id_base, '', \Hydra\Builder::FORM_EXTENDER);
        $form->addField('hidden', array('widget_identifier', $this->id_base . '-' . $this->number));

        // widget title
        $form->addField('text', array('title', __('Title', 'aviators')));

        $this->basicSettings($form, $instance);

        for($i = 1; $i <= 3; $i++) {
            $fieldset = $form->addField('fieldset', array($i, 'Feature ' . $i));

            $fieldset->addField('text', array('title', __('Title', 'aviators')));
            $fieldset->addField('textarea', array('content', __('Text or HTML', 'aviators')))
                ->setRows(10)
                ->setCols(40);
            $fieldset->addField('text', array('icon', __('Icon', 'aviators')));
            $fieldset->addField('text', array('button', __('Button Text', 'aviators')));
            $fieldset->addField('text', array('link', __('Button Link', 'aviators')));

            if(isset($instance[$i])) {
                $fieldset->setValue($instance[$i]);
            }
        }



        $form->render();
    }
}