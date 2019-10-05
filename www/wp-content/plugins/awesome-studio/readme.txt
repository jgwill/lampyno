=== Awesome Studio ===
Contributors: wpoets, anirudha.prabhune, bendreabhijeet
Tags: modules, page builder, builder, assemble, studio, content module, shortcodes, shortcode,landing page builder,Page Layout, site-builder, visual composer, website builder
Requires at least: 4.3
Tested up to: 5.1.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Awesome Studio is a shortcode based platform which comes with a massive collection of beautifully crafted, fully responsive and easy to use UI Modules, making it simple for you to assemble your website like Legos.

== Description ==

Awesome Studio is a shortcode based platform along with ready to use modules that can be installed and used by calling the shortcodes for those modules.

Interested in knowing more about our platform? [Get started with Awesome Studio](https://www.getawesomestudio.com/guides/getting-started-awesome-studio-platform/ "Get started with Awesome Studio")

More details about the platform & documentation can be found on https://getawesomestudio.com


== Installation ==

Upload the Awesome Studio plugin to your blog, Activate it, download the modules you need from Awesome Studio tab. Just call them using shortcodes within the pages you want.

== Screenshots ==

1. List of all the modules currently available to install.
2. List of all the modules that are currently installed, or created by you.

== Frequently Asked Questions ==

= Where can I get support? =

We are monitoring WordPress support forums: https://wordpress.org/support/plugin/awesome-studio , if you have questions just ask.

= Where can I find documentation? =
You can find the documentation and tutorials at 
https://www.getawesomestudio.com/tutorials/



== Changelog ==
= 2.4.4 =
* Removed the hardcoding of posts table.

= 2.4.3 =
* Added support for G-Suite API and G-Suite Login
* Added support for 2-Factor Authentication using Google Authenticator
* Regression bug fixes.

= 2.4.2 =
* Regression bug fixes.

= 2.4.1 =
* Added support of GetResponse API & Elastic Mail to aw2.subscribe shortcode
* Added support for registering less variables that will be available to aw2.client less blocks
* Regression bug fixes.

= 2.4.0 =
* Regression bug fixes.

= 2.3.9 =
* Added all_terms views as part of plug-in installation.
* Regression bug fixes.

= 2.3.8 =
* Regression bug fixes.

= 2.3.7 =
* Added support to add custom metaboxes on User  edit screen.
* Added new select field type which support multiselect.
* Added support for API shortcode.
* Regression bug fixes.

= 2.3.6 =
* Added support for adding comma separated terms in save_form
* Added support for RazoPay, SBI Payment Gateways
* [aw2.sideload save_to_path /] now supports ability save files within uploads folder with custom path
* Added support for getting attachment details using [aw2.get attachment attachment_id='' /]
* Regression bug fixes.

= 2.3.5 =
* Added support for creating PDFs using new shortcode aw2.pdf
* Added new shortcode aw2.sideload for loading images from URLs
* Added support for entities_encode & entities_decode with ENT_QUOTES set.
* Regression bug fixes.

= 2.3.4 =
* Fixed issue for Facebook oAuth API
* Added support for excel.read and excel.info
* Added support for request.request_body for reading raw post data.
* Fixed the compatibility bug with 7.1.1 and site_settings
* Regression bug fixes.

= 2.3.3 =
* Added support for socket communication.
* Added support for 'root' app.
* Added checks for minimum required PHP version and WordPress Version.
* Awesome Apps now show up in Nav menu, making it easier to add them in menu.
* Regression bug fixes.

= 2.3.2 =
* Regression bug fixes.

= 2.3.1 =
* Regression bug fixes.

= 2.3 =
* Improved aw2.push
* Added support for users_builder to do better support for users search and query
* Deprecated aw2.spa
* SPA version upgrade to V2, axn support added
* Introduced aw2.cdn
* Filebase cleanup.
* Regression bug fixes.

= 2.2.4 =
* Added support for triggers to be called using aw2.trigger
* Added support for aw2.push for ios and android
* Added support for reply-to
* Regression bug fixes.

= 2.2.3 =
* zoho.crm shortcode usage changed.
* Custom flow for app.
* Added support for custom layout. Now you can access a module directly: http://<YOUR DOMAIN>/<APP SLUG>/<MODULE SLUG>
* Rights check in case on non-loggedin user for apps.
* Regression bug fixes.

= 2.2.2 =
* Regression bug fixes.

= 2.2.1 =
* Updated Hybrid Auth to latest version
* Added support of sideload_media for sideloading images to WordPress
* Added support to choose menu cache for select items.
* Return Status instead of XML Data from KooKoo SMS Gateway
* Regression bug fixes.

= 2.2 =
* Restructured Awesome Apps flow.
* Restructured Awesome Catalogue flow.
* Added support to SYNC module & triggers between environments.
* Added support to get newdate from a given date.
* Added new shortcodes; aw2.include, aw2.load, aw2.new
* Added support to call sidebars inside modules. 
* Integrated Zoho CRM. Use [zoho.crm]
* Regression bug fixes.

= 2.1.7 =
* Added support for comma separation in numbers.
* RETURN CSS & LESS instead of ECHO.
* Minify style before output.
* Added aw2.set_array
* Added filter to support ACE Editor in CPTs.
* Regression bug fixes.

= 2.1.6 =
* Regression bug fixes.

= 2.1.5 =
* Added support for in_array in aw2.if condition.
* Added support for date_query in Posts Builder.
* Added support for Excel export.
* Fix: taxonomy filter for modules.
* Fix: set_term_meta issue when using term ids.
* Fix: problem of array not being passed.
* Fix: login so that it does not send default email to user.
* Fix: issue with device mobile check.
* Added userid for social login.
* Regression bug fixes.

= 2.1.4 =
* Regression bug fixes.

= 2.1.3 =
* Regression bug fixes.
* Removed public access of Triggers and Module types.
* Added support to get Billing edit form, execute any WooCommerce template function
* Added support to get formatted meta fields from an WC Order using order.display_item_meta
* Added support for Line Total using order.get_formatted_line_subtotal
* Added support for delete_post_meta
* Added support for add_non_unique_post_meta. This will not create unique meta entries.

= 2.1.2 =
* Regression bug fixes.
* WooCommerce - Added support for conditional application of taxes and an action for new order.
* Added support for core:timer & core:reload activity within [aw2.spa]
* Updated the helper function to use latest settings.
* Added support for showing private post types and taxonomies in CPT UI. This allows now to make our post_types and taxonomies private and still link them up.
* Added support in [aw2.loop] to set the result.
* Added support for inserting Post comments.
* Added support for Ozonetel SMS Gateway.

= 2.1.1 =
* Regression bug fixes.
* WooCommerce Order creation

= 2.1.0 =
* Added support for raw
* Added support for MailChimp integration
* Added support for meta field search -- based on "WP-Admin Search Post Meta"
* Added WooCommerce support [woo.get]
* Added support for templates in AJAX URLs
* Removed the_content filter application
* Added support for aw2.do for using device and few other conditions to execute the code block
* Added Third party plugin for Tags like meta fields added in CMB2
* Added support for Awesome shortcodes in Menu labels
* Added support for core:reload in spa_activity
* Added support for App backup and restore
* Added support for MOD in Math function
* Added support for Return to end execution
* Added support for creating Custom Metabox
* Regression bug fixes.


= 2.0.9 =
* Fixed - support to allow file types while upload
* Return error if PHP Session is not set
* Fixes for validation of script tag for w3c validation
* aw2.mail now supports file attachments.
* Added module type tax filter to all app level modules as well
* Support for appajax (only in the url and not js)
* Fixed flow of awesome apps
* Changed to rawurldecode because URL decode converts + into a space
* Added support for app specific Iframe Form Submit
* Fixed the issue with the_content override in other themes.
* Support for part added
* Added support for "ajax" in app url


= 2.0.8 =
* Improved app workflow settings.
* Fixed multiple bugs
* Updated module labels for better clarity
* wp_head filter priority reduced.
* Added support for restricting App access in front end for specific roles/logged-in users.
* Custom header & footer for app sections
* Code tab with ace editor for pages & awesome pages
* Now [aw2.set x='{{aw2.get request.x}}-{request.x}-{request.y}-{{aw2.get request.x}}' /] is valid
* Added cmb2 function 'cmb2_get_user_roles' for giving user role dropdowns
* Added cmb2 function 'cmb2_get_registered_objects' for giving registered post types and taxonomies
* Added support for "parese_cotnent" to post content.
* CSS is now outputted when called by default.
* added proper support for using default CPT/Taxonomy for app



= 2.0.7 =
* Debug info cleanup.

= 2.0.6 =
* Support for uploading files to custom path.
* Support for custom shortcodes from CMS.
* Support for CDNCSS runtime.
* Added support for media image alt.
* Added support for getting country from IP.
* Added support to get attachment image url.
* Regression bug fixes.

= 2.0.5 =
* support for custom shortcodes
* support for social login
* bunch of bug fixes
* added aw2.for shorcode
* app based ajax flow introduced

= 2.0.4 =
* Removed few more PHP notices.
* Awesome apps restructured
* fixed the ellipsis sign in excerpt.
* breadcrumbs ported to 2.x
* removed instances of old shortcode
* rewrite rules migrated to 2.x	


= 2.0.3 =
* Regression bug fix - empty & not_empty conditions.
* Removed PHP notices displayed during installation.
* CMB2 updated to 2.2.1
* Fixed issues with App specific settings.

= 2.0.2 =
* Removed unwanted menu items

= 2.0.1 =
* Regression bug fix - Module installation process.

= 2.0.0 =
* Full rewrite of Awesome core. DO NOT upgrade directly from 1.x as this will break your existing site.
* Theme options moved to CMB2 framework.
* New syntax introduced [aw2.get]
* Concept of 'One click Install' Apps introduced.

= 1.1.0 =
*  Added support for system notification after registration.

= 1.0.9 =
* Updated monoframe to support Taxonomy Metadata.

= 1.0.8 =
* Added support for post_list and taxonomy list within theme options for select fields.
* Fixed the positions of Menu Items in admin menu.
* CSS fix for Generate Shortcode block while adding/editing WordPress Page.
* Fix for user login to support for both Email-address & Username for login.
* Added support for User Registration & Forgot Password.

= 1.0.7 =
* Show filter of Form Entry type.
* bug fix: setting post term from awesome form
* Added support for collecting other form fields
* Awesome form validation bug fix
* Added ability to pass customer_id instead of assuming customer id
* Fixed the issue for php 7, where function definition was not matching.
* Added rewrite rule flush on new install, new post types if installed will work out of box
* Moved the Awesome Studio menu position below Dashboard.

= 1.0.6 =
* made it compatible with PHP less then 5.5.
* updated yoast seo meta box to a low priority
* added function to support app install flow
* added support for script & style enqueue
* container class in menu was getting overridden, appended to it.

= 1.0.5 =
* delayed our wp_head action to so that our design loads later.

= 1.0.4 =
* Added support for html validation in textarea field.
* Minified the output of aw2_less.
* Removed extra spaces as output of triggers
* Fix the bug while installing modules.
* Cleaned up plugin comments from files
* Added support for installing modules from server.
* Included bootstrap.css from plugin.
* Cleaned the remote module install screen
* Changed aw2_save_form_data shortcode registration process
* When adding new module type, along with slug, now term names is also saved.



= 1.0.3 =
* Icons swapped between Awesome Studio & Awesome Dev
* Site settings made compatible with Redux plugin if installed.
* "Load More" button style fixed on catalogue page
* Bug fix while installing a trigger dependency.
* Changed label on "Set Trigger" page.
* Converted set trigger button to ladda.
* Cleaned up plugin comments from files
* Removed aw2_trigger js





= 1.0.2 =
* CSS Fixes
* Show Triggers on Local Modules list
* Module image set as Featured image upon installation
* Site Name set as title on Settings page
* Include lessc.inc.php file only if Class lessc doesn't exist
* Ability to re-install modules added
* Ability to filter Modules based on "Module Type"
* Added custom Bootstrap Menu Walker
* Site Settings made compatible with Redux if installed.

= 1.0.1 =
* Fixed few flow issues
* Studio workflow is working properly

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.3 =
2.3 is a major update so it is important that you make backups, and ensure themes and extensions are 2.3 compatible.
