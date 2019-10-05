// <![CDATA[
var main_version = "1.2.0"
var jsbackcolor = parseInt ( backgcolor.replace('#','0x'), 16 );
var groundcolor = parseInt ( ground_color.replace('#','0x'), 16 );
var light_color = parseInt ( lightcolor.replace('#','0x'), 16 );
var amb_light_color = parseInt ( amb_lightcolor.replace('#','0x'), 16 );


jQuery(document).ready(function($) {
   //jQuery('head').append('<meta name=\'viewport\' content=\'width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0\'/>');
   //required for two finger zooming
   setTimeout(function() { jQuery('.imgloader').fadeOut('slow'); // hide();
       }, 3000);
   // console.log('here');

});
if ((info_text.length > 0)) {
    jQuery('#'+canvas_nameSpin).append("<a class=\"modellink\" href=\""+info_link+"\">"+info_text+"</a>");
    }
// full-screen available?
fsa=false;
rotate=false;
// autostart = $autostart;
if ( document.fullscreenEnabled || document.webkitFullscreenEnabled || document.mozFullScreenEnabled || document.msFullscreenEnabled )
{
    fsa=true; /*console.log('full screen available');*/
}

/* document.body.addEventListener("keydown", function() {
  // if (!document.fullscreenElement) {
  //     elem.requestFullscreen().then({}).catch(err => {
  //     alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
  //     });
  // }
  //THREEx.FullScreen.request(); // for the doc
  divS = document.getElementById(cname);
  THREEx.FullScreen.request(divS); //for the element
}, false);  */

jQuery(function(){
    if (fsa==true) {
        // jQuery('#$canvas_nameFS').click(function(e){ e.preventDefault();jQuery('.$canvas_name').spritespin('api').requestFullscreen(); });
        jQuery('#'+canvas_nameFS).attr('title', 'full screen');
    }
    else {
        jQuery('#'+canvas_nameFS).hide();
    }
    //jQuery('#'+canvas_nameFS).hide(); //forcing FS button hide
    jQuery('#'+canvas_nameR).click(function(e){
        // console.log('Run-'+canvas_name);
        rotate = !rotate;
        });
        // jQuery('.$canvas_name').spritespin('api').data.reverse=!jQuery('.$canvas_name').spritespin('api').data.reverse;jQuery('.$canvas_name').spritespin('api').startAnimation(); });
        jQuery('#'+canvas_nameR).attr('title', 'run stop');
        jQuery('#'+canvas_nameZu).attr('title', 'zoom up');
        jQuery('#'+canvas_nameZd).attr('title', 'zoom down');
        if (hide_cmds=='all') {
            jQuery('#'+canvas_nameFS).hide();
            jQuery('#'+canvas_nameR).hide();
            jQuery('#'+canvas_nameF).hide();
            jQuery('#'+canvas_nameZu).hide();
            jQuery('#'+canvas_nameZd).hide();
        }
        if (hide_cmds.includes('fullscreen')) {
            jQuery('#'+canvas_nameFS).hide();
        }
        if (hide_cmds.includes('run')) {
            jQuery('#'+canvas_nameR).hide();
        }
        jQuery('#'+canvas_nameF).attr('title', 'zoom fit');
        if (hide_cmds.includes('fit')) {
            jQuery('#'+canvas_nameF).hide();
        }
        if (hide_cmds.includes('zoom')) {
            jQuery('#'+canvas_nameZu).hide();
            jQuery('#'+canvas_nameZd).hide();
        }
        if (hide_cmds=='on_mobile') {
            if (debug_vrm == 'true') {console.log('onmobile '+isOnMobile);}
            if(isOnMobile == 'true') {
                jQuery('#'+canvas_nameFS).hide();
                jQuery('#'+canvas_nameR).hide();
                jQuery('#'+canvas_nameF).hide();
                jQuery('#'+canvas_nameZu).hide();
                jQuery('#'+canvas_nameZd).hide();
            }
        }
        var pathVar = model_url;
        // console.log(pathVar+' model');
        // pathVar=pathVar+'{frame}.jpg';
        // pathVar=pathVar+'{frame}'+'$img_ext';
        // console.log(model_url);
        // console.log(pathVar);
        // console.log('$test_file');
        // console.log('$bkg_loader');
        cname = canvas_nameS;
        ar = aspect_ratio;
        // initial_offset = '$initial_offset'; //1.15;
        init( pathVar, cname, ar, initial_offset, ground);
        offs = 1.0;
        //offs = 1.0; 
        //speed = $speed;
        animate();
        jQuery('#'+canvas_nameF).click(function(e){
            // console.log('Fit-'+canvas_name);
            rotate = false;
            zoom_refit (offs);
            // setTimeout(function() { jQuery('.imgpreloader').fadeOut('slow'); // hide();
            //      }, 3000);
            });
        jQuery('#'+canvas_nameFS).click(function(e){
            // console.log('FullScreen-'+canvas_name);
            // var c = document.getElementById(cname);
            // var rect = c.getBoundingClientRect();
            // // c.width = rect.width;
            // // c.height = rect.height;
            // c.width = window.innerWidth;
            // c.height = window.innerHeight;
            // console.log('FullScreen-'+c.width+' h'+c.height);
            // goFS(canvas_nameS);
            divIdS = document.getElementById(canvas_nameS);
            // http://learningthreejs.com/data/THREEx/docs/THREEx.FullScreen.html
            THREEx.FullScreen.request(divIdS); //for the element
            });
        jQuery('#'+canvas_nameZu).click(function(e){
            // console.log('Zu '+canvas_name);
            zoom (0.8)
            // zoom up
            });
        jQuery('#'+canvas_nameZd).click(function(e){
            // console.log('Zd '+canvas_name);
            zoom (1.25)
            // zoom down
            });
        //jQuery('.$canvas_name').append(container); // insering threejs canvas
        // jQuery('head').append('');
    });  // end of main function
// var touchtime = 0; 
var clicknbr = 0; var dly = 150;

jQuery('.'+canvas_name).on('dblclick', function() {
    // console.log('double clicked');
    rotate = 0;
    zoom_refit (1.0);
});    
//jQuery('.'+canvas_name).on('click', function() {
jQuery('.'+canvas_name).on('mousedown', function() {
    // console.log('clicked');
    touchtime = new Date().getTime();
});
jQuery('.'+canvas_name).on('mouseup', function() {
    // console.log('release');
    if (((new Date().getTime())-touchtime) < 1.5*dly) {
        // console.log('single click');
        rotate = !rotate;
    }
    touchtime = 0;
});

    
//var clicknbr = 0; var dly = 300;
// jQuery('.'+canvas_name).on('click', function() {
//     if(touchtime == 0) {
//         //set first click
//         touchtime = new Date().getTime();
//         clicknbr = 1;
//         setTimeout(function() { 
//             if(touchtime != 0) {
//                 if (((new Date().getTime())-touchtime) < 1.5*dly) {
//                     console.log('single click timeout');
//                     touchtime = new Date().getTime();
//                     rotate = !rotate;
//                     touchtime = 0;
//                 }
//             }
//         },  1.5*dly);  //ms
//     } 
//     else {
//         //compare first click to this click
//         if(((new Date().getTime())-touchtime) < dly) {
//             //double click occurred
//             console.log('double clicked');
//             rotate = 0;
//             zoom_refit (1.0);
//             touchtime = 0;
//         }
//         // else {
//         //     //not a double click so set as a new first click
//         //     console.log('single click');
//         //     touchtime = new Date().getTime();
//         //     rotate = !rotate;
//         //     touchtime = 0;
//         // }
//     }
// });

// ]]>
