<?php if ( is_front_page() ) {	?>
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
                    <?php echo hydra_render_field($slide->ID, 'price'); ?>
                </div>
                <!-- /.price-->

                <h2>
                    <a href="<?php echo get_permalink($slide); ?>"><?php echo $slide->post_title; ?></a>
                </h2>

                <?php 
				//echo hydra_render_group($slide->ID, 'meta');

				$configration_value = get_field( "configurations", $slide->ID );
			$possession_value = get_field( "possession", $slide->ID );
			
			$area_value = get_field('hf_property_area',$slide->ID);
			
			$areavalue = "";
			if(!empty($area_value)){
				$areavalue = $area_value["items"][0]["value"];
			}
			
			$price_value = get_field('starting_price',$slide->ID);
?>
			
			
			<div class=" html-group meta hf-property-meta">

				<div class="field-items">
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" col-xs-3 number number hf-property-bathrooms">
								<div class="label"><p>Config.</p></div>
								<div class="field-item field-item-0">
									<?php $new_configration_value = substr($configration_value,0,16).'..'; ?>
									<div class="field-value" title="<?php echo $configration_value; ?>"><?php echo $new_configration_value; ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" col-xs-3 number number hf-property-bedrooms">
								<div class="label"><p>Possession</p></div>
								<div class="field-item field-item-0">
									<?php $possession_value = substr($possession_value,0,6).'..'; ?>
									<div class="field-value"><?php echo $possession_value; ?></div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" col-xs-3 number number hf-property-area">
								<div class="label"><p>Area</p></div>
								<div class="field-item field-item-0">
									
									<div class="field-value"><?php echo $areavalue; ?></div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="group-field-item">
						<div class="field-item-inner">
							<div class=" no-columns number number hf-property-price">
								<div class="label"><p>Price</p></div>
								<div class="field-item field-item-0">
									
									<div class="field-value"><i class="fa fa-inr fa-1x"></i><?php echo $price_value; ?></div>
									
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
<?php }else{ ?>
<div id="properties-slider" class="carousel slide" data-ride="carousel">
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
                    <?php echo hydra_render_field($slide->ID, 'price'); ?>
                </div>
                <!-- /.price-->

                <h2>
                    <a href="<?php echo get_permalink($slide); ?>"><?php echo $slide->post_title; ?></a>
                </h2>

                <?php echo hydra_render_group($slide->ID, 'meta'); ?>
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