<?php
require_once 'awesome2_library.php';
require_once 'includes/triggers.php';
require_once 'includes/post-type-reports.php';
require_once 'includes/util.php';
require_once 'includes/minify.php';
require_once 'includes/widget-class.php';

global $aw2_ajax;
$aw2_ajax=false;

//Solving the CPT UI Issue of not showing private objects
add_filter( 'cptui_attach_taxonomies_to_post_type', 'cptui_all_objects', 10, 1 );
add_filter( 'cptui_attach_post_types_to_taxonomy', 'cptui_all_objects', 10, 1 );

function cptui_all_objects( $args) {
	unset($args['public']);
	return $args;
}


add_action('wp_head','include_spa');
function include_spa() {
?>
<script type="text/javascript">
jQuery( document ).ready(function( $ ) {
	$.ajax({
		url: '<?php echo aw2_library::$cdn; ?>spa/spa.v2.min.js',
		dataType: "script",
		cache: true,
		success: function() {
			spa.app.start({
				homeurl:'<?php echo aw2_library::get('url.home'); ?>',
				cdn:'<?php echo aw2_library::get('url.cdn'); ?>',
				path:'<?php echo aw2_library::get('app.path'); ?>/'
			});
		}
	});
});
</script>
<?php
return;
}

//Adding the Editor Menu
add_action( 'wp_footer','awesome2_footer' ,100);
add_action( 'admin_footer','awesome2_footer' ,100);
function awesome2_footer() {
	//throw out scripts	
	$scripts=aw2_library::get('footer_output.ready');
	if(is_array($scripts)){
		foreach($scripts as $script){
			echo $script;
		}
	}

/* 	$styles=aw2_library::get('footer_output.style');
	if(is_array($styles)){
		foreach($styles as $style){
			echo $style;
		}
	}

	$styles=aw2_library::get('footer_output.stylesheet');
	if(is_array($styles)){
		foreach($styles as $style){
			echo "<link rel='stylesheet' href='" . aw2_library::$cdn . $style . "' type='text/css' media='all' />";
		}
	}
 */	
	$less=aw2_library::get('footer_output.less');
	if(is_array($less)){
		$string='';
		foreach($less as $single){
			$string .= $single;
		}
		$less = new lessc;
		$css = $less->compile($string);
		echo '<style>' . $css . '</style>';
	}
	

	//throw out editor	
	if (!current_user_can( 'manage_options' ) || is_admin() === 1)return;
	$modules=aw2_library::get_array_ref('modules');
	foreach($modules as $module){
		echo '<script type="text/module" data-module_id="' . $module->id . '" data-module_slug="' . $module->slug . '" data-module_title="' . $module->title . '"></script>';
	}
	echo "<style>
			#editor button{
				background-color: #7cb342;
				width:100px;
			}
			#editor button:hover{
				background-color: #628e34;
			}
			#editor_modules{margin: 0;}
			#editor_modules li {
				list-style-type: none;
				line-height: 0;
				margin-bottom: 10px;
				padding: 0px 3px;
				display: table;
				position: relative;
			}
			#editor_modules li::before,#editor_modules li::after{
				content: '';
				width: 6px;
				background-color: transparent;
				height: 100%;				
				border-top: 2px solid #ff5722;
				border-bottom: 2px solid #ff5722;
				display: table-cell;
			}
			#editor_modules li::before{border-left: 2px solid #ff5722;}
			#editor_modules li::after{border-right: 2px solid #ff5722;}
			#editor_modules li::after{margin-top: 0;}
			#editor_modules li a{
				padding: 0px 5px;
				font-size: 14px;
				line-height: 1.3;
				color: #ffffff;
			}
			#editor_modules li a:hover{
				color: #ff5722;
			}
			.module-hover{
				position:absolute; 
				width:100%; 
				height:100%; 
				z-index:1000000;
				background-color: yellow;
				opacity: 0.4;
				top: 0;
				left: 0;
			}
		</style>";
}

add_action( 'plugins_loaded', 'aw2_load_shortcodes' );

function aw2_load_shortcodes() {
	do_action( 'aw2_add_shortcode');
}

add_action( 'init', 'load_shortcodes' ,3);
function load_shortcodes(){
	$posts = get_posts(
	array(
		'post_type' => 'aw2_shortcode',
		'post_status' => 'publish',
		'posts_per_page'=>-1
	)
	);
		
	foreach ( $posts as $post ){
		aw2_library::parse_shortcode($post->post_content);
	}
}

add_filter( 'wpseo_title', 'change_yoast_title', 10, 1 );
function change_yoast_title( $str ) {
	
	if(strpos($str, 'id:')===false){
		return $str;
	}
	else{
		$str=trim(str_replace("id:","",$str));
		return trim(aw2_library::parse_shortcode('[aw2_seo title id=' . $str . ']'));
	}
}


add_filter( 'wpseo_metadesc', 'change_yoast_meta_desc', 10, 1 );
function change_yoast_meta_desc( $str ) {
	if(strpos($str, 'id:')===false){
		return $str;
	}
	else{
		$str=trim(str_replace("id:","",$str));
		return trim(aw2_library::parse_shortcode('[aw2_seo meta_desc id=' . $str . ']'));
	}
}

add_filter( 'wpseo_opengraph_title', 'change_yoast_opengraph_title', 10, 1 );
function change_yoast_opengraph_title( $str ) {
	if(strpos($str, 'id:')===false){
		return $str;
	}
	else{
		$str=trim(str_replace("id:","",$str));
		if(aw2_library::existsparam($id . '_' . 'opengraph_title'))
				return trim(aw2_library::parse_shortcode('[aw2_seo opengraph_title id=' . $str . ']'));
	}
	return trim(aw2_library::parse_shortcode('[aw2_seo title id=' . $str . ']'));

}




add_action('init', 'aw2_register',1);
function aw2_register() {
	register_post_type('aw2_module', array(
	'label' => 'Awesome Modules',
	'description' => '',
	'public' => false,
	'show_in_nav_menus'=>false,
	'show_ui' => true,
	'show_in_menu' => false,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'hierarchical' => true,
	'menu_icon'   => 'dashicons-align-right',
	'menu_position'   => 26,
	'rewrite' => false,
	'delete_with_user' => false,
	'query_var' => true,
	'supports' => array('title','editor','excerpt','revisions','custom-fields','thumbnail'),
	'labels' => array (
	  'name' => 'Awesome Modules',
	  'singular_name' => 'Awesome Module',
	  'menu_name' => 'Awesome Modules',
	  'add_new' => 'Add Awesome Module',
	  'add_new_item' => 'Add New Awesome Module',
	  'edit' => 'Edit',
	  'edit_item' => 'Edit Awesome Module',
	  'new_item' => 'New Awesome Module',
	  'view' => 'View Awesome Module',
	  'view_item' => 'View Awesome Module',
	  'search_items' => 'Search Awesome Modules',
	  'not_found' => 'No Awesome Modules Found',
	  'not_found_in_trash' => 'No Awesome Modules Found in Trash',
	  'parent' => 'Parent Awesome Module',
	)
	) ); 
	
	register_taxonomy('aw2_module_type', 'aw2_module', array(
		// Hierarchical taxonomy (like categories)
		'hierarchical' => true,
		'public' => false,
		'query_var' => false,
		'show_ui' => true,
		'show_in_menu' => false,
		'show_admin_column'=>true,
		'show_admin_column'=>true,
		// This array of options controls the labels displayed in the WordPress Admin UI
		'labels' => array(
		  'name' => _x( 'Module Type', 'taxonomy general name' ),
		  'singular_name' => _x( 'Module Type', 'taxonomy singular name' ),
		  'search_items' =>  __( 'Search Module Type' ),
		  'all_items' => __( 'All Module Type' ),
		  'parent_item' => __( 'Parent Module Type' ),
		  'parent_item_colon' => __( 'Parent Module Type:' ),
		  'edit_item' => __( 'Edit Module Type' ),
		  'update_item' => __( 'Update Module Type' ),
		  'add_new_item' => __( 'Add New Module Type' ),
		  'new_item_name' => __( 'New Module Type Name' ),
		  'menu_name' => __( 'Module Type' ),
		),
		// Control the slugs used for this taxonomy
		'rewrite' => array(
		  'slug' => 'module_type', // This controls the base slug that will display before each term
		  'with_front' => false, // Don't display the category base before "/Module Type/"
		  'hierarchical' => true // This will allow URL's like "/Module Type/boston/cambridge/"
		  
		),
	  ));
	  
	register_post_type('aw2_shortcode', array(
	'label' => 'Shortcodes',
	'description' => '',
	'public' => false,
	'show_in_nav_menus'=>false,
	'show_ui' => true,
	'show_in_menu' => false,
	'capability_type' => 'post',
	'map_meta_cap' => true,
	'hierarchical' => true,
	'menu_icon'   => 'dashicons-align-right',
	'menu_position'   => 26,
	'rewrite' => false,
	'delete_with_user' => false,
	'query_var' => true,
	'supports' => array('title','editor','excerpt','revisions','custom-fields','thumbnail'),
	'labels' => array (
	  'name' => 'Shortcodes',
	  'singular_name' => 'Shortcode',
	  'menu_name' => 'Shortcodes',
	  'add_new' => 'Add Shortcode',
	  'add_new_item' => 'Add New Shortcode',
	  'edit' => 'Edit',
	  'edit_item' => 'Edit Shortcode',
	  'new_item' => 'New Shortcode',
	  'view' => 'View Shortcode',
	  'view_item' => 'View Shortcode',
	  'search_items' => 'Search Shortcodes',
	  'not_found' => 'No Shortcodes Found',
	  'not_found_in_trash' => 'No Shortcodes Found in Trash',
	  'parent' => 'Parent Shortcode',
	)
	) ); 
	  

}

function awesome_studio_add_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('aw2_module_type');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'aw2_module' ){
 
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
	}
	
	if( $typenow == 'asf_entries' ){ 
		$tax_obj = get_taxonomy('entry_type');
		$tax_name = $tax_obj->labels->name;
		$terms = get_terms('entry_type');
		if(count($terms) > 0) {
			echo "<select name='entry_type' id='entry_type' class='postform'>";
			echo "<option value=''>All $tax_name</option>";
			foreach ($terms as $term) { 
				echo '<option value='. $term->slug, $_GET['entry_type'] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
			}
			echo "</select>";
		}
	}
}
add_action( 'restrict_manage_posts', 'awesome_studio_add_taxonomy_filters',100 );


function awesome_studio_add_filter_to_posts($query){
	 global $post_type, $pagenow;

    //if we are currently on the edit screen of the post type listings

    if($pagenow == 'edit.php' && $post_type == @$_GET['post_type'] && $query->is_main_query()){
		//util::var_dump($query);	
        if(isset($_GET['aw2_module_type']) && !empty($_GET['aw2_module_type'])){
            //get the desired post format
            $aw2_module_type = sanitize_text_field($_GET['aw2_module_type']);
			$query->query_vars['tax_query'] = array(
				array(
					'taxonomy'  => 'aw2_module_type',
					'field'     => 'slug',
					'terms'     => $aw2_module_type
				)
			);
        }
		
		if(isset($_GET['aw2_trigger_when']) && !empty($_GET['aw2_trigger_when'])){
            $aw2_trigger_when = sanitize_text_field($_GET['aw2_trigger_when']);
			$query->query_vars['tax_query'] = array(
				array(
					'taxonomy'  => 'aw2_trigger_when',
					'field'     => 'slug',
					'terms'     => $aw2_trigger_when
				)
			);
        }
		
		if(isset($_GET['entry_type']) && !empty($_GET['entry_type'])){
            $entry_type = sanitize_text_field($_GET['entry_type']);
			$query->query_vars['tax_query'] = array(
				array(
					'taxonomy'  => 'entry_type',
					'field'     => 'slug',
					'terms'     => $entry_type
				)
			);
        }
		
    } 

}

add_action('pre_get_posts','awesome_studio_add_filter_to_posts');
add_filter( 'manage_aw2_module_posts_columns', 'set_custom_edit_aw2_module_columns' );
add_action( 'manage_aw2_module_posts_custom_column' , 'custom_aw2_module_column', 10, 2 );

function set_custom_edit_aw2_module_columns($columns) {
    unset( $columns['author'] );

	$columns['thumb'] = 'Image';
	$columns['actions'] ='Actions';
    $columns['dependancy'] ='Dependancy';
    /*$columns['help'] ='Help';*/

	return $columns;
}

function custom_aw2_module_column( $column, $post_id ) {
    switch ( $column ) {
		
		case 'thumb' :
			$thumb=get_post_meta($post_id , '_module_thumb' , true);
			echo '<img src="'.$thumb.'" width="250px" height="auto" style="max-width: 100%;" />';
		break;

		case 'actions' :
			$post_data = get_post($post_id);
			$slug = $post_data->post_name;
			$url = get_admin_url().'admin.php?';
			echo '<a href="'.$url.'page=awesome-get-shortcode&slug='.$slug.'" >Get Shortcode</a><br />';
			echo '<a href="'.$url.'page=awesome-set-trigger&slug='.$slug.'" >Set Trigger</a><br />';
			//echo '<a href="#">Re-Install</a>';
		break;
		
        case 'dependancy' :
		$install=get_post_meta($post_id , '_installation' , true);
		//$install=json_decode($install,true);
		if(is_array($install)){
			foreach ($install as $activity){
				foreach($activity as $key=>$value)
				{
					switch($key) {
						case 'trigger':
							$return=aw2_library::get_post_from_slug($value,'aw2_trigger',$post);
							if($return)
								echo '<a target=_blank href="' . get_edit_post_link($post->ID) . '">' . $post->post_title . '</a><br/>';
							break;
						case 'module':
							$return=aw2_library::get_post_from_slug($value,'aw2_module',$post);
							if($return)
								echo '<a  target=_blank href="' . get_edit_post_link($post->ID) . '">' . $post->post_title . '</a><br/>';
							break;
						
					}
				}
			}
		}
		break;
        case 'help' :
		$post=get_post($post_id);
		echo "<a target=_blank href='/help?slug=" . $post->post_name . "'>Help</a>" ;
		break;


    }
}



function aw2_framework_overview_callback(){
   echo '<div class="wrap">';
          echo '<h2>Awesome Studio Framework</h2>';
          //$count_posts = wp_count_posts();
          //$published_posts = $count_posts->publish;
		  if(class_exists('Adminaw2_modulemarks'))
		  {
			 $ab=Adminaw2_modulemarks::get_instance();
			 $ab->render_aw2_modulemarks_list();
		  } 
   echo '</div>';       
}
	
aw2_library::setup();			
	


