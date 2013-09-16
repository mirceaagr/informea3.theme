jQuery('document').ready(function() {
    var menu = jQuery('#menu-about-page-menu');
    jQuery('h2').each(function(idx, el) {
        if(jQuery(el).attr('id')) {
            var css = idx == 0 ? ' class="active"' : '';
            menu.append(jQuery('<li' + css + '><a href="#' + jQuery(el).attr('id') + '">' + jQuery(el).text() + '</a></li>'));
        }
    });
});