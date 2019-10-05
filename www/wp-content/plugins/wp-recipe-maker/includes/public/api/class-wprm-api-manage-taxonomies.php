<?php
/**
 * API for managing the taxonomies.
 *
 * @link       https://bootstrapped.ventures
 * @since      5.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/api
 */

/**
 * API for managing the taxonomies.
 *
 * @since      5.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Api_Manage_Taxonomies {

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
			register_rest_route( 'wp-recipe-maker/v1', '/manage/taxonomy', array(
				'callback' => array( __CLASS__, 'api_manage_taxonomies' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			) );
			register_rest_route( 'wp-recipe-maker/v1', '/manage/taxonomy/merge', array(
				'callback' => array( __CLASS__, 'api_manage_taxonomies_merge' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			) );
			register_rest_route( 'wp-recipe-maker/v1', '/manage/taxonomy/bulk', array(
				'callback' => array( __CLASS__, 'api_manage_taxonomies_bulk_edit' ),
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
	 * Handle manage taxonomies call to the REST API.
	 *
	 * @since    5.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_manage_taxonomies( $request ) {
		// Parameters.
		$params = $request->get_params();

		$type = isset( $params['type'] ) ? sanitize_key( $params['type'] ) : '';
		$taxonomy = 'wprm_' . $type;

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return false;
		}

		$page = isset( $params['page'] ) ? intval( $params['page'] ) : 0;
		$page_size = isset( $params['pageSize'] ) ? intval( $params['pageSize'] ) : 25;
		$sorted = isset( $params['sorted'] ) ? $params['sorted'] : array( array( 'id' => 'id', 'desc' => true ) );
		$filtered = isset( $params['filtered'] ) ? $params['filtered'] : array();

		// Starting query args.
		$args = array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
			'number' => $page_size,
			'offset' => $page * $page_size,
			'count' => true,
		);

		// Order.
		$args['order'] = $sorted[0]['desc'] ? 'DESC' : 'ASC';
		switch( $sorted[0]['id'] ) {
			case 'name':
				$args['orderby'] = 'title';
				break;
			case 'count':
				$args['orderby'] = 'count';
				break;
			case 'group':
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'wprmp_ingredient_group';
				break;
			case 'link':
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'wprmp_' . $type . '_link';
				break;
			case 'link_nofollow':
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = 'wprmp_' . $type . '_link_nofollow';
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
					case 'name':
						$args['search'] = $value;
						break;
					case 'group':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprmp_ingredient_group',
								'compare' => 'LIKE',
								'value' => $value,
							);
						}
						break;
					case 'link':
						if ( '' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprmp_' . $type . '_link',
								'compare' => 'LIKE',
								'value' => $value,
							);
						}
						break;
					case 'link_nofollow':
						if ( 'all' !== $value ) {
							$args['meta_query'][] = array(
								'key' => 'wprmp_' . $type . '_link_nofollow',
								'compare' => '=',
								'value' => $value,
							);

							// Only when link exists.
							$args['meta_query'][] = array(
								'key' => 'wprmp_' . $type . '_link',
								'compare' => '!=',
								'value' => '',
							);
						}
						break;
					case 'image_id':
						if ( 'all' !== $value ) {
							$compare = 'yes' === $value ? 'EXISTS' : 'NOT EXISTS';

							$args['meta_query'][] = array(
								'key' => 'wprmp_' . $type . '_image_id',
								'compare' => $compare,
							);
						}
						break;
				}
			}
		}

		add_filter( 'terms_clauses', array( __CLASS__, 'api_manage_taxonomies_query' ), 10, 3 );
		$query = new WP_Term_Query( $args );

		unset( $args['number'] );
		unset( $args['offset'] );
		$filtered_terms = wp_count_terms( $taxonomy, $args );
		remove_filter( 'terms_clauses', array( __CLASS__, 'api_manage_taxonomies_query' ), 10, 3 );

		$total_terms = wp_count_terms( $taxonomy, array( 'hide_empty' => false ) );
		$rows = $query->terms ? array_values( $query->terms ) : array();

		// Extra information needed.
		if ( 'ingredient' === $type ) {
			foreach( $rows as $index => $row ) {
				// Ingredient link.
				$row->group = get_term_meta( $row->term_id, 'wprmp_ingredient_group', true );

				// Ingredient link.
				$row->link = get_term_meta( $row->term_id, 'wprmp_ingredient_link', true );
				$row->link_nofollow = '';
				if ( $row->link ) {
					$link_nofollow = get_term_meta( $row->term_id, 'wprmp_ingredient_link_nofollow', true );
					$row->link_nofollow = in_array( $link_nofollow, array( 'default', 'nofollow', 'follow' ) ) ? $link_nofollow : 'default';
				}
			}
		} else if ( 'equipment' === $type ) {
			foreach( $rows as $index => $row ) {
				// Equipment link.
				$row->link = get_term_meta( $row->term_id, 'wprmp_equipment_link', true );
				$row->link_nofollow = '';
				if ( $row->link ) {
					$link_nofollow = get_term_meta( $row->term_id, 'wprmp_equipment_link_nofollow', true );
					$row->link_nofollow = in_array( $link_nofollow, array( 'default', 'nofollow', 'follow' ) ) ? $link_nofollow : 'default';
				}

				// Equipment image.
				$row->image_id = get_term_meta( $row->term_id, 'wprmp_equipment_image_id', true );
				$row->image_url = '';

				if ( $row->image_id ) {
					$thumb = wp_get_attachment_image_src( $row->image_id, array( 150, 999 ) );

					if ( $thumb && isset( $thumb[0] ) ) {
						$row->image_url = $thumb[0];
					}
				}
			}
		} else if( 'nutrition_ingredient' === $type ) {
			foreach( $rows as $index => $row ) {
				$nutrition = WPRMPN_Ingredient_Manager::get_nutrition( $row->term_id );

				if ( $nutrition ) {
					$row->amount = $nutrition['amount'];
					$row->unit = $nutrition['unit'];
					$row->facts = $nutrition['nutrients'];
				} else {
					$row->amount = '';
					$row->unit = '';
					$row->facts = array();
				}
			}
		}

		return array(
			'rows' => $rows,
			'total' => intval( $total_terms ),
			'filtered' => intval( $filtered_terms ),
			'pages' => ceil( $filtered_terms / $page_size ),
		);
	}

	/**
	 * Filter the where taxonomies query.
	 *
	 * @since	5.0.0
	 */
	public static function api_manage_taxonomies_query( $pieces, $taxonomies, $args ) {		
		$id_search = isset( $args['wprm_search_id'] ) ? $args['wprm_search_id'] : false;
		if ( $id_search ) {
			$pieces['where'] .= ' AND t.term_id LIKE \'%' . esc_sql( like_escape( $id_search ) ) . '%\'';
		}

		return $pieces;
	}

	/**
	 * Handle taxonomies merge call to the REST API.
	 *
	 * @since    5.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_manage_taxonomies_merge( $request ) {
		// Parameters.
		$params = $request->get_params();

		$type = isset( $params['type'] ) ? sanitize_key( $params['type'] ) : '';
		$taxonomy = 'wprm_' . $type;

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return false;
		}

		$old_id = isset( $params['oldId'] ) ? intval( $params['oldId'] ) : false;
		$new_id = isset( $params['newId'] ) ? intval( $params['newId'] ) : false;

		if ( $old_id && $new_id ) {
			$old_term = get_term( $old_id, $taxonomy );
			$new_term = get_term( $new_id, $taxonomy );

			if ( $old_term && ! is_wp_error( $old_term ) && $new_term && ! is_wp_error( $new_term ) ) {
				// Add new term ID to recipes using the old term ID.
				$args = array(
					'post_type' => WPRM_POST_TYPE,
					'post_status' => 'any',
					'nopaging' => true,
					'tax_query' => array(
						array(
							'taxonomy' => $old_term->taxonomy,
							'field' => 'id',
							'terms' => $old_term->term_id,
						),
					)
				);
		
				$query = new WP_Query( $args );
				$posts = $query->posts;
				foreach ( $posts as $post ) {
					if ( 'wprm_ingredient' === $old_term->taxonomy ) {
						$recipe = WPRM_Recipe_Manager::get_recipe( $post );
		
						$new_ingredients = array();
						$new_ingredient_ids = array();
						foreach ( $recipe->ingredients() as $ingredient_group ) {
							$new_ingredient_group = $ingredient_group;
							$new_ingredient_group['ingredients'] = array();
		
							foreach ( $ingredient_group['ingredients'] as $ingredient ) {
								if ( intval( $ingredient['id'] ) === $old_term->term_id ) {
									$ingredient['id'] = $new_term->term_id;
									$ingredient['name'] = $new_term->name;
								}
								$new_ingredient_ids[] = intval( $ingredient['id'] );
								$new_ingredient_group['ingredients'][] = $ingredient;
							}
		
							$new_ingredients[] = $new_ingredient_group;
						}
		
						$new_ingredient_ids = array_unique( $new_ingredient_ids );
						wp_set_object_terms( $recipe->id(), $new_ingredient_ids, 'wprm_ingredient', false );
		
						update_post_meta( $recipe->id(), 'wprm_ingredients', $new_ingredients );
					} else if ( 'wprm_equipment' === $old_term->taxonomy ) {
						$recipe = WPRM_Recipe_Manager::get_recipe( $post );
		
						$new_equipment = array();
						$new_equipment_ids = array();
						foreach ( $recipe->equipment() as $equipment ) {
							if ( intval( $equipment['id'] ) === $old_term->term_id ) {
								$equipment['id'] = $new_term->term_id;
								$equipment['name'] = $new_term->name;
							}
							$new_equipment_ids[] = intval( $equipment['id'] );
							$new_equipment[] = $equipment;
						}
		
						$new_equipment_ids = array_unique( $new_equipment_ids );
						wp_set_object_terms( $recipe->id(), $new_equipment_ids, 'wprm_equipment', false );
		
						update_post_meta( $recipe->id(), 'wprm_equipment', $new_equipment );
					} else {
						// Append new term.
						wp_set_object_terms( $post->ID, $new_term->term_id, $new_term->taxonomy, true );
					}
				}

				// Delete old term.
				wp_delete_term( $old_term->term_id, $taxonomy );
				return true;
			}
		}

		return false;
	}

	/**
	 * Handle taxonomies bulk edit call to the REST API.
	 *
	 * @since    5.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_manage_taxonomies_bulk_edit( $request ) {
		// Parameters.
		$params = $request->get_params();

		$type = isset( $params['type'] ) ? sanitize_key( $params['type'] ) : '';
		$taxonomy = 'wprm_' . $type;

		if ( ! taxonomy_exists( $taxonomy ) ) {
			return false;
		}

		$ids = isset( $params['ids'] ) ? array_map( 'intval', $params['ids'] ) : array();
		$action = isset( $params['action'] ) ? $params['action'] : false;

		if ( $ids && $action && $action['type'] ) {
			// Do per post.
			$args = array(
				'taxonomy' => $taxonomy,
				'hide_empty' => false,
				'include' => $ids,
			);

			$query = new WP_Term_Query( $args );
			$terms = $query->terms ? array_values( $query->terms ) : array();

			foreach ( $terms as $term ) {
				switch ( $action['type'] ) {
					case 'change-group':
						if ( 'wprm_ingredient' === $taxonomy ) {
							$group = sanitize_text_field( $action['options'] );
							update_term_meta( $term->term_id, 'wprmp_ingredient_group', $group );
						}
						break;
					case 'change-link':
						if ( 'wprm_ingredient' === $taxonomy ) {
							$link = trim( $action['options'] );
							update_term_meta( $term->term_id, 'wprmp_ingredient_link', $link );
						}
						if ( 'wprm_equipment' === $taxonomy ) {
							$link = trim( $action['options'] );
							update_term_meta( $term->term_id, 'wprmp_equipment_link', $link );
						}
						break;
					case 'change-nofollow':
						if ( 'wprm_ingredient' === $taxonomy ) {
							$nofollow = in_array( $action['options'], array( 'default', 'nofollow', 'follow' ), true ) ? $action['options'] : 'default';
							update_term_meta( $term->term_id, 'wprmp_ingredient_link_nofollow', $nofollow );
						}
						if ( 'wprm_equipment' === $taxonomy ) {
							$nofollow = in_array( $action['options'], array( 'default', 'nofollow', 'follow' ), true ) ? $action['options'] : 'default';
							update_term_meta( $term->term_id, 'wprmp_equipment_link_nofollow', $nofollow );
						}
						break;
					case 'delete':
						wp_delete_term( $term->term_id, $taxonomy );
						break;
				}
			}

			return true;
		}

		return false;
	}
}

WPRM_Api_Manage_Taxonomies::init();
