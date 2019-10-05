<?php

namespace Mediavine\Create;

class LinkScraper {
	/**
	 * @param array $defaults Default values for responses.
	 * @param array $methods  Extra methods to try, in addition to OpenGraph and others.
	 *                        Should be passed as an associative array with the keys
	 *                        'title', 'thumbnail_uri', or 'description', and the values
	 *                        being regex patterns used to scrape that property from
	 *                        an HTML document.
	 */
	function __construct(
		$defaults = array(
			'title'                => '',
			'remote_thumbnail_uri' => '',
			'description'          => null,
		),
		$methods = array()
	) {
		$this->defaults = $defaults;
		$this->methods  = array_merge(
			array(
				// Ref: https://regex101.com/r/gM4jyh/1
				'open-graph' => array(
					'title'                => '/(?:property="og:title"[^>]+content="([^"]+))|(?:content="([^"]+)[^>]+property="og:title")/',
					'remote_thumbnail_uri' => '/p(?:property="og:image"[^>]+content="([^"]+))|(?:content="([^"]+)[^>]+property="og:image")/',
					'description'          => '/(?:property="og:description"[^>]+content="([^"]+))|(?:content="([^"]+)[^>]+property="og:title")/',
				),
				'amazon'     => array(
					'title'                => '/id="productTitle" class="a-size-large">\s*(.*?)\s*<\/span>/s',
					'remote_thumbnail_uri' => '/id="landingImage"\sdata-a-dynamic-image="{&quot;(.*?)&quot;/',
					'description'          => '/name="description" content="(.*?)"/',
				),
				'fallback'   => array(
					'title'                => '/<title>(.*?)</',
					'remote_thumbnail_uri' => '/<img src="(.*?)"/',
				),
			), $methods
		);
	}

	/**
	 * Public method to execute a scrape
	 * @param  string $url      URL of resource to be scraped.
	 * @param  array  $priority Array of strings that correspond to scrape methods.
	 *                          Scrapes will be attempted in this order.
	 * @return array            Array
	 */
	public function scrape( $url, $priority = array( 'open-graph', 'amazon', 'fallback' ) ) {
		$response = wp_remote_get( $url );

		// Early return if request fails
		if ( is_wp_error( $response ) ) {
			return array_merge( $this->defaults, array( 'source' => 'default' ) );
		}

		// Set some defaults
		$data   = null;
		$method = 'default';

		// Loop over every scrape method, breaking if we have a match
		foreach ( $priority as $method_name ) {
			$matches = $this->process( $response['body'], $this->methods[ $method_name ] );

			if ( $matches ) {
				$method = $method_name;
				$data   = $matches;
				break;
			}
		}

		// If we don't have a match, return early with defaults
		if ( ! $data ) {
			return array_merge( $this->defaults, array( 'source' => 'default' ) );
		}

		return array_merge( $data, array( 'source' => $method ) );
	}

	/**
	 * Handles a scrape.
	 * @param  string $body     HTML document
	 * @param  array  $patterns Array of regex patterns. Should have 'title',
	 *                          'remote_thumbnail_uri', and 'description' keys.
	 * @return array|null       Array of match data
	 */
	private function process( $body, $patterns ) {
		// Set bool flag for if we have a match. We might have a partial match,
		// in which case we would want to merge that with our results, but if we
		// don't have any match, we want to return a false-y value instead of defaults.
		$has_match = false;
		$data      = $this->defaults;

		// Check for matches for each property
		$properties = array( 'title', 'remote_thumbnail_uri', 'description' );
		foreach ( $properties as $property ) {
			$match = null;
			// Skip over methods that don't exist.
			if ( isset( $patterns[ $property ] ) ) {
				preg_match( $patterns[ $property ], $body, $match );

				if ( is_array( $match ) ) {
					// We iterate over each subpattern by starting at 1st index.
					for ( $i = 1; $i < count( $match ); $i++ ) {
						// If a subpattern is matched, use it as the value.
						if ( isset( $match[ $i ] ) && $match[ $i ] && strlen( $match[ $i ] ) ) {
							// We have a match, so we want to return something from this function.
							$has_match         = true;
							$data[ $property ] = trim( $match[ $i ] );
							// We found a match, so we can stop.
							break;
						}
					}
				}
			}
		}

		// Return results
		return $has_match ? $data : null;
	}

}
