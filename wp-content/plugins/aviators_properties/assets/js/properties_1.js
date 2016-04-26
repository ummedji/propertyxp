jQuery(document).ready(function($) {
    'use strict';

    if ($('.bxslider').length !== 0) {
        var slider =  $('.bxslider').bxSlider({
            minSlides: 1,
            //maxSlides: 6,
            maxSlides: 4,
            slideWidth: 170,
            slideMargin: 30,
            responsive: true,
            onSliderLoad: function() {
                $('.bxslider').css('visibility', 'visible');
            }
        });
    }
	
	if ($('.bxslider_featured').length !== 0) {
	
        $('.bxslider_featured').bxSlider({
            minSlides: 1,
            maxSlides: 6,
           // maxSlides: 4,
            slideWidth: 170,
            slideMargin: 30,
            responsive: true,
            onSliderLoad: function() {
                $('.bxslider_featured').css('visibility', 'visible');
            }
        });
    }
	
	
});
