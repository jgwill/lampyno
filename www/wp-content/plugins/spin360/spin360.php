<?php
/*
Plugin Name: Spin360
Plugin URI:  https://easyw.github.io/spin360/
Description: A new plugin to add 360 rotation support in wp
Version:     1.2.6
Author:      Maurice
Author URI:  https://github.com/easyw/spin360
License:     GPL2License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('SPIN360_PLUGIN_MAIN', __FILE__);
define('SPIN360_PLUGIN_PATH', plugin_dir_path(__FILE__));

// define spin360 folder in uploads
function spin360_upl_folder() {
    $wp_uploads = wp_upload_dir();
    $products_path = $wp_uploads['basedir'].'/spin360show/';
    define('SPIN360_UPLOAD_PATH', $products_path);
    $products_url = $wp_uploads['baseurl'].'/spin360show/';
    define('SPIN360_UPLOAD_URL', $products_url);
    }


// add_action('wp_enqueue_scripts', 'check_font_awesome', 99999);

function check_font_awesome() {
  global $wp_styles;
  $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src') );
  // print_r($srcs);
  if ( in_array('spin-style.css', $srcs) || in_array('spin-style.css', $srcs)  ) {
    /* echo 'font-awesome.css registered'; */
  } else {
    //wp_enqueue_style('font-awesome', get_template_directory_uri() . '/font-awesome.css' );
    //wp_register_style( 'spin360-font-awesome', plugins_url( 'spin360/css/spin-style.css' ) );
    wp_register_style( 'spin360-font-awesome', plugins_url( 'css/spin-style.css', __FILE__) );
    wp_enqueue_style( 'spin360-font-awesome' );
    // wp_enqueue_style('font-awesome', plugins_url('font-awesome.min.css', __FILE__) );
  }
}

// rate plugin link
function add_spin360_links($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $supp_url = 'https://wordpress.org/support/plugin/' . basename(dirname(__FILE__));
        $links[] = '<a target="_blank" href="'. $supp_url .'" title="Click here to ask for support on this plugin on WordPress.org">Ask for Support</a>';
        $rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . basename(dirname(__FILE__)) . '?rate=5#postform';
        $links[] = '<a target="_blank" href="'. $rate_url .'" title="Click here to rate and review this plugin on WordPress.org">Rate this plugin</a>';
        $alt_url = 'https://wordpress.org/plugins/vrm360/';
        $links[] = '<a target="_blank" href="'. $alt_url .'" title="Discover an alternative 3D model viewer plugin">Vrm360 3D viewer</a>';
        $wp_uploads = wp_upload_dir();
        $upl_url = $wp_uploads['baseurl'].'/spin360show/';
        $links[] = 'spin360show location: <b>'.$upl_url.'</b>';
    }
    return $links;
}
add_filter('plugin_row_meta', 'add_spin360_links', 10, 2);

// register spin360 scripts and styles
function spin360_enqueue_scripts() {
    // wp_register_script( 'spritespin-js', plugins_url('spritespin.min.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'spritespin.min.js', plugins_url('scripts/spritespin.min.js', __FILE__), array('jquery') );
    wp_enqueue_script( '_panzoom.js', plugins_url('scripts/_panzoom.js', __FILE__), array('jquery') );
    wp_enqueue_style( 'spin360-style', plugins_url('spin360.css', __FILE__) );
    check_font_awesome();
    // wp_enqueue_script( 'spin360.js', plugins_url('spin360.js', __FILE__) );
    // if ( is_singular() ) { wp_enqueue_style('spin360-font-awesome', plugins_url('font-awesome.min.css', __FILE__) );}
    }

add_action( 'wp_enqueue_scripts', 'spin360_enqueue_scripts' );
spin360_upl_folder();

//in wordpress admin area
if (is_admin())
    {
        include_once SPIN360_PLUGIN_PATH.'spin360act.php';
        new spin360activation();
    }

function is_200($url)
{
    $options['http'] = array(
        'method' => "HEAD",
        'ignore_errors' => 1,
        'max_redirects' => 0
    );
    $body = file_get_contents($url, NULL, stream_context_create($options));
    sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $code);
    return $code === 200;
}

/*
 * spin360 shortcode generator.
 */
function spin360_shortcode($atts) {
    $spin360_atts = shortcode_atts( array(
        'canvas_name' => 'first_canvas',
        'imgs_folder' => 'spin360demo/',
        'img_type' => 'jpg',
        'aspect_ratio' => '1.3333',
        'img_hor_size' => '800',
        'imgs_nbr' => '100',
        'speed' => '1',
        'loop' => 'true',
        'autostart' => 'true',
        'gesture' => 'horizontal',
        'hide_cmds' => 'false',
        //'zoom' => 'false',
        'button_color' => '#00ABFF',
    ), $atts, 'spin360' );

    $canvas_name = $spin360_atts[ 'canvas_name' ];
    $canvas_nameR = $canvas_name.'R';
    $canvas_nameFS = $canvas_name.'FS';
    $canvas_nameS = $canvas_name.'S';
    $canvas_nameZu = $canvas_name.'Zu';
    $canvas_nameZd = $canvas_name.'Zd';
    $canvas_nameZR = $canvas_name.'ZR';
    $folder = "imgs_folder='".$spin360_atts[ 'imgs_folder' ]."'";
    // $folder_url = SPIN360_UPLOAD_URL.$spin360_atts[ 'imgs_folder' ];
    $folder_var_url = $spin360_atts[ 'imgs_folder' ];
    $query = "http";
    if (substr($folder_var_url, 0, strlen($query)) === $query) {
        $folder_url = $folder_var_url;
        }
    else {
        $folder_url = SPIN360_UPLOAD_URL.$spin360_atts[ 'imgs_folder' ];
        }
    $folder_url = rtrim($folder_url, '\\') . '/';
    $folder_url = rtrim($folder_url, '/') . '/'; //verifying last dir separator
    $imgs_nbr = $spin360_atts[ 'imgs_nbr' ];
    $img_type = $spin360_atts[ 'img_type' ];
    $img_ext='.jpg';
    if ($img_type == 'png') {
        $img_ext='.png';
    }
    $img_hor_size = $spin360_atts[ 'img_hor_size' ];
    $aspectRatio_attr = "aspectRatio='".$spin360_atts[ 'aspect_ratio' ]."'";
    $height = $img_hor_size/$spin360_atts[ 'aspect_ratio' ];
    $purl=plugins_url();
    $plugin_url_path = plugin_dir_url( __FILE__ );
    $bkg_loader=$plugin_url_path."ajax-loader-sm.svg";
    // $bkg_loader=$plugin_url_path."ajax-loader-ripple.gif";
    $over_loader=$plugin_url_path."dragtospin.png";
    $speed = $spin360_atts[ 'speed' ];
    $sense = 1;
    if ($speed < 0)
        $sense = -1;
    if (abs($speed) > 10)
        $speed=10;
    if (abs($speed) < 0.1)
        $speed=0.1;
    $frame_time = 40/abs($speed);
    $loop = $spin360_atts[ 'loop' ];
    $hide_cmds = $spin360_atts[ 'hide_cmds' ];
    $autostart = $spin360_atts[ 'autostart' ];
    $gesture = $spin360_atts[ 'gesture' ];
    $button_color = $spin360_atts[ 'button_color' ];
    if ($gesture == 'vertical') {
        $over_loader=$plugin_url_path."dragtospin-vert.png";
    }
    return "
    <div class='imgover'>
    <div class='container'>
    <style>
        [class^=\"icon-\"], [class*=\" icon-\"]  {
            color:$button_color;
        }
    </style>
    <i id='$canvas_nameR' class='icospin-img icon-ion-loop' ></i>
    
    <i id='$canvas_nameZu' class='icospin-img icon-ion-arrow-up-b' ></i>
    <i id='$canvas_nameZR' class='icospin-img icon-ion-zoom-reset' ></i>
    <i id='$canvas_nameZd' class='icospin-img icon-ion-arrow-down-b' ></i>
    &nbsp;&nbsp;
    <i id='$canvas_nameFS' class='icospin-img icon-ion-android-expand' ></i>
    
    <img class='imgloader' src='$over_loader'>
        <div id='$canvas_nameS' class='$canvas_name' style='cursor:pointer;' >
        </div>
    </div>
    </div>
    <style>
        .spritespin-instance.loading {
            background: url(\"$bkg_loader\");
            background-position: 50% 50%;
            background-repeat: repeat-y; }
            /*background-repeat: no-repeat; }*/
    </style>
    <script type='text/javascript'>// <![CDATA[
       jQuery(document).ready(function($) {
        setTimeout(function() { jQuery('.imgloader').fadeOut('slow'); // hide();
            }, 3000);
        });
       // full-screen available?
       fsa=false;
       if (
            document.fullscreenEnabled ||
            document.webkitFullscreenEnabled ||
            document.mozFullScreenEnabled ||
            document.msFullscreenEnabled
        )
          {
           fsa=true; /*console.log('full screen available');*/
          }
       jQuery(function(){ //document ready
           jQuery('#$canvas_nameZd').hide();
           if (fsa==true) {
               jQuery('#$canvas_nameFS').click(function(e){ 
                e.preventDefault();
                sc = 1; // forcing standard Ratio for FS
                var data = jQuery('.$canvas_name').spritespin('data');
                data.canvasRatio = window.devicePixelRatio * sc;
                SpriteSpin.applyLayout(data);
                SpriteSpin.updateFrame(data);
                data.stage.show();
                jQuery('.$canvas_name').spritespin('api').requestFullscreen(); 
                });
                
               jQuery('#$canvas_nameFS').attr('title', 'full screen');
            }
           else {jQuery('#$canvas_nameFS').hide();}
           jQuery('#$canvas_nameR').click(function(e){ // console.log('$canvas_name');
           jQuery('.$canvas_name').spritespin('api').data.reverse=!jQuery('.$canvas_name').spritespin('api').data.reverse;jQuery('.$canvas_name').spritespin('api').startAnimation(); });
           jQuery('#$canvas_nameR').attr('title', 'reverse play direction');
           if ('$hide_cmds'=='all') {
              jQuery('#$canvas_nameFS').hide();
              jQuery('#$canvas_nameR').hide();
              jQuery('#$canvas_nameZu').hide();
              jQuery('#$canvas_nameZR').hide();
           }
           if ('$hide_cmds'.includes('fullscreen')) {
              jQuery('#$canvas_nameFS').hide();
           }
           if ('$hide_cmds'.includes('reverse')) {
              jQuery('#$canvas_nameR').hide();
           }
           if ('$hide_cmds'.includes('zoom')) {
              jQuery('#$canvas_nameZu').hide();
              jQuery('#$canvas_nameZR').hide();
           }
           var pathVar = '$folder_url';
           pathVar=pathVar+'{frame}'+'$img_ext';
           //spritespin instance
           jQuery('.$canvas_name').spritespin({width: '$img_hor_size', height: '$height', source: SpriteSpin.sourceArray(pathVar, { frame: [1,'$imgs_nbr'], digits: 4 }), sense: 1, responsive: true,
                    loop: $loop, frameTime: '$frame_time', animate: $autostart, orientation: '$gesture'});
           // orientation: 'vertical', //'horizontal', //vertical value will make animation on mouse up/dowm movenemt    
           if ( '$sense' == '-1' )
                {
                    jQuery('.$canvas_name').spritespin('api').data.reverse=!jQuery('.$canvas_name').spritespin('api').data.reverse;
                }
           //panzoom-init
           jQuery('.spritespin-canvas').panzoom({
                    panOnlyWhenZoomed: true,
                    //disablePan: true,
                    duration: 200, // duration of the zoom to effect
                    easing: 'ease-in-out', // type of zoom animation
                    //contain: 'invert',
                    minScale: 1,
                    increment: .5,
                    maxScale: 5,
                    linearZoom: true,
                    which: 1, // changing this values makes pan possible on right lcick of mouse value : 1(left),2(middle),3(right clcik)
                    // Pan only on the X or Y axes
                    disableXAxis: false,
                    disableYAxis: false,
                    _zoomIn: jQuery('#$canvas_nameZu'), // .zoom-in-1'),
                    _zoomOut: jQuery('#$canvas_nameZd'), //.zoom-out-1'),
                    _reset: jQuery('#$canvas_nameZR'), //.reset-1'),
                    // _zoomRange: jQuery('.zoom-range'),
                    onStart: undefined,
                    onChange: function(){},
                    onZoom: undefined,
                    onPan: undefined,
                    onEnd: function(){},
                    onReset: function(){}
                });
                //end panzoom instance
            var panzoom1 = jQuery('.spritespin-canvas').panzoom('instance');
            
           }); //end document ready function
           document.addEventListener('fullscreenchange', function() {
                //console.log('fullscreenchange event fired!');
                var state = document.fullScreen || document.mozFullScreen || document.webkitIsFullScreen;
                var event = state ? 'FullscreenOn' : 'FullscreenOff';
                //console.log(event,state);
                if (event == 'FullscreenOff') {
                    jQuery('#$canvas_nameZR').trigger( 'click' );
                    // console.log('fullscreen Off event fired!');
                }
            });
           var touchtime = 0;
           jQuery('.$canvas_name').on('click', function() {
               if(touchtime == 0) {
                   //set first click
                   touchtime = new Date().getTime();
               } else {
                   //compare first click to this click
                   if(((new Date().getTime())-touchtime) < 300) {
                       //double click occurred
                       jQuery('.$canvas_name').spritespin('api').data.reverse=!jQuery('.$canvas_name').spritespin('api').data.reverse;
                       jQuery('.$canvas_name').spritespin('api').startAnimation();
                       touchtime = 0;
                   } else {
                       //not a double click so set as a new first click
                       jQuery('.$canvas_name').spritespin('api').stopAnimation();
                       touchtime = new Date().getTime();
                   }
               }
           });
           // Whatch fullscreen
           function exitFS() {
             if(document.exitFullscreen) {
               document.exitFullscreen();
             } else if(document.mozCancelFullScreen) {
               document.mozCancelFullScreen();
             } else if(document.webkitExitFullscreen) {
               document.webkitExitFullscreen();
             }
           } //end function
           jQuery(window).on('orientationchange',function(){
              if( fsa == true ) {
                  jQuery('#$canvas_nameZR').trigger( 'click' );
                  exitFS();
              }
           });
            jQuery('#$canvas_nameZu').on('click', function() { 
                mtx = jQuery('#$canvas_nameS').find('.spritespin-canvas').panzoom('getMatrix');
                sc = mtx[0];
                if (sc > 2) {sc=2;}
                // console.log('onpanzoom scale',sc);
                var data = jQuery('.$canvas_name').spritespin('data');
                data.canvasRatio = sc * window.devicePixelRatio;
                SpriteSpin.applyLayout(data);
                SpriteSpin.updateFrame(data);
                data.stage.show();
                });
            jQuery('#$canvas_nameZR').on('click', function() { 
                mtx = jQuery('#$canvas_nameS').find('.spritespin-canvas').panzoom('getMatrix');
                sc = mtx[0];
                if (sc > 2) {sc=2;}
                // console.log('onpanzoom scale',sc);
                var data = jQuery('.$canvas_name').spritespin('data');
                data.canvasRatio = sc * window.devicePixelRatio;
                SpriteSpin.applyLayout(data);
                SpriteSpin.updateFrame(data);
                data.stage.show();
                });
                
    // ]]></script>
    "
;}


// register shortcode
function spin360_register_shortcode() {
    add_shortcode( 'spin360', 'spin360_shortcode' );
}

add_action( 'init', 'spin360_register_shortcode' );

?>
