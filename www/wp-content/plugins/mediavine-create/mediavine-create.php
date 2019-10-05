<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://www.mediavine.com/
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Create by Mediavine
 * Plugin URI:        https://www.mediavine.com/mediavine-create/
 * Description:       Create custom recipe cards to be displayed in posts.
 * Version:           1.4.17

 * Author:            Mediavine
 * Author URI:        https://www.mediavine.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mediavine
 * Domain Path:       /languages
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

function mv_create_is_compatible() {
	global $wp_version;
	$wp         = '4.7';
	$php        = '5.4.45';
	$compatible = true;

	if ( version_compare( PHP_VERSION, $php ) < 0 ) {
		$compatible = false;
	}

	if ( version_compare( $wp_version, $wp ) < 0 ) {
		$compatible = false;
	}

	return $compatible;
}

function mv_create_incompatible_notice() {
	if ( ! mv_create_is_compatible() ) {
		printf(
			'<div class="notice notice-error"><p>%1$s</p></div>',
			wp_kses_post( __( '<strong>Create by Mediavine</strong> requires PHP 5.3.29 or higher, WordPress 4.7 or higher.  Please upgrade your hosting and/or WordPress.', 'mediavine' ) )
		);
		printf(
			'<div class="notice notice-error"><p><em>%1$s</em></p></div>',
			wp_kses_post( __( 'The plugin has been deactivated.', 'mediavine' ) )
		);
		deactivate_plugins( plugin_basename( __FILE__ ) );
		return;
	}
}

function mv_create_throw_warnings() {
	$compatible    = true;
	$missing_items = [];
	if ( ! extension_loaded( 'mbstring' ) ) {
		$missing_items[] = 'php-mbstring';
		$compatible      = false;
	}
	if ( ! extension_loaded( 'xml' ) ) {
		$missing_items[] = 'php-xml';
		$compatible      = false;
	}
	if ( $compatible || empty( $missing_items ) ) {
		return;
	}

	$message = trim( implode( ', ', $missing_items ), ', ' );
	printf(
		'<div class="notice notice-error"><p>%1$s</p></div>',
		wp_kses(
			sprintf(
				// translators: a list of disabled PHP extensions
				__( '<strong>Create by Mediavine</strong> requires the following disabled PHP extensions in order to function properly: <code>%1$s</code>.<br/><br/>Your hosting environment does not currently have these enabled.<br/><br/>Please contact your hosting provider and ask them to ensure these extensions are enabled.', 'mediavine' ),
				$message
			),
			[
				'strong' => [],
				'code'   => [],
				'br'     => [],
			]
		)
	);
	return;
}

function mv_create_add_action_links( $links ) {
	$create_links = array(
		'<a href="' . admin_url( 'options-general.php?page=mv_settings' ) . '">Settings</a>',
	);
	if ( class_exists( 'MV_Control_Panel' ) || class_exists( 'MVCP' ) ) {
		$create_links[] = '<a href="https://help.mediavine.com">Support</a>';
	}

	return array_merge( $links, $create_links );
}

function mv_create_plugin_info_links( $links, $file ) {
	if ( strpos( $file, 'mediavine-create.php' ) !== false ) {
		$new_links = array(
			'importers' => '<a href="https://www.mediavine.com/mediavine-recipe-importers-download" target="_blank">Download Mediavine Recipe Importers Plugin</a>',
		);
		$links     = array_merge( $links, $new_links );
	}

	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'mv_create_add_action_links' );
add_filter( 'plugin_row_meta', 'mv_create_plugin_info_links', 10, 2 );

add_action( 'admin_head', 'mv_create_incompatible_notice' );
add_action( 'admin_head', 'mv_create_throw_warnings' );

if ( ! mv_create_is_compatible() ) {
	return;
}

require_once( 'class-plugin.php' );

// Load i18n
function mv_create_load_plugin_textdomain() {
	load_plugin_textdomain( 'mediavine', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'mv_create_load_plugin_textdomain' );

/**
 * Gets a list of reviews by creation_id
 * @param integer $creation_id ID of Creation from which you want reviews.
 * @param array $args limit and offset to get max number or paginate (default 50, 0)
 * @return array Returns an array of objects
 */
function mv_create_get_reviews( $creation_id, $args = array() ) {
	return \Mediavine\Create\Reviews::get_reviews( $creation_id, $args );
}

/**
 * Gets a list of Creation IDs associated with a Post ID
 * @param integer $post_id ID of WP Post from which you want a list of Associated Creations.
 * @return array Returns an array of objects
 */
function mv_get_post_creations( $post_id ) {
	return \Mediavine\Create\Creations::get_creation_ids_by_post( $post_id );
}

/**
 * Gets a single creation by ID
 * @param  {number}  $id        Creation ID
 * @param  {boolean} $published Return published data
 * @return {object}             Card data
 */
function mv_create_get_creation( $id, $published = false ) {
	$creations_dbi = new \Mediavine\MV_DBI( 'mv_creations' );
	$creation      = $creations_dbi->find_one_by_id( $id );
	if ( $published ) {
		$published_content = '[]';
		if ( is_array( $creation ) && isset( $creation['published'] ) ) {
			$published_content = $creation['published'];
		}
		if ( is_object( $creation ) && isset( $creation->published ) ) {
			$published_content = $creation->published;
		}
		return json_decode( $published_content );
	}
	return $creation;
}

/**
 * Get a custom field registered to a creation
 *
 * @since 1.1.0
 * @param {string} $slug   Custom field slug
 * @param {number} $id     Creation ID
 * @param {mixed}          Value of field
 */
function mv_create_get_field( $id, $slug ) {
	$creation      = mv_create_get_creation( $id );
	$custom_fields = $creation->custom_fields;
	$parsed_data   = json_decode( $custom_fields );
	if ( empty( $parsed_data ) || empty( $parsed_data[ $slug ] ) ) {
		return null;
	}
	return $parsed_data[ $slug ];
}

/**
 * Declares that a theme supports integration with a particular version of Create skins.
 * (For now, if a theme integrates, just pass 'v1')
 *
 * If this is _not_ called in the theme's functions.php file, custom skins will _not_ override defaults.
 *
 * @since 1.1.0
 * @param  {string} $version  Compatible version
 * @return {void}
 */
function mv_create_theme_support( $version ) {
	add_filter(
		'mv_create_style_version',
		function() use ( $version ) {
			return $version;
		}
	);
}

/**
 * Register a custom field.
 *
 * A helper function to quickly register a custom field to the Custom Fields section of Create Cards.
 *
 * @since 1.1.0
 * @param array $field Refer to CustomFields.md for acceptable params
 * @return void
 */
function mv_create_register_custom_field( $field ) {
	add_filter(
		'mv_create_fields', function( $arr ) use ( $field ) {
			$arr[] = $field;
			return $arr;
		}
	);
}

// We go ahead and register a custom field for users
add_filter(
	'mv_create_fields', function( $arr ) {
	$arr[] = array(
		'slug'         => 'class',
		'label'        => __( 'CSS Class', 'mediavine' ),
		'instructions' => __( 'Add an additional CSS class to this card.', 'mediavine' ),
		'type'         => 'text',
	);
	$arr[] = array(
		'slug'         => 'mv_create_nutrition_disclaimer',
		'label'        => __( 'Custom Nutrition Disclaimer', 'mediavine' ),
		'instructions' => __( 'Example: Nutrition information isn’t always accurate.', 'mediavine' ),
		'type'         => 'textarea',
		'card'         => 'recipe',
	);
	$arr[] = array(
		'slug'         => 'mv_create_affiliate_message',
		'label'        => __( 'Custom Affiliate Message', 'mediavine' ),
		'instructions' => __( 'Override the default affiliate message for this card.', 'mediavine' ),
		'type'         => 'textarea',
		'card'         => array( 'recipe', 'diy' ),
	);
	return $arr;
	}
);

// Register default Create settings for Creation published data
add_filter(
	'mv_publish_create_settings', function ( $arr ) {
		// Get the authenticated user to assign the copyright attribution if none has been set in settings.
		$user = wp_get_current_user();
		$arr[ \Mediavine\Create\Plugin::$settings_group . '_copyright_attribution' ] = $user->display_name;

		// Assign the default settings. These can be overwritten by using this filter.
		foreach ( \Mediavine\Create\Plugin::$create_settings_slugs as $slug ) {
			$setting = \Mediavine\Settings::get_setting( $slug );
			if ( $setting ) {
				$arr[ $slug ] = $setting;
			}
		}
		return $arr;
	}
);
