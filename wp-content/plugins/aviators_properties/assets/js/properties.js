jQuery(document).ready(function($) {
    'use strict';

    if ($('.bxslider').length !== 0) {
        $('.bxslider').bxSlider({
            minSlides: 1,
            maxSlides: 6,
            slideWidth: 170,
            slideMargin: 30,
            responsive: false,
            onSliderLoad: function() {
                $('.bxslider').css('visibility', 'visible');
            }
        });
    }
});
