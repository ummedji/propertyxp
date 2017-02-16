<div class="property-small clearfix small-image-s UMMED">
    <?php if(has_post_thumbnail()): ?>
    <div class="property-small-picture col-sm-12 col-md-4 col-xs-3">
        <div class="property-small-picture-inner">
            <a href="<?php echo get_permalink(); ?>" class="property-small-picture-target">
                <img src="<?php echo aviators_get_featured_image(get_the_ID(), 100, 100); ?>" alt="<?php the_title(); ?>">
            </a>
        </div><!-- /.property-small-picture -->
    </div><!-- /.property-small-picture -->
    <?php endif; ?>

    <div class="property-small-content col-sm-12 col-md-8 col-xs-8">
        <h3 class="property-small-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3><!-- /.property-small-title -->
        <?php //echo hydra_render_group(get_the_ID(), 'information', 'sidebar'); ?>


        <div class=" html-group information hf-property-information">

            <div class="field-items">
                <div class="group-field-item">
                    <div class="field-item-inner">
                        <div class=" no-columns number number hf-property-price"><div class="label"><p>Price</p></div><div class="field-item field-item-0"><div class="field-value"><!--<i class="fa fa-inr fa-1x"></i>-->

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
                                    echo $fraction." ".$ext;//print hydra_render_field(get_the_ID(), 'price', 'detail'); ?>


                                </div></div></div>                </div>
                </div>
                <div class="group-field-item">
                    <div class="field-item-inner">

                        <?php
                            $property_type = getHydrameta(get_the_ID(), 'hf_property_type');
                            $property_type_name  = get_term( $property_type,"types" );
                        ?>

                        <div class=" no-columns taxonomy taxonomy hf-property-type"><div class="label"><p>Property Type</p></div><div class="field-item field-item-0"><a href="http://www.propertyxp.com/property-type/<?php echo $property_type_name->slug; ?>"><?php echo $property_type_name->name; ?></a></div></div>                </div>
                </div>
            </div>
        </div>


    </div><!-- /.property-small-content -->
</div>