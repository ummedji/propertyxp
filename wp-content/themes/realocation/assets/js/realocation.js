(function($) {
    'use strict';

    /***********************************************************
     * ISOTOPE
     ***********************************************************/
    $('.isotope.properties-items').imagesLoaded(function() {
        var isotope_works = $('.isotope.properties-items');
        isotope_works.isotope({
            'itemSelector': '.property-item'
        });

        $('.properties-filter a').click(function() {
            $(this).parent().parent().find('li').removeClass('selected');
            $(this).parent().addClass('selected');

            var selector = $(this).attr('data-filter');
            isotope_works.isotope({ filter: selector });
            return false;
        });
    });
})(jQuery);

jQuery(document).ready(function($) {
	'use strict';

    $('.map-navigation-wrapper').css({ opacity: 1 });
    /***********************************************************
     * STYLED SELECT
     ***********************************************************/
    $('select').wrap('<div class="select-wrapper"></div>');

    /***********************************************************
     * AUTOSIZE
     ***********************************************************/
    $('textarea').autosize();

    /***********************************************************
     * RESIZABLE MAP
     ***********************************************************/
    if ($('.map-wrapper').length !== 0) {
        var mapMinHeight = 200;
        var filter = $('.map-wrapper .map-navigation');

        if (filter.length !== 0) {
            mapMinHeight = filter.height() + 140;

            if($('#map').height() < mapMinHeight) {
                $('#map').css('height', mapMinHeight);
                filter.css({'display': 'block'});
            }
        }

        $( '.map' ).resizable({
            maxHeight: 1000,
            minHeight: mapMinHeight,
            handles: 's',
            resize: function(event, ui) {
                $('#map').css('height', $(this).height());
                google.maps.event.trigger(map, 'resize');
            }
        });
    }

    /***********************************************************
     * ACCORDION
     ***********************************************************/
    $('.panel-heading a[data-toggle="collapse"]').on('click', function () {
        var context = $(this).data('parent');
        var clicked_panel = $(this).parent().parent();

        if(clicked_panel.hasClass('active')) {
            $(clicked_panel).removeClass('active');
        } else {
            $('.panel-heading', context).removeClass('active');
            $(clicked_panel).addClass('active');
        }
    });

    /***********************************************************
     * FLEX Slider
     ***********************************************************/
    $('.flexslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails"
    });

    /***********************************************************
     * COUNT UP
     ***********************************************************/
    $('.block-stats').appear();
    $('.block-stats').on('appear', function(event, $all_appeared_elements) {
        $all_appeared_elements.each(function() {
            if (!$(this).hasClass('counting')) {
                var max_value = $('strong', this).text();
                var el = $('strong', this);
                var difference = Math.ceil(max_value/25);
                el.text(0);

                var interval = setInterval( function () {
                    var current_value = parseInt(el.text());

                    if (parseInt(el.text()) < max_value) {
                        if (current_value + difference > max_value) {
                            el.text(max_value);
                            clearInterval(interval);
                        } else {
                            el.text(current_value + difference);
                        }
                    }
                }, 100);
            }
            $(this).addClass('counting');
        });
    });
    $.force_appear();


    $('.carousel-select ul.list-unstyled > li').click(function() {
        if ($('input', this).prop( 'checked' )) {
            $('input', this).prop('checked', false);
            $(this).removeClass('active');
        } else {
            $('input', this).prop('checked', true);
            $(this).addClass('active');
        }
    });

    /***********************************************************
     * PALETTE
     ***********************************************************/
    $('.palette-colors a').click(function(e) {
        e.preventDefault();
        var newCSSHref = $(this).attr('href');
        $('#realocation-css').attr('href', newCSSHref);
    });
    // close the palette on click
    $('.palette-toggle').click(function() {
        $('.palette-wrapper').toggleClass('palette-closed');
    });

    // change page layout from palette
    $('.palette-layout').change(function() {
        $('body').removeClass('layout-wide').removeClass('layout-boxed');
        $('body').addClass($(this).find(":selected").attr('value'));
    });

    // change page header style from palette
    $('.palette-header').change(function() {
        $('body').removeClass('header-light').removeClass('header-dark');
        $('body').addClass($(this).find(":selected").attr('value'));
    });

    // change page footer style from palette
    $('.palette-footer').change(function() {
        $('body').removeClass('footer-light').removeClass('footer-dark');
        $('body').addClass($(this).find(":selected").attr('value'));
    });

    // change navigation style from palette
    $('.palette-map-navigation').change(function() {
        $('body').removeClass('map-navigation-light').removeClass('map-navigation-dark');
        $('body').addClass($(this).find(":selected").attr('value'));
    });

    // select a background pattern from palette
    $('.palette-patterns a').click(function() {
        var activePattern = $('.palette-patterns a.active');
        $('body').removeClass(activePattern.attr('class'));
        activePattern.removeClass('active');

        $('body').addClass($(this).attr("class"));
        $(this).addClass('active');
    });
});