
(function( $ ) {

	// Site title.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-name-pr' ).text( to );
		});
	});

	// Site description.
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description-pr' ).text( to );
		});
	});

	//


} )( jQuery );
