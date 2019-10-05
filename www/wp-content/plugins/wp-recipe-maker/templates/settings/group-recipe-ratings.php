<?php
/**
 * Template for the plugin settings structure.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/settings
 */

$jetpack_warning = '';
if ( class_exists( 'Jetpack' ) && in_array( 'comments', Jetpack::get_active_modules(), true ) ) {
	$jetpack_warning = ' ' . __( 'Warning: comment ratings cannot work with the Jetpack Comments feature you have activated.', 'wp-recipe-maker' );
}

$recipe_ratings = array(
	'id' => 'recipeRatings',
	'name' => __( 'Star Ratings', 'wp-recipe-maker' ),
	'subGroups' => array(
		array(
			'name' => __( 'Rating Feature', 'wp-recipe-maker' ),
			'description' => __( 'Choose what rating features to enable. The average recipe rating will combine the different methods of rating.', 'wp-recipe-maker' ),
			'settings' => array(
				array(
					'id' => 'features_comment_ratings',
					'name' => __( 'Comment Ratings', 'wp-recipe-maker' ),
					'description' => __( 'Allow visitors to vote on your recipes when commenting.', 'wp-recipe-maker' ) . $jetpack_warning,
					'documentation' => 'https://help.bootstrapped.ventures/article/26-comment-ratings',
					'type' => 'toggle',
					'default' => true,
				),
				array(
					'id' => 'features_user_ratings',
					'name' => __( 'User Ratings', 'wp-recipe-maker' ),
					'required' => 'premium',
					'description' => __( 'Allow visitors to vote on your recipes by simply clicking on the stars.', 'wp-recipe-maker' ),
					'documentation' => 'https://help.bootstrapped.ventures/article/27-user-ratings',
					'type' => 'toggle',
					'default' => false,
				),
			),
		),
		array(
			'name' => __( 'Comment Ratings', 'wp-recipe-maker' ),
			'settings' => array(
				array(
					'id' => 'template_color_comment_rating',
					'name' => __( 'Stars Color', 'wp-recipe-maker' ),
					'description' => __( 'Color of the stars in the comment section, not in the recipe itself.', 'wp-recipe-maker' ),
					'type' => 'color',
					'default' => '#343434',
					'dependency' => array(
						'id' => 'features_custom_style',
						'value' => true,
					),
				),
				array(
					'id' => 'comment_rating_position',
					'name' => __( 'Stars Position in Comments', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'above' => __( 'Above the comment', 'wp-recipe-maker' ),
						'below' => __( 'Below the comment', 'wp-recipe-maker' ),
					),
					'default' => 'above',
				),
				array(
					'id' => 'comment_rating_form_position',
					'name' => __( 'Stars Position in Comment Form', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'above' => __( 'Above the comment field', 'wp-recipe-maker' ),
						'below' => __( 'Below the comment field', 'wp-recipe-maker' ),
						'legacy' => __( 'Legacy mode', 'wp-recipe-maker' ),
					),
					'default' => 'above',
				),
				array(
					'id' => 'label_comment_rating',
					'name' => __( 'Comment Rating', 'wp-recipe-maker' ),
					'type' => 'text',
					'description' => __( 'Label used in the comment form.', 'wp-recipe-maker' ),
					'default' => __( 'Recipe Rating', 'wp-recipe-maker' ),
					'dependency' => array(
						'id' => 'recipe_template_mode',
						'value' => 'legacy',
						'type' => 'inverse',
					),
				),
			),
			'dependency' => array(
				'id' => 'features_comment_ratings',
				'value' => true,
			),
		),
		array(
			'name' => __( 'User Ratings', 'wp-recipe-maker' ),
			'settings' => array(
				array(
					'id' => 'features_comment_ratings',
					'name' => __( 'Force people to leave a comment', 'wp-recipe-maker' ),
					'description' => __( 'You need to enable the Comment Ratings feature to use this option.', 'wp-recipe-maker' ),
					'type' => 'toggle',
					'default' => true,
					'dependency' => array(
						'id' => 'features_comment_ratings',
						'value' => false,
					),
				),
				array(
					'id' => 'user_ratings_force_comment',
					'name' => __( 'Force visitors to leave a comment', 'wp-recipe-maker' ),
					'description' => __( 'Redirect visitors to the comment form instead of allowing them to vote by just clicking.', 'wp-recipe-maker' ),
					'type' => 'dropdown',
					'options' => array(
						'never' => __( 'Never, allow any user rating', 'wp-recipe-maker' ),
						'1_star' => __( 'If they want to give 1 star', 'wp-recipe-maker' ),
						'2_star' => __( 'If they want to give 2 stars or less', 'wp-recipe-maker' ),
						'3_star' => __( 'If they want to give 3 stars or less', 'wp-recipe-maker' ),
						'4_star' => __( 'If they want to give 4 stars or less', 'wp-recipe-maker' ),
						'always' => __( 'Always redirect to the comment form', 'wp-recipe-maker' ),
					),
					'default' => 'never',
					'dependency' => array(
						'id' => 'features_comment_ratings',
						'value' => true,
					),
				),
			),
			'dependency' => array(
				'id' => 'features_user_ratings',
				'value' => true,
			),
		),
	),
);
