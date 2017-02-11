<div class="property-item">
    <div class="property-box small">
        <div class="property-box-inner">
            <div class="property-box-header">
                <h3 class="property-box-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                <div class="property-box-subtitle"><?php print hydra_render_field(get_the_ID(), 'location', 'small'); ?></div>
            </div><!-- /.property-box-header -->

            <div class="property-box-picture">
                <div class="property-box-price">
				<?php $price = getHydrameta(get_the_ID(), 'hf_property_starting_price'); 
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
				echo $fraction." ".$ext;
				?>
				<?php?>
			</div><!-- /.property-box-price -->
                <div class="property-box-picture-inner">
                    <a href="<?php echo get_permalink(); ?>" class="property-box-picture-target">
                        <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
                    </a><!-- /.property-box-picture-target -->
                </div><!-- /.property-picture-inner -->
            </div><!-- /.property-picture -->
        </div><!-- /.property-box-inner -->
    </div><!-- /.property-box -->
</div>
<?php 
if (function_exists('count_digit')) { 
}
else
{
	function count_digit($number) { echo "aaa";
	  return strlen($number);
	}	
}
if (function_exists('divider')) { 
}
else
{
	function divider($number_of_digits) {
		//echo "bbb";
		$tens="1";
	  while(($number_of_digits-1)>0)
	  {
		$tens.="0";
		$number_of_digits--;
	  }
	  return $tens;
	}	
}



?>
