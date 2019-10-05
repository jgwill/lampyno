(function($){
	// Sticky Header Options 

	$(window).scroll(function() {
    if ($(this).scrollTop() > 150){  
        $('.nav-wrap').addClass("sticky-nav");
      }
      else{
        $('.nav-wrap').removeClass("sticky-nav");
      }
   });

})(jQuery); 