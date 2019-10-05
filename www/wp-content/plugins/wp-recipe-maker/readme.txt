=== WP Recipe Maker ===
Contributors: BrechtVds, BirtheVdm
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=QG7KZMGFU325Y
Tags: recipe, recipes, ingredients, food, cooking, seo, schema.org, json-ld
Requires at least: 4.4
Tested up to: 5.2
Requires PHP: 5.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The easy and user-friendly recipe plugin for everyone. Automatic JSON-LD metadata for food AND how-to recipes will improve your SEO!

== Description ==

[WP Recipe Maker](https://bootstrapped.ventures/wp-recipe-maker/) is the easy recipe plugin that everyone can use. An easy workflow allows you to add recipes to any post or page with automatic JSON-LD metadata for your recipes. This metadata will improve your SEO and get you more visitors!

Would you like to see the plugin in action before installing it? We have a [WP Recipe Maker demo website](https://demo.wprecipemaker.com) showcasing all of our features! 

> <strong>Get the most out of WP Recipe Maker!</strong><br>
> Join our [self-paced email course](https://www.getdrip.com/forms/86388969/submissions/new) and we'll help you get started and learn all the tips and trick for using this plugin.

= Features =
An overview of WP Recipe Maker features:

*   Compatible with both the Classic Editor and new **Gutenberg** editor
*   Includes an **Elementor block** and shortcode can be used in other page builders
*   **Easy workflow** to add recipes to any post or page
*   Uses schema.org/Recipe JSON-LD metadata optimised for **Google Recipe search**
*   Uses schema.org/How-to JSON-LD metadata optimised for **non-food recipes and instructions**
*   Integrates recipe metadata with Yoast **SEO schema graph**
*   Option to **disable metadata per recipe** if you want to publish non-food or DIY recipes
*   Compatible with **Pinterest Rich Pins** and a setting to easily opt out
*   Outputs ItemList metadata for **Recipe Roundup** posts
*   **Recipe ratings** in the user comments
*   Clean **print recipe** version for your visitors with optional credit to your website
*   **Fallback recipe** shows up when the plugin is disabled
*   Include a **recipe video** in the template and metadata
*   Add **photos** to any step of the recipe
*   Print recipe and **jump to recipe** shortcodes
*   This plugin is **fully responsive**, your recipes will look good on any device
*   Easily change the look and feel to fit your website in the **Template Editor**
*   Structure your ingredients and instructions in **groups** (e.g. icing and cake batter)
*   **Full text search** for your recipes
*   Access your recipes through the WordPress **REST API**
*   Built-in **SEO check** for your recipe metadata
*   Compatible with **RTL** languages
*   **Import your recipes** from other plugins (see below)

= WP Recipe Maker Premium =

Looking for some more advanced functionality? We also have the [WP Recipe Maker Premium](https://bootstrapped.ventures/wp-recipe-maker/) add-on available with the following features:

*   Use **ingredient links** for linking to products or other recipes
*   **Adjustable servings** make it easy for your visitors
*   Display all nutrition data in a **nutrition label**
*   **User Ratings** allow visitors to vote without commenting
*   Add a mobile-friendly **kitchen timer** to your recipes
*   More **Premium templates** for a unique recipe template
*   Create custom **recipe taxonomies** like price level, difficulty, ...
*   Use **checkboxes** for your ingredients and instructions

Even more add-ons can add the following functionality:

*   Integration with a **Nutrition API** for automatic nutrition facts
*   **Unit Conversion** to reach an international audience with a different unit system
*   Have your users send in recipes through the **Recipe Submission** form
*   Give your visitors the power of **Recipe Collections** for favourites, meal planning and more

= Import Options =

Currently using another recipe plugin? No problem! You can easily migrate all your existing recipes to WP Recipe Maker if you're using any of the following plugins:

*   Tasty Recipes
*   Create by Mediavine
*   EasyRecipe
*   WP Ultimate Recipe
*   Meal Planner Pro
*   BigOven
*   ZipList and Zip Recipes
*   Yummly
*   Yumprint Recipe Card
*   FoodiePress
*   Cooked
*   Cookbook
*   Simple Recipe Pro
*   Purr Recipe Plugin
*   Recipes by Simmer
*   WordPress.com shortcode
*   (Need anything else? Just ask!)

This plugin is in active development. Feel free to contact us with any feature requests or ideas.

== Installation ==

1. Upload the `wp-recipe-maker` directory (directory included) to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add recipes using the "WP Recipe Maker" button when editing posts or pages

== Frequently asked questions ==

= Where can I find a demo and some more documentation? =
Check out the [WP Recipe Maker sales site](https://bootstrapped.ventures/wp-recipe-maker/), [demo website](https://demo.wprecipemaker.com) and [WPRM documentation](https://help.bootstrapped.ventures/collection/1-wp-recipe-maker) for more information on all of our features!

= What's the difference with WP Ultimate Recipe? =

[WP Ultimate Recipe](http://www.wpultimaterecipe.com/) is the popular recipe plugin that we released in 2013 and have been working on ever since. This gave us a great idea of what most food bloggers are looking for.

Why the new plugin? A few structural choices we made early on have caused WP Ultimate Recipe to be quite complex and not 100% compatible with all themes. With WP Recipe Maker we're building the perfect recipe plugin from scratch, without all the baggage of years of development.

WP Ultimate Recipe is still in active development and will be maintained alongside this new alternative.

= Do you offer any support? =

Yes! We pride ourselves on offering awesome support and almost always answer support questions within 24 hours. Send us an email at [support@bootstrapped.ventures](mailto:support@bootstrapped.ventures) whenever you have a question or suggestion!

== Screenshots ==

1. Example recipe using the default Compact template.
2. Our Template Editor allows you to completely customize the look and feel.
3. A powerful manage pages gives you full control over your recipes.
4. The recipe input form.
5. Fully compatible with the Gutenberg Block Editor.
6. Fully compatible with the Classic Editor.

== Changelog ==
= 5.6.0 =
* Feature: Setting to not output ItemList metadata when there is already recipe metadata
* Feature: Disable pinning of external roundup item images
* Improvement: Import courses and cuisines from ziplist
* Improvement: Use oEmbed for Mediavine video metadata
* Fix: thumbnailUrl issue in video metadata for how-to instructions
* Fix: Compatibility with Lazy Load for Comments plugin
* Fix: Problem with parentheses in import from text
* Fix: Correct template styles for Elementor block
* Fix: Don't output automatic snippets for the excerpt

= 5.5.3 =
* Fix: Make sure comment rating stars only show up when there is a recipe in the post
* Fix: Jetpack warning showing up on settings page incorrectly

= 5.5.2 =
* Fix: Rich text field issues in Firefox

= 5.5.1 =
* Fix: Make sure JS gets localized in correct order

= 5.5.0 =
* Feature: Option to open external roundup link in same tab
* Feature: Unit separator option for nutrition blocks
* Improvement: Only load WPRM assets when needed
* Improvement: Alt tag for comment star rating
* Improvement: Use summary in custom pin description
* Fix: Issue when saving numbers as taxonomy terms
* Fix: Elementor Recipe Block not saving correctly
* Fix: Prevent HTML issue from breaking Template Editor preview
* Fix: Safari 10 compatibility

= 5.4.3 =
* Fix: Make sure recipe metadata shows up in all situations
* Fix: BPS Security plugin compatibility

= 5.4.2 =
* Improvement: Open name and image links in new tab for external roundup items
* Fix: Nutrition Shortcode not showing unit
* Fix: Make sure comment ratings for trashed comments don't show

= 5.4.1 =
* Improvement: Check if Yoast graph is using article metadata or not
* Fix: Prevent scripts from loading on AMP pages

= 5.4.0 =
* Feature: Import for Create by Mediavine
* Feature: Revision Manager TMC compatibility
* Improvement: Yoast SEO graph compatibility
* Improvement: Make sure contentUrl is set in oEmbed video metadata
* Improvement: Show equipment in classic editor preview
* Fix: Prevent wpautop bug from breaking recipe layout
* Fix: Incorrectly thinking changes were made in some cases

= 5.3.3 =
* Fix: Problem with Find Ratings tool

= 5.3.2 =
* Fix: Shortcode in block problem not resolving

= 5.3.1 =
* Fix: Shortcode problem

= 5.3.0 =
* Feature: Show number of ratings with shortcode
* Improvement: Parent Post ID on the ratings manage page
* Improvement: More fraction symbols in rich editor
* Fix: TAB key problem in MS Edge
* Fix: How-to Instructions metadata problem with unnamed sections
* Fix: Don't count ratings of unapproved comments
* Fix: Make sure snippet template CSS gets loaded when not adding automatically
* Fix: Double recipe metadata on AMP pages when using Yoast SEO
* Fix: Paragraph spacing issues when using alignment
* Fix: Prevent PHP notice in admin
* Fix: Divi adding extra bracket to shortcode output
* Fix: Bulk Edit terms dropdown not changing

= 5.2.1 =
* Feature: Set different template per recipe type
* Improvement: Make sure metadata gets output but only once
* Improvement: Speed up comment ratings query
* Improvement: Menu for the manage page
* Improvement: Equipment in import from text feature
* Improvement: Range parsing for ingredient amounts
* Improvement: Setting to change clickable image size
* Improvement: Option to show instruction image before the text
* Fix: Settings not showing up correctly in some cases
* Fix: Bloom plugin compatibility

= 5.2.0 =
* Feature: Use external links for Roundup Items
* Feature: Output How-to metadata for DIY and craft recipes
* Feature: Estimated cost field
* Feature: Recipe equipment section
* Feature: View trash on manage page
* Improvement: Edit roundup items in Gutenberg editor
* Improvement: Clean up HTML in import from text feature
* Improvement: Cache ingredient suggestions in modal
* Improvement: Use global ingredient links as default when switching to custom
* Improvement: Don't shrink image in Snippet Summary template
* Improvement: Working WPURP shortcode for converted recipes after import
* Fix: Make sure REST API always gets latest version
* Fix: Time shortcode selection in Template Editor
* Fix: Yoast metadata integration for the "other" recipe type

= 5.1.1 =
* Fix: Elementor PHP warning

= 5.1.0 =
* Feature: Integration with Yoast SEO 11 schema graph for the recipe metadata
* Feature: "WPRM Recipe" block in Elementor page builder
* Feature: Show and bulk edit recipe type on manage page
* Improvement: Add HTML or shortcode in rich text fields
* Improvement: Allow browser autocomplete for input fields
* Improvement: Try to prevent REST API nonce issues
* Improvement: Clean up cut and copy from rich text fields
* Improvement: Show "Saved successfully" in modal
* Fix: Alert message when clicking on some buttons
* Fix: Not recognizing all amounts during import in some PHP environments
* Fix: Keep serving size field after nutrition calculation
* Fix: Order of time input fields for RTL languages
* Fix: Prevent video embed code PHP warnings

= 5.0.4 =
* Fix: ID undefined when creating new recipe in Classic Editor
* Fix: Do not show a time of 0 in the metadata

= 5.0.3 =
* Fix: Performance issues with typing in new modal
* Fix: Emulate PUT and DELETE API calls for better compatibility
* Fix: Comet Cache compatibility problem when saving a recipe
* Fix: Prevent error when opening ingredient links tab in free version

= 5.0.2 =
* Improvement: Include debug information when API call fails
* Fix: Video embed not working in some cases
* Fix: Dismissing of notices would not work for next one

= 5.0.1 =
* Improvement: Show error that occurs on Manage page to send to support
* Fix: Prevent missing fields from breaking manage page

= 5.0.0 =
* Feature: Brand new recipe modal
* Feature: Brand new manage page
* Feature: Save revisions for recipes
* Feature: Copy to JSON when saving fails
* Feature: Autosuggest existing ingredients
* Feature: Ratings on the Manage page
* Feature: Output 0 for cook and prep time in metadata
* Feature: Show "0" in template for cook, prep or custom times
* Feature: Link image and name block to recipe URL (for roundup)
* Improvement: Allow links in ingredient and instruction group headers
* Improvement: Reduce rating queries
* Improvement: Support more formats for custom icon
* Improvement: Keywords and total time in WP Tasty import
* Improvement: Replace WP Tasty recipes in Gutenberg after import
* Improvement: Use recipe name placeholder in roundup link
* Improvement: Adjustable servings in recipe roundup
* Fix: Prevent closing bracket from breaking shortcode in Template Editor
* Fix: Double block properties when editing roundup template

= 4.3.4 =
* Feature: Set same author name for every recipe
* Fix: Prevent incorrect ID from breaking recipe roundup shortcode
* Fix: Print link when using plain permalinks

= 4.3.3 =
* Improvement: Setting to output metadata in either head or body
* Improvement: Only automatically output snippets on posts, not pages
* Improvement: Legacy mode setting for comment rating placement
* Fix: Specificy VideoObject type for video metadata
* Fix: Prevent WP_Error when getting YouTube metadata
* Fix: Revisionize compatibility for parent post

= 4.3.2 =
* Fix: Deprecated notice related to oEmbed cache

= 4.3.1 =
* Improvement: Consistent image size in Roundup Summary template
* Improvement: Clear oEmbed cache when no video metadata is found
* Fix: Issue with 2 recipes in 1 post on archive page
* Fix: Visual Composer compatibility
* Fix: PHP warning with nutrition label on print page

= 4.3.0 =
* Feature: Recipe Roundup for ItemList metadata
* Feature: Setting to prevent printing of non-published recipes
* Fix: Image position in print version for some browsers
* Fix: Overlap when selecting icons in Template Editor
* Fix: Update post status when parent post gets deleted

= 4.2.1 =
* Feature: Change link for Jump to Comments button
* Feature: Change position of rating field in comment form
* Improvement: Better default image sizes
* Improvement: Prevent WP Rocket lazy image loading on print page
* Improvement: Try to prevent conflict with generic [recipe] shortcode
* Improvement: Change print template for multilingual sites
* Fix: Color of rating stars in comment form
* Fix: Print button with query parameters

= 4.2.0 =
* Feature: Searchable and fallback recipe for Gutenberg blocks
* Feature: Setting to only show metadata for first recipe on page
* Feature: Polylang compatibility for changing recipe template in different languages
* Feature: Option to disable recipe and instruction image pinning
* Feature: Set instruction margin in Template Editor
* Feature: Set different template for RSS Feed
* Feature: Use recipe shortcodes in WP Ultimate Post Grid template
* Feature: Import Recipes by Simmer
* Feature: Import WordPress.com recipe shortcode
* Improvement: Restrict access to print version for non-published recipes
* Improvement: Add metadata to head instead of body
* Improvement: Drastically reduce DOM nodes for comment stars
* Improvement: Labels in template easier to translate
* Improvement: Classes for rating stars on hover
* Improvement: Date placeholder for print credit
* Fix: Changing instruction images size not working in some cases
* Fix: Use correct recipe default for shortcode on archive pages
* Fix: Bug in Elementor removing our admin menu
* Fix: PHP 7.3 compatibility for EasyRecipe import
* Fix: Print not always matching template

= 4.1.1 =
* Fix: Styling for automatic snippets in Legacy Mode

= 4.1.0 =
* Feature: Shortcode to display recipe snippets
* Improvement: Prevent other plugin notices from breaking the Template Editor layout
* Fix: Jump to Video button in Legacy templates
* Fix: Call to Action link color when using custom link action


= 4.0.8 =
* Improvement: Recipe block preview in Gutenberg editor
* Improvement: Filter by "No terms set" on the Manage page
* Fix: Make sure snippets only show up for posts containing a recipe
* Fix: EasyRecipe import not finding all recipes when encountering error

= 4.0.7 =
* Fix: Gutenberg 4.5.1 compatibility
* Fix: Convert to Gutenberg blocks for recipe shortcodes
* Fix: Translations in "Simple" nutrition label

= 4.0.6 =
* Fix: Prevent z-index problems in legacy templates
* Fix: Preview of some shortcodes in the Template Editor
* Fix: Prevent Template Editor from breaking in "Edit HTML" mode
* Fix: Don't show dateModified in metadata anymore to prevent rich snippet issues

= 4.0.5 =
* Fix: Prevent variable problem from breaking custom template

= 4.0.4 =
* Feature: Property to open CTA custom links in same or new tab and as nofollow
* Improvement: Separate stylesheet for modern mode to prevent legacy template conflicts
* Fix: Don't add inline styling to recipe snippet buttons in legacy mode
* Fix: Only include default.css for non-custom templates
* Fix: Make sure recipe metadata shows up on AMP pages

= 4.0.3 =
* Improvement: Speed and resource usage of Template Editor preview
* Improvement: Print page HTML code
* Fix: Line breaks in summary, instructions and notes
* Fix: Print button not clickable in some Legacy templates
* Fix: Ingredient links in clean legacy template

= 4.0.2 =
* Fix: Template Editor error when creating your own template in the theme folder
* Fix: Star ratings in legacy clean template

= 4.0.1 =
* Improvement: Prevent caching issue from breaking the backend
* Fix: Red stars in compact template
* Fix: Boxes and Columns container with large images
* Fix: User rating hovering problem in legacy mode
* Fix: Internet Explorer 11 compatibility

= 4.0.0 =
* Feature: Template Editor
* Feature: Set specific template for recipe block in Gutenberg
* Feature: Set different template for recipe archive pages
* Feature: Pin Recipe button
* Feature: Jump to comment form shortcode
* Feature: Recognize VideoObject meta tags in video embed code
* Feature: Include dateModified in metadata
* Improvement: Get rid of paragraphs in summary and instructions to prevent styling issues
* Improvement: Add slight delay to print dialog to make sure page is fully loaded
* Improvement: Match multiple URLs for MediaVine embed videos
* Improvement: Add Cookbook instruction images to previous instruction instead of separate line
* Improvement: Default options for the recipe dropdowns
* Fix: Import problem with multiple images on the same line
* Fix: Import instruction groups from Simple Recipe Pro correctly
* Fix: Yoast readability highlighter with recipe in post
* Fix: Loading incorrect ingredient links
* Fix: Prevent recursion issue when a recipe is added to its own notes
* Fix: NaN problem in Unit Conversion
* Fix: Prevent unit conversion issues when using numbers in the ingredient name
* Fix: Should not mix noindex and canonical on print page
* Fix: Remove blank lines in HTML fields when saving
* Fix: Translation JS errors in Gutenberg

= 3.2.1 =
* Fix: Allow shortcodes in new recipe shortcodes

= 3.2.0 =
* Feature: Shortcodes for different recipe parts
* Feature: Setting to show recipe and/or instruction images on the print page
* Feature: Jump to Recipe Video shortcode and block
* Improvement: Ignore recipe shortcode in Yoast SEO readability test
* Improvement: Show ingredient links when using one of the print templates
* Improvement: Own category for WP Recipe Maker blocks in Gutenberg
* Improvement: Import Meal Planner Pro instruction images
* Improvement: Import ingredient links for various plugins
* Improvement: Import ingredient links from various plugins
* Improvement: Import instruction links and styling from various plugins
* Improvement: Register settings and labels for translation in WPML
* Fix: Import ingredient and instruction groups in Cookbook
* Fix: Update recipe rating when comment gets trashed
* Fix: Update recipe rating when (un)approving comments
* Fix: Only update post content in find parents tool when necessary
* Fix: Scheduled recipes showing in recipe grid
* Fix: First letter of paragraph not displaying correctly on print page for iOS
* Fix: PHP Error caused by fallback recipe
* Fix: Using > sign in Custom Styling

= 3.1.2 =
* Feature: Gutenberg blocks and compatibility
* Improvement: Plugin hooks to change star icon

= 3.1.1 =
* Fix: Fatal error when embedding unpublished Youtube videos

= 3.1.0 =
* Feature: Full video metadata when using Youtube
* Feature: Use WordPress embed shortcode when using a URL for the video
* Feature: Import from Purr Recipe plugin
* Feature: Video metadata for WP YouTube Lyte plugin
* Improvement: Cache video metadata for 7 days
* Improvement: Cache recipe rating to improve performance
* Improvement: Cache comment ratings in meta to reduce database queries
* Fix: Only show recipe snippets in main query
* Fix: Prevent theme compatibility issue with first letter in paragraph

= 3.0.3 =
* Fix: Make sure settings JS is loaded after admin JS
* Fix: Don't cache settings structure to prevent issues with some settings not showing up
* Improvement: Hide notices on settings page

= 3.0.2 =
* Fix: Another settings problem in some environments

= 3.0.1 =
* Fix: Settings problem in some environments

= 3.0.0 =
* Feature: Brand new settings page
* Feature: Add video metadata for the Adthrive shortcode
* Feature: Support video metadata for oEmbed (YouTube, Vimeo, ...)
* Feature: Import ratings from Comment Rating Field plugin
* Improvement: Cache video metadata

= 2.5.3 =
* Improvement: Keep ingredient styling in EasyRecipe import
* Fix: Make sure print page is always noindex
* Fix: Prevent datatables conflicts with other plugins

= 2.5.2 =
* Improvement: Privacy policy suggestions
* Improvement: Don't use Google CDN
* Improvement: Support author queries through REST API
* Fix: Mediavine embed in Tastefully Simple template
* Fix: GLOB_BRACE warning when not defined on system
* Fix: Nutrition label warning

= 2.5.1 =
* Feature: Ability to embed instead of upload the recipe video
* Feature: Automatically add embedded Mediavine video metadata
* Improvement: Ability to save when getting logged out during editing

= 2.5.0 =
* Feature: Recipe video with metadata
* Feature: Ability to disable pinning to Pinterest on the print page
* Feature: Setting to hide keywords from recipe template
* Improvement: Change keyword label from settings
* Improvement: Use correct format for date in metadata
* Improvement: Noindex print page if parent post is not set

= 2.4.1 =
* Feature: Support for new Google Assistant keywords metadata
* Feature: Use new HowToStep and HowToSection for recipeInstructions metadata
* Improvement: Canonical URL on Print page

= 2.4.0 =
* Feature: Ability to set recipe type as "Non-Food" and not output metadata
* Feature: User and comment ratings accessible via REST API
* Feature: Compatible with Classic block in Gutenberg
* Improvement: Find Simple Recipe Pro ratings with the "Find Ratings" tool
* Fix: Ability to remove comment rating
* Fix: Prevent ratings migration from showing up on first install

= 2.3.0 =
* Feature: Import support for new Simple Recipe Pro update
* Feature: Allow HTML to be used as text for the print and jump shortcodes
* Improvement: Nofollow for print links in recipe template
* Improvement: Adjust height of tooltip on manage page to fit content
* Improvement: wpautop for recipe notes
* Improvement: Wider input fields for numbers
* Improvement: Allow more HTML tags in recipe text

= 2.2.2 =
* Fix: Get rid of ratings warning

= 2.2.1 =
* Fix: Showing all ratings when there were no ratings yet

= 2.2.0 =
* Feature: Optional custom time field for resting, cooling, ...
* Feature: Setting for default custom author name
* Improvement: Tool to find missing recipe ratings from settings page
* Improvement: Site icon on print page
* Improvement: Separate instructions steps better in Simple Recipe Pro import
* Fix: Times not showing in Tastyfully Simple template when Prep Time was not filled in
* Fix: Not all information showing in nutrition label when only some nutrients were filled in
* Fix: HTML Entities when editing ingredient fields

= 2.1.1 =
* Fix: Remove !important flags from AMP CSS output
* Fix: Don't show 0 values in nutrition label after importing

= 2.1.0 =
* Feature: Recipe styling on AMP pages
* Feature: Set instruction image alignment on settings page
* Feature: Tool to automatically find parent posts
* Feature: Import user ratings from Zip Recipes Premium
* Feature: Import comment ratings from Meal Planner Pro
* Feature: Import recipes from Cookbook recipe plugin
* Feature: Import recipes from Simple Recipe Pro
* Improvement: Use actual link for print button
* Improvement: Don't apply custom CSS to print page when feature is disabled
* Improvement: Use svg for TinyMCE button icon
* Improvement: Set standard text alignment for recipe template
* Fix: Not finding MealPlannerPro recipes to import
* Fix: Filter manage table when clicking through from taxonomy

= 2.0.0 =
* Plugin restructure for performance improvements and Premium bundle system

= 1.27.0 =
* Feature: Create and update recipes via REST API
* Improvement: Only show automatically added snippets on singular pages
* Improvement: Only show warning when changes have actually been made
* Improvement: Introduction video on the welcome page
* Fix: Status of recipes in scheduled posts
* Fix: Show correct plural or singular form for hours
* Fix: Prevent PHP notice caused by metadata

= 1.26.1 =
* Fix: Modal overlay problem

= 1.26.0 =
* Feature: Setting to automatically add recipe snippets like Jump to Recipe
* Feature: Create recipes on the Manage page
* Feature: Import from Cooked recipe plugin
* Improvement: Ability to reset settings to defaults
* Fix: Prevent issue with image metadata in different thumbnail sizes
* Fix: Prevent trashing parent post from trashing recipe
* Fix: Recipe image not loading when using Fly Dynamic Image Resizer

= 1.25.0 =
* Feature: Show recipe rating on manage page
* Feature: Remove inline metadata for recipes, using JSON-LD metadata only now
* Feature: Present multiple image sizes to Google in the metadata
* Feature: Setting to opt out of Pinterest Rich Pins
* Feature: Import from FoodiePress
* Improvement: Top margin for nutrition label inside recipe box
* Improvement: Don't fill in serving unit automatically when empty
* Fix: Correct font from settings applied to Tastefully Simple template

= 1.24.0 =
* Improvement: Only show ratings given by an enabled feature
* Improvement: Import title in older versions of EasyRecipe recipes
* Improvement: Prevent instruction list style icon position problem
* Fix: Default author setting not working
* Fix: Prevent PHP warning when saving posts

= 1.23.1 =
* Fix: Make sure recipe rating is updated
* Fix: Inline rating metadata when there are no votes yet

= 1.23.0 =
* Feature: Import WP Tasty Recipes
* Improvement: Better handling of shortcodes in JSON-LD metadata
* Fix: Problem with double recipes in categories
* Fix: Jetpack Contact Form compatibility problem on manage page

= 1.22.0 =
* Feature: RTL support for recipe templates and print
* Improvement: Print and unit conversion functionality when using the print templates
* Improvement: Combined public JS files
* Improvement: Apply appearance settings to print template as well
* Improvement: Recipe rating saved as post meta
* Improvement: Migrate WP Ultimate Recipe Premium user ratings
* Fix: Heading style dropdown in Recipe Notes

= 1.21.0 =
* Feature: change ingredients and instructions list style from settings page
* Feature: Rename terms on the manage page
* Feature: Associate same categories as parent post with recipes
* Improvement: Correctly apply font size setting to Tastefully Simple template
* Improvement: Ability to override the comment rating templates
* Fix: Prevent Firefox list style position issue
* Fix: Make sure Premium version loads with all directory names
* Fix: Prevent empty nutrition label from showing up

= 1.20.0 =
* Feature: Intermediate save when creating or editing recipes
* Feature: Settings to personalize the ingredient text import
* Improvement: Abbreviations in ingredient text import
* Improvement: Immediately update parent post when importing
* Improvement: Try to fix serialize issues when getting ingredients or instructions
* Improvement: Prevent styling differences in instructions
* Fix: EasyRecipe recipes stuck in to import list
* Fix: Remove leftover debug code

= 1.19.1 =
* Fix: PHP Notice when saving recipes

= 1.19.0 =
* Feature: Sub- and superscript in summary and instructions
* Feature: Allow for basic HTML in ingredients
* Feature: Setting to align nutrition label left, center or right
* Improvement: Streamlined import process using AJAX
* Fix: Ingredients not importing when going too fast in the text import
* Fix: Prevent wpautop from breaking our icons
* Fix: Prevent compatibilty bugs when saving posts

= 1.18.0 =
* Feature: Add custom styling to the recipe print page
* Feature: Bulk delete ingredients
* Improvement: Easy edit and view links for imported recipes
* Fix: Prevent jumping to the top on the manage page
* Fix: Print URL without trailing slash

= 1.17.1 =
* Fix: Ingredient import problem

= 1.17.0 =
* Feature: Setting to disable the output of inline CSS
* Improvement: Better import of ingredient notes
* Improvement: Prevent themes from messing up the recipe template
* Fix: Duplicate slug problem

= 1.16.0 =
* Feature: Change image sizes in settings
* Feature: Recipe placeholders for print credit
* Feature: Change position of the comment rating stars
* Improvement: Easier access to next recipes on import page
* Improvement: change comment rating label
* Improvement: Support unicode units when parsing ingredients
* Improvement: Ability to save empty ingredient and  instruction groups
* Improvement: Print shortcode works without JS as well (AMP pages)
* Improvement: Click on SEO indicator to edit recipe
* Fix: Search filter in WP Ultimate Post Grid
* Fix: Saving links for new ingredients in Premium plugin

= 1.15.0 =
* Feature: SEO check on manage page
* Feature: Change recipe template fonts from settings
* Feature: Show latest or random recipe with the shortcode
* Improvement: Show preview of links in recipe summary and instructions
* Improvement: Import Recipe Card adapted field to recipe notes
* Improvement: More information in shortcode preview
* Fix: Disappearing characters in text import
* Fix: Don't replace encoded characters in ingredient links
* Fix: Query issues on import recipes page

= 1.14.1 =
* Feature: Setting to change access to import recipes page
* Improvement: Better parsing of ingredients during import
* Improvement: Stay on correct page after reloading datatable
* Fix: Ability to remove ingredient links again

= 1.14.0 =
* Feature: Edit Recipe button for easy access
* Feature: Setting to set capability required for the manage page
* Improvement: Shortcode preview shows entire recipe
* Improvement: Taxonomies in REST API
* Improvement: AggregateRating details in inline metadata even when not shown
* Improvement: Better parsing of ingredient notes
* Fix: Clearfix for recipe container
* Fix: Manage page filters appearing over modal
* Fix: Pagination on taxonomy manage pages

= 1.13.0 =
* Feature: Filter recipes on manage page by ingredients and tags
* Feature: Change comment rating stars color in the settings
* Improvement: Mobile template of Tastefully Simple
* Fix: Problem with unwanted redirections by the Redirection plugin
* Fix: Problem with unwanted redirections by the Yoast SEO Premium plugin
* Fix: Prevent warnings on settings page

= 1.12.1 =
* Fix: Recipe Card import of instructions

= 1.12.0 =
* Feature: Print Credit message
* Feature: Add existing recipe through modal
* Feature: Import Yummly recipes
* Feature: Import Yumprint Recipe Card recipes
* Fix: Issue with shortcode preview displaying on the front-end
* Fix: Prevent importing empty lines
* Fix: Prevent datatable from outputting errors as alerts
* Fix: Empty ingredient groups in text import
* Fix: Text import unit issue in some languages

= 1.11.0 =
* Improvement: Set default value for Author Display field
* Improvement: Noindex the print page
* Improvement: Better margins for recipe image in Tastefully Simple
* Fix: Make sure correct nutrition label is shown with multiple recipes on a page
* Fix: Tastefully Simple template image on mobile

= 1.10.1 =
* Fix: Activation issue for hosts using an old version of PHP

= 1.10.0 =
* Feature: Change recipe template colors in the settings
* Feature: Change recipe template labels in the settings
* Feature: Manage courses and cuisines
* Improvement: Show days in recipe times
* Improvement: Recipe import performance
* Improvement: Prevent accidental closing of the modal
* Improvement: Setting to use featured image of parent post
* Improvement: Prevent recipe getting overwritten by our other shortcodes
* Fix: Prevent issue with post content replacing recipe notes
* Fix: Only import numbers for nutrition facts
* Fix: WordFence Compatibility

= 1.9.1 =
* Feature: WP Recipe Maker icon in TinyMCE editor
* Fix: Ingredients settings page

= 1.9.0 =
* Feature: Manage recipes and ingredients in a central place
* Feature: Edit recipes through the WP Recipe Maker button
* Fix: Prevent Divi Builder bug

= 1.8.0 =
* Feature: Import from ZipList and Zip Recipes
* Improvement: Increased performance of recipe dropdowns
* Improvement: Don't output JSON-LD metadata in RSS feed
* Improvement: Use fallback recipe in RSS feed
* Improvement: Easier to select multiple recipes for import
* Improvement: Indicate recipes without parent post in import
* Fix: Use correct default feature settings

= 1.7.1 =
* Fix: Associate all ingredient terms with recipes

= 1.7.0 =
* Feature: Import recipe from text
* Feature: Add nofollow links in summary and instructions
* Feature: Import recipes from Meal Planner Pro
* Feature: Import recipes from BigOven
* Improvement: Setting to disable comment ratings
* Improvement: Recognize unicode fractions when importing ingredients
* Improvement: Import nutrition facts from WP Ultimate Recipe
* Fix: Only show nutritional metadata if present
* Fix: Consistent behaviour for automatic time calculations

= 1.6.1 =
* Improvement: Show warning if EasyRecipe is breaking things

= 1.6.0 =
* Feature: Show hours for longer recipe times
* Improvement: Prevent font size inconsistencies in template
* Fix: Don't associate recipes with revisions
* Fix: Capital letters in template names

= 1.5.0 =
* Feature: Set recipe author
* Improvement: Sanitize metadata before outputting
* Fix: Warning when adding comments as a subscriber
* Fix: Compatibility issue with Jetpack
* Fix: Prevent infinite shortcode loop

= 1.4.0 =
* Feature: Access recipes though REST API
* Feature: Choose specific recipe template in shortcode
* Improvement: Check for leftover ER comment ratings when importing from WP Ultimate Recipe
* Improvement: Execute shortcodes in the recipe template
* Fix: Include correct stylesheet when using recipe templates from theme
* Fix: Show all recipes to be checked instead of just 8 recipes
* Fix: Use correct print URL if WordPress is in a subdirectory
* Fix: Linebreak accumulation when updating recipes
* Fix: Prevent Post Type Switcher plugin bug from breaking recipes

= 1.3.0 =
* Feature: Import from WP Ultimate Recipe
* Feature: wpDiscuz support for comment ratings
* Improvement: Use photo from Photo tab when importing from EasyRecipe
* Improvement: Check for custom templates in both parent and child theme
* Improvement: Different print system for better browser compatibility
* Fix: Round average comment rating to 2 decimals

= 1.2.0 =
* Feature: New "Tastefully Simple" template, similar to EasyRecipe
* Feature: New "Clean Print with Image" recipe template
* Feature: Print recipe shortcode
* Feature: Jump to recipe shortcode
* Improvement: Shortcode preview includes image and summary
* Fix: use ratingCount instead of reviewCount for JSON-LD metadata
* Fix: Trailing slash issue in asset URLs

= 1.1.0 =
* Feature: Comment ratings with metadata
* Feature: Inline metadata for Pinterest rich pins
* Feature: Calories field for nutrition metadata
* Improvement: FAQ pages
* Improvement: Strip HTML from JSON-LD metadata

= 1.0.0 =
* Feature: JSON-LD Metadata
* Feature: Intuitive workflow using regular posts or pages
* Feature: Import from EasyRecipe
* Feature: Clean printing of recipes
* Feature: Fallback recipe when the plugin is disabled

== Upgrade notice ==
= 5.6.0 = 
Various fixes and improvements

= 5.5.3 =
Small fixes related to comment ratings

= 5.5.2 =
Update highly recommended when using Firefox

= 5.5.1 =
Update if you're experiencing issues with not all features loading correctly

= 5.5.0 =
Various fixes and improvements

= 5.4.3 =
Update highly recommended to make sure the metadata shows up in all situations

= 5.4.2 =
A few smaller fixes

= 5.4.1 =
Update recommended when using AMP our Yoast SEO

= 5.4.0 =
A few smaller features and fixes

= 5.3.3 =
Update when getting incorrect comment rating totals

= 5.3.2 =
Update when using the Gutenberg Editor

= 5.3.1 =
Update when using the Classic Editor

= 5.3.0 =
Update for a variety of fixes

= 5.2.1 =
Various fixes and improvements

= 5.2.0 =
Update when using the plugin for How-to instructions

= 5.1.1 =
Upgrade when using Elementor

= 5.1.0 =
Some integrations, improvements and fixes

= 5.0.4 =
Update when using the Classic Editor

= 5.0.3 =
Better compatibility for our new modal

= 5.0.2 =
Update to make sure video embeds work

= 5.0.1 =
Update to prevent manage page from breaking

= 5.0.0 =
Major update with brand new modal and manage page

= 4.3.4 =
Update for a few minor fixes and a new author option

= 4.3.3 =
Update for a few minor improvements and fixes

= 4.3.2 =
Update to prevent PHP notice from showing up

= 4.3.1 =
A few smaller bug and compatibility fixes

= 4.3.0 =
New ItemList metadata feature and a few fixes

= 4.2.1 =
A few smaller fixes and improvements

= 4.2.0 =
Update with lots of smaller improvements and features

= 4.1.1 =
Update if you're using legacy mode

= 4.1.0 =
Update required to use the new premium Recipe Collections feature

= 4.0.8 =
Update recommend to ensure WordPress 5.0 and Gutenberg compatibility

= 4.0.7 =
Update required when using Gutenberg

= 4.0.6 =
Fix some template issues

= 4.0.5 =
Update when using a legacy template

= 4.0.4 =
Update for improved Legacy Mode compatibility

= 4.0.3 =
Various fixes for legacy and modern templates

= 4.0.2 =
Update if you want to create your own modern template

= 4.0.1 =
Update if you're experiencing issues editing recipes

= 4.0.0 =
Major update with the brand new Template Editor feature as the highlight

= 3.2.1 =
Update if you're using shortcodes in the summary, video or notes section

= 3.2.0 =
Update for various improvements and new features

= 3.1.2 =
Update if you want to use the new Gutenberg editor

= 3.1.1 =
Update to prevent a fatal error when embedding videos

= 3.1.0 =
Update for some metadata and performance improvements

= 3.0.3 =
Update if you're experiencing issues with the new settings page

= 3.0.2 =
Update to make sure all the settings work

= 3.0.1 =
Update to prevent a fatal error in some environments

= 3.0.0 =
Update for a brand new settings page and better video metadata

= 2.5.3 =
Update to prevent the print page from getting indexed

= 2.5.2 =
Update for privacy policy suggestions in compliance with GDPR

= 2.5.1 =
Ability to embed a video and prevent save problems

= 2.5.0 =
Various metadata improvements and new video feature

= 2.4.1 =
Update for the latest changes in Google's structured data

= 2.4.0 =
A few new features and improvements, including basic Gutenberg compatibility (blocks still coming up!)

= 2.3.0 =
A few new features and improvements

= 2.2.2 =
Update to prevent a rating related warning from showing up

= 2.2.1 =
Update to prevent incorrect ratings from showing up

= 2.2.0 =
A few new features and improvements

= 2.1.1 =
Update to prevent issues on AMP pages

= 2.1.0 =
Update for more import options, AMP improvements and a few smaller fixes

= 2.0.0 =
Update for performance improvements due to restructured assets

= 1.27.0 =
Update for a few bug fixes and improvements

= 1.26.1 =
Update to prevent the modal overlay from blocking TinyMCE functionality

= 1.26.0 =
Update to prevent issues with the recipe metadata

= 1.25.0 =
Update to use the latest metadata structure

= 1.24.0 =
Update to fix a few bugs

= 1.23.1 =
Update if you're experiencing issues with the ratings

= 1.23.0 =
Update to prevent a Jetpack compatibility problem

= 1.22.0 =
Update required if you want to use the latest version of the Premium version

= 1.21.0 =
Update for the latest version of this plugin

= 1.20.0 =
Update for a few great tweaks

= 1.19.1 =
Update to get rid of a PHP notice

= 1.19.0 =
Update to ensure WordPress 4.8 compatibility

= 1.18.0 =
Update to easily customize the print page

= 1.17.1 =
Update if you're importing from other plugins

= 1.17.0 =
Update if you're experiencing problemns with the post slug

= 1.16.0 =
Update for even more easy template customization options

= 1.15.0 =
Some fun new features and improvements

= 1.14.1 =
Upgrade required to use the latest Premium add-ons

= 1.14.0 =
Update for various improvements and bug fixes

= 1.13.0 =
Update to prevent warning notices on the settings page

= 1.12.1 =
Update if you want to use the Recipe Card import

= 1.12.0 =
New import and other features + some bug fixes

= 1.11.0 =
Some improvements to the template

= 1.10.1 =
Update only needed if you're on a very old version of PHP

= 1.10.0 =
Make your template unique in this new update

= 1.9.1 =
Fix for settings issue introduced in previous update

= 1.9.0 =
Easier recipe management in this new update

= 1.8.0 =
A bunch of general improvements and the possibility to import from ZipList and Zip Recipes

= 1.7.1 =
Update to fix the ingredient term relations

= 1.7.0 =
Lots of great improvements

= 1.6.1 =
Warning message for EasyRecipe users

= 1.6.0 =
Some minor updates and the release of our Premium plugin

= 1.5.0 =
Fixed a few issues and added the author field.

= 1.4.0 =
A few important bug fixes and improvements

= 1.3.0 =
Another week, another update!

= 1.2.0 =
Update for some new SEO improvements and templates.

= 1.1.0 =
Update highly recommended for SEO purposes.

= 1.0.0 =
First version of this plugin, no upgrades needed.
