jQuery('document').ready(function() {
    jQuery('#treaty-nfp-country-select').on('change', function(){
        get_country_nfp_from_treaty(jQuery(this).val());
    });

   /*Fixes the bug when page loads, the tab li is not set active*/
   jQuery('#sites ul>li:first a').tab('show');
   jQuery('#membership ul>li:first a').tab('show');
   jQuery('#ecolex_literature ul>li:first a').tab('show');

   /*fix a bug where last link from afix is preactivated (if affix has more than 4 li)*/
   jQuery('.affix-menu a[href="#ecolex_literature"]').delay(100).parent().removeClass('active');
});

function get_country_nfp_from_treaty(id_treaty){
    jQuery.ajax({
            url: i3_config_ajax.ajaxurl,
            data: {
                dataType: 'html',
                action: 'get_country_nfp_from_treaty',
                id_treaty: id_treaty,
                id_country: jQuery('#id_country').val()
            }
        }).done(function(resp) {
            jQuery('#focal-point-list').html(resp);
            jQuery('#treaty-nfp-country-count').html(jQuery('#focal-point-list>li.focal-point').length);
            var $option = jQuery('#treaty-nfp-country-select').find(':selected');
            jQuery('#country-treaty-nfp-link').attr('href', $option.attr('data-url'));
            jQuery('#country-nfp-treaty-logo').attr('src', $option.attr('data-src'));
        });
}

