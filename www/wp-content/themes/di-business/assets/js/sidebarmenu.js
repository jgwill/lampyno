( function( $ ) {
	$(document).ready(function() {

		// Sidebar menu add remove class
		$('.side-menu-menu-button').on('click', function (e) {
			e.preventDefault();
			$( 'body' ).addClass( 'side-menu-show-menu' );
			$( '#side-menu-open-button' ).addClass( 'displaynon' );
		});

		$( '.side-menu-close-button' ).click(function(){
			$( 'body' ).removeClass( 'side-menu-show-menu' );
			$( '#side-menu-open-button' ).removeClass( 'displaynon' );
		});

	});
} )( jQuery );
