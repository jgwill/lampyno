<?php
	$content ='';
	aw2_library::get_post_content('archive','aw2_core',$content);
	
	aw2_library::setparam('default_collection'. '_wpquery',$wp_query);
	aw2_library::setparam('default_collection',$wp_query->posts);
	if(is_post_type_archive( ))
	{
		$post_type = get_query_var('post_type');
		aw2_library::setparam('current_archive_name',$post_type);
		if(aw2_library::get_post_from_slug( $post_type . '-archive','aw2_page',$ignore))
			aw2_library::get_post_content($post_type . '-archive','aw2_page',$content);
	}
	else if(is_tax())
	{
		$tax = $wp_query->get_queried_object();
		aw2_library::setparam('default_taxonomy',$tax->taxonomy);
		aw2_library::setparam('default_term_slug',$tax->slug);
		aw2_library::setparam('current_archive_name',$tax->name);
		if(aw2_library::get_post_from_slug($tax->taxonomy . '-archive','aw2_page',$ignore))
			aw2_library::get_post_content($tax->taxonomy . '-archive','aw2_page',$content);

	}
	else if(is_category()){
		$cat = get_category( get_query_var( 'cat' ) );
		aw2_library::setparam('default_taxonomy','category');
		aw2_library::setparam('default_term_slug',$cat->slug);
		aw2_library::setparam('current_archive_name',$cat->name);
		
		if(aw2_library::get_post_from_slug($cat->slug . '-archive','aw2_page',$ignore))
			aw2_library::get_post_content($cat->slug . '-archive','aw2_page',$content);
	}
	else if( is_tag()){
		//aw2_library::setparam('default_tag',$wp_query->posts);
		aw2_library::setparam('current_archive_name',$cat->name);
		if(aw2_library::get_post_from_slug($cat->slug . '-archive','aw2_page',$ignore))
			aw2_library::get_post_content($cat->slug . '-archive','aw2_page',$content);
	}

	
	echo aw2_library::parse_shortcode($content);
