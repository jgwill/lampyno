<?php
/**
 * Handle the recipe nutrition fields.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.3.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe nutrition fields.
 *
 * @since      5.3.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Nutrition {
	/**
	 * Get nutrition fields.
	 *
	 * @since    5.3.0
	 */
	public static function get_fields( $include_inactive = false ) {
		$nutrition_fields = array(
			'calories' => array(
				'label' => __( 'Calories', 'wp-recipe-maker' ),
				'unit' => 'kcal',
				'api' => 'Calories',
				'active' => true,
			),
		);

		$nutrition_fields = apply_filters( 'wprm_nutrition_fields', $nutrition_fields, $include_inactive );

		// Optionally remove inactive nutrients.
		if ( ! $include_inactive ) {
			$nutrition_fields = array_filter( $nutrition_fields, function( $nutrient ) { return true === $nutrient['active']; } );
		}

		return $nutrition_fields;
	}
}
