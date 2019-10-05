<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class Importer_Compatibility {
	public static $checked = false;

	public static function is_importer_compatible() {
		$importer_compatible = true;
		$required_version    = '0.3.0';

		if ( class_exists( 'Mediavine\Create\Importer\Plugin' ) && version_compare( \Mediavine\Create\Importer\Plugin::VERSION, $required_version, '<' ) ) {
			$importer_compatible = false;
		}

		return $importer_compatible;
	}

	function deactivate_importer() {
		if ( ! self::$checked ) {
			if ( ! self::is_importer_compatible() ) {
				printf(
					'<div class="notice notice-error"><p>%1$s</p></div>',
					wp_kses_post( __( 'The currently installed version of <strong>Mediavine Recipe Importer</strong> is not compatible with <strong>Create by Mediavine</strong> and has been deactivated.', 'mediavine' ) )
				);

				$plugin_slug = 'mediavine-recipe-importers/mediavine-recipe-importer.php';
				deactivate_plugins( $plugin_slug );
			}
			self::$checked = true;
		}
	}
}
