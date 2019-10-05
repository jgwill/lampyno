<div class="mv-create-image-container">

	<?php
	/**
	 * mv_recipe_card_image_container hook.
	 *
	 * @hooked mv_recipe_image - 10
	 * @hooked mv_recipe_rating - 20
	 * @hooked mv_recipe_print_button - 30
	 */
	do_action( 'mv_create_card_image_container', $args );
	?>

</div>
