<?php
/**
 * Represents a recipe.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Represents a recipe.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Recipe {

	/**
	 * WP_Post object associated with this recipe post type.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $post    WP_Post object of this recipe post type.
	 */
	private $post;

	/**
	 * Metadata associated with this recipe post type.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $meta    Recipe metadata.
	 */
	private $meta = false;

	/**
	 * Get new recipe object from associated post.
	 *
	 * @since    1.0.0
	 * @param		 object $post WP_Post object for this recipe post type.
	 */
	public function __construct( $post ) {
		$this->post = $post;
	}

	/**
	 * Get recipe data.
	 *
	 * @since    1.0.0
	 */
	public function get_data() {
		$recipe = array();

		// Technical Fields.
		$recipe['id'] = $this->id();

		// Recipe Details.
		$recipe['type'] = $this->type();
		$recipe['image_id'] = $this->image_id();
		$recipe['image_url'] = $this->image_url( array( 150, 999 ) );
		$recipe['pin_image_id'] = $this->pin_image_id( true );
		$recipe['pin_image_url'] = $this->pin_image_url( array( 150, 999 ) );
		$recipe['name'] = $this->name();
		$recipe['summary'] = str_ireplace( '<br>', '<br/>', $this->summary() ); // Otherwise new editor detects change.

		$recipe['author_display'] = $this->author_display( true );
		$recipe['author_name'] = $this->custom_author_name();
		$recipe['author_link'] = $this->custom_author_link();
		$recipe['cost'] = $this->cost();
		$recipe['servings'] = $this->servings();
		$recipe['servings_unit'] = $this->servings_unit();
		$recipe['prep_time'] = $this->prep_time();
		$recipe['prep_time_zero'] = $this->prep_time_zero();
		$recipe['cook_time'] = $this->cook_time();
		$recipe['cook_time_zero'] = $this->cook_time_zero();
		$recipe['total_time'] = $this->total_time();
		$recipe['custom_time'] = $this->custom_time();
		$recipe['custom_time_zero'] = $this->custom_time_zero();
		$recipe['custom_time_label'] = $this->custom_time_label();

		$recipe['tags'] = array();
		$taxonomies = WPRM_Taxonomies::get_taxonomies();
		foreach ( $taxonomies as $taxonomy => $options ) {
			$key = substr( $taxonomy, 5 ); // Get rid of wprm_.
			$recipe['tags'][ $key ] = $this->tags( $key );
		}

		$recipe['equipment'] = $this->equipment();

		// Ingredients & Instructions.
		$recipe['ingredients'] = $this->ingredients();
		$recipe['instructions'] = $this->instructions();

		$recipe['ingredients_flat'] = $this->ingredients_flat();
		$recipe['instructions_flat'] = $this->instructions_flat();

		// Recipe Notes.
		$recipe['video_id'] = $this->video_id();
		$recipe['video_embed'] = $this->video_embed();
		$recipe['video_thumb_url'] = $this->video_thumb_url();
		$recipe['notes'] = $this->notes();

		// Recipe Nutrition.
		$recipe['nutrition'] = $this->nutrition();

		// Custom Fields.
		$recipe['custom_fields'] = $this->custom_fields();

		// Other fields.
		$recipe['ingredient_links_type'] = $this->ingredient_links_type();

		return $recipe;
	}

	/**
	 * Get recipe data for the manage page.
	 *
	 * @since    4.1.0
	 */
	public function get_data_manage() {
		$recipe = $this->get_data();

		$recipe['date'] = $this->date();
		$recipe['post_status'] = $this->post_status();
		$recipe['seo'] = WPRM_Seo_Checker::check_recipe( $this );
		$recipe['rating'] = WPRM_Rating::get_ratings_summary_for( $this->id() );

		// Parent Post.
		$recipe['parent_post_id'] = $this->parent_post_id();
		$recipe['parent_post'] = $this->parent_post();
		$recipe['parent_post_edit_url'] = $this->parent_edit_url();

		// Authors.
		$recipe['author'] = $this->author();
		$recipe['post_author'] = $this->post_author();
		$recipe['post_author_name'] = $this->post_author_name();
		$recipe['post_author_link'] = $this->post_author() ? get_edit_user_link( $this->post_author() ) : '';

		// Unit Conversion.
		$recipe['unit_conversion'] = __( 'n/a', 'wp-recipe-maker' );
		
		// Submission Author.
		$recipe['submission_author'] = $this->submission_author();
		if ( $recipe['submission_author'] && isset( $recipe['submission_author']['id'] ) && $recipe['submission_author']['id'] ) {
			$recipe['submission_author_user_link'] = get_edit_user_link( $recipe['submission_author']['id'] );

			$userdata = get_userdata( $recipe['submission_author']['id'] );
			if ( $userdata ) {
				$recipe['submission_author_user_name'] = $userdata->display_name;	
			}
		}

		return apply_filters( 'wprm_recipe_manage_data', $recipe, $this );
	}

	/**
	 * Get metadata value.
	 *
	 * @since    1.0.0
	 * @param		 mixed $field		Metadata field to retrieve.
	 * @param		 mixed $default	Default to return if metadata is not set.
	 */
	public function meta( $field, $default ) {
		if ( ! $this->meta ) {
			$this->meta = get_post_custom( $this->id() );
		}

		if ( isset( $this->meta[ $field ] ) ) {
			return $this->meta[ $field ][0];
		}

		return $default;
	}

	/**
	 * Try to unserialize as best as possible.
	 *
	 * @since    1.22.0
	 * @param	 mixed $maybe_serialized Potentially serialized data.
	 */
	public function unserialize( $maybe_serialized ) {
		$unserialized = @maybe_unserialize( $maybe_serialized );

		if ( false === $unserialized ) {
			$maybe_serialized = preg_replace('/\s+/', ' ', $maybe_serialized );
			$unserialized = unserialize( preg_replace_callback( '!s:(\d+):"(.*?)";!', array( $this, 'regex_replace_serialize' ), $maybe_serialized ) );
		}

		return $unserialized;
	}

	/**
	 * Callback for regex to fix serialize issues.
	 *
	 * @since    1.20.0
	 * @param	 mixed $match Regex match.
	 */
	public function regex_replace_serialize( $match ) {
		return ( $match[1] == strlen( $match[2] ) ) ? $match[0] : 's:' . strlen( $match[2] ) . ':"' . $match[2] . '";';
	}

	/**
	 * Get the recipe author.
	 *
	 * @since    1.0.0
	 */
	public function author() {
		$author = '';

		switch ( $this->author_display() ) {
			case 'post_author':
				$author = $this->post_author_name();
				break;
			case 'custom':
				$author = $this->custom_author_name();
				break;
			case 'same':
				$author = WPRM_Settings::get( 'recipe_author_same_name' );
				break;
		}

		return apply_filters( 'wprm_recipe_author', $author, $this );
	}

	/**
	 * Get the recipe author display option.
	 *
	 * @since    1.5.0
	 * @param    boolean $keep_default Wether to replace the default value with the actual one.
	 */
	public function author_display( $keep_default = false ) {
		$default_author_display = WPRM_Settings::get( 'recipe_author_display_default' );

		if ( 'same' === $default_author_display ) {
			return $default_author_display;
		}
		
		// If not forced to "same", use value set for recipe.
		$author_display = $this->meta( 'wprm_author_display', 'default' );

		if ( ! $keep_default && 'default' === $author_display ) {
			$author_display = $default_author_display;
		}

		return $author_display;
	}

	/**
	 * Get the recipe author to use in the metadata.
	 *
	 * @since    1.5.0
	 */
	public function author_meta() {
		switch ( $this->author_display() ) {
			case 'custom':
				return $this->custom_author_name();
			case 'same':
				$name = WPRM_Settings::get( 'recipe_author_same_name' );

				if ( $name ) {
					return $name;
				}
				// Fall back to author name otherwise.
			default:
				return $this->post_author_name();
		}
	}

	/**
	 * Get the recipe custom author name.
	 *
	 * @since    1.5.0
	 */
	public function custom_author_name() {
		return $this->meta( 'wprm_author_name', '' );
	}

	/**
	 * Get the recipe custom author link.
	 *
	 * @since    1.20.0
	 */
	public function custom_author_link() {
		return $this->meta( 'wprm_author_link', '' );
	}

	/**
	 * Get the recipe post author.
	 *
	 * @since    5.0.0
	 */
	public function post_author() {
		return $this->post->post_author;
	}

	/**
	 * Get the recipe post author name.
	 *
	 * @since    1.5.0
	 */
	public function post_author_name() {
		$author_id = $this->post_author();

		if ( $author_id ) {
			$author = get_userdata( $author_id );
			return $author->data->display_name;
		} else {
			return '';
		}
	}

	/**
	 * Get the recipe submission author.
	 *
	 * @since	5.0.0
	 */
	public function submission_author() {
		return self::unserialize( $this->meta( 'wprm_submission_user', array() ) );
	}

	/**
	 * Get the recipe calories.
	 *
	 * @since    1.0.0
	 */
	public function calories() {
		$nutrition = $this->nutrition();
		return isset( $nutrition['calories'] ) ? $nutrition['calories'] : false;
	}

	/**
	 * Get the recipe cost.
	 *
	 * @since    5.2.0
	 */
	public function cost() {
		return $this->meta( 'wprm_cost', '' );
	}

	/**
	 * Get a recipe custom field.
	 *
	 * @since    5.2.0
	 */
	public function custom_field( $field ) {
		return apply_filters( 'wprm_recipe_custom_field', '', $field, $this );
	}

	/**
	 * Get the recipe custom fields.
	 *
	 * @since    5.2.0
	 */
	public function custom_fields() {
		return apply_filters( 'wprm_recipe_custom_fields', array(), $this );
	}

	/**
	 * Get the recipe publish date.
	 *
	 * @since    1.0.0
	 */
	public function date() {
		return $this->post->post_date;
	}

	/**
	 * Get the recipe modified date.
	 *
	 * @since    4.0.0
	 */
	public function date_modified() {
		return $this->post->post_modified;
	}

	/**
	 * Get the recipe ID.
	 *
	 * @since    1.0.0
	 */
	public function id() {
		return $this->post->ID;
	}

	/**
	 * Get the recipe type.
	 *
	 * @since    2.4.0
	 */
	public function type() {
		$type = $this->meta( 'wprm_type', 'food' );
		$type = 'non-food' === $type ? 'other' : $type; // Use "other" instead of "non-food" as of 4.0.3.

		return $type;
	}

	/**
	 * Get the recipe image HTML.
	 *
	 * @since	1.0.0
	 * @param	mixed $size Thumbnail name or size array of the image we want.
	 */
	public function image( $size = 'thumbnail' ) {
		$img = wp_get_attachment_image( $this->image_id(), $size );

		// Prevent stretching of recipe image in Gutenberg Preview.
		if ( isset( $GLOBALS['wp']->query_vars['rest_route'] ) && '/wp/v2/block-renderer/wp-recipe-maker/recipe' === $GLOBALS['wp']->query_vars['rest_route'] ) {
			$image_data = $this->image_data( $size );
			if ( $image_data[1] ) {
				$style = 'max-width: ' . $image_data[1] . 'px; height: auto;';

				if ( false !== stripos( $img, ' style="' ) ) {
					$img = str_ireplace( ' style="', ' style="' . $style, $img );
				} else {
					$img = str_ireplace( '<img ', '<img style="' . $style . '" ', $img );
				}
			}
		}

		// Disable recipe image pinning.
		if ( WPRM_Settings::get( 'pinterest_nopin_recipe_image' ) ) {
			$img = str_ireplace( '<img ', '<img data-pin-nopin="true" ', $img );
		}

		// Clickable images.
		if ( WPRM_Settings::get( 'recipe_image_clickable' ) ) {
			$settings_size = WPRM_Settings::get( 'clickable_image_size' );

			preg_match( '/^(\d+)x(\d+)$/i', $settings_size, $match );
			if ( ! empty( $match ) ) {
				$size = array( intval( $match[1] ), intval( $match[2] ) );
			} else {
				$size = $settings_size;
			}

			$clickable_image_url = $this->image_url( $size );
			if ( $clickable_image_url ) {
				$img = '<a href="' . esc_url( $clickable_image_url ) . '">' . $img . '</a>';
			}
		}

		return $img;
	}

	/**
	 * Get the recipe image data.
	 *
	 * @since    1.2.0
	 * @param		 mixed $size Thumbnail name or size array of the image we want.
	 */
	public function image_data( $size = 'thumbnail' ) {
		$thumb = false;

		if ( function_exists( 'fly_get_attachment_image_src' ) ) {
			$thumb = fly_get_attachment_image_src( $this->image_id(), $size );
		}

		if ( ! $thumb ) {
			$thumb = wp_get_attachment_image_src( $this->image_id(), $size );
		}

		return $thumb;
	}

	/**
	 * Get the recipe image ID.
	 *
	 * @since    1.0.0
	 */
	public function image_id() {
		$image_id = get_post_thumbnail_id( $this->id() );
		if ( ! $image_id ) {
			$image_id = 0;

			if ( WPRM_Settings::get( 'recipe_image_use_featured' ) ) {
				$parent_image_id = get_post_thumbnail_id( $this->parent_post_id() );

				if ( $parent_image_id ) {
					$image_id = $parent_image_id;
				}
			}
		}
		return $image_id;
	}

	/**
	 * Get the recipe image URL.
	 *
	 * @since    1.0.0
	 * @param		 mixed $size Thumbnail name or size array of the image we want.
	 */
	public function image_url( $size = 'thumbnail' ) {
		$image_url = '';

		if ( function_exists( 'fly_get_attachment_image_src' ) ) {
			$thumb = fly_get_attachment_image_src( $this->image_id(), $size );

			if ( $thumb ) {
				$image_url = isset( $thumb[0] ) ? $thumb[0] : $thumb['src'];
			}
		}

		if ( ! $image_url ) {
			$thumb = wp_get_attachment_image_src( $this->image_id(), $size );
			$image_url = $thumb && isset( $thumb[0] ) ? $thumb[0] : '';
		}

		return $image_url;
	}

	/**
	 * Get the recipe pin image ID.
	 *
	 * @since	4.0.0
	 * @param   boolean $for_editing Wether or not we're retrieving the value for editing.
	 */
	public function pin_image_id( $for_editing = false ) {
		$image_id = '';

		switch ( WPRM_Settings::get( 'pinterest_use_for_image' ) ) {
			case 'recipe_image':
				$image_id = $this->image_id();
				break;
			case 'custom_or_recipe_image':
				if ( ! $for_editing ) {
					$image_id = $this->image_id();
				}
				break;
		}

		return apply_filters( 'wprm_recipe_pin_image_id', $image_id, $for_editing, $this );
	}

	/**
	 * Get the recipe pin image url.
	 *
	 * @since	4.0.0
	 * @param	mixed $size Thumbnail name or size array of the image we want.
	 */
	public function pin_image_url( $size = 'full' ) {
		$pin_image_url = '';

		if ( ! $this->pin_image_id() ) {
			return $pin_image_url;
		}

		if ( function_exists( 'fly_get_attachment_image_src' ) ) {
			$thumb = fly_get_attachment_image_src( $this->pin_image_id(), $size );

			if ( $thumb ) {
				$pin_image_url = isset( $thumb[0] ) ? $thumb[0] : $thumb['src'];
			}
		}

		if ( ! $pin_image_url ) {
			$thumb = wp_get_attachment_image_src( $this->pin_image_id(), $size );
			$pin_image_url = $thumb && isset( $thumb[0] ) ? $thumb[0] : '';
		}

		return $pin_image_url;
	}

	/**
	 * Get the recipe pin image url.
	 *
	 * @since	4.0.0
	 */
	public function pin_image_description() {
		$description = '';

		switch ( WPRM_Settings::get( 'pinterest_use_for_description' ) ) {
			case 'recipe_name':
				$description = $this->name();
				break;
			case 'recipe_summary':
				$description = $this->summary();
				break;
			case 'image_title':
				$description = get_the_title( $this->pin_image_id() );
				break;
			case 'image_caption':
				$description = get_the_excerpt( $this->pin_image_id() );
				break;
			case 'image_description':
				$image = get_post( $this->pin_image_id() );
				if ( $image ) {
					$description = $image->post_content;
				}
				break;
			case 'custom':
				$description = WPRM_Settings::get( 'pinterest_custom_description' );
				$description = str_ireplace( '%recipe_name%', $this->name(), $description );
				$description = str_ireplace( '%recipe_summary%', $this->summary(), $description );
				break;
		}

		return wp_strip_all_tags( $description );
	}

	/**
	 * Get the recipe post status date.
	 *
	 * @since    4.2.0
	 */
	public function post_status() {
		return $this->post->post_status;
	}

	/**
	 * Get the recipe video.
	 *
	 * @since    2.5.0
	 */
	public function video() {
		$output = '';
		if ( $this->video_id() ) {
			$video_data = $this->video_data();
			$output = '[video';
			$output .= ' width="' . $video_data['width'] . '"';
			$output .= ' height="' . $video_data['height'] . '"';

			$format = isset( $video_data['fileformat'] ) && $video_data['fileformat'] ? $video_data['fileformat'] : 'mp4';
			$output .= ' ' . $format . '="' . $this->video_url() . '"';

			$thumb_size = array( $video_data['width'], $video_data['height'] );
			$thumb_url = $this->video_thumb_url( $thumb_size );

			if ( $thumb_url ) {
				$output .= ' poster="' . $thumb_url . '"';
			}

			$output .= '][/video]';
		} elseif ( $this->video_embed() ) {
			$embed_code = $this->video_embed();

			// Check if it's a regular URL.
			$url = filter_var( $embed_code, FILTER_SANITIZE_URL );

			if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
				global $wp_embed;

				if ( isset( $wp_embed ) ) {
					$output = $wp_embed->run_shortcode( '[embed]' . $url . '[/embed]' );
				}
			} else {
				$output = $embed_code;
			}
		}

		return $output;
	}

	/**
	 * Get the recipe video embed code.
	 *
	 * @since    2.5.1
	 */
	public function video_embed() {
		return $this->meta( 'wprm_video_embed', '' );
	}

	/**
	 * Get the recipe video ID.
	 *
	 * @since    2.5.0
	 */
	public function video_id() {
		return max( array( intval( $this->meta( 'wprm_video_id', 0 ) ), 0 ) ); // Make sure to return 0 when set to -1.
	}

	/**
	 * Get the recipe video URL.
	 *
	 * @since    2.5.0
	 */
	public function video_url() {
		return wp_get_attachment_url( $this->video_id() );
	}

	/**
	 * Get the recipe video data.
	 *
	 * @since    2.5.0
	 */
	public function video_data() {
		return wp_get_attachment_metadata( $this->video_id() );
	}

	/**
	 * Get the recipe video thumb url.
	 *
	 * @since    2.5.0
	 */
	public function video_thumb_url( $size = 'thumbnail' ) {
		$image_id = get_post_thumbnail_id( $this->video_id() );
		$image_url = '';

		if ( function_exists( 'fly_get_attachment_image_src' ) ) {
			$thumb = fly_get_attachment_image_src( $image_id, $size );

			if ( $thumb ) {
				$image_url = isset( $thumb[0] ) ? $thumb[0] : $thumb['src'];
			}
		}

		if ( ! $image_url ) {
			$thumb = wp_get_attachment_image_src( $image_id, $size );
			$image_url = $thumb && isset( $thumb[0] ) ? $thumb[0] : '';
		}

		return $image_url;
	}

	/**
	 * Get the recipe video metadata.
	 *
	 * @since    2.5.1
	 */
	public function video_metadata() {
		$metadata = self::unserialize( $this->meta( 'wprm_video_metadata', '' ) );
		$metadata_updated = intval( $this->meta( 'wprm_video_metadata_updated', '' ) );

		if ( ! $metadata || ( time() - $metadata_updated > 60 * 60 * 24 * 7 ) ) {
			$metadata = WPRM_MetadataVideo::get_video_metadata_for_recipe( $this );

			// Cache for reuse. Automatically cleared when resaving a recipe.
			if ( $metadata ) {
				// Clear oEmbed cache.
				global $wp_embed;
				$parent_post = $this->parent_post_id();

				if ( $parent_post && isset( $wp_embed ) ) {
					$wp_embed->delete_oembed_caches( $parent_post );
				}

				update_post_meta( $this->id(), 'wprm_video_metadata', $metadata );
				update_post_meta( $this->id(), 'wprm_video_metadata_updated', time() );
			}
		}

		return $metadata;
	}

	/**
	 * Get the recipe name.
	 *
	 * @since    1.0.0
	 */
	public function name() {
		return $this->post->post_title;
	}

	/**
	 * Get the recipe nutrition data.
	 *
	 * @since    1.0.0
	 */
	public function nutrition() {
		$deprecated_nutrition = $this->meta( 'wprm_nutrition', false );

		// Migration required after version 5.3.0.
		if ( false !== $deprecated_nutrition ) {
			// Migrate deprecated nutrition meta.
			$deprecated_nutrition = self::unserialize( $deprecated_nutrition );
			$meta = array();

			$migrate_values = array(
				'vitamin_a' => 5000,
				'vitamin_c' => 82.5,
				'calcium' => 1000,
				'iron' => 18,
			);

			foreach ( $deprecated_nutrition as $nutrient => $value ) {
				if ( false !== $value ) {

					if ( array_key_exists( $nutrient, $migrate_values ) ) {
						// Daily needs * currently saved as percentage, round to 1 decimal.
						$value = round( $migrate_values[ $nutrient ] * ( $value / 100 ), 1 );
					}

					// Save in post meta and emulate.
					update_post_meta( $this->id(), 'wprm_nutrition_' . $nutrient, $value );
					$meta[ 'wprm_nutrition_' . $nutrient ] = array( $value );
				}
			}

			// Delete old postmeta.
			delete_post_meta( $this->id(), 'wprm_nutrition' );
		} else {
			$meta = $this->meta;
		}

		// Get all meta that starts with wprm_nutrition_
		$keys = array_filter( array_keys( $meta ), function ( $key ) { return 'wprm_nutrition_' === substr( $key, 0, 15 ); } ); 
		$meta_nutrition = array_intersect_key( $meta, array_flip( $keys ) );

		// Drop wprm_nutrition_ from keys.
		$nutrition = array();
		foreach ( $meta_nutrition as $meta_key => $meta_value ) {
			$nutrient = substr( $meta_key, 15 );
			$value = $meta_value[0];

			if ( '' !== $value && false !== $value ) {
				$nutrition[ $nutrient ] = 'serving_unit' === $nutrient ? $value : floatval( $value );
			}
		}

		return apply_filters( 'wprm_recipe_nutrition', $nutrition );
	}

	/**
	 * Does the recipe have a rating?
	 *
	 * @since    1.6.0
	 */
	public function has_rating() {
		$rating = $this->rating();
		return $rating['count'] > 0;
	}

	/**
	 * Get the recipe rating.
	 *
	 * @since    1.1.0
	 */
	public function rating() {
		$rating = self::unserialize( $this->meta( 'wprm_rating', array() ) );

		// Recalculate if rating has not been set yet.
		if ( empty( $rating ) || ( 0 === $rating['count'] && is_singular() ) ) {
			$rating = WPRM_Rating::update_recipe_rating( $this->id() );
		}

		return apply_filters( 'wprm_recipe_rating', $rating, $this );
	}

	/**
	 * Get the recipe summary.
	 *
	 * @since    1.0.0
	 */
	public function summary() {
		return $this->post->post_content;
	}

	/**
	 * Get the recipe servings.
	 *
	 * @since    1.0.0
	 */
	public function servings() {
		return $this->meta( 'wprm_servings', 0 );
	}

	/**
	 * Get the recipe servings unit.
	 *
	 * @since    1.0.0
	 */
	public function servings_unit() {
		return $this->meta( 'wprm_servings_unit', '' );
	}

	/**
	 * Get the recipe prep time.
	 *
	 * @since    1.0.0
	 */
	public function prep_time() {
		return $this->meta( 'wprm_prep_time', 0 );
	}

	/**
	 * Does the prep time display with a 0 value.
	 *
	 * @since	 5.0.0
	 */
	public function prep_time_zero() {
		return $this->meta( 'wprm_prep_time_zero', false );
	}

	/**
	 * Get the recipe cook time.
	 *
	 * @since    1.0.0
	 */
	public function cook_time() {
		return $this->meta( 'wprm_cook_time', 0 );
	}

	/**
	 * Does the cook time display with a 0 value.
	 *
	 * @since	 5.0.0
	 */
	public function cook_time_zero() {
		return $this->meta( 'wprm_cook_time_zero', false );
	}

	/**
	 * Get the recipe total time.
	 *
	 * @since    1.0.0
	 */
	public function total_time() {
		return $this->meta( 'wprm_total_time', 0 );
	}

	/**
	 * Get the recipe custom time.
	 *
	 * @since    2.2.0
	 */
	public function custom_time() {
		return $this->meta( 'wprm_custom_time', 0 );
	}

	/**
	 * Does the custom time display with a 0 value.
	 *
	 * @since	 5.0.0
	 */
	public function custom_time_zero() {
		return $this->meta( 'wprm_custom_time_zero', false );
	}

	/**
	 * Get the recipe custom time label.
	 *
	 * @since    2.2.0
	 */
	public function custom_time_label() {
		return $this->meta( 'wprm_custom_time_label', '' );
	}

	/**
	 * Get the recipe tags for a certain tag type.
	 *
	 * @since    1.0.0
	 * @param		 mixed $taxonomy Taxonomy to get the tags for.
	 */
	public function tags( $taxonomy ) {
		$taxonomy = 'wprm_' . $taxonomy;
		$terms = get_the_terms( $this->id(), $taxonomy );

		return is_array( $terms ) ? $terms : array();
	}

	/**
	 * Get the template for this recipe.
	 *
	 * @since    1.0.0
	 * @param		 mixed $type Type of template to get, defaults to single.
	 */
	public function template( $type = 'single' ) {
		return WPRM_Template_Manager::get_template( $this, $type );
	}

	/**
	 * Check if a recipe is in a specific collection.
	 *
	 * @since	4.1.0
	 * @param	mixed $collection_id Collection to check.
	 */
	public function in_collection( $collection_id = 'inbox' ) {
		return apply_filters( 'wprm_recipe_in_collection', false, $collection_id, $this );
	}

	/**
	 * Get the recipe equipment.
	 *
	 * @since	5.2.0
	 */
	public function equipment() {
		$equipment_array = self::unserialize( $this->meta( 'wprm_equipment', array() ) );
		$terms = $this->tags( 'equipment' );

		$uid = 0;
		foreach ( $equipment_array as $index => $equipment ) {
			$equipment_array[ $index ]['uid'] = $uid;
			$uid++;

			$term_key = array_search( intval( $equipment['id'] ), wp_list_pluck( $terms, 'term_id' ) );
			
			if ( false !== $term_key ) {
				$term = $terms[ $term_key ];
				$equipment_array[ $index ]['name'] = $term->name;
			}
		}

		return $equipment_array;
	}

	/**
	 * Get the recipe ingredients.
	 *
	 * @since    1.0.0
	 */
	public function ingredients() {
		return self::unserialize( $this->meta( 'wprm_ingredients', array() ) );
	}

	/**
	 * Get the recipe ingredient links type.
	 *
	 * @since    1.14.1
	 */
	public function ingredient_links_type() {
		return $this->meta( 'wprm_ingredient_links_type', 'global' );
	}

	/**
	 * Get the recipe ingredients flat.
	 *
	 * @since	5.0.0
	 */
	public function ingredients_flat() {
		$ingredients = self::ingredients();

		$uid = 0;
		$ingredients_flat = array();

		foreach ( $ingredients as $group_index => $group ) {
			$group_ingredients = $group['ingredients'];

			if ( 0 !== $group_index || $group['name'] ) {
				$group['uid'] = $uid;
				$group['type'] = 'group';
				unset( $group['ingredients'] );

				$ingredients_flat[] = $group;
				$uid++;
			}

			foreach ( $group_ingredients as $index => $ingredient ) {
				$ingredient['uid'] = $uid;
				$ingredient['type'] = 'ingredient';

				$ingredients_flat[] = $ingredient;
				$uid++;
			}
		}

		return $ingredients_flat;
	}

	/**
	 * Get the recipe ingredients without nested groups.
	 *
	 * @since    1.0.0
	 */
	public function ingredients_without_groups() {
		$ingredients = $this->ingredients();
		$ingredients_without_groups = array();

		foreach ( $ingredients as $ingredient_group ) {
			$ingredients_without_groups = array_merge( $ingredients_without_groups, $ingredient_group['ingredients'] );
		}

		return $ingredients_without_groups;
	}

	/**
	 * Get the recipe instructions.
	 *
	 * @since    1.0.0
	 */
	public function instructions() {
		return self::unserialize( $this->meta( 'wprm_instructions', array() ) );
	}

	/**
	 * Get the recipe instructions flat.
	 *
	 * @since	5.0.0
	 */
	public function instructions_flat() {
		$instructions = self::instructions();

		$uid = 0;
		$instructions_flat = array();

		foreach ( $instructions as $group_index => $group ) {
			$group_instructions = $group['instructions'];

			if ( 0 !== $group_index || $group['name'] ) {
				$group['uid'] = $uid;
				$group['type'] = 'group';
				unset( $group['instructions'] );

				$instructions_flat[] = $group;
				$uid++;
			}

			foreach ( $group_instructions as $index => $instruction ) {
				// Include image for preview in modal.
				$image_url = '';
				if ( isset( $instruction['image'] ) && $instruction['image'] ) {
					$thumb = wp_get_attachment_image_src( $instruction['image'], array( 150, 999 ) );

					if ( $thumb && isset( $thumb[0] ) ) {
						$image_url = $thumb[0];
					}
				}

				$instruction['uid'] = $uid;
				$instruction['type'] = 'instruction';
				$instruction['image_url'] = $image_url;
				$instruction['text'] = str_ireplace( '<br>', '<br/>', $instruction['text'] ); // Otherwise new editor detects change.

				$instructions_flat[] = $instruction;
				$uid++;
			}
		}

		return $instructions_flat;
	}

	/**
	 * Get the recipe instructions without nested groups.
	 *
	 * @since    1.0.0
	 */
	public function instructions_without_groups() {
		$instructions = $this->instructions();
		$instructions_without_groups = array();

		foreach ( $instructions as $instruction_group ) {
			$instructions_without_groups = array_merge( $instructions_without_groups, $instruction_group['instructions'] );
		}

		return $instructions_without_groups;
	}

	/**
	 * Get the recipe notes.
	 *
	 * @since    1.0.0
	 */
	public function notes() {
		return wpautop( $this->meta( 'wprm_notes', '' ) );
	}

	/**
	 * Get the parent post.
	 *
	 * @since    4.1.0
	 */
	public function parent_post() {
		$parent_post_id = $this->parent_post_id();
		if ( $parent_post_id ) {
			return get_post( $parent_post_id );
		}
		return false;
	}

	/**
	 * Get the parent post ID.
	 *
	 * @since    1.0.0
	 */
	public function parent_post_id() {
		return $this->meta( 'wprm_parent_post_id', 0 );
	}

	/**
	 * Get the parent post URL.
	 *
	 * @since    1.16.0
	 */
	public function parent_url() {
		$parent_post_id = $this->parent_post_id();
		return $parent_post_id ? get_permalink( $parent_post_id ) : '';
	}

	/**
	 * Get the parent URL open in new tab preference.
	 *
	 * @since	5.4.2
	 */
	public function parent_url_new_tab() {
		return false;
	}
	
	/**
	 * Get the parent URL nofollow preference.
	 *
	 * @since	5.2.0
	 */
	public function parent_url_nofollow() {
		return false;
	}

	/**
	 * Get the parent post edit URL.
	 *
	 * @since    5.0.0
	 */
	public function parent_edit_url() {
		$parent_post_id = $this->parent_post_id();
		return $parent_post_id ? get_edit_post_link( $parent_post_id ) : '';
	}

	/**
	 * Get the recipe print URL.
	 *
	 * @since    2.1.0
	 */
	public function print_url() {
		if ( get_option( 'permalink_structure' ) ) {
			return home_url( '/wprm_print/' . $this->id() );
		} else {
			return home_url( '?wprm_print=' . $this->id() );
		}
	}

	// DEPRECATED.
	public function rating_stars( $show_details = false ) {
		return WPRM_Template_Helper::rating_stars( $this->rating(), $show_details );
	}
	public function prep_time_formatted( $shorthand = false ) {
		return WPRM_Template_Helper::time( 'prep_time', $this->prep_time(), $this->prep_time_zero(), $shorthand );
	}
	public function cook_time_formatted( $shorthand = false ) {
		return WPRM_Template_Helper::time( 'cook_time', $this->cook_time(), $this->cook_time_zero(), $shorthand );
	}
	public function total_time_formatted( $shorthand = false ) {
		return WPRM_Template_Helper::time( 'total_time', $this->total_time(), false, $shorthand );
	}
	public function custom_time_formatted( $shorthand = false ) {
		return WPRM_Template_Helper::time( 'custom_time', $this->custom_time(), $this->custom_time_zero(), $shorthand );
	}
}
