<?php

namespace Hydra\Plugins\Gallery;

use Hydra\Formatter\Formatter as Formatter;
use Hydra\Definitions;
use Hydra\Builder;
use Hydra\Widgets;


class CarouselFormatter extends Formatter {
    private $id;

    public function __construct() {
        $this->name = 'carousel_gallery';
    }

    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }
        $this->id = 'carousel-gallery-' . $view->id;
        $output = '<div id="' . $this->id . '" class="carousel slide" data-ride="carousel">';

        $itemOutput = '';
        $pagerOutput = '';
        foreach ($items as $delta => $item) {
            $pagerOutput .= $this->renderPagerItem($meta, $delta, $settings, $item);
            $itemOutput .= $this->renderItem($meta, $delta, $settings, $item);
        }

        $output .= '<ol class="carousel-indicators">';
        $output .= $pagerOutput;
        $output .= '</ol>';
        $output .= '<div class="carousel-inner">';
        $output .= $itemOutput;
        $output .= '</div>';

        $output .= '<a class="left carousel-control" href="#' . $this->id . '" data-slide="prev"><span class="fa fa-chevron-left"></span></a>';
        $output .= '<a class="right carousel-control" href="#' . $this->id . '" data-slide="next"><span class="fa fa-chevron-right"></span></a>';


        $output .= '</div>';

        return $output;
    }


    public function renderPagerItem($meta, $delta, $settings, $item) {
        if ($delta == 0) {
            $active = " active";
        }

        return "<li data-target=\"#" . $this->id . "\" data-slide-to=\"" . $delta . "\" class=\"" . $active . "\"></li>";
    }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        if (function_exists('aq_resize') && $settings['width'] && $settings['height']) {
            if ($new_url = aq_resize($item['url'], $settings['width'], $settings['height'], TRUE)) {
                $item['url'] = $new_url;
            }
        }

        $active = "";
        if ($delta == 0) {
            $active = " active";
        }

        $output = "<div class=\"field-item item field-item-$delta $active\">";
        $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";
        $output .= '</div>';

        return $output;
    }


    /**
     * @param $parentElement
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('columns');
        $parentForm->removeField('prefix');
        $parentForm->removeField('suffix');
        $parentForm->addField('fieldset', array('resize', 'Resize Image (Requires aqua resizer to be included)'))
            ->isTree(FALSE);

        if (function_exists('aq_resize')) {

            $parentForm->addField('text', array('width', 'Resize to Width'))
                ->addValidator('numeric')
                ->setDefaultValue(840);

            $parentForm->addField('text', array('height', 'Resize to Height'))
                ->addValidator('numeric')
                ->setDefaultValue(540);
        }
    }
}



class FlexSliderFormatter extends Formatter {

    public function __construct() {
        $this->name = 'flexslider_gallery';
    }


    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }

        $output = '<div class="flexslider"><ul class="slides">';
        foreach ($items as $delta => $item) {
            $output .= $this->renderItem($meta, $delta, $settings, $item);
        }
        $output .= '</ul></div>';

        return $output;
    }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        if(function_exists('aq_resize') && $settings['width'] && $settings['height']) {
            $new_url = aq_resize($item['url'], $settings['width'], $settings['height'], true, true, true);
            if($new_url) {
                $item['url'] = $new_url;
            }
        }



        $output = "<li class=\"field-item field-item-$delta\" data-thumb=\"" . $item['url'] . "\">";
        if ($meta->prefix) {
            $output .= "<div class=\"field-prefix\" >" . $meta->prefix . "</div>";
        }
        $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";
        if ($meta->suffix) {
            $output .= "<div class=\"field-suffix\">" . $meta->suffix . "</div>";
        }
        $output .= '</li>';

        return $output;
    }

    private function get_pager()
    {
        return '<div class="cycle-pager"></div>';
    }


    /**
     * @param $parentForm
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('columns');

        $parentForm->addField('fieldset', array('resize', 'Resize Image (Requires aqua resizer to be included)'))
            ->isTree(false);

        if(function_exists('aq_resize')) {

            $parentForm->addField('text', array('width', 'Resize to Width'))
                ->addValidator('numeric')
                ->setDefaultValue(840);


            $parentForm->addField('text', array('height', 'Resize to Height'))
                ->addValidator('numeric')
                ->setDefaultValue(540);
        }

        $parentForm->addField('text', array('def_img_url', 'Defult image url'))
                ->setDefaultValue('http://127.0.0.1:8080/wp-content/themes/carat/assets/img/car_icon.png');


    }

    private function get_default_img( $url )
    {
        return "<div class=\"picture\">
                    <div class=\"image-slider\">
                        <a class=\"slide\">
                            <img src=\"". $url ."\" />
                        </a>
                    </div>
                </div>";
    }

    public function render(\HydraFieldViewRecord $view, $post) {

        // pull out meta
        $meta = $view->field->meta;
        // pull out settings
        $settings = $view->settings;

        $items = $this->getValues($view);
        if (!$items)
            if( $settings['url'] )
                return $this->get_default_img( $settings['url'] );


        $label_bellow = FALSE;
        if (isset($settings['label_below'])) {
            $label_bellow = $settings['label_below'];
        }


        $output = '<div ' . $this->printAttributes($view) . '>';

        if (!$label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }
        $output .= $this->renderItems($view, $meta, $settings, $items);

        if ($label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }

        $output .= "</div>";

        return $output;
    }
}

class CycleFormatter extends Formatter {

    public function __construct() {
        $this->name = 'cycle_gallery';
    }


    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }

        $output = "<div class=\"image-slider cycle-2 hydra-cycle-gallery\">";
        foreach ($items as $delta => $item) {
            $output .= $this->renderItem($meta, $delta, $settings, $item);
        }

        $output .= $this->get_cycle_pager();

        $output .= "</div>";

        return $output;
    }

    private function get_cycle_pager()
        {
            return "<div class=\"cycle-pager\"></div>";
        }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        if(function_exists('aq_resize') && $settings['width'] && $settings['height']) {
            $new_url = aq_resize($item['url'], $settings['width'], $settings['height'], true, true, true);
            if($new_url) {
                $item['url'] = $new_url;
            }
        }

        $output = '<a href=\"detail.html\" class=\"slide\">';
        if ($meta->prefix) {
            $output .= "<div class=\"field-prefix\" >" . $meta->prefix . "</div>";
        }
        $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";
        if ($meta->suffix) {
            $output .= "<div class=\"field-suffix\">" . $meta->suffix . "</div>";
        }
        $output .= '</a>';



        return $output;


    }


    /**
     * @param $parentForm
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('columns');

        $parentForm->addField('fieldset', array('resize', 'Resize Image (Requires aqua resizer to be included)'))
            ->isTree(false);

        if(function_exists('aq_resize')) {

            $parentForm->addField('text', array('width', 'Resize to Width'))
                ->addValidator('numeric')
                ->setDefaultValue(255);


            $parentForm->addField('text', array('height', 'Resize to Height'))
                ->addValidator('numeric')
                ->setDefaultValue(200);
        }

        $parentForm->addField('text', array('def_img_url', 'Defult image url'))
            ->setDefaultValue('http://127.0.0.1:8080/wp-content/themes/carat/assets/img/car_icon.png');
    }

    private function get_default_img( $url )
    {
        return "<div class=\"picture\">
                    <div class=\"image-slider\">
                        <a class=\"slide\">
                            <img src=\"". $url ."\" />
                        </a>
                    </div>
                </div>";
    }

    public function render(\HydraFieldViewRecord $view, $post) {
        // pull out meta
        $meta = $view->field->meta;
        // pull out settings
        $settings = $view->settings;

        $items = $this->getValues($view);
        if (!$items)
            if( $settings['url'] )
                return $this->get_default_img( $settings['url'] );

        $label_bellow = FALSE;
        if (isset($settings['label_below'])) {
            $label_bellow = $settings['label_below'];
        }


        $output = '<div ' . $this->printAttributes($view) . '>';

        if (!$label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }
        $output .= $this->renderItems($view, $meta, $settings, $items);

        if ($label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }

        $output .= "</div>";

        return $output;
    }
}



class DetailCycleFormatter extends Formatter {

    public function __construct() {
        $this->name = 'cycle_gallery_detail';
    }


    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if (!$items) {
            return $output;
        }


        $output = "<div id=\"gallery-wrapper\"><div class=\"gallery\">";
        foreach ($items as $delta => $item)
            $output .= $this->renderItem($meta, $delta, $settings, $item);
        $output .= "</div>";

        $output .= $this->get_pager();
        $output .= $this->renderThumb( $items );
        $output .= "</div>";
        return $output;
    }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {
        if(function_exists('aq_resize') && $settings['width'] && $settings['height']) {
            $new_url = aq_resize($item['url'], $settings['width'], $settings['height'], true, true, true);
            if($new_url) {
                $item['url'] = $new_url;
            }
        }
        $output = "<div class=\"slide\"><div class=\"picture-wrapper\">";
        if ($meta->prefix)
            $output .= "<div class=\"field-prefix\" >" . $meta->prefix . "</div>";

        $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";
        if ($meta->suffix)
            $output .= "<div class=\"field-suffix\">" . $meta->suffix . "</div>";

        $output .= "</div></div>";

        return $output;


    }

    private function renderThumb( $items )
    {
        $output = "<div class=\"gallery-thumbnails\">";
        $thumb_number = 0;
        foreach( $items as $item ) // pripadne 'as $delta => $item'
        {
            $output .= "<div class=\"thumbnail-$thumb_number\">";
            $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";
            $output .= "</div>";
            $thumb_number++;
        }
        $output .= "</div>";
        return $output;
    }

    private function get_pager()
    {
        return "<div id=\"gallery-pager\" class=\"white block-shadow\">
                    <div class=\"prev\">
                        <i class=\"icon-normal-left-arrow-small\"></i>
                    </div>
                    <div class=\"pager\"></div>
                    <div class=\"next\">
                        <i class=\"icon-normal-right-arrow-small\"></i>
                    </div>
                </div>";
    }




    /**
     * @param $parentForm
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('columns');

        $parentForm->addField('fieldset', array('resize', 'Resize Image (Requires aqua resizer to be included)'))
            ->isTree(false);

        if(function_exists('aq_resize')) {

            $parentForm->addField('text', array('width', 'Resize to Width'))
                ->addValidator('numeric')
                ->setDefaultValue(255);


            $parentForm->addField('text', array('height', 'Resize to Height'))
                ->addValidator('numeric')
                ->setDefaultValue(200);
        }

        $parentForm->addField('text', array('def_img_url', 'Defult image url'))
            ->setDefaultValue('http://127.0.0.1:8080/wp-content/themes/carat/assets/img/car_icon.png');
    }

    private function get_default_img( $url )
    {
        return "<div class=\"picture\">
                    <div class=\"image-slider\">
                        <a class=\"slide\">
                            <img src=\"". $url ."\" />
                        </a>
                    </div>
                </div>";
    }

    public function render(\HydraFieldViewRecord $view, $post) {
        // pull out meta
        $meta = $view->field->meta;
        // pull out settings
        $settings = $view->settings;

        $items = $this->getValues($view);
        if (!$items)
            if( $settings['def_img_url'] )
                return $this->get_default_img( $settings['def_img_url'] );


        $label_bellow = FALSE;
        if (isset($settings['label_below'])) {
            $label_bellow = $settings['label_below'];
        }


        $output = '<div ' . $this->printAttributes($view) . '>';

        if (!$label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }
        $output .= $this->renderItems($view, $meta, $settings, $items);

        if ($label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }

        $output .= "</div>";

        return $output;
    }
}


class BxGalleryFormatter extends Formatter {

    public function __construct() {
        $this->name = 'bx_featured_cars';
    }


    public function renderItems($view, $meta, $settings, $items) {
        $output = '';
        if (!$items) {
            return $output;
        }                                                                                                                                                                                              //"<img src=\"" . bloginfo('template_directory') . "/assets/img/car_icon.png\" alt=\"" . the_title() . "\">"
        $output  .= "<div class=\"picture\">
                        <div class=\"image-slider\">";

        foreach ($items as $delta => $item)
            $output .= $this->renderItem($meta, $delta, $settings, $item);
        $output .= $this->get_pager();

            $output .= "</div>
                    </div>";

        $output .= $this->get_like_btn();

        return $output;
    }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {

        if(function_exists('aq_resize') && $settings['width'] && $settings['height']) {
            $new_url = aq_resize($item['url'], $settings['width'], $settings['height'], true, true, true);
            if($new_url) {
                $item['url'] = $new_url;
            }
        }

        $output = '';

        $output .= "<a class=\"slide\">";
        if ($meta->prefix)
            $output .= "<div class=\"field-prefix\" >" . $meta->prefix . "</div>";

        $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";

        if ($meta->suffix)
            $output .= "<div class=\"field-suffix\">" . $meta->suffix . "</div>";

        $output .= "</a>";

        return $output;


    }


    private function get_pager()
    {
        return "<div class=\"cycle-pager\"></div>";
    }

    private function get_like_btn()
    {
        return "<div class=\"like\"><a><i class=\"icon icon-outline-thumb-up\"></i></a></div>";
    }




    /**
     * @param $parentForm
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('columns');

        $parentForm->addField('fieldset', array('resize', 'Resize Image (Requires aqua resizer to be included)'))
            ->isTree(false);

        if(function_exists('aq_resize')) {

            $parentForm->addField('text', array('width', 'Resize to Width'))
                ->addValidator('numeric')
                ->setDefaultValue(255);


            $parentForm->addField('text', array('height', 'Resize to Height'))
                ->addValidator('numeric')
                ->setDefaultValue(200);
        }

        $parentForm->addField('text', array('def_img_url', 'Defult image url'))
            ->setDefaultValue('http://127.0.0.1:8080/wp-content/themes/carat/assets/img/car_icon.png');
    }

    private function get_default_img( $url )
    {
        return "<div class=\"picture\">
                    <div class=\"image-slider\">
                        <a class=\"slide\">
                            <img src=\"". $url ."\" />
                        </a>
                    </div>
                </div>";
    }

    public function render(\HydraFieldViewRecord $view, $post) {
        // pull out meta
        $meta = $view->field->meta;
        // pull out settings
        $settings = $view->settings;

        $items = $this->getValues($view);
        if (!$items)
            if( $settings['def_img_url'] )
                return $this->get_default_img( $settings['def_img_url'] );

        $label_bellow = FALSE;
        if (isset($settings['label_below'])) {
            $label_bellow = $settings['label_below'];
        }


        $output = '<div ' . $this->printAttributes($view) . '>';

        if (!$label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }
        $output .= $this->renderItems($view, $meta, $settings, $items);

        if ($label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }

        $output .= "</div>";

        return $output;
    }
}

class RowCycleFormatter extends Formatter {

    public function __construct() {
        $this->name = 'cycle_gallery_row';

    }

    public function renderItems($view, $meta, $settings, $items) {
        $output = '';

        if ( !$items )
            return $output;


        $output  .= "<div class=\"picture\">
                        <div class=\"image-slider\">";

        foreach ($items as $delta => $item)
            $output .= $this->renderItem($meta, $delta, $settings, $item);

        $output .= $this->get_pager();

        $output .= "</div>
               </div>";

        return $output;
    }

    /**
     * Render single item
     * @param $meta
     * @param $delta
     * @param $settings
     * @param $item
     * @return string
     */
    public function renderItem($meta, $delta, $settings, $item) {

        if(function_exists('aq_resize') && $settings['width'] && $settings['height']) {
            $new_url = aq_resize($item['url'], $settings['width'], $settings['height'], true, true, true);
            if($new_url) {
                $item['url'] = $new_url;
            }
        }

        $output = '';

        $output .= "<a class=\"slide\">";
        if ($meta->prefix)
            $output .= "<div class=\"field-prefix\" >" . $meta->prefix . "</div>";

        $output .= "<img src=\"" . $item['url'] . "\" alt=\"" . $item['alt'] . "\">";

        if ($meta->suffix)
            $output .= "<div class=\"field-suffix\">" . $meta->suffix . "</div>";

        $output .= "</a>";

        return $output;
    }


    private function get_pager()
    {
        return "<div class=\"cycle-pager\"></div>";
    }

    private function get_default_img( $url )
    {
        return "<div class=\"picture\">
                    <div class=\"image-slider\">
                        <a class=\"slide\">
                            <img src=\"".$url."\" />
                        </a>
                    </div>
                </div>";

    }

    /**
     * @param $parentForm
     * @param $settings
     * @param $field
     */
    public function getSettingsForm($parentForm, $settings, $field) {
        parent::getSettingsForm($parentForm, $settings, $field);
        $parentForm->removeField('columns');

        $parentForm->addField('fieldset', array('resize', 'Resize Image (Requires aqua resizer to be included)'))
            ->isTree(false);

        if(function_exists('aq_resize')) {

            $parentForm->addField('text', array('width', 'Resize to Width'))
                ->addValidator('numeric')
                ->setDefaultValue(255);


            $parentForm->addField('text', array('height', 'Resize to Height'))
                ->addValidator('numeric')
                ->setDefaultValue(200);
        }
        $parentForm->addField('text', array('def_img_url', 'Defult image url'))
                ->setDefaultValue('http://127.0.0.1:8080/wp-content/themes/carat/assets/img/car_icon.png');
    }

    public function render(\HydraFieldViewRecord $view, $post) {

        // pull out meta
        $meta = $view->field->meta;
        // pull out settings
        $settings = $view->settings;

        $items = $this->getValues($view);

        if (!$items) {
            if( $settings['url'] )
            return $this->get_default_img( $settings['url'] );
        }



        $label_bellow = FALSE;
        if (isset($settings['label_below'])) {
            $label_bellow = $settings['label_below'];
        }


        $output = '<div ' . $this->printAttributes($view) . '>';

        if (!$label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }
        $output .= $this->renderItems($view, $meta, $settings, $items);

        if ($label_bellow) {
            $output .= $this->renderLabel($view, $meta, $settings);
        }

        $output .= "</div>";

        return $output;
    }
}



