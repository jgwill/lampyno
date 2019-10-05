<?php
add_action('admin_menu', 'register_report_pages');


function register_report_pages(){
	add_submenu_page( 'edit.php?post_type=book','Reports on Books','Reports','manage_options','book-report','aw2_report');
	
}

function aw2_report(){
	$return=awesome2_library::get_post_content('post-type-report-page','aw2_page',$content);
	echo awesome2_library::parse_shortcode($content);
}
	

