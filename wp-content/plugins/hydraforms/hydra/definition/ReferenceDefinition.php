<?php

namespace Hydra\Definitions;

use Hydra\Builder;
use Hydra\Decorators\FieldDecorator;
use Hydra\Decorators\TableDecorator;
use Hydra\Fields\TextareaField;
use Hydra\Fields\TextField;
use Hydra\Fields\FieldsetField;

class ReferenceDefinition extends FieldDefinition {

    public function __construct(Builder $builder = null, $widget_type = 'field') {
        parent::__construct($builder, $widget_type);
        $this->type = 'reference';
    }

    protected function definitionSpecificFields($fieldSet) {
        $post_types = get_post_types();
        $fieldSet->removeField('placeholder');
        $fieldSet->removeField('class');

        $fieldSet->addField('select', array('post_type', __('Post Type', 'hydraforms')))
            ->setOptions($post_types)
            ->setDescription(__('Select post type to be referenced', 'hydraforms'));
    }

    public function getOptions($fieldRecord) {
        if(!isset($fieldRecord->attributes['post_type'])) {
            return array();
        }

        // we need to restrict this
        // only admin should be able to see all the posts, rest should be able to see only posts created from his own account

        // user can access administration thus should have privileges to assign any
        if(is_admin()) {
            $posts = get_posts( array('post_type' => $fieldRecord->attributes['post_type'], 'numberposts' => 200));
        } else {

            $posts = get_posts( array('post_type' => $fieldRecord->attributes['post_type'], 'numberposts' => 200, 'author' => get_current_user_id()));
        }


        if(!count($posts)) {
            return array();
        }

        $options = array();

        foreach($posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        return $options;
    }

    // @todo - finish tokens for this field
    public function getTokenDefinition($fieldRecord = null) {
        return array();
    }
}
