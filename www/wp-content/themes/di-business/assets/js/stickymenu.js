( function( $ ) {
	$(document).ready(function() {
		
		if( $(window).width() > 943 ) {
			
			var h = $('.navbarouter').offset().top;
			
			var placeholder = document.createElement('div');
			placeholder.setAttribute("class", "menuplaceholder");
			placeholder.style.width = $('.navbarouter').width() + 'px';
			placeholder.style.height = $('.navbarouter').height() + 'px';
			
			$(window).scroll(function () {
				if( $(this).scrollTop() > h )
				{
					$('.navbarouter').addClass('sticky_menu_top');
					$('.navbarouter').after(placeholder);
					$('.menuplaceholder').css('display','block');
				}
				else
				{
					$('.navbarouter').removeClass('sticky_menu_top');
					$('.menuplaceholder').css('display','none');
				}
				
			});
		}
	});
})( jQuery );
