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

    // Resize treaty reader according to the screen dimension
    var dlg_tt = jQuery('#treaty-text-modal');
    dlg_tt.on('shown',function () {
        var head = jQuery('div.modal .modal-header').height();
        var dlg_h = jQuery(window).height() * 0.83;
        var height = (dlg_h - head - 25) + 'px'; // Some adjustements due to paddings
        dlg_tt.css('max-height', dlg_h + 'px');
        dlg_tt.css('height', dlg_h + 'px');
        jQuery('.modal-body', dlg_tt).css('max-height', height);
        jQuery('.modal-body', dlg_tt).css('height', height);
        jQuery('.modal-body .span3', dlg_tt).css('max-height', height);
        jQuery('.modal-body .span3', dlg_tt).css('height', height);
        jQuery('#treaty-text-container', dlg_tt).css('max-height', height);
        jQuery('#treaty-text-container', dlg_tt).css('height', height);
        //var offset = jQuery(this).offset().top;
        //jQuery(window).scrollTop(offset);
        //jQuery('#treaty-text-select').on('change', function() {
        //    jQuery('#treaty-text-container').scrollTo(jQuery('#treaty-text-select').val() - 50);
        //});
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