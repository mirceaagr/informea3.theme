jQuery(function() {
    var sidebar = jQuery('#sidebar-scroll'),
    sticky_navigation_offset_top = sidebar.offset().top;
    var sticky_navigation = function(){
        var scroll_top = Math.floor(jQuery(window).scrollTop()),
        onePos = Math.floor(sidebar.offset().top+sidebar.outerHeight(true)),
        twoPos = Math.floor(jQuery('.footer').offset().top),
        container_min_size = 360,
        container_actual_size = jQuery('#treaty-container').height();
        if(container_actual_size >= container_min_size){
            if (scroll_top > sticky_navigation_offset_top) { 
                sidebar.css({'position':'fixed','top':'10px'});
                if(onePos >= twoPos) {
                    dif = Math.floor(onePos - twoPos) + 360;
                   if(dif <= sidebar.height()){
                     sidebar.css({'top':'-'+dif+'px'});
                   }else{
                     sidebar.hide();   
                   }
                }else{
                    sidebar.show('fast','linear');
                    sidebar.css({'margin-top':'10px'});
                }
            } else {
                sidebar.css({'position':'relative','top':'0'});
                sidebar.show('fast','linear');
            } 
        }
          
    };
    jQuery(window).scroll(function() {
         sticky_navigation();
    });
});