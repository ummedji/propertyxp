<?php
/**
 * Template Name: Newsletter
 */
?>
<?php get_header(); ?>

<div id="main-content" class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php dynamic_sidebar( 'content-top' ); ?>

	 
    
   <?php while ( have_posts() ) : the_post(); ?>
        <div <?php post_class() ?>>
		    <div class="clearfix">
		        <div class="col-md-12">
		            <h2>
		                <!--<a href="<?php /*the_permalink(); */?>"><?php /*the_title(); */?></a>-->
						Subscribe News Letter
		                <?php echo aviators_edit_post_link(); ?>
		            </h2>
		
		            <div class="content-wrapper">
		                <div class="content">
			            <div class="col-md-12" style="margin-bottom: 20px;">
					<div class="col-md-2"></div>
		                    	<div class="newsletter-popup newsletter-page col-md-8">
			                	<img src="<?php bloginfo('template_directory'); ?>/images/NEWS-LETTER.png" alt="" />
								<?php echo do_shortcode('[wysija_form id="1"]'); ?>
					</div>
					<div class="col-md-2"></div>
				    </div>
				    <div class="col-md-12">
			                    <?php if ( is_single() || is_page()) : ?>
		                        <?php the_content(); ?>
		
			                    <?php else: ?>
			                        <?php the_excerpt(); ?>
			                    <?php endif; ?>
		                    </div>
							
		                </div><!-- /.content -->
		            </div><!-- /.content-wrapper -->
		        </div><!-- /.col-md-8 -->
		    </div>
		</div>
        

    <?php endwhile; ?>
	
    
    
    

    <?php dynamic_sidebar( 'content-bottom' ); ?>
</div><!-- /#main -->

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- /.sidebar -->
<?php endif; ?>

<?php get_footer(); ?>