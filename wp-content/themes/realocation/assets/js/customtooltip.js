jQuery(document).ready(function () {
	jQuery(".field-item label").mouseover(function(){
		showTooltip(this);
	});
	jQuery(".field label").mouseover(function(){
		showTooltip(this);
	});
	jQuery(".hndle span").mouseover(function(){
		showTooltip(this);
	});
	jQuery(".wrap h2").mouseover(function(){
		showTooltip(this);
	});
	jQuery("#displayform").mouseover(function(){
		showEnquiryTooltip(this);
	});
});
function showTooltip(elem)
{
	var tooltipLabel = jQuery(elem).text().toLowerCase().trim();
	tooltipLabel = tooltipLabel.replace('*', '').trim();
		if(typeof tooltipMessage[tooltipLabel] != 'undefined'){
			jQuery(elem).attr("title","");
			jQuery(elem).tooltip({
			  content: tooltipMessage[tooltipLabel]
			});
		}				
}
function showEnquiryTooltip()
{
	jQuery('#displayform').attr("title","");
	jQuery('#displayform').tooltip({
	content: tooltipMessage['displayform']
	});
}		
			/* var Arr = { 'Add New Property':'.wrap h2', 'aaaa':'bbb' };
			var getTitle = jQuery( ".wrap h2" ).text();
			jQuery( Arr[getTitle] ).hover(function(){
				jQuery(Arr[getTitle]).attr('title','');
				jQuery(function() {
				jQuery( Arr[getTitle] ).tooltip({
			content: "<strong>Title of Property!</strong>",
			track:true
			})
			});
				}); */
			/* jQuery( Arr[getTitle] ).attr('title','');
			jQuery(function() {
			jQuery( Arr[getTitle] ).tooltip({
			content: "<strong>Title of Property!</strong>",
			track:true
			})
			}); */
			
		
	/*	jQuery(document).ready(function(jQuery){
		
		
		
		//jQuery( "#titlewrap" ).attr('title','');
	/*	jQuery( "#hydra-hf-property-minimum-price-items-0-value" ).attr('title','');
		jQuery( "#hydra-hf-property-gallery-items-0-url" ).attr('title','');
		jQuery( "#hydra-hf-property-gallery-items-0-alt" ).attr('title','');
		jQuery( "#hydra-hf-property-gallery2-items-0-url" ).attr('title','');
		jQuery( "#hydra-hf-property-gallery2-items-0-alt" ).attr('title','');
		jQuery( "#hydra-hf-property-maximum-price-items-0-value" ).attr('title','');
		jQuery("label[for='hydra-hf-property-person-items-0-value']").attr('title','');
		jQuery("label[for='hydra-hf-property-contract-type-items-0-value']").attr('title','');
		jQuery( "#hydra-hf-property-available-items-0-date" ).attr('title','');
		jQuery("label[for='hydra-hf-property-type-items-0-value']").attr('title','');
		jQuery("label[for='hydra-hf-property-amenities-items-0-value']").attr('title','');
		jQuery("label[for='hydra-hf-property-location-items-0-country']").attr('title','');
		jQuery("label[for='hydra-hf-property-location-items-0-location']").attr('title','');
		jQuery("label[for='hydra-hf-property-location-items-0-sublocation']").attr('title','');
		jQuery("#pac-input").attr('title','');
		jQuery("#hydra-hf-property-map-items-0-latitude").attr('title','');
		jQuery("#hydra-hf-property-map-items-0-longitude").attr('title','');
		jQuery("#hydra-hf-property-price-items-0-value").attr('title','');
		});
		
		
		jQuery(function() {
		/*jQuery( "#titlewrap" ).tooltip({
		content: "<strong>Title of Property!</strong>",
		track:true
		}),*/
		/*jQuery( "#hydra-hf-property-minimum-price-items-0-value" ).tooltip({
		content: "<strong>Minimum Price!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-gallery-items-0-url" ).tooltip({
		content: "<strong>Image Url!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-gallery-items-0-alt" ).tooltip({
		content: "<strong>Add Alternet Text!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-gallery2-items-0-url" ).tooltip({
		content: "<strong>Image Url!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-gallery2-items-0-alt" ).tooltip({
		content: "<strong>Add Alternet Text!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-maximum-price-items-0-value" ).tooltip({
		content: "<strong>Maximum Price!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-person-items-0-value']" ).tooltip({
		content: "<strong>Select Person!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-contract-type-items-0-value']" ).tooltip({
		content: "<strong>Contract Type!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-available-items-0-date" ).tooltip({
		content: "<strong>Available From!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-type-items-0-value']" ).tooltip({
		content: "<strong>Property Type!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-amenities-items-0-value']" ).tooltip({
		content: "<strong>Amenities!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-location-items-0-country']" ).tooltip({
		content: "<strong>Level1!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-location-items-0-location']" ).tooltip({
		content: "<strong>Level2!</strong>",
		track:true
		}),
		jQuery( "label[for='hydra-hf-property-location-items-0-sublocation']" ).tooltip({
		content: "<strong>Level3!</strong>",
		track:true
		}),
		jQuery( "#pac-input" ).tooltip({
		content: "<strong>Enter Place!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-map-items-0-latitude" ).tooltip({
		content: "<strong>Enter Latitude!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-map-items-0-longitude" ).tooltip({
		content: "<strong>Enter Longitude!</strong>",
		track:true
		}),
		jQuery( "#hydra-hf-property-price-items-0-value" ).tooltip({
		content: "<strong>Price!</strong>",
		track:true
		})
		});*/
		
		