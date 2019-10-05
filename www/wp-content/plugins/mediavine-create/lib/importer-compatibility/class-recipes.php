<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class Recipes {
	public function __construct() {
		add_action( 'admin_head', array( 'Mediavine\Create\Importer_Compatibility', 'deactivate_importer' ), 10, 2 );
	}
}
