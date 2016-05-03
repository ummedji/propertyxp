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
            if (jQuery(this).scrollTop() > 550) {
                nav.addClass("fixed");
            } else {
                nav.removeClass("fixed");
            }
        });
    });
</script>
<div class="developer-menu top-dev-menu">

	<ul>
		<li>
			<a href="#details" class="active">
				<span class="nave_sp detailnave_i"></span>
				<span>DETAILS</span>
			</a>
		</li>
		<li>
			<a href="#flats">
				<span class="nave_sp catenave_i"></span>
				<span>CATAGORY</span>
			</a>
		</li>
		<li>
			<a href="#amenities">
				<span class="nave_sp amennave_i"></span>
				<span>AMENITIES</span>
			</a>
		</li>
		<li>
			<a href="#map">
				<span class="nave_sp locationnave_i"></span>
				<span>LOCATION</span>
			</a>
		</li>
		<li>
			<a href="#three_sixty_data">
				<span class="nave_sp rotnave_i"></span>
				<span>360*</span>
			</a>
		</li>
		<li>
			<a href="#gallery">
				<span class="nave_sp gallnave_i"></span>
				<span>GALLERY</span>
			</a>
		</li>
		<li>
			<a href="#line_chart">
				<span class="nave_sp marketnave_i"></span>
				<span>MARKET</span>
			</a>
		</li>
	</ul>

	<div class="im-interested" style="border:none !important; border-color:none !important;">
		<?php echo do_shortcode('[AnythingPopup id="4"]'); ?>
	</div>
	<div class="interested_cl">
		<div class="in_int_btn">
			<span class="text_of_ints"><i class="fa fa-envelope"></i><a href="javascript:AnythingPopup_OpenForm('AnythingPopup_BoxContainer4','AnythingPopup_BoxContainerBody4','AnythingPopup_BoxContainerFooter4','800','550');">I'M INTERESTED</a></span>
		</div>
	</div>

	<!--<div class="left_shar">
		<div class="inn_share_btn">
			<div class="share_txt"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>share Property</span></div>
		</div>
	</div>-->

</div>

<div class="property-detail developer-details">
	<div class="row temp_2_developer-details" id="details">
		<div class="col-md-12">
			<div class="tamp_title cl_tamp_title">
					<div class="row">
						<div class="col-md-4"><h2 class="pro_tl"><?php the_title(); ?></h2></div>
						<div class="col-md-4 text-center">
							<div class="address_tag"><?php print hydra_render_field(get_the_ID(), 'location', 'detail'); ?>
							</div>
						</div>
						<div class="col-md-4 top_tena_price">
							<?php print hydra_render_field(get_the_ID(), 'price', 'detail'); ?>
						</div>
					</div>
					<!-- /.header-title -->
				<div class="clearfix"></div>
			</div>
			<div class="row">
				<div class="col-md-12 about_cont temp_2about_cont center">

					<div class="center section-title as_section_tl"><h2><span>About <?php the_title();?></span></h2></div>
					<?php $content = get_the_content(); ?>
					<?php if (!empty($content)) : ?>
						<?php the_content(); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="row as_flats" >
				<div class="project-spec-details">
					<div class="col-md-12">
						<div class="col-md-2 col-sm-6 text-center about_box_tl">
							<div class="abtn_icon about_ii"></div>
							<h6>ADDRESS</h6>
							<p><?php the_field('address');?></p>
						</div>
						<div class="col-md-2 col-sm-6 text-center about_box_tl">
							<div class="abtn_icon configuration_ii"></div>
							<h6>CONFIGURATIONS</h6>
							<p><?php the_field('configurations');?></p>
						</div>
						<div class="col-md-2 col-sm-6 text-center about_box_tl">
							<div class="abtn_icon starting_ii"></div>
							<h6>STARTING PRICE</h6>
							<p><i class="icon-rupee"></i> <?php the_field('starting_price');?></p>
						</div>
						<div class="col-md-2 col-sm-6 text-center about_box_tl">
							<div class="abtn_icon builtup_square_ii"></div>
							<h6>BUILTUP AREA</h6>
							<p><?php the_field('builtup_area');?></p>
						</div>
						<div class="col-md-2 col-sm-6 col-sm-6 text-center about_box_tl">
							<div class="abtn_icon blocks_square_ii"></div>
							<h6>BLOCKS</h6>
							<p><?php the_field('blocks');?></p>
						</div>
						<div class="col-md-2 col-sm-6 text-center about_box_tl">
							<div class="abtn_icon prossesion_square_ii"></div>
							<h6>POSSESSION</h6>
							<p itemprop="releaseDate"><?php the_field('possession');?></p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

    	
    	<div class="row as_flats about_cont" id="flats">
    		<div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>Configuration Available <?php the_title();?></span></h2></div>
	        </div>
			<?php 
			    $bedroom_amenities = get_field('2_bedroom_apartment_ame');
			  
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
				if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}
		    ?>
	        
	        <div class="col-md-12 text-center mr_50">
				<h3>2 BedRoom Apartment</h3>
				<p class="cate_cont"> Al Burooj is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> 2.98 Crs</div>
					<div class="clearfix"></div>
				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5">
						<?php $sfa = get_field('2_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7">
						<div class="row">
							<div class="col-md-2 text-center">
								<div class="<?php echo $living_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/leving-room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $living;?>" style="text-align: center;">Leaving room</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $servant_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/servant_room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $servant;?>" style="text-align: center;">Servant room</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $kitchen_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/kitchen.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $kitchen;?>" style="text-align: center;">Kitchen</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $balconies_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/balconies.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $balconies;?>" style="text-align: center;">Balconies</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $bathrooms_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/bathrooms.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $bathrooms;?>" style="text-align: center;">Bathrooms</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $pooja_room_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/pooja_room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $pooja_room;?>" style="text-align: center;">Pooja room</p>
							</div>
							<div class="clearfix"></div>



							<div class="col-md-2 text-center">
								<div class="<?php echo $study_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/study_room.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $study;?>" style="text-align: center;">Study room</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $ac_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/ac.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $ac;?>" style="text-align: center;">AC</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $intercom_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/intercom.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $intercom;?>" style="text-align: center;">Intercom</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $video_door_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/video_door_phone.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $video_door;?>" style="text-align: center;">Video Door Phone</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $washing_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/washing_area.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $washing;?>" style="text-align: center;">Washing Area</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $gas_line_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/gas_line.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $gas_line;?>" style="text-align: center;">Gas Line</p>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-2 text-center">
								<div class="<?php echo $power_backup_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/power_backup.png" alt=" " width="100%">
								</div>
								<p class="icon_cont center<?php echo $power_backup;?>" style="text-align: center;">Power Backup</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $wooden_fade;?>">
									<img src="<?php bloginfo('template_directory')?>/images/templatev2/wooden_floor.png" alt=" " width="100%">
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
			
			    $bedroom_amenities = get_field('3_bedroom_apartment_ame');
			   
			  
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
				if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}
		    ?>
	        
	        <div class="col-md-12 text-center mr_50">
				<h3>3 BedRoom Apartment</h3>
				<p class="caps_text"> Al Burooj is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> 2.98 Crs</div>
				<div class="clearfix"></div>

				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5 as-pull-right">
						<?php $sfa = get_field('3_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7" >
						<div class="col-md-12">
							<div class="col-md-2 text-center">
								<div class="<?php echo $living_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/leving-room.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $living;?>" style="text-align: center;">Leving room</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $servant_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/servant_room.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $servant;?>">Servant room</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $kitchen_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/kitchen.png" alt=" " width="100%" />
								</div>
								<p class="center <?php echo $kitchen;?>">Kitchen</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $balconies_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/balconies.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $balconies;?>">Balconies</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $bathrooms_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/bathrooms.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $bathrooms;?>">Bathrooms</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $pooja_room_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/pooja_room.png" alt=" " width="100%" />
								</div>
								<p class="center <?php echo $pooja_room;?>">Pooja room</p>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-2 text-center">
								<div class="<?php echo $study_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/study_room.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $study;?>">Study room</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $ac_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/ac.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $ac;?>">AC</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $intercom_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/intercom.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $intercom;?>">Intercom</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $video_door_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/video_door_phone.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $video_door;?>">Video Door Phone</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $washing_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/washing_area.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $washing;?>">Washing Area</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $gas_line_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/gas_line.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $gas_line;?>">Gas Line</p>
							</div>
							<div class="clearfix"></div>

							<div class="col-md-2 text-center">
								<div class="<?php echo $power_backup_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/power_backup.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $power_backup;?>">Power Backup</p>
							</div>
							<div class="col-md-2 text-center">
								<div class="<?php echo $wooden_fade;?>">
									<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/wooden_floor.png" alt=" " width="100%">
								</div>
								<p class="center <?php echo $wooden;?>">Wooden Floor</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<?php 
			    $bedroom_amenities = get_field('4_bedroom_apartment_ame');
			   
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
				if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';}
		    ?>
	        
	        <div class="col-md-12 text-center mr_50">
				<h3>4 BedRoom Apartment</h3>
				<p class="cate_cont"> Al Burooj is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> 2.98 Crs</div>
				<div class="clearfix"></div>

				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5">
						<?php $sfa = get_field('4_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7" >
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2 text-center">
									<div class="<?php echo $living_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/leving-room.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $living;?>" style="text-align: center;">Leving room</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $servant_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/servant_room.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $servant;?>">Servant room</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $kitchen_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/kitchen.png" alt=" " width="100%" />
									</div>
									<p class="center <?php echo $kitchen;?>">Kitchen</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $balconies_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/balconies.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $balconies;?>">Balconies</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $bathrooms_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/bathrooms.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $bathrooms;?>">Bathrooms</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $pooja_room_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/pooja_room.png" alt=" " width="100%" />
									</div>
									<p class="center <?php echo $pooja_room;?>">Pooja room</p>
								</div>
								<div class="clearfix"></div>

								<div class="col-md-2 text-center">
									<div class="<?php echo $study_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/study_room.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $study;?>">Study room</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $ac_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/ac.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $ac;?>">AC</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $intercom_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/intercom.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $intercom;?>">Intercom</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $video_door_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/video_door_phone.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $video_door;?>">Video Door Phone</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $washing_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/washing_area.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $washing;?>">Washing Area</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $gas_line_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/gas_line.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $gas_line;?>">Gas Line</p>
								</div>
								<div class="clearfix"></div>

								<div class="col-md-2 text-center">
									<div class="<?php echo $power_backup_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/power_backup.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $power_backup;?>">Power Backup</p>
								</div>
								<div class="col-md-2 text-center">
									<div class="<?php echo $wooden_fade;?>">
										<img class="aligncenter" src="<?php bloginfo('template_directory')?>/images/templatev2/wooden_floor.png" alt=" " width="100%">
									</div>
									<p class="center <?php echo $wooden;?>">Wooden Floor</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
    	</div>
    <!--<hr/>-->
    <?php $amenities = hydra_render_field(get_the_ID(), 'amenities', 'detail');  ?>
    <?php 
    if ($amenities): //print_r( strip_tags($amenities)); 
	    $val_am = trim(strip_tags($amenities));
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
        <div class="row as_amenities" id="amenities" >
        	<div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>Amenities in <?php the_title();?></span></h2></div>
          	</div>
          	<div class="col-md-12" style="margin-top: 20px;">
	          	<ul class="amenities-options">
					<li class="single-amenity">
						<div class="<?php echo $life_fade;?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Lift.png" ></div>
						<div class="<?php echo $lift; ?> text amenities_cn">Lift</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $sec_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Security.png" ></div>
						<div class="<?php echo $security; ?> text amenities_cn">Security</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $internet_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Internet.png" ></div>
						<div class="<?php echo $internet; ?> text amenities_cn">Internet</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $kids_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Kids-Zone.png" ></div>
						<div class="<?php echo $kids_area; ?> text amenities_cn">Kids Zone</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $swim_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Swimming-Pool.png" ></div>
						<div class="<?php echo $swimming_pool; ?> text amenities_cn">Swimming Pool</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $gym_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Gymnasium.png" ></div>
						<div class="<?php echo $gymnasium; ?> text amenities_cn">Gymnasium</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $garen_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Garden.png" ></div>
						<div class="<?php echo $garden; ?> text amenities_cn">Garden</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $lib_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Library.png" ></div>
						<div class="<?php echo $llibrary; ?> text amenities_cn">Library</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $com_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Community-Hall.png" ></div>
						<div class="<?php echo $community; ?> text amenities_cn">Community Hall</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $internal_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Internal-Roads.png" ></div>
						<div class="<?php echo $internal_roads; ?> text amenities_cn">Internal Roads</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $jog_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Jogging-Track.png" ></div>
						<div class="<?php echo $jogging; ?> text amenities_cn">Jogging Track</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $power_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/No-Power-Backup.png" ></div>
						<div class="<?php echo $no_power_backup; ?> text amenities_cn">No Power Backup</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $club_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Club-House.png" ></div>
						<div class="<?php echo $club_house; ?> text amenities_cn">Club House</div>
					</li>
					<li class="single-amenity">
						<div class="<?php echo $indoor_fade; ?>"><img src="<?php bloginfo('template_directory')?>/images/amenities/pink/Indoor-Games.png" ></div>
						<div class="<?php echo $indoor_games; ?> text amenities_cn">Indoor Games</div>
					</li>
					
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
			<div class="col-md-12 row-wise-amenities as_row-wise-amenities temp_2_amenities">
				<ul class="properties-filter">
			       <li class="selected">
			       		<a href="#" data-filter=".floors" class="first-click-this">
			       			<!--<div><span class="dev-floors"></span><!-- <img src="<?php /*bloginfo('template_directory')*/?>/images/FLOOR.png" > </div>-->
							<div class="header-text">FLOORS</div>
							<div class="separator"></div>
							<div class="clearfix"></div>
						</a>
					</li>
			       <li>
			       		<a href="#" data-filter=".fittings">
			       			<!--<div><span class="dev-fittings"></span><!-- <img src="<?php /*bloginfo('template_directory')*/?>/images/FITTINGS.png" > </div>-->
							<div class="header-text">FITTINGS</div>
							<div class="separator"></div>
							<div class="clearfix"></div>
						</a>
					</li>
			       <li>
			       		<a href="#" data-filter=".walls">
			       			<!--<div><span class="dev-walls"></span><!-- <img src="<?php /*bloginfo('template_directory')*/?>/images/WALLS.png" > </div>-->
							<div class="header-text">WALLS</div>
							<div class="separator"></div>
							<div class="clearfix"></div>
						</a>
					</li>
		     	</ul>
		   
		  
		    	<div class="properties-items inn_properties-items isotope">
		    		<div class="items-list row">
			    		<div class="building-card floors-card co  floors property-item isotope-item">
							<div class="row">
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">BALCONY</div>
										<div class="texts as_texts"><?php the_field('balcony'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">KITCHEN</div>
										<div class="texts as_texts"><?php the_field('kitchen'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">LIVING/DINING</div>
										<div class="texts as_texts"><?php the_field('living/dining'); ?></div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">MASTER BEDROOM</div>
										<div class="texts as_texts"><?php the_field('master_bedroom'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">OTHER BEDROOM</div>
										<div class="texts as_texts"><?php the_field('other_bedroom'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">TOILETS</div>
										<div class="texts as_texts"><?php the_field('toilets'); ?></div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="building-card fittings-card  fittings property-item isotope-item">
							<div class="row">
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">DOORS</div>
										<div class="texts as_texts"><?php the_field('doors'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">ELECTRICAL</div>
										<div class="texts as_texts"><?php the_field('electrical'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">KITCHEN</div>
										<div class="texts as_texts"><?php the_field('fitting_kitchen'); ?></div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">WINDOWS</div>
										<div class="texts as_texts"><?php the_field('windows'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">TOILETS</div>
										<div class="texts as_texts"><?php the_field('fitting_toilets'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">OTHERS</div>
										<div class="texts as_texts"><?php the_field('others'); ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="building-card walls-card  walls property-item isotope-item">
							<div class="row">
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">EXTERIOR</div>
										<div class="texts as_texts"><?php the_field('exterior'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">INTERIOR</div>
										<div class="texts as_texts"><?php the_field('interior'); ?></div>
									</div>
								</div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">KITCHEN</div>
										<div class="texts as_texts"><?php the_field('kitchen_walls'); ?></div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="pills col-md-4">
									<div class="as_pills">
										<div class="header">TOILETS</div>
										<div class="texts as_texts"><?php the_field('toilets_walls'); ?></div>
									</div>
								</div>
							</div>
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
    
    	<div class="row as_map" id="map" >
    	 <div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>EXPLORE PROJECT AND NEIGHBOURHOOD <?php the_title();?></span></h2></div>
         </div>
         
         <?php /*?>
         <ul class="map-tabs-links properties-filter">
		       <li class="selected">
		       		<a href="#" data-filter=".normal-map" class="first-click-this">BUILDINGS </a>
		       </li>
		       <li>
		       		<a href="#" data-filter=".nearby-map">NEARBY</a>
		       </li>
		</ul>		
		<div class="isotope properties-items">
		    		<div class="items-list row">
			    		
			    		<div class="isotope-item   property-item  normal-map col-md-12">
			    		<?php $latitude = get_field('latitude');
					    	$longitude = get_field('longitude');?>
			    		<!-- 	<iframe width="1150" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $latitude?>,<?php echo $longitude?> (<?php the_title()?>)&amp;output=embed"></iframe>
					    	 --><?php //wp_enqueue_script('googlemaps3');
    						
						    wp_enqueue_script('clusterer');
						    wp_enqueue_script('infobox');
						    ?>
						   
						    <?php $mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE); ?>
						    <?php if (isset($mapPosition['items'][0])): ?>
						        <?php if (!empty($mapPosition['items'][0]['latitude']) && !empty($mapPosition['items'][0]['longitude'])) : ?>
						            <div id="map-property">
						            </div><!-- /#map-property -->
						        <?php endif; ?>
						    <?php endif; ?>
						    <?php add_action('aviators_footer_map_detail', 'aviators_properties_map_detail'); ?>
	    					
	    				</div>
	    				<div class="isotope-item   property-item  nearby-map col-md-12">
						    <?php 
						    	$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');
						    	$longitude = $mapPosition['items'][0]['longitude'];//get_field('longitude');
						    	echo do_shortcode('[map_neighbourhood location="'.$latitude.','.$longitude.'"]')?>
						</div>
				</div>
	    </div>
	    <?php */?>
	     <div class="col-md-12 inn_map_cont" >
		     <ul class="map-tabs-links properties-filter">
			       <li class="selected">
			       		<a href="#"  onclick ="removeonlyMarkers();clearResults();" class="first-click-this">BUILDINGS </a>
			       </li>
			       <li>
			       		<a href="#" onclick ="removecenterMarkers();reallyDoSearch();" >NEARBY</a>
			       </li>
			</ul>	
	    	<?php 
	    	$mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE);
	    	$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');
	    	$longitude = $mapPosition['items'][0]['longitude'];//get_field('longitude');
	    	echo do_shortcode('[map_neighbourhood location="'.$latitude.','.$longitude.'"]')?>
	    </div>
		<div class="col-md-12 map_bot_border"><span></span></div>
	 
	</div>
        
        
         <hr/>
          <div class="row" id="three_sixty_data" >
	        <div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>360* OF <?php the_title();?></span></h2></div>
	        	
	        		<div class="properties-items-three_sixty_data isotope">
			    		<div class="items-list row">
                                            <div class="three_sixty_data-gallery1 property-item-three_sixty_data isotope-item-three_sixty_data  col-md-12">
		            			<?php 	$three_sixty_data_image = get_field('three_sixty_data');
						if( !empty($three_sixty_data_image) ): ?>
							<img src="<?php echo $three_sixty_data_image['url']; ?>" alt="<?php echo $three_sixty_data_image['alt']; ?>" />
						<?php 	endif; ?>
                                            </div>
		            		
                                        </div>
	        		</div>
	        </div>
	        <!-- /.col-md-6 -->
	    </div>
	    <!-- /.row -->
         <hr/>
         
         <div class="row temp_2_gallery" id="gallery" >
	        <div class="col-md-12 al_baruj_slider">
	        	<div class="center section-title as_section_tl"><h2><span>Images of <?php the_title();?></span></h2></div>
	        	<ul class="properties-filter">
	        		<li class="selected"><a href="#" data-filter=".gallery1" class="first-click-this">Gallery 1</a></li>
	        		<li><a href="#" data-filter=".gallery2">Gallery 2</a></li>
	        	</ul>
	        		<div class="properties-items isotope">
			    		<div class="items-list row">
				    		<div class="gallery1 property-item isotope-item  col-md-12">
		            			<?php print hydra_render_field(get_the_ID(), 'gallery', 'detail'); ?>
		            		</div>
		            		<div class="gallery2 property-item isotope-item  col-md-12">
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
		            data: [	<?php if(get_field('jan') != null ) echo get_field('jan'); else echo '7000';?>, 
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
				            <?php if(get_field('dec') != null ) echo get_field('dec'); else echo '9600';?>,]
		
		        }]
		    });
		    jQuery( ".first-click-this" ).trigger( "click" );
		});
	</script>
	<div class="row" id="line_chart" >
		<div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>Insights Into <?php the_title();?></span></h2></div>
	        	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
         </div>
	
		<div class="col-md-12">
			<div id="line_chart_container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		</div>
	</div>	
	<div class="row" id="about-developer">
		<div class="col-md-12">
			<div class="center section-title as_section_tl"><h2><span>About <?php the_field('developer_name'); ?></span></h2></div>
			<div class="row">
				<div class="col-md-4 center">
					<div class="d_group">
						<?php 	$image = get_field('developer_image');
						if( !empty($image) ): ?>
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
						<?php 	endif; ?>
					</div>
				</div>
				<div class="col-md-8">
					<p class="caps_text"><?php the_field('developer_description'); ?></p>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4 center"><h5>YEAR OF ESTABLISHMENT</h5><p><?php the_field('year_of_establishment')?></p></div>
				<div class="col-md-4 center"><h5>TOTAL PROJECTS</h5><p><?php the_field('total_projects')?></p></div>
				<div class="col-md-4 center"><h5>ASSOCIATE MEMBERSHIPS</h5><p><?php the_field('associate_memberships')?></p></div>
			</div>
		</div>
	</div>	
		
	<div class="row" id="contact-developer">	
		<div class="col-md-12 popup-this-contact-form">
			<div class="center section-title as_section_tl"><h2><span>Contact <?php the_field('developer_name'); ?></span></h2></div>
			<div class="row">
				<div class="col-md-4 pull-right center">
					<?php /*	$image = get_field('developer_image');
					if( !empty($image) ): */?><!--
					<img src="<?php /*echo $image['url']; */?>" alt="<?php /*echo $image['alt']; */?>" />
				--><?php /*	endif; */?>
					<div class="contact_inn"><h4><?php the_field('developer_contact_no.')?></h4></div>
					<!--<p>Sold exclusively by Hiranandani without the intervention of any third party.</p>-->
				</div>
				<div class="col-md-8 right_cont">
					<!--<p></p>-->
					<?php $contact_value = get_field('contact_form_shortcode')?>
					<?php echo do_shortcode($contact_value)?>
				</div>
			</div>
		</div>
	</div>

</div>