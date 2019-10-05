<?php
/**
 * API for managing the recipe revisions.
 *
 * @link       https://bootstrapped.ventures
 * @since      5.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/api
 */

/**
 * API for managing the recipe revisions.
 *
 * @since      5.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/api
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Api_Manage_Revisions {

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
			register_rest_route( 'wp-recipe-maker/v1', '/manage/revision', array(
				'callback' => array( __CLASS__, 'api_manage_revisions' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			) );
		}
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
	 * Handle manage recipe revisions call to the REST API.
	 *
	 * @since    5.0.0
	 * @param    WP_REST_Request $request Current request.
	 */
	public static function api_manage_revisions( $request ) {
		// Parameters.
		$params = $request->get_params();

		$page = isset( $params['page'] ) ? intval( $params['page'] ) : 0;
		$page_size = isset( $params['pageSize'] ) ? intval( $params['pageSize'] ) : 25;
		$sorted = isset( $params['sorted'] ) ? $params['sorted'] : array( array( 'id' => 'id', 'desc' => true ) );
		$filtered = isset( $params['filtered'] ) ? $params['filtered'] : array();

		// Starting query args.
		$args = array(
			'post_type' => 'revision',
			'post_status' => 'inherit',
			'posts_per_page' => $page_size,
			'offset' => $page * $page_size,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => 'wprm_recipe',
					'compare' => 'EXISTS',
				),
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
			case 'recipe_id':
				$args['orderby'] = 'post_parent';
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
					case 'recipe_id':
						$args['wprm_search_parent'] = $value;
						break;
				}
			}
		}

		add_filter( 'posts_where', array( __CLASS__, 'api_manage_revisions_query_where' ), 10, 2 );
		$query = new WP_Query( $args );
		remove_filter( 'posts_where', array( __CLASS__, 'api_manage_revisions_query_where' ), 10, 2 );

		$revisions = array();
		$posts = $query->posts;
		foreach ( $posts as $post ) {
			$original_recipe = WPRM_Recipe_Manager::get_recipe( $post->post_parent );
			$recipe_data = get_post_meta( $post->ID, 'wprm_recipe', true );

			if ( $original_recipe && $recipe_data ) {
				$post->recipe_original = $original_recipe->get_data();
				$post->recipe_data = $recipe_data;

				$revisions[] = $post;
			}
		}

		return array(
			'rows' => array_values( $revisions ),
			'total' => false,
			'filtered' => intval( $query->found_posts ),
			'pages' => ceil( $query->found_posts / $page_size ),
		);
	}

	/**
	 * Filter the where recipes query.
	 *
	 * @since    5.0.0
	 */
	public static function api_manage_revisions_query_where( $where, $wp_query ) {
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

		$parent_search = $wp_query->get( 'wprm_search_parent' );
		if ( $parent_search ) {
			$where .= ' AND ' . $wpdb->posts . '.post_parent LIKE \'%' . esc_sql( like_escape( $parent_search ) ) . '%\'';
		}

		return $where;
	}
}

WPRM_Api_Manage_Revisions::init();
