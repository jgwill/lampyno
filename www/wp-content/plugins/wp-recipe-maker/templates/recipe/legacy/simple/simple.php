<?php
/**
 * Simple recipe template.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/recipe/legacy/simple
 */

// @codingStandardsIgnoreStart
?>
<div class="wprm-recipe wprm-recipe-simple">
	<div class="wprm-recipe-image-container">
		<div class="wprm-recipe-image"><?php echo WPRM_Template_Helper::recipe_image( $recipe, 'thumbnail' ); ?></div>
		<div class="wprm-recipe-buttons">
			<?php echo $recipe->rating_stars( true ); ?>
			<a href="<?php echo $recipe->print_url(); ?>" class="wprm-recipe-print" target="_blank" rel="nofollow"><span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/printer.svg' ); ?></span> <?php echo WPRM_Template_Helper::label( 'print_button' ); ?></a>
		</div>
	</div>
	<h2 class="wprm-recipe-name"><?php echo $recipe->name(); ?></h2>
	<div class="wprm-recipe-summary">
		<?php echo $recipe->summary(); ?>
	</div>
	<div class="wprm-recipe-details-container wprm-recipe-tags-container">
		<?php
		$taxonomies = WPRM_Taxonomies::get_taxonomies();

		foreach ( $taxonomies as $taxonomy => $options ) :
			$key = substr( $taxonomy, 5 );
			$terms = $recipe->tags( $key );

			// Hide keywords from template.
			if ( 'keyword' === $key && ! WPRM_Settings::get( 'metadata_keywords_in_template' ) ) {
				$terms = array();
			}

			if ( count( $terms ) > 0 ) : ?>
			<div class="wprm-recipe-<?php echo $key; ?>-container">
				<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/tag.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-<?php echo $key; ?>-name"><?php echo WPRM_Template_Helper::label( $key . '_tags', $options['singular_name'] ); ?></span>
				<span class="wprm-recipe-<?php echo $key; ?>">
					<?php foreach ( $terms as $index => $term ) {
						if ( 0 !== $index ) {
							echo ', ';
						}
						echo $term->name;
					} ?>
				</span>
			</div>
		<?php endif; // Count.
		endforeach; // Taxonomies. ?>
	</div>
	<div class="wprm-recipe-details-container wprm-recipe-times-container">
		<?php if ( $recipe->prep_time() || $recipe->prep_time_zero() ) : ?>
		<div class="wprm-recipe-prep-time-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/knife.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-prep-time-name"><?php echo WPRM_Template_Helper::label( 'prep_time' ); ?></span> <?php echo $recipe->prep_time_formatted(); ?>
		</div>
		<?php endif; // Prep time. ?>
		<?php if ( $recipe->cook_time() || $recipe->cook_time_zero() ) : ?>
		<div class="wprm-recipe-cook-time-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/pan.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-cook-time-name"><?php echo WPRM_Template_Helper::label( 'cook_time' ); ?></span> <?php echo $recipe->cook_time_formatted(); ?>
		</div>
		<?php endif; // Cook time. ?>
		<?php if ( ( $recipe->custom_time() || $recipe->custom_time_zero() ) && $recipe->custom_time_label() ) : ?>
		<div class="wprm-recipe-custom-time-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/hourglass.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-custom-time-name"><?php echo $recipe->custom_time_label(); ?></span> <?php echo $recipe->custom_time_formatted(); ?>
		</div>
		<?php endif; // Custom time. ?>
		<?php if ( $recipe->total_time() ) : ?>
		<div class="wprm-recipe-total-time-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/clock.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-total-time-name"><?php echo WPRM_Template_Helper::label( 'total_time' ); ?></span> <?php echo $recipe->total_time_formatted(); ?>
		</div>
		<?php endif; // Total time. ?>
	</div>
	<div class="wprm-recipe-details-container">
		<?php if ( $recipe->servings() ) : ?>
		<div class="wprm-recipe-servings-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/cutlery.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-servings-name"><?php echo WPRM_Template_Helper::label( 'servings' ); ?></span> <span class="wprm-recipe-details wprm-recipe-servings wprm-recipe-servings-<?php echo $recipe->id(); ?>"><?php echo $recipe->servings(); ?></span> <span class="wprm-recipe-details-unit wprm-recipe-servings-unit"><?php echo $recipe->servings_unit(); ?></span>
		</div>
		<?php endif; // Servings. ?>
		<?php if ( $recipe->calories() ) : ?>
		<div class="wprm-recipe-calories-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/battery.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-calories-name"><?php echo WPRM_Template_Helper::label( 'calories' ); ?></span> <span class="wprm-recipe-details wprm-recipe-calories"><?php echo $recipe->calories(); ?></span> <span class="wprm-recipe-details-unit wprm-recipe-calories-unit"><?php _e( 'kcal', 'wp-recipe-maker' ); ?></span>
		</div>
		<?php endif; // Calories. ?>
		<?php if ( $recipe->author() ) : ?>
		<div class="wprm-recipe-author-container">
			<span class="wprm-recipe-details-icon"><?php include( WPRM_DIR . 'assets/icons/chef-hat.svg' ); ?></span> <span class="wprm-recipe-details-name wprm-recipe-author-name"><?php echo WPRM_Template_Helper::label( 'author' ); ?></span> <span class="wprm-recipe-details wprm-recipe-author"><?php echo $recipe->author(); ?></span>
		</div>
		<?php endif; // Author. ?>
	</div>

	<?php
	$ingredients = $recipe->ingredients();
	if ( count( $ingredients ) > 0 ) : ?>
	<div class="wprm-recipe-ingredients-container">
		<h3 class="wprm-recipe-header"><?php echo WPRM_Template_Helper::label( 'ingredients' ); ?></h3>
		<?php foreach ( $ingredients as $ingredient_group ) : ?>
		<div class="wprm-recipe-ingredient-group">
			<?php if ( $ingredient_group['name'] ) : ?>
			<h4 class="wprm-recipe-group-name wprm-recipe-ingredient-group-name"><?php echo $ingredient_group['name']; ?></h4>
			<?php endif; // Ingredient group name. ?>
			<ul class="wprm-recipe-ingredients">
				<?php foreach ( $ingredient_group['ingredients'] as $ingredient ) : ?>
				<li class="wprm-recipe-ingredient">
					<?php if ( $ingredient['amount'] ) : ?>
					<span class="wprm-recipe-ingredient-amount"><?php echo $ingredient['amount']; ?></span>
					<?php endif; // Ingredient amount. ?>
					<?php if ( $ingredient['unit'] ) : ?>
					<span class="wprm-recipe-ingredient-unit"><?php echo $ingredient['unit']; ?></span>
					<?php endif; // Ingredient unit. ?>
					<span class="wprm-recipe-ingredient-name"><?php echo WPRM_Template_Helper::ingredient_name( $ingredient, true ); ?></span>
					<?php if ( $ingredient['notes'] ) : ?>
					<span class="wprm-recipe-ingredient-notes"><?php echo $ingredient['notes']; ?></span>
					<?php endif; // Ingredient notes. ?>
				</li>
				<?php endforeach; // Ingredients. ?>
			</ul>
		</div>
	 <?php endforeach; // Ingredient groups. ?>
	 <?php echo WPRM_Template_Helper::unit_conversion( $recipe ); ?>
	</div>
	<?php endif; // Ingredients. ?>
	<?php
	$instructions = $recipe->instructions();
	if ( count( $instructions ) > 0 ) : ?>
	<div class="wprm-recipe-instructions-container">
		<h3 class="wprm-recipe-header"><?php echo WPRM_Template_Helper::label( 'instructions' ); ?></h3>
		<?php foreach ( $instructions as $instruction_group ) : ?>
		<div class="wprm-recipe-instruction-group">
			<?php if ( $instruction_group['name'] ) : ?>
			<h4 class="wprm-recipe-group-name wprm-recipe-instruction-group-name"><?php echo $instruction_group['name']; ?></h4>
			<?php endif; // Instruction group name. ?>
			<ol class="wprm-recipe-instructions">
				<?php foreach ( $instruction_group['instructions'] as $instruction ) : ?>
				<li class="wprm-recipe-instruction">
					<?php if ( $instruction['text'] ) : ?>
					<div class="wprm-recipe-instruction-text"><?php echo $instruction['text']; ?></div>
					<?php endif; // Instruction text. ?>
					<?php if ( $instruction['image'] ) : ?>
					<div class="wprm-recipe-instruction-image"><?php echo WPRM_Template_Helper::instruction_image( $instruction, 'thumbnail' ); ?></div>
					<?php endif; // Instruction image. ?>
				</li>
				<?php endforeach; // Instructions. ?>
			</ol>
		</div>
		<?php endforeach; // Instruction groups. ?>
	</div>
	<?php endif; // Instructions. ?>
	<?php if ( $recipe->video() ) : ?>
	<div id="wprm-recipe-video-container-<?php echo $recipe->id(); ?>" class="wprm-recipe-video-container">
		<h3 class="wprm-recipe-header"><?php echo WPRM_Template_Helper::label( 'video' ); ?></h3>
		<?php echo $recipe->video(); ?>
	</div>
	<?php endif; // Video. ?>
	<?php if ( $recipe->notes() ) : ?>
	<div class="wprm-recipe-notes-container">
		<h3 class="wprm-recipe-header"><?php echo WPRM_Template_Helper::label( 'notes' ); ?></h3>
		<?php echo $recipe->notes(); ?>
	</div>
	<?php endif; // Notes ?>
	<?php echo WPRM_Template_Helper::nutrition_label( $recipe->id() ); ?>
</div>
