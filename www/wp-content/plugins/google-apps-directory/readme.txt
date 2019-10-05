=== Plugin Name ===
Contributors: levertechadmin, danlester
Tags: google apps login, g suite, employee directory, company, directory, employee, extranet, intranet, profile, staff, google, staff directory
Requires at least: 3.8
Tested up to: 5.2.2
Stable tag: 1.6.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Search your G Suite (Google Apps) domain for employee info from a widget

== Description ==

Enable logged-in users to search your G Suite (Google Apps) employee directory from a widget on your intranet or client site.

Enter search text to see matching names and email addresses, along with profile photos!

**This plugin requires that you also install the free (or paid) version of the popular [Google Apps Login](http://wp-glogin.com/dirgoogleappslogin) plugin**

Setup should take fifteen minutes following our widely-praised instructions.

= Enterprise Version =

There is now also a paid Enterprise version of this plugin available - embed an interactive table format showing all your staff
(or selected OrgUnits). Users can sort by clicking on a column heading, or search to filter the table for matching text.
It is fully configurable so you can choose the columns to show, and you can style the table as desired.

See [our website for more information](https://wp-glogin.com/directory/?utm_source=Dir%20Readme%20Top&utm_medium=freemium&utm_campaign=Freemium) including pricing.

= Requirements =

Google Apps Directory should work for the following domains:

*  G Suite Basic (Google Apps for Work)
*  G Suite Business (Google Apps Unlimited for Work)
*  G Suite for Education (Google Apps for Education)
*  G Suite for Non-profits (Google Apps for Non-profits)
*  G Suite for Government (Google Apps for Government)

Google Apps Login plugin setup requires you to have admin access to any G Suite (Google Apps) domain, or a regular Gmail account, to register and
obtain two simple codes from Google.

To use Google Apps Directory, you will also need to register a Service Account with Google and upload details to the Google Apps Login 
plugin's settings page. This is an extra step that you don't need if you set up Google Apps Login alone, or if you use our 
[Google Drive Embedder](http://wp-glogin.com/dirgoogledriveembed) extension plugin.

= Google Apps Login =

The [Google Apps Login](http://wp-glogin.com/dirgoogleappslogin) plugin (which you must also install) 
allows existing Wordpress user accounts to login to the website 
using Google to securely authenticate their account. This means that if they are already logged into Gmail for example,
they can simply click their way through the Wordpress login screen - no username or password is explicitly required!

Full support and premium features are also available for purchase:

Eliminate the need for G Suite (Google Apps) domain admins to separately manage WordPress user accounts, and get peace
of mind that only authorized employees have access to the organizations's websites and intranet.

**See [http://wp-glogin.com/](http://wp-glogin.com/?utm_source=Dir%20Readme&utm_medium=freemium&utm_campaign=Freemium)**

= Website =

Please see our website [http://wp-glogin.com/](http://wp-glogin.com/?utm_source=Dir%20Readme%20Website&utm_medium=freemium&utm_campaign=Dir) 
for more information about all our products, and to join our mailing list. 

== Screenshots ==

1. Add the widget to any widget area, then logged in users can search your Google Apps domain for employee details.
2. Configuration is through Google Apps Login plugin, including set up of a Service Account.

== Frequently Asked Questions ==

= How can I obtain support for this product? =

Please feel free to email [contact@wp-glogin.com](mailto:contact@wp-glogin.com) with any questions.

We may occasionally be able to respond to support queries posted on the 'Support' forum here on the wordpress.org
plugin page, but we recommend sending us an email instead if possible.

= What are the system requirements? =

*  PHP 5.3.x or higher
*  Wordpress 3.8 or above

= Can I add custom fields? =

There are hooks (from version 1.2) to add your own fields. For example, you could add the following code to your functions.php file of your Theme:

    add_filter('gad_extract_user_data', 'my_gad_extract_user_data', 10,2);

    function my_gad_extract_user_data($user_outdata, $u) {
       // $u contains data returned from Google
       $phones = $u->getPhones();
       if (is_array($phones) && count($phones) > 0) {
           $phone = $phones[0]['value'];
           // Add extra custom data for this user
           $user_outdata['phone'] = 'Phone: '.$phone;
       }
       return $user_outdata;
    }

    add_filter('gad_extra_output_fields', 'my_gad_extra_output_fields', 10,1);

    // Tell javascript widget extra fields to pull from the array extracted above
    function my_gad_extra_output_fields($infields) {
       return 'phone,'.$infields;
    }
 

== Installation ==

For Google Apps Directory to work, you will need also need to install and configure the Google Apps Login plugin 
(either before or after).

Google Apps Directory plugin:

1. Go to your WordPress admin control panel's plugin page
1. Search for 'Google Apps Directory'
1. Click Install
1. Click Activate on the plugin
1. If you do not have the correct version of Google Apps Login installed, you will see a warning notice to that effect, in
which case you should follow the instructions below

Google Apps Login plugin:

1. Go to your WordPress admin control panel's plugin page
1. Search for 'Google Apps Login'
1. Click Install
1. Click Activate on the plugin
1. Go to 'Google Apps Login' under Settings in your Wordpress admin area
1. Follow the instructions on that page to obtain two codes from Google, and also submit two URLs back to Google
1. In the Google Cloud Console, you must also enable the switch for Admin SDK access
1. You must also follow the instructions for setting up a Service Account in Settings -> Google Apps Login.

Finally, go to Appearance -> Widgets to add the Google Apps Directory to any widget area.

If you cannot install from the WordPress plugins directory for any reason, and need to install from ZIP file:

1. For Google Apps Directory plugin: Upload `googleappsdirectory` folder and contents to the `/wp-content/plugins/` directory, 
or upload the ZIP file directly in the Plugins section of your Wordpress admin
1. For Google Apps Login plugin: Upload `googleappslogin` folder and contents to the `/wp-content/plugins/` directory, 
or upload the ZIP file directly in the Plugins section of your Wordpress admin
1. Follow the instructions to configure the Google Apps Login plugin post-installation


== Changelog ==

= 1.6.1 =

Widget search is more flexible and can accept e.g. "fred smith" to locate Frederick Smith.
Before, no match would be found - only searches for "fred", or searches for "smith" would find that user.

Now translation-ready for major public-facing strings.

= 1.5.5 =

Reorganised internally to match Enterprise version code.
Updated for WordPress 4.8.

= 1.5 =

References to G Suite in place of just Google Apps, following Google's rebranding.
Versioning of JS/CSS assets to ensure smoother upgrades (in case older files were cached in user's browser).
Version number to match upcoming Enterprise release.

= 1.3.4 =

New security option to prevent logged-out users from being allowed to use the search widget.

Internal changes to match new Enterprise version.

= 1.2.2 =

Allow html markup in extra fields.

= 1.2.1 =

Ability for extensions to remove people from the results - by returning null from the filter gad_extract_user_data.

= 1.2 =

Hooks provided so you can add extra fields. See FAQ.

= 1.1 =

Email addresses now display as 'mailto' hyperlinks.

= 1.0 =

Ready for public release
