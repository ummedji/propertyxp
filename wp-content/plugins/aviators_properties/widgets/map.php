<?php

class Map_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('Map_Widget', __('Aviators: Map', 'aviators'), array('classname' => 'map'));
    }

    public function form($instance) {
        $form = new \Hydra\Builder($this->id_base, '', \Hydra\Builder::FORM_EXTENDER);
        $form->addField('hidden', array('widget_identifier', $this->id_base . '-' . $this->number));

        $form->addField('text', array('latitude', __('Latitude', 'aviators')))
            ->addAttribute('class', 'latitude');

        $form->addField('text', array('longitude', __('Longitude', 'aviators')));
        $form->addField('select', array('zoom', __('Zoom', 'aviators')))
            ->setOptions(array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                8 => 8,
                9 => 9,
                10 => 10,
                11 => 11,
                12 => 12,
                13 => 13,
                14 => 14,
                15 => 15,
                16 => 16,
                17 => 17,
                18 => 18,
                19 => 19,
                20 => 20,
            ))
            ->setValue(16);

        $form->addField('checkbox', array('show_filter', __('Show filter', 'aviators')))
            ->setDefaultValue(1);

        $formModel = new HydraFormModel();
        $filters = $formModel->loadByType('filter');
        $filterOptions = array();

        foreach($filters as $filter) {
            $filterOptions[$filter->name] = $filter->label;
        }

        $form->addField('select', array('filter', __('Select Filter', 'aviators')))
            ->setOptions($filterOptions);

        $form->addField('checkbox', array('is_horizontal', __('Filter is horizontal', 'aviators')))
            ->setDefaultValue(1);

        $form->addField('markup', array('markup', __('If you wish to overwrite template for map filter, open theme directory and rename filter-horizontal-sample.php to filter-horizontal.php. Now you can do custom render of filter.', 'aviators')))
            ->setDefaultValue(FALSE);


        $form->addField('text', array('height', __('Height', 'aviators')))
            ->setDefaultValue('600px');
        $form->addField('text', array('width', __('Width', 'aviators')))
            ->setDefaultValue('100%');

        $form->addField('checkbox', array('map_filtering', __('Filtering on Map', 'aviators')))
            ->setDefaultValue(true);

        $form->addField('checkbox', array('enable_geolocation', __('Enable Geolocation', 'aviators')))
            ->setDefaultValue(FALSE);



        $form->setValues($instance);
        print $form->render();
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        if ($_POST['id_base'] == $this->id_base) {
            if ($_POST['widget_identifier'] == $this->id_base . '-' . $this->number) {
                $new_instance = $_POST;
                $instance['title'] = strip_tags($new_instance['title']);
                $instance['latitude'] = strip_tags($new_instance['latitude']);
                $instance['longitude'] = strip_tags($new_instance['longitude']);
                $instance['zoom'] = strip_tags($new_instance['zoom']);
                $instance['height'] = strip_tags($new_instance['height']);
                $instance['show_filter'] = strip_tags($new_instance['show_filter']);
                $instance['filter'] = strip_tags($new_instance['filter']);
                $instance['is_horizontal'] = strip_tags($new_instance['is_horizontal']);
                $instance['enable_geolocation'] = strip_tags($new_instance['enable_geolocation']);
                $instance['map_filtering'] = isset($new_instance['map_filtering']) ? (bool)$new_instance['map_filtering'] : false;
                $instance['horizontal'] = strip_tags($new_instance['horizontal']);
                return $instance;
            }
        }
    }

    public function widget($args, $instance) {
        wp_enqueue_script('googlemaps3');
        wp_enqueue_script('clusterer');
        wp_enqueue_script('infobox');
        wp_enqueue_script('map');
        wp_enqueue_script('jquery-ui-resizable');
        wp_enqueue_script('realocation-map');
        extract($args);
        ?>

        <?php if (defined('HYDRA_THEME_MODE')) : ?>


            <div class="map-wrapper">
                <div class="map ">
                    <div id="map" class="map-inner" style="height: <?php echo $instance['height']; ?>"></div>
                    <!-- /.map-inner -->
                    <?php $GLOBALS['map_widget_instance'] = $instance; ?>
                    <?php add_action('aviators_footer_map_widget', 'aviators_properties_init_map'); ?>
                </div>
                <!-- /.map -->

            <?php if ($instance['show_filter']) : ?>
                <div class="filter-container <?php if($instance['is_horizontal']): ?>filter-horizontal<?php endif; ?>">

                    <div class="container">
                        <div class="row">
                            <div class="<?php if($instance['is_horizontal']): ?>col-sm-12 <?php else: ?>col-sm-4 col-sm-offset-8 col-md-3 col-md-offset-9 <?php endif; ?> ">
                                <div class="map-navigation-wrapper row">
                                    <div class="map-navigation col-sm-12">

                                        <?php $filterManager = hydra_form_filter($instance['filter']); ?>
                                        <?php $form = $filterManager->buildForm(); ?>

                                        <?php if($instance['map_filtering']): ?>
                                            <?php
                                                $form->addAttribute('class', 'map-filter-form');
                                                $form->addField('hidden', array('map_filter', 'on'));
                                                $form->setSubmit('');
                                                $form->build();
                                            ?>
                                        <?php endif; ?>

                                        <?php $renderer = new HydraAdvancedRender($form); ?>

                                        <?php if($path = aviators_get_template('filter', 'horizontal', null, false)): ?>
                                            <?php include($path); ?>
                                        <?php else: ?>
                                            <?php if($instance['is_horizontal']): ?>
                                                <?php include 'templates/filter-horizontal.php'; ?>
                                            <?php else: ?>
                                                <?php include 'templates/filter-vertical.php'; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                    <!-- /.map-navigation -->
                                </div>
                                <!-- /.map-navigation-wrapper -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.container -->
                </div><!-- /.filter-container -->
            <?php endif; ?>
            </div><!-- /.map-wrapper -->
        <?php endif; ?>
    <?php
    }
}
