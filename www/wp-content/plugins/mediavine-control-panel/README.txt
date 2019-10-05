=== Mediavine Control Panel ===
Contributors: mediavine
Donate link: https://www.mediavine.com
Tags: amp, advertising, mediavine
Requires at least: 3.5
Tested up to: 5.2.0
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Manage your ads, analytics and more with our lightweight plugin!

== Description ==

Mediavine Control Panel connects your WordPress blog to your Mediavine account. Simply install the plugin, provide your mediavine account name, and take advantage of our cutting edge features

* Easy to use interface makes it simple to adjust your settings
* Monetize traffic to AMP Pages with our AMP Ad Plugin!
* Automatically track your AMP content and see which posts are performing the best on each platform


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/mediavine-control-panel` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Mediavine Control Panel screen to configure the plugin

== Frequently Asked Questions ==

= Where can I find support articles =
[Visit our Mediavine Help site](https://help.mediavine.com/)

= How can I contact Mediavine support? =
On the Settings->Mediavine Control Panel screen, you will find an icon to the bottom right that will contact the Mediavine support team. You can also email Mediavine at [publishers@mediavine.com](mailto:publishers@mediavine.com).

== Screenshots ==

== Changelog ==

= 2.2.0 =
* FEATURE: Adds support for Video Sitemaps
* FIX: Videos now use custom thumbnails when set in Mediavine Dashboard
* FIX: Video button is properly aligned in Classic Editor
* FIX: Backward compatibility for shortcodes using "sticky" attribute

= 2.1.2 =
* ENHANCEMENT: Adds a clearer description to the Include Script Wrapper setting

= 2.1.1 =
* FIX: Fixes issue with new video placement logic

= 2.1.0 =
* FEATURE: Add support for new video placement settings
* FEATURE: Intercom chat will display history
* FIX: Fixes issue with incorrect ID being saved when reinserting a video
* FIX: Fixes an issue with a class sometimes recursively calling itself
* FIX: Prevent videos from rendering inside Gutenberg or Relevanssi search results
* CHANGE: New sites will include script wrapper by default

= 2.0.1 =
* FIX: Fixes issue with Cloudflare 414 errors

= 2.0.0 =
* FEATURE: Incorporated Publisher Identity Service v2
* FEATURE: Adds pagination to videos

= 1.9.12 =
* FIX: Compatibility with official AMP 1.0 plugin's Classic mode

= 1.9.11 =
* FIX: Hotfix issue with potential PHP fatal when checking for AMP

= 1.9.10 =
* FIX: Compatibility with official AMP plugin's template modes
* FIX: Prevent issue where delete buttons in Create would not work
* FIX: Prevent issue where images in TinyMCE could not be edited

= 1.9.9 =
* FIX: Marking videos as sticky will now actually make them sticky
* FIX: More compatibility with official AMP 1.0 plugin

= 1.9.8 =
* FIX: Compatibility with official AMP 1.0 plugin

= 1.9.7 = 
* ENHANCEMENT: Adds Gutenberg support

= 1.9.6 =
* FIX: Issue with videos sometimes not displaying on posts
* ENHANCEMENT: Add target class to video shortcode render

= 1.9.5 =
* ENHANCEMENT: Only enable ads.txt cron job if site_id exists
* FIX: `[mv_video]` shortcode now compatible with Jetpack shortcodes
* FIX: Prevents re-enabling ads.txt on activation if it was previously disabled manually
* FIX: Disable ads for admin users with Page Builder utilties activated on the site.

= 1.9.4 =
* FEATURE: Adds targeted ads and GDPR consent form for AMP for WP 
* FIX: Gracefully goes into legacy mode if on older versions of WordPress (4.4 and below)
* FIX: Prefixes variables to prevent plugin conflicts using global variables

= 1.9.3 =
* Improves TinyMCE stability
* Improves compatibility with Create

= 1.9.2 =
* Improves shortcode render on non-sticky cards
* Improves database table creation fallback

= 1.9.1 =
* Improves settings table creation
* Provides fallback if table cannot be created
* Improves script to shortcode replacement

= 1.9.0 =
* Login with Mediavine
* Insert Mediavine videos straight to your Editor without visiting your Dashboard
* Using this tool will eliminate Mediavine Script Tag issues

= 1.8.4 =
* Remove non-EU countries from AMP Geo
* Fix bug with AMP for WP validation
* Block script wrapper from customizer

= 1.8.3 =
* Fix AMP Bug
* Improves compatibility with other AMP plugins

= 1.8.2 =
* Adds GDPR Support for AMP Pages

= 1.8.1 =
* Improves file path reliability

= 1.8.0 =
* Improves ads.txt reliability

= 1.7.9 =
* Fix AMP Bug

= 1.7.8 =
* Removes Ads.txt mismatch notifications

= 1.7.7 =
* Adds Intercom button to settings page

= 1.7.6 =
* Removes notifications regarding Ads.txt mismatch to improve user experience

= 1.7.5 =
* Adds Ads.txt autoupdate on first out-of-date check
* Adds support for MVCP_ROOT_PATH and MVCP_ROOT_URL config defines
* Adds better failed Ads.txt update notifications
* Adds preactivation hook to prevent version incompatibility
* Fixes Ads.txt update problems on some hosts

= 1.7.4 =
* Adds option to disable Automatic Ads.txt syncing
* Fixes a bug saying ads.txt updated when it didn't

= 1.7.3 =
* Fixes blank Ads.txt files

= 1.7.2 =
* Fixes AMP problems on some hosts
* Internal build only

= 1.7.1 =
* Fixes issues relating to AMP for WP

= 1.7.0 =
* Adds Ad.txt sync
* Removes Upgrade CSP option
* Adds block CSP Option

= 1.6.0 =
* Adds google ad fraud protection

= 1.5.2 =
* Removes CRON Cleanup

= 1.5.0 =
* Rollsback to 1.3.9

= 1.4.0 =
* BAD VERSION

= 1.3.9 =
* Minor bugfixes

= 1.3.8 =
* General Bugfixes & Improvements

= 1.3.7 =
* Adds AMP ad settings

= 1.3.6 =
* Minor Bugfixes with AMP Video

= 1.3.5 =
* Adds AMP Backout option

= 1.3.4 =
* Settings page improvements

= 1.3.3 =
* Fixes additional conflicts with AMP for WP

= 1.3.2 =
* Bugfixes & Improvements

= 1.3.1 =
* Fixes a bug that could cause the plugin to crash

= 1.3.0 =
* Adds AMP support for Mediavine Videos
* Fixes a fatal conflict with AMP For WP
* Fixes an instance where AMP for WP could cause less than optimal search results
* Adds settings button to plugin list

= 1.2.0 =
* Adds Secure Content Settings
* Fixes a bug where the script wrapper would sometimes appear low in the page

= 1.1.1 =
* Fixed a bug that was preventing some settings from saving

= 1.1.0 =
* Fixed a bug that was preventing some settings from saving

= 1.0.1 =
* Fixes a bug that was preventing some settings from saving

= 1.0 =
* Initial Plugin Build

== Upgrade Notice ==

= 2.1.0 =
* This update fixes an issue with the new video settings placement logic

= 2.0.1 =
* This update improves Cloudflare compatibility

= 2.0.0 =
* This update improves the Mediavine login experience

= 1.9.12 =
* This update provides better AMP compatibility

= 1.9.11 =
* This update fixes a potential PHP fatal error

= 1.9.10 =
* This update provides better AMP compatibility

= 1.9.9 =
* This update improves video support and gives better AMP compatibility

= 1.9.8 =
* This update fixes compatibility with official AMP 1.0 plugin

= 1.9.7 = 
* Adds Gutenberg support for videos

= 1.9.6 =
* This update improves video display on posts

= 1.9.5 =
* This update improves compatibility with Jetpack

= 1.9.4 =
* This update improves support with older versions of WordPress and potential plugin conflicts
* Also provides better AMP for WP support

= 1.9.3 =
* This update improves reliability with video features in the editor

= 1.9.2 =
* This update improves reliability with video features

= 1.9.1 =
* This update improves reliability with video features

= 1.9.0 =
* This update adds the ability to login with Mediavine and easily add videos to your editor

= 1.8.4 =
* This update improves AMP plugin compatibility and GDPR support

= 1.8.3 =
* Fix AMP Bug
* Improves compatibility with other AMP plugins

= 1.8.2 =
* Adds GDPR Support for AMP Pages

= 1.8.1 =
* Improves file path reliability

= 1.8.0 =
* This update improves ads.txt reliability

= 1.7.8 =
* This update includes a bug fix to AMP

= 1.7.8 =
* This update includes general user experience enhancements

= 1.7.7 =
* Increases ease of contacting Mediavine support

= 1.7.6 =
* This update includes general user experience enhancements

= 1.7.4 =
* This update includes performance enhancements and improvements to our ads.txt manager.

= 1.7.3 =
* General bugfixes & performance Enhancements
* Enhances Ads.txt features

= 1.7.2 =
* General bugfixes & performance Enhancements

= 1.7.1 =
* Fixes issues relating to AMP for WP

= 1.7.0 =
* Fixes a conflict with AMP for WP
* General Bugfixes and Improvements

= 1.6.0 =
* Adds google ad fraud protection

= 1.5.2 =
* Minor bugfix for users unable to upgrade to 1.5.1

= 1.3.9 =
* Minor bugfixes & Language improvements

= 1.3.8 =
* General Bugfixes & Improvements

= 1.3.7 =
* Adds settings for AMP Ad Units

= 1.3.6 =
* Fixes a bug with some videos not showing up in AMP

= 1.3.5 =
* Minor bugfixes & Improvments

= 1.3.4 =
* Improves Settings Page

= 1.3.3 =
* Fixes additional conflicts with AMP for WP

= 1.3.2 =
* Critical Bugfixes & Improvements

= 1.3.1 =
* Fixes a bug that could cause the plugin to crash

= 1.3.0 =
* Adds AMP support for Mediavine Videos & General Plugin Improvements

= 1.2.0 =
* Adds Security Enhancements & General Plugin Improvements

= 1.1.1 =
* Fixed a bug that was preventing some settings from saving

= 1.1.0 =
* Fixed a bug that was preventing some settings from saving

= 1.0.1 =
* Fixed a bug that was preventing some settings from saving

= 1.0 =
* Initial Plugin Build
