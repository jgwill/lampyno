<?php

namespace Mediavine\Create;

use Mediavine\WordPress\Support\Str;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Plugin' ) ) {

	class JSON_LD extends Plugin {

		public static $schema_types = array(
			'diy'    => array(
				'type'       => 'HowTo',
				'properties' => array(
					'name'            => array(
						'type' => 'string',
						'map'  => 'title',
					),
					'author'          => 'author',
					'datePublished'   => array(
						'type' => 'date',
						'map'  => 'created',
					),
					'yield'           => 'string',
					'description'     => array(
						'type'  => 'string',
						'map'   => 'description',
						'flags' => array(
							'no_html' => true,
						),
					),
					'about'           => array(
						'type' => 'string',
						'map'  => 'secondary_term_name',
					),
					'image'           => array(
						'type' => 'image',
						'map'  => array(
							'haystack' => 'images',
							'needle'   => 'object_id',
							'size'     => 'image_size',
						),
					),
					'prepTime'        => array(
						'type'  => 'duration',
						'map'   => 'prep_time',
						'flags' => array(
							'force' => true,
						),
					),
					// Hooked by Creations->additional_perform_time()
					// Hook used: mv_json_ld_value_prop_performTime
					'performTime'     => array(
						'type'  => 'duration',
						'map'   => 'active_time',
						'flags' => array(
							'force' => true,
						),
					),
					'totalTime'       => array(
						'type'  => 'duration',
						'map'   => 'total_time',
						'flags' => array(
							'force' => true,
						),
					),
					'tool'            => array(
						'type' => 'list',
						'map'  => array(
							'haystack'       => 'tools',
							'needle'         => 'original_text',
							'groups'         => true,
							'strip_brackets' => true,
						),
					),
					'supply'          => array(
						'type' => 'list',
						'map'  => array(
							'haystack'       => 'materials',
							'needle'         => 'original_text',
							'groups'         => true,
							'strip_brackets' => true,
						),
					),
					// Hooked by Creations->check_for_list_steps()
					// Hook used: mv_schema_types
					'step'            => array(
						'type' => 'step',
						'map'  => 'instructions',
					),
					'video'           => 'video',
					'keywords'        => 'string',
					'aggregateRating' => array(
						'type' => 'rating',
						'map'  => array(
							'ratingValue' => 'rating',
							'reviewCount' => 'rating_count',
						),
					),
					'url'             => array(
						'type'  => 'string',
						'map'   => 'canonical_post_id',
						'flags' => array(
							'get_permalink' => true,
						),
					),
				),
			),
			'recipe' => array(
				'type'       => 'Recipe',
				'properties' => array(
					'name'               => array(
						'type' => 'string',
						'map'  => 'title',
					),
					'author'             => 'author',
					'datePublished'      => array(
						'type' => 'date',
						'map'  => 'created',
					),
					'recipeYield'        => array(
						'type' => 'string',
						'map'  => 'yield',
					),
					'description'        => array(
						'type'  => 'string',
						'map'   => 'description',
						'flags' => array(
							'no_html' => true,
						),
					),
					'image'              => array(
						'type' => 'image',
						'map'  => array(
							'haystack' => 'images',
							'needle'   => 'object_id',
							'size'     => 'image_size',
						),
					),
					'recipeCategory'     => array(
						'type' => 'string',
						'map'  => 'category_name',
					),
					'recipeCuisine'      => array(
						'type' => 'string',
						'map'  => 'secondary_term_name',
					),
					'prepTime'           => array(
						'type'  => 'duration',
						'map'   => 'prep_time',
						'flags' => array(
							'force' => true,
						),
					),
					'cookTime'           => array(
						'type'  => 'duration',
						'map'   => 'active_time',
						'flags' => array(
							'force' => true,
						),
					),
					// Hooked by Creations->additional_perform_time()
					// Hook used: mv_json_ld_value_prop_performTime
					'performTime'        => array(
						'type'  => 'duration',
						'map'   => 'active_time',
						'flags' => array(
							'force' => true,
						),
					),
					'totalTime'          => array(
						'type'  => 'duration',
						'map'   => 'total_time',
						'flags' => array(
							'force' => true,
						),
					),
					'recipeIngredient'   => array(
						'type' => 'list',
						'map'  => array(
							'haystack'       => 'ingredients',
							'needle'         => 'original_text',
							'groups'         => true,
							'strip_brackets' => true,
						),
					),
					'recipeInstructions' => array(
						'type' => 'step',
						'map'  => 'instructions',
					),
					'external_video'     => 'video',
					'video'              => 'video',
					'keywords'           => 'string',
					'suitableForDiet'    => array(
						'type' => 'string',
						'map'  => 'suitable_for_diet',
					),
					'nutrition'          => 'nutrition',
					'aggregateRating'    => array(
						'type' => 'rating',
						'map'  => array(
							'ratingValue' => 'rating',
							'reviewCount' => 'rating_count',
						),
					),
					'url'                => array(
						'type'  => 'string',
						'map'   => 'canonical_post_id',
						'flags' => array(
							'get_permalink' => true,
						),
					),
				),
			),
			'list'   => array(
				'type'       => 'ItemList',
				'properties' => array(
					'name'            => array(
						'type' => 'string',
						'map'  => 'title',
					),
					'description'     => array(
						'type'  => 'string',
						'map'   => 'description',
						'flags' => array(
							'no_html' => true,
						),
					),
					'itemListElement' => array(
						'type' => 'item_list',
						'map'  => 'list_items',
					),
				),
			),
		);

		/**
		 * Runs the value through several filters, opening expansion possiblities
		 *
		 * @param  mixed $value Value to be filtered
		 * @param  string $schema_type type of schema (e.g. string, integer, time)
		 * @param  string $schema_prop property name of the schema item
		 * @param  array $json_ld The current build of the JSON-LD array
		 * @param  array $creation The full creation array for relationships
		 * @return mixed Value after filters run
		 */
		public static function filter_json_ld_value( $value, $schema_type, $schema_prop, $json_ld, $creation = array() ) {
			$value = apply_filters( 'mv_json_ld_value_', $value, $schema_type, $schema_prop, $json_ld, $creation );
			$value = apply_filters( 'mv_json_ld_value_type_' . $schema_type, $value, $schema_type, $schema_prop, $json_ld, $creation );
			$value = apply_filters( 'mv_json_ld_value_prop_' . $schema_prop, $value, $schema_type, $schema_prop, $json_ld, $creation );

			return $value;
		}

		public static function add_json_ld_type( $json_ld, $type, $schema_types ) {
			if ( ! array_key_exists( $type, $schema_types ) || empty( $schema_types[ $type ]['type'] ) ) {
				return false;
			}

			$json_ld['@type'] = $schema_types[ $type ]['type'];

			return $json_ld;
		}

		public static function add_json_ld_author( $json_ld, $value, $schema_prop, $creation, $flags = array() ) {
			$value = self::filter_json_ld_value( $value, 'author', $schema_prop, $json_ld, $creation );

			$json_ld[ $schema_prop ] = array(
				'@type' => 'Person',
				'name'  => $value,
			);

			return $json_ld;
		}

		public static function add_json_ld_date( $json_ld, $value, $schema_prop, $creation, $flags = array() ) {
			$value = self::filter_json_ld_value( $value, 'date', $schema_prop, $json_ld, $creation );
			$date  = strtotime( $value );

			if ( ! empty( $date ) ) {
				$date                    = date( 'Y-m-d', $date );
				$json_ld[ $schema_prop ] = $date;
			}

			return $json_ld;
		}

		public static function remove_html( $content ) {
			// Remove any new lines already in there
			$content = str_replace( "\n", '', $content );
			// Replace <br /> and lists with \n
			$content = str_replace( [ '<br />', '<br>', '<br/>', '</ol>', '</ul>', '</li>' ], "\n", $content );
			// Replace </p> with \n\n
			$content = str_replace( '</p>', "\n\n", $content );
			// Remove <p> and lists
			$content = str_replace( [ '<p>', '<ol>', '<ul>', '<li>' ], '', $content );
			// Remove shortcodes
			$content = strip_shortcodes( $content );
			// Remove remaining HTML
			$content = wp_strip_all_tags( $content );
			// Remove any trailing whitespace
			$content = rtrim( $content );

			return $content;
		}

		public static function strip_square_brackets( $content ) {
			$content = str_replace( [ '[', ']' ], '', $content );

			return $content;
		}

		// Parse times and get output
		public static function parse_seconds_to_times( $seconds ) {
			// Force seconds as in integer
			$seconds = (int) $seconds;

			// gmdate() doesn't play nice with days and years because of leap years
			$days  = floor( $seconds / 86400 );
			$years = floor( $days / 365 );
			if ( $years ) {
				$days = $days - $years * 365;
			}

			// Prep values
			$time_array = array(
				'original' => $seconds,
				'years'    => $years,
				'days'     => $days,
				'hours'    => (int) gmdate( 'H', $seconds ),
				'minutes'  => (int) gmdate( 'i', $seconds ),
				'seconds'  => (int) gmdate( 's', $seconds ),
			);

			return $time_array;
		}

		/**
		 * Builds the time into a duration format for schema
		 *
		 * @param array $time_array Array with the following 'years', 'days',
		 *                          'hours', 'minutes', and 'seconds'.
		 * @param array $added_arrays Array with more $time_arrays to be added
		 *                            to duration
		 * @return string Duration in required schema format
		 */
		public static function build_duration( $time_array, $added_arrays = null ) {
			// Make sure time array is built
			if ( ! is_array( $time_array ) ) {
				// Only return if there are no added arrays
				if ( ! $time_array && '0' !== $time_array && empty( $added_arrays ) ) {
					return null;
				}
				$time_array = self::parse_seconds_to_times( $time_array );
			}
			$durations      = array(
				'years',
				'days',
				'hours',
				'minutes',
				'seconds',
			);
			$date_durations = array(
				'Y' => 'years',
				'D' => 'days',
			);
			$time_durations = array(
				'H' => 'hours',
				'M' => 'minutes',
				'S' => 'seconds',
			);
			if ( is_array( $added_arrays ) ) {
				foreach ( $added_arrays as $added_array ) {
					// Make sure time array is built
					if ( ! is_array( $added_array ) ) {
						if ( ! $added_array ) {
							continue;
						}
						$added_array = self::parse_seconds_to_times( $added_array );
					}

					foreach ( $durations as $current_duration ) {
						// Create base time array if field missing
						if ( empty( $time_array[ $current_duration ] ) ) {
							$time_array[ $current_duration ] = 0;
						}
						// Add time to time array
						if ( ! empty( $added_array[ $current_duration ] ) ) {
							$time_array[ $current_duration ] = intval( $time_array[ $current_duration ] ) + intval( $added_array[ $current_duration ] );
						}
					}
				}

				if ( ! empty( $time_array['seconds'] ) && $time_array['seconds'] > 60 ) {
					$time_array['minutes'] = $time_array['minutes'] + floor( $time_array['seconds'] / 60 );
					$time_array['seconds'] = $time_array['seconds'] % 60;
				}
				if ( ! empty( $time_array['minutes'] ) && $time_array['minutes'] > 60 ) {
					$time_array['hours']   = $time_array['hours'] + floor( $time_array['minutes'] / 60 );
					$time_array['minutes'] = $time_array['minutes'] % 60;
				}
				if ( ! empty( $time_array['hours'] ) && $time_array['hours'] > 24 ) {
					$time_array['days']  = $time_array['days'] + floor( $time_array['hours'] / 24 );
					$time_array['hours'] = $time_array['hours'] % 24;
				}
				if ( ! empty( $time_array['days'] ) && $time_array['days'] > 365 ) {
					$time_array['years'] = $time_array['years'] + floor( $time_array['days'] / 365 );
					$time_array['days']  = $time_array['days'] % 365;
				}
			}

			$duration = 'P';
			foreach ( $date_durations as $abbr => $date_duration ) {
				if ( ! empty( $time_array[ $date_duration ] ) ) {
						$duration .= intval( $time_array[ $date_duration ] ) . $abbr;
				}
			}
			$duration .= 'T';
			foreach ( $time_durations as $abbr => $time_duration ) {
				if ( ! empty( $time_array[ $time_duration ] ) ) {
						$duration .= intval( $time_array[ $time_duration ] ) . $abbr;
				}
			}

			// Handle 0-y values
			if ( 'PT' === $duration ) {
				$duration .= '0S';
			}

			return $duration;
		}

		public static function add_json_ld_duration( $json_ld, $value, $schema_prop, $creation ) {
			$added_arrays = self::filter_json_ld_value( null, 'duration_arrays', $schema_prop, $json_ld, $creation );
			$value        = self::build_duration( $value, $added_arrays );
			$value        = self::filter_json_ld_value( $value, 'duration', $schema_prop, $json_ld, $creation );

			// We force flags on durations for some 0 values, but we don't want ot output any blank values
			if ( isset( $value ) ) {
				$json_ld[ $schema_prop ] = $value;
			}

			return $json_ld;
		}

		public static function add_json_ld_image( $json_ld, $value, $schema_prop, $map_info, $creation ) {
			$images          = array();
			$available_sizes = wp_list_pluck( $value, 'image_url', 'image_size' );

			foreach ( $value as $image ) {
				if ( empty( $image[ $map_info['needle'] ] ) && empty( $image[ $map_info['size'] ] ) ) {
					continue;
				}

				$object_id  = $image[ $map_info['needle'] ];
				$image_size = $image[ $map_info['size'] ];

				// Because we calculate highest resolution image, we can ignore the high_res suffixes
				$resolutions = apply_filters(
					'mv_create_image_resolutions', array(
						'_medium_res',
						'_medium_high_res',
						'_high_res',
					)
				);
				foreach ( $resolutions as $resolution ) {
					$continue = false;
					if ( strpos( $image_size, $resolution ) ) {
						$continue = true;
						break;
					}
				}
				if ( $continue ) {
					continue;
				}

				$highest_res_image = \Mediavine\Images::get_highest_available_image_size( $object_id, $image[ $map_info['size'] ], $available_sizes );
				$image_meta        = wp_get_attachment_image_src( $object_id, $highest_res_image );
				if ( $image_meta ) {
					$images[] = $image_meta[0];
				}
			}

			if ( ! empty( $images ) ) {
				$images = self::filter_json_ld_value( array_values( $images ), 'image', $schema_prop, $json_ld, $creation );

				// Remove duplicate images (array_unique sometimes forces associative arrays and is slower than array_flip)
				$unique_images           = array_merge( array_flip( array_flip( $images ) ) );
				$json_ld[ $schema_prop ] = $unique_images;
			}

			return $json_ld;
		}

		public static function add_json_ld_list( $json_ld, $value, $schema_prop, $map_info, $creation ) {
			$map_data = $value;
			// Merge down all groups if groups flag exists
			if ( ! empty( $map_info['groups'] ) ) {
				$map_data = array();
				foreach ( $value as $group_value ) {
					foreach ( $group_value as $list_value ) {
						$map_data[] = $list_value;
					}
				}
			}
			$list_data = wp_list_pluck( $map_data, $map_info['needle'] );

			foreach ( $list_data as $key => $list_value ) {
				if ( empty( $list_value ) ) {
					continue;
				}
				if ( ! empty( $map_info['strip_brackets'] ) ) {
					$list_data[ $key ] = self::strip_square_brackets( $list_value );
				}
			}

			if ( ! empty( $list_data ) ) {
				$list_data               = self::filter_json_ld_value( $list_data, 'list', $schema_prop, $json_ld, $creation );
				$json_ld[ $schema_prop ] = $list_data;
			}

			return $json_ld;
		}

		public static function add_json_ld_nutrition( $json_ld, $value, $schema_prop, $creation ) {
			$nutrition_map = apply_filters(
				'mv_json_ld_nutrition_map', array(
					'calories'        => array(
						'schema' => 'calories',
						'text'   => __( ' calories', 'mediavine' ),
					),
					'carbohydrates'   => array(
						'schema' => 'carbohydrateContent',
						'text'   => __( ' grams carbohydrates', 'mediavine' ),
					),
					'cholesterol'     => array(
						'schema' => 'cholesterolContent',
						'text'   => __( ' milligrams cholesterol', 'mediavine' ),
					),
					'total_fat'       => array(
						'schema' => 'fatContent',
						'text'   => __( ' grams fat', 'mediavine' ),
					),
					'fiber'           => array(
						'schema' => 'fiberContent',
						'text'   => __( ' grams fiber', 'mediavine' ),
					),
					'protein'         => array(
						'schema' => 'proteinContent',
						'text'   => __( ' grams protein', 'mediavine' ),
					),
					'saturated_fat'   => array(
						'schema' => 'saturatedFatContent',
						'text'   => __( ' grams saturated fat', 'mediavine' ),
					),
					'serving_size'    => array(
						'schema' => 'servingSize',
						'text'   => null,
					),
					'sodium'          => array(
						'schema' => 'sodiumContent',
						'text'   => __( ' grams sodium', 'mediavine' ),
					),
					'sugar'           => array(
						'schema' => 'sugarContent',
						'text'   => __( ' grams sugar', 'mediavine' ),
					),
					'trans_fat'       => array(
						'schema' => 'transFatContent',
						'text'   => __( ' grams trans fat', 'mediavine' ),
					),
					'unsaturated_fat' => array(
						'schema' => 'unsaturatedFatContent',
						'text'   => __( ' grams unsaturated fat', 'mediavine' ),
					),
				)
			);

			$has_nutrition = false;
			$nutrition     = array(
				'@type' => 'NutritionInformation',
			);

			foreach ( $nutrition_map as $key => $schema_data ) {
				if ( ! empty( $value[ $key ] ) || ( '0' === $value[ $key ] ) || ( 0 === $value[ $key ] ) ) {
					$nutrition[ $schema_data['schema'] ] = $value[ $key ] . $schema_data['text'];
					$has_nutrition                       = true;
				}
			}

			if ( $has_nutrition ) {
				$nutrition               = self::filter_json_ld_value( $nutrition, 'nutrition', $schema_prop, $json_ld, $creation );
				$json_ld[ $schema_prop ] = $nutrition;
			}

			return $json_ld;
		}

		public static function add_json_ld_rating( $json_ld, $value, $schema_prop, $creation ) {
			$aggregate_rating = array(
				'@type' => 'AggregateRating',
			);

			$value = array_merge( $aggregate_rating, $value );
			$value = self::filter_json_ld_value( $value, 'rating', $schema_prop, $json_ld, $creation );

			$json_ld['aggregateRating'] = $value;

			return $json_ld;
		}

		// TODO: Add title support
		public static function add_json_ld_step( $json_ld, $value, $schema_prop, $creation, $flags = array() ) {
			// We need DOMDocument installed for this to work. Fallback to single block of steps
			if ( ! class_exists( 'DOMDocument' ) ) {
				return self::add_json_ld_string( $json_ld, $value, $schema_prop, $creation, array( 'no_html' => true ) );
			}

			$value = self::filter_json_ld_value( $value, 'step', $schema_prop, $json_ld, $creation );

			// Build DOMDocument with blank steps array
			$dom = new \DOMDocument;
			if ( function_exists( 'libxml_use_internal_errors' ) ) {
				libxml_use_internal_errors( true );
			}
			$load = $dom->loadHTML( mb_convert_encoding( do_shortcode( $value ), 'HTML-ENTITIES', 'UTF-8' ) );
			if ( function_exists( 'libxml_use_internal_errors' ) ) {
				libxml_use_internal_errors( false );
			}
			$lis   = $dom->getElementsByTagName( 'li' );
			$steps = array();
			$i     = 0;

			foreach ( $lis as $li ) {
				$text = self::remove_html( $li->textContent );
				$url  = get_permalink( $creation['canonical_post_id'] );
				$id   = $creation['id'];
				$pos  = $i + 1;

				$steps[ $i ] = array(
					'@type' => 'HowToStep',
					'text'  => $text,
				);

				if ( 'diy' === $creation['type'] ) {
					$steps[ $i ]['position'] = $pos;
					$steps[ $i ]['name']     = wp_trim_words( $text, 8, '...' );
					$steps[ $i ]['url']      = "$url#mv_create_{$id}_$pos";

					$imgs = $li->getElementsByTagName( 'img' );
					if ( empty( $imgs ) || $imgs instanceof \DOMNodeList && ! $imgs->length && $li->nextSibling ) {
						if ( 'div' === $li->nextSibling->nodeName ) {
							$imgs = $li->nextSibling->getElementsByTagName( 'img' );
						}
					}

					if ( ! empty( $imgs[0] ) && $imgs[0]->hasAttribute( 'src' ) ) {
						$steps[ $i ]['image'] = $imgs[0]->getAttribute( 'src' );
					}
				}

				++$i;
			}

			// Fallback to single block if no LI elements were found
			if ( empty( $steps ) ) {
				return self::add_json_ld_string( $json_ld, $value, $schema_prop, $creation, array( 'no_html' => true ) );
			}

			$json_ld[ $schema_prop ] = $steps;

			return $json_ld;
		}

		public static function add_json_ld_string( $json_ld, $value, $schema_prop, $creation, $flags = array() ) {
			$value = self::filter_json_ld_value( $value, 'string', $schema_prop, $json_ld, $creation );

			if ( ! empty( $flags['get_permalink'] ) ) {
				$value = get_permalink( $value );
			}
			if ( ! empty( $flags['no_html'] ) ) {
				$value = self::remove_html( $value );
			}

			$json_ld[ $schema_prop ] = $value;

			return $json_ld;
		}

		public static function add_json_ld_video( $json_ld, $mv_video, $ext_video, $schema_prop, $creation, $flags = array() ) {
			if ( $mv_video ) {
				$value = (array) json_decode( $mv_video, true );
				$video = array( '@type' => 'VideoObject' );

				if ( ! empty( $value['title'] ) ) {
					$video['name'] = $value['title'];
				}

				if ( ! empty( $value['rawData']['description'] ) ) {
					$video['description'] = $value['rawData']['description'];
				} elseif ( ! empty( $value['rawData']['keywords'] ) ) {
					$video['description'] = $value['rawData']['keywords'];
				} elseif ( ! empty( $creation['description'] ) ) {
					$video['description'] = $creation['description'];
				}

				if ( ! empty( $value['thumbnail'] ) ) {
					$video['thumbnailUrl'] = $value['thumbnail'];
				}

				if ( ! empty( $value['slug'] ) ) {
					$video['contentUrl'] = 'https://mediavine-res.cloudinary.com/video/upload/' . $value['slug'] . '.mp4';
				} elseif ( ! empty( $value['key'] ) ) {
					$video['contentUrl'] = 'https://mediavine-res.cloudinary.com/video/upload/' . $value['key'] . '.mp4';
				}

				if ( ! empty( $value['duration'] ) ) {
					$video['duration'] = $value['duration'];
				}

				if ( ! empty( $value['uploadDate'] ) ) {
					$video['uploadDate'] = $value['uploadDate'];
				} elseif ( ! empty( $creation['modified'] ) ) {
					$video['uploadDate'] = date( 'c', (int) $creation['modified'] );
				}
			} elseif ( $ext_video ) {
				$value = (array) json_decode( $ext_video, true );
				$video = array(
					'@type'        => 'VideoObject',
					'name'         => $value['name'],
					'description'  => $value['description'],
					'thumbnailUrl' => $value['thumbnailUrl'],
					'contentUrl'   => $value['contentUrl'],
					'duration'     => $value['duration'],
					'uploadDate'   => $value['uploadDate'],
				);
			}

			$video            = self::filter_json_ld_value( $video, 'video', 'video', $json_ld, $creation );
			$json_ld['video'] = $video;

			return $json_ld;
		}

		public static function add_json_ld_item_list( $json_ld, $item_list ) {
			$json_ld['itemListElement'] = array();
			$current_host               = parse_url( home_url() );
			$position                   = 0;
			$types                      = array( 'external', 'card' );
			foreach ( $item_list as $item ) {
				$permalink = null;
				if ( $item->url ) {
					$permalink = $item->url;
				} elseif ( ! empty( $item->canonical_post_id ) ) {
					$permalink = get_the_permalink( $item->canonical_post_id );
				} elseif ( ! in_array( $item->content_type, $types, true ) ) {
					$permalink = get_the_permalink( $item->relation_id );
				}
				if ( ! $permalink || ! wp_http_validate_url( $permalink ) ) {
					continue;
				}

				// Don't add external URLs to JSON-LD
				$permalink_host = parse_url( $permalink );
				// If the link is a subdomain, we want to keep it in the JSON-LD
				// If the link is neither a subdomain nor the primary domain, skip it
				if ( ! Str::contains( $current_host['host'], $permalink_host['host'] ) && ! Str::is( $current_host['host'], $permalink_host['host'] ) ) {
					continue;
				}

				$json_ld['itemListElement'][] = array(
					'@type'    => 'ListItem',
					'position' => $position,
					'url'      => $permalink,
				);
				$position                     = $position + 1;
			}

			return $json_ld;
		}

		public static function build_json_ld( $creation, $type ) {
			// Actions to perform before building json_ld
			// Allows hooks to be added on a per type basis
			do_action( 'mv_create_before_json_ld_build', $creation, $type );
			do_action( 'mv_create_before_json_ld_build_' . $type, $creation );

			// Filter creation content for JSON LD
			$creation = apply_filters( 'mv_create_json_ld_build_creation', $creation, $type );
			$creation = apply_filters( 'mv_create_json_ld_build_creation_' . $type, $creation );

			$schema_types = apply_filters( 'mv_schema_types', self::$schema_types, $type, $creation );

			$json_ld = array(
				'@context' => 'http://schema.org',
			);

			// Get type
			$json_ld = self::add_json_ld_type( $json_ld, $type, $schema_types );

			// If no type, we don't want to even attempt to render JSON-LD
			if ( false === $json_ld['@type'] ) {
				return false;
			}

			// Loop through each schema property and set correct value based on type
			if ( ! empty( $schema_types[ $type ]['properties'] ) && is_array( $schema_types[ $type ] ) ) {
				foreach ( $schema_types[ $type ]['properties'] as $schema_prop => $schema_data ) {

					// If schema_prop doesn't have data array, prop is map and data is type
					$schema_type  = $schema_data;
					$schema_map   = $schema_prop;
					$schema_flags = array();
					if ( is_array( $schema_data ) ) {
						// If no type then move on
						if ( ! isset( $schema_data['type'] ) ) {
							continue;
						}
						$schema_type = $schema_data['type'];
						if ( isset( $schema_data['map'] ) ) {
							$schema_map = $schema_data['map'];
						}
						if ( isset( $schema_data['flags'] ) ) {
							$schema_flags = $schema_data['flags'];
						}
					}

					// Don't do anything with missing value unless forced or is map data array
					if ( $schema_map && ! is_array( $schema_map ) && empty( $creation[ $schema_map ] ) && empty( $schema_flags['force'] ) ) {
						continue;
					}

					switch ( $schema_type ) {
						case 'author':
							if ( isset( $creation[ $schema_map ] ) ) {
								$json_ld = self::add_json_ld_author( $json_ld, $creation[ $schema_map ], $schema_prop, $creation, $schema_flags );
							}
							break;
						case 'date':
							if ( isset( $creation[ $schema_map ] ) ) {
								$json_ld = self::add_json_ld_date( $json_ld, $creation[ $schema_map ], $schema_prop, $creation );
							}
							break;
						case 'duration':
							if ( isset( $creation[ $schema_map ] ) ) {
								$json_ld = self::add_json_ld_duration( $json_ld, $creation[ $schema_map ], $schema_prop, $creation );
							}
							break;
						case 'image':
							if ( isset( $creation[ $schema_map['haystack'] ] ) ) {
								$json_ld = self::add_json_ld_image( $json_ld, $creation[ $schema_map['haystack'] ], $schema_prop, $schema_map, $creation );
							}
							break;
						case 'list':
							if ( empty( $schema_map['haystack'] ) ||
								empty( $schema_map['needle'] ) ||
								! isset( $creation[ $schema_map['haystack'] ] ) ||
								! is_array( $creation[ $schema_map['haystack'] ] )
							) {
								break;
							}
							$json_ld = self::add_json_ld_list( $json_ld, $creation[ $schema_map['haystack'] ], $schema_prop, $schema_map, $creation );
							break;
						case 'nutrition':
							if ( isset( $creation[ $schema_map ] ) ) {
								$json_ld = self::add_json_ld_nutrition( $json_ld, $creation[ $schema_map ], $schema_prop, $creation );
							}
							break;
						case 'rating':
							$rating_value = array();
							foreach ( $schema_map as $key => $map ) {
								if ( ! empty( $creation[ $map ] ) && '0.0' !== $creation[ $map ] ) {
									$rating_value[ $key ] = $creation[ $map ];
								}
							}
							if ( ! empty( $rating_value ) ) {
								$json_ld = self::add_json_ld_rating( $json_ld, $rating_value, $schema_prop, $creation );
							}
							break;
						case 'step':
							if ( isset( $creation[ $schema_map ] ) ) {
								$json_ld = self::add_json_ld_step( $json_ld, $creation[ $schema_map ], $schema_prop, $creation, $schema_flags );
							}
							break;
						case 'string':
							if ( isset( $creation[ $schema_map ] ) ) {
								$json_ld = self::add_json_ld_string( $json_ld, $creation[ $schema_map ], $schema_prop, $creation, $schema_flags );
							}
							break;
						case 'video':
							if ( isset( $creation['video'] ) || isset( $creation['external_video'] ) ) {
								$json_ld = self::add_json_ld_video( $json_ld, $creation['video'], $creation['external_video'], $schema_prop, $creation );
							}
							break;
						case 'item_list':
							$json_ld = self::add_json_ld_item_list( $json_ld, $creation['list_items'] );
							break;
						default:
							break;
					}
				}
			}

			// Filter final JSON LD output
			$json_ld = apply_filters( 'mv_create_json_ld_output', $json_ld, $type, $creation );
			$json_ld = apply_filters( 'mv_create_json_ld_output_' . $type, $json_ld, $creation );

			return $json_ld;
		}
	}

}
