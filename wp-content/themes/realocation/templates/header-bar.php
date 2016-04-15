<div class="header-bar">
    <div class="container">
        <?php dynamic_sidebar( 'topbar-left'); ?>

        <?php if ( function_exists( 'icl_sitepress_activate' ) ) : ?>
            <?php echo do_action( 'icl_language_selector' ); ?>
        <?php endif; ?>

        <?php if (is_user_logged_in()) : ?>
            <?php $menu = wp_nav_menu( array(
                'container_class' => 'header-bar-nav',
                'theme_location' => 'authenticated',
                'menu_class' => 'header-bar-nav nav',
                'fallback_cb' => false,
                'echo' => false,
            ) ); ?>

            <?php if ( substr_count( $menu, 'class="menu-item' ) > 0 ) : ?>
                <?php echo $menu; ?>
            <?php endif; ?>
        <?php else : ?>
            <?php $menu = wp_nav_menu( array(
                'container_class' => 'header-bar-nav',
                'theme_location' => 'anonymous',
                'menu_class' => 'nav',
                'fallback_cb' => false,
                'echo' => false,
            ) ); ?>

            <?php if ( substr_count( $menu, 'class="menu-item' ) > 0 ) : ?>
                <?php echo $menu; ?>
            <?php endif ?>
        <?php endif; ?>
        <?php 
        $terms = get_terms( 'locations' , array('parent'=> 0,) );
        echo '<div class="all-state-list">';
        	echo '<div class="select-your-state-or-city">Select Your state or city</div>';
	        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	        	echo '<div class="state-menu">';
		        	foreach ( $terms as $term ) {
						
		        		echo '<a href="'.get_bloginfo('url').'/properties/?hf_property_location_filter%5Bitems%5D%5B0%5D%5Bcountry%5D='.$term->term_id.'&submit=Search">' . $term->name . '</a>';
		        		
		        		$child_terms = get_terms( 'locations' , array('parent'=> $term->term_id) );
		        		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		        			echo '<div class="sub-menu">';
			        			foreach ( $child_terms as $child_term ) {
			        				echo "<a href='".get_bloginfo('url')."/?hf_property_type_filter%5Bcount%5D=1&hf_property_location_filter%5Bitems%5D%5B0%5D%5Bcountry%5D=".$term->term_id."&hf_property_location_filter%5Bitems%5D%5B0%5D%5Blocation%5D=".$child_term->term_id."&hf_property_location_filter%5Bcount%5D=1&submit=Search'>";
			        				 echo $child_term->name . '</a>';
			        			}
		        			echo '</div>';
						}
		        	}
	        	echo '</div>';
	        }
	       
        echo '</div>';
        ?>
        <?php /* ?>
        <div class="widget widget_text">
        <select name="select-state" class="state-select option-state-select">
        <option value="" selected="selected">Any State</option>
		  <option value="282">Gujarat</option>
		  <option value="290">Maharastra</option>
		</select>
		</div>
		<!-- http://localhost/proxp/properties/?hf_property_type_filter%5Bcount%5D=1&hf_property_location_filter%5Bitems%5D%5B0%5D%5Bcountry%5D=282&hf_property_location_filter%5Bitems%5D%5B0%5D%5Blocation%5D=283&hf_property_location_filter%5Bcount%5D=1&submit=Search -->
		<script type="text/javascript">
		jQuery( document ).ready(function() {
			jQuery( ".option-state-select" ).change(function() {
					
					window.location.href ='<?php bloginfo('url')?>/properties/?hf_property_location_filter%5Bitems%5D%5B0%5D%5Bcountry%5D='+jQuery( ".state-select" ).val()+'&submit=Search';
				  
				});
		});
		</script> 
		<?php */ ?>
    </div><!-- /.container -->

</div><!-- /.header-bar -->