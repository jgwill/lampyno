<?php 
 
add_action('admin_init', 'awesome_editor::init'); 
class awesome_editor{ 
	static function init() {
		global $post;
		
		if($post){
			$supported_post = strpos($post->post_type, 'page');
			if ($supported_post ) {
				add_action('admin_enqueue_scripts', 'awesome_editor::scripts');
				add_filter('the_editor', 'awesome_editor::content');
			}
		}
	}

	static function scripts( $page ) {
		global $post;
		util::var_dump($post);
		$supported_post = strpos($post->post_type, 'page');
		util::var_dump($supported_post);
		if ( ($page === 'post.php' || $page === 'post-new.php') && $supported_post ) {
			$custom_css = "#content-gmet.active { 
				background: #f5f5f5;
					color: #555;
					border-bottom-color: #f5f5f5;
			}
			";
			wp_enqueue_script('ace', plugins_url( 'shortcodes/lib/ace/ace.js' , dirname(dirname(__FILE__) )));
			wp_enqueue_script('ace_ext', plugins_url( 'shortcodes/lib/ace/ext-language_tools.js' , dirname(dirname(__FILE__) )));
			wp_enqueue_script('awui_autocomplete', plugins_url( 'shortcodes/lib/ace/awui_autocomplete.js' ,dirname(dirname(__FILE__) ) ));

			wp_add_inline_style( 'cmb2-styles', $custom_css );
			wp_enqueue_script('gmet', plugins_url('/gmet.js', __FILE__ ) );
			wp_localize_script('gmet', 'gmetData', array(
				'tabTitle' => __('Code', 'gmet')
			));
		}
	}

	static function content( $content ) {

		preg_match("/<textarea[^>]*id=[\"']([^\"']+)\"/", $content, $matches);
		$id = $matches[1];
		// only for main content
		if( $id !== "content" ) return $content;
		ob_start();
		include( plugin_dir_path( __FILE__ ) . 'gmet-content.php' );
		$out = ob_get_clean();
		
		//var_dump($content .$out);exit;
		return $content . $out;
	}
}	