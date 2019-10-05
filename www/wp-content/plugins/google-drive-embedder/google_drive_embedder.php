<?php

/**
 * Plugin Name: Google Drive Embedder
 * Plugin URI: http://wp-glogin.com/drive
 * Description: Easily browse for Google Drive documents and embed directly in your posts and pages. Extends the popular Google Apps Login plugin so no extra user authentication (or admin setup) is required. Compatible With Gutenberg Editor WordPress
 * Version: 5.1
 * Author: Lever Technology LLC
 * Author URI: http://wp-glogin.com/
 * License: GPL3
 */

if (class_exists('core_google_drive_embedder')) {
	global $gdm_core_already_exists;
	$gdm_core_already_exists = true;
}
else {
	require_once( plugin_dir_path( __FILE__ ) . '/core/core_google_drive_embedder.php' );
}

class gdm_basic_google_drive_embedder extends core_google_drive_embedder {

	protected $PLUGIN_VERSION = '5.1';

	// Singleton
	private static $instance = null;
	
	public static function get_instance() {
		if (null == self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	// Basic specific
	
	protected function get_extra_js_name() {
		return 'basic';
	}
	
	// ADMIN
	
	protected function get_options_name() {
		return 'gdm_basic';
	}
	
	protected function gdm_mainsection_text() {
		?>
		<p>There are no settings to configure in this free version of Google Drive Embedder.</p>
		<p>Please 
		<a href="http://wp-glogin.com/drive/?utm_source=Drive%20Settings&utm_medium=freemium&utm_campaign=Drive" target="_blank">visit our website</a> 
		for more details of our premium and enterprise versions.</p>
		
		<h3>Premium Version</h3>
		<ul>
			<li><b>My Drive:</b> locate files to embed by browsing your Drive, searching, or looking through starred/recent files - just like on Drive itself.</li>
			<li><b>Embed Folders:</b> simply keep your Google Drive folder up-to-date with your files, and your staff or website visitors will always be able to view a list of the latest documents.
			For more advanced folder integration please take a look at the Enterprise version.</li>
			<li><b>Calendars:</b> pick from your Google Calendars and provide download links to ICAL or XML, or embed them directly in your site.</li>
    		<li><b>Support and updates for one year.</b></li>
    		
    		<p><a href="http://wp-glogin.com/drive/?utm_source=Drive%20Settings&utm_medium=freemium&utm_campaign=Drive" target="_blank">Click here for details or purchase</a></p>
		</ul>
		
		<h3>Enterprise Version</h3>
		<p>Google Drive is a versatile way to store files and share with colleagues, while your intranet is clearer and 
		better structured for sharing more focused information. But using both at the same time can lead to confusion about 
		where information is stored.</p>

		<p>Wouldn't it be great if your intranet could be used to control and structure the information your organization
		 stores in Drive?</p>

		<p>Our Enterprise version of Google Drive Embedder integrates Drive much more closely with your WordPress intranet,
		 essentially allowing each page or post on your intranet to host its own file attachments, completely backed by 
		 Drive.</p>

		<p>This means you no longer need to manage Drive and your Intranet as two completely separate document sharing systems!
		</p>
		
		<p>Drive Embedder Enterprise has all the features of the premium and basic versions - easily embed files from Google Drive 
		into your WordPress site - plus much more advanced folder embedding. This starts with much slicker styling. 
		Instead of embedding folders as iframes, they are built directly into your WordPress pages, meaning users can
		click into subfolders and preview files without leaving your website.</p>

        <p>Supports Google's new <b>Team Drives</b>.</p>
		
		<b>Includes support and updates for one year.</b>
		
		<p><a href="http://wp-glogin.com/drive/?utm_source=Drive%20Settings%20Enterprise&utm_medium=freemium&utm_campaign=Drive" target="_blank">Click here for details or purchase</a></p>
		<?php
	}
	
	// Don't need a submit button here
	protected function gdm_options_submit() {
	}
	
	// AUX
	
	protected function my_plugin_basename() {
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
function GoogleDriveEmbedder() {
	return gdm_basic_google_drive_embedder::get_instance();
}

// Initialise at least once
GoogleDriveEmbedder();

?>