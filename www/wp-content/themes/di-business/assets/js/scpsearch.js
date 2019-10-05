( function( $ ) {
	$(document).ready(function() {

		$( '#scp-btn-search' ).click(function() {
			$( '.scp-search' ).addClass( 'scp-search--open' );
			$( '.scp-search .scp-search__input' ).focus();
		});

		$( '#scp-btn-search-close' ).click(function() {
			$( '.scp-search' ).removeClass( 'scp-search--open' );
			$( '.scp-search .scp-search__input' ).blur();
		});

		document.addEventListener('keyup', function(scp_ev) {
				// escape key.
				if( scp_ev.keyCode == 27 ) {
					$( '.scp-search' ).removeClass( 'scp-search--open' );
					$( '.scp-search .scp-search__input' ).blur();
				}
			});

		});
} )( jQuery );
