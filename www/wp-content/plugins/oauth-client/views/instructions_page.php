<?php

function mo_oauth_client_instructions($appname, $newdiv){
	
	if($newdiv)
		echo '</div><div class="mo_table_layout" id="howtoconfigure"> <br><b>Here are the Step by Step Guides for different OAuth Servers:</b><br><ul><table class="mo_table-bordered" height="125" width="300">

	 <tr>
	 <th>OAuth Servers</th><th>Links</th></tr>
	 
	 <tr><td style="text-align:center;">miniOrange OAuth Server</td><td style="text-align:center;"><a target="_blank" href="https://miniorange.com/step-by-step-guide-to-setup-miniorange-oauth-server.php">Click Here</td></tr>
	 <tr><td style="text-align:center;">Custom OAuth Server</td><td style="text-align:center;"><a target="_blank" href="https://miniorange.com/step-by-step-guide-to-setup-custom-oauth-server.php">Click Here</td></tr>
	 </table> </ul>';
	
	if($appname=="google"){
		echo '<br><strong>Instructions to configure Google :</strong><ol><li>Visit the Google website for developers <a href="https://console.developers.google.com/project"target="_blank">console.developers.google.com</a>.</li><li>Open the Google API Console Credentials page and go to API Manager -> Credentials</li><li>From the project drop-down, choose Create a new project, enter a name for the project, and optionally, edit the provided Project ID. Click Create.</li><li>On the Credentials page, select Create credentials, then select OAuth client ID.</li><li>You may be prompted to set a product name on the Consent screen. If so, click Configure consent screen, supply the requested information, and click Save to return to the Credentials screen.</li><li>Select Web Application for the Application Type. Follow the instructions to enter JavaScript origins, redirect URIs, or both. For Redirect URI provide the <b>Configure OAuth->Redirect/Callback URI</b>h.</li><li>Click Create.</li><li>On the page that appears, copy the client ID and client secret to your clipboard, as you will need them to configure above.</li><li>Enable the Google+ API.</li><li>Go to Appearance->Widgets. Among the available widgets youwill find miniOrange OAuth, drag it to the widget area where you want it to appear.</li><li>Now logout and go to your site. You will see a login link where you placed that widget.</li></ol>';
	} else if($appname=="facebook"){
		echo '<br><strong>Instructions to configure Facebook : </strong><ol><li>Go to Facebook developers console <a href="https://developers.facebook.com/apps/" target="_blank">https://developers.facebook.com/apps/</a>.</li><li>Click on Create a New App/Add new App button. You will need to register as a Facebook developer to create an App.</li><li>Enter <b>Display Name</b>. And choose category.</li><li>Click on <b>Create App ID</b>.</li><li>From the left pane, select <b>Settings</b>.</li><li>From the tabs above, select <b>Advanced</b>.</li><li>Under <b>Client OAuth Settings</b>, enter <b>Configure OAuth->Redirect/Callback URI</b> in Valid OAuth redirect URIs and click <b>Save Changes</b>.</li><li>Paste your App ID/Secret provided by Facebook into the fields above.</li><li>Click on the Save settings button.Go to Appearance->Widgets. Among the available widgets youwill find miniOrange OAuth, drag it to the widget area where you want it to appear.</li><li>Now logout and go to your site. You will see a login link where you placed that widget.</li></ol>';
	} else if($appname=="eveonline"){
		echo '<strong>Instructions:</strong><ol><li>Log in to your EVE Online account</li><li>At EVE Online, go to Support. Request for enabling OAuthfor a third-party application.</li><li>At EVE Online, add a new project/application. GenerateClient ID and Client Secret.</li><li>At EVE Online, set Redirect URL as <b>https://login.xecurify.com/moas/oauth/client/callback</b></li><li>Enter your Client ID and Client Secret above.</li><li>Click on the Save settings button.</li><li>Go to Appearance->Widgets. Among the available widgets you will find miniOrange OAuth, drag it to the widget area where you want it to appear.</li><li>Now logout and go to your site. You will see a login link where you placed that widget.</li></ol>';
	}  else if($appname=="eveonlinenew") {
		echo '<strong>Instructions:</strong><ol><li>Log in to your EVE Online account</li><li>At EVE Online, go to Support. Request for enabling OAuth for a third-party application.</li><li>At EVE Online, add a new project/application. Generate Client ID and Client Secret.</li><li>At EVE Online, set Redirect URL as <b>Configure OAuth->Redirect/Callback URI</b></li><li>Enter your Client ID and Client Secret above.</li><li>Click on the Save settings button.</li><li>Go to Appearance->Widgets. Among the available widgets you will find miniOrange OAuth, drag it to the widget area where you want it to appear.</li><li>Now logout and go to your site. You will see a login link where you placed that widget.</li></ol>';
	} else{
		echo '<br><strong>Instructions to configure custom OAuth Server:</strong><ol><li>Enter your Client ID and Client Secret above.</li><li>Click on the Save settings button.</li><li>Provide <b>Configure OAuth->Redirect/Callback URI</b> for your OAuth server Redirect URI.</li><li>Go to Appearance->Widgets. Among the available widgets you will find miniOrange OAuth, drag it to the widget area where you want it to appear.</li><li>Now logout and go to your site. You will see a login link where you placed that widget.</li></ol>';
	}
}

?>