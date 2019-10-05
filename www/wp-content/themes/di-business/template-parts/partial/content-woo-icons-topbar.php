<?php
if( get_theme_mod( 'display_shop_link_top_bar', '1' ) == 1 ) {
?>
	<a title="<?php esc_attr_e( 'Shop', 'di-business' ); ?>" href="<?php echo esc_url( get_permalink( get_option('woocommerce_shop_page_id') ) ); ?>"><span class="fa fa-shopping-bag bgtoph-icon-clr"></span></a>
<?php
}
?>

<?php
if( get_theme_mod( 'display_cart_link_top_bar', '1' ) == 1 ) {
?>
<a title="<?php esc_attr_e( 'Cart', 'di-business' ); ?>" href="<?php echo esc_url( get_permalink( get_option('woocommerce_cart_page_id') ) ); ?>"><span class="fa fa-shopping-cart bgtoph-icon-clr"></span></a>
<?php
}
?>

<?php
if( get_theme_mod( 'display_myaccount_link_top_bar', '1' ) == 1 ) {
?>
<a title="<?php esc_attr_e( 'My Account ', 'di-business' ); ?>" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>"><span class="fa fa-user bgtoph-icon-clr"></span></a>
<?php
}
?>
