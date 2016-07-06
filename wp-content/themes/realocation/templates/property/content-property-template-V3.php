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
	<div id="content-5" class="content horizontal-images light">
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
			<a href="#flats">
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
	</div>
        
	<!--<div class="interested_cl">
		<div class="in_int_btn">
			<span class="text_of_ints"><i class="fa fa-envelope"></i><a href="javascript:AnythingPopup_OpenForm('AnythingPopup_BoxContainer4','AnythingPopup_BoxContainerBody4','AnythingPopup_BoxContainerFooter4','800','550');">I'M INTERESTED</a></span>
		</div>
	</div> -->

	<!--<div class="left_shar">
		<div class="inn_share_btn">
			<div class="share_txt"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>share Property</span></div>
		</div>
	</div>-->

</div>



<div class="col-md-9">
	<div class="property-detail developer-details">
		<div class="row temp_2_developer-details"  id="details">
			<div class="col-md-12">
				<div class="tamp_title">
					<div class="row">
						<div class="col-md-4 col-sm-4"><h2 class="pro_tl"><?php the_title(); ?></h2></div>
						<div class="col-md-4 col-sm-4 text-center">
							<div class="address_tag"><?php print hydra_render_field(get_the_ID(), 'location', 'detail'); ?>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 top_tena_price">
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
								<h6>ADDRESS</h6>
								<div class="abtn_icon about_ii"></div>
								<p><?php echo getHydrameta(get_the_ID(),'hf_property_address');//the_field('address');?></p>
							</div>
							<div class="col-md-2 col-sm-6 text-center about_box_tl">
								<h6>CONFIGURATIONS</h6>
								<div class="abtn_icon configuration_ii"></div>
								<p><?php echo getHydrameta(get_the_ID(),'hf_property_configurations');//the_field('configurations');?></p>
							</div>
							<div class="col-md-2 col-sm-6 text-center about_box_tl">
								<h6>STARTING PRICE</h6>
								<div class="abtn_icon starting_ii"></div>
								<p><i class="icon-rupee"></i> <?php echo getHydrameta(get_the_ID(),'hf_property_starting_price');//the_field('starting_price');?></p>
							</div>
							<div class="col-md-2 col-sm-6 text-center about_box_tl">
								<h6>BUILTUP AREA</h6>
								<div class="abtn_icon builtup_square_ii"></div>
								<p><?php echo getHydrameta(get_the_ID(),'hf_property_builtup_area');//the_field('builtup_area');?></p>
							</div>
							<div class="col-md-2 col-sm-6 text-center about_box_tl">
								<h6>BLOCKS</h6>
								<div class="abtn_icon blocks_square_ii"></div>
								<p><?php echo getHydrameta(get_the_ID(),'hf_property_blocks'); //the_field('blocks');?></p>
							</div>
							<div class="col-md-2 col-sm-6 text-center about_box_tl">
								<h6>POSSESSION</h6>
								<div class="abtn_icon prossesion_square_ii"></div>
								<p itemprop="releaseDate"><?php echo getHydrameta(get_the_ID(),'hf_property_possession');	//the_field('possession');?></p>
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
			/*$bedroom_amenities = get_field('2_bedroom_apartment_ame');

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
			?>

			<div class="col-md-12 text-center mr_50">
				<h3>2 BedRoom Apartment</h3>
				<p class="cate_cont room-bto"> <?php the_title(); ?> is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> 2.98 Crs</div>
				<div class="clearfix"></div>
				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5">
						<?php //$sfa = get_field('2_bed_flat_slider_alias');
						$sfa = getHydrameta(get_the_ID(),'hf_property_2_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7 config-content_img">
						<div class="row">
							<ul class="room_details">
								<li class="<?php echo $living_fade;?>">Leaving room</li>
								<li class="<?php echo $servant_fade;?>">Servant room</li>
								<li class="<?php echo $kitchen_fade;?>">Kitchen</li>
								<li class="<?php echo $balconies_fade;?>">Balconies</li>
								<li class="<?php echo $bathrooms_fade;?>">Bathrooms</li>
								<li class="<?php echo $pooja_room_fade;?>">Pooja room</li>
								<li class="<?php echo $study_fade;?>">Study room</li>
								<li class="<?php echo $ac_fade;?>">AC</li>
								<li class="<?php echo $intercom_fade;?>">Intercom</li>
								<li class="<?php echo $video_door_fade;?>">Video Door Phone</li>
								<li class="<?php echo $washing_fade;?>">Washing Area</li>
								<li class="<?php echo $gas_line_fade;?>">Gas Line</li>
								<li class="<?php echo $power_backup_fade;?>">Power Backup</li>
								<li class="<?php echo $wooden_fade;?>">Wooden Floor</li>
								<li class="">&nbsp;</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- -- 3 Bedroom Apartment -- -->
			<?php

			/*$bedroom_amenities = get_field('3_bedroom_apartment_ame');


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
			if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';} */
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
			?>

			<div class="col-md-12 text-center mr_50">
				<h3>3 BedRoom Apartment</h3>
				<p class="room-bto1"> <?php the_title(); ?> is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> 2.98 Crs</div>
				<div class="clearfix"></div>

				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5 as-pull-right">
						<?php //$sfa = get_field('3_bed_flat_slider_alias');
						$sfa = getHydrameta(get_the_ID(),'hf_property_3_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7 config-content_img" >
						<div class="row">
							<ul class="room_details">
								<li class="<?php echo $living_fade;?>">Leving room</li>
								<li class="<?php echo $servant_fade;?>">Servant room</li>
								<li class="<?php echo $kitchen_fade;?>">Kitchen</li>
								<li class="<?php echo $balconies_fade;?>">Balconies</li>
								<li class="<?php echo $bathrooms_fade;?>">Bathrooms</li>
								<li class="<?php echo $pooja_room_fade;?>">Pooja room</li>
								<li class="<?php echo $study_fade;?>">Pooja room</li>
								<li class="<?php echo $ac_fade;?>">AC</li>
								<li class="<?php echo $intercom_fade;?>">Intercom</li>
								<li class="<?php echo $video_door_fade;?>">Video Door Phone</li>
								<li class="<?php echo $washing_fade;?>">Washing Area</li>
								<li class="<?php echo $gas_line_fade;?>">Gas Line</li>
								<li class="<?php echo $power_backup_fade;?>">Power Backup</li>
								<li class="<?php echo $wooden_fade;?>">Wooden Floor</li>
								<li class="">&nbsp;</li>
							</ul>

						</div>
					</div>
				</div>
			</div>

			<?php
			/*$bedroom_amenities = get_field('4_bedroom_apartment_ame');

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
			if (in_array('woodenfloor', $bedroom_amenities)){ $wooden = '';$wooden_fade='';} else { $wooden = 'fade-text';$wooden_fade = 'fade';} */
			
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

			<div class="col-md-12 text-center mr_50">
				<h3>4 BedRoom Apartment</h3>
				<p class="cate_cont room-bto2"> <?php the_title(); ?> is a beyond lifestyle apartment scheme having equal focus on spaces like interior space, private space & community space. It is indeed a place to taste, smell, touch, see and feel luxury everywhere, just like living with ultra sophistication and pure refinement.</p>
				<div class="price_right"><i class="fa fa-inr fa-1x"></i> 2.98 Crs</div>
				<div class="clearfix"></div>

				<div class="row bedroom_par">
					<div class="small-flat-slider col-md-5">
						<?php //$sfa = get_field('4_bed_flat_slider_alias');
						$sfa = getHydrameta(get_the_ID(),'hf_property_4_bed_flat_slider_alias');
						if($sfa != '') putRevSlider( $sfa ); else putRevSlider( 'property_1004_flats' );?>
					</div>
					<div class="config-content col-md-7 config-content_img" >
						<div class="row">
							<ul class="room_details">
								<li class="<?php echo $living_fade;?>">Leving room</li>
								<li class="<?php echo $servant_fade;?>">Servant room</li>
								<li class="<?php echo $kitchen_fade;?>">Kitchen</li>
								<li class="<?php echo $balconies_fade;?>">Balconies</li>
								<li class="<?php echo $bathrooms_fade;?>">Bathrooms</li>
								<li class="<?php echo $pooja_room_fade;?>">Pooja room</li>
								<li class="<?php echo $study_fade;?>">Study room</li>
								<li class="<?php echo $ac_fade;?>">AC</li>
								<li class="<?php echo $intercom_fade;?>">Intercom</li>
								<li class="<?php echo $video_door_fade;?>">Video Door Phone</li>
								<li class="<?php echo $washing_fade;?>">Washing Area</li>
								<li class="<?php echo $gas_line_fade;?>">Gas Line</li>
								<li class="<?php echo $power_backup_fade;?>">Power Backup</li>
								<li class="<?php echo $wooden_fade;?>">Wooden Floor</li>
								<li class="">&nbsp;</li>
							</ul>
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
				
				<div id="hidden_ammineties" style="display:none;">
					<?php echo $amenities; ?>
				</div>
				
				<div class="col-md-12 parent_amenities text-center" style="margin-top: 5px;">

					<ul class="amenities-options">
					
					</ul>
				
				<!--	<ul class="temp3amenities-options">
						<li class="<?php echo $life_fade;?>">Lift</li>
						<li class="<?php echo $sec_fade; ?>">Security</li>
						<li class="<?php echo $internet_fade; ?>">Internet</li>
						<li class="<?php echo $kids_fade; ?>">Kids Zone</li>
						<li class="<?php echo $swim_fade; ?>">Swimming Pool</li>
						<li class="<?php echo $gym_fade; ?>">Gymnasium</li>
						<li class="<?php echo $garen_fade; ?>">Garden</li>
						<li class="<?php echo $lib_fade; ?>">Library</li>
						<li class="<?php echo $com_fade; ?>">Community Hall</li>
						<li class="<?php echo $internal_fade; ?>">Internal Roads</li>
						<li class="<?php echo $jog_fade; ?>">Jogging Track</li>
						<li class="<?php echo $power_fade; ?>">No Power Backup</li>
						<li class="<?php echo $club_fade; ?>">Club House</li>
						<li class="<?php echo $indoor_fade; ?>">Indoor Games</li>
						<li class="">&nbsp;</li>
						<li class="">&nbsp;</li>
						<li class="">&nbsp;</li>
						<li class="">&nbsp;</li>
						<div class="clearfix"></div>
					</ul> -->
					<div class="clearfix"></div>
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
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_balcony'); //the_field('balcony'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">KITCHEN</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_kitchen'); //the_field('kitchen'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">LIVING/DINING</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_livingdining');//the_field('living/dining'); ?></div>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">MASTER BEDROOM</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_master_bedroom');//the_field('master_bedroom'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">OTHER BEDROOM</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_other_bedroom'); //the_field('other_bedroom'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">TOILETS</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_toilets'); //the_field('toilets'); ?></div>
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
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_doors'); //the_field('doors'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">ELECTRICAL</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_electrical');//the_field('electrical'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">KITCHEN</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_kitchen'); //the_field('fitting_kitchen'); ?></div>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">WINDOWS</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_windows'); //the_field('windows'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">TOILETS</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_toiletsf');//the_field('fitting_toilets'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">OTHERS</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_others'); //the_field('others'); ?></div>
										</div>
									</div>
								</div>
							</div>
							<div class="building-card walls-card  walls property-item isotope-item">
								<div class="row">
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">EXTERIOR</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_nexterior');//the_field('exterior'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">INTERIOR</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_ninterior'); //the_field('interior'); ?></div>
										</div>
									</div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">KITCHEN</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_nkitchen');  //the_field('kitchen_walls'); ?></div>
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="pills col-md-4">
										<div class="as_pills">
											<div class="header">TOILETS</div>
											<div class="texts as_texts"><?php echo getHydrameta(get_the_ID(),'hf_property_ntoilets'); //the_field('toilets_walls'); ?></div>
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
			<div class="col-md-12 inn_map_cont v3-filter">
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
                <div class="row as_flats" id="three_sixty_data" >
	        <div class="col-md-12">
	        	<div class="center section-title as_section_tl"><h2><span>360* OF <?php the_title();?></span></h2></div>
	        	
	        		<div class="properties-items-three_sixty_data isotope">
			    		<div class="items-list-three_sixty_data row">
                                            <div class="three_sixty_data-gallery property-item-three_sixty_data isotope-item  col-md-12">
		            			<?php 	//$three_sixty_data_image = get_field('three_sixty_data');
								$three_sixty_data_imageurl = getHydrameta(get_the_ID(),'hf_property_three_sixty_data', 'url');
								$three_sixty_data_imagealt = getHydrameta(get_the_ID(),'hf_property_three_sixty_data', 'alt');
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
                        
                
               <div class="row temp_2_gallery" id="gallery" >
				<div class="col-md-12 al_baruj_slider">
					<div class="center section-title as_section_tl"><h2><span>Images of <?php the_title();?></span></h2></div>
					<ul class="properties-filter gallery-top">
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
						data: [	<?php if(getHydrameta(get_the_ID(),'hf_property_jan') != null ) echo getHydrameta(get_the_ID(),'hf_property_jan'); else echo '6900'; ?>,
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
							<?php if(getHydrameta(get_the_ID(),'hf_property_dec') != null ) echo getHydrameta(get_the_ID(),'hf_property_dec'); else echo '6900'; ?>,/*<?php if(get_field('jan') != null ) echo get_field('jan'); else echo '7000';?>,
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
							<?php if(get_field('dec') != null ) echo get_field('dec'); else echo '9600';?>,*/]

					}]
				});
				jQuery( ".first-click-this" ).trigger( "click" );
			});
		</script>
		<div class="row" id="line_chart" >
			<div class="col-md-12">
				<div class="center section-title as_section_tl"><h2><span>Insights Into <?php the_title();?></span></h2></div>
				<p><?php echo getHydrameta(get_the_ID(),'hf_property_insights'); ?></p>
			</div>

			<div class="col-md-12">
				<div id="line_chart_container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
			</div>
		</div>
		<div class="row" id="about-developer">
			<div class="col-md-12">
				<div class="center section-title as_section_tl"><h2><span>About <?php echo getHydrameta(get_the_ID(),'hf_property_developer_name');//the_field('developer_name'); ?></span></h2></div>
				<div class="row">
					<div class="col-md-4 center">
						<div class="d_group">
							<?php 	//$image = get_field('developer_image');
							$imageurl = getHydrameta(get_the_ID(),'hf_property_developer_image', 'url');
							$imagealt = getHydrameta(get_the_ID(),'hf_property_developer_image', 'alt');
							if( !empty($imageurl) ): ?>
								<img src="<?php echo $imageurl; ?>" alt="<?php echo $imagealt; ?>" />
							<?php 	endif; ?>
						</div>
					</div>
					<div class="col-md-8">
						<p><?php  echo getHydrameta(get_the_ID(),'hf_property_developer_description'); //the_field('developer_description'); ?></p>
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
					<div class="col-md-4 col-sm-4 col-xs-12 pull-right center">
					
						<?php /*	$image = get_field('developer_image');
					if( !empty($image) ): */?><!--
					<img src="<?php /*echo $image['url']; */?>" alt="<?php /*echo $image['alt']; */?>" />
				--><?php /*	endif; */?>
				
						
				
						<div class="contact_inn"><h4>
						<?php 	//$image = get_field('developer_image');
						if( !empty($imageurl) ): ?>
							<img src="<?php echo $imageurl; ?>" alt="<?php echo $imagealt; ?>" />
						<?php 	endif; ?>
						<?php echo getHydrameta(get_the_ID(),'hf_property_developer_contact_no'); //the_field('developer_contact_no.')?></h4></div>
						<!--<p>Sold exclusively by Hiranandani without the intervention of any third party.</p>-->
					</div>
					<div class="col-md-8 col-sm-8 col-xs-12 right_cont">
						<!--<p></p>-->
						<?php //$contact_value = get_field('contact_form_shortcode');
						$contact_value = getHydrameta(get_the_ID(),'hf_property_contact_form_shortcode');?>
						<?php echo do_shortcode($contact_value)?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<script type="text/javascript">
	jQuery("document").ready(function () {
		var nav = jQuery('.left_interested');

		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 550) {
				nav.addClass("fixed");
			} else {
				nav.removeClass("fixed");
			}
		});
	});
</script>
<div class="col-md-3 left_interested">
	<h3>I'M INTERESTED</h3>
	<div class="cont_deep">
		<div class="col-md-4 col-xs-4"><img src="<?php bloginfo('template_directory')?>/images/since_logo.png" alt=" " class="img-responsive"></div>
		<div class="col-md-8 col-xs-8 text-center">
			<h4>Contact Deep Group</h4>
			<h6>079-26446232-33</h6>
			<p>Sold exclusively by Hiranandani without the intervention of any third party.</p>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="cont_deep_form">
			<?php $contact_value = get_field('contact_form_shortcode')?>
			<?php echo do_shortcode($contact_value)?>
	</div>

	<div class="share_pro">
           <?php 
            global $wpdb;
            global $post;
		$ctOptions = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'csbwfs_%'");
								
		foreach ($ctOptions as $option) {
			$ctOptions[$option->option_name] =  $option->option_value;
		}
                
                $pluginOptionsVal = $ctOptions;
                
                
                $shareurl = csbwfs_get_current_page_url($_SERVER);
/* Set title and url for home page */  
if(is_home() || is_front_page()) 
    {
	   $shareurl =home_url('/');
        $ShareTitle=get_bloginfo('name');	
		}	
			
$ShareTitle= htmlspecialchars(urlencode($ShareTitle));



/* Get All buttons Image */

//get facebook button image
if($pluginOptionsVal['csbwfs_fb_image']!=''){ $fImg=$pluginOptionsVal['csbwfs_fb_image'];} 
   else{$fImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/fb.png');}   
   
   //echo $fImg;die;
   
//get twitter button image  
if($pluginOptionsVal['csbwfs_tw_image']!=''){ $tImg=$pluginOptionsVal['csbwfs_tw_image'];} 
   else{$tImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/tw.png');}   
//get Linkedin button image
if($pluginOptionsVal['csbwfs_li_image']!=''){ $lImg=$pluginOptionsVal['csbwfs_li_image'];} 
   else{$lImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/in.png');}   
//get mail button image  
if($pluginOptionsVal['csbwfs_mail_image']!=''){ $mImg=$pluginOptionsVal['csbwfs_mail_image'];} 
   else{$mImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/ml.png');}   
//get google plus button image 
if($pluginOptionsVal['csbwfs_gp_image']!=''){ $gImg=$pluginOptionsVal['csbwfs_gp_image'];} 
   else{$gImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/gp.png');}  
//get pinterest button image   
 
if($pluginOptionsVal['csbwfs_pin_image']!=''){ $pImg=$pluginOptionsVal['csbwfs_pin_image'];} 
   else{$pImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/pinit.png');}   
   
//get youtube button image
if(isset($pluginOptionsVal['csbwfs_yt_image']) && $pluginOptionsVal['csbwfs_yt_image']!=''){ $ytImg=$pluginOptionsVal['csbwfs_yt_image'];} 
   else{$ytImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/youtube.png');}   
    
//get reddit plus button image 
if(isset($pluginOptionsVal['csbwfs_re_image']) && $pluginOptionsVal['csbwfs_re_image']!=''){ $reImg=$pluginOptionsVal['csbwfs_re_image'];} 
   else{$reImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/reddit.png');}  
   
//get stumbleupon button image   
if(isset($pluginOptionsVal['csbwfs_st_image']) && $pluginOptionsVal['csbwfs_st_image']!=''){ $stImg=$pluginOptionsVal['csbwfs_st_image'];} 
   else{$stImg=plugins_url('custom-share-buttons-with-floating-sidebar/images/stumbleupon.png');}   


/* Get All buttons Image Alt/Title */
//get facebook button image alt/title
if($pluginOptionsVal['csbwfs_fb_title']!=''){ $fImgAlt=$pluginOptionsVal['csbwfs_fb_title'];} 
else{$fImgAlt='Share On Facebook';}   
//get twitter button image alt/title
if($pluginOptionsVal['csbwfs_tw_title']!=''){ $tImgAlt=$pluginOptionsVal['csbwfs_tw_title'];} 
else{$tImgAlt='Share On Twitter';}   
//get Linkedin button image alt/title
if($pluginOptionsVal['csbwfs_li_title']!=''){ $lImgAlt=$pluginOptionsVal['csbwfs_li_title'];} 
else{$lImgAlt='Share On Linkedin';}   
//get mail button image alt/title 
if($pluginOptionsVal['csbwfs_mail_title']!=''){ $mImgAlt=$pluginOptionsVal['csbwfs_mail_title'];} 
else{$mImgAlt='Contact us';}   
//get google plus button image alt/title
if($pluginOptionsVal['csbwfs_gp_title']!=''){ $gImgAlt=$pluginOptionsVal['csbwfs_gp_title'];} 
else{$gImgAlt='Share On Google Plus';}  
//get pinterest button image alt/title  
if($pluginOptionsVal['csbwfs_pin_title']!=''){ $pImgAlt=$pluginOptionsVal['csbwfs_pin_title'];} 
else{$pImgAlt='Share On Pinterest';}   
//get youtube button image alt/title
if(isset($pluginOptionsVal['csbwfs_yt_title']) && $pluginOptionsVal['csbwfs_yt_title']!=''){ $ytImgAlt=$pluginOptionsVal['csbwfs_yt_title'];} 
else{$ytImgAlt='Share On Youtube';}
//get reddit plus button image alt/title
if(isset($pluginOptionsVal['csbwfs_re_title']) && $pluginOptionsVal['csbwfs_re_title']!=''){ $reImgAlt=$pluginOptionsVal['csbwfs_re_title'];} 
else{$reImgAlt='Share On Reddit';}  
//get stumbleupon button image alt/title  
if(isset($pluginOptionsVal['csbwfs_st_title']) && $pluginOptionsVal['csbwfs_st_title']!=''){ $stImgAlt=$pluginOptionsVal['csbwfs_st_title'];} 
else{$stImgAlt='Share On Stumbleupon';}   
     
//get email message
if(is_page() || is_single() || is_category() || is_archive()){
	
		if($pluginOptionsVal['csbwfs_mailMessage']!=''){ $mailMsg=$pluginOptionsVal['csbwfs_mailMessage'];} else{
		 $mailMsg='?subject='.$ShareTitle.'&body='.$shareurl;}
 }else
 {
	 $mailMsg='?subject='.get_bloginfo('name').'&body='.home_url('/');
	 }
 

// Top Margin
if($pluginOptionsVal['csbwfs_top_margin']!=''){
	$margin=$pluginOptionsVal['csbwfs_top_margin'];
}else
{
	$margin='25%';
	}

//Sidebar Position
if($pluginOptionsVal['csbwfs_position']=='right'){
$style=' style="top:'.$margin.';right:-5px;"';	
$idName=' id="csbwfs-right"';
$showImg='hide-r.png';
$hideImg='show.png';	
}else if($pluginOptionsVal['csbwfs_position']=='bottom'){
$style=' style="bottom:0;"';
$idName=' id="csbwfs-bottom"'; 
$showImg='hide-b.png'; 
$hideImg='show.png';
}
else
{
$idName=' id="csbwfs-left"'; 
$style=' style="top:'.$margin.';left:0;"';
$showImg='hide-l.png';
$hideImg='hide.png';
}
/* Get All buttons background color */
//get facebook button image background color 
if($pluginOptionsVal['csbwfs_fb_bg']!=''){ $fImgbg=' style="background:'.$pluginOptionsVal['csbwfs_fb_bg'].';"';} 
else{$fImgbg='';}   
//get twitter button image  background color 
if($pluginOptionsVal['csbwfs_tw_bg']!=''){ $tImgbg=' style="background:'.$pluginOptionsVal['csbwfs_tw_bg'].';"';} 
else{$tImgbg='';}   
//get Linkedin button image background color 
if($pluginOptionsVal['csbwfs_li_bg']!=''){ $lImgbg=' style="background:'.$pluginOptionsVal['csbwfs_li_bg'].';"';} 
else{$lImgbg='';}   
//get mail button image  background color 
if($pluginOptionsVal['csbwfs_mail_bg']!=''){ $mImgbg=' style="background:'.$pluginOptionsVal['csbwfs_mail_bg'].';"';} 
else{$mImgbg='';}   
//get google plus button image  background color 
if($pluginOptionsVal['csbwfs_gp_bg']!=''){ $gImgbg=' style="background:'.$pluginOptionsVal['csbwfs_gp_bg'].';"';} 
else{$gImgbg='';}  
//get pinterest button image   background color 
if($pluginOptionsVal['csbwfs_pin_bg']!=''){ $pImgbg=' style="background:'.$pluginOptionsVal['csbwfs_pin_bg'].';"';}
else{$pImgbg='';}  

//get youtube button image   background color 
if(isset($pluginOptionsVal['csbwfs_yt_bg']) && $pluginOptionsVal['csbwfs_yt_bg']!=''){ $ytImgbg=' style="background:'.$pluginOptionsVal['csbwfs_yt_bg'].';"';}else{$ytImgbg='';}   
//get reddit button image   background color 
if(isset($pluginOptionsVal['csbwfs_re_bg']) && $pluginOptionsVal['csbwfs_re_bg']!=''){ $reImgbg=' style="background:'.$pluginOptionsVal['csbwfs_re_bg'].';"';}else{$reImgbg='';}  
//get stumbleupon button image   background color 
if(isset($pluginOptionsVal['csbwfs_st_bg']) && $pluginOptionsVal['csbwfs_st_bg']!=''){ $stImgbg=' style="background:'.$pluginOptionsVal['csbwfs_st_bg'].';"';} else{$stImgbg='';}
     
/** Message */ 
if($pluginOptionsVal['csbwfs_show_btn']!=''){ $showbtn=$pluginOptionsVal['csbwfs_show_btn'];} 
   else{$showbtn='Show Buttons';}   
//get show/hide button message 
if($pluginOptionsVal['csbwfs_hide_btn']!=''){ $hidebtn=$pluginOptionsVal['csbwfs_hide_btn'];} 
   else{$hidebtn='Hide Buttons';}   
//get mail button message 
if($pluginOptionsVal['csbwfs_share_msg']!=''){ $sharemsg=$pluginOptionsVal['csbwfs_share_msg'];} 
   else{$sharemsg='Share This With Your Friends';}   

/** Check display Show/Hide button or not*/
if(isset($pluginOptionsVal['csbwfs_rmSHBtn']) && $pluginOptionsVal['csbwfs_rmSHBtn']!=''):
$isActiveHideShowBtn='yes';
else:
$isActiveHideShowBtn='no';
endif;
$flitingSidebarContent='<div id="csbwfs-delaydiv-newdata"><div class="csbwfs-social-widget-newdata" title="'.$sharemsg.'">';

if($isActiveHideShowBtn!='yes') :
//$flitingSidebarContent .= '<div class="csbwfs-show-newdata"><a href="javascript:" title="'.$showbtn.'" id="csbwfs-show-newdata"><img src="'.plugins_url('custom-share-buttons-with-floating-sidebar/images/'.$showImg).'" alt="'.$showbtn.'"></a></div>';
endif;

$flitingSidebarContent .= '<div id="csbwfs-social-inner-data">';

/** FB */
if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-fb" class="csbwfs-fb-newdata"><a href="javascript:" onclick="javascript:window.open(\'//www.facebook.com/sharer/sharer.php?u='.$shareurl.'\', \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;" target="_blank" title="'.$fImgAlt.'" '.$fImgbg.'><img src="'.$fImg.'" alt="'.$fImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/** TW */
if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-tw-newdata" class="csbwfs-tw-newdata"><a href="javascript:" onclick="window.open(\'//twitter.com/share?url='.$shareurl.'&text='.$ShareTitle.'\',\'_blank\',\'width=800,height=300\')" title="'.$tImgAlt.'" '.$tImgbg.'><img src="'.$tImg.'" alt="'.$tImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/** GP */
if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-gp-newdata" class="csbwfs-gp-newdata"><a href="javascript:"  onclick="javascript:window.open(\'//plus.google.com/share?url='.$shareurl.'\',\'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800\');return false;" title="'.$gImgAlt.'" '.$gImgbg.'><img src="'.$gImg.'" alt="'.$gImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/**  LI */
if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-li-newdata" class="csbwfs-li-newdata"><a href="javascript:" onclick="javascript:window.open(\'//www.linkedin.com/cws/share?mini=true&url='. $shareurl.'\',\'\',\'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800\');return false;" title="'.$lImgAlt.'" '.$lImgbg.'><img src="'.$lImg.'" alt="'.$lImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/** PIN */
if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-pin-newdata" class="csbwfs-pin-newdata"><a onclick="window.open(\'//pinterest.com/pin/create/button/?url='.$shareurl.'&amp;media='.$pinShareImg.'&amp;description='.$ShareTitle.' :'.$shareurl.'\',\'pinIt\',\'toolbar=0,status=0,width=800,height=500\');" href="javascript:void(0);" '.$pImgbg.' title="'.$pImgAlt.'"><img src="'.$pImg.'" alt="'.$pImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/** YT */	 	 
if(isset($pluginOptionsVal['csbwfs_ytpublishBtn']) && $pluginOptionsVal['csbwfs_ytpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-yt-newdata" class="csbwfs-yt-newdata"><a onclick="window.open(\''.$pluginOptionsVal['csbwfs_ytPath'].'\');" href="javascript:void(0);" '.$ytImgbg.' title="'.$ytImgAlt.'"><img src="'.$ytImg.'" alt="'.$ytImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/** Reddit */
if(isset($pluginOptionsVal['csbwfs_republishBtn']) && $pluginOptionsVal['csbwfs_republishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-re-newdata" class="csbwfs-re-newdata"><a onclick="window.open(\'//reddit.com/submit?url='.$shareurl.'&amp;title='.$ShareTitle.'\',\'Reddit\',\'toolbar=0,status=0,width=1000,height=800\');" href="javascript:void(0);" '.$reImgbg.' title="'.$reImgAlt.'"><img src="'.$reImg.'" alt="'.$reImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

/** Stumbleupon */
if(isset($pluginOptionsVal['csbwfs_stpublishBtn']) && $pluginOptionsVal['csbwfs_stpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-st-newdata" class="csbwfs-st-newdata"><a onclick="window.open(\'//www.stumbleupon.com/submit?url='.$shareurl.'&amp;title='.$ShareTitle.'\',\'Stumbleupon\',\'toolbar=0,status=0,width=1000,height=800\');"  href="javascript:void(0);" '.$stImgbg.' title="'.$stImgAlt.'"><img src="'. $stImg.'" alt="'.$stImgAlt.'" width="35" height="35" ></a></div></div>';
endif; 

/** Mail*/
if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
$flitingSidebarContent .='<div class="csbwfs-sbutton-newdata csbwfsbtns-newdata" style="width:30px;"><div id="csbwfs-ml-newdata" class="csbwfs-ml-newdata"><a href="mailto:'.$mailMsg.'" title="'.$mImgAlt.'" '.$mImgbg.' ><img src="'.$mImg.'" alt="'.$mImgAlt.'" width="35" height="35" ></a></div></div>';
endif;

$flitingSidebarContent .='</div>'; //End social-inner

if($isActiveHideShowBtn!='yes') :
//$flitingSidebarContent .='<div class="csbwfs-hide-newdata"><a href="javascript:" title="'.$hidebtn.'" id="csbwfs-hid-newdatae"><img src="'.plugins_url('custom-share-buttons-with-floating-sidebar/images/'.$hideImg).'" alt="'.$hidebtn.'"></a></div>';
endif;

$flitingSidebarContent .='</div></div>'; //End social-inner


                
          ?>  
            
            
		<a href="#">
			<img src="<?php bloginfo('template_directory')?>/images/share_property.jpg" alt=" " class="img-responsive">
			<div class="inn_share_deta"><?php  echo $flitingSidebarContent; ?></div>
		</a>
	</div>

</div>