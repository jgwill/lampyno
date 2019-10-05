<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
	return;
}

$Maximum_Score = get_option("EWD_URP_Maximum_Score");

$Post_Data = $product->get_post_data();

$rating_count = EWD_URP_Get_Review_Count($Post_Data->post_title);
$review_count = EWD_URP_Get_Review_Count($Post_Data->post_title);
$average      = $EWD_URP_Rating = EWD_URP_Get_Aggregate_Score($Post_Data->post_title);

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		<div class="star-rating" title="<?php printf( __( 'Rated %s out of %s', 'woocommerce' ), $average, $Maximum_Score ); ?>">
			<span style="width:<?php echo ( ( $average / $Maximum_Score ) * 100 ); ?>%">
				<strong class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s', 'woocommerce' ), $Maximum_Score); ?>
				<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), $rating_count ); ?>
			</span>
		</div>
		<?php if ( comments_open() ) : ?><a href="#tab-reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), $review_count ); ?>)</a><?php endif ?>
	</div>

<?php endif; ?>