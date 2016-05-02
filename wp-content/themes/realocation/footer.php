                                </div><!-- /.row -->
                            </div><!-- /.block-content-inner -->
                        </div><!-- /.block-content-small-padding -->
                       
                    <?php 	$person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid')); 
                    		if (is_singular(array('property')) && $person_field == 'Developer') { 
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
<div id="topcontrol" class="scroll-top-img scroll-active" title="Scroll Back to Top" style="position: fixed;  bottom: 5px; right: 5px; cursor: pointer;">
	<img title="Back To Top" src="<?php bloginfo('template_directory'); ?>/images/up.png" style="z-index:1000; position:relative;">
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery( ".scroll-top-img" ).click(function() {
		jQuery('html, body').animate({scrollTop: '0px'}, 1000);
	});
var iScrollPos = 0;
jQuery(window).scroll(function () {
    var iCurScrollPos = jQuery(this).scrollTop();
    if (iCurScrollPos > iScrollPos) {
    	jQuery( ".scroll-top-img" ).removeClass( "scroll-deactive" ).addClass( "scroll-active" );
    } else {
        //alert('up');
    	jQuery( ".scroll-top-img" ).removeClass( "scroll-active" ).addClass( "scroll-deactive" );
    }
    iScrollPos = iCurScrollPos;
	});
	
	//jQuery("div.row-wise-amenities ul.properties-filter li:first-child a").trigger("click");
		
	setTimeout(function(){
		//alert("UD");
		jQuery("div.row-wise-amenities ul.properties-filter li:first-child a").trigger("click");
		
	}, 2000);
	
	setTimeout(function(){
	//	alert("HERE");
		alert(jQuery("div#gallery").find("properties-filter").html());
		
	}, 4000);
	
	
	jQuery("a#render_all_premium_properties").on("click",function(){
	
		jQuery("ul.premium_property_filter li:first-child a").trigger("click");
	});
	
	
	jQuery(".im-interested .do-not-display").remove();
	jQuery("div.im-interested").css("border-color","none !important");

	jQuery("span#share_property").on("click",function(){
	
		jQuery("div.oss_title_replace").css("display","block");
		
		//$( "div.oss_title_replace" ).toggle();
		
	
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