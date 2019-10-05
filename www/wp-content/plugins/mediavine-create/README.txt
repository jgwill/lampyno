=== Create by Mediavine ===
Contributors: mediavine
Donate link: https://www.mediavine.com
Tags: create, recipe, recipe card, how to, schema, seo
Requires at least: 4.7
Tested up to: 5.2.1
Requires PHP: 5.4.45
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Complete tool for creating and publishing recipes and other schema types on your site.

== Description ==

= A Plugin for Bakers. Makers. Adventure-takers. =
Top in tech, speed, and SEO so you can focus on what you do best and CREATE.

Now you can craft multiple Google Schema.org types using just one plugin.

* Recipes
* How-to guides and craft instructions
* Lists and round-ups
* More to come!

Now: Automatically calculate nutritional data for your recipes for free.

[youtube https://www.youtube.com/watch?v=OmtqDGi3Nc4]

= Create is for... =

**Recipes** — Easily import content from other plugins. Includes free nutrition calculator and video embeds.
**Lists and round-ups** — Showcase images, links and more in a user-friendly manner.
**How-to guides** — Display beautiful printable materials lists, instructions and videos for DIYs, crafts and more.

= Create by Mediavine was built with the following in mind: =
**1. Speed**
Lightweight, with our strong focus on site speed

**2. Optimized for SEO**
Full Google Rich Snippet support and one-button schema validation so content is marked up for mobile search carousels

**3. Easy to Use**
Built for optimal user experience, for you and your readers

**4. Top-notch Importers**
Easily transfer your content from other recipe plugins

**5. Multiple Themes**
Five gorgeous themes by Purr Design with more on the way

**6. Ad-Ready**
Fully monetize your content using the most-ad-optimized themes

**7. Matches your site**
All themes mimic your site's unique design so no two look the same

**8. Live Preview**
See your content how it will appear on your site, in real time, with full Gutenberg support

**9. Mobile First**
Responsively designed to engage the majority of your audience

== Installation ==

= Minimum Requirements =

* PHP version 5.4.45 or greater (PHP 7.2 or greater is recommended)
* MySQL version 5.5 or greater (MySQL 5.6 or greater is recommended)

= Automatic Installation =

1. Go to Plugins > Add New
1. Type "Create by Mediavine" in the search field and click "Search Plugins"
1. Click "Install Now" to install and then click "Activate"
1. Go to Settings > Create by Mediavine and choose your card style
1. [Register your Create plugin](https://help.mediavine.com/create-by-mediavine/how-to-register-your-create-plugin)
1. If using another recipe card plugin and you'd like to import your recipes from that plugin, [download and install the Mediavine Recipe Importers utility](https://www.mediavine.com/mediavine-recipe-importers-download)

= Manual Installation =

1. [Download a copy of the "Create by Mediavine" plugin](https://downloads.wordpress.org/plugin/mediavine-create.latest-stable.zip)
1. Upload `mediavine-create` to the `/wp-content/plugins/` directory
1. Activate the plugin through the "Plugins" menu in WordPress
1. Go to Settings > Create by Mediavine and choose your card style
1. [Register your Create plugin](https://help.mediavine.com/create-by-mediavine/how-to-register-your-create-plugin)
1. If using another recipe card plugin and you'd like to import your recipes from that plugin, [download and install the Mediavine Recipe Importers utility](https://www.mediavine.com/mediavine-recipe-importers-download)

For more, please see our [help center](https://help.mediavine.com/create-by-mediavine).

== Frequently Asked Questions ==

= How do I import my existing recipes? =

[Download and install the Mediavine Recipe Importers utility](https://www.mediavine.com/mediavine-recipe-importers-download)

= Which recipe card plugins does the importer support?

* Cookbook
* EasyRecipe
* Meal Planner Pro Recipes
* Purr Recipe Cards
* Simple Recipe Pro
* WP Recipe Maker
* WP Tasty
* WP Ultimate Recipe
* Yummly
* Zip Recipes
* ZipList Recipe Plugin

= How will the cards display? =
Our cards are displayed using a WordPress shortcode.

This means that if the plugin is disabled, the recipes themselves will not display on the front end of a blog post. This is typical behavior for most WordPress plugins.

If the plugin is deactivated, no data will be deleted and reactivating the plugin will restore the original card display.

= Will I be able to add nutritional data? =

Yes! Nutritional data is an important part of Schema, which search engines love to have for optimal results.

Nutrition facts can be manually entered for a recipe. They will also transfer over if the recipe already contains it.

We also provide automatic nutrition calculation through our partnership with [Nutritionix](http://nutritionix.com/). [Learn more about this feature](http://help.mediavine.com/create-by-mediavine/auto-calculate-nutrition-with-create-by-mediavine).

= How much does it cost? =

Create is free to the blogging community at large. You do not need to be a Mediavine publisher to use it. All core functions of the plugin will always remain free.

There may be features in the future that non-Mediavine publishers would need to license for a fee, but the core functionalities will always remain free and supported for everyone — including plugin updates to keep Create in compliance with WordPress releases.

== Screenshots ==

1. Choose between Recipe, How-To and List cards. (More types coming soon.)
2. Refreshed interface design provides a better user experience.
3. View all of your cards at a glance in the Create card gallery.
4. Search and sort all of your cards for easy editing.
5. Create SEO-ready Recipe cards in minutes.
6. A published Recipe card using the Hero Image card style.
7. A published Recipe card using the Simple Square card style.
8. Our automatic nutrition calculator saves you time and headaches.
9. Publish beautiful lists and round-ups with the List card type.
10. A published List card using the Big Image layout.
11. A published List card using the Circles layout.
12. How-to cards can be used for any kind of instructional guide.
13. A published How-To card on the Dark Classy Circle card style.
14. A published How-To card on the Hero Image card style.
15. Add recommended products to your Recipe and How-To cards.
16. All card styles adapt to your site's existing design.

== Changelog ==

= 1.4.17 =
* ENHANCEMENT: Adds support for WP Accessibility Helper plugin on print page
* ENHANCEMENT: Prevents canonical post from being selected as a list item
* ENHANCEMENT: Adds global default list button texts to dropdown
* FIX: Normalizes apostrophes in WYSIWYG shortcodes
* FIX: Improves display of primary image in card preview
* FIX: Prevents errors on sites with older versions of Mediavine Control Panel
* FIX: Images are now equally sized when viewing list with Grid style on mobile
* FIX: Fixes "Choose from existing" link when editing card from a post
* FIX: JSON-LD improvements to instructions anchor links
* FIX: Disables nutrition calculation with ranged servings and adds tooltip notice
* FIX: Fixes lists so the headings respect selected setting
* FIX: Makes sure Mediavine ads are never placed in header
* FIX: Supports "ugly" permalinks
* FIX: Pinterest button location settings properly respected
* FIX: Moves affiliate disclaimer above recommended products
* FIX: JSON-LD schema now properly displays when canonical is second card on post

= 1.4.16 =
* FIX: Ad Hint Conflict
* FIX: Prevents Mediavine ads from loading in Recommended Products
* FIX: Nutrition calculate button no longer disabled when Create registered

= 1.4.15 =
* ENHANCEMENT: Loads admin font from CDN, reducing plugin file size
* FIX: Fixes issue with card creation on older versions of PHP (below 7.0.13) with `opcache` disabled
* FIX: Pinterest button on cards again works when Mediavine Control Panel is activated
* FIX: Prevents too many Mediavine ads from loading in rare circumstances
* FIX: Front-end reviews by visitors no longer appear clickable

= 1.4.14 =
* ENHANCEMENT: Ads for Mediavine publishers are now generated more reliably within instructions
* ENHANCEMENT: The ability to rate a recipe with a half star has been removed
* ENHANCEMENT: Video thumbnails are now displayed in a card's preview
* ENHANCEMENT: Messaging for errors when adding list items is now more descriptive
* ENHANCEMENT: 3/4 and 2/5 are now options in the Special Characters selection modal
* FIX: Ads for Mediavine publishers are no longer placed at the end of Lists
* FIX: Brings in custom thumbnails on Mediavine videos
* FIX: List items pointing to a subdomain now appear in JSON-LD
* FIX: Fix issue where categories haven't been selected
* FIX: Prevent duplicate list items
* FIX: Fix issue where an additional line break was insterted while adding materials
* FIX: JSON-LD anchor link for How-To cards now links to correct step
* FIX: Adding a card to a post can no longer create duplicates if publish button is double clicked
* FIX: Adding a list item to a list will now always place the item in the correct spot
* FIX: Correctly round the aggregate rating in the JSON-LD output
* FIX: Clicking the print button on a card more reliably brings up the print dialog

= 1.4.11 =
* ENAHNCEMENT: Manual Nutrition fields for Net Carbs and Sugar Alcohols
* FIX: List's support for pages
* FIX: Check for Server support of PHP Extenstions xml and mbstring
* FIX: Issue where logged in users couldn't use external links services
* FIX: Insert products at the beginning of the list
* FIX: Ensure updates to Products would propogate across the site
* FIX: Possible issue with reviews if comments were empty
* FIX: Possible issue with upgrading mv_recipe shortcodes to mv_create shortcodes
* FIX: Issue where number of servings wasn't updated in API request
* FIX: Surface Nutrition API Error to UI

= 1.4.10 =
* ENHANCEMENT: List items can now easily be added between others, and all items can be collapsed with a button
* ENHANCEMENT: Better filter support in admin
* ENHANCEMENT: Pasting content into WYSIWYG now retains formatting
* ENHANCEMENT: Admin notice displayed if outdated Mediavine Recipe Importer plugin is found
* ENHANCEMENT: Featured images pulled from a website for a list will provide a notice if they weren't downloaded
* ENHANCEMENT: Warning is provided when a new category is about to be added
* ENHANCEMENT: Setting added to remove popup review prompt on ratings above 4 stars
* ENHANCEMENT: Filter `mv_create_ratings_prompt_threshold` can be returned with a number for a different popup review prompt threshold
* ENHANCEMENT: Filter `mv_create_ratings_submit_threshold` can be returned with a number for a different required review for rating level (Default is 4)
* ENHANCEMENT: You can now add an internal page as a list item
* ENAHNCEMENT: JSON-LD can be disabled on individual How-To cards.
* FIX: Minor bugs with WYSIWYG editor
* FIX: Fix bugs when pasting ingredient URLs with extra spaces
* FIX: Amazon links now properly save in the URL field for external list items
* FIX: Hero Lists now render longer titles properly on mobile devices
* FIX: Fix issues with certain UI elements improperly overlapping others
* FIX: Cleaner deletion of reviews through admin
* FIX: Remove style descrepancy of descriptions in cards
* FIX: Ingredients now display in the correct order in the card preview
* FIX: Fix issue where blank settings were being created on a few sites
* FIX: Fix issue with reordering list items through the use of buttons
* FIX: Google Search Console will no longer error when there are multiple How-To cards on a post

= 1.4.9 =
* ENHANCEMENT: WYSIWYG editors now support hard line breaks in lists with the use of Shift+Enter
* ENHANCEMENT: Card ratings modal now has a close button
* FIX: Detail editor no longer has disappearing text of previous ingredients when editing another
* FIX: Styled text in WYSIWYG can now be edited after initial publish
* FIX: List items and ingredients no longer disappear when reordering
* FIX: When the importers plugin is active, the re-importer works again with the new 1.4 UI

= 1.4.8 =
* ENHANCEMENT: Filter `mv_generate_intermediate_sizes_return_early` can be returned false to disable image regeneration of older images
* ENHANCEMENT: Set default ingredients view to bulk instead of detail
* FIX: Fix issue where card style setting was incorrect from older versions of Create
* FIX: Reviews now display the correct date/time, with absolute time in a tooltip
* FIX: Safari users can now edit list descriptions in Classic and Gutenberg editors
* FIX: Adding an image no longer will break list format in instructions
* FIX: Custom nutrition disclaimer is now used, falling back to global setting
* FIX: Image picker no longer refreshes page when importing a recipe
* FIX: Shortcodes with IDs of deleted cards will no longer attempt to render
* FIX: Fix obscure bug with JSON-LD output on custom PHP installs
* FIX: Fix bug with styled instruction content disappearing

= 1.4.7 =
* FIX: Images display in instructions again
* FIX: Fixed an issue where instruction content was disappearing
* FIX: Editing a card no longer removes content in the Classic Editor if another shortcode exists
* FIX: Support again for versions 4.7-4.9 of WordPress

= 1.4.6 =
* FIX: Fix issue where admin UI wasn't displaying for some people
* FIX: Safari users can now edit list descriptions
* FIX: Nested modals such as adding videos and links no longer break in Gutenberg
* FIX: Ingredients are saved in the correct order

= 1.4.5 =
* Versions 1.4.0-1.4.4 were for beta testing

* We hired a designer! The admin has been re-skinned. (We love you, Kat!)
* Changes to List UI: Lists now support text in between items.
* Changes to video: new videos will include duration data in schema.
* Changes to products: Products use our services API, which improves reliability of image scraping.
* Changes to autosave: Autosave actions will occur more predictably.
* Improves size and performance of client-side JavaScript.

New features:
* Cards can now use your brand colors! Go to Settings > Display and click "enable" under "Colors."
* Changes to instructions: The Instructions UI limits content to those which are best for SEO. Existing content can be optimized using the "Optimize" button.
- User reviews can be made public and will display in a tab next to your comments. Go to Settings > Advanced and "Enable Public Reviews." Then, add a DOM selector for your comments div.

= 1.3.22 =
* FIX: Fix an issue where video data for cards was missing contentUrl

= 1.3.20 =
* ENHANCEMENT: Add JSON-LD schema toggle to How-To cards
* ENHANCEMENT: Add contentUrl property to video schema
* FIX: Zero cook and prep times should no longer give Google Search Console errors

= 1.3.19 =
* ENHANCEMENT: Add stepped instructions to JSON-LD
* FIX: Link Parsing in Ingredients
* FIX: Some creations weren't mapping to canonical posts
* FIX: Restore Ads on Print pages

= 1.3.18 =
* FIX: Fix missing thumbnails for list items in admin UI
* FIX: Prevent conflicts with other plugins using common function names

= 1.3.17 =
* FIX: Fix activation error with certain versions of MySQL
* FIX: Fix issue where pre-0.3 recipes could not be cloned

= 1.3.16 =
* ENHANCEMENT: Cards no longer can be cloned when using modal editor
* ENHANCEMENT: Add new hook to print card output
* FIX: Fixes occasional databases errors when saving cards
* FIX: Only external list cards open in a new window

= 1.3.15 =
* FIX: Fixes issue with list URLs

= 1.3.14 =
* ENHANCEMENT: Setting added to adjust H1s in cards to H2s
* ENHANCEMENT: JSON-LD schema now only displays on canonical post
* FIX: Prevents nutrition and products from incorrectly being linked to lists
* FIX: Pinterest buttons in lists respect "off" setting
* FIX: Prevents Social Warfare from affecting related product images
* FIX: Prevents Chicory from appearing on How-To cards
* FIX: Fixes issue where nofollow attribute wasn't always saving on supplies
* FIX: Lists now output proper URL for all internal items
* FIX: JSON-LD validation test button works again
* FIX: Better data management of associated posts

= 1.3.13 =
* FIX: Fixes issue where previously created instructions may not properly display within the editor

= 1.3.12 =
* FIX: Better conversion of shortcodes into Gutenberg
* FIX: Pinterest button no longer attached to top of list when rendering after another card
* FIX: Fixes issue where a MySQL error appeared on some server environments
* FIX: Prevent Chrome autocomplete when adding cuisine or category to card
* FIX: More reliable WYSIWYG component

= 1.3.11 =
* FIX: Aggressive Buttons setting now applies to Lists
* FIX: Prevents a PHP error when a card is added after a List
* FIX: Fixes issue where time UI wasn't visible

= 1.3.10 =
* FIX: Prevent List descriptions from being tiny
* FIX: Amazon images will display in dropdown
* FIX: Prevent misordered ingredients from detailed editor
* FIX: Prevent multiple List JSON-LDs from outputting
* FIX: Prevent a bug where typing in time inputs will insert "minutes" sporadically
* FIX: Improve performance of image rendering in instructions preview
* FIX: Buttons in lists will sync with theme
* FIX: Add missing "Cost" field to front-end How-To renders

= 1.3.9 =
* ENHANCEMENT: Create List items manually
* ENHANCEMENT: Improved Error Messages for user timeouts
* ENHANCEMENT: Make Notices for API Registration dismissible
* FIX: Output alt text in images
* FIX: Prevent activations for incompatible PHP and WP
* FIX: Conflict with Jetpack YouTube embeds
* FIX: User validation in secondary UIs
* FIX: TinyMCE state reset
* FIX: Multipage Print Margins
* FIX: Print Image sizes
* FIX: Display of No Follow state for Lists
* FIX: Photo Credit layout styles
* FIX: Moving between internal and external links
* FIX: Remove image if Pinterest is turned off

= 1.3.8 =
* FIX: Prevents duplicate images within Lists
* FIX: Duplicate List item prevention
* FIX: Properly saves List thumbnail images

= 1.3.7 =
* FIX: Fix bug in List Drag and Drop functionality
* FIX: Improve relationship mapping in Clone tool
* FIX: Check for pre v1.7.7 of Mediavine Control Panel

= 1.3.6 =
* FEATURE: Improves UX and speed of List search
* FEATURE: Add a setting to disable JSON-LD output for individual posts
* FEATURE: Add `mv_create_card_before_render` and `mv_create_card_after_render` hooks
* FEATURE: Adds support for Amazon links as List items
* FIX: Prevents output of JSON-LD markup in RSS feeds
* FIX: Removes duplicate ad hints when rendering a List after a recipe card in a single post
* FIX: Fixes error in List render
* FIX: Prevents display of special characters as HTML entities in List search
* ENHANCEMENT: Protect client-side resources from caching plugins
* ENHANCEMENT: Refactor client-side JavaScript to optimize page load

= 1.3.3 =
* ENHANCEMENT: Adds ability to no-follow external List items
* ENHANCEMENT: Optimize the ad hint used for Mediavine publishers
* ENHANCEMENT: Adds a setting to override the author for all cards with default Copyright Attribution
* FIX: Prevents Social Warfare and Pinterest browser extension from targeting List images for which we already include a Pinterest button
* FIX: Prevents issue where List items would sometimes display in incorrect order
* FIX: Fix an issue where adding previously-added products without thumbnails would result in the thumbnail not being re-scraped
* FIX: Fixes issue where including Recipe and List in the same post would sometimes result in duplicate descriptions
* FIX: Fixes an issue where Cards used as List items would link to incorrect page
* FIX: Center ads used in Lists
* FIX: Prevents an issue where backspacing immediately after clicking a card would create an error when re-inserting the card
* FIX: Prevents issues where editor would sometimes load with empty content
* FIX: Improves size of images used by Grid layouts
* FIX: Prevents an error when global affiliate notice has not been set
* CHANGE: Changes the "Save" notice on the Settings page to be more visible
* CHANGE: List JSON-LD will only display in the canonical post for that link

= 1.3.1 =
* FIX: Change ad target for Mediavine publishers
* FIX: Fix missing Pinterest buttons
* FIX: CSS improvements for circle List layouts
* FIX: Grid layouts will display ads for Mediavine publishers in a separate row
* FIX: Regenerate images for List items if they don't exist
* CHANGE: Change "Duplicate" button to "Clone" button

= 1.3.0 =
New Content Type: Lists!
* The new "List" content type allows you to create curated link roundups of your other Create Cards, other posts on your site, or external URLs
* Lists support four beautiful layouts:
  * Hero – includes a large, Pinterest-friendly image
  * Grid – displays in a two-across grid
  * Numbered – includes a large number, great for "X Best _______" lists
  * Circles – displays images in a circle, looks great with the Classy Circle card theme!
* Links to Create cards can reference data from that card, for instance, cook time for a List of quick meals, calories for a List of diet-friendly recipes, or difficulty for a List of around-the-home projects
* Lists correspond to the Google's "Carousel" structured data type: https://developers.google.com/search/docs/guides/mark-up-listings
* All Lists include built-in content hints for Mediavine ads, including a setting to control frequency

Features & Enhancements
* Creating content on the run? The Create dashboard will look better on your phone or tablet
* Want to use one card as a base to make another? Cards now include a "Duplicate" button to save you from tedious copying and pasting
* Using a shortcode-friendly page builder instead of TinyMCE or Gutenberg? Cards now include shortcode snippet for you to copy and paste
* Never going to make a recipe or a how-to and overwhelmed by choice? We've added a setting to limit the types of content to choose from
* Support for dashboard internationalization
* Navigating to another page of cards will scroll you to the top of the new page
* Fixes an issue where the "Select Existing" UI in Gutenberg would display the wrong content type when multiple types of cards are added to a single post

Changes
* Cards without an author will use the default copyright attribution setting as the author
* Printed cards will include a URL back to the original post
* Icons in the Gutenberg block selector are now under their own heading and have a new and lovely splash of teal

= 1.3.2 =
* FIX: Restored card editor to last published data.

= 1.2.8 =
* FIX: Fix issue with scrolling breaking upon modal close
* FIX: Fix issues with editing images in posts

= 1.2.7 =
* FIX: Fix issue with taxonomy dropdowns sometimes not updating on click
* FIX: Fix issue where scheduled posts wouldn't create card associations necessary for canonical posts or review syncing

= 1.2.6 =
* ENHANCEMENT: Print button compatibility with security plugins that strip \<form\> tags from post content
* FIX: Prevent pinning of print pages
* FIX: Yield displays on Centered card themes when times have not been provided
* FIX: Fix issue where bulk ingredients would display as blank field during importing

= 1.2.5 =
* FIX: Fixes dropdowns like author and category in Gutenberg
* FIX: Provides a button to register with a different email address
* FIX: Prevents a nutrition notice from displaying when it shouldn't
* FIX: Fixes a bug in Mediavine Control Panel preventing videos from being deleted from posts

= 1.2.4 =
* Adds an upgrade notice for upcoming changes in the 1.3.0 release
* FIX: Fixes error on single Product pages
* FIX: Correctly disables card hero images from being targeted by Pinterest browser extension
* FIX: Fixes issue that was causing infinite loops with themes or plugins using the 'save_post' hook
* FIX: Provides backwards compatibility for custom card templates that used 'disable_nutrition' and 'disable_reviews' settings

= 1.2.3 =
* FIX: Add support for block tags
* FIX: Duplicate post association issues

= 1.2.2 =
* ENHANCEMENT: Improve UX around calculate button
* ENHANCEMENT: Add global nutrition disclaimer setting
* FIX: Fix issue with PHP 5.4 conflict
* COSMETIC: Better UI render on low-DPR screens

= 1.2.1 =
* FIX: Fix local storage conflict with nutrition calculation auth

= 1.2.0 =
* FEATURE: Free automatic nutrition calculation with simple plugin registration
* FEATURE: Option to have traditional nutrition label display
* FEATURE: Preview Google Rich Snippet with one click
* FEATURE: Full Gutenberg support
* FEATURE: Disable thumbnails in print cards
* FEATURE: List view of Create Cards
* FEATURE: Classic Editor button to access Create Card editor without scrolling

= 1.1.12 =
* FIX: Fix a bug with Pinterest not picking up Pinterest image

= 1.1.11 =
* FIX: Fix a bug with adding recommended products

= 1.1.0 =
* FIX: Provide ability to translate plural time units (e.g. "minutes")
* FIX: Fix issues with recommended product search
* FIX: Fix front-end JavaScript errors in IE11
* FIX: Fix "Add New" URL in sites running in subdirectories
* FIX: Print card style will always be default style

= 1.1.9 =
* FIX: Highest resolution image check only pulls from available sizes
* FIX: ShortPixel will no longer re-optimize images after card publish

= 1.1.8 =
* FEATURE: Track new ratings from Comment Rating Field pro
* FIX: Prevent TinyMCE application from mounting on the wrong editor

= 1.1.7 =
* FIX: Prevent app crash when adding multiple cards to a Gutenberg post
* FIX: Prevent error when filtering JSON-LD by unique image
* FIX: Prevent warning when rendering cards with no thumbnail images

= 1.1.6 =
* FIX: Adhere to recommendations for JSON-LD image sizes

= 1.1.5 =
* ENHANCEMENT: More reliable JSON-LD object for Google
* FIX: Remove unnecessary Autoptimize clear on activate and deactivate
* FIX: More reliable category and cuisine term names in JSON-LD
* FIX: Fixes issue where MCP videos would use mv_create shortcode
* FIX: Featured image displays properly in Gutenberg

= 1.1.4 =
* FIX: Make Pinterest description available to browser extension
* FIX: Fix display of thumbnail editor
* FIX: Improve rendered card styles for small phones
* FIX: Better display of images in card instructions
* FIX: Fix issue with print view on some servers
* FIX: Prevent Autoptimize from aggregating script localizations
* FIX: Prevent mv_create post types from creating redirects

= 1.1.3 =
* FIX: Improve responsive image size for recommended products
* FIX: Allow for default localization of time labels
* FIX: Improve Gutenberg integration

= 1.1.2 =
* ENHANCEMENT: Add .pot with plugin so users can generate translations (note: at the moment, translations will only appear on the front-end of the site. Back-end support is coming in a future release!)
* FIX: Prevent re-saving posts extraneously, fixing issues with <script> tags being stripped and pingbacks being triggered
* FIX: Resolve issue where deleting content from Instructions or Notes fields would leave remaining content
* FIX: Prevent admin CSS and JS from being cached
* COSMETIC: Various improvements for admin CSS and copy

= 1.1.1 =
* FEATURE: Remove tooltip from Instructions WYSIWYG
* FEATURE: Adding async to front-end javascript tag
* FEATURE: Track active filters when page is refreshed
* FIX: Eliminate Duplicate DB Call
* FIX: Prevent error with undefined properties field
* COSMETIC: Adding namespaces to admin CSS
* COSMETIC: Increase base font size to 16px on rendered cards

= 1.1.0 =
* FEATURE: Add support for registering custom fields to cards
* FEATURE: Add support for videos from YouTube
* FEATURE: Add button to settings to clear Create data from browser cache
* FEATURE: Add support for adding custom CSS classes on a per-card basis
* FEATURE: Add support for custom affiliate link notices, globally and on a per-card basis
* FIX: Correctly output JSON-LD schema for How-To content
* FIX: Fix conflict with The SEO Framework when adding a new card to a post with an assigned category
* FIX: Limit size of data stored in browser cache
* FIX: Prevent issue where card preview in WYSIWYG sometimes render as broken if certain tags were stripped
* FIX: Big hero theme respects "disable ratings" setting
* FIX: Improves query time when searching site for content within cards
* COSMETIC: Change instances of "Skin" to "Card Style"
* COSMETIC: `.mv-create-skin-{CARD-STYLE}` is now being replaced with `.mv-create-card-style-{CARD-STYLE}`

= 1.0.1 =
* FEATURE: Allow \<strong\>, \<em\>, and \<a\> tags in description field
* FEATURE: Add setting to disable product link scraping
* FEATURE: Automatically display an affiliate link notice on the front end for recommend products
* FIX: Prevent issue where cached recipes wouldn't show recent changes
* FIX: Remove unused sw.js file on the front-end of cards
* FIX: Fix strange cursor behavior when adding line breaks to instructions and notes fields
* FIX: Prevent crashes in IE11

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.4.17 =
* This update provides bug fixes to the plugin

= 1.4.16 =
* This update provides bug fixes to the plugin

= 1.4.15 =
* This update provides bug fixes to the plugin

= 1.4.14 =
* This update provides bug fixes to the plugin

= 1.4.11 =
* This update provides bug fixes to the plugin

= 1.4.10 =
* This update provides bug fixes to the plugin

= 1.4.9 =
* This update provides bug fixes to the plugin

= 1.4.8 =
* This update provides bug fixes to the plugin

= 1.4.7 =
* This update provides bug fixes to the plugin

= 1.4.6 =
* This update provides bug fixes to the plugin

= 1.4.5 =
* Adds new admin UI, public reviews, and several other features. WordPress 5.0 or greater is required.

= 1.3.22 =
* This update provides bug fixes to the plugin

= 1.3.16 =
* This update provides bug fixes to the plugin

= 1.3.15 =
* This update provides bug fixes to the plugin

= 1.3.14 =
* This update provides bug fixes to the plugin

= 1.3.13 =
* This update provides bug fixes to the plugin

= 1.3.12 =
* This update provides bug fixes to the plugin

= 1.3.11 =
* This update provides bug fixes to the plugin

= 1.3.10 =
* This update provides bug fixes to the plugin

= 1.3.9 =
* This update provides bug fixes to the plugin

= 1.3.8 =
* This update provides bug fixes to the plugin

= 1.3.7 =
* This update provides bug fixes to the plugin

= 1.3.6 =
* This update provides bug fixes to the plugin

= 1.3.3 =
* This update provides bug fixes to the plugin

= 1.3.1 =
* This update provides bug fixes to the plugin

= 1.3.0 =
* Adds "Lists" content type and several other features

= 1.2.8 =
* This update provides bug fixes to the plugin

= 1.2.7 =
* This update provides bug fixes to the plugin

= 1.2.6 =
* This update provides bug fixes to the plugin

= 1.2.5 =
* This update provides bug fixes to the plugin

= 1.2.4 =
* This update provides bug fixes to the plugin

= 1.2.3 =
* This update provides bug fixes to the plugin

= 1.2.2 =
* This update provides bug fixes to the plugin

= 1.2.1 =
* This update provides bug fixes to the plugin

= 1.2.0 =
* Free nutrition calculation and full Gutenberg support

= 1.1.12 =
* This update provides bug fixes to the plugin

= 1.1.11 =
* This update fixes a bug with adding new Recommended Products

= 1.1.10 =
* This update provides bug fixes to the plugin

= 1.1.9 =
* This update provides bug fixes to the plugin

= 1.1.8 =
* This update provides bug fixes to the plugin

= 1.1.7 =
* This update provides bug fixes to the plugin

= 1.1.6 =
* This update fixes an issue with the image sizes included in JSON-LD markup

= 1.1.5 =
* This update provides bug fixes to the plugin

= 1.1.4 =
* This update provides bug fixes to the plugins

= 1.1.3 =
* This update provides bug fixes to the plugin

= 1.1.2 =
* This update provides bug fixes to the plugin

= 1.1.1 =
* This update provides bug fixes to the plugin

= 1.1.0 =
* This update adds custom field and YouTube support and JSON-LD for How-To content

= 1.0.1 =
* This update fixes some initial bugs with the plugin
