<?php

function EWD_URP_Facebook_Config() {
	$Facebook_App_ID = get_option("EWD_URP_Facebook_App_ID");
	$Facebook_Secret = get_option("EWD_URP_Facebook_Secret");

	include_once(EWD_URP_CD_PLUGIN_PATH . "social/facebook.php"); //include facebook SDK
	$fbPermissions = 'public_profile';  //Required facebook permissions
	
	//Call Facebook API
	$facebook = new Facebook(array(
	  'appId'  => $Facebook_App_ID,
	  'secret' => $Facebook_Secret
	
	));

	return $facebook;
}

?>