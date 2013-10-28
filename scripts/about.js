jQuery('document').ready(function() {
    var menu = jQuery('#menu-about-page-menu');
    jQuery('h2').each(function(idx, el) {
        if(typeof jQuery(el).attr('id') == 'undefined') {
            jQuery(this).attr('id','h2-'+idx);
        }
        var css = idx == 0 ? ' class="active"' : '';
        menu.append(jQuery('<li' + css + '><a href="#' + jQuery(this).attr('id') + '">' + jQuery(el).text() + '</a></li>'));
    });
});