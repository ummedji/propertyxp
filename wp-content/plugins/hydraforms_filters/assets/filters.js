(function($) {
    $(document).ready(function() {
        initBxSlider();
        initRangeSlider();

        $("#widget").bind('hydra_ajax', function() {
            initBxSlider();
            initRangeSlider();
        });
    });
})(jQuery);

function initBxSlider() {
    jQuery('.carousel-select > ul').each(function() {
        var initData = jQuery(this).data();
        initData.infiniteLoop = false;
        initData.slideWidth = initData.slide_width;
        initData.minSlides = initData.min_slides;
        initData.maxSlides = initData.max_slides;
        initData.moveSlides = initData.move_slides;
        initData.pager = initData.pager;

        jQuery(this).bxSlider(initData);
    });
}

function initRangeSlider() {

    jQuery(".ion-range-slider").ionRangeSlider({
        type: 'double'
    });
}

