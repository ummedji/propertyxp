<?php


/**
 * Include required scripts for this widget
 */
function aviators_properties_widget_js() {
    wp_enqueue_script('bxslider', plugins_url() . '/aviators_properties/assets/js/jquery.bxslider.min.js', array('jquery'));
    wp_enqueue_script('properties', plugins_url() . '/aviators_properties/assets/js/properties.js', array('jquery'));

    wp_enqueue_style('bxslider', plugins_url() . '/aviators_properties/assets/css/jquery.bxslider.css');
}

add_action('wp_enqueue_scripts', 'aviators_properties_widget_js');

class PropertiesCarousel_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'PropertiesCarousel_Widget',
            __('Aviators: Properties Carousel', 'aviators'),
            array(
                'classname' => 'properties_carousel_widget'
            ));
    }

    function widget($args, $instance) {
        extract($args);
        $title_position = '';
        $title_color = $background_color = 'transparent';
        $padding = $fullwidth = '';

        extract($instance);
        $title_classes_variables = array($title_position, $title_color);
        $title_classes = implode(' ', $title_classes_variables);

        $classes_variables = array($background_color, $fullwidth, $padding);
        $classes = implode(' ', $classes_variables);
        $style = "";
        if ($image_url) {
            $style = 'style="background-image: url(' . $image_url . ');"';
        }


        $query = array(
            'post_type' => 'property',
        );

        if (isset($instance['property_ids']) && !empty($instance['property_ids'])) {
            $query['post__in'] = explode(',',$instance['property_ids']);
        }
        else {
            if (isset($instance['types']) && $instance['types']) {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'types',
                        'terms' => $instance['types']
                    )
                );
            }
        }

        query_posts($query);
        echo $before_widget;
        include 'templates/properties_carousel.php';
        echo $after_widget;
        wp_reset_query();
    }

    function update($new_instance, $old_instance) {
        $values = $_POST;
        if ($values['id_base'] == $this->id_base) {
            if ($values['widget_identifier'] == $this->id_base . '-' . $this->number) {
                $new_instance['title'] = $values['title'];
                $new_instance['image_url'] = $values['image_url'];
                $new_instance['background_color'] = $values['background_color'];
                $new_instance['fullwidth'] = $values['fullwidth'];
                $new_instance['padding'] = $values['padding'];
                $new_instance['title_position'] = $values['title_position'];
                $new_instance['title_color'] = $values['title_color'];
                $new_instance['types'] = $values['types'];
                $new_instance['property_ids'] = $values['property_ids'];

            }
        }

        return $new_instance;
    }

    function form($instance) {
        $instance['text'] = stripslashes(!empty($instance['text']) ? $instance['text'] : '');

        $form = new \Hydra\Builder($this->id_base, '', \Hydra\Builder::FORM_EXTENDER);
        $form->addField('hidden', array('widget_identifier', $this->id_base . '-' . $this->number));

        // widget title
        $form->addField('text', array('title', __('Title', 'aviators')))
            ->setValue(!empty($instance['title']) ? $instance['title'] : '');

        $form->addField('text', array('image_url', __('Image Url', 'aviators')))
            ->addAttribute('class', 'hydra-image-url')
            ->setValue(!empty($instance['image_url']) ? $instance['image_url'] : '');

        $form->addField('button', array('add_image', __('Add image', 'aviators')))
            ->addAttribute('class', 'hydra-add-image');

        $form->addField('select', array('background_color', __('Background Color', 'aviators')))
            ->setOptions(array(
                'background-transparent' => __('Transparent', 'aviators'),
                'background-gray' => __('Gray Color', 'aviators'),
                'background-primary' => __('Primary', 'aviators'),
            ))
            ->setValue(!empty($instance['background_color']) ? $instance['background_color'] : '');

        $form->addField('select', array('fullwidth', __('Use Fullwidth Background', 'aviators')))
            ->setOptions(array(
                'boxed' => __('No', 'aviators'),
                'fullwidth' => __('Yes', 'aviators'),
            ))
            ->setValue(!empty($instance['fullwidth']) ? $instance['fullwidth'] : '');

        $form->addField('select', array('padding', __('Top/Bottom padding', 'aviators')))
            ->setOptions(array(
                'block-content-small-padding' => __('Small padding', 'aviators'),
                'block-padding' => __('Large padding', 'aviators'),
            ))

            ->setValue(!empty($instance['padding']) ? $instance['padding'] : '');

        $form->addField('select', array('title_position', __('Title position', 'aviators')))
            ->setOptions(array(
                'left' => __('Left', 'aviators'),
                'center' => __('Center', 'aviators'),
                'right' => __('Right', 'aviators'),
            ))
            ->setValue(!empty($instance['title_position']) ? $instance['title_position'] : '');

        $form->addField('select', array('title_color', __('Title position', 'aviators')))
            ->setOptions(array(
                'color-default' => __('Default Color', 'aviators'),
                'color-primary' => __('Primary Color', 'aviators'),
            ))
            ->setValue(!empty($instance['title_color']) ? $instance['title_color'] : '');


        $form->addField('text', array('property_ids', __('Filter by ID', 'aviators')))
            ->setAttribute('placeholder', 'Property IDs separated with comma')
            ->setDescription(__('List ONLY specific properties', 'aviators'))
            ->setValue(!empty($instance['property_ids']) ? $instance['property_ids'] : '');

        $options = array();
        $terms = get_terms('types');
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }

        $form->addField('checkboxes', array('types', __('Filter by type', 'aviators')))
            ->setOptions($options)
            ->setValue(!empty($instance['types']) ? $instance['types'] : '');

        $form->render();
    }
}