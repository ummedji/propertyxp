<div class="infobox">
    <div class="infobox-header">
    	<h3 class="infobox-title">
    		<?php if(is_page('map-mode')) {?>
    		<a target="_blank" href="<?php bloginfo('url')//print get_permalink($property->ID); ?>/map-mode?prop_id=<?php echo $property->ID; ?>"><?php print addslashes($property->post_title); ?></a>
    		<?php } else {?>
    		<a target="_blank"  href="<?php print get_permalink($property->ID); ?>"><?php print addslashes($property->post_title); ?></a>
    		<?php } ?>
    	</h3>
    </div>
    <div class="infobox-picture"><a href="<?php print get_permalink($property->ID); ?>"><img
                src="<?php print aviators_get_featured_image($property->ID, 150, 150)?>" alt="#"></a>

<?php
		$price = getHydrameta($property->ID, 'hf_property_starting_price');
		$num = $price;
		$ext="";
		$number_of_digits = count_digit($num);
		if($number_of_digits>3)
		{
		if($number_of_digits%2!=0)
		$divider=divider($number_of_digits-1);
		else
		$divider=divider($number_of_digits);
		}
		else
		$divider=1;
		$fraction=$num/$divider;
		//$fraction=number_format($fraction,2);
		if($number_of_digits==4 ||$number_of_digits==5)
		$ext="k";
		if($number_of_digits==6 ||$number_of_digits==7)
		$ext="Lac";
		if($number_of_digits==8 ||$number_of_digits==9)
		$ext="Cr";
?>

        <div class="infobox-price"><?php echo $fraction." ".$ext;// print hydra_render_field($property->ID, 'price');?></div>
    </div>
</div>
