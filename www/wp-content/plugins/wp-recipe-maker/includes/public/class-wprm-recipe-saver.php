<?php
/**
 * Responsible for saving recipes.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Responsible for saving recipes.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Recipe_Saver {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'save_post', array( __CLASS__, 'update_post' ), 10, 2 );
		add_action( 'admin_init', array( __CLASS__, 'update_recipes_check' ) );

		add_filter( 'wp_insert_post_data', array( __CLASS__, 'post_type_switcher_fix' ), 20, 2 );
	}

	/**
	 * Create a new recipe.
	 *
	 * @since    1.0.0
	 * @param		 array $recipe Recipe fields to save.
	 */
	public static function create_recipe( $recipe ) {
		$post = array(
			'post_type' => WPRM_POST_TYPE,
			'post_status' => 'draft',
		);

		$recipe_id = wp_insert_post( $post );
		WPRM_Recipe_Saver::update_recipe( $recipe_id, $recipe );

		return $recipe_id;
	}

	/**
	 * Save recipe fields.
	 *
	 * @since    1.0.0
	 * @param		 int   $id Post ID of the recipe.
	 * @param		 array $recipe Recipe fields to save.
	 */
	public static function update_recipe( $id, $recipe ) {
		$meta = array();

		// Featured Image.
		if ( isset( $recipe['image_id'] ) ) {
			if ( $recipe['image_id'] ) {
				set_post_thumbnail( $id, $recipe['image_id'] );
			} else {
				delete_post_thumbnail( $id );
			}
		}

		// Recipe Taxonomies.
		if ( isset( $recipe['tags'] ) ) {
			$taxonomies = WPRM_Taxonomies::get_taxonomies();
			foreach ( $taxonomies as $taxonomy => $options ) {
				$key = substr( $taxonomy, 5 ); // Get rid of wprm_.
				wp_set_object_terms( $id, $recipe['tags'][ $key ], $taxonomy, false );
			}
		}

		// Recipe Equipment.
		if ( isset( $recipe['equipment'] ) ) {
			$equipment_ids = array();
			foreach ( $recipe['equipment'] as $equipment ) {
				$equipment_ids[] = intval( $equipment['id'] );
			}
			$equipment_ids = array_unique( $equipment_ids );

			$meta['wprm_equipment'] = $recipe['equipment'];
			wp_set_object_terms( $id, $equipment_ids, 'wprm_equipment', false );
		}

		// Recipe Ingredients.
		if ( isset( $recipe['ingredients'] ) ) {
			$ingredient_ids = array();
			foreach ( $recipe['ingredients'] as $ingredient_group ) {
				foreach ( $ingredient_group['ingredients'] as $ingredient ) {
					$ingredient_ids[] = intval( $ingredient['id'] );
				}
			}
			$ingredient_ids = array_unique( $ingredient_ids );

			$meta['wprm_ingredients'] = $recipe['ingredients'];
			wp_set_object_terms( $id, $ingredient_ids, 'wprm_ingredient', false );
		}

		// Video fields (always clear metadata).
		$meta['wprm_video_metadata'] = '';
		if ( isset( $recipe['video_id'] ) )	{
			$meta['wprm_video_id'] = $recipe['video_id'];
		}
		if ( isset( $recipe['video_embed'] ) ) {
			$meta['wprm_video_embed'] = $recipe['video_embed'];
		}

		// Nutrition fields.
		if ( isset( $recipe['nutrition'] ) ) {
			foreach ( $recipe['nutrition'] as $nutrient => $value ) {
				$meta[ 'wprm_nutrition_' . $nutrient ] = $value;
			}
		}

		// Meta Fields.
		if ( isset( $recipe['type'] ) )						{ $meta['wprm_type'] = $recipe['type']; }
		if ( isset( $recipe['pin_image_id'] ) )				{ $meta['wprm_pin_image_id'] = $recipe['pin_image_id']; }
		if ( isset( $recipe['author_display'] ) )			{ $meta['wprm_author_display'] = $recipe['author_display']; }
		if ( isset( $recipe['author_name'] ) )				{ $meta['wprm_author_name'] = $recipe['author_name']; }
		if ( isset( $recipe['author_link'] ) )				{ $meta['wprm_author_link'] = $recipe['author_link']; }
		if ( isset( $recipe['servings'] ) )					{ $meta['wprm_servings'] = $recipe['servings']; }
		if ( isset( $recipe['servings_unit'] ) )			{ $meta['wprm_servings_unit'] = $recipe['servings_unit']; }
		if ( isset( $recipe['cost'] ) )						{ $meta['wprm_cost'] = $recipe['cost']; }
		if ( isset( $recipe['prep_time'] ) )				{ $meta['wprm_prep_time'] = $recipe['prep_time']; }
		if ( isset( $recipe['prep_time_zero'] ) )			{ $meta['wprm_prep_time_zero'] = $recipe['prep_time_zero']; }
		if ( isset( $recipe['cook_time'] ) )				{ $meta['wprm_cook_time'] = $recipe['cook_time']; }
		if ( isset( $recipe['cook_time_zero'] ) )			{ $meta['wprm_cook_time_zero'] = $recipe['cook_time_zero']; }
		if ( isset( $recipe['total_time'] ) )				{ $meta['wprm_total_time'] = $recipe['total_time']; }
		if ( isset( $recipe['custom_time'] ) )				{ $meta['wprm_custom_time'] = $recipe['custom_time']; }
		if ( isset( $recipe['custom_time_zero'] ) )			{ $meta['wprm_custom_time_zero'] = $recipe['custom_time_zero']; }
		if ( isset( $recipe['custom_time_label'] ) )		{ $meta['wprm_custom_time_label'] = $recipe['custom_time_label']; }
		if ( isset( $recipe['instructions'] ) )				{ $meta['wprm_instructions'] = $recipe['instructions']; }
		if ( isset( $recipe['notes'] ) )					{ $meta['wprm_notes'] = $recipe['notes']; }
		if ( isset( $recipe['ingredient_links_type'] ) )	{ $meta['wprm_ingredient_links_type'] = $recipe['ingredient_links_type']; }
		if ( isset( $recipe['import_source'] ) ) 			{ $meta['wprm_import_source'] = $recipe['import_source']; }
		if ( isset( $recipe['import_backup'] ) ) 			{ $meta['wprm_import_backup'] = $recipe['import_backup']; }

		$meta = apply_filters( 'wprm_recipe_save_meta', $meta, $id, $recipe );

		// Post Fields.
		$post = array(
			'ID' => $id,
			'meta_input' => $meta,
		);

		if ( isset( $recipe['name'] ) ) {
			$post['post_title'] = $recipe['name'];
			$post['post_name'] = 'wprm-' . sanitize_title( $recipe['name'] );
		}

		if ( isset( $recipe['summary'] ) ) {
			$post['post_content'] = $recipe['summary'];
		}

		// Always update post to make sure revision gets made.
		WPRM_Recipe_Manager::invalidate_recipe( $id );
		wp_update_post( $post );
	}

	/**
	 * Check if post being saved contains recipes we need to update.
	 *
	 * @since    1.0.0
	 * @param		 int    $id Post ID being saved.
	 * @param		 object $post Post being saved.
	 */
	public static function update_post( $id, $post ) {
		// Use parent post if we're currently updating a revision.
		$revision_parent = wp_is_post_revision( $post );
		if ( $revision_parent ) {
			$post = get_post( $revision_parent );
		}

		$recipe_ids = WPRM_Recipe_Manager::get_recipe_ids_from_content( $post->post_content );

		if ( count( $recipe_ids ) > 0 ) {
			// Immediately update when importing, otherwise do on next load to prevent issues with other plugins.
			if ( isset( $_POST['importer_uid'] ) || ( isset( $_POST['action'] ) && 'wprm_finding_parents' === $_POST['action'] ) ) { // Input var okay.
				self::update_recipes_in_post( $post->ID, $recipe_ids );
			} else {
				$post_recipes_to_update = get_option( 'wprm_post_recipes_to_update', array() );
				$post_recipes_to_update[ $post->ID ] = $recipe_ids;
				update_option( 'wprm_post_recipes_to_update', $post_recipes_to_update );
			}
		}
	}

	/**
	 * Check if post being saved contains recipes we need to update.
	 *
	 * @since    1.19.0
	 */
	public static function update_recipes_check() {
		if ( ! isset( $_POST['action'] ) ) {
			$post_recipes_to_update = get_option( 'wprm_post_recipes_to_update', array() );

			if ( ! empty( $post_recipes_to_update ) ) {
				// Get first post to update the recipes for.
				$recipe_ids = reset( $post_recipes_to_update );
				$post_id = key( $post_recipes_to_update );

				self::update_recipes_in_post( $post_id, $recipe_ids );

				// Update remaing post/recipes to update.
				unset( $post_recipes_to_update[ $post_id ] );
				update_option( 'wprm_post_recipes_to_update', $post_recipes_to_update );
			}
		}
	}

	/**
	 * Update recipes with post data.
	 *
	 * @since    1.20.0
	 * @param	 mixed $post_id    Post to use the data from.
	 * @param	 array $recipe_ids Recipes to update.
	 */
	public static function update_recipes_in_post( $post_id, $recipe_ids ) {
		$post = get_post( $post_id );

		// Skip Revisionize revisions.
		$revisionize = get_post_meta( $post_id, '_post_revision_of', true );
		if ( $revisionize ) {
			return;
		}

		// Skip Revision Manager TMC revisions.
		$rm_tmc = get_post_meta( $post_id, 'linked_post_id', true );
		if ( $rm_tmc ) {
			return;
		}

		if ( 'trash' !== $post->post_status ) {
			$categories = get_the_terms( $post, 'category' );
			$cat_ids = ! $categories || is_wp_error( $categories ) ? array() : wp_list_pluck( $categories, 'term_id' );

			// Update recipes.
			foreach ( $recipe_ids as $recipe_id ) {
				$recipe = array(
					'ID'          	=> $recipe_id,
					'post_status' 	=> $post->post_status,
					'post_author' 	=> $post->post_author,
					'post_date' 	=> $post->post_date,
					'post_date_gmt' => $post->post_date_gmt,
					'post_modified' => $post->post_modified,
					'edit_date'		=> true, // Required when going from draft to future.
				);
				wp_update_post( $recipe );

				update_post_meta( $recipe_id, 'wprm_parent_post_id', $post_id );

				// Optionally associate categories with recipes.
				if ( is_object_in_taxonomy( WPRM_POST_TYPE, 'category' ) ) {
					wp_set_post_categories( $recipe_id, $cat_ids );
				}
			}
		} else {
			// Parent got deleted, set as draft and remove parent post relation.
			foreach ( $recipe_ids as $recipe_id ) {
				$recipe = array(
					'ID'          => $recipe_id,
					'post_status' => 'draft',
				);
				wp_update_post( $recipe );

				delete_post_meta( $recipe_id, 'wprm_parent_post_id' );
			}
		}
	}

	/**
	 * Prevent post type switcher bug from changing our recipe's post type.
	 *
	 * @since    1.4.0
	 * @param		 array $data    Data that might have been modified by Post Type Switcher.
	 * @param	   array $postarr Unmodified post data.
	 */
	public static function post_type_switcher_fix( $data, $postarr ) {
		if ( WPRM_POST_TYPE === $postarr['post_type'] ) {
			$data['post_type'] = WPRM_POST_TYPE;
		}
		return $data;
	}
}

WPRM_Recipe_Saver::init();
