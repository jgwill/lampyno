<?php
namespace Mediavine\MCP;

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This plugin requires WordPress' );
}

class MV_DBI {

	public $table_name = null;

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
						created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',";
		$key_clause = '';

		foreach ( $fields as $key => $array ) {
			$default  = '';
			$col_type = 'longtext';

			if ( isset( $array['type'] ) ) {
				self::graph_type_to_sql( $array['type'] );
			}

			if ( isset( $array['col'] ) ) {
				if ( isset( $array['col']['default'] ) ) {
					$default = "NOT NULL DEFAULT '{$array['col']['default']}' ";
				}
				if ( isset( $array['col']['col_type'] ) ) {
					$col_type = $array['col']['col_type'];
				}
				if ( isset( $array['col']['unique'] ) && $array['col']['unique'] ) {
					$key_clause .= "UNIQUE KEY {$key} ({$key}),";
				}
			}

			$sql .= "{$key} {$col_type}{$default},";
		}

		$sql .= $key_clause;
		$sql .= 'PRIMARY  KEY (id)';

		return $sql;
	}

	public static function create_schema_tables( $graphql_fields, $table_name, $db_version ) {
		$table = array(
			'version'    => $db_version,
			'table_name' => $table_name,
			'sql'        => self::schema_to_sql( $graphql_fields ),
		);
		self::create_table( $table );
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
		$models = new \Mediavine\MCP\Models();
		global $wpdb;

		if ( $plugin_prefix ) {
			$query   = $wpdb->esc_like( $wpdb->prefix . $plugin_prefix );
			$query   = $query . '%';
			$results = $wpdb->get_results( $wpdb->prepare( 'SHOW TABLES LIKE %s', $query ) ); //db call ok; no-cache ok;

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

	public static function upgrade_database_check( $plugin_name, $db_version ) {
		if ( get_option( $plugin_name . '_db_version' ) !== $db_version ) {
			self::create_custom_tables();
		}
	}

	public function __construct( $table_name ) {
		global $wpdb;

		$this->table_name = $wpdb->prefix . $table_name;
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
		$columns         = $wpdb->get_col( 'DESC ' . $this->table_name, 0 ); // db call ok; no-cache ok; unprepared SQL ok;
		foreach ( $columns as $column_name ) {
			if ( isset( $data[ $column_name ] ) ) {
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
		return $this->insert( $data );
	}

	public function before_create( $data ) {
		$data = apply_filters( 'mv_dbi_before_create', $data, $this );
		return $data;
	}

	public function after_create( $data ) {
		$data = apply_filters( 'mv_dbi_after_create', $data, $this );
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
		$wpdb->hide_errors();

		$date             = date( 'Y-m-d H:i:s' );
		$data['created']  = $date;
		$data['modified'] = $date;

		$data = $this->before_create( $data );

		$normalized_data = $this->normalize_data( $data );
		$insert          = $wpdb->insert( $this->table_name, $normalized_data ); //db call ok; no-cache ok;

		if ( $insert ) {
			$new_record = $this->select_one_by_id( $wpdb->insert_id );
			$new_record = $this->after_create( $new_record );
			return $new_record;
		}

		return $insert;
	}

	public function find_or_create( $data, $where_array = null ) {
		global $wpdb;
		$wpdb->hide_errors();

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
		$wpdb->hide_errors();

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
		$data = apply_filters( 'mv_dbi_before_update', $data, $this );
		return $data;
	}

	public function after_update( $data ) {
		$data = apply_filters( 'mv_dbi_after_update', $data, $this );
		return $data;
	}

	public function update( $data, $args = null, $return_updated = true ) {
		global $wpdb;
		$wpdb->hide_errors();

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
		$update = $wpdb->update( $this->table_name, $normalized_data, array( $args['col'] => $key ), $args['format'], $args['where_format'] ); // db call ok; no-cache ok;
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
			$record = $this->before_update( $record );
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
		$wpdb->hide_errors();

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

		foreach ( $args['where'] as $key => $value ) {
			if ( ! empty( $where_statement ) ) {
				$where_statement .= ' AND ';
			}
			$sprintf_identifier = $this->get_sprintf( $value );
			if ( ! $sprintf_identifier ) {
				continue;
			}
			$prepare_array[]  = $value;
			$where_statement .= $key . ' = ' . $sprintf_identifier;
		}

		$build_sql = "SELECT * FROM `$this->table_name` WHERE " . $where_statement;
		$select    = $wpdb->get_results( $wpdb->prepare( $build_sql, $prepare_array ) ); // db call ok; no-cache ok; unprepared SQL ok;

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
		$wpdb->hide_errors();

		$results  = array();
		$limit    = 50;
		$offset   = 0;
		$order_by = 'created';
		$order    = 'DESC';

		// Array of params that should be handled with LIKE, not =
		// This probably won't ever change, since would only be used by search, practically.
		$like_params = array(
			'published_recipe',
			'title',
		);

		if ( isset( $args['prepared_statement'] ) ) {
			$results = $wpdb->get_results( $args['prepared_statement'] ); // db call ok; no-cache ok; unprepared SQL ok;
			return $results;
		}

		$default_statement = "SELECT * FROM `$this->table_name` ORDER BY $order_by $order LIMIT $limit OFFSET $offset";

		if ( empty( $args ) && ! $search_params ) {
			$results = $wpdb->get_results( $default_statement ); // db call ok; no-cache ok; unprepared SQL ok;
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
		if ( isset( $args['order'] ) && 'ASC' === $args['order'] ) {
			$order = 'ASC';
		}

		$build_sql = "SELECT * FROM `$this->table_name`";
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
			$prepared_statement = $wpdb->prepare( $build_sql, $prepare_array ); // db call ok; no-cache ok; unprepared SQL ok;
			$results            = $wpdb->get_results( $prepared_statement ); // db call ok; no-cache ok; unprepared SQL ok;
		} else {
			$results = $wpdb->get_results( $build_sql . $order_sql ); // db call ok; no-cache ok; unprepared SQL ok;
		}

		return $results;
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
		$wpdb->hide_errors();

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

		if ( isset( $args['order'] ) && 'ASC' === $args['order'] ) {
			$order = 'ASC';
		}

		if ( ! $prepared_statement ) {
			// All inbound data is sanitized, additionally using wpdb->prepare resulted in invalid SQL
			$prepared_statement = "SELECT * FROM `$this->table_name` ORDER BY $order_by $order LIMIT $limit OFFSET $offset";
		}

		$select = $wpdb->get_results( $prepared_statement ); // db call ok; no-cache ok; unprepared SQL ok;

		return $select;

	}

	public function before_delete( $data ) {
		apply_filters( 'mv_dbi_before_delete', $data, $this );
		return;
	}

	public function after_delete( $data ) {
		apply_filters( 'mv_dbi_after_delete', $data, $this );
		return;
	}

	public function delete( $args ) {
		global $wpdb;
		$wpdb->hide_errors();

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

		$this->before_delete( $args );

		$where_array                 = array();
		$where_array[ $args['col'] ] = $args['key'];

		$deleted = $wpdb->delete( $this->table_name, $where_array ); // db call ok; no-cache ok; unprepared SQL ok;

		if ( $deleted ) {
			$this->after_delete( $deleted );
			return true;
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
			if ( in_array( $key, array( 'created', 'modified' ), true ) ) {
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
