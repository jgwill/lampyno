=== OAuth 2.0 client for SSO ===
Contributors: cyberlord92,oauth
Tags: oauth, oauth 2.0, oauth login, oauth sso, oauth single sign on
Requires at least: 3.0.1
Tested up to: 5.2.1
Stable tag: 1.9.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

OAuth Login plugin allows Single Sign On (SSO) with your Eve Online, Slack, Discord or any custom OAuth server with OAuth 2.0 standard

== Description ==

OAuth Login plugin allows login with your Eveonline, Slack, Discord, Custom OAuth server, Openid Connect provider. OAuth Client plugin works with any OAuth provider that conforms to the OAuth 2.0 standard which provides quick & easy configuration.


= FREE VERSION FEATURES =

*	OAuth Login supports login (sso) with any 3rd party OAuth server or custom OAuth server.
*	Attribute Mapping : OAuth Login supports basic Attribute Mapping feature to map WordPress user profile attributes like email and first name. Manage username & email with data provided
*	OAuth Provider Support : OAuth Login supports only one OAuth Provider. (ENTERPRISE : Supports Multiple OAuth Provider)
*	Redirect URL after Login : OAuth Login Automatically Redirects user after successful login. Note: Does not include custom redirect URL
*	Display Options : OAuth Login Provides Display Option for both Login form and Registration form
*	Logging : If you run into issues OAuth Login can be helpful to enable debug logging


= STANDARD VERSION FEATURES =

*	All the Free Version Features
*	Optionally Auto Register Users : OAuth Login does automatic user registration after login if the user is not already registered with your site
*	Attribute Mapping : OAuth Login provides custom Attribute Mapping feature to map WordPress user profile attributes like username, firstname, lastname, email and profile picture. Manage username & email with data provided
*	Login Widget : Use Widgets to easily integrate the login link with your WordPress site
*	Support for Shortcode : Use shortcode to place OAuth login button anywhere in your Theme or Plugin
*	Customize Login Buttons / Icons / Text : Wide range of OAuth login Buttons/Icons and it allows you to customize Text shadow
*	Custom Redirect URL after Login : OAuth Login provides Auto Redirection and this is useful if you wanted to globally  protect your whole site
*	Redirect URL after logout : OAuth Login auto Redirect Users to custom URL after logout in WordPress
*	Basic Role Mapping : Assign default role to user registering through OAuth Login based on rules you define.


= PREMIUM VERSION FEATURES =

*	All the Standard Version Features
*	Advanced Role Mapping : Assign roles to users registering through OAuth Login based on rules you define.
*	OpenID Connect Support : OAuth Login supports login with any 3rd party OpenID Connect server.
*	Multiple Userinfo Endpoints Support : OAuth Login supports multiple Userinfo Endpoints.
*	Account Linking : OAuth Login supports the linking of user accounts from OAuth Providers to Wordpress account.
*	App domain specific Registration Restrictions : OAuth Login restricts registration on your site based on the person's email address domain
*	Multi-site Support : OAuth Login have unique ability to support multiple sites under one account
*	Extended OAuth API support : Extend OAuth API support to extend functionality to the existing OAuth client.[ENTERPRISE]
*	BuddyPress Attribute Mapping : OAuth Login allows BuddyPress Attribute Mapping.[ENTERPRISE]
*	Page Restriction according to roles : Limit Access to pages based on user status or roles. This WordPress OAuth Login plugin allows you to restrict access to the content of a page or post to which only certain group of users can access.[ENTERPRISE]
*	Login Reports : OAuth Login creates user login and registration reports based on application used. [ENTERPRISE]


= No SSL restriction =
*	Login to WordPress using Google credentials (Google Apps Login) or any other app without having an SSL or HTTPS enabled site.

= List of popular OAuth Providers we support =
*	Eve Online
*	Slack
*	Discord
*	HR Answerlink / Support center
*	WSO2
*	Wechat
*	Weibo
*	AWS cognito
*   LinkedIn
*	Azure AD
*	Gitlab
*	Shibboleth
*	Blizzard (Formerly Battle.net)
*	servicem8
*	Meetup

= List of popular OpenID Connect (OIDC) Providers we support =
*	Amazon
*	Salesforce
*	PayPal
*	Google
*	AWS Cognito
*	Okta
*	OneLogin
*	Yahoo
*	ADFS
*	Gigya

= List of grant types we support =
*   Authorization code grant
*   Implicit grant
*   Resource owner credentials grant
*   Client credentials grant
*   Refresh token grant


= Other OAuth Providers we support =
*	Other OAuth Providers OAuth Login (OAuth client) plugin support includes Foursquare, Harvest, Mailchimp, Bitrix24, Spotify, Vkontakte, Huddle, Reddit, Strava, Ustream, Yammer, RunKeeper, Instagram, SoundCloud, Pocket, PayPal, Pinterest, Vimeo, Nest, Heroku, DropBox, Buffer, Box, Hubic, Deezer, DeviantArt, Delicious, Dailymotion, Bitly, Mondo, Netatmo, Amazon, WHMCS, FitBit, Clever, Sqaure Connect, Windows, Dash 10, Github, Invision Comminuty, Blizzar, authlete, Keycloak etc.


== Installation ==

= From your WordPress dashboard =
1. Visit `Plugins > Add New`
2. Search for `WordPress OAuth Login`. Find and Install `WordPress OAuth Login`
3. Activate the plugin from your Plugins page

= From WordPress.org =
1. Download WordPress OAuth Login.
2. Unzip and upload the `miniorange-oauth-login` directory to your `/wp-content/plugins/` directory.
3. Activate miniOrange OAuth from your Plugins page.

= Once Activated =
1. Go to `Settings-> miniOrange OAuth -> Configure OAuth`, and follow the instructions
2. Go to `Appearance->Widgets` ,in available widgets you will find `miniOrange OAuth` widget, drag it to chosen widget area where you want it to appear.
3. Now visit your site and you will see login with widget.


== Frequently Asked Questions ==
= I need to customize the plugin or I need support and help? =
Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.

= I don't see any applications to configure. I only see Register to miniOrange? =
Our very simple and easy registration lets you register to miniOrange. OAuth login works if you are connected to miniOrange. Once you have registered with a valid email-address and phone number, you will be able to configure applications for OAuth.

= How to configure the applications? =
When you want to configure a particular application, you will see a Save Settings button, and beside that a Help button. Click on the Help button to see configuration instructions.


<code>
add_action( 'show_user_profile', 'mo_oauth_my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'mo_oauth_my_show_extra_profile_fields' );
</code>


= I need integration of this plugin with my other installed plugins like BuddyPress, etc.? =
We will help you in integrating this plugin with your other installed plugins. Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.

= I verified the OTP received over my email and entering the same password that I registered with, but I am still getting the error message - "Invalid password." =
Please write to us at info@xecurify.com and we will get back to you very soon.

= For any other query/problem/request =
Please email us at info@xecurify.com or <a href="http://miniorange.com/contact" target="_blank">Contact us</a>. You can also submit your query from plugin's configuration page.

== Screenshots ==

1. Add OAuth Applications
2. List of Apps
2. Configure Custom OAuth Application

== Changelog ==

= 1.1.1 =
* First version with supported applications as slack, discord, aws, google, facebook

= 1.2.1 =
* Added Custom Display Button

= 1.2.2 =
* Timestamp issue fixed

= 1.3.3 =
* Added Eve Online Corporation and Alliance Restriction

= 1.3.4 =
* Updated OAuth Guide link

= 1.4.0 =
* Bug fixes for 'Vulnerable Link' issue

= 1.5.0 =
* Added Auto Create User feature

= 1.6.0 =
* Updated Licensing Plan

= 1.8.0 =
* Upadted Google APIs
* Fixed cURL issues 

= 1.8.1 =
* Added support for customized Eve APIs

= 1.9.0 =
* Upadetd contact-us api
* Added comptibility for WordPress v5.1 and above