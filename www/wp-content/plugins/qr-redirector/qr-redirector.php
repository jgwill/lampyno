<?php
/**
 * @package QR Redirector
 * @version 1.3
 */
/*
Plugin Name: QR Redirector
Plugin URI: http://nlb-creations.com/2012/10/19/wordpress-plugin-qr-redirector/
Description: This plugin creates a new content type that can be used to set up a URL redirect site for generated QR codes.
Author: Nikki Blight <nblight@nlb-creations.com>
Version: 1.3
Author URI: http://www.nlb-creations.com
*/

include('phpqrcode/qrlib.php');

add_action( 'init', 'qr_create_post_types' );
add_action( 'wp', 'qr_redirect_to_url' );

//load styles for the admin section
function load_qr_admin_style() {
	global $post_type;
	if( 'qrcode' == $post_type ) {
		wp_register_style( 'qr_admin_css', plugins_url('/admin.css', __FILE__), false, '1.0.0' );
		wp_enqueue_style( 'qr_admin_css' );
    }
}
add_action('admin_enqueue_scripts', 'load_qr_admin_style');

//intercept the post before it actually renders so we can redirect if it's a qrcode
function qr_redirect_to_url() {
	global $post;
	
	//for backwards compatibility
	if(!isset($post->ID)) {
		//get the post_name so we can look up the post
		if(stristr($_SERVER['REQUEST_URI'], "/") && stristr($_SERVER['REQUEST_URI'], "/qr/")) {
			$uri = explode("/", $_SERVER['REQUEST_URI']);
			
			foreach($uri as $i => $u) {
				if($u == '') {
					unset($uri[$i]);
				}
			}
			$uri = array_pop($uri);
		}
		else {
			$uri = $_SERVER['REQUEST_URI'];
		}
	
		$post = get_page_by_path($uri,'OBJECT','qrcode');
	}
	
	if(!is_admin()) {
		if(isset($post->post_type) && $post->post_type == 'qrcode') {
			$url = get_post_meta($post->ID, 'qr_redirect_url', true);

			if($url != '') {
				qr_add_count($post->ID);
				header( 'Location: '.$url );
				exit();
			}
			else {
				//if for some reason there's no url, redirect to homepage
				header( 'Location: '.get_bloginfo('url') );
				exit();
			}
		}
	}
}

//create a custom post type to hold qr redirect data
function qr_create_post_types() {
	register_post_type( 'qrcode',
		array(
			'labels' => array(
				'name' => __( 'QR Redirects' ),
				'singular_name' => __( 'QR Redirect' ),
				'add_new' => __( 'Add QR Redirect'),
				'add_new_item' => __( 'Add QR Redirect'),
				'edit_item' => __( 'Edit QR Redirect' ),
				'new_item' => __( 'New QR Redirect' ),
				'view_item' => __( 'View QR Redirect' )
			),
			'show_ui' => true,
			'description' => 'Post type for QR Redirects',
			//'menu_position' => 5,
			'menu_icon' => WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)) . '/qr-menu-icon.png',
			'public' => true,
			'exclude_from_search' => true,
			'supports' => array('title'),
			'rewrite' => array('slug' => 'qr'),
			'can_export' => true
		)
	);
}

//simple function to keep some stats on how many times a QR Code has been used
function qr_add_count($post_id) {
	$count = get_post_meta($post_id,'qr_redirect_count',true);
	if(!$count) {
		$count = 0;
	}
	
	$count = $count + 1;
	update_post_meta($post_id,'qr_redirect_count',$count);
}

// Add a custom postmeta field for the redirect url
add_action( 'add_meta_boxes', 'qr_dynamic_add_custom_box' );

//save the data in the custom field
add_action( 'save_post', 'qr_dynamic_save_postdata' );

//Add boxes to the edit screens for a qrcode post type
function qr_dynamic_add_custom_box() {
    //the redirect url
	add_meta_box(
		'dynamic_url',
		__( 'Redirect URL', 'myplugin_textdomain' ),
		'qr_redirect_custom_box',
		'qrcode');
        
	//the actual generated qr code
	add_meta_box(
		'dynamic_qr',
		__( 'QR Code', 'myplugin_textdomain' ),
		'qr_image_custom_box',
		'qrcode',
		'side');
}

//print the url custom meta box content
function qr_redirect_custom_box() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    
    echo '<div id="meta_inner">';

    //get the saved metadata
    $url = get_post_meta($post->ID,'qr_redirect_url',true);
    $ecl = get_post_meta($post->ID,'qr_redirect_ecl',true);
    $size = get_post_meta($post->ID,'qr_redirect_size',true);
    $notes = get_post_meta($post->ID,'qr_redirect_notes',true);

    //output the form
	echo '<p> <strong>URL:</strong> <input type="text" name="qr_redirect[url]" value="'.$url.'" style="width: 95%;" /> </p>';
	
	echo '<p>';
	echo '<div class="tooltip"><strong>Error Correction Level:</strong> ';
	echo '<span class="tooltiptext">The Error Correction Level is the amount of "backup" data in the QR code to account for damage it may receive in its intended environment.  Higher levels result in a more complex QR image.</span>';
	echo '</div>';
	echo '<select name="qr_redirect[ecl]">';
	echo '<option value="L"';
	if($ecl == "L") { echo ' selected="selected"'; }
	echo '>L - recovery of up to 7% data loss</option>';
	echo '<option value="M"';
	if($ecl == "M") {
		echo ' selected="selected"';
	}
	echo '>M - recovery of up to 15% data loss</option>';
	echo '<option value="Q"';
	if($ecl == "Q") {
		echo ' selected="selected"';
	}
	echo'>Q - recovery of up to 25% data loss</option>';
	echo '<option value="H"';
	if($ecl == "H") {
		echo ' selected="selected"';
	}
	echo '>H - recovery of up to 30% data loss</option>';
	echo '</select></p>';
	
	echo '<p><strong>Size:</strong> <select name="qr_redirect[size]">';
	for($i=1; $i<=30; $i++) {
		echo '<option value="'.$i.'"';
		if(!$size && $i==5) {
			echo ' selected="selected"';
		}
		elseif($size == $i) {
			echo ' selected="selected"';
		}
		echo '>'.$i;
		echo ' - '.($i*29).' x '.($i*29).' pixels';
		echo '</option>';
	}
	echo '</select></p>';
	
	echo '<p>';
	echo '<div class="tooltip"><strong>Admin Notes:</strong> ';
	echo '<span class="tooltiptext">Anything entered here is for your reference only and will not appear outside of the WordPress backend.</span>';
	echo '</div>';
	echo '<br /> <textarea style="width: 75%; height: 150px;" name="qr_redirect[notes]">'.$notes.'</textarea></p>';
	
	if($post->post_status !='auto-draft') {
		//post has not yet been saved if status is auto-draft
		echo '<p><strong>Shortcode:</strong><br />';
		echo 'Copy and paste this short code into your posts or pages to display this QR Code:';
		
		echo '<br /><br /><code>[qr-code id="'.$post->ID.'"]</code></p>';
	}
	
	if($post->post_status !='auto-draft') {
		echo '<p>';
		echo '<strong>Actual Size:</strong></br ><br />';
		echo do_shortcode('[qr-code id="'.$post->ID.'"]');
		echo '</p>';
	}
	
	echo '</div>';
}

//print the qr code image and meta info
function qr_image_custom_box() {
    global $post;
    $img = get_post_meta($post->ID, 'qr_image_url', true);
    
    echo '<div id="meta_inner" style="text-align: center;">';
	
	if($post->post_status == "publish") {
		echo '<img src="'.$img.'" style="max-width: 250px; max-height: 250px;" />';
		echo '<br /><br />';
		echo get_permalink($post->ID);
		echo '<br /><br />will redirect to:<br /><br />';
		echo get_post_meta($post->ID,'qr_redirect_url',true);
		
		$count = get_post_meta($post->ID,'qr_redirect_count',true);
		if(!$count) {
			$count = 0;
		}
		echo '<br /><br />This QR has redirected <strong>'.$count.'</strong> times';
	}
	else {
		echo 'Publish to generate QR Code';
	}
	echo '</div>';
}

//when the post is saved, save our custom postmeta too
function qr_dynamic_save_postdata( $post_id ) {
	//if our form has not been submitted, we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
		return;
	}

	// verify this came from the our screen and with proper authorization
	if (isset($_POST['dynamicMeta_noncename'])){
		if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
			return;
	}
	else {
		return;
	}
	//save the data
	$url = $_POST['qr_redirect']['url'];
	
	if(!stristr($url, "://")) {
		$url = "http://".$url;
	}
	
	$permalink = get_permalink($post_id);
	$errorCorrectionLevel = $_POST['qr_redirect']['ecl'];
	$matrixPointSize = $_POST['qr_redirect']['size'];
	
	//generate the image file
	$upload_dir = wp_upload_dir();
	$PNG_TEMP_DIR = $upload_dir['basedir'].'/qrcodes/';
	
	if (!file_exists($PNG_TEMP_DIR)) {
		mkdir($PNG_TEMP_DIR);
	}
	
	//processing form input
	$filename = $PNG_TEMP_DIR.'qr'.md5($permalink.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	
	//if we're updating an image, we dont want to keep the old version
	$oldfile = str_replace($upload_dir['baseurl'].'/qrcodes/', $PNG_TEMP_DIR, get_post_meta($post_id,'qr_image_url',true));
	if ($oldfile != '' && file_exists($oldfile)) {
		unlink($oldfile);
	}
	
	QRcode::png($permalink, $filename, $errorCorrectionLevel, $matrixPointSize, 0);
	$img = content_url().'/uploads/qrcodes/'.basename($filename);
	
	update_post_meta($post_id,'qr_image_url',$img);
	update_post_meta($post_id,'qr_redirect_url',$url);
	update_post_meta($post_id,'qr_redirect_ecl',$errorCorrectionLevel);
	update_post_meta($post_id,'qr_redirect_size',$matrixPointSize);
	update_post_meta($post_id,'qr_redirect_notes',$_POST['qr_redirect']['notes']);
}

//shortcode function to show a QR code in a post
function qr_show_code($atts) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
	
	//if no id is specified, we have nothing to display
	if(!$id) {
		return false;
	}
	$output = '';
	$img = get_post_meta($id, 'qr_image_url', true);
	$output .= '<img src="'.$img.'" class="qr-code" />';	
	return $output;
}
add_shortcode( 'qr-code', 'qr_show_code');

?>