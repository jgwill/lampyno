<?php

function booknet_getDisplayMessage($message) {
	return "<i>[" . $message . "]</i> ";
}

//set default options on first activation and on reset
function booknet_utilities_setDefaultOptions() {

	$deprecated='';
    $autoload='no';

	//test if options exist, if not create them
	$template = get_option(BN_OPTION_TEMPLATE1_NAME); //a required field

	if ($template == FALSE) {
		add_option(BN_OPTION_TEMPLATE1_NAME, BN_OPTION_TEMPLATE1_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_TEMPLATE2_NAME, BN_OPTION_TEMPLATE2_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_TEMPLATE3_NAME, BN_OPTION_TEMPLATE3_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_TEMPLATE4_NAME, BN_OPTION_TEMPLATE4_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_TEMPLATE5_NAME, BN_OPTION_TEMPLATE5_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME, BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_FINDINLIBRARY_PHRASE_NAME, BN_OPTION_FINDINLIBRARY_PHRASE_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME, BN_OPTION_FINDINLIBRARY_IMAGESRC_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_LIBRARY_DOMAIN_NAME, BN_OPTION_LIBRARY_DOMAIN_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_TOKEN_NAME, BN_OPTION_TOKEN_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_COUNTRY_NAME, BN_OPTION_COUNTRY_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_PROXY_NAME, BN_OPTION_PROXY_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_PROXYPORT_NAME, BN_OPTION_PROXYPORT_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_TIMEOUT_NAME, BN_OPTION_TIMEOUT_VAL, $deprecated, $autoload);
		add_option(BN_OPTION_SHOWERRORS_NAME, BN_OPTION_SHOWERRORS_VALUE, $deprecated, $autoload);
		add_option(BN_OPTION_SAVESETTINGS_NAME, BN_OPTION_SAVESETTINGS_VALUE, $deprecated, $autoload);
	}
}

function booknet_utilities_deleteOptions() {

	delete_option(BN_OPTION_TEMPLATE1_NAME);
	delete_option(BN_OPTION_TEMPLATE2_NAME);
	delete_option(BN_OPTION_TEMPLATE3_NAME);
	delete_option(BN_OPTION_TEMPLATE4_NAME);
	delete_option(BN_OPTION_TEMPLATE5_NAME);
	delete_option(BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME);
	delete_option(BN_OPTION_FINDINLIBRARY_PHRASE_NAME);
	delete_option(BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME);
	delete_option(BN_OPTION_LIBRARY_DOMAIN_NAME);
	delete_option(BN_OPTION_TOKEN_NAME);
	delete_option(BN_OPTION_COUNTRY_NAME);
	delete_option(BN_OPTION_PROXY_NAME);
	delete_option(BN_OPTION_PROXYPORT_NAME);
	delete_option(BN_OPTION_TIMEOUT_NAME);
	delete_option(BN_OPTION_SHOWERRORS_NAME);
	delete_option(BN_OPTION_SAVESETTINGS_NAME);
}

function booknet_utilities_getUrlContents($url, $timeout, $proxy, $proxyport, $errmessage, $showerrors) {

	//establish a cURL handle.
	$ch = curl_init($url);

	//set options
	curl_setopt($ch, CURLOPT_HEADER, false); //false=do not include headers
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //true=return as string
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); //timeout for when OL is down

	//set user defined constants
	//timeout for when OL is down or slow
	if ($timeout) {
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // timeout on connect
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // timeout on response
	}

	if ($proxy) curl_setopt($ch, CURLOPT_PROXY, $proxy); //proxy server name
	if ($proxyport) curl_setopt($ch, CURLOPT_PROXYPORT, $proxyport); //proxy port

	// Execute the request
	$output = curl_exec($ch);
	if (stripos($output, 'Server')>0 && stripos($output, 'Error')>0) { throw new Exception (BN_OLSERVERERROR_LANG); }

	//handle errors
	$err = curl_errno($ch);
	if($err!=0) {
		if ($err == '28') {
			curl_close($ch);
			throw new Exception(BN_CURLTIMEOUT_LANG);
		}
		else {
			if ($showerrors == BN_HTML_CHECKED_TRUE) {
				$errmsg = curl_error($ch); //see more at http://us.php.net/manual/en/function.curl-getinfo.php
				//$header = curl_getinfo($ch);
				curl_close($ch); //close after obtaining error info
				throw new Exception('cURL error ' . $err . ' - ' . $errmsg . ' - ' . $url);
			}
			throw new Exception(BN_CURLERROR_LANG);
		}
	}
	elseif($output == "" || $output == FALSE) {
		curl_close($ch);
		throw new Exception($errmessage);
	}

	// Close the cURL session.
	curl_close($ch);

	return $output;
}

//test if 10 or 13 digits ISBN
function booknet_utilities_validISBN($testisbn) {
	return (preg_match ("([0-9]{10})", $testisbn, $regs) || preg_match ("([0-9]{13})", $testisbn, $regs));
}

function booknet_utilities_getDomain()
{
	return strip_tags( $_SERVER[ "SERVER_NAME" ] );
}

?>
