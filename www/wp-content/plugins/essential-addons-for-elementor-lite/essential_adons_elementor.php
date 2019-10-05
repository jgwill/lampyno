<?php
/**
 * Plugin Name: Essential Addons for Elementor
 * Description: The ultimate elements library for Elementor page builder plugin for WordPress.
 * Plugin URI: https://essential-addons.com/elementor/
 * Author: WPDeveloper
 * Version: 3.3.2
 * Author URI: https://wpdeveloper.net/
 *
 * Text Domain: essential-addons-elementor
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Defining plugin constants.
 *
 * @since 3.0.0
 */
define('EAEL_PLUGIN_FILE', __FILE__);
define('EAEL_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('EAEL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('EAEL_PLUGIN_URL', plugins_url('/', __FILE__));
define('EAEL_PLUGIN_VERSION', '3.3.2');
define('EAEL_ASSET_PATH', WP_CONTENT_DIR . '/uploads/essential-addons-elementor');
define('EAEL_ASSET_URL', WP_CONTENT_URL . '/uploads/essential-addons-elementor');

/**
 * Including composer autoloader globally.
 *
 * @since 3.0.0
 */
require_once EAEL_PLUGIN_PATH . 'autoload.php';

/**
 * Including plugin config.
 *
 * @since 3.0.0
 */
$GLOBALS['eael_config'] = require_once EAEL_PLUGIN_PATH . 'config.php';

/**
 * Run plugin after all others plugins
 *
 * @since 3.0.0
 */
add_action('plugins_loaded', function () {
    \Essential_Addons_Elementor\Classes\Bootstrap::instance();
});

/**
 * Plugin migrator
 *
 * @since v3.0.0
 */
add_action('wp_loaded', function () {
    $migration = new \Essential_Addons_Elementor\Classes\Migration;
    $migration->migrator();
});

/**
 * Activation hook
 *
 * @since v3.0.0
 */
register_activation_hook(__FILE__, function () {
    $migration = new \Essential_Addons_Elementor\Classes\Migration;
    $migration->plugin_activation_hook();
});

/**
 * Deactivation hook
 *
 * @since v3.0.0
 */
register_deactivation_hook(__FILE__, function () {
    $migration = new \Essential_Addons_Elementor\Classes\Migration;
    $migration->plugin_deactivation_hook();
});

/**
 * Upgrade hook
 *
 * @since v3.0.0
 */
add_action('upgrader_process_complete', function ($upgrader_object, $options) {
    $migration = new \Essential_Addons_Elementor\Classes\Migration;
    $migration->plugin_upgrade_hook($upgrader_object, $options);
}, 10, 2);