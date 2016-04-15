<?php

class Aviators_Widget_Text extends Aviators_Widget {
	function __construct() {
            parent::__construct( 'PM_Widget_Text', __( 'Aviators: Text', 'aviators' ));
	}

	function widget( $args, $instance ) {

            $title_position = '';
            $title_color = $background_color = 'transparent';
            $padding = $fullwidth = '';

            extract($instance);
            $text = do_shortcode($text);
            extract($args);

            $title_classes_variables = array($title_position, $title_color);
            if(!$text) {
                $title_classes_variables[] = 'no-margin';
            }
            $title_classes = implode(' ', $title_classes_variables);

            $classes_variables = array($background_color, $fullwidth, $padding);
            $classes = implode(' ', $classes_variables);
            $style = "";

            if($image_url) {
                $style='style="background-image: url(' . $image_url . ');"';
            }

            echo $before_widget;
            include "templates/text.php";
            echo $after_widget;
	}

        function update($new_instance, $old_instance) {
            $values = $_POST;
            if($this->isSubmitted()) {
                $new_instance['title'] = $values['title'];
                $new_instance['text'] = stripslashes($values['text']);
                $this->saveBasicSettings($new_instance, $values);
            }
            return $new_instance;
        }


        function form($instance) {
            if(isset($instance['text'])) {
                $instance['text'] = stripslashes($instance['text']);
            }

            $form = new \Hydra\Builder($this->id_base, '', \Hydra\Builder::FORM_EXTENDER);
            $form->addField('hidden', array('widget_identifier', $this->id_base . '-' . $this->number));

            // widget title
            $form->addField('text', array('title', __('Title', 'aviators')))
                ->setValue($instance['title']);

            // widget teaser text
            $form->addField('textarea', array('text', __('Text or HTML', 'aviators')))
                ->setRows(10)
                ->setCols(40)
                ->setValue($instance['text']);

            $this->basicSettings($form, $instance);

            $form->render();
        }
}