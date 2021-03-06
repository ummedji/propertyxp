<?php if ( is_front_page() ) {	?>
<div id="properties-slider" class="carousel slide carousel_prp" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach($slides as $index => $slide): ?>
            <li data-target="#properties-slider" data-slide-to="<?php echo $index; ?>" class="<?php if($index == 0 ) { echo "active"; } ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">

    <?php
	$k = 0;

	foreach($slides as $index => $slide):

		$class = "";
		if($k == 0 || $k == 1){
			$class= " content-pink-parent";
		}

		?>

        <div class="item <?php if($index == 0) { print "active"; } echo $class; ?>">
            <a href="<?php echo get_permalink($slide); ?>">
                <img src="<?php echo aviators_get_featured_image($slide->ID, 870, 420); ?> " alt="<?php echo $slide->post_title; ?>">
            </a>
            <div class="slider-info">
                <div class="price">
                    <?php 
					//echo $slide->ID;
					//$price = getHydrameta($slide->ID,'hf_property_starting_price_0_value');
					$price = get_field('hf_property_starting_price_0_value',$slide->ID);
					$num = $price;
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
					//echo hydra_render_field($slide->ID, 'price'); ?>
                </div>
                <!-- /.price-->

                <h2>
                    <a href="<?php echo get_permalink($slide); ?>"><?php echo $slide->post_title; ?></a>
                </h2>

                <?php 
				//echo hydra_render_group($slide->ID, 'meta');

			$configration_value = get_field( "configurations", $slide->ID );
			$possession_value = get_field( "hf_property_newpossession", $slide->ID );

				$possessionvalue = "";
				if(!empty($possession_value)){
					$possessionvalue = $possession_value["items"][0]["value"];
				}

			//	echo "<pre>";
			//	print_r($possession_value);

			$area_value = get_field('hf_property_area',$slide->ID);
			
			$areavalue = "";
			if(!empty($area_value)){
				$areavalue = $area_value["items"][0]["value"];
			}
			
			$price_value = get_field('hf_property_starting_price_0_value',$slide->ID);
			//$price_value = getHydrameta($slide->ID,'hf_property_starting_price_0_value');
?>
			
			
			<div class=" html-group meta hf-property-meta">

				<div class="field-items">
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" col-xs-3 number number hf-property-bathrooms">
								<div class="label"><p>Configuration</p></div>
								<div class="field-item field-item-0">
									<?php $new_configration_value = substr($configration_value,0,16); ?>
									<div class="field-value" title="<?php echo $configration_value; ?>"><?php echo trim($new_configration_value); ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" col-xs-3 number number hf-property-bedrooms">
								<div class="label"><p>Possession</p></div>
								<div class="field-item field-item-0">
									<?php //$possession_value = substr($possession_value,0,16); ?>
									<div class="field-value"><?php echo $possessionvalue; ?></div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" col-xs-3 number number hf-property-area">
								<div class="label"><p>Area</p></div>
								<div class="field-item field-item-0">
									
									<div class="field-value"><span class="area_data"><?php echo $areavalue; ?></span> Sq. Ft.</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" no-columns number number hf-property-price ummed222">
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
									$fraction=number_format($fraction,2);
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
            </div>
            <!-- /.slider - info-->
        </div><!-- /.slide-->
    <?php

	$k++;

	endforeach; ?>
    </div>

    <a class="left carousel-control" href="#properties-slider" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>

    <a class="right carousel-control" href="#properties-slider" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<?php }else{ ?>
<div id="properties-slider" class="carousel slide carousel_prp" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach($slides as $index => $slide): ?>
            <li data-target="#properties-slider" data-slide-to="<?php echo $index; ?>" class="<?php if($index == 0 ) { echo "active"; } ?>"></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">

    <?php foreach($slides as $index => $slide): ?>

        <div class="item <?php if($index == 0) { print "active"; } ?>">
            <a href="<?php echo get_permalink($slide); ?>">
                <img src="<?php echo aviators_get_featured_image($slide->ID, 870, 420); ?> " alt="<?php echo $slide->post_title; ?>">
            </a>
            <div class="slider-info">
                <div class="price">
                    <?php //echo hydra_render_field($slide->ID, 'hf_property_starting_price_0_value'); ?>

					<?php
					//echo $slide->ID;
					//$price = getHydrameta($slide->ID,'hf_property_starting_price_0_value');
					$price = get_field('hf_property_starting_price_0_value',$slide->ID);
					$num = $price;
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
					//echo hydra_render_field($slide->ID, 'price'); ?>

                </div>
                <!-- /.price-->

                <h2>
                    <a href="<?php echo get_permalink($slide); ?>"><?php echo $slide->post_title; ?></a>
                </h2>

                <?php //echo hydra_render_group($slide->ID, 'meta'); ?>


				<?php
				//echo hydra_render_group($slide->ID, 'meta');

				$configration_value = get_field( "configurations", $slide->ID );
				$possession_value = get_field( "hf_property_newpossession", $slide->ID );

				$possessionvalue = "";
				if(!empty($possession_value)){
					$possessionvalue = $possession_value["items"][0]["value"];
				}

				//	echo "<pre>";
				//	print_r($possession_value);

				$area_value = get_field('hf_property_area',$slide->ID);

				$areavalue = "";
				if(!empty($area_value)){
					$areavalue = $area_value["items"][0]["value"];
				}

				$price_value = get_field('hf_property_starting_price_0_value',$slide->ID);
				//$price_value = getHydrameta($slide->ID,'hf_property_starting_price_0_value');
				?>

				<div class=" html-group meta hf-property-meta">

					<div class="field-items">
						<div class="group-field-item">
							<div class="field-item-inner">
								<div class=" col-xs-3 number number hf-property-bathrooms">
									<div class="label"><p>Configuration</p></div>
									<div class="field-item field-item-0">
										<?php $new_configration_value = substr($configration_value,0,16); ?>
										<div class="field-value" title="<?php echo $configration_value; ?>"><?php echo trim($new_configration_value); ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="group-field-item">
							<div class="field-item-inner">
								<div class=" col-xs-3 number number hf-property-bedrooms">
									<div class="label"><p>Possession</p></div>
									<div class="field-item field-item-0">
										<?php //$possession_value = substr($possession_value,0,16); ?>
										<div class="field-value"><?php echo $possessionvalue; ?></div>

									</div>
								</div>
							</div>
						</div>
						<div class="group-field-item">
							<div class="field-item-inner">
								<div class=" col-xs-3 number number hf-property-area">
									<div class="label"><p>Area</p></div>
									<div class="field-item field-item-0">

										<div class="field-value"><span class="area_data"><?php echo $areavalue; ?></span> Sq. Ft.</div>

									</div>
								</div>
							</div>
						</div>
						<div class="group-field-item">
							<div class="field-item-inner">
								<div class=" no-columns number number hf-property-price ummed222">
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
											$fraction=number_format($fraction,2);
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

            </div>
            <!-- /.slider - info-->
        </div><!-- /.slide-->
    <?php endforeach; ?>
    </div>

    <a class="left carousel-control" href="#properties-slider" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>

    <a class="right carousel-control" href="#properties-slider" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<?php } ?>
<?php 
if (function_exists('count_digit')) { 
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
}



?>