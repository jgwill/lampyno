<?php

require('shortcode.functions.php');
require('shortcode.request.php');


function Zotpress_func( $atts )
{
    extract( shortcode_atts( array(

        'user_id' => false, // deprecated
        'userid' => false,
        'nickname' => false,
        'nick' => false,

        'author' => false,
        'authors' => false,
        'year' => false,
        'years' => false,

        'item_type' => 'items',
        'data_type' => false, // deprecated
        'datatype' => 'items',

        'collection_id' => false,
        'collection' => false,
        'collections' => false,

        'item_key' => false,
        'item' => false,
        'items' => false,

        'inclusive' => 'yes',

        'tag_name' => false,
        'tag' => false,
        'tags' => false,

        'style' => false,
        'limit' => false,

        'sortby' => 'default',
        'order' => false,
        'sort' => false,

        'title' => 'no',

        'image' => false,
        'images' => false,
        'showimage' => 'no',

        'showtags' => 'no',

        'downloadable' => 'no',
        'download' => 'no',

        'shownotes' => false,
        'note' => false,
        'notes' => 'no',

        'abstract' => false,
        'abstracts' => 'no',

        'cite' => 'no',
        'citeable' => false,

        'metadata' => false,

        'target' => false,
		'urlwrap' => false,

		'highlight' => false,
		'forcenumber' => false,
		'forcenumbers' => false

    ), $atts, 'zotpress'));


    // FORMAT & CLEAN PARAMETERS

    // Filter by account
    if ($user_id) $api_user_id = zp_clean_param( $user_id );
    else if ($userid) $api_user_id = zp_clean_param( $userid );
    else $api_user_id = false;

    if ($nickname) $nickname = zp_clean_param( $nickname );
    if ($nick) $nickname = zp_clean_param( $nick );

    // Filter by author
    $author = zp_clean_param( $author );
    if ($authors) $author = zp_clean_param( $authors );

    // Filter by year
    if ( $year ) $year = zp_clean_param( $year );
    else if ($years) $year = zp_clean_param( $years );
    else if (strpos($year, ",") > 0) $year = explode(",", $year);
	else $year = "";

    // Format with datatype and content
    if ($item_type) $item_type = zp_clean_param( $item_type );
    else if ($data_type) $item_type = zp_clean_param( $data_type );
    else $item_type = zp_clean_param( $datatype );

    // Filter by collection
    if ($collection_id) $collection_id = zp_clean_param( $collection_id );
    else if ($collection) $collection_id = zp_clean_param( $collection );
    else if ($collections) $collection_id = zp_clean_param( $collections );
	$collection_id = str_replace(" ", "", $collection_id );

    if (strpos($collection_id, ",") > 0) $collection_id = explode(",", $collection_id);
    if ($item_type == "collections" && isset($_GET['zpcollection']) ) $collection_id = htmlentities( urldecode( $_GET['zpcollection'] ) );

    // Filter by tag
    if ($tag_name) $tag_id = zp_clean_param( $tag_name );
    else if ($tags) $tag_id = zp_clean_param( $tags );
    else $tag_id = zp_clean_param( $tag );

    $tag_id = str_replace("+", "", $tag_id);
    if (strpos($tag_id, ",") > 0) $tag_id = explode(",", $tag_id);
    if ($item_type == "tags" && isset($_GET['zptag']) ) $tag_id = htmlentities( urldecode( $_GET['zptag'] ) );

    // Filter by itemkey
    if ($item_key) $item_key = zp_clean_param( $item_key );
    if ($items) $item_key = zp_clean_param( $items );
    if ($item) $item_key = zp_clean_param( $item );
    if (strpos($item_key, ", ") > 0) $item_key = str_replace(', ',',',html_entity_decode($item_key)); // remove spces after commas
    // if (strpos($item_key, ",") > 0) $item_key = explode(",", $item_key); // ? break at commas?
	$item_key = str_replace(" ", "", $item_key ); // remove any spaces

	// Inclusive (for multiple authors)
    if ($inclusive == "yes" || $inclusive == "true" || $inclusive === true ) $inclusive = true; else $inclusive = false;

    // Format style
    $style = zp_clean_param( $style );

    // Limit
    $limit = zp_clean_param( $limit );

    // Order / sort
    $sortby = zp_clean_param( $sortby );

    if ($order) $order = strtolower(zp_clean_param( $order ));
    else if ($sort) $order = strtolower(zp_clean_param( $sort ));
    if ($order === false) $order = "asc";

    // Show title
	// Sorting by secondary sort
    $title = zp_clean_param( $title );
    if ( $title == "yes" || $title == "true" || $title === true )
        $title = "year";
    else if ( $title == "no" || $title == "false" )
        $title = false;

    // Show image
    if ($showimage) $showimage = zp_clean_param( $showimage );
    if ($image) $showimage = zp_clean_param( $image );
    if ($images) $showimage = zp_clean_param( $images );

    if ($showimage == "yes" || $showimage == "true" || $showimage === true ) $showimage = true;
	else if ( $showimage === "openlib") $showimage = "openlib";
    else $showimage = false;

    // Show tags
    if ($showtags == "yes" || $showtags == "true" || $showtags === true) $showtags = true;
    else $showtags = false;

    // Show download link
    if ($download == "yes" || $download == "true" || $download === true
            || $downloadable == "yes" || $downloadable == "true" || $downloadable === true)
        $downloadable = true; else $downloadable = false;

    // Show notes
    if ($shownotes) $shownotes = zp_clean_param( $shownotes );
    else if ($notes) $shownotes = zp_clean_param( $notes );
    else if ($note) $shownotes = zp_clean_param( $note );

    if ($notes == "yes" || $notes == "true" || $notes === true) $shownotes = true;
    else $shownotes = false;

    // Show abstracts
    if ($abstracts) $abstracts = zp_clean_param( $abstracts );
    if ($abstract) $abstracts = zp_clean_param( $abstract );

    if ($abstracts == "yes" || $abstracts == "true" || $abstracts === true) $abstracts = true;
    else $abstracts = false;

    // Show cite link
    if ($cite) $citeable = zp_clean_param( $cite );
    if ($citeable) $citeable = zp_clean_param( $citeable );

    if ($citeable == "yes" || $citeable == "true" || $citeable === true) $citeable = true;
    else $citeable = false;

    if ( ! preg_match("/^[0-9a-zA-Z]+$/", $metadata) ) $metadata = false;

	// URL attributes
    if ($target == "yes" || $target == "_blank" || $target == "new" || $target == "true" || $target === true)
    $target = true; else $target = false;

    if ($urlwrap == "title" || $urlwrap == "image" ) $urlwrap = zp_clean_param( $urlwrap );
	else $urlwrap = false;

    if ($highlight ) $highlight = zp_clean_param( $highlight ); else $highlight = false;

    if ( $forcenumber == "yes" || $forcenumber == "true" || $forcenumber === true
            || $forcenumbers == "yes" || $forcenumbers == "true" || $forcenumbers === true )
        $forcenumber = true; else $forcenumber = false;




    // GET ACCOUNT

    global $wpdb;

    // Turn on/off minified versions if testing/live
    $minify = ''; if ( ZOTPRESS_LIVEMODE ) $minify = '.min';

	wp_enqueue_script( 'zotpress.shortcode.bib'.$minify.'.js' );

    // Get account (api_user_id)
    $zp_account = false;

    if ($nickname !== false)
    {
        $zp_account = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."zotpress WHERE nickname='".$nickname."'", OBJECT);

		if ( is_null($zp_account) ):
            return "<p>Sorry, but the selected Zotpress nickname can't be found.</p>";
        endif;

        $api_user_id = $zp_account->api_user_id;
    }
    else if ($api_user_id !== false)
    {
        $zp_account = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."zotpress WHERE api_user_id='".$api_user_id."'", OBJECT);

		if ( is_null($zp_account) ):
            return "<p>Sorry, but the selected Zotpress account can't be found.</p>";
        endif;

        $api_user_id = $zp_account->api_user_id;
    }
    else if ($api_user_id === false && $nickname === false)
    {
        if (get_option("Zotpress_DefaultAccount") !== false)
        {
            $api_user_id = get_option("Zotpress_DefaultAccount");
            $zp_account = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."zotpress WHERE api_user_id ='".$api_user_id."'", OBJECT);
        }
        else // When all else fails ...
        {
            $zp_account = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."zotpress LIMIT 1", OBJECT);
            $api_user_id = $zp_account->api_user_id;
        }
    }

    // Generate instance id for shortcode
	if ( is_array( $item_key ) ) $temp_item_key = implode( "-", $item_key); else $temp_item_key = $item_key;
	if ( is_array( $collection_id ) ) $temp_collection_id = implode( "-", $collection_id); else $temp_collection_id = $collection_id;
	if ( is_array( $tag_id ) ) $temp_tag_name = implode( "-", $tag_id); else $temp_tag_name = $tag_id;
	if ( is_array( $author ) ) $temp_author = implode( "-", $author); else $temp_author = $author;
	if ( is_array( $year ) ) $temp_year = implode( "-", $year); else $temp_year = $year;
	if ( is_array( $sortby ) ) $temp_sortby = implode( "-", $sortby); else $temp_sortby = $sortby;
    // REVIEW: Added post ID
    $instance_id = "zotpress-".md5(get_the_ID().$api_user_id.$nickname.$temp_author.$temp_year.$item_type.$temp_collection_id.$temp_item_key.$temp_tag_name.$style.$temp_sortby.$order.$limit.$showimage.$showtags.$downloadable.$shownotes.$citeable.$inclusive);

	// Prepare item key
	if ( $item_key ) if ( gettype( $item_key ) != "string" ) $item_key = implode( ",", $item_key );

	// Prepare collection
	if ( $collection_id ) if ( gettype( $collection_id ) != "string" ) $collection_id = implode( ",", $collection_id );

	// Prepare tags
	if ( $tag_id ) if ( gettype( $tag_id ) != "string" ) $tag_id = implode( ",", $tag_id );

    // Set up request vars
    $request_start = 0;
    $request_last = 0;
    $overwrite_last_request = false;

    // Set up Library vars
    $is_dropdown = false;
    $maxresults = 50;
    $maxperpage = 10;
    $maxtags = 100;

    // Set up Search vars
    $term = false;

    // Set up Update vars
    $update = false;

	$zp_output = '<div id="' . $instance_id . '" class="zp-Zotpress zp-Zotpress-Bib';
	if ( $forcenumber ) $zp_output .= " forcenumber";
	$zp_output .= '">

		<span class="ZP_API_USER_ID" style="display: none;">'.$api_user_id.'</span>
		<span class="ZP_ITEM_KEY" style="display: none;">'.$item_key.'</span>
		<span class="ZP_COLLECTION_ID" style="display: none;">'.$collection_id.'</span>
		<span class="ZP_TAG_ID" style="display: none;">'.$tag_id.'</span>
		<span class="ZP_AUTHOR" style="display: none;">'.$author.'</span>
		<span class="ZP_YEAR" style="display: none;">'.$year.'</span>
		<span class="ZP_ITEM_TYPE" style="display: none;">'.$item_type.'</span>
		<span class="ZP_INCLUSIVE" style="display: none;">'.$inclusive.'</span>
		<span class="ZP_STYLE" style="display: none;">'.$style.'</span>
		<span class="ZP_LIMIT" style="display: none;">'.$limit.'</span>
		<span class="ZP_SORTBY" style="display: none;">'.$sortby.'</span>
		<span class="ZP_ORDER" style="display: none;">'.$order.'</span>
		<span class="ZP_TITLE" style="display: none;">'.$title.'</span>
		<span class="ZP_SHOWIMAGE" style="display: none;">'.$showimage.'</span>
		<span class="ZP_SHOWTAGS" style="display: none;">'.$showtags.'</span>
		<span class="ZP_DOWNLOADABLE" style="display: none;">'.$downloadable.'</span>
		<span class="ZP_NOTES" style="display: none;">'.$shownotes.'</span>
		<span class="ZP_ABSTRACT" style="display: none;">'.$abstracts.'</span>
		<span class="ZP_CITEABLE" style="display: none;">'.$citeable.'</span>
		<span class="ZP_TARGET" style="display: none;">'.$target.'</span>
		<span class="ZP_URLWRAP" style="display: none;">'.$urlwrap.'</span>
		<span class="ZP_FORCENUM" style="display: none;">'.$forcenumber.'</span>
        <span class="ZP_HIGHLIGHT" style="display: none;">'.$highlight.'</span>
		<span class="ZOTPRESS_PLUGIN_URL" style="display:none;">'.ZOTPRESS_PLUGIN_URL.'</span>

		<div class="zp-List loading">';


    // GENERATE SHORTCODE PLACEHOLDER

    if ( $zp_account === false )
    {
        $zp_output .= "\n<div id='".$instance_id."' class='zp-Zotpress'>Sorry, no citation(s) found for this account.</div>\n";
    }
    else // Make the first request via PHP for SEO purposes
    {
        $_GET['instance_id'] = $instance_id;
        $_GET['api_user_id'] = $api_user_id;
        $_GET['item_key'] = $item_key;
        $_GET['collection_id'] = $collection_id;
        $_GET['tag_id'] = $tag_id;
        $_GET['author'] = $author;
        $_GET['year'] = $year;
        $_GET['item_type'] = $item_type;
        $_GET['inclusive'] = $inclusive;
        $_GET['style'] = $style;
        $_GET['limit'] = $limit;
        $_GET['sortby'] = $sortby;
        $_GET['order'] = $order;
        $_GET['title'] = $title;
        $_GET['showimage'] = $showimage;
        $_GET['showtags'] = $showtags;
        $_GET['downloadable'] = $downloadable;
        $_GET['shownotes'] = $shownotes;
        $_GET['abstracts'] = $abstracts;
        $_GET['citeable'] = $citeable;
        $_GET['target'] = $target;
        $_GET['urlwrap'] = $urlwrap;
        $_GET['forcenumber'] = $forcenumber;
        $_GET['highlight'] = $highlight;
        $_GET['request_start'] = $request_start;
        $_GET['request_last'] = $request_last;
        $_GET['is_dropdown'] = $is_dropdown;
        $_GET['maxresults'] = $maxresults;
        $_GET['maxperpage'] = $maxperpage;
        $_GET['maxtags'] = $maxtags;
        $_GET['term'] = $term;
        $_GET['update'] = $update;
        $_GET['overwrite_last_request'] = $overwrite_last_request;

        $zp_output .= "\n<div class=\"zp-SEO-Content\">";
        $zp_output .= Zotpress_shortcode_request( true ); // Check catche first
        $zp_output .= "</div><!-- .zp-zp-SEO-Content -->\n";
    }

	$zp_output .= "</div><!-- .zp-List --></div><!--.zp-Zotpress-->\n\n";


	// Indicate that shortcode is displayed

	$GLOBALS['zp_is_shortcode_displayed'] = true;

	return $zp_output;
}

?>
