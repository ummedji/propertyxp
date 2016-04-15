<?php

class Properties_Widget extends Aviators_Widget {
    function __construct() {
        parent::__construct(
            'Properties_Widget',
            __('Aviators: Properties', 'aviators'),
            array(
                'classname' => 'properties_widget'
            ));
    }

    function widget($args, $instance) {
        extract($args);
        $query_args['post_type'] = 'property';

        if (isset($instance['contract_types']) && $instance['contract_types']) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'contract_types',
                'terms' => array_keys($instance['contract_types']),
            );
        }

        if (isset($instance['types']) && $instance['types']) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'types',
                'terms' => array_keys($instance['types']),
            );
        }

        if ($instance['limit'] > 0) {
            $query_args['posts_per_page'] = $instance['limit'];
        }


        if (!isset($instance['sort_order_default'])) {
            $query_args['orderby'] = $instance['sort_order_default'];
        }

        switch ($instance['sort_default']) {
            case 'title';
                $query_args['orderby'] = 'title';
                break;
            case 'created':
                $query_args['orderby'] = 'date';
                break;
            default:
                // hydra fields!
                $fieldModel = new HydraFieldModel();
                $field = $fieldModel->load($instance['sort_default']);

                if ($field) {
                    $machine_name = $field->field_name . '_0_value';
                    $query_args['orderby'] = 'meta_value_num';
                    $query_args['meta_key'] = $machine_name;
                }

                break;
        }

        query_posts($query_args);
        if (more_posts()) {
            echo $before_widget;
            if ($instance['title']) {
                print "<h2>" . $instance['title'] . "</h2>";
            }
            while (more_posts()) {
                the_post();
                aviators_get_content_template('property', $instance['formatter']);
            }
            echo $after_widget;
            wp_reset_query();
        }
    }

    function update($new_instance, $old_instance) {
        $values = $_POST;
        if ($this->isSubmitted()) {
            $new_instance['title'] = $values['title'];
            $new_instance['contract_types'] = $values['contract_types'];
            $new_instance['types'] = $values['types'];
            $new_instance['sort_default'] = $values['sort_default'];
            $new_instance['sort_order_default'] = $values['sort_order_default'];
            $new_instance['formatter'] = $values['formatter'];

            $new_instance['limit'] = $values['limit'];

            // whoaau ?
            $new_instance['translations'] = $values['translations'];
        }

        return $new_instance;
    }

    function form($instance) {
        $form = new \Hydra\Builder($this->id_base, '', \Hydra\Builder::FORM_EXTENDER);
        $form->addField('hidden', array('widget_identifier', $this->id_base . '-' . $this->number));

        $form->addField('text', array('title', __('Title', 'aviators')));

        $terms = get_terms(array('types', 'contract_types'), array('get' => 'all'));

        $options = _aviators_properties_taxonomy_term_options('types', $terms);
        if ($options) {
            $form->addField('checkboxes', array('types', __('Filter by Type', 'aviators')))
                ->setOptions($options);
        }

        $options = _aviators_properties_taxonomy_term_options('contract_types', $terms);
        if ($options) {
            $form->addField('checkboxes', array('contract_types', __('Filter by Contract Type', 'aviators')))
                ->setOptions($options);
        }

        $sortableOptions = _aviators_settings_get_sortable_options();

        $form->addField('select', array('sort_default', __('Sort By', 'aviators')))
            ->setOptions($sortableOptions);

        $form->addField('select', array('sort_order_default', __('Default sort order by', 'aviators')))
            ->setOptions(array('ASC' => __('Ascending', 'aviators'), 'DESC' => __('Descending', 'aviators')));

        $form->addField('text', array('limit', __('Limit', 'aviators')))
            ->setDefaultValue(5)
            ->setDescription(__('Set -1 for unlimited', 'aviators'))
            ->addValidator('numeric');

        $db = new \HydraViewModel();
        $displayTypes = $db->loadByPostType('property');
        $options = array();
        foreach ($displayTypes as $displayType) {
            $options[$displayType->name] = $displayType->label;
        }

        $form->addField('select', array('formatter', __('Display format', 'aviators')))
            ->setOptions($options);

        $form->setValues($instance);
        $form->render();
    }
}