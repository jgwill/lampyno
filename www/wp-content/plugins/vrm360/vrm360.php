<?php
/*
Plugin Name: Vrm360
Plugin URI:  https://wordpress.org/plugins/vrm360/
Description: 3D model viewer w/ rotation and zoom
Version:     1.2.1
Author:      Maurice
Author URI:  https://easyw.github.io/
License:     GPL2License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('VRM360_PLUGIN_MAIN', __FILE__);
define('VRM360_PLUGIN_PATH', plugin_dir_path(__FILE__));


// add_action('wp_enqueue_scripts', 'check_font_awesome', 99999);
function check_vrmfont_awesome() {
  global $wp_styles;
  $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
  // print_r($srcs);
  if ( in_array('vrm-style.css', $srcs) || in_array('vrm-style.css', $srcs)  ) {
    /* echo 'font-awesome.css registered'; */
  } else {
    //wp_enqueue_style('font-awesome', get_template_directory_uri() . '/font-awesome.css' );
    //wp_register_style( 'spin360-font-awesome', plugins_url( 'spin360/css/spin-style.css' ) );
    wp_register_style( 'vrm360-font-awesome', plugins_url( 'css/vrm-style.css', __FILE__) );
    wp_enqueue_style( 'vrm360-font-awesome' );
    // wp_enqueue_style('font-awesome', plugins_url('font-awesome.min.css', __FILE__) );
  }
}

// rate plugin link
function add_vrm360_links($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $supp_url = 'https://wordpress.org/support/plugin/' . basename(dirname(__FILE__));
        $links[] = '<a target="_blank" href="'. $supp_url .'" title="Click here to ask for support on this plugin on WordPress.org">Ask for Support</a>';
        $rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . basename(dirname(__FILE__)) . '?rate=5#postform';
        $links[] = '<a target="_blank" href="'. $rate_url .'" title="Click here to rate and review this plugin on WordPress.org">Rate this plugin</a>';
        $alt_url = 'https://wordpress.org/plugins/spin360/';
        $links[] = '<a target="_blank" href="'. $alt_url .'" title="Discover an alternative 3D model viewer plugin">Spin360 3D viewer</a>';
    }
    return $links;
}
add_filter('plugin_row_meta', 'add_vrm360_links', 10, 2);

// register vrm360 scripts and styles
function vrm360_enqueue_scripts() {
    //wp_enqueue_script( 'spritespin.min.js', plugins_url('scripts/spritespin.min.js', __FILE__), array('jquery') );
    wp_enqueue_style( 'vrm360-style', plugins_url('vrm360.css', __FILE__) );
    wp_enqueue_script( 'three.min.js', plugins_url('js/three.min.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'OrbitControls.js', plugins_url('js/OrbitControls.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'WebGL.js', plugins_url('js/WebGL.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'VRMLLoader.js', plugins_url('js/VRMLLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'DDSLoader.js', plugins_url('js/DDSLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'MTLLoader.js', plugins_url('js/MTLLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'OBJLoader.js', plugins_url('js/OBJLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'FBXLoader.js', plugins_url('js/FBXLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'inflate.min.js', plugins_url('js/inflate.min.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'ColladaLoader.js', plugins_url('js/ColladaLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'STLLoader.js', plugins_url('js/STLLoader.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'THREEx.FullScreen.js', plugins_url('js/THREEx.FullScreen.js', __FILE__), array('jquery') );
    wp_enqueue_script( 'inserter.js', plugins_url('js/inserter.js', __FILE__), array('jquery') );
    
    check_vrmfont_awesome();
    }

add_action( 'wp_enqueue_scripts', 'vrm360_enqueue_scripts' );

//in wordpress admin area
// if (is_admin())
//     {
//         include_once VRM360_PLUGIN_PATH.'vrm360act.php';
//         new vrm360activation();
//     }

/*
 * spin360 shortcode generator.
 */

add_filter('upload_mimes', 'vrmCustom_upload_mimes');

function hook_mobile_head() {
    ?>
        <meta name='viewport' content='width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0'/>
    <?php
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

if(isMobile()){
    add_action('wp_head', 'hook_mobile_head'); //required for two finger zooming
}

function vrm360_basename($file) {
    $array=explode('/',$file);
    $base=array_pop($array);
    return $base;
} 

function debug_to_myconsole( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.log( 'php_console_log: " . $output . "' );</script>";
}

function warn_to_myconsole( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.warn( 'php_console_log: " . $output . "' );</script>";
}

function unzip($mdl) {
    //debug_to_myconsole( "test2 ".class_exists('ZipArchive'));
    if (class_exists('ZipArchive')) {
        $time=time();
        $upload_dir = wp_upload_dir();
        $upload_dir_url = $upload_dir['baseurl'];
        // debug_to_myconsole('basedir '.$upload_dir['basedir']);
        // debug_to_myconsole('subdir '.$upload_dir['subdir']);
        // debug_to_myconsole('baseurl '.$upload_dir['baseurl']);
        // debug_to_myconsole(dirname(vrm360_basename($mdl)));
        $targetDir = ($upload_dir['basedir']);
        $filePath = $targetDir.'/tmp/'.vrm360_basename($mdl);
        // debug_to_myconsole('filePath='.$filePath);
        if (!file_exists("$targetDir/tmp")) mkdir ("$targetDir/tmp");
        // debug_to_myconsole('new dir'.$targetDir."/tmp");
        if (!copy($mdl, $filePath)) {
            warn_to_myconsole("failed to copy $mdl $filePath ...");
        }
        /* else {
            warn_to_myconsole("copied $mdl $filePath ...");
        }*/
        $zip = new ZipArchive;
        $res = $zip->open( $filePath );
        if ( $res === TRUE ) {
            for( $i = 0; $i < $zip->numFiles; $i++ ) {
                $file_to_extract = vrm360_basename( $zip->getNameIndex($i) );
                $f2e_path_parts = pathinfo($file_to_extract);
                $f2e_extension = mb_strtolower($f2e_path_parts['extension']);
                if (!in_array($f2e_extension, array('wrl','stl','fbx','obj','mtl','png','jpg','jpeg','gif','tga','bmp'))) continue;
                debug_to_myconsole('file to be extracted '.$zip->getNameIndex($i));
                if ( in_array($f2e_extension, array('wrl','stl','fbx','obj')) && !in_array($f2e_extension, array('mtl','png','jpg','jpeg','gif','tga','bmp'))) {
                    $file_found = true;
                    $file_to_extract = rawurlencode( vrm360_basename( $file_to_extract ) ) ;
                    // debug_to_myconsole('file extracted '.$file_to_extract);
                    $wp_filename =  $time.'_'.$file_to_extract ;
                    $zp_filename_url = $upload_dir_url.'/tmp/'.$file_to_extract;
                    // debug_to_myconsole('new url target file '.$zp_filename_url);
                }
                $zip->extractTo( "$targetDir/tmp", array( $zip->getNameIndex($i) ) );
            }
            $zip->close();
            if ( !$file_found ) {
                warn_to_myconsole( "Error!!! 3D model file MISSING !!!");
                die('error');
            }
            return $zp_filename_url;
        }
        else {
            warn_to_myconsole( "Error!!! Zip open failed !!!");
            die('error');
        }
    }  // end if class zip exists
    else {
            warn_to_myconsole( "Error!!! Zip extension MISSING !!!");
        }
} // end function zip
        
function vrmCustom_upload_mimes ( $existing_mimes=array() ) {
    $existing_mimes['obj'] = 'text/plain';
    $existing_mimes['mtl'] = 'text/plain';
    //$existing_mimes['dae'] = 'text/plain';
    $existing_mimes['fbx'] = 'application/bin';
    $existing_mimes['stl'] = 'text/plain';
    $mime_types['zip']  = 'application/zip';
    // $existing_mimes['dae'] = 'text/plain';
    $existing_mimes['wrl'] = 'model/vrml';
    return $existing_mimes;
}

add_filter( 'wp_check_filetype_and_ext', 'vrmCustom_multi_mimes', 99, 4 );

function vrmCustom_multi_mimes( $check, $file, $filename, $mimes ) {
    if ( empty( $check['ext'] ) && empty( $check['type'] ) ) {
        // mime needs to be pre-added
        $multi_mimes = [ [ 'stl' => 'text/plain' ], [ 'stl' => 'application/bin' ], [ 'fbx' => 'application/bin' ], [ 'fbx' => 'text/plain' ]];

        // Run new checks for our custom mime types and not on core mime types.
        foreach( $multi_mimes as $mime ) {
            remove_filter( 'wp_check_filetype_and_ext', 'vrmCustom_multi_mimes', 99, 4 );
            $check = wp_check_filetype_and_ext( $file, $filename, $mime );
            add_filter( 'wp_check_filetype_and_ext', 'vrmCustom_multi_mimes', 99, 4 );
            if ( ! empty( $check['ext'] ) ||  ! empty( $check['type'] ) ) {
                return $check;
            }
        }
    }
    return $check;
}

function debug_vrm_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.log( 'php_console_log: " . $output . "' );</script>";
}
function vrm360_shortcode($atts) {
    $vrm360_atts = shortcode_atts( array(
        'canvas_name' => 'first_canvas',
        'model_url' => 'your_full_obj_url',
        'aspect_ratio' => '1.3333',
        'img_hor_size' => '800',
        'speed' => '1.0',
        'autostart' => 'false',
        'hide_cmds' => 'false',
        'backgcolor' => '#D9D9D9',
        'mesh_color' => '#FF5533',
        'lightcolor' => '#FFFFFF',
        'lightintensity' => '0.9',
        'amb_lightcolor' => '#9D9D9D',
        'amb_lightintensity' => '0.9',
        'initial_offset' => '1.15',
        'rx' => '0.0',
        'ry' => '0.0',
        'rz' => '0.0',
        'lx' => '2.0',
        'ly' => '2.0',
        'lz' => '10.0',
        'info_text' => '',
        'info_link' => '',
        'back_image_url' => '',
        'ground' => 'false',
        'ground_color' => '#999999',
        'ground_offset' => '0.0',
        'grid' => 'false',
        'button_color' => '#99CC99',
        'border_color'  => '#D9D9D9',
        'border_width'  => '1',
        'debug' => 'false',
    ), $atts, 'vrm360' );

    $canvas_name = $vrm360_atts[ 'canvas_name' ];
    $canvas_nameR = $canvas_name.'R';
    $canvas_nameFS = $canvas_name.'FS';
    $canvas_nameF = $canvas_name.'F';
    $canvas_nameS = $canvas_name.'S';
    $canvas_nameSpin = $canvas_name.'Spin';
    $canvas_nameM = $canvas_name.'M';
    $canvas_nameZu = $canvas_name.'Zu';
    $canvas_nameZd = $canvas_name.'Zd';
    $backgcolor = $vrm360_atts[ 'backgcolor' ];
    $lightcolor = $vrm360_atts[ 'lightcolor' ];
    $lightintensity = $vrm360_atts[ 'lightintensity' ];
    $amb_lightcolor = $vrm360_atts[ 'amb_lightcolor' ];
    $amb_lightintensity = $vrm360_atts[ 'amb_lightintensity' ];
    $autostart = $vrm360_atts[ 'autostart' ];
    $initial_offset  = $vrm360_atts[ 'initial_offset' ];
    $info_text = $vrm360_atts[ 'info_text' ];
    $info_link = $vrm360_atts[ 'info_link' ];
    $back_image_url = $vrm360_atts[ 'back_image_url' ];
    $ground = $vrm360_atts[ 'ground' ];
    $ground_color = $vrm360_atts[ 'ground_color' ];
    $grid = $vrm360_atts[ 'grid' ];
    $ground_offset = $vrm360_atts[ 'ground_offset' ];
    $rx = $vrm360_atts[ 'rx' ];
    $ry = $vrm360_atts[ 'ry' ];
    $rz = $vrm360_atts[ 'rz' ];
    $lx = $vrm360_atts[ 'lx' ];
    $ly = $vrm360_atts[ 'ly' ];
    $lz = $vrm360_atts[ 'lz' ];
    $mesh_color = $vrm360_atts[ 'mesh_color' ];
    $plugin_url_path = plugin_dir_url( __FILE__ );
    $mainscript = $plugin_url_path.'js/main.js';
    
    $model_var_url = $vrm360_atts[ 'model_url' ];
    $query = "http";
    if (strpos($model_var_url, '.zip') !== false) {
        $model_url = unzip ($model_var_url);
    }
    //else if
    else if (substr($model_var_url, 0, strlen($query)) === $query) {
        $model_url = $model_var_url;
        }
    else {
        //only demo allowed
        $model_url = $plugin_url_path.'demo/'.$model_var_url; //.'.obj';
    }
    $aspectRatio_attr = "aspectRatio='".$vrm360_atts[ 'aspect_ratio' ]."'";
    $aspect_ratio = $vrm360_atts[ 'aspect_ratio' ];
    $img_hor_size = $vrm360_atts[ 'img_hor_size' ];
    $height = $img_hor_size/$vrm360_atts[ 'aspect_ratio' ];
    $purl=plugins_url();
    //$plugin_url_path = plugin_dir_url( __FILE__ );
    $bkg_loader=$plugin_url_path."ajax-loader-ripple.gif";
    //$over_loader=$plugin_url_path."dragtospin.png";
    $over_loader=$plugin_url_path."drag2spin.svg";
    //$pre_loader=$plugin_url_path."ajax-loader-spin.gif";
    $pre_loader=$plugin_url_path."ajax-loader.svg";
    $speed = $vrm360_atts[ 'speed' ];
    $hide_cmds = $vrm360_atts[ 'hide_cmds' ];
    $button_color = $vrm360_atts[ 'button_color' ];
    $border_color = $vrm360_atts[ 'border_color' ];
    $border_width = $vrm360_atts[ 'border_width' ].'px';
    $mesh_color = $vrm360_atts[ 'mesh_color' ];
    $debug_vrm = $vrm360_atts[ 'debug' ];
    $isOnMobile = 'false';
    if(isMobile()){
        $isOnMobile = 'true';
    }
    if ($border_width == '0px') {
        $div_content = "id='$canvas_nameS' class='$canvas_name' style='cursor:pointer; background-color: $backgcolor'";
        }
    else {
        $div_content = "id='$canvas_nameS' class='$canvas_name' style='cursor:pointer;border: $border_color; border-style:solid; border-width:$border_width; background-color: $backgcolor'";
    }
    if ($debug_vrm == 'true') {
        debug_vrm_to_console('model location: '.$model_url);
        debug_vrm_to_console('autostart:'.$autostart.';backgcolor:'.$backgcolor.';canvas_name:'.$canvas_name);
        debug_vrm_to_console('lightcolor:'.$lightcolor.';light_intensity:'.$lightintensity.';amb_lightcolor:'.$amb_lightcolor.';amb_light_intensity:'.$amb_lightintensity);
        debug_vrm_to_console('canvas_nameR:'.$canvas_nameR.';canvas_nameFS:'.$canvas_nameFS.';canvas_nameF:'.$canvas_nameF);
        debug_vrm_to_console('canvas_nameS:'.$canvas_nameS.';canvas_nameSpin:'.$canvas_nameSpin.';canvas_nameM:'.$canvas_nameM);
        debug_vrm_to_console('canvas_nameZu:'.$canvas_nameZu.';canvas_nameZd:'.$canvas_nameZd.';hide_cmds:'.$hide_cmds);
        debug_vrm_to_console('model_url:'.$model_url.';aspect_ratio:'.$aspect_ratio.';initial_offset:'.$initial_offset.';speed:'.$speed);
        debug_vrm_to_console('info_text:'.$info_text.';info_link:'.$info_link.';ground:'.$ground.';ground_offset:'.$ground_offset);
        debug_vrm_to_console('rx:'.$rx.';ry:'.$ry.';rz:'.$rz.';grid:'.$grid.';back_image_url:'.$back_image_url);
        debug_vrm_to_console('lx:'.$lx.';ly:'.$ly.';lz:'.$lz.';isOnMobile:'.$isOnMobile);
        debug_vrm_to_console('mesh_color:'.$mesh_color.';ground_color:'.$ground_color.';debug_vrm:'.$debug_vrm);
    }
    
    return "
    <div class='imgover'>
    <div class='container'>
    <style>
        /*[class^=\"icovrm-\"], [class*=\" icovrm-\"]  {*/
        [class^=\"icovrm-\"], [class*=\" icovrm-\"] {
            color:$button_color;
        }
    </style>
    <i id='$canvas_nameF' class='icovrm-img icon-ion-android-locate' ></i>
    <i id='$canvas_nameR' class='icovrm-img icon-ion-loop' ></i>
    &nbsp;
    <i id='$canvas_nameZu' class='icovrm-img icon-ion-arrow-up-b' ></i>
    <i id='$canvas_nameZd' class='icovrm-img icon-ion-arrow-down-b' ></i>
    &nbsp;
    &nbsp;
    <i id='$canvas_nameFS' class='icovrm-img icon-ion-android-expand' ></i>
    <!-- i id='$canvas_nameFS' class='icovrm-img icon-ion-android-contract' ></i -->
    <!-- i id='icovrm icon-refresh' 'icovrm icon-ion-desktop'></i -->
    <div id='$canvas_nameSpin'>
        <img class='imgpreloader' src='$over_loader'>
        <img class='imgpreloader' src='$pre_loader'/>
        <!-- changed svg viewBoxinside the svgs -->
    </div>
    <div $div_content>
    </div>
    </div>
    </div>
    <script>
    var autostart = $autostart, backgcolor = '$backgcolor', canvas_name = '$canvas_name';
    var lightcolor = '$lightcolor', light_intensity = $lightintensity, amb_lightcolor = '$amb_lightcolor', amb_light_intensity = $amb_lightintensity;
    var canvas_nameR = '$canvas_nameR', canvas_nameFS = '$canvas_nameFS', canvas_nameF = '$canvas_nameF';
    var canvas_nameS = '$canvas_nameS', canvas_nameSpin = '$canvas_nameSpin', canvas_nameM = '$canvas_nameM';
    var canvas_nameZu = '$canvas_nameZu', canvas_nameZd = '$canvas_nameZd', hide_cmds = '$hide_cmds';
    var model_url = '$model_url', aspect_ratio = '$aspect_ratio', initial_offset = '$initial_offset', speed = '$speed';
    var touchtime = 0, info_text = '$info_text', info_link = '$info_link', ground= $ground, ground_offset = $ground_offset;
    var rx = $rx, ry = $ry, rz = $rz, grid= $grid, back_image_url = '$back_image_url';
    var lx = $lx, ly = $ly, lz = $lz, isOnMobile = '$isOnMobile';
    var mesh_color = '$mesh_color', ground_color = '$ground_color', debug_vrm = '$debug_vrm';
    </script>
    <script src='$mainscript'/></script>
    "
;}


// register shortcode
function vrm360_register_shortcode() {
    add_shortcode( 'vrm360', 'vrm360_shortcode' );
}

add_action( 'init', 'vrm360_register_shortcode' );

?>
