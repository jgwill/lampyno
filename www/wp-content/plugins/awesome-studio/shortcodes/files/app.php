<?php
aw2_library::add_shortcode('app','backup', 'app_backup');
function app_backup($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;

	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	
	if(!$main)
		return;

	$app_posts=get_posts('post_type=aw2_app&posts_per_page=-1&post_status=publish');
	$all_apps=array();
	foreach($app_posts as $app_post){
		$s=get_post_meta($app_post->ID,'slug',true);
		if($s==$main){
			$page=$app_post->ID.'_page';
			$module=$app_post->ID.'_module';
			$trigger=$app_post->ID.'_trigger';
		}	
	}

	
	$upload_dir=wp_upload_dir()['basedir'];
	
	$apps_backup=$upload_dir . '/apps_backup';
	if (!file_exists($apps_backup)) {
		mkdir($apps_backup, 0777, true);
	}
	
	$app_directory=$apps_backup . '/' . $main;
	if (!file_exists($app_directory)) {
		mkdir($app_directory, 0777, true);
	}

	create_backup($page,$app_directory);
	create_backup($module,$app_directory);
	create_backup($trigger,$app_directory);
	return;	
}

function deleteDir($path) {
    if (empty($path)) { 
        return false;
    }
    return is_file($path) ?
            @unlink($path) :
            array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path);
}	

function create_backup($post_type,$app_directory){
	$args = array( 'posts_per_page' => -1, 'post_type'=>$post_type, 'post_status'=>'publish');
	$posts = get_posts( $args );
	
	deleteDir($app_directory . '/' . $post_type);
	if (!file_exists($app_directory . '/' . $post_type)) {
		mkdir($app_directory . '/' . $post_type, 0777, true);
	}
	
	
	foreach ( $posts as $post ){
		$one_page=new stdClass();
		$one_page->post_name=$post->post_name;
		$one_page->post_content=$post->post_content;
		$one_page->post_title=$post->post_title;
		$one_page->post_type=$post->post_type;
		$one_page_json=json_encode($one_page);
		$file = $app_directory . '/' . $post_type . '/' . $post->post_name . '.json';
		file_put_contents($file,$one_page_json);
	}

	
	
}


aw2_library::add_shortcode('app','restore', 'app_restore');
function app_restore($atts,$content=null,$shortcode){
	if(aw2_library::pre_actions('all',$atts,$content,$shortcode)==false)return;
	extract( shortcode_atts( array(
	'main'=>null
	), $atts) );
	
	if(!$main)
		return;
	
	$app_posts=get_posts('post_type=aw2_app&posts_per_page=-1&post_status=publish');
	$all_apps=array();
	foreach($app_posts as $app_post){
		$s=get_post_meta($app_post->ID,'slug',true);
		if($s==$main){
			$page=$app_post->ID.'_page';
			$module=$app_post->ID.'_module';
			$trigger=$app_post->ID.'_trigger';
		}	
	}
	
	$upload_dir=wp_upload_dir()['basedir'];
	
	$apps_backup=$upload_dir . '/apps_backup';
	$app_directory=$apps_backup . '/' . $main;

	echo '<br><br><div><h3>Updating Pages</h3></div>';
	restore_backup($page,$app_directory);

	echo '<br><br><div><h3>Updating Modules</h3></div>';
	restore_backup($module,$app_directory);
	
	echo '<br><br><div><h3>Updating Triggers</h3></div>';
	restore_backup($trigger,$app_directory);

	
	$return_value=aw2_library::get($main,$atts,$content);
	
	$return_value=aw2_library::post_actions('all',$return_value,$atts);
	return $return_value;
}

function restore_backup($post_type,$app_directory){
	$args = array( 'posts_per_page' => -1, 'post_type'=>$post_type,'post_status'=>'publish');
	$posts = get_posts( $args );
	
	$current_list=array();
	foreach ( $posts as $post ){
		$current_list[$post->post_name]=$post->post_name;
	}
	$post_directory = $app_directory . '/' . $post_type ;
	if (!file_exists($post_directory)) {
		echo "Cannot Restore " . $post_type ;
		return;
	} 
	$files = scandir($post_directory);
	
	$file_list=array();
	foreach($files as $file){
		if( is_file($post_directory . '/' . $file) )
		{
			$name=str_replace('.json','',$file);
			$file_list[$name]=$name;
		}
	}
	$list=array_merge($current_list,$file_list);
	
	foreach($list as $post_name){
		//if exists only in file_list and not in current_list insert
		if(!array_key_exists($post_name,$current_list) && array_key_exists($post_name,$file_list) ){
			$json=file_get_contents($post_directory . '/' . $post_name . '.json');
			$arr=json_decode($json);
			$args=array();
			$args['post_name']=$arr->post_name;
			$args['post_title']=$arr->post_title;
			$args['post_type']=$post_type;
			$args['post_content']=$arr->post_content;
			$args['post_status']='publish';
			$return_value= wp_insert_post($args,true);
			if(	is_object($return_value) && get_class($return_value)=='WP_Error'){
				util::var_dump($return_value); 
				return;
			}
			echo '<div>' . $post_name . ' is created</div>';
		}
			
		//if exists only in current_list and not in file_list trash
		if(array_key_exists($post_name,$current_list) && !array_key_exists($post_name,$file_list) ){
				aw2_library::get_post_from_slug($post_name,$post_type,$post);
				wp_trash_post( $post->ID);
				echo '<div>' . $post_name . ' is trashed</div>';
		}
		
		//if exists in both list update
		if(array_key_exists($post_name,$current_list) && array_key_exists($post_name,$file_list) ){
			$json=file_get_contents($post_directory . '/' . $post_name . '.json');
			$obj=json_decode($json);
			aw2_library::get_post_from_slug($post_name,$post_type,$post);
			
			$args = array(
			  'ID'           => $post->ID,
			  'post_title'   => $obj->post_title,
			  'post_content' => $obj->post_content,
			  'post_status' => 'publish'
			);

			// Update the post into the database
			wp_update_post( $args );
			echo '<div>' . $post_name . ' is updated</div>';
		}
		
	}
	
}
