<?php

//module handles all booknet html formatting
//no styling here, just html

function booknet_html_getCoverImage($url_coverimage, $title) {

	$html_coverimage = "<img src='" . $url_coverimage . "' alt='" . $title . "' title='" . $title . "' />";
	return $html_coverimage;
}

function booknet_html_getTitle($title, $subtitle) {

	if ($subtitle != "") $title .= ": " . $subtitle;
	return $title;
}

function booknet_html_getContributor($contributor) {

	if ($contributor != "") {
		$url_flag = WP_PLUGIN_URL . '/bnc-biblioshare/canada_flag.png';
		$html_flag = "<img src='" . $url_flag . "' alt='(CA)' title='(CA)' />";
		$contributor = str_ireplace('(CA)', $html_flag, $contributor);
	}
	return $contributor;
}

function booknet_html_getPrice($country, $priceCAD, $priceUSD) {

	if ($country==BN_OPTION_COUNTRY_CA) $html_price = $priceCAD;
	else $html_price = $priceUSD;
	return $html_price;
}

function booknet_html_getPublisher($publisher, $publisherurl) {

	$html_publisher = "";
	if ($publisher != '') {
		$html_publisher = $publisher;
		if ($publisherurl != '') {
			$html_publisher = "<a href='" . $publisherurl . "' title='" . BN_DISPLAY_CLICKTOVIEWPUBLISHER_LANG . "' >" . $publisher . "</a>";
		}
	}

	return 	$html_publisher;
}

function booknet_html_getPublicationDate($publicationdate) {

	$html_publicationdate = "";
	if ($publicationdate != '') {
		$date = new DateTime($publicationdate);
		$html_publicationdate = $date->format('M d, Y');
	}
	return 	$html_publicationdate;
}

function booknet_html_getOpenUrl($openurlresolver, $title, $isbn, $authors, $publisher, $publishdate) {

	if (!$openurlresolver) return "";

	$openurl = $openurlresolver;
	$openurl .= '?url_ver=Z39.88-2004';
	$openurl .= '&amp;rft_val_fmt=info%3Aofi%2Ffmt%3Akev%3Amtx%3Abook';
	$openurl .= booknet_html_getCoinsContents($title, $isbn, $authors, $publisher, $publishdate);

	return $openurl;
}

function booknet_html_getFindInLibrary($openurlresolver, $openurl, $findinlibraryphrase, $isbn, $title, $author) {

	$html_findinlibrary = "";

	if (!$openurlresolver || !$findinlibraryphrase) return ""; //if resolver or phrase is not configured this feature will be blank

	$url = $openurl;
	$html_findinlibrary = '<a href="' . $url . '" title="' . $findinlibraryphrase . '">' . $findinlibraryphrase . '</a>';

	return $html_findinlibrary;
}

function booknet_html_getFindInLibraryImage($openurlresolver, $openurl, $findinlibraryimagesrc, $findinlibraryphrase, $isbn, $title, $author) {

	$html_findinlibraryimage = "";

	if (!$openurlresolver || !$findinlibraryimagesrc) return ""; //if resolver or src is not configured this feature will be blank

	$url = $openurl;
	$html_findinlibraryimage = '<a href="' . $url . '" title="' . $findinlibraryphrase . '">' . '<img src="' . $findinlibraryimagesrc . '" alt="' . $findinlibraryphrase . '" /></a>';

	return $html_findinlibraryimage;
}

//build the HTML for coins, as per http://ocoins.info/
function booknet_html_getCoins($title, $isbn, $authors, $publisher, $publishdate) {

	$domain = booknet_utilities_getDomain();

	//meta values
	$coins = '<span class="Z3988" ';
	$coins .= 'title="ctx_ver=Z39.88-2004';
	$coins .= '&amp;rft_val_fmt=info%3Aofi%2Ffmt%3Akev%3Amtx%3Abook';
	$coins .= '&amp;rfr_id=info%3Asid%2F' . $domain . '%3ABookNet';
	$coins .= '&amp;rft.genre=book';

	$coins .= booknet_html_getCoinsContents($title, $isbn, $authors, $publisher, $publishdate);

	//end
	$coins .= '"></span>';

	return $coins;
}

function booknet_html_getCoinsContents($title, $isbn, $authors, $publisher, $publishdate) {

	$contents = "";

	//title, includes subtitle
	$title = urlencode($title);
	if ($title != "") $contents .= '&amp;rft.btitle=' . $title;

	if ($isbn != "" && booknet_utilities_validISBN($isbn)) $contents .= "&amp;rft.isbn=" . $isbn;

	//author
	$authors_coins = "";

	$authors = explode(",", $authors);
	$authorcount = count($authors);
	for($i=0;$i<$authorcount;$i++) {
		$author = $authors[$i]; //BiblioShare shows "William Shakespeare", i.e., first and lastname as one field;
		$author = urlencode($author);
		$author_coins = '&amp;rft.au=' . $author;
		$authors_coins .= $author_coins;
	}
	if ($authors_coins != "") $contents .= $authors_coins;

	$publisher = urlencode($publisher);
	if ($publisher != "") $contents .= "&amp;rft.pub=" . $publisher;

	$publishdate = urlencode($publishdate);
	if ($publishdate != "") $contents .= "&amp;rft.date=" . $publishdate;

	return $contents;
}

function booknet_html_getLinkGoogleBooks($isbn, $title, $author) {

	if ($isbn) {
		$url = 'http://books.google.com/books?as_isbn=' . $isbn; //isbn search
	}
	elseif ($title) {
		//search by title and author
		$url = 'http://books.google.com/books?&as_vt=' . $title;
		if ($author) $url .= '&as_auth=' . $author;
	}
	else { return ""; }

	$html_link = '<a href="' . $url . '" title="' . BN_DISPLAY_GOOGLEBOOKS_TITLE_LANG . '">' . BN_DISPLAY_GOOGLEBOOKS_LANG . '</a>';
	return $html_link;
}

function booknet_html_getLinkLibraryThing($isbn, $title, $author) {

	if ($isbn) {
		$url = 'http://librarything.com/isbn/' . $isbn; //isbn search
	}
	elseif ($title) {
		//search by title and author
		$url = 'http://www.librarything.com/search_works.php?q=' . $title;
		if ($author) $url .= '+' . $author;
	}
	else { return ""; }

	$html_link = '<a href="' . $url . '" title="' . BN_DISPLAY_LIBRARYTHING_TITLE_LANG . '">' . BN_DISPLAY_LIBRARYTHING_LANG . '</a>';
	return $html_link;
}

function booknet_html_getLinkWorldCat($isbn, $title, $author) {

	if ($isbn) {
		$url = 'http://worldcat.org/isbn/' . $isbn; //isbn search
	}
	elseif ($title) {
		//search by title and author
		$url = 'http://www.worldcat.org/search?q=ti%3A' . $title;
		if ($author) $url .= '+au%3A' . $author;
		$url .= '&qt=advanced';
	}
	else { return ""; }

	$html_link = '<a href="' . $url . '" title="' . BN_DISPLAY_WORLDCAT_TITLE_LANG . '">' . BN_DISPLAY_WORLDCAT_LANG . '</a>';
	return $html_link;
}

function booknet_html_getLinkBookFinder($isbn, $title, $author) {

	$html_bookfinder = "";

	if (!$isbn && !$title) return ""; //if no isbn or title, this feature will be blank

	if ($isbn) $url = 'http://www.bookfinder.com/search/?st=xl&ac=qr&isbn=' . $isbn; //isbn search
	else {
		//search by title and author -- expects spaces in these values as '+'
		$url = 'http://www.bookfinder.com/search/?submit=Begin+search&new_used=*&mode=basic&st=sr&ac=qr&title=' . $title;
		if ($author) $url .= '&author=' . $author;
		//there is an available language parameter for the search
	}

	$html_bookfinder = '<a href="' . $url . '" title="' . BN_DISPLAY_BOOKFINDER_TITLE_LANG . '">' . BN_DISPLAY_BOOKFINDER_LANG . '</a>';

	return $html_bookfinder;
}

function booknet_html_getLinkAmazon($isbn) {

	if ($isbn && (strlen($isbn)==10)) {
		$url = 'http://www.amazon.com/dp/' . $isbn;
	}
	else { return ""; }

	$html_link = '<a href="' . $url . '" title="' . BN_DISPLAY_AMAZON_TITLE_LANG . '">' . BN_DISPLAY_AMAZON_LANG . '</a>';
	return $html_link;
}

function booknet_html_getLinkChaptersIndigo($title, $isbn) {

	if ($isbn) {
		$title = str_replace(' ', '-', $title);
		$url = 'http://www.chapters.indigo.ca/books/' . $title . '/' . $isbn . '-item.html';
	}
	else { return ""; }

	$html_link = '<a href="' . $url . '" title="' . BN_DISPLAY_CHAPTERSINDIGO_TITLE_LANG . '">' . BN_DISPLAY_CHAPTERSINDIGO_LANG . '</a>';
	return $html_link;
}

function booknet_html_setDelimiters($display) {

	//clear double dots, e.g., read online link might be blank
	$exceptions = array('[BN_DOT]  [BN_DOT]', '[BN_DOT] [BN_DOT]', '[BN_DOT][BN_DOT]');
	$display = str_replace($exceptions, '[BN_DOT]', $display);
	$display = str_replace($exceptions, '[BN_DOT]', $display); //first run is supposed to replace all, but doesn't

	$display = str_replace('[BN_DOT]', '&#8226;', $display);

	return $display;
}

?>
