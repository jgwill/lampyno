<?php
/**
 * Represents a recipe that doesn't have an associated post.
 *
 * @link       http://bootstrapped.ventures
 * @since      5.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Represents a recipe that doesn't have an associated post.
 *
 * @since      5.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Recipe_Shell {

	/**
	 * Data associated with this recipe.
	 *
	 * @since    5.2.0
	 * @access   private
	 * @var      array    $data    Recipe data.
	 */
	private $data = array();

	/**
	 * Get new recipe object from associated post.
	 *
	 * @since	5.2.0
	 * @param	object $data mixed Data for this recipe.
	 */
	public function __construct( $data = array() ) {
		$defaults = array(
			'type' => 'food',
			'image_id' => 0,
			'image_url' => '',
			'pin_image_id' => 0,
			'pin_image_url' => '',
			'video_id' => 0,
			'video_embed' => '',
			'video_thumb_url' => '',
			'name' => '',
			'summary' => '',
			'author_display' => 'default',
			'author_name' => 'custom' === WPRM_Settings::get( 'recipe_author_display_default' ) ? WPRM_Settings::get( 'recipe_author_custom_default' ) : '',
			'author_link' => '',
			'servings' => 0,
			'servings_unit' => '',
			'cost' => '',
			'prep_time' => 0,
			'prep_time_zero' => false,
			'cook_time' => 0,
			'cook_time_zero' => false,
			'total_time' => 0,
			'custom_time' => 0,
			'custom_time_zero' => false,
			'custom_time_label' => '',
			'tags' => array(),
			'equipment' => array(),
			'ingredients' => array(),
			'ingredients_flat' => array(),
			'ingredient_links_type' => 'global',
			'instructions' => array(),
			'instructions_flat' => array(),
			'notes' => '',
			'nutrition' => array(),
			'custom_fields' => array(),
		);

		$this->data = array_merge( $defaults, $data );
	}

	/**
	 * Get recipe data.
	 *
	 * @since	5.2.0
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Get recipe data for the manage page.
	 *
	 * @since	5.2.0
	 */
	public function get_data_manage() {
		return $this->data;
	}

	/**
	 * Get metadata value.
	 *
	 * @since	5.2.0
	 * @param	mixed $field	Metadata field to retrieve.
	 * @param	mixed $default	Default to return if metadata is not set.
	 */
	public function meta( $field, $default ) {
		if ( isset( $this->data[ $field ] ) ) {
			return $this->data[ $field ];
		}

		return $default;
	}

	/**
	 * Get the recipe image HTML.
	 *
	 * @since	5.2.0
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

		// Disable external recipe image pinning.
		if ( WPRM_Settings::get( 'pinterest_nopin_external_roundup_image' ) ) {
			$img = str_ireplace( '<img ', '<img data-pin-nopin="true" ', $img );
		}

		// Clickable images.
		if ( WPRM_Settings::get( 'recipe_image_clickable' ) ) {
			$full_image_url = $this->image_url( 'full' );
			if ( $full_image_url ) {
				$img = '<a href="' . esc_url( $full_image_url) . '">' . $img . '</a>';
			}
		}

		return $img;
	}

	/**
	 * Get the recipe image data.
	 *
	 * @since	5.2.0
	 * @param	mixed $size Thumbnail name or size array of the image we want.
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
	 * Catch all other recipe function calls.
	 *
	 * @since	5.2.0
	 */
	public function __call( $name, $arguments ) {
		if ( isset( $this->data[ $name ] ) ) {
			return $this->data[ $name ];
		}

		return false;
	}
}
