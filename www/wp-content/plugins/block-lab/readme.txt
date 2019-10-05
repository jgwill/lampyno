=== Block Lab ===

Contributors: lukecarbis, ryankienstra, Stino11, rheinardkorf
Tags: Gutenberg, Blocks
Requires at least: 5.0
Tested up to: 5.2
Requires PHP: 5.6
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl

The easy way to build custom blocks for Gutenberg.

== Description ==

Gutenberg, the new WordPress editor, opens up a whole new world for the way we build pages, posts, and websites with WordPress. Block Lab makes it easy to harness Gutenberg and build custom blocks the way you want them to be built. Whether you want to implement a custom design, deliver unique functionality, or even remove your dependance on other plugins, Block Lab equips you with the tools you need to hit “Publish” sooner.

== Features ==

= A Familiar Experience =
Work within the WordPress admin with an interface you already know.

= Block Fields =
Add from a growing list of available fields to your custom blocks.

= Simple Templating =
Let the plugin do the heavy lifting so you can use familiar WordPress development practices to build block templates.

= Developer Friendly Functions =
Simple to use functions, ready to render and work with the values stored through your custom block fields.

= Connect with Community =
Join The Lab, our free Block Lab Community on Slack. The Lab is our real-time home for sharing resources, learning, and making connections. [Learn more.](https://getblocklab.com/welcome-to-the-lab/)

= Go Pro =
Block Lab Pro is coming mid 2019 with power features to take your block building to the next level. [Learn more.](https://getblocklab.com/block-lab-pro)

== Links ==
* [WordPress.org](https://wordpress.org/plugins/block-lab)
* [Github](https://github.com/getblocklab/block-lab)
* [Documentation](https://getblocklab.com/docs)
* [Support](https://wordpress.org/support/plugin/block-lab)
* [Block Lab Pro](https://getblocklab.com/block-lab-pro)

== Installation ==
= From Within WordPress =
* Visit Plugins > Add New
* Search for "Block Lab"
* Install the Block Lab plugin
* Activate Block Lab from your Plugins page.

= Manually =
* Clone Block Lab into a working directory with `https://github.com/getblocklab/block-lab.git`
* `cd` into the `block-lab` directory, and run `npm install`
* Next, build the scripts and styles with `npm build`
* Move the `block-lab` folder to your `/wp-content/plugins/` directory
* Activate the Block Lab plugin through the Plugins menu in WordPress

== Frequently Asked Questions =
**Q: Do I need to write code to use this plugin?**
A: Although the plugin handles the majority of the work in building a custom block, you will need to build HTML templates to display the content of the block. You can learn how in the the developer documentation.

**Q: I have an idea for the plugin**
A: This plugin is open source and can only be better through community contribution. The GitHub repo is [here](https://github.com/getblocklab/block-lab).

**Q: Where can I find documentation for this plugin?**
A: [Here](https://getblocklab.com/docs/)

== Contributing ==

See [Contributing to Block Lab](https://github.com/getblocklab/block-lab/blob/develop/CONTRIBUTING.md).

== Changelog ===

= 1.4.1 – 2019-09-11 =

You can now add a Minimum and Maximum Rows setting to repeaters, allowing you to specify a lower and upper limit on how many repeater rows can be added.

* New: The repeater field now includes a minimum and maximum row setting
* Fix: Location and Width settings are now visible again when adding a new field
* Fix: Using block_sub_field() with an image now correctly outputs the image URL instead of the ID

= 1.4.0 – 2019-09-04 =

This release applies some finishing touches to the repeater field. It also introduces a new "Field Width" feature, which lets you choose the width of the fields as seen in the Editor.

* New: Function to reset repeater rows: reset_block_rows()
* New: Add a "Field Width" control to blocks
* Fix: Empty repeater rows now save and can be moved properly
* Fix: An issue which occasionally prevented repeater rows from being deleted
* Fix: Prevent repeated requests to validate a Pro license
* Tweaks: Add a different admin notice for when a license validation request fails
* Tweaks: Many new and shiny unit and integration tests, making Block Lab more solid than ever

= 1.3.6 – 2019-08-22 =

* New: 🔁 REPEATER FIELD 🔁
* New: Conditional Blocks, based on Post Type
* Tweaks: Just about everything! We did a lot of refactoring in this release to make things silky smooth and über-maintainable.

= 1.3.5 – 2019-08-18 =

* New: Block Lab will now enqueue a global stylesheet, so you can keep your common block styles in one place. [Read more](https://github.com/getblocklab/block-lab/pull/371)
* New: Block templates can now be placed inside a sub-folder, for an even cleaner directory structure. [Read more](https://github.com/getblocklab/block-lab/pull/372)
* Tweak: Use a textarea for specifying the default value of a textarea control.
* Tweak: Better handling of deprecated functions.
* Tweak: Rewrite of various functions, making developer access to common commands much simpler.
* Fix: Child theme templates are now correctly loaded before their parent templates.
* Fix: Autoslugs now continue to work properly after the title field loses focus.

= 1.3.4 - 2019-07-22 =

* New: Block Lab grew to level 1.3.4. Block Lab learned **Custom Categories**.
* Tweak: **@phpbits** used Pull Request. All right! The **`block_lab_get_block_attributes`** filter was caught!
* Tweak: **Template Loader** used Harden. **Template Loader**'s defense rose!
* Tweak: Booted up a TM! It contained **Unit Tests**!
* Fix: Wild **Missing Filter in Inspector Controls** bug appeared! Go! Bugfix!
* Fix: Enemy **Mixed Up Inspector Controls** fainted! @kienstra gained 0902a06 EXP. Points!

= 1.3.3 - 2019-06-21 =

* Fix: The previous release broke the `className` field, used for the Additional CSS Class setting. This fixes it.

= 1.3.2 - 2019-06-21 =

* New: Rich Text Control (for Block Lab Pro users)!
* New: Show Block Category in the list table
* New: We've got a new `block_lab_render_template` hook which fires before rendering a block on the front end. Great for enqueuing JS
* Tweak: Updated logo
* Tweak: Prevent block field slugs from changing when you edit the field title
* Fix: Saving your license key no longer results in an error page
* Fix: License details screen showing the wrong information
* Fix: Remove duplicate IDs on the edit block screen
* Fix: Range sliders can now set a minimum value of zero
* Fix: A console warning about unique props

= 1.3.1 - 2019-05-22 =

* New: Support for Gutenberg's built-in Additional CSS Class in your block template, by using the field `className`. [Read more](https://getblocklab.com/docs/faqs/)
* New: The Textarea field now has an option to automatically add paragraph tags and line-breaks
* Fix: Bug affecting blocks containing Pro fields when there's no active Pro license

= 1.3.0 - 2019-04-30 =

**Important**: This update includes a backwards compatibility break related to the User field.

[Read more here](https://github.com/getblocklab/block-lab/pull/294===issue-272649668)

* New: A Taxonomy control type, for selecting a Category / Tag / or custom term from a dropdown menu (for Block Lab Pro users)
* Fix: Bug with the Post control when outputting data with block_field()
* Tweak: Update the User control to store data as an object, matching the Post control

= 1.2.3 - 2019-04-23 =

**Important**: This update includes a backwards compatibility break related to the Image field.
If you are using the `block_value()` function with an image field and externally hosted images, this update may effect you.

[Read more here](https://getblocklab.com/backwards-compatability-break-for-the-image-field/)

* New: A Post control type, for selecting a Post from a dropdown menu (for Block Lab Pro users)
* New: Added the block_lab_controls filter to allow custom controls to be loaded (props @rohan2388)
* New: The Image control now returns the image's Post ID
* Tweak: Travis CI support

= 1.2.2 - 2019-04-05 =

* New: Block Editor redesign

= 1.2.1 - 2019-03-21 =

* New: Automatic stylesheet enqueuing. Now you can create custom stylesheets for individual blocks! [Read more here](https://getblocklab.com/docs/get-started/style-block-lab-custom-blocks/).
* New: A User control type (for Block Lab Pro users)
* Fix: Various multiselect bug fixes, allowing for empty values in the multiselect control

= 1.2.0 - 2019-02-27 =

* New: Introducing Block Lab Pro!
* New: A setting for the number of rows to display in a Textarea control
* Fix: Allow negative numbers in Number and Range controls

= 1.1.3 - 2019-01-25 =

* New: Image field

= 1.1.2 - 2019-01-11 =

* New: Color field
* Fix: Incorrect output for empty fields

= 1.1.1 - 2018-12-14 =

* Fix: Undefined index error for multiselect and select fields
* Fix: Correct values now returned for boolean fields like checkbox and toggle
* Fix: Editor preview templates are back! Use the filename `preview-{blog slug}.php`
* Fix: "Field instructions" is now a single line text, and renamed to "Help Text"
* Fix: Slashes being added to field options
* Fix: Allow empty value for select and number fields
* Fix: Allow empty default values

= 1.1.0 - 2018-12-07 =

* New: Complete revamp of the in-editor preview
* New: Email field
* New: URL field
* New: Number field
* New: `block_config()` and `block_field_config` helper functions, to retrieve your block's configuration
* Fix: filemtime errors
* Fix: HTML tags were being merged together when previewed in the editor
* Fix: Problems with quotes and dashes in a block's title or field parameters
* Fix: `field_value()` sometimes returned the wrong value
* Fix: Incorrect values shown in the editor preview

= 1.0.1 - 2018-11-16 =

* New: Added "Save Draft" button, so you can save Blocks-in-Progress
* New: Better handling of the auto-slug feature, so you don't accidentally change your block's slug
* New: Better expanding / contracting of the Field settings
* New: Emoji (and special character) support! 😎
* Fix: Resolved Fatal Error that could occur in some environments
* Fix: Remove unused "Description" field
* Fix: Remove duplicate star icon

= 1.0.0 - 2018-11-14 =

*Rename!*
* Advanced Custom Blocks is now Block Lab

*Added*
* New control types (Radio, Checkbox, Toggle, Select, Range)
* Block icons
* Field location – add your block fields to the inspector
* List table refinements
* Field repeater table improvements

*Fixed*
* All the things. Probably not _all_ the things, but close.

= 0.1.2 - 2018-08-10 =

*Added*
* New properties `help`, `default` and `required` added to fields.
* Ability to import blocks from a `{theme}/blocks/blocks.json` file. Documentation still to be added.
* Gutenberg controls library updated preparing for `0.0.3`.

*Technical Changes*
* Updated control architecture to improve development and adding adding of additional controls.
* Clean up enqueuing of scripts.

= 0.1 - 2018-08-03 =
* Initial release.