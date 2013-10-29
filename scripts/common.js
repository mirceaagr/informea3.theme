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

   /* jQuery('#search').typeahead({
        source: function ( query, process ) {
            console.log('asdasd');
            //searchPeople( query, process );
            var e = [];
            e.push("Alabama");
            process(e);
            return;
        },
        minLength: 1,
        updater: function (item) {
            console.log('selected id'+nameIdMap[item]);
            return item;
        }
    });*/
    jQuery('#search').on('keyup', function(){
        var term = jQuery(this).val();
        jQuery('#search-term').html(term);
        if (term.length > 1) {
            jQuery(this).siblings('ul.typeahead').show();
            search(term);
        } else {
            jQuery(this).siblings('ul.typeahead').hide();
        }
    });
});

function search(q){
    jQuery.ajax({
            url: i3_config_ajax.ajaxurl,
            data: {
                dataType: 'json',
                action: 'get_search_result',
                q: q
            }
        }).done(function(resp) {
            data = jQuery.parseJSON(resp);
            clear_search_result();

            if(data.treaties.length > 0) {
                jQuery('.typeahead-category.treaties-category').show();
                jQuery.each(data.treaties, function(index, treaty){
                   jQuery('.typeahead-category.treaties-category').after(create_li(treaty, 'treaty'));
                });
            } else {
                jQuery('.typeahead-category.treaties-category').hide();
            }
            if(data.countries.length > 0) {
                jQuery('.typeahead-category.countries-category').show();
                jQuery.each(data.countries, function(index, country){
                   jQuery('.typeahead-category.countries-category').after(create_li(country, 'country'));
                });
            } else {
                jQuery('.typeahead-category.countries-category').hide();
            }
            if(data.terms.length > 0) {
                jQuery.each(data.terms, function(index, term){
                   jQuery('.typeahead-category.terms-category').show();
                   jQuery('.typeahead-category.terms-category').after(create_li(term, 'term'));
                });
            } else {
                jQuery('.typeahead-category.terms-category').hide();
            }
        });
}
function create_li(item, type){
    var html = '<li class="'+ type +'-result">'+
                    '<a href="'+ item.display_link +'">';
    if ('display_logo' in item) {
        html += '<img class="logo logo-left" src="'+ item.display_logo +'" alt="'+ item.display_name +'"/>';
    }
        html +=  item.display_name +
                    '</a>'+
               '</li>';
    return html;
}
function create_li_no_result(type){
    return '<li class="'+ type +'-result">No results</li>';
}
function clear_search_result(){
    jQuery('.typeahead > .treaty-result').remove();
    jQuery('.typeahead > .country-result').remove();
    jQuery('.typeahead > .term-result').remove();
}
function toggle_filters(item){
    if (item.innerHTML === 'Show more') {
        item.innerHTML = 'Show less';
    } else {
        item.innerHTML = 'Show more';
    };
}
