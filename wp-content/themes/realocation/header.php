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
  
</head>

<body <?php body_class(); ?> >

	<!--		
<div class="custom-menu">
		<a class="custom-menu-button custom-menu-active fa fa-bars " href="##">Menu</a>
		<div class="custom-menu-content custom-menu-deactive">
			<a class="custom-menu-close" href="##">X</a>
			<?php echo do_shortcode('[custom_menu]');?>	
		</div>
</div> -->


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

                <?php require_once 'templates/header-top.php'; ?>

                <?php 
	                $person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid'));
                
               
                	if($person_field == 'Developer') {

                	} else {
                		require_once 'templates/header-navigation.php';
			}
				?>	
            </div><!-- /.header-inner -->
        </div><!-- /#header -->
    </div><!-- /#header-wrapper -->

    <div id="main-wrapper">
        <div id="main">
        <?php if (is_singular(array('property'))) { 
            
        		//if($person_field == 'Developer') {
            
                        /*
                        * NEW TEMPLATE APPROACH CODE ADDED
                        * if statement change on the basics of selected templated value earlier it dependes on person field.
                        */
            
                         $selected_template_value = get_field("select_template");    
                        if($selected_template_value == 'developer'){
                            
        			//the_post_thumbnail(array(1500,500), array( 'class' => 'property-main-image center' )); 
        			$sa = get_field('slider_alias');
        			if($sa != '')
        				putRevSlider( $sa )
        		?>
        		<div class="row">
			        <div class="col-md-12" >
			            <h1 class="property-detail-title center developer-property-title"><?php the_title(); ?></h1>
			
			            <div class="property-detail-subtitle center developer-prperty-price"><?php print hydra_render_field(get_the_ID(), 'location', 'detail'); ?>
			                <?php print hydra_render_field(get_the_ID(), 'price', 'detail'); ?>
			            </div>
			        </div>
			        <!-- /.header-title -->
			    </div>
        		<?php 
        		}
        	} ?>
            <div id="main-inner">
                <?php dynamic_sidebar( 'top-fullwidth' ); ?>
                
                <?php if (is_singular(array('property'))){
                    
    				
    				//if($person_field != 'Developer') { 
                    /*
                        * NEW TEMPLATE APPROACH CODE ADDED
                        * if statement change on the basics of selected templated value earlier it dependes on person field.
                        */
            
                    $selected_template_value = get_field("select_template");    
                    if($selected_template_value != 'developer'){

                    wp_enqueue_script('googlemaps3');
                    wp_enqueue_script('clusterer');
                    wp_enqueue_script('infobox');
                    ?>
                    <?php $mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE); ?>
                    <?php if (isset($mapPosition['items'][0])): ?>
                        <?php if (!empty($mapPosition['items'][0]['latitude']) && !empty($mapPosition['items'][0]['longitude'])) : ?>
                            <div id="map-property">
                            </div><!-- /#map-property -->
                        <?php endif; 
                    	 endif; 
                    	 add_action('aviators_footer_map_detail', 'aviators_properties_map_detail'); 
						}
                	  	else {
						?>
						<div class="developer-menu center">
							<div class="developer-menu-links">
							<a href="#details" >
							<!--<div class="icon-details icon-small"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/PROJECT.png"> -->
								<span class="dev-details"></span>
								<div class="title">DETAILS</div>
							</a>
							<a  href="#flats">
							<!--<div class="icon-building-filled icon-small"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/CATEGORY.png"> -->
								<span class="dev-category"></span>
								<div class="title">CATAGORY</div>
							</a>
							<a href="#amenities" >
							<!-- <div class="icon-amenities-filled icon-small"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/AMENITIES.png"> -->
								<span class="dev-amenities"></span>
								<div class="title">AMENITIES</div>
							</a>
							<a  href="#map" >
							<!--<div class="icon-location-filled icon-small"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/LOCATION.png"> -->
								<span class="dev-location"></span>
								<div class="title">LOCATION</div>
							</a>
							<a  href="#flats" >
							<!--<div class="icon-plane-filled icon-small"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/360.png"> -->
								<span class="dev-360"></span>
								<div class="title">360*</div>
							</a>
							<a  href="#gallery" >
							<!--<div class="icon-gallery-filled icon-small"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/GALLERY.png"> -->
								<span class="dev-gallery"></span>
								<div class="title">GALLERY</div>
							</a>
							<a  href="#line_chart" >
							<!--<div class="icon-small icon-trends-filled"></div> -->
								<!-- <img src="<?php bloginfo('template_directory'); ?>/images/MARKET.png"> -->
								<span class="dev-market"></span>
								<div class="title">MARKET</div>
							</a>
							</div>
							<div class="im-interested">
								<div class="icon icon-message-filled"></div>
								<?php echo do_shortcode('[AnythingPopup id="4"]'); ?>
								
							</div>
						</div>
						<?php 
					  	} 
                	}?>

                <div class="container">
                	<?php 	echo do_shortcode('[AnythingPopup id="1"]'); 
                		echo do_shortcode('[AnythingPopup id="2"]');
                		echo do_shortcode('[AnythingPopup id="3"]');?>
                    <?php dynamic_sidebar( 'top' ); ?>
                   
                    <?php echo aviators_render_messages(); ?>

                    <div class="block-content block-content-small-padding">
                        <div class="block-content-inner <?php if($person_field == 'Developer') { ?>developers-all-content<?php } ?>">
                            <div class="row">