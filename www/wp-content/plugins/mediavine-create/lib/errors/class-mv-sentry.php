<?php

namespace Mediavine\Create;

use Mediavine\Settings;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {
	class MV_Sentry {

		public $client;

		function __construct() {
			$this->client = $this->get_client();
		}

		private function get_client() {
			$dsn     = 'https://4df8f478a4c747d69b827c939337a0ca@sentry.io/1287304';
			$options = array(
				'release'     => \Mediavine\Create\Plugin::VERSION,
				'environment' => 'beta',
			);

			return new \Raven_Client( $dsn, $options );
		}

		public static function log( string $message, array $data, $level = 'info' ) {
			$logging_enabled = Settings::get_Setting( 'mv_create_enable_logging', false );

			if ( ! $logging_enabled ) {
				return;
			}

			$Sentry = new MV_Sentry;
			$Sentry->client->captureMessage( $message, null, (array) $data, $level );
		}
	}
}
