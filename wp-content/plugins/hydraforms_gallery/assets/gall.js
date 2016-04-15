jQuery(document).ready(function ()
{
    //initCycleCarousel('.hydra-cycle-gallery');
    _initGallery();// single-car.php [ detail ]

});

//************************************

function initCycleCarousel(selector)
{
    jQuery(selector).cycle(
        {
        paused: true,
        slides: '> .slide'
        });
}

function _initGallery() {
    jQuery('.gallery').bxSlider({
        pagerSelector: '#gallery-pager .pager',
        mode: 'vertical',
        nextSelector:  '#gallery-pager .next',
        nextText: '',
        prevSelector:  '#gallery-pager .prev',
        prevText: '',
        buildPager: function (slideIndex) {
            var selector = '.thumbnail-' + slideIndex;
            return jQuery(selector).html();
        }
    });
}

