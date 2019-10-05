<?php if ( ! $args['print'] && $args['allow_reviews'] ) { ?>
	<div id="mv-create-<?php echo esc_attr( $args['creation']['id'] ); ?>"
		class="mv-create-reviews"
		data-mv-create-id="<?php echo esc_attr( $args['creation']['id'] ); ?>"
		data-mv-create-rating="<?php echo esc_attr( $args['creation']['rating'] ); ?>"
		data-mv-create-total-ratings="<?php echo esc_attr( $args['creation']['rating_count'] ); ?>"
		data-mv-rest-url="<?php echo esc_url_raw( rest_url() ); ?>"></div>
	<!-- This is a button so it inherits theme styles -->
<?php
}
