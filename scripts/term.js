jQuery('document').ready(function() {
    var current_term_id = jQuery('input[name=current_term_id]').val();
    jQuery('a[data-id='+ current_term_id +']').closest('li').addClass('active');
    jQuery('a[data-id='+ current_term_id +']').parents('ul.collapse').addClass('in').parent().children('button').removeClass('collapsed');
});