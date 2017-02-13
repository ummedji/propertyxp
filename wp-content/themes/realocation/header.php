<?php
session_start();
//echo "<pre>";
//print_r($_SESSION);
//die;

if(isset($_GET['hf_property_header_location_filter'])){
	$_SESSION["parent_selected_location_id"] = $_GET['hf_property_header_location_filter'];
}

do_action('aviators_pre_render'); ?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Aviators, http://aviators.com">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">-->

    <?php wp_head(); ?>
	<?php
	//session_start();
	//unset($_SESSION["parent_selected_location_id"]);
	?>

    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
    <title><?php echo wp_title('|', FALSE, 'right'); ?></title>
    <?php if($ga = realocation_ga_get_tracking()): ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php print $ga['code']; ?>', '<?php print $ga['name']; ?>');
        ga('send', 'pageview');
    </script>
    <?php endif; ?>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/developer-icon.css">
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>-->
    <script>
    jQuery( document ).ready(function() {
    var availableTags = [
      "100",
      "500",
      "1000",
      "10000",
      "50000",
      "100000",
      "500000",
      "1000000",
      "5000000",
      "10000000",
      "50000000",
      "100000000",

    ];
	 jQuery( "#hydra-hf-property-maximum-price-filter-items-0-value" ).autocomplete({
	      source: availableTags
	    });

	  jQuery( "#hydra-hf-property-minimum-price-filter-items-0-value" ).autocomplete({
	      source: availableTags
	    });
	});
    </script>
<?php
	//$getcurrentcity = $_GET['hf_property_location_filter'];
	$getcurrentcity = $_GET['hf_property_header_location_filter'];
	$_GET['hf_property_location_filter'] = array();
	$_GET['hf_property_location_filter']['items'][0]['location'] = $getcurrentcity;
	//$getcurrentcity = $_GET['hf_property_location_filter']; //['items'][0]['location'];

	//unset($_SESSION["parent_selected_location_id"]);
	if(!empty($getcurrentcity))
	{
	$selcity =	get_term_by( 'id', $getcurrentcity, 'locations');

	$_SESSION["selected_city"] = $selcity->name;

	$parent_term = get_term( $getcurrentcity,'locations');

	$_SESSION["parent_selected_location_id"] = $parent_term->parent;

	//echo $_SESSION["selected_city"];die;

	//$selcity = get_terms('locations', $getcurrentcity);
	?>
	<script>
		jQuery(document).ready(function() {
			//alert("111");
			jQuery('.as_header_bar .container > button').html('Change City : '+'<?php echo $selcity->name; ?>');

		});
	</script>
	<?php }else{

		if(isset($_SESSION["selected_city1"]) && $_SESSION["selected_city1"] != ""){
			$selcity->name = $_SESSION["selected_city1"];

			?>
			<script>
				jQuery(document).ready(function() {
					//alert("222");
					jQuery('.as_header_bar .container > button').html('Change City : '+'<?php echo $selcity->name; ?>');

					jQuery('select#lunchBegins').val('<?php echo $_SESSION["selected_city_id1"]; ?>');
					//console.log('SESSION ID: <?php echo $_SESSION["selected_city_id1"]; ?>');
				});
			</script>
			<?php
		}
		?>
		<?php
	} ?>


<script type="text/javascript">
	jQuery(document).ready(function (){

		jQuery('.custom-menu-button').click(function(){
			jQuery('.custom-menu-content').addClass('custom-menu-active').removeClass('custom-menu-deactive');
			jQuery('.custom-menu-button').addClass('custom-menu-deactive').removeClass('custom-menu-active');
		});

		jQuery('.custom-menu-close').click(function(){
			jQuery('.custom-menu-content').addClass('custom-menu-deactive').removeClass('custom-menu-active');
			jQuery('.custom-menu-button').addClass('custom-menu-active').removeClass('custom-menu-deactive');
		});

		setTimeout(function(){

		 var html_data = "";

		  jQuery("div#hidden_ammineties div.inner ul li").each(function( index, element){
			jQuery("ul.amenities-options").empty();
			jQuery(this).find("i").html();



			if(jQuery(this).find("i").hasClass("fa-ban")){

				var regex = /(<([^>]+)>)/ig
				var result_data = jQuery.trim(jQuery(this).html().replace(regex, "")).toUpperCase();

				var result = jQuery.trim(jQuery(this).html().replace(regex, "")).toUpperCase();

				if(result.indexOf(' ') >= 0){

					result = result.replace(/\s+/g, '-');

				}
				html_data += '<li class="single-amenity"><div class="fade"><img src="<?php bloginfo('template_directory')?>/images/'+result+'.png" ></div><div class="fade-text text amenities_cn">'+result_data+'</div></li>';

			}
			else{
				var regex = /(<([^>]+)>)/ig


				var result_data = jQuery.trim(jQuery(this).html().replace(regex, "")).toUpperCase();

				var result = jQuery.trim(jQuery(this).html().replace(regex, "")).toUpperCase();

				if(result.indexOf(' ') >= 0){

					result = result.replace(/\s+/g, '-');

				}


				html_data += '<li class="single-amenity"><div class=""><img src="<?php bloginfo('template_directory')?>/images/'+result+'.png" ></div><div class=" text amenities_cn">'+result_data+'</div></li>';


			}


		  });

		  jQuery("ul.amenities-options").append(html_data);

		}, 3000);

		//var price = jQuery("div.hf-property-price div.field-value").html();

		jQuery("div.hf-property-price div.field-value").each(function(index,element){

			var price = jQuery(this).html();

			if(price != ""){
				jQuery(this).html('&nbsp;&nbsp;<i class="fa fa-inr fa-1x"></i>&nbsp;'+price);

			}
			//alert(index+"===="+element);

		});


		jQuery("div.developer-menu ul li a").on("click",function(){

			//alert("INNN");
		//	jQuery(this).dblclick();
		//	jQuery("div.developer-menu ul li a").removeClass("active");
			//jQuery(this).addClass("active");

		});

/*

		jQuery(window).scroll(function(){

			//console.log("SCROLL");
			var footer_offset = jQuery("div#footer-wrapper").offset().top;
			var left_side_bar = jQuery("div.developer-menu").offset().top;

			var diff = parseInt(footer_offset)-600;
			var data =  parseInt(footer_offset)-1100;



			console.log(jQuery("div.developer-menu").offset().top +"===="+ diff+"===="+footer_offset+"===="+data+"===");

			if(jQuery("div.developer-menu").offset().top >= diff){

				jQuery("div.developer-menu").css({ "top":data, "position": "absolute","left":"-90px" });


			}
			else{

				jQuery("div.developer-menu").css({ "top":"0px", "position": "fixed","left":"0px" });
			}


		});

*/


		setTimeout(function(){

		//	var home_price = commaSeparateNumber(jQuery.trim(jQuery("form#mortgage input#hydra-home-price").val()));
			var x = jQuery("form#mortgage input#hydra-home-price").val();

			if(jQuery("form#mortgage input#hydra-home-price").length > 0){
				jQuery("form#mortgage input#hydra-home-price").val(x.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			}

			var y = jQuery("form#mortgage input#hydra-down-price").val();

			if(jQuery("form#mortgage input#hydra-down-price").length > 0){
				jQuery("form#mortgage input#hydra-down-price").val(y.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
			}

			//var down_price = commaSeparateNumber(jQuery.trim(jQuery("form#mortgage input#hydra-down-price").val()));


			jQuery('table tbody td.item').each(function(){

				var data = jQuery.trim(jQuery(this).html()).replace('Rs.','');

				data = commaSeparateNumber(data);
				var final_data = "Rs."+data;
				jQuery(this).html(final_data);

			});

			jQuery('.area_data').each(function(){

				var data = jQuery.trim(jQuery(this).html());

				var isnum = /^\d+$/.test(data);
				if(isnum){
					data = commaSeparateNumber(data);
				}

				var final_data = data;
				jQuery(this).html(final_data);
			});

			var i = 1;

			jQuery('div.summary').each(function(){

				var data = commaSeparateNumber(jQuery.trim(jQuery(this).text()).match(/\d+/));
				var html_data = "";
				if(i == 1){
					html_data = "<strong>Total per Month:</strong>Rs."
				}
				else if(i == 2){
					html_data = "<strong>Total per Year:</strong>Rs."
				}else{
					html_data = "<strong>Total:</strong>Rs."
				}
				var final_data = html_data+data;
				jQuery(this).html(final_data);

				i++;
			});




			var url_data = window.location.href;
			var str1 = "hf_property_header_location_filter";

			var header_search_data = '<?php echo $_SESSION["parent_selected_location_id"]; ?>';

			//	alert(header_search_data);

			if(jQuery("select#hydra-hf-property-location-filter-items-0-country").length > 0) {

				if(url_data.indexOf(str1) != -1){
					//alert("INNN");

					//alert(header_search_data);
					jQuery("select#hydra-hf-property-location-filter-items-0-country").val(<?php echo $_SESSION["parent_selected_location_id"]; ?>);
				}
				else{
					jQuery("select#hydra-hf-property-location-filter-items-0-country").val(<?php echo $_SESSION["selected_cou_id1"]; ?>);
				}

			}

			if(jQuery("select#hydra-hf-property-location-filter-1-items-0-country").length > 0) {

				if(header_search_data != ""){
					jQuery("select#hydra-hf-property-location-filter-1-items-0-country").val(<?php echo $_SESSION["parent_selected_location_id"]; ?>);
				}else{
					jQuery("select#hydra-hf-property-location-filter-1-items-0-country").val(<?php echo $_SESSION["selected_cou_id1"]; ?>);
				}
			}

			//if(url_data.indexOf(str1) != -1){
			if(header_search_data != ""){
				location_data('<?php echo $_SESSION["parent_selected_location_id"]; ?>','city');
			}
			else{
				location_data('<?php echo $_SESSION["selected_cou_id1"]; ?>','city');
			}

			location_data('<?php echo $_SESSION["selected_city_id1"]; ?>','sublocation');




		}, 2000);



	});
	
	function location_data(locationdata,datatype){

		//alert(locationdata+"=="+datatype);

		jQuery.ajax({

			type:"POST",
			url: "<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php", // our PHP handler file
			data: {action: "get_location_data",location_data: locationdata,type_data:datatype},
			success:function(results){
				if(datatype == "city"){

					if(jQuery("select#hydra-hf-property-location-filter-items-0-location").length > 0) {
						jQuery("select#hydra-hf-property-location-filter-items-0-location").html(results);
						jQuery("select#hydra-hf-property-location-filter-items-0-location").removeAttr("disabled");
					}

					if(jQuery("select#hydra-hf-property-location-filter-1-items-0-location").length > 0) {
						jQuery("select#hydra-hf-property-location-filter-1-items-0-location").html(results);
						jQuery("select#hydra-hf-property-location-filter-1-items-0-location").removeAttr("disabled");
					}

				}
				if(datatype == "sublocation"){

					if(jQuery("select#hydra-hf-property-location-filter-items-0-sublocation").length > 0) {
						jQuery("select#hydra-hf-property-location-filter-items-0-sublocation").html(results);
						jQuery("select#hydra-hf-property-location-filter-items-0-sublocation").removeAttr("disabled");
					}


					if(jQuery("select#hydra-hf-property-location-filter-1-items-0-sublocation").length > 0) {
						jQuery("select#hydra-hf-property-location-filter-1-items-0-sublocation").html(results);
						jQuery("select#hydra-hf-property-location-filter-1-items-0-sublocation").removeAttr("disabled");
					}
				}
			}

		});

	}

	function commaSeparateNumber(val){
		/*while (/(\d+)(\d{3})/.test(val.toString())){
			val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
		}
		return val;*/

		x=val.toString();
		var afterPoint = '';
		if(x.indexOf('.') > 0)
			afterPoint = x.substring(x.indexOf('.'),x.length);
		x = Math.floor(x);
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
			lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

		return res;
	}

</script>

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/jquery.mCustomScrollbar.css" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/template/template-common.CSS" />

	<script type='text/javascript' src="<?php bloginfo('template_directory'); ?>/assets/js/jquery.mCustomScrollbar.concat.min.js" ></script>
<?php
	//wp_register_script( 'googlemaps3', 'http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true', array('jquery'), '', true);

?>

	<!--<link rel="stylesheet" href="<?php /*bloginfo('template_directory'); */?>/assets/css/bootstrap-select.css" />
	<script type='text/javascript' src="<?php /*bloginfo('template_directory'); */?>/assets/js/bootstrap-select.js" ></script>-->

	<script>
		(function($){
			$(window).load(function(){

				$("#content-5").mCustomScrollbar({
					axis:"x",
					theme:"dark-thin",
					autoExpandScrollbar:true,
					advanced:{autoExpandHorizontalScroll:true}
				});

			});
		})(jQuery);
	</script>
  <?php
  $selected_template = getHydrameta(get_the_ID(),'hf_property_bselect_template');
 $selected_template_value = get_field("select_template"); 
 //$selected_template_value = trim($selected_template); 
 
     if($selected_template_value == 'developer'){
  ?>
         <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/template/template-V1.CSS" />
<?php
     }
     elseif($selected_template_value == 'TemplateV2'){

?>
         <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/template/template-V2.CSS" />
<?php
     }
	elseif($selected_template_value == 'TemplateV3'){
?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/css/template/template-V3.CSS" />
<?php } ?>

	<?php
	/*wp_enqueue_script('googlemaps3');
	wp_enqueue_script('clusterer');
	wp_enqueue_script('infobox');*/
	?>

</head>

<body <?php body_class(); ?> >
<!--<div class="im-interested">
	<div class="icon icon-message-filled"></div>
	<?php /*echo do_shortcode('[AnythingPopup id="4"]'); */?>

</div>-->
	<!--
<div class="custom-menu">
		<a class="custom-menu-button custom-menu-active fa fa-bars " href="##">Menu</a>
		<div class="custom-menu-content custom-menu-deactive">
			<a class="custom-menu-close" href="##">X</a>
			<?php echo do_shortcode('[custom_menu]');?>
		</div>
</div> -->


<?php if(get_theme_mod('general_enable_customizer', 1)): ?>
    <?php aviators_get_template('template', 'palette'); ?>
<?php endif; ?>

<div id="wrapper">
    <div id="header-wrapper">
        <div id="header">
            <div id="header-inner">
                <?php if ( get_theme_mod('general_topbar_is_enabled') ) : ?>
                    <?php require_once 'templates/header-bar.php'; ?>
                <?php endif; ?>

                <?php require_once 'templates/header-top.php'; ?>

                <?php
	                $person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid'));


                	if($person_field == 'Developer') {

                	} else {
                		//require_once 'templates/header-navigation.php';
			}
				?>
            </div><!-- /.header-inner -->
        </div><!-- /#header -->
    </div><!-- /#header-wrapper -->

    <div id="main-wrapper">
        <div id="main">
        <?php if (is_singular(array('property'))) {

        		//if($person_field == 'Developer') {

                        /*
                        * NEW TEMPLATE APPROACH CODE ADDED
                        * if statement change on the basics of selected templated value earlier it dependes on person field.
                        */

                         $selected_template_value = get_field("select_template");
                        if($selected_template_value == 'developer' || $selected_template_value == 'TemplateV2' || $selected_template_value == 'TemplateV3'){

        			//the_post_thumbnail(array(1500,500), array( 'class' => 'property-main-image center' ));
        			//$sa = get_field('get_field');
        			$sa = getHydrameta(get_the_ID(),'hf_property_slider_alias');
        			if($sa != '') {
						?>
						<div class="as_inn_slider">
						 <?php  putRevSlider($sa); ?>
							</div>
						<?php
					}

						}
				 if($selected_template_value == 'developer'){
        		?>
        		<div class="tamp_title">
					<div class="container">
						<div class="row">
							<div class="col-md-4 col-sm-4"><h2 class="pro_tl"><?php the_title(); ?></h2></div>
							<div class="col-md-4 col-sm-4 text-center">
								<div class="address_tag"><?php print hydra_render_field(get_the_ID(), 'location', 'detail'); ?>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 top_tena_price">
								<div class="price_right"><i class="fa fa-inr fa-1x"></i><?php $price = getHydrameta(get_the_ID(), 'hf_property_starting_price'); 
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
				echo $fraction." ".$ext;//print hydra_render_field(get_the_ID(), 'price', 'detail'); ?></div>
							</div>
						</div>
						<!-- /.header-title -->
					</div>
				</div>

							<!--<div class="row">
								<div class="col-md-12" >
									<h1 class="property-detail-title aaa center developer-property-title"><?php /*the_title(); */?></h1>

									<div class="property-detail-subtitle center developer-prperty-price"><?php /*print hydra_render_field(get_the_ID(), 'location', 'detail'); */?>
										<?php /*print hydra_render_field(get_the_ID(), 'price', 'detail'); */?>
									</div>
								</div>

							</div>-->
        		<?php
        		}
        	} ?>
            <div id="main-inner">
                <?php dynamic_sidebar( 'top-fullwidth' ); ?>

                <?php if (is_singular(array('property'))){


    				//if($person_field != 'Developer') {
                    /*
                        * NEW TEMPLATE APPROACH CODE ADDED
                        * if statement change on the basics of selected templated value earlier it dependes on person field.
                        */

                    $selected_template_value = get_field("select_template");
                    if($selected_template_value != 'developer' && $selected_template_value != 'TemplateV2' && $selected_template_value != 'TemplateV3'){

					//	echo "asasas";exit;
                //    wp_enqueue_script('googlemaps3');
                    wp_enqueue_script('clusterer');
                    wp_enqueue_script('infobox');
                    ?>
                    <?php $mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE);
						//echo "<pre>";
						//print_r($mapPosition);
						//die;


						//$mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE);
						//$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');								$longitude = $mapPosition['items'][0]['longitude'];//get_field('longitude');

						//echo do_shortcode('[map_neighbourhood location="'.$latitude.','.$longitude.'"]');


						?>
                    <?php if (isset($mapPosition['items'][0])): ?>
                        <?php if (!empty($mapPosition['items'][0]['latitude']) && !empty($mapPosition['items'][0]['longitude'])) : ?>
                            <div class="temp3map">
								<div id="map-property">
                            </div><!-- /#map-property -->
							</div>
                        <?php endif;
                    	 endif;

                    	//	add_action('aviators_footer_map_detail', 'aviators_properties_map_detail');
						}
                	  	elseif($selected_template_value == 'developer') {

						?>
						<div class="developer-menu top-dev-menu df">
							<div class="container">
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
									</div>
							</div>
							<!--<div class="developer-menu-links as_developer-menu-links">
							<a href="#details" >
							<div class="icon-details icon-small"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/PROJECT.png">
								<span class="dev-details"></span>
								<div class="title">DETAILS</div>
							</a>
							<a  href="#flats">
							<div class="icon-building-filled icon-small"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/CATEGORY.png">
								<span class="dev-category"></span>
								<div class="title">CATAGORY</div>
							</a>
							<a href="#amenities" >
							 <div class="icon-amenities-filled icon-small"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/AMENITIES.png">
								<span class="dev-amenities"></span>
								<div class="title">AMENITIES</div>
							</a>
							<a  href="#map" >
							<div class="icon-location-filled icon-small"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/LOCATION.png">
								<span class="dev-location"></span>
								<div class="title">LOCATION</div>
							</a>
							<a  href="#flats" >
							<div class="icon-plane-filled icon-small"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/360.png">
								<span class="dev-360"></span>
								<div class="title">360*</div>
							</a>
							<a  href="#gallery" >
							<div class="icon-gallery-filled icon-small"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/GALLERY.png">
								<span class="dev-gallery"></span>
								<div class="title">GALLERY</div>
							</a>
							<a  href="#line_chart" >
							<div class="icon-small icon-trends-filled"></div>
								 <img src="<?php /*bloginfo('template_directory'); */?>/images/MARKET.png">
								<span class="dev-market"></span>
								<div class="title">MARKET</div>
							</a>
							</div>-->

							<!--<div class="im-interested" style="border:none !important; border-color:none !important;"> -->


							<div class="im-interested" style="border:none !important; border-color:none !important;">
								<?php echo do_shortcode('[AnythingPopup id="4"]'); ?>
							</div>

							<div class="interested_cl">
								<div class="in_int_btn">
									<span class="text_of_ints"><i class="fa fa-envelope"></i><a href="javascript:AnythingPopup_OpenForm('AnythingPopup_BoxContainer4','AnythingPopup_BoxContainerBody4','AnythingPopup_BoxContainerFooter4','800','550');">I'M INTERESTED</a></span>
								</div>
							</div>


							<!--div class="left_shar">
								<div class="inn_share_btn">
									<div class="share_txt"><i class="fa fa-share-alt" aria-hidden="true"></i> <span id="share_property">share Property</span></div>


								</div>



							</div-->

						</div>
						<?php
					  	}

                	}?>

				<?php

				$page_url =  $_SERVER["REQUEST_URI"];
				//$page_name_data = explode("/",$page_url);

				//$page_name = $page_name_data[count($page_name_data)-2];

				if (strpos($page_url, 'map-mode') !== false) {
				//if($page_name == "map-mode"){
				?>
					<?php
					if($_GET['prop_id']) {
						echo '<div class="row">
					<div class="col-md-12">
	        			<div class="center section-title"><h2><span>'.get_the_title( $_GET['prop_id'] ).'</span></h2></div>
         			</div>

					<div class="col-sm-12">';
						$mapPosition = get_post_meta($_GET['prop_id'], 'hf_property_map', TRUE);
						//print_r($mapPosition);
						$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');
						$longitude = $mapPosition['items'][0]['longitude'];//get_field('longitude');

						// echo "here";die;

						echo do_shortcode('[map_neighbourhood location="'.$latitude.','.$longitude.'"]');
						echo '</div></div>';
					} else {
						?>
						<?php dynamic_sidebar( 'mapmode-fullwidth' );?>
					<?php } ?>
				<?php
				}
				?>


                <div class="container">
                	<?php 	echo do_shortcode('[AnythingPopup id="1"]');
                		echo do_shortcode('[AnythingPopup id="2"]');
                		echo do_shortcode('[AnythingPopup id="3"]');?>
                    <?php dynamic_sidebar( 'top' ); ?>

                    <?php echo aviators_render_messages(); ?>

                    <div class="block-content block-content-small-padding as-content-pr">
                        <div class="block-content-inner <?php if($person_field == 'Developer') { ?>developers-all-content<?php } ?>">
                            <div class="row">