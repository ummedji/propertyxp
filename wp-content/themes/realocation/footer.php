                                </div><!-- /.row -->
                            </div><!-- /.block-content-inner -->
                        </div><!-- /.block-content-small-padding -->
                       
                    <?php 	$person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid')); 
                    
                                $selected_template_value = get_field("select_template");    
                    if($selected_template_value == 'developer' || $selected_template_value == 'TemplateV2' || $selected_template_value == 'TemplateV3'){
                    
                    
                    		//if (is_singular(array('property')) && $person_field == 'Developer') { 
                    		} else {
					?>
					 <?php if(is_front_page()) { ?>
                    <div class="col-md-12 blog-article-display">
			<?php 
			$args = array('post_type'=>array('post','news'), 'post_status' => 'publish', 'posts_per_page' => 6);
			$post_loop = new WP_Query($args);
			?>
			<div class="col-md-4 blogs-slider flexslider" >
				<h3>Blog & News Posts</h3>
				<div class="block-content-inner row">
				    <ul class="slides">
					<?php while ( $post_loop->have_posts() ) : $post_loop->the_post(); ?>
						<li><h4><?php the_title()?></h4><p><?php  the_excerpt(); ?></p></li>
					<?php endwhile;?>
				    </ul>
				</div>
			</div>
			<?php
			wp_reset_postdata();wp_reset_query(); 
			$args = array('post_type'=>'article_type', 'post_status' => 'publish', 'posts_per_page' => 6);
			$article_loop = new WP_Query($args);
			?>
			<div class="col-md-8 article-slider flexslider" >
				<h3>Articles</h3>
				<div class="block-content-inner row">
				    <ul class="slides">
					<?php while ( $article_loop->have_posts() ) : $article_loop->the_post(); ?>
						<li>
							<h4><?php the_title()?></h4>
							<div class="col-md-4"><?php the_post_thumbnail()?></div>
							<div class="col-md-8"><p><?php the_excerpt(); ?></p></div>
						</li>
					<?php endwhile;?>
				    </ul>
				</div>
			</div>
			
			</div><div style="clear:both"></div>
		    <?php } ?>
	<div class="block-content clearfix background-gray fullwidth text-center block-content-small-padding featured-builders as_featured-builders">
	<h3 class="center">Featured Builders </h3>
					        <div class="block-content-inner row">
					            <ul class="bxslider_featured">
					            <?php $args = array('post_type'=>'featured-builders', 'post_status' => 'publish', 'posts_per_page' => -1);
							  $builder_loop = new WP_Query($args);
							  while ( $builder_loop->have_posts() ) : $builder_loop->the_post(); ?>
					     		<li><a href="<?php the_field('link_to_builder'); ?>" target="_blank"><?php the_post_thumbnail('full'); ?></a> </li>
					     	    <?php endwhile; ?>
					            </ul>
					        </div>
					      </div>
					<?php 			dynamic_sidebar('bottom');
                    		} ?>
                    
                </div><!-- /.container -->
            </div><!-- /#main-inner -->
        </div><!-- /#main -->
    </div><!-- /#main-wrapper -->

    <div id="footer-wrapper">
        <div id="footer">
            <div id="footer-inner" class="as_footer">
              <?php if (aviators_active_sidebars(array('footer-left', 'footer-right', 'footer-lower-left', 'footer-lower-right'), AVIATORS_SIDEBARS_ANY)): ?>
                    <?php require_once 'templates/footer-top.php'; ?>
                <?php endif;  ?>

                <?php if (aviators_active_sidebars(array('footer-bottom'))): ?>

                    <?php require_once 'templates/footer-bottom.php'; ?>
                <?php endif; ?>
				<div class="clearfix"></div>
            </div><!-- /#footer-inner -->
        </div><!-- /#footer -->
    </div><!-- /#footer-wrapper -->
</div><!-- /#wrapper -->
<div id="topcontrol" class="scroll-top-img scroll-active" title="Scroll Back to Top" style="position: fixed;  bottom: 5px; right: 40px; cursor: pointer;">
	<img title="Back To Top" src="<?php bloginfo('template_directory'); ?>/images/up.png" style="z-index:1000; position:relative;">
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery( ".scroll-top-img" ).click(function() {
		jQuery('html, body').animate({scrollTop: '0px'}, 1000);
	});

	jQuery( ".scroll-top-img" ).removeClass( "scroll-active" ).addClass( "scroll-deactive" );

var iScrollPos = 100;
jQuery(window).scroll(function () {
    var iCurScrollPos = jQuery(this).scrollTop();
    if (iCurScrollPos > iScrollPos) {
    	jQuery( ".scroll-top-img" ).removeClass( "scroll-deactive" ).addClass( "scroll-active" );
    } else {
        //alert('up');
    	jQuery( ".scroll-top-img" ).removeClass( "scroll-active" ).addClass( "scroll-deactive" );
    }
    iScrollPos = iCurScrollPos;

	//DETAIL POSITION

	var detail_top_data = jQuery("#details").offset().top;
	var detail_bottom_data = jQuery("#details").position().top + jQuery("#details").outerHeight(true);

	//CATEGORY POSITION

	var flat_top_data = jQuery("#flats").offset().top;
	var flat_bottom_data = jQuery("#flats").position().top + jQuery("#flats").outerHeight(true);

	//AMENITIES POSITION

	var amenities_top_data = jQuery("#amenities").offset().top;
	var amenities_bottom_data = jQuery("#amenities").position().top + jQuery("#amenities").outerHeight(true);

	//LOCATION POSITION

	var map_top_data = jQuery("#map").offset().top;
	var map_bottom_data = jQuery("#map").position().top + jQuery("#map").outerHeight(true);

	//THREE SIXTY DATA

	var three_sixty_data_top_data = jQuery("#three_sixty_data").offset().top;
	var three_sixty_data_bottom_data = jQuery("#three_sixty_data").position().top + jQuery("#three_sixty_data").outerHeight(true);

	//GALLERY POSITION

	var gallery_top_data = jQuery("#gallery").offset().top;
	var gallery_bottom_data = jQuery("#gallery").position().top + jQuery("#gallery").outerHeight(true);

	// MARKET POSITION

	var line_chart_top_data = jQuery("#line_chart").offset().top;
	var line_chart_bottom_data = jQuery("#line_chart").position().top + jQuery("#line_chart").outerHeight(true);

	//console.log(iCurScrollPos+"=="+flat_top_data+"==="+flat_bottom_data);

	if(iCurScrollPos >= detail_top_data && iCurScrollPos <= detail_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(1) a").addClass("active");
	}

	if(iCurScrollPos >= flat_top_data && iCurScrollPos <= flat_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(2) a").addClass("active");
	}

	if(iCurScrollPos >= amenities_top_data && iCurScrollPos <= amenities_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(3) a").addClass("active");
	}

	if(iCurScrollPos >= map_top_data && iCurScrollPos <= map_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(4) a").addClass("active");
	}

	if(iCurScrollPos >= three_sixty_data_top_data && iCurScrollPos <= three_sixty_data_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(5) a").addClass("active");
	}

	if(iCurScrollPos >= gallery_top_data && iCurScrollPos <= gallery_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(6) a").addClass("active");
	}

	if(iCurScrollPos >= line_chart_top_data && iCurScrollPos <= line_chart_bottom_data){
		jQuery("div#mCSB_1_container ul li a").removeClass("active");
		jQuery("div#mCSB_1_container ul li:nth-child(7) a").addClass("active");
	}

	//alert(top_data);
});



	//var scroll_pos = jQuery(this).scrollTop();
	
	
	//jQuery("div#gallery ul.properties-filter li.selected > a").trigger("click").delay( 800 );
	//jQuery("div#gallery div.properties-filter li:first-child a").trigger("click");
	
	//jQuery("div.row-wise-amenities ul.properties-filter li:first-child a").trigger("click");
		
	setTimeout(function(){
	
		jQuery("div.row-wise-amenities ul.properties-filter li:first-child a").trigger("click");
		
	}, 2000);
	
        
        //jQuery("div#gallery div.gallery1").show();
        jQuery("div#gallery div.gallery2").hide();
        
        jQuery("div#gallery ul.properties-filter li a").on("click",function(e){
            e.preventDefault();
         //   alert('here');
           var attr_id = jQuery(this).attr('id');
           
           if(attr_id == "gallery1"){               
               jQuery("div#gallery div.gallery2").hide();
               jQuery("div#gallery div.gallery1").show();
           }
           if(attr_id == "gallery2"){               
               jQuery("div#gallery div.gallery1").hide();
               jQuery("div#gallery div.gallery2").show();
           }           
        });        
        
        
	jQuery("a#render_all_premium_properties").on("click",function(){	
		jQuery("ul.premium_property_filter li:first-child a").trigger("click");
	});
	
	
	jQuery(".im-interested .do-not-display").remove();
	jQuery("div.im-interested").css("border-color","none !important");

	jQuery("span#share_property").on("click",function(){
	
		jQuery("div.oss_title_replace").css("display","block");
		
		//$( "div.oss_title_replace" ).toggle();
		
	
	});

	jQuery("ul.map_section_data li a").on("click",function(){
		reallyDoSearch();
		return false;
	});

	if(jQuery("select#hydra-hf-property-location-filter-items-0-location").is(":disabled")){
	//	jQuery("select#hydra-hf-property-location-filter-items-0-location").parent().find("div.select-wrapper").addClass("UMMED");
	}

	//jQuery(".widget_wysija").validate();

	jQuery(".wysija-submit-field").on("click",function(e){
		e.preventDefault();

		jQuery("span.error").remove();

		var firstname_data = jQuery("div#subcribe_search_newsletter form input#firstname_data").val();
		var email_data = jQuery("div#subcribe_search_newsletter form input#email_data").val();

		if(email_data != ""){

			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
			if (filter.test(email_data)) {

				jQuery(this).parents("form").submit();

			}
			else {

				jQuery("div#subcribe_search_newsletter form input#email_data").after('</br><span class="error">Please enter valid email. </span>');

				return false;
			}

		}
		else{
			jQuery("div#subcribe_search_newsletter form input#email_data").after('</br><span class="error">Please enter email. </span>');
			return false;
		}


		setTimeout(function(){
			jQuery("span.error").remove();
		}, 2000);

	});

});
 </script>
 
 <style>
 
 .oss_title_replace{
 
 display:none;
 
 }
 
 </style>
 
<?php wp_footer(); ?>
<?php aviators_footer(); ?>
<?php $person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid'));if($person_field == 'Developer') {?><script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/slidx.js"></script><header> <button id="slidx_button"><i class="fa fa-bars" style="font-size: 26px;"></i></button>        <nav id="slidx_menu">            <?php echo do_shortcode('[custom_menu]'); ?>        </nav></header><?php } ?>
</body>
</html>