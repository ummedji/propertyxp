<?php 
$args = array('orderby'=>'asc','hide_empty'=>false,'parent'=>0);
$terms = get_terms('locations', $args);
foreach($terms as $term)
{
	$args = array('orderby'=>'asc','hide_empty'=>false,'parent'=>$term->term_id);
	$cityterms = get_terms('locations', $args);
	foreach($cityterms as $cityval)
	{
		$cityarr[] = $cityval;
	}
}

//$getcurrentcity = $_GET['hf_property_location_filter'];
$getcurrentcity = $_GET['hf_property_header_location_filter'];
$_GET['hf_property_location_filter'] = array();
$_GET['hf_property_location_filter']['items'][0]['location'] = $getcurrentcity;
//$getcurrentcity = $_GET['hf_property_location_filter']; //['items'][0]['location'];

if(!empty($getcurrentcity))
{
$selcity =	get_term_by( 'id', $getcurrentcity, 'locations');

	$_SESSION["selected_city"] = $selcity->name;

	//echo $_SESSION["selected_city"];die;

//$selcity = get_terms('locations', $getcurrentcity);
?>
<script>
jQuery(document).ready(function() {
jQuery('.as_header_bar .container > a').html('Change City : '+'<?php echo $selcity->name; ?>');

});
</script>
<?php } ?>
<script>
jQuery(document).ready(function() {
	
	jQuery("#hydra-hf-property-location-filter-items-0-location option:first").html('City');
	jQuery("#hydra-hf-property-location-filter-items-0-location option:first").attr('selected');
	jQuery("#hydra-hf-property-location-filter-items-0-sublocation option:first").html('Location');
	jQuery("#hydra-hf-property-location-filter-items-0-sublocation option:first").attr('selected');

	jQuery('#lunchBegins').change(function() {
	var term_id = this.value;
	if(term_id == 0){
		//alert("INNN");
	var url = '<?php echo get_bloginfo('url'); ?>';
	}
	else
	{
		//alert("OUT");
	var url = '<?php echo get_bloginfo('url'); ?>'+'/?hf_property_header_location_filter='+term_id+'&submit=Search';
	//[items][0][location]
		//console.log(url);
		//return false;

	}
	window.location.href = url;
	});
});

</script>
<div class="collapse" id="collapseExample">
    <div class="well_box text-center">
        <button class="btn btn-primary cls_btn" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <div class="fa fa-times" aria-hidden="true"></div>
        </button>
        <h3>SELECT YOUR CITY</h3>
        <form class="form-inline">
            <div class="form-group">
                <select id="lunchBegins" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Please select a lunch ...">
				<option value="0">Select City</option>
				<?php foreach($cityarr as $city) {  
				if($getcurrentcity == $city->term_id) { 
				$select = 'selected'; } else { $select = ''; } 
				?>
				 <option value="<?php echo $city->term_id; ?>" <?php echo $select; ?>><?php echo '<a href="'.get_bloginfo('url').'/properties/?hf_property_location_filter%5Bitems%5D%5B0%5D%5Bcountry%5D='.$term->term_id.'&submit=Search">' . $city->name . '</a>'; ?></option>
				<?php } ?>
				<?php ?>
                </select>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>
<div class="header-bar as_header_bar">
    <div class="container">
        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Select Your City
        </a>
       <!-- --><?php /*dynamic_sidebar( 'topbar-left'); */?>

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
            <?php //$menu = wp_nav_menu( array(
               // 'container_class' => 'header-bar-nav',
               // 'theme_location' => 'anonymous',
               // 'menu_class' => 'nav',
               // 'fallback_cb' => false,
               // 'echo' => false,
            //) ); ?>

            <?php //if ( substr_count( $menu, 'class="menu-item' ) > 0 ) : ?>
                <?php //echo $menu; ?>
            <?php //endif ?>
        <?php endif; ?>
        <?php
        $terms = get_terms( 'locations' , array('parent'=> 0,) );
        /*echo '<div class="all-state-list">';
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
	       
        echo '</div>';*/

       /* echo '<div class="terms_and">';

            $menu = wp_nav_menu( array(
                'container_class' => 'header-bar-nav',
                'theme_location' => 'anonymous',
                'menu_class' => 'nav',
                'fallback_cb' => false,
                'echo' => false,
            ) );

            echo $menu;
//<a href="#">Terms & Conditions</a>';

        echo '</div>';*/
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