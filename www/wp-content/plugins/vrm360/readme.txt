=== Vrm 360 3D Model Viewer ===
Contributors: maui2wp
Donate link: 
Tags: 360 deg viewer, 3d viewer, 3D model viewer, 3d model display, 360 product viewer, 3d product viewer, 3d, 360 product rotation, obj, mtl, stl, wrl, fbx, kicad
Requires at least: 4.0.1
Tested up to: 5.2
Requires PHP: 5.3
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

360 viewing support for 3D models (obj + mtl, stl, wrl, fbx with animation) w/ rotation and zoom in wordpress using shortcodes;
Responsive Web Design; 
3D model Rotation, 360 degrees view.

== Description ==

A featured plugin to add 360 degrees and 3d model view models w/ rotation and zoom in wordpress using shortcodes
Responsive Web Design
Displays 3D model on wordPress page, post, or custom page
3D model Zoom & Rotation enabled
Allowed format to display the product: obj (within mtl & png), stl, wrl, fbx (with animation)
Zip archive files allowed (ZipArchive PHP Extension Class needs to be enabled in your WP site)
Model compatibility w/ Blender software
3D Library from threejs.org

Looking for a 3D model (Photography turntable based on images) full rotation & zoom plugin? 
Try the <a href="https://wordpress.org/plugins/spin360/" target="_blank">Spin360 wordpress 3D plugin</a>

####Demo####

<a href="https://easyw.github.io/vrm360/" target="_blank">Live Demo 3D</a>

Sample 3D project shortcode: 

<code>[vrm360 canvas_name=s1 model_url=demo.obj aspect_ratio=1.8 initial_offset=0.9]</code>

full_3d_model_url -> a reference to a web resource that specifies its location

<code>[vrm360 canvas_name=s2 model_url=full_3d_model_url aspect_ratio=1.33333 hide_cmds=all]</code>

####Plugin Features####
* 3D model Display
* obj (obj with mtl & texture), stl, wrl, fbx (with animation), zip archive
* 360 deg and 3D view enabled
* ShortCodes System
* Very Lightweight
* three.js 3D engine
* KiCAD 3D wrl support

== Installation ==

1. Upload the plugin files to the `your_wordpress_plugins_dir/vrm360` directory, or Install as a regular WordPress plugin
2. Go your Plugins page via WordPress Dashboard and activate it
3. Use these shortcodes to post or page


   <code>[vrm360 canvas_name=s1 model_url=full_3d_model_url aspect_ratio=1.33333 hide_cmds=zoom,fullscreen]</code>
   
   defaults: <code>canvas_name=s1, aspect_ratio=1.33333, hide_cmds=false</code>

   **Be sure to use the HTML editor when inserting shortcodes!**
   
4. obj, mtl and png texture file must be located at the same folder and same server 

   mtl and png are optional;
   
   place the full url location of your obj file inside the shortcode
   
   for 3D models the obj, mtl and png files can be generated using **Blender**
   
   upload your 3d model files (obj, [mtl and png]) in your WordPress Library or to your model library site.
   
   NB: you can check the full url location in your Media Library with its Attachment Details.

5. Modify the css style to adapt some features
   * change `css/vrm-style.css` to change some style aspect

6. click to stop animation, click and hold to drag, double click to restart or invert sense of animation

   left-mouse/one-finger: Orbit;  middle-mouse/two-fingers: Zoom; right-mouse/three-fingers: Pan

Shortcode Parameters:

* canvas_name = canvas name needed in case of multiple shows on the same page (required)
* model_url = full 3d model url (required)
* aspect_ratio = any number i.e.: 1.3333  for 4/3 aspect ratio
* initial_offset = any positive number around 1.0 (camera offset, default 1.15)
* change `css/vrm-style.css` to adapt some style aspect (as loading image or button font color)
* hide_cmds = all, fullscreen, fit, run, zoom, on_mobile or false  (default is false)
* speed = any number (default spin rotation value = 1.0)
* autostart = true/false (default false)
* backgcolor = html color value (default #D9D9D9)
* lightcolor = html directional light color value (default #FFFFFF)
* lightintensity = directional light intensity (default 0.9)
* lx, ly, lz = directional light position (default lx=2 ly=2 lz=2)
* amb_lightcolor = html ambient light color value (default #FFFFFF)
* amb_lightintensity = > ambient light intensity (default 0.9)
* border_color = html color for canvas border (default = #D9D9D9)
* border_width = canvas border width in pixels (default = 1); set it to 0 to remove canvas border.
* mesh_color = html color value for stl models (default #FF5533)
* rx = deg, ry = deg, rz = deg (model rotation angle, default rx=0,ry=0,rz=0)
* back_image_url = full background image url (default = '')
* ground = true/false (ground plane, default false)
* ground_color = html color (ground plane color, default #999999)
* ground_offset = any number (ground plane offset, default = 0.0)
* grid = true/false (grid on floor, default false)
* button_color = html color for buttons (default = #99CC99)
* debug = debugging console log (default = false)



== Frequently asked questions ==
= Display 3D model on wordPress page, post, or custom page  =
= 3D model Rotation & Zoom, 360 view enabled, based on 3D model (obj, stl, wrl, fbx [with animation] format)  =
* Fully **Responsive design**; works on **mobile devices**; 
* **click** to RUN/STOP rotation;
* **click and hold** to DRAG; 
* **doubleclick** to zoom fit;
* **mousewheel / two fingers spread or squish** zooming
* **left click / one finger** orbit
* **right click / three fingers swipe** panning
* **full screen** option
* **WIP multy canvas** option
* **clear your site cache** after a plugin update

* be sure to use the HTML editor when inserting shortcodes

* in case of use of "minify HTML" plugin, don't enable compression for inline scripts
 
* **WIP to have many 3D models or to resize the canvas** in the page, it will be possible to use the shortcode inside i.e. a table and set the cell dimension of the table. That will force the plugin to resize itself to the cell size

== Upgrade Notice ==

= 1.2.1 =

* directional and ambient light color & intensity
* directional light position
* allowing to hide buttons on mobile device
* debug console log available
* allowed multimimes types per extension
* updated THREE.WebGLRenderer to 1.0.5
* fixed fbx loader for non animated models
* zip archive allowed for 3D file upload
* added border color & width, ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

== Screenshots ==

1. Screenshot-1.png
2. Screenshot-2.png
3. Screenshot-3.png
4. Screenshot-4.png


== Changelog ==

= 1.2.1 =

* directional and ambient light color & intensity
* directional light position
* allowing to hide buttons on mobile device
* debug console log available
* allowed multimimes types per extension
* updated THREE.WebGLRenderer to 1.0.5
* fixed fbx loader for non animated models
* zip archive allowed for 3D file upload
* added border color & width, ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.1.4 =

* allowed multimimes types per extension
* updated THREE.WebGLRenderer to 1.0.5
* fixed fbx loader for non animated models
* zip archive allowed for 3D file upload
* added border color & width, ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.1.3 =

* updated THREE.WebGLRenderer to 1.0.5
* fixed fbx loader for non animated models
* zip archive allowed for 3D file upload
* added border color & width, ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.1.2 =

* zip archive allowed for 3D file upload
* added border color & width, ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.1.0 =

* zip archive allowed for 3D file upload
* added ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.0.4 =

* added ground floor, background image and other controls 
* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.0.3 =

* allow mouse control of three.js scene only when mouse is over canvas
* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.0.2 =

* obj (within mtl & png), stl, wrl, fbx (with animation)
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.0.1 =
* obj (within mtl & png)
* initial commit
* multisite support
* hide_cmds option to hide command buttons
* added "ask for support" and "rate this plugin" link
* click, doubleclick event to handle stop and restart animation
* shortcodes for page/post
* preloader
* improved readme

= 1.0.0 =
Basic version
