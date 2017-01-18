<?php
/**
 * Template Name: Properties
 */
?>
<?php
session_start();
the_post();

if (get_query_var('page')) {
    $paged = get_query_var('page');
}

$query_args = array(
    'post_type' => 'property',
    'paged' => $paged,
);



$properties_horizontal = hydra_form_filter('properties_horizontal');
if ($properties_horizontal->getFormRecord()) {

    $query_args1 = $properties_horizontal->getQueryArray();

    $query_args = $properties_horizontal->getQueryArray();

  //  print_r($query_args1);

    if (isset($query_args1["meta_query"][1]["value"]) && !empty($query_args1["meta_query"][1]["value"])) {
        $query_args['meta_query'][1] = array(
            'key' => '_%_location',
            'compare' => '=',
            'value' => $query_args1["meta_query"][1]["value"]
        );
        $selloc =	get_term_by( 'id', $query_args1["meta_query"][1]["value"], 'locations');
       // print_r($selloc);
        $_SESSION["selected_city"] = $selloc->name;
        $_SESSION["selected_city_id"] = $query_args1["meta_query"][1]["value"];


    }

    if (isset($query_args1["meta_query"][2]["value"]) && !empty($query_args1["meta_query"][2]["value"]))
    {

        $query_args['meta_query'][2] = array(
            'key' => '_%_country',
            'compare' => '=',
            'value' => $query_args1["meta_query"][2]["value"]
        );
        $selcou =	get_term_by( 'id',$query_args1["meta_query"][2]["value"], 'locations');
        $_SESSION["selected_cou"] = $selcou->name;
        $_SESSION["selected_cou_id"] = $query_args1["meta_query"][2]["value"];

    }


    if(isset($query_args1["meta_query"][3]["value"]) && !empty($query_args1["meta_query"][3]["value"])) {
        $query_args['meta_query'][3] = array(
            'key' => '_%_sublocation',
            'compare' => '=',
            'value' => $query_args1["meta_query"][3]["value"]
        );
        $selsubloc =	get_term_by( 'id',  $query_args1["meta_query"][3]["value"], 'locations');
        $_SESSION["selected_subloc"] = $selsubloc->name;
        $_SESSION["selected_subloc_id"] = $query_args1["meta_query"][3]["value"];

    }

}


$properties_vertical = hydra_form_filter('properties_vertical');
if ($properties_vertical->getFormRecord()) {

    $tmp_args = $properties_vertical->getQueryArray();
    // $query_args = $properties_vertical->getQueryArray();
    if (count($tmp_args['meta_query'])) {

        if(isset($tmp_args['meta_query'][4]['value']) && !empty($tmp_args['meta_query'][4]['value']) && isset($tmp_args['meta_query'][3]['value']) && !empty($tmp_args['meta_query'][3]['value']) && $tmp_args['meta_query'][3]['key'] == 'hf_property_maximum_price_%_value' && $tmp_args['meta_query'][4]['key'] == "hf_property_minimum_price_%_value") {
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
        }
        else if(isset($tmp_args['meta_query'][1]['value']) && !empty($tmp_args['meta_query'][1]['value']) && isset($tmp_args['meta_query'][2]['value']) && !empty($tmp_args['meta_query'][2]['value']) && $tmp_args['meta_query'][1]['key'] == "hf_property_maximum_price_%_value" && $tmp_args['meta_query'][2]['key'] == "hf_property_minimum_price_%_value"){

            $tmp_args['meta_query'][1] = array(

                'key' => 'hf_property_starting_price_%_value',
                'compare' => 'BETWEEN',
                'value' => Array
                (
                    "0" => $tmp_args['meta_query'][2]['value'],
                    "1" => $tmp_args['meta_query'][1]['value']
                ),
                'type' => 'numeric'
            );
            unset($tmp_args['meta_query'][2]);
        }

        //   echo "<pre>";
        //   print_r($tmp_args);

        //   unset($tmp_args['meta_query'][5]);

        $query_args['meta_query'] = $tmp_args['meta_query'];

        //  echo "<pre>";
        //  print_r($query_args);
        //die;

        $selloc =	get_term_by( 'id',$query_args["meta_query"][0]["value"], 'locations');
        $_SESSION["selected_city"] = $selloc->name;

        $selcou =	get_term_by( 'id',$query_args["meta_query"][1]["value"], 'locations');
        $_SESSION["selected_cou"] = $selcou->name;

        $selsubloc =	get_term_by( 'id',      $query_args["meta_query"][2]["value"], 'locations');
        $_SESSION["selected_subloc"] = $selsubloc->name;

        $_SESSION["selected_city_id"] = $query_args["meta_query"][0]["value"];
        $_SESSION["selected_cou_id"] = $query_args["meta_query"][1]["value"];
        $_SESSION["selected_subloc_id"] = $query_args["meta_query"][2]["value"];
        // echo $_SESSION["selected_city"]."===".$_SESSION["selected_cou"]."===".$_SESSION["selected_subloc"];die;

    }
}

if(isset($_GET["hf_property_header_location_filter"]) && $_GET["hf_property_header_location_filter"] != ""){

    $query_args['meta_query'][1] = array(
        'key' => '_%_location',
        'compare' => '=',
        'value' => $_GET["hf_property_header_location_filter"]
    );

    $selloc =	get_term_by( 'id', $_GET["hf_property_header_location_filter"], 'locations');
    // print_r($selloc);
    $_SESSION["selected_city"] = $selloc->name;
    $_SESSION["selected_city_id"] = $_GET["hf_property_header_location_filter"];

    unset($_SESSION["selected_cou_id"]);
    unset($_SESSION["selected_cou"]);
    unset($_SESSION["selected_subloc_id"]);
    unset($_SESSION["selected_subloc"]);


}


//print_r($query_args);


$sort = aviators_settings_get('property', get_the_ID(), 'sort');
$display_pager = aviators_settings_get('property', get_the_ID(), 'display_pager');
$display = aviators_settings_get('property', get_the_ID(), 'display_type');
$isotope_taxonomy = aviators_settings_get('property', get_the_ID(), 'isotope_taxonomy');

/*if(isset($_SESSION["selected_city_id"]) && $_SESSION["selected_city_id"] != ""){
    $query_args['meta_query'][1] = array(
        'key' => '_%_location',
        'compare' => '=',
        'value' => $_SESSION["selected_city_id"]
    );
}

if(isset($_SESSION["selected_cou_id"]) && $_SESSION["selected_cou_id"] != ""){

    $query_args['meta_query'][2] = array(
        'key' => '_%_country',
        'compare' => '=',
        'value' => $_SESSION["selected_cou_id"]
    );

}

if(isset($_SESSION["selected_subloc_id"]) && $_SESSION["selected_subloc_id"] != ""){

    $query_args['meta_query'][3] = array(
        'key' => '_%_sublocation',
        'compare' => '=',
        'value' => $_SESSION["selected_subloc_id"]
    );

}*/

//print_r($query_args);

if (isset($sort) && $sort) {
   aviators_properties_sort_get_query_args(get_the_ID(), $query_args);
}
aviators_properties_filter_get_query_args(get_the_ID(), $query_args);

//query_posts($query_args);

$fullwidth = !is_active_sidebar('sidebar-1');

switch ($display) {
    case "row":
        $class = empty($fullwidth) ? "col-sm-12" : "col-sm-offset-1 col-sm-10";
        break;
    case "grid":
        $class = empty($fullwidth) ? "col-sm-6 col-md-4" : "col-sm-4 col-md-3";
        break;
    case "isotope":
        $class = empty($fullwidth) ? "col-sm-6 col-md-4" : "col-sm-6 col-md-4";
        break;
    default:
        $class = 'post col-sm-12';
        break;
}

if ($display == 'isotope') {
    $filter_terms = aviators_properties_get_isotope_filter_terms($isotope_taxonomy, get_the_ID());
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

//echo $display;


?>

<?php get_header(); ?>


    <div id="main-content" class="<?php if ( is_active_sidebar( 'sidebar-1' ) && !aviators_settings_get('property', get_the_ID(), 'disable_sidebar') ) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
		<div class="col-md-12 text-center tlt-wt-margn"><h1 class="center">HOT PROPERTIES</h1></div>
       <div class="as_pro_slider"> <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?> </div>
        
<div class="additional-tools as-additional-tools col-md-12">
<a class="center" href='<?php bloginfo('url');?>/brochures-page/'>
	<span class="brochure-search"></span>
	<label class="pro_llb">BROCHURE<br>SEARCH</label>
</a>
<a class="center" href='<?php bloginfo('url');?>/mortgage/'>
	<span class="emi-calculator"></span>
	<label class="pro_llb">EMI<br>CALCULATOR</label>
</a>
<a class="center" href="<?php bloginfo('url');?>/map-mode">
	<span class="map-mode-search"></span>
	<label class="pro_llb">MAP MODE<br>SEARCH</label>
</a>
<a class="center" href="#">
	<span class="news-and-views"></span>
	<label class="pro_llb">NEWS AND<br>VIEWS</label>
</a>
<!--<a class="center" href="#">
	<span class="radio-live"></span>
	<label class="pro_llb">RADIO LIVE</label>
</a>-->
<a class="center" href='<?php bloginfo('url');?>/subscribe-news-letter/'>
	<span class="subscribe-news-letter"></span>
	<label class="pro_llb">SUBSCRIBE NEWS LETTER</label>
</a>
<a class="center" href="<?php bloginfo('url');?>/tv-live/">
	<span class="tv-lve"></span>
	<label class="pro_llb">TV LIVE</label>
</a>
<a class="center" href="<?php bloginfo('url');?>/value-me/">
	<span class="value-me"></span>
	<label class="pro_llb">VALUE ME</label>
</a>
</div>
<div class="clear"></div>
        <div class="col-md-12 text-center top-premuim"><h1 <?php if ($display == 'isotope'): ?>class="center"<?php endif; ?>>
            <?php the_title(); ?>
            <?php aviators_edit_post_link(); ?>
            <?php aviators_configure_page_link('property', get_the_ID()); ?>
        </h1></div>
        <?php the_content(); ?>

        <?php if (isset($sort) && $sort): ?>
            <?php aviators_get_template('sort', 'property'); ?>
        <?php endif; ?>

        <?php query_posts($query_args); ?>

        <?php if ($display == 'isotope'): ?>
            <?php if ($filter_terms): ?>
                <ul class="properties-filter as_properties-filter premium_property_filter">
                    <li class="selected"><a href="#" data-filter="*"><span><?php print __('All', 'aviators'); ?></span></a>
                    </li>
                    <?php foreach ($filter_terms as $slug => $filter_term): ?>
                        <li><a href="#"
                               data-filter=".property-<?php print $slug; ?>"><span><?php print $filter_term; ?></span></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <div class="properties-items as_properties-items <?php print $display; ?>">
            <div class="items-list">
                <?php $count = 0; ?>
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

                    <?php if ($display == 'isotope'): ?>
                        <?php $property_class = aviators_properties_append_term_classes($isotope_taxonomy); ?>
                        <div class="property-item <?php print $class; ?> <?php print $property_class; ?>">
                            <?php aviators_get_content_template('property', 'grid'); ?>
                        </div>
                    <?php else: ?>
                        <div class="property-item <?php print $class; ?> <?php print $end_line; ?>">
                            <?php aviators_get_content_template('property', $display); ?>
                        </div>
                    <?php endif; ?>
                    <?php $count++; ?>
                <?php endwhile; ?>
            </div>
        </div>
     <!--   <div class="col-md-12 text-center"><a class="btn vie_mr_btn" id="render_all_premium_properties" href="javascript:void(0);">View All</a></div> -->
        <!--div class="col-md-12 text-center"><h1 class="center">INDIVIDUAL PROPERTIES</h1></div-->
        <!-- /.items-list -->

        <?php if($display_pager): ?>
            <?php //aviators_pagination(); ?>
        <?php endif; ?>

        <div class="col-md-12 text-center view_all_btn">
            <a type="button" id="view_all_property" href="<?php bloginfo('url');?>/all-properties/">View All</a>
        </div>

        <?php wp_reset_query(); ?>
		<!--<div class="properties-items as_properties-items">
        <?php //if (dynamic_sidebar('content-bottom')) : ?><?php //endif; ?>
		</div>-->
    </div><!-- /#main-content -->

    <?php if ( is_active_sidebar( 'sidebar-1' ) && !aviators_settings_get('property', get_the_ID(), 'disable_sidebar') ): ?>
        <div class="sidebar col-md-3 col-sm-3">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div><!-- /#sidebar -->
    <?php endif; ?>


<?php get_footer(); ?>