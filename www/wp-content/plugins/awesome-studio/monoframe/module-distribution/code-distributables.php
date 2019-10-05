<?php

add_action( 'admin_menu', 'awesome_distribution::awesome_studio_pages' );
add_action('wp_ajax_aw2_user_check', 'awesome_distribution::register_account');
add_action('wp_ajax_aw2_get_types', 'awesome_distribution::get_object_type');
add_action('wp_ajax_aw2_distribution_list', 'awesome_distribution::get_items');
add_action('wp_ajax_aw2_install_obj', 'awesome_distribution::install');
add_action('wp_ajax_aw2_clean_up', 'awesome_distribution::clean_up');
add_action('admin_enqueue_scripts', 'awesome_distribution::load_scripts');

class awesome_distribution {
	static $server_url = "http://apps.getawesomestudio.com/wp-admin/admin-ajax.php";
	
	//catalog call back to show list of items -- this is the MAIN function
	static function awesome_catalogue(){
			
		//check if user has api key.
		$key=get_option('awesome-studio-api-key');
		echo "
		<style>
		 ul.master-nav {
			display: table;
			float: none;
			list-style: outside none none;
			margin: 0 auto 40px;
			padding: 0;
			width: auto;
		}
		ul.master-nav > li {
			float: left;
			margin: 0 2px;
		}
		
		ul.master-nav li a {
			color: #666;
			font-size: 12px;
			line-height: 26px;
			text-decoration: none;
		}
		
		ul.master-nav li a.selected {
			color: rgba(0, 0, 0, 0);
			position: relative;
			z-index: 9;
			-webkit-transition: all 0.4s ease 0s;
			-moz-transition: all 0.4s ease 0s;
			-ms-transition: all 0.4s ease 0s;
			-o-transition: all 0.4s ease 0s;
			transition: all 0.4s ease 0s;
		}
		
		ul.master-nav > li > a.selected  > span{
			border-color: #ff7c00;
			background-color: #ff7c00;
		}
		ul.master-nav > li > a.selected > span {
			color: #fff;
		}
		ul.master-nav > li > a span {
			border: 1px solid #d3d3d3;
			color: #3e3e3e;
			float: left;
			font-family: arimo;
			font-size: 12px;
			letter-spacing: 0.3px;
			margin: 0 1px;
			padding: 8px 35px;
			position: relative;
			text-transform: uppercase;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			-ms-border-radius: 3px;
			-o-border-radius: 3px;
			border-radius: 3px;
			-webkit-transition: all 0.4s ease 0s;
			-moz-transition: all 0.4s ease 0s;
			-ms-transition: all 0.4s ease 0s;
			-o-transition: all 0.4s ease 0s;
			transition: all 0.4s ease 0s;
		}
		h1.title{
			text-align:center;
			font-size:30px;
		}
		</style>
		
		
		";
		
		$active_object = $_GET['active_object'];
		$active_object_type = $_GET['active_object_type'];
		
		echo '<div class="wrap">';
		echo '<h1 class="title">Awesome Studio Catalogue</h1>';
		echo '<ul id="master-nav" class="master-nav">
                <li><a href="'.admin_url( 'admin.php?page=awesome-studio&active_object=apps').'" data-value="apps" class="'.self::selected_object($active_object, 'apps','apps').'"><span>APPS</span></a></li>
                <li><a href="'.admin_url( 'admin.php?page=awesome-studio&active_object=modules').'" data-value="modules" class="'.self::selected_object($active_object, 'modules').'"><span>MODULES</span></a></li>
                <li><a href="'.admin_url( 'admin.php?page=awesome-studio&active_object=triggers').'" data-value="triggers" class="'.self::selected_object($active_object, 'triggers').'"><span>TRIGGER</span></a></li>
                <li><a href="'.admin_url( 'admin.php?page=awesome-studio&active_object=shortcodes').'" data-value="shortcodes" class="'.self::selected_object($active_object, 'shortcodes').'"><span>SHORTCODES</span></a></li>                                
            </ul>';
			if(empty($key)){
				self::show_registration_box();
			}
			else{
				self::show_installable_item_list($key);
			}			

		
	}
	
	static function get_object_type(){

		delete_transient( 'awesome_studio_types' );
		$types = get_transient( 'awesome_studio_types' );
		$output = array();
		$output['error']=false;

		if((is_null($types))||($types  === false)) {
			//get the parts from awesomestudio
			
			$request_url = self::$server_url.'?action=awesome_server_get_types&object_type='.$_GET['object_type'];
			$response = wp_remote_get( $request_url); 
			
			//echo $request_url;
			if(!is_wp_error($response)) { 
				$r_decoded=json_decode($response['body'],true);
			
				$types=$r_decoded['types'];
				set_transient( 'awesome_studio_types', $types, 14400 );
			}
			else {
				$output['error']=true;
				$output['message']=$response->get_error_message().'<p> Could not get the list please try again.</p>';
			}		
		}
		$output['results']=$types;
		
		echo json_encode($output);
		wp_die();
	}
	
	static function get_items(){
		$post_type = array(
			"modules" =>"aw2_module",
			"triggers" =>"aw2_trigger",
			"shortcodes" =>"aw2_shortcode"
		);
		$tax_type = array();
		
		$active_object = $_GET['active_object'];
		$active_object_type = $_GET['active_object_type'];
		$output = array();
		$modules_array = array();
		if($active_object != 'apps'){
			$args = array(
				'posts_per_page'   => -1,
				'post_type'        => $post_type[$active_object],
				'post_status'      => 'publish'
			);
			
			$modules_array = get_posts( $args );
		}
		
		$request_url = self::$server_url.'?action=awesome_server_get_post_list&object='.$active_object.'&page='.$_GET['pagenum'].'&module_type='.$active_object_type;

		$response = wp_remote_get( $request_url); 
		if(!is_wp_error($response)) { 
			$r_decoded=json_decode($response['body'],true);
			$output['error']=false;
			foreach($modules_array as $module){
				$key = array_search($module->post_name, array_column($r_decoded['modules'], 'slug'));
				if($key === false){
					continue;
				}else{
					$r_decoded['modules'][$key]['installed'] = 'yes';
				}
			}
			$parts=$r_decoded['modules'];

			//set_transient( 'awesome_studio_parts', $parts, 14400 );
			$output['total']=$r_decoded['total'];
			$output['page_num']=$r_decoded['page_num'];
		}
		else {
			$output['error']=true;
			$output['message']=$response->get_error_message().'<p> Could not get the list please try again.</p>';
		}		

		$output['results']=$parts;
		
		echo json_encode($output);
		wp_die();
	}
	
	//regsiter account and save 32 digit api key
	static function register_account(){
	
		$request_url = self::$server_url.'?action=aw2_register_subscriber';
	
		$args = array(
		'timeout'     => 10,
		'redirection' => 5,
		'headers' => array(),
		'body' => array( 'name' => $_POST['name'], 'email' => sanitize_email($_POST['email']),'url' => site_url() ),
		'cookies' => array()
		);
		$response = wp_remote_post($request_url,$args); 
		$data = array();
		if(!is_wp_error($response)){ 
			$data['status']="pass";
			update_option('awesome-studio-api-key',$response['body'],false);
		}
		else {
			$data['status']="fail";
			$data['msg']=$response->get_error_message();	
		}
		echo json_encode($data);
		wp_die();
	}
	
	
	//check if not exists & install 
	static function install(){
	    $output=array();
		$output['success']=false;
		$output['msg']='';
		
		if(empty($_GET['active_object']) || empty($_REQUEST['slug'])){
		  $output['msg'] = '<p>Object type not specified.</p>';
		  echo json_encode($output);
		  wp_die();
		}
		
		if( $_GET['active_object']=='apps' && (empty($_GET['app_name']) || empty($_GET['app_slug'])) ){
		  $output['msg'] = '<p><em>name</em> and <em>slug</em> is required for installing App.</p>';
		  echo json_encode($output);
		  wp_die();
		}
		
		
		
		if(isset($_REQUEST['reinstall']) && $_REQUEST['reinstall'] == "yes"){
			$reinstall = 'yes';
		}
		$upgrade = 'no';
		if(isset($_REQUEST['upgrade']) && $_REQUEST['upgrade'] == "yes"){
			$upgrade = 'yes';
		}

		self::start_installation($_REQUEST['slug'],$_GET['active_object'],$upgrade);
		
		$output['success']=true;
		$output['msg'] = $_REQUEST['slug'].' installed.';
		$output['nonce' ] = wp_create_nonce( 'aw2_install_obj_nonce' );
		
		echo json_encode($output);
		wp_die();
	}
	
	//support functions
	static function start_installation($slug,$active_object,$upgrade='no'){
		
		$request_url = self::$server_url.'?action=awesome_server_install&slug='.$slug.'&object='.$active_object;
	 
		$args = array(
			'timeout'     => 10,
			'redirection' => 5
			);
		$response = wp_remote_get($request_url,$args); 
		if(is_wp_error($response)){ 
			$output['success']=false;
			$output['msg']=$output['msg'].'<p>Error : Could not communicate with server.'. $response->get_error_message() .'</p>';
			echo json_encode($output);
			wp_die();
		}
		
		$response =json_decode($response['body'],true);
		if($response['success'] === false){ 
			$output['success']=false;
			$output['msg']=$output['msg'].'<p>Error : '.$response->msg .'</p>';
			echo json_encode($output);
			wp_die();
		}
		
		//now start creating the posts

		$item_id = self::setup_item($response['data'],$upgrade);
		
		if(is_wp_error($item_id)){
			$output['success']=false;
			$output['msg']=$output['msg'].'<p>Error: '.$item_id->get_error_message() .'</p>';
			echo json_encode($output);
			wp_die();
		}
		$output['msg']=$output['msg'].'';
		if($active_object == 'apps')
			self::setup_app_items($item_id,$response['data'],$upgrade);
		
		
		
		if($upgrade == 'no'){
			foreach($response['data']['dependencies'] as $key=>$dependent_item){
				$obj=$key;
				foreach($dependent_item as $item){
					self::start_installation($item,$obj);
				}
			}
		}
		
		return ;
	}
	static function setup_item(&$data,$upgrade="no"){
		//util::var_dump($data);
		$return=aw2_library::get_post_from_slug($data['post']['post_name'],$data['post']['post_type'],$post);
		
		if(!isset($data['post']['post_excerpt']))
			$data['post']['post_excerpt']='';
		
		$new_item = array(
			'post_title' => $data['post']['post_title'],
			'post_name' => $data['post']['post_name'],
			'post_content'  => $data['post']['post_content'],
			'post_excerpt'  => $data['post']['post_excerpt'],
			'post_status'   =>  'publish',
			'post_type'   => $data['post']['post_type']
		);
		
		if($return && $upgrade == "no"){
			return $post->ID;
		}	
		
		if($return && $upgrade == "yes"){
			$new_item['ID']=$post->ID;
		}
		
		unset($data['post']);
		
		if(!empty($data['meta'])){
			foreach($data['meta'] as $meta_key=>$meta_value){
				$new_item['meta_input'][$meta_key]=$meta_value;
			}
			unset($data['meta']);
		}

		$post_id=wp_insert_post($new_item,true);     
		
			// Insert the post into the database
		if(!is_wp_error($post_id)){				
			
			if(!empty($data['tax'])){
				foreach($data['tax'] as $tax_key=>$tax_value){
					foreach($tax_value as $tax){
						wp_set_object_terms( $post_id, $tax['slug'], $tax_key );
					}	
				}	
				unset($data['tax']);
			}
			
			$featured_image_id=aw2_library::sideload_file($new_item['meta_input']['_module_thumb'],$post_id);
			set_post_thumbnail($post_id, $featured_image_id);
		}
		return $post_id;	
	}
	
	static function setup_app_items($item_id,$data,$upgrade="no"){
		
		
		$update_args = array(
					'ID' => $item_id,
					'post_title' => $_GET['app_name'],
					'post_name' => $_GET['app_slug'],
				);
		
		$result =  wp_update_post($update_args);
		
		//fix meta data of app
		update_post_meta($item_id,'default_pages',$item_id.'_page');
		update_post_meta($item_id,'default_modules',$item_id.'_module');
		update_post_meta($item_id,'default_triggers',$item_id.'_trigger');
		
		//update post_title and slug
		
		//set up pages, modules and triggers.
		
		
		foreach($data['module'] as $page_item){
			$page_item['post']['post_type']=$item_id.'_module';
			self::setup_item($page_item,$upgrade);
		}
		
		foreach($data['trigger'] as $page_item){
			$page_item['post']['post_type']=$item_id.'_trigger';
			self::setup_item($page_item,$upgrade);
		}
		
		foreach($data['page'] as $page_item){
			$page_item['post']['post_type']=$item_id.'_page';
			self::setup_item($page_item,$upgrade);
		}
	}
	
	static function show_registration_box(){
		echo '
		<link href="'.plugins_url('module-distribution/css/login.css',dirname(__FILE__)).'" rel="stylesheet">
		<form id="login-form">
		  <div class="group">
			<input type="text" name="name" required><span class="aw-highlight"></span><span class="bar"></span>
			<label>Name</label>
		  </div>
		  <div class="group">
			<input type="email" name="email" required><span class="aw-highlight"></span><span class="bar"></span>
			<label>Email</label>
		  </div>
		  <div class="js-error"></div>
		  <button type="submit" class="aw-button buttonBlue js-button" data-style="slide-right"><span class="ladda-label">Activate</span></button>
		</form>
		
		';
?>
		<script>
			( function($) {
			$(window, document, undefined).ready(function() {

			  $('input').blur(function() {
				var $this = $(this);
				if ($this.val())
				  $this.addClass('used');
				else
				  $this.removeClass('used');
			  });

			  var $ripples = $('.ripples');

			  $ripples.on('click.Ripples', function(e) {

				var $this = $(this);
				var $offset = $this.parent().offset();
				var $circle = $this.find('.ripplesCircle');

				var x = e.pageX - $offset.left;
				var y = e.pageY - $offset.top;

				$circle.css({
				  top: y + 'px',
				  left: x + 'px'
				});

				$this.addClass('is-active');

			  });

			  $ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function(e) {
				$(this).removeClass('is-active');
			  });
			 
			 activate_btn  =Ladda.create( document.querySelector( '.js-button' ) );
			 jQuery('#login-form').submit(function( event ) {
				 activate_btn.start();
					  var datastring = $("#login-form").serializeArray(); 			  
					  jQuery.post( "<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=aw2_user_check&ajax=true",datastring, function( response ) {
						 var data = jQuery.parseJSON(response);
						 if(data.status=="pass"){
							activate_btn.stop();
							window.location.reload();
						 }
						 else{
							$('.js-error').html(data.msg);
						 }
					  });
					  
				 return false;
				});
			});
		} ) ( jQuery );
		</script>
<?php
	}
	static function clean_up(){
		
		if( check_ajax_referer('aw2_install_obj_nonce', 'nonce' ) ) {
			flush_rewrite_rules(); 
            die( '1' ); // Success!
        }
		
	}
	static function show_installable_item_list($key){
		echo '<div class="theme-browser rendered">
				<div class="themes container-fluid">
					<div class="aw2_navbar row no-margin">
						<div class="menu js-menu col-xs-12 no-padding priority-nav"></div>
					</div>
					<div class="js-modules row"></div>
					<div class="row">
						<div class="col-md-4 col-xs-12 col-md-offset-4 text-center">
							<button class="btn btn-third btn-lg ladda-button js-load-more load-more" type="button" data-style="slide-down" data-size="l"><span class="ladda-label">Load More</span></button>
						</div>
					</div>
				</div>
			 </div>
			 <div class="theme-overlay"></div> 
		</div>';  
		echo '<section id="aw2-loader" class="">
				<div class="st-loader"><span class="equal"></span></div>
			  </section>';	
	}
	
	static function load_scripts($hook) {
		if($hook!='toplevel_page_awesome-studio')
			return;
	
		self::enqueue_style_scripts();
	}
	
	static function enqueue_style_scripts(){
		wp_enqueue_script( 'bootstrap', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js', array(), '4.0.0' );
		wp_enqueue_script( 'bootbox', '//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js', array(), '4.4.0' );
		wp_enqueue_script( 'pnotify', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.min.js', array(), '3.0.0' );
		wp_enqueue_script( 'pnotify-animate', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.animate.min.js', array(), '3.0.0' );
		wp_enqueue_script( 'pnotify-buttons', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.buttons.min.js', array(), '3.0.0' );
		wp_enqueue_script( 'jquery-age', '//cdnjs.cloudflare.com/ajax/libs/jquery.age/1.2.4/jquery.age.min.js', array(), '1.2.4' );
		wp_enqueue_script( 'imageloaded', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/3.1.8/imagesloaded.pkgd.js', array(), '3.1.8' );
		wp_enqueue_script( 'match-height', '//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.6.0/jquery.matchHeight-min.js', array(), '1.2.4' );
		wp_enqueue_script( 'ladda-spin', '//cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/spin.min.js', array(), '1.2.4' );
		wp_enqueue_script( 'ladda', '//cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.js', array(), '1.2.4' );
		wp_enqueue_script( 'priority-nav', '//cdn.getawesomestudio.com/lib/priority-nav/priority-nav.min.js', array(), '3.1.1' );
		//wp_enqueue_script( 'aw2_distri', plugins_url('module-distribution/js/aw2_distributables.js',dirname(__FILE__)), array(), '3.1.1' );
		wp_enqueue_script( 'aw2catalogue', plugins_url('module-distribution/js/awesome-catalogue.js',dirname(__FILE__)), array(), '3.1.1' );
		wp_enqueue_script( 'flippant', plugins_url('module-distribution/js/flippant.min.js',dirname(__FILE__)), array(), '3.1.1' );
		wp_enqueue_script( 'flip', plugins_url('module-distribution/js/flip.js',dirname(__FILE__)), array(), '3.1.1' );
		
		wp_enqueue_style( 'ladda-css', '//cdnjs.cloudflare.com/ajax/libs/ladda-bootstrap/0.9.4/ladda.min.css', array(), '3.1.1' );
		wp_enqueue_style( 'pnotify-css', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.css', array(), '3.0.0' );
		wp_enqueue_style( 'pnotify-brighttheme-css', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.brighttheme.min.css', array(), '3.0.0' );
		wp_enqueue_style( 'pnotify-buttons-css', '//cdnjs.cloudflare.com/ajax/libs/pnotify/3.0.0/pnotify.buttons.min.css', array(), '3.0.0' );
		//wp_enqueue_style( 'priority-nav-css', plugins_url('lib/priority-nav/priority-nav-core.css',dirname(__FILE__)), array(), '3.1.1' );
		wp_enqueue_style( 'studio-css', plugins_url('module-distribution/css/studio-admin.css',dirname(__FILE__)), array(), '3.1.1' );
		wp_enqueue_style( 'flippant-css', plugins_url('module-distribution/css/flippant.css',dirname(__FILE__)), array(), '3.1.1' );
	}
	
	static function awesome_studio_pages(){
	
		$awicon="PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE3LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHdpZHRoPSIyMHB4IiBoZWlnaHQ9IjEwcHgiIHZpZXdCb3g9IjAgMCAyMCAxMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjAgMTAiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxnPg0KCQkJPHBhdGggZmlsbD0iI0YwNTkyQiIgZD0iTTcuNTQ4LDcuOTA0Yy0wLjY2NywwLTEuMTEyLTAuMjMzLTEuMzI5LTAuNjk3QzUuODQxLDcuNjc4LDUuMzU2LDcuOTE1LDQuNzYzLDcuOTE1DQoJCQkJYy0wLjU5MiwwLTEuMDktMC4yMDEtMS40OTMtMC42Yy0wLjQwNC0wLjQtMC42MDUtMC45MjYtMC42MDUtMS41OGMwLTAuOTUxLDAuMjc5LTEuNzEyLDAuODQtMi4yNzgNCgkJCQljMC41NTktMC41NjcsMS4yNjctMC44NSwyLjEyNS0wLjg1YzAuMDIyLDAsMC4wNDQsMCwwLjA2NSwwYzAuMzY0LDAsMC42OTgsMC4wNjIsMS4wMDMsMC4xODUNCgkJCQljMC4xOTUtMC4xMjMsMC40MzQtMC4xODUsMC43MTUtMC4xODVjMC4yNzksMCwwLjQ4LDAuMDM2LDAuNjA0LDAuMTA5QzcuOTUxLDMuMjUzLDcuODgxLDMuNzgyLDcuODEsNC4zMDINCgkJCQlDNy43MzcsNC44MjEsNy42ODYsNS4xOSw3LjY1Nyw1LjQwN2MtMC4wNjYsMC40OTQtMC4wOTksMC44NS0wLjA5OSwxLjA2OGMwLDAuMjkxLDAuMTE2LDAuNDM3LDAuMzUsMC40MzcNCgkJCQljMC4xODEsMCwwLjM3NC0wLjEyMywwLjU3OC0wLjM2NmMwLjIwMi0wLjI0NCwwLjM4LTAuNjI2LDAuNTMzLTEuMTVjMC4yMTIsMC4xODksMC4zNTYsMC40LDAuNDM2LDAuNjMyDQoJCQkJYy0wLjIxLDAuNjkxLTAuNDk0LDEuMTc1LTAuODUsMS40NTVDOC4yNDksNy43NjQsNy44OTYsNy45MDQsNy41NDgsNy45MDR6IE01Ljc5MywzLjQ1NmMtMC40NjUsMC0wLjgzMywwLjE3Ny0xLjEwNiwwLjUyOQ0KCQkJCUM0LjQxNSw0LjMzOCw0LjI1Myw0Ljg2Myw0LjIwMiw1LjU2QzQuMTk1LDUuNjI1LDQuMTkxLDUuNjg3LDQuMTkxLDUuNzQ2YzAsMC4zNTYsMC4wODUsMC42MzksMC4yNTcsMC44NDkNCgkJCQljMC4xNywwLjIxMSwwLjM5LDAuMzE4LDAuNjU4LDAuMzE4YzAuNDU4LDAsMC44MDMtMC4zMjUsMS4wMzUtMC45NzFsMC4yNjMtMi4zNTVDNi4xOTMsMy41LDUuOTg5LDMuNDU2LDUuNzkzLDMuNDU2eiIvPg0KCQkJPHBhdGggZmlsbD0iI0YwNTkyQiIgZD0iTTEzLjA3NCw2LjExNmMwLDAuNTIzLDAuMjIxLDAuNzg0LDAuNjY0LDAuNzg0YzAuMDE1LDAsMC4wMjcsMCwwLjAzMywwYzAuMjAzLDAsMC4zODUtMC4xMDksMC41NDUtMC4zMjYNCgkJCQljMC4xNi0wLjIxOSwwLjI4LTAuNDkyLDAuMzYtMC44MThjMC4xNzUtMC42NjgsMC4yNjItMS4yNzYsMC4yNjItMS44MkgxNC44NGMtMC4zMDYsMC0wLjU0MS0wLjA3LTAuNzA5LTAuMjA3DQoJCQkJYy0wLjE3NS0wLjE1OS0wLjI2Mi0wLjM1My0wLjI2Mi0wLjU3OGMwLTAuMjI2LDAuMDY5LTAuNDA4LDAuMjA3LTAuNTQ1YzAuMTY4LTAuMTUyLDAuMzc1LTAuMjI5LDAuNjIxLTAuMjI5DQoJCQkJYzAuNTM4LDAsMC45MDIsMC4yNzYsMS4wOTEsMC44MjdjMC41MDgtMC4xMjMsMS4wNDYtMC4yOTMsMS42MTMtMC41MTJ2MC42MjJjLTAuNTM4LDAuMjAzLTEuMDQsMC4zNi0xLjUwNCwwLjQ2OQ0KCQkJCWMwLjAwOCwwLjA1OSwwLjAxMSwwLjE0MiwwLjAxMSwwLjI1MWMtMC4wMjksMS41MDMtMC4zODIsMi41OTMtMS4wNTcsMy4yN2MtMC4zOTksMC40LTAuOTE4LDAuNTk5LTEuNTUzLDAuNTk5DQoJCQkJYy0wLjYzNiwwLTEuMTEtMC4yNjgtMS40MjMtMC44MDZjLTAuMzU2LDAuNTQ1LTAuOTAxLDAuODE3LTEuNjM0LDAuODE3Yy0wLjQzNywwLTAuNzk0LTAuMTU1LTEuMDc0LTAuNDYzDQoJCQkJYy0wLjI4LTAuMzA5LTAuNDItMC42NzQtMC40Mi0xLjA5NmMwLTAuMDcyLDAuMDA0LTAuMTYsMC4wMTItMC4yNjFDOC45MSw0LjgzLDkuMDM4LDMuNzExLDkuMTM5LDIuNzM3DQoJCQkJQzkuNDAxLDIuNjUsOS42MywyLjYwNyw5LjgyNiwyLjYwN2MwLjUxNiwwLDAuNzc0LDAuMTc4LDAuNzc0LDAuNTM0YzAsMC4xMzgtMC4wNTQsMC42MTUtMC4xNjQsMS40MjcNCgkJCQljLTAuMTM4LDEuMDI0LTAuMjA4LDEuNjAxLTAuMjA4LDEuNzI4YzAsMC4xMjcsMC4wNDksMC4yNTMsMC4xNDgsMC4zNzZjMC4wOTgsMC4xMjMsMC4yNDEsMC4xODYsMC40MjUsMC4xODYNCgkJCQljMC4xODYsMCwwLjM1MS0wLjA4NSwwLjQ5Ni0wLjI1MWMwLjE0NC0wLjE2NywwLjI1MS0wLjM3MSwwLjMxNi0wLjYxbDAuMzgyLTMuMjU5YzAuMjMyLTAuMDg3LDAuNDc5LTAuMTMxLDAuNzQxLTAuMTMxDQoJCQkJYzAuNDcyLDAsMC43MDksMC4xNzgsMC43MDksMC41MzRjMCwwLjEzMi0wLjA1MiwwLjU1Ny0wLjE1MywxLjI3NUMxMy4xNDYsNS40MzMsMTMuMDc0LDYsMTMuMDc0LDYuMTE2eiBNMTQuNDkxLDMuMTUyDQoJCQkJYzAsMC4xMjMsMC4xMDUsMC4xODUsMC4zMTcsMC4xODVjMC4wMiwwLDAuMDQzLDAsMC4wNjUsMGMtMC4wNTEtMC4xOTctMC4xMjgtMC4yOTUtMC4yMjktMC4yOTUNCgkJCQlDMTQuNTQyLDMuMDQyLDE0LjQ5MSwzLjA3OSwxNC40OTEsMy4xNTJ6Ii8+DQoJCTwvZz4NCgkJPGc+DQoJCQk8Zz4NCgkJCQk8cmVjdCB4PSIwIiBmaWxsPSIjRjA1OTJCIiB3aWR0aD0iMS4xMTEiIGhlaWdodD0iMTAiLz4NCgkJCQk8cmVjdCB4PSIwIiB5PSIwIiBmaWxsPSIjRjA1OTJCIiB3aWR0aD0iMy4zMzQiIGhlaWdodD0iMS4xMTEiLz4NCgkJCQk8cmVjdCB4PSIwIiB5PSI4Ljg4OSIgZmlsbD0iI0YwNTkyQiIgd2lkdGg9IjMuMzM0IiBoZWlnaHQ9IjEuMTExIi8+DQoJCQk8L2c+DQoJCQk8Zz4NCgkJCQk8cmVjdCB4PSIxOC44ODkiIGZpbGw9IiNGMDU5MkIiIHdpZHRoPSIxLjExMSIgaGVpZ2h0PSIxMCIvPg0KCQkJCTxyZWN0IHg9IjE2LjY2NiIgeT0iMCIgZmlsbD0iI0YwNTkyQiIgd2lkdGg9IjMuMzM0IiBoZWlnaHQ9IjEuMTExIi8+DQoJCQkJPHJlY3QgeD0iMTYuNjY2IiB5PSI4Ljg4OSIgZmlsbD0iI0YwNTkyQiIgd2lkdGg9IjMuMzM0IiBoZWlnaHQ9IjEuMTExIi8+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4=";
		
		add_menu_page( 'UI Catalogue - Awesome Studio', 'Awesome Studio', 'manage_options', 'awesome-studio', 'awesome_distribution::awesome_catalogue',  'data:image/svg+xml;base64,'.$awicon,3 ); 
	    add_submenu_page('awesome-studio', 'Awesome Studio Catalogue - Awesome Studio', 'Catalogue', 'manage_options', 'awesome-studio' );
		add_submenu_page( 'awesome-studio', 'Global Modules - Awesome Studio', 'Global Modules', 'develop_for_awesomeui', 'edit.php?post_type=aw2_module' );
		add_submenu_page( 'awesome-studio', 'Global Triggers - Awesome Studio', 'Global Triggers', 'develop_for_awesomeui', 'edit.php?post_type=aw2_trigger' );
		add_submenu_page( 'awesome-studio', 'Shortcodes - Awesome Studio', 'Shortcodes', 'develop_for_awesomeui', 'edit.php?post_type=aw2_shortcode' );
		add_submenu_page( '', 'Get Module Shortcode - Awesome Studio', 'Get Module Shortcode', 'manage_options', 'awesome-get-shortcode', 'aw2_module_get_shortcode' );
		add_submenu_page( '', 'Set Module Trigger - Awesome Studio', 'Set Module Trigger', 'manage_options', 'awesome-set-trigger', 'aw2_module_set_trigger' );
		add_submenu_page( '', 'Install Module - Awesome Studio', 'Install Module', 'manage_options', 'install-awesome-module', 'aw2_module_install_awesome_module_callback' );
		add_submenu_page( '', 'App Starter Packs - Awesome Studio', 'App Starter Packs', 'manage_options', 'app-starter-pack', 'aw2_app_starter_pack_callback' );
		add_submenu_page( '', 'Install App - Awesome Studio', 'Install App', 'manage_options', 'install-app', 'aw2_install_app_callback' );
	}
	
	static function selected_object($obj, $curr_obj, $default=null){
		$val='';
		
		if($curr_obj == $obj)
			$val = 'selected';
		
		if(empty($obj) && !is_null($default) && ($curr_obj == $default))
			$val = 'selected';
		return $val;
	}
}

function asf_installed_distributables_page_callback(){
	// this needs to be ported once module distribution is ready.// purpose of this function is to show list of modules that can be inserted into a page.
}


