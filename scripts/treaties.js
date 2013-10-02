/**
 * @globals: i3_config_ajax injected globally
 * @globals: i3_config_treaty injected by treaties page
 */

jQuery('document').ready(function() {
    // @todo Add filtering here

    var tncs = jQuery('#treaty-nfp-country-select');
    tncs.on('change', function() {
        tncs_on_change(tncs.val());
    });
});


function tncs_on_change(country_iso) {
    jQuery.ajax({
            url: i3_config_ajax.ajaxurl,
            data: {
                dataType: 'html',
                action: 'get_nfp_for_treaty_country',
                iso: country_iso,
                id_treaty: i3_config_treaty.id
            }
    })
    .done(function(resp) {
        jQuery('#focal-point-list').html(resp);
    });
}