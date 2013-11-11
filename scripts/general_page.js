jQuery('document').ready(function() {
    var menu = jQuery('#menu-about-page-menu');

    if (jQuery('h2').length > 0) {
        //if existing h2 in content, make the affix menu
        jQuery('h2').each(function(idx, el) {
            if(typeof jQuery(el).attr('id') == 'undefined') {
                jQuery(this).attr('id','h2-'+idx);
            }
            var css = idx == 0 ? ' class="active"' : '';
            menu.append(jQuery('<li' + css + '><a href="#' + jQuery(this).attr('id') + '">' + jQuery(el).text() + '</a></li>'));
        });
    } else {
        //if no h2 in the content, hide the side affix div and make content div full width
        jQuery('.user-article').removeClass('span9').addClass('span12');
        jQuery('.affix-menu').hide();
    }
});