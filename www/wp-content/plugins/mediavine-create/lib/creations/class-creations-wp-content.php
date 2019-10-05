<?php

namespace Mediavine\Create;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

if ( class_exists( 'Mediavine\Create\Creations' ) ) {

	class Creations_WP_Content extends Creations {
		static $slug = 'mv_create';

		public static function register_content_types() {
			$permssion_level  = \Mediavine\Permissions::access_level();
			$post_type_name   = __( 'Create Card', 'mediavine' );
			$post_type_plural = __( 'Create Cards', 'mediavine' );

			$post_type_labels = array(
				'name'                  => '%2$s',
				'singular_name'         => '%1$s',
				/* translators: %1$s: post type name */
				'add_new'               => __( 'Add New %1$s', 'mediavine' ),
				/* translators: %1$s: post type name */
				'add_new_item'          => __( 'Add New %1$s', 'mediavine' ),
				/* translators: %1$s: post type name */
				'edit_item'             => __( 'Edit %1$s', 'mediavine' ),
				/* translators: %1$s: post type name */
				'new_item'              => __( 'Add New %1$s', 'mediavine' ),
				/* translators: %1$s: post type name */
				'view_item'             => __( 'View %1$s', 'mediavine' ),
				/* translators: %2$s: post type name */
				'view_items'            => __( 'View %2$s', 'mediavine' ),
				/* translators: %2$s: post type name */
				'search_items'          => __( 'Search %2$s', 'mediavine' ),
				/* translators: %2$s: post type name */
				'not_found'             => __( 'No %2$s found', 'mediavine' ),
				/* translators: %2$s: post type name */
				'not_found_in_trash'    => __( 'No %2$s found in trash', 'mediavine' ),
				/* translators: %2$s: post type name */
				'parent_item_colon'     => __( 'Parent %2$s:', 'mediavine' ),
				/* translators: %2$s: post type name */
				'all_items'             => __( 'All %2$s', 'mediavine' ),
				/* translators: %1$s: post type name */
				'archives'              => __( '%1$s Archives', 'mediavine' ),
				/* translators: %1$s: post type name */
				'attributes'            => __( '%1$s Attributes', 'mediavine' ),
				/* translators: %1$s: post type name */
				'insert_into_item'      => __( 'Insert into %1$s', 'mediavine' ),
				/* translators: %1$s: post type name */
				'uploaded_to_this_item' => __( 'Uploaded to this %1$s', 'mediavine' ),
				/* translators: %2$s: post type name */
				'filter_items_list'     => __( 'Filter %2$s list', 'mediavine' ),
				/* translators: %2$s: post type name */
				'items_list_navigation' => __( '%2$s list navigation', 'mediavine' ),
				/* translators: %2$s: post type name */
				'items_list'            => __( '%2$s list', 'mediavine' ),
			);

			foreach ( $post_type_labels as $key => $value ) {
				$post_type_labels[ $key ] = sprintf( $value, $post_type_name, $post_type_plural );
			}

			$post_type_args = array(
				'labels'              => $post_type_labels,
				'public'              => false,
				'hierarchical'        => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_ui'             => true,
				'show_in_rest'        => true,
				'menu_position'       => 5,
				'menu_icon'           => '',
				'capability_type'     => 'post',
				'supports'            => array( 'title', 'author' ),
				'taxonomies'          => array(),
				'has_archive'         => false,
				'can_export'          => true,
				'query_var'           => false,
				'delete_with_user'    => false,
				'rewrite'             => false,
				'capabilities'        => array(
					'publish_posts'       => $permssion_level,
					'edit_others_posts'   => $permssion_level,
					'delete_posts'        => $permssion_level,
					'delete_others_posts' => $permssion_level,
					'read_private_posts'  => $permssion_level,
					'edit_post'           => $permssion_level,
					'delete_post'         => $permssion_level,
					'read_post'           => $permssion_level,
				),
			);

			register_post_type( self::$slug, $post_type_args );
		}

		public static function register_taxonomies() {
			foreach ( self::$term_map as $term ) {
				$taxonomy_name   = $term;
				$taxonomy_plural = $term;

				$taxonomy_labels = array(
					'name'                       => '%2$s',
					'singular_name'              => '%1$s',
					/* translators: %2$s: post type name */
					'search_items'               => __( 'Search %2$s', 'mediavine' ),
					/* translators: %2$s: post type name */
					'popular_items'              => __( 'Popular %2$s', 'mediavine' ),
					/* translators: %2$s: post type name */
					'all_items'                  => __( 'All %2$s', 'mediavine' ),
					/* translators: %2$s: post type name */
					'parent_item'                => __( 'Parent %2$s', 'mediavine' ),
					/* translators: %2$s: post type name */
					'parent_item_colon'          => __( 'Parent %2$s:', 'mediavine' ),
					/* translators: %1$s: post type name */
					'edit_item'                  => __( 'Edit %1$s', 'mediavine' ),
					/* translators: %1$s: post type name */
					'view_item'                  => __( 'View %1$s', 'mediavine' ),
					/* translators: %1$s: post type name */
					'update_item'                => __( 'Update %1$s', 'mediavine' ),
					/* translators: %1$s: post type name */
					'add_new_item'               => __( 'Add New %1$s', 'mediavine' ),
					/* translators: %1$s: post type name */
					'new_item_name'              => __( 'New %1$s Name', 'mediavine' ),
					/* translators: %2$s: post type name */
					'separate_items_with_commas' => __( 'Separate %2$s with commas', 'mediavine' ),
					/* translators: %2$s: post type name */
					'add_or_remove_items'        => __( 'Add or remove %2$s', 'mediavine' ),
					/* translators: %2$s: post type name */
					'choose_from_most_used'      => __( 'Choose from the most used %2$s', 'mediavine' ),
					/* translators: %2$s: post type name */
					'not_found'                  => __( 'No %2$s found', 'mediavine' ),
					/* translators: %2$s: post type name */
					'no_terms'                   => __( 'No %2$s', 'mediavine' ),
				);

				foreach ( $taxonomy_labels as $key => $value ) {
					$taxonomy_labels[ $key ] = sprintf( $value, $taxonomy_name, $taxonomy_plural );
				}

				$taxonomy_args = array(
					'labels'             => $taxonomy_labels,
					'public'             => false,
					'publicly_queryable' => false,
					'hierarchical'       => false,
					'show_ui'            => false,
					'show_in_rest'       => true,
					'rest_base'          => 'mv-' . $term,
					'show_admin_column'  => true,
					'rewrite'            => array( 'slug' => $term ),
					'query_var'          => true,
				);

				register_taxonomy( 'mv_' . $term, self::$slug, $taxonomy_args );
			}
		}
	}

}
