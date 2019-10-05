<?php

namespace Mediavine\Create;

use Mediavine\API_Services;



if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class Restore extends Plugin {

	public $creation_id;

	public function __construct( $creation_id ) {
		$this->creation_id = $creation_id;
	}

	public static function from_published( \WP_REST_Request $request, \WP_REST_Response $response ) {
		$creation_id = intval( $request->get_param( 'id' ) );

		$restore = new Restore( $creation_id );

		$published = $restore->get_creation_from_published();
		$new       = $published;

		unset(
			$new['nutrition'],
			$new['products'],
			$new['images'],
			$new['ingredients'],
			$new['posts'],
			$new['create_settings']
		);
		$new['prep_time']       = $restore->time_from_array( 'prep_time', $new );
		$new['active_time']     = $restore->time_from_array( 'active_time', $new );
		$new['additional_time'] = $restore->time_from_array( 'additional_time', $new );
		$new['total_time']      = $restore->time_from_array( 'total_time', $new );

		$restored = $restore->creation( $new );

		if ( isset( $published['nutrition'] ) ) {
			$restore->nutrition( $published['nutrition'] );
		}
		if ( isset( $published['products'] ) ) {
			$restore->products( $published['products'] );
		}
		if ( isset( $published['images'] ) ) {
			$restore->images( $published['images'] );
		}
		if ( isset( $published['ingredients'] ) ) {
			Supplies::delete_all_supplies( $creation_id, 'ingredients' );
			$restore->ingredients( $published['ingredients'] );
		}
		if ( isset( $published['materials'] ) ) {
			Supplies::delete_all_supplies( $creation_id, 'materials' );
			$restore->materials( $published['materials'] );
		}
		if ( isset( $published['tools'] ) ) {
			Supplies::delete_all_supplies( $creation_id, 'tools' );
			$restore->tools( $published['tools'] );
		}

		return $response;
	}

	private function get_creation_from_published() {
		$creation = self::$models_v2->mv_creations->find_one( $this->creation_id );

		if ( ! is_object( $creation ) ) {
			return null;
		}
		return json_decode( $creation->published, true );
	}

	private function creation( $creation ) {
		return self::$models_v2->mv_creations->update( $creation );
	}

	private function nutrition( $nutrition ) {
		if ( ! empty( $nutrition ) ) {
			self::$models_v2->mv_nutrition->upsert(
				$nutrition,
				[ 'creation' => $this->creation_id ]
			);
		}
	}

	private function products( $products ) {
		if ( ! empty( $published['products'] ) ) {
			foreach ( $published['products'] as $product ) {
				self::$models_v2->mv_products_map->upsert( $product );
			}
		}
	}

	private function images( $images ) {
		if ( ! empty( $images ) ) {
			foreach ( $images as $image ) {
				self::$models_v2->mv_images->upsert(
					$image,
					[
						'associated_id' => $this->creation_id,
						'image_size'    => $image['image_size'],
					]
				);
			}
		}
	}

	private function ingredients( $ingredients ) {
		if ( ! empty( $ingredients ) ) {
			foreach ( $ingredients as $group ) {
				foreach ( $group as $ingredient ) {
					unset( $ingredient['id'] );
					unset( $ingredient['created'] );
					unset( $ingredient['modified'] );
					$result = self::$models_v2->mv_supplies->create(
						$ingredient
					);
				}
			}
		}
	}

	private function materials( $materials ) {
		if ( ! empty( $materials ) ) {
			foreach ( $materials as $group ) {
				foreach ( $group as $material ) {
					unset( $material['id'] );
					unset( $material['created'] );
					unset( $material['modified'] );
					$result = self::$models_v2->mv_supplies->create(
						$material
					);
				}
			}
		}
	}

	private function tools( $tools ) {
		if ( ! empty( $tools ) ) {
			foreach ( $tools as $group ) {
				foreach ( $group as $tool ) {
					unset( $tool['id'] );
					unset( $tool['created'] );
					unset( $tool['modified'] );
					self::$models_v2->mv_supplies->create(
						$tool
					);
				}
			}
		}
	}

	private function time_from_array( $time_key, array $creation ) {
		$time = $creation[ $time_key ];
		if ( empty( $time ) ) {
			return;
		}

		if ( ! is_array( $time ) ) {
			return $time;
		}
		return $time['original'];
	}

}
