<?php
/**
 * API for managing the recipes.
 *
 * @link       https://bootstrapped.ventures
 * @since      5.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/api
 */

/**
 * API for managing the recipes.
 *
 * @since      5.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Api_Manage_Recipes {

	/**
	 * Register actions and filters.
	 *
	 * @since    5.0.0
	 */
	public static function init() {
		add_action( 'rest_api_init', array( __CLASS__, 'api_register_data' ) );
	}

	/**
	 * Register data for the REST API.
	 *
	 * @since    5.0.0
	 */
	public static function api_register_data() {
		if ( function_exists( 'register_rest_field' ) ) {
			register_rest_route( 'wp-recipe-maker/v1', '/manage/recipe', array(
				'callback' => array( __CLASS__, 'api_manage_recipes' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			) );
			register_rest_route( 'wp-recipe-maker/v1', '/manage/recipe/bulk', array(
				'callback' => array( __CLASS__, 'api_manage_recipes_bulk_edit' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			) );
		}
	}

	/**
	 * Validate ID in API call.
	 *
	 * @since    5.0.0
	 * @param    mixed           $param Parameter to validate.
	 * @param    WP_REST_Request $request Current request.
	 * @param    mixed           $key Key.
	 */
	public static function api_validate_numeric( $param, $request, $key ) {
		return is_numeric( $param );
	}

	/**
	 * Required permissions for the API.
	 *
	 * @since    5.0.0
	 */
	public static function api_required_permissions() {
		return current_user_can( WPRM_Settings::get( 'features_manage_access' ) );
	}

	/**
	 * Handle manage recipes call to the REST API.
	 *
	 * @since    5.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_manage_recipes( $request ) {
		// Parameters.
		$params = $request->get_params();

		$page = isset( $params['page'] ) ? intval( $params['page'] ) : 0;
		$page_size = isset( $params['pageSize'] ) ? intval( $params['pageSize'] ) : 25;
		$sorted = isset( $params['sorted'] ) ? $params['sorted'] : array( array( 'id' => 'id', 'desc' => true ) );
		$filtered = isset( $params['filtered'] ) ? $params['filtered'] : array();

		// Exclude recipe submissions.
		$post_status = array( 'publish', 'future', 'draft', 'private' );
		if ( ! WPRM_Addons::is_active( 'recipe-submission' ) ) {
			$post_status[] = 'pending';
		}

		// Starting query args.
		$args = array(
			'post_type' => WPRM_POST_TYPE,
			'post_status' => $post_status,
			'posts_per_page' => $page_size,
			'offset' => $page * $page_size,
			'meta_query' => array(
				'relation' => 'AND',
			),
			'tax_query' => array(),
		);

		// Order.
		$args['order'] = $sorted[0]['desc'] ? 'DESC' : 'ASC';
		switch( $sorted[0]['id'] ) {
			case 'date':
				$args['orderby'] = 'date';
				break;
			case 'name':
				$args['orderby'] = 'title';
				break;
			case 'post_author':
				$args['orderby'] = 'post_author';
				break;
			case 'type':
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'wprm_type';
				break;
			case 'author_display':
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'wprm_author_display';
				break;
			case 'parent_post_id':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'wprm_parent_post_id';
				break;
			case 'rating':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'wprm_rating_average';
				break;
			case 'prep_time':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'wprm_prep_time';
				break;
			case 'cook_time':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'wprm_cook_time';
				break;
			case 'custom_time':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'wprm_custom_time';
				break;
			case 'total_time':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = 'wprm_total_time';
				break;
			default:
			 	$args['orderby'] = 'ID';
		}

		// Filter.
		if ( $filtered ) {
			foreach ( $filtered as $filter ) {
				$value = trim( $filter['value'] );
				switch( $filter['id'] ) {
					case 'id':
						$args['wprm_search_id'] = $value;
						break;
					case 'date':
						$args['wprm_search_date'] = $value;
						break;
					case 'name':
						$args['wprm_search_title'] = $value;
						break;
					case 'post_author':
						if ( 'all' !== $value ) {
							$args['author'] = $value;
						}
						break;
					case 'type':
						if ( 'all' !== $value ) {
							if ( 'other' === $value ) {
								// Used non-food before other.
								$args['meta_query'][] = array(
									'key' => 'wprm_type',
									'compare' => 'IN',
									'value' => array( 'other', 'non-food' ),
								);
							} else {
								$args['meta_query'][] = array(
									'key' => 'wprm_type',
									'compare' => '=',
									'value' => $value,
								);
							}
						}
						break;
					case 'image':
						if ( 'all' !== $value ) {
							if ( 'yes' === $value ) {
								$args['meta_query'][] = array(
									'key' => '_thumbnail_id',
									'compare' => 'EXISTS'
								);
							} elseif ( 'no' === $value ) {
								$args['meta_query'][] = array(
									'key' => '_thumbnail_id',
									'compare' => 'NOT EXISTS'
								);
							}
						}
						break;
					case 'author_display':
						if ( 'all' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprm_author_display',
								'compare' => '=',
								'value' => $value,
							);
						}
						break;
					case 'status':
						if ( 'all' !== $value ) {
							$args['post_status'] = $value;
						}
						break;
					case 'parent_post_id':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprm_parent_post_id',
								'compare' => 'LIKE',
								'value' => $value,
							);
						}
						break;
					case 'parent_post':
						if ( 'all' !== $value ) {
							$compare = 'yes' === $value ? 'EXISTS' : 'NOT EXISTS';

							$args['meta_query'][] = array(
								'key' => 'wprm_parent_post_id',
								'compare' => $compare,
							);
						}
						break;
					case 'rating':
						if ( 'all' !== $value ) {
							if ( 'none' === $value ) {
								$args['meta_query'][] = array(
									'key' => 'wprm_rating_average',
									'compare' => '=',
									'value' => '0',
								);
							} elseif ( 'any' === $value ) {
								$args['meta_query'][] = array(
									'key' => 'wprm_rating_average',
									'compare' => '!=',
									'value' => '0',
								);
							} else {
								$stars = intval( $value );

								$args['meta_query'][] = array(
									'key' => 'wprm_rating_average',
									'compare' => '>',
									'value' => $value - 1,
								);

								$args['meta_query'][] = array(
									'key' => 'wprm_rating_average',
									'compare' => '<=',
									'value' => $value,
								);
							}
						}
						break;
					case 'prep_time':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprm_prep_time',
								'compare' => '=',
								'value' => self::parse_time( $value ),
							);
						}
						break;
					case 'cook_time':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprm_cook_time',
								'compare' => '=',
								'value' => self::parse_time( $value ),
							);
						}
						break;
					case 'custom_time':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprm_custom_time',
								'compare' => '=',
								'value' => self::parse_time( $value ),
							);
						}
						break;
					case 'total_time':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprm_total_time',
								'compare' => '=',
								'value' => self::parse_time( $value ),
							);
						}
						break;
					case 'equipment':
						if ( '' !== $value ) {
							$equipment_ids = get_terms(array(
								'taxonomy' => 'wprm_equipment',
								'name__like' => $value,
								'hide_empty' => false,
								'fields' => 'ids',
							));

							$args['tax_query'][] = array(
								'taxonomy' => 'wprm_equipment',
								'field' => 'term_id',
								'terms' => $equipment_ids,
								'operator' => 'IN',
							);
						}
						break;
					case 'ingredient':
						if ( '' !== $value ) {
							$ingredient_ids = get_terms(array(
								'taxonomy' => 'wprm_ingredient',
								'name__like' => $value,
								'hide_empty' => false,
								'fields' => 'ids',
							));

							$args['tax_query'][] = array(
								'taxonomy' => 'wprm_ingredient',
								'field' => 'term_id',
								'terms' => $ingredient_ids,
								'operator' => 'IN',
							);
						}
						break;
					case 'submission_author':
						if ( 'all' !== $value ) {
							$compare = 'yes' === $value ? 'EXISTS' : 'NOT EXISTS';

							$args['meta_query'][] = array(
								'key' => 'wprm_submission_user',
								'compare' => $compare,
							);
						}
						break;
					default:
						// Assume it's a taxonomy if it doesn't match anything else.
						if ( 'all' !== $value ) {
							$taxonomy = 'wprm_' . $filter['id'];

							if ( 'none' === $value ) {
								$args['tax_query'][] = array(
									'taxonomy' => $taxonomy,
									'operator' => 'NOT EXISTS',
								);
							} elseif ( 'any' === $value ) {
								$args['tax_query'][] = array(
									'taxonomy' => $taxonomy,
									'operator' => 'EXISTS',
								);
							} else {
								$args['tax_query'][] = array(
									'taxonomy' => $taxonomy,
									'field' => 'term_id',
									'terms' => intval( $value ),
								);
							}
						}
				}
			}
		}

		add_filter( 'posts_where', array( __CLASS__, 'api_manage_recipes_query_where' ), 10, 2 );
		$query = new WP_Query( $args );
		remove_filter( 'posts_where', array( __CLASS__, 'api_manage_recipes_query_where' ), 10, 2 );

		$recipes = array();
		$posts = $query->posts;
		foreach ( $posts as $post ) {
			$recipe = WPRM_Recipe_Manager::get_recipe( $post );

			if ( ! $recipe ) {
				continue;
			}

			$recipes[] = $recipe->get_data_manage();
		}

		// Got total number of recipes.
		$total = (array) wp_count_posts( WPRM_POST_TYPE );
		unset( $total['trash'] );

		// Remove recipe submissions from total.
		if ( WPRM_Addons::is_active( 'recipe-submission' ) ) {
			unset( $total['pending'] );
		}

		return array(
			'rows' => array_values( $recipes ),
			'total' => array_sum( $total ),
			'filtered' => intval( $query->found_posts ),
			'pages' => ceil( $query->found_posts / $page_size ),
		);
	}

	/**
	 * Filter the where recipes query.
	 *
	 * @since    5.0.0
	 */
	public static function api_manage_recipes_query_where( $where, $wp_query ) {
		global $wpdb;

		$id_search = $wp_query->get( 'wprm_search_id' );
		if ( $id_search ) {
			$where .= ' AND ' . $wpdb->posts . '.ID LIKE \'%' . esc_sql( like_escape( $id_search ) ) . '%\'';
		}

		$date_search = $wp_query->get( 'wprm_search_date' );
		if ( $date_search ) {
			$where .= ' AND ' . $wpdb->posts . '.post_date LIKE \'%' . esc_sql( like_escape( $date_search ) ) . '%\'';
		}

		$title_search = $wp_query->get( 'wprm_search_title' );
		if ( $title_search ) {
			$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $title_search ) ) . '%\'';
		}

		return $where;
	}

	/**
	 * Parse the time filter.
	 *
	 * @since    5.0.0
	 */
	public static function parse_time( $time ) {
		// Assume a number is minutes.
		if ( '' . $time === '' . intval( $time ) ) {
			$time = "{$time} minutes";
		}

		$time .= ' ';

		// Common units.
		$time = str_ireplace( 'd ', 'day ', $time );
		$time = str_ireplace( 'hrs ', 'hours ', $time );
		$time = str_ireplace( 'hr ', 'hour ', $time );
		$time = str_ireplace( 'h ', 'hour ', $time );
		$time = str_ireplace( 'mins ', 'minutes ', $time );
		$time = str_ireplace( 'min ', 'minutes ', $time );
		$time = str_ireplace( 'm ', 'minutes ', $time );

		$now = time();
		$time = strtotime( $time, $now );

		return ( $time - $now ) / 60;
	}

	/**
	 * Handle recipe bulk edit call to the REST API.
	 *
	 * @since    5.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_manage_recipes_bulk_edit( $request ) {
		// Parameters.
		$params = $request->get_params();

		$ids = isset( $params['ids'] ) ? array_map( 'intval', $params['ids'] ) : array();
		$action = isset( $params['action'] ) ? $params['action'] : false;

		if ( $ids && $action && $action['type'] ) {
			// Do once.
			if ( 'export' === $action['type'] ) {
				if ( WPRM_Addons::is_active( 'premium' ) ) {
					return WPRMP_Export_JSON::bulk_edit_export( $ids );
				} else {
					return false;
				}
			}

			// Do per post.
			$args = array(
				'post_type' => WPRM_POST_TYPE,
				'post_status' => 'any',
				'nopaging' => true,
				'post__in' => $ids,
				'ignore_sticky_posts' => true,
			);

			$query = new WP_Query( $args );
			$posts = $query->posts;
			foreach ( $posts as $post ) {
				$recipe = WPRM_Recipe_Manager::get_recipe( $post->ID );
				$recipe_data = $recipe->get_data();

				switch ( $action['type'] ) {
					case 'remove-terms':
						$remove_terms = array_map( function( $option ) {
							$term_id = intval( $option['term_id'] );

							if ( 0 === $term_id ) {
								$term = get_term_by( 'name', $option['term_id'], 'eafl_category' );

								if ( $term && ! is_wp_error( $term ) ) {
									$term_id = $term->term_id;
								}
							}

							return $term_id;
						}, $action['options']['terms'] );

						$new_terms = array_filter( $recipe_data['tags'][ $action['options']['taxonomy'] ], function( $term ) use ( $remove_terms ) {
							return ! in_array( $term->term_id, $remove_terms );
						});

						if ( count( $new_terms ) !== count( $recipe_data['tags'][ $action['options']['taxonomy'] ] ) ) {
							$recipe_data['tags'][ $action['options']['taxonomy'] ] = $new_terms;
						} else {
							$recipe_data = false;
						}
						break;
					case 'add-terms':
						$recipe_data['tags'][ $action['options']['taxonomy'] ] = array_merge( $recipe_data['tags'][ $action['options']['taxonomy'] ], $action['options']['terms'] );
						break;
					case 'change-type':
						$recipe_data['type'] = $action['options'];
						break;
					case 'change-author':
						$recipe_data['author_display'] = $action['options']['author'];
						$recipe_data['author_name'] = $action['options']['author_name'];
						$recipe_data['author_link'] = $action['options']['author_link'];
						break;
					case 'delete':
						$recipe_data = false;
						wp_trash_post( $recipe->id() );
						break;
				}

				if ( $recipe_data ) {
					$recipe_data = WPRM_Recipe_Sanitizer::sanitize( $recipe_data );
					WPRM_Recipe_Saver::update_recipe( $recipe->id(), $recipe_data );
				}
			}

			return true;
		}

		return false;
	}
}

WPRM_Api_Manage_Recipes::init();
