<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class MVAMP_Ad_Embed extends AMP_Base_Embed_Handler {
	public function register_embed() {
	}

	public function unregister_embed() {
	}

	public function get_scripts() {
		return array( 'amp-ad' => 'https://cdn.ampproject.org/v0/amp-ad-0.1.js' );
	}
}


