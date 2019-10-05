<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

/**
 * MVSecurity Template
 *
 * @category Template
 * @package  Mediavine Control Panel
 * @author   Mediavine
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://www.mediavine.com
 */

if ( $security->option( 'block_mixed_content' ) ) {
	$security->option( 'enable_forced_ssl', false );
}

if ( $security->option( 'enable_forced_ssl' ) ) {
?>
<div class="notice dismissable notice-info">
	<p>We've removed the <strong>upgrade-insecure-assets</strong> content security option as it was unreliable across different browsers. We now recommend using the option below.</p>
</div>
<?php } ?>

<div class="option">
	<input id="<?php echo esc_attr( $security->get_key( 'block_mixed_content' ) ); ?>"
			name="<?php echo esc_attr( $security->get_key( 'block_mixed_content' ) ); ?>"
		<?php checked( true === $security->option( 'block_mixed_content' ) ); ?> value="true" type="checkbox"/>
	&nbsp;<label for="<?php echo esc_attr( $security->get_key( 'block_mixed_content' ) ); ?>">Block Insecure Assets</label>
</div>
<div class="description">
	<p>Setting the <a href="https://help.mediavine.com/mediavine-learning-resources/force-all-ads-secure-with-a-content-security-policy" target="_blank">Content Security Policy</a> will tell modern web browsers what to do if they encounter a non-secure image, script or advertisement. Enable this feature if you want to block all insecure assets.</p>
</div>
