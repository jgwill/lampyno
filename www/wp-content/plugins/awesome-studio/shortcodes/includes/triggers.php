<?php
add_action('setup_theme', 'awesome2_trigger::register',1);
add_action( 'setup_theme', 'awesome2_trigger::load' ,2);


add_action( 'after_setup_theme', 'awesome2_trigger::after_setup_theme' ,2);


add_action( 'init', 'awesome2_trigger::init' ,1);
add_filter('query_vars', 'awesome2_trigger::query_vars',1);
add_filter('wp_enqueue_scripts', 'awesome2_trigger::wp_enqueue_scripts',100);

add_action( 'wp_head', 'awesome2_trigger::wp_head' ,100);
add_action( 'header', 'awesome2_trigger::header' ,1);

add_action( 'footer', 'awesome2_trigger::footer' ,1);
add_action( 'wp_footer', 'awesome2_trigger::wp_footer' ,1);

//add_action( 'cmb2_admin_init', 'awesome2_trigger::cmb2_metabox' );
//add_action( 'admin_menu', 'awesome2_trigger::remove_meta_boxes' );

add_filter( 'cmb2_meta_boxes', 'awesome2_trigger::metaboxes' );
add_filter('awesome_site_settings', 'awesome2_trigger::site_options');

add_action( 'add_meta_boxes', 'awesome2_trigger::custom_metaboxes' );

add_action( 'show_user_profile', 'awesome2_trigger::custom_user_metaboxes' );
add_action( 'edit_user_profile', 'awesome2_trigger::custom_user_metaboxes' );

class awesome2_trigger{
	static $triggers=array();

	static function activation() {
		self::register();
		self::register_default_when_terms();
		
	}
	static function return_trigger_output($when){
		$return_value='';
		foreach ( self::$triggers as $trigger ){
			if($trigger['when']==$when){
				$return_value .= trim(aw2_library::parse_shortcode($trigger['content']));
			}	
		}
		return $return_value;
	}
	static function echo_output($when){
		foreach ( self::$triggers as $trigger ){
			if($trigger['when']==$when){
				echo trim(aw2_library::parse_shortcode($trigger['content']));
			}	
		}
	}
	static function run_trigger($when){
		foreach ( self::$triggers as $trigger ){
			if($trigger['when']==$when){
				aw2_library::parse_shortcode($trigger['content']);
			}	
		}
	}
	static function register_default_when_terms() {
        $taxonomy = 'aw2_trigger_when';
        $terms = array (
            '0' => array (
                'name'          => 'WP_Head Hook',
                'slug'          => 'wp_head',
                'description'   => 'Executed when wp_head action hook is fired',
            ),
            '1' => array (
                'name'          => 'CSS/JS Definitions',
                'slug'          => 'js_def',
                'description'   => 'This is executed after wp_head triggers have run',
            ),
            '2' => array (
                'name'          => 'Header',
                'slug'          => 'header',
                'description'   => 'This will be fired when core header module is called',
            ),
            '3' => array (
                'name'          => 'WP_Footer Hook',
                'slug'          => 'wp_footer',
                'description'   => 'Executed when wp_footer action hook is fired',
            ),
            '4' => array (
                'name'          => 'Footer',
                'slug'          => 'footer',
                'description'   => 'This is fired when core footer module is fired',
            ),
            '5' => array (
                'name'          => 'Init Hook',
                'slug'          => 'init',
                'description'   => 'This is executed when init action hook is fired',
            ),
            '6' => array (
                'name'          => 'Rewrite Rules',
                'slug'          => 'rewrite_rules',
                'description'   => 'This is executed after init hook has fired.',
            ),
			'7' => array (
                'name'          => 'Metabox',
                'slug'          => 'metabox',
                'description'   => 'This is executed when cmb2_meta_boxes hook has fired.',
            ),
			'8' => array (
                'name'          => 'Site Options',
                'slug'          => 'site_options',
                'description'   => 'This is executed when Quilt hook is fired.',
            ),
			'9' => array (
                'name'          => 'After Setup Theme',
                'slug'          => 'after_setup_theme',
                'description'   => 'This is executed after Theme is loaded.',
            ),
			'10' => array (
                'name'          => 'Enqueue Style/Scripts',
                'slug'          => 'enqueue',
                'description'   => 'This is executed when wp_enqueue_script hook is fired.',
            ),
			'11' => array (
                'name'          => 'App Settings',
                'slug'          => 'app_settings',
                'description'   => 'These are the App Settings.',
			),	
			'12' => array (
                'name'          => 'App Menu',
                'slug'          => 'app_menu',
                'description'   => 'Create the App Menu.',
			)
			);  

        foreach ( $terms as $term_key=>$term) {
			if( !term_exists( $term['slug'], $taxonomy ) ) {
                wp_insert_term(
                    $term['name'],
                    $taxonomy, 
                    array(
                        'description'   => $term['description'],
                        'slug'          => $term['slug'],
                    )
                );
				unset( $term ); 
			}
        }

    }

//public functions	
	static function register() {
		if ( post_type_exists( 'aw2_trigger' ) ) 
			return;

		register_post_type('aw2_trigger', array(
		'label' => 'Trigger',
		'description' => '',
		'public' => false,
		'exclude_from_search'=>true,
		'publicly_queryable'=>false,
		'show_in_nav_menus'=>false,
		'show_ui' => true,
		'show_in_menu' => false,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'menu_icon'   => 'dashicons-schedule',
		'menu_position'   => 25,
		'rewrite' => false,
		'delete_with_user' => false,
		'query_var' => true,
		'supports' => array('title','editor','excerpt','revisions'),
		'labels' => array (
		  'name' => 'Awesome Triggers',
		  'singular_name' => 'Awesome Trigger',
		  'menu_name' => 'Awesome Triggers',
		  'add_new' => 'Add Awesome Trigger',
		  'add_new_item' => 'Add New Awesome Trigger',
		  'edit' => 'Edit',
		  'edit_item' => 'Edit Awesome Trigger',
		  'new_item' => 'New Awesome Trigger',
		  'view' => 'View Awesome Trigger',
		  'view_item' => 'View Awesome Trigger',
		  'search_items' => 'Search Awesome Triggers',
		  'not_found' => 'No Awesome Triggers Found',
		  'not_found_in_trash' => 'No Awesome Triggers Found in Trash',
		  'parent' => 'Parent Awesome Trigger',
		)
		) ); 


		register_taxonomy('aw2_trigger_when', 'aw2_trigger', array(
			// Hierarchical taxonomy (like categories)
			'hierarchical' => true,
			'public' => false,
			'query_var' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_admin_column'=>true,
			// This array of options controls the labels displayed in the WordPress Admin UI
			'labels' => array(
			  'name' => _x( 'When', 'taxonomy general name' ),
			  'singular_name' => _x( 'When', 'taxonomy singular name' ),
			  'search_items' =>  __( 'Search When' ),
			  'all_items' => __( 'All When' ),
			  'parent_item' => __( 'Parent When' ),
			  'parent_item_colon' => __( 'Parent When:' ),
			  'edit_item' => __( 'Edit When' ),
			  'update_item' => __( 'Update When' ),
			  'add_new_item' => __( 'Add New When' ),
			  'new_item_name' => __( 'New When Name' ),
			  'menu_name' => __( 'When' ),
			),
			// Control the slugs used for this taxonomy
			'rewrite' => array(
			  'slug' => 'when', // This controls the base slug that will display before each term
			  'with_front' => false, // Don't display the category base before "/When/"
			  'hierarchical' => true // This will allow URL's like "/When/boston/cambridge/"
			  
			),
		  ));
	}
	
	static function cmb2_metabox() {

		/**
		 * Initiate the metabox
		 */
		$cmb = new_cmb2_box( array(
			'id'            => 'trigger_box',
			'title'         => __( 'When', 'cmb2' ),
			'object_types'  => array( 'aw2_trigger' ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
		) );

		// Regular text field
		$cmb->add_field( array(
			'name'       =>'Trigger On',
			'desc'       =>'Select when this trigger will be called',
			'id' =>'aw2_trigger_when',
			'taxonomy' => 'aw2_trigger_when', // Enter Taxonomy Slug
			'type'     => 'taxonomy_radio',
			// Optional:
			'options' => array(
				'no_terms_text' => 'Sorry, no terms could be found.' // Change default text. Default: "No terms"
			)
		) );

	  
		// Add other metaboxes as needed

	}
	
	static function remove_meta_boxes() {
		 remove_meta_box('aw2_trigger_whendiv', 'aw2_trigger', 'normal');

	}

	static function load_app(){
		$app_post_type=aw2_library::get('app.default_triggers');
		
		if(empty($app_post_type))
			return;
		
		$posts = get_posts(
			array(
				'post_type' => $app_post_type,
				'post_status' => 'publish',
				'posts_per_page'=>-1
			)
		);
		
		foreach ( $posts as $post ){
			$trigger=array();
			$trigger['content']=$post->post_content;
			$term_list = wp_get_post_terms($post->ID, 'aw2_trigger_when', array("fields" => "slugs"));
			$trigger['when']=implode(",", $term_list);
			$trigger['slug']=$post->post_name;
			array_push(self::$triggers, $trigger);
		}
		
		
	}
	
	static function load(){
		$posts = get_posts(
			array(
				'post_type' => 'aw2_trigger',
				'post_status' => 'publish',
				'posts_per_page'=>-1
			)
		);
		foreach ( $posts as $post ){
			$trigger=array();
			$trigger['content']=$post->post_content;
			$term_list = wp_get_post_terms($post->ID, 'aw2_trigger_when', array("fields" => "slugs"));
			$trigger['when']=implode(",", $term_list);
			$trigger['slug']=$post->post_name;
			array_push(self::$triggers, $trigger);
		}
	}	
	
	static function run_settings_triggers($post_type){
		$posts = get_posts(
			array(
				'post_type' => $post_type,
				'post_status' => 'publish',
				'posts_per_page'=>-1,
				'tax_query' => array(
					array(
						'taxonomy'     => 'aw2_trigger_when',
						'field'   => 'slug',
						'terms'   => 'app_settings'
					),
				),
			)
		);
		foreach ( $posts as $post ){
			aw2_library::parse_shortcode($post->post_content);
		}
	}
	
	static function wp_head(){
		self::echo_output('wp_head');
		self::echo_output('js_def');
	}
	
	static function header(){
		self::echo_output('header');
	}

	static function wp_footer(){
		self::echo_output('wp_footer');
	}

	static function footer(){
		self::echo_output('footer');
	}
	
	static function init(){
		self::echo_output('init');
		self::run_trigger('rewrite_rules');
		
	}

	static function after_setup_theme(){
		self::echo_output('after_setup_theme');
		self::setup_image_sizes();
	}
	
	static function setup_image_sizes(){
		$image_sizes=&aw2_library::get_array_ref('image_sizes');
		
		foreach($image_sizes as $name=>$image_size){
			
			$width=9999;
			if(!empty($image_size['width']))
				$width=$image_size['width'];
			$height=9999;
			if(!empty($image_size['height']))
				$height=$image_size['height'];
			
			$crop=false;
			if(!empty($image_size['crop'])){
				
				if(is_array($image_size['crop']) ){
					$crop=$image_size['crop'];
				}	
				else if(strtolower($image_size['crop']) == "true"){
					$crop = true;
				}
			}
				
			
			add_image_size( $name, $width, $height, $crop );
		}
		
	}
	static function metaboxes(array $meta_boxes){

		$cmb_meta_boxes=&aw2_library::get_array_ref('cmb_meta_boxes');
		$cmb_meta_boxes = array_merge($cmb_meta_boxes, $meta_boxes);
		self::run_trigger('metabox');
		$meta_boxes = aw2_library::get('cmb_meta_boxes');
		if(!is_array($meta_boxes))
			$meta_boxes = array();
		return $meta_boxes;
	}
	
	static function custom_user_metaboxes(){

		$custom_user_metaboxes=&aw2_library::get_array_ref('custom_user_metaboxes');
		
		if(!empty($custom_user_metaboxes)){
			foreach($custom_user_metaboxes as $custom_user_box){
				$return=aw2_library::get_module_for_app($custom_user_box['module'], $post);
				$return_value=aw2_library::run_module($custom_user_box['module'],null,null,null,$post->post_type,'run');
			
				echo $return_value;
			}
			
		}
	
	}	
	static function custom_metaboxes(){
		$custom_meta_boxes=&aw2_library::get_array_ref('custom_meta_boxes');
		
		if(!empty($custom_meta_boxes)){
			foreach($custom_meta_boxes as $custom_meta_box){
				add_meta_box( $custom_meta_box['id'], $custom_meta_box['title'], 'awesome2_trigger::custom_metabox_callback' , $custom_meta_box['object_types'], $custom_meta_box['context'], $custom_meta_box['priority'], array('module' => $custom_meta_box['module']) );
			}
		}
	
	}
	
	static function custom_metabox_callback( $post, $metabox ) {
		$return=aw2_library::get_module_for_app($metabox['args']['module'], $post);
		$return_value=aw2_library::run_module($metabox['args']['module'],null,null,null,$post->post_type,'run');
		
		echo $return_value;
	}
		
	static function site_options(array $sections){
	
		aw2_library::set('site_setting_sections',$sections);
		self::run_trigger('site_options');
		$site_setting_sections = aw2_library::get('site_setting_sections');
		if(!is_array($site_setting_sections))
			$site_setting_sections = array();
		
		return $site_setting_sections;
	}

	static function query_vars($query_vars) {
		$query_vars_new = aw2_library::get('query_vars_array');
		if(!is_array($query_vars_new)) return $query_vars;
		
		$query_vars_new = array_merge($query_vars_new, $query_vars);		
		aw2_library::set('query_vars_array','');

		return $query_vars_new;
		
	}
	
	static function wp_enqueue_scripts() {
		self::run_trigger('enqueue');
	}

}

function awesome_studio_trigger_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomies you want to display. Use the taxonomy name or slug
	$taxonomies = array('aw2_trigger_when');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'aw2_trigger' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>$tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'awesome_studio_trigger_taxonomy_filters',100 );


add_filter( 'image_size_names_choose', 'awesome_studio_custom_image_sizes_choose' );
function awesome_studio_custom_image_sizes_choose( $sizes ) {

	$image_sizes=&aw2_library::get_array_ref('image_sizes');
		
	foreach($image_sizes as $name=>$image_size){
		 $label=$name;
		 if(!empty($image_size['label']))
			 $label= $image_size['label'];
		 
		 $custom_sizes[$name]=$label;
	}
	
    return array_merge( $sizes, $custom_sizes );
}