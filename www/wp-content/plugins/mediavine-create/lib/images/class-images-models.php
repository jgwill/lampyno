<?php

namespace Mediavine;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Images' ) && ! class_exists( 'Mediavine\Images_Models' ) ) {

	class Images_Models extends Images {

		public function init() {
			add_filter( 'mv_custom_tables', array( $this, 'create_custom_tables' ) );
		}

		public function create( $data ) {
			$prepped_image = $this->prep_image( $data );
			return self::$models->images->insert( $prepped_image );
		}

		public function delete( $args ) {
			return self::$models->images->delete( $args );
		}

		// Creates custom tables
		public function create_custom_tables( $custom_tables ) {

			// Image table
			$custom_tables[] = array(
				'version'    => self::DB_VERSION,
				'table_name' => $this->images_table,
				'sql'        => "
					id bigint(20) NOT NULL AUTO_INCREMENT,
					type varchar(20) NOT NULL DEFAULT 'image',
					object_id bigint(20),
					image_size text,
					image_url text,
					image_url_full_size text,
					image_srcset text,
					image_srcset_sizes text,
					associated_id bigint(20),
					associated_type varchar(20) NOT NULL,
					created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					PRIMARY KEY  (id),
					KEY object_id (object_id),
					KEY associated_id (associated_id),
					KEY associated_type (associated_type)",
			);

			return $custom_tables;

		}

	}

}
