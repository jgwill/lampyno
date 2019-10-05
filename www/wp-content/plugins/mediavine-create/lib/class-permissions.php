<?php

	namespace Mediavine;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( ! class_exists( 'Mediavine\Permissions' ) ) {

	class Permissions {

		public static function is_user_authorized( $api = null ) {

			$user = wp_get_current_user();

			$user_role_setting = \Mediavine\Settings::get_settings( 'mv_create_default_access_role' . $user->ID );

			if ( ! empty( $user_role_setting ) ) {
				return current_user_can( $user_role_setting->value );
			}

			\Mediavine\Settings::get_settings( 'mv_create_default_access_role' );

			if ( ! empty( $user_role_setting ) ) {
				return current_user_can( $user_role_setting->value );
			}

			return current_user_can( 'publish_posts' );
		}

		public static function access_level() {

			$Settings = new MV_DBI( 'mv_settings' );

			$user_role_setting = $Settings->find_one(
				array(
					'col' => 'slug',
					'key' => 'mv_create_default_access_role',
				)
			);

			if ( $user_role_setting ) {
				return $user_role_setting->value;
			}

			return 'publish_posts';
		}



	}
}
