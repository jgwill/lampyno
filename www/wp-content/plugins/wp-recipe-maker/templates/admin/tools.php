<?php
/**
 * Template for tools page.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/admin
 */

?>

<div class="wrap wprm-tools">
	<h1><?php esc_html_e( 'WP Recipe Maker Tools', 'wp-recipe-maker' ); ?></h1>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Find Parent Posts', 'wp-recipe-maker' ); ?>
				</th>
				<td>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=wprm_finding_parents' ) ); ?>" class="button" id="tools_finding_parents"><?php esc_html_e( 'Find Parent Posts', 'wp-recipe-maker' ); ?></a>
					<p class="description" id="tagline-tools_finding_parents">
						<?php esc_html_e( 'Go through all posts and pages on your website to find and link recipes to their parent.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Find Recipe Ratings', 'wp-recipe-maker' ); ?>
				</th>
				<td>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=wprm_finding_ratings' ) ); ?>" class="button" id="tools_finding_ratings"><?php esc_html_e( 'Find Recipe Ratings', 'wp-recipe-maker' ); ?></a>
					<p class="description" id="tagline-tools_finding_ratings">
						<?php esc_html_e( 'Go through all recipes on your website to find any missing ratings.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Reset Settings', 'wp-recipe-maker' ); ?>
				</th>
				<td>
				<a href="#" class="button" id="tools_reset_settings"><?php esc_html_e( 'Reset Settings to Default', 'wp-recipe-maker' ); ?></a>
					<p class="description" id="tagline-tools_reset_settings">
						<?php esc_html_e( 'Try using this if the settings page is not working at all.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
<?php if ( class_exists( 'WPUltimateRecipe' ) ) : ?>
	<h2><?php esc_html_e( 'WP Ultimate Recipe Migration', 'wp-recipe-maker' ); ?></h2>
	<p><?php esc_html_e( 'Use these buttons to migrate from our old WP Ultimate Recipe plugin.', 'wp-recipe-maker' ); ?></p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Import Ingredient Links', 'wp-recipe-maker' ); ?>
				</th>
				<td>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=wprm_wpurp_ingredients&field=link' ) ); ?>" class="button"><?php esc_html_e( 'Import Ingredient Links', 'wp-recipe-maker' ); ?></a>
					<p class="description">
						<?php esc_html_e( 'Import all ingredients that have ingredient links set.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Import Shopping List Groups', 'wp-recipe-maker' ); ?>
				</th>
				<td>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=wprm_wpurp_ingredients&field=group' ) ); ?>" class="button"><?php esc_html_e( 'Import Shopping List Groups', 'wp-recipe-maker' ); ?></a>
					<p class="description">
						<?php esc_html_e( 'Import all ingredients that have a shopping list group set for use in the Recipe Collections feature.', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<?php if ( taxonomy_exists( 'wprm_nutrition_ingredient' ) ) : ?>
			<tr>
				<th scope="row">
					<?php esc_html_e( 'Import Nutrition Facts', 'wp-recipe-maker' ); ?>
				</th>
				<td>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=wprm_wpurp_nutrition' ) ); ?>" class="button"><?php esc_html_e( 'Import Nutrition Facts', 'wp-recipe-maker' ); ?></a>
					<p class="description">
						<?php esc_html_e( 'Import all ingredients that have nutrition facts set. These will become Custom Nutrition Ingredients', 'wp-recipe-maker' ); ?>
					</p>
				</td>
			</tr>
			<?php endif; // Taxonomy exists. ?>
		</tbody>
	</table>
<?php endif; // WP Ultimate Recipe is active. ?>
</div>
