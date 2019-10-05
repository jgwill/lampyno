<?php

namespace Mediavine\Create;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class Admin_Init extends Plugin {

	public static $mcp_data = null;

	/**
	 * Manages default custom field registration.
	 */
	public static function custom_fields() {
		$fields = array();
		$fields = apply_filters( 'mv_create_fields', $fields );
		return $fields;
	}

	/**
	 * Gets localization data needed for both Gutenberg and general scripts
	 */
	public static function localization() {
		global $wpdb;
		$settings       = \Mediavine\Settings::get_settings();
		$shapes         = \Mediavine\Create\Shapes::get_shapes();
		self::$mcp_data = self::get_mcp_data();

		$authors = get_users(
			array(
				'who'    => 'authors',
				'fields' => array( 'display_name' ),
			)
		);

		foreach ( $authors as &$author ) {
			$author = $author->display_name;
		}

		$key_match_statement = "SELECT id, original_object_id from {$wpdb->prefix}mv_creations WHERE original_object_id";
		$results             = $wpdb->get_results( $key_match_statement );
		$keys                = array();
		foreach ( $results as $result ) {
			$keys[ $result->original_object_id ] = $result->id;
		}

		$current_user = wp_get_current_user();

		return array(
			'__URL__'           => esc_url_raw( rest_url() ),
			'__NONCE__'         => wp_create_nonce( 'wp_rest' ),
			'__ADMIN_URL__'     => esc_url_raw( admin_url() ),
			'__STATIC__'        => plugin_dir_url( __FILE__ ) . 'ui/static',
			'__SETTINGS__'      => $settings,
			'__SHAPES__'        => $shapes,
			'__AUTHORS__'       => $authors,
			'__MCP__'           => self::$mcp_data,
			'__KEY_LOOKUP__'    => $keys,
			'__CUSTOM_FIELDS__' => self::custom_fields(),
			'__I18N__'          => self::internationalization(),
			'__USER__'          => array(
				'current_user_email'  => $current_user->user_email,
				'current_firstname'   => $current_user->user_firstname,
				'current_lastname'    => $current_user->user_lastname,
				'site_url'            => site_url(),
				'mediavine_publisher' => self::$mcp_enabled,
			),
			'__FLAGS__'         => [
				'NO_DOM_DOC' => class_exists( 'DOMDocument' ) === false,
			],
		);
	}

	public static function internationalization() {
		return array(
			// Add New UI
			'ADD_NEW'                     => __( 'Add New', 'mediavine' ),
			'ADD_CARD'                    => __( 'Add Card', 'mediavine' ),
			'EDIT_CARD_IN_POST'           => __( 'Edit card in post', 'mediavine' ),
			'SELECT_EXISTING'             => __( 'Select Existing', 'mediavine' ),
			'CHOOSE_EXISTING'             => __( 'Choose an existing card', 'mediavine' ),
			'ADD_NEW_TYPE_PROMPT'         => __( 'What would you like to create?', 'mediavine' ),
			/* translators: adding a new card */
			'ADD_NEW_NAME_PROMPT'         => __( 'Name your %s:', 'mediavine' ),
			'ADD_NEW_BRACKET_WARNING'     => __( 'Titles can\'t contain brackets.', 'mediavine' ),
			'ADD_NEW_NO_TITLE_WARNING'    => __( 'Add a title first!', 'mediavine' ),
			'TITLE_VALIDATION_TOOLTIP'    => __( 'Please enter a title.', 'mediavine' ),
			'ADD_FIRST_CARD_PROMPT'       => __( 'Create your first card. What card would you like to create?', 'mediavine' ),
			/* translators: adding first card title */
			'FIRST_CARD_TITLE_PROMPT'     => __( 'Create your first %s. What would you like to title it?', 'mediavine' ),
			/* translators: adding new card title */
			'ADD_NEW_TITLE_PROMPT'        => __( 'What\'s the title of your %s?', 'mediavine' ),
			/* translators: type of new card */
			'ADD_NEW_BUTTON_TEXT'         => __( 'Create %s Card', 'mediavine' ),
			'ADD_NEW_DIFF_TYPE'           => __( 'Create a different card', 'mediavine' ),
			// Save/Publish/draft actions
			'PUBLISH'                     => __( 'Publish', 'mediavine' ),
			'PUBLISHING'                  => __( 'Publishing', 'mediavine' ),
			'PUBLISHED'                   => __( 'Published', 'mediavine' ),
			'PUBLISH_AND_INSERT'          => __( 'Publish and Insert', 'mediavine' ),
			'SAVE_DRAFT'                  => __( 'Save Draft', 'mediavine' ),
			'SAVING_DRAFT'                => __( 'Saving Draft', 'mediavine' ),
			'SAVE_CHANGES'                => __( 'Save Changes', 'mediavine' ),
			'SAVING_CHANGES'              => __( 'Saving Changes', 'mediavine' ),
			'CHANGES_SAVED'               => __( 'Changes Saved', 'mediavine' ),
			'DRAFT_SAVED'                 => __( 'Draft Saved', 'mediavine' ),
			'SAVING'                      => __( 'Saving', 'mediavine' ),
			'SAVED'                       => __( 'Saved!', 'mediavine' ),
			'DIET'                        => __( 'Diet', 'mediavine' ),
			'TIMES'                       => __( 'Times', 'mediavine' ),
			'TOTAL_TIME'                  => __( 'Total Time', 'mediavine' ),
			'PREP_TIME'                   => __( 'Prep Time', 'mediavine' ),
			'COOK_TIME'                   => __( 'Cook Time', 'mediavine' ),
			'ACTIVE_TIME'                 => __( 'Active Time', 'mediavine' ),
			'ADDITIONAL_TIME'             => __( 'Additional Time', 'mediavine' ),
			'REORDER_TIMES'               => __( 'You can reorder times by dragging.', 'mediavine' ),
			'NOTES'                       => __( 'Notes', 'mediavine' ),
			'NOTES_PLACEHOLDER'           => __( 'Write additional notes', 'mediavine' ),
			'KEYWORDS'                    => __( 'Keywords', 'mediavine' ),
			'INSTRUCTIONS'                => __( 'Instructions', 'mediavine' ),
			/* translators: type -> product/group/step */
			'ADD_NEW_THING'               => __( 'Add New %s', 'mediavine' ),
			/* translators: type -> product/group/step */
			'ADD_THING'                   => __( 'Add %s', 'mediavine' ),
			'ADD_STEP'                    => __( 'Add Step', 'mediavine' ),
			'ADD_ONE'                     => __( 'Add One', 'mediavine' ),
			/* translators: type -> product/group/step */
			'REMOVE_ALL'                  => __( 'Delete all %s', 'mediavine' ),
			// Editor Utilities
			'CANONICAL_POST'              => __( 'Canonical Post', 'mediavine' ),
			'CANONICAL_INSTRUCTIONS'      => __( 'If this Creation is used on multiple pages, the selected canonical post will help search engines determine the preferred URL.', 'mediavine' ),
			'SCHEMA_VALIDATION'           => __( 'Schema Validation', 'mediavine' ),
			'VALIDATION_INSTRUCTIONS'     => __( 'Check your content against Google\'s structured data testing utility. You may need to enable pop-ups.', 'mediavine' ),
			'SCHEMA_VALIDATION_BUTTON'    => __( 'Validate JSON-LD', 'mediavine' ),
			'JSONLD_SCHEMA_BUTTON'        => __( 'JSON-LD Schema', 'mediavine' ),
			'RICH_SNIPPET_BUTTON'         => __( 'Rich Snippet', 'mediavine' ),
			'RICH_SNIPPET_VALIDATION'     => __( 'Validate Rich Snippet', 'mediavine' ),
			'WARNING_NO_BRACKETS'         => __( 'Brackets are not allowed in titles.', 'mediavine' ),
			'SHORTCODE'                   => __( 'Shortcode', 'mediavine' ),
			'SHORTCODE_INSTRUCTIONS'      => __( 'You can copy and paste this shortcode into editors that support it.', 'mediavine' ),
			'COPIED'                      => __( 'Copied!', 'mediavine' ),
			'UTILITIES'                   => __( 'Utilities', 'mediavine' ),
			'CUSTOM_FIELDS'               => __( 'Custom Fields', 'mediavine' ),
			'RECIPE'                      => __( 'Recipe', 'mediavine' ),
			'RECIPE_INFORMATION'          => __( 'Recipe Information', 'mediavine' ),
			'HOW-TO_INFORMATION'          => __( 'How-To Information', 'mediavine' ),
			'NUTRITION'                   => __( 'Nutrition', 'mediavine' ),
			'NUTRITION_INFORMATION'       => __( 'Nutrition Information', 'mediavine' ),
			'VIDEO'                       => __( 'Video', 'mediavine' ),
			'VIDEO_URL'                   => __( 'Video URL', 'mediavine' ),
			'SEO/SOCIAL'                  => __( 'SEO & Social Media', 'mediavine' ),
			/* translators: removing an item */
			'REMOVE_PROMPT'               => __( 'Remove "%s"', 'mediavine' ),
			'USE_JSON-LD?'                => __( 'Use Schema (LD+JSON)', 'mediavine' ),
			'PINTEREST_OPTIONS'           => __( 'Pinterest Options', 'mediavine' ),
			// Editor UI
			/* translators: type -> item, product, group, step*/
			'NEW_THING'                   => __( 'New %s', 'mediavine' ),
			'TITLE'                       => __( 'Title', 'mediavine' ),
			'DESCRIPTION'                 => __( 'Description', 'mediavine' ),
			'DESCRIPTION_PLACEHOLDER'     => __( 'Description is required.', 'mediavine' ),
			'DEFAULT_ATTRIBUTION_TOOLTIP' => __( 'If left blank, we\'ll use the default copyright attribution from your settings.', 'mediavine' ),
			'THUMBNAIL_TOOLTIP'           => __( 'Select a thumbnail from your media library.', 'mediavine' ),
			'NEW_OPTION_TOOLTIP'          => __( 'You can create a new option by typing.', 'mediavine' ),
			'SCHEMA_DISPLAY_TOOLTIP'      => __( 'Disable for non-human food recipes (e.g. pet treats, soaps)', 'mediavine' ),
			'SCHEMA_DISPLAY_LISTS'        => __( 'Disable for content you don\'t want search engines to index as a rich snippet. By default, JSON-LD is only included on the canonical post for this list.', 'mediavine' ),
			'CARD_SEARCH_PLACEHOLDER'     => __( 'Search for a title, ingredient, author, etc...', 'mediavine' ),
			// Taxonomies
			'AUTHOR'                      => __( 'Author', 'mediavine' ),
			'CATEGORY'                    => __( 'Category', 'mediavine' ),
			'CUISINE'                     => __( 'Cuisine', 'mediavine' ),
			'PROJECT_TYPE'                => __( 'Project Type', 'mediavine' ),
			'DIFFICULTY'                  => __( 'Difficulty', 'mediavine' ),
			'COST'                        => __( 'Cost', 'mediavine' ),
			'ESTIMATED_COST'              => __( 'Estimated Cost', 'mediavine' ),
			'YIELD'                       => __( 'Yield', 'mediavine' ),
			'MAKES'                       => __( 'Makes', 'mediavine' ),
			'IMAGE'                       => __( 'Image', 'mediavine' ),
			// Labels
			'INGREDIENTS'                 => __( 'Ingredients', 'mediavine' ),
			'MATERIALS'                   => __( 'Materials', 'mediavine' ),
			'TOOLS'                       => __( 'Tools', 'mediavine' ),
			'PINTEREST_TOOLTIP'           => __( 'You can manually override the default options for sharing on Pinterest. These values are only shown to users when sharing.', 'mediavine' ),
			'DIET_INSTRUCTIONS'           => __( 'This is only shown to search engines, not users. If your recipe matches multiple diets, list them in the Keywords field.', 'mediavine' ),
			// Diets
			'VEGETARIAN'                  => __( 'Vegetarian', 'mediavine' ),
			'VEGAN'                       => __( 'Vegan', 'mediavine' ),
			'LOW_SALT'                    => __( 'Low Salt', 'mediavine' ),
			'LOW_LACTOSE'                 => __( 'Low Lactose', 'mediavine' ),
			'LOW_FAT'                     => __( 'Low Fat', 'mediavine' ),
			'LOW_CALORIE'                 => __( 'Low Calorie', 'mediavine' ),
			'KOSHER'                      => __( 'Kosher', 'mediavine' ),
			'HINDU'                       => __( 'Hindu', 'mediavine' ),
			'HALAL'                       => __( 'Halal', 'mediavine' ),
			'GLUTEN_FREE'                 => __( 'Gluten-Free', 'mediavine' ),
			'DIABETIC'                    => __( 'Diabetic Diet', 'mediavine' ),
			'N/A'                         => __( 'N/A', 'mediavine' ),
			'DISCLAIMER'                  => __( 'Disclaimer', 'mediavine' ),
			'NUTRITION_DISCLAIMER_GLOBAL' => __( 'You can set this value globally at Settings > Create Settings > Recipes!', 'mediavine' ),
			'NUTRITION_DISCLAIMER'        => __( 'Nutrition Disclaimer', 'mediavine' ),
			'NUTRITION_NOT_REQUIRED'      => __( 'Nutrition is not required, but providing at least calories is strongly recommended.', 'mediavine' ),
			'CALCULATED_NUTRITION'        => __( 'Calculated Nutrition', 'mediavine' ),
			'CALCULATING'                 => __( 'Calculating...', 'mediavine' ),
			'CALCULATE'                   => __( 'Calculate', 'mediavine' ),
			'NUTRITION INFORMATION'       => __( 'Nutrition Information', 'mediavine' ),
			'NUTRITION_TOOLTIP_EMAIL'     => __( 'You must confirm your email first', 'mediavine' ),
			'NUTRITION_TOOLTIP_SERVINGS'  => __( 'Number of servings is required for nutrition calculation!', 'mediavine' ),
			'NUTRITION_TOOLTIP_INGR'      => __( 'Ingredients are required for nutrition calculation!', 'mediavine' ),
			'NUTRITION_TOOLTIP_INVALID'   => __( 'Ingredients or serving size have been updated. You need to recalculate!', 'mediavine' ),
			'NUTRITION_TOOLTIP_WHOLE_NUM' => __( 'Number of servings must be a single value in order to use nutrition calculation', 'mediavine' ),
			'NUTRITION_CALC_SUPPORT'      => __( 'Automatic nutrition calculation is here!', 'mediavine' ),
			/* translators: data calculation disclaimer */
			'NUTRITION_CALCULATED_ON'     => __( 'This data was provided and calculated by %1$s on %2$s', 'mediavine' ),
			'GRAMS'                       => __( 'grams', 'mediavine' ),
			'MILLIGRAMS'                  => __( 'milligrams', 'mediavine' ),
			// Nutrition
			'SERVING_SIZE'                => __( 'Serving Size', 'mediavine' ),
			'HOW_MANY_SERVINGS'           => __( 'How many servings does this recipe make?', 'mediavine' ),
			'NUMBER_OF_SERVINGS'          => __( 'Number of Servings', 'mediavine' ),
			'CALORIES'                    => __( 'Calories', 'mediavine' ),
			'TOTAL_FAT'                   => __( 'Total Fat', 'mediavine' ),
			'SATURATED_FAT'               => __( 'Saturated Fat', 'mediavine' ),
			'TRANS_FAT'                   => __( 'Trans Fat', 'mediavine' ),
			'UNSATURATED_FAT'             => __( 'Unsaturated Fat', 'mediavine' ),
			'CHOLESTEROL'                 => __( 'Cholesterol', 'mediavine' ),
			'SODIUM'                      => __( 'Sodium', 'mediavine' ),
			'CARBOHYDRATES'               => __( 'Carbohydrates', 'mediavine' ),
			'NET_CARBOHYDRATES'           => __( 'Net Carbohydrates', 'mediavine' ),
			'FIBER'                       => __( 'Fiber', 'mediavine' ),
			'SUGAR'                       => __( 'Sugar', 'mediavine' ),
			'SUGAR_ALCOHOLS'              => __( 'Sugar Alcohols', 'mediavine' ),
			'PROTEIN'                     => __( 'Protein', 'mediavine' ),
			// Materials
			'BULK'                        => __( 'Bulk', 'mediavine' ),
			'DETAIL'                      => __( 'Detail', 'mediavine' ),
			'ADVANCED'                    => __( 'Advanced', 'mediavine' ),
			'ADVANCED_TOOLTIP'            => __( 'Advanced Mode provides additional tools for creating links and groups.', 'mediavine' ),
			'SIMPLE_TOOLTIP'              => __( 'If you have disabled no-follow for any links, you may lose this by switching back to Bulk Edit mode. Save changes before continuing.', 'mediavine' ),
			/* translators: instructions for ingredients */
			'CREATE_LINKS'                => __( 'Create links by wrapping an item in brackets and the link in parentheses, e.g. %s', 'mediavine' ),
			/* translators: instructions for groups */
			'CREATE_GROUPS'               => __( 'In Bulk Edit mode, you can group items by starting a line with an exclamation point, (e.g. %s) followed by each item on a new line.', 'mediavine' ),
			/* translators: type -> group, product */
			'NAME_THIS_THING'             => __( 'Name this %s...', 'mediavine' ),
			'ITEM'                        => __( 'Item', 'mediavine' ),
			'GROUP_NAME'                  => __( 'Group Name', 'mediavine' ),
			/* translators: adding something */
			'CREATE_GROUP'                => __( 'Add %s', 'mediavine' ),
			'UNTITLED_GROUP'              => __( 'Untitled Group', 'mediavine' ),
			'NO_FOLLOW_TOOLTIP'           => __( 'This is best practice for links where you may earn a commission or have been paid by a brand for sponsored work.', 'mediavine' ),
			/* translators: empty state for ingredients */
			'NO_THING_YET'                => __( 'You don\'t have any %s yet!', 'mediavine' ),
			/* translators: adding empty ingredients */
			'RENAME_BEFORE_ADD'           => __( 'Rename %s before adding another.', 'mediavine' ),
			/* translators: adding a new item */
			'ADD_THING'                   => __( 'Add %s', 'mediavine' ),
			/* translators: adding a new item to a group */
			'ADD_THING_TO_THING'          => __( 'Add %1$s to %2$s', 'mediavine' ),
			'GROUP'                       => __( 'Group', 'mediavine' ),
			'TIP'                         => __( 'Tip', 'mediavine' ),
			/* translators: type -> step, group, item */
			'DELETE_THING'                => __( 'Delete %s', 'mediavine' ),
			// Reviews
			'REVIEW'                      => __( 'Review', 'mediavine' ),
			'REVIEW_TITLE'                => __( 'Review Title', 'mediavine' ),
			'REVIEWS'                     => __( 'Reviews', 'mediavine' ),
			'UPDATE_REVIEW'               => __( 'Update Review', 'mediavine' ),
			'CHOOSE_A_CARD'               => __( 'Choose a card', 'mediavine' ),
			'RATING'                      => __( 'Rating', 'mediavine' ),
			'FILTER'                      => __( 'Filter', 'mediavine' ),
			'ALL_RATING'                  => __( 'All', 'mediavine' ),
			'NO_REVIEW_TITLE'             => __( 'No Review Title', 'mediavine' ),
			'ANONYMOUS_USER'              => __( 'Anonymous User', 'mediavine' ),
			'SELECT_A_REVIEW'             => __( 'Select a review', 'mediavine' ),
			'SEARCH_BY_REVIEW_CONTENT'    => __( 'Search by review content', 'mediavine' ),
			'SEARCH_BY_CARD'              => __( 'Search by card', 'mediavine' ),
			/* translators: reviews by author */
			'LEFT_BY'                     => __( 'Left by %s', 'mediavine' ),
			/* translators: reviews by author */
			'MORE_BY'                     => __( 'More by %s', 'mediavine' ),
			'YOUVE_EDITED'                => __( 'You\'ve edited this review', 'mediavine' ),
			/* translators: author has edited review notice */
			'THEYVE_EDITED'               => __( '%s edited this review', 'mediavine' ),
			'DELETE'                      => __( 'Delete', 'mediavine' ),
			'YES'                         => __( 'Yes', 'mediavine' ),
			'CANCEL'                      => __( 'Cancel', 'mediavine' ),
			'CONFIRM'                     => __( 'Confirm', 'mediavine' ),
			'NO_REVIEWS_FOUND'            => __( 'No reviews found.', 'mediavine' ),
			'SEE_REVIEWS'                 => __( 'See Reviews', 'mediavine' ),
			// Errors
			'ERROR_NOTICE'                => __( 'Well, this shouldn\'t happen', 'mediavine' ),
			'ERROR_TEAM_ALERT'            => __( 'Something went wrong and Mediavine Create crashed. Our team has been alerted of the issue, but you can also leave a detailed report.', 'mediavine' ),
			'ERROR_PROMPT'                => __( 'Did something go wrong?', 'mediavine' ),
			'ERROR_CONTAINER_TOOLTIP'     => __( 'If you can briefly describe what happened, you can help our team improve Mediavine Create.', 'mediavine' ),
			/* translators: %s: click here */
			'ERROR_REFRESH'               => __( 'Something went wrong with Create by Mediavine. %s to refresh and resume progress.', 'mediavine' ),
			'ERROR_REFRESH_BUTTON'        => __( 'Click here', 'mediavine' ),
			'REFRESH'                     => __( 'Refresh', 'mediavine' ),
			'GENERIC_ERROR'               => __( 'Something went wrong.', 'mediavine' ),
			'404_ERROR'                   => __( '404: We couldn\'t find that resource. This usually indicates it was deleted.', 'mediavine' ),
			'401_ERROR'                   => __( 'Security token expired. This can happen if your tab has been open too long. If you\'re using a firewall, whitelist the WordPress REST API.', 'mediavine' ),
			'429_ERROR'                   => __( 'You\'ve made too many requests. Please try again later.', 'mediavine' ),
			'500_ERROR'                   => __( 'This usually indicates a problem with your server.', 'mediavine' ),
			'RANGED_TIME_WARNING'         => __( 'Ranged times are not supported.', 'mediavine' ),
			//Settings
			'MV_CREATE_DISPLAY'           => __( 'Display', 'mediavine' ),
			'MV_CREATE_ADVANCED'          => __( 'Advanced', 'mediavine' ),
			'MV_CREATE_RECIPES'           => __( 'Recipes', 'mediavine' ),
			'MV_CREATE_LISTS'             => __( 'Lists', 'mediavine' ),
			'MV_CREATE_MVP'               => __( 'MVP', 'mediavine' ),
			'RESET_BROWSER_STORAGE'       => __( 'Reset Browser Storage', 'mediavine' ),
			'RESET_BROWSER_INSTRUCTIONS'  => __( 'Create uses your browser\'s cache to improve performance. This button will reset your local broswer cache. Please proceed with caution.', 'mediavine' ),
			'ALLOWED_TYPES'               => __( 'Allowed Types', 'mediavine' ),
			'ALLOWED_TYPES_INSTRUCTIONS'  => __( 'If any types are selected, only they will be available for adding new cards. (Existing cards of disallowed types will still function properly.)', 'mediavine' ),
			// Registration
			'FIRSTNAME'                   => __( 'First Name', 'mediavine' ),
			'LASTNAME'                    => __( 'Last Name', 'mediavine' ),
			'EMAIL'                       => __( 'Email', 'mediavine' ),
			'MARKETING_OPT_IN'            => __( 'I agree to receive marketing communications from Mediavine.', 'mediavine' ),
			/* translators: %s is terms of service */
			'READ_AND_AGREE'              => __( 'I have read and agree to the %s', 'mediavine' ),
			'TERMS_OF_SERVICE'            => __( 'terms of service.', 'mediavine' ),
			'REGISTER'                    => __( 'Register', 'mediavine' ),
			'THANKS_FOR_CONFIRMING'       => __( 'Thanks for confirming your email.', 'mediavine' ),
			'EMAIL_SENT'                  => __( 'Email sent.', 'mediavine' ),
			'CONFIRM_EMAIL'               => __( 'Confirm your email in order to take full advantages of plugin features!', 'mediavine' ),
			'USE_DIFFERENT_EMAIL'         => __( 'I need to use a different email.', 'mediavine' ),
			// Color Picker
			'COLOR_ACCESSIBILITY'         => __( 'The color you selected doesn\'t meet accessiblity standards with the text color of the card theme you\'ve selected.', 'mediavine' ),
			'PICK_COLORS'                 => __( 'Pick Colors', 'mediavine' ),
			'PRIMARY_COLOR_DESCRIPTION'   => __( 'The primary color will be used for your card\'s background, if the selected theme has a background.', 'mediavine' ),
			'SECONDARY_COLOR_DESCRIPTION' => __( 'The secondary color will be used for interface elements like buttons and stars.', 'mediavine' ),
			'COLORS'                      => __( 'Colors', 'mediavine' ),
			'COLORS_INSTRUCTIONS'         => __( 'Enabling this setting allows you to manually set the colors used for cards.', 'mediavine' ),
			'ENABLE'                      => __( 'Enable', 'mediavine' ),
			'PRIMARY_COLOR_CONTRAST'      => __( 'Primary Color Contrast', 'mediavine' ),
			'USE_DEFAULTS'                => __( 'Use Defaults', 'mediavine' ),
			'PRIMARY_COLOR'               => __( 'Primary Color', 'mediavine' ),
			'SECONDARY_COLOR'             => __( 'Secondary Color', 'mediavine' ),
			// Products
			'RECOMMENDED_PRODUCTS'        => __( 'Recommended Products', 'mediavine' ),
			'BACK_TO_PRODUCTS'            => __( 'Back to products', 'mediavine' ),
			'PRODUCT'                     => __( 'Product', 'mediavine' ),
			'UPDATE_PRODUCT'              => __( 'Update Product', 'mediavine' ),
			'PRODUCT_URL'                 => __( 'Product URL', 'mediavine' ),
			'PRODUCT_NAME'                => __( 'Product Name', 'mediavine' ),
			'CHOOSE_PRODUCT'              => __( 'Choose Product', 'mediavine' ),
			'PRODUCT_GLOBAL_NOTICE'       => __( 'Changing a product\'s link, title or image here will update the product across all Create Cards.', 'mediavine' ),
			'CHOOSE_EXISTING'             => __( 'Choose from existing', 'mediavine' ),
			'PRODUCT_SEARCH_PLACEHOLDER'  => __( 'Search for a product...', 'mediavine' ),
			'SCRAPE'                      => __( 'This will scrape the title and image from the provided link.', 'mediavine' ),
			'PROCESS'                     => __( 'Process', 'mediavine' ),
			'PROCESSING'                  => __( 'Processing', 'mediavine' ),
			'EXTERNAL_LINK_SUPPORT'       => __( 'External link support is waiting!', 'mediavine' ),
			/* translators: %s is call-to-action text to register for product scraping */
			'REGISTER_TO_FETCH_PRODUCTS'  => __( 'In order to fetch products, you\'ll need to %s. This is a free, one-time action used for internal purposes.', 'mediavine' ),
			'REGISTER_YOUR_PLUGIN'        => __( 'register your plugin', 'mediavine' ),
			/* translators: %s is call-to-action text to register */
			'YOU_CAN_REGISTER'            => __( 'You can register %s and get access to this feature. This is a free, one-time action.', 'mediavine' ),
			'REGISTER_LINK'               => __( 'here', 'mediavine' ),
			'CONFIRM_REGISTERED_EMAIL'    => __( 'Just confirm the email you used to register with.', 'mediavine' ),
			// Pinterest
			'PINTEREST_DEFAULT_URL'       => __( 'Default: Post URL', 'mediavine' ),
			'PINTEREST_URL'               => __( 'Pinterest URL', 'mediavine' ),
			'PINTEREST_DEFAULT_LABEL'     => __( 'Default: Title', 'mediavine' ),
			// Video
			'VIDEO_OVERWRITE'             => __( 'Your Mediavine video will override your video from another source.', 'mediavine' ),
			'VIDEO_REMOVE'                => __( 'Remove Video', 'mediavine' ),
			'VIDEO_FOOTER'                => __( 'This is a new feature. At the moment, only YouTube is supported.', 'mediavine' ),
			'VIDEO_DISPLAY'               => __( 'Display video', 'mediavine' ),
			'VIDEO_DISPLAY_NOTICE'        => __( 'If disabled, your video will be included in schema data but not displayed to users. Only select this if you\'re displaying the video elsewhere in the post.', 'mediavine' ),
			'VIDEO_PLACEHOLDER'           => __( 'Paste URL from YouTube', 'mediavine' ),
			'VIDEO_OPTIONS'               => __( 'Video Options', 'mediavine' ),
			'ADD_MEDIAVINE_VIDEO'         => __( 'Add Mediavine Video', 'mediavine' ),
			'ADD_EXTERNAL_VIDEO'          => __( 'Add External Video', 'mediavine' ),
			'EDIT_VIDEO_SETTINGS'         => __( 'Edit Video Settings', 'mediavine' ),
			'RATIO_DEFAULT'               => __( 'Match Video Ratio', 'mediavine' ),
			'ASPECT_RATIO'                => __( 'Aspect Ratio', 'mediavine' ),
			'HIDE_VIDEO'                  => __( 'Hide Video', 'mediavine' ),
			'VOLUME'                      => __( 'Volume', 'mediavine' ),
			'VIDEO_HIDDEN_DISCLAIMER'     => __( 'Video data will be still be included in card schema. It\'s not recommended to include data that isn\'t visible to users, so only enable this setting if you\'re including the video elsewhere on the page.', 'mediavine' ),
			'USE_VIDEO'                   => __( 'Use this video', 'mediavine' ),
			'VIDEO_SEARCH_PLACEHOLDER'    => __( 'Search by title', 'mediavine' ),
			'CHOOSE_VIDEO'                => __( 'Choose a different video', 'mediavine' ),
			'ADD_VIDEO'                   => __( 'Add a video', 'mediavine' ),
			// Generic
			'USER'                        => __( 'User', 'mediavine' ),
			'URL'                         => __( 'URL', 'mediavine' ),
			'CREATE_CARD'                 => __( 'Create Card', 'mediavine' ),
			'CREATE_CARDS'                => __( 'Create Cards', 'mediavine' ),
			'CREATE_NEW_CARD_BUTTON'      => __( 'Create New Card', 'mediavine' ),
			'CREATIONS'                   => __( 'Creations', 'mediavine' ),
			'CREATION'                    => __( 'Creation', 'mediavine' ),
			'RECIPES'                     => __( 'Recipes', 'mediavine' ),
			'LISTS'                       => __( 'Lists', 'mediavine' ),
			'LIST'                        => __( 'List', 'mediavine' ),
			'LIST_ITEMS'                  => __( 'List Items', 'mediavine' ),
			'LIST_INFORMATION'            => __( 'List Information', 'mediavine' ),
			'ADD_LIST_ITEM'               => __( 'Add List Item', 'mediavine' ),
			'ADD_CUSTOM_TEXT'             => __( 'Add Custom Text', 'mediavine' ),
			'HIDE_TITLE'                  => __( 'Hide Title', 'mediavine' ),
			'HIDE_DESCRIPTION'            => __( 'Hide Description', 'mediavine' ),
			'LINK'                        => __( 'Link', 'mediavine' ),
			'ITEMS'                       => __( 'Items', 'mediavine' ),
			'LAYOUT'                      => __( 'Layout', 'mediavine' ),
			'HOW-TO'                      => __( 'How-To', 'mediavine' ),
			'HOW-TOS'                     => __( 'How-Tos', 'mediavine' ),
			'THANKS'                      => __( 'Thanks!', 'mediavine' ),
			'NO_THANKS'                   => __( 'No Thanks', 'mediavine' ),
			'CLOSE'                       => __( 'Close', 'mediavine' ),
			'SUBMIT'                      => __( 'Submit', 'mediavine' ),
			'SELECT_CARD'                 => __( 'Select', 'mediavine' ),
			'TRASH'                       => __( 'Trash', 'mediavine' ),
			'DATE'                        => __( 'Date', 'mediavine' ),
			'EDIT'                        => __( 'Edit', 'mediavine' ),
			'CREATED'                     => __( 'Created', 'mediavine' ),
			'MODIFIED'                    => __( 'Modified', 'mediavine' ),
			'RESET'                       => __( 'Reset', 'mediavine' ),
			'TYPE'                        => __( 'Type', 'mediavine' ),
			'CARD'                        => __( 'Card', 'mediavine' ),
			'CARDS'                       => __( 'Cards', 'mediavine' ),
			'DONE'                        => __( 'Done', 'mediavine' ),
			'DUPLICATE_CARD'              => __( 'Clone Card', 'mediavine' ),
			'DUPLICATE_INSTRUCTIONS'      => __( 'This will create an exact copy of the current card.', 'mediavine' ),
			'POST'                        => __( 'Post', 'mediavine' ),
			'POSTS'                       => __( 'Posts', 'mediavine' ),
			'PAGE'                        => __( 'Page', 'mediavine' ),
			'SEARCH'                      => __( 'Search', 'mediavine' ),
			'SEARCH_OPTIONS'              => __( 'Search Options', 'mediavine' ),
			'PREVIOUS'                    => __( 'Previous', 'mediavine' ),
			'NEXT'                        => __( 'Next', 'mediavine' ),
			'PREVIOUS_PAGE'               => __( 'Previous Page', 'mediavine' ),
			'NEXT_PAGE'                   => __( 'Next Page', 'mediavine' ),
			'INSERT'                      => __( 'Insert', 'mediavine' ),
			'REVERT'                      => __( 'Revert', 'mediavine' ),
			'EXTERNAL'                    => __( 'External', 'mediavine' ),
			'LIST_VIEW'                   => __( 'List View', 'mediavine' ),
			'GRID_VIEW'                   => __( 'Grid View', 'mediavine' ),
			'CHOOSE_IMAGE'                => __( 'Choose Image', 'mediavine' ),
			'PHOTO_CREDIT'                => __( 'Photo Credit', 'mediavine' ),
			'NO_FOLLOW'                   => __( 'No-Follow', 'mediavine' ),
			'LINK_TO_POST'                => __( 'Link to Post', 'mediavine' ),
			'EXTRA_INFO'                  => __( 'Extra Info (Max. 2)', 'mediavine' ),
			'BUTTON_ACTION'               => __( 'Button Action', 'mediavine' ),
			'CUSTOM_BUTTON_TEXT'          => __( 'Custom button text', 'mediavine' ),
			'ADDED_TO_LIST'               => __( 'Added to list', 'mediavine' ),
			'CARD_NOT_ADDED_TO_POST'      => __( 'This card has not been added to a post.', 'mediavine' ),
			/* translators: %s: ui mode */
			'SWITCH_TO'                   => __( 'Switch to %s', 'mediavine' ),
			'ALL_CARDS'                   => __( 'All Cards', 'mediavine' ),
			'TITLE_ONLY'                  => __( 'Title Only', 'mediavine' ),
			'TITLE_AND_CONTENT'           => __( 'Title and Content', 'mediavine' ),
			'TOGGLE_TITLE_SORT'           => __( 'Toggle title sort', 'mediavine' ),
			'TOGGLE_DATE_SORT'            => __( 'Toggle date sort', 'mediavine' ),
			/* translators: %s: additional information */
			'DELETION_CONFIRMATION'       => __( 'Are you sure? This card is used in the following posts:%s This is a permanent action and cannot be undone.', 'mediavine' ),
			/* translators: deleting card */
			'DELETION_CONFIRMATION_SIMP'  => __( 'Are you sure you want to do this?', 'mediavine' ),
			/* translators: item belongs to something else */
			'FOLLOWING_POSTS'             => __( 'This %1$s is used in the following %2$s:%3$s', 'mediavine' ),
			/* translators: nothing found */
			'NO_MATCHING'                 => __( 'No matching %s found.', 'mediavine' ),
			'NO_MATCHING_RESULTS'         => __( 'No matching results.', 'mediavine' ),
			/* translators: nothing found instructions */
			'TRY_ADJUSTING'               => __( 'You can try adjusting your search filters, or you can click "Add New" to create a new %s.', 'mediavine' ),
			'PLEASE_WAIT'                 => __( 'Sorry! This is taking awhile.', 'mediavine' ),
			'NOT_IN_POST'                 => __( 'Not in post.', 'mediavine' ),
			'NO_CARD_YET'                 => __( 'You haven\'t added a card yet!', 'mediavine' ),
			'PASTE_URL'                   => __( 'Paste a URL', 'mediavine' ),
			'CANNOT_PROCESS_URL'          => __( 'Cannot process this URL.', 'mediavine' ),
			'ALREADY_ADDED'               => __( 'This has already been added to the list.', 'mediavine' ),
			'ADD_MANUALLY'                => __( 'Add Manually.', 'mediavine' ),
			'CARD_POST_PLACEHOLDER'       => __( 'Search for a card or post...', 'mediavine' ),
			'PRODUCT_SEARCH_PLACEHOLDER'  => __( 'Search existing products', 'mediavine' ),
			'SPECIAL_CHARACTERS'          => __( 'Special Characters', 'mediavine' ),
			/* translators: %s -> render in Interface */
			'NOT_A_FIELD'                 => __( '%s is not a field.', 'mediavine' ),
			'WORD_COUNT'                  => __( 'Word Count', 'mediavine' ),
			'PREVIEW'                     => __( 'Preview', 'mediavine' ),
			'REPUBLISH_CREATIONS'         => __( 'Republish Creations', 'mediavine' ),
			'VIA_GIPHY'                   => __( 'via GIPHY', 'mediavine' ),
			'MCP_AUTH'                    => __( 'You must authenticate your account through Mediavine Control Panel to use this feature.', 'mediavine' ),
			'THANK_YOU_FOR_CREATING'      => __( 'Thank you for creating with', 'mediavine' ),
			// Button texts
			'GET_THE_RECIPE'              => __( 'Get the Recipe', 'mediavine' ),
			'GET_THE_GUIDE'               => __( 'Get the Guide', 'mediavine' ),
			'READ_MORE'                   => __( 'Read More', 'mediavine' ),
			'CONTINUE_READING'            => __( 'Continue Reading', 'mediavine' ),
			'NUTRITION_NOT_ON_API'        => __( 'This field is not calculated by NutritionIX', 'mediavine' ),
		);
	}

	function admin_enqueue_scripts( $hook ) {
		$settings = \Mediavine\Settings::get_settings();
		$shapes   = \Mediavine\Create\Shapes::get_shapes();

		wp_register_style( 'mv-font/open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' );

		wp_enqueue_style( Plugin::PLUGIN_DOMAIN . '/mv-create.css', Plugin::assets_url() . 'admin/ui/build/app.build.' . self::VERSION . '.css', array(), self::VERSION );

		// Pull Proxima Nova from CDN using correct protocol
		$proxima_nova_cdn = 'http://cdn.mediavine.com/fonts/ProximaNova/stylesheet.css';
		if ( is_ssl() ) {
			$proxima_nova_cdn = 'https://cdn.mediavine.com/fonts/ProximaNova/stylesheet.css';
		}
		wp_enqueue_style( 'mv-font/proxima-nova', $proxima_nova_cdn );

		$script_url  = Plugin::assets_url() . 'admin/ui/build/app.build.' . self::VERSION . '.js';
		$vendor_url  = Plugin::assets_url() . 'admin/ui/build/vendor.build.' . self::VERSION . '.js';
		$runtime_url = Plugin::assets_url() . 'admin/ui/build/runtime.build.' . self::VERSION . '.js';

		if ( apply_filters( 'mv_create_dev_mode', false ) ) {
			$script_url  = '//localhost:3000/app.build.' . self::VERSION . '.js';
			$vendor_url  = '//localhost:3000/vendor.build.' . self::VERSION . '.js';
			$runtime_url = Plugin::assets_url() . 'admin/ui/build/runtime.build.' . self::VERSION . '.js';
			wp_dequeue_style( Plugin::PLUGIN_DOMAIN . '/mv-create.css' );
		}

		wp_enqueue_media();
		wp_enqueue_script( 'mv_raven', 'https://cdn.ravenjs.com/3.25.2/raven.min.js', array(), self::VERSION, true );
		wp_enqueue_style( 'mv-create-card/css' );
		wp_register_script(
			'create-runtime',
			$runtime_url,
			null,
			self::VERSION,
			true
		);
		wp_register_script(
			'mv-vendor',
			$vendor_url,
			null,
			self::VERSION,
			true
		);

		$deps = [ 'mv_raven', 'mv-vendor' ];

		if ( self::$mcp_data ) {
			$deps[] = 'mv-create/intercom';
		}

		if ( function_exists( 'is_gutenberg_page' ) && is_gutenberg_page() ) {
			$deps = array_merge( $deps, [ 'wp-plugins', 'wp-i18n', 'wp-element' ] );
		}

		wp_register_script(
			Plugin::PLUGIN_DOMAIN .
			'/mv-create.js',
			$script_url,
			$deps,
			self::VERSION,
			true
		);

		wp_localize_script( Plugin::PLUGIN_DOMAIN . '/mv-create.js', 'MV_CREATE', self::localization() );

		if ( ! wp_script_is( 'mv-blocks' ) ) {
			wp_enqueue_script( 'mv-vendor' );
			wp_enqueue_script( 'create-runtime' );
			wp_enqueue_script( Plugin::PLUGIN_DOMAIN . '/mv-create.js' );
		}
	}

	function admin_enqueue_intercom() {
		if ( ! self::$mcp_data ) {
			return;
		}

		$data                 = array();
		$current_user         = wp_get_current_user();
		$data['email']        = $current_user->user_email;
		$data['access_token'] = null;
		$data['site_info']    = '';
		$data['intercom']     = null;

		// Don't use method if it doesn't exist
		if ( method_exists( '\Mediavine\MCP\Settings', 'read' ) ) {
			$token_data = \Mediavine\MCP\Settings::read( 'mcp-services-api-token' );
		}

		if ( isset( $token_data->value ) ) {
			$data['access_token'] = $token_data->value;
		}

		if ( isset( $token_data->data->intercom ) ) {
			$data['intercom'] = $token_data->data->intercom;
		}

		if ( isset( $token_data->data->email ) ) {
			$data['email'] = $token_data->data->email;
		}

		if ( ! empty( $current_user ) ) {
			$data['site_info'] = esc_html( $current_user->display_name ) . ' | Site: ' . esc_url( site_url() );
		}

		wp_register_script( 'mv-create/intercom', Plugin::assets_url() . 'admin/vendor/intercom.js', [], self::VERSION, false );
		wp_localize_script( 'mv-create/intercom', 'mvcreate_intercom', $data, self::VERSION );
		wp_enqueue_script( 'mv-create/intercom' );
	}

	function admin_head() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		// check if WYSIWYG is enabled
		if ( 'true' === get_user_option( 'rich_editing' ) ) {
			add_filter( 'tiny_mce_before_init', array( $this, 'tiny_mce_before_init' ) );
		}

		echo '<style>.post-type-mv_create #wpbody #wpbody-content { display: none };</style>';
	}

	function admin_footer() {
		echo '<div id="mv-gb-modal"></div>';
	}

	function admin_menu() {
		$shapes         = \Mediavine\Create\Shapes::get_shapes();
		$allowed_shapes = \Mediavine\Settings::get_setting( 'mv_create_allowed_types' );
		$allowed_shapes = json_decode( $allowed_shapes );

		$menu_keys = array(
			'recipe' => __( 'Recipes', 'mediavine' ),
			'diy'    => __( 'How-Tos', 'mediavine' ),
			'list'   => __( 'Lists', 'medivine' ),
		);

		foreach ( $shapes as $card ) {
			if ( ! empty( $allowed_shapes ) && ! in_array( $card->slug, $allowed_shapes, true ) ) {
				continue;
			}
			add_submenu_page(
				'edit.php?post_type=mv_create',
				$menu_keys[ $card->slug ],
				$menu_keys[ $card->slug ],
				'manage_options',
				$card->slug,
				array( $this, 'card_page' )
			);
		}

		$static_pages = array();
		$static_pages[ __( 'Recommended Products', 'mediavine' ) ] = 'products';
		$static_pages[ __( 'User Reviews', 'mediavine' ) ]         = 'reviews';

		foreach ( $static_pages as $label => $value ) {
			add_submenu_page(
				'edit.php?post_type=mv_create',
				$label,
				$label,
				'manage_options',
				$value,
				array( $this, 'card_page' )
			);
		}

		add_submenu_page(
			'edit.php?post_type=mv_create',
			__( 'Create by Mediavine Plugin Settings', 'mediavine' ),
			__( 'Settings', 'mediavine' ),
			'manage_options',
			'settings',
			array( $this, 'menu_page' )
		);

		add_options_page(
			__( 'Create by Mediavine Plugin Settings', 'mediavine' ),
			__( 'Create by Mediavine', 'mediavine' ),
			'manage_options',
			'mv_settings',
			array( $this, 'menu_page' )
		);
	}

	function card_page() {
		$screen_object = get_current_screen();
		$exploded      = explode( '_', $screen_object->base );
		$position      = count( $exploded ) - 1;
		$type          = $exploded[ $position ];
		?>
			<div id="MVRoot" data-type="<?php echo esc_html( $type ); ?>"></div>
		<?php
	}

	// Blank function prevents PHP notice
	function menu_page() {}

	function media_buttons( $editor_id ) {
		if ( 'content' !== $editor_id ) {
			return;
		}
		?>
			<div data-shortcode="mv_create"></div>
		<?php
	}

	function tiny_mce_before_init( $mceInit ) {
		$mceInit['content_css'] .= ', ' . Plugin::assets_url() . 'admin/ui/build/tinymce.build.css?' . self::VERSION;
		return $mceInit;
	}

	function block_categories( $categories ) {
		$merged = array_merge(
			$categories,
			[
				[
					'slug'  => 'mediavine-create',
					'title' => __( 'Create by Mediavine', 'medaivine' ),
					'icon'  => 'mediavine',
				],
			]
		);
		return $merged;
	}

	function init() {
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_intercom' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'media_buttons', array( $this, 'media_buttons' ) );
		add_filter( 'block_categories', [ $this, 'block_categories' ], 10, 1 );
	}

}
