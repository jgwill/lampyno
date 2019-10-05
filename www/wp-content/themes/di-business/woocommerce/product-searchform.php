<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form class="form-inline" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" >
	<div class="form-group">
		<input type="text" name="s" class="form-control mr5" id="terms" placeholder="<?php esc_attr_e( 'Search Products', 'di-business');  ?>" value="<?php echo get_search_query(); ?>" />
		<input type="hidden" name="post_type" value="product" />
		<button type="submit" class="masterbtn"><?php esc_attr_e( 'Search &raquo;', 'di-business');  ?></button>
	</div>
</form>
