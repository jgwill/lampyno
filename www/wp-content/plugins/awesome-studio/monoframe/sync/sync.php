<?php

add_action( 'admin_menu', 'awesome_sync::setup' );
add_action( 'cmb2_admin_init', 'awesome_sync::add_settings_metabox' );
add_action( 'admin_init', 'awesome_sync::admin_init' );
add_action( 'add_meta_boxes', 'awesome_sync::sync_meta_boxes' );

add_action( 'wp_ajax_awesome_sync_init', 'awesome_sync::initialize_sync' );
add_action( 'wp_ajax_awesome_bulk_sync', 'awesome_sync::initialize_bulk_sync' );
add_action( 'wp_ajax_nopriv_awesome_remote_pull', 'awesome_sync::pull' );
add_action( 'wp_ajax_nopriv_awesome_remote_push', 'awesome_sync::push' );
add_action( 'wp_ajax_nopriv_awesome_remote_bulk_pull', 'awesome_sync::bulk_pull' );

class awesome_sync{
	
	static function setup(){
		$my_page = add_submenu_page('awesome-studio', 'Awesome Sync', 'Sync', 'develop_for_awesomeui', 'awesome-sync', 'awesome_sync::sync_dashboard' );
		add_action( "admin_print_styles", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
		add_action( 'load-' . $my_page, 'awesome_sync::load_js' );
	}
	
	static function load_js(){
		add_action( 'admin_enqueue_scripts', 'awesome_sync::enqueue_admin_js' );
	}
	
	static function enqueue_admin_js(){
		wp_enqueue_script( 'awsome-sync-script', plugins_url('sync/js/sync.js',dirname(__FILE__)), array() );
		wp_enqueue_script( 'ladda-spin', '//cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/spin.min.js', array(), '1.2.4' );
		wp_enqueue_script( 'ladda', '//cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.js', array(), '1.2.4' );
		wp_enqueue_style( 'ladda-css', '//cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.css', array(), '3.1.1' );
		wp_enqueue_script( 'bootstrap', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js', array(), '4.0.0' );
		wp_enqueue_script( 'bootbox', '//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js', array(), '4.4.0' );
	}
	
	static function admin_init(){
		register_setting( 'awesome-sync', 'awesome-sync' );
		
	}
	
	static function sync_meta_boxes($post_type){
		$post_types= Monoframe::get_awesome_post_type();
		if(in_array($post_type,$post_types)){
			self::load_js();
			add_meta_box(
					'awesome_sync_metabox',
					'Awesome Sync',
					'awesome_sync::metabox',
					$post_type , 'side', 'core');			
		}
	}
	
	static function metabox(){
		
		global $post;
		global $pagenow;
		$app_slug=null;
		if(in_array( $pagenow, array( 'post-new.php' ) )){
			echo'<div class="awesome-sync-metabox" style="text-align:center">';
			echo '<p> Sync is avilable in <em>edit</em> mode.</p>';
			echo'</div>';
			return;
		}	
	
		 
		$site_sync_settings = cmb2_get_option( 'awesome-sync','all');
		$options='';
		if(is_array($site_sync_settings) && isset($site_sync_settings['awesome-sync-sites'])){
			foreach($site_sync_settings['awesome-sync-sites'] as $s){
			 $options .='<option value="'.$s['site_url'].'">'.$s['site_url'].'</option>';	
			}
		}
		
		//get the parent app if it is app item
		$args = array(
			'post_type' => 'aw2_app',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key'     => 'default_triggers',
					'value'   => $post->post_type,
					'compare' => '=',
				),
				array(
					'key'     => 'default_modules',
					'value'   => $post->post_type,
					'compare' => '=',
				),
				array(
					'key'     => 'default_pages',
					'value'   => $post->post_type,
					'compare' => '=',
				),
			),	
		);
		$parent_app = new WP_Query( $args );
		
		//util::var_dump($parent_app);
		
		if($parent_app->found_posts){
			$app_slug= $parent_app->post->post_name;
			unset($parent_app);
		}
		
		echo '
		<style>
		.awesome-sync-metabox{
			text-align:center;
		}
		.awesome-sync-metabox button{
			margin-top:5px;
		}
		</style>
		';
		
		echo'<div class="awesome-sync-metabox">';
		echo' <div class="js-action-msg"></div>
			
			<select name="site_sync_url" class="js-site-sync-url" style="width:100%">
				<option value="">Select URL</option>'.$options.'
			</select>
			
			<button type="button" class="btn button-large ladda-button js-push-button" data-slug="'.$post->post_title.'" data-post_type="'.$post->post_type.'" data-app="'.$app_slug.'" data-reload="false" data-style="zoom-out"><span class="ladda-label">Push</span></button>
			<button type="button" class="button-large btn ladda-button js-pull-button" data-slug="'.$post->post_title.'" data-post_type="'.$post->post_type.'" data-app="'.$app_slug.'" data-reload="true" data-style="zoom-out"><span class="ladda-label">Pull</span></button>';
		echo'</div>';
	}
	static function sync_dashboard(){
		
		$tab_url=menu_page_url( $_REQUEST['page'],false );
		
		if(!isset($_GET['tab']))
			$panel = 'mods';
		else
			$panel = $_GET['tab'];
		
		echo '<div class="wrap ">';        	
		echo '<h2>Awesome Sync</h2>';
		echo '<div class="nav-tab-wrapper">
				<a href="?page=awesome-sync&tab=mods" class="nav-tab ';if($panel=='mods'){echo ' nav-tab-active';}echo'">Recent Mods</a>
				<a href="?page=awesome-sync&tab=bulk" class="nav-tab ';if($panel=='bulk'){echo ' nav-tab-active';}echo'">Bulk Sync</a>
				<a href="?page=awesome-sync&tab=settings" class="nav-tab ';if($panel=='settings'){echo ' nav-tab-active';}echo'">Settings</a>
			 </div>';	
		if(method_exists('awesome_sync',$panel.'_panel'))
			call_user_func(array('awesome_sync', $panel.'_panel'));
		echo '</div>';		 
	}
	
	static function mods_panel(){
		$lastupdated_args = array(
			'orderby' => 'modified',
			'post_type' => Monoframe::get_awesome_post_type(), 
			'ignore_sticky_posts' => '1',
			 'date_query' => array(
				array(
					'after' => '2 week ago'
				)
			)
		);
		
	   $lastupdated = new WP_Query( $lastupdated_args );
	   
		$site_sync_settings = cmb2_get_option( 'awesome-sync','all');
		echo '<div class="panel ">';
		echo '<table class="wp-list-table widefat striped pages"><tbody id="the-list">';
			echo self::show_mod_row($lastupdated->posts,'aw2_module',"Global Modules",$site_sync_settings);
			echo self::show_mod_row($lastupdated->posts,'aw2_trigger',"Global Triggers",$site_sync_settings);		
			echo self::show_mod_row($lastupdated->posts,'aw2_shortcode',"Shortcodes",$site_sync_settings);
			$registered_apps=&aw2_library::get_array_ref('apps');
			
			foreach ($registered_apps as $app){
				
				$app_post_types[]=$app->default_modules;
				echo self::show_mod_row($lastupdated->posts,$app->default_pages,$app->name." Pages",$site_sync_settings,$app->slug);
				echo self::show_mod_row($lastupdated->posts,$app->default_modules,$app->name." Modules",$site_sync_settings,$app->slug);
				echo self::show_mod_row($lastupdated->posts,$app->default_triggers,$app->name." Triggers",$site_sync_settings,$app->slug);
			}
			
		echo '</tbody></table>';	
		echo '</div>';		
	}
	static function bulk_panel(){
		$options='';
		$site_sync_settings = cmb2_get_option( 'awesome-sync','all');
		if(is_array($site_sync_settings) && isset($site_sync_settings['awesome-sync-sites'])){
			foreach($site_sync_settings['awesome-sync-sites'] as $s){
			 $options .='<option value="'.$s['site_url'].'">'.$s['site_url'].'</option>';	
			}
		}
		echo'
		<style>
			.js-progress{
				display:none;
			}
			progress[value] {
			  /* Reset the default appearance */
			  -webkit-appearance: none;
			  appearance: none;
			  border:none;
			  width: 315px;
			  height: 10px;
			 
			  margin-bottom: 2px;
			}
			
		</style>
		
		
		';
		
		echo '<div class="bluk ">' ; 
		echo '<table class="wp-list-table widefat striped pages"><tbody id="the-list">';
		echo '<tr id="" class="">
				<th scope="row" class="title column-title column-primary page-title" data-colname="Title">	
					Global Modules
				</th>
				<td class="actions column-actions" data-colname="Actions">
					<div>
						<progress class="js-progress" max="100" value="0"></progress>
					<div>
					<div class="js-action-msg"></div>
					<select name="site_sync_url" class="js-site-sync-url">
						<option value="">Select URL</option>'.$options.'
					</select>
					<button class="btn ladda-button js-bulk-push-button" data-post_type="aw2_module" data-style="zoom-out"><span class="ladda-label">Bulk Push</span></button>
					<button class="btn ladda-button js-bulk-pull-button" data-post_type="aw2_module" data-style="zoom-out"><span class="ladda-label">Bulk Pull</span></button>
				</td>	
			</tr>';
		echo '<tr id="" class="">
				<th scope="row" class="title column-title column-primary page-title" data-colname="Title">	
					Global Triggers
				</th>
				<td class="actions column-actions" data-colname="Actions">
					<div>
						<progress class="js-progress" max="100" value="0"></progress>
					<div>
					<div class="js-action-msg"></div>
					<select name="site_sync_url" class="js-site-sync-url">
						<option value="">Select URL</option>'.$options.'
					</select>
					<button class="btn ladda-button js-bulk-push-button" data-post_type="aw2_trigger" data-style="zoom-out"><span class="ladda-label">Bulk Push</span></button>
					<button class="btn ladda-button js-bulk-pull-button" data-post_type="aw2_trigger" data-style="zoom-out"><span class="ladda-label">Bulk Pull</span></button>
				</td>	
			</tr>';
		echo '<tr id="" class="">
				<th scope="row" class="title column-title column-primary page-title" data-colname="Title">	
					Shortcodes
				</th>
				<td class="actions column-actions" data-colname="Actions">
					<div>
						<progress class="js-progress" max="100" value="0"></progress>
					<div>
				    <div class="js-action-msg"></div>
					<select name="site_sync_url" class="js-site-sync-url">
						<option value="">Select URL</option>'.$options.'
					</select>
					<button class="btn ladda-button js-bulk-push-button" data-post_type="aw2_shortcode" data-style="zoom-out"><span class="ladda-label">Bulk Push</span></button>
					<button class="btn ladda-button js-bulk-pull-button" data-post_type="aw2_shortcode" data-style="zoom-out"><span class="ladda-label">Bulk Pull</span></button>
				</td>	
			</tr>';
			
			$registered_apps=&aw2_library::get_array_ref('apps');
			foreach ($registered_apps as $app){
				
				echo '<tr id="" class="">
					<th scope="row" class="title column-title column-primary page-title" data-colname="Title">	
						'.$app->name.' App
					</th>
					<td class="actions column-actions" data-colname="Actions">
						<div>
							<progress class="js-progress" max="100" value="0"></progress>
						</div>
						<div class="js-action-msg"></div>
						<select name="site_sync_url" class="js-site-sync-url">
							<option value="">Select URL</option>'.$options.'
						</select>
						<button class="btn ladda-button js-bulk-push-button" data-app_slug="'.$app->slug.'" data-post_type="aw2_app" data-style="zoom-out"><span class="ladda-label">Bulk Push</span></button>
						<button class="btn ladda-button js-bulk-pull-button" data-app_slug="'.$app->slug.'" data-post_type="aw2_app" data-style="zoom-out"><span class="ladda-label">Bulk Pull</span></button>
					</td>	
				</tr>';
			}
			
		echo '</tbody></table>';		
		echo '</div>';		
	}
	static function settings_panel(){
		
		echo '<style>.sync-key{ font-size: 18px; border: dashed 1px #f00; padding:10px; backgound-color:#fff}</style>';
		
		echo '<div class="settings cmb2-options-page ">';        	
		echo '<p>Your Sync Key: <span class="sync-key"><em>'.self::get_sync_key().'</em></span> </p> <hr />';
		cmb2_metabox_form( 'sync-settings-box', 'awesome-sync' );
		echo '</div>';		
		
	}
	static function initialize_bulk_sync(){
		$output=array();
		$output['status']="fail";
		//$output['message']=$_GET['site_url'];	
		if(empty($_GET['site_url'])||empty($_GET['post_type'])||empty($_GET['activity'])){
			$output['message']='Somethings Wrong.';
			echo json_encode($output);
			wp_die();
		}
		
		$data=array();
		$site_sync_settings = cmb2_get_option( 'awesome-sync','all');
		if(is_array($site_sync_settings) && !isset($site_sync_settings['awesome-sync-sites'])){
			$output['message']='Site settings not found or incorrect.';
			echo json_encode($output);
			wp_die();
		}
		
		foreach($site_sync_settings['awesome-sync-sites'] as $s){
			if($s['site_url'] == $_GET['site_url']){
				$site_sync_settings = $s; 
				break;
			}
		}
		
		$data['username']=$site_sync_settings['site_username'];
		$data['key']=$site_sync_settings['site_key'];
		$data['post_type']=$_GET['post_type'];
		$data['app_slug']=$_GET['app_slug'];
		
		//if it is push request
		// collect all the data in a packet and send the request.
		if($_GET['activity']=='push'){
			$return=self::collect_item_list($data);
			if($return === false){
				$output['message']=' posts not found for post type '.$data['post_type'];
				echo json_encode($output);
				wp_die();
			}
			
			$output['status']="pass";
			$output['items']=$return;
			echo json_encode($output);
			wp_die();
		
		}
		
		if($_GET['activity']=='pull'){
			$request_url = $site_sync_settings['site_url'].'/wp-admin/admin-ajax.php?action=awesome_remote_bulk_pull';
	
			$args = array(
				'timeout'     => 10,
				'redirection' => 5,
				'headers' => array(),
				'body' => array( 'data' => $data ),
				'cookies' => array()
			);
			$response = wp_remote_post($request_url,$args); 
			
			if(is_wp_error($response) || $response['response']['code'] != '200'){ 
				$output['message']=$response->get_error_message();	
				echo json_encode($output);
				wp_die();
			}
			
			$r = json_decode($response['body'],true);
			
			if($r['status'] == 'fail'){
				$output['message']=$r['message'];	
				echo json_encode($output);
				wp_die();
			}
			
			if($r['status'] == 'pass'){
				$output['status']="pass";
				$output['items']=$r['items'];
				echo json_encode($output);
				wp_die();
			}
		}
		
	}
	
	static function bulk_pull(){
		$output=array();
		$output['status']="fail";
		
		$data =$_POST['data'];
		if(!is_array($data) || !isset($data['username'])|| !isset($data['key'])){
			$output['message']='Invalid Data.';
			echo json_encode($output);
			wp_die();
		}
		
		//validate the user
		if(self::get_sync_key($data['username']) != $data['key'])	{
			$output['message']=' Authentication falied. ';
			echo json_encode($output);
			wp_die();
		}
		
		$return=self::collect_item_list($data);
		if($return === false){
			$output['message']='Not found ';
			echo json_encode($output);
			wp_die();
		}
		
		$output['status']="pass";
		$output['items']=$return;
		echo json_encode($output);
		wp_die();
	}
	static function collect_item_list($data){
		global $wpdb;
		
		if(empty($data['post_type']))
			return false;
		
		if(!empty($data['app_slug']) && $data['app_slug'] !=='null'){
			
			$app=new aw2_app();
			$status=$app->setup($data['app_slug']);
			
			if($status['status']=='fail')
				return false;
			
			$sql = "SELECT post_title, post_name, post_type FROM ".$wpdb->posts."  WHERE 1=1  AND post_type IN ('".aw2_library::get('app.default_pages' )."','".aw2_library::get('app.default_modules' )."','".aw2_library::get('app.default_triggers' )."') AND ((post_status <> 'trash' AND post_status <> 'auto-draft'))  ORDER BY post_date DESC";
			
		}
		else{
			$sql = "SELECT post_title, post_name, post_type FROM ".$wpdb->posts." WHERE 1=1  AND post_type='".$data['post_type']."'  AND ((post_status <> 'trash' AND post_status <> 'auto-draft'))  ORDER BY post_date DESC";
		}
		
		$results = $wpdb->get_results($sql,ARRAY_A);
		
		if(!empty($data['app_slug']) && $data['app_slug'] !=='null'){
			$sql = "SELECT post_title, post_name, post_type FROM ".$wpdb->posts." WHERE 1=1  AND post_type='aw2_app' AND post_name='".$data['app_slug']."'  AND ((post_status <> 'trash' AND post_status <> 'auto-draft'))  ORDER BY post_date DESC";
			
			$app_post=$wpdb->get_results($sql,ARRAY_A);
			array_unshift($results, $app_post[0]);
		}
		
		return $results;
		
	}
	
	static function initialize_sync(){
		$output=array();
		$output['status']="fail";
		//$output['message']=$_GET['site_url'];	
		if(empty($_GET['site_url'])||empty($_GET['post_slug'])||empty($_GET['post_type'])||empty($_GET['activity'])){
			$output['message']='Somethings Wrong.';
			echo json_encode($output);
			wp_die();
		}
		
		$data=array();
		$site_sync_settings = cmb2_get_option( 'awesome-sync','all');
		if(is_array($site_sync_settings) && !isset($site_sync_settings['awesome-sync-sites'])){
			$output['message']='Site settings not found or incorrect.';
			echo json_encode($output);
			wp_die();
		}
		
		foreach($site_sync_settings['awesome-sync-sites'] as $s){
			if($s['site_url'] == $_GET['site_url']){
				$site_sync_settings = $s; 
				break;
			}
		}
		
		$data['slug']=$_GET['post_slug'];
		$data['username']=$site_sync_settings['site_username'];
		$data['key']=$site_sync_settings['site_key'];
		$data['post_type']=$_GET['post_type'];
		$data['app_slug']=$_GET['app_slug'];
		//util::var_dump($data);
		//if it is push request
		// collect all the data in a packet and send the request.
		if($_GET['activity']=='push'){
			$return=self::collect_content($data);
			if($return === false){
				$output['message']=$data['slug'].' not found for post type '.$data['post_type'];
				echo json_encode($output);
				wp_die();
			}
					
			$data['post'] = $return;
			$request_url = $site_sync_settings['site_url'].'/wp-admin/admin-ajax.php?action=awesome_remote_push';
	
			$args = array(
			'timeout'     => 10,
			'redirection' => 5,
			'headers' => array(),
			'body' => array( 'data' => $data ),
			'cookies' => array()
			);
			$response = wp_remote_post($request_url,$args); 

			if(!is_wp_error($response) && $response['response']['code'] == '200'){ 
				$r=json_decode($response['body']);
				if($r->status=='fail')
					$output['message']=$r->message;
				else{
					$output['status']="pass";
					$output['message']="Pushed Sucessfully.";
				}
			}
			else {
				$output['message']=$response->get_error_message();	
			}
		}
		
		// if it is pull
		//send a request, on getting the packet call update function with the packet.
		if($_GET['activity']=='pull'){
			
			$request_url = $site_sync_settings['site_url'].'/wp-admin/admin-ajax.php?action=awesome_remote_pull';
	
			$args = array(
			'timeout'     => 10,
			'redirection' => 5,
			'headers' => array(),
			'body' => array( 'data' => $data ),
			'cookies' => array()
			);
			$response = wp_remote_post($request_url,$args); 
			
			if(is_wp_error($response) || $response['response']['code'] != '200'){ 
				$output['message']=$response->get_error_message();	
				echo json_encode($output);
				wp_die();
			}
			
			$r = json_decode($response['body'],true);
			
			if($r['status'] == 'fail'){
				$output['message']=$r->message;	
				echo json_encode($output);
				wp_die();
			}
			
			if($r['status'] == 'pass'){
				$result=self::update_content($r['data']);
				if($result){
					$output['status']="pass";
					$output['message']="Pull Sucessful.";
				}
				else{
					$output['message'] ='Failed to update.';
				}
			}
		}

		echo json_encode($output);
		wp_die();
	}
	//handles remote pull request
	static function pull(){
		$output=array();
		$output['status']="fail";
		
		$data =$_POST['data'];
		if(!is_array($data) || !isset($data['username'])|| !isset($data['key'])){
			$output['message']='Invalid Data.';
			echo json_encode($output);
			wp_die();
		}
		
		//validate the user
		if(self::get_sync_key($data['username']) != $data['key'])	{
			$output['message']=' Authentication falied. ';
			echo json_encode($output);
			wp_die();
		}
		
		$collected_content = self::collect_content($data);
		if($collected_content !== false){
			$output['status']="pass";
			$output['data']['post']=$collected_content;
		}
		else{
			$output['message']=$data['slug'].' does not exists';
		}	
		
		echo json_encode($output);
		wp_die();
	}
	
	static function collect_content($data){
		$return=aw2_library::get_post_from_slug($data['slug'],$data['post_type'],$post);
		if(!$return)
			return false;
		
		$taxonomies = get_object_taxonomies( $data['post_type'], 'names' );
		$terms = wp_get_object_terms($post->ID, $taxonomies);
		$meta = get_post_meta($post->ID);
		
		$output['post_title'] = $post->post_title;
		$output['post_name'] = $post->post_name;
		$output['post_type'] = $post->post_type;
		$output['post_content'] = $post->post_content;
		$output['post_status'] = $post->post_status;
		
		
		$output['meta']=$meta;
		$output['tax'] = array();
		
		foreach($terms as $term){
			$output['tax'][$term->taxonomy][] = $term;	
		}
		
		 /*
		util::var_dump($output);
		util::var_dump($data);
		util::var_dump($taxonomies);
		util::var_dump($terms);
		 */
		
		return $output;
	}
	
	//handles remote push request
	static function push(){
		$output=array();
		$output['status']="fail";
		
		$data =$_POST['data'];
		if(!is_array($data) || !isset($data['username'])|| !isset($data['key'])){
			$output['message']='Invalid Data.';
			echo json_encode($output);
			wp_die();
		}
		
		//validate the user
		if(self::get_sync_key($data['username']) != $data['key'])	{
			$output['message']=' Authentication falied. ';
			echo json_encode($output);
			wp_die();
		}
		
		if(self::update_content($data)){
			$output['status']="pass";
			$output['message']='';
		}
		else{
			$output['message']='Update failed.';
		}
		echo json_encode($output);
		wp_die();
	}
	
	static function update_content($data){

		if(!empty($data['app_slug']) && $data['app_slug'] !=='null'  && $data['post']['post_type'] !=='aw2_app'){
			
			$app=new aw2_app();
			$status=$app->setup($data['app_slug']);
			
			if($status['status']=='fail')
				return false;
			
			if(strpos($data['post']['post_type'],'module')){
				$data['post']['post_type'] = aw2_library::get('app.default_modules'); 
			}
			elseif(strpos($data['post']['post_type'],'trigger')){
				$data['post']['post_type'] = aw2_library::get('app.default_triggers');
			}
			elseif(strpos($data['post']['post_type'],'page')){
				$data['post']['post_type'] = aw2_library::get('app.default_pages' );
			}

		}
		$return=aw2_library::get_post_from_slug($data['post']['post_name'],$data['post']['post_type'],$post);
		
		if(!isset($data['post']['post_excerpt']))
			$data['post']['post_excerpt']='';
		
		
		
		$new_item = array(
			'post_title' => $data['post']['post_title'],
			'post_name' => $data['post']['post_name'],
			'post_content'  => $data['post']['post_content'],
			'post_excerpt'  => $data['post']['post_excerpt'],
			'post_status'   =>  $data['post']['post_status'],
			'post_type'   => $data['post']['post_type']
		);

		$user = get_user_by('login',$data['username']);
		if($user){
		  $new_item['post_author']= $user->ID;
		}		
		
		if(!empty($data['post']['meta'])){
			foreach($data['post']['meta'] as $meta_key=>$meta_value){
				$new_item['meta_input'][$meta_key]=$meta_value[0];
			}
		}
		
		if($return ){
			$new_item['ID']=$post->ID;
		}
		kses_remove_filters();
		$post_id=wp_insert_post($new_item,true);     
		
			// Insert the post into the database
		
		if(is_wp_error($post_id)){
			echo $post_id->get_error_message();
			return false;
		}		
			
		if(!empty($data['post']['tax'])){
			foreach($data['post']['tax'] as $tax_key=>$tax_value){
				foreach($tax_value as $tax){
					wp_set_object_terms( $post_id, $tax['slug'], $tax_key );
				}	
			}	
		}
		
		//this currently does not work.. need to figure out
		if(isset($new_item['meta_input']['_module_thumb'])){
			$featured_image_id=aw2_library::sideload_file($new_item['meta_input']['_module_thumb'],$post_id);
			set_post_thumbnail($post_id, $featured_image_id);
		}
			
		kses_init_filters();
		
		return true;
	}
		
	static function get_sync_key($username=null){
		$sync_key=get_option('awesome-sync-keys');
		if($sync_key)
			$sync_key=json_decode($sync_key);
		
		if(is_null($username)){
			$current_user = wp_get_current_user();
			$username= $current_user->user_login;
		}
		
		//if sync key does not exists create and return
		if(!isset($sync_key->$username))
			$sync_key = self::set_sync_key();
		
		return $sync_key->$username;
	}
	
	static function set_sync_key(){
		
		$sync_key=get_option('awesome-sync-keys');
		
		if($sync_key)
			$sync_key=json_decode($sync_key);
		
		$current_user = wp_get_current_user();
		$username=$current_user->user_login;
		
		$key= $username.''.time().''.site_url().''.AUTH_KEY;
		
		$sync_key->$username=md5($key);
		update_option( 'awesome-sync-keys', json_encode($sync_key), false);
		return $sync_key;
	}
	
	static function add_settings_metabox(){
		add_action( "cmb2_save_options-page_fields_sync-settings-box",  'awesome_sync::settings_notices' , 10, 2 );
		$cmb = new_cmb2_box( array(
			'id'         => 'sync-settings-box',
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( 'awesome-sync', )
			),
		) );
		
		$group_field_id = $cmb->add_field( array(
			'id'          => 'awesome-sync-sites',
			'type'        => 'group',
			'description' => __( 'Add Sites to Sync with.', 'cmb2' ),
			
			'options'     => array(
				'group_title'   => __( 'Site {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Link Another Site', 'cmb2' ),
				'remove_button' => __( 'Remove Site', 'cmb2' )
			),
		) );
		
		// Set our CMB2 fields
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Site URL',
			'id'   => 'site_url',
			'type' => 'text_url',
			'desc' => 'URL of the website to sync with',
			 //'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );
		
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Username',
			'id'   => 'site_username',
			'type' => 'text',
			'desc' => 'Username of person whose key will be used below',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );
		
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Sync Key',
			'id'   => 'site_key',
			'type' => 'text',
			'desc' => 'Sync key of the user for the site, you want to sync with.',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}
	
	static function settings_notices( $object_id, $updated ) {
		if ( $object_id !== 'awesome-sync' || empty( $updated ) ) {
			return;
		}
		add_settings_error( 'awesome-sync-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( 'awesome-sync-notices' );
	}
	static function show_mod_row($posts,$post_type,$title,$site_sync_settings,$app_slug=''){
		//util::var_dump($site_sync_settings);
		$options='';
		if(is_array($site_sync_settings) && isset($site_sync_settings['awesome-sync-sites'])){
			foreach($site_sync_settings['awesome-sync-sites'] as $s){
			 $options .='<option value="'.$s['site_url'].'">'.$s['site_url'].'</option>';	
			}
		}
		
		
		$str ='<tr><th colspan="4"><strong>'.$title.'<strong></th></tr>';
		$count=0;
		foreach($posts as $post){
			if($post->post_type !==$post_type)
				continue;
			
			$count=$count+1;
			
			$user_info = get_userdata($post->post_author);
			$str .='
			<tr id="" class="">
				<th scope="row" class="title column-title column-primary page-title" data-colname="Title">	
					<a href="'.admin_url('post.php?post='.$post->ID.'&action=edit').'" class="row-title" target="_blank">'.$post->post_title.'</a>
				</th>
				<td class="" >'.human_time_diff( strtotime($post->post_modified), current_time('timestamp') ) . ' ago'.'</td>
				<td class="" data-colname="Module Type">'.$user_info->display_name.'</td>
				<td class="actions column-actions" data-colname="Actions">
				    <div class="js-action-msg"></div>
					<select name="site_sync_url" class="js-site-sync-url">
						<option value="">Select URL</option>'.$options.'
					</select>
					<button class="btn ladda-button js-push-button" data-slug="'.$post->post_title.'" data-post_type="'.$post_type.'" data-app="'.$app_slug.'" data-style="zoom-out"><span class="ladda-label">Push</span></button>
					<button class="btn ladda-button js-pull-button" data-slug="'.$post->post_title.'" data-post_type="'.$post_type.'" data-app="'.$app_slug.'" data-style="zoom-out"><span class="ladda-label">Pull</span></button>
				</td>	
			</tr>
			';
		}
		if($count)
			echo $str;
		
	}

}