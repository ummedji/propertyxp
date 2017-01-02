<?php
$display = "row";
if (isset($_GET['display'])) {
    $display = $_GET['display'];
}
else {
    $display = aviators_settings_get('property', 'archive', 'display_type');
}

$properties_horizontal = hydra_form_filter('properties_horizontal');
if ($properties_horizontal->getFormRecord()) {
    $query_args = $properties_horizontal->getQueryArray();
}

$properties_vertical = hydra_form_filter('properties_vertical');
if ($properties_vertical->getFormRecord()) {
    $tmp_args = $properties_vertical->getQueryArray();
   // $query_args = $properties_vertical->getQueryArray();
    if (count($tmp_args['meta_query'])) {

      //  echo "<pre>";
     //   print_r($tmp_args);


        $tmp_args['meta_query'][3] = array(

            'key' => 'hf_property_starting_price_%_value',
            'compare' => 'BETWEEN',
            'value' => Array
            (
                "0" => $tmp_args['meta_query'][4]['value'],
                "1" => $tmp_args['meta_query'][3]['value']
            ),
            'type' => 'numeric'
        );
        unset($tmp_args['meta_query'][4]);
     //   unset($tmp_args['meta_query'][5]);

        $query_args['meta_query'] = $tmp_args['meta_query'];
    }
}


//die;

$paged = get_query_var('paged');
if (isset($paged)) {
    $query_args['paged'] = get_query_var('paged');
}

$sort = aviators_settings_get('property', 'archive', 'sort');
if (isset($sort) && $sort) {
    aviators_properties_sort_get_query_args(get_the_ID(), $query_args);
}



//echo "<pre>";
//print_r($query_args);

//die;
query_posts($query_args);

$fullwidth = !is_active_sidebar('sidebar-1');
switch ($display) {
    case "row":
        $class = empty($fullwidth) ? "col-sm-12" : "col-sm-offset-1 col-sm-10";
        break;
    case "grid":
        $class = empty($fullwidth) ? "col-sm-6 col-md-4" : "col-sm-4 col-md-3";
        break;
    case "default":
        $class = 'post col-sm-12';
        break;
}


$resolutions = array(
    'xs' => 12,
    'sm' => 6,
    'md' => 4,
    'lg' => 4,
);

if($fullwidth) {
    $resolutions = array(
        'xs' => 12,
        'sm' => 6,
        'md' => 3,
        'lg' => 3,
    );
}

?>
<!--
<?php /*get_header(); */?>

    <div id="main-content" class="<?php /*if ( is_active_sidebar( 'sidebar-1' ) && !aviators_settings_get('property', get_the_ID(), 'disable_sidebar') ) : */?>col-md-9 col-sm-9<?php /*else : */?>col-md-12 col-sm-12<?php /*endif; */?>">
        <div class="col-md-12 text-center"><h1 class="center">HOT PROPERTIES</h1></div>
-->
        <?php
      //  echo do_shortcode('[widget id="propertiesslider_widget-3"]');
        ?>

        <!--<div class="as_pro_slider"> <?php /*if (dynamic_sidebar('content-top')) : */?><?php /*endif; */?> </div>-->



<div class="col-md-12 text-center top-premuim">
<h1><?php echo aviators_settings_get('property', 'archive', 'title'); ?></h1>
</div>

<ul class="properties-filter as_properties-filter premium_property_filter">
       <li class="selected"><a href="#" data-filter="*"><span>All</span></a></li>
       <li><a href="#" data-filter=".Agent"><span>Agent</span></a></li>
       <li><a href="#" data-filter=".Individual"><span>Individual</span></a></li>
       <li><a href="#" data-filter=".Developer"><span>Developer</span></a></li>
     </ul>

<?php /*if (isset($sort) && $sort): ?>
    <?php aviators_get_template('sort', 'property'); ?>
<?php endif; */?>
<div class="properties-items as_properties-items isotope">
<div class="items-list">
<?php //echo do_shortcode('[ajax_load_more post_type="property" offset="3" posts_per_page="9" button_label="Loading..."]'); ?>
    <?php  /*global $wpdb;
   echo "<pre>";
   print_r($post);
   echo "</pre>";*/$count = 0; ?>
   
    
    <?php while (have_posts()) : the_post(); ?>

        <?php
        $end_line = '';
        if($display == 'grid') {
            foreach ($resolutions as $resolution => $columns) {
                if ($count % (12 / $columns) == 0) {
                    $end_line .= ' new-line-' . $resolution;
                }
            }
        }
        ?>
	<?php //echo strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid')); ?>
        <div class="post property-item isotope-item <?php echo strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid')); ?> <?php print $class; ?> <?php echo $end_line; ?>">
            <?php aviators_get_content_template('property', $display); ?>
        </div>
        <?php $count++; ?>
    <?php endwhile; ?>
  </div>
</div><!-- /.items-list -->

 <!--</div> -->

<?php //get_footer(); ?>