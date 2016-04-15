<?php

namespace Hydra\Widgets;

/**
 * Class LinkWidget
 * @package Hydra\Widgets
 */
class LinkWidget extends Widget {

    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'link';
    }

    public function createItem($itemSet, $wrapperSet, $index) {
        $attrGenerator = FieldAttributesGenerator::getInstance();
        $widgetValues = $this->getWidgetSettings();

        $itemSet->setLabel($this->fieldRecord->getLabel());
        $itemSet->isRenderable(true);

        $title = $itemSet->addField('text', array('value', __('Title')));
        $link = $itemSet->addField('text', array('url', __('URL', 'hydraforms')));

        // required validator for field
        if($this->isRequired() && $index == 0) {
            $title->addValidator('required');
            $link->addValidator('required');
        }

        $attrGenerator->process($itemSet, $this->getWidgetSettings());
    }
}
