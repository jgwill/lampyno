=== Spin 360 deg and 3D Model Viewer ===
Contributors: maui2wp
Donate link: 
Tags: 360 deg viewer, 3d viewer, 3D model viewer, 3d model display, 3D Model Viewer WordPress, 360, 360 product view, 360 product viewer, 3d product viewer, 3d, 360 product rotation
Requires at least: 4.0.1
Tested up to: 5.2
Stable tag: 1.2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin to add 360 rotation support and 3d view animation in wordpress using shortcodes;
Responsive Web Design; 
3D model Rotation, 360 degrees view.

== Description ==

A featured plugin to add 360 degrees and 3d animate view in wordpress using shortcodes
Responsive Web Design
Displays 3D model on wordPress page, post, or custom page
3D model Rotation enabled
Based on a sequence of images (jpg or png) to animate and display the product
Transparency available for png images
Zoom option (best viewed on fullscreen)
Images can be generated with Blender animation
Photography turntable ready

Looking for a 3D model (obj, stl, wrl, fbx format) full rotation & zoom plugin? 
Try the <a href="https://wordpress.org/plugins/vrm360/" target="_blank">Vrm360 wordpress 3D plugin</a>

####Demo####
<a href="https://easyw.github.io/spin360/" target="_blank">Live Demo 3D</a>

[Sample 3D project](https://easyw.github.io/spin360/spin360demo.zip "3d viewer sample")

<a href="https://www.robit.com/gallery/" target="_blank">User Case Gallery</a>

<a href="https://remcorheeproducties.nl/online/#productpresentatie" target="_blank">User Case e-commerce</a>

Download Wordpress Plugin page: <a href="https://wordpress.org/plugins/spin360/" target="_blank">wordpress plugins spin360 page</a>

GitHub Wordpress Plugin: https://github.com/easyw/spin360

jQuery plugin page: http://spritespin.ginie.eu/

<a href="https://easyw.github.io/spin360/" target="_blank">Live Demo 3D</a>

####Plugin Features####
* 3D model Display
* 360 deg and 3D view enabled
* Photography turntable ready 
* ShortCodes System
* Very Lightweight

== Installation ==

1. Upload the plugin files to the `your_wordpress_plugins_dir/spin360` directory, or Install as a regular WordPress plugin
2. Go your Plugins page via WordPress Dashboard and activate it
3. Use these shortcodes to post or page


   <code>[spin360 canvas_name=&#34;s1&#34; imgs_folder=&#34;my_product/&#34; imgs_nbr=100 aspect_ratio=1.33333 speed=1.0 loop=true]</code>

   <code>[spin360 canvas_name=&#34;s1&#34; imgs_folder=&#34;spin360demo/&#34; imgs_nbr=48 aspect_ratio=1.33333]</code>
   
   <code>[spin360 canvas_name=&#34;s1&#34; imgs_folder=&#34;spin360demo/&#34; imgs_nbr=100 autostart=false gesture=vertical]</code>
   
   <code>[spin360 canvas_name=&#34;s1&#34; imgs_folder=&#34;spin360demo/&#34; imgs_nbr=36 hide_cmds=all]</code>
   
   defaults: <code>canvas_name=&#34;s1&#34;, aspect_ratio=1.33333, speed=-1.0, loop=true hide_cmds=zoom,fullscreen</code>

   **Be sure to use the HTML editor when inserting shortcodes!**
   
   **check that your Quotation marks are exactly the correct symbol (Alt 34)**
   
4. Use `jpg` or `png` image files to display your model as a dynamic sequence; 

   Name your images as following: `0001.jpg, 0002.jpg, ..., 0048.jpg (4 digits name)`
   
   for `png` as following: `0001.png, 0002.png, ..., 0048.png (4 digits name)` and add `img_type=png` to your shortcode
   
   **NB** `.jpg` or `.png` extension MUST be lowercase
   
   <code>[spin360 canvas_name=&#34;s1&#34; imgs_folder=&#34;spin360demo/&#34; imgs_nbr=36 img_type=png]</code>
   
   for 3D models the image sequence can be generated using **Blender** turntable animation
   
   upload your project image files in a `your_wordpress_uploads_dir/spin360show` subfolder 
   
   (i.e `"your_wordpress_uploads_dir/spin360show/my_product/"`) via a standard FTP access
   
   NB: for multisite add `/sites/#blog_id/` to path `your_wordpress_uploads_dir/sites/2/spin360show`

5. Modify the css style to adapt some features
   * change `css/spin-style.css` to change some style aspect

6. click to stop animation, click and hold to drag, double click to restart or invert sense of animation

Shortcode Parameters:

* canvas_name = canvas name needed in case of multiple shows on the same page (required)
* imgs_folder = folder of image sequence project; i.e.: `"spin360demo/"` or `"my_product"` (required)
* imgs_nbr = any number > 1; i.e.: 100 image screenshots (required)

  Note: name your images as following: `0001.jpg, 0002.jpg, ..., 0100.jpg (4 digits name)`
  or for png as following: `0001.png, 0002.png, ..., 0100.png (4 digits name)` and add `img_type=png` to your shortcode
  Don't mix up jpg with png image types on the same project folder.
* speed = any number > 0.1 and < 10; i.e.: 1.5; Negative values will start the animation reversed
* aspect_ratio = any number i.e.: 1.3333  for 4/3 aspect ratio
* change `css/spin-style.css` to adapt some style aspect (as loading image or button font color)
* loop = true or false (default is true)
* autostart = true or false (default is true) auto start the animation on load
* gesture = 'horizontal' (default) will make animation on mouse left/right movement; 'vertical' value will make animation on mouse up/dowm movement
* hide_cmds = all, fullscreen, reverse, zoom or false  (default is false)
* button_color = '#00ABFF' (default) HTML color values

== Frequently asked questions ==
= Display 3D model on wordPress page, post, or custom page  =
= 3D model Rotation, 360 view enabled, based on image sequences  =
* Fully **Responsive design**; works on **mobile devices**; 
* **click** to STOP;
* **click and hold** to DRAG; 
* **doubleclick** to RESTART; 
* **speed parameter**, **loop=true/false**, **full screen** optimization

* in case you have trouble in FTP your image folders under the folder `your_wordpress_uploads_dir/spin360show`, check the `spin360show` folder permissions or just delete it and make a new one
* for multisite add `/sites/#blog_id/` to path `your_wordpress_uploads_dir/sites/2/spin360show`
* shortcode support for alternative location of your 360 product images; valuable when you need to host image assets on a dedicated file server or CDN; just place your full folder location path in `"imgs_folder"` shortcode variable
* be sure to use the HTML editor when inserting shortcodes
* to have **many spinning images or to resize the image** in the page, it is possible to use the shortcode inside i.e. a table and set the cell dimension of the table. That will force the plugin to resize itself to the cell size
* Check if your Quotation marks are exactly the correct symbol (Alt 34) https://usefulshortcuts.com/alt-codes/punctuation-alt-codes.php
* **clear your site cache** after a plugin update
* in case of use of "minify HTML" plugin, don't enable compression for inline scripts

== Upgrade Notice ==

= 1.2.6 =
* better zoom resolution
* zoom option
* buttons color on shortcode
* autostart option added
* png and transparency supported
* CDN full url support
* multisite support
* hide_cmds option to hide command buttons
* loop option for single run
* removed dbg msg on activation
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* onrotation event on fullscreen
* shortcodes and multiple shows on a single page/post
* speed parameter (negative values allowed)
* preloader
* improved readme
* fixing server side asp.net 'comment bug'

== Screenshots ==

1. Screenshot-1.png
2. Screenshot-2.png
3. Screenshot-3.png
4. Screenshot-4.png
5. Screenshot-5.png


== Changelog ==

= 1.2.6 =
Stable release with better zoom resolution, autostart, png and transparency allowed, multisite & CDN support support. Click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme, fixing server side comment bug, fixing zoom hide when 'all' is selected

= 1.2.5 =
Stable release with zoom option, autostart, png and transparency allowed, multisite & CDN support support. Click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme, fixing server side comment bug, fixing zoom hide when 'all' is selected

= 1.2.1 =
Stable release with autostart option, png and transparency allowed, multisite & CDN support support. Click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme

= 1.2.0 =
Stable release with png and transparency allowed, multisite & CDN support support. Click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme

= 1.1.8 =
Stable release with multisite & CDN support support. Click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme

= 1.1.7 =
Stable release with multisite. Click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme

= 1.1.6 =
Stable release with click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization, hide commands and start reversed 
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation 
improved readme

= 1.1.5 =
Stable release with click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'ask for support' and 'rate this plugin' link, removed dbg msg on activation
improved readme

= 1.1.4 =
Stable release with click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
loop option, natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'rate this plugin' link, removed dbg msg on activation

= 1.1.3 =
Stable release with click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'rate this plugin' link, removed dbg msg on activation

= 1.1.2.1 =
Stable release with click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader, 'rate this plugin' link
= 1.1.2 =
Stable release with click, doubleclick and onrotation event; shortcode, multiple shows, relative upload folder path,
natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader
= 1.1.1 =
Stable release with shortcode, multiple shows, relative upload folder path,
natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons, 
drag tips and better ajax preloader
= 1.1.0 =
Stable release with shortcode, multiple shows, relative upload folder path,
natural sense of interaction, speed parameter, tooltips, full screen optimization
folder name without slash, subset of font-awesome and ionicons buttons 
= 1.0.11 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
with natural sense of interaction, speed parameter, tooltips, 
full screen (fix for osx, chrome both desktop and mobile),
no more need to have '/' at the end of folder name, subset of font-awesome and ionicons buttons 
= 1.0.10 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
with natural sense of interaction, font-awesome buttons, speed parameter, tooltips, 
full screen (fix for osx, chrome both desktop and mobile),
no more need to have '/' at the end of folder name
= 1.0.9 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
with natural sense of interaction, font-awesome buttons, speed parameter, tooltips, 
full screen (fix for osx, chrome both desktop and mobile)
= 1.0.8 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
with natural sense of interaction, font-awesome buttons, speed parameter, tooltips, full screen
= 1.0.7 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
with natural sense of interaction, font-awesome buttons
= 1.0.6 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
with natural sense of interaction
= 1.0.5 =
Basic version with shortcode and multiple shows, relative upload folder path and Play button
= 1.0.4 =
Basic version with shortcode and multiple shows, with relative upload folder path
= 1.0.3 =
Basic version with shortcode and multiple shows, still under development
= 1.0.2 =
Basic version with shortcode, still under development
= 1.0.1 =
Basic version updated, still under development
= 1.0 =
Basic version, still under development
