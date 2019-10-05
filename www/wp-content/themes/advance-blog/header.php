<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Advance_Blog
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
</head>
<?php if (advance_blog_get_option('select_global_sidebar_layout') == 'sidebar-left') {
    $min_custom_class = 'sidebar-left';
} elseif (advance_blog_get_option('select_global_sidebar_layout') == 'sidebar-right') {
    $min_custom_class = 'sidebar-right';
} else {
    $min_custom_class = 'no-sidebar';
} ?>
<body <?php body_class($min_custom_class); ?>>

<?php if (function_exists('wp_body_open')) {
    wp_body_open();
}
?>

<!--Loader-->
<div id="mini-loader">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
            <div class="object"></div>
        </div>
    </div>
</div>
<!-- Loader end -->

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'advance-blog'); ?></a>

    <header id="masthead" class="site-header" role="banner">
        <div class="wrapper">
            <?php get_template_part('components/header/site', 'branding'); ?>
        </div>
        <?php get_template_part('components/navigation/navigation', 'top'); ?>
    </header>
    <div id="content" class="site-content">
        <div class="wrapper">
            <?php if (! is_page_template( 'home-page-template.php' )) {
                if (is_front_page() && !is_home ()) {
                    get_template_part('components/banner/banner', 'slider');
                    get_template_part('components/banner/featured', 'category');
                }
            } ?>