/**
 * Ajax handling of forms
 */
(function ($) {

    var focused_element;
    $('.token-area').focus(function () {
        focused_element = $(this);
    });

    $('.replacement-token').click(function (e) {
        var token = $(this).data('input');
        // keep the focus
        if (focused_element.length != 0) {
            insertTextAtCursor(focused_element, token)
            e.preventDefault();
        }
    });

    $('.token-table .expander .switch').click(function () {
        var context = $(this).parent().parent();

        if ($(this).hasClass('closed')) {
            $('table', context).slideDown('fast');
            $(this).removeClass('closed');
            $(this).addClass('open');
        } else {
            $('table', context).slideUp('fast');
            $(this).removeClass('open');
            $(this).addClass('closed');
        }

    });

    function insertTextAtCursor(element, text) {
        //var element = document.getElementById(areaId);
        element = element[0];
        var scrollPos = element.scrollTop;
        var strPos = 0;
        var br = ((element.selectionStart || element.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false ) );
        if (br == "ie") {
            element.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -element.value.length);
            strPos = range.text.length;
        }
        else if (br == "ff") strPos = element.selectionStart;

        var front = (element.value).substring(0, strPos);
        var back = (element.value).substring(strPos, element.value.length);
        element.value = front + text + back;
        strPos = strPos + text.length;
        if (br == "ie") {
            element.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -element.value.length);
            range.moveStart('character', strPos);
            range.moveEnd('character', 0);
            range.select();
        }
        else if (br == "ff") {
            element.selectionStart = strPos;
            element.selectionEnd = strPos;
            element.focus();
        }
        element.scrollTop = scrollPos;
    }


    // hierarchy select
    $('.field-widget-hierarchy_select_widget-wrapper').each(function () {
        var context = this;
        $('.hierarchy-level-2', context).chained($('.hierarchy-level-1', context));
        $('.hierarchy-level-3', context).chained($('.hierarchy-level-2', context));
    });

    $('.ajax-action').each(function() {
        $('#' + $(this).attr('id')).live($(this).data('action'), function (e) {
            var data_form = $(this).data('form');
            var data_submit = ($(this).data('submit'));
            var data_wrapper = ($(this).data('wrapper'));
            var trigger_element = $(this).attr('name');

            if ($("#" + data_form).length == 0) {
                data_form = 'post';
            }

            $.ajax({
                type: "POST",
                url: data_submit,
                data: $("#" + data_form).serialize() + "&trigger_element=" + trigger_element,
                success: function (data) {
                    $(data_wrapper).replaceWith(data);
                    $(data_wrapper).trigger('hydra_ajax');
                }
            });

            e.preventDefault();
        });
    });

    $('.hide-times').live('click', function(e) {
        var context = $(this).parent().parent().parent();

        if($(this).is(':checked')) {
            $('.time', context).parent().hide();
        } else {
            $('.time', context).parent().show();
        }
    })

    machineName();
})(jQuery);

function machineName() {
    jQuery('.machine-name-source').change(function() {
        var value = jQuery(this).attr('value');
        var machine_name = URLify(value, 35);
        jQuery('.machine-name').attr('value', machine_name);
    });
}


var hydra = {
    media: null,
    image: null
};

(function ($) {
    // prototyping
    hydra.media = {
        div: null,
        frame: null,

        clear_frame: function () {

            // validate
            if (!this.frame) {
                return;
            }

            // detach
            this.frame.detach();
            this.frame.dispose();

            // reset var
            this.frame = null;

        },

        init: function () {
            // vars
            var _prototype = wp.media.view.AttachmentCompat.prototype;

            // orig
            _prototype.render();
        }
    };


    // reference
    var _media = hydra.media;

    hydra.image = {
        $el: null,

        o: {},

        set: function (o) {

            // merge in new option
            $.extend(this, o);
            // return this for chaining
            return this;

        },
        add: function (image) {

            // this function must reference a global div variable due to the pre WP 3.5 uploader
            // vars
            var div = this.$el;


            // set atts
            // Oh jesus !
            $('.hydra-image-url', _media.div).val(image.url);

            $('.hydra-image-url', _media.div).trigger('change');
            // set div class
            div.addClass('active');

            // validation
            div.closest('.field').removeClass('error');
        },
        popup: function () {

            // reference
            var t = this;


            // set global var
            _media.div = this.$el;


            // clear the frame
            _media.clear_frame();

            // Create the media frame
            _media.frame = wp.media({
                states: [
                    new wp.media.controller.Library({
                        library: wp.media.query(t.o.query),
                        multiple: t.o.multiple,
                        title: 'Insert image',
                        priority: 20,
                        filterable: 'all'
                    })
                ]
            });

            // When an image is selected, run a callback.
            hydra.media.frame.on('select', function () {

                // get selected images
                selection = _media.frame.state().get('selection');

                if (selection) {
                    var i = 0;
                    selection.each(function (attachment) {
                        // vars
                        var image = {
                            id: attachment.id,
                            url: attachment.attributes.url
                        };


                        // add image to field
                        hydra.image.add(image);


                    });
                }
            });

            hydra.media.frame.open();
            return false;
        }
    };

    $(document).on('click', '.hydra-remove-image', function (e) {
        var context = $(this).parent().parent();
        $('.hydra-image-url', context).val();
    });

    $(document).on('click', '.hydra-add-image', function (e) {
        e.preventDefault();
        hydra.image.set({ $el: $(this).parent().parent() }).popup();
    });


})(jQuery);




var LATIN_MAP = {
    'À': 'A', 'Á': 'A', 'Â': 'A', 'Ã': 'A', 'Ä': 'A', 'Å': 'A', 'Æ': 'AE', 'Ç':
        'C', 'È': 'E', 'É': 'E', 'Ê': 'E', 'Ë': 'E', 'Ì': 'I', 'Í': 'I', 'Î': 'I',
    'Ï': 'I', 'Ð': 'D', 'Ñ': 'N', 'Ò': 'O', 'Ó': 'O', 'Ô': 'O', 'Õ': 'O', 'Ö':
        'O', 'Ő': 'O', 'Ø': 'O', 'Ù': 'U', 'Ú': 'U', 'Û': 'U', 'Ü': 'U', 'Ű': 'U',
    'Ý': 'Y', 'Þ': 'TH', 'ß': 'ss', 'à':'a', 'á':'a', 'â': 'a', 'ã': 'a', 'ä':
        'a', 'å': 'a', 'æ': 'ae', 'ç': 'c', 'è': 'e', 'é': 'e', 'ê': 'e', 'ë': 'e',
    'ì': 'i', 'í': 'i', 'î': 'i', 'ï': 'i', 'ð': 'd', 'ñ': 'n', 'ò': 'o', 'ó':
        'o', 'ô': 'o', 'õ': 'o', 'ö': 'o', 'ő': 'o', 'ø': 'o', 'ù': 'u', 'ú': 'u',
    'û': 'u', 'ü': 'u', 'ű': 'u', 'ý': 'y', 'þ': 'th', 'ÿ': 'y'
}
var LATIN_SYMBOLS_MAP = {
    '©':'(c)'
}
var GREEK_MAP = {
    'α':'a', 'β':'b', 'γ':'g', 'δ':'d', 'ε':'e', 'ζ':'z', 'η':'h', 'θ':'8',
    'ι':'i', 'κ':'k', 'λ':'l', 'μ':'m', 'ν':'n', 'ξ':'3', 'ο':'o', 'π':'p',
    'ρ':'r', 'σ':'s', 'τ':'t', 'υ':'y', 'φ':'f', 'χ':'x', 'ψ':'ps', 'ω':'w',
    'ά':'a', 'έ':'e', 'ί':'i', 'ό':'o', 'ύ':'y', 'ή':'h', 'ώ':'w', 'ς':'s',
    'ϊ':'i', 'ΰ':'y', 'ϋ':'y', 'ΐ':'i',
    'Α':'A', 'Β':'B', 'Γ':'G', 'Δ':'D', 'Ε':'E', 'Ζ':'Z', 'Η':'H', 'Θ':'8',
    'Ι':'I', 'Κ':'K', 'Λ':'L', 'Μ':'M', 'Ν':'N', 'Ξ':'3', 'Ο':'O', 'Π':'P',
    'Ρ':'R', 'Σ':'S', 'Τ':'T', 'Υ':'Y', 'Φ':'F', 'Χ':'X', 'Ψ':'PS', 'Ω':'W',
    'Ά':'A', 'Έ':'E', 'Ί':'I', 'Ό':'O', 'Ύ':'Y', 'Ή':'H', 'Ώ':'W', 'Ϊ':'I',
    'Ϋ':'Y'
}
var TURKISH_MAP = {
    'ş':'s', 'Ş':'S', 'ı':'i', 'İ':'I', 'ç':'c', 'Ç':'C', 'ü':'u', 'Ü':'U',
    'ö':'o', 'Ö':'O', 'ğ':'g', 'Ğ':'G'
}
var RUSSIAN_MAP = {
    'а':'a', 'б':'b', 'в':'v', 'г':'g', 'д':'d', 'е':'e', 'ё':'yo', 'ж':'zh',
    'з':'z', 'и':'i', 'й':'j', 'к':'k', 'л':'l', 'м':'m', 'н':'n', 'о':'o',
    'п':'p', 'р':'r', 'с':'s', 'т':'t', 'у':'u', 'ф':'f', 'х':'h', 'ц':'c',
    'ч':'ch', 'ш':'sh', 'щ':'sh', 'ъ':'', 'ы':'y', 'ь':'', 'э':'e', 'ю':'yu',
    'я':'ya',
    'А':'A', 'Б':'B', 'В':'V', 'Г':'G', 'Д':'D', 'Е':'E', 'Ё':'Yo', 'Ж':'Zh',
    'З':'Z', 'И':'I', 'Й':'J', 'К':'K', 'Л':'L', 'М':'M', 'Н':'N', 'О':'O',
    'П':'P', 'Р':'R', 'С':'S', 'Т':'T', 'У':'U', 'Ф':'F', 'Х':'H', 'Ц':'C',
    'Ч':'Ch', 'Ш':'Sh', 'Щ':'Sh', 'Ъ':'', 'Ы':'Y', 'Ь':'', 'Э':'E', 'Ю':'Yu',
    'Я':'Ya'
}
var UKRAINIAN_MAP = {
    'Є':'Ye', 'І':'I', 'Ї':'Yi', 'Ґ':'G', 'є':'ye', 'і':'i', 'ї':'yi', 'ґ':'g'
}
var CZECH_MAP = {
    'č':'c', 'ď':'d', 'ě':'e', 'ň': 'n', 'ř':'r', 'š':'s', 'ť':'t', 'ů':'u',
    'ž':'z', 'Č':'C', 'Ď':'D', 'Ě':'E', 'Ň': 'N', 'Ř':'R', 'Š':'S', 'Ť':'T',
    'Ů':'U', 'Ž':'Z'
}

var POLISH_MAP = {
    'ą':'a', 'ć':'c', 'ę':'e', 'ł':'l', 'ń':'n', 'ó':'o', 'ś':'s', 'ź':'z',
    'ż':'z', 'Ą':'A', 'Ć':'C', 'Ę':'e', 'Ł':'L', 'Ń':'N', 'Ó':'o', 'Ś':'S',
    'Ź':'Z', 'Ż':'Z'
}

var LATVIAN_MAP = {
    'ā':'a', 'č':'c', 'ē':'e', 'ģ':'g', 'ī':'i', 'ķ':'k', 'ļ':'l', 'ņ':'n',
    'š':'s', 'ū':'u', 'ž':'z', 'Ā':'A', 'Č':'C', 'Ē':'E', 'Ģ':'G', 'Ī':'i',
    'Ķ':'k', 'Ļ':'L', 'Ņ':'N', 'Š':'S', 'Ū':'u', 'Ž':'Z'
}

var ARABIC_MAP = {
    'أ':'a', 'ب':'b', 'ت':'t', 'ث': 'th', 'ج':'g', 'ح':'h', 'خ':'kh', 'د':'d',
    'ذ':'th', 'ر':'r', 'ز':'z', 'س':'s', 'ش':'sh', 'ص':'s', 'ض':'d', 'ط':'t',
    'ظ':'th', 'ع':'aa', 'غ':'gh', 'ف':'f', 'ق':'k', 'ك':'k', 'ل':'l', 'م':'m',
    'ن':'n', 'ه':'h', 'و':'o', 'ي':'y'
}

var ALL_DOWNCODE_MAPS=new Array()
ALL_DOWNCODE_MAPS[0]=LATIN_MAP
ALL_DOWNCODE_MAPS[1]=LATIN_SYMBOLS_MAP
ALL_DOWNCODE_MAPS[2]=GREEK_MAP
ALL_DOWNCODE_MAPS[3]=TURKISH_MAP
ALL_DOWNCODE_MAPS[4]=RUSSIAN_MAP
ALL_DOWNCODE_MAPS[5]=UKRAINIAN_MAP
ALL_DOWNCODE_MAPS[6]=CZECH_MAP
ALL_DOWNCODE_MAPS[7]=POLISH_MAP
ALL_DOWNCODE_MAPS[8]=LATVIAN_MAP
ALL_DOWNCODE_MAPS[9]=ARABIC_MAP

var Downcoder = new Object();
Downcoder.Initialize = function()
{
    if (Downcoder.map) // already made
        return ;
    Downcoder.map ={}
    Downcoder.chars = '' ;
    for(var i in ALL_DOWNCODE_MAPS)
    {
        var lookup = ALL_DOWNCODE_MAPS[i]
        for (var c in lookup)
        {
            Downcoder.map[c] = lookup[c] ;
            Downcoder.chars += c ;
        }
    }
    Downcoder.regex = new RegExp('[' + Downcoder.chars + ']|[^' + Downcoder.chars + ']+','g') ;
}

downcode= function( slug )
{
    Downcoder.Initialize() ;
    var downcoded =""
    var pieces = slug.match(Downcoder.regex);
    if(pieces)
    {
        for (var i = 0 ; i < pieces.length ; i++)
        {
            if (pieces[i].length == 1)
            {
                var mapped = Downcoder.map[pieces[i]] ;
                if (mapped != null)
                {
                    downcoded+=mapped;
                    continue ;
                }
            }
            downcoded+=pieces[i];
        }
    }
    else
    {
        downcoded = slug;
    }
    return downcoded;
}


function URLify(s, num_chars) {
    // changes, e.g., "Petty theft" to "petty_theft"
    // remove all these words from the string before urlifying
    s = downcode(s);
    removelist = ["a", "an", "as", "at", "before", "but", "by", "for", "from",
        "is", "in", "into", "like", "of", "off", "on", "onto", "per",
        "since", "than", "the", "this", "that", "to", "up", "via",
        "with"];
    r = new RegExp('\\b(' + removelist.join('|') + ')\\b', 'gi');
    s = s.replace(r, '');
    // if downcode doesn't hit, the char will be stripped here
    s = s.replace(/[^-\w\s]/g, '');  // remove unneeded chars
    s = s.replace(/^\s+|\s+$/g, ''); // trim leading/trailing spaces
    s = s.replace(/[-\s]+/g, '_');   // convert spaces to hyphens
    s = s.toLowerCase();             // convert to lowercase
    return s.substring(0, num_chars);// trim to first num_chars chars
}

