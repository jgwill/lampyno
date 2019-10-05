<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<?php do_action( 'di_business_the_head' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
<?php
if( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'di-business' ); ?></a>

<!-- Loader icon -->
<?php
if( get_theme_mod( 'loading_icon', '0' ) == 1 ) {
?>
	<div class="load-icon"></div>
<?php
}
?>
<!-- Loader icon Ends -->


<div id="maincontainer" class="container-fluid clearfix maincontainer"> <!-- start header div 1, will end in footer -->
	<div id="content" class="container"> <!-- start header div 2, will end in footer -->
		<!-- row and col will added by page builder -->
	