<?php 
/*
Plugin Name: Layero Google Map Neighbourhood Plugin
Description: Easiest way to find near by places using Address on Google Map. Plugin based on latest google api version.
Author: Layero
Version: 1.0
Author URI: http://layero.com/
*/

add_shortcode('map_neighbourhood','wgmnp_show_nearbyplaces_in_map');
add_action('admin_head', 'wgmnp_head');
add_action( 'admin_menu','wgmnp_admin_menu' );
/*
 * Adding the admin menu for neighbourhood map settings
 */
function wgmnp_admin_menu()
{
 global $wpdb;	
 add_menu_page('Map Settings', __('Map Settings','google-map-neighbourhood'), 'manage_options','google_map_settings', 'google_map_neighbourhood', wgmnp_get_plugin_url()."/images/map-icon.png");

}	
/*
 * Displaying map and the neighbourhood.
 */
function wgmnp_show_nearbyplaces_in_map($atts){

	$wgmnp_location = $atts['location'];
	$wgmnp_settings = get_option("WGMNP_MAP_SETTINGS");
	$wgmnp_mapwidth=(isset($wgmnp_settings['wgmnp_mapwidth'])&&(strlen($wgmnp_settings['wgmnp_mapwidth'])>0) )?$wgmnp_settings['wgmnp_mapwidth']:900;
  $wgmnp_mapheight=(isset($wgmnp_settings['wgmnp_mapheight'])&&(strlen($wgmnp_settings['wgmnp_mapheight'])>0) )?$wgmnp_settings['wgmnp_mapheight']:400;
	$wgmnp_placetypes = array();
	$wgmnp_placelabels = array();
	if ($wgmnp_settings['wgmnp_mapplacetypes_airport'] == "yes") { $wgmnp_placetypes[] = "airport"; $wgmnp_placelabels[] = "Airport"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_night_club'] == "yes") { $wgmnp_placetypes[] = "night_club"; $wgmnp_placelabels[] = "Night Club"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_art_gallery'] == "yes") { $wgmnp_placetypes[] = "art_gallery"; $wgmnp_placelabels[] = "Art Gallery"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_park'] == "yes") { $wgmnp_placetypes[] = "park"; $wgmnp_placelabels[] = "Park"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_parking'] == "yes") { $wgmnp_placetypes[] = "parking"; $wgmnp_placelabels[] = "Parking"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_bar'] == "yes") { $wgmnp_placetypes[] = "bar"; $wgmnp_placelabels[] = "Bar"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_bus_station'] == "yes") { $wgmnp_placetypes[] = "bus_station"; $wgmnp_placelabels[] = "Bus Station"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_restaurant'] == "yes") { $wgmnp_placetypes[] = "restaurant"; $wgmnp_placelabels[] = "Resturants"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_car_rental'] == "yes") { $wgmnp_placetypes[] = "car_rental"; $wgmnp_placelabels[] = "Car For Rent"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_hospital'] == "yes") { $wgmnp_placetypes[] = "hospital"; $wgmnp_placelabels[] = "Hospital"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_school'] == "yes") { $wgmnp_placetypes[] = "school"; $wgmnp_placelabels[] = "School"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_shopping_mall'] == "yes") { $wgmnp_placetypes[] = "shopping_mall"; $wgmnp_placelabels[] = "Shopping Mall"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_subway_station'] == "yes") { $wgmnp_placetypes[] = "subway_station"; $wgmnp_placelabels[] = "Subway Station"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_attractions'] == "yes") { $wgmnp_placetypes[] = "attractions"; $wgmnp_placelabels[] = "Attractions"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_resorts'] == "yes") { $wgmnp_placetypes[] = "resorts"; $wgmnp_placelabels[] = "Resorts"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_homestay'] == "yes") { $wgmnp_placetypes[] = "homestay"; $wgmnp_placelabels[] = "Homestay"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_grocery_or_supermarket'] == "yes") { $wgmnp_placetypes[] = "grocery_or_supermarket"; $wgmnp_placelabels[] = "Grocery Or Supermarket"; }
	?>
	<script type="text/javascript">
  	 	var map, places, iw;
  		var markers = [];
  		var searchTimeout;
  		var centerMarker;
  		var autocomplete;
  		var hostnameRegexp = new RegExp('^https?://.+?/');
  		function initialize() {
    		var myLatlng = new google.maps.LatLng(<?php echo $wgmnp_location ?>);
    		var myOptions = {
      			zoom: 14,
      			center: myLatlng,
            streetViewControl:false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
    		}
    	map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

/////////////////////Customize ///////////////
<?php if(!is_page('map-mode')) { ?>
var citymap = {};
<?php $mapPosition = get_post_meta(get_the_ID(), 'hf_property_map', TRUE);
	    	$latitude = $mapPosition['items'][0]['latitude'];//get_field('latitude');
	    	$longitude = $mapPosition['items'][0]['longitude'];
	    	
	    	?>
citymap['Ahmedabad'] = {
  center: new google.maps.LatLng(<?php echo $latitude?>, <?php echo $longitude?>),
		  population: 250
  
};


	var cityCircle;

    var populationOptions = {
      strokeColor: '#FF3401',
      strokeOpacity: 0.8,
      strokeWeight: 0.5,
      fillColor: '#FF3401',
      fillOpacity: 0.1,
      map: map,
      center: citymap['Ahmedabad'].center,
      radius: Math.sqrt(citymap['Ahmedabad'].population) * 100
    };
    // Add the circle for this city to the map.
    cityCircle = new google.maps.Circle(populationOptions);
    //console.log(cityCircle);
    
 <?php } ?>   
///////////////////////////////////////
        	
    	var obj= document.getElementById('map_canvas');
		//obj.style.width= "<?php //echo $wgmnp_mapwidth-240 ?>px";  //Original
		obj.style.width= "<?php echo $wgmnp_mapwidth?>px";
		obj.style.height= "<?php echo $wgmnp_mapheight ?>px";
		document.getElementById('map-content').style.width= "<?php echo $wgmnp_mapwidth ?>px";
		document.getElementById('map-content').style.height= "<?php echo $wgmnp_mapheight ?>px";
		document.getElementById('listing').style.height= "<?php echo $wgmnp_mapheight ?>px";
		document.getElementById('controls').style.width= "<?php echo $wgmnp_mapwidth ?>px";
   		places = new google.maps.places.PlacesService(map);
   	    google.maps.event.addListener(map, 'tilesloaded', tilesLoaded);
    
    	var typeSelect = document.getElementById('type');
    	typeSelect.onchange = function() {
      	search();
    	};
    	
  	}

  	function tilesLoaded() {
    search();
    google.maps.event.clearListeners(map, 'tilesloaded');
   
  	}

  	function search() {
    clearResults();
    clearMarkers();

    if (searchTimeout) {
      window.clearTimeout(searchTimeout);
    }
    searchTimeout = window.setTimeout(reallyDoSearch, 500);
  }

  function reallyDoSearch() {      
    var type = document.getElementById('type').value;
    var rankBy ='distance';
    var search = {};
    
    if (type != 'establishment') {
      search.types = [type];
    }

     // alert(type);
    
    if (rankBy == 'distance' && (search.types)) {
     //   alert("111");

      search.rankBy = google.maps.places.RankBy.DISTANCE;
      search.location = new google.maps.LatLng(<?php echo $wgmnp_location ?>);//place latitude and longitude for finding nearest places
       centerMarker = new google.maps.Marker({
        position: search.location,
        animation: google.maps.Animation.DROP,
        map: map
      });
    } else {
       // alert("222");
      search.bounds = map.getBounds();
    }

    //  var bounds = new google.maps.LatLngBounds();
    
    places.search(search, function(results, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {

          {

              console.log(results);

          for (var i = 0; i < results.length; i++) {
              var icon = '<?php echo wgmnp_get_plugin_url() ?>/images/icons/number_' + (i + 1) + '.png';

              console.log(results[i].geometry.location);

              markers.push(new google.maps.Marker({
                  position: results[i].geometry.location,
                  animation: google.maps.Animation.DROP,
                  icon: icon
              }));

            //  bounds.extend(markers[i].getPosition());

              google.maps.event.addListener(markers[i], 'click', getDetails(results[i], i));
              //google.maps.event.addListener(markers[i], 'load', getDetails(results[i], i));


             // map.fitBounds(bounds);

              window.setTimeout(dropMarker(i), i * 100);
              addResult(results[i], i);
          }
        }
      }
    });
  }

        function newLocation(newLat,newLng)
        {
            map.setCenter({
                lat : newLat,
                lng : newLng
            });
        }


        function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
    markers = [];
   
    if (centerMarker) {
      centerMarker.setMap(null);
    }
  }
  function removeonlyMarkers() {
	    for (var i = 0; i < markers.length; i++) {
	      markers[i].setMap(null);
	    }
	    markers = [];
	 //   cityCircle.setMap(null);
  }
  function removecenterMarkers() {
	  
	    if (centerMarker) {
	      centerMarker.setMap(null);
	    }
  }
  

  function dropMarker(i) {
    return function() {
      if (markers[i]) {
        markers[i].setMap(map);
      }
    }
  }
  function addResult(result, i) {
    var results = document.getElementById('results');
    var tr = document.createElement('tr');
    tr.style.backgroundColor = (i% 2 == 0 ? '#F0F0F0' : '#FFFFFF');
    tr.onclick = function() {
      google.maps.event.trigger(markers[i], 'click');
    };

    var iconTd = document.createElement('td');
    var nameTd = document.createElement('td');
    var icon = document.createElement('img');
    icon.src = '<?php echo wgmnp_get_plugin_url() ?>/images/icons/number_' + (i+1) + '.png';
    icon.setAttribute('class', 'placeIcon');
    icon.setAttribute('className', 'placeIcon');
    var name = document.createTextNode(result.name);
    iconTd.appendChild(icon);
    nameTd.appendChild(name);
    tr.appendChild(iconTd);
    tr.appendChild(nameTd);
    results.appendChild(tr);
  }

  function clearResults() {
    var results = document.getElementById('results');
    while (results.childNodes[0]) {
      results.removeChild(results.childNodes[0]);
    }

      removeonlyMarkers();
     /* if (markersArray) {
          for (i in markersArray) {
              markersArray[i].setVisible(false)
          }
          //markersArray.length = 0;
      }*/

  }

  function getDetails(result, i) {
    return function() {
      places.getDetails({
          reference: result.reference
      }, showInfoWindow(i));
        console.log(result);

        //map.setCenter(result[i].getPosition());

       // newLocation(lat_long_data[0],lat_long_data[1]);
    }
  }

  function showInfoWindow(i) {
    return function(place, status) {
      if (iw) {
        iw.close();
        iw = null;
      }
      
      if (status == google.maps.places.PlacesServiceStatus.OK) {
        iw = new google.maps.InfoWindow({
          content: getIWContent(place)
        });
        iw.open(map, markers[i]);        
      }
    }
  }
  
  function getIWContent(place) {
    var content = '';
    content += '<table>';
    content += '<tr class="iw_table_row">';
    content += '<td style="text-align: right"><img class="hotelIcon" src="' + place.icon + '"/></td>';
    content += '<td><b><a href="' + place.url + '">' + place.name + '</a></b></td></tr>';
    content += '<tr class="iw_table_row"><td class="iw_attribute_name">Address:</td><td>' + place.vicinity + '</td></tr>';
    if (place.formatted_phone_number) {
      content += '<tr class="iw_table_row"><td class="iw_attribute_name">Telephone:</td><td>' + place.formatted_phone_number + '</td></tr>';      
    }
    if (place.rating) {
      var ratingHtml = '';
      for (var i = 0; i < 5; i++) {
        if (place.rating < (i + 0.5)) {
          ratingHtml += '&#10025;';
        } else {
          ratingHtml += '&#10029;';
        }
      }
      content += '<tr class="iw_table_row"><td class="iw_attribute_name">Rating:</td><td><span id="rating">' + ratingHtml + '</span></td></tr>';
    }
    if (place.website) {
      var fullUrl = place.website;
      var website = hostnameRegexp.exec(place.website);
      if (website == null) { 
        website = 'http://' + place.website + '/';
        fullUrl = website;
      }
      content += '<tr class="iw_table_row"><td class="iw_attribute_name">Website:</td><td><a href="' + fullUrl + '">' + website + '</a></td></tr>';
    }
    content += '</table>';
    return content;
  }
  google.maps.event.addDomListener(window, 'load', initialize);
  google.maps.event.addListenerOnce(map, 'idle', function(){
	    // do something only the first time the map is loaded
	  removeonlyMarkers();clearResults();
	});
	</script>
	<div id="map-content">
	<div id="controls" class="row">
	<div class="col-md-12">
		<div class="col-md-10"></div>
		<div class="col-md-2">
			<!-- <span id="typeLabel">Type</span> -->
		    <select id="type" style="width:100%">
		    <?php for ($i=0; $i < count($wgmnp_placetypes); $i++) { ?>
		     	 <option value="<?php echo $wgmnp_placetypes[$i] ?>"><?php echo $wgmnp_placelabels[$i] ?></option>
		     <?php } ?>
		    </select>
	    </div>
    </div>
   </div>
  <div id="map_canvas"></div>
  <div id="listing"><table id="resultsTable"><tbody id="results"></tbody></table></div>
  <?php $wgmnp_settings = get_option("WGMNP_MAP_SETTINGS");
  if( $wgmnp_settings['wgmnp_neighbourhood_credits'] == 1) { ?>
  <div id="nh_map_credits">
  Made by <a href="http://layero.com/">Layero</a>
  </div>
  <?php } ?>
  </div>
	<?php

}
// The neighbourhood map settings section.
function google_map_neighbourhood()
{
	$wgmnp_settings = get_option("WGMNP_MAP_SETTINGS");
	$wgmnp_mapwidth=$wgmnp_settings['wgmnp_mapwidth'];
	$wgmnp_mapheight=$wgmnp_settings['wgmnp_mapheight'];
	if ($wgmnp_settings['wgmnp_mapplacetypes_airport'] == "yes") { $wgmnp_airport_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_night_club'] == "yes") { $wgmnp_night_club_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_art_gallery'] == "yes") { $wgmnp_art_gallery_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_park'] == "yes") { $wgmnp_park_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_parking'] == "yes") { $wgmnp_parking_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_bar'] == "yes") { $wgmnp_bar_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_bus_station'] == "yes") { $wgmnp_bus_station_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_restaurant'] == "yes") { $wgmnp_restaurant_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_car_rental'] == "yes") { $wgmnp_car_rental_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_hospital'] == "yes") { $wgmnp_hospital_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_school'] == "yes") { $wgmnp_school_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_shopping_mall'] == "yes") { $wgmnp_shopping_mall_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_subway_station'] == "yes") { $wgmnp_subway_station_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_attractions'] == "yes") { $wgmnp_attractions_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_resorts'] == "yes") { $wgmnp_resorts_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_homestay'] == "yes") { $wgmnp_homestay_checked = "checked='checked'"; }
	if ($wgmnp_settings['wgmnp_mapplacetypes_grocery_or_supermarket'] == "yes") { $wgmnp_grocery_or_supermarket_checked = "checked='checked'"; }

?>
<div class="wrap">  
<div id="icon-options-general" class="icon32"><br></div><h2>Google MAP Settings</h2>
<form method="post" action="" id="wgmnp_options">  
<table class="form-table">
<tbody>  
<tr valign="top">
<th scope="row"><label for="wgmnp_mapwidth">Map Width</label></th>
<td> <input type="text" name="wgmnp_mapwidth" size="45" value="<?php echo $wgmnp_mapwidth; ?>" />
<p class="description">Write down width of the map(ex:900). Default is 900px. </p></td>
</tr>
<tr valign="top">
<th scope="row"><label for="wgmnp_mapheight">Map Height</label></th>
<td> <input type="text" name="wgmnp_mapheight" size="45" value="<?php echo $wgmnp_mapheight; ?>" />
<p class="description">Write down height of the map(ex:400). Default is 400px. </p></td>
</tr>
<tr valign="top">
<th scope="row"><label for="wgmnp_mapplacetypes">Supported Place Types</label></th>
<td>  <input name='wgmnp_mapplacetypes_airport' type='checkbox' id='wgmnp_mapplacetypes_airport' value='yes' <?php echo $wgmnp_airport_checked ?>/> Enable Airport<br />
    <input name='wgmnp_mapplacetypes_night_club' type='checkbox' id='wgmnp_mapplacetypes_night_club' value='yes' <?php echo $wgmnp_night_club_checked ?>/> Enable Night Club<br />
    <input name='wgmnp_mapplacetypes_art_gallery' type='checkbox' id='wgmnp_mapplacetypes_art_gallery' value='yes' <?php echo $wgmnp_art_gallery_checked ?>/> Enable Art Gallery<br />
    <input name='wgmnp_mapplacetypes_park' type='checkbox' id='wgmnp_mapplacetypes_park' value='yes' <?php echo $wgmnp_park_checked ?>/> Enable Park<br />
    <input name='wgmnp_mapplacetypes_parking' type='checkbox' id='wgmnp_mapplacetypes_parking' value='yes' <?php echo $wgmnp_parking_checked ?>/> Enable Parking<br />
    <input name='wgmnp_mapplacetypes_bar' type='checkbox' id='wgmnp_mapplacetypes_bar' value='yes' <?php echo $wgmnp_bar_checked ?>/> Enable Bar<br />
    <input name='wgmnp_mapplacetypes_bus_station' type='checkbox' id='wgmnp_mapplacetypes_bus_station' value='yes' <?php echo $wgmnp_bus_station_checked ?>/> Enable Bus Station<br />
    <input name='wgmnp_mapplacetypes_restaurant' type='checkbox' id='wgmnp_mapplacetypes_restaurant' value='yes' <?php echo $wgmnp_restaurant_checked ?>/> Enable Resturant<br />
    <input name='wgmnp_mapplacetypes_car_rental' type='checkbox' id='wgmnp_mapplacetypes_car_rental' value='yes' <?php echo $wgmnp_car_rental_checked ?>/> Enable Car Rent<br />
    <input name='wgmnp_mapplacetypes_hospital' type='checkbox' id='wgmnp_mapplacetypes_hospital' value='yes' <?php echo $wgmnp_hospital_checked ?>/> Enable Hospital<br />
    <input name='wgmnp_mapplacetypes_school' type='checkbox' id='wgmnp_mapplacetypes_school' value='yes' <?php echo $wgmnp_school_checked ?>/> Enable School<br />
    <input name='wgmnp_mapplacetypes_shopping_mall' type='checkbox' id='wgmnp_mapplacetypes_shopping_mall' value='yes' <?php echo $wgmnp_shopping_mall_checked ?>/> Enable Shopping Mall<br />
    <input name='wgmnp_mapplacetypes_subway_station' type='checkbox' id='wgmnp_mapplacetypes_subway_station' value='yes' <?php echo $wgmnp_subway_station_checked ?>/> Enable Subway Station<br />
    <input name='wgmnp_mapplacetypes_attractions' type='checkbox' id='wgmnp_mapplacetypes_attractions' value='yes' <?php echo $wgmnp_attractions_checked ?>/> Enable Attractions<br />
    <input name='wgmnp_mapplacetypes_resorts' type='checkbox' id='wgmnp_mapplacetypes_resorts' value='yes' <?php echo $wgmnp_resorts_checked ?>/> Enable Resorts<br />
    <input name='wgmnp_mapplacetypes_homestay' type='checkbox' id='wgmnp_mapplacetypes_homestay' value='yes' <?php echo $wgmnp_homestay_checked ?>/> Enable Home Stay<br />
    <input name='wgmnp_mapplacetypes_grocery_or_supermarket' type='checkbox' id='wgmnp_mapplacetypes_grocery_or_supermarket' value='yes' <?php echo $wgmnp_grocery_or_supermarket_checked ?>/> Enable Grocery Or Supermarket<br />
    
</td>
</tr>
<tr valign="top">
<th scope="row"><label for="wgmnp_neighbourhood_credits">Enable Neighbourhood plugin credits</label></th>
<td>   <input type="checkbox" name="wgmnp_neighbourhood_credits" <?php if( $wgmnp_settings['wgmnp_neighbourhood_credits'] == 1){echo "checked";}?>>   
<p class="description">Check to show the plugin credits </p></td>
</tr>
</tbody>
</table> 
<p>Use the shortcode [map_neighbourhood location="latitude,longitude"] in(post or page)</p>
    <p class="submit"><input type="submit" name="save_settings" id="save_settings" class="button button-primary" value="Save Changes"></p>
 		   </form> 
<?php
}
// Saving the map settings data.
function wgmnp_head(){

	if (isset($_POST['save_settings'])){
		global $wpdb;
		$wgmnp_data['wgmnp_mapwidth'] = esc_attr($_POST['wgmnp_mapwidth']);
		$wgmnp_data['wgmnp_mapheight'] = esc_attr($_POST['wgmnp_mapheight']);
		$wgmnp_data['wgmnp_mapplacetypes_airport'] = esc_attr($_POST['wgmnp_mapplacetypes_airport']);
		$wgmnp_data['wgmnp_mapplacetypes_night_club'] = esc_attr($_POST['wgmnp_mapplacetypes_night_club']);
		$wgmnp_data['wgmnp_mapplacetypes_art_gallery'] = esc_attr($_POST['wgmnp_mapplacetypes_art_gallery']);
		$wgmnp_data['wgmnp_mapplacetypes_park'] = esc_attr($_POST['wgmnp_mapplacetypes_park']);
		$wgmnp_data['wgmnp_mapplacetypes_parking'] = esc_attr($_POST['wgmnp_mapplacetypes_parking']);
		$wgmnp_data['wgmnp_mapplacetypes_bar'] = esc_attr($_POST['wgmnp_mapplacetypes_bar']);
		$wgmnp_data['wgmnp_mapplacetypes_bus_station'] = esc_attr($_POST['wgmnp_mapplacetypes_bus_station']);
		$wgmnp_data['wgmnp_mapplacetypes_restaurant'] = esc_attr($_POST['wgmnp_mapplacetypes_restaurant']);
		$wgmnp_data['wgmnp_mapplacetypes_car_rental'] = esc_attr($_POST['wgmnp_mapplacetypes_car_rental']);
		$wgmnp_data['wgmnp_mapplacetypes_hospital'] = esc_attr($_POST['wgmnp_mapplacetypes_hospital']);
		$wgmnp_data['wgmnp_mapplacetypes_school'] = esc_attr($_POST['wgmnp_mapplacetypes_school']);
		$wgmnp_data['wgmnp_mapplacetypes_shopping_mall'] = esc_attr($_POST['wgmnp_mapplacetypes_shopping_mall']);
		$wgmnp_data['wgmnp_mapplacetypes_subway_station'] = esc_attr($_POST['wgmnp_mapplacetypes_subway_station']);
		$wgmnp_data['wgmnp_mapplacetypes_attractions'] = esc_attr($_POST['wgmnp_mapplacetypes_attractions']);
		$wgmnp_data['wgmnp_mapplacetypes_resorts'] = esc_attr($_POST['wgmnp_mapplacetypes_resorts']);
		$wgmnp_data['wgmnp_mapplacetypes_homestay'] = esc_attr($_POST['wgmnp_mapplacetypes_homestay']);
		$wgmnp_data['wgmnp_mapplacetypes_grocery_or_supermarket'] = esc_attr($_POST['wgmnp_mapplacetypes_grocery_or_supermarket']);
		$wgmnp_data['wgmnp_neighbourhood_credits'] =(isset($_POST['wgmnp_neighbourhood_credits'])) ? 1 : 0;
    update_option('WGMNP_MAP_SETTINGS', $wgmnp_data);
        echo "<div class='updated'>";
        _e("Your settings have been saved.","google-map-neighbourhood");
        echo "</div>";
	}

}
/*
 * Returning the plugin url.
 */
function wgmnp_get_plugin_url() {
    if ( !function_exists('plugins_url') )
        return get_option('siteurl') . '/wp-content/plugins/' . plugin_basename(dirname(__FILE__));
    return plugins_url(plugin_basename(dirname(__FILE__)));
}
// Setting the plugin scripts
function wgmnp_scripts_method() {
    wp_enqueue_script('wgmnp_map','http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=true&amp;libraries=places');
}
// Setting the plugin styles
function wgmnp_user_styles() {
    wp_register_style( 'wgmnp-style', plugins_url('css/wgmnp_style.css', __FILE__) );
    wp_enqueue_style( 'wgmnp-style' );
}

add_action('wp_print_styles', 'wgmnp_user_styles');
add_action( 'wp_enqueue_scripts', 'wgmnp_scripts_method' );
?>