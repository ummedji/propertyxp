<div class="property-row">
    <div class="row">
        <div class="property-row-picture col-sm-6 col-md-6 col-lg-4 inner-pro-parent">

            <div class="property-row-picture-inner">
                <a href="<?php echo get_permalink(); ?>" class="property-row-picture-target">
                    <img src="<?php echo aviators_get_featured_image(get_the_ID(), 284, 284); ?>" alt="<?php the_title(); ?>">
                </a>

                <div class="property-row-meta">
                    <?php //echo hydra_render_group(get_the_ID(), 'meta', 'row'); ?>

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

                    <div class=" html-group meta hf-property-meta">

                        <div class="field-items">
                            <div class="group-field-item">
                                <div class="field-item-inner">
                                    <div class=" col-xs-3 number number hf-property-bathrooms"><div class="label"><p>Config.</p></div><div class="field-item field-item-0"><div class="field-prefix"></div>

                                            <?php $new_configration_value = substr($configration_value,0,16); ?>

                                            <div class="field-value" title="<?php echo $configration_value; ?>"><?php echo trim($new_configration_value); ?></div>

                                            <div class="field-suffix"></div></div></div>                </div>
                            </div>
                            <div class="group-field-item">
                                <div class="field-item-inner">
                                    <div class=" col-xs-3 number number hf-property-bedrooms"><div class="label"><p>Area</p></div><div class="field-item field-item-0"><div class="field-prefix"></div><div class="field-value"><span class="area_data"><?php echo $area_value; ?></span> Sq. Ft.</div><div class="field-suffix"></div></div></div>                </div>
                            </div>
                            <div class="group-field-item">
                                <div class="field-item-inner">
                                    <div class=" col-xs-3 number number hf-property-area"><div class="label"><p>Possession</p></div><div class="field-item field-item-0"><div class="field-prefix"></div><div class="field-value"><?php echo $possession_value; ?></div><div class="field-suffix"></div></div></div>                </div>
                            </div>
                            <div class="group-field-item">
                                <div class="field-item-inner">
                                    <div class=" no-columns number number hf-property-price"><div class="label"><p>Price</p></div><div class="field-item field-item-0"><div class="field-prefix"></div><div class="field-value">&nbsp;<!--<i class="fa fa-inr fa-1x"></i>-->
                                                <?php

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

                                                //echo $price_value; ?>
                                            </div><div class="field-suffix"></div></div></div>                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- /.property-row-meta -->
            </div>
            <!-- /.property-row-picture -->
        </div>
        <!-- /.property-row-picture -->

        <div class="property-row-content col-sm-6 col-md-6 col-lg-8 col-md-6 col-lg-8">
            <h3 class="property-row-title">
                <a href="<?php echo get_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h3><!-- /.property-row-title -->

            <div class="property-row-subtitle">
                <?php echo hydra_render_field(get_the_ID(), 'location', 'row'); ?>
            </div><!-- /.property-row-subtitle -->

            <div class="property-row-price"><?php  echo $fraction." ".$ext;//hydra_render_field(get_the_ID(), 'price', 'row'); ?></div>
            <!-- /.property-row-price -->

            <?php the_excerpt(); ?>
        </div>
        <!-- /.property-row-content -->
    </div>
    <!-- /.row -->
</div>

