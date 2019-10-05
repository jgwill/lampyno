<?php
/*
Plugin Name: BNC BiblioShare
Plugin URI: http://wordpress.org/extend/plugins/bnc-biblioshare/
Description: Displays a book's cover image, title, author, and other book data from BNC BiblioShare
Version: 1.0.9
Author: BookNet Canada
Author URI: http://www.booknetcanada.ca/

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include_once('libraries/booknet_language.php'); //include before constants
include_once('libraries/booknet_constants.php');
include_once('libraries/booknet_html.php');
include_once('libraries/booknet_biblioshare.php');
include_once('libraries/booknet_utilities.php');

if ( ! defined( 'ABSPATH' ) )
	die( "Can't load this file directly" );

class MyBookNet
{
	function __construct() {
		register_activation_hook(__FILE__, 'bn_activation_check');
		register_deactivation_hook(__FILE__, 'bn_deactivation');
		add_action( 'admin_init', array( $this, 'action_admin_init' ) );
		add_action('admin_menu', 'booknet_add_pages');
		add_shortcode('booknet', 'booknet_insertbookdata');
		add_filter('widget_text', 'do_shortcode'); //allows shortcodes in widgets
	}

	function action_admin_init() {
		// only hook up these filters if we're in the admin panel, and the current user has permission
		// to edit posts and pages
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons', array( $this, 'filter_mce_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'filter_mce_plugin' ) );
			$plugin = plugin_basename(__FILE__);
			add_filter( 'plugin_action_links_' . $plugin, array( $this, 'filter_plugin_actions_links'), 10, 2);
		}
	}

	function filter_mce_button( $buttons ) {
		// add a separation before our button
		array_push( $buttons, '|', 'booknet_button' );
		return $buttons;
	}

	function filter_mce_plugin( $plugins ) {
		// this plugin file will work the magic of our button
		$plugins['booknet'] = plugin_dir_url( __FILE__ ) . 'libraries/booknet_button.js';
		return $plugins;
	}

	function filter_plugin_actions_links($links, $file)
	{
		$settings_link = $settings_link = '<a href="options-general.php?page=booknet_options.php">' . __('Settings') . '</a>';
		array_unshift($links, $settings_link);
		return $links;
	}
}

//handles any processing when the plugin is activated
function bn_activation_check() {

	$plugin = trim( $GET['plugin'] );

	//test if cURL is enabled
	if (!function_exists('curl_init')) {
		deactivate_plugins($plugin);
		wp_die(BN_ENABLECURL_LANG);
	}

	//initialize options
	booknet_utilities_setDefaultOptions();
}

//handles any cleanup when plugin is deactivated
function bn_deactivation() {
	$savetemplates = get_option(BN_OPTION_SAVETEMPLATES_NAME);
	if ($savetemplates!=BN_HTML_CHECKED_TRUE) {
		booknet_utilities_deleteOptions();
	}
}

// action function for admin hooks
function booknet_add_pages() {
	add_options_page('BNC BiblioShare', 'BNC BiblioShare', 'manage_options', 'booknet_options.php', 'booknet_options_page'); // add a new submenu under Options:
}

// displays the page content for the options submenu
function booknet_options_page() {
	require_once('booknet_options.php');
}

//main function finds and replaces [booknet] shortcodes with HTML
function booknet_insertbookdata($atts, $content = null) {

	try {

		//-------------------------------------------------------------------------
		//get arguments
		$args = new booknet_arguments($atts, $content);

		$booknumber=$args->booknumber;
		$template=$args->template;
		$publisherurl=$args->publisherurl;
		$openurlresolver=$args->openurlresolver;
		$findinlibraryphrase=$args->findinlibraryphrase;
		$findinlibraryimagesrc=$args->findinlibraryimagesrc;
		$domain=$args->domain;
		$token=$args->token;
		$country=$args->country;
		$proxy=$args->proxy;
		$proxyport=$args->proxyport;
		$timeout=$args->timeout;
		$showerrors=$args->showerrors;
		$savetemplates=$args->savetemplates;

		//-------------------------------------------------------------------------
		//get book data
		$bdata = new booknet_biblioshare_bookdata($domain, $token, $booknumber, $timeout, $proxy, $proxyport, $showerrors);
		$bookdata = $bdata->bookdata;

		//validate xml
		libxml_use_internal_errors(true); //capture errors silently
		$sxe = simplexml_load_string($bookdata);
		if (!$sxe) {
		    return booknet_getDisplayMessage(BN_NOBOOKDATAFORBOOKNUMBER_LANG);
		}

		//extract good xml
		$bookxml = new SimpleXMLElement($bookdata);

		//check BiblioShare error message
		$messagetext = booknet_biblioshare_extractValue($bookxml, 'MessageText');
		if ($messagetext != "") return $messagetext;

		//-------------------------------------------------------------------------
		//extract raw Biblioshare data, prefix with BS_

		$BS_COVERURL_FULL = booknet_biblioshare_getCoverUrl($domain, $token, $booknumber, 'False');
		$BS_COVERURL_THUMBNAIL = booknet_biblioshare_getCoverUrl($domain, $token, $booknumber, 'True');

		$BS_TITLE = booknet_biblioshare_extractValueFormatted($bookxml, 'Title');
		$BS_SUBTITLE = booknet_biblioshare_extractValueFormatted($bookxml, 'Subtitle');
		$BS_SERIES = booknet_biblioshare_extractValueFormatted($bookxml, 'Series');
		$BS_CONTRIBUTOR = booknet_biblioshare_extractValueFormatted($bookxml, 'Contributor');
		$BS_FORMAT = booknet_biblioshare_extractValueFormatted($bookxml, 'Format');
		$BS_PRICECAD = booknet_biblioshare_extractValueFormatted($bookxml, 'PriceCAD');
		$BS_PRICEUSD = booknet_biblioshare_extractValueFormatted($bookxml, 'PriceUSD');
		$BS_PUBLISHER = booknet_biblioshare_extractValueFormatted($bookxml, 'Publisher');
		$BS_ISBN13 = booknet_biblioshare_extractValueFormatted($bookxml, 'ISBN13');
		$BS_ISBN10 = booknet_biblioshare_extractValueFormatted($bookxml, 'ISBN10');
		$BS_PUBLICATIONDATE = booknet_biblioshare_extractValueFormatted($bookxml, 'PublicationDate');

		//-------------------------------------------------------------------------
		//prepare formatted BookNet data elements, prefix with BN_

		$BN_COVER_FULL = booknet_html_getCoverImage($BS_COVERURL_FULL, $BS_TITLE);
		$BN_COVER_THUMBNAIL = booknet_html_getCoverImage($BS_COVERURL_THUMBNAIL, $BS_TITLE);

		$BN_TITLE = booknet_html_getTitle($BS_TITLE, $BS_SUBTITLE);
		$BN_CONTRIBUTOR = booknet_html_getContributor($BS_CONTRIBUTOR);
		$BN_PRICE = booknet_html_getPrice($country, $BS_PRICECAD, $BS_PRICEUSD);
		$BN_PUBLISHER = booknet_html_getPublisher($BS_PUBLISHER, $publisherurl);
		$BN_PUBLICATIONDATE = booknet_html_getPublicationDate($BS_PUBLICATIONDATE);

		$openurl = booknet_html_getOpenUrl($openurlresolver, $BS_TITLE, $BS_ISBN13, $BS_CONTRIBUTOR, $BS_PUBLISHER, $BS_PUBLICATIONDATE);
		$BN_LINK_FINDINLIBRARY = booknet_html_getFindInLibrary($openurlresolver, $openurl, $findinlibraryphrase, $BS_ISBN13, $BS_TITLE, $BS_CONTRIBUTOR);
		$BN_IMAGE_FINDINLIBRARY = booknet_html_getFindInLibraryImage($openurlresolver, $openurl, $findinlibraryimagesrc, $findinlibraryphrase, $BS_ISBN13, $BS_TITLE, $BS_CONTRIBUTOR);
		$BN_COINS = booknet_html_getCoins($BS_TITLE, $BS_ISBN13, $BS_CONTRIBUTOR, $BS_PUBLISHER, $BS_PUBLICATIONDATE);

		$BN_LINK_AMAZON = booknet_html_getLinkAmazon($BS_ISBN10);
		$BN_LINK_CHAPTERSINDIGO = booknet_html_getLinkChaptersIndigo($BS_TITLE, $BS_ISBN13);
		$BN_LINK_GOOGLEBOOKS = booknet_html_getLinkGoogleBooks($BS_ISBN13, $BS_TITLE, $BS_CONTRIBUTOR);
		$BN_LINK_LIBRARYTHING = booknet_html_getLinkLibraryThing($BS_ISBN13, $BS_TITLE, $BS_CONTRIBUTOR);
		$BN_LINK_WORLDCAT = booknet_html_getLinkWorldCat($BS_ISBN13, $BS_TITLE, $BS_CONTRIBUTOR);
		$BN_LINK_BOOKFINDER = booknet_html_getLinkBookFinder($BS_ISBN13, $BS_TITLE, $BS_CONTRIBUTOR);

		//-------------------------------------------------------------------------
		//substitue _BS elements in template

		$display = $template;

		$display = str_ireplace('[BS_COVERURL_FULL]', $BS_COVERURL_FULL, $display);
		$display = str_ireplace('[BS_COVERURL_THUMBNAIL]', $BS_COVERURL_THUMBNAIL, $display);
		$display = str_ireplace('[BS_TITLE]', $BS_TITLE, $display);
		$display = str_ireplace('[BS_SUBTITLE]', $BS_SUBTITLE, $display);
		$display = str_ireplace('[BS_SERIES]', $BS_SERIES, $display);
		$display = str_ireplace('[BS_CONTRIBUTOR]', $BS_CONTRIBUTOR, $display);
		$display = str_ireplace('[BS_FORMAT]', $BS_FORMAT, $display);
		$display = str_ireplace('[BS_PRICECAD]', $BS_PRICECAD, $display);
		$display = str_ireplace('[BS_PRICEUSD]', $BS_PRICEUSD, $display);
		$display = str_ireplace('[BS_PUBLISHER]', $BS_PUBLISHER, $display);
		$display = str_ireplace('[BS_ISBN13]', $BS_ISBN13, $display);
		$display = str_ireplace('[BS_ISBN10]', $BS_ISBN10, $display);
		$display = str_ireplace('[BS_PUBLICATIONDATE]', $BS_PUBLICATIONDATE, $display);

		//-------------------------------------------------------------------------
		//substitue _BN elements in template

		$display = str_ireplace('[BN_COVER_FULL]', $BN_COVER_FULL, $display);
		$display = str_ireplace('[BN_COVER_THUMBNAIL]', $BN_COVER_THUMBNAIL, $display);
		$display = str_ireplace('[BN_TITLE]', $BN_TITLE, $display);
		$display = str_ireplace('[BN_CONTRIBUTOR]', $BN_CONTRIBUTOR, $display);
		$display = str_ireplace('[BN_PRICE]', $BN_PRICE, $display);
		$display = str_ireplace('[BN_PUBLISHER]', $BN_PUBLISHER, $display);
		$display = str_ireplace('[BN_PUBLICATIONDATE]', $BN_PUBLICATIONDATE, $display);
		$display = str_ireplace('[BN_LINK_FINDINLIBRARY]', $BN_LINK_FINDINLIBRARY, $display);
		$display = str_ireplace('[BN_IMAGE_FINDINLIBRARY]', $BN_IMAGE_FINDINLIBRARY, $display);
		$display = str_ireplace('[BN_COINS]', $BN_COINS, $display);
		$display = str_ireplace('[BN_LINK_AMAZON]', $BN_LINK_AMAZON, $display);
		$display = str_ireplace('[BN_LINK_CHAPTERSINDIGO]', $BN_LINK_CHAPTERSINDIGO, $display);
		$display = str_ireplace('[BN_LINK_GOOGLEBOOKS]', $BN_LINK_GOOGLEBOOKS, $display);
		$display = str_ireplace('[BN_LINK_LIBRARYTHING]', $BN_LINK_LIBRARYTHING, $display);
		$display = str_ireplace('[BN_LINK_WORLDCAT]', $BN_LINK_WORLDCAT, $display);
		$display = str_ireplace('[BN_LINK_BOOKFINDER]', $BN_LINK_BOOKFINDER, $display);

		//last substitution: delimiters
		$display = booknet_html_setDelimiters($display);
	}
	catch(Exception $e) {

		$message = $e->getMessage();
		return booknet_getDisplayMessage($message);
	}

	//===================================================
	//6. return book data

	return $display;
}

class booknet_arguments {

	public $atts='';
	public $content='';

	public $booknumber='';
	public $template='';
	public $publisherurl='';
	public $openurlresolver='';
	public $findinlibraryphrase='';
	public $findinlibraryimagesrc='';
	public $domain='';
	public $token='';
	public $country='';
	public $proxy='';
	public $proxyport='';
	public $timeout='';
	public $showerrors='';
	public $savetemplates='';

	function __construct($atts, $content) {

		$this->atts = $atts;
		$this->content = $content;

		//first check for current shortcode format
		//shortcode format takes parameters from inside the tags, e.g., [booknet booknumber="1234"]
		//if both are provided, use new shortcodes
		extract( shortcode_atts( array(
			'booknumber' => '',
			'templatenumber' => '',
			'publisherurl' => ''
			), $atts ) );

		if (!$booknumber) throw new Exception(BN_BOOKNUMBERREQUIRED_LANG);

		//collect option configurations
		//use if inline value not provided above

		if (!$templatenumber) $templatenumber = BN_OPTION_TEMPLATENUMBER_1;
		if ($templatenumber == BN_OPTION_TEMPLATENUMBER_1) $template = trim(get_option(BN_OPTION_TEMPLATE1_NAME));
		elseif ($templatenumber == BN_OPTION_TEMPLATENUMBER_2) $template = trim(get_option(BN_OPTION_TEMPLATE2_NAME));
		elseif ($templatenumber == BN_OPTION_TEMPLATENUMBER_3) $template = trim(get_option(BN_OPTION_TEMPLATE3_NAME));
		elseif ($templatenumber == BN_OPTION_TEMPLATENUMBER_4) $template = trim(get_option(BN_OPTION_TEMPLATE4_NAME));
		elseif ($templatenumber == BN_OPTION_TEMPLATENUMBER_5) $template = trim(get_option(BN_OPTION_TEMPLATE5_NAME));
		else throw new Exception(BN_INVALIDTEMPLATENUMBER_LANG);
		if (!$template) throw new Exception(BN_INVALIDTEMPLATENUMBER_LANG);

		$publisherurl = trim($publisherurl); //don't url encode the url

		$openurlresolver = trim(get_option(BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME));

		$findinlibraryphrase = trim(get_option(BN_OPTION_FINDINLIBRARY_PHRASE_NAME));
		$findinlibraryimagesrc = trim(get_option(BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME));

		$domain = trim(get_option(BN_OPTION_LIBRARY_DOMAIN_NAME));
		if (!$domain) throw new Exception(BN_INVALIDDOMAIN_LANG);

		$token = trim(get_option(BN_OPTION_TOKEN_NAME));
		if (!$token) throw new Exception(BN_INVALIDTOKEN_LANG);

		$country = trim(get_option(BN_OPTION_COUNTRY_NAME));

		$timeout = trim(get_option(BN_OPTION_TIMEOUT_NAME));
		$proxy = trim(get_option(BN_OPTION_PROXY_NAME));
		$proxyport = trim(get_option(BN_OPTION_PROXYPORT_NAME));

		$showerrors = get_option(BN_OPTION_SHOWERRORS_NAME);
		$savetemplates = get_option(BN_OPTION_SAVETEMPLATES_NAME);

		//set return values
		$this->booknumber=$booknumber;
		$this->template=$template;
		$this->publisherurl=$publisherurl;
		$this->template=$template;
		$this->openurlresolver=$openurlresolver;
		$this->findinlibraryphrase=$findinlibraryphrase;
		$this->findinlibraryimagesrc=$findinlibraryimagesrc;
		$this->domain=$domain;
		$this->token=$token;
		$this->country=$country;
		$this->proxy=$proxy;
		$this->proxyport=$proxyport;
		$this->timeout=$timeout;
		$this->showerrors=$showerrors;
		$this->savetemplates=$savetemplates;
	}
}

$mybooknet = new MyBookNet();

add_action('wp_ajax_my_special_action', 'booknet_action_callback');

//server-side call for ajax visual editor button
function booknet_action_callback() {

	$booknumber = $_POST['booknumber'];
	$templatenumber = $_POST['templatenumber'];
	$publisherurl = $_POST['publisherurl'];

	$shortcode_array = array( 'booknumber' => $booknumber, 'templatenumber' => $templatenumber, 'publisherurl' => $publisherurl);

	$ret = booknet_insertbookdata($shortcode_array, null);
	echo $ret;
	die();
}

?>
