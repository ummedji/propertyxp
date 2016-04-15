<div class="infobox">
    <div class="infobox-header">
    	<h3 class="infobox-title">
    		<?php if(is_page('map-mode')) {?>
    		<a href="<?php bloginfo('url')//print get_permalink($property->ID); ?>/map-mode?prop_id=<?php echo $property->ID; ?>"><?php print addslashes($property->post_title); ?></a>
    		<?php } else {?>
    		<a href="<?php print get_permalink($property->ID); ?>"><?php print addslashes($property->post_title); ?></a>
    		<?php } ?>
    	</h3>
    </div>
    <div class="infobox-picture"><a href="<?php print get_permalink($property->ID); ?>"><img
                src="<?php print aviators_get_featured_image($property->ID, 150, 150)?>" alt="#"></a>
        <div class="infobox-price"><?php print hydra_render_field($property->ID, 'price');?></div>
    </div>
</div>
