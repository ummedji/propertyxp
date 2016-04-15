<?php

namespace Hydra\Widgets;

/**
 * Class ImageWidget
 */
class ImageWidget extends Widget {
    public function __construct($fieldDefinition = NULL, $fieldRecord = NULL, $parentElement = NULL) {
        parent::__construct($fieldDefinition, $fieldRecord, $parentElement);
        $this->type = 'image';
    }

    /**
     * @param $itemSet
     * @param $wrapperSet
     * @return array|void
     */
    public function createItem($itemSet, $wrapperSet, $index) {
        $url = $itemSet->addField('text', array('url', __('Url', 'hydraforms')))
            ->addAttribute('class', 'hydra-image-url');

        // required validator for field
        if($this->isRequired() && $index == 0) {
            $url->addValidator('required');
        }

        $itemSet->addField('text', array('alt', __('Alternate text', 'hydraforms')));

        $itemSet->addField('button', array('add-image', __('Select Image', 'hydraforms')))
            ->addAttribute('class', 'hydra-add-image')
            ->addAttribute('class', 'btn btn-primary');
    }


    public function processValuesBeforeSave(\HydraFieldRecord $fieldRecord, $items, $post = NULL) {
        if (!count($items['items'])) {
            return array();
        }

        foreach ($items['items'] as $key => $item) {
            if (empty($item['url'])) {
                unset($items['items'][$key]);
            }
        }

        if (!count($items['items'])) {
            return array();
        }

        return $items;
    }
}