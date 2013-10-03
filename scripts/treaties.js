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

    // Close NFP contact modal dialog
    jQuery('#confact-nfp-close').click(function() {
        jQuery('#contact-nfp').modal('hide');
    });
});


/**
 * Open a pop-up on the center of the screen
 * @param url URL to open
 * @param title Window title
 * @param w Width
 * @param h Height
 */
function popup_center(url, title, w, h) {
    // Fixes dual-screen position                       Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var left = ((screen.width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((screen.height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}