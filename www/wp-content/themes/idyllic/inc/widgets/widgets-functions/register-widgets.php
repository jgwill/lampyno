<?php
/**
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
/**************** IDYLLIC REGISTER WIDGETS ***************************************/
add_action('widgets_init', 'idyllic_widgets_init');
function idyllic_widgets_init() {

	register_sidebar(array(
			'name' => __('Main Sidebar', 'idyllic'),
			'id' => 'idyllic_main_sidebar',
			'description' => __('Shows widgets at Main Sidebar.', 'idyllic'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('Top Header Info', 'idyllic'),
			'id' => 'idyllic_header_info',
			'description' => __('Shows widgets on all page.', 'idyllic'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Side Menu', 'idyllic'),
			'id' => 'idyllic_side_menu',
			'description' => __('Shows widgets on all page.', 'idyllic'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Contact Page Sidebar', 'idyllic'),
			'id' => 'idyllic_contact_page_sidebar',
			'description' => __('Shows widgets on Contact Page Template.', 'idyllic'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Iframe Code For Google Maps', 'idyllic'),
			'id' => 'idyllic_form_for_contact_page',
			'description' => __('Add Iframe Code using text widgets', 'idyllic'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('WooCommerce Sidebar', 'idyllic'),
			'id' => 'idyllic_woocommerce_sidebar',
			'description' => __('Add WooCommerce Widgets Only', 'idyllic'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	$idyllic_settings = idyllic_get_theme_options();
	for($i =1; $i<= $idyllic_settings['idyllic_footer_column_section']; $i++){
	register_sidebar(array(
			'name' => __('Footer Column ', 'idyllic') . $i,
			'id' => 'idyllic_footer_'.$i,
			'description' => __('Shows widgets at Footer Column ', 'idyllic').$i,
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	}
}