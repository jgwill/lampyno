<?php

namespace Mediavine\Create;

// Don't load just in case the autoload file gets removed
if ( ! file_exists( plugin_dir_path( __FILE__ ) . 'vendor/autoload.php' ) ) {
	return;
}

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Plugin {

	const VERSION = '1.4.17'; // {{-KERNL_VERSION-}} DO NOT REMOVE: WILL BE REPLACED IN BUILD

	const DB_VERSION = '1.4.17'; // {{-KERNL_VERSION-}} DO NOT REMOVE: WILL BE REPLACED IN BUILD

	const TEXT_DOMAIN = 'mediavine';

	const PLUGIN_DOMAIN = 'mv_create';

	const PREFIX = '_mv_';

	const PLUGIN_FILE_PATH = __FILE__;

	const PLUGIN_ACTIVATION_FILE = 'mediavine-create.php';

	const REQUIRED_IMPORTER_VERSION = '0.10.3';

	public $api_route = 'mv-create';

	public $api_version = 'v1';

	public static $db_interface = null;

	public static $api_services = null;

	public static $models = null;

	public static $models_v2 = null;

	public static $views = null;

	public static $settings = null;

	public static $settings_group = 'mv_create';

	public static $shapes = null;

	public static $mcp_enabled = false;

	public static $create_settings_slugs = array(
		'mv_create_affiliate_message',
		'mv_create_copyright_attribution',
	);

	public $rest_response = null;

	private static $instance = null;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$models   = new \Mediavine\Models();
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function assets_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Get MCP site id if it exists
	 *
	 * @return  string|false  Site id if it exists and MCP is active, or false
	 */
	public static function get_mcp_data() {
		$mcp_data = false;
		if ( self::$mcp_enabled ) {
			// TODO: Check if video support exists and is authorized with identity service
			$mcp_data = array( 'site_id' => get_option( 'MVCP_site_id' ) );
		}

		return $mcp_data;
	}

	public static function get_activation_path() {
		return dirname( __FILE__ ) . '/' . self::PLUGIN_ACTIVATION_FILE;
	}

	public function load_models() {
		$models_loader = new \Mediavine\Models();

		return $models_loader;
	}

	public function plugin_activation() {
		// This runs after all plugins are loaded so it can run after update
		if ( get_option( 'mv_create_version' ) === self::VERSION ) {
			return;
		}

		do_action( self::PLUGIN_DOMAIN . '_plugin_activated' );
		update_option( 'mv_create_version', self::VERSION );
		flush_rewrite_rules();
	}

	/**
	 * Flushes rewrite rules on deactivation
	 * @return void
	 */
	public function plugin_deactivation() {
		do_action( self::PLUGIN_DOMAIN . '_plugin_deactivated' );
		flush_rewrite_rules();
	}

	public function generate_tables() {
		\Mediavine\MV_DBI::upgrade_database_check( self::PLUGIN_DOMAIN, self::DB_VERSION );
	}

	public function init() {
		if (
			(
				class_exists( 'MV_Control_Panel' ) ||
				class_exists( 'MVCP' )
			) && get_option( 'MVCP_site_id' )
		) {
			self::$mcp_enabled = true;
		}
		self::$views        = \Mediavine\View_Loader::get_instance( plugin_dir_path( __FILE__ ) );
		self::$api_services = \Mediavine\API_Services::get_instance();
		self::$models_v2    = \Mediavine\MV_DBI::get_models(
			array(
				'mv_images',
				'mv_nutrition',
				'mv_products',
				'mv_products_map',
				'mv_reviews',
				'mv_creations',
				'mv_supplies',
				'mv_relations',
				'posts',
			)
		);

		self::$settings = array(
			array(
				'slug'  => self::$settings_group . '_default_access_role',
				'value' => 'manage_options',
				'group' => self::$settings_group . '_advanced',
				'order' => 10,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Default Access Role', 'mediavine' ),
					'instructions' => __( 'Select what user roles have access to edit Create Cards.', 'mediavine' ),
					'default'      => __( 'Administrators', 'mediavine' ),
					// QUESTION: Should these settings be created programmatically?
					'options'      => array(
						array(
							'label' => __( 'Administrators', 'mediavine' ),
							'value' => 'manage_options',
						),
						array(
							'label' => __( 'Editors', 'mediavine' ),
							'value' => 'edit_others_posts',
						),
						array(
							'label' => __( 'Authors', 'mediavine' ),
							'value' => 'edit_posts',
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_copyright_attribution',
				'value' => null,
				'group' => self::$settings_group . '_advanced',
				'order' => 15,
				'data'  => array(
					'type'         => 'text',
					'label'        => __( 'Default Copyright Attribution', 'mediavine' ),
					'instructions' => __( 'If left blank, the Create Card author will be displayed.', 'mediavine' ),
					'default'      => null,
				),
			),
			array(
				'slug'  => self::$settings_group . '_copyright_override',
				'value' => false,
				'group' => self::$settings_group . '_advanced',
				'order' => 16,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Override author', 'mediavine' ),
					'instructions' => __( 'Enabling this setting will cause the default copyright attribution to display instead of the author.', 'mediavine' ),
					'default'      => 'false',
					'dependent_on' => self::$settings_group . '_copyright_attribution',
				),
			),
			array(
				'slug'  => self::$settings_group . '_measurement_system',
				'value' => null,
				'group' => self::$settings_group,
				'order' => 20,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Measurement System', 'mediavine' ),
					'instructions' => __( 'Force a default measurement system (or choose "Any" to allow either).', 'mediavine' ),
					'default'      => null,
					'options'      => array(
						array(
							'label' => __( 'Metric', 'mediavine' ),
							'value' => 'metric',
						),
						array(
							'label' => __( 'Imperial', 'mediavine' ),
							'value' => 'imperial',
						),
						array(
							'label' => __( 'Any', 'mediavine' ),
							'value' => 'any',
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_photo_ratio',
				'value' => 'mv_create_no_ratio',
				'group' => self::$settings_group . '_display',
				'order' => 30,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Photo Ratio', 'mediavine' ),
					'instructions' => __( 'Select an aspect ratio for photo display. Some card styles, such as Classy Circle, will ignore this setting.', 'mediavine' ),
					'default'      => __( 'No fixed ratio', 'mediavine' ),
					'options'      => array(
						array(
							'label' => __( 'No fixed ratio', 'mediavine' ),
							'value' => 'mv_create_no_ratio',
						),
						array(
							'label' => '1x1',
							'value' => 'mv_create_1x1',
						),
						array(
							'label' => '4x3',
							'value' => 'mv_create_4x3',
						),
						array(
							'label' => '16x9',
							'value' => 'mv_create_16x9',
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_enable_print_thumbnails',
				'value' => true,
				'group' => self::$settings_group . '_display',
				'order' => 35,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Enable Print Thumbnails', 'mediavine' ),
					'instructions' => __( 'By default, card thumbnails will display in the print view. This can be disabled.', 'mediavine' ),
					'default'      => __( 'Enabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_pinterest_location',
				'value' => 'mv-pinterest-btn-right',
				'group' => self::$settings_group . '_display',
				'order' => 40,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Pinterest Button Location', 'mediavine' ),
					'instructions' => __( 'Select location for Pinterest button. Note: On the list card styles Numbered and Circles, the Pinterest button will still display to the right.', 'mediavine' ),
					'default'      => __( 'Top Right', 'mediavine' ),
					'options'      => array(
						array(
							'label' => __( 'Off', 'mediavine' ),
							'value' => 'off',
						),
						array(
							'label' => __( 'Top Left', 'mediavine' ),
							'value' => 'mv-pinterest-btn-left',
						),
						array(
							'label' => __( 'Inside Top Left', 'mediavine' ),
							'value' => 'mv-pinterest-btn-left-inside',
						),
						array(
							'label' => __( 'Inside Top Right', 'mediavine' ),
							'value' => 'mv-pinterest-btn-right-inside',
						),
						array(
							'label' => __( 'Top Right', 'mediavine' ),
							'value' => 'mv-pinterest-btn-right',
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_force_uppercase',
				'value' => true,
				'group' => self::$settings_group . '_display',
				'order' => 50,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Force Uppercase', 'mediavine' ),
					'instructions' => __( 'By default, recipe cards show some pieces of text as all-uppercase, which for certain typefaces may not be desired.', 'mediavine' ),
					'default'      => __( 'Enabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_aggressive_lists',
				'value' => false,
				'group' => self::$settings_group . '_display',
				'order' => 60,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Aggressive List CSS', 'mediavine' ),
					'instructions' => __( 'Some themes may remove bullets and numbers from lists. This forces them to display in Create by Mediavine Cards.', 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_aggressive_buttons',
				'value' => false,
				'group' => self::$settings_group . '_display',
				'order' => 70,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Aggressive Buttons CSS', 'mediavine' ),
					'instructions' => __( "Some themes may not have button styles, or they won't look good with your theme. This forces a generic button style.", 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_primary_headings',
				'value' => 'h2',
				'group' => self::$settings_group . '_advanced',
				'order' => 18,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Primary Heading Tag', 'mediavine' ),
					'instructions' => sprintf(
						// translators: Link tags
						__( 'While having %1$smultiple H1s on a page is approved by Google%2$s, many still recommend maintaining the page to only a single H1. This allows you to choose what tag you want for the primary heading, properly adjusting the heading hierarchy throughout the card.', 'mediavine' ),
						'<a href="https://www.youtube.com/watch?v=WsgrSxCmMbM" target="_blank">',
						'</a>'
					),
					'default'      => __( 'H2', 'mediavine' ),
					'options'      => array(
						array(
							'label' => 'H1',
							'value' => 'h1',
						),
						array(
							'label' => 'H2',
							'value' => 'h2',
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_enhanced_search',
				'value' => false,
				'group' => self::$settings_group . '_advanced',
				'order' => 80,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Use Enhanced Search', 'mediavine' ),
					'instructions' => __( 'Create by Mediavine has a search feature that allows users to match posts based on the content of the recipe cards included in the post. If you notice that this feature is causing an issue with other themes or plugins that modify the search query, you can disable this feature.', 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_autosave',
				'value' => true,
				'group' => self::$settings_group . '_advanced',
				'order' => 85,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Autosave', 'mediavine' ),
					'instructions' => __( 'By default, we\'ll save your work as you edit, even if you haven\'t published your changes. If you disable this setting, we\'ll only save draft content if you specifically click the \'Save Draft\' button.', 'mediavine' ),
					'default'      => __( 'Enabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_card_style',
				'value' => 'square',
				'group' => self::$settings_group . '_display',
				'order' => 90,
				'data'  => array(
					'type'    => 'image_select',
					'label'   => __( 'Card Style', 'mediavine' ),
					'default' => __( 'Simple Square', 'mediavine' ),
					'options' => array(
						array(
							'label' => __( 'Simple Square by Purr Design', 'mediavine' ),
							'value' => 'square',
							'image' => plugin_dir_url( __FILE__ ) . 'admin/img/card-style-default.png',
							/* translators: credit name and url */
							'title' => sprintf( __( 'Simple Square<br>by %s', 'mediavine' ), '<a href="https://www.purrdesign.com/" target="_blank">Purr Design<span class="dashicons dashicons-external"></span></a>' ),
						),
						array(
							'label' => __( 'Dark Simple Square by Purr Design', 'mediavine' ),
							'value' => 'dark',
							'image' => plugin_dir_url( __FILE__ ) . 'admin/img/card-style-dark.png',
							/* translators: credit name and url */
							'title' => sprintf( __( 'Dark Simple Square<br>by %s', 'mediavine' ), '<a href="https://www.purrdesign.com/" target="_blank">Purr Design<span class="dashicons dashicons-external"></span></a>' ),
						),
						array(
							'label' => __( 'Classy Circle by Purr Design', 'mediavine' ),
							'value' => 'centered',
							'image' => plugin_dir_url( __FILE__ ) . 'admin/img/card-style-centered.png',
							/* translators: credit name and url */
							'title' => sprintf( __( 'Classy Circle<br>by %s', 'mediavine' ), '<a href="https://www.purrdesign.com/" target="_blank">Purr Design<span class="dashicons dashicons-external"></span></a>' ),
						),
						array(
							'label' => __( 'Dark Classy Circle by Purr Design', 'mediavine' ),
							'value' => 'centered-dark',
							'image' => plugin_dir_url( __FILE__ ) . 'admin/img/card-style-centered-dark.png',
							/* translators: credit name and url */
							'title' => sprintf( __( 'Dark Classy Circle<br>by %s', 'mediavine' ), '<a href="https://www.purrdesign.com/" target="_blank">Purr Design<span class="dashicons dashicons-external"></span></a>' ),
						),
						array(
							'label' => __( 'Hero Image by Purr Design', 'mediavine' ),
							'value' => 'big-image',
							'image' => plugin_dir_url( __FILE__ ) . 'admin/img/card-style-big-image.png',
							/* translators: credit name and url */
							'title' => sprintf( __( 'Hero Image<br>by %s', 'mediavine' ), '<a href="https://www.purrdesign.com/" target="_blank">Purr Design<span class="dashicons dashicons-external"></span></a>' ),
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_color',
				'value' => null,
				'group' => self::$settings_group . '_display',
				'order' => '0',
				'data'  => array(
					'type'         => 'color_picker',
					'label'        => __( 'Theme Colors' ),
					'instructions' => null,
				),
			),
			array(
				'slug'  => self::$settings_group . '_secondary_color',
				'value' => null,
				'group' => 'mv_create_hidden',
				'order' => '0',
				'data'  => array(),
			),
			array(
				'slug'  => self::$settings_group . '_enable_high_contrast',
				'value' => false,
				'group' => self::$settings_group . '_advanced',
				'order' => 10,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Enable High Contrast', 'mediavine' ),
					'instructions' => __( 'By default, high contrast mode is disabled.', 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_lists_rounded_corners',
				'value' => '0',
				'group' => self::$settings_group . '_lists',
				'order' => 95,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Rounded Corners', 'mediavine' ),
					'instructions' => __( 'This value is used for buttons and other card elements.', 'mediavine' ),
					'default'      => __( 'None', 'mediavine' ),
					'options'      => array(
						array(
							'label' => __( 'High', 'mediavine' ),
							'value' => '1rem',
						),
						array(
							'label' => __( 'Low', 'mediavine' ),
							'value' => '3px',
						),
						array(
							'label' => __( 'None', 'mediavine' ),
							'value' => '0',
						),
					),
				),
			),
			array(
				'slug'  => self::$settings_group . '_external_link_tab',
				'value' => true,
				'group' => self::$settings_group . '_lists',
				'order' => 100,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Open external list items in new tab', 'mediavine' ),
					'instructions' => __( 'Checking the box will open external list items in a new tab', 'mediavine' ),
					'default'      => __( 'Enabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_internal_link_tab',
				'value' => false,
				'group' => self::$settings_group . '_lists',
				'order' => 100,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Open internal list items in new tab', 'mediavine' ),
					'instructions' => __( 'Checking the box will open internal list items in a new tab', 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_enable_nutrition',
				'value' => true,
				'group' => self::$settings_group . '_recipes',
				'order' => 95,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Use Nutrition', 'mediavine' ),
					'instructions' => __( 'Unchecking the box will remove nutrition inputs from the recipe card interface and hide nutrition data for all recipes.', 'mediavine' ),
					'default'      => __( 'Enabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_allow_reviews',
				'value' => true,
				'group' => self::$settings_group . '_advanced',
				'order' => 100,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Allow Reviews', 'mediavine' ),
					'instructions' => __( 'Unchecking this box will prevent users from being able to leave reviews on your recipe cards.', 'mediavine' ),
					'default'      => __( 'Enabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_use_realistic_nutrition_display',
				'value' => false,
				'group' => self::$settings_group . '_recipes',
				'order' => 98,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Use Traditional Nutrition Display', 'mediavine' ),
					'instructions' => __( 'Checking the box will add a traditional nutrition display.', 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_nutrition_disclaimer',
				'value' => '',
				'group' => self::$settings_group . '_recipes',
				'order' => 99,
				'data'  => array(
					'type'         => 'textarea',
					'label'        => __( 'Calculated Nutrition Disclaimer', 'mediavine' ),
					'instructions' => __( 'If provided, this disclaimer will be automatically added to each recipe upon nutrition calculation.', 'mediavine' ),
					'default'      => '',
					'dependent_on' => self::$settings_group . '_api_token',
				),
			),
			array(
				'slug'  => self::$settings_group . '_enable_logging',
				'value' => false,
				'group' => self::$settings_group . '_advanced',
				'order' => 105,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Enable Error Reporting', 'mediavine' ),
					'instructions' => __( 'Checking this box allows the plugin to automatically send useful error reports to the development team. (You may still be prompted to manually send error reports, even if this box is unchecked.)', 'mediavine' ),
					'default'      => __( 'Disabled', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_affiliate_message',
				'value' => 'As an Amazon Associate and member of other affiliate programs, I earn from qualifying purchases.',
				'group' => self::$settings_group . '_advanced',
				'order' => 80,
				'data'  => array(
					'type'         => 'textarea',
					'label'        => __( 'Global Affiliate Message', 'mediavine' ),
					'instructions' => __( 'Set the default affiliate disclaimer message with this text. Affiliate messaging can be overridden in individual posts.', 'mediavine' ),
					// No localization because the default value does not get translated.
					'default'      => 'As an Amazon Associate and member of other affiliate programs, I earn from qualifying purchases.',
				),
			),
			array(
				'slug'  => self::$settings_group . '_allowed_types',
				'value' => '[]',
				'group' => self::$settings_group . '_advanced',
				'order' => 0,
				'data'  => array(
					'type'         => 'allowed_types',
					'label'        => __( 'Allowed Types', 'mediavine' ),
					'instructions' => null,
					'default'      => '[]',
				),
			),
			array(
				'slug'  => self::$settings_group . '_enable_review_prompt_always',
				'value' => true,
				'group' => self::$settings_group . '_advanced',
				'order' => 110,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Always Enable Review Popup', 'mediavine' ),
					'instructions' => __( 'If enabled, users leaving a star rating will see a popup modal prompting them to leave an optional review. Disabling this will not display the prompt if the left rating is 4 or higher.', 'mediavine' ),
					'default'      => 'Enabled',
				),
			),
			array(
				'slug'  => self::$settings_group . '_enable_public_reviews',
				'value' => false,
				'group' => self::$settings_group . '_advanced',
				'order' => 120,
				'data'  => array(
					'type'         => 'checkbox',
					'label'        => __( 'Enable Public Reviews', 'mediavine' ),
					'instructions' => __( 'If enabled, card reviews will be publicly visible, displayed in a tab alongside comments. You must specify a DOM selector for your comments section.' ),
					'default'      => 'Disabled',
				),
			),
			array(
				'slug'  => self::$settings_group . '_public_reviews_el',
				'value' => '#comments',
				'group' => self::$settings_group . '_advanced',
				'order' => 125,
				'data'  => array(
					'type'         => 'text',
					'label'        => __( 'Comments Section', 'mediavine' ),
					// TODO: Add a link to help.mediavine.com
					'instructions' => __( 'Add the DOM selector of your comments section. (In most themes, this will be "#comments".)' ),
					'default'      => '#comments',
					'dependent_on' => self::$settings_group . '_enable_public_reviews',
				),
			),
			array(
				'slug'  => self::$settings_group . '_custom_buttons',
				'value' => 'Read More\nGet Recipe',
				'group' => self::$settings_group . '_lists',
				'order' => 126,
				'data'  => array(
					'type'         => 'custom_buttons',
					'label'        => __( 'Button Action Defaults', 'mediavine' ),
					'instructions' => __( 'Add options for the Button Action dropdown in list items. Add a new line between items.' ),
					'default'      => '',
				),
			),
			array(
				'slug'  => self::$settings_group . '_api_token',
				'value' => null,
				'group' => self::$settings_group . '_api',
				'order' => 105,
				'data'  => array(
					'type'         => 'api_authentication',
					'label'        => __( 'Product Registration', 'mediavine' ),
					'instructions' => __( 'In order to use services like nutrition calculation or link scraping, you must register an account. This is a free, one-time action that will grant access to all of our external APIs.', 'mediavine' ),
				),
			),
			array(
				'slug'  => self::$settings_group . '_api_email_confirmed',
				'value' => false,
				'group' => 'hidden',
				'order' => 105,
				'data'  => array(),
			),
			array(
				'slug'  => self::$settings_group . '_api_user_id',
				'value' => false,
				'group' => 'hidden',
				'order' => 105,
				'data'  => array(),
			),
		);

		if ( class_exists( 'MV_Control_Panel' ) || class_exists( 'MVCP' ) ) {
			self::$settings[] = array(
				'slug'  => self::$settings_group . '_ad_density',
				'value' => '583',
				'group' => self::$settings_group . '_mvp',
				'order' => 100,
				'data'  => array(
					'type'         => 'select',
					'label'        => __( 'Ad Density', 'mediavine' ),
					'instructions' => __( 'Choose the density of ads in a recipe card.', 'mediavine' ),
					'default'      => __( 'Normal', 'mediavine' ),
					'options'      => array(
						array(
							'label' => __( 'Single Ad', 'mediavine' ),
							'value' => '0',
						),
						array(
							'label' => __( 'Normal', 'mediavine' ),
							'value' => '583',
						),
						array(
							'label' => __( 'Medium', 'mediavine' ),
							'value' => '750',
						),
						array(
							'label' => __( 'Low', 'mediavine' ),
							'value' => '1000',
						),
					),
				),
				self::$settings[] = array(
					'slug'  => self::$settings_group . '_list_items_between_ads',
					'value' => '3',
					'group' => self::$settings_group . '_mvp',
					'order' => 110,
					'data'  => array(
						'type'         => 'select',
						'label'        => __( 'List Items Between Ads', 'mediavine' ),
						'instructions' => __( 'Choose the number of card between ads in a list.', 'mediavine' ),
						'options'      => array(
							array(
								'label' => __( '2', 'mediavine' ),
								'value' => '2',
							),
							array(
								'label' => __( '3', 'mediavine' ),
								'value' => '3',
							),
							array(
								'label' => __( '4', 'mediavine' ),
								'value' => '4',
							),
							array(
								'label' => __( '5', 'mediavine' ),
								'value' => '5',
							),
						),
					),
				),
			);
		}

		// Shape implementation is very, very temp
		self::$shapes = array(
			array(
				'name'   => 'Recipe',
				'plural' => 'Recipes',
				'slug'   => 'recipe',
				'icon'   => 'carrot',
				'shape'  => file_get_contents( __DIR__ . '/shapes/recipe.json' ),
			),
			array(
				'name'   => 'How-To',
				'plural' => 'How-Tos',
				'slug'   => 'diy',
				'icon'   => 'lightbulb',
				'shape'  => file_get_contents( __DIR__ . '/shapes/how-to.json' ),
			),
			array(
				'name'   => 'List',
				'plural' => 'Lists',
				'slug'   => 'list',
				'icon'   => '',
				'shape'  => file_get_contents( __DIR__ . '/shapes/list.json' ),
			),
		);

		register_activation_hook( self::get_activation_path(), array( $this, 'plugin_activation' ) );
		add_action( 'setup_theme', array( $this, 'plugin_activation' ), 10, 2 );
		register_deactivation_hook( self::get_activation_path(), array( $this, 'plugin_deactivation' ) );

		// Activations hooks, forcing order
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', array( $this, 'generate_tables' ), 20 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', array( $this, 'create_settings' ), 30 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', array( $this, 'create_shapes' ), 35 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', array( $this, 'republish_queue' ), 40 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', array( $this, 'update_reviews_table' ), 50 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', array( $this, 'importer_admin_notice' ), 60 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', [ $this, 'fix_cloned_ratings' ], 70 );
		add_action( self::PLUGIN_DOMAIN . '_plugin_activated', [ $this, 'fix_cookbook_canonical_post_ids' ], 80 );

		// Shortcodes
		add_shortcode( 'mv_img', array( $this, 'mv_img_shortcode' ) );
		add_shortcode( 'mvc_ad', array( $this, 'mvc_ad_shortcode' ) );

		add_filter( 'rest_prepare_post', array( $this, 'rest_prepare_post' ), 10, 3 );
	}

	/**
	 * Updates Create Services Site ID with php, create and wp versions
	 *
	 * @return void
	 */
	function update_services_api() {
		global $wp_version;
		$php_version       = PHP_VERSION;
		$create_version    = Plugin::VERSION;
		$api_token_setting = \Mediavine\Settings::get_settings( 'mv_create_api_token' );

		if ( ! $api_token_setting ) {
			return;
		}

		$token_values = explode( '.', $api_token_setting->value );

		if ( empty( $token_values[1] ) ) {
			return;
		}

		$token_data = json_decode( base64_decode( $token_values[1] ) );

		if ( ! isset( $token_data->site_id ) ) {
			return;
		}

		$data = array();

		if ( isset( $php_version ) ) {
			$data['php_version'] = PHP_VERSION;
		}

		if ( isset( $wp_version ) ) {
			$data['wp_version'] = $wp_version;
		}

		if ( isset( $create_version ) ) {
			$data['create_version'] = $create_version;
		}

		$result = wp_remote_post(
			'https://create-api.mediavine.com/api/v1/sites/' . $token_data->site_id, array(
				'headers' => array(
					'Content-Type'  => 'application/json; charset=utf-8',
					'Authorization' => 'bearer ' . $api_token_setting->value,
				),
				'body'    => wp_json_encode( $data ),
				'method'  => 'POST',
			)
		);
		return;
	}

	public function mv_img_shortcode( $atts ) {
		$a = shortcode_atts(
			array(
				'id'      => null,
				'options' => null,
			), $atts
		);
		if ( isset( $a['id'] ) ) {
			if ( isset( $a['options'] ) ) {
				$meta    = wp_prepare_attachment_for_js( $a['id'] );
				$alt     = $meta['alt'];
				$title   = $meta['title'];
				$options = json_decode( $a['options'] );
				$img     = get_image_tag( $a['id'], $alt, $title, $options->alignment, $options->size );
			} else {
				$img = wp_get_attachment_image( $a['id'], '' );
			}
			return $img;
		}
		return '';
	}

	/**
	 * In 1.4.12, we moved ad insertion logic from the admin UI to the client, see #2860.
	 * This shortcode output is intentionally left empty to provide backwards compatibility
	 * with content that includes the old ad target shortcode.
	 */
	public function mvc_ad_shortcode() {
		return '';
	}

	public function create_settings() {
		$settings = $this->update_settings( self::$settings );
		\Mediavine\Settings::create_settings_filter( $settings );
	}

	public function create_shapes() {
		$shape_dbi = new \Mediavine\MV_DBI( 'mv_shapes' );

		foreach ( self::$shapes as $shape ) {
			$shape_dbi->upsert( $shape );
		}
	}

	/**
	 * Migrates old settings to newer versions within settings table
	 *
	 * Always check for less than current version as this is run before the version is updated
	 * Add estimated removal date (6 months) so we don't clutter code with future publishes
	 * Remove code within this function, but don't remove this function
	 *
	 * Example usage:
	 * ```
	 * if ( version_compare( $last_plugin_version, '1.0.0', '<' ) ) {
	 *     $settings = \Mediavine\Settings::migrate_setting_value( $settings, self::$settings_group . '_slug', 'old_value', 'new_value' );
	 *     $settings = \Mediavine\Settings::migrate_setting_slug( $settings, self::$settings_group . '_old_slug', self::$settings_group . '_new_slug' );
	 * }
	 * ```
	 *
	 * @param   array  $settings  Current list of settings before running create settings
	 * @return  array             List of settings after migrated changes made
	 */
	public function update_settings( $settings ) {
		$last_plugin_version = get_option( 'mv_create_version', Plugin::VERSION );

		// Update incorrect card style slug of mv_create to square (Remove Jan 2020)
		if ( version_compare( $last_plugin_version, '1.4.8', '<' ) ) {
			$settings = \Mediavine\Settings::migrate_setting_value( $settings, self::$settings_group . '_card_style', 'mv_create', 'square' );
		}

		return $settings;
	}

	/**
	 * Republishes create cards depending on plugin version
	 *
	 * Always check for less than current version as this is run before the version is updated
	 * Add estimated removal date (6 months) so we don't clutter code with future publishes
	 * Remove code within this function, but don't remove this function
	 *
	 * @return  void
	 */
	public function republish_queue() {
		global $wpdb;
		$creations           = new \Mediavine\MV_DBI( 'mv_creations' );
		$last_plugin_version = get_option( 'mv_create_version', Plugin::VERSION );

		// Update JSON-LD with correct contentUrl data for videos in cards (Remove November 2019)
		if ( version_compare( $last_plugin_version, '1.3.22', '<' ) ) {
			$args = array(
				'select' => array( 'id' ),
				'limit'  => 10000,
			);
			$ids  = array_values( wp_list_pluck( $creations->find( $args ), 'id' ) );
			if ( ! empty( $ids ) ) {
				\Mediavine\Create\Publish::update_publish_queue( $ids );
			}
		}

		// Add associated_posts key to creations that are embedded in posts as `mv_recipe` shortcodes (remove September 2019)
		if ( version_compare( $last_plugin_version, '1.3.13', '<' ) ) {
			$statement = "SELECT ID, post_content
				FROM {$wpdb->posts}
				WHERE post_content LIKE '%[mv_recipe%'";
			$posts     = $wpdb->get_results( $statement );
			$recipes   = [];
			if ( $posts ) {
				foreach ( $posts as $post ) {
					$re = '/\[mv_recipe[\s\S]post_id="(\d+)"/';
					if ( preg_match( $re, $post->post_content, $match ) ) {
						if ( ! empty( $match[1] ) ) {
							$recipes[ $match[1] ][] = $post->ID;
						}
					}
				}
			}
			if ( $recipes ) {
				foreach ( $recipes as $recipe_id => $post_ids ) {
					$creation            = $creations->find_one(
						[
							'col' => 'original_object_id',
							'key' => $recipe_id,
						]
					);
					$original_associated = json_decode( $creation->associated_posts, true );
					$original_associated = ! empty( $original_associated ) && is_array( $original_associated ) ? $original_associated : [];
					$associated_posts    = array_merge( $post_ids, $original_associated );
					$creations->update(
						[
							'id'               => $creation->id,
							'associated_posts' => wp_json_encode( $associated_posts ),
						]
					);
				}
			}
		}
	}

	/**
	 * Display importer download admin notice
	 *
	 * @return void
	 */
	public function importer_admin_notice_display() {
		printf(
			'<div class="notice notice-info"><p><strong>%1$s</strong></p><p>%2$s</p></div>',
			wp_kses_post( __( 'Thanks for installing Create by Mediavine!', 'mediavine' ) ),
			wp_kses_post(
				sprintf(
					/* translators: %1$s: linked importer plugin */
					__( 'If you\'re moving from another recipe plugin, you can also download and install our %1$s.', 'mediavine' ),
					'<a href="https://www.mediavine.com/mediavine-recipe-importers-download" target="_blank">' . __( 'importer plugin', 'mediavine' ) . '</a>'
				)
			)
		);
	}

	/**
	 * Display importer download admin notice if plugin not active
	 *
	 * @return void
	 */
	public function importer_admin_notice() {
		if ( ! class_exists( 'Mediavine\Create\Importer\Plugin' ) ) {
			add_action( 'admin_notices', array( $this, 'importer_admin_notice_display' ) );
		}
	}

	/**
	 * Fixes reviews that were imported from other plugins.
	 *
	 * Importers were assigning a `recipe_id` to imported reviews instead of `creation`.
	 * This caused reviews to not show up, even though they'd been imported.
	 * This method fixes that by reassigning imported reviews.
	 *
	 * Remove Apr 2019
	 *
	 * @since 1.1.1
	 *
	 * @return {void}
	 */
	public function update_reviews_table() {
		global $wpdb;
		$last_plugin_version = get_option( 'mv_create_version', Plugin::VERSION );

		if ( version_compare( $last_plugin_version, '1.2.0', '<' ) ) {
			// Not all users had the plugin when `recipe_id` was a column in the `mv_reviews` table.
			// Check for this column before trying to update it.
			$has_recipe_id_column_statement = "SHOW COLUMNS FROM {$wpdb->prefix}mv_reviews LIKE 'recipe_id'";
			$has_recipe_id_column           = $wpdb->get_row( $has_recipe_id_column_statement );
			if ( ! $has_recipe_id_column ) {
				return;
			}

			$statement = "UPDATE {$wpdb->prefix}mv_reviews a
							INNER JOIN {$wpdb->prefix}mv_reviews b on a.id = b.id
							SET a.creation = b.recipe_id
							WHERE b.recipe_id";
			$wpdb->query( $statement );
		}
	}

	/**
	 * Fixes cloned cards' ratings.
	 *
	 * Previously, cloned cards retained the originating card's `rating` and `rating_count`
	 * attributes, giving the client-facing card the appearance of its ratings having been
	 * duplicated. Resetting the count resolves this issue.
	 *
	 * Remove November 2019
	 *
	 * @since 1.3.20
	 *
	 * @return void
	 */
	public function fix_cloned_ratings() {
		global $wpdb;
		$last_plugin_version = get_option( 'mv_create_version', Plugin::VERSION );

		if ( version_compare( $last_plugin_version, '1.3.20', '<' ) ) {
			$creations_with_ratings = $wpdb->get_results(
				"SELECT id as creation FROM {$wpdb->prefix}mv_creations WHERE rating AND rating_count;"
			);
			$model                  = new Reviews_Models();
			foreach ( $creations_with_ratings as $review ) {
				$model->update_creation_rating( $review );
			}
		}
	}

	/**
	 * Fixes canonical post ids of imported Cookbook recipes.
	 *
	 * Recipes imported from Cookbook were using the Cookbook recipe id as the canonical_post_id.
	 * Obviously, this was not good, so we need to fix that.
	 *
	 * Remove December 2019
	 *
	 * @since 1.4.6
	 *
	 * @return void
	 */
	public function fix_cookbook_canonical_post_ids() {
		global $wpdb;
		$last_plugin_version = get_option( 'mv_create_version', Plugin::VERSION );

		if ( version_compare( $last_plugin_version, '1.4.6', '<' ) ) {
			$creations = $wpdb->get_results(
				"SELECT * FROM {$wpdb->prefix}mv_creations WHERE type='recipe' AND metadata LIKE '%cookbook%' AND metadata NOT LIKE '%fixed_canonical_post_id%'",
				ARRAY_A
			);
			$ids       = [];
			foreach ( $creations as $creation ) {
				$post     = get_post( $creation['canonical_post_id'] );
				$metadata = json_decode( $creation['metadata'] );
				$posts    = json_decode( $creation['associated_posts'] );
				if ( 'cookbook_recipe' === $post->post_type && ! empty( $posts ) ) {
					$creation['canonical_post_id'] = $posts[0];
				}
				$metadata->fixed_canonical_post_id = true;
				$creation['metadata']              = wp_json_encode( $metadata );
				self::$models_v2->mv_creations->update( $creation );
				$ids[] = $creation->id;
			}
			\Mediavine\Create\Publish::update_publish_queue( $ids );
		}
	}

	/**
	 * Extend default REST API with useful data.
	 *
	 * @param [object] $data the current object outbound to rest response
	 * @param [object] $post post object for use in the outbound response
	 * @param [object] $request the wp rest request object.
	 * @return [object] update $data object
	 */
	public function rest_prepare_post( $data, $post, $request ) {
		$_data                        = $data->data;
		$_data['mv']                  = array();
		$_data['mv']['thumbnail_id']  = null;
		$_data['mv']['thumbnail_uri'] = null;

		$thumbnail_id = get_post_thumbnail_id( $post->ID );

		if ( empty( $thumbnail_id ) ) {
			$data->data = $_data;
			return $data;
		}

		$thumbnail                   = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
		$_data['mv']['thumbnail_id'] = $thumbnail_id;

		if ( isset( $thumbnail[0] ) ) {
			$_data['mv']['thumbnail_uri'] = $thumbnail[0];
		}

		$data->data = $_data;
		return $data;
	}

}

$Plugin = Plugin::get_instance();
$Plugin->init();

$Images = new \Mediavine\Images();
$Images->init();

$Settings = new \Mediavine\Settings();
$Settings->init();

$Nutrition = new Nutrition();
$Nutrition->init();

$Products = new Products();
$Products->init();

$Products_Map = new Products_Map();
$Products_Map->init();

$Relations = new Relations();
$Relations->init();

$Reviews_Models = new Reviews_Models();
$Reviews_Models->init();

$Reviews_API = new Reviews_API();
$Reviews_API->init();

$Reviews = new Reviews();
$Reviews->init();

$Shapes    = Shapes::get_instance();
$Creations = Creations::get_instance();
$Supplies  = Supplies::get_instance();

$Admin_Init = new Admin_Init();
$Admin_Init->init();
