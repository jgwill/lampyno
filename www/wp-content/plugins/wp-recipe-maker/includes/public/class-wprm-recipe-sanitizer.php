<?php
/**
 * Santize recipe input fields.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Santize recipe input fields.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Recipe_Sanitizer {

	/**
	 * Sanitize recipe array.
	 *
	 * @since    1.0.0
	 * @param		 array $recipe Array containing all recipe input data.
	 */
	public static function sanitize( $recipe ) {
		$sanitized_recipe = array();

		// Unsanitized fields.
		if ( isset( $recipe['video_embed'] ) ) { $sanitized_recipe['video_embed'] = $recipe['video_embed']; }

		// Boolean fields.
		if ( isset( $recipe['prep_time_zero'] ) )	{ $sanitized_recipe['prep_time_zero'] = $recipe['prep_time_zero'] ? true : false; }
		if ( isset( $recipe['cook_time_zero'] ) )	{ $sanitized_recipe['cook_time_zero'] = $recipe['cook_time_zero'] ? true : false; }
		if ( isset( $recipe['custom_time_zero'] ) )	{ $sanitized_recipe['custom_time_zero'] = $recipe['custom_time_zero'] ? true : false; }

		// Text fields.
		if ( isset( $recipe['name'] ) )					{ $sanitized_recipe['name'] = sanitize_text_field( $recipe['name'] ); }
		if ( isset( $recipe['author_name'] ) )			{ $sanitized_recipe['author_name'] = sanitize_text_field( $recipe['author_name'] ); }
		if ( isset( $recipe['author_link'] ) )			{ $sanitized_recipe['author_link'] = sanitize_text_field( $recipe['author_link'] ); }
		if ( isset( $recipe['servings_unit'] ) )		{ $sanitized_recipe['servings_unit'] = sanitize_text_field( $recipe['servings_unit'] ); }
		if ( isset( $recipe['cost'] ) )					{ $sanitized_recipe['cost'] = sanitize_text_field( $recipe['cost'] ); }
		if ( isset( $recipe['custom_time_label'] ) )	{ $sanitized_recipe['custom_time_label'] = sanitize_text_field( $recipe['custom_time_label'] ); }

		// HTML fields.
		if ( isset( $recipe['summary'] ) )	{ $sanitized_recipe['summary'] = self::sanitize_html( $recipe['summary'] ); }
		if ( isset( $recipe['notes'] ) )	{ $sanitized_recipe['notes'] = self::sanitize_html( $recipe['notes'] ); }

		// Number fields.
		if ( isset( $recipe['image_id'] ) )		{ $sanitized_recipe['image_id'] = intval( $recipe['image_id'] ); }
		if ( isset( $recipe['pin_image_id'] ) ) { $sanitized_recipe['pin_image_id'] = intval( $recipe['pin_image_id'] ); }
		if ( isset( $recipe['video_id'] ) ) 	{ $sanitized_recipe['video_id'] = intval( $recipe['video_id'] ); }
		if ( isset( $recipe['servings'] ) ) 	{ $sanitized_recipe['servings'] = intval( $recipe['servings'] ); }
		if ( isset( $recipe['prep_time'] ) ) 	{ $sanitized_recipe['prep_time'] = intval( $recipe['prep_time'] ); }
		if ( isset( $recipe['cook_time'] ) ) 	{ $sanitized_recipe['cook_time'] = intval( $recipe['cook_time'] ); }
		if ( isset( $recipe['total_time'] ) ) 	{ $sanitized_recipe['total_time'] = intval( $recipe['total_time'] ); }
		if ( isset( $recipe['custom_time'] ) ) 	{ $sanitized_recipe['custom_time'] = intval( $recipe['custom_time'] ); }

		// Limited options fields.
		$options = array( 'food', 'howto', 'other' );
		if ( isset( $recipe['type'] ) && in_array( $recipe['type'], $options, true ) ) {
			$sanitized_recipe['type'] = $recipe['type'];
		}

		$options = array( 'default', 'disabled', 'post_author', 'custom' );
		if ( isset( $recipe['author_display'] ) && in_array( $recipe['author_display'], $options, true ) ) {
			$sanitized_recipe['author_display'] = $recipe['author_display'];
		}

		$options = array( 'global', 'custom' );
		if ( isset( $recipe['ingredient_links_type'] ) && in_array( $recipe['ingredient_links_type'], $options, true ) ) {
			$sanitized_recipe['ingredient_links_type'] = $recipe['ingredient_links_type'];
		}

		// Recipe Tags.
		if ( isset( $recipe['tags'] ) ) {
			$sanitized_recipe['tags'] = array();
			$taxonomies = WPRM_Taxonomies::get_taxonomies();
			foreach ( $taxonomies as $taxonomy => $options ) {
				$key = substr( $taxonomy, 5 ); // Get rid of wprm_.
				$sanitized_recipe['tags'][ $key ] = isset( $recipe['tags'] ) && isset( $recipe['tags'][ $key ] ) && $recipe['tags'][ $key ] ? array_map( array( __CLASS__, 'sanitize_tags' ), $recipe['tags'][ $key ] ) : array();
			}
		}

		// Recipe Equipment.
		if ( isset( $recipe['equipment'] ) ) {
			$sanitized_recipe['equipment'] = array();

			foreach ( $recipe['equipment'] as $equipment ) {
				$name = isset( $equipment['name'] ) ? self::sanitize_html( $equipment['name'] ) : '';

				if ( $name ) {
					$sanitized_recipe['equipment'][] = array(
						'id' => self::get_equipment_id( $name ),
						'name' => $name,
					);
				}
			}
		}

		// Recipe Ingredients.
		if ( isset( $recipe['ingredients'] ) || isset( $recipe['ingredients_flat'] ) ) {
			$sanitized_recipe['ingredients'] = array();
			$ingredients = isset( $recipe['ingredients'] ) ? $recipe['ingredients'] : array();

			// Use ingredients_flat if set.
			if ( isset( $recipe['ingredients_flat'] ) ) {
				$ingredients = self::unflatten( 'ingredients', $recipe['ingredients_flat'] );
			}

			foreach ( $ingredients as $ingredient_group ) {
				$sanitized_group = array(
					'ingredients' => array(),
					'name' => isset( $ingredient_group['name'] ) ? self::sanitize_html( $ingredient_group['name'] ) : '',
				);

				if ( isset( $ingredient_group['ingredients'] ) ) {
					foreach ( $ingredient_group['ingredients'] as $ingredient ) {
						if ( isset( $ingredient['raw'] ) && ! isset( $ingredient['name'] ) ) {
							$ingredient = array_replace( $ingredient, WPRM_Recipe_Parser::parse_ingredient( $ingredient['raw'] ) );
						}

						$sanitized_ingredient = array(
							'amount' => isset( $ingredient['amount'] ) ? self::sanitize_html( $ingredient['amount'] ) : '',
							'unit' => isset( $ingredient['unit'] ) ? self::sanitize_html( $ingredient['unit'] ) : '',
							'name' => isset( $ingredient['name'] ) ? self::sanitize_html( $ingredient['name'] ) : '',
							'notes' => isset( $ingredient['notes'] ) ? self::sanitize_html( $ingredient['notes'] ) : '',
						);

						// Custom ingredient link.
						if ( isset( $ingredient['link'] ) ) {
							$sanitized_ingredient['link'] = array(
								'url' => isset( $ingredient['link']['url'] ) ? sanitize_text_field( $ingredient['link']['url'] ) : '',
								'nofollow' => isset( $ingredient['link']['nofollow'] ) ? sanitize_text_field( $ingredient['link']['nofollow'] ) : 'default',
							);
						}

						// Unit Conversion.
						if ( isset( $ingredient['converted'] ) ) {
							$sanitized_ingredient['converted'] = array();

							foreach ( $ingredient['converted'] as $system => $conversion ) {
								$sanitized_ingredient['converted'][ $system ] = array(
									'amount' => self::sanitize_html( $conversion['amount'] ),
									'unit' => self::sanitize_html( $conversion['unit'] ),
								);
							}
						}

						if ( $sanitized_ingredient['name'] ) {
							$sanitized_ingredient['id'] = self::get_ingredient_id( $sanitized_ingredient['name'] );
							$sanitized_group['ingredients'][] = $sanitized_ingredient;
						}
					}
				}

				if ( $sanitized_group['name'] || count( $sanitized_group['ingredients'] ) > 0 ) {
						$sanitized_recipe['ingredients'][] = $sanitized_group;
				}
			}
		}

		// Recipe Instructions.
		if ( isset( $recipe['instructions'] ) || isset( $recipe['instructions_flat'] ) ) {
			$sanitized_recipe['instructions'] = array();
			$instructions = isset( $recipe['instructions'] ) ? $recipe['instructions'] : array();

			// Use ingredients_flat if set.
			if ( isset( $recipe['instructions_flat'] ) ) {
				$instructions = self::unflatten( 'instructions', $recipe['instructions_flat'] );
			}

			foreach ( $instructions as $instruction_group ) {
				$sanitized_group = array(
					'instructions' => array(),
					'name' => isset( $instruction_group['name'] ) ? self::sanitize_html( $instruction_group['name'] ) : '',
				);

				if ( isset( $instruction_group['instructions'] ) ) {
					foreach ( $instruction_group['instructions'] as $instruction ) {
						$sanitized_instruction = array(
							'text' => isset( $instruction['text'] ) ? self::sanitize_html( $instruction['text'] ) : '',
							'image' => isset( $instruction['image'] ) ? intval( $instruction['image'] ) : 0,
						);

						if ( $sanitized_instruction['text'] || $sanitized_instruction['image'] ) {
							$sanitized_group['instructions'][] = $sanitized_instruction;
						}
					}
				}

				if ( $sanitized_group['name'] || count( $sanitized_group['instructions'] ) > 0 ) {
						$sanitized_recipe['instructions'][] = $sanitized_group;
				}
			}
		}

		// Recipe Nutrition.
		if ( isset( $recipe['nutrition'] ) ) {
			$sanitized_recipe['nutrition'] = array();

			foreach ( $recipe['nutrition'] as $nutrition_field => $nutrition_value ) {
				$nutritition_value = trim( $nutrition_value );
				$sanitized_recipe['nutrition'][ $nutrition_field ] = '' !== $nutritition_value ? floatval( str_replace( ',', '.', $nutritition_value ) ) : false;
			}

			$sanitized_recipe['nutrition']['serving_unit'] = isset( $recipe['nutrition']['serving_unit'] ) && '' !== trim( $recipe['nutrition']['serving_unit'] ) ? sanitize_text_field( $recipe['nutrition']['serving_unit'] ) : false;
		}

		// Other fields.
		if ( isset( $recipe['import_source'] ) ) { $sanitized_recipe['import_source'] = sanitize_text_field( $recipe['import_source'] ); }
		if ( isset( $recipe['import_backup'] ) ) { $sanitized_recipe['import_backup'] = $recipe['import_backup']; }

		return apply_filters( 'wprm_recipe_sanitize', $sanitized_recipe, $recipe );
	}

	/**
	 * Get ingredient ID from its name.
	 *
	 * @since	5.1.0
	 * @param	mixed $name Name of the ingredient.
	 */
	public static function get_ingredient_id( $name ) {
		return self::get_term_id_by_name( 'wprm_ingredient', $name );
	}

	/**
	 * Get equipment ID from its name.
	 *
	 * @since	5.2.0
	 * @param	mixed $name Name of the equipment.
	 */
	public static function get_equipment_id( $name ) {
		return self::get_term_id_by_name( 'wprm_equipment', $name );
	}

	/**
	 * Get term ID from its name.
	 *
	 * @since	5.2.0
	 * @param	mixed $taxonomy Taxonomy to search.
	 * @param	mixed $name 	Name of the term.
	 */
	public static function get_term_id_by_name( $taxonomy, $name ) {
		$id = 0;

		// Make sure name is sanitized.
		$name = self::sanitize_html( $name );

		if ( $name ) {
			$term = term_exists( $name, $taxonomy ); // @codingStandardsIgnoreLine

			if ( 0 === $term || null === $term ) {
				$term = wp_insert_term( $name, $taxonomy );
			}

			if ( is_wp_error( $term ) ) {
				if ( isset( $term->error_data['term_exists'] ) ) {
					$term_id = $term->error_data['term_exists'];
				} else {
					$term_id = 0;
				}
			} else {
				$term_id = $term['term_id'];
			}

			$id = intval( $term_id );
		}

		return $id;
	}

	/**
	 * Sanitize recipe tags.
	 *
	 * @since    1.0.0
	 * @param		 mixed $tag Tag ID or new tag name.
	 */
	public static function sanitize_tags( $tag ) {
		if ( is_array( $tag ) || is_object( $tag ) ) {
			$tag = (array) $tag;

			if ( ! is_string( $tag['term_id'] ) && is_numeric( $tag['term_id'] ) ) {
				return intval( $tag['term_id'] );
			} else {
				return sanitize_text_field( $tag['term_id'] );
			}
		} elseif ( is_numeric( $tag ) ) {
			return intval( $tag );
		} else {
			return sanitize_text_field( $tag );
		}
	}

	/**
	 * Unflatten ingredients or instructions.
	 *
	 * @since	5.0.0
	 * @param	string $type Type we're unflattening.
	 * @param	mixed  $flat Flat array.
	 */
	public static function unflatten( $type, $flat ) {
		$unflattened = array();

		// Start with an empty group.
		$group = array(
			'name' => '',
		);
		$group[ $type ] = array();

		foreach ( $flat as $index => $item ) {
			if ( 'group' === $item['type'] ) {
				// Add previous group.
				if ( 0 !== $index ) {
					$unflattened[] = $group;
				}
				
				// New group.
				$group = array(
					'name' => $item['name'],
				);
				$group[ $type ] = array();
			} else {
				// Instruction or ingredient.
				$group[ $type ][] = $item;
			}
		}

		// Add last group.
		$unflattened[] = $group;

		return $unflattened;
	}

	/**
	 * Sanitize HTML content.
	 *
	 * @since   1.0.0
	 * @param	mixed $text Text to sanitize.
	 */
	public static function sanitize_html( $text ) {
		$allowed_tags = wp_kses_allowed_html( 'post' );
		$allowed_tags['wprm-code'] = true;

		// Allow more when user can edit posts to prevent abuse from User Submissions form.
		if ( current_user_can( 'edit_posts' ) ) {
			$allowed_tags['iframe'] = array(
				'src'             => array(),
				'height'          => array(),
				'width'           => array(),
				'frameborder'     => array(),
				'allowfullscreen' => array(),
			);

			$allowed_tags['script'] = array(
				'src'             => array(),
				'height'          => array(),
				'width'           => array(),
			);

			// Specific data attributes.
			$allowed_tags['a']['data-optimize-leads-uid'] = true;
		}

		// Remove blank lines from HTML.
		$text = str_replace( '<p></p>', '', $text );
		$text = str_replace( '<p><br></p>', '', $text );
		$text = str_replace( '<p><br/></p>', '', $text );

		// WPRM Code in rich text.
		preg_match_all( '/<wprm-code>(.*?)<\/wprm-code>/m', $text, $matches );
		foreach ( $matches[1] as $key => $match ) {
			$code = html_entity_decode( $match );
			$text = str_replace( $match, $code, $text );
		}

		return wp_kses( $text, $allowed_tags );
	}
}
