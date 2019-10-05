=== modulus ===
Contributors: webulous
Tags: custom-menu, featured-images, fixed-layout, responsive-layout, right-sidebar, sticky-post, threaded-comments, translation-ready, two-columns
Requires at least: 4.0
Tested up to: 4.9.8
Stable tag: 1.3.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

modulus is best suited for all types of site and uses Theme Customizer.

== Description ==
Modulus comes with modern, stylish and responsive design. It uses skeleton framework for grids which keeps minimal css. Stylesheet is generated using SASS and so stays DRY. Best suited for Corporate/Business/Blog sites. There is no theme options panel, instead uses Customizer, core feature of WordPress and comes with lots of options to customize. Has 4 Footer Widget Areas. 

== Frequently Asked Questions ==
= Installation =
1. Download and unzip `modulus` theme
2. Upload the `modulus` folder to the `/wp-content/themes/` directory
3. Activate the Theme through the 'Themes' menu in WordPress

= Setting Up Front Page =
1. By default, your front page looks like a blog. However, you can make it look like screenshot by following these steps.
2. Goto Dashboard => Apperance => Customize
3. Click on 'Static Front Page'
4. Select 'A static page' radio option
5. Select a static page for 'Front Page' and another page for 'Posts Page'
6. Go back and Click 'Home' panel
7. Click on 'Slider Section'
8. Select a category for 'Slider Posts Category'.
9. Enter no. of slides to show from above selected category.
10. Select 4 Pages for 'Services' sections
11. Select no. of recent posts to show on home page.

= How to change `Our Services` heading =
Make a Child Theme
Add following in `functions.php` file
`function childname_change_service_title($title) {
 	$title = __('Your Own Title','childname');
 	return $title;
 }
 add_filter('modulus_service_title','childname_change_service_title');`

= How to control featured images visibility =

Goto Dashboard => Apperance => Customize. 
Select 'modulus Options' Panel
Select 'Blog' section
Enable/Disable featured images visibility.

== Changelog ==

= 1.3.9 =
* Fixed Service section issue
* Added Full Width Layout option for blog

= 1.3.8 = 
* WPForms Lite plugin action removed.

= 1.3.7 = 
* Gutenberg unit test style added. 

= 1.3.6 = 
* Added option for separate slider selecting option in Blog Page. 
* Updating .po file. 

= 1.3.5 = 
* Scroll To top Enable/disable option added.
* WPForms Lite plugin recommended. 

= 1.3.4 =
* Alpha Option added in theme Options.
* RTL Support style issue fixed.

= 1.3.3 =
* Post Exclude Option added. 

= 1.3.2 =
* Added site Creation Ads in Theme Upgrade Page. 

= 1.3.1 =
* Kirki file updated and WP 4.9 compatible issue fixed. 

= 1.3.0 =
* Updated flexslider and font-awesome Files.

= 1.2.9 =
 * Added Starter content
 * Flex Caption Issue Fixed.

= 1.2.8 =
 * Site URL's Changed
 * Style.php issue fixed.

= 1.2.7 =
 * Added Custom header video

= 1.2.6 =
 * Modify twitter share link
 * Added Header hook for responsive menu title

= 1.2.5 =
 * Fix Page edit style

= 1.2.4 =
 * Fix Archive pagination bug

= 1.2.3 =
 * Fix comments related bug

= 1.2.2 =
 * Fix header already sent bug

= 1.2.1 =
 * Added More options
 * Customizer Changed to kirki 

= 1.2.0 =
 * Fix Responsive Divider
 * Added custom header background option
 
= 1.1.9 =
 * Fix Responsive Menu bug (toggle)

= 1.1.8 =
 * Fix Responsive Menu bug

= 1.1.7 =
 * Fix Home page responsive bug
 * Added Page Fullwidth no-nav & Landing Page Templates

= 1.1.6 =
 * Change Pro Theme URL

= 1.1.5 =
 * Added Sticky Header Option
 * Added Russian Language .po file

= 1.1.4 =
 * Added Theme Rating link
 * Fix Woocommerce Breadcrumb Heading issue
 * Added Related Post options

= 1.1.3 =
 * Added rtl.css file
 * Added more customizer home option and layout options
 * Language .po file change

= 1.1.2 =
 * Added Flexcaption background option

= 1.1.1 =
 * Fix Single page feature image

= 1.1.0 =
 * Added Hook for frontpage heading and single page

= 1.0.9 =
 * Fix Home page flexslider default value

= 1.0.8 =
 * Added Hook in frontpage
 * Single post breadcrumb remove

= 1.0.7 =
 * fix service page order
 * Added Home page flexslider options

= 1.0.6 =
 * Woo Commerce support and other changes

= 1.0.5 =
* Front Page: Clickable service section

= 1.0.4 =
* Fix for wrong register_sidebars() code.

= 1.0.3 =
* No image issue fixed.
* Updated screenshot

= 1.0.2 =
* Mistaken upload

= 1.0.1 =
* Fixes for broken up-sell links

= 1.0.0 =
* Fixes for theme review issues

= 0.0.9 =
* Added demo content

= 0.0.8 =
* Initial Release

== Upgrade Notice ==

= 1.3.9 =
* Fixed Service section issue
* Added Full Width Layout option for blog

== Resources ==
* {_s}, GPLv2, http://underscores.me/
* {Skeleton}, MIT, https://github.com/dhg/Skeleton#license
* {Flexslider} © 2015 Woo Themes, GPLv2 ,https://github.com/woothemes/FlexSlider
* {FontAwesome} © Dave Gandy, SIL OFL 1.1 and MIT ,https://fortawesome.github.io/Font-Awesome
* {Rippler JS} © 2016 blivesta, MIT, https://github.com/blivesta/rippler
* screenshot.png © 2015 Pixabay, CC0,
https://pixabay.com/en/lighthouse-nautical-navigation-768754/