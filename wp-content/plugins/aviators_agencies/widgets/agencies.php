<?php

class Agency_Widget extends Aviators_Widget {
    function __construct() {
        parent::__construct(
            'Agency_Widget',
            __('Aviators: Agencies', 'aviators'),
            array(
                'classname' => 'agencies_widget'
        ));
    }

    function widget($args, $instance) {
        global $post;

        add_filter('posts_where', 'aviators_agencies_posts_where');

        extract($args);
        $fieldModel = new HydraFieldModel();

        $query_args = array('post_type' => 'agency');

        if (empty($post)) {
            $post_type = '';
        } else {
            $post_type = get_post_type(get_the_ID());
        }

        $can_display = false;

        // if we require context of property and we have one, success
        if(($instance['property'] && $post_type == 'property' && !is_archive())) {
            $can_display = true;
        }

        // if we require context of agent and we have one, success
        if(($instance['agent'] && $post_type == 'agent' && !is_archive())) {
            $can_display = true;
        }

        // we don't require any context - success again!
        if(empty($instance['agent']) && empty($instance['property'])) {
            $can_display = true;
        }

        if(!$can_display) {
            return;
        }

        if($instance['property'] && $post_type == 'property') {
            $field = $fieldModel->load($instance['property_reference_field']);

            $query_args['meta_query'][] = array(
                'key' => $field->field_name . '_%_' . 'value',
                'value' => get_the_ID(),
                'type' => 'numeric',
            );
        }

        if(isset($instance['agent']) && $instance['agent'] && $post_type == 'agent') {
            $field = $fieldModel->load($instance['agent_reference_field']);

            $query_args['meta_query'][] = array(
                'key' => $field->field_name . '_%_' . 'value',
                'value' => get_the_ID(),
                'type' => 'numeric',
            );
        }

        if($instance['limit'] > 0) {
            $query_args['posts_per_page'] = $instance['limit'];
        }

        query_posts($query_args);

        if(more_posts()) {
            echo $before_widget;
            if($instance['title']) {
                print "<h2>" . $instance['title'] . "</h2>";
            }
            while(more_posts()) {
                the_post();
                aviators_get_content_template('agency', $instance['formatter']);
            }
            echo $after_widget;
        }

        wp_reset_query();
    }

    function update($new_instance, $old_instance) {
        $values = $_POST;
        if($this->isSubmitted()) {
            $new_instance['title'] = $values['title'];
            $new_instance['limit'] = $values['limit'];
            $new_instance['property'] = $values['property'];
            $new_instance['agent'] = $values['agent'];
            $new_instance['formatter'] = $values['formatter'];
            $new_instance['property_reference_field'] = $values['property_reference_field'];

            // whoaau ?
            $new_instance['translations'] = $values['translations'];
        }
        return $new_instance;
    }

    function form($instance) {
        $form = new \Hydra\Builder($this->id_base, '', \Hydra\Builder::FORM_EXTENDER);
        $form->addField('hidden', array('widget_identifier', $this->id_base . '-' . $this->number));

        $fieldModel = new HydraFieldModel();
        $form->addField('text', array('title', __('Title', 'aviators')));

        $options = aviators_agencies_get_reference_field_options('agency', 'property');
        $form->addField('checkbox', array('property', __('Display only agencies assigned to currently displayed property', 'aviators')))
            ->setDefaultValue(false);
        $form->addField('select', array('property_reference_field', __('Property Reference field', 'aviators')))
            ->setOptions($options);

        $options = aviators_agencies_get_reference_field_options('agency', 'agent');
        $form->addField('checkbox', array('agent', __('Display only agencies assigned to currently displayed agent', 'aviators')))
            ->setDefaultValue(false);
        $form->addField('select', array('agent_reference_field', __('Agent Reference field', 'aviators')))
            ->setOptions($options);

        $form->addField('text', array('limit', __('Limit', 'aviators')))
            ->setDefaultValue(3)
            ->setDescription(__('Set -1 for unlimited', 'aviators'))
            ->addValidator('numeric');

        $db = new \HydraViewModel();
        $displayTypes = $db->loadByPostType('agent');
        $options = array();
        foreach($displayTypes as $displayType) {
            $options[$displayType->name] = $displayType->label;
        }

        $form->addField('select', array('formatter', __('Display format', 'aviators')))
            ->setOptions($options);

        $form->setValues($instance);
        $form->render();
    }
}


function aviators_agencies_get_reference_field($id) {
    $fieldModel = new HydraFieldModel();
    return $fieldModel->load($id);
}

function aviators_agencies_get_reference_field_options($post_type, $referring_to) {
    $fieldModel = new HydraFieldModel();
    $referenceFields = $fieldModel->loadOptionsByFieldType('reference', $post_type);
    $options = array();
    foreach($referenceFields as $id => $referenceField) {
        $field = $fieldModel->load($id);
        if($field->attributes['post_type'] == $referring_to) {
            $options[$id] = $referenceField;
        }
    }

    return  $options;
}

function aviators_agencies_posts_where($where) {
    $options = aviators_agencies_get_reference_field_options('agency', 'property');
    $options += aviators_agencies_get_reference_field_options('agency', 'agent');

    foreach($options as $id => $field_label) {
        $field = aviators_agencies_get_reference_field($id);
        $where = str_replace("meta_key = '{$field->field_name}_%_value'", "meta_key LIKE '{$field->field_name}_%_value'", $where);
    }

    return $where;
}