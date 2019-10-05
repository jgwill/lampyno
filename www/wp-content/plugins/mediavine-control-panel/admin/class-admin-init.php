<?php

namespace Mediavine\Control_Panel;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( class_exists( '\MV_Control_Panel' ) ) {

	class Admin_Init extends \MV_Control_Panel {

		private $includes = array(
			'lib/settings/class-settings.php',
		);

		function __construct() {
			$this->load_dependencies();
		}

		private static function localize() {

			$access_token = null;
			$token_id     = null;

			$token_data = \Mediavine\MCP\Settings::read( 'mcp-services-api-token' );

			if ( isset( $token_data->value ) ) {
				$access_token = $token_data->value;
				$token_id     = $token_data->id;
			}

			$user = wp_get_current_user();

			$idstring = \base64_encode(
				wp_json_encode(
					array(
						'login' => $user->user_login,
						'id'    => $user->ID,
					)
				)
			);

			return array(
				'root'              => esc_url_raw( rest_url() ),
				'nonce'             => wp_create_nonce( 'wp_rest' ),
				'asset_url'         => self::assets_url() . 'admin/ui/build/',
				'admin_url'         => esc_url_raw( admin_url() ),
				'mcp_api_token'     => $access_token,
				'platform_auth_url' => 'https://publisher-identity.mediavine.com/?auth=' . $idstring . '&redirect=' . esc_url_raw( admin_url() . 'admin-ajax.php?action=mv_identity' ),
				'platform_api_root' => 'https://publisher-identity.mediavine.com/',
			);
		}

		private function load_dependencies() {
			foreach ( $this->includes as $file ) {
				$filepath = plugin_dir_path( __DIR__ ) . $file;
				if ( ! $filepath ) {
					triggor_error( sprintf( 'Error location %s for inclusion', $file ), E_USER_ERROR );
				}
				require_once $filepath;
			}
		}

		function admin_enqueue( $hook ) {

			wp_register_style( 'mv-font/open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' );

			$script_url = self::assets_url() . 'admin/ui/build/app.build.' . self::VERSION . '.js';

			if ( defined( 'ENV' ) ) {
				$script_url = '//localhost:3001/app.build.' . self::VERSION . '.js';
			}

			$access_token = null;
			$token_id     = null;

			$token_data = \Mediavine\MCP\Settings::read( 'mv_identity_bearer_token' );

			if ( isset( $token_data->value ) ) {
				$access_token = $token_data->value;
				$token_id     = $token_data->id;
			}

			wp_register_script( self::PLUGIN_DOMAIN . '/mv-mcp.js', $script_url, array(), self::VERSION, true );
			wp_localize_script( self::PLUGIN_DOMAIN . '/mv-mcp.js', 'mvMCPApiSettings', self::localize() );

			if ( 'mv_recipes_page_mv_recipe_cards_importer_import' !== $hook ) {
				wp_enqueue_style( self::PLUGIN_DOMAIN . '/mv-mcp.css', self::assets_url() . 'admin/ui/build/app.build.' . self::VERSION . '.css', array( 'mv-font/open-sans' ), self::VERSION );
				wp_enqueue_script( self::PLUGIN_DOMAIN . '/mv-mcp.js' );
			}

		}

		function admin_footer() {
			echo '<div id="mcp-gb-modal"></div>';
		}

		/**
		 * Add Access All header if needed
		 */
		function api_cors() {
			header( 'Access-Control-Allow-Origin: *' );
		}

		function video_shortcode_div() {
			?>
				<div id="MVVideoShortcode" class="mv-ui"></div>
			<?php
		}

		function block_editor_assets() {
			$handle     = 'mcp-blocks';
			$script_url = plugins_url( 'admin/ui/build/blocks.build.' . self::VERSION . '.js', __DIR__ );

			if ( defined( 'ENV' ) ) {
				$script_url = '//localhost:3001/blocks.build.' . self::VERSION . '.js';
			}

			wp_enqueue_script(
				$handle,
				$script_url,
				array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Gutenberg dependencies
				self::VERSION,
				true
			);

			wp_localize_script( $handle, 'mvMCPApiSettings', self::localize() );

		}

		function add_tmce_stylesheet( $mceInit ) {
			if ( empty( $mceInit['content_css'] ) ) {
				$mceInit['content_css'] = '';
			}
			$mceInit['content_css'] .= ', ' . self::assets_url() . 'admin/ui/public/mcp-tinymce.css?' . '0.1.1';

			return $mceInit;
		}

		function init() {
			add_action( 'media_buttons', array( $this, 'video_shortcode_div' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
			add_action( 'admin_footer', array( $this, 'admin_footer' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_assets' ) );
			add_filter( 'tiny_mce_before_init', array( $this, 'add_tmce_stylesheet' ) );
		}

	}

}
