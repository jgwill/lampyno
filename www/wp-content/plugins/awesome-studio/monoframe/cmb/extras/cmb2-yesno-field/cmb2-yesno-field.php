<?php
/*
Plugin Name: CMB Field YES NO
Plugin URI: https://github.com/pvmishra/cmb2-yesno-field
Description: Yes/No field type for Custom Metaboxes and Fields for WordPress.
Version: 1.0.0
Author: Pashupatinath Mishra
Author URI: http://pvmishra.blogspot.in/
License: GPLv2+
*/

class Own_Field_yesno {

	const VERSION = '0.1.0';

	public function hooks() {
		add_filter( 'cmb2_render_own_yesno',  array( $this, 'own_yesno_field' ), 10, 5 );
		add_filter( 'cmb2_sanitize_own_yesno', array( $this, 'sanitize' ), 10, 2 );
	}

	public function own_yesno_field( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {

		// Only enqueue scripts if field is used.
		$this->setup_admin_scripts();


		//Render the data
		$attributes = $field->args( 'attributes' );
		$dataon  = $attributes['data-on'] ? $attributes['data-on'] : "ON";
		$dataoff  = $attributes['data-off'] ? $attributes['data-off'] : "OFF";
		
		$checked = ($field_escaped_value=='on')?'checked="checked"':'';

		echo '<div class="onoffswitch">';
		echo '<input type="checkbox" class="own-yesno-field-value onoffswitch-checkbox" id="'. $field->args( 'id' ) .'" name="'. $field->args( 'id' ) .'" value="on" '. $checked .' >';

		echo '<label class="onoffswitch-label" for="'.$field->args( 'id' ).'">
        <span class="onoffswitch-inner" data-label="'. $dataoff .'"></span>
        <span class="onoffswitch-switch" data-label="'. $dataon .'"></span>
    </label>';
		echo '</div>';

		$field_type_object->_desc( true, true );
	}

	public function setup_admin_scripts( ) {
		
		wp_enqueue_style( 'cmb2_field_yesno_css', plugin_dir_url( __FILE__ ) . '/css/iphone.style.css', array(), self::VERSION );

	}

	public function sanitize( $override_value, $value ) {
		if(empty($value)){
			$value = "off";
		}
		else
		{
			$value = "on";

		}
	return $value;
	}
}
$own_field_yesno_object = new Own_Field_yesno;
$own_field_yesno_object->hooks();

