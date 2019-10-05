<?php
/**
 * Compatability file for ThemeGrill themes.
 *
 * @package   olympus-google-fonts
 * @copyright Copyright (c) 2019, Fonts Plugin
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

/**
 * Modify the default element selectors to improve compatability with ThemeGrill themes.
 *
 * @param array $elements The default elements.
 */
function ogf_themegrill_elements( $elements ) {

	$elements['ogf_body']['selectors'] = 'body, p';
	return $elements;

}

add_filter( 'ogf_elements', 'ogf_themegrill_elements' );
