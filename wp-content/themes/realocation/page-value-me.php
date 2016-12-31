<?php
/**
 * Template Name: Value Me
 */
?>
<?php get_header(); ?>

<div class="<?php if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif; ?>">
    <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>
   <?php

global $wpdb;
$states = get_terms('locations', array('parent' => 0, 'hide_empty' => false));

$url = get_bloginfo('url');
?>

<script type="text/javascript">
	jQuery(function(){
 
  
		jQuery('#state').change(function(){	
			jQuery("#LoadingImage").show();		
			var data = {
				action: 'search_location_by_city',
				state_id: jQuery('#state').val()
			};

			
			var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#vm_location').html(response);
				jQuery("#LoadingImage").hide();
				
			});
		});

		

	});

   function calculate_price()
    {

		var state_data = jQuery("select#state").val();
		var location_data = jQuery("select#vm_location").val();
	if(state_data != "" && location_data != ""){

		var data = {
			action: 'get_property_average_value',
			state_id: jQuery('#state').val(),
			city_id: jQuery('#vm_location').val()
		};
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		jQuery.post(ajaxurl, data, function(response) {
			console.log(response);
			jQuery('.property_val').html(response);
			/*var results = JSON.parse(response);
			 //var res = JSON.stringify(results);
			 //jQuery('#res').html(res);

			 if(results['wpcf-prise'] != 'undefined')
			 {
			 var floor = $('#floor').val();
			 var floor_m = 'wpcf-floor-'+floor;
			 var prise_val = parseInt(results['wpcf-prise']);
			 var area_val = parseInt($('#area').val());
			 var floor_val = parseInt(results[floor_m]);
			 var full_f = $('.full_f:checked').val();

			 if(full_f=="yes"){ var furnished_val = parseInt(results['wpcf-furnished']); }
			 else{ var furnished_val = 0;}
			 var property_value = (area_val*prise_val);

			 var property_value = property_value+furnished_val+floor_val;

			 var amn_val = 0;
			 $('.shortchecked:checked').each(function(){
			 var amn_i = 'wpcf-'+$(this).val();
			 amn_i = parseInt(results[amn_i]);
			 console.log(amn_i);
			 if(!isNaN(amn_i)){
			 amn_val += amn_i;
			 }
			 });

			 var property_value = property_value+amn_val;
			 var property_value = formatNumber(property_value);
			 $('.property_val').text(property_value+ ' Rs.');
			 if(property_value==''){ $('.error').text('Please select proper data.'); }
			 else{ $('.property_val').text(property_value+ ' Rs.'); }

			 }*/
		});

	}else{
		if(state_data == ""){
			jQuery( "select#state" ).after("<span class='error'>Please select state.</span>");
		}

		if(location_data == ""){
			jQuery( "select#vm_location" ).after("<span class='error'>Please select location.</span>");
		}

		setTimeout(function(){
			jQuery("span.error").remove();
		}, 4000);

		return false;

	}

    }
</script>
<script>
	jQuery(function() {
	jQuery( "#slider-range-min" ).slider({
	  range: "min",
	  value: 10,
	  min: 0,
	  max: 100,
	  slide: function( event, ui ) {
		  	    jQuery( "#floor" ).val( "" + ui.value );
	  }
	});
	jQuery( "#floor" ).val( "" + jQuery( "#slider-range-min" ).slider( "value" ) );

		jQuery("input#floor").on("focusout",function(){
			if(jQuery( "#floor" ).val() > 100){
				jQuery( "#floor" ).val("");

				jQuery( "#floor" ).after("<span class='error'>Please enter value with in range of 100.</span>");
				setTimeout(function(){
					jQuery("span.error").remove();
				}, 2000);
			}
		});

	});

	jQuery(function() {
	jQuery( "#slider-range-area" ).slider({
	  range: "min",
	  value: 4000,
	  min: 1,
	  max: 10000,
	  slide: function( event, ui ) {
	    jQuery( "#area" ).val( "" + ui.value );
	  }
	});
		jQuery( "#area" ).val( "" + jQuery( "#slider-range-area" ).slider( "value" ) );

		jQuery("input#area").on("focusout",function(){
			if(jQuery( "#area" ).val() > 100){
				jQuery( "#area" ).val("");

				jQuery( "#area" ).after("<span class='error'>Please enter value with in range of 10000.</span>");
				setTimeout(function(){
					jQuery("span.error").remove();
				}, 2000);
			}
		});


	});
</script>

<style type="text/css">
    .error{
    color:red;
    }
    /*#value_me {
    top: -450px;
    position: relative;
    float: left;
    width: 524px;
    margin: 0 10px 20px 0;
    }*/
    .value_me_inner {
    background: #fcfcfc;
    border: 1px solid #E0E0E0;
    position: relative;
    padding: 10px;
    margin: 3px 0 20px 0;
    font-size: 16px;
    }
    .valueme-ele{
    	width: 100%;
    }
    .vm_ele{
    	padding: 10px 0px;
    }
    .vm_ele_sel{
    	border: 1px dashed #ccc;
    	margin: 10px 0px;
    	padding: 10px 0px 10px 5px;
    
    }
    .vm_small{
    	font-size: 11px;
    }
    
    .loader {
        
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('<?php echo $url; ?>/wp-content/themes/realtorpress/images/ajax-loader.gif') 
                    50% 50% 
                    no-repeat;
    }
      .loading-text { 
        text-align:center;
         position: absolute;
         top: 60%;
         width:100%;
         margin: 0px auto;
      }
      .value_me_toon{
        position: relative;
        z-index: 100;
        top: 400px;
        left: 300px;
    }
    .searchslider{
        width:232px;
    }
</style>

<div class="loader" id="LoadingImage" style="display: none">	
<div class="loading-text">Please wait...</div>
</div>

<div class="itembox">
	<h2 class="title"><?php the_title(); ?></h2>	<div class="col-md-12">				<div class="col-md-2"></div>				<div class="col-md-8 center">				<img style="margin-bottom:20px" src="http://www.propertyxp.com/wp-content/themes/realocation/images/VALUE.png" alt="">				</div>				<div class="col-md-2"></div>			</div>
		<div class="itemboxinner">
            <div id="res"></div>
			<div id="value_me">
                <!--<img class="value_me_toon" src="<?php echo get_bloginfo('url');?>/wp-content/uploads/05.png" alt="" />-->
				<fieldset class="value_me_inner">
                
				<form name="location_form" id="location_form">
					<div class="f_half vm_ele" id="field_title_wrapper">
						<label>State <span class="required">*</span></label>
						<select id="state" class="valueme-ele">
							<option value="">Select</option>
                           
							<?php
							if($states)
							{
								foreach($states as $state_key => $state_value)
								{
								?>
									<option value="<?php echo $state_value->term_id; ?>"><?php echo $state_value->name; ?></option>
									<?php
								}
							}
							?>
						</select>
                        

                         <p id="error3" style="color:#F00"></p>
					</div>

					<div class="f_half vm_ele" id="field_title_wrapper">
						<label>Location <span class="required">*</span></label>
						<select id="vm_location" name="vm_location" class="valueme-ele">
							<option value="">Select</option>
						</select>
                        <p id="error4" style="color:#F00"></p>
					</div>
				

					<div class="full vm_ele vm_ele_sel" id="field_title_wrapper">
						<label>You Reside/Flat on floor no.: </label>
						<span class="vm_small">Floor </span><input type="text" id="floor" name="floor"/>
						<div id="slider-range-min" class="searchslider"></div>
					</div>

					<div class="full vm_ele vm_ele_sel" id="field_title_wrapper">
						<label>Your Property area </label>
						<span class="vm_small">Sq.Ft</span> <input type="text" name="area" id="area"/>
						<div id="slider-range-area" class="searchslider"></div>
					</div>
                    
                    <div class="full vm_ele vm_ele_sel" id="field_title_wrapper">
    					<label>Is your Reside/Flat fully furnished ?</label>
						<label><input type="radio" name="full_f" class="full_f" value="yes" checked="checked"> Yes</label>
                        <label><input type="radio" name="full_f" class="full_f" value="no">No</label>
					</div>
					

					<div class="full vm_ele clearfix box"><label>Other Facilities</label>
    					<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][1]" class="shortchecked"  value="amn-1"> Garden</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][2]" class="shortchecked"  value="amn-2"> Swimming Pool</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][3]" class="shortchecked"  value="amn-3"> Play Area</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][4]" class="shortchecked"  value="amn-4"> Health Facilities</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][5]" class="shortchecked"  value="amn-5"> 24Hr Backup</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][6]" class="shortchecked"  value="amn-6"> Maintenance Staff</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][7]" class="shortchecked"  value="amn-7"> Security</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][8]" class="shortchecked"  value="amn-8"> Intercom</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][9]" class="shortchecked"  value="amn-9"> Club House</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][10]" class="shortchecked"  value="amn-10"> Rain Water Harvesting</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][11]" class="shortchecked"  value="amn-11"> Wifi</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][12]" class="shortchecked"  value="amn-12"> Cafeteria</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][13]" class="shortchecked"  value="amn-13"> Broadband Internet</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][14]" class="shortchecked"  value="amn-14"> Library</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][15]" class="shortchecked"  value="amn-15"> Tennis Court</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][16]" class="shortchecked"  value="amn-16"> Badminton Court</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][17]" class="shortchecked"  value="amn-17"> Gymnasium</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][18]" class="shortchecked"  value="amn-18"> Indoor Games</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][19]" class="shortchecked"  value="amn-19"> Basket Ball Court</span>
						<span class="shortcheckedwrap"><input type="checkbox" name="custom[9][value][20]" class="shortchecked"  value="amn-20"> Community Hall</span>
						<br><small></small><input type="hidden" name="custom[9][name]" value="other_facilities">
						<input type="hidden" name="custom[9][type]" value="check">
					</div>
					
					<div class="enditembox inner" style="overflow:hidden;">
				    	<input type="button" value="Generate" name="submit" onclick="javascript:calculate_price(); return false;"  id="submitMe" class="button green left">
				    </div>
                    <div class="prop_val">
                        <p>Your property estimated valuation: </p>
    			    	<h1 class="property_val prop_val-aa"></h1>
                        <p class="error"></p>
				    </div>
					
				</form>
				</fieldset> 
			</div>
		</div>
</div>


    <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>
</div><!-- /#main -->

<?php if (is_active_sidebar('sidebar-1')) : ?>
    <div class="sidebar col-md-3 col-sm-3">
        <?php get_sidebar('sidebar-1'); ?>
    </div><!-- /#sidebar -->
<?php endif; ?>

<?php get_footer(); ?>