<?php
/**
 * API for the recipe modal.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * API for the recipe modal.
 *
 * @since      5.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Api_Modal {

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
		if ( function_exists( 'register_rest_field' ) ) { // Prevent issue with Jetpack.
			register_rest_route( 'wp-recipe-maker/v1', '/modal/suggest', array(
				'callback' => array( __CLASS__, 'api_modal_suggest' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
			register_rest_route( 'wp-recipe-maker/v1', '/modal/ingredient/parse', array(
				'callback' => array( __CLASS__, 'api_modal_parse_ingredients' ),
				'methods' => 'POST',
				'permission_callback' => array( __CLASS__, 'api_required_permissions' ),
			));
		}
	}

	/**
	 * Required permissions for the API.
	 *
	 * @since 5.0.0
	 */
	public static function api_required_permissions() {
		return current_user_can( 'edit_posts' );
	}

	/**
	 * Handle suggest call to the REST API.
	 *
	 * @since 5.0.0
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_modal_suggest( $request ) {
		// Parameters.
		$params = $request->get_params();

		$taxonomy = isset( $params['type'] ) && 'equipment' === $params['type'] ? 'wprm_equipment' : 'wprm_ingredient';
		$search = isset( $params['search'] ) ? $params['search'] : '';
		$search = trim( strip_tags( $search ) );

		// Starting query args.
		$args = array(
			'taxonomy' => $taxonomy,
			'hide_empty' => false,
			'number' => 10,
			'offset' => 0,
			'count' => true,
			'orderby' => 'count',
			'order' => 'DESC',
			'search' => $search,
		);

		$query = new WP_Term_Query( $args );
		$terms = $query->get_terms();
		$suggestions = array();

		if ( $terms && is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				$suggestions[] = array(
					'name' => $term->name,
					'count' => $term->count,
				);
			}
		}

		return array(
			'suggestions' => $suggestions,
		);
	}

	/**
	 * Handle parse ingredients call to the REST API.
	 *
	 * @since 5.0.0
	 * @param WP_REST_Request $request Current request.
	 */
	public static function api_modal_parse_ingredients( $request ) {
		// Parameters.
		$params = $request->get_params();

		$ingredients = isset( $params['ingredients'] ) ? $params['ingredients'] : '';
		$parsed = array();

		foreach ( $ingredients as $index => $ingredient ) {
			$parsed[ $index ] = WPRM_Recipe_Parser::parse_ingredient( $ingredient );
		}

		return array(
			'parsed' => $parsed,
		);
	}
}

WPRM_Api_Modal::init();
