<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
/********************* IDYLLIC CUSTOMIZER SANITIZE FUNCTIONS *******************************/
function idyllic_checkbox_integer( $input ) {
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

function idyllic_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

function idyllic_sanitize_latest_from_blog_select($input) {
	
	$input = sanitize_key( $input );
	return ( ( isset( $input ) && true == $input ) ? $input : '' );

}

function idyllic_numeric_value( $input ) {
	if(is_numeric($input)){
	return $input;
	}
}

function idyllic_sanitize_page( $input ) {
	if(  get_post( $input ) ){
		return $input;
	}
	else {
		return '';
	}
}

function idyllic_reset_alls( $input ) {
	if ( $input == 1 ) {
		delete_option( 'idyllic_theme_options');
		$input=0;
		return absint($input);
	} 
	else {
		return '';
	}
}