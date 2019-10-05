( function( $ ) {
	$(document).ready(function() {
			
		//Add img-fluid class to all images
		 $('body img').addClass("img-fluid");
		 // Remove img-fluid class for elementor content.
		 $('body.elementor-page .elementor img').removeClass('img-fluid');

		// Title in tooltip for top bar right icons
		$('.iconouter a[title]').tooltip( {placement: "bottom"} );

		// Nav Main DD Toggle
		$( ".navbarprimary .dropdowntoggle" ).click(function() {
			if( $(this).parent('li').hasClass('navbarprimary-open') ) {
				$(this).parent('li').removeClass('navbarprimary-open');
			} else {
				$(this).parent('li').addClass('navbarprimary-open');
			}

			if( $(this).children('span').hasClass('fa-chevron-circle-down') ) {
				$(this).children('span').removeClass('fa-chevron-circle-down');
				$(this).children('span').addClass('fa-chevron-circle-right');
			} else {
				$(this).children('span').removeClass('fa-chevron-circle-right');
				$(this).children('span').addClass('fa-chevron-circle-down');
			}
			
			return false;
		});
		
			
	});
} )( jQuery );
