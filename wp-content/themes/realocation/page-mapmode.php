<?php
/**
 * Template Name: Map Mode
 */
?>
<?php do_action('aviators_pre_render'); ?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Aviators, http://aviators.com">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>

    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
    <title><?php echo wp_title('|', FALSE, 'right'); ?></title>
    <?php if($ga = realocation_ga_get_tracking()): ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php print $ga['code']; ?>', '<?php print $ga['name']; ?>');
        ga('send', 'pageview');
    </script>
    <?php endif; ?>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/developer-icon.css">
    <script>
    jQuery( document ).ready(function() {
    var availableTags = [
      "100",
      "500",
      "1000",
      "10000",
      "50000",
      "100000",
      "500000",
      "1000000",
      "5000000",
      "10000000",
      "50000000",
      "100000000",
 
    ];
	 jQuery( "#hydra-hf-property-maximum-price-filter-items-0-value" ).autocomplete({
	      source: availableTags
	    });
	    
	  jQuery( "#hydra-hf-property-minimum-price-filter-items-0-value" ).autocomplete({
	      source: availableTags
	    });
	});
    </script>
    
<script type="text/javascript">
	jQuery(document).ready(function (){

		jQuery('.custom-menu-button').click(function(){
			jQuery('.custom-menu-content').addClass('custom-menu-active').removeClass('custom-menu-deactive');
			jQuery('.custom-menu-button').addClass('custom-menu-deactive').removeClass('custom-menu-active');			
		});

		jQuery('.custom-menu-close').click(function(){
			jQuery('.custom-menu-content').addClass('custom-menu-deactive').removeClass('custom-menu-active');
			jQuery('.custom-menu-button').addClass('custom-menu-active').removeClass('custom-menu-deactive');			
		});
		
	});
</script>
  <style>
  	#map .gm-style .marker .marker-inner {display: none;}
  	.col-sm-12 #map-content {width:100%!important}
  	.col-sm-12 #map_canvas {width:100%!important;height : 600px!important}
  </style>
</head>

<body <?php body_class(); ?> >



<?php if(get_theme_mod('general_enable_customizer', 1)): ?>
    <?php aviators_get_template('template', 'palette'); ?>
<?php endif; ?>

<div id="wrapper">
    <div id="header-wrapper">
        <div id="header">
            <div id="header-inner">
                <?php if ( get_theme_mod('general_topbar_is_enabled') ) : ?>
                    <?php require_once 'templates/header-bar.php'; ?>
                <?php endif; ?>

                <?php require_once 'templates/header-top.php';
                require_once 'templates/header-navigation.php';
                ?>

                
            </div><!-- /.header-inner -->
        </div><!-- /#header -->
    </div><!-- /#header-wrapper -->

    <div id="main-wrapper">
        <div id="main">
    
            <div id="main-inner">
            	<?php 
            	if($_GET['prop_id']) {
				 echo '<div class="row">
					<div class="col-md-12">
	        			<div class="center section-title"><h2><span>'.get_the_title( $_GET['prop_id'] ).'</span></h2></div>
         			</div>	
					
					<div class="col-sm-12">';
			    	$mapPosition = get_post_meta($_GET['prop_id'], 'hf_property_map', TRUE);
			    	//print_r($mapPosition);
			    	$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');
			    	$longitude = $mapPosition['items'][0]['longitude'];//get_field('longitude');

                   // echo "here";die;
			    	
			    	echo do_shortcode('[map_neighbourhood location="'.$latitude.','.$longitude.'"]');
			    	echo '</div></div>';
			    } else {
	    		?>
            	<?php dynamic_sidebar( 'mapmode-fullwidth' );?>
            	<?php } ?>
            </div>
         </div>
     </div>	
            	
 <?php get_footer(); ?>