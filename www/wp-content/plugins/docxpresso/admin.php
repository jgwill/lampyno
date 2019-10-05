<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu', 'docxpresso_menu');
add_action('media_buttons', 'add_docxpresso_button', 15);
add_action('wp_enqueue_media', 'include_docxpresso_js');
add_action( 'init', 'docxpressoCutPaste_block' );

function docxpressoCutPaste_block() {
    if ( ! function_exists( 'register_block_type' ) ) {
            // Gutenberg is not active.
            return;
    }
	
    wp_register_script(
        'docxpressoCutPaste/Gutenberg',
        plugins_url( 'gutenberg/block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-components', 'wp-editor')
    );
	
    wp_register_style(
        'docxpressoCutPaste/Gutenberg',
        plugins_url( 'gutenberg/style.css', __FILE__ ),
        array( )
    );

    register_block_type( 'docxpresso-cut-paste/plugin', array(
		'style' => 'docxpressoCutPaste/Gutenberg',
                'editor_script' => 'docxpressoCutPaste/Gutenberg')
    );
}

function docxpresso_menu() {
    add_options_page('Docxpresso', 'Docxpresso', 'manage_options', 'docxpresso/options.php');
}

function add_docxpresso_button() {
    echo '<a href="#" id="insert-docxpresso" class="button"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAPAgMAAABGuH3ZAAAAA3NCSVQICAjb4U/gAAAACVBMVEX////MzMyBgYFQ1Uj9AAAAA3RSTlMA//9EUNYhAAAACXBIWXMAAArwAAAK8AFCrDSYAAAAIHRFWHRTb2Z0d2FyZQBNYWNyb21lZGlhIEZpcmV3b3JrcyBNWLuRKiQAAAAWdEVYdENyZWF0aW9uIFRpbWUAMDYvMDUvMTUjouemAAAAPUlEQVR4nGNgAINVK4DE1CggMYGrgYFBgHECg9YKhgkMrKFAggvEYgSxmEAshqkgYgKIWLUKSIiGBoDNAAAPGg6OmqVKSwAAAABJRU5ErkJggg==" />  Insert Document</a>';
}

function include_docxpresso_js() {
    wp_enqueue_script('docxpresso_button', '/wp-content/plugins/docxpresso/docxpresso.js', array('jquery'), '2.0', true);
}