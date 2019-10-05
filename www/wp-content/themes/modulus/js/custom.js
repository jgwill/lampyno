(function($){

	$(function(){
		if( $.fn.flexslider ) {
           $('.flexslider').flexslider();
		}	
	});   

	$('.main-navigation a,.top-right a,.tagcloud a,.more-link').addClass("rippler rippler-default");

	  $(".rippler").rippler({
	    effectClass      :  'rippler-effect'
	    ,effectSize      :  0      // Default size (width & height)
	    ,addElement      :  'div'   // e.g. 'svg'(feature)
	    ,duration        :  400
	  });


})(jQuery);

// jQuery powered scroll to top

jQuery(document).ready(function(){

	//Check to see if the window is top if not then display button
	jQuery(window).scroll(function(){ 
		if (jQuery(this).scrollTop() > 100) {
			jQuery('.scroll-to-top').fadeIn();
		} else {
			jQuery('.scroll-to-top').fadeOut();  
		}
	});

	//Click event to scroll to top
	jQuery('.scroll-to-top').click(function(){
		jQuery('html, body').animate({scrollTop : 0},800);
		return false;
	});
	

});