<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($) {

		$(".details-options a").click(function(){
	//event.preventDefault();
			$("#menu").slideToggle("slow");
		});

  });

    jQuery(document).ready(function($) {
    	jQuery('a[href*=#]:not([href=#])').click(function() {
    	if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

    	  var target = $(this.hash);
    	  target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
    	  if (target.length) {
    		  jQuery('html,body').animate({
    	  scrollTop: target.offset().top
    	}, 1000);

		if($('#menu').css('display') != 'none')
			$('#bar').find('a').click();

		return false;

    	  }
    	}
    });
 });

    jQuery(function(){
 var shrinkHeader = 300;
 jQuery(window).scroll(function() {
    var scroll = getCurrentScroll();
      if ( scroll >= shrinkHeader ) {
    	  jQuery('#header').addClass('shrink');
        }
        else {
        	jQuery('#header').removeClass('shrink');
        }
  });
function getCurrentScroll() {
    return window.pageYOffset;
    }
});

function handleResize() {
var h = jQuery(window).height();
jQuery('.location-map , #who-we-are , #what-we-do , #portfolio , #clients , #contact , #inetwork , .banner , .banner .flexslider .slides > li').css({'height':h+'px'});
}
jQuery(function(){
        handleResize();
        jQuery(window).resize(function(){
        handleResize();
    });
});

</script>
<script type="text/javascript">
    jQuery("document").ready(function () {
        var nav = jQuery('.developer-menu');

        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 770) {
                nav.addClass("fixed");
            } else {
                nav.removeClass("fixed");
            }
        });
    });
</script>
<?php
//$res = do_action('wp_getHydrameta',get_the_ID(),'hf_property_2_amenities');

?>
<div class="property-detail developer-details">
    	<div class="row as_flats" id="details" >
	    	<?php /* ?>
	        <div class="col-md-4">
	            <?php print hydra_render_group(get_the_ID(), 'overview', 'detail'); ?>
	        </div>
	        <?*/?>
        	<div class="col-md-12 about_cont">
	        	<div class="center section-title as_section_tl"><h2><span>About <?php the_title();?></span></h2></div>
	            <?php $content = get_the_content(); ?>
	            <?php if (!empty($content)) : ?>
	                <?php the_content(); ?>
	            <?php endif; ?>
          	</div>
            <div class="project-spec-details">
				<div class="col-md-12">
					<div class="col-md-2 col-sm-6 col-xs-6 text-center about_box_tl">
						<div class="abtn_icon about_i"></div>
						<h6>ADDRESS</h6>
						<p><?php
							echo getHydrameta(get_the_ID(),'hf_property_address');	//do_action('wp_getHydravalue',get_the_ID(),'address'); ?></p>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-center about_box_tl">
						<div class="abtn_icon configuration_i"></div>
						<h6>CONFIGURATIONS</h6>
						<p><?php echo getHydrameta(get_the_ID(),'hf_property_configurations');	//do_action('wp_getHydravalue',get_the_ID(),'configurations'); ?><?php //the_field('configurations');?></p>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-center about_box_tl">
						<div class="abtn_icon starting_i"></div>
						<h6>STARTING PRICE</h6>
						<p><!--<i class="icon-rupee"></i>--><?php
					     echo getHydrameta(get_the_ID(),'hf_property_starting_price');	//do_action('wp_getHydravalue',get_the_ID(),'starting_price'); ?><?php //the_field('starting_price');?></p>
					</div>
					<div class="col-md-2 col-sm-6  text-center about_box_tl">
						<div class="abtn_icon builtup_square_i"></div>
						<h6>BUILTUP AREA</h6>
						<p><?php echo getHydrameta(get_the_ID(),'hf_property_builtup_area');	//do_action('wp_getHydravalue',get_the_ID(),'builtup_area'); ?><?php //the_field('builtup_area');?></p>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 col-sm-6 text-center about_box_tl">
						<div class="abtn_icon blocks_square_i"></div>
						<h6>BLOCKS</h6>
						<p><?php echo getHydrameta(get_the_ID(),'hf_property_blocks');	//do_action('wp_getHydravalue',get_the_ID(),'blocks'); ?><?php //the_field('blocks');?></p>
					</div>
					<div class="col-md-2 col-sm-6 col-xs-6 text-center about_box_tl">
						<div class="abtn_icon prossesion_square_i"></div>
						<h6>POSSESSION</h6>
						<p itemprop="releaseDate"><?php
						echo getHydrameta(get_the_ID(),'hf_property_possession');	//do_action('wp_getHydravalue',get_the_ID(),'possession');

					/*	print hydra_render_field(get_the_ID(), '3_bedroom_apartment_amenities', 'default'); */

						//do_action('wp_getHydravalue',get_the_ID(),'2_bedroom_apartment_amenities'); ?><?php //the_field('possession');?></p>
					</div>


					<!--<div class="col-md-4 project-specs developer-addr">
						<div class="icon-builtup-area icon-small"></div>
						<div class="item-label"><span>ADDRESS</span></div>
						<div class="item-value"><?php /*the_field('address');*/?></div>
					</div>
					<div class="col-md-4 project-specs developer-config">
						<div class="icon-home icon-small"></div>
						<div class="item-label"><span>CONFIGURATIONS</span></div>
						<div class="item-value"><?php /*the_field('configurations');*/?></div>
					</div>
					<div class="col-md-4 project-specs developer-st-price" >
						<div class="icon-price-tag icon-small"></div>
						<div class="item-label"><span>STARTING PRICE</span></div>
						<div class="item-value"><div class="in-place-currency-dropdown" data-value="11720058"><i class="icon-rupee"></i> <?php /*the_field('starting_price');*/?></div></div>
					</div>

					<div class="col-md-4 project-specs developer-builtup">
						<div class="icon-builtup-area icon-small"></div>
						<div class="item-label"><span>BUILTUP AREA</span></div>
						<div class="item-value"><?php /*the_field('builtup_area');*/?></div>
					</div>
					<div class="col-md-4 project-specs developer-blocks">
					<div class="icon-building icon-small"></div>
						<div class="item-label"><span>BLOCKS</span></div>
						<div class="item-value"><?php /*the_field('blocks');*/?></div>
					</div>
					<div class="col-md-4 project-specs developer-poss">
						<div class="icon-key icon-small"></div>
						<div class="item-label"><span>POSSESSION</span></div>
						<div class="item-value" itemprop="releaseDate"><?php /*the_field('possession');*/?></div>
					</div>-->
				</div>


				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
    	</div>
	<div class="clearfix"></div>
    	<div class="row as_flats about_cont" id="flats">
    		<div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>Configuration Available <?php the_title();?></span></h2></div>
	        </div>
			<?php
			   // $bedroom_amenities = get_field('2_bedroom_apartment_ame');

				$termhydata = getHydrametaTerm(get_the_ID(),'hf_property_2_amenities');
				if(empty($termhydata))
				{
					$termdata = array('1','2');
				}
				else
				{
					$termdata = $termhydata;
				}

				if (in_array("Leving room", $termdata)) { $living = ''; $living_fade='';} else { $living = 'fade-text'; $living_fade = 'fade';}
			    if (in_array('Servant room', $termdata)) { $servant = '';$servant_fade='';} else { $servant = 'fade-text' ; $servant_fade = 'fade';}
				if (in_array('Kitchen', $termdata)) { $kitchen = '';$kitchen_fade='';} else { $kitchen = 'fade-text' ; $kitchen_fade = 'fade';}
				if (in_array('Balconies', $termdata)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('Balconies', $termdata)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('Bathrooms', $termdata)) { $bathrooms = '';$bathrooms_fade='';} else { $bathrooms = 'fade-text' ; $bathrooms_fade = 'fade';}
				if (in_array('Pooja Room', $termdata)) { $pooja_room = '';$pooja_room_fade='';} else { $pooja_room = 'fade-text' ; $pooja_room_fade = 'fade';}
				if (in_array('Study Room', $termdata)) { $study = '';$study_fade='';} else { $study = 'fade-text' ;$study_fade = 'fade';}
				if (in_array('Ac', $termdata)){ $ac = '';$ac_fade='';} else { $ac = 'fade-text' ;$ac_fade = 'fade';}
				if (in_array('Intercom', $termdata)){ $intercom = '';$intercom_fade='';} else { $intercom = 'fade-text' ;$intercom_fade = 'fade';}
				if (in_array('Video Door Phone', $termdata)){ $video_door = '';$video_door_fade='';} else { $video_door = 'fade-text' ;$video_door_fade = 'fade';}
				if (in_array('Washing Area', $termdata)){ $washing = '';$washing_fade='';} else { $washing = 'fade-text' ;$washing_fade = 'fade';}
				if (in_array('Gas Line', $termdata)){ $gas_line = '';$gas_line_fade='';} else { $gas_line = 'fade-text';$gas_line_fade = 'fade';}
				if (in_array('Power Backup', $termdata)){ $power_backup = '';$power_backup_fade='';} else { $power_backup = 'fade-text';$power_backup_fade = 'fade';}
				if (in_array('Wooden Floor', $termdata)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}



			/*	if (in_array("levingroom", $bedroom_amenities)) { $living = ''; $living_fade='';} else { $living = 'fade-text'; $living_fade = 'fade';}
			    if (in_array('servantroom', $bedroom_amenities)) { $servant = '';$servant_fade='';} else { $servant = 'fade-text' ; $servant_fade = 'fade';}
				if (in_array('kitchen', $bedroom_amenities)) { $kitchen = '';$kitchen_fade='';} else { $kitchen = 'fade-text' ; $kitchen_fade = 'fade';}
				if (in_array('balconies', $bedroom_amenities)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('bathrooms', $bedroom_amenities)) { $bathrooms = '';$bathrooms_fade='';} else { $bathrooms = 'fade-text' ; $bathrooms_fade = 'fade';}
				if (in_array('poojaroom', $bedroom_amenities)) { $pooja_room = '';$pooja_room_fade='';} else { $pooja_room = 'fade-text' ; $pooja_room_fade = 'fade';}
				if (in_array('studyroom', $bedroom_amenities)) { $study = '';$study_fade='';} else { $study = 'fade-text' ;$study_fade = 'fade';}
				if (in_array('ac', $bedroom_amenities)){ $ac = '';$ac_fade='';} else { $ac = 'fade-text' ;$ac_fade = 'fade';}
				if (in_array('intercom', $bedroom_amenities)){ $intercom = '';$intercom_fade='';} else { $intercom = 'fade-text' ;$intercom_fade = 'fade';}
				if (in_array('videodoorphone', $bedroom_amenities)){ $video_door = '';$video_door_fade='';} else { $video_door = 'fade-text' ;$video_door_fade = 'fade';}
				if (in_array('washingarea', $bedroom_amenities)){ $washing = '';$washing_fade='';} else { $washing = 'fade-text' ;$washing_fade = 'fade';}
				if (in_array('gasline', $bedroom_amenities)){ $gas_line = '';$gas_line_fade='';} else { $gas_line = 'fade-text';$gas_line_fade = 'fade';}
				if (in_array('powerbackup', $bedroom_amenities)){ $power_backup = '';$power_backup_fade='';} else { $power_backup = 'fade-text';$power_backup_fade = 'fade';}
				if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}
				*/


		    ?>

	        <div class="col-md-12 text-left mr_50">
				<h3>2 BedRoom Apartment</h3>
				<p class="cate_cont room-bto"> <?php the_title(); ?>  is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> <?php
				$num = getHydrameta(get_the_ID(),'hf_property_2bedroomprice');
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
				echo $fraction." ".$ext; ?></div>
					<div class="clearfix"></div>
				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5">
						<?php //$sfa = get_field('2_bed_flat_slider_alias');
						$sfa = getHydrameta(get_the_ID(),'hf_property_2_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' ); ?>
					</div>
					<div class="config-content col-md-7 config-content_img">
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $living_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/leving-room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $living;?>" style="text-align: center;">Leaving room</p>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $servant_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/servant_room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $servant;?>" style="text-align: center;">Servant room</p>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $kitchen_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/kitchen.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $kitchen;?>" style="text-align: center;">Kitchen</p>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $balconies_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/balconies.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $balconies;?>" style="text-align: center;">Balconies</p>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $bathrooms_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/bathrooms.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $bathrooms;?>" style="text-align: center;">Bathrooms</p>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $pooja_room_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/pooja_room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $pooja_room;?>" style="text-align: center;">Pooja room</p>
								<div class="clearfix"></div>
							</div>
							<div class="clearfix"></div>



							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $study_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/study_room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $study;?>" style="text-align: center;">Study room</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $ac_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/ac.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $ac;?>" style="text-align: center;">AC</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $intercom_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/intercom.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $intercom;?>" style="text-align: center;">Intercom</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $video_door_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/video_door_phone.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $video_door;?>" style="text-align: center;">Video Door Phone</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $washing_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/washing_area.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $washing;?>" style="text-align: center;">Washing Area</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $gas_line_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/gas_line.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $gas_line;?>" style="text-align: center;">Gas Line</p>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $power_backup_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/power_backup.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $power_backup;?>" style="text-align: center;">Power Backup</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $wooden_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev1/wooden_floor.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $wooden;?>" style="text-align: center;">Wooden Floor</p>
							</div>



						</div>
<!--							<!--<div class="grid10">-->
<!--								<div class="--><?php ///*echo $living_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/LIVING-ROOM.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $living;*/?><!--" style="text-align: center;">Leving room</p>-->
<!--							</div>-->

<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $servant_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/SERVANT-ROOM.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $servant;*/?><!--">Servant room</p>-->
<!--							</div>-->

<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $kitchen_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/Kitchen.png" alt=" " width="100%" />-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $kitchen;*/?><!--">Kitchen</p>-->
<!--							</div>-->

<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $balconies_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/BALCONY.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $balconies;*/?><!--">Balconies</p>-->
<!--							</div>-->

<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $bathrooms_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/Bathrooms.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $bathrooms;*/?><!--">Bathrooms</p>-->
<!--							</div>-->

<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $pooja_room_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/POOJA-ROOM.png" alt=" " width="100%" />-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $pooja_room;*/?><!--">Pooja room</p>-->
<!--							</div>-->

<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $study_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/STUDY-ROOM.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $study;*/?><!--">Study room</p>-->
<!--							</div>-->
<!--							<div class="clear"></div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $ac_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/ac.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $ac;*/?><!--">AC</p>-->
<!--							</div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $intercom_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/Intercom.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $intercom;*/?><!--">Intercom</p>-->
<!--							</div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $video_door_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/VEDIO-DOOR-PHONE.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $video_door;*/?><!--">Video Door Phone</p>-->
<!--							</div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $washing_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/WASHING-AREA.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $washing;*/?><!--">Washing Area</p>-->
<!--							</div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $gas_line_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/GAS-LINE.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $gas_line;*/?><!--">Gas Line</p>-->
<!--							</div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $power_backup_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/POWER-BACKUP.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $power_backup;*/?><!--">Power Backup</p>-->
<!--							</div>-->
<!--							<div class="grid10">-->
<!--								<div class="--><?php ///*echo $wooden_fade;*/?><!--">-->
<!--									<img class="aligncenter" src="--><?php ///*bloginfo('template_directory')*/?><!--/images/WOODEN-FLOOR.png" alt=" " width="100%">-->
<!--								</div>-->
<!--								<p class="center --><?php ///*echo $wooden;*/?><!--">Wooden Floor</p>-->
<!--							</div>-->

						<!--<div class="col-md-2">
                            <h3 style="border-bottom: 1px solid #CCC;"><span class="alignnone ut-custom-icon"><i class="fa fa-inr fa-1x"></i></span> 2.98 Crs</h3>
                            <p>&nbsp;</p>
                            <p>Text Comes here</p>
                            <h5>2 Bedroom Apartment</h5>
                        </div>-->
					</div>
				</div>
			</div>
			<!-- -- 3 Bedroom Apartment -- -->
			<?php

			   // $bedroom_amenities = get_field('3_bedroom_apartment_ame');
			   $termhydata = getHydrametaTerm(get_the_ID(),'hf_property_3_bedroom_apartment_amenities');
				if(empty($termhydata))
				{
					$termdata = array('1','2');
				}
				else
				{
					$termdata = $termhydata;
				}
				if (in_array("Leving room", $termdata)) { $living = ''; $living_fade='';} else { $living = 'fade-text'; $living_fade = 'fade';}
			    if (in_array('Servant room', $termdata)) { $servant = '';$servant_fade='';} else { $servant = 'fade-text' ; $servant_fade = 'fade';}
				if (in_array('Kitchen', $termdata)) { $kitchen = '';$kitchen_fade='';} else { $kitchen = 'fade-text' ; $kitchen_fade = 'fade';}
				if (in_array('Balconies', $termdata)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('Balconies', $termdata)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('Bathrooms', $termdata)) { $bathrooms = '';$bathrooms_fade='';} else { $bathrooms = 'fade-text' ; $bathrooms_fade = 'fade';}
				if (in_array('Pooja Room', $termdata)) { $pooja_room = '';$pooja_room_fade='';} else { $pooja_room = 'fade-text' ; $pooja_room_fade = 'fade';}
				if (in_array('Study Room', $termdata)) { $study = '';$study_fade='';} else { $study = 'fade-text' ;$study_fade = 'fade';}
				if (in_array('Ac', $termdata)){ $ac = '';$ac_fade='';} else { $ac = 'fade-text' ;$ac_fade = 'fade';}
				if (in_array('Intercom', $termdata)){ $intercom = '';$intercom_fade='';} else { $intercom = 'fade-text' ;$intercom_fade = 'fade';}
				if (in_array('Video Door Phone', $termdata)){ $video_door = '';$video_door_fade='';} else { $video_door = 'fade-text' ;$video_door_fade = 'fade';}
				if (in_array('Washing Area', $termdata)){ $washing = '';$washing_fade='';} else { $washing = 'fade-text' ;$washing_fade = 'fade';}
				if (in_array('Gas Line', $termdata)){ $gas_line = '';$gas_line_fade='';} else { $gas_line = 'fade-text';$gas_line_fade = 'fade';}
				if (in_array('Power Backup', $termdata)){ $power_backup = '';$power_backup_fade='';} else { $power_backup = 'fade-text';$power_backup_fade = 'fade';}
				if (in_array('Wooden Floor', $termdata)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}

				/*if (in_array("levingroom", $bedroom_amenities)) { $living = ''; $living_fade='';} else { $living = 'fade-text'; $living_fade = 'fade';}
			    if (in_array('servantroom', $bedroom_amenities)) { $servant = '';$servant_fade='';} else { $servant = 'fade-text' ; $servant_fade = 'fade';}
				if (in_array('kitchen', $bedroom_amenities)) { $kitchen = '';$kitchen_fade='';} else { $kitchen = 'fade-text' ; $kitchen_fade = 'fade';}
				if (in_array('balconies', $bedroom_amenities)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('bathrooms', $bedroom_amenities)) { $bathrooms = '';$bathrooms_fade='';} else { $bathrooms = 'fade-text' ; $bathrooms_fade = 'fade';}
				if (in_array('poojaroom', $bedroom_amenities)) { $pooja_room = '';$pooja_room_fade='';} else { $pooja_room = 'fade-text' ; $pooja_room_fade = 'fade';}
				if (in_array('studyroom', $bedroom_amenities)) { $study = '';$study_fade='';} else { $study = 'fade-text' ;$study_fade = 'fade';}
				if (in_array('ac', $bedroom_amenities)){ $ac = '';$ac_fade='';} else { $ac = 'fade-text' ;$ac_fade = 'fade';}
				if (in_array('intercom', $bedroom_amenities)){ $intercom = '';$intercom_fade='';} else { $intercom = 'fade-text' ;$intercom_fade = 'fade';}
				if (in_array('videodoorphone', $bedroom_amenities)){ $video_door = '';$video_door_fade='';} else { $video_door = 'fade-text' ;$video_door_fade = 'fade';}
				if (in_array('washingarea', $bedroom_amenities)){ $washing = '';$washing_fade='';} else { $washing = 'fade-text' ;$washing_fade = 'fade';}
				if (in_array('gasline', $bedroom_amenities)){ $gas_line = '';$gas_line_fade='';} else { $gas_line = 'fade-text';$gas_line_fade = 'fade';}
				if (in_array('powerbackup', $bedroom_amenities)){ $power_backup = '';$power_backup_fade='';} else { $power_backup = 'fade-text';$power_backup_fade = 'fade';}
				if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}*/
		    ?>

	        <div class="col-md-12 text-left mr_50">
				<h3>3 BedRoom Apartment</h3>
				<p class="room-bto1"> <?php the_title(); ?> is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> <?php
				$num = getHydrameta(get_the_ID(),'hf_property_3bedroomprice');
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
				echo $fraction." ".$ext; ?></div>
				<div class="clearfix"></div>

				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5 as-pull-right">
						<?php //$sfa = get_field('3_bed_flat_slider_alias');
						$sfa = getHydrameta(get_the_ID(),'hf_property_3_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7 config-content_img" >
						<div class="row">
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $living_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/leving-room.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $living;?>" style="text-align: center;">Leving room</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $servant_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/servant_room.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $servant;?>">Servant room</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $kitchen_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/kitchen.png" alt=" " width="100%" />
								</div>
								<p class="center <?php echo $kitchen;?>">Kitchen</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $balconies_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/balconies.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $balconies;?>">Balconies</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $bathrooms_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/bathrooms.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $bathrooms;?>">Bathrooms</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $pooja_room_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/pooja_room.png" alt=" " width="100%" />
								</div>
								<p class="center <?php echo $pooja_room;?>">Pooja room</p>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $study_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/study_room.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $study;?>">Study room</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $ac_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/ac.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $ac;?>">AC</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $intercom_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/intercom.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $intercom;?>">Intercom</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $video_door_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/video_door_phone.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $video_door;?>">Video Door Phone</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $washing_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/washing_area.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $washing;?>">Washing Area</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $gas_line_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/gas_line.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $gas_line;?>">Gas Line</p>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $power_backup_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/power_backup.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $power_backup;?>">Power Backup</p>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-6 text-center">
								<div class="<?php echo $wooden_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/wooden_floor.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $wooden;?>">Wooden Floor</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			   /* $bedroom_amenities = get_field('4_bedroom_apartment_ame');

			    if (in_array("levingroom", $bedroom_amenities)) { $living = ''; $living_fade='';} else { $living = 'fade-text'; $living_fade = 'fade';}
			    if (in_array('servantroom', $bedroom_amenities)) { $servant = '';$servant_fade='';} else { $servant = 'fade-text' ; $servant_fade = 'fade';}
				if (in_array('kitchen', $bedroom_amenities)) { $kitchen = '';$kitchen_fade='';} else { $kitchen = 'fade-text' ; $kitchen_fade = 'fade';}
				if (in_array('balconies', $bedroom_amenities)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('bathrooms', $bedroom_amenities)) { $bathrooms = '';$bathrooms_fade='';} else { $bathrooms = 'fade-text' ; $bathrooms_fade = 'fade';}
				if (in_array('poojaroom', $bedroom_amenities)) { $pooja_room = '';$pooja_room_fade='';} else { $pooja_room = 'fade-text' ; $pooja_room_fade = 'fade';}
				if (in_array('studyroom', $bedroom_amenities)) { $study = '';$study_fade='';} else { $study = 'fade-text' ;$study_fade = 'fade';}
				if (in_array('ac', $bedroom_amenities)){ $ac = '';$ac_fade='';} else { $ac = 'fade-text' ;$ac_fade = 'fade';}
				if (in_array('intercom', $bedroom_amenities)){ $intercom = '';$intercom_fade='';} else { $intercom = 'fade-text' ;$intercom_fade = 'fade';}
				if (in_array('videodoorphone', $bedroom_amenities)){ $video_door = '';$video_door_fade='';} else { $video_door = 'fade-text' ;$video_door_fade = 'fade';}
				if (in_array('washingarea', $bedroom_amenities)){ $washing = '';$washing_fade='';} else { $washing = 'fade-text' ;$washing_fade = 'fade';}
				if (in_array('gasline', $bedroom_amenities)){ $gas_line = '';$gas_line_fade='';} else { $gas_line = 'fade-text';$gas_line_fade = 'fade';}
				if (in_array('powerbackup', $bedroom_amenities)){ $power_backup = '';$power_backup_fade='';} else { $power_backup = 'fade-text';$power_backup_fade = 'fade';}
				if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}*/

				$termhydata = getHydrametaTerm(get_the_ID(),'hf_property_4_bedroom_apartment_amenities');
				if(empty($termhydata))
				{
					$termdata = array('1','2');
				}
				else
				{
					$termdata = $termhydata;
				}
				if (in_array("Leving room", $termdata)) { $living = ''; $living_fade='';} else { $living = 'fade-text'; $living_fade = 'fade';}
			    if (in_array('Servant room', $termdata)) { $servant = '';$servant_fade='';} else { $servant = 'fade-text' ; $servant_fade = 'fade';}
				if (in_array('Kitchen', $termdata)) { $kitchen = '';$kitchen_fade='';} else { $kitchen = 'fade-text' ; $kitchen_fade = 'fade';}
				if (in_array('Balconies', $termdata)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('Balconies', $termdata)){ $balconies = '';$balconies_fade='';} else { $balconies = 'fade-text' ;$balconies_fade = 'fade';}
				if (in_array('Bathrooms', $termdata)) { $bathrooms = '';$bathrooms_fade='';} else { $bathrooms = 'fade-text' ; $bathrooms_fade = 'fade';}
				if (in_array('Pooja Room', $termdata)) { $pooja_room = '';$pooja_room_fade='';} else { $pooja_room = 'fade-text' ; $pooja_room_fade = 'fade';}
				if (in_array('Study Room', $termdata)) { $study = '';$study_fade='';} else { $study = 'fade-text' ;$study_fade = 'fade';}
				if (in_array('Ac', $termdata)){ $ac = '';$ac_fade='';} else { $ac = 'fade-text' ;$ac_fade = 'fade';}
				if (in_array('Intercom', $termdata)){ $intercom = '';$intercom_fade='';} else { $intercom = 'fade-text' ;$intercom_fade = 'fade';}
				if (in_array('Video Door Phone', $termdata)){ $video_door = '';$video_door_fade='';} else { $video_door = 'fade-text' ;$video_door_fade = 'fade';}
				if (in_array('Washing Area', $termdata)){ $washing = '';$washing_fade='';} else { $washing = 'fade-text' ;$washing_fade = 'fade';}
				if (in_array('Gas Line', $termdata)){ $gas_line = '';$gas_line_fade='';} else { $gas_line = 'fade-text';$gas_line_fade = 'fade';}
				if (in_array('Power Backup', $termdata)){ $power_backup = '';$power_backup_fade='';} else { $power_backup = 'fade-text';$power_backup_fade = 'fade';}
				if (in_array('Wooden Floor', $termdata)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}
		    ?>

	        <div class="col-md-12 text-left mr_50">
				<h3>4 BedRoom Apartment</h3>
				<p class="cate_cont room-bto2"> <?php the_title(); ?> is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i><?php
				$num = getHydrameta(get_the_ID(),'hf_property_4bedroomprice');
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
				echo $fraction." ".$ext; ?></div>
				<div class="clearfix"></div>

				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5">
						<?php //$sfa = get_field('4_bed_flat_slider_alias');
						$sfa = getHydrameta(get_the_ID(),'hf_property_4_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7 config-content_img" >
						<div class="row">
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $living_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/leving-room.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $living;?>" style="text-align: center;">Leving room</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $servant_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/servant_room.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $servant;?>">Servant room</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $kitchen_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/kitchen.png" alt=" " width="100%" />
									</div>
									<p class="center <?php echo $kitchen;?>">Kitchen</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $balconies_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/balconies.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $balconies;?>">Balconies</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $bathrooms_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/bathrooms.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $bathrooms;?>">Bathrooms</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $pooja_room_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/pooja_room.png" alt=" " width="100%" />
									</div>
									<p class="center <?php echo $pooja_room;?>">Pooja room</p>
								</div>
								<div class="clearfix"></div>

								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $study_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/study_room.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $study;?>">Study room</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $ac_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/ac.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $ac;?>">AC</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $intercom_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/intercom.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $intercom;?>">Intercom</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $video_door_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/video_door_phone.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $video_door;?>">Video Door Phone</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $washing_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/washing_area.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $washing;?>">Washing Area</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $gas_line_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/gas_line.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $gas_line;?>">Gas Line</p>
								</div>
								<div class="clearfix"></div>

								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $power_backup_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/power_backup.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $power_backup;?>">Power Backup</p>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-6 text-center">
									<div class="<?php echo $wooden_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev1/wooden_floor.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $wooden;?>">Wooden Floor</p>
								</div>
						</div>
					</div>
				</div>

			</div>
    	</div>
    <!--<hr/>-->
    <?php $amenities = hydra_render_field(get_the_ID(), 'amenities', 'detail');  ?>
    <?php

	//echo "<pre>";
	//print_r($amenities);


    if ($amenities):



		//$value=preg_match_all('/<li><i class=\"fa fa-check ok\"></i>(.*?)<\/li>/s',$amenities,$estimates);

		//echo "<pre>";
		//print_r($estimates);

	    $val_am = trim(strip_tags($amenities));

		//echo "<pre>";
		//print_r($val_am);

	    $diffentiated_amenities = explode(",",$val_am);
	    $trimmed_array=array_map('trim',$diffentiated_amenities);



	    if (in_array("Lift", $trimmed_array)) { $lift = '';} else { $lift = 'fade-text'; $life_fade = 'fade';}
	    if (in_array('Security', $trimmed_array)) { $security = '';} else { $security = 'fade-text' ; $sec_fade = 'fade';}
		if (in_array('Internet', $trimmed_array)) { $internet = '';} else { $internet = 'fade-text' ; $internet_fade = 'fade';}
		if (in_array('Kids Zone', $trimmed_array)){ $kids_area = '';} else { $kids_area = 'fade-text' ;$kids_fade = 'fade';}
		if (in_array('Swimming Pool', $trimmed_array)) { $swimming_pool = '';} else { $swimming_pool = 'fade-text' ; $swim_fade = 'fade';}
		if (in_array('Gymnasium', $trimmed_array)) { $gymnasium = '';} else { $gymnasium = 'fade-text' ; $gym_fade = 'fade';}
		if (in_array('Garden', $trimmed_array)) { $garden = '';} else { $garden = 'fade-text' ;$garen_fade = 'fade';}
		if (in_array('Library', $trimmed_array)){ $llibrary = '';} else { $llibrary = 'fade-text' ;$lib_fade = 'fade';}
		if (in_array('Community Hall', $trimmed_array)){ $community = '';} else { $community = 'fade-text' ;$com_fade = 'fade';}
		if (in_array('Internal Roads', $trimmed_array)){ $internal_roads = '';} else { $internal_roads = 'fade-text' ;$internal_fade = 'fade';}
		if (in_array('Jogging Track', $trimmed_array)){ $jogging = '';} else { $jogging = 'fade-text' ;$jog_fade = 'fade';}
		if (in_array('No Power Backup', $trimmed_array)){ $no_power_backup = '';} else { $no_power_backup = 'fade-text';$power_fade = 'fade';}
		if (in_array('Club House', $trimmed_array)){ $club_house = '';} else { $club_house = 'fade-text';$club_fade = 'fade';}
		if (in_array('Indoor Games', $trimmed_array)){ $indoor_games = '';} else { $indoor_games = 'fade-text';$indoor_fade = 'fade';}
    ?>
        <div class="row none_row as_amenities" id="amenities" >
        	<div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>Amenities in <?php the_title();
							?></span></h2></div>
          	</div>

			<div id="hidden_ammineties" style="display:none;">
				<?php echo $amenities; ?>
			</div>

          	<div class="col-md-12" >
	          	<ul class="amenities-options">
				<!--	<li class="single-amenity">
						<div class="<?php echo $life_fade;?>"><img src="<?php bloginfo('template_directory')?>/images/LIFT.png" ></div>
						<div class="<?php echo $lift; ?> text amenities_cn">Lift</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $sec_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/SECURITY.png" ></div>
						<div class="<?php echo $security; ?> text amenities_cn">Security</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $internet_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/INTERNET.png" ></div>
						<div class="<?php echo $internet; ?> text amenities_cn">Internet</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $kids_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/KIDS-ZONE.png" ></div>
						<div class="<?php echo $kids_area; ?> text amenities_cn">Kids Zone</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $swim_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/SWIMMING-POOL.png" ></div>
						<div class="<?php echo $swimming_pool; ?> text amenities_cn">Swimming Pool</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $gym_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/GYM.png" ></div>
						<div class="<?php echo $gymnasium; ?> text amenities_cn">Gymnasium</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $garen_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/GARDEN.png" ></div>
						<div class="<?php echo $garden; ?> text amenities_cn">Garden</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $lib_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/LIBRARY.png" ></div>
						<div class="<?php echo $llibrary; ?> text amenities_cn">Library</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $com_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/COMMUNITY-HALL.png" ></div>
						<div class="<?php echo $community; ?> text amenities_cn">Community Hall</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $internal_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/INTERNAL-ROADS.png" ></div>
						<div class="<?php echo $internal_roads; ?> text amenities_cn">Internal Roads</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $jog_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/JOGGING-TRACK.png" ></div>
						<div class="<?php echo $jogging; ?> text amenities_cn">Jogging Track</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $power_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/NO-POWER-BACKUP.png" ></div>
						<div class="<?php echo $no_power_backup; ?> text amenities_cn">No Power Backup</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $club_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/CLUB-HOUSE.png" ></div>
						<div class="<?php echo $club_house; ?> text amenities_cn">Club House</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $indoor_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/INDOOR-GAMES.png" ></div>
						<div class="<?php echo $indoor_games; ?> text amenities_cn">Indoor Games</div>
					</li>

					-->

				</ul>
			</div>
			<div style="clear:both"></div>
			<?php /*?>
			<div class="col-md-12">
				<div class="center section-title"><h2 class="header-text"><span>Interiros of <?php the_title()?></span></h2></div>
				<div class="building-info-card" id="4507" style="display:block;">
					<div class="building-card floors-card co col-md-4">
						<div class="icon-floors icon-small"></div>
						<div class="header-text">FLOORS</div>
						<div class="separator"></div>
						<div class="pills"><div class="header">BALCONY</div><div class="texts"><?php the_field('balcony'); ?></div></div>
						<div class="pills"><div class="header">KITCHEN</div><div class="texts"><?php the_field('kitchen'); ?></div></div>
						<div class="pills"><div class="header">LIVING/DINING</div><div class="texts"><?php the_field('living/dining'); ?></div></div>
						<div class="pills"><div class="header">MASTER BEDROOM</div><div class="texts"><?php the_field('master_bedroom'); ?></div></div>
						<div class="pills"><div class="header">OTHER BEDROOM</div><div class="texts"><?php the_field('other_bedroom'); ?></div></div>
						<div class="pills"><div class="header">TOILETS</div><div class="texts"><?php the_field('toilets'); ?></div></div>
					</div>
					<div class="building-card fittings-card col-md-4">
						<div class="icon-fittings icon-small"></div>
						<div class="header-text">FITTINGS</div>
						<div class="separator"></div>
						<div class="pills"><div class="header">DOORS</div><div class="texts"><?php the_field('doors'); ?></div></div>
						<div class="pills"><div class="header">ELECTRICAL</div><div class="texts"><?php the_field('electrical'); ?></div></div>
						<div class="pills"><div class="header">KITCHEN</div><div class="texts"><?php the_field('fitting_kitchen'); ?></div></div>
						<div class="pills"><div class="header">WINDOWS</div><div class="texts"><?php the_field('windows'); ?></div></div>
						<div class="pills"><div class="header">TOILETS</div><div class="texts"><?php the_field('fitting_toilets'); ?></div></div>
						<div class="pills"><div class="header">OTHERS</div><div class="texts"><?php the_field('others'); ?></div></div>
					</div>
					<div class="building-card walls-card col-md-4">
						<div class="icon-small icon-wall"></div>
						<div class="header-text">WALLS</div>
						<div class="separator"></div>
						<div class="pills"><div class="header">EXTERIOR</div><div class="texts"><?php the_field('exterior'); ?></div></div>
						<div class="pills"><div class="header">INTERIOR</div><div class="texts"><?php the_field('interior'); ?></div></div>
						<div class="pills"><div class="header">KITCHEN</div><div class="texts"><?php the_field('kitchen_walls'); ?></div></div>
						<div class="pills"><div class="header">TOILETS</div><div class="texts"><?php the_field('toilets_walls'); ?></div></div>
					</div>
				</div>
			</div>
			*/?>
			<div class="col-md-12 row-wise-amenities as_row-wise-amenities">
				<ul class="properties-filter left-filter">
			       <li class="selected">
			       		<a href="#" data-filter=".floors" class="first-click-this">
			       			<div><span class="dev-floors"></span><!-- <img src="<?php bloginfo('template_directory')?>/images/FLOOR.png" > --></div>
							<div class="header-text">FLOORS</div>
							<div class="separator"></div>
							<div class="clearfix"></div>
						</a>
					</li>
			       <li>
			       		<a href="#" data-filter=".fittings">
			       			<div><span class="dev-fittings"></span><!-- <img src="<?php bloginfo('template_directory')?>/images/FITTINGS.png" > --></div>
							<div class="header-text">FITTINGS</div>
							<div class="separator"></div>
						</a>
					</li>
			       <li>
			       		<a href="#" data-filter=".walls">
			       			<div><span class="dev-walls"></span><!-- <img src="<?php bloginfo('template_directory')?>/images/WALLS.png" > --></div>
							<div class="header-text">WALLS</div>
							<div class="separator"></div>
						</a>
					</li>
		     	</ul>


		    	<div class="properties-items inn_properties-items isotope">
		    		<div class="items-list row">
			    		<div class="building-card floors-card co  floors property-item isotope-item  col-md-12">
							<div class="pills col-md-4"><div class="header">BALCONY</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_balcony'); //the_field('balcony'); ?></div></div>
							<div class="pills col-md-4"><div class="header">KITCHEN</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_kitchen'); //the_field('kitchen'); ?></div></div>
							<div class="pills col-md-4"><div class="header">LIVING/DINING</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_livingdining'); //the_field('living/dining'); ?></div></div>
							<div class="clearfix"></div>
							<div class="pills col-md-4"><div class="header">MASTER BEDROOM</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_master_bedroom');//the_field('master_bedroom'); ?></div></div>
							<div class="pills col-md-4"><div class="header">OTHER BEDROOM</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_other_bedroom'); //the_field('other_bedroom'); ?></div></div>
							<div class="pills col-md-4"><div class="header">TOILETS</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_toilets');  //the_field('toilets'); ?></div></div>
						</div>
						<div class="building-card fittings-card  fittings property-item isotope-item col-md-12">

							<div class="pills col-md-4"><div class="header">DOORS</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_doors'); //the_field('doors'); ?></div></div>
							<div class="pills col-md-4"><div class="header">ELECTRICAL</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_electrical');// the_field('electrical'); ?></div></div>
							<div class="pills col-md-4"><div class="header">KITCHEN</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_kitchen'); //the_field('fitting_kitchen'); ?></div></div>
							<div class="clearfix"></div>
							<div class="pills col-md-4"><div class="header">WINDOWS</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_windows'); //the_field('windows'); ?></div></div>
							<div class="pills col-md-4"><div class="header">TOILETS</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_toiletsf'); //the_field('fitting_toilets'); ?></div></div>
							<div class="pills col-md-4"><div class="header">OTHERS</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_others');  // the_field('others'); ?></div></div>
						</div>
						<div class="building-card walls-card  walls property-item isotope-item col-md-12">
							<div class="pills col-md-4"><div class="header">EXTERIOR</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_nexterior'); // the_field('exterior'); ?></div></div>
							<div class="pills col-md-4"><div class="header">INTERIOR</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_ninterior'); //the_field('interior'); ?></div></div>
							<div class="pills col-md-4"><div class="header">KITCHEN</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_nkitchen');  //the_field('kitchen_walls'); ?></div></div>
							<div class="clearfix"></div>
							<div class="pills col-md-4"><div class="header">TOILETS</div><div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_ntoilets');   //the_field('toilets_walls'); ?></div></div>
						</div>
		    		</div>

		    	</div>
		    </div>

			<?php /*?>
            <div class="property-detail-amenities">
                <?php //print $amenities; ?>
            </div>
            <?*/?>


        </div>
         <hr/>


    <?php print hydra_render_field(get_the_ID(), 'related', 'detail'); ?>
    <?php $presentation = hydra_render_group(get_the_ID(), 'presentation', 'detail'); ?>

    <?php if ($presentation): ?>
        <div class="row">
            <div class="col-md-12"><h2><?php echo __('Presentation', 'aviators'); ?></h2></div>
            <?php print $presentation; ?>
        </div>
        <hr/>
    <?php endif; ?>




    <?php endif; ?>

    	<div class="row as_map" id="map">
    	 <div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>EXPLORE PROJECT AND NEIGHBOURHOOD <?php the_title();?></span></h2></div>
         </div>


	     <div class="col-md-12 inn_map_cont v1-filter">
		     <ul class="map-tabs-links properties-filter map-filter map_section_data">
			       <li class="selected">
			       		<a href="#"  onclick ="clearResults();removeonlyMarkers();removecenterMarkers();" class="first-click-this">BUILDINGS </a>
			       </li>
			       <li>
			       		<a href="#" onclick ="removecenterMarkers();reallyDoSearch();" >NEARBY</a>
			       </li>
			</ul>
	    	<?php
	    	$mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE);
	    	$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');
	    	$longitude = $mapPosition['items'][0]['longitude'];//get_field('longitude');
	    	echo do_shortcode('[map_neighbourhood location="'.$latitude.','.$longitude.'"]');?>
	    </div>
		<div class="col-md-12 map_bot_border al-burooj-border"><span></span></div>

	</div>

         <hr/>

          <div class="row as_flats" id="three_sixty_data">
	        <div class="col-md-12"  style="margin-top: 20px;">
	        	<div class="center section-title as_section_tl"><h2><span>360* View OF <?php the_title();?></span></h2></div>

	        		<div class="properties-items-three-sixty isotope-three-sixty">
			    		<div class="items-list-three-sixty row">
                                            <div class="three_sixty_data-gallery property-item-three_sixty_data isotope-item-three-sixty  col-md-12">
								<?php
								$three_sixty_data_imageurl = getHydrameta(get_the_ID(),'hf_property_three_sixty_data', 'url');
								$three_sixty_data_imagealt = getHydrameta(get_the_ID(),'hf_property_three_sixty_data', 'alt');
								//$three_sixty_data_image = get_field('three_sixty_data');
						if( !empty($three_sixty_data_imageurl) ): ?>
							<img src="<?php echo $three_sixty_data_imageurl; ?>" alt="<?php echo $three_sixty_data_imagealt; ?>" />
						<?php 	endif; ?>
                                            </div>

                                        </div>
	        		</div>
	        </div>
	        <!-- /.col-md-6 -->
	    </div>
	    <!-- /.row -->

         <hr/>

              <div class="row" id="gallery" >
	        <div class="col-md-12 al_baruj_slider">
	        	<div class="center section-title as_section_tl"><h2><span>Images of <?php the_title();?></span></h2></div>
	        	<ul class="properties-filter gallery-top">
	        		<li class="selected"><a id="gallery1" href="#" >Gallery 1</a></li>
	        		<li><a id="gallery2" href="#" >Gallery 2</a></li>
	        	</ul>
	        		<div class="properties-items-gallery isotope-gallery">
			    		<div class="items-list-gallery row">
				    	<div class="gallery1  col-md-12">
		            			<?php print hydra_render_field(get_the_ID(), 'gallery', 'detail'); ?>
		            		</div>
		            		<div class="gallery2  col-md-12">
		            			<?php print hydra_render_field(get_the_ID(), 'gallery2', 'detail'); ?>
		            		</div>
		            	</div>
	        		</div>
	        </div>
	        <!-- /.col-md-6 -->
	    </div>
	    <!-- /.row -->


	<script src="<?php bloginfo('template_directory'); ?>/js/highcharts.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/exporting.js"></script>
	<?php if(showMap(get_the_ID())) { ?>
	<script type="text/javascript">
		jQuery("document").ready(function () {
		    jQuery('#line_chart_container').highcharts({
		        chart: {
		            type: 'spline'
		        },
		        title: {
		            text: 'Monthly Average Prices'
		        },
		        subtitle: {
		            text: 'Source: PropertyXP.com'
		        },
		        xAxis: {
		            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
		                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		        },
		        yAxis: {
		            title: {
		                text: 'Price (Rs.)'
		            },
		            labels: {
		                formatter: function () {
		                    return this.value ;
		                }
		            }
		        },
		        tooltip: {
		            crosshairs: true,
		            shared: true
		        },
		        plotOptions: {
		            spline: {
		                marker: {
		                    radius: 4,
		                    lineColor: '#666666',
		                    lineWidth: 1
		                }
		            }
		        },
		        series: [{
		            name: 'Satellite',
		            marker: {
		                symbol: 'circle'
		            },
		            data: [<?php if(getHydrameta(get_the_ID(),'hf_property_jan') != null ) echo getHydrameta(get_the_ID(),'hf_property_jan'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_feb') != null ) echo getHydrameta(get_the_ID(),'hf_property_feb'); else echo '6900'; ?>,
		            		<?php if(getHydrameta(get_the_ID(),'hf_property_mar') != null ) echo getHydrameta(get_the_ID(),'hf_property_mar'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_apr') != null ) echo getHydrameta(get_the_ID(),'hf_property_apr'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_may') != null ) echo getHydrameta(get_the_ID(),'hf_property_may'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_june') != null ) echo getHydrameta(get_the_ID(),'hf_property_june'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_july') != null ) echo getHydrameta(get_the_ID(),'hf_property_july'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_aug') != null ) echo getHydrameta(get_the_ID(),'hf_property_aug'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_sep') != null ) echo getHydrameta(get_the_ID(),'hf_property_sep'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_oct') != null ) echo getHydrameta(get_the_ID(),'hf_property_oct'); else echo '6900';?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_nov') != null ) echo getHydrameta(get_the_ID(),'hf_property_nov'); else echo '6900'; ?>,
							<?php if(getHydrameta(get_the_ID(),'hf_property_dec') != null ) echo getHydrameta(get_the_ID(),'hf_property_dec'); else echo '6900'; ?>,]

					/*[	<?php if(get_field('jan') != null ) echo get_field('jan'); else echo '7000';?>,
		            		<?php if(get_field('feb') != null ) echo get_field('feb'); else echo '6900';?>,
		            		<?php if(get_field('mar') != null ) echo get_field('mar'); else echo '9500';?>,
		            		<?php if(get_field('apr') != null ) echo get_field('apr'); else echo '14500';?>,
		            		<?php if(get_field('may') != null ) echo get_field('may'); else echo '10200';?>,
		            		<?php if(get_field('jun') != null ) echo get_field('jun'); else echo '1500';?>,
		            		<?php if(get_field('jul') != null ) echo get_field('jul'); else echo '10000';?>,
		            		<?php if(get_field('aug') != null ) echo get_field('aug'); else echo '14500'; ?>,
						    <?php //{y: 15000,marker: {symbol: 'url(http://www.highcharts.com/demo/gfx/sun.png)'}}, ?>
				            <?php if(get_field('sep') != null ) echo get_field('sep'); else echo '13000';?>,
				            <?php if(get_field('oct') != null ) echo get_field('oct'); else echo '8300';?>,
				            <?php if(get_field('nov') != null ) echo get_field('nov'); else echo '11000';?>,
				            <?php if(get_field('dec') != null ) echo get_field('dec'); else echo '9600';?>,] */

		        }]
		    });
		    jQuery( ".first-click-this" ).trigger( "click" );
		});
	</script>
	<?php } ?>
	<div class="row" id="line_chart" >
		<div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>Insights Into <?php the_title();?></span></h2></div>
	        	<p class="caps_text"><?php echo getHydrameta(get_the_ID(),'hf_property_insights'); ?></p>
         </div>
		<?php if(showMap(get_the_ID())) { ?>
		<div class="col-md-12">
			<div id="line_chart_container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		</div>
		<?php } ?>
	</div>
	<div class="row" id="about-developer">
		<div class="col-md-12">
			<div class="center section-title as_section_tl group-bot"><h2><span>About <?php echo getHydrameta(get_the_ID(),'hf_property_developer_name');//the_field('developer_name'); ?></span></h2></div>
			<div class="row">
				<div class="col-md-4 center">
					<div class="d_group">
						<?php 	//$image = get_field('developer_image');
						$imageurl = getHydrameta(get_the_ID(),'hf_property_developer_image', 'url');
						$imagealt = getHydrameta(get_the_ID(),'hf_property_developer_image', 'alt');
						if( !empty($imageurl) ): ?>
							<img src="<?php echo $imageurl; ?>" alt="<?php echo $imagealt; ?>" style="width:25%; height:auto;" />
						<?php 	endif; ?>
					</div>
				</div>
				<div class="col-md-8">
					<p class="caps_text"><?php echo getHydrameta(get_the_ID(),'hf_property_developer_description'); //the_field('developer_description'); ?></p>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4 center"><h5>YEAR OF ESTABLISHMENT</h5><p><?php echo getHydrameta(get_the_ID(),'hf_property_year_establishment');//the_field('year_of_establishment')?></p></div>
				<div class="col-md-4 center"><h5>TOTAL PROJECTS</h5><p><?php echo getHydrameta(get_the_ID(),'hf_property_total_projects');//the_field('total_projects')?></p></div>
				<div class="col-md-4 center"><h5>ASSOCIATE MEMBERSHIPS</h5><p><?php echo getHydrameta(get_the_ID(),'hf_property_associate_memberships'); //the_field('associate_memberships')?></p></div>
			</div>
		</div>
	</div>

	<div class="row" id="contact-developer">
		<div class="col-md-12 popup-this-contact-form">
			<div class="center section-title as_section_tl group-bot"><h2><span>Contact <?php echo getHydrameta(get_the_ID(),'hf_property_developer_name');//the_field('developer_name'); ?></span></h2></div>
			<div class="row">
				<div class="col-md-4 center">
					<?php /*	$image = get_field('developer_image');
					if( !empty($image) ): */?><!--
					<img src="<?php /*echo $image['url']; */?>" alt="<?php /*echo $image['alt']; */?>" />
				--><?php /*	endif; */?>



					<div class="contact_inn"><h4>
					<?php //	$image = get_field('developer_image');
					if( !empty($imageurl) ): ?>
						<img src="<?php echo $imageurl; ?>" alt="<?php echo $imagealt; ?>" />
					<?php 	endif; ?>
					<?php echo getHydrameta(get_the_ID(),'hf_property_developer_contact_no'); //the_field('developer_contact_no.')?></h4></div>
					<!--<p>Sold exclusively by Hiranandani without the intervention of any third party.</p>-->
				</div>
				<div class="col-md-8 right_cont form_parent">
					<!--<p></p>-->
					<?php //$contact_value = get_field('contact_form_shortcode')?>
					<?php $contact_value = getHydrameta(get_the_ID(),'hf_property_contact_form_shortcode'); ?>
					<?php echo do_shortcode($contact_value)?>
				</div>
			</div>
		</div>
	</div>

</div>