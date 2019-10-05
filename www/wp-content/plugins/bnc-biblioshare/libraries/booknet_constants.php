<?php

//constants used in the constants file
//note: include language file before this one - language constants used as defaults

define('BN_HTML_CHECKED_TRUE', 'checked');
define('BN_HTML_CHECKED_FALSE', '');

//options

define('BN_OPTION_TEMPLATENUMBER_1', '1');
define('BN_OPTION_TEMPLATENUMBER_2', '2');
define('BN_OPTION_TEMPLATENUMBER_3', '3');
define('BN_OPTION_TEMPLATENUMBER_4', '4');
define('BN_OPTION_TEMPLATENUMBER_5', '5');

define('BN_OPTION_TEMPLATE1_NAME', 'booknet_template1');
define('BN_OPTION_TEMPLATE1_VAL', '<div style="clear:both"><div style="float:left;width:160px;padding-right:10px;padding-bottom:10px;"><img src="[BS_COVERURL_THUMBNAIL]" width=140px></div><div><h4>[BS_SERIES]</h4><h3><i>[BN_TITLE] </i>by [BN_CONTRIBUTOR]</h3><p>Published: [BN_PUBLICATIONDATE] by [BN_PUBLISHER]<br />ISBN: [BS_ISBN13]<br />Price: $[BN_PRICE]<br />[BN_LINK_CHAPTERSINDIGO]<br />[BN_LINK_AMAZON]<br />[BN_LINK_FINDINLIBRARY]</p></div>[BN_COINS]</div>');

define('BN_OPTION_TEMPLATE2_NAME', 'booknet_template2');
define('BN_OPTION_TEMPLATE2_VAL', '<div style="clear:both"><div style="float:left;width:230px;padding-right:10px;padding-bottom:10px;"><img src="[BS_COVERURL_FULL]" width=210px></div><div><h4>[BS_SERIES]</h4><h3><i>[BN_TITLE] </i>by [BN_CONTRIBUTOR]</h3><p>Published: [BN_PUBLICATIONDATE] by [BN_PUBLISHER]<br />ISBN: [BS_ISBN13]<br />Price: $[BN_PRICE]<br />Format: [BS_FORMAT]</p><p>Find <i>[BS_TITLE] </i>at: <br />[BN_LINK_AMAZON] <br />[BN_LINK_CHAPTERSINDIGO] <br />[BN_LINK_GOOGLEBOOKS] <br />[BN_LINK_LIBRARYTHING] <br />[BN_LINK_WORLDCAT] <br />[BN_LINK_BOOKFINDER] <p></div>[BN_COINS]</div>');

define('BN_OPTION_TEMPLATE3_NAME', 'booknet_template3');
define('BN_OPTION_TEMPLATE3_VAL', '<div style="clear:both"><div align="center"><img src="[BS_COVERURL_FULL]" width=300px><p><i>[BN_TITLE]</i>, [BN_CONTRIBUTOR]</p>[BN_COINS]</div></div>');

define('BN_OPTION_TEMPLATE4_NAME', 'booknet_template4');
define('BN_OPTION_TEMPLATE4_VAL', '<div style="clear:both"><div align="center">[BN_COVER_THUMBNAIL]<p><i>[BS_TITLE]</i>, [BN_CONTRIBUTOR]</p>[BN_COINS]</div></div>');

define('BN_OPTION_TEMPLATE5_NAME', 'booknet_template5');
define('BN_OPTION_TEMPLATE5_VAL', '<p>[BN_CONTRIBUTOR], <i>[BN_TITLE]</i> ([BN_PUBLISHER], [BN_PUBLICATIONDATE])</p>');

define('BN_OPTION_TOKEN_NAME', 'booknet_token');
define('BN_OPTION_TOKEN_VAL', '');

define('BN_OPTION_COUNTRY_NAME', 'booknet_country');
define('BN_OPTION_COUNTRY_CA', 'CA');
define('BN_OPTION_COUNTRY_US', 'US');
define('BN_OPTION_COUNTRY_VAL', BN_OPTION_COUNTRY_CA);

define('BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_NAME', 'booknet_findinlibrary_openurlresolver');
define('BN_OPTION_FINDINLIBRARY_OPENURLRESOLVER_VAL', '');

define('BN_OPTION_FINDINLIBRARY_PHRASE_NAME', 'booknet_findinlibrary_phrase');
define('BN_OPTION_FINDINLIBRARY_PHRASE_VAL', BN_OPTIONS_FINDINLIBRARY_LANG);

define('BN_OPTION_FINDINLIBRARY_IMAGESRC_NAME', 'booknet_imagesrc_phrase');
define('BN_OPTION_FINDINLIBRARY_IMAGESRC_VAL', '');

define('BN_OPTION_LIBRARY_DOMAIN_NAME', 'booknet_biblioshare_domain');
define('BN_OPTION_LIBRARY_DOMAIN_VAL', 'http://biblioshare.org');

define('BN_OPTION_PROXY_NAME', 'booknet_proxy');
define('BN_OPTION_PROXY_VAL', '');

define('BN_OPTION_PROXYPORT_NAME', 'booknet_proxyport');
define('BN_OPTION_PROXYPORT_VAL', '');

define('BN_OPTION_TIMEOUT_NAME', 'booknet_timeout');
define('BN_OPTION_TIMEOUT_VAL', '10');

define('BN_OPTION_SHOWERRORS_NAME', 'booknet_showerrors');
define('BN_OPTION_SHOWERRORS_VALUE', BN_HTML_CHECKED_FALSE);
define('BN_OPTION_SAVETEMPLATES_NAME', true);

define('BN_OPTION_SAVESETTINGS_NAME', 'booknet_savesettings');
define('BN_OPTION_SAVESETTINGS_VALUE', BN_HTML_CHECKED_TRUE);

?>
