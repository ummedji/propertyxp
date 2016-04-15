<?php

class Aviators_Widget_Features extends Aviators_Widget {
    function __construct() {
        parent::__construct('Aviators_Widget_Features', __('Aviators: Features', 'aviators'));
    }

    function widget($args, $instance) {
        extract($args);
        extract($instance);

        // identifies the accordion group for js
        $parent_id = $this->id_base . '-' . $this->number;

        $features = array();
        for($i = 0; $i<= $instance['count']; $i++ ) {
            if(isset($instance[$i])) {
                $features[$i] = $instance[$i];
            }
        }


        $chunks = array_chunk($features, ceil(count($features)/$instance['columns']));

        switch($instance['columns']) {
            case 1:
                $class = 'col-xs-12';
                break;
            case 2:
                $class = 'col-xs-12 col-sm-6';
                break;
            case 3:
                $class = 'col-xs-12 col-sm-4';
                break;
        }


        echo $before_widget;
        include 'templates/feature.php';
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $values = $_POST;
        if ($this->isSubmitted()) {
            $new_instance['title'] = $values['title'];
            $new_instance['count'] = $values['count'];
            $new_instance['columns'] = $values['columns'];

            for($i = 1; $i <= $values['count']; $i++) {
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

        $options = array();
        for($i = 1; $i <= 30; $i++) {
            $options[$i] = $i;
        }

        $form->addField('select', array('columns', __('Number of columns', 'aviators')))
            ->setOptions(array(1 => 1, 2=>2, 3=>3))
            ->setDefaultvalue(2);

        $form->addField('select', array('count', __('Number of items', 'aviators')))
            ->setOptions($options)
            ->setDefaultValue(3);

        $items_count = isset($instance['count']) ? $instance['count'] : 3;

        for ($i = 1; $i <= $items_count; $i++) {
            $fieldset = $form->addField('fieldset', array($i, 'Item ' . $i));

            $fieldset->addField('text', array('title', __('Title', 'aviators')));
            $fieldset->addField('text', array('icon', __('Icon', 'aviators')));
            $fieldset->addField('textarea', array('content', __('Text or HTML', 'aviators')))
                ->setRows(10)
                ->setCols(40);

            if(isset($instance[$i])) {
                $fieldset->setValue($instance[$i]);
            }
        }

        $form->setValues($instance);
        $form->render();
    }
}