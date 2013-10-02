/**
 * @globals: i3_config_ajax injected globally
 * @globals: i3_config_treaty injected by treaties page
 */

jQuery('document').ready(function() {
    // @todo Add filtering here

    var tncs = jQuery('#treaty-nfp-country-select');
    tncs.on('change', function() {
        jQuery.ajax({
            url: i3_config_ajax.ajaxurl,
            data: {
                dataType: 'html',
                action: 'get_nfp_for_treaty_country',
                iso: tncs.val(),
                id_treaty: i3_config_treaty.id
            }
        }).done(function(resp) {
            var option = jQuery('select#treaty-nfp-country-select > option:selected');
            jQuery('#treaty-nfp-country-flag').attr('src', option.data('flag'));
            jQuery('#focal-point-list').html(resp);
            jQuery('#treaty-nfp-country-count').text(
                jQuery('ul#focal-point-list > li').length
            );
        });
    });
});
