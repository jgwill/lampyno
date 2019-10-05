<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Reviews' ) ) {
	class Reviews_Models extends Reviews {

		public static function get_creation_rating( $creation_id ) {
			global $wpdb;
			$review_table = $wpdb->prefix . 'mv_reviews';

			$reviews_avg_statement = $wpdb->prepare( "SELECT AVG(rating) FROM `$review_table` WHERE creation = %d", $creation_id );
			$avg                   = $wpdb->get_var( $reviews_avg_statement );

			// Round to the nearest decimal
			$rounded_avg = round( $avg, 1 );

			return $rounded_avg;
		}

		public static function get_creation_rating_count( $creation_id ) {
			global $wpdb;
			$review_table = $wpdb->prefix . 'mv_reviews';

			$reviews_count_statement = $wpdb->prepare( "SELECT COUNT(*) FROM `$review_table` WHERE creation = %d", $creation_id );
			$count                   = $wpdb->get_var( $reviews_count_statement );

			return $count;
		}

		function init() {
			add_filter( 'mv_custom_tables', array( $this, 'reviews_custom_tables' ) );
			self::$models->{'reviews'} = new \Mediavine\MV_DBI( $this->review_table );
		}

		function update( $data ) {
			$updated = self::$models->reviews->update( $data );
			if ( $updated ) {
				$review = self::$models->reviews->select_one_by_id( $data['id'] );
				return $review;
			}
			return false;
		}

		function find( $args = null, $search = null ) {
			$search_params = null;

			if ( $search ) {
				$search_params = array(
					'author_name'    => $search,
					'review_title'   => $search,
					'review_content' => $search,
				);
			}

			return self::$models->reviews->find( $args, $search_params );
		}

		public function get_count( $args = null, $search = null ) {
			$search_params = null;

			if ( $search ) {
				$search_params = array(
					'author_name'    => $search,
					'review_title'   => $search,
					'review_content' => $search,
				);
			}

			$total = self::$models->reviews->get_count( $args, $search_params );

			return $total;
		}

		/**
		 * Create review for create card and insert in database
		 *
		 * @param  array $review Array containing 'author_email', 'author_name', 'creation',
		 *                       'rating', 'review_title', 'review_content'
		 * @return object|false Inserted review
		 */
		public function create_review( $review ) {
			// Return if required fields missing
			if (
				empty( $review['author_email'] ) ||
				empty( $review['author_name'] ) ||
				empty( $review['creation'] ) ||
				empty( $review['rating'] )
			) {
				return false;
			}

			// Make sure rating is correct type
			$review['rating'] = intval( $review['rating'] * 2 ) / 2;

			// Require comment if less than 4 stars
			$enable_text_reviews    = apply_filters( 'mv_create_enable_text_review_modal', true );
			$text_reviews_threshold = 4;
			if ( ! $enable_text_reviews ) {
				$text_reviews_threshold = 0;
			}

			if ( ( 0 < $review['rating'] ) && ( $text_reviews_threshold > $review['rating'] ) ) {
				if ( empty( $review['review_content'] ) ) {
					return false;
				}
			}

			// Set title if missing
			if ( empty( $review['review_title'] ) ) {
				/* translators: %s: reviewer's name */
				$review['review_title'] = sprintf( __( 'Review from %s', 'mediavine' ), $review['author_name'] );
			}

			$inserted = self::$models->reviews->insert( $review );

			if ( $inserted ) {
				$this->update_creation_rating( $inserted );

				return $inserted;
			}

			return false;
		}

		function update_creation_rating( $review ) {
			$rounded_avg = $this->get_creation_rating( $review->creation );
			$count       = $this->get_creation_rating_count( $review->creation );

			do_action( 'mv_rating_updated', $rounded_avg, $review, $count );

			return;
		}

		function reviews_custom_tables( $custom_tables ) {

			$custom_tables[] = array(
				'version'    => self::DB_VERSION,
				'table_name' => $this->review_table,
				'sql'        => "
					id bigint(20) NOT NULL AUTO_INCREMENT,
					type varchar(20) NOT NULL DEFAULT 'review',
					object_id bigint(20),
					review_title text,
					creation bigint(20),
					review_content longtext,
					author_email text,
					author_name text,
					rating float(2,1) NOT NULL default '5.0',
					edited_by_admin tinyint(1) default 0,
					edited_by_user tinyint(1) default 0,
					created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					PRIMARY KEY  (id)",

			);

			return $custom_tables;

		}

	}
}
