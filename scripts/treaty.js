jQuery(function() {
    var sticky_navigation_offset_top = jQuery('#sidebar-scroll').offset().top;
    var sticky_navigation = function(){
        var scroll_top = Math.floor(jQuery(window).scrollTop()),
        onePos = Math.floor(jQuery('#sidebar-scroll').offset().top+jQuery('#sidebar-scroll').outerHeight(true)),
        twoPos = Math.floor(jQuery('.footer').offset().top),
        container_min_size = 360,
        container_actual_size = jQuery('#treaty-container').height();
        if(container_actual_size >= container_min_size){
            if (scroll_top > sticky_navigation_offset_top) { 
                jQuery('#sidebar-scroll').css({'position':'fixed','top':'10px'});
                console.log(onePos);
                if(onePos >= twoPos) {
                    dif = Math.floor(onePos - twoPos) + 360;
                   if(dif <= jQuery('#sidebar-scroll').height()){
                     jQuery('#sidebar-scroll').css({'top':'-'+dif+'px'});
                   }else{
                     jQuery('#sidebar-scroll').hide();   
                   }
                }else{
                    jQuery('#sidebar-scroll').show('fast','linear');
                    jQuery('#sidebar-scroll').css({'margin-top':'10px'});
                }
            } else {
                jQuery('#sidebar-scroll').css({'position':'relative','top':'0'});
                jQuery('#sidebar-scroll').show('fast','linear');
            } 
        }
          
    };
    sticky_navigation();
    jQuery(window).scroll(function() {
         sticky_navigation();
    });
});