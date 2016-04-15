jQuery('document').ready(function () {


    jQuery('#add-group').click(function () {
        jQuery('.fieldset-form').slideDown('fast');
    });

    jQuery('.hide-action').click(function (e) {
        var item_id = parseInt(jQuery(this).attr('id').match(/\d+/));

        if (jQuery('#item_' + item_id).hasClass('hidden-item')) {
            jQuery('#item_' + item_id).removeClass('hidden-item');
            jQuery('#hidden-' + item_id).attr('value', 0);
        } else {
            jQuery('#item_' + item_id).addClass('hidden-item');
            jQuery('#hidden-' + item_id).attr('value', 1);
        }

        e.preventDefault();
    })


    jQuery('.add-new-field').hover(
        function () {
            var context = jQuery(this);
            jQuery('.options', context).slideDown('fast');
        },
        function () {
            var context = jQuery(this);
            jQuery('.options', context).slideUp('fast');
        }
    );

    jQuery('.select-chosen').chosen({
        disable_search_threshold: 20
    });


    var group = jQuery("ul.hydra-sort").sortable({
        group: 'nested',
        handle: '.drag',
        isValidTarget: function ($item, container) {

            if ($item.hasClass('field')) {
                return true;
            }
//            if ($item.hasClass('fieldset') && jQuery(container.items[0]).hasClass('fieldset')) {
//                return false;
//            }

            return true;
        },
        onDrop: function (item, container, _super) {
            _super(item, container);
            jQuery('li', 'ul.hydra-sort').each(function (index, value) {
                var parent_id = 0;
                if (jQuery(value).parent().parent().attr('id')) {
                    parent_id = parseInt(jQuery(value).parent().parent().attr('id').match(/\d+/));
                }

                if (jQuery(value).attr('id')) {
                    var item_id = parseInt(jQuery(value).attr('id').match(/\d+/));

                    jQuery('#weight-' + item_id).attr('value', index);
                    jQuery('#parent-' + item_id).attr('value', parent_id);
                    console.log('Placing item: ' + item_id + " into " + parent_id);
                }
            });
        }
    });


    formatterSettings();
    widgetSettings();
});


function formatterSettings() {

    jQuery(".formatter-settings").hide();

    jQuery('.settings-action').click(function (e) {

        var viewId = parseInt(jQuery(this).attr('id').match(/\d+/));
        var item = jQuery('#item_' + viewId)
        var input = jQuery('select', item);
        var value = input.attr('value');
        if (jQuery("> .formatter-settings", jQuery('#item_' + viewId)).is(':visible')) {
            jQuery("> .formatter-settings", jQuery('#item_' + viewId)).slideUp('fast');
        } else {
            jQuery("> .formatter-settings", jQuery('#item_' + viewId)).slideDown('fast');
        }

        e.preventDefault();
    });

    jQuery('.formatter').change(function () {
        var viewId = parseInt(jQuery(this).attr('id').match(/\d+/));
        jQuery("> .formatter-settings", jQuery('#item_' + viewId)).slideUp('fast');

        var item = jQuery('#item_' + viewId)
        var input = jQuery(this);
        var value = input.attr('value');

        jQuery.ajax({
            url: "/hydraformatter/" + value + "/" + viewId
        }).done(function (data) {
                jQuery("> .formatter-settings", jQuery('#item_' + viewId)).html(data);
            });
    });


}

function widgetSettings() {

    jQuery('#widget-select').change(function (e) {
        var fieldId = jQuery("[name='id']").attr('value');
        var value = jQuery(this).attr('value');
        var is_filter = 0;
        if(jQuery('#hydra-is-filter').length) {
            is_filter = 1;
        }
        jQuery.ajax({
            url: "/hydrawidget/" + value + "/" + fieldId + "/" + is_filter
        }).done(function (data) {

                jQuery("#widget").html(data);
                jQuery('#widget').trigger('hydra_ajax');
            });
    });
}
