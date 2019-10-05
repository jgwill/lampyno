<?php
add_action('plugins_loaded','aw2_apps_library::load_apps',1);
add_action('init','aw2_apps_library::setup_apps',2);
add_filter( 'post_type_link', 'aw2_apps_library::fix_app_slug', 10, 3 );

add_action( 'admin_menu', 'aw2_apps_library::register_menus' );
add_action( 'cmb2_admin_init', 'aw2_apps_library::set_app_metabox' );
add_action( 'parse_request', 'aw2_apps_library::app_takeover' );
add_action('template_redirect', 'aw2_apps_library::template_redirect');

add_action('generate_rewrite_rules', 'aw2_apps_library::app_slug_rewrite');
add_action( 'add_meta_boxes', 'aw2_apps_library::app_modules_metabox' );
add_action( 'restrict_manage_posts', 'aw2_apps_library::add_taxonomy_filters',100 );
add_action( 'save_post_aw2_app', 'aw2_apps_library::save_defaults', 20, 3 );
add_action( 'wp_loaded', 'aw2_apps_library::initialize_app' );

add_filter( 'manage_aw2_app_posts_columns', 'aw2_apps_library::set_custom_edit_columns' );
add_action( 'manage_aw2_app_posts_custom_column' , 'aw2_apps_library::custom_column', 10, 2 );

//seo-sitemaps
add_filter( 'wpseo_sitemap_index', 'aw2_apps_library::add_apps_to_yoast_sitemap' );

require_once 'apps/app-settings.php';

class aw2_apps_library{
	static function load_apps(){
		
		$registered_apps=&aw2_library::get_array_ref('apps');
		
		$app_posts=get_posts('post_type=aw2_app&posts_per_page=-1&post_status=publish');
		foreach($app_posts as $app_post){
			$app = new stdclass();

			$app->base_path=site_url().'/'.$app_post->post_name;
			$app->path=site_url().'/'.$app_post->post_name;
			$app->name=$app_post->post_title;
			$app->slug=$app_post->post_name;
			//$this->options = cmb2_get_option( $this->slug .'_options','all');
			$app->default_post_type=get_post_meta($app_post->ID,'default_post_type',true);
			$app->default_taxonomy=get_post_meta($app_post->ID,'default_taxonomy',true);
			
			$app->default_pages=get_post_meta($app_post->ID,'default_pages',true);
			if(empty($app->default_pages))
				$app->default_pages = $app_post->ID .'_page';
			$app->default_modules=get_post_meta($app_post->ID,'default_modules',true);
			if(empty($app->default_modules))
				$app->default_modules = $app_post->ID .'_module';
			$app->default_triggers=get_post_meta($app_post->ID,'default_triggers',true);
			if(empty($app->default_triggers))
				$app->default_triggers = $app_post->ID .'_trigger';
			
			$registered_apps[$app_post->post_name]=$app;
		}
		
		$registered_apps['root']=self::get_root_app();

	}
	
	static function get_root_app(){
		$app_name='root';
		$app_slug='root';
		
		$app = new stdclass();

		$app->base_path=site_url().'/'.$app_slug;
		$app->path=site_url().'/'.$app_slug;
		
		$app->name=$app_name;
		$app->slug=$app_slug;
		//$this->options = cmb2_get_option( $this->slug .'_options','all');
		$app->default_post_type='';
		$app->default_taxonomy='';
		
		$app->default_pages='page';
		
		$app->default_modules='aw2_module';
		$app->default_triggers='aw2_trigger';
		
		return $app;
	}
	
	static function setup_apps(){
		Awesome_App_Settings::add_wp_actions();
		//add_action( 'cmb2_admin_init', 'aw2_app::set_options_page' );
		// register APP CPT itself.
		
		register_post_type('aw2_app', array(
			'label' => 'Awesome Apps',
			'public' => false,
			'show_in_nav_menus'=>true,
			'show_ui' => true,
			'show_in_menu' => false,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => false,
			'query_var' => false,
			'menu_icon'=>'dashicons-archive',
			'supports' => array('title','editor','revisions','thumbnail','custom-fields'),
			'rewrite' => true,
			'delete_with_user' => false,
			'labels' => array (
				  'name' => 'Awesome Apps',
				  'singular_name' => 'Awesome App',
				  'menu_name' => 'Awesome Apps',
				  'add_new' => 'Create New App',
				  'add_new_item' => 'Add New Awesome App',
				  'new_item' => 'New Awesome App',
				  'edit' => 'Edit Awesome App',
				  'edit_item' => 'Edit Awesome App',
				  'view' => 'View Awesome App',
				  'view_item' => 'View Awesome App',
				  'search_items' => 'Search Awesome Apps',
				  'not_found' => 'No Awesome App Found',
				  'not_found_in_trash' => 'No Awesome App Found in Trash'
				)
			) 
		);
		
		
		$registered_apps=&aw2_library::get_array_ref('apps');
		
		foreach($registered_apps as $key => $app){
			if($app->name == 'root')
				continue;
			
			self::register_cpt($app->default_pages,$app->name.' Pages',true,true,$key);
			self::register_cpt($app->default_triggers,$app->name.' Triggers',false);
			register_taxonomy_for_object_type('aw2_trigger_when', $app->default_triggers);
			
			self::register_cpt($app->default_modules,$app->name.' Modules',false);
			register_taxonomy_for_object_type('aw2_module_type', $app->default_modules);
			
			$wp_post_types[$app->default_post_type]->rewrite['slug'] = $key;
			$wp_rewrite->extra_permastructs[$app->default_post_type]['struct'] = "/".$key."/%".$app->default_post_type."%";
			$wp_rewrite->extra_permastructs[$app->default_post_type]['struct'] = "/".$key."/".$app->default_taxonomy."/%".$app->default_taxonomy."%";
		}

		self::setup_yoast_links();		
	}
	
	static function fix_app_slug( $post_link, $post, $leavename ) {
 		//now apps show list show up in the menu to make it easy to add to nav menu
		if ( 'aw2_app' != $post->post_type || 'publish' != $post->post_status ) {
			return $post_link;
		}
		
		$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
		return $post_link;
	}
	
	static function set_custom_edit_columns($columns){
		$columns['actions'] ='Actions';
		return $columns;
	}
	
	static function custom_column( $column, $post_id ) {
		switch ( $column ) {
			
			case 'actions' :
				$original_url=get_post_meta($post_id , '_module_thumb' , true);
				echo '<img src="'.@$thumb.'" width="250px" height="auto" style="max-width: 100%;" />';
			break;
		}
	}
	static function initialize_app(){
		//At init the app is set to default. The app will get changed as required when parse_request except for home where parse_request is not called 	
		if(!is_admin()){
			$app=new aw2_app();
			$arr=$app->setup_root();	
			
		}
		
	}	
	
	static function register_menus(){
		add_submenu_page('awesome-studio', 'Apps - Awesome Studio', 'Apps', 'develop_for_awesomeui', 'edit.php?post_type=aw2_app' );
		
		$registered_apps=&aw2_library::get_array_ref('apps');
		foreach($registered_apps as $key => $app){
			if($app->name == 'root')
				continue;
			
			add_menu_page( $app->name, $app->name.' App', 'manage_options', 'awesome-app-settings-'.$app->slug, 'aw2_apps_library::show_app_pages', 'dashicons-admin-multisite',3);
			//add_submenu_page('awesome-app-reports-'.$app->slug, $app->name.' Reports', 'Reports',  'manage_options', 'awesome-app-reports-'.$app->slug);
			add_submenu_page('awesome-app-settings-'.$app->slug, $app->name.' Settings', 'Settings',  'manage_options', 'awesome-app-settings-'.$app->slug,'aw2_apps_library::show_app_pages' );
			add_submenu_page('awesome-app-settings-'.$app->slug, $app->name.' Pages', 'Pages',  'manage_options', 'edit.php?post_type='.$app->default_pages );
			add_submenu_page('awesome-app-settings-'.$app->slug, $app->name.' Modules', 'Modules',  'develop_for_awesomeui','edit.php?post_type='.$app->default_modules);
			add_submenu_page('awesome-app-settings-'.$app->slug, $app->name.' Triggers', 'Triggers',  'develop_for_awesomeui', 'edit.php?post_type='.$app->default_triggers   );		
		}	
	}
	
	static function show_app_pages(){
	
		$slug=str_replace('awesome-app-','',$_REQUEST['page']);
		$parts = explode('-', $slug, 2);//0 is action and 1 is app slug
		
		//self::set_app($slug);
		$app = new aw2_app();
		$app->setup($parts[1]);
		
		echo '<div class="wrap ">';        	
		if(method_exists($app, $parts[0].'_page'))
			call_user_func(array($app, $parts[0].'_page'));
		echo '</div>';		
	}
	
	static function app_takeover($query){

		if(empty($query->request))
			return;
		
		$pieces = explode('/',$query->request);
		$app_slug=$pieces[0];
		array_shift($pieces);
		
		$arr=array();
		$arr['status']='';
		if($app_slug =='root'){
			
			$app=new aw2_app();
			$app->setup_root();
		}
		else if(aw2_library::get_post_from_slug($app_slug,'aw2_app',$post)){
			$app=new aw2_app();
			if($app_slug!='root'){
				$arr=$app->setup($app_slug);
			}
		}
		else{
			return;
		}		
			
		if($arr['status']=='error')
			return;
		
		$arr=$app->check_rights();
		

		if($arr['status']=='invalid_rights'){
			echo '<h3>You dont have rights to access this app</h3>';
			exit();
		}
		
		if($arr['status']=='error'){
			if(aw2_library::get_correct_post('login',$app->default_modules,$post)){
				echo aw2_library::run_module('login');
				exit();
			}
			
			$login_url=wp_login_url(site_url().'/'.$query->request);
			if(!empty(aw2_library::get('app.options.login_url'))){
			   $login_url=aw2_library::get('app.options.login_url');
			   $separator = (parse_url($login_url, PHP_URL_QUERY) == NULL) ? '?' : '&';
			   $login_url .= $separator.'redirect_to='.urlencode(site_url().'/'.$query->request);
			}
			wp_redirect( $login_url );
			exit();
		}
		
		$app->load_triggers();
		do_action('app_init');
	
		$app->resolve_route($pieces,$query);

		//data
		if($app->action == 'data' || $app->action == 'ajax-data'){
			if($app->lib){
				$result=aw2_library::run_cdn(array("lib"=>$app->lib, "module"=>$app->module, "template"=>$app->template));
			}
			else	
				$result=aw2_library::run_module($app->module,$app->template);
			
			echo json_encode($result);
			exit();	
		}
		
		//ajax or module
		if($app->action == 'ajax' || $app->action == 'module'){
			
			if($app->lib){
				$result=aw2_library::run_cdn(array("lib"=>$app->lib, "module"=>$app->module, "template"=>$app->template));
			}	
			else	
				$result=aw2_library::run_module($app->module,$app->template);

			echo $result;
			exit();	
		}

		//callback
		if($app->action == 'callback'){
			$pieces=explode('.',$app->module);
			$token=$pieces[0];
			$nonce=$pieces[1];
			
			//verify that nonce is valid
			if(wp_create_nonce($token)!=$nonce){
				echo 'Error E1:The Data Submitted is not valid. Check with Administrator';
				exit();		
			}
			$json=get_option($token);
			if(empty($json)){
				echo 'Error E2:The Data Submitted is not valid. Check with Administrator';
				exit();		
			}				
			echo aw2_library::call_api($json);
			exit();	
		}
		
		//ajax or module
		if($app->action == 'css'){
			
			if($app->lib){
				$result=aw2_library::run_cdn(array("lib"=>$app->lib, "module"=>$app->module, "template"=>$app->template));
			}	
			else	
				$result=aw2_library::run_module($app->module,$app->template);
			
			header("Content-type: text/css");
			header("Cache-Control: max-age=31536000"); 
			echo $result;
			exit();	
		}

		//ajax or module
		if($app->action == 'js'){
			
			if($app->lib){
				$result=aw2_library::run_cdn(array("lib"=>$app->lib, "module"=>$app->module, "template"=>$app->template));
			}	
			else	
				$result=aw2_library::run_module($app->module,$app->template);
			
			header("Content-type: application/javascript");
			header("Cache-Control: max-age=31536000"); 
			echo $result;
			exit();	
		}
		
		if($app->action == 'file'){
			$extension=$app->module;
			$filename=$_REQUEST['filename'];	
			$folder=aw2_library::get('realpath.app_folder');
			$path=$folder . $filename;
			
			switch ($extension) {
				case 'excel':
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');	
					break;				
				case 'xls':
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');	
					break;
				case 'xlsx':
					header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');	
					break;
				case 'pdf':
					header('Content-Type: application/pdf');	
					break;
			}			
			
			header('Content-Disposition: attachment;filename="' . $filename);
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			$result=file_get_contents($path);	
			echo $result;
			exit();	
		}
		
		
		if($app->action == 'excel'){
			$filename=$app->module;	
			$folder=aw2_library::get('realpath.app_folder');
			$path=$folder . $filename;

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename);
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
			$result=file_get_contents($path);	
			echo $result;
			exit();	
		}

		

		//managed modules
		if($app->action == 'custom_layout'){
			echo aw2_library::run_module('custom-layout',null,"",array("slug"=>$app->module));
			echo awesome2_footer();
			exit();
		}
		
		//pages are currently same as modules in behaviour
		if($app->action == 'pages'){
			if(aw2_library::get('app.options.custom_app_mode')=='on' )
				echo aw2_library::run_module(aw2_library::get('app.options.custom_header_module'));
				echo aw2_library::run_module($app->module);
			
			if(aw2_library::get('app.options.custom_app_mode')=='on' )
				echo aw2_library::run_module(aw2_library::get('app.options.custom_footer_module'));
			exit();
		}
		
		if($app->action == 'z'){
			
			if(empty($app->module) ){
				//show list of modules
				$args=array(
					'post_type' => $app->default_modules,
					'post_status'=>'publish',
					'posts_per_page'=>500,
					'no_found_rows' => true, // counts posts, remove if pagination required
					'update_post_term_cache' => false, // grabs terms, remove if terms required (category, tag...)
					'update_post_meta_cache' => false, // grabs post meta, remove if post meta required	
					'orderby'=>'title',
					'order'=>'ASC'
				);
				
				$results = new WP_Query( $args );
				$my_posts=$results->posts;

				foreach ($my_posts as $obj){
					echo('<a target=_blank href="' . site_url("wp-admin/post.php?post=" . $obj->ID  . "&action=edit") .'">' . $obj->post_title . '(' . $obj->ID . ')</a>' . '<br>');
				}
					echo('<br><a target=_blank href="' . site_url("wp-admin/post-new.php?post_type=" . $app->default_modules) .'">Add New</a><br>');

			
			} else {
				aw2_library::get_post_from_slug($app->module,$app->default_modules,$post);
				header("Location: " . site_url("wp-admin/post.php?post=" . $post->ID  . "&action=edit"));
			}
			exit();
		}
		
		if($app->action == 's'){
				$post_type=$app->default_modules;
				echo '<h3>Searching for:' . urldecode($app->module) . '</h3>';
				$sql="Select * from wp_posts where post_status='publish' and post_content like '%" . urldecode($app->module) . "%' and post_type='" . $post_type . "'";
				global $wpdb;
				$results = $wpdb->get_results($sql,ARRAY_A);
				foreach ($results as $result){
					echo('<a target=_blank href="' . site_url("wp-admin/post.php?post=" . $result['ID']  . "&action=edit") .'">' . $result['post_title'] . '(' . $result['ID'] . ')</a>' . '<br>');
				}				
				
			exit();
		}		
	
	}
	
	static function template_redirect(){
		$action=aw2_library::get('app.action');
		//aw2_library::d();
		if(aw2_library::get('app.options.theme_apperance.exists') && aw2_library::get('app.options.theme_apperance') == 'on') {
			add_filter('template_include', 'aw2_apps_library::do_not_include_template');
			aw2_library::set('app.content_overide', false);
			include('apps/template.php');
		} 
		else{
			//single or archive
			if($action == 'single' ){
				aw2_library::set('app.content_overide',true);
				add_filter('the_content','aw2_app::takeover_the_content',1); 
			}
			
			if($action == 'archive'){
				// not sure how to override in generic wp themes. monomyth handles it.
			}
			
			//page
			if($action == 'page' || $action == '404'){
				//do nothing it will be handled by theme 
			}
		}
		
		
	
	}
	
	//supporting functions
	static function do_not_include_template($template){
		return false;//do not include any thing
	}

	static function app_slug_rewrite($wp_rewrite) {
    	
		$rules = array();
		
		$registered_apps=&aw2_library::get_array_ref('apps');
		foreach($registered_apps as $key => $app){
			$rules[$app->slug . '/?$'] = 'index.php?pagename=home&post_type='.$app->default_pages;
			
			$default_cpt=$app->default_post_type;
			$defualt_tax = $app->default_taxonomy;
			
			if(!empty($default_cpt)){
				$app_structure = $wp_rewrite->root . $app->slug."/%".$default_cpt."%/";
				$app_rewrite = $wp_rewrite->generate_rewrite_rules($app_structure);
			
				$rules = array_merge($rules,$app_rewrite);
			} 
		}	
		
		$wp_rewrite->rules = $rules + $wp_rewrite->rules;

	}
	static function set_app_metabox(){
		$app_meta_box = new_cmb2_box( array(
			'id'            => 'app_metabox',
			'title'         => 'App Defaults',
			'object_types'  => array( 'aw2_app' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true
			) 
		);

		$app_meta_box->add_field( array(
			'name' => "Default Post Type",
			'desc' => "Default custom post type for this App",
			'id'   => 'default_post_type',
			'type' => 'text'
		) );
		
		$app_meta_box->add_field( array(
			'name' => "Default Taxonomy Type",
			'desc' => "Default custom taxonomy for this App",
			'id'   => 'default_taxonomy',
			'type' => 'text'
		) );
		
		$app_meta_box->add_field( array(
			'name' => "Default Pages CPT",
			'desc' => "Default CPT for App pages, if not specified it will take <postid>_page",
			'id'   => 'default_pages',
			'type' => 'text'
		) );
		
		$app_meta_box->add_field( array(
			'name' => "Default Modules CPT",
			'desc' => "Default CPT for App Modules, if not specified it will take <postid>_module",
			'id'   => 'default_modules',
			'type' => 'text'
		) );
		
		$app_meta_box->add_field( array(
			'name' => "Default Triggers CPT",
			'desc' => "Default CPT for App Triggers, if not specified it will take <postid>_trigger",
			'id'   => 'default_triggers',
			'type' => 'text'
		) );

	}
	static function register_cpt($post_type,$name,$public,$hierarchical=false,$slug=null){
		
		if($slug==null)$slug=$post_type;
		
		register_post_type($post_type, array(
			'label' => $name,
			'description' => '',
			'public' => $public,
			'show_in_nav_menus'=>false,
			'show_ui' => true,
			'show_in_menu' => false,
			'capability_type' => 'page',
			'delete_with_user'    => false,
			'map_meta_cap' => true,
			'hierarchical' => $hierarchical,
			'query_var' => true,
			'rewrite' => array("slug"=>$slug,'with_front'=>false),
			'register_meta_box_cb' => 'aw2_apps_library::app_modules_metabox',
			'supports' => array('title','editor','revisions','thumbnail'),
			'labels' => array (
				  'name' => $name,
				  'singular_name' => rtrim($name,'s'),
				  'add_new_item' => 'Add New '.rtrim($name,'s'),
				  'edit_item' => 'Edit '.rtrim($name,'s'),
				  'new_item' => 'New '.rtrim($name,'s'),
				  'view_item' => 'View '.rtrim($name,'s'),
				  'search_items' => 'Search '.$name,
				  'not_found' => 'No '.$name.' Found',
				  'not_found_in_trash' => 'No '.$name.' Found in Trash',
				)
			) 
		);
	}
	static function app_modules_metabox(){
		$registered_apps=&aw2_library::get_array_ref('apps');
		foreach($registered_apps as $key => $app){

			add_meta_box(
					'aw_ui_modulecode',
					'Local Module Selection',
					'asf_installed_distributables_page_callback',
					$app->default_modules ,'advanced','high'
				);
		}	
	}
	static function add_taxonomy_filters(){
		global $typenow;
	 
		// must set this to the post type you want the filter(s) displayed on
		$registered_apps=&aw2_library::get_array_ref('apps');
		foreach($registered_apps as $key => $app){
			if( $typenow == $app->default_modules){
				$taxonomies = array('aw2_module_type');
				foreach ($taxonomies as $tax_slug) {
					$tax_obj = get_taxonomy($tax_slug);
					$tax_name = $tax_obj->labels->name;
					$terms = get_terms($tax_slug);
					if(count($terms) > 0) {
						echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
						echo "<option value=''>All $tax_name</option>";
						foreach ($terms as $term) { 
							echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
						}
						echo "</select>";
					}
				}
				break;
			}
		}
	}
	
	static function save_defaults( $post_id, $post, $update ) {
	  // verify if this is an auto save routine. 
	  // If it is our form has not been submitted, so we dont want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;

		if ( !current_user_can( 'edit_post', $post_id ) )
			return;

		// OK, we're authenticated: we need to find and save the data
	
		if(empty($_POST['default_pages'])){
			update_post_meta($post_id,'default_pages',$post_id.'_page');
		}
		
		if(empty($_POST['default_modules'])){
			update_post_meta($post_id,'default_modules',$post_id.'_module');
		}
		
		if(empty($_POST['default_triggers'])){
			update_post_meta($post_id,'default_triggers',$post_id.'_trigger');
		}
		
		return;
	}

	static function  add_apps_to_yoast_sitemap(){
		global $wpseo_sitemaps;
		global $wpdb;
		
		$sql  = $wpdb->prepare(" SELECT MAX(p.post_modified_gmt) AS lastmod
						FROM	$wpdb->posts AS p
						WHERE post_status IN ('publish') AND post_type = %s ", 'aw2_app' );
		$mod = $wpdb->get_var( $sql )." +00:00";
				
		//$date = $wpseo_sitemaps->get_last_modified('aw2_app');
		$timezone =  new WPSEO_Sitemap_Timezone();
		$mod = $timezone->format_date($mod );
		$smp ='';
		
		$smp .= '<sitemap>' . "\n";
		$smp .= '<loc>' . site_url() .'/awesome-apps-sitemap.xml</loc>' . "\n";
		$smp .= '<lastmod>' . htmlspecialchars( $mod ) . '</lastmod>' . "\n";
		$smp .= '</sitemap>' . "\n";
		
		return $smp;
	}
	
	static function setup_yoast_links(){
		add_action( "wpseo_do_sitemap_awesome-apps", 'aw2_apps_library::awesome_apps_pages_sitemap');
	}
	
	static function awesome_apps_pages_sitemap(){
		global $wpseo_sitemaps;
		global $wpdb;
		
		$registered_apps=&aw2_library::get_array_ref('apps');
		$skip_slugs=array('single','archive','header','footer');
		
		$output = '';
		foreach($registered_apps as $key => $app){
			
			if($app->slug=='root')
				continue;

			$app_options = cmb2_get_option( $app->slug .'_options','all');	
			
			if(!empty($app_options['members_only'])){
				continue;
			}
			
			$args = array(
				'posts_per_page'   => -1,
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => $app->default_pages,
				'post_status'      => 'publish',
				'suppress_filters' => true
			);
			
			$app_pages = new WP_Query( $args );
			
			
			if( $app_pages->have_posts() ){
				$chf = 'weekly';
				$pri = 1.0;
				foreach ( $app_pages->posts as $p ) {
					if(in_array($p->post_name,$skip_slugs)){
						continue;
					}
					$slug= $p->post_name.'/';
					if($slug=='home')
						$slug='';
					
					$url = array();
					if ( isset( $p->post_modified_gmt ) && $p->post_modified_gmt != '0000-00-00 00:00:00' && $p->post_modified_gmt > $p->post_date_gmt ) {
						$url['mod'] = $p->post_modified_gmt;
					} else {
						if ( '0000-00-00 00:00:00' != $p->post_date_gmt ) {
							$url['mod'] = $p->post_date_gmt;
						} else {
							$url['mod'] = $p->post_date;
						}
					}
					$url['loc'] = site_url().'/'.$app->slug.'/'.$slug;
					$url['chf'] = $chf;
					$url['pri'] = $pri;
					$output .= $wpseo_sitemaps->sitemap_url( $url );
				}
			}

			if(!empty($app->default_post_type)){
				$args = array(
					'posts_per_page'   => -1,
					'orderby'          => 'post_date',
					'order'            => 'DESC',
					'post_type'        => $app->default_post_type,
					'post_status'      => 'publish',
					'suppress_filters' => true
				);
				
				$app_posts = new WP_Query( $args );
				
				
				if( $app_posts->have_posts() ){
					$chf = 'weekly';
					$pri = 1.0;
					foreach ( $app_posts->posts as $p ) {
								
						$url = array();
						if ( isset( $p->post_modified_gmt ) && $p->post_modified_gmt != '0000-00-00 00:00:00' && $p->post_modified_gmt > $p->post_date_gmt ) {
							$url['mod'] = $p->post_modified_gmt;
						} else {
							if ( '0000-00-00 00:00:00' != $p->post_date_gmt ) {
								$url['mod'] = $p->post_date_gmt;
							} else {
								$url['mod'] = $p->post_date;
							}
						}
						$url['loc'] = site_url().'/'.$app->slug.'/'.$p->post_name.'/';
						$url['chf'] = $chf;
						$url['pri'] = $pri;
						$output .= $wpseo_sitemaps->sitemap_url( $url );
					}
				}
			}
			if(!empty($app->default_taxonomy)){
				$sql  = $wpdb->prepare(" SELECT MAX(p.post_modified_gmt) AS lastmod
						FROM	$wpdb->posts AS p
						WHERE post_status IN ('publish') AND post_type = %s ", $app->default_post_type );
				$mod = $wpdb->get_var( $sql );

				$terms = get_terms( array(
							'taxonomy' => $app->default_taxonomy,
							'hide_empty' => false,
						) );
				if( ! empty( $terms ) && ! is_wp_error( $terms )  ){
					$chf = 'weekly';
					$pri = 1.0;
					foreach ( $terms as $term  ) {
	
						$url = array();
						$url['loc'] = site_url().'/'.$app->slug.'/'.$term->slug.'/';
						$url['pri'] = $pri;
						$url['mod'] = $mod;
						$url['chf'] = $chf;
						$output .= $wpseo_sitemaps->sitemap_url( $url );
						
					}
				}
				
			}
			
	
		}

		if ( empty( $output ) ) {
            $wpseo_sitemaps->bad_sitemap = true;
            return;
        }
		//Build the full sitemap
        $sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
        $sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
        $sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $sitemap .= $output . '</urlset>';
        //echo $sitemap;
        $wpseo_sitemaps->set_sitemap($sitemap);
	}
}

class aw2_app{
	public $lib;
	public function setup($app_slug){
		$arr['status']='error';
		if(!aw2_library::get_post_from_slug($app_slug,'aw2_app',$app))
			return $arr;
		
		$this->base_path=site_url().'/'.$app->post_name;
		$this->path=site_url().'/'.$app->post_name;
		$this->slug=$app->post_name;
		$this->name=$app->post_title;
		
		$this->options = cmb2_get_option( $app->post_name .'_options','all');
	
		$this->default_post_type=get_post_meta($app->ID,'default_post_type',true);
		$this->default_taxonomy=get_post_meta($app->ID,'default_taxonomy',true);
		
		$this->default_pages=get_post_meta($app->ID,'default_pages',true);
		if(empty($this->default_pages))
			$this->default_pages = $app->ID .'_page';
		
		$this->default_modules=get_post_meta($app->ID,'default_modules',true);
		if(empty($this->default_modules))
			$this->default_modules = $app->ID .'_module';
		
		$this->default_triggers=get_post_meta($app->ID,'default_triggers',true);
		if(empty($this->default_triggers))
			$this->default_triggers = $app->ID .'_trigger';	
		
		aw2_library::set('app',$this);				
		$arr['status']='success';
		return $arr;
	}

	public function setup_root(){
		$app_name='root';
		$app_slug='root';
		$arr['status']='error';

		$return=$this->setup($app_slug);
		
		if($return['status']=='success'){
			$arr['status']='success';
			return $arr;
		}
			
		$this->path=site_url().'/'.$app_name;
		$this->slug=$app_name;
	
		$this->default_post_type='post';
		$this->default_taxonomy='category';
		$this->default_pages='page';
		$this->default_modules='aw2_module';
		$this->default_triggers='aw2_trigger';
		aw2_library::set('app',$this);				
		$arr['status']='success';
		return $arr;
		
	}
	
	public function check_rights(){
		$arr=array();
		$arr['status']='error';

		if(isset($this->default_modules) && aw2_library::get_post_from_slug('check-rights',array($this->default_modules),$post)){
			return aw2_library::run_module('check-rights');
		}
		
		if(empty(aw2_library::get('app.options.members_only'))){
			$arr['status']='success';
			return $arr;
		}
		
		//You should be logged in
		if(!is_user_logged_in()){
			return $arr;
		}

		// The person is logged in

 		if(current_user_can('administrator')){
			$arr['status']='success';
			return $arr;
		}
		
		
		if(empty(aw2_library::get('app.options.access_role')) && empty(aw2_library::get('app.options.access_user'))){
			$arr['status']='success';
			return $arr;
		} 
		
		$current_user = wp_get_current_user();
		
		//check if current user is given explicit permission.	
		if(in_array($current_user->ID,aw2_library::get('app.options.access_user'))){
			$arr['status']='success';
			return $arr;
		}
		
		// We must match the role, check for multiple
		$roles=aw2_library::get('app.options.access_role');
		if(!is_array($roles)){
			$roles = array($roles);
		}
		
		
		$current_role = current( $current_user->roles );
		
		if(!in_array($current_role,$roles)){
			$arr['status']='invalid_rights';
			return $arr;
		} 

		if(in_array($current_role,$roles)){
			$arr['status']='success';
			return $arr;
		} 
		
		return $arr;
	}
	
	public function load_triggers(){
		$arr=array();
		$arr['status']='success';
		awesome2_trigger::load_app();
		
		return $arr;
	}
	
	static function takeover_the_content($content){
		
		//remove_filter('the_content','aw2_app::takeover_the_content',1);
		$action=aw2_library::get('app.action');
		if($action == 'single')
			aw2_library::get_post_from_slug('single',$post_type,$post);
		
		return $post->post_content;
	}
		
	public function settings_page(){
		$app=&aw2_library::get_array_ref('app');
		
		$tab_url=menu_page_url( $_REQUEST['page'],false );
		$panel ='';
		if(isset($_GET['panel']))
			$panel = $_GET['panel'];
		echo '<style>
		p.cmb2-metabox-description{
			width:300px;
		}
		</style>
		
		<div class="wrap ">';        	
		echo '<h2>'.$app->name.' Settings</h2>';
		awesome2_trigger::run_settings_triggers('aw2_trigger');        
		awesome2_trigger::run_settings_triggers($app->default_triggers);        
		$app_setting_sections = aw2_library::get_array_ref('app_setting_sections');
		
		$ref=&aw2_library::get_array_ref();
		unset($ref['app_setting_sections']);
		
		Awesome_App_Settings::display_setting($app->slug,$app_setting_sections,$tab_url,$panel);

		echo '</div>';		
	}

	public function reports_page(){
		$app=&aw2_library::get_array_ref('app');
		wp_enqueue_script( 'aw2_distri', plugins_url('monoframe/module-distribution/js/aw2_distributables.js',dirname(__FILE__)), array(), '3.1.1' );
		$module_slug = "reports";	
		echo '<h2>'.$app->name.' Reports</h2>';
		echo aw2_library::run_module($module_slug,null,null,array("post_type"=>$app->default_post_type,"taxonomy"=>$app->default_taxonomy),$app->default_modules);
	}

	public function resolve_route($pieces,$query){
		$o=new stdClass();
		$o->pieces=$pieces;
		$this->route=implode("/",$pieces);
	
		//Check if it home
		if(empty($o->pieces))
			$o->pieces=array('home');
		
		
		if(current_user_can("develop_for_awesomeui")){
			if(empty($this->action))
				$this->resolve_z($o);

			if(empty($this->action))
				$this->resolve_s($o);
		}
		
		if(empty($this->action))
			$this->resolve_ajax($o);

		
		if(empty($this->action))
			$this->resolve_ajax_data($o);
		
		if(empty($this->action))
			$this->resolve_modules($o);

		if(empty($this->action))
			$this->resolve_pages($o);

		if(empty($this->action))
			$this->resolve_data($o);
		
		if(empty($this->action))
			$this->resolve_css($o);

		if(empty($this->action))
			$this->resolve_js($o);		
		
		if(empty($this->action))
			$this->resolve_excel($o);

		if(empty($this->action))
			$this->resolve_file($o);
		
		if(empty($this->action)){
			
			unset($query->query_vars['name']);
			unset($query->query_vars['post_type']);
			unset($query->query_vars[$this->default_pages]);
			unset($query->query_vars[$this->default_post_type]);
			unset($query->query_vars[$this->default_taxonomy]);
			
			$this->resolve_leaf($o,$query);
		}


		$qs=&aw2_library::get_array_ref('qs');
		$i=0;
		foreach ($o->pieces as $value){
			$pos = strpos($value, '$');
			if ($pos === false) {
				$qs[$i]=$value;
				$i++;
			} else {
				$arr=explode('~',$value);
				$qs[$arr[0]]=$arr[1];
			}
		}

	}

	private function resolve_ajax($o){
		if(empty($o->pieces) || $o->pieces[0]!='ajax' )return;
		$this->ajax='yes';
		array_shift($o->pieces);	
		if($o->pieces[0]=='callback'){
			$this->action='callback';//ajax or ajax-data
			array_shift($o->pieces);
			$this->module=$o->pieces[0];
			return;
		}
		
		$this->action='ajax';//ajax or ajax-data
		if(empty($o->pieces)){
			$this->module=aw2_library::get_request('slug');
			$this->template=aw2_library::get_request('template');
		}
		else{
			$this->module=$o->pieces[0];
			array_shift($o->pieces);
			$this->module_parts();
		}
	}

	private function resolve_css($o){
		if(empty($o->pieces) || $o->pieces[0]!='css' )return;
		$this->action='css';//css
		
		array_shift($o->pieces);		
		if(empty($o->pieces)){
			$this->module=aw2_library::get_request('slug');
			$this->template=aw2_library::get_request('template');
		}
		else{
			$this->module=$o->pieces[0];
			array_shift($o->pieces);
			$this->module_parts();
		}
	}
	
	private function resolve_js($o){
		if(empty($o->pieces) || $o->pieces[0]!='js' )return;
		$this->action='js';//css
		
		array_shift($o->pieces);		
		if(empty($o->pieces)){
			$this->module=aw2_library::get_request('slug');
			$this->template=aw2_library::get_request('template');
		}
		else{
			$this->module=$o->pieces[0];
			array_shift($o->pieces);
			$this->module_parts();
		}
	}	

	private function resolve_excel($o){
		if(empty($o->pieces) || $o->pieces[0]!='excel' )return;
		$this->action='excel';//css
		array_shift($o->pieces);
		$this->module=$o->pieces[0];
	}
	
	private function resolve_file($o){
		if(empty($o->pieces) || $o->pieces[0]!='file' )return;
		$this->action='file';//css
		array_shift($o->pieces);
		$this->module=$o->pieces[0];
	}
	
	private function resolve_ajax_data($o){
		if(empty($o->pieces) || $o->pieces[0]!='ajax-data' )return;
		
		$this->ajax='yes';
		$this->action='ajax-data';//ajax or ajax-data
		
		array_shift($o->pieces);		
		if(empty($o->pieces)){
			$this->module=aw2_library::get_request('slug');
			$this->template=aw2_library::get_request('template');
		}
		else{
			$this->module=$o->pieces[0];
			array_shift($o->pieces);
			$this->module_parts();
		}
	}

	private function resolve_z($o){
		if(empty($o->pieces) || $o->pieces[0]!='z')return;
		array_shift($o->pieces);
		
		$this->action='z';
		$this->module= '';
		if(count($o->pieces)==1 ){
			$this->module = $o->pieces[0];
			array_shift($o->pieces);
		}
	}	
	
	private function resolve_s($o){
		if(empty($o->pieces) || $o->pieces[0]!='s')return;
		array_shift($o->pieces);
		
		$this->action='s';
		$this->module= '';
		if(count($o->pieces)==1 ){
			$this->module = $o->pieces[0];
			array_shift($o->pieces);
		}
	}	

	
	private function resolve_modules($o){
		if(empty($o->pieces) || $o->pieces[0]!='modules')return;
		array_shift($o->pieces);
		
		$this->action='module';
		$this->module = $o->pieces[0];
		array_shift($o->pieces);
		$this->module_parts();
	}	
	
	private function resolve_pages($o){
		if(empty($o->pieces) || $o->pieces[0]!='pages')return;
		array_shift($o->pieces);
		
		$this->action='pages';
		$this->module = $o->pieces[0];
		array_shift($o->pieces);		
	}

	private function resolve_data($o){
		if(empty($o->pieces) || $o->pieces[0]!='data')return;
		array_shift($o->pieces);
		$this->action='data';
		
		if(empty($o->pieces)){
			$this->module=aw2_library::get_request('slug');
			$this->template=aw2_library::get_request('template');
		}
		else{
			$this->module=$o->pieces[0];
			array_shift($o->pieces);
			$this->module_parts();
		}
	}

	private function module_parts(){
		$t=strpos($this->module,'.');
		if($t===false){
			$this->template='';
			return;	
		}
		$parts=explode ('.' , $this->module); 

		if($parts[0]=='cdn'){
			array_shift($parts);
			$this->lib=$parts[0];
			array_shift($parts);
			$this->module=$parts[0];
			array_shift($parts);
			$this->template=implode('.',$parts);
			return;	
		}

		$this->module=$parts[0];
		array_shift($parts);
		$this->template=implode('.',$parts);
	}
	
	private function resolve_leaf($o,$query){
		if(empty($o->pieces))return;
		$slug=$o->pieces[0];
		$options=$this->options;

		
		//check if it is a page
		$post_type=$this->default_pages;
		if(aw2_library::get_post_from_slug($slug,$post_type,$post)){
			array_shift($o->pieces);
			$this->action='page';
			
			$query->query_vars['post_type']=$post_type;
			$query->query_vars['pagename']=$slug;
			unset($query->query_vars['attachment']);
			return;
		}		
		//check if it is a post
		$post_type=$this->default_post_type;
		if(!empty($post_type) && aw2_library::get_post_from_slug($slug,$post_type,$post)){
			array_shift($o->pieces);
			$this->action='single';
			
			$query->query_vars[$post_type]=$slug;
			$query->query_vars['post_type']=$post_type;
			$query->query_vars['name']=$slug;
			return;
		}		
		//check if it is a term
		$taxonomy=$this->default_taxonomy;
		if(!empty($taxonomy) && term_exists( $slug, $taxonomy )){
			array_shift($o->pieces);
			$this->action='archive';
			
			$query->query_vars[$taxonomy]=$slug;
			$query->query_vars['post_type']=$post_type;
			return;
		}	
		//check if it is a module
		$post_type=$this->default_modules;
		
		if(aw2_library::get_post_from_slug($slug,$post_type,$post)){
			array_shift($o->pieces);
			$this->action='custom_layout';
			$this->module=$slug;
			return;
		}		
			
		// see if there are any regex registered else 404 error
		$post_type=$this->default_pages;
		if(aw2_library::get_post_from_slug('404-page',$post_type,$post)){
			array_shift($o->pieces);
			$this->action='404';
			
			$query->query_vars['post_type']=$post_type;
			$query->query_vars['pagename']='404-page';
			return;
		}		
	}
}