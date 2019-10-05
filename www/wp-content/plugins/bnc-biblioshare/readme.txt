=== BNC BiblioShare ===
Contributors: johnmiedema, meghanmac, kirtim, 
Tags: book, books, reading, library, libraries, book covers, COinS, OpenURL, OpenBook, BookNet, BiblioShare
Requires at least: 2.5.1
Tested up to: 4.1
Stable tag: 1.0.9

Displays a book's cover image, title, author, and other book data from BiblioShare

== Description ==

The BNC BiblioShare plugin is for book reviewers, book bloggers, library webmasters, anyone who wants to put book covers and data on their WordPress blog or website. Use the plugin button in the WordPress visual editor or insert a 'shortcode' with a book number in a WordPress post, page or widget. The plugin will display a book cover image, author, and other book data from BiblioShare (http://biblioshare.org). The plugin is built on the OpenBook WordPress plugin. As with OpenBook, users can control the content and styling through templates. The plugin inserts COinS to integrate with applications like Zotero. Librarians can point the plugin to their library records using an OpenURL resolver. 

Requirements. To use the plugin, your server must use PHP 5 or higher, and cURL must be enabled. 

== Installation ==

You can install the plugin through your WordPress plugins menu, or use the following manual steps:

1. Deactivate any previous version of the plugin through the 'Plugins' menu in WordPress.
2. Delete any previous version of the plugin in the `/wp-content/plugins/` directory.
3. Upload the entire plugin folder to the `/wp-content/plugins/` directory.
4. Activate the plugin through the 'Plugins' menu in WordPress.

Once you have activated the plugin:

1. Enter your user Token ID on the the plugin Settings page. Get one for free by filling out BookNet Canada's request form at http://www.booknetcanada.ca/get-biblioshare-token.
2. Click Save.

Insert a book:

1. Insert an book into a post or page in one of two ways. Using the WordPress visual editor, click the plugin button to add a form for entering a book number and options, then click Preview or Insert. Or, in a post, page, or text widget, insert the plugin tags and an ISBN number, like so: [booknet booknumber="9780439023511"].
2. Type your content as usual after the instance.

By default, the plugin will display a book cover image, title, author, and publisher and other data.

== Frequently Asked Questions ==

* Where do I find an ISBN number?

The ISBN for a book is frquently listed in sources of book data, e.g., Amazon.

* What happens if BiblioShare is slow, down, or unavailable?

BiblioShare's cover and/or data servers are up most of the time, but this cannot be guaranteed. The plugin times out in ten seconds (or the value configured in Settings) and displays an availability message where the data would normally go. When BiblioShare becomes available, the book data will be displayed normally.

* How do I point the plugin to my library?

In the plugin Settings panel, configure an OpenURL resolver for your library.

* How do I change the display?

Change the content, ordering and styling using the templates in the Settings panel. There are two kinds of template elements. BiblioShare elements (prefixed with a BS_) are original data from the data source. BookNet elements (prefixed with a BN_) are HTML formatted elements that use the BiblioShare elements and present them in a richer format for display. You can add your own HTML to the templates.

BiblioShare Elements

* [BS_COVERURL_FULL] The web address for the full book cover image provided by the publisher 
* [BS_COVERURL_THUMBNAIL] The web address for a thumbnail version of the book cover image 
* [BS_TITLE] Title 
* [BS_SUBTITLE] Subtitle 
* [BS_SERIES] Series 
* [BS_CONTRIBUTOR] The author or contributor 
* [BS_FORMAT] Format 
* [BS_PRICECAD] Price in Canadian dollars, if available 
* [BS_PRICEUSD] Price in US dollars, if available 
* [BS_PUBLISHER] Publisher 
* [BS_ISBN13] 13 digit ISBN 
* [BS_ISBN10] 10 digit ISBN 
* [BS_PUBLICATIONDATE] Publication date 

BookNet Elements

* [BN_COVER_FULL] An HTML formatted cover 
* [BN_COVER_THUMBNAIL] An HTML formatted thumbnail cover 
* [BN_TITLE] Title: Subtitle 
* [BN_CONTRIBUTOR] Replaces (CA) with a Canadian flag 
* [BN_PRICE] Price in Canadian or US dollars, depending on the Country setting on the Options page 
* [BN_PUBLISHER] Publisher with link to the publisher's website, if provided 
* [BN_PUBLICATIONDATE] Publication date, formatted as mmm dd, yyyy 
* [BN_LINK_FINDINLIBRARY] If an OpenURL resolver is provided, this text links to the library catalogue record 
* [BN_IMAGE_FINDINLIBRARY] If an OpenURL resolver is provided, this image links to the library catalogue record 
* [BN_COINS] Invisible HTML with book data for integration with applications, e.g., Zotero 
* [BN_LINK_AMAZON] Link to Amazon by ISBN 
* [BN_LINK_CHAPTERSINDIGO] Link to Chapters-Indigo by ISBN 
* [BN_LINK_GOOGLEBOOKS] Link to Google Books by ISBN or title and author 
* [BN_LINK_LIBRARYTHING] Link to LibraryThing by ISBN or title and author 
* [BN_LINK_WORLDCAT] Link to WorldCat by ISBN or title and author 
* [BN_LINK_BOOKFINDER] Link to BookFinder by ISBN or title and author 

== Screenshots ==

1. Insert an ISBN using a shortcode. 
2. Use the plugin's form to insert an ISBN and parameters. You can preview the display.
3. The plugin displays book data from BiblioShare.
4. Customize the display using the plugin's templates.

== Changelog ==
= 1.0.9 =

* fix for XSS and CSRF vulnerabilities.

= 1.0.7 =

* fix for 3.9 and tinymce upgrade. 

= 1.0.3 =

* Link to BiblioShare Developer Token Request Form added

= 1.0.2 =

* Visual toolbar button fixed

= 1.0.1 =

* Created



