=== Docxpresso ===
Tags: Word, Excel, Libre Office, Open Office, copy and paste, insert, content, document, spreadsheets, html, css, comment popovers, sortable tables, MS Office, Google forms, Google Docs, youtube videos
Requires at least: 3.5
Tested up to: 5.2
Stable tag: trunk
Contributors: No-nonsense Labs
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

"Copy and Paste" from MS Word, Excel, Libre Office or Open Office.

== Description ==

If you are used to write all your documents using a Office Suite Word Processor or Spreadsheets like the ones available in MS Office, Libre Office or Open Office [Docxpresso](http://www.docxpresso.com "PDF, Word and ODF documents from HTML5") is the WordPress plugin you are looking for!

> This plugin will allow you to publish content that has been generated with your favourite Office Suite (MS, Libre or Open Office) preserving all of its structure, design and format:

> * Nicely formatted text
> * Headings
> * Tables (sortable and responsive)
> * Links and bookmarks
> * Nested lists with sophisticated numberings
> * Images
> * Charts
> * Textboxes
> * Footnotes and endnotes
> * Headers and Footers
> * Tables of contents (TOCs)
> * Comments
> * Math equations
> * Drop caps
> * Office SmartArt and forms (partial)
> * Support for Right-To-Left languages

You may even create sortable tables or even export your **charts** in a browser friendly manner.

This plugin is a spin-off of our [Docxpresso API](http://www.docxpresso.com "Generate dynamically all your documents online") library designed to generate all kind of dynamical documents on your web server (PDF, Word, ODT, RTF). 

If you use our plugin we would be very thankful if you fulfill this simple [online survery](http://en.docxpresso.com/documents/preview/346 "Docxpresso online survey").

= How to use it =

**NOTE:** If you have updated to WP5.* or you are using the Gutenberg editor plugin you should also have a look at the **Gutenberg - WP5 Block editor** section of this page.

1. Create a standard document with the content that you want to insert in your Post or Page using your favourite Word Processor or Spreadsheet (MS Word, Libre Office or Open Office).
2. IMPORTANT: Save your document in **.odt** (or **.ods** format for spreadsheets) format. In MS Word choose OpenDocument (*.odt) in your **Save As** dialogue (in Libre or Open Office is the default format). If you are working with Excel you may equivalently save it in Open Document Format (*.ods in this case).
3. Create or edit a Post or Page in your WordPress interface.
4. Click the **Insert Document** button located over the text editor.
5. A standard WordPress media window will open. You may upload a new document with the required contents or use a previously uploaded document.
6. After choosing a file click on the **Insert** button.
7. A [docxpresso] shortcode will be included within your text editor.     
8. You may then add or not any additional content to your post but do not try to modify by hand the contents of the Docxpresso shortcode unless you really know what you are doing.
9. You may insert as many documents as you wish in a single Post or Page.

**NOTE:** You may use also Docxpresso plugin in conjunction with other plugins that allow to retrieve documents from cloud storage repositories like Amazon S3.

Check this video tutorial where you will find a detailed example of all the above:

http://www.youtube.com/watch?v=wu_pi8FOrUs

In case you want to make any of your tables sortable you also should:

1. Declare the first row of your table as a **header row** within your Office document
2. insert a "@" symbol as the first character in every column that you wish to be sortable
3. If you want to sort columns by numbers that do not follow the en-US standard, i.e. 3,576.45, you should modify the number format for sorting in your plugin options panel under the **Settings** section of your Wordpress installation

You may check how to do it with the help of this video:

https://www.youtube.com/watch?v=Zv7lw_EliA8

Since v2.1 you may also insert in your document a link to a yotube video, a Google form or a Google doc to render it in your Wordpress post or page:

1. Go to youtube, Google forms or Google docs interfaces and copy the offered share link
2. Always use, if available, the short URL format
3. Insert it into your office document as a link
4. By default the videos are fluid and the forms and docs take all available width space. But you can set custom width and height by adding, for example, '?width=600&height=400' to the link URL

You may see an example in the following video:

https://www.youtube.com/watch?v=dWl-RbFmcRE

= Gutenberg - WP5 Block editor =

Since v2.3 this plugin is compatible with the new "WP block editor", also known as Gutenberg:

1. Click on the **Docxpresso block** that is available together with all the standard **widget blocks** within your block editor interface.
2. A new block will appear in the editor interface with a button inviting you to select a file.
3. Clicking on that button a standard WordPress media window will open. You may upload a new document with the required contents or use a previously uploaded document.
4. After clicking on the "Select button" a shortcode will be inserted in your editor.
5. As before, if you wish, you may insert multiple documents with Docxpresso in the same page or post and combine them with all other available blocks.

**NOTE:** With this new editor you need to save the edition before being able to visualize the uploaded document in the preview page.

https://www.youtube.com/watch?v=q4pflMSiNsg

If you prefer to use the "Classical editor" in your WP5 installation you may proceed as described in the previous section.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'.
2. Search for **Docxpresso**.
3. Activate Docxpresso from your Plugins page.

= From WordPress.org =

1. Download Docxpresso.
2. Upload the 'docxpresso' directory to your '/wp-content/plugins/' directory.
3. Activate Docxpresso from your Plugins page.

== Frequently Asked Questions ==

= May I use this plugin in any website, commercial or not? =
Yes, there are no limits to that regard.
= May I ask for support? =
Yes, you may write in the forum or leave a message in [Docxpresso](http://www.docxpresso.com "Generate dynamically all your documents online") but beware that support is not (always) offered for free.

== Screenshots ==

1. **Docxpresso button** - just clicking on it you will be able to upload or choose a document from the media popup window. A shortcode will be inserted into your text editor with all the required data.
2. **Sample post** - this is just a sample result of a document with charts and formatted text.

== Changelog ==

= 2.5 =

* Improvements in HTML rendering of charts

= 2.4 =

* Improvements in HTML rendering of spreadsheets

= 2.3 =

* Support for Gutenberg - WP5 block editor
* Minor improvements in HTML rendering

= 2.2 =

* Several improvements in HTML rendering
* Optional SVG rendering via the SVG shortcode attribute

= 2.1 =

* Support for Youtube videos
* Support for Google docs
* Support for Google forms
* Improvements in spreadsheet chart rendering
* Improvements in table sorting

= 2.0 =

* Support for Spreadsheets
* Support for remote files stored in the cloud
* Improvements in SVG rendering
* Support for combined charts, for exmple, bar+ line

= 1.6 =

* Support for Right-To-Left languages
* Responsive tables
* Improvements in the rendering of numbered headings
* Minor improvements in the rendering engine


= 1.5 =

* Drop caps support
* Minor improvements in the rendering engine


= 1.4 =

* Math equations
* Number format configuration for sortable tables accesible from the plugin options page in the Settings section of your Wordpress installation
* Minor improvements in the rendering engine

= 1.3 =

* Parsing of document comments as popovers
* Sortable tables
* Numbered headings and paragraphs
* Superscripts and subscripts
* Miscellaneous improvements in the rendering engine
* Correction of minor bugs

= 1.2 =

* Improvements in chart rendering

= 1.1 =

* Improvements in selector specificity to avoid conflicts among styles
* New added default styles

= 1.0.1 =

* Minor improvements in the documentation

= 1.0 =

* Initial version

== Licensing ==

This work is licensed under GPLv2 or later.

This plugin comes bundled with the D3 and C3 JavaScript libraries for chart rendering, the webui-popover library for comment rendering and the MathJax library for rendering of math equations in a web browser. D3 (http://d3js.org) is distributed under the BSD license, MathJax (https://www.mathjax.org/) and dropcap.js (https://github.com/adobe-webplatform/dropcap.js) under the Apache license v2.0 , C3 (http://c3js.org/) and webui-popover (https://github.com/sandywalker/webui-popover) are distributed under the MIT license . 
