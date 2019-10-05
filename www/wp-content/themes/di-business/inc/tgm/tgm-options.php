<?php
/**
 * Include the TGM_Plugin_Activation class. (included in init.php)
 */

function di_business_register_required_plugins() {
	
	$plugins = array(
		
		array(
			'name'      => __( 'Elementor Page Builder', 'di-business'),
			'slug'      => 'elementor',
			'required'  => false,
		),
		
		array(
			'name'      => __( 'WooCommerce (For E-Commerce)', 'di-business'),
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		
		array(
			'name'      => __( 'Contact Form 7 (For Forms)', 'di-business'),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),

		array(
			'name'      => __( 'Max Mega Menu (for Mega Menu)', 'di-business'),
			'slug'      => 'megamenu',
			'required'  => false,
		),

		array(
			'name'      => __( 'Regenerate Thumbnails', 'di-business'),
			'slug'      => 'regenerate-thumbnails',
			'required'  => false,
		),

		array(
			'name'      => __( 'Di Themes Demo Site Importer', 'di-business'),
			'slug'      => 'di-themes-demo-site-importer',
			'required'  => false,
		),

		array(
			'name'      => __( 'MailOptin - Popups, Email Optin Forms & Newsletters for MailChimp, Aweber etc.', 'di-business'),
			'slug'      => 'mailoptin',
			'required'  => false,
		),
		
	);
	
	
	$config = array(
		'id'           => 'di-business',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'di-business-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'di_business_register_required_plugins' );

