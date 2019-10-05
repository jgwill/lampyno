<?php
/**
 * Handle the recipe video metadata.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe video metadata.
 *
 * @since      3.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_MetadataVideo {

	/**
	 * Apis for looking up video metadata.
	 *
	 * @since    3.1.0
	 * @access   private
	 * @var      array	$apis	Apis for looking up video metadata.
	 */
	private static $apis = array(
		'youtube' => 'AIzaSyCb5vbLd6f6397ygyBd-yIU0omZagxTfDY',
	);

	/**
	 * Output metadata in the HTML head.
	 *
	 * @since   3.0.0
	 * @param	object $recipe Recipe to get the video metadata for.
	 */
	public static function get_video_metadata_for_recipe( $recipe ) {
		$metadata = false;

		if ( $recipe->video_id() ) {
			$attachment = get_post( $recipe->video_id() );

			if ( $attachment ) {
				$video_data = $recipe->video_data();

				// Google complains about multiple thumbnailUrl when not a food recipe.
				if ( 'food' === $recipe->type() ) {
					$image_sizes = array(
						$recipe->video_thumb_url( 'full' ),
						$recipe->video_thumb_url( 'wprm-metadata-1_1' ),
						$recipe->video_thumb_url( 'wprm-metadata-4_3' ),
						$recipe->video_thumb_url( 'wprm-metadata-16_9' ),
					);
					$image_sizes = array_values( array_unique( $image_sizes ) );
				} else {
					$image_sizes = $recipe->video_thumb_url( 'full' );
				}

				$metadata = array(
					'name' => $attachment->post_title,
					'description' => $attachment->post_content,
					'thumbnailUrl' => $image_sizes,
					'contentUrl' => $recipe->video_url(),
					'uploadDate' => date( 'c', strtotime( $attachment->post_date ) ),
					'duration' => 'PT' . $video_data['length'] . 'S',
				);
			}
		} elseif ( $recipe->video_embed() ) {
			$embed_code = trim( $recipe->video_embed() );

			$metadata = $metadata ? $metadata : self::check_for_adthrive_embed( $embed_code );
			$metadata = $metadata ? $metadata : self::check_for_mediavine_embed( $embed_code );
			$metadata = $metadata ? $metadata : self::check_for_wp_youtube_lyte_embed( $embed_code );

			$metadata = $metadata ? $metadata : self::check_for_oembed( $embed_code );
			$metadata = $metadata ? $metadata : self::check_for_meta_html( $embed_code );
		}

		return $metadata;
	}

	/**
	 * Check the embed code for a Adthrive video.
	 *
	 * @since   3.0.0
	 * @param	string $embed_code Embed code to check.
	 */
	private static function check_for_adthrive_embed( $embed_code ) {
		$metadata = false;

		$pattern = get_shortcode_regex( array( 'adthrive-in-post-video-player' ) );

		// Prevent issues with - in shortcode.
		$embed_code = str_ireplace( 'video-id', 'video_id', $embed_code );
		$embed_code = str_ireplace( 'upload-date', 'upload_date', $embed_code );

		preg_match( '/' . $pattern . '/s', $embed_code, $matches );
		
		if ( $matches && isset( $matches[3] ) ) {

			$attributes = shortcode_parse_atts( stripslashes( $matches[3] ) );

			$video_id = isset( $attributes['video_id'] ) ? $attributes['video_id'] : false;

			if ( $video_id ) {
				$upload_date = isset( $attributes['upload_date'] ) ? $attributes['upload_date'] : '';
				$name = isset( $attributes['name'] ) ? $attributes['name'] : '';
				$description = isset( $attributes['description'] ) ? $attributes['description'] : '';

				$metadata = array(
					'name' => $name,
					'description' => $description,
					'thumbnailUrl' => 'https://content.jwplatform.com/thumbs/' . $video_id . '-720.jpg',
					'contentUrl' => 'https://content.jwplatform.com/videos/' . $video_id . '.mp4',
					'uploadDate' => $upload_date,
				);
			}
		}

		return $metadata;
	}

	/**
	 * Check the embed code for a MediaVine video.
	 *
	 * @since   3.0.0
	 * @param	string $embed_code Embed code to check.
	 */
	private static function check_for_mediavine_embed( $embed_code ) {
		$metadata = false;

		preg_match( '/.mediavine.com\/videos\/(.*?)\.js/im', $embed_code, $match );
		if ( $match && isset( $match[1] ) ) {
			$metadata = self::check_for_oembed( 'https://embed.mediavine.com/videos/' . $match[1] );
		}

		return $metadata;
	}

	/**
	 * Check the embed code for a WP YouTube Lyte video.
	 *
	 * @since   3.1.0
	 * @param	string $embed_code Embed code to check.
	 */
	private static function check_for_wp_youtube_lyte_embed( $embed_code ) {
		$metadata = false;

		$pattern = get_shortcode_regex( array( 'lyte' ) );
		preg_match( '/' . $pattern . '/s', $embed_code, $matches );
		
		if ( $matches && isset( $matches[3] ) ) {

			$attributes = shortcode_parse_atts( stripslashes( $matches[3] ) );
			$video_id = isset( $attributes['id'] ) ? $attributes['id'] : false;

			if ( $video_id ) {
				$metadata = self::check_for_oembed( 'https://www.youtube.com/watch?v=' . $video_id );
			}
		}

		return $metadata;
	}

	/**
	 * Check the embed code for meta fields.
	 *
	 * @since   3.3.0
	 * @param	string $embed_code Embed code to check.
	 */
	private static function check_for_meta_html( $embed_code ) {
		$metadata = false;

		$dom = new DOMDocument;

		// Prevent errors from showing up.
		$internalErrors = libxml_use_internal_errors( true );
		$dom->loadHTML( $embed_code );
		libxml_use_internal_errors( $internalErrors );

		$meta_tags = $dom->getElementsByTagName( 'meta' );

		if ( 0 < $meta_tags->length ) {
			$metadata = array();

			foreach ( $meta_tags as $meta_tag ) {
				if ( in_array( $meta_tag->getAttribute( 'itemprop' ),
						array(
							'uploadDate',
							'name',
							'description',
							'duration',
							'expires',
							'interactionCount',
							'thumbnailUrl',
							'contentUrl',
							'embedUrl',
						)
					) ) {
					$metadata[ $meta_tag->getAttribute( 'itemprop' ) ] = $meta_tag->getAttribute( 'content' );
				}
			}

			if ( ! $metadata ) {
				$metadata = false;
			}
		}

		return $metadata;
	}

	/**
	 * Check the embed code for an oEmbed video.
	 *
	 * @since   3.0.0
	 * @param	string $embed_code Embed code to check.
	 */
	private static function check_for_oembed( $embed_code ) {
		$metadata = false;
		$url = false;

		// Check if it's a regular URL.
		$potential_url = filter_var( $embed_code, FILTER_SANITIZE_URL );

		if ( filter_var( $potential_url, FILTER_VALIDATE_URL ) ) {
			$url = $potential_url;
		}

		// No regular URL? Check embed code.
		if ( ! $url ) {
			$url = self::get_url_from_embed_code( $embed_code );
		}

		// If we've found a URL, try getting the metadata through oEmbed.
		if ( $url ) {
			// Get the WP oEmbed class.
			global $wp_oembed;
			if ( ! $wp_oembed ) {
				require_once( ABSPATH . WPINC . '/class-oembed.php' );
				$wp_oembed = new WP_oEmbed();
			}

			// Check if we can find a provider for this URL.
			$provider = $wp_oembed->get_provider( $url );

			if ( $provider ) {
				$oembed_data = $wp_oembed->fetch( $provider, $url );

				if ( $oembed_data ) {
					$name = isset( $oembed_data->title ) ? $oembed_data->title : '';
					$description = isset( $oembed_data->description ) ? $oembed_data->description : '';
					$duration = isset( $oembed_data->duration ) ? 'PT' . intval( $oembed_data->duration ) . 'S' : '';
					$thumbnail_url = isset( $oembed_data->thumbnail_url ) ? $oembed_data->thumbnail_url : '';
					$upload_date = isset( $oembed_data->upload_date ) ? date( 'c', strtotime( $oembed_data->upload_date ) ) : '';

					if ( ! $upload_date && isset( $oembed_data->uploadDate ) ) {
						$upload_date = date( 'c', strtotime( $oembed_data->uploadDate ) );
					}

					// Default to oEmbed URL.
					$content_url = isset( $oembed_data->content_url ) ? $oembed_data->content_url : '';
					$content_url = $content_url ? $content_url : $url;

					$metadata = array(
						'name' => $name,
						'description' => $description,
						'thumbnailUrl' => $thumbnail_url,
						'contentUrl' => $content_url,
						'uploadDate' => $upload_date,
						'duration' => $duration,
					);

					if ( isset( $oembed_data->html ) ) {
						preg_match( '/src\s*=\s*"([^"]+)"/im', $oembed_data->html, $match );
						if ( $match && isset( $match[1] ) ) {
							$metadata['embedUrl'] = $match[1];
						}	
					}
				}

				// Extend Youtube metadata via API.
				if ( is_array( $metadata ) && false !== stripos( $provider, 'youtube' ) ) {
					$metadata = self::get_youtube_metadata( $url ) + $metadata;
				}
			}
		}

		return $metadata;
	}

	/**
	 * Check the embed code for a URL.
	 *
	 * @since   3.0.0
	 * @param	string $embed_code Embed code to get the URL from.
	 */
	private static function get_url_from_embed_code( $embed_code ) {
		// Check for YouTube embed code.
		preg_match("/youtube.com\/embed\/(.*?)[\"\?]/im", $embed_code, $match );
		if ( $match && isset( $match[1] ) ) {
			return 'https://www.youtube.com/watch?v=' . $match[1];
		}

		// Check for src="" in the embed code.
		preg_match( '/src\s*=\s*"([^"]+)"/im', $embed_code, $match );
		if ( $match && isset( $match[1] ) ) {
			return $match[1];
		}		

		return false;
	}

	/**
	 * Get Youtube metadata video the API.
	 *
	 * @since   3.1.0
	 * @param	string $url Youtube video URL.
	 */
	private static function get_youtube_metadata( $url ) {
		$metadata = array();

		// Get video ID.
		preg_match( "/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $video_parts );
		if( isset( $video_parts[1] ) ) {
			$video_id = $video_parts[1];
		}

		if ( $video_id ) {
			$api_key = self::$apis['youtube'];
			$api_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=' . urlencode( $video_id ) . '&key=' . urlencode( $api_key );

			$response = wp_remote_get( $api_url );
			$body = ! is_wp_error( $response ) && isset( $response['body'] ) ? json_decode( $response['body'] ) : false;

			if ( $body ) {
				$item = isset( $body->items[0] ) ? $body->items[0] : false;

				if ( $item ) {
					$snippet = $item->snippet;
					$name = isset( $snippet->title ) ? $snippet->title : '';
					$description = isset( $snippet->description ) ? $snippet->description : '';
					$duration = isset( $item->contentDetails->duration ) ? $item->contentDetails->duration : '';
					$upload_date = isset( $snippet->publishedAt ) ? date( 'c', strtotime( $snippet->publishedAt ) ) : '';

					$metadata = array(
						'name' => $name,
						'description' => $description,
						'uploadDate' => $upload_date,
						'duration' => $duration,
					);
				}
			}
		}

		return $metadata;
	}
}
