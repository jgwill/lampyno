jQuery(document).ready(function(){ 
 
 
	 //scroll up
	 
        jQuery(window).scroll(function(){
            if (jQuery(this).scrollTop() > 100) {
                jQuery('.scrollup').fadeIn();
            } else {
                jQuery('.scrollup').fadeOut();
            }
        }); 
 
        jQuery('.scrollup').click(function(){
            jQuery("html, body").animate({ scrollTop: 0 }, 600);
            return false;
        });
        
        });
		


// Ticker

(function($) {

    function tick(){
		$('.ticker li:first').slideUp( function () { $(this).appendTo($('.ticker')).slideDown(); });
	}
	setInterval(function(){ tick () }, 5000);
	
	})(jQuery);
	
	
