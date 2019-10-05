<?php 
while ( have_posts() ) : the_post();
	$post_type=get_post_type( $post );
	$content=null;
	aw2_library::setparam('default_item',$post);
	if(aw2_library::get_post_from_slug( $post_type . '-single','aw2_page',$ignore)){
		aw2_library::get_post_content($post_type . '-single','aw2_page',$content);
	}	
	else{				
		aw2_library::get_post_content('single','aw2_core',$content);
	}
	
	echo aw2_library::parse_shortcode($content);
endwhile; 
