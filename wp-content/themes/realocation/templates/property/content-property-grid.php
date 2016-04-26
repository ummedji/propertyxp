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
			
			$configration_value = get_field( "configurations", $postid );
			$possession_value = get_field( "possession", $postid );
			
			$area_value = get_field('hf_property_area',$postid);
			
			$price_value = get_field('starting_price',$postid);
			$areavalue = "";
			if(!empty($area_value)){
				$areavalue = $area_value["items"][0]["value"];
			}
			
			//echo "<pre>";
			//print_r($configration_value);
			//print_r($possession_value);
			//print_r($area_value);
			//print_r($price_value);
		
			
			?>
			
			
				<div class="field-items">
					
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class="col-xs-3 no-columns number number hf-property-bathrooms">
								<div class="label">
									<p>Configuration</p>
								</div>
								<div class="field-item field-item-0">
									<div class="field-prefix"></div>
									<div class="field-value"><?php echo $configration_value; ?></div>
									<div class="field-suffix"></div>
								</div>
							</div>
						</div>
					</div>
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class="col-xs-3 no-columns number number hf-property-bedrooms">
								<div class="label">
									<p>Area</p>
								</div>
								<div class="field-item field-item-0">
									<div class="field-prefix"></div>
									<div class="field-value"><?php echo $areavalue; ?></div>
									<div class="field-suffix"></div>
								</div>
							</div>
						</div>
					</div>
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class="col-xs-3 no-columns number number hf-property-area">
								<div class="label"><p>Possession</p></div>
								<div class="field-item field-item-0">
									<div class="field-prefix"></div>
									<div class="field-value"><?php echo $possession_value; ?></div>
									<div class="field-suffix"></div>
								</div>
							</div>
						</div>
					</div>
                    <div class="group-field-item">
						<div class="field-item-inner">
							<div class=" no-columns number number hf-property-price">
								<div class="label"><p>Price</p></div>
								<div class="field-item field-item-0">
									<div class="field-prefix"></div>
									<div class="field-value"><?php echo $price_value; ?></div>
									<div class="field-suffix"></div>
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



