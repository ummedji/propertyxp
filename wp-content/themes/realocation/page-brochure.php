<?php
/**
 * Template Name: Brochure
 */
?>
<?php get_header(); ?>

<div id="main-content" class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php dynamic_sidebar( 'content-top' ); ?>

    
    
    <div class="row">
    	<div class="search-brochure-form">
<!-- 		<img src="http://localhost/proxp/wp-content/themes/realocation/images/BROCHURE-SEARCH.png"> -->
	    	<div class="col-md-12">
				<h2>Search Brochure</h2>
			</div>
			<div class="col-md-12">
				<div class="col-md-2"></div>
				<div class="col-md-8 center">
					<img style="margin-bottom:20px" src="<?php bloginfo('template_directory'); ?>/images/BROCHURE.png" alt="" />
				</div>
				<div class="col-md-2"></div>
			</div>
			<div class="col-md-12 brochure-form">
				<form method="GET" action="<?php bloginfo('url'); ?>/brochures-page/">
					<div class="col-md-3">
						<label>Brochure Name</label>
						<p><input type="text" name="searchfield" value="<?php echo (isset($_GET['searchfield'])  && $_GET['searchfield'] != "")?$_GET['searchfield']:""; ?>"/></p>
					</div>
					<div class="col-md-3">
						<label>State</label>
						<div class="statewise">
							<select name="statewise" class="form-control">
							<option value="">Any</option>
							<option value="gujarat" <?php echo (isset($_GET['statewise'])  && $_GET['statewise'] != "" && $_GET['statewise'] == "gujarat")? "selected":""; ?>>Gujarat</option>
							<option <?php echo (isset($_GET['statewise'])  && $_GET['statewise'] != "" && $_GET['statewise'] == "madhya-pradesh")? "selected":""; ?> value="madhya-pradesh">Madhya Pradesh</option>
							<option <?php echo (isset($_GET['statewise'])  && $_GET['statewise'] != "" && $_GET['statewise'] == "rajasthan")? "selected":""; ?> value="rajasthan">Rajasthan</option>
							<option <?php echo (isset($_GET['statewise'])  && $_GET['statewise'] != "" && $_GET['statewise'] == "maharashtra")? "selected":""; ?> value="maharashtra">Maharashtra</option>
							</select>
						</div>
					</div>
					
					<div class="col-md-3">
						<label>Property Type</label>
						<div class="propertywise">
							<select name="propertywise" class="form-control">
							<option value="">Any</option>
							<option <?php echo (isset($_GET['propertywise'])  && $_GET['propertywise'] != "" && $_GET['propertywise'] == "villa")? "selected":""; ?> value="villa">Villa</option>
							<option <?php echo (isset($_GET['propertywise'])  && $_GET['propertywise'] != "" && $_GET['propertywise'] == "bunglows")? "selected":""; ?> value="bunglows">Bunglows</option>
							<option <?php echo (isset($_GET['propertywise'])  && $_GET['propertywise'] != "" && $_GET['propertywise'] == "apartment")? "selected":""; ?> value="apartment">Apartment</option>
							</select>
						</div>
					</div>
					
					<div class="col-md-3">
						<label>&nbsp;</label>
						<p><input type="submit" value="Submit"></p>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	
	<?php //if( $_GET['searchfield'] != '' || $_GET['statewise'] != '' || $_GET['propertywise'] != '' ) { ?>	    
	    <div class="row">
	    	<div class="col-md-12">
	    		<h4>Search Results as per <b>Brochure Name</b> : <?php echo $_GET['searchfield']; ?>, <b>State</b> : <?php echo $_GET['statewise']; ?> and <b>Property Type</b> : <?php echo $_GET['propertywise']; ?></h4>
	    	</div>
	    </div>
	    <?php

	//	echo "<pre>";
	//	print_r($_GET);
	//	print_r($_POST);

		global $wpdb;
	    	$args = array(
	    					'post_type'=>'brochures',
	    					'post_status'=>'publish',
	    					'statewise' => $_GET['statewise'],
	    					'propertywise' => $_GET['propertywise'],
	    					's' => $_GET['searchfield'],
							'posts_per_page' => -1
			); ?>

	<?php $loops = new WP_Query($args); ?>

	<?php //echo $GLOBALS['wp_query']->request;die; ?>

	    <?php while ( $loops->have_posts() ) : $loops->the_post(); ?>
	        	<div class="row">
		        	<div class="col-md-12">
		        		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		        	</div>
		        	<div class="col-md-12">					<div class="col-md-4"><?php the_post_thumbnail(array(270,250)); ?></div>
		        	<div class="col-md-8"><?php the_content(); ?>			        	<?php $brochure_file = get_field('upload_brochure'); 			        	      if( $brochure_file) { ?>			        		<h5 class="brochure-pdf-link" ><a target="_blank" href="<?php echo $brochure_file['url']; ?>">Download Brochure</a></h5>			        	<?php } ?>		        	</div>
		        	</div>
	        	</div>
	    <?php endwhile; ?>
    <?php /*} else {?>
    	  <div class="row">
	    	<div class="col-md-12"><p>No Results found.</p></div>
	      </div>
    <?php }*/?>
    
    
    

    <?php dynamic_sidebar( 'content-bottom' ); ?>
</div><!-- /#main -->

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </div><!-- /.sidebar -->
<?php endif; ?>

<?php get_footer(); ?>