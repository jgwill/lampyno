<div class="wrap">
<?php

include_once('libraries/booknet_constants.php');
include_once('libraries/booknet_language.php');
include_once('libraries/booknet_utilities.php');

$template1 = stripslashes(get_option(BN_OPTION_TEMPLATE1_NAME));
$template2 = stripslashes(get_option(BN_OPTION_TEMPLATE2_NAME));
$template3 = stripslashes(get_option(BN_OPTION_TEMPLATE3_NAME));
$template4 = stripslashes(get_option(BN_OPTION_TEMPLATE4_NAME));
$template5 = stripslashes(get_option(BN_OPTION_TEMPLATE5_NAME));
$token = stripslashes(get_option(BN_OPTION_TOKEN_NAME));
$country = stripslashes(get_option(BN_OPTION_COUNTRY_NAME));
$openurlresolver = get_option(BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME);
$findinlibraryphrase = get_option(BN_OPTION_FINDINLIBRARY_PHRASE_NAME);
$findinlibraryimagesrc = get_option(BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME);
$proxy = get_option(BN_OPTION_PROXY_NAME);
$proxyport = get_option(BN_OPTION_PROXYPORT_NAME);
$timeout = get_option(BN_OPTION_TIMEOUT_NAME);
$showerrors = get_option(BN_OPTION_SHOWERRORS_NAME);
$savesettings = get_option(BN_OPTION_SAVESETTINGS_NAME);

//files affected when you add an option:
//language values in booknet_language.php
//constants in open_constants.php
//add it to booknet_utilities_setDefaultOptions
//scoop it in booknet_getArguments



// Validate the nonce and referrer.  If this fails, check_admin_referer() will automatically print a "failed" page and die.
if ( ! empty( $_POST ) && check_admin_referer( 'booknet-options-submit' ) ) {
   // process form data
   
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$template1 = stripslashes($_POST[BN_OPTION_TEMPLATE1_NAME]);
		$template2 = stripslashes($_POST[BN_OPTION_TEMPLATE2_NAME]);
		$template3 = stripslashes($_POST[BN_OPTION_TEMPLATE3_NAME]);
		$template4 = stripslashes($_POST[BN_OPTION_TEMPLATE4_NAME]);
		$template5 = stripslashes($_POST[BN_OPTION_TEMPLATE5_NAME]);
		$token = stripslashes($_POST[BN_OPTION_TOKEN_NAME]);
		$country = stripslashes($_POST[BN_OPTION_COUNTRY_NAME]);
		$openurlresolver = $_POST[BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME];
		$findinlibraryphrase = $_POST[BN_OPTION_FINDINLIBRARY_PHRASE_NAME];
		$findinlibraryimagesrc = $_POST[BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME];
		$proxy = $_POST[BN_OPTION_PROXY_NAME];
		$proxyport = $_POST[BN_OPTION_PROXYPORT_NAME];
		$timeout = $_POST[BN_OPTION_TIMEOUT_NAME];
		$showerrors = $_POST[BN_OPTION_SHOWERRORS_NAME]; if ($showerrors=='on') $showerrors=BN_HTML_CHECKED_TRUE;
		$savesettings = $_POST[BN_OPTION_SAVESETTINGS_NAME]; if ($savesettings=='on') $savesettings=BN_HTML_CHECKED_TRUE;

		if ($_REQUEST['action'] == 'save') {

			validateRequired(BN_OPTION_TEMPLATE1_LANG, $template1);
			saveOption(BN_OPTION_TEMPLATE1_NAME, $template1);
			saveOption(BN_OPTION_TEMPLATE2_NAME, $template2);
			saveOption(BN_OPTION_TEMPLATE3_NAME, $template3);
			saveOption(BN_OPTION_TEMPLATE4_NAME, $template4);
			saveOption(BN_OPTION_TEMPLATE5_NAME, $template5);

			validateRequired(BN_OPTIONS_TOKEN_LANG, $token);
			saveOption(BN_OPTION_TOKEN_NAME, $token);

			validateRequired(BN_OPTIONS_COUNTRY_LANG, $country);
			saveOption(BN_OPTION_COUNTRY_NAME, $country);

			saveOption(BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME, $openurlresolver);

			validateRequired(BN_OPTION_FINDINLIBRARY_PHRASE_LANG, $findinlibraryphrase);
			saveOption(BN_OPTION_FINDINLIBRARY_PHRASE_NAME, $findinlibraryphrase);

			saveOption(BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME, $findinlibraryimagesrc);

			saveOption(BN_OPTION_PROXY_NAME, $proxy);
			saveOption(BN_OPTION_PROXYPORT_NAME, $proxyport);

			validateRequired(BN_OPTION_TIMEOUT_LANG, $timeout);
			saveOption(BN_OPTION_TIMEOUT_NAME, $timeout);

			saveOption(BN_OPTION_SHOWERRORS_NAME, $showerrors);
			saveOption(BN_OPTION_SAVESETTINGS_NAME, $savesettings);

			echo '<strong><em>' . BN_OPTIONS_CONFIRM_SAVED_LANG . '</strong></em>';
		}
		else if($_REQUEST['action'] == 'reset') {

			booknet_utilities_deleteOptions();
			booknet_utilities_setDefaultOptions();

			$template1 = get_option(BN_OPTION_TEMPLATE1_NAME);
			$template2 = get_option(BN_OPTION_TEMPLATE2_NAME);
			$template3 = get_option(BN_OPTION_TEMPLATE3_NAME);
			$template4 = get_option(BN_OPTION_TEMPLATE4_NAME);
			$template5 = get_option(BN_OPTION_TEMPLATE5_NAME);
			$token = get_option(BN_OPTION_TOKEN_NAME);
			$country = get_option(BN_OPTION_COUNTRY_NAME);
			$openurlresolver = get_option(BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME);
			$findinlibraryphrase = get_option(BN_OPTION_FINDINLIBRARY_PHRASE_NAME);
			$findinlibraryimagesrc = get_option(BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME);
			$proxy = get_option(BN_OPTION_PROXY_NAME);
			$proxyport = get_option(BN_OPTION_PROXYPORT_NAME);
			$timeout = get_option(BN_OPTION_TIMEOUT_NAME);
			$showerrors = get_option(BN_OPTION_SHOWERRORS_NAME);
			$savesettings = get_option(BN_OPTION_SAVESETTINGS_NAME);

			echo '<strong><em>' . BN_OPTIONS_CONFIRM_RESET_LANG  . '</strong></em>';
		}
	}
}

if ($country==BN_OPTION_COUNTRY_US) {$country_us_selected=' SELECTED ';} else {$country_us_selected='';}

function validateRequired($option_name, $option_value) {
	$option_value = trim($option_value);
	$message = $option_name . BN_VALUEREQUIRED_LANG;
	if ($option_value == '') wp_die($message);
}

//update or insert
function saveOption($option_name, $option_value) {

	$option_value = trim($option_value);

	if (get_option($option_name)) {
    		update_option($option_name, $option_value);
  	}
	else {
    		$deprecated='';
    		$autoload='no';
			delete_option($option_name); //handles case where option exists with a blank value - fails get_option test in this function
    		add_option($option_name, $option_value, $deprecated, $autoload);
  	}
}

?>

<h2>BNC BiblioShare</h2>

<form method="post" action="">

<?php 
// Emit the nonce and referrer to prevent CSRF attacks.
wp_nonce_field( 'booknet-options-submit' ); 
?>

<h3><?php echo BN_OPTIONS_TEMPLATETEMPLATES_LANG; ?></h3>
<p><?php echo BN_OPTIONS_TEMPLATETEMPLATES_DETAIL_LANG; ?></p>

<table class="form-table">

<tr valign="top">
<td width="12%"><?php echo BN_OPTION_TEMPLATE1_LANG ?></td>
<td><textarea cols="80" rows="8" name="<?php echo BN_OPTION_TEMPLATE1_NAME ?>" ><?php echo htmlentities($template1, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?></textarea></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTION_TEMPLATE2_LANG ?></td>
<td><textarea cols="80" rows="8" name="<?php echo BN_OPTION_TEMPLATE2_NAME ?>" ><?php echo htmlentities($template2, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?></textarea></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTION_TEMPLATE3_LANG ?></td>
<td><textarea cols="80" rows="8" name="<?php echo BN_OPTION_TEMPLATE3_NAME ?>" ><?php echo htmlentities($template3, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?></textarea></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTION_TEMPLATE4_LANG ?></td>
<td><textarea cols="80" rows="8" name="<?php echo BN_OPTION_TEMPLATE4_NAME ?>" ><?php htmlentities($template4, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?></textarea></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTION_TEMPLATE5_LANG ?></td>
<td><textarea cols="80" rows="8" name="<?php echo BN_OPTION_TEMPLATE5_NAME ?>" ><?php echo htmlentities($template5, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?></textarea></td>
</tr>

</table>

<h3><?php echo BN_OPTIONS_USER_LANG; ?></h3>
<table class="form-table">

<tr valign="top">
<td width="12%"><?php echo BN_OPTIONS_TOKEN_LANG; ?></td>
<td width="28%"><input type="text" name="<?php echo BN_OPTION_TOKEN_NAME ?>" value="<?php echo htmlentities($token, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="50" /></td>
<td><?php echo BN_OPTIONS_TOKEN_DETAIL_LANG; ?><a href="http://booknetcanada.ca/index.php?option=com_forme&Itemid=590&fid=11">BiblioShare Developer Token Request Form</a>.</td>
</tr>

<tr valign="top">
<td width="12%"><?php echo BN_OPTIONS_COUNTRY_LANG; ?></td>
<td width="28%">
	<select name="<?php echo BN_OPTION_COUNTRY_NAME ?>">
		<option value="<?php echo BN_OPTION_COUNTRY_CA ?>"><?php echo BN_OPTIONS_COUNTRY_CA_LANG ?></option>
		<option value="<?php echo BN_OPTION_COUNTRY_US ?>" <?php echo $country_us_selected ?>><?php echo BN_OPTIONS_COUNTRY_US_LANG ?></option>
	</select>
</td>
<td><?php echo BN_OPTIONS_COUNTRY_DETAIL_LANG; ?></td>
</tr>

</table>

<h3><?php echo BN_OPTIONS_FINDINLIBRARY_LANG; ?></h3>
<table class="form-table">

<tr valign="top">
<td width="12%"><?php echo BN_OPTIONS_FINDINLIBRARY_OPENURLRESOLVER_LANG; ?></td>
<td width="28%"><input type="text" name="<?php echo BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME ?>" value="<?php echo htmlentities($openurlresolver, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="50" /></td>
<td><?php echo BN_OPTIONS_FINDINLIBRARY_OPENURLRESOLVER_DETAIL_LANG; ?> <a href="http://www.worldcat.org/registry/institutions">WorldCat Registry</a>.</td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTIONS_FINDINLIBRARY_PHRASE_LANG; ?></td>
<td><input type="text" name="<?php echo BN_OPTION_FINDINLIBRARY_PHRASE_NAME; ?>" value="<?php echo htmlentities($findinlibraryphrase, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="50" /></td>
<td><?php echo BN_OPTIONS_FINDINLIBRARY_PHRASE_DETAIL_LANG; ?></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTIONS_FINDINLIBRARY_IMAGESRC_LANG; ?></td>
<td><input type="text" name="<?php echo BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME; ?>" value="<?php echo htmlentities($findinlibraryimagesrc, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="50" /></td>
<td><?php echo BN_OPTIONS_FINDINLIBRARY_IMAGESRC_DETAIL_LANG; ?></td>
</tr>

</table>

<h3><?php echo BN_OPTIONS_SYSTEM_LANG; ?></h3>
<table class="form-table">

<tr valign="top">
<td><?php echo BN_OPTION_SYSTEM_PROXY_LANG; ?></td>
<td><input type=text name="<?php echo BN_OPTION_PROXY_NAME ?>" value="<?php echo htmlentities($proxy, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="50" /></td>
<td><?php echo BN_OPTION_SYSTEM_PROXY_DETAIL_LANG; ?></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTION_SYSTEM_PROXYPORT_LANG; ?></td>
<td><input type=text name="<?php echo BN_OPTION_PROXYPORT_NAME ?>" value="<?php echo htmlentities($proxyport, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="5" /></td>
<td><?php echo BN_OPTION_SYSTEM_PROXYPORT_DETAIL_LANG; ?></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTION_SYSTEM_TIMEOUT_LANG; ?></td>
<td><input type=text name="<?php echo BN_OPTION_TIMEOUT_NAME ?>" value="<?php echo htmlentities($timeout, ENT_COMPAT | ENT_HTML401, ini_get("default_charset"), false); ?>" size="5" /></td>
<td><?php echo BN_OPTION_SYSTEM_TIMEOUT_DETAIL_LANG; ?></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTIONS_SHOWERRORS_LANG; ?></td>
<td><input type="checkbox" name="<?php echo BN_OPTION_SHOWERRORS_NAME; ?>" <?php echo ' ' . $showerrors . ' '; ?> /> </td>
<td><?php echo BN_OPTIONS_SHOWERRORS_DETAIL_LANG; ?></td>
</tr>

<tr valign="top">
<td><?php echo BN_OPTIONS_SAVESETTINGS_LANG; ?></td>
<td><input type="checkbox" name="<?php echo BN_OPTION_SAVESETTINGS_NAME; ?>" <?php echo ' ' . $savesettings . ' '; ?> /> </td>
<td><?php echo BN_OPTIONS_SAVESETTINGS_DETAIL_LANG; ?></td>
</tr>

</table>

<p class="submit">
<input name="save" type="submit" class="button-primary" value="<?php echo BN_OPTIONS_SAVECHANGES_LANG ?>" />
<input type="hidden" name="action" value="save" />
</form>

<form method="post">
<input name="reset" type="submit" class="button-primary" value="<?php echo BN_OPTIONS_RESET_LANG ?>" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<br>

</div>
