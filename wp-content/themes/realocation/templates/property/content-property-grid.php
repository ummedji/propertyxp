<div class="property-box">
    <div class="property-box-inner">
        <div class="property-box-header">
            <h3 class="property-box-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="property-box-subtitle"><?php print hydra_render_field(get_the_ID(), 'location', 'grid'); ?></div>
        </div><!-- /.property-box-header -->

        <div class="property-box-picture">
            <div class="property-box-price"><?php echo hydra_render_field(get_the_ID(), 'price', 'grid'); ?></div><!-- /.property-box-price -->
            <div class="property-box-picture-inner">
                <a href="<?php echo get_permalink(); ?>" class="property-box-picture-target">
                    <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
                </a><!-- /.property-box-picture-target -->
            </div><!-- /.property-picture-inner -->
        </div><!-- /.property-picture -->

        <div class="property-box-meta asproperty-box-meta">
            <?php //echo hydra_render_group(get_the_ID(), 'meta', 'grid'); ?>
			
			
			<div class=" html-group meta hf-property-meta">
			<?php
			$post = get_post();
			$postid = $post->ID;
			//$configration_value = get_field( "configurations", $postid );
			$configration_value = getHydrameta($postid,'hf_property_configurations');	
			//$possession_value = get_field( "possession", $postid );
			//$possession_value = getHydrameta($postid,'hf_property_possession','date');
			$possession_value = getHydrameta($postid,'hf_property_newpossession');
			//$area_value = get_field('hf_property_area',$postid);
			$area_value = getHydrameta($postid,'hf_property_builtup_area');
			//$price_value = get_field('starting_price',$postid);
			$price_value = getHydrameta($postid,'hf_property_starting_price');	
		//	$areavalue = "";
			/*if(!empty($area_value)){
				$areavalue = $area_value["items"][0]["value"];
			}*/
			
			//echo "<pre>";
			//print_r($configration_value);
			//print_r($possession_value);
			//print_r($area_value);
			//print_r($price_value);
		
			
			?>
			
			
				<div class="field-items">
					
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class="no-columns number number hf-property-bathrooms">
								<div class="label">
									<p>Config.</p>
								</div>
								<div class="field-item field-item-0">
									<?php $new_configration_value = substr($configration_value,0,16); ?>
									<div class="field-value" title="<?php echo $configration_value; ?>"><?php echo trim($new_configration_value); ?></div>
									
								</div>
							</div>
						</div>
					</div>
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class="no-columns number number hf-property-bedrooms">
								<div class="label">
									<p>Area</p>
								</div>
								<div class="field-item field-item-0">
									
									<div class="field-value"><span class="area_data"><?php echo $area_value; ?></span> Sq. Ft.</div>
									
								</div>
							</div>
						</div>
					</div>
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class="no-columns number number hf-property-area">
								<div class="label"><p>Possession</p></div>
								<div class="field-item field-item-0">
									<?php //$possession_value = substr($possession_value,0,16); ?>
									<div class="field-value"><?php echo $possession_value; ?></div>
									
								</div>
							</div>
						</div>
					</div>
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class=" no-columns number number hf-property-price">
								<div class="label"><p>Price</p></div>
								<div class="field-item field-item-0">
									
									<div class="field-value"><?php

									//function call
									$num = $price_value;
									$ext="";//thousand,lac, crore
									$number_of_digits = count_digit($num); //this is call :)
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

									//echo $price_value; ?></div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			
			
        </div><!-- /.property-box-meta -->
        <div class="clearfix"></div>
    </div><!-- /.property-box-inner -->
</div><!-- /.property-box -->

<?php 
/* if (function_exists('count_digit')) { 
}
else
{
	function count_digit($number) {
	  return strlen($number);
	}	
}
if (function_exists('divider')) { 
}
else
{
	function divider($number_of_digits) {
		$tens="1";
	  while(($number_of_digits-1)>0)
	  {
		$tens.="0";
		$number_of_digits--;
	  }
	  return $tens;
	}	
} */

?>