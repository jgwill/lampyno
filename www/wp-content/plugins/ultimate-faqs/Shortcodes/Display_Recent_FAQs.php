<?php
function UFAQ_Recent_FAQs_Block() {
    if(function_exists('render_block_core_block')){  
		wp_register_script( 'ewd-ufaq-blocks-js', plugins_url( '../blocks/ewd-ufaq-blocks.js', __FILE__ ), array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ) );
		wp_register_style( 'ewd-ufaq-blocks-css', plugins_url( '../blocks/ewd-ufaq-blocks.css', __FILE__ ), array( 'wp-edit-blocks' ), filemtime( plugin_dir_path( __FILE__ ) . '../blocks/ewd-ufaq-blocks.css' ) );
		register_block_type( 'ultimate-faqs/ewd-ufaq-recent-faqs-block', array(
			'attributes'      => array(
				'post_count' => array(
					'type' => 'integer',
				),
			),
			'editor_script'   => 'ewd-ufaq-blocks-js', // The script name we gave in the wp_register_script() call.
			'editor_style'  => 'ewd-ufaq-blocks-css',
			'render_callback' => 'Display_Recent_FAQs',
		) );
	}
	// Define our shortcode, too, using the same render function as the block.
	add_shortcode("recent-faqs", "Display_Recent_FAQs");
}
add_action( 'init', 'UFAQ_Recent_FAQs_Block' );

function Display_Recent_FAQs($atts) {
    extract( shortcode_atts( array(
                'no_comments' => "",
                'post_count'=>5),
            $atts
        )
    );
    $ReturnString = do_shortcode("[ultimate-faqs post_count=".$post_count." no_comments='" . $no_comments . "' orderby='date']");

		return $ReturnString;
}

