jQuery('document').ready(function() {

    var $window = jQuery(window);
    // Set the focus on the search box on every page
    jQuery('input#search').focus();
    jQuery('.scrollspy').scrollspy();
    jQuery('.informea-tooltip').tooltip();

    setTimeout(function () {
        jQuery('.affix-menu').affix({
            offset: {
                top: function () { return $window.width() <= 980 ? 220 : 180 },
                bottom: 100
            }
        })
    }, 100);
});
