jQuery(document).ready(function(){
    jQuery('.text-center a').each(function(index,a){
        jQuery(a).attr('href','javascript:void(0)');
    });

    // filters the countries in countries page
    jQuery('.text-center a').click(function(){
         jQuery('html,body').animate({scrollTop: offset - (offset * 0.3)}, 100);
        var alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        var id = jQuery(this).data('link');
        if(id == 'all'){
             jQuery.each(alphabet, function( index, value ) {
                jQuery('#'+value).show();
            });
        }else{
            jQuery.each(alphabet, function( index, value ) {
                jQuery('#'+value).hide();
            });
             jQuery('#'+id).show();
             var offset = jQuery('body').offset().top;
        }
    });
});
