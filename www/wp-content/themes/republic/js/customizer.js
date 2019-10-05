/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	 wp.customize("ads_code", function(value) {
        value.bind(function(newval) {
            $("#ads_code").html(newval);
        } );
    }); 

	wp.customize("shoplabel_front_color", function(value) {
        value.bind(function(newval) {
            $(".label.success").html(newval);
        } );
    });
	wp.customize("republic_logo", function(value) {
        value.bind(function(newval) {
            $("#republic_logo").html(newval);
        } );
    });
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
       
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
} )( jQuery );
