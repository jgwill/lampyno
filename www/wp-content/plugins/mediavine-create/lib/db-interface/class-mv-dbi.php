<?php

namespace Mediavine;

use Mediavine\WordPress\Support\Arr;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class MV_DBI {

	public $table_name = null;

	public $short_name = null;

	public $columns = [];

	public static function graph_type_to_sql( $type ) {
		switch ( $type->name ) {
			case 'Int':
				return 'bigint(20)';
			case 'Boolean':
				return 'tinyint(1)';
			case 'Float':
				return 'float(2,1)';
			default:
				return 'longtext';
		}
	}

	public static function create_table( $table ) {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		if ( array_key_exists( 'table_name', $table ) && array_key_exists( 'sql', $table ) ) {
			$custom_table_name       = $wpdb->prefix . $table['table_name'];
			$custom_table_sql        = $table['sql'];
			$create_custom_table_sql = "CREATE TABLE $custom_table_name ( $custom_table_sql ) $charset_collate;";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$new_table = dbDelta( $create_custom_table_sql );
			update_option( $table['table_name'] . '_db_version', $table['version'] );
		}
	}

	public static function schema_to_sql( $fields ) {
		$sql        = "id bigint(20) NOT NULL AUTO_INCREMENT,
						created datetime DEFAULT NULL,
						modified datetime DEFAULT NULL, \n";
		$key_clause = '';
		foreach ( $fields as $key => $value ) {
			$default  = '';
			$col_type = 'longtext';
			if ( gettype( $value ) === 'string' ) {
				$col_type = $value;
			}

			if ( gettype( $value ) === 'array' ) {
				if ( isset( $value['default'] ) ) {
					if ( 'NULL' === $value['default'] ) {
						$default = ' DEFAULT NULL ';
					} else {
						$default = " NOT NULL DEFAULT {$value['default']} ";
					}
				}
				if ( isset( $value['type'] ) ) {
					$col_type = $value['type'];
				}
				if ( isset( $value['key'] ) ) {
					$key_clause .= "KEY {$key} ({$key}),  \n";
				}
				if ( isset( $value['unique'] ) ) {
					$key_clause .= "UNIQUE KEY {$key} ({$key}),  \n";
				}
			}

			$sql .= "{$key} {$col_type}{$default}, \n";
		}
		$sql .= $key_clause;
		$sql .= 'PRIMARY KEY  (id)';

		return $sql;
	}


	public static function create_schema_tables( $tables = array() ) {
		$tables = apply_filters( 'mv_custom_schema', $tables );

		foreach ( $tables as $table ) {
				$table['sql'] = self::schema_to_sql( $table['schema'] );
				self::create_table( $table );
		}
	}

	public static function create_custom_tables( $custom_tables = array() ) {
		$custom_tables = apply_filters( 'mv_custom_tables', $custom_tables );

		if ( is_array( $custom_tables ) ) {

			// nest in subarray if only a single array exists
			if ( array_key_exists( 'table_name', $custom_tables ) ) {
				$custom_tables = array( $custom_tables );
			}

			foreach ( $custom_tables as $custom_table ) {
				self::create_table( $custom_table );
			}
		}
	}

	/**
	 * Fetch an Object of Models
	 * @param  array  $table_names   Optional array of just the tables desired (minus db prefix)
	 * @param  string $plugin_prefix Optional prefix for a select set of tables
	 * @return [type]                Model Object, includes refrence ORM Methods in Object
	 */
	public static function get_models( $table_names = array(), $plugin_prefix = null ) {
		$models = new \Mediavine\Models();
		global $wpdb;

		if ( $plugin_prefix ) {
			$query     = $wpdb->prefix . $plugin_prefix . '%';
			$statement = $wpdb->prepare( 'SHOW TABLES LIKE %s', $query );
			$results   = $wpdb->get_results( $statement );

			foreach ( $results as $index => $value ) {
				foreach ( $value as $table_name ) {
					$simple_name            = str_replace( $wpdb->prefix, '', $table_name );
					$models->{$simple_name} = new self( $simple_name );
				}
			}
			return $models;
		}

		if ( ! empty( $table_names ) ) {
			foreach ( $table_names as $table_name ) {
				$models->{$table_name} = new self( $table_name );
			}
			return $models;
		}

		return null;
	}
	/**
	 * Evaluates database upgrade requirement and if necessary executes
	 *
	 * @param string $plugin_name plugin unique slug for use in option
	 * @param string $db_version to check if the version is initialized
	 * @return boolean true if upgraded, false if not necessary.
	 */
	public static function upgrade_database_check( $plugin_name, $db_version ) {
		if ( get_option( $plugin_name . '_db_version' ) !== $db_version ) {
			self::create_schema_tables();
			self::create_custom_tables();
			update_option( $plugin_name . '_db_version', $db_version );
			return true;
		}
		return false;
	}

	public function __construct( $table_name ) {
		global $wpdb;

		$this->table_name = $wpdb->prefix . $table_name;
		$this->short_name = $table_name;
	}

	/**
	 * Normalizes data to only return data that exists as cols within table
	 *
	 * @param  array $data Data to be normalized
	 * @return array Normalized data
	 */
	public function normalize_data( $data ) {
		global $wpdb;

		$normalized_data = array();

		foreach ( $wpdb->get_col( 'DESC ' . $this->table_name, 0 ) as $column_name ) {
			if ( isset( $data[ $column_name ] ) ) {
				// Data should never be in an array at this point, so skip if array
				if ( is_array( $data[ $column_name ] ) ) {
					continue;
				}

				$normalized_data[ $column_name ] = $data[ $column_name ];
			}
		}

		return $normalized_data;
	}

	/**
	 * Returns the sprintf type for preparing sql statements
	 *
	 * @param  mixed $var Variable to determin type
	 * @return string|false sprintf type
	 */
	public function get_sprintf( $var ) {
		$type = gettype( $var );

		switch ( $type ) {
			case 'string':
				if ( is_numeric( $type ) ) {
					return '%d';
				} else {
					return '%s';
				}
				// no break
			case 'boolean':
				return '%b';
			case 'integer':
				return '%d';
			case 'double':
				return '%f';
			default:
				return false;
		}
	}

	public function get_wp_sprintf_type( $var ) {
		$type = gettype( $var );

		switch ( $type ) {
			case 'string':
			case 'NULL':
				if ( is_numeric( $type ) ) {
					return '%d';
				}
				return '%s';
			case 'boolean':
			case 'integer':
				return '%d';
			case 'double':
				return '%f';
			default:
				return false;
		}

	}

	/**
	 * Checks if duplicate exists in table
	 *
	 * @param  string $col Column value
	 * @param  string $key Key values
	 * @return object|false Database query result of duplicate entry
	 */
	public function has_duplicate( $where_array ) {
		$args = array(
			'where' => $where_array,
		);

		$duplicate = $this->select_one( $args );

		if ( $duplicate ) {
			return $duplicate;
		}

		return false;
	}

	public function create( $data ) {
		add_filter( 'query', array( $this, 'allow_null' ) );
		return $this->insert( $data );
	}

	public function before_create( $data ) {
		$data        = apply_filters( 'mv_dbi_before_create', $data, $this->table_name );
		$filter_name = 'mv_dbi_before_create_' . $this->short_name;
		$data        = apply_filters( $filter_name, $data );
		return $data;
	}

	public function after_create( $data ) {
		$data        = apply_filters( 'mv_dbi_after_create', $data, $this->table_name );
		$filter_name = 'mv_dbi_after_create_' . $this->short_name;
		$data        = apply_filters( $filter_name, $data );
		return $data;
	}

	/**
	 * Insert many items into the database in a single transaction.
	 *
	 * @param array $data
	 * @return int inserted count
	 */
	public function create_many( array $data ) {
		global $wpdb;

		if ( empty( $data ) || ! count( $data ) ) {
			return null;
		}
		$date = date( 'Y-m-d H:i:s' );

		// get the columns from the table
		$table_columns = $wpdb->get_col( 'DESC ' . $this->table_name, 0 );

		// default all values to null so we can add values where items are missing keys
		$defaults = [];
		foreach ( $table_columns as $column ) {
			$defaults[ $column ] = 'NULL';
		}

		// generate the "(columns...) part of the insert query
		$insert_fields = '`' . implode( '`, `', $table_columns ) . '`';

		$value_formats = '';
		$values        = [];
		foreach ( $data as $item ) {
			// set timestamps
			$item['created']  = $date;
			$item['modified'] = $date;

			// Remove arrays from item.
			// This prevents issue with other plugins adding meta
			// to any custom post type that may be used in lists.
			$item = array_filter(
				$item, function( $value ) {
				return ! is_array( $value );
				}
			);

			// If any keys are not set on the item, add the default
			$item = array_merge( $defaults, $item );
			// Remove any keys that aren't in the table columns list
			$item = Arr::only( $item, $table_columns );

			// get sprintf formats for item to prepare SQL
			$formats = [];
			foreach ( $item as $value ) {
				$formats[] = $this->get_wp_sprintf_type( $value );
				$values[]  = $value;
			}

			// generate the "(values...)" part of the insert query for this item
			$value_formats .= '(' . implode( ', ', $formats ) . '), ';
		}
		$insert_values = trim( $value_formats, ', ' );
		$statement     = "INSERT INTO {$this->table_name} ($insert_fields) VALUES $insert_values";

		// use the formats, Luke--escape SQL
		$prepared = $wpdb->prepare( $statement, $values );

		add_filter( 'query', [ $this, 'allow_null' ] );
		return $wpdb->query( $prepared );
	}

	public function after_select( $data ) {

		return $data;
	}

	/**
	 * Inserts new row into custom table
	 *
	 * @param  array $data Data to be inserted
	 * @return object Database query result from insert
	 */
	public function insert( $data ) {
		global $wpdb;

		$date             = date( 'Y-m-d H:i:s' );
		$data['created']  = $date;
		$data['modified'] = $date;

		$data = $this->before_create( $data );

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$normalized_data = $this->normalize_data( $data );
		add_filter( 'query', array( $this, 'allow_null' ) );
		$insert = $wpdb->insert( $this->table_name, $normalized_data );
		remove_filter( 'query', array( $this, 'allow_null' ) );

		if ( $insert ) {
			$new_record = $this->select_one_by_id( $wpdb->insert_id );
			$new_record = $this->after_create( $new_record );
			return $new_record;
		}

		return $insert;
	}

	public function find_or_create( $data, $where_array = null ) {
		global $wpdb;

		if ( ! $where_array && isset( $data['slug'] ) ) {
			$where_array = array(
				'slug' => $data['slug'],
			);
		}

		if ( ! is_array( $where_array ) ) {
			$where_array = array(
				'slug' => $where_array,
			);
		}

		$existing = $this->has_duplicate( $where_array );

		if ( $existing ) {
			return $existing;
		}

		$normalized_data = $this->normalize_data( $data );
		$new             = $this->insert( $data );

		return $new;
	}

	public function upsert( $data, $where_array = null ) {
		global $wpdb;

		if ( ! $where_array && isset( $data['slug'] ) ) {
			$where_array = array(
				'slug' => $data['slug'],
			);
		}

		if ( ! $where_array && isset( $data['id'] ) ) {
			$where_array = array(
				'id' => $data['id'],
			);
		}

		if ( ! is_array( $where_array ) ) {
			$where_array = array(
				'slug' => $where_array,
			);
		}

		$normalized_data = $this->normalize_data( $data );
		$existing        = $this->has_duplicate( $where_array );

		if ( $existing ) {
			$args    = array(
				'id' => $existing->id,
			);
			$updated = $this->update( $data, $args, true );

			return $updated;
		}

		$new = $this->insert( $data );

		return $new;
	}

	public function before_update( $data ) {
		$data        = apply_filters( 'mv_dbi_before_update', $data, $this->table_name );
		$filter_name = 'mv_dbi_before_update_' . $this->short_name;
		$data        = apply_filters( $filter_name, $data );
		return $data;
	}

	public function after_update( $data ) {
		$data        = apply_filters( 'mv_dbi_after_update', $data, $this->table_name );
		$filter_name = 'mv_dbi_after_update_' . $this->short_name;
		$data        = apply_filters( $filter_name, $data );
		return $data;
	}

	public function update( $data, $args = null, $return_updated = true ) {
		global $wpdb;

		if ( isset( $data['created'] ) ) {
			unset( $data['created'] );
		}

		$date             = date( 'Y-m-d H:i:s' );
		$data['modified'] = $date;

		$data = $this->before_update( $data );

		$defaults = apply_filters(
			"mv_db_update_defaults_{$this->table_name}", array(
				'col'          => 'id',
				'key'          => null,
				'format'       => null,
				'where_format' => null,
			)
		);

		if ( ! $args ) {
			if ( ! empty( $data['id'] ) ) {
				$args       = array();
				$args['id'] = $data['id'];
			}
		}

		// If $args not array, set value as id
		if ( ! is_array( $args ) ) {
			$args = array( 'id' => $args );
		}

		$args = array_merge( $defaults, $args );
		$key  = ( ! empty( $args['id'] ) && ! $args['key'] ) ? $args['id'] : $args['key'];

		$normalized_data = self::normalize_data( $data );
		add_filter( 'query', array( $this, 'allow_null' ) );

		$update = $wpdb->update( $this->table_name, $normalized_data, array( $args['col'] => $key ), $args['format'], $args['where_format'] );
		remove_filter( 'query', array( $this, 'allow_null' ) );
		// Return error message if error
		if ( false === $update ) {
			return array( 'error' => $wpdb->last_error );
		}

		if ( $return_updated ) {

			$args   = array(
				'col' => $args['col'],
				'key' => $key,
			);
			$record = $this->select_one( $args );
			$record = $this->after_update( $record );
			return $record;
		}

		return $update;
	}

	/**
	 * Alias for $this->select_one
	 * @param  ARRAY $args array of options to pb passed to select_one
	 * @return OBJECT      DB Object response
	 */
	public function find_one( $args ) {
		return $this->select_one( $args );
	}

	public function find_one_by_id( $id ) {
		return $this->select_one_by_id( $id );
	}

	public function select_one( $args ) {
		global $wpdb;

		$defaults = apply_filters(
			"mv_db_select_one_defaults_{$this->table_name}", array(
				'col' => 'id',
				'key' => null,
			)
		);

		// If $args not array, set key as id
		if ( ! is_array( $args ) ) {
			$args = array( 'key' => $args );
		}

		$args = array_merge( $defaults, $args );

		// Setup where array if it doesn't exist
		if ( empty( $args['where'] ) || ! is_array( $args['where'] ) ) {
			$args['where'] = array(
				$args['col'] => $args['key'],
			);
		}

		$where_statement = '';
		$prepare_array   = array();

		$operator = ' AND ';

		if ( isset( $args['where']['or'] ) ) {
			$operator      = ' OR ';
			$args['where'] = $args['where']['or'];
		}

		foreach ( $args['where'] as $key => $value ) {
			if ( ! empty( $where_statement ) ) {
				$where_statement .= $operator;
			}
			$sprintf_identifier = $this->get_sprintf( $value );
			if ( ! $sprintf_identifier ) {
				continue;
			}
			$prepare_array[]  = $value;
			$where_statement .= $key . ' = ' . $sprintf_identifier;
		}

		$build_sql          = "SELECT * FROM `$this->table_name` WHERE " . $where_statement;
		$prepared_statement = $wpdb->prepare( $build_sql, $prepare_array );

		$select = $wpdb->get_results( $prepared_statement );

		$select = $this->after_find( $select );

		// return without array if array
		if ( ! empty( $select ) && is_array( $select ) ) {
			return $select[0];
		}

		return $select;

	}

	public function select_one_by_id( $id ) {
		$select = $this->select_one( $id );

		return $select;
	}

	public function select_one_by_object_id( $object_id ) {
		$args   = array(
			'col' => 'object_id',
			'key' => $object_id,
		);
		$select = $this->select_one( $args );

		return $select;
	}

	/**
	 * Retrieve an entire SQL result set from the database
	 *
	 * Prepares queries that need a prepare
	 *
	 * @param  array  $args Array containing basic SQL arguments or a prepared
	 *                      SQL statement
	 * @param array   $search_params Array containing a list of column names that should
	 *                               be searched with LIKE/OR queries to support
	 *                               text search.
	 * @return object Database query results
	 */
	public function find( $args = array(), $search_params = null ) {
		global $wpdb;

		$results  = array();
		$limit    = 50;
		$offset   = 0;
		$order_by = 'created';
		$order    = 'DESC';
		$select   = '*';

		// Array of params that should be handled with LIKE, not =
		// This probably won't ever change, since would only be used by search, practically.
		$like_params = array(
			'published',
			'title',
			'post_title',
			'associated_posts',
		);

		if ( isset( $args['prepared_statement'] ) ) {
			$results = $wpdb->get_results( $args['prepared_statement'] );
			return $results;
		}

		$default_statement = "SELECT * FROM `$this->table_name` ORDER BY $order_by $order LIMIT $limit OFFSET $offset";

		if ( empty( $args ) && ! $search_params ) {
			$results = $wpdb->get_results( $default_statement );
			return $results;
		}

		if ( isset( $args['limit'] ) ) {
			$limit = (int) $args['limit'];
		}
		if ( isset( $args['offset'] ) ) {
			$offset = (int) $args['offset'];
		}
		if ( isset( $args['order_by'] ) ) {
			$order_by = $args['order_by'];
		}
		if ( isset( $args['order'] ) && ( 'ASC' === $args['order'] || 'asc' === $args['order'] ) ) {
			$order = 'ASC';
		}

		if ( isset( $args['select'] ) ) {
			$select = implode( ', ', $args['select'] );
			$select = trim( $select );
			$select = rtrim( $select );
		}

		$build_sql = "SELECT $select FROM `$this->table_name`";
		$order_sql = " ORDER BY $order_by $order LIMIT $limit OFFSET $offset";

		if ( $search_params || ! empty( $args['where'] ) && is_array( $args['where'] ) ) {
			$where_statement  = '';
			$search_statement = '';
			$prepare_array    = array();

			if ( ! empty( $args['where'] ) ) {
				foreach ( $args['where'] as $key => $value ) {
					if ( ! empty( $where_statement ) ) {
						$where_statement .= ' AND ';
					}
					$sprintf_identifier = $this->get_sprintf( $value );
					if ( ! $sprintf_identifier ) {
						continue;
					}
					$prepare_array[] = $value;
					if ( in_array( $key, $like_params, true ) ) {
						$where_statement .= $key . " LIKE '%%%s%%'";
					} else {
						$where_statement .= $key . ' = ' . $sprintf_identifier;
					}
				}
			}

			if ( $search_params ) {
				foreach ( $search_params as $key => $value ) {
					if ( strlen( $search_statement ) === 0 ) {
						if ( strlen( $where_statement ) ) {
							$search_statement .= ' AND ';
						}
						$search_statement .= '(';
					} else {
						$search_statement .= ' OR';
					}
					$search_statement .= " $key LIKE '%%%s%%' ";
					$prepare_array[]   = $value;
				}
				$search_statement .= ')';
			}
			$build_sql          = $build_sql . ' WHERE ' . $where_statement . $search_statement . $order_sql;
			$prepared_statement = $wpdb->prepare( $build_sql, $prepare_array );

			$results = $wpdb->get_results( $prepared_statement );
		} else {
			$results = $wpdb->get_results( $build_sql . $order_sql );
		}

		$results = $this->after_find( $results );

		return $results;
	}
	/**
	 * Lifecycle Hook that provides each item in a find response
	 * @param  array $data Returned DB data array
	 * @return array $data Returned DB data array after filters on each item
	**/
	public function after_find( $data ) {
		foreach ( $data as &$item ) {
			$item        = apply_filters( 'mv_dbi_after_find', $item, $this->table_name );
			$filter_name = 'mv_dbi_after_find_' . $this->short_name;
			$item        = apply_filters( $filter_name, $item );
		}
		return $data;
	}

	/**
	 * Retrieve an entire SQL result set from the database
	 * @deprecated Use $this->find() instead
	 *
	 * @param  array  $args                Array containing basic SQL arguments
	 * @param  array  $prepared_statement Optional. Prepared SQL statement
	 * @return object Database query results
	 *
	 * TODO: Make this function use $this->find
	 */
	public function select( $args = array(), $prepared_statement = null ) {
		global $wpdb;

		$limit    = 50;
		$offset   = 0;
		$order_by = 'id';
		$order    = 'DESC';

		if ( isset( $args['limit'] ) ) {
			$limit = (int) $args['limit'];
		}

		if ( isset( $args['offset'] ) ) {
			$offset = (int) $args['offset'];
		}

		if ( isset( $args['order_by'] ) ) {
			$order_by = $args['order_by'];
		}

		if ( isset( $args['order'] ) && ( 'ASC' === $args['order'] || 'asc' === $args['order'] ) ) {
			$order = 'ASC';
		}

		if ( ! $prepared_statement ) {
			// All inbound data is sanitized, additionally using wpdb->prepare resulted in invalid SQL
			$prepared_statement = "SELECT * FROM `$this->table_name` ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
		}

		$select = $wpdb->get_results( $prepared_statement );

		return $select;

	}

	// TODO: This doesn't do anything useful
	public function before_delete( $data ) {
		apply_filters( 'mv_dbi_before_delete', $data, $this->table_name );
		$filter_name = 'mv_dbi_before_delete_' . $this->short_name;
		$data        = apply_filters( $filter_name, $data );
		return;
	}

	// TODO: This doesn't do anything useful
	public function after_delete( $data ) {
		apply_filters( 'mv_dbi_after_delete', $data, $this->table_name );
		$filter_name = 'mv_dbi_after_delete_' . $this->short_name;
		$data        = apply_filters( $filter_name, $data );
		return $data;
	}

	public function delete( $args ) {
		global $wpdb;
		$item_to_delete = null;

		$defaults = apply_filters(
			"mv_db_select_one_defaults_{$this->table_name}", array(
				'col' => 'id',
				'key' => null,
			)
		);

		// If $args not array, set key as id
		if ( ! is_array( $args ) ) {
			$args           = array( 'key' => $args );
			$item_to_delete = $this->find_one_by_id( $args );
		}

		$args = array_merge( $defaults, $args );

		if ( $item_to_delete ) {
			$this->before_delete( $item_to_delete );
		}

		$where_array                 = array();
		$where_array[ $args['col'] ] = $args['key'];

		if ( ! empty( $args['where'] ) ) {
			$where_array = $args['where'];
		}

		$deleted = $wpdb->delete( $this->table_name, $where_array );

		if ( $deleted ) {
			$data = $this->after_delete( $item_to_delete );
			return $data;
		}

		return false;
	}

	public function delete_by_id( $object_id ) {
		$delete = $this->delete( $object_id );

		return $delete;
	}

	function append_relationships( $item, $new_item, $relationships ) {
		$all_relationships = $relationships;

		if ( ! empty( $item->object_id ) ) {
			$item_permalink = get_the_permalink( $item->object_id );
			$post_title     = get_the_title( $item->object_id );
			$post_type      = get_post_type( $item->object_id );

			$all_relationships[ $post_type ]                            = array();
			$all_relationships[ $post_type ]['attributes']['id']        = $item->object_id;
			$all_relationships[ $post_type ]['attributes']['title']     = $post_title;
			$all_relationships[ $post_type ]['attributes']['permalink'] = $item_permalink;
		}

		if ( ! empty( $all_relationships ) ) {
			$new_item['relationships'] = $all_relationships;
		}

		return $new_item;
	}

	public function prepare_item( $item, $relationships = array() ) {
		$new_item = array();

		$new_item['type'] = $item->type;
		$new_item['id']   = intval( $item->id );
		unset( $item->id );
		unset( $item->type );
		foreach ( $item as $key => $value ) {
			$new_item['attributes'][ $key ] = '';
			// 0 and '0' should be allowed
			if ( $item->{$key} || ( 0 === $item->{$key} ) || ( '0' === $item->{$key} ) ) {
				$new_item['attributes'][ $key ] = $value;
			}

			// Make dates UNIX timestamps
			if ( in_array( $key, array( 'created', 'modified', 'published' ), true ) ) {
				$new_item['attributes'][ $key ] = mysql2date( 'U', $value );
			}
		}

		$new_item = $this->append_relationships( $item, $new_item, $relationships );

		return $new_item;
	}

	/**
	 * Returns the total number of results of a db query, ignoring limits.
	 * @param  array $args Array of arguments
	 * @return integer Number of results
	 */
	public function get_count( $args, $search_params = null ) {
		$no_limit_args = array_merge(
			$args, array(
				'limit'  => 999999,
				'offset' => 0,
			)
		);
		$results       = $this->find( $no_limit_args, $search_params );
		return count( $results );
	}

	public function allow_null( $query ) {
		return str_ireplace( "'NULL'", 'NULL', $query );
	}
}
