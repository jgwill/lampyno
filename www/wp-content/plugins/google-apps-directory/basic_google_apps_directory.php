<?php

/**
 * Plugin Name: Google Apps Directory
 * Plugin URI: http://wp-glogin.com/directory/
 * Description: Search your G Suite (Google Apps) domain for employee info from a widget
 * Version: 1.6.1
 * Author: Lever Technology LLC
 * Author URI: http://wp-glogin.com/
 * Text Domain: google-apps-directory
 * License: GPL3
 * Network: true
 */

if (class_exists('core_google_apps_directory')) {
	global $gad_core_already_exists;
	$gad_core_already_exists = true;
}
else {
	require_once( plugin_dir_path( __FILE__ ) . '/core/core_google_apps_directory.php' );
}

class basic_google_apps_directory extends core_google_apps_directory {
	
	protected $PLUGIN_VERSION = '1.6.1';
	
	// Singleton
	private static $instance = null;
	
	public static function get_instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	// Admin options

	protected function gad_pretab_options_text() {
		?>
		<p><b>For full support, and Enterprise features giving a complete full-page browsable employee directory, please visit:
				<a href="https://wp-glogin.com/directory/?utm_source=Admin%20Dir&utm_medium=freemium&utm_campaign=Freemium" target="_blank">https://wp-glogin.com/directory/</a></b>
		</p>
		<?php
	}

	// AUX
	
	public function my_plugin_basename() {
		$basename = plugin_basename(__FILE__);
		if ('/'.$basename == __FILE__) { // Maybe due to symlink
			$basename = basename(dirname(__FILE__)).'/'.basename(__FILE__);
		}
		return $basename;
	}
	
	protected function my_plugin_url() {
		$basename = plugin_basename(__FILE__);
		if ('/'.$basename == __FILE__) { // Maybe due to symlink
			return plugins_url().'/'.basename(dirname(__FILE__)).'/';
		}
		// Normal case (non symlink)
		return plugin_dir_url( __FILE__ );
	}

}

// Global accessor function to singleton
function gadbasicGoogleAppsDirectory() {
	return basic_google_apps_directory::get_instance();
}

// Initialise at least once
gadbasicGoogleAppsDirectory();

