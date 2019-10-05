<?php
/**
 * Template for the plugin settings structure.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/settings
 */

$equipment_links = array(
	'id' => 'equipmentLinks',
	'name' => __( 'Equipment Links', 'wp-recipe-maker' ),
	'required' => 'premium',
	'description' => __( 'Equipment links can be set on the WP Recipe Maker > Manage > Equipment page.', 'wp-recipe-maker' ),
	'documentation' => 'https://help.bootstrapped.ventures/article/193-equipment-links',
	'settings' => array(
		array(
			'id' => 'equipment_links_open_in_new_tab',
			'name' => __( 'Open in New Tab', 'wp-recipe-maker' ),
			'description' => __( 'Open equipment links in a new tab.', 'wp-recipe-maker' ),
			'type' => 'toggle',
			'default' => false,
		),
		array(
			'id' => 'equipment_links_use_nofollow',
			'name' => __( 'Default Use Nofollow', 'wp-recipe-maker' ),
			'description' => __( 'Add the nofollow attribute to equipment links by default.', 'wp-recipe-maker' ),
			'type' => 'toggle',
			'default' => false,
		),
	),
);
