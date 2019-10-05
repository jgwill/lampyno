<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * No Idea?.
 *
 * @category     WordPress_Plugin
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */

/**
 * Base Utility class for MCP.
 *
 * @category     WordPress_Plugin
 * @package      Mediavine Control Panel
 * @author       Mediavine
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link         https://www.mediavine.com
 */
require_once( 'class-mv-base.php' );

if ( ! class_exists( 'MV_Extension' ) ) {

	/**
	 * No Idea.
	 *
	 * @category     WordPress_Plugin
	 * @package      Mediavine Control Panel
	 * @author       Mediavine
	 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
	 * @link         https://www.mediavine.com
	 */
	class MV_Extension extends MV_Base {
	}
}


