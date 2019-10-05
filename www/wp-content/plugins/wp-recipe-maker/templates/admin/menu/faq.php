<?php
/**
 * Template for the WP Recipe Maker FAQ.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.1.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin/menu
 */

// Active version.
$name = 'WP Recipe Maker';
$version = WPRM_VERSION;
$full_name = $name . ' ' . $version;

// Image directory.
$img_dir = WPRM_URL . 'assets/images/faq';
?>

<div class="wrap about-wrap wprm-faq">
	<h1><?php echo esc_html( $name ); ?></h1>
	<div class="about-text">Welcome to version <?php echo esc_html( $version ) ?>! Check out the <a href="https://help.bootstrapped.ventures/article/124-wp-recipe-maker-changelog" target="_blank">changelog</a> now.</div>
	<div class="wprm-badge">Version <?php echo esc_html( $version ); ?></div>

	<?php
	// Show message about translations if WordPress language not set to English.
	$locale = strtolower( get_locale() );
	if ( 'en' !== substr( $locale, 0, 2 ) ) :
	?>
	<h3>Using WPRM in a different language? No problem!</h3>
	<p>
		Looks like your website is not using English as the default language? Not a problem at all! All text in WP Recipe Maker can be translated to fit your needs. Learn more here:
	</p>
	<ul>
		<li><a href="https://help.bootstrapped.ventures/article/128-translating-text-in-the-plugin" target="_blank">Translating any text in WP Recipe Maker</a></li>
		<li><a href="https://help.bootstrapped.ventures/article/132-how-to-use-this-for-a-multilingual-blog" target="_blank">Using WPRM on a multilingual website</a></li>
	</ul>
	<?php endif; ?>

	<h3>Getting Started with WPRM</h3>
	<p>
		To create a recipe, add a <em>WPRM Recipe</em> block in the <strong>Gutenberg Block Editor</strong>:
	</p>
	<img src="<?php echo WPRM_URL; ?>assets/images/faq/gutenberg.png" alt="Adding a recipe in the Gutenberg Block Editor" />
	<p>
		Or use the <em>WP Recipe Maker</em> button or icon in the <strong>Classic Editor</strong>:
	</p>
	<img src="<?php echo WPRM_URL; ?>assets/images/faq/classic-editor.png" alt="Adding a recipe in the Classic Editor" />
	<p>
		Want to learn more? Check out our <a href="https://help.bootstrapped.ventures/article/188-wp-recipe-maker-101" target="_blank">WP Recipe Maker 101 documentation</a>!
	</p>

	<h3>I need more help</h3>
	<p>
		Check out <a href="https://help.bootstrapped.ventures/collection/1-wp-recipe-maker" target="_blank">all documentation for WP Recipe Maker</a> or contact us using the blue question mark in the bottom right of this page or by emailing <a href="mailto:support@bootstrapped.ventures">support@bootstrapped.ventures</a> directly.
	</p>

	<h3>Get the most out of WP Recipe Maker!</h3>
	<p>
		Join our self-paced email course to <strong>help you get started</strong> and learn about all the <strong>tips and tricks</strong> to get the most out of WP Recipe Maker.
	</p>
	<p>
		Go through the entire course and we'll even <strong>promote your recipes for free</strong>!
	</p>
	<?php
	$current_user = wp_get_current_user();
	$email = $current_user->user_email;
	$website = get_site_url();
	?>
	<form action="https://www.getdrip.com/forms/86388969/submissions" method="post" class="wprm-drip-form" data-drip-embedded-form="86388969" target="_blank">
		<div>
				<label for="fields[email]">Email Address</label><br />
				<input type="email" id="fields[email]" name="fields[email]" value="<?php echo esc_attr( $email ); ?>" />
				<input type="hidden" name="tags[]" value="wprm-getting-started-welcome" />
		</div>
		<div>
			<input type="checkbox" name="fields[eu_consent]" id="drip-eu-consent" value="granted">
			<label for="drip-eu-consent">I understand and agree to the <a href="https://www.iubenda.com/privacy-policy/82708778" target="_blank">privacy policy</a></label>
		</div>
		<div>
			<input type="hidden" name="fields[eu_consent_message]" value="I understand and agree to the privacy policy (https://www.iubenda.com/privacy-policy/82708778)">
		</div>
		<div>
			<input type="submit" name="submit" value="Help me get the most out of WP Recipe Maker!" class="button button-primary" data-drip-attribute="sign-up-button" />
		</div>
	</form>

</div>
