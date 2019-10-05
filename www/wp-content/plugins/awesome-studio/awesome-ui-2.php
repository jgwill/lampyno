<?php
/*
Plugin Name: Awesome Studio
Plugin URI: http://www.getawesomestudio.com
Description: Awesome Studio is a shortcode based platfrom along with massive collection beautifullly designed, fully responsive and easy to use UI parts. 
Version: 2.4.4
Author: WPoets
Author URI: http://www.wpoets.com
License: GPLv2 or Later
*/

define('AW2_VERSION','2.4.4');

if(!class_exists('aw2_library'))
	require_once 'shortcodes/shortcodes.php';

if(!class_exists('Monoframe')) {
	require_once 'monoframe.php';
}

	
register_activation_hook( __FILE__,'awesome2_trigger::activation' );
register_activation_hook( __FILE__, array( 'AW_Studio', 'activation_check' ) );

add_action( 'in_plugin_update_message-awesome-studio/awesome-ui-2.php', array( 'AW_Studio', 'in_plugin_update_message' ) );

class AW_Studio {
	
	function __construct() {
        add_action( 'admin_init', array( $this, 'check_version' ) );
 
        // Don't run anything else in the plugin, if we're on an incompatible WordPress/PHP version
        if ( ! self::compatible_version() ) {
            return;
        }
    }
	
	// The primary sanity check, automatically disable the plugin on activation if it doesn't
    // meet minimum requirements.
    static function activation_check() {
        if ( ! self::compatible_version() ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die( __( 'Awesome Studio requires WordPress 4.3 or higher and PHP 5.6 or higher!', 'my-plugin' ) );
        }
		
		//create all_terms views needed by api to make filters faster
		self::create_views();
    }
	
	static function create_views(){
	
		global $wpdb;
		$prefix = $wpdb->prefix;
		
		$sql = "CREATE OR REPLACE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `all_terms`  AS  select `".$prefix."terms`.`term_id` AS `term_id`,`".$prefix."terms`.`name` AS `name`,`".$prefix."terms`.`slug` AS `slug`,`".$prefix."term_taxonomy`.`term_taxonomy_id` AS `term_taxonomy_id`,`".$prefix."term_relationships`.`object_id` AS `object_id`,`".$prefix."term_taxonomy`.`taxonomy` AS `taxonomy` from ((`".$prefix."term_relationships` join `".$prefix."term_taxonomy` on((`".$prefix."term_relationships`.`term_taxonomy_id` = `".$prefix."term_taxonomy`.`term_taxonomy_id`))) join `".$prefix."terms` on((`".$prefix."terms`.`term_id` = `".$prefix."term_taxonomy`.`term_id`)))";
		
		$wpdb->query($sql);
		
	}
 
    // The backup sanity check, in case the plugin is activated in a weird way,
    // or the versions change after activation.
    function check_version() {
        if ( ! self::compatible_version() ) {
            if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
                deactivate_plugins( plugin_basename( __FILE__ ) );
                add_action( 'admin_notices', array( $this, 'disabled_notice' ) );
                if ( isset( $_GET['activate'] ) ) {
                    unset( $_GET['activate'] );
                }
            }
        }
    }
 
    function disabled_notice() {
       echo '<strong>' . esc_html__( 'Awesome Studio requires WordPress 4.3 or higher and PHP 5.6 or higher!', 'my-plugin' ) . '</strong>';
    }
 
    static function compatible_version() {
        if ( version_compare( $GLOBALS['wp_version'], '4.3', '<' ) ) {
            return false;
        }
		
		if (version_compare(PHP_VERSION, '5.6.0') < 0) {
			return false;
		}

 
        // Add sanity checks for other version requirements here
 
        return true;
    }
	
	/**
	 * Show plugin changes.
	*/
	static function in_plugin_update_message( $args ) {
		$transient_name = 'aw_upgrade_notice_' . $args['Version'];

		if ( false === ( $upgrade_notice = get_transient( $transient_name ) ) ) {
			$response = wp_safe_remote_get( 'https://plugins.svn.wordpress.org/awesome-studio/trunk/readme.txt' );

			if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
				$upgrade_notice = self::parse_update_notice( $response['body'] );
				set_transient( $transient_name, $upgrade_notice, DAY_IN_SECONDS );
			}
		}

		echo wp_kses_post( $upgrade_notice );
	}

	/**
	 * Parse update notice from readme file
	 * @param  string $content
	 * @return string
	 */
	static function parse_update_notice( $content ) {
		// Output Upgrade Notice
		$matches        = null;
		$regexp         = '~==\s*Upgrade Notice\s*==\s*=\s*(.*)\s*=(.*)(=\s*' . preg_quote( AW2_VERSION ) . '\s*=|$)~Uis';
		$upgrade_notice = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$version = trim( $matches[1] );
			$notices = (array) preg_split('~[\r\n]+~', trim( $matches[2] ) );

			if ( version_compare( AW2_VERSION, $version, '<' ) ) {

				$upgrade_notice .= '<div style="background-color: #d54e21; padding: 10px; color: #f9f9f9; margin-top: 10px">';

				foreach ( $notices as $index => $line ) {
					$upgrade_notice .= wp_kses_post( preg_replace( '~\[([^\]]*)\]\(([^\)]*)\)~', '<a href="${2}">${1}</a>', $line ) );
				}

				$upgrade_notice .= '</div> ';
			}
		}

		return wp_kses_post( $upgrade_notice );
	}
	
}

$awe = new AW_Studio();