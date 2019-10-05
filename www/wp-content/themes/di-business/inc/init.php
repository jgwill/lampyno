<?php
/**
 * Bootstrap the theme.
 *
 * @package Di Business
 */

// Add class Di_Business_Engine, responsible for setup, styles, scripts, sidebar registration.
require_once get_template_directory() . '/inc/core/class-di-business-engine.php';

// Add inline css in front head.
require_once get_template_directory() . '/inc/core/inline-css.php';

// Social custom widget addition.
require_once get_template_directory() . '/inc/core/custom-widget-social.php';

// Custom widget recent posts with thumb addition.
require_once get_template_directory() . '/inc/core/custom-widget-recent-posts-thumb.php';

// Action and filter addition.
require_once get_template_directory() . '/inc/core/action-filters.php';

// Individual functions addition.
require_once get_template_directory() . '/inc/core/individual-functions.php';

// Navwalker.
require_once get_template_directory() . '/inc/core/navwalker.php';

// Customize / partial refresh handle.
require_once get_template_directory() . '/inc/core/customize.php';

// Tgm class.
require_once get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

// Tgm options.
require get_template_directory() . '/inc/tgm/tgm-options.php';

// Include kirki plugin files if it is not activated.
if ( ! class_exists( 'Kirki' ) ) {
	require get_template_directory() . '/inc/kirki/kirki/kirki.php';
}

// Include the kirki options file.
require get_template_directory() . '/inc/kirki/kirki-options.php';

// Include page metabox options file.
require get_template_directory() . '/inc/core/page-metabox.php';

// Include post metabox file.
require get_template_directory() . '/inc/core/post-metabox.php';

// Include custom woocommerce file.
require get_template_directory() . '/inc/core/custom-woocommerce.php';

// Theme page.
require get_template_directory() . '/inc/core/theme-page.php';

/*
* DO NOT edit any code of theme, use child theme instead
*/
