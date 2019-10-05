<?php
/**
 * Calculate and store the recipe rating.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.22.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Calculate and store the recipe rating.
 *
 * @since      1.22.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Rating {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.22.0
	 */
	public static function init() {
	}

	/**
	 * Update the rating for the recipes affected by a specific comment.
	 *
	 * @since    1.22.0
	 * @param	 int $comment_id Comment ID to update the rating for.
	 */
	public static function update_recipe_rating_for_comment( $comment_id ) {
		$comment = get_comment( $comment_id );
		$post_id = $comment->comment_post_ID;

		$recipe_ids = WPRM_Recipe_Manager::get_recipe_ids_from_post( $post_id );

		if ( $recipe_ids ) {
			foreach ( $recipe_ids as $recipe_id ) {
				self::update_recipe_rating( $recipe_id );
			}
		}
	}

	/**
	 * Update the rating for a specific recipe.
	 *
	 * @since    1.22.0
	 * @param	 int $recipe_id Recipe ID to to update the rating for.
	 */
	public static function update_recipe_rating( $recipe_id ) {
		$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

		$recipe_rating = array(
			'count' => 0,
			'total' => 0,
			'average' => 0,
		);

		$ratings = self::get_ratings_for( $recipe_id );

		foreach ( $ratings['ratings'] as $rating ) {
			$recipe_rating['count']++;
			$recipe_rating['total'] += intval( $rating->rating );
		}

		// Calculate average.
		if ( $recipe_rating['count'] > 0 ) {
			$recipe_rating['average'] = ceil( $recipe_rating['total'] / $recipe_rating['count'] * 100 ) / 100;
		}

		// Update recipe rating and average (to sort by).
		update_post_meta( $recipe_id, 'wprm_rating', $recipe_rating );
		update_post_meta( $recipe_id, 'wprm_rating_average', $recipe_rating['average'] );

		// Update parent post with rating data (TODO account for multiple recipes in a post).
		update_post_meta( $recipe->parent_post_id(), 'wprm_rating', $recipe_rating );
		update_post_meta( $recipe->parent_post_id(), 'wprm_rating_average', $recipe_rating['average'] );

		return $recipe_rating;
	}

	/**
	 * Get the ratings for a specific recipe.
	 *
	 * @since    2.2.0
	 * @param	 int $recipe_id Recipe ID to to get the ratings for.
	 */
	public static function get_ratings_for( $recipe_id ) {
		$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

		$ratings = array(
			'total' => 0,
			'ratings' => array(),
		);
		$query_where = '';

		// Get comment ratings.
		if ( WPRM_Settings::get( 'features_comment_ratings' ) ) {
			if ( WPRM_Migrations::is_migrated_to( 'ratings_db_post_id' ) ) {
				$parent_post_id = $recipe->parent_post_id();

				if ( $parent_post_id ) {
					$where_comments = 'approved = 1 AND post_id = ' . intval( $parent_post_id );
					$query_where .= $query_where ? ' OR ' . $where_comments : $where_comments;
				}
			} else {
				$comments = get_approved_comments( $recipe->parent_post_id() );
				$comment_ids = array_map( 'intval', wp_list_pluck( $comments, 'comment_ID' ) );

				if ( count( $comment_ids ) ) {
					$where_comments = 'comment_id IN (' . implode( ',', $comment_ids ) . ')';
					$query_where .= $query_where ? ' OR ' . $where_comments : $where_comments;
				}
			}
		}

		// Get user ratings.
		if ( WPRM_Addons::is_active( 'premium' ) && WPRM_Settings::get( 'features_user_ratings' ) ) {
			$where_recipe = 'recipe_id = ' . intval( $recipe_id );
			$query_where .= $query_where ? ' OR ' . $where_recipe : $where_recipe;
		}

		if ( $query_where ) {
			$rating_args = array(
				'where' => $query_where,
			);
			$ratings = WPRM_Rating_Database::get_ratings( $rating_args );
		}

		return $ratings;
	}

	/**
	 * Get the ratings summary for a specific recipe.
	 *
	 * @since    5.0.0
	 * @param	 int $recipe_id Recipe ID to to get the ratings summary for.
	 */
	public static function get_ratings_summary_for( $recipe_id ) {
		$ratings = array(
			'average' => get_post_meta( $recipe_id, 'wprm_rating_average', true ),
			'comment_ratings' => false,
			'user_ratings' => false,
		);

		if ( WPRM_Settings::get( 'features_comment_ratings' ) ) {
			$count = 0;
			$total = 0;

			$comment_ratings = WPRM_Comment_Rating::get_ratings_for( $recipe_id );
			foreach ( $comment_ratings as $comment_rating ) {
				$count++;
				$total += intval( $comment_rating->rating );
			}

			if ( $count ) {
				$ratings['comment_ratings'] = array(
					'count' => $count,
					'average' => ceil( $total / $count * 100 ) / 100,
				);
			}
		}

		if ( WPRM_Addons::is_active( 'premium' ) && WPRM_Settings::get( 'features_user_ratings' ) ) {
			$count = 0;
			$total = 0;

			$user_ratings = WPRMP_User_Rating::get_ratings_for( $recipe_id );
			foreach ( $user_ratings as $user_rating ) {
				$count++;
				$total += intval( $user_rating->rating );
			}

			if ( $count ) {
				$ratings['user_ratings'] = array(
					'count' => $count,
					'average' => ceil( $total / $count * 100 ) / 100,
				);
			}
		}

		return $ratings;
	}
}

WPRM_Rating::init();
