<?php

//handle all translation here with __, see WordPress documentation

//errors

define('BN_ENABLECURL_LANG', __('BNC BiblioShare uses the PHP cURL library. Ask your system administrator to enable this package.'));
define('BN_BOOKNUMBERREQUIRED_LANG', __('BNC BiblioShare requires at least an ISBN'));
define('BN_INVALIDTEMPLATENUMBER_LANG', __('Invalid template or template number. Correct the template, or enter a template number of 1-5. If this does not work, click \'Reset to installation values\' in Settings.'));

define('BN_VALUEREQUIRED_LANG', __(' is a required value. Please return to the BNC BiblioShare settings and enter a value.'));

define('BN_BIBLIOSHAREDATAUNAVAILABLE_KEY_LANG', __('BiblioShare Data Unavailable')); //most common

//!!!are these next two used
define('BN_BIBLIOSHAREDATAUNAVAILABLE_BOOK_LANG', __('BiblioShare Data Unavailable (books)'));
define('BN_BIBLIOSHAREDATAUNAVAILABLE_AUTHOR_LANG', __('BiblioShare Data Unavailable (authors)'));

define('BN_NOBOOKDATAFORBOOKNUMBER_LANG', __('No Book Data for this Book Number'));
define('BN_INVALIDDOMAIN_LANG', __('Invalid domain. The usual value is http://biblioshare.org.'));
define('BN_INVALIDTOKEN_LANG', __('A user token is required. Get one for free by filling out BookNet Canada\'s request form at token.booknetcanada.ca'));
define('BN_CURLTIMEOUT_LANG', __('Timeout contacting BiblioShare'));
define('BN_CURLERROR_LANG', __('Error contacting BiblioShare'));
define('BN_OLSERVERERROR_LANG', __('BiblioShare Server Error'));

//options page

define('BN_OPTIONS_TEMPLATETEMPLATES_LANG', __('Templates'));
define('BN_OPTIONS_TEMPLATETEMPLATES_DETAIL_LANG', __('Modify these templates to change the content, order and style of the display elements. Template 1 is the default, but you can change the template by setting a template number in a shortcode, e.g., [booknet booknumber="123" templatenumber="2"]. If you know CSS, you can set class attibutes here and manage the style through your WordPress theme\'s stylesheet. See the plugin\'s readme file for more information.'));

define('BN_OPTION_TEMPLATE1_LANG', __('Template 1 (default)'));
define('BN_OPTION_TEMPLATE2_LANG', __('Template 2 (large cover, book information, links)'));
define('BN_OPTION_TEMPLATE3_LANG', __('Template 3 (large cover, title and author below)'));
define('BN_OPTION_TEMPLATE4_LANG', __('Template 4 (thumbnail cover, title and author below - good for sidebar widgets)'));
define('BN_OPTION_TEMPLATE5_LANG', __('Template 5 (citation)'));

define('BN_OPTIONS_USER_LANG', __('User'));
define('BN_OPTIONS_TOKEN_LANG', __('Token'));
define('BN_OPTIONS_TOKEN_DETAIL_LANG', __("A user token is required. Get one for free by filling out BookNet Canada's "));

define('BN_OPTIONS_COUNTRY_LANG', __('Country'));
define('BN_OPTIONS_COUNTRY_DETAIL_LANG', __('Country determines if the [BN_PRICE] template element is displayed in Canadian or US dollars. You can also use the [BS_PRICE_CAD] and [BS_PRICE_USD] template elements to show either price.'));
define('BN_OPTIONS_COUNTRY_CA_LANG', __('Canada'));
define('BN_OPTIONS_COUNTRY_US_LANG', __('United States'));

define('BN_OPTIONS_FINDINLIBRARY_LANG', __('Find in the Library'));

define('BN_OPTIONS_FINDINLIBRARY_OPENURLRESOLVER_LANG', __('OpenURL Resolver'));
define('BN_OPTIONS_FINDINLIBRARY_OPENURLRESOLVER_DETAIL_LANG', __("If you enter a library's OpenURL resolver (version 1.0) here, and add [BN_LINK_FINDINLIBRARY] or [BN_IMAGE_FINDINLIBRARY] to a template, a link will point to that library's records. To find the resolver, ask the Systems Librarian or look it up in the "));

define('BN_OPTIONS_FINDINLIBRARY_PHRASE_LANG', __('Phrase'));
define('BN_OPTIONS_FINDINLIBRARY_PHRASE_DETAIL_LANG', __('If you enter an OpenURL resolver, and add [BN_LINK_FINDINLIBRARY] to a template, this phrase is used for the text link. You may wish to name your library.'));

define('BN_OPTIONS_FINDINLIBRARY_IMAGESRC_LANG', __('Image Source'));
define('BN_OPTIONS_FINDINLIBRARY_IMAGESRC_DETAIL_LANG', __('If you enter an OpenURL resolver, and add [BN_IMAGE_FINDINLIBRARY] to a template, this image URL is used for the image link. You may wish to use your library\'s image.'));

define('BN_OPTIONS_SYSTEM_LANG', __('System'));

define('BN_OPTIONS_LIBRARY_DOMAIN_LANG', __('Library Domain'));
define('BN_OPTIONS_LIBRARY_TOKEN_LANG', __('User Token'));
define('BN_OPTION_SYSTEM_TIMEOUT_LANG', __('Timeout (sec)'));
define('BN_OPTION_SYSTEM_PROXY_LANG', __('Proxy'));
define('BN_OPTION_SYSTEM_PROXYPORT_LANG', __('Proxy Port'));
define('BN_OPTION_SYSTEM_TIMEOUT_DETAIL_LANG', __('The timeout for connecting with BiblioShare. Increase to wait longer. Decrease if page loads are hanging.'));
define('BN_OPTION_SYSTEM_PROXY_DETAIL_LANG', __('May be needed if you are behind a firewall. Ask your system administrator for this value and the port.'));
define('BN_OPTION_SYSTEM_PROXYPORT_DETAIL_LANG', __('Goes with the proxy. Just enter the number, no colon.'));

define('BN_OPTIONS_SHOWERRORS_LANG', __('Show Error Details'));
define('BN_OPTIONS_SHOWERRORS_DETAIL_LANG', __('If checked, the plugin displays detailed information if an error occurs. Useful for diagnosing problems.'));

define('BN_OPTIONS_SAVESETTINGS_LANG', __('Save Settings'));
define('BN_OPTIONS_SAVESETTINGS_DETAIL_LANG', __('If checked, the plugin will save your settings when the plugin is deactivated, otherwise it will delete them.'));

define('BN_OPTIONS_SAVECHANGES_LANG', __('Save Changes'));
define('BN_OPTIONS_RESET_LANG', __('Reset to Installation Values'));

define('BN_OPTIONS_CONFIRM_SAVED_LANG', __('Your changes have been saved'));
define('BN_OPTIONS_CONFIRM_RESET_LANG', __('The options have been reset to the original installation values'));

//display

define('BN_DISPLAY_CLICKTOVIEWPUBLISHER_LANG', __('View the publisher\'s website'));
define('BN_DISPLAY_FINDINLIBRARY_WORLDCAT_TITLE_LANG', __('Find this title in a library using WorldCat'));
define('BN_DISPLAY_FINDINLIBRARY_OPENURL_TITLE_LANG', __('Find this title in the library'));
define('BN_DISPLAY_READONLINE_LANG', __('Read Online'));
define('BN_DISPLAY_READONLINE_TITLE_LANG', __('Read this work online'));

define('BN_DISPLAY_GOOGLEBOOKS_LANG', __('Google Books'));
define('BN_DISPLAY_GOOGLEBOOKS_TITLE_LANG', __('View this title at Google Books'));
define('BN_DISPLAY_LIBRARYTHING_LANG', __('LibraryThing'));
define('BN_DISPLAY_LIBRARYTHING_TITLE_LANG', __('View this title at LibraryThing'));
define('BN_DISPLAY_WORLDCAT_LANG', __('WorldCat'));
define('BN_DISPLAY_WORLDCAT_TITLE_LANG', __('View this title at WorldCat'));
define('BN_DISPLAY_BOOKFINDER_LANG', __('BookFinder'));
define('BN_DISPLAY_BOOKFINDER_TITLE_LANG', __('Search for the best price at BookFinder'));
define('BN_DISPLAY_AMAZON_LANG', __('Amazon'));
define('BN_DISPLAY_AMAZON_TITLE_LANG', __('View this title at Amazon'));
define('BN_DISPLAY_CHAPTERSINDIGO_LANG', __('Chapters-Indigo'));
define('BN_DISPLAY_CHAPTERSINDIGO_TITLE_LANG', __('View this title at Chapters-Indigo'));

?>
