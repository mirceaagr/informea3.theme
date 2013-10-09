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


    // Manually open the dialogs to prevent data stalling (Bootstrap issue)
    jQuery('.data-target-modal').click(function(e) {
        e.preventDefault();
        var dlg_id = jQuery(this).data('target');
        jQuery(dlg_id).modal({
            remote: jQuery(this).attr('href') + '?display=modal'
        });
    });

    // Resize treaty reader according to the screen dimension
    // https://github.com/twbs/bootstrap/pull/5514 - Bootstrap issue with dialog reuse.
    var dlg_tt = jQuery('.modal');
    dlg_tt.on('hidden', function() {jQuery(this).data('modal', null);});
    dlg_tt.on('shown',function () {
        var w_height = jQuery(window).height();
        var dlg_height = Math.floor(w_height * 0.90);
        var top_spacing = Math.ceil((w_height - dlg_height) / 2);
        var header_height = jQuery('.modal-header', this).height();

        jQuery(this).css('top', top_spacing + 'px');
        jQuery(this).css('height', dlg_height + 'px');
        jQuery(this).css('max-height', dlg_height + 'px');

        var height = (dlg_height - header_height - 25); // Some padding adjustment
        jQuery('.modal-body', this).css('max-height', height + 'px');
        jQuery('.modal-body', this).css('height', height + 'px');

        var additional_head_height = jQuery('.modal-body .additional-header', this).height();
        if(additional_head_height == null) { additional_head_height = 0; }
        var high_content_height = (height - additional_head_height);
        console.log(high_content_height);

        jQuery('.modal-body .high-content', this).css('max-height', high_content_height + 'px');
        jQuery('.modal-body .high-content', this).css('height', high_content_height + 'px');
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