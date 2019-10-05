<?php

//module contains logic specific to BiblioShare

//get data for one book in BiblioShare
class booknet_biblioshare_bookdata {

	public $bookdata='';

	function __construct($domain, $token, $booknumber, $timeout, $proxy, $proxyport, $showerrors) {

		//clean book number
		$booknumber = trim($booknumber);
		$booknumber = str_replace("'", "", $booknumber); //single quote - prevent problems with string concatenation

		//get the book data
		$url = $domain . '//BNCServices/BNCServices.asmx/BiblioSimple?Token=' . $token . '&EAN=' . $booknumber;
		$result = booknet_utilities_getUrlContents($url, $timeout, $proxy, $proxyport, BN_BIBLIOSHAREDATAUNAVAILABLE_BOOK_LANG, $showerrors);

		$this->bookdata = $result;
	}
}

function booknet_biblioshare_getBookData($domain, $token, $booknumber, $timeout, $proxy, $proxyport, $showerrors) {

}

function booknet_biblioshare_extractValueFormatted($xml, $elementname) {
	$value = $xml ->{$elementname};
	$value = htmlspecialchars($value);
	return $value;
}

//no formatting
function booknet_biblioshare_extractValue($xml, $elementname) {
	$value = $xml ->{$elementname};
	return $value;
}

function booknet_biblioshare_getCoverUrl($domain, $token, $booknumber, $thumbnail) {

	$url_coverimage = $domain . '//BNCServices/BNCServices.asmx/Images?Token=' . $token . '&EAN=' . $booknumber . '&SAN=&Thumbnail=' . $thumbnail;
	return $url_coverimage;
}

?>
