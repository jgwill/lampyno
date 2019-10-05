<?php

namespace Mediavine;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class MV_ORM {
	public static function get_models() {
		add_action( 'admin_head', array( 'Mediavine\Create\Importer_Compatibility', 'deactivate_importer' ), 10, 2 );
	}
}
