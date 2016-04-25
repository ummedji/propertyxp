jQuery(document).ready(function(){
	
	jQuery("select#hydra-hf-property-location-filter-items-0-country").parent().parent().find("label").remove();
	jQuery("select#hydra-hf-property-location-filter-items-0-location").parent().parent().find("label").remove();
	jQuery("select#hydra-hf-property-location-filter-items-0-sublocation").parent().parent().find("label").remove();
	
	jQuery("select#hydra-hf-property-location-filter-items-0-country option:first-child").html(" ");
	jQuery("select#hydra-hf-property-location-filter-items-0-country option:first-child").html("State");
	
	jQuery("select#hydra-hf-property-contract-type-filter-items-0-value option:first-child").html(" ");
	jQuery("select#hydra-hf-property-contract-type-filter-items-0-value option:first-child").html("Contract Type");
	
	//jQuery("select#hydra-hf-property-location-filter-items-0-location option:first-child").html(" ");
	//jQuery("select#hydra-hf-property-location-filter-items-0-location option:first-child").html("City");
	
	//jQuery("select#hydra-hf-property-location-filter-items-0-sublocation option:first-child").html(" ");
	//jQuery("select#hydra-hydra-hf-property-location-filter-items-0-sublocation option:first-child").html("Location");
	
});