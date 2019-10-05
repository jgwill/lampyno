<?php

/**
 * Holds the functions needed for the admin settings page.
 *
 * @since 1.0
 */
class CPT_onomies_Admin_Settings {

	public $options_page,
		$is_network_admin,
		$admin_url,
		$manage_options_capability,
		$dismiss_ids,
		$thickbox_network_sites;

	/**
	 * Holds the class instance.
	 *
	 * @since	1.3.5
	 * @access	private
	 * @var		CPT_onomies_Admin_Settings
	 */
	private static $instance;

	/**
	 * Returns the instance of this class.
	 *
	 * @access  public
	 * @since   1.3.5
	 * @return	CPT_onomies_Admin_Settings
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			$class_name = __CLASS__;
			self::$instance = new $class_name;
		}
		return self::$instance;
	}

	/**
	 * Adds WordPress hooks (actions and filters).
	 *
	 * This function is only run in the admin.
	 *
	 * @since   1.0
	 * @uses    $cpt_onomies_manager
	 */
	protected function __construct() {
		global $cpt_onomies_manager;

		if ( is_admin() ) {

			/*
			 * Lets us know if we're dealing with a multisite
			 * and on the network admin page.
			 *
			 * Also, defines admin url and capability for users
			 * to be able to edit options.
			 */
			if ( is_multisite() && is_network_admin() ) {

				$this->is_network_admin = true;
				$this->admin_url = network_admin_url( 'settings.php' );
				$this->manage_options_capability = 'manage_network_options';

				// The network admin picks up the settings for the main blog so we need to clear them out.
				$cpt_onomies_manager->user_settings['custom_post_types'] = array();
				$cpt_onomies_manager->user_settings['other_custom_post_types'] = array();

			} else {

				$this->is_network_admin = false;
				$this->admin_url = admin_url( 'options-general.php' );
				$this->manage_options_capability = 'manage_options';

			}

			// Will show thickbox of network site information.
			$this->thickbox_network_sites = $this->is_network_admin ? ( ' <a href="' . add_query_arg( array( 'action' => 'custom_post_type_onomy_get_network_sites' ), admin_url( 'admin-ajax.php' ) ) . '" class="thickbox" title="' . ( ( $network_name = get_site_option( 'site_name' ) ) ? $network_name : 'Sites' ) . '">' . __( 'View Network Site Information', 'cpt-onomies' ) . '</a>' ) : null;

			// Adds a settings link to the plugins page.
			add_filter( 'network_admin_plugin_action_links_' . CPT_ONOMIES_PLUGIN_FILE, array( $this, 'add_plugin_action_links' ), 10, 4 );
			add_filter( 'plugin_action_links_' . CPT_ONOMIES_PLUGIN_FILE, array( $this, 'add_plugin_action_links' ), 10, 4 );

			// Update multisite settings.
			add_action( 'update_wpmu_options', array( $this, 'update_network_plugin_options_custom_post_types' ) );

			// Register/update site settings.
			add_action( 'admin_init', array( $this, 'register_user_settings' ) );

			// Add multisite plugin options page.
			add_action( 'network_admin_menu', array( $this, 'add_network_plugin_options_page' ) );

			// Add site plugin options page.
			add_action( 'admin_menu', array( $this, 'add_plugin_options_page' ) );
			add_action( 'admin_head-settings_page_' . CPT_ONOMIES_OPTIONS_PAGE, array( $this, 'add_plugin_options_page_meta_boxes' ) );

			// Takes care of actions on all plugin options pages.
			add_action( 'admin_init', array( $this, 'manage_plugin_options_actions' ) );

			// Add styles and scripts for all plugin options pages.
			add_action( 'admin_print_styles-settings_page_' . CPT_ONOMIES_OPTIONS_PAGE, array( $this, 'add_plugin_options_styles' ) );
			add_action( 'admin_print_scripts-settings_page_' . CPT_ONOMIES_OPTIONS_PAGE, array( $this, 'add_plugin_options_scripts' ) );

			// AJAX functions for all plugin options pages.
			add_action( 'wp_ajax_custom_post_type_onomy_get_network_sites', array( $this, 'ajax_print_network_sites' ) );
			add_action( 'wp_ajax_custom_post_type_onomy_validate_if_post_type_exists', array( $this, 'ajax_validate_plugin_options_if_post_type_exists' ) );
			add_action( 'wp_ajax_custom_post_type_onomy_update_edit_custom_post_type_closed_edit_tables', array( $this, 'ajax_update_plugin_options_edit_custom_post_type_closed_edit_tables' ) );
			add_action( 'wp_ajax_custom_post_type_onomy_update_edit_custom_post_type_dismiss', array( $this, 'ajax_update_plugin_options_edit_custom_post_type_closed_dismiss' ) );

		}
	}

	/**
	 * Method to keep our instance from being cloned.
	 *
	 * @since	1.3.5
	 * @access	private
	 * @return	void
	 */
	private function __clone() {}

	/**
	 * Method to keep our instance from being unserialized.
	 *
	 * @since	1.3.5
	 * @access	private
	 * @return	void
	 */
	private function __wakeup() {}

	/**
	 * Adds a settings link to network and site plugins page.
	 *
	 * This function is invoked by the filter 'plugin_action_links'.
	 *
	 * @since   1.0
	 * @param   $actions - array - An array of plugin action links.
	 * @param   $plugin_file - string  - Path to the plugin file relative to the plugins directory.
	 * @param   $plugin_data - array - An array of plugin data.
	 * @param   $context - string - The plugin context. Defaults are 'All', 'Active',
	 *              'Inactive', 'Recently Activated', 'Upgrade', 'Must-Use', 'Drop-ins', 'Search'.
	 * @return  array - the links info after it has been filtered
	 */
	public function add_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {

		// Make sure plugin is network activated.
		if ( ! $this->is_network_admin || ( $this->is_network_admin && function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( $plugin_file ) ) ) {
			$actions['settings'] = '<a href="' . ( $this->is_network_admin ? 'settings' : 'options-general' ) . '.php?page=' . CPT_ONOMIES_OPTIONS_PAGE . '" title="' . sprintf( esc_attr__( 'Visit the %s settings page', 'cpt-onomies' ), 'CPT-onomies' ) . '">' . __( 'Settings', 'cpt-onomies' ) . '</a>';
		}

		return $actions;
	}

	/**
	 * Registers user's plugin settings.
	 *
	 * This function is invoked by the action 'admin_init'.
	 *
	 * @since 1.0
	 */
	public function register_user_settings() {
		register_setting( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types', 'custom_post_type_onomies_custom_post_types', array( $this, 'update_plugin_options_custom_post_types' ) );
		register_setting( CPT_ONOMIES_OPTIONS_PAGE . '-other-custom-post-types', 'custom_post_type_onomies_other_custom_post_types', array( $this, 'update_validate_plugin_options_other_custom_post_types' ) );
	}

	/**
	 * Returns the count of any still existing taxonomy terms
	 * under the same name as a current CPT-onomy.
	 *
	 * @since   1.3.4
	 * @uses    $wpdb
	 * @param   string - the CPT-onomy's name, aka post type
	 * @return  int|false - number of conflicting terms assigned to a CPT-onomy's matching taxonomy or false, if none exist
	 */
	private function get_conflicting_taxonomy_terms_count( $post_type ) {
		global $wpdb;

		// Not in the network admin.
		if ( $this->is_network_admin ) {
			return false;
		}

		// First check both the taxonomy and terms tables together.
		$terms_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->term_taxonomy} term_tax INNER JOIN {$wpdb->terms} terms ON terms.term_id = term_tax.term_id WHERE term_tax.taxonomy = %s GROUP BY term_tax.term_id", $post_type ) );
		if ( $terms_count > 0 ) {
			return $terms_count;
		}

		// Then check just the taxonomy table.
		$terms_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->term_taxonomy} WHERE taxonomy = %s", $post_type ) );
		if ( $terms_count > 0 ) {
			return $terms_count;
		}

		return false;
	}

	/**
	 * Deletes any still existing taxonomy terms
	 * under the same name as a current CPT-onomy.
	 *
	 * @since   1.3.4
	 * @uses    $wpdb
	 * @param   string - the CPT-onomy's name, aka post type
	 * @return  int|false - the number of terms that were deleted, or false if no terms were deleted
	 */
	private function delete_conflicting_taxonomy_terms( $post_type ) {
		global $wpdb;

		// First, we need terms info for this particular taxonomy.
		$terms_info = $wpdb->get_results( $wpdb->prepare( "SELECT term_id, term_taxonomy_id FROM {$wpdb->term_taxonomy} WHERE taxonomy = %s", $post_type ) );
		if ( ! empty( $terms_info ) ) {

			foreach ( $terms_info as $term ) {

				// Delete the term.
				$wpdb->delete( $wpdb->terms, array( 'term_id' => $term->term_id ), array( '%d' ) );

				// Delete the term taxonomy info
				$wpdb->delete( $wpdb->term_taxonomy, array(
					'term_taxonomy_id' => $term->term_taxonomy_id,
					'taxonomy' => $post_type,
					), array(
						'%d',
						'%s',
					)
				);

				// Delete any term relationships.
				$wpdb->delete( $wpdb->term_relationships, array( 'term_taxonomy_id' => $term->term_taxonomy_id ), array( '%d' ) );

			}

			return count( $terms_info );
		}

		return false;
	}

	/**
	 * This function allows the settings page to detect if we
	 * are editing a custom post type, and whether that post type is
	 * 'new' or an 'other' post type.
	 *
	 * We can't just check for post types that exist because
	 * we allow the user to 'deactivate' post types so we need to
	 * check the settings.
	 *
	 * Used to be named 'detect_custom_post_type_new_edit_other'.
	 * Renamed in 1.3.1
	 *
	 * @since   1.1, renamed in 1.3.1
	 * @uses    $cpt_onomies_manager
	 * @return  array of 'new', 'edit' and 'other' values
	 */
	private function detect_settings_page_variables() {
		global $cpt_onomies_manager;

		// Figuring out if it's new is pretty simple.
		$new = ( isset( $_REQUEST['edit'] ) && strtolower( $_REQUEST['edit'] ) == 'new' ) ? true : false;

		// If its not new, then check to see if the name exists in the settings.
		if ( $edit = ( ! $new && isset( $_REQUEST['edit'] ) ) ? strtolower( $_REQUEST['edit'] ) : false ) {

			// Check to see if CPT exists in settings.
			foreach ( array( 'edit' ) as $cpt_key_to_check ) {

				if ( ${$cpt_key_to_check} ) {

					/*
					 * For network settings.
					 *
					 * Otherwise, for site settings.
					 */
					if ( $this->is_network_admin ) {

						// If it doesn't exist in the network settings, it doesn't exist.
						if ( ! ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && array_key_exists( ${$cpt_key_to_check}, $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) ) {
							${$cpt_key_to_check} = false;
						}
					} else {

						if ( ! ( ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( ${$cpt_key_to_check}, $cpt_onomies_manager->user_settings['custom_post_types'] ) )
							|| ( isset( $_REQUEST['other'] ) && isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( ${$cpt_key_to_check}, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) )
							|| ( ! ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( ${$cpt_key_to_check}, $cpt_onomies_manager->user_settings['custom_post_types'] ) ) && ! ( isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( ${$cpt_key_to_check}, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) && ! ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && array_key_exists( ${$cpt_key_to_check}, $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) && post_type_exists( ${$cpt_key_to_check} ) ) ) ) {
							${$cpt_key_to_check} = false;
						}
					}
				}
			}
		}

		// We need to know if the custom post type was created by our plugin, or someone else.
		if ( $other = ( ! $this->is_network_admin && ! $new && $edit ) ? true : false ) {

			$cpt_key_to_check = $edit;

			$other = ( isset( $_REQUEST['other'] ) && ( ! $cpt_onomies_manager->is_registered_cpt( $cpt_key_to_check ) || isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( $cpt_key_to_check, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) )
					||
				( ! isset( $_REQUEST['other'] ) && ( ( ! ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( $cpt_key_to_check, $cpt_onomies_manager->user_settings['custom_post_types'] ) ) && isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( $cpt_key_to_check, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) || ( ! ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( $cpt_key_to_check, $cpt_onomies_manager->user_settings['custom_post_types'] ) ) && ! ( isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( $cpt_key_to_check, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) && post_type_exists( $cpt_key_to_check ) ) ) )
					? true : false;

		}

		return array( 'new' => $new, 'edit' => $edit, 'other' => $other );
	}

	/**
	 * This function allows the settings page to detect if we have any issues
	 * with the custom post type and/or CPT-onomy settings.
	 *
	 * Because WordPress gives the network admin a blog ID of 1, it's too difficult
	 * to troubleshoot/validate network-registered custom post types so, with the exception
	 * being inactive, all error messages are disabled for now.
	 *
	 * @since   1.2
	 * @uses    $cpt_onomies_manager, $blog_id
	 * @return  array of 'inactive_cpt', 'is_registered_cpt', 'overwrote_network_cpt',
	 *		'is_registered_cpt_onomy', 'programmatic_cpt_onomy', 'should_be_cpt_onomy',
	 *		'attention_cpt' and 'attention_cpt_onomy'
	 */
	private function detect_custom_post_type_message_variables( $post_type, $cpt, $other ) {
		global $cpt_onomies_manager, $blog_id;

		$inactive_cpt = isset( $cpt->deactivate ) ? true : false;

		$is_registered_cpt = ( post_type_exists( $post_type ) && ( ! $this->is_network_admin && ! $cpt_onomies_manager->is_registered_network_cpt( $post_type ) && ( ( ! $other && $cpt_onomies_manager->is_registered_cpt( $post_type ) ) || ( $other && ! $cpt_onomies_manager->is_registered_cpt( $post_type ) ) ) ) ) ? true : false;

		$overwrote_network_cpt = ( ! $this->is_network_admin && $cpt_onomies_manager->overwrote_network_cpt( $post_type ) ) ? true : false;

		$is_registered_cpt_onomy = ( ! $this->is_network_admin && $is_registered_cpt && taxonomy_exists( $post_type ) && $cpt_onomies_manager->is_registered_cpt_onomy( $post_type ) ) ? true : false;

		$programmatic_cpt_onomy = ( ! $this->is_network_admin && $is_registered_cpt_onomy && ! get_taxonomy( $post_type )->created_by_cpt_onomies ) ? true : false;

		$should_be_cpt_onomy = ( ! $this->is_network_admin && isset( $cpt->attach_to_post_type ) && ! empty( $cpt->attach_to_post_type ) ) ? true : false;

		$attention_cpt = ( ! $this->is_network_admin && ! $inactive_cpt && ! $is_registered_cpt ) ? true : false;

		$attention_cpt_onomy = ( ! $this->is_network_admin && ! $inactive_cpt && $should_be_cpt_onomy && ( $attention_cpt || ! $is_registered_cpt_onomy ) ) ? true : false;

		/*
		 * If attention doesn't already need to be paid to the CPT-onomy,
		 * check to see if it has any plain taxonomy terms assigned to it
		 * i.e. there used to be a taxononmy with this name that needs to
		 * have some terms removed If we have conflicting terms, then this
		 * CPT-onomy needs attention.
		 */
		if ( ! $this->is_network_admin
			&& ! $attention_cpt_onomy
			&& ( $conflicting_terms_count = $this->get_conflicting_taxonomy_terms_count( $post_type ) )
			&& $conflicting_terms_count > 0 ) {

			$attention_cpt_onomy = true;

		}

		return array(
			'inactive_cpt' => $inactive_cpt,
			'is_registered_cpt' => $is_registered_cpt,
			'overwrote_network_cpt' => $overwrote_network_cpt,
			'is_registered_cpt_onomy' => $is_registered_cpt_onomy,
			'programmatic_cpt_onomy' => $programmatic_cpt_onomy,
			'should_be_cpt_onomy' => $should_be_cpt_onomy,
			'attention_cpt' => $attention_cpt,
			'attention_cpt_onomy' => $attention_cpt_onomy,
		);
	}

	/**
	 * Returns site information for all sites on the network.
	 *
	 * @since 1.3
	 */
	public function get_network_sites() {
		global $wpdb;

		$network_blogs = $wpdb->get_col( $wpdb->prepare( "SELECT blog_id FROM {$wpdb->blogs} WHERE archived IN ( 0, '0' ) ORDER BY blog_id", null ) );
		$network_blogs_details = array();

		foreach ( $network_blogs as $this_blog_id ) {
			$network_blogs_details[ $this_blog_id ] = get_blog_details( $this_blog_id );
		}

		return $network_blogs_details;
	}

	/**
	 * Prints a table of network site info for an AJAX call.
	 *
	 * @since 1.3
	 */
	public function ajax_print_network_sites() {

		$network_blogs = $this->get_network_sites();

		if ( ! is_multisite() ) :

			?>
			<p><?php _e( 'You are not running a WordPress multisite and therefore only have one site/blog with a blog ID of 1.', 'cpt-onomies' ); ?></p>
			<?php

		elseif ( is_multisite() && ! $network_blogs ) :

			?>
			<p><?php echo sprintf( __( 'You are running a WordPress multisite but there seems to have been a problem retrieving your site information. If the problem persists, %1$svisit your "Sites" page%2$s for more information.', 'cpt-onomies' ), '<a href="' . esc_url( network_admin_url( 'sites.php' ) ) . '">', '</a>' ); ?></p>
			<?php

		else :

			?>
			<table id="thickbox-network-sites" cellpadding="0" cellspacing="0" border="0">
				<thead>
					<tr>
						<th class="blog_id">Blog ID</th>
						<th>Blog Name</th>
						<th>Blog Path</th>
					</tr>
				</thead>
				<tbody>
					<?php

					foreach ( $network_blogs as $this_blog_id => $this_blog ) :

						?>
						<tr>
							<td><?php echo $this_blog->blog_id; ?></td>
							<td><a href="<?php echo get_admin_url( $this_blog_id ); ?>" target="_blank"><?php echo $this_blog->blogname; ?></a></td>
							<td><?php echo $this_blog->path; ?></td>
						</tr>
						<?php

					endforeach;

					?>
				</tbody>
			</table>
			<?php

		endif;

		die();

	}

	/**
	 * This ajax function is run on the "edit" custom post type page.
	 * It tells the script whether or not the post type name the
	 * user is trying to enter already exists.
	 *
	 * It checks using the function post_type_exists() and looks for the post type
	 * in the user's settings. There's no need to check the "other" post types because
	 * these post types are tested by post_type_exists() while post types created by
	 * this plugin could be "deactivated" so we need to check the settings.
	 *
	 * This function is invoked by the action 'wp_ajax_custom_post_type_onomy_validate_if_post_type_exists'.
	 *
	 * @since 1.0
	 */
	public function ajax_validate_plugin_options_if_post_type_exists() {
		global $cpt_onomies_manager;

		// Get post type info.
		$custom_post_type_onomies_is_network_admin = ( isset( $_POST['custom_post_type_onomies_is_network_admin'] ) && $_POST['custom_post_type_onomies_is_network_admin'] ) ? true : false;
		$original_custom_post_type_name = ( isset( $_POST['original_custom_post_type_onomies_cpt_name'] ) && ! empty( $_POST['original_custom_post_type_onomies_cpt_name'] ) ) ? $_POST['original_custom_post_type_onomies_cpt_name'] : null;
		$custom_post_type_name = ( isset( $_POST['custom_post_type_onomies_cpt_name'] ) && ! empty( $_POST['custom_post_type_onomies_cpt_name'] ) ) ? $_POST['custom_post_type_onomies_cpt_name'] : null;

		if ( ( ( ! empty( $original_custom_post_type_name ) && ! empty( $custom_post_type_name ) && $custom_post_type_name != $original_custom_post_type_name ) || ( empty( $original_custom_post_type_name ) && ! empty( $custom_post_type_name ) ) ) && ( ( $custom_post_type_onomies_is_network_admin && array_key_exists( $custom_post_type_name, $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) || ( ! $custom_post_type_onomies_is_network_admin && ( ( post_type_exists( $custom_post_type_name ) && ( ! $cpt_onomies_manager->is_registered_network_cpt( $custom_post_type_name ) ) ) || array_key_exists( $custom_post_type_name, $cpt_onomies_manager->user_settings['custom_post_types'] ) ) ) ) ) {
			echo false;
		} else {
			echo 'true';
		}

		die();
	}

	/**
	 * This ajax function is run on the "edit" custom post type page.
	 * It detects when the user has "opened" or "closed" an advanced
	 * edit table and updates the user_option accordingly.
	 *
	 * This function is invoked by the action 'wp_ajax_custom_post_type_onomy_update_edit_custom_post_type_closed_edit_tables'.
	 *
	 * @since   1.0
	 * @uses    $user_ID
	 */
	public function ajax_update_plugin_options_edit_custom_post_type_closed_edit_tables() {
		global $user_ID;

		// Get the table we're editing.
		$edit_table = ( isset( $_POST['custom_post_type_onomies_edit_table'] ) && ! empty( $_POST['custom_post_type_onomies_edit_table'] ) ) ? $_POST['custom_post_type_onomies_edit_table'] : null;
		if ( $edit_table ) {

			$show = $_POST['custom_post_type_onomies_edit_table_show'];
			if ( 'true' == $show ) {
				$show = true;
			} else {
				$show = false;
			}

			// Get set option.
			$option_name = 'custom_post_type_onomies_show_edit_tables';
			$saved_option = get_user_option( $option_name, $user_ID );

			/*
			 * We need to make sure its saved into the array.
			 *
			 * Otherwise, we need to make sure its removed from the array.
			 */
			if ( $show ) {

				if ( empty( $saved_option ) || ( ! empty( $saved_option ) && ! in_array( $edit_table, $saved_option ) ) ) {
					$saved_option[] = $edit_table;
				}
			} elseif ( ! empty( $saved_option ) && in_array( $edit_table, $saved_option ) ) {

				foreach ( $saved_option as $key => $value ) {
					if ( $value == $edit_table ) {
						unset( $saved_option[ $key ] );
					}
				}
			}

			// Update the database.
			update_user_option( $user_ID, $option_name, $saved_option, true );

		}
		die();
	}

	/**
	 *
	 * This function is invoked by the action 'wp_ajax_custom_post_type_onomy_update_edit_custom_post_type_dismiss'.
	 *
	 * @since   1.3
	 * @uses    $user_ID
	 */
	public function ajax_update_plugin_options_edit_custom_post_type_closed_dismiss() {
		global $user_ID;

		$dismiss_id = ( isset( $_POST['custom_post_type_onomies_dismiss_id'] ) && ! empty( $_POST['custom_post_type_onomies_dismiss_id'] ) ) ? $_POST['custom_post_type_onomies_dismiss_id'] : null;
		if ( $dismiss_id ) {

			// Get set option.
			$option_name = 'custom_post_type_onomies_dismiss';
			$saved_option = get_user_option( $option_name, $user_ID );

			// We need to make sure its saved into the array
			if ( empty( $saved_option ) || ( ! empty( $saved_option ) && ! in_array( $dismiss_id, $saved_option ) ) ) {
				$saved_option[] = $dismiss_id;
			}

			// Update the database
			update_user_option( $user_ID, $option_name, $saved_option, true );

		}
		die();
	}

	/**
	 * Validates/updates user's network-registered plugin settings.
	 *
	 * If saving the "edit" options page and a new custom post type is added,
	 * the function will edit the redirect to show new CPT.
	 *
	 * This function is invoked by the action 'update_wpmu_options'.
	 *
	 * @since   1.3
	 * @uses    $cpt_onomies_manager
	 */
	public function update_network_plugin_options_custom_post_types() {
		global $cpt_onomies_manager;

		/*
		 * Makes sure we're in the network admin saving the
		 * network admin options for CPT-onomies.
		 */
		if ( current_user_can( $this->manage_options_capability )
			&& check_admin_referer( 'siteoptions' )
			&& isset( $_POST['save_cpt_onomies_changes'] ) ) {

			// Update/validate custom post types.
			if ( isset( $_POST['custom_post_type_onomies_custom_post_types'] )
				&& ( $custom_post_types = $_POST['custom_post_type_onomies_custom_post_types'] ) ) {

				// Get saved settings.
				$saved_post_types = ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) ? $cpt_onomies_manager->user_settings['network_custom_post_types'] : array();

				// Validate settings.
				$custom_post_types = $this->validate_plugin_options_custom_post_types( $custom_post_types, $saved_post_types );

				// Update settings.
				update_site_option( 'custom_post_type_onomies_custom_post_types', $custom_post_types );

				/*
				 * Flushing the rewrite rules helps take care of pesky
				 * rewrite rules not changing when permalinks or other
				 * rewrite settings are tweaked.
				 */
				flush_rewrite_rules( false );

				// If no errors, then show general message.
				if ( ! count( get_settings_errors() ) ) {
					add_settings_error( 'general', 'settings_updated', __( 'Settings saved.', 'cpt-onomies' ), 'updated' );
				}

				// Stores settings errors so they can be displayed on redirect.
				set_transient( 'settings_errors', get_settings_errors(), 30 );

				// Redirect to settings page.
				wp_redirect( add_query_arg( array( 'settings-updated' => 'true' ), $_REQUEST['_wp_http_referer'] ) );
				exit();

			}
		}
	}

	/**
	 * This function updates the 'custom_post_types' setting anytime update_option() is run.
	 * This includes saving the "edit" options page, when a plugin CPT is deleted on the options
	 * page and when a plugin CPT is activated (by link) on the options page.
	 *
	 * If saving the "edit" options page and a new custom post type is added,
	 * the function will edit the redirect to show new CPT.
	 *
	 * @since   1.0, name changed in 1.3
	 * @uses    $cpt_onomies_manager
	 * @param   array $custom_post_types - the custom post type setting that is being updated
	 * @return  array - validated custom post type information
	 */
	public function update_plugin_options_custom_post_types( $custom_post_types ) {
		global $cpt_onomies_manager;

		// Make sure we're saving data from the options page.
		if ( current_user_can( $this->manage_options_capability )
			&& wp_verify_nonce( $_POST['_wpnonce'], CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types-options' ) ) {

			// Get saved settings.
			$saved_post_types = ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) ) ? $cpt_onomies_manager->user_settings['custom_post_types'] : array();

			// Validate settings.
			$custom_post_types = $this->validate_plugin_options_custom_post_types( $custom_post_types, $saved_post_types );

			/*
			 * Flushing the rewrite rules helps take care of pesky
			 * rewrite rules not changing when permalinks or other
			 * rewrite settings are tweaked.
			 */
			flush_rewrite_rules( false );

		}

		// Return settings to be updated by settings API.
		return $custom_post_types;
	}

	/**
	 * This function validates custom post type settings.
	 *
	 * @since   1.3
	 * @param   array $custom_post_types - the custom post type settings that are being validated
	 * @param   array $saved_custom_post_types - the original custom post type settings
	 * @return  array - validated custom post type settings
	 */
	public function validate_plugin_options_custom_post_types( $custom_post_types, $saved_custom_post_types = array() ) {

		if ( current_user_can( $this->manage_options_capability ) && ! empty( $custom_post_types ) ) {

			// If set, will redirect settings page to show specified custom post type.
			$redirect_cpt = null;

			foreach ( $custom_post_types as $cpt_key => $cpt ) {

				// Sanitize the data.
				foreach ( $cpt as $key => $data ) {
					if ( ! is_array( $data ) ) {
						$cpt[ $key ] = strip_tags( $data );
					}
				}

				// Maximum is 20 characters. Can only contain lowercase, alphanumeric characters and underscores.
				$valid_name_preg_test = '/([^a-z0-9\_])/i';

				$original_name = ( isset( $cpt['original_name'] ) && ! empty( $cpt['original_name'] ) && strlen( $cpt['original_name'] ) <= 20 && ! preg_match( $valid_name_preg_test, $cpt['original_name'] ) ) ? strtolower( $cpt['original_name'] ) : null;
				$new_name = ( isset( $cpt['name'] ) && ! empty( $cpt['name'] ) && strlen( $cpt['name'] ) <= 20 && ! preg_match( $valid_name_preg_test, $cpt['name'] ) ) ? strtolower( $cpt['name'] ) : null;
				$label = ( isset( $cpt['label'] ) && ! empty( $cpt['label'] ) ) ? $cpt['label'] : null;

				// If no valid name or label, why bother so remove the data.
				if ( empty( $original_name ) && empty( $new_name ) && empty( $label ) ) {

					unset( $custom_post_types[ $cpt_key ] );
					$redirect_cpt = 'new';

					// Add a settings error to let the user know it was a no go.
					add_settings_error( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types', 'custom-post-type-onomies-custom-post-types-error', __( 'You must provide a valid "Label" or "Name" for the custom post type to be saved.', 'cpt-onomies' ), 'error' );

				} else {

					// Remove names from info.
					if ( isset( $cpt['original_name'] ) ) {
						unset( $cpt['original_name'] );
					}

					// If no label, then add 'Posts'.
					if ( ! isset( $cpt['label'] ) || empty( $cpt['label'] ) ) {
						$cpt['label'] = 'Posts';
					}

					// Will be the name and key for storing data.
					$store_name = null;

					/*
					 * If no original name (new) and new name is empty
					 * OR already exists, take the label and create a name.
					 */
					if ( empty( $original_name ) && ( empty( $new_name ) || ( ! empty( $new_name ) && array_key_exists( $new_name, $saved_custom_post_types ) ) ) ) {

						// Convert spaces to underscores first.
						$made_up_orig = $made_up_name = substr( strtolower( preg_replace( $valid_name_preg_test, '', str_replace( ' ', '_', $cpt['label'] ) ) ), 0, 20 );
						$made_up_index = 1;

						while ( post_type_exists( $made_up_name ) || array_key_exists( $made_up_name, $saved_custom_post_types ) ) {
							$made_up_name = $made_up_orig . $made_up_index;
							$made_up_index++;
						}

						$store_name = $made_up_name;

						/*
						 * The following adds a settings error to let the user know we made up our own name.
						 */

						// They included a name but it was invalid so we made one up
						if ( isset( $cpt['name'] ) && ! empty( $cpt['name'] ) && empty( $new_name ) ) {

							add_settings_error( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types', 'custom-post-type-onomies-custom-post-types-error', sprintf( __( 'The "name" you provided for your custom post type was invalid so %1$s just made one up. If "%2$s" doesn\'t work for you, then make sure you edit the name property below.', 'cpt-onomies' ), 'CPT-onomies', $store_name ), 'error' );

						} elseif ( empty( $new_name ) ) {

							// The name was empty so we made one up
							add_settings_error( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types', 'custom-post-type-onomies-custom-post-types-error', sprintf( __( 'You did not provide a "name" for your custom post type so %1$s just made one up. If "%2$s" doesn\'t work for you, then make sure you edit the name property below.', 'cpt-onomies' ), 'CPT-onomies', $store_name ), 'error' );

						} else {

							// The name is already taken so we made one up
							add_settings_error( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types', 'custom-post-type-onomies-custom-post-types-error', sprintf( __( 'The "name" you provided for your custom post type was already taken so %1$s just made one up. If "%2$s" doesn\'t work for you, then make sure you edit the name property below.', 'cpt-onomies' ), 'CPT-onomies', $store_name ), 'error' );

						}
					} else {

						// If no original name (new) and new name exists then save under new name
						if ( empty( $original_name ) && ! empty( $new_name ) ) {

							$store_name = $new_name;

						} elseif ( empty( $new_name ) && ! empty( $original_name ) ) {

							/*
							 * If no new name and original name exists then save under original name.
							 */

							$store_name = $original_name;

						} elseif ( ! empty( $original_name ) && ! empty( $new_name ) && $new_name != $original_name && array_key_exists( $new_name, $saved_custom_post_types ) ) {

							/*
							 * If both original and new name exist and new is different from original
							 * BUT new name already exists elsewhere.
							 */
							// Store under original name
							$store_name = $original_name;

							// Let the user know why the change didn't stick
							add_settings_error( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types', 'custom-post-type-onomies-custom-post-types-error', sprintf( __( 'The new "name" you provided for your custom post type was already taken so %s restored the original name.', 'cpt-onomies' ), 'CPT-onomies', '"' . $store_name . '"' ), 'error' );

						} elseif ( ! empty( $original_name ) && ! empty( $new_name ) && $new_name != $original_name ) {

							/*
							 * If both original and new name exist and new is
							 * different from original then remove info with
							 * original name and save under new name.
							 */

							// Remove original name
							if ( array_key_exists( $original_name, $saved_custom_post_types ) ) {
								unset( $saved_custom_post_types[ $original_name ] );
							}

							$store_name = $new_name;

						} else {

							// No conflicts. Save info under name new
							$store_name = $new_name;
						}
					}

					// Clean up the capability type.
					if ( isset( $cpt['capability_type'] ) && ! empty( $cpt['capability_type'] ) ) {

						// Can be separated by space or comma.
						$cpt['capability_type'] = str_replace( ', ', ',', trim( $cpt['capability_type'] ) );
						$cpt['capability_type'] = str_replace( ' ', ',', trim( $cpt['capability_type'] ) );
						$cpt['capability_type'] = explode( ',', $cpt['capability_type'] );

						// Only save as array if more than one capability type.
						if ( count( $cpt['capability_type'] ) < 2 ) {

							if ( count( $cpt['capability_type'] ) == 1 ) {
								$cpt['capability_type'] = array_shift( $cpt['capability_type'] );
							} else {
								$cpt['capability_type'] = null;
							}
						}
					}

					// Validating.
					if ( isset( $cpt['register_meta_box_cb'] ) && ! empty( $cpt['register_meta_box_cb'] ) ) {
						$cpt['register_meta_box_cb'] = preg_replace( '/([^a-z0-9\_])/i', '', $cpt['register_meta_box_cb'] );
					}

					// Must be numeric.
					if ( isset( $cpt['menu_position'] ) && ! empty( $cpt['menu_position'] ) && is_numeric( $cpt['menu_position'] ) ) {
						$cpt['menu_position'] = intval( $cpt['menu_position'] );
					} elseif ( isset( $cpt['menu_position'] ) && ! empty( $cpt['menu_position'] ) ) {
						unset( $cpt['menu_position'] );
					}

					// Store data.
					$cpt['name'] = $store_name;
					$saved_custom_post_types[ $store_name ] = $cpt;

					// Redirect.
					$redirect_cpt = $store_name;

				}
			}

			// Sort custom post types (alphabetically) by post type.
			ksort( $saved_custom_post_types );

			// Change the referer URL to change cpt=new to cpt=[new cpt] so that redirect will show recently added cpt.
			if ( isset( $redirect_cpt ) ) {
				$_REQUEST['_wp_http_referer'] = preg_replace( '/(\&edit\=([^\&]*))/i', '&edit=' . $redirect_cpt, $_REQUEST['_wp_http_referer'] );
			}

			return $saved_custom_post_types;
		}

		return $custom_post_types;
	}

	/**
	 * This function validates/updates the "other" custom post types setting anytime update_option() is run.
	 * This function is run on the options page.
	 *
	 * If the "other" custom post type no longer exists, it deletes the settings from the DB.
	 *
	 * @since   1.0, name changed in 1.3
	 * @uses    $cpt_onomies_manager
	 * @param   array $other_custom_post_types - the other custom post type setting that is being updated
	 * @return  array - validated custom post type information
	 */
	public function update_validate_plugin_options_other_custom_post_types( $other_custom_post_types ) {
		global $cpt_onomies_manager;

		// Make sure this is only run when we're saving data from the options page.
		if ( current_user_can( $this->manage_options_capability )
			&& wp_verify_nonce( $_POST['_wpnonce'], CPT_ONOMIES_OPTIONS_PAGE . '-other-custom-post-types-options' ) ) {

			// Get saved settings.
			$saved_other_post_types = ( isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) ? $cpt_onomies_manager->user_settings['other_custom_post_types'] : array();

			// Save information.
			if ( ! empty( $other_custom_post_types ) ) {
				foreach ( $other_custom_post_types as $cpt_key => $cpt ) {
					$saved_other_post_types[ $cpt_key ] = $cpt;
				}
			}

			// Post types that no longer exist are removed from the settings.
			foreach ( $saved_other_post_types as $cpt_key => $cpt ) {
				$post_type_exists = post_type_exists( $cpt_key );
				if ( ! $post_type_exists || ( $post_type_exists && ( $cpt_onomies_manager->is_registered_cpt( $cpt_key ) ) ) ) {
					unset( $saved_other_post_types[ $cpt_key ] );
				}
			}

			// Sort custom post types (alphabetically) by post type.
			ksort( $saved_other_post_types );

			/*
			 * Flushing the rewrite rules helps take care of pesky
			 * rewrite rules not changing when permalinks or other
			 * rewrite settings are tweaked.
			 */
			flush_rewrite_rules( false );

			return $saved_other_post_types;
		}

		return $other_custom_post_types;
	}

	/**
	 * Returns an object that contains the fields/properties
	 * for creating the admin table for creating/managing custom post types.
	 *
	 * This function is only invoked on the plugin's options page and is only
	 * available for users who have capability to manage options.
	 *
	 * As of version 1.2, you can customize yours settings by removing options
	 * and setting default property values using various filters.
	 *
	 * @since   1.0
	 * @uses    $cpt_onomies_manager
	 * @param   string $post_type_being_edited - the custom post type that's being edited. null if creating a new custom post type.
	 * @return  object - the custom post type properties
	 * @filters 'custom_post_type_onomies_attach_to_post_type_property_include_post_type' - $post_type_to_include, $post_type_being_edited
	 *		'custom_post_type_onomies_taxonomies_property_include_taxonomy' - $taxonomy, $post_type_being_edited
	 *		'custom_post_type_onomies_restrict_user_capabilities_property_include_user_role' - $user_role, $post_type_being_edited
	 *		'custom_post_type_onomies_supports_property_include_support' - $support, $post_type_being_edited
	 */
	public function get_plugin_options_page_cpt_properties( $post_type_being_edited = null ) {
		global $cpt_onomies_manager;

		if ( current_user_can( $this->manage_options_capability ) ) {

			// Retrieve saved custom post type data.
			$saved_custom_post_type_data = array();
			if ( $this->is_network_admin ) {

				if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) {
					$saved_custom_post_type_data = $cpt_onomies_manager->user_settings['network_custom_post_types'];
				}
			} elseif ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) ) {
				$saved_custom_post_type_data = $cpt_onomies_manager->user_settings['custom_post_types'];
			}

			// Gather post type data to use in 'attach_post_type' property.
			$attach_to_post_type_data = array();

			// Do not include nav menu items or revisions.
			$do_not_add_to_post_type_data = array( 'nav_menu_item', 'revision' );

			/*
			 * In network admin, only showing network CPTs registered
			 * by CPT-onomies AND remaining builtin post types (posts and pages).
			 */
			if ( $this->is_network_admin ) {

				// Combine saved custom post type data with remaining builtin post types (posts and pages).
				foreach ( array_merge( get_post_types( array( '_builtin' => true ), 'objects' ), $saved_custom_post_type_data ) as $cpt_key => $cpt ) {
					$cpt = (object) $cpt;
					if ( ! empty( $cpt_key ) && ! in_array( $cpt_key, $do_not_add_to_post_type_data ) ) {

						// Don't want deactivated custom post types.
						if ( isset( $cpt->deactivate ) && $cpt->deactivate ) {
							continue;
						}

						// Make sure label exists.
						$label = null;
						if ( isset( $cpt->labels ) && isset( $cpt->labels->name ) && ! empty( $cpt->labels->name ) ) {
							$label = $cpt->labels->name;
						} elseif ( isset( $cpt->label ) && ! empty( $cpt->label ) ) {
							$label = $cpt->label;
						}

						if ( empty( $label ) ) {
							continue;
						}

						$attach_to_post_type_data[ $cpt_key ] = (object) array(
							'label' => $label,
						);

					}
				}
			} else {

				foreach ( get_post_types( array(), 'objects' ) as $cpt_key => $cpt ) {
					if ( ! empty( $cpt_key ) && ! in_array( $cpt_key, $do_not_add_to_post_type_data ) && ! empty( $cpt->labels->name ) ) {

						$attach_to_post_type_data[ $cpt_key ] = (object) array(
							'label' => $cpt->labels->name,
						);

					}
				}
			}

			// Get deactivated post types created by plugin.
			foreach ( $saved_custom_post_type_data as $cpt_key => $cpt ) {
				if ( isset( $cpt['deactivate'] ) && $cpt['deactivate'] ) {
					if ( ! array_key_exists( $cpt_key, $attach_to_post_type_data ) ) {
						$attach_to_post_type_data[ $cpt_key ] = (object) array(
							'label' => sprintf( __( '%1$s %2$sdeactivated%3$s', 'cpt-onomies' ), $cpt['label'], '<span class="gray"><em>(', ')</em></span>' ),
						);
					}
				}
			}

			// Add post type names that are saved and no longer exist.
			if ( $post_type_being_edited ) {

				$stored_attach_to_post_type = array();
				if ( isset( $saved_custom_post_type_data ) && array_key_exists( $post_type_being_edited, $saved_custom_post_type_data ) && isset( $saved_custom_post_type_data[ $post_type_being_edited ]['attach_to_post_type'] ) ) {
					$stored_attach_to_post_type = $saved_custom_post_type_data[ $post_type_being_edited ]['attach_to_post_type'];
				} elseif ( ! $this->is_network_admin && isset( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( $post_type_being_edited, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type_being_edited ]['attach_to_post_type'] ) ) {
					$stored_attach_to_post_type = $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type_being_edited ]['attach_to_post_type'];
				}

				if ( ! empty( $stored_attach_to_post_type ) ) {
					foreach ( $stored_attach_to_post_type as $cpt_key ) {
						if ( ! array_key_exists( $cpt_key, $attach_to_post_type_data ) ) {
							$attach_to_post_type_data[ $cpt_key ] = (object) array(
								'label' => sprintf( __( '%1$s %2$snot registered%3$s', 'cpt-onomies' ), "'" . $cpt_key . "'", '<span class="gray"><em>(', ')</em></span>' ),
							);
						}
					}
				}
			}

			// This filter allows you to remove particular post types from the list.
			foreach ( $attach_to_post_type_data as $cpt_key => $cpt ) {
				if ( ! apply_filters( 'custom_post_type_onomies_' . ( $this->is_network_admin ? 'network_admin_' : null ) . 'attach_to_post_type_property_include_post_type', true, $cpt_key, $post_type_being_edited ) ) {
					unset( $attach_to_post_type_data[ $cpt_key ] );
				}
			}

			// Sort post types by key.
			ksort( $attach_to_post_type_data );

			// Gather taxonomy data to use in properties.
			$taxonomy_data = array();
			foreach ( get_taxonomies( array(), 'objects' ) as $value => $tax ) {

				// Do not include link categories or nav menu stuff.
				if ( ! empty( $value ) && apply_filters( 'custom_post_type_onomies_taxonomies_property_include_taxonomy', true, $value, $post_type_being_edited ) && ! in_array( $value, array( 'link_category', 'nav_menu' ) ) && ! $cpt_onomies_manager->is_registered_cpt_onomy( $value ) && ! empty( $tax->labels->name ) ) {

					$taxonomy_data[ $value ] = (object) array(
						'label' => $tax->labels->name,
					);

				}
			}

			// Gather user data to use in properties.
			$user_data = array();
			$wp_roles = new WP_Roles();
			foreach ( $wp_roles->role_names as $value => $label ) {
				if ( ! empty( $value ) && ! empty( $label ) && apply_filters( 'custom_post_type_onomies_restrict_user_capabilities_property_include_user_role', true, $value, $post_type_being_edited ) ) {

					$user_data[ $value ] = (object) array(
						'label' => $label,
					);
				}
			}

			// Allow you to filter out supports.
			$cpt_supports_data = array(
				'title' => (object) array(
					'label' => __( 'Title', 'cpt-onomies' ),
					),
				'editor' => (object) array( // Content
					'label' => __( 'Editor', 'cpt-onomies' ),
					),
				'author' => (object) array(
					'label' => __( 'Author', 'cpt-onomies' ),
					),
				'thumbnail' => (object) array( // Featured Image) (current theme must also support post-thumbnails
					'label' => __( 'Thumbnail', 'cpt-onomies' ),
					),
				'excerpt' => (object) array(
					'label' => __( 'Excerpt', 'cpt-onomies' ),
					),
				'trackbacks' => (object) array(
					'label' => __( 'Trackbacks', 'cpt-onomies' ),
					),
				'custom-fields' => (object) array(
					'label' => __( 'Custom Fields', 'cpt-onomies' ),
					),
				'comments' => (object) array(
					'label' => __( 'Comments', 'cpt-onomies' ),
					),
				'revisions' => (object) array( // Will store revisions
					'label' => __( 'Revisions', 'cpt-onomies' ),
					),
				'page-attributes' => (object) array( // Template and menu order (hierarchical must be true)
					'label' => __( 'Page Attributes', 'cpt-onomies' ),
					),
				'post-formats' => (object) array(
					'label' => __( 'Post Formats', 'cpt-onomies' ),
					),
				);

			foreach ( $cpt_supports_data as $support => $support_info ) {
				if ( ! apply_filters( 'custom_post_type_onomies_' . ( $this->is_network_admin ? 'network_admin_' : null ) . 'supports_property_include_support', true, $support, $post_type_being_edited ) ) {
					unset( $cpt_supports_data[ $support ] );
				}
			}

			// Default true/false data
			$true_false_data = array(
				'true' => (object) array(
					'label' => __( 'True', 'cpt-onomies' ),
				),
				'false' => (object) array(
					'label' => __( 'False', 'cpt-onomies' ),
				),
			);

			// Create properties
			$cpt_properties = (object) array(
				'basic' => array(
					'label' => (object) array(
						'label'         => __( 'Label', 'cpt-onomies' ),
						'type'          => 'text',
						'fieldid'       => 'custom-post-type-onomies-custom-post-type-label',
						'validation'    => 'required',
						'description'   => sprintf( __( 'A general, %1$susually plural%2$s, descriptive name for the post type.', 'cpt-onomies' ), '<strong>', '</strong>' ) . ' <strong><span class="red">' . __( 'This field is required.', 'cpt-onomies' ) . '</span></strong>',
					),
					'name' => (object) array(
						'label'         => __( 'Name', 'cpt-onomies' ),
						'type'          => 'text',
						'fieldid'       => 'custom-post-type-onomies-custom-post-type-name',
						'validation'    => 'required custom_post_type_onomies_validate_post_type_name custom_post_type_onomies_validate_post_type_name_characters',
						'description'   => __( 'The name of the post type. This property is very important because it is used to reference the post type all throughout WordPress.', 'cpt-onomies' ) . ' <strong>' . __( 'This should contain only lowercase alphanumeric characters and underscores. Maximum is 20 characters.', 'cpt-onomies' ) . '</strong> ' . __( 'Be careful about changing this field once it has been set and you have created posts because the posts will not convert to the new name.', 'cpt-onomies' ) . ' <strong><span class="red">' . __( 'This field is required.', 'cpt-onomies' ) . '</span></strong>',
					),
					'description' => (object) array(
						'label'         => __( 'Description', 'cpt-onomies' ),
						'type'          => 'textarea',
						'description'   => __( 'Feel free to include a description.', 'cpt-onomies' ),
					),
				),
				'site_registration' => array(), // Will add info later if actually the network admin
				'cpt_as_taxonomy' => (object) array(
					'other' => true, // Which means this section will show up for "other" CPTs
					'label' => sprintf( __( 'Register this Custom Post Type as a %s', 'cpt-onomies' ), 'CPT-onomy' ),
					'type'	=> 'group',
					'data'	=> array(
						'attach_to_post_type' => (object) array(
							'label' => __( 'Attach to Post Types', 'cpt-onomies' ),
							'type' => 'checkbox',
							'description' => sprintf( __( 'This setting allows you to use your custom post type in the same manner as a taxonomy, using your post titles as the terms. This is what we call a "%1$s". You can attach this %2$s to to any post type and assign posts just as you would assign taxonomy terms.', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy' ) . ( $this->is_network_admin ? ' <strong>This will register the CPT-onomy on each individual site and not across the network.</strong>' : null ) . ' <strong><span class="red">' . sprintf( __( 'A post type must be checked in order to register this custom post type as a %s.', 'cpt-onomies' ), 'CPT-onomy' ) . '</span></strong>',
							'data' => $attach_to_post_type_data,
						),
						'meta_box_title' => (object) array(
							'label' => __( 'Meta Box Title', 'cpt-onomies' ),
							'type' => 'text',
							'description' => sprintf( __( 'Title, or header, for the admin meta box. If not set, defaults to the %s "label".', 'cpt-onomies' ), "CPT-onomy's" ),
						),
						'meta_box_format' => (object) array(
							'label' => __( 'Meta Box Format', 'cpt-onomies' ),
							'type' => 'radio',
							'description' => sprintf( __( 'Meta boxes will be added to each "Edit Post" page, where applicable, so users, who have the capability, can assign the desired terms. If a format is not selected, %1$s will use \'%2$s\' for hierarchical %3$s and \'%4$s\' for non-hierarchical %5$s.', 'cpt-onomies' ), 'CPT-onomies', 'Checklist', 'CPT-onomies', 'Autocomplete', 'CPT-onomies' ),
							'data' => array(
								'autocomplete' => (object) array(
									'label' => __( 'Autocomplete', 'cpt-onomies' ),
								),
								'checklist' => (object) array(
									'label' => __( 'Checklist', 'cpt-onomies' ),
								),
								'dropdown' => (object) array(
									'label' => __( 'Dropdown', 'cpt-onomies' ) . ' <span class="gray"><em>(' . __( 'limits to one term', 'cpt-onomies' ) . ')</em></span>',
								),
							),
						),
						'show_admin_column' => (object) array(
							'label' => __( 'Show Admin Column', 'cpt-onomies' ),
							'type' => 'radio',
							'description' => sprintf( __( 'Whether or not to add/show the %s column on the admin edit screen for associated post types.', 'cpt-onomies' ), 'CPT-onomy\'s' ),
							'default' => 1,
							'data' => $true_false_data,
						),
						'admin_column_title' => (object) array(
							'label' => __( 'Admin Column Title', 'cpt-onomies' ),
							'type' => 'text',
							'description' => sprintf( __( 'Title, or header, for the admin column. If not set, defaults to the %s "label".', 'cpt-onomies' ), "CPT-onomy's" ),
						),
						'has_cpt_onomy_archive' => (object) array(
							'label' => __( 'Has Archive Page', 'cpt-onomies' ),
							'type' => 'radio',
							'description' => sprintf( __( 'This setting allows you to enable archive pages for this %s. If enabled, you can customize the archive page slug below.', 'cpt-onomies' ), 'CPT-onomy' ),
							'default' => 1,
							'data' => $true_false_data,
						),
						'cpt_onomy_archive_slug' => (object) array(
							'label' => __( 'Archive Page Slug', 'cpt-onomies' ),
							'type' => 'text',
							'description' => sprintf( __( 'You can use the variables %1$s, %2$s and %3$s to customize your slug. %4$s, which is also the default archive page slug, translates to %5$s.', 'cpt-onomies' ), '<strong>$post_type</strong>', '<strong>$term_slug</strong>', '<strong>$term_id</strong>', '<strong>$post_type/tax/$term_slug</strong>', '<em>http://www.yoursite.com/movies/tax/the-princess-bride</em>' ),
						),
						'restrict_user_capabilities' => (object) array(
							'label' => __( 'Restrict User\'s Capability to Assign Term Relationships', 'cpt-onomies' ),
							'type' => $this->is_network_admin ? 'text' : 'checkbox',
							'message' => $this->is_network_admin ? array(
								'dismiss' => 'restrict_user_capabilities_network_message',
								'text' => '<strong>' . __( 'This setting is a little trickier in the network admin to allow for maximum customization.', 'cpt-onomies' ) . '</strong> ' . sprintf( __( 'If you want to define user roles network wide, just enter the user roles separated by a comma: %1$s. If you want to define user roles for a specific site, prefix the user roles with the blog ID: %2$s. For multiple sites, separate each site definition with a semicolon: %3$s. To combine network and site definitions, simply separate with a semicolon: %4$s. In this scenario, the site definitions will not overwrite, but merge with, the network definition. If you would like the site definition to overwrite the network definition, add %5$s to the end of your site definition: %6$s.', 'cpt-onomies' ), '<em>administrator, editor</em>', '<em>2: administrator, editor</em>', '<em>2: administrator, editor; 3: administrator</em>', '<em>administrator; 2: author, editor; 3: contributor</em>', '":overwrite"', '<em>administrator; 2: author, editor: overwrite; 3: contributor</em>' ) . $this->thickbox_network_sites,
								) : null,
							'description' => sprintf( __( 'This setting allows you to grant specific user roles the capability, or permission, to assign term relationships for this %s.', 'cpt-onomies' ), 'CPT-onomy' ) . ( ( $this->is_network_admin ) ? ' <strong>' . __( 'Visit the "Help" tab for instructions.', 'cpt-onomies' ) . '</strong>' : null ) . ' <strong><span class="red">' . __( 'If no user roles are defined, then all user roles will have permission.', 'cpt-onomies' ) . '</span></strong>',
							'default' => $this->is_network_admin ? 'administrator, editor, author' : array( 'administrator', 'editor', 'author' ),
							'data' => $this->is_network_admin ? null : $user_data,
						),
					),
				),
				'labels' => (object) array(
					'label' => __( 'Customize the Labels', 'cpt-onomies' ),
					'type' => 'group',
					'advanced' => true,
					'data' => array(
						'singular_name' => (object) array(
							'label'         => __( 'Singular Name', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'Name for one object of this post type. If not set, defaults to the value of the "Label" property.', 'cpt-onomies' ),
						),
						'add_new' => (object) array(
							'label'         => __( 'Add New', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used for "Add New" submenu item. If not set, the default is "Add New" for both hierarchical and non-hierarchical posts.', 'cpt-onomies' ),
						),
						'add_new_item' => (object) array(
							'label'         => __( 'Add New Item', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used for the "Add New" button. If not set, the default is "Add New Post" for non-hierarchical posts and "Add New Page" for hierarchical posts.', 'cpt-onomies' ),
						),
						'edit_item' => (object) array(
							'label'         => __( 'Edit Item', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used when editing an individual post. If not set, the default is "Edit Post" for non-hierarchical posts and "Edit Page" for hierarchical posts.', 'cpt-onomies' ),
						),
						'new_item' => (object) array(
							'label'         => __( 'New Item', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used when creating a new post. If not set, the default is "New Post" for non-hierarchical posts and "New Page" for hierarchical posts.', 'cpt-onomies' ),
						),
						'all_items' => (object) array(
							'label'         => __( 'All Items', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used for the "All Items" submenu item. If not set, defaults to the value of the "Label" property.', 'cpt-onomies' ),
						),
						'view_item' => (object) array(
							'label'         => __( 'View Item', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used when viewing an individual post. If not set, the default is "View Post" for non-hierarchical posts and "View Page" for hierarchical posts.', 'cpt-onomies' ),
						),
						'search_items' => (object) array(
							'label'         => __( 'Search Items', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used for the "Search Posts" button. If not set, the default is "Search Posts" for non-hierarchical posts and "Search Pages" for hierarchical posts.', 'cpt-onomies' ),
						),
						'not_found' => (object) array(
							'label'         => __( 'Not Found', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used when no posts are found. If not set, the default is "No posts found" for non-hierarchical posts and "No pages found" for hierarchical posts.', 'cpt-onomies' ),
						),
						'not_found_in_trash' => (object) array(
							'label'         => __( 'Not Found in Trash', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used when no posts are found in the trash. If not set, the default is "No posts found in Trash" for non-hierarchical posts and "No pages found in Trash" for hierarchical posts.', 'cpt-onomies' ),
						),
						'parent_item_colon' => (object) array(
							'label'         => __( 'Parent Item Colon', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used when displaying a post\'s parent. This string is not used on non-hierarchical posts. If post is hierarchical, and not set, the default is "Parent Page".', 'cpt-onomies' ),
						),
						'menu_name' => (object) array(
							'label'         => __( 'Menu Name', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used as the text for the menu item. If not set, defaults to the value of the "Label" property.', 'cpt-onomies' ),
						),
						'name_admin_bar' => (object) array(
							'label'         => __( 'Name for Admin Bar', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This label is used for the "Add New" dropdown on the admin bar. If not set, uses the "Singular Name" label, if it exists. Otherwise, it defaults to the value of the "Label" property.', 'cpt-onomies' ),
						),
					),
				),
				'options' => (object) array(
					'label' => __( 'Advanced Options', 'cpt-onomies' ),
					'type' => 'group',
					'advanced' => true,
					'data' => array(
						'public' => (object) array(
							'label'         => __( 'Public', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting defines whether this post type is visible in the admin and front-end of your site. This property is a catchall and trickles down to define other properties ("Show UI", "Publicly Queryable", and "Exclude From Search") unless they are set individually. For complete customization, be sure to check the value of these other properties.', 'cpt-onomies' ),
							'default'       => 1,
							'data'          => $true_false_data,
						),
						'hierarchical' => (object) array(
							'label'         => __( 'Hierarchical', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting defines whether this post type is hierarchical, which allows a parent to be specified. In order to define a post\'s parent, the post type must support "Page Attributes".', 'cpt-onomies' ),
							'default'       => 0,
							'data'          => $true_false_data,
						),
						'supports' => (object) array(
							'label'         => __( 'Supports', 'cpt-onomies' ),
							'type'          => 'checkbox',
							'description'   => __( 'These settings let you register support for certain features. All features are directly associated with a functional area of the edit post screen.', 'cpt-onomies' ),
							'default'       => array( 'title', 'editor' ),
							'data'          => $cpt_supports_data,
						),
						'has_archive' => (object) array(
							'label'         => __( 'Has Archive Page', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This setting allows you to define/enable an archives page for this post type.', 'cpt-onomies' ) . ' ' . sprintf( __( '%1$sThe default setting is true so leave the field blank if you want an archives page%2$s (which will tell WordPress to use the post type name as the slug) or enter your own customized archive slug. Type %3$s if you do not want an archives page.', 'cpt-onomies' ), '<strong>', '</strong>', '<strong>false</strong>' ),
						),
						'taxonomies' => (object) array(
							'label'         => __( 'Taxonomies', 'cpt-onomies' ),
							'type'          => $this->is_network_admin ? 'text' : 'checkbox',
							'message'       => $this->is_network_admin ? array(
								'dismiss'   => 'taxonomies_network_message',
								'text'      => '<strong>' . __( 'This setting is a little trickier in the network admin to allow for maximum customization.', 'cpt-onomies' ) . '</strong> ' . sprintf( __( 'If you want to define taxonomies network wide, just enter the taxonomy names separated by a comma: %1$s. If you want to define taxonomies for a specific site, prefix the taxonomy names with the blog ID: %2$s. For multiple sites, separate each site definition with a semicolon: %3$s. To combine network and site definitions, simply separate with a semicolon: %4$s. In this scenario, the site definitions will not overwrite, but merge with, the network definition. If you would like the site definition to overwrite the network definition, add %5$s to the end of your site definition: %6$s.', 'cpt-onomies' ), '<em>category, post_tag</em>', '<em>2: category, post_tag</em>', '<em>2: category, post_tag; 3: category</em>', '<em>category; 2: post_tag; 3: post_format</em>', '":overwrite"', '<em>category; 2: post_tag: overwrite; 3: post_tag, post_format</em>' ) . $this->thickbox_network_sites,
								) : null,
							'description'   => sprintf( __( 'This setting allows you to add support for pre-existing, registered %s taxonomies.', 'cpt-onomies' ), '<strong>non-CPT-onomy</strong>' ) . ( ( $this->is_network_admin ) ? ' <strong>' . __( 'Visit the "Help" tab for instructions.', 'cpt-onomies' ) . '</strong>' : null ),
							'data'          => $this->is_network_admin ? null : $taxonomy_data,
						),
						'show_ui' => (object) array(
							'label'         => __( 'Show UI', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting defines whether to show the administration screens for managing this post type.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to the value of the "Public" property.', 'cpt-onomies' ) . '</strong>',
							'data'          => $true_false_data,
						),
						'show_in_menu' => (object) array(
							'label'         => __( 'Show in Admin Menu', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This setting allows you to customize the placement of this post type in the admin menu.', 'cpt-onomies' ) . ' <strong>' . __( 'Note that "Show UI" must be true.', 'cpt-onomies' ) . '</strong> ' . __( 'If you think the menu item is fine where it is, leave this field blank.', 'cpt-onomies' ) . sprintf( __( ' Type %1$s to remove from the menu, %2$s to display as a top-level menu, or enter the name of a top-level menu (i.e. %3$s or %4$s) to add this item to it\'s submenu.', 'cpt-onomies' ), '<strong>false</strong>', '<strong>true</strong>', '<strong>tools.php</strong>', '<strong>edit.php?post_type=page</strong>' ),
						),
						'menu_position' => (object) array(
							'label'         => __( 'Admin Menu Position', 'cpt-onomies' ),
							'type'          => 'text',
							'validation'    => 'digits',
							'description'   => __( 'This setting defines the position in the menu order where the post type item should appear. If you think the menu item is fine where it is, leave this field blank. To move the menu item up or down, enter a custom menu position.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, post types are added below the "Comments" menu item.', 'cpt-onomies' ) . '</strong> ' . __( 'Visit the "Help" tab for a list of suggested menu positions.', 'cpt-onomies' ),
						),
						'menu_icon' => (object) array(
							'label'         => __( 'Menu Icon', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This setting defines the URL to the image you want to use as the menu icon for this post type in the admin menu.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, the menu will show the Posts icon.', 'cpt-onomies' ) . '</strong>',
						),
						'show_in_nav_menus' => (object) array(
							'label'         => __( 'Show in Nav Menus', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting enables posts of this type to appear for selection in the navigation menus.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to the value of the "Public" property.', 'cpt-onomies' ) . '</strong>',
							'data'          => $true_false_data,
						),
						'show_in_admin_bar' => (object) array(
							'label'         => __( 'Show in Admin Bar', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting defines whether or not to make this post type available in the WordPress admin bar.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to the value of the "Show In Admin Menu" property.', 'cpt-onomies' ) . '</strong>',
							'data'          => $true_false_data,
						),
						'query_var' => (object) array(
							'label'         => __( 'Query Variable', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => sprintf( __( 'This setting defines the query variable used to search for posts of this type. Type %s to prevent queries or enter a custom query variable name.', 'cpt-onomies' ), '<strong>false</strong>' ) . ' <strong>' . __( 'If not set, defaults to true and the variable will equal the name of the post type.', 'cpt-onomies' ) . '</strong>',
						),
						'publicly_queryable' => (object) array(
							'label'         => __( 'Publicly Queryable', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting defines whether queries for this post type can be performed on the front-end of your site.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to the value of the "Public" property.', 'cpt-onomies' ) . '</strong>',
							'data'          => $true_false_data,
						),
						'exclude_from_search' => (object) array(
							'label'         => __( 'Exclude From Search', 'cpt-onomies' ),
							'type'          => 'radio',
							'description'   => __( 'This setting allows you to exclude posts with this post type from search results on your site.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to the OPPOSITE value of the "Public" property.', 'cpt-onomies' ) . '</strong>',
							'data'          => $true_false_data,
						),
						'register_meta_box_cb' => (object) array(
							'label'         => __( 'Register Meta Box Callback', 'cpt-onomies' ),
							'type'          => 'text',
							'description'   => __( 'This setting allows you to provide a callback function that will be called for setting up your post type\'s meta boxes.', 'cpt-onomies' ) . ' <strong>' . __( 'Enter the function\'s name only.', 'cpt-onomies' ) . '</strong>',
						),
						'rewrite' => (object) array(
							'label' => __( 'Rewrite', 'cpt-onomies' ),
							'type' => 'group',
							'data' => array(
								'enable_rewrite' => (object) array(
									'label' => __( 'Enable Permalinks', 'cpt-onomies' ),
									'type' => 'radio',
									'description' => sprintf( __( 'This setting allows you to activate custom permalinks for this post type. If %1$s, WordPress will create permalinks and use the post type (or "Query Var", if set) as the slug. If %2$s, this post type will have no custom permalink structure.', 'cpt-onomies' ), '<strong>true</strong>', '<strong>false</strong>' ),
									'default' => 1,
									'data' => $true_false_data,
								),
								'slug' => (object) array(
									'label' => __( 'Slug', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'If rewrite is enabled, you can customize your permalink rewrite even further by prepending posts with a custom slug.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to the post type.', 'cpt-onomies' ) . '</strong>',
								),
								'with_front' => (object) array(
									'label' => __( 'With Front', 'cpt-onomies' ),
									'type' => 'radio',
									'description' => sprintf( __( 'This setting defines whether to allow permalinks to be prepended with the permalink front base. Example: If your permalink structure is /blog/, then your links will be: %1$s = \'/blog/news/\', %2$s = \'/news/\'.', 'cpt-onomies' ), '<strong>true</strong>', '<strong>false</strong>' ),
									'default' => 1,
									'data' => $true_false_data,
								),
								'feeds' => (object) array(
									'label' => __( 'Feeds', 'cpt-onomies' ),
									'type' => 'radio',
									'description' => __( 'This setting defines whether this post type will have a feed for its posts.', 'cpt-onomies' ) . ' <strong>' . __( '"Has Archive Page" needs to be set to true for the feeds to work.', 'cpt-onomies' ) . '</strong> ' . __( 'If not set, defaults to the value of the "Has Archive Page" property.', 'cpt-onomies' ),
									'data' => $true_false_data,
								),
								'pages' => (object) array(
									'label' => __( 'Pages', 'cpt-onomies' ),
									'type' => 'radio',
									'description' => __( 'This setting defines whether this post type\'s archive pages should be paginated.', 'cpt-onomies' ) . ' <strong>' . __( '"Has Archive Page" needs to be set to true for the archive pages to work.', 'cpt-onomies' ) . '</strong>',
									'default' => 1,
									'data' => $true_false_data,
								),
							),
						),
						'map_meta_cap' => (object) array(
							'label' => __( 'Map Meta Cap', 'cpt-onomies' ),
							'type' => 'radio',
							'description' => __( 'This setting defines whether to use the internal default meta capability handling.', 'cpt-onomies' ),
							'default' => 1,
							'data' => $true_false_data,
						),
						'capability_type' => (object) array(
							'label' => __( 'Capability Type', 'cpt-onomies' ),
							'type' => 'text',
							'description' => __( 'This setting allows you to define a custom set of capabilities. This term will be used to build the read, edit, and delete capabilities. The "Capabilities" property below can be used to overwrite specific individual capabilities. If you want to pass multiple capability types to allow for alternative plurals, separate the types with a space or comma, e.g. story, stories.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, the default is post.', 'cpt-onomies' ) . '</strong>',
						),
						'capabilities' => (object) array(
							'label' => __( 'Capabilities', 'cpt-onomies' ),
							'type' => 'group',
							'data' => array(
								'read' => (object) array(
									'label' => __( 'Read', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether objects of this post type can be read by the user.', 'cpt-onomies' ),
								),
								'read_post' => (object) array(
									'label' => __( 'Read Post', 'cpt-onomies' ),
									'type' => 'text',
									'description' => '',
								),
								'read_private_posts' => (object) array(
									'label' => __( 'Read Private Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether private objects of this post type can be read by the user.', 'cpt-onomies' ),
								),
								'edit_post' => (object) array(
									'label' => __( 'Edit Post', 'cpt-onomies' ),
									'type' => 'text',
									'description' => '',
								),
								'edit_posts' => (object) array(
									'label' => __( 'Edit Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether objects of this post type can be edited by the user.', 'cpt-onomies' ),
								),
								'edit_others_posts' => (object) array(
									'label' => __( 'Edit Others Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether objects of this type, owned by other users, can be edited by the user. If the post type does not support an author, then this will behave like edit_posts.', 'cpt-onomies' ),
								),
								'edit_private_posts' => (object) array(
									'label' => __( 'Edit Private Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether private objects of this post type can be edited by the user.', 'cpt-onomies' ),
								),
								'edit_published_posts' => (object) array(
									'label' => __( 'Edit Published Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether published objects of this post type can be edited by the user.', 'cpt-onomies' ),
								),
								'delete_post' => (object) array(
									'label' => __( 'Delete Post', 'cpt-onomies' ),
									'type' => 'text',
									'description' => '',
								),
								'delete_posts' => (object) array(
									'label' => __( 'Delete Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether objects of this post type can be deleted by the user.', 'cpt-onomies' ),
								),
								'delete_private_posts' => (object) array(
									'label' => __( 'Delete Private Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether private objects of this post type can be deleted by the user.', 'cpt-onomies' ),
								),
								'delete_others_posts' => (object) array(
									'label' => __( 'Delete Others Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether objects, owned by other users, can be deleted by the user. If the post type does not support an author, then this will behave like delete_posts.', 'cpt-onomies' ),
								),
								'delete_published_posts' => (object) array(
									'label' => __( 'Delete Published Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether published objects of this post type can be deleted by the user.', 'cpt-onomies' ),
								),
								'publish_posts' => (object) array(
									'label' => __( 'Publish Posts', 'cpt-onomies' ),
									'type' => 'text',
									'description' => __( 'This capability controls whether this user can publish objects of this post type.', 'cpt-onomies' ),
								),
							),
						),
						'can_export' => (object) array(
							'label' => __( 'Can Export', 'cpt-onomies' ),
							'type' => 'radio',
							'description' => __( 'This setting defines whether users can export posts with this post type.', 'cpt-onomies' ),
							'default' => 1,
							'data' => $true_false_data,
						),
						'delete_with_user' => (object) array(
							'label' => __( 'Delete With User', 'cpt-onomies' ),
							'type' => 'radio',
							'description' => __( 'Whether to delete posts of this type when deleting a user. If true, posts of this type belonging to the user will be moved to trash when then user is deleted. If false, posts of this type belonging to the user will not be trashed or deleted. If not set (the default), posts are trashed if the post type supports \'author\'. Otherwise posts are not trashed or deleted.', 'cpt-onomies' ) . '</strong>',
							'data' => $true_false_data,
						),
						'permalink_epmask' => (object) array(
							'label' => __( 'Permalink Endpoint Bitmasks', 'cpt-onomies' ),
							'type' => 'text',
							'description' => __( 'This setting defines the rewrite endpoint bitmask used for posts with this post type.', 'cpt-onomies' ) . ' <strong>' . __( 'If not set, defaults to EP_PERMALINK.', 'cpt-onomies' ) . '</strong>',
						),
					),
				),
				'deactivate' => array(
					'deactivate' => (object) array(
						'label' => __( 'Deactivate', 'cpt-onomies' ),
						'type' => 'checkbox',
						'description' => __( 'This setting allows you to deactive, or disable, your custom post type (and hide it from WordPress) while allowing you to save your settings for later use.', 'cpt-onomies' ) . ' <strong>' . __( 'Deactivating your custom post type does not delete its posts.', 'cpt-onomies' ) . '</strong>',
						'data' => array(
							'true' => (object) array(
								'label' => __( 'Deactivate this CPT but save my settings.', 'cpt-onomies' ),
							),
						),
					),
				),
			);

			/*
			 * If network admin, add site registration data.
			 *
			 * Otherwise, remove array item.
			 */
			if ( ! $this->is_network_admin ) {
				unset( $cpt_properties->site_registration );
			} else {

				$network_blogs = $this->get_network_sites();
				$network_blogs_data = array();
				foreach ( $network_blogs as $this_blog_id => $this_blog ) {
					$network_blogs_data[ $this_blog_id ] = (object) array(
						'label' => $this_blog->blogname,
					);
				}

				// Hides setting if more than 10 sites.
				$cpt_properties->site_registration = array(
					'site_registration' => (object) array(
						'label' => __( 'Register this Custom Post Type on a Site-by-Site Basis', 'cpt-onomies' ),
						'advanced' => ( count( $network_blogs ) > 10 ) ? true : false,
						'type' => 'checkbox',
						'description' => __( 'This option is provided for those who wish to register a custom post type on multiple sites but not the entire network.', 'cpt-onomies' ) . ' <strong><span class="red">' . __( 'Leave this setting blank if you want to register your custom post type on ALL sites.', 'cpt-onomies' ) . '</span></strong>',
						'data' => $network_blogs_data,
					),
				);

			}

			return $cpt_properties;
		}
	}

	/**
	 * Queues style sheet for plugin's option page.
	 *
	 * This function is invoked by the action 'admin_print_styles-settings_page_{plugin name}'.
	 *
	 * @since 1.0
	 */
	public function add_plugin_options_styles() {
		wp_enqueue_style( 'custom-post-type-onomies-admin-options', plugins_url( 'assets/css/admin-options.min.css', __FILE__ ), array( 'thickbox' ), null );
	}

	/**
	 * Queues scripts for plugin's option page.
	 *
	 * This function is invoked by the action 'admin_print_scripts-settings_page_{plugin name}'.
	 *
	 * @since 1.0
	 */
	public function add_plugin_options_scripts() {

		// Plugin scripts.
		wp_enqueue_script( 'custom-post-type-onomies-admin-options', plugins_url( 'assets/js/admin-options.min.js', __FILE__ ), array( 'jquery', 'thickbox' ), null, true );
		wp_enqueue_script( 'custom-post-type-onomies-admin-options-validate', plugins_url( 'assets/js/admin-options-validate.min.js', __FILE__ ), array( 'jquery', 'jquery-form-validation' ), null, true );

		// Need this script for the metaboxes to work correctly.
		wp_enqueue_script( 'post' );
		wp_enqueue_script( 'postbox' );

		// Localize script for options page.
		wp_localize_script( 'custom-post-type-onomies-admin-options', 'cpt_onomies_admin_options_L10n', array(
			'unsaved_message1' => __( 'It looks like you might have some unsaved changes.', 'cpt-onomies' ),
			'unsaved_message2' => __( 'Are you sure you want to leave?', 'cpt-onomies' ),
			'delete_conflicting_terms_message1' => __( 'Are you sure you want to delete the conflicting taxonomy terms?', 'cpt-onomies' ),
			'delete_conflicting_terms_message2' => __( 'There is NO undo and once you click "OK", all of the terms will be deleted and cannot be restored.', 'cpt-onomies' ),
			'delete_message1' => __( 'Are you sure you want to delete this custom post type?', 'cpt-onomies' ),
			'delete_message2' => __( 'There is NO undo and once you click "OK", all of your settings will be gone.', 'cpt-onomies' ),
			'delete_message3' => __( 'Deleting your custom post type DOES NOT delete the actual posts.', 'cpt-onomies' ),
			'delete_message4' => __( 'They\'ll be waiting for you if you decide to register this post type again.', 'cpt-onomies' ),
			'delete_message5' => __( 'Just make sure you use the same name.', 'cpt-onomies' ),
			'close_site_registration' => __( 'Close Site Registration', 'cpt-onomies' ),
			'close_labels' => __( 'Close Labels', 'cpt-onomies' ),
			'close_advanced_options' => __( 'Close Advanced Options', 'cpt-onomies' ),
			'site_registration_message1' => __( 'If you want to register your custom post type on multiple sites, but not the entire network, this section is for you. However, your list of sites is kind of long so we hid it away as to not clog up your screen.', 'cpt-onomies' ),
			'site_registration_message2' => __( 'Show your List of Sites', 'cpt-onomies' ),
			'labels_message1' => __( 'Instead of sticking with the boring defaults, why don\'t you customize the labels used for your custom post type. They can really add a nice touch.', 'cpt-onomies' ),
			'labels_message2' => __( 'Customize the Labels', 'cpt-onomies' ),
			'advanced_options_message1' => __( 'You can make your custom post type as "advanced" as you like but, beware, some of these options can get tricky. Visit the "Help" tab if you get stuck.', 'cpt-onomies' ),
			'advanced_options_message2' => __( 'Edit the Advanced Options', 'cpt-onomies' ),
			'invalid_post_type_name' => __( 'Your post type name is invalid.', 'cpt-onomies' ),
			'post_type_name_exists' => __( 'That post type name already exists. Please choose another name.', 'cpt-onomies' ),
		));

	}

	/**
	 * This functions adds the help tab to the top of the options page.
	 *
	 * Added support for help tab backwards compatability in version 1.0.3.
	 *
	 * @since 1.0
	 */
	public function add_plugin_options_help_tab() {

		// Backwards compatability.
		if ( get_bloginfo( 'version' ) < 3.3 ) {

			$text = $this->get_plugin_options_help_tab_getting_started();
			$text .= $this->get_plugin_options_help_tab_managing_editing_your_cpt_settings();
			$text .= $this->get_plugin_options_help_tab_custom_cpt_onomy_archive_pages();
			$text .= $this->get_plugin_options_help_tab_troubleshooting();
			add_contextual_help( $this->options_page, $text );

		} else {

			// Get info for the current screen.
		    $screen = get_current_screen();

		    // Only add help tab on my options page.
			if ( $this->is_network_admin ) {

				if ( $screen->id != $this->options_page . '-network' ) {
					return;
				}
			} elseif ( $screen->id != $this->options_page ) {
				return;
			}

			$screen->add_help_tab( array(
		        'id'	    => 'custom_post_type_onomies_help_getting_started',
		        'title'	    => __( 'Getting Started', 'cpt-onomies' ),
		        'callback'	=> array( $this, 'get_plugin_options_help_tab_getting_started' ),
		    ));

			$screen->add_help_tab( array(
		        'id'	    => 'custom_post_type_onomies_help_managing_editing_your_cpt_settings',
		        'title'	    => __( 'Managing/Editing Your Custom Post Type Settings', 'cpt-onomies' ),
		        'callback'	=> array( $this, 'get_plugin_options_help_tab_managing_editing_your_cpt_settings' ),
		    ));

			$screen->add_help_tab( array(
		        'id'	    => 'custom_post_type_onomies_help_custom_cpt_onomy_archive_pages',
		        'title'	    => sprintf( __( 'Custom %s Archive Pages', 'cpt-onomies' ), 'CPT-onomy' ),
		        'callback'	=> array( $this, 'get_plugin_options_help_tab_custom_cpt_onomy_archive_pages' ),
		    ));

			$screen->add_help_tab( array(
		        'id'	    => 'custom_post_type_onomies_help_troubleshooting',
		        'title'	    => __( 'Troubleshooting', 'cpt-onomies' ),
		        'callback'	=> array( $this, 'get_plugin_options_help_tab_troubleshooting' ),
		    ));

		}
	}

	/**
	 * This function returns the content for the What Is A CPT-onomy "Help" tab on the options page.
	 *
	 * Added support for help tab backwards compatability in version 1.0.3.
	 *
	 * @since 1.0
	 */
	public function get_plugin_options_help_tab_getting_started() {
		$text = '<h3>' . sprintf( __( 'Getting Started With %s', 'cpt-onomies' ), 'CPT-onomies' ) . '</h3>
		<h4>' . sprintf( __( 'What Is A %s?', 'cpt-onomies' ), 'CPT-onomy' ) . '</h4>
		<p>' . sprintf( __( 'A %1$s is a Custom-Post-Type-powered taxonomy that functions just like a regular WordPress taxonomy, using your post titles as your taxonomy terms. "Attach", or register, your %2$s to any post type and create relationships between your posts, just as you would create taxonomy relationships. Need to associate a %3$s term with its post? No problem!', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy', 'CPT-onomy' ) . ' <strong><span class="red">' . sprintf( __( 'The %s term\'s term ID is the same as the post ID.', 'cpt-onomies' ), 'CPT-onomy' ) . '</span></strong></p>
		<h4>' . sprintf( __( 'Is %s an official WordPress term?', 'cpt-onomies' ), 'CPT-onomy' ) . '</h4>
		<p>' . __( 'No. It\'s just a fun word I made up.', 'cpt-onomies' ) . '</p>
		<h4>' . sprintf( __( 'Need Custom Post Types But Not (Necessarily) %s?', 'cpt-onomies' ), 'CPT-onomies' ) . '</h4>
		<p>' . sprintf( __( '%1$s offers an extensive, %2$sand multisite compatible%3$s, custom post type manager, allowing you to create and completely customize your custom post types within the admin.', 'cpt-onomies' ), 'CPT-onomies', '<strong>', '</strong>' ) . '</p>
        <h4>' . __( 'How to Get Started', 'cpt-onomies' ) . '</h4>';

		if ( $this->is_network_admin ) {
	        $text .= '<p>' . sprintf( __( 'You can\'t have a %1$s without a custom post type! %2$sAdd a new custom post type%3$s, register the custom post type as a %4$s (under "Register this Custom Post Type as a %5$s" on the edit screen) and %6$s will take care of the rest.', 'cpt-onomies' ), 'CPT-onomy', '<a href="' . esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => 'new' ), $this->admin_url ) ) . '">', '</a>', 'CPT-onomy', 'CPT-onomy', 'CPT-onomies' ) . '</p>';
		} else {
	        $text .= '<p>' . sprintf( __( 'You can\'t have a %1$s without a custom post type! %2$sAdd a new custom post type%3$s (or %4$suse custom post types created by themes or other plugins%5$s), register the custom post type as a %6$s (under "Register this Custom Post Type as a %7$s" on the edit screen) and %8$s will take care of the rest.', 'cpt-onomies' ), 'CPT-onomy', '<a href="' . esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => 'new' ), $this->admin_url ) ) . '">', '</a>', '<a href="' . esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE ), $this->admin_url ) ) . '#custom-post-type-onomies-other-custom-post-types-mb">', '</a>', 'CPT-onomy', 'CPT-onomy', 'CPT-onomies' ) . '</p>';
		}

		$text .= '<h4>' . sprintf( __( 'Why %s?', 'cpt-onomies' ), 'CPT-onomies' ) . '</h4>
        <p>' . __( 'It doesn\'t take long to figure out that custom post types can be a pretty powerful tool for creating and managing numerous types of content. For example, you might use the custom post types "Movies" and "Actors" to build a movie database but what if you wanted to group your "movies" by its "actors"? You could create a custom "actors" taxonomy but then you would have to manage your list of actors in two places: your "actors" custom post type and your "actors" taxonomy. This can be a pretty big hassle, especially if you have an extensive custom post type.', 'cpt-onomies' ) . '</p>
        <p><strong>' . sprintf( __( 'This is where %s steps in.', 'cpt-onomies' ), 'CPT-onomies' ) . '</strong> ' . sprintf( __( 'Register your custom post type, \'Actors\', as a %1$s and %2$s will build your \'actors\' taxonomy for you, using your actors\' post titles as the terms. Pretty cool, huh?', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomies' ) . '</p>
        <h4>' . sprintf( __( 'Using %s', 'cpt-onomies' ), 'CPT-onomies' ) . '</h4>
        <p>' . sprintf( __( 'What\'s really great about %1$s is that they function just like any other taxonomy, allowing you to use WordPress taxonomy functions, like %2$s, %3$s and %4$s, to access the %5$s information you need. %6$s will also work with tax queries when using %7$sThe Loop%8$s, help you build %9$scustom %10$s archive pages%11$s, allow you to %12$sprogrammatically register your %13$s%14$s, and includes a tag cloud widget for your sidebar. %15$sCheck out the %16$s documentation%17$s for more information.', 'cpt-onomies' ), 'CPT-onomies', '<a href="http://codex.wordpress.org/Function_Reference/get_terms" target="_blank">get_terms()</a>', '<a href="http://codex.wordpress.org/Function_Reference/get_the_terms" target="_blank">get_the_terms()</a>', '<a href="http://codex.wordpress.org/Function_Reference/wp_get_object_terms" target="_blank">wp_get_object_terms()</a>', 'CPT-onomy', 'CPT-onomies', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/The_Loop/" target="_blank">', '</a>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/custom-archive-pages/" target="_blank">', 'CPT-onomies', '</a>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/register_cpt_onomy/" target="_blank">', 'CPT-onomies', '</a>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/" target="_blank">', 'CPT-onomies', '</a>' ) . '</p>
        <p>' . sprintf( __( 'If you\'re not sure what a taxonomy is, how to use one, or if it\'s right for your needs, be sure to do some research. %1$sThe WordPress Codex page for taxonomies%2$s is a great place to start!', 'cpt-onomies' ), '<a href="http://codex.wordpress.org/Taxonomies" target="_blank">', '</a>' ) . '</p>
        <p><em><strong>' . __( 'Note', 'cpt-onomies' ) . ':</strong> ' . sprintf( __( 'Unfortunately, not every taxonomy function can be used at this time. %1$sCheck out the %2$s documentation%3$s to see which WordPress taxonomy functions work and when you\'ll need to access the plugin\'s %4$s functions.', 'cpt-onomies' ), '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation" target="_blank">', 'CPT-onomy', '</a>', 'CPT-onomy' ) . '</em></p>';

		// Backwards compatability.
		if ( get_bloginfo( 'version' ) < 3.3 ) {
			return $text;
		} else {
			echo $text;
		}
	}

	/**
	 * This function returns the content for the Managing Your Custom Post Type "Help" tab on the options page.
	 *
	 * Added support for help tab backwards compatability in version 1.0.3.
	 *
	 * @since 1.0
	 */
	public function get_plugin_options_help_tab_managing_editing_your_cpt_settings() {
		$text = '<h3>' . __( 'Managing/Editing Your Custom Post Type Settings', 'cpt-onomies' ) . '</h3>
        <p>' . sprintf( __( 'For the most part, managing your custom post type settings is fairly easy. However, there are a few settings that can either be confusing or complicated. If you can\'t find the answer below, refer to %1$sthe WordPress Codex%2$s, %3$sthe plugin\'s support forums%4$s, or %5$smy web site%6$s for help.', 'cpt-onomies' ), '<a href="http://codex.wordpress.org/Function_Reference/register_post_type" target="_blank">', '</a>', '<a href="http://wordpress.org/support/plugin/cpt-onomies" target="_blank">', '</a>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/" target="_blank">', '</a>' ) . '</p>';

		if ( $this->is_network_admin ) {
	        $text .= '<h4>' . sprintf( __( 'Register this Custom Post Type as a %s', 'cpt-onomies' ), 'CPT-onomy' ) . '</h4>
        	<h5>' . __( 'Restrict User\'s Capability to Assign Term Relationships', 'cpt-onomies' ) . '</h5>
        	<p><strong>' . __( 'This setting is a little trickier in the network admin to allow for maximum customization.', 'cpt-onomies' ) . '</strong> ' . sprintf( __( 'If you want to define user roles network wide, just enter the user roles separated by a comma: %1$s. If you want to define user roles for a specific site, prefix the user roles with the blog ID: %2$s. For multiple sites, separate each site definition with a semicolon: %3$s. To combine network and site definitions, simply separate with a semicolon: %4$s. In this scenario, the site definitions will not overwrite, but merge with, the network definition. If you would like the site definition to overwrite the network definition, add %5$s to the end of your site definition: %6$s.', 'cpt-onomies' ), '<em>administrator, editor</em>', '<em>2: administrator, editor</em>', '<em>2: administrator, editor; 3: administrator</em>', '<em>administrator; 2: author, editor; 3: contributor</em>', '":overwrite"', '<em>administrator; 2: author, editor: overwrite; 3: contributor</em>' ) . '</p>
        	<ul>
        		<li>' . $this->thickbox_network_sites . '</li>
        	</ul>';
		}

		$text .= '<h4>' . __( 'Advanced Options', 'cpt-onomies' ) . '</h4>';

		if ( $this->is_network_admin ) {
	        $text .= '<h5>' . __( 'Taxonomies', 'cpt-onomies' ) . '</h5>
        	<p><strong>' . __( 'This setting is a little trickier in the network admin to allow for maximum customization.', 'cpt-onomies' ) . '</strong> ' . sprintf( __( 'If you want to define taxonomies network wide, just enter the taxonomy names separated by a comma: %1$s. If you want to define taxonomies for a specific site, prefix the taxonomy names with the blog ID: %2$s. For multiple sites, separate each site definition with a semicolon: %3$s. To combine network and site definitions, simply separate with a semicolon: %4$s. In this scenario, the site definitions will not overwrite, but merge with, the network definition. If you would like the site definition to overwrite the network definition, add %5$s to the end of your site definition: %6$s.', 'cpt-onomies' ), '<em>category, post_tag</em>', '<em>2: category, post_tag</em>', '<em>2: category, post_tag; 3: category</em>', '<em>category; 2: post_tag; 3: post_format</em>', '":overwrite"', '<em>category; 2: post_tag: overwrite; 3: post_tag, post_format</em>' ) . '</p>
        	<ul>
        		<li>' . $this->thickbox_network_sites . '</li>
        	</ul>';
		}

		$text .= '<h5>' . __( 'Admin Menu Position', 'cpt-onomies' ) . '</h5>
        <p>' . __( 'If you would like to customize your custom post type\'s postion in the administration menu, all you have to do is enter a custom menu position. Use the table below as a quide.', 'cpt-onomies' ) . '</p>
        <table class="menu_position" cellpadding="0" cellspacing="0" border="0">
        	<tr>
            	<td><strong>' . __( '5', 'cpt-onomies' ) . '</strong> - ' . __( 'below Posts', 'cpt-onomies' ) . '</td>
                <td><strong>' . __( '65', 'cpt-onomies' ) . '</strong> - ' . __( 'below Plugins', 'cpt-onomies' ) . '</td>
           	</tr>
            <tr>
            	<td><strong>' . __( '10', 'cpt-onomies' ) . '</strong> - ' . __( 'below Media', 'cpt-onomies' ) . '</td>
                <td><strong>' . __( '70', 'cpt-onomies' ) . '</strong> - ' . __( 'below Users', 'cpt-onomies' ) . '</td>
          	</tr>
            <tr>
            	<td><strong>' . __( '15', 'cpt-onomies' ) . '</strong> - ' . __( 'below Links', 'cpt-onomies' ) . '</td>
                <td><strong>' . __( '75', 'cpt-onomies' ) . '</strong> - ' . __( 'below Tools', 'cpt-onomies' ) . '</td>
          	</tr>
            <tr>
            	<td><strong>' . __( '20', 'cpt-onomies' ) . '</strong> - ' . __( 'below Pages', 'cpt-onomies' ) . '</td>
                <td><strong>' . __( '80', 'cpt-onomies' ) . '</strong> - ' . __( 'below Settings', 'cpt-onomies' ) . '</td>
          	</tr>
            <tr>
            	<td><strong>' . __( '25', 'cpt-onomies' ) . '</strong> - ' . __( 'below comments', 'cpt-onomies' ) . '</td>
                <td><strong>' . __( '100', 'cpt-onomies' ) . '</strong> - ' . __( 'below second separator', 'cpt-onomies' ) . '</td>
          	</tr>
            <tr>
            	<td colspan="2"><strong>' . __( '60', 'cpt-onomies' ) . '</strong> - ' . __( 'below first separator', 'cpt-onomies' ) . '</td>
          	</tr>
      	</table>';

		// Backwards compatability.
		if ( get_bloginfo( 'version' ) < 3.3 ) {
			return $text;
		} else {
			echo $text;
		}
	}

	/**
	 * This function returns the content for the Custom CPT-onomy Archive Pages "Help" tab on the options page.
	 *
	 * @since 1.2
	 */
	public function get_plugin_options_help_tab_custom_cpt_onomy_archive_pages() {

		$text = '<h3>' . sprintf( __( 'Custom %s Archive Pages', 'cpt-onomies' ), 'CPT-onomy' ) . '</h3>
		<p>' . sprintf( __( 'As of version 1.2, %1$s has implemented a simple, built-in method of setting up custom %2$s archive pages that\'s as easy as adding a rewrite rule with a few parameters. I\'ve included a few samples that should help you get your feet wet.', 'cpt-onomies' ), 'CPT-onomies', 'CPT-onomy' ) . '</p>
		<p style="margin-bottom: 3px;"><strong>' . __( 'Just a few notes before you get started:', 'cpt-onomies' ) . '</strong></p>
		<ul style="margin-top:0;">
			<li><span class="red"><strong>' . sprintf( __( 'The %s parameter is required to make all of this work.', 'cpt-onomies' ), '\'cpt_onomy_archive=1\'' ) . '</strong></span></li>';

		if ( $this->is_network_admin ) {
			$text .= '<li><strong>' . sprintf( __( 'You\'re running a multsite network so be sure to keep that in mind when adding rewrite rules. If you don\'t want to add your rewrites to every site on your network, access the global %s variable to add rewrite rules to specific blog IDs. ', 'cpt-onomies' ), '$blog_id' ) . '</strong> ' . $this->thickbox_network_sites . '</li>';
		}

		$text .= '<li>' . __( 'Be sure to flush your rewrite rules each time you edit them. Flush your rewrite rules by visiting Settings -> Permalinks and clicking "Save Changes".', 'cpt-onomies' ) . '</li>
			<li>' . __( 'If you have multiple rewrite rules with the same base, like the first two examples below, the rule with the longer structure needs to go first.', 'cpt-onomies' ) . '</li>
		</ul>
		<pre>&lt;?php<br />add_action( \'init\', \'my_website_add_rewrite_rule\' );<br />function my_website_add_rewrite_rule() {<br /><br />&#160;&#160;&#160;// ' . sprintf( __( 'Says that if the URL matches this rule, i.e. %1$s,%2$s then it should display the %3$s post type that are tagged with the first term (which should be%4$s from the %5$s %6$s) and the second term (which should be from the %7$s %8$s).', 'cpt-onomies' ), 'http://mywebsite.com/movies/steven-spielberg/tom-hanks/', '<br />&#160;&#160;&#160;//', '\'movies\'', '<br />&#160;&#160;&#160;//', '\'directors\'', 'CPT-onomy', '\'actors\'', 'CPT-onomy' ) . '<br />&#160;&#160;&#160;add_rewrite_rule( \'^movies/([^/]*)/([^/]*)/?\', \'index.php?post_type=movies&directors=$matches[1]&actors=$matches[2]&cpt_onomy_archive=1\', \'top\' );<br /><br />&#160;&#160;&#160;// ' . sprintf( __( 'Says that if the URL matches this rule, i.e. %1$s,%2$s then it should display the %3$s post type that are tagged with the first term (which should%4$s be from the %5$s %6$s).', 'cpt-onomies' ), 'http://mywebsite.com/movies/steven-spielberg/', '<br />&#160;&#160;&#160;//', '\'movies\'', '<br />&#160;&#160;&#160;//', '\'directors\'', 'CPT-onomy' ) . '<br />&#160;&#160;&#160;add_rewrite_rule( \'^movies/([^/]*)/?\', \'index.php?post_type=movies&directors=$matches[1]&cpt_onomy_archive=1\', \'top\' );<br /><br />&#160;&#160;&#160;// ' . sprintf( __( 'Says that if the URL matches this rule, i.e. %1$s,%2$s then it should display all post types that are tagged with the first term (which should be from the %3$s %4$s).', 'cpt-onomies' ), 'http://mywebsite.com/directors/steven-spielberg/', '<br />&#160;&#160;&#160;//', '\'directors\'', 'CPT-onomy' ) . '<br />&#160;&#160;&#160;add_rewrite_rule( \'^directors/([^/]*)/?\', \'index.php?directors=$matches[1]&cpt_onomy_archive=1\', \'top\' );<br /><br />}<br />?&gt;</pre>';

		// Backwards compatability.
		if ( get_bloginfo( 'version' ) < 3.3 ) {
			return $text;
		} else {
			echo $text;
		}
	}

	/**
	 * This function returns the content for the Troubleshooting "Help" tab on the options page.
	 *
	 * Added support for help tab backwards compatability in version 1.0.3.
	 *
	 * @since 1.0
	 */
	public function get_plugin_options_help_tab_troubleshooting() {
		$text = '<h3>' . __( 'Troubleshooting', 'cpt-onomies' ) . '</h3>
        <p>' . sprintf( __( 'If you\'re having trouble, and can\'t find the answer below, %1$scheck the support forums%2$s or %3$svisit my web site%4$s. If your problem involves a custom post type setting, %5$sthe WordPress Codex%6$s might be able to help.', 'cpt-onomies' ), '<a href="http://wordpress.org/support/plugin/cpt-onomies" target="_blank">', '</a>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/" target="_blank">', '</a>', '<a href="http://codex.wordpress.org/Function_Reference/register_post_type" target="_blank">', '</a>' ) . '</p>';

		if ( $this->is_network_admin ) {
	        $text .= '<p class="red"><strong>FYI:</strong> ' . sprintf( __( 'Because the network admin is assigned a blog ID of 1, which is the same as your main blog, it detects network-registered post types AND post types registered for your main blog. This makes it hard to troubleshoot/validate network-registered custom post type settings. Please keep this in mind while managing your network-registered custom post types. If a custom post type, or %s, is not behaving as it should on an individual site, check your individual site settings to make sure you do not have a custom post type, with the same name, overwriting your network settings.', 'cpt-onomies' ), 'CPT-onomy' ) . '</p>';
		}

		$text .= '<h5>' . sprintf( __( 'My custom post type and/or %s is not showing up', 'cpt-onomies' ), 'CPT-onomy' ) . '</h5>
        <p>' . sprintf( __( 'Make sure your custom post type has not been deactivated. If you are %1$sprogrammatically registering a %2$s%3$s, and it is not showing up, make sure your custom post type has been registered BEFORE you register it\'s namesake %4$s.', 'cpt-onomies' ), '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/register_cpt_onomy/" target="_blank">', 'CPT-onomy', '</a>', 'CPT-onomy' ) . '</p>
        <h5>' . sprintf( __( 'My custom post type and/or %s archive page is not working', 'cpt-onomies' ), 'CPT-onomy' ) . '</h5>
        <p>' . __( 'If archive pages are enabled but are not working correctly, or are receiving a 404 error, it\'s probably the result of a rewrite or permalink error. Here are a few suggestions to get things working:', 'cpt-onomies' ) . '</p>
        <ul>
        	<li><strong>' . __( 'Double check "Has Archive Page"', 'cpt-onomies' ) . '</strong> ' . __( 'Make sure the archive pages are enabled.', 'cpt-onomies' ) . '</li>
        	<li><strong>' . sprintf( __( 'Are pretty permalinks enabled?', 'cpt-onomies' ) . '</strong> ' . __( 'Archive pages will not work without pretty permalinks. Visit Settings %s Permalinks and make sure anything but "Default" is selected.', 'cpt-onomies' ), '->' ) . '</li>
        	<li><strong>' . sprintf( __( 'Reset your rewrite rules:', 'cpt-onomies' ) . '</strong> ' . __( 'Whenever rewrite settings are changed, the rules need to be "flushed" to make sure everything is in working order. Flush your rewrite rules by visiting Settings %s Permalinks and clicking "Save Changes".', 'cpt-onomies' ), '->' ) . '</li>
      	</ul>
      	<h5>' . __( 'I\'m not able to save my custom post type because the page keeps telling me "That post type name already exists."', 'cpt-onomies' ) . '</h5>
      	<p>' . sprintf( __( 'This is a jQuery "bug" that only seems to plague a few. I\'ve noticed that this validation standstill will occur if you have any text printed outside the &lt;body&gt; element on your page. If that\'s not the case, and the problem still lingers after you\'ve upgraded to version 1.1, you can dequeue the validation script by placing the following code in your %s file:', 'cpt-onomies' ), 'functions.php' ) . '</p>
      	<pre>&lt;?php<br />add_action( \'admin_head\', \'my_website_admin_head\' );<br />function my_website_admin_head() {<br />&#160;&#160;&#160;wp_dequeue_script( \'custom-post-type-onomies-admin-options-validate\' );<br />}<br />?&gt;</pre>
		<h5>' . __( 'I added support for "Thumbnail" to my custom post type, but the "Featured Image" box does not show up', 'cpt-onomies' ) . '</h5>
		<p>' . __( 'You also have to add theme support for post thumbnails to your functions.php file:', 'cpt-onomies' ) . '</p>
		<pre>&lt;?php add_theme_support( \'post-thumbnails\' ); ?&gt;</pre>		
		<h5>' . sprintf( __( 'When I try to retrieve %s AND taxonomy terms, the results are incorrect', 'cpt-onomies' ), 'CPT-onomy' ) . '</h5>
		<p>' . sprintf( __( 'The most important thing to understand is that %1$s information is stored differently than regular taxonomy information. And if you are using %2$s and taxonomies and are trying to retrieve both %3$s and taxonomy term information in the same request, i.e. in %4$s, there\'s a small chance WordPress might get a little confused. %5$sThe easiest solution? When you are using %6$s or something similar, request %7$s or %8$s fields.%9$s If WordPress has to retrieve all of the term information, it eliminates the chance that a %10$s or taxonomy term will be overwritten and lost in the shuffle.', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomies', 'CPT-onomy', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/wp_get_object_terms/" target="_blank">wp_get_object_terms()</a>', '<strong>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/wp_get_object_terms/" target="_blank">wp_get_object_terms()</a>', '\'all\'', '\'all_with_object_id\'', '</strong>', 'CPT-onomy' ) . '</p>
		<h5>' . __( 'When I filter or query posts, the results are incorrect', 'cpt-onomies' ) . '</h5>
		<p>' . sprintf( __( '%1$s bear the same name as their custom post type counterparts, i.e. if you have an "actors" custom post type, it\'s %2$s is also named "actors". With that said, pre-%3$s, you may have had a custom taxonomy named "actors" and, although that taxonomy is no longer registered, your old taxonomy\'s term information may still exist in your database. This is where WordPress gets a little confused because %4$s information is stored differently than regular taxonomies. To fix the problem, all you have to do is remove the old taxonomy information (by following the steps below). If that doesn\'t solve your problem, please %5$slet me know%6$s.', 'cpt-onomies' ), 'CPT-onomies', 'CPT-onomy', 'CPT-onomies', 'CPT-onomy', '<a href="http://wpdreamer.com/contact/" target="_blank">', '</a>' ) . '</p>
		<ul>
			<li><strong>' . __( 'If you do not have access to your database or wish to only deal with the WP admin:', 'cpt-onomies' ) . '</strong>
				<ol>
					<li>' . sprintf( __( '"Unregister" your %1$s. You do not have to remove your custom post type, just the %2$s. Just make sure everything is unchecked under "Attach to Post Types".', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy' ) . '</li>
					<li>' . sprintf( __( 'Open your %1$s file and %2$sregister your old taxonomy%3$s. It doesn\'t matter which post type you attach it to, you just need access to the taxonomy\'s "edit" page. For the sake of this tutorial, we\'ll pretend you\'ve attached it to "Posts".', 'cpt-onomies' ), 'functions.php', '<a href="http://codex.wordpress.org/Function_Reference/register_taxonomy" target="_blank">', '</a>' ) . '</li>
					<li>' . __( 'Open the "Posts" submenu, and click your taxonomy. Select the checkbox at the top left of the terms table and do a "bulk action" to delete all of the terms.', 'cpt-onomies' ) . '</li>
					<li>' . sprintf( __( 'Once you\'ve removed all of the terms, you can "unregister" your taxonomy by removing the %1$s code from your %2$s file and then re-register your %2$s. This should clear up any WordPress confusion.', 'cpt-onomies' ), 'register_taxonomy()', 'CPT-onomy', 'functions.php' ) . '</li>
				</ol>
			</li>
			<li><strong>' . __( 'If you have access to your database:', 'cpt-onomies' ) . '</strong>
				<ol>
					<li>' . sprintf( __( 'Find the %1$s table and take note of the %2$s and %3$s of all of the rows with your taxonomy, then delete these rows.', 'cpt-onomies' ), '"term_taxonomy"', '"term_taxonomy_id"', '"term_id"' ) . '</li>
					<li>' . sprintf( __( 'Find the %1$s table and delete any of the rows that contain one of your noted %2$s.', 'cpt-onomies' ), '"terms"', '"term_id"s' ) . '</li>
					<li>' . sprintf( __( 'Find the %1$s table and delete any of the rows that contain one of your noted %2$s.', 'cpt-onomies' ), '"term_relationships"', '"term_taxonomy_id"s' ) . '</li>
				</ol>
			</li>
		</ul>';

		// Backwards compatability.
		if ( get_bloginfo( 'version' ) < 3.3 ) {
			return $text;
		} else {
			echo $text;
		}
	}

	/**
	 * This function takes care of a few actions on the options page.
	 * It activates and deletes custom post types.
	 *
	 * This function is invoked by the action 'admin_init'.
	 *
	 * @since 1.0
	 * @uses $cpt_onomies_manager
	 */
	public function manage_plugin_options_actions() {
		global $cpt_onomies_manager;

		if ( current_user_can( $this->manage_options_capability )
		    && isset( $_REQUEST['page'] )
		    && CPT_ONOMIES_OPTIONS_PAGE == $_REQUEST['page']
		    && isset( $_REQUEST['_wpnonce'] ) ) {

			// Activate.
			if ( isset( $_REQUEST['activate'] ) ) {

				$cpt = $_REQUEST['activate'];

				// Verify nonce.
				if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'activate-cpt-' . $cpt ) ) {

					// Change the activation settings
					if ( $this->is_network_admin ) {

						if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && array_key_exists( $cpt, $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) {

							// Remove the setting.
							unset( $cpt_onomies_manager->user_settings['network_custom_post_types'][ $cpt ]['deactivate'] );

							// Update the database.
							update_site_option( 'custom_post_type_onomies_custom_post_types', $cpt_onomies_manager->user_settings['network_custom_post_types'] );

							// Redirect.
							wp_redirect( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'cptactivated' => $cpt ), $this->admin_url ) );
							exit();

						}
					} elseif ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( $cpt, $cpt_onomies_manager->user_settings['custom_post_types'] ) ) {

						// Remove the setting.
						unset( $cpt_onomies_manager->user_settings['custom_post_types'][ $cpt ]['deactivate'] );

						// Update database.
						update_option( 'custom_post_type_onomies_custom_post_types', $cpt_onomies_manager->user_settings['custom_post_types'] );

						// Redirect.
						wp_redirect( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'cptactivated' => $cpt ), $this->admin_url ) );
						exit();

					}
				} else {

					// Add error message.
					wp_die( sprintf( __( 'Looks like there was an error and the custom post type was not activated. %1$sGo back to %2$s%3$s and try again.', 'cpt-onomies' ), '<a href="' . add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE ), $this->admin_url ) . '">', 'CPT-onomies', '</a>' ) );

				}
			} elseif ( isset( $_REQUEST['delete'] ) ) {

				/*
				 * Delete the CPT.
				 */

				$cpt = $_REQUEST['delete'];

				// Verify nonce.
				if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'delete-cpt-' . $cpt ) ) {

					// Delete CPT from settings.
					if ( $this->is_network_admin ) {

						if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && array_key_exists( $cpt, $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) {

							// Remove from settings.
							unset( $cpt_onomies_manager->user_settings['network_custom_post_types'][ $cpt ] );

							// Update database.
							update_site_option( 'custom_post_type_onomies_custom_post_types', $cpt_onomies_manager->user_settings['network_custom_post_types'] );

							// Redirect.
							wp_redirect( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'cptdeleted' => '1' ), $this->admin_url ) );
							exit();

						}
					} elseif ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( $cpt, $cpt_onomies_manager->user_settings['custom_post_types'] ) ) {

						// Remove from settings.
						unset( $cpt_onomies_manager->user_settings['custom_post_types'][ $cpt ] );

						// Update database.
						update_option( 'custom_post_type_onomies_custom_post_types', $cpt_onomies_manager->user_settings['custom_post_types'] );

						// Redirect.
						wp_redirect( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'cptdeleted' => '1' ), $this->admin_url ) );
						exit();

					}
				} else {

					// Add error message.
					wp_die( sprintf( __( 'Looks like there was an error and the custom post type was not deleted. %1$sGo back to %2$s%3$s and try again.', 'cpt-onomies' ), '<a href="' . add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE ), $this->admin_url ) . '">', 'CPT-onomies', '</a>' ) );

				}
			} elseif ( isset( $_REQUEST['delete_conflicting_terms'] ) ) {

				/*
				 * Delete "conflicting" taxonomy terms.
				 */

				// Which taxonomy's terms are we deleting?
				$taxonomy = $_REQUEST['delete_conflicting_terms'];

				// Were we successful?
				$delete_success = false;

				// Verify nonce.
				if ( wp_verify_nonce( $_REQUEST['_wpnonce'], 'delete-conflicting-terms-' . $taxonomy ) ) {

					// Delete any conflicting terms.
					$delete_success = $this->delete_conflicting_taxonomy_terms( $taxonomy );

				}

				// Build the redirect URL.
				$redirect_url = add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => $taxonomy, 'other' => ( isset( $_REQUEST['other'] ) && $_REQUEST['other'] ? '1' : null ) ), $this->admin_url );

				if ( $delete_success ) {
					$redirect_url = add_query_arg( array( 'deleted_conflicting_terms' => '1' ), $redirect_url );
				} else {
					$redirect_url = add_query_arg( array( 'delete_conflicting_terms_error' => '1' ), $redirect_url );
				}

				wp_redirect( $redirect_url );
				exit;

			}
		}
	}

	/**
	 * Adds a settings/options page for the plugin to the WordPress network admin menu, under 'Settings'.
	 *
	 * This function is invoked by the action 'network_admin_menu'.
	 *
	 * @since 1.3
	 */
	public function add_network_plugin_options_page() {

		// Make sure plugin is network activated.
		if ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( CPT_ONOMIES_PLUGIN_FILE ) ) {

			// Add options page.
			$this->options_page = add_submenu_page( 'settings.php', sprintf( __( '%s: Using Custom Post Types as Taxonomies', 'cpt-onomies' ), 'CPT-onomies' ), 'CPT-onomies', $this->manage_options_capability, CPT_ONOMIES_OPTIONS_PAGE, array( $this, 'print_plugin_options_page' ) );

			// Adds the help tabs when the option page loads.
			add_action( 'load-' . $this->options_page, array( $this, 'add_plugin_options_help_tab' ) );

		}
	}

	/**
	 * Adds a settings/options page for the plugin to the WordPress admin menu, under 'Settings'.
	 *
	 * This function is invoked by the action 'admin_menu'.
	 *
	 * @since 1.0
	 */
	public function add_plugin_options_page() {

		// Add options page.
		$this->options_page = add_options_page( sprintf( __( '%s: Using Custom Post Types as Taxonomies', 'cpt-onomies' ), 'CPT-onomies' ), 'CPT-onomies', $this->manage_options_capability, CPT_ONOMIES_OPTIONS_PAGE, array( $this, 'print_plugin_options_page' ) );

		// Adds the help tabs when the option page loads.
		add_action( 'load-' . $this->options_page, array( $this, 'add_plugin_options_help_tab' ) );

	}

	/**
	 * Adds the meta boxes to the CPT-onomies settings pages.
	 *
	 * This function is invoked by the action 'admin_head-settings_page_'.CPT_ONOMIES_OPTIONS_PAGE.
	 *
	 * @since 1.1
	 */
	public function add_plugin_options_page_meta_boxes() {

		/*
		 * Detects page variables, i.e. if we're creating a new CPT,
		 * or editing a CPT, and whether or not it's an 'other' CPT.
		 *
		 * Will create $new, $edit, and $other.
		 */
		extract( $this->detect_settings_page_variables() );

		//$bla = $this->detect_settings_page_variables();
		//var_dump($bla);
		// Add meta boxes for the edit screen.
		if ( $new || $edit ) {

			// Save.
			add_meta_box( 'custom-post-type-onomies-save-changes-mb', __( 'Save Your Changes', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'save_changes' );


			// Spread the Love.
			add_meta_box( 'custom-post-type-onomies-promote-mb', __( 'Don\'t miss out!', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'promote' );

			// Any Questions?
			add_meta_box( 'custom-post-type-onomies-support-mb', __( 'Any Questions?', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'support' );
			// Delete Custom Post Type, if created by plugin.


			if ( ! $other ) {
				add_meta_box( 'custom-post-type-onomies-delete-custom-post-type-mb', __( 'Delete this Custom Post Type', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'delete_custom_post_type' );
			}

/*
			// About this Plugin.
		add_meta_box( 'custom-post-type-onomies-about-mb', __( 'About this Plugin', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'about' );
*/

			// Edit Properties.
			add_meta_box( 'custom-post-type-onomies-edit-custom-post-type-mb', __( 'Edit Your Custom Post Type\'s Properties', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'normal', 'core', 'edit_custom_post_type' );

		} else {

			// Add A New Custom Post Type.
			add_meta_box( 'custom-post-type-onomies-add-new-custom-post-type-mb', __( 'Add A New Custom Post Type', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'add_new_custom_post_type' );

			// Manage Your Custom Post Types.
			add_meta_box( 'custom-post-type-onomies-custom-post-types-mb', __( 'Manage Your Custom Post Types', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'normal', 'core', 'manage_custom_post_types' );

			// Manage Your Other Custom Post Types - but not in the network admin.
			if ( ! $this->is_network_admin ) {
				add_meta_box( 'custom-post-type-onomies-other-custom-post-types-mb', __( 'Manage Your Other Custom Post Types', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'normal', 'core', 'manage_other_custom_post_types' );
			}

			// What The Icons Mean.
			add_meta_box( 'custom-post-type-onomies-key-mb', __( 'What The Icons Mean', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'key' );
			// Spread the Love.
			add_meta_box( 'custom-post-type-onomies-promote-mb', __( 'Don\'t miss out!', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'promote' );

			// Any Questions?
			add_meta_box( 'custom-post-type-onomies-support-mb', __( 'Any Questions?', 'cpt-onomies' ), array( $this, 'print_plugin_options_meta_box' ), $this->options_page, 'side', 'core', 'support' );

		}



	}

	/**
	 * This function is invoked when the plugin's option page is added to output the content.
	 *
	 * Added support for submit button backwards compatability in version 1.0.3.
	 *
	 * This function is invoked by the action 'admin_menu'.
	 *
	 * @since   1.0
	 * @uses    $cpt_onomies_manager
	 */
	public function print_plugin_options_page() {
		global $cpt_onomies_manager;

		if ( current_user_can( $this->manage_options_capability ) ) {

			/*
			 * Detects page variables, i.e. if we're creating a new CPT,
			 * or editing a CPT, and whether or not it's an 'other' CPT.
			 *
			 * Will create $new, $edit, and $other.
			 */
			extract( $this->detect_settings_page_variables() );

			// Create the tabs.
			$tabs = array();

			if ( $new || $edit ) {

				// Create the properties tab.
				$tabs['properties'] = (object) array(
					'title'		=> __( 'Custom Post Type Properties', 'cpt-onomies' ),
					'link'		=> esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => ( $new ? 'new' : $edit ), 'other' => ( $other ? '1' : null ) ), $this->admin_url ) ),
					'active'	=> true,
				);
			}

			?>
			<div id="custom-post-type-onomies" class="wrap">
				<h2>
					<?php

					printf( __( '%s: Using Custom Post Types as Taxonomies', 'cpt-onomies' ), 'CPT-onomies' );

					if ( ! $new ) :
						?> <a href="<?php echo esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => 'new' ), $this->admin_url ) ); ?>" class="add-new-h2">Add New CPT</a><?php
					endif;

					?>
				</h2>
				<?php

				/*
                 * Print settings errors.
                 *
                 * Regular site settings pages take care of this for us,
                 * so only needed on network admin
                 */
				if ( $this->is_network_admin ) {
	                settings_errors();
				}

				if ( $new || $edit ) :

					// Define the label
					$label = null;

					if ( $new ) {
						$label = __( 'Creating a New Custom Post Type', 'cpt-onomies' );
					} else {

						$cpt_key_to_check = $edit;

						if ( $this->is_network_admin ) {

							if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['network_custom_post_types'][ $cpt_key_to_check ] ) && isset( $cpt_onomies_manager->user_settings['network_custom_post_types'][ $cpt_key_to_check ]['label'] ) ) {
								$label = $cpt_onomies_manager->user_settings['network_custom_post_types'][ $cpt_key_to_check ]['label'];
							}
						} else {

							if ( $other && ( $post_type_object_label = get_post_type_object( $cpt_key_to_check )->label ) ) {
								$label = $post_type_object_label;
							} elseif ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['custom_post_types'][ $cpt_key_to_check ] ) && isset( $cpt_onomies_manager->user_settings['custom_post_types'][ $cpt_key_to_check ]['label'] ) ) {
								$label = $cpt_onomies_manager->user_settings['custom_post_types'][ $cpt_key_to_check ]['label'];
							}
						}

						if ( $label ) {
							$label = sprintf( __( 'Editing "%s"', 'cpt-onomies' ), $label );
						}
					}

					?>
					<h3 class="nav-tab-wrapper">
						<?php

						if ( $label ) :

							?>
							<span class="label"><?php echo $label . '&nbsp;&nbsp;'; ?></span>
							<?php

						endif;

						// Don't include tab name in URL, for now, considering there's only one tab.
						foreach ( $tabs as $tab_key => $this_tab ) :
							?><a href="<?php echo $this_tab->link; ?>" class="nav-tab<?php echo ( $this_tab->active ) ? ' nav-tab-active' : ''; ?>"><?php echo $this_tab->title; ?></a><?php
						endforeach;

						?>
						<div class="etc">
							<a class="return" href="<?php echo esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE ), $this->admin_url ) ); ?>">&laquo; <?php printf( __( 'Back to %s', 'cpt-onomies' ), 'CPT-onomies' ); ?></a>
							<a class="new" href="<?php echo esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => 'new' ), $this->admin_url ) ); ?>" title="<?php _e( 'Add a new custom post type', 'cpt-onomies' ); ?>"><?php _e( 'Add a new custom post type', 'cpt-onomies' ); ?></a>
						</div>
					</h3>
					<?php

				endif;

				// Setup message to display.
				$message = null;

				// What's the message class? - updated by default
				$message_class = 'updated';

				// Add deleted message.
				if ( isset( $_REQUEST['cptdeleted'] ) ) {

					$message = __( 'The custom post type was deleted.', 'cpt-onomies' );

				} elseif ( isset( $_REQUEST['cptactivated'] ) ) {

					/*
					 * Add activated message.
					 */

					$activated_cpt = strtolower( $_REQUEST['cptactivated'] );
					$label = null;
					if ( $this->is_network_admin ) {

						if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && array_key_exists( $activated_cpt, $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['network_custom_post_types'][ $activated_cpt ]['label'] ) ) {
							$label = $cpt_onomies_manager->user_settings['network_custom_post_types'][ $activated_cpt ]['label'];
						}
					} else {

						if ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && array_key_exists( $activated_cpt, $cpt_onomies_manager->user_settings['custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['custom_post_types'][ $activated_cpt ]['label'] ) ) {
							$label = $cpt_onomies_manager->user_settings['custom_post_types'][ $activated_cpt ]['label'];
						}
					}

					if ( $label ) {
						$message = sprintf( __( 'The custom post type \'%s\' is now active.', 'cpt-onomies' ), $label );
					} else {
						$message = __( 'The custom post type is now active.', 'cpt-onomies' );
					}
				} elseif ( isset( $_REQUEST['delete_conflicting_terms_error'] ) ) {

					/*
					 * Add "delete conflicting terms" error message.
					 */

					// Build the refresh URL
					$refresh_url = add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => $edit, 'other' => ( $other ? '1' : null ) ), $this->admin_url );

					// Build the message
					$message = sprintf( __( 'There seems to have been an error deleting the conflicting taxonomy terms. Please %1$srefresh the page%2$s and try again. If the problem persists, %3$sthe %4$s documentation%5$s might help.', 'cpt-onomies' ), '<a href="' . $refresh_url . '">', '</a>', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/incorrect-query-results/#remove-conflicting-taxonomy-terms" target="_blank">', 'CPT-onomies', '</a>' );

					// This is an error message
					$message_class = 'error';

				} elseif ( isset( $_REQUEST['deleted_conflicting_terms'] ) ) {

					/*
					 * Add "deleted conflicting terms" message.
					 */
					$message = __( 'The conflicting taxonomy terms have been deleted!', 'cpt-onomies' );

				}

				// Display message.
				if ( $message ) :

					?>
					<div id="message" class="<?php echo $message_class; ?>">
						<p><?php echo $message; ?></p>
					</div>
					<?php

				endif;

				// Output form, nonce, action, and option_page fields.
				$print_form = ( $new || $edit ) ? true : false;

				// Are we printing a form?
				if ( $print_form ) :

					// Create the form ID.
					$form_id = 'custom-post-type-onomies';

					// If we're creating a new CPT or editing a CPT, then add on to the ID.
					if ( $new || $edit ) {
						$form_id .= '-edit-cpt';
					}

					// Print the form.
					?>
					<form id="<?php echo $form_id; ?>" method="post" action="<?php echo ( $this->is_network_admin ) ? 'settings.php' : 'options.php'; ?>">
					<?php

					/*
                     * Handle network settings.
                     *
                     * Otherwise, handle regular settings.
                     */
					if ( $this->is_network_admin ) {
			            wp_nonce_field( 'siteoptions' );
		            } else {

						if ( $other ) {
				            settings_fields( CPT_ONOMIES_OPTIONS_PAGE . '-other-custom-post-types' );
			            } else {
				            settings_fields( CPT_ONOMIES_OPTIONS_PAGE . '-custom-post-types' );
			            }
					}

					// Need those for both.
					wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
					wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );

				endif;

				?>
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">

						<div id="postbox-container-1" class="postbox-container">
							<div id="side-sortables" class="meta-box-sortables">
								<?php do_meta_boxes( $this->options_page, 'side', array() ); ?>
							</div>
						</div>

						<div id="postbox-container-2" class="postbox-container">
		                    <div id="normal-sortables" class="meta-box-sortables">
			                    <?php do_meta_boxes( $this->options_page, 'normal', array() ); ?>
		                    </div>
		                    <div id="advanced-sortables" class="meta-box-sortables">
			                    <?php do_meta_boxes( $this->options_page, 'advanced', array() ); ?>
		                    </div>
							<?php

							if ( $print_form ) {
			                    submit_button( __( 'Save Your Changes', 'cpt-onomies' ), 'primary', 'save_cpt_onomies_changes', false, array( 'id' => 'custom-post-type-onomies-save-changes-bottom' ) );
		                    }

		                    ?>
						</div>
					</div>
		            <br class="clear" />
				</div>
				<?php

				if ( $print_form ) :
					?></form><?php
				endif;

				?>
			</div>
			<?php

	    }
	}

	/**
	 * This function is invoked when a meta box is added to plugin's option page.
	 * This 'callback' function prints the html for the meta box.
	 *
	 * This function is invoked by the action 'admin_init'.
	 *
	 * @since 1.0
	 * @uses $cpt_onomies_manager, $user_ID
	 * @param array $post - information about the current post, which is empty because there is no current post on a settings page
	 * @param array $metabox - information about the metabox
	 */
	public function print_plugin_options_meta_box( $post, $metabox ) {
		global $cpt_onomies_manager, $user_ID;

		if ( current_user_can( $this->manage_options_capability ) ) {

			switch ( $metabox['args'] ) {

				// Add New CPT Meta Box
				case 'add_new_custom_post_type':

					?>
					<div class="custom-post-type-onomies-button-postbox">
						<a class="add_new_cpt_onomies_custom_post_type" href="<?php echo esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => 'new' ), $this->admin_url ) ); ?>" title="<?php esc_attr_e( 'Add a new custom post type', 'cpt-onomies' ); ?>"><?php _e( 'Add a new custom post type', 'cpt-onomies' ); ?></a>
					</div> <!-- .custom-post-type-onomies-button-postbox -->
					<?php

					break;

				// About Meta Box
				case 'about':

					?>
					<p><strong><a href="<?PHP echo CPT_ONOMIES_PLUGIN_DIRECTORY_URL; ?>" title="<?php printf( esc_attr__( '%s: Using Custom Post Types as Taxonomies', 'cpt-onomies' ), 'CPT-onomies' ); ?>" target="_blank"><?php printf( __( '%s: Using Custom Post Types as Taxonomies', 'cpt-onomies' ), 'CPT-onomies' ); ?></a></strong></p>
	                <p><strong><?php _e( 'Version', 'cpt-onomies' ); ?>:</strong> <?php echo CPT_ONOMIES_VERSION; ?><br />
	                <strong><?php _e( 'Author', 'cpt-onomies' ); ?>:</strong> <a href="http://wpdreamer.com" title="Rachel Carden" target="_blank">Rachel Carden</a></p>
					<?php

					break;

				// Key Meta Box
				case 'key':

					?>
					<p class="inactive"><img src="<?php echo plugins_url( 'assets/images/inactive.png', __FILE__ ); ?>" /><span><?php printf( __( 'This %s is inactive.', 'cpt-onomies' ), 'CPT' ); ?></span></p>
					<p class="attention"><img src="<?php echo plugins_url( 'assets/images/attention.png', __FILE__ ); ?>" /><span><?php printf( __( 'This %s is not registered.', 'cpt-onomies' ), 'CPT' ); ?></span></p>
					<p class="working"><img src="<?php echo plugins_url( 'assets/images/working.png', __FILE__ ); ?>" /><span><?php printf( __( 'This %s is registered and working.', 'cpt-onomies' ), 'CPT' ); ?></span></p>
					<?php

					break;

				// Support Meta Box
				case 'support':

					?>
					<p><strong><?php _e( 'Need help?', 'cpt-onomies' ); ?></strong> <?php _e( 'Here are a few options:', 'cpt-onomies' ); ?></p>
					<ol>
						<li><a class="custom_post_type_onomies_show_help_tab" href="#"><?php _e( 'The \'Help\' tab', 'cpt-onomies' ); ?></a></li>
						<li><a href="http://wordpress.org/support/plugin/cpt-onomies" title="<?php printf( esc_attr__( '%s support forums', 'cpt-onomies' ), 'CPT-onomies' ); ?>" target="_blank"><?php printf( __( 'The %s support forums', 'cpt-onomies' ), 'CPT-onomies\'' ); ?></a></li>
                        <!--
						<li><a href="http://wpdreamer.com/plugins/cpt-onomies/" title="<?php esc_attr_e( 'Visit my web site', 'cpt-onomies' ); ?>" target="_blank"><?php _e( 'My web site', 'cpt-onomies' ); ?></a></li> -->
					</ol>
                    <!--
					<p><?php printf( __( 'If you notice any bugs or problems with the plugin, %1$splease let me know%2$s.', 'cpt-onomies' ), '<a href="http://wpdreamer.com/contact/" target="_blank">', '</a>' ); ?></p> -->
					<?php

                    break;


				// Promote Meta Box
				case 'promote':

					?>
                    <!--
					<p class="star"><a href="<?php echo CPT_ONOMIES_PLUGIN_DIRECTORY_URL; ?>" title="<?php esc_attr_e( 'Give the plugin a good rating', 'cpt-onomies' ); ?>" target="_blank"><span class="dashicons dashicons-star-filled"></span> <span class="promote-text"><?php _e( 'Give the plugin a good rating', 'cpt-onomies' ); ?></span></a></p>
					<p class="twitter"><a href="https://twitter.com/bamadesigner" title="<?php _e( 'Follow bamadesigner on Twitter', 'cpt-onomies' ); ?>" target="_blank"><span class="dashicons dashicons-twitter"></span> <span class="promote-text"><?php _e( 'Follow me on Twitter', 'cpt-onomies' ); ?></span></a></p>
					<p class="donate"><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=bamadesigner%40gmail%2ecom&lc=US&item_name=Rachel%20Carden%20%28CPT%2donomies%29&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted" title="<?php esc_attr_e( 'Donate a few bucks to the plugin', 'cpt-onomies' ); ?>" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" alt="<?php esc_attr_e( 'Donate', 'cpt-onomies' ); ?>" /> <span class="promote-text"><?php _e( 'and buy me a coffee', 'cpt-onomies' ); ?></span></a></p>
					-->


                    <div class="metabox-holder">
                        <div class="postbox">
                            <div class="inside">
								<?php _e( 'By downloading this plugin you have qualified for the <strong>10% off for life</strong> <a href=" https://app.socialwebsuite.com/coupon-code/10offhsb?utm_source=freehsb&amp;utm_medium=button&amp;utm_content=14dayTrial&amp;utm_campaign=freehsb" target="_blank" rel="noopener">Social Web Suite</a> just use the code: <strong>10offhsb </strong>', 'HYPESocialBuffer' ); ?>
                                <br/>
                                <br/>
                                <span><strong>Deep integration with WordPress</strong></span>
                                <iframe src="https://player.vimeo.com/video/274783796" width="100%" height="185" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <span><strong>Custom message templates for WordPress</strong></span>
                                <iframe src="https://player.vimeo.com/video/274785071" width="100%" height="185" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

                                <a class="button-primary hsb_button " style="background-color:##30c0f4;" target="_blank" href="https://vimeo.com/socialwebsuite">Check out all our videos here</a>
                                <br/>
                                <br/>

                                <p><strong>Benefits:</strong></p>
                                <ol>
                                    <li>Share your WordPress posts immediately as they got published.</li>
                                    <li>Send a different message every time - your audience will thank you.</li>
                                    <li>Manage all your shares on the Social Media Calendar.</li>
                                    <li>Set it and forget it social media perfected.</li>
                                    <li>Take the stress out of social media marketing and let Social Web Suite take care of it.</li>
                                    <li>Save time and set your social media scheduling for months ahead or a year ahead.</li>
                                    <li>Evergreen post recycling has never been easier.</li>
                                </ol>

                                <p><strong>Key features of Social Web Suite:</strong></p>
                                <ol>
                                    <li>Deep integrations with WordPress Categories, Posts, Mulitple custom messages</li>
                                    <li>Social media automation that works</li>
                                    <li>Social Media Calendar and Queue</li>
                                    <li>Share posts via RSS Feeds</li>
                                    <li>Schedule and share YouTube videos </li>
                                    <li>bit.ly URL shortening with analytics</li>
                                    <li>Custom post types & custom taxonomies supported</li>
                                    <li>Track the Google Analytics with UTM Parameters</li>
                                    <li>Social Web Suite's lightweight plugin will never slow down your site or affect your performance</li>
                                </ol>

                                <a class="button-primary hsb_button " style="background-color:##30c0f4;" target="_blank" href="https://app.socialwebsuite.com/coupon-code/10offhsb?utm_source=freehsb&amp;utm_medium=button&amp;utm_content=14dayTrial&amp;utm_campaign=freehsb">Start Your Free 14-Day Trial</a>

                            </div>
                        </div>
                    </div>
					<?php

					break;

	            // Manage CPT Meta Boxes
	            case 'manage_custom_post_types':
				case 'manage_other_custom_post_types':

					// Are we managing other custom post types?
					$other = ( 'manage_other_custom_post_types' == $metabox['args'] ) ? true : false;

					?>
					<div class="custom-post-type-onomies-manage-postbox">
						<?php

						if ( $other ) :
							?><p><?php printf( __( 'If you\'re using a theme, or another plugin, that creates a custom post type, you can still register these "other" custom post types as %s.', 'cpt-onomies' ), 'CPT-onomies' ); ?> <span class="description"><?php _e( 'You cannot, however, manage the actual custom post type. Sorry, but that\'s up to the plugin and/or theme.', 'cpt-onomies' ); ?></span></p><?php
						else :

							?>
							<p>
								<?php

								// Print a unique message in the network admin.
								if ( $this->is_network_admin ) :
									_e( "If you'd like to create a custom post type that's registered across your entire network, but don't want to mess with code, you've come to the right place. Only want to register your custom post type on select sites? No problem!", 'cpt-onomies' );
								else :
									_e( "If you'd like to create a custom post type, but don't want to mess with code, you've come to the right place.", 'cpt-onomies' );
								endif;

								echo ' ' . __( "Customize every setting, or just give us a name, and we'll take care of the rest.", 'cpt-onomies' );

								?>
								<span class="description"><?php printf( __( 'For more information, like how to create a %s, visit the Help tab.', 'cpt-onomies' ), 'CPT-onomy' ); ?></span>
							</p>
							<?php

	                  	endif;

	                  	// Get custom post type settings.
	                  	$post_type_objects = array();
						$builtin = get_post_types( array( '_builtin' => true ), 'objects' );

	                  	// Network custom post type settings.
	                  	if ( $this->is_network_admin ) {
	                  		if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) ) {
			                    $post_type_objects = $cpt_onomies_manager->user_settings['network_custom_post_types'];
		                    }
	                  	} else {

							/*
							 * Get custom post types created by this plugin.
							 *
							 * Otherwise, get other (non-builtin) custom post types.
							 */
							if ( ! $other ) {
								$post_type_objects = $cpt_onomies_manager->user_settings['custom_post_types'];
							} else {

								// Get the post type information.
								$post_type_objects = get_post_types( array( '_builtin' => false ), 'objects' );

								foreach ( $post_type_objects as $post_type => $cpt ) {

									/*
									 * If registered CPT, remove.
									 *
									 * Otherwise, gather the plugin settings.
									 */
									if ( $cpt_onomies_manager->is_registered_cpt( $post_type ) ) {
										unset( $post_type_objects[ $post_type ] );
									} elseif ( is_array( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( $post_type, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) {

										if ( isset( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['attach_to_post_type'] ) && ! empty( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['attach_to_post_type'] ) ) {
											$post_type_objects[ $post_type ]->attach_to_post_type = $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['attach_to_post_type'];
										}

										if ( isset( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['has_cpt_onomy_archive'] ) && ! empty( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['has_cpt_onomy_archive'] ) ) {
											$post_type_objects[ $post_type ]->has_cpt_onomy_archive = $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['has_cpt_onomy_archive'];
										}

										if ( isset( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['restrict_user_capabilities'] ) && ! empty( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['restrict_user_capabilities'] ) ) {
											$post_type_objects[ $post_type ]->restrict_user_capabilities = $cpt_onomies_manager->user_settings['other_custom_post_types'][ $post_type ]['restrict_user_capabilities'];
										}
									}
								}
							}
						}

						// Print the table.
						?>
						<table class="manage_custom_post_type_onomies<?php echo ( $other ) ? ' other' : ''; ?>" cellpadding="0" cellspacing="0" border="0">
	                        <thead>
	                            <tr valign="bottom">
	                            	<th class="status"><?php _e( 'Status', 'cpt-onomies' ); ?></th>
	                                <th class="label"><?php _e( 'Label', 'cpt-onomies' ); ?></th>
	                                <th class="name"><?php _e( 'Name', 'cpt-onomies' ); ?></th>
	                                <th class="public"><?php _e( 'Public', 'cpt-onomies' ); ?></th>
	                                <?php

	                                if ( ! $this->is_network_admin ) {
	                                	?><th class="registered_custom_post_type_onomy"><?php _e( 'Registered', 'cpt-onomies' ); ?><br />CPT-onomy?</th><?php
	                                }

	                                ?>
	                                <th class="attached_to">CPT-onomy<br /><?php _e( 'Attached to', 'cpt-onomies' ); ?></th>
	                                <?php

	                                if ( ! $this->is_network_admin ) {
	                                	?><th class="ability"><?php _e( 'Ability to Assign Terms', 'cpt-onomies' ); ?></th><?php
	                                }

	                                ?>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php

		                        if ( empty( $post_type_objects ) ) :

			                        ?>
	                            	<tr valign="top">
	                                	<td class="none" colspan="7">
			                                <?php

											if ( $other ) {
	                                		    _e( 'There are no "other" custom post types.', 'cpt-onomies' );
											} else {
												_e( 'What are you waiting for? Custom post types are pretty awesome and you don\'t have to touch one line of code.', 'cpt-onomies' );
											}

											?>
		                                </td>
	                                </tr>
	                                <?php

	                        	else :

			                        foreach ( $post_type_objects as $post_type => $cpt ) :

		                                if ( ! is_object( $cpt ) ) {
		                                	$cpt = (object) $cpt;
		                                }

										if ( ! empty( $post_type ) && ( ! isset( $cpt->name ) || empty( $cpt->name ) ) ) {
											$cpt->name = $post_type;
										} elseif ( empty( $post_type ) && isset( $cpt->name ) && ! empty( $cpt->name ) ) {
											$post_type = $cpt->name;
										}

										// Make sure post type and label exist.
										if ( ! empty( $post_type ) && ! ( ! isset( $cpt->label ) || empty( $cpt->label ) ) ) :

											/*
											 * Detect if we're editing a CPT AND whether its a new CPT or an "other" CPT
											 * will create $inactive_cpt, $is_registered_cpt, $is_registered_cpt_onomy,
											 * $programmatic_cpt_onomy, $should_be_cpt_onomy, $attention_cpt
											 * and $attention_cpt_onomy.
											 */
											extract( $this->detect_custom_post_type_message_variables( $post_type, $cpt, $other ) );

											// Check to see if attached post types exist.
											$attach_to_post_type_not_exist = array();
											if ( ! empty( $cpt->attach_to_post_type ) ) {
												foreach ( $cpt->attach_to_post_type as $attached ) {
													if ( ! post_type_exists( $attached ) ) {
														$attach_to_post_type_not_exist[] = $attached;
													}
												}
											}

											$message = null;
											if ( $attention_cpt ) {

												/*
												 * Builtin conflicts.
												 */
												if ( array_key_exists( $post_type, $builtin ) ) {
													$message = sprintf( esc_attr__( 'The custom post type, "%1$s", is not registered because the built-in WordPress post type, "%2$s", is already registered under the name "%3$s". Sorry, but WordPress wins on this one. You\'ll have to change the post type name if you want to get "%4$s" up and running.', 'cpt-onomies' ), $cpt->label, $builtin[ $post_type ]->label, $post_type, $cpt->label );
												} else {
													$message = sprintf( esc_attr__( 'The custom post type, "%s", is not registered because another custom post type with the same name already exists. This other custom post type is probably setup in your theme or another plugin. Check out the \'Manage Your Other Custom Post Types\' section to see what else has been registered.', 'cpt-onomies' ), $cpt->label );
												}
											} elseif ( ! $is_registered_cpt_onomy && $should_be_cpt_onomy ) {

												if ( taxonomy_exists( $post_type ) ) {
													$message = sprintf( esc_attr__( 'This custom post type\'s %1$s is not registered because another taxonomy with the same name already exists. If you would like this %2$s to work, please remove the conflicting taxonomy.', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy' );
												} else {
													$message = sprintf( esc_attr__( 'This custom post type\'s %1$s is not registered because the post type(s) it is attached to is not active/registered. If you would like this %2$s to work, please activate/register said post type(s).', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy' );
												}
											} elseif ( $is_registered_cpt_onomy && $attach_to_post_type_not_exist && count( $attach_to_post_type_not_exist ) != count( $cpt->attach_to_post_type ) ) {

												/*
												 * This means this CPT-onomy is registered but not for ALL of its assigned custom post types.
												 */

												if ( count( $attach_to_post_type_not_exist ) > 1 ) {

													$attach_to_post_type_not_exist_string = null;

													foreach ( $attach_to_post_type_not_exist as $not_exist_index => $not_exist ) {

														if ( ( count( $attach_to_post_type_not_exist ) - 1 ) == $not_exist_index ) {
															$attach_to_post_type_not_exist_string .= ' and ';
														} elseif ( $not_exist_index > 0 ) {
															$attach_to_post_type_not_exist_string .= ', ';
														}

														$attach_to_post_type_not_exist_string .= "'" . $not_exist . "'";

													}

													$message = sprintf( esc_attr__( 'This custom post type\'s %1$s is not attached to the %2$s custom post types because they are not active/registered. If you would like this %3$s to work, please activate/register said post type(s).', 'cpt-onomies' ), 'CPT-onomy', $attach_to_post_type_not_exist_string, 'CPT-onomy' );

												} else {

													$message = sprintf( esc_attr__( 'This custom post type\'s %1$s is not attached to the \'%2$s\' custom post type because it is not active/registered. If you would like this %3$s to work, please activate/register said post type(s).', 'cpt-onomies' ), 'CPT-onomy', $attach_to_post_type_not_exist[0], 'CPT-onomy' );

												}
											}

											// Build classes.
											$tr_classes = array();

											if ( $inactive_cpt ) {
												$tr_classes[] = 'inactive';
											} elseif ( $attention_cpt ) {
												$tr_classes[] = 'attention';
											}

											?>
											<tr valign="top"<?php echo ! empty( $tr_classes ) ? ' class="' . implode( ' ', $tr_classes ) . '"' : ''; ?>>
												<td class="status">&nbsp;</td>
												<td class="label">
													<?php

													// Edit URL.
													$edit_url = esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => $post_type, 'other' => ( $other ? '1' : null ) ), $this->admin_url ) );

													// Activate URL.
													$activate_url = esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'activate' => $post_type, '_wpnonce' => wp_create_nonce( 'activate-cpt-' . $post_type ) ), $this->admin_url ), 'activate-cpt-' . $post_type );

													// Delete URL.
													$delete_url = esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'delete' => $post_type, '_wpnonce' => wp_create_nonce( 'delete-cpt-' . $post_type ) ), $this->admin_url ), 'delete-cpt-' . $post_type );

													// View URL.
													$view_url = ! $this->is_network_admin ? esc_url( add_query_arg( array( 'post_type' => $post_type ), admin_url( 'edit.php' ) ) ) : null;

													?>
													<span class="label"><a href="<?php echo $edit_url; ?>"><?php echo $cpt->label; ?></a></span>
													<div class="row-actions">

														<span class="edit"><a href="<?php echo $edit_url; ?>" title="<?php esc_attr_e( 'Edit this custom post type\'s properties', 'cpt-onomies' ); ?>"><?php _e( 'Edit', 'cpt-onomies' ); ?></a></span>
														<?php

														if ( $inactive_cpt ) {
															echo ' | <a href="' . $activate_url . '" title="' . esc_attr__( 'Active this custom post type', 'cpt-onomies' ) . '">' . sprintf( __( 'Activate this %s', 'cpt-onomies' ), 'CPT' ) . '</a>';
														}

														if ( ! $other ) {
															echo ' | <span class="trash"><a class="submitdelete delete_cpt_onomy_custom_post_type" title="' . esc_attr__( 'Delete this custom post type', 'cpt-onomies' ) . '" href="' . $delete_url . '">' . __( 'Delete', 'cpt-onomies' ) . '</a></span>';
														}

														if ( $view_url && ! ( $attention_cpt || $inactive_cpt ) ) {
															echo ' | <span class="view"><a href="' . $view_url . '" title="' . esc_attr__( 'View posts', 'cpt-onomies' ) . '">' . __( 'View posts', 'cpt-onomies' ) . '</a></span>';
														}

														if ( $attention_cpt ) {
															echo '<span class="message"><a class="show_cpt_message" href="' . $edit_url . '" title="' . esc_attr__( 'Find out why this custom post type is not registered', 'cpt-onomies' ) . '" alt="' . $message . '">' . __( 'Find out why this CPT is not registered.', 'cpt-onomies' ) . '</a></span>';
														} elseif ( $overwrote_network_cpt ) {
															echo '<span class="message">' . __( 'This site-wide custom post type is overwriting a custom post type registered by your network admin.', 'cpt-onomies' ) . '</span>';
														}

														?>
													</div>
												</td>
												<td class="name"><?php echo $post_type; ?></td>
												<td class="public"><?php echo $cpt->public ? __( 'Yes', 'cpt-onomies' ) : __( 'No', 'cpt-onomies' ); ?></td>
												<?php

												if ( ! $this->is_network_admin ) :

													// Build the classes.
													$td_registered_classes = array( 'registered_custom_post_type_onomy' );

													if ( $attention_cpt && $attention_cpt_onomy ) {
														$td_registered_classes[] = 'attention';
													} elseif ( $attention_cpt_onomy ) {
														$td_registered_classes[] = 'error';
													} elseif ( $is_registered_cpt_onomy ) {
														$td_registered_classes[] = 'working';
													}

													?>
													<td<?php echo ! empty( $td_registered_classes ) ? ' class="' . implode( ' ', $td_registered_classes ) . '"' : ''; ?>>
														<?php

														if ( ! $is_registered_cpt_onomy && $should_be_cpt_onomy ) {

															if ( $inactive_cpt ) {
																echo sprintf( __( 'No, because this %s is inactive.', 'cpt-onomies' ), 'CPT' ) . '<br /><a href="' . $activate_url . '" title="' . esc_attr__( 'Activate this custom post type', 'cpt-onomies' ) . '">' . __( 'Activate this CPT', 'cpt-onomies' ) . '</a>';
															} elseif ( $attention_cpt ) {
																echo sprintf( __( 'No, because this %s is not registered.', 'cpt-onomies' ), 'CPT' ) . '<br /><a class="show_cpt_message" href="' . $edit_url . '" title="' . esc_attr__( 'Find out why this custom post type is not registered', 'cpt-onomies' ) . '" alt="' . $message . '">' . __( 'Find out why', 'cpt-onomies' ) . '</a>';
															} else {

																if ( taxonomy_exists( $post_type ) ) {
																	echo sprintf( __( 'This %s is not registered due to a taxonomy conflict.', 'cpt-onomies' ), 'CPT-onomy' ) . '<br /><a class="show_cpt_message" href="' . $edit_url . '" title="' . sprintf( esc_attr__( 'Find out why this %s is not registered', 'cpt-onomies' ), 'CPT-onomy' ) . '" alt="' . $message . '">' . __( 'Find out why', 'cpt-onomies' ) . '</a>';
																} else {
																	echo sprintf( __( 'This %s is not registered due to a post type conflict.', 'cpt-onomies' ), 'CPT-onomy' ) . '<br /><a class="show_cpt_message" href="' . $edit_url . '" title="' . sprintf( esc_attr__( 'Find out why this %s is not registered', 'cpt-onomies' ), 'CPT-onomy' ) . '" alt="' . $message . '">' . __( 'Find out why', 'cpt-onomies' ) . '</a>';
																}
															}
														} elseif ( $is_registered_cpt_onomy && $attach_to_post_type_not_exist && count( $attach_to_post_type_not_exist ) != count( $cpt->attach_to_post_type ) ) {

															/*
															 * This means this CPT-onomy is registered but
															 * not for ALL of its assigned custom post types.
															 */

															echo sprintf( __( 'Yes, but there is a post type conflict.', 'cpt-onomies' ), 'CPT-onomy' ) . '<br /><a class="show_cpt_message" href="' . $edit_url . '" title="' . sprintf( esc_attr__( 'Find out why this %s is not registered', 'cpt-onomies' ), 'CPT-onomy' ) . '" alt="' . $message . '">' . __( 'Find out why', 'cpt-onomies' ) . '</a>';

														} elseif ( $is_registered_cpt_onomy ) {

															/*
															 * This means there might be a conflict with conflicting taxonomy terms.
															 */
															if ( ! $this->is_network_admin
																&& $attention_cpt_onomy
																&& ( $conflicting_terms_count = $this->get_conflicting_taxonomy_terms_count( $post_type ) ) ) {

																echo __( 'Yes, but there might be a terms conflict.', 'cpt-onomies' ) . '<br /><a href="' . $edit_url . '" title="Edit the settings to learn more">' . __( 'Learn more', 'cpt-onomies' ) . '</a>';

															} elseif ( $programmatic_cpt_onomy ) {

																/*
																 * This means the CPT-onomy was registered outside the plugin.
																 */

																_e( 'Yes', 'cpt-onomies' );
																echo '<br /><em><span class="gray not-bold">' . sprintf( __( 'This %1$s is %2$sprogrammatically registered%3$s.', 'cpt-onomies' ), 'CPT-onomy', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/register_cpt_onomy/" target="_blank">', '</a>' ) . '</span></em>';

															} else {

																// This means it's registered and all is well.
																_e( 'Yes', 'cpt-onomies' );

															}
														} else {
															_e( 'No', 'cpt-onomies' );
														}

														?>
													</td>
													<?php

												endif;

												?>
												<td class="attached_to">
													<?php

													$text = null;
													if ( $this->is_network_admin ) {
														if ( isset( $cpt->attach_to_post_type ) ) {
															foreach ( $cpt->attach_to_post_type as $attached ) {

																$label = null;
																if ( array_key_exists( $attached, $post_type_objects ) ) {

																	// Don't show deactivated post types.
																	if ( isset( $post_type_objects[ $attached ]['deactivate'] ) && $post_type_objects[ $attached ]['deactivate'] ) {
																		continue;
																	}

																	if ( isset( $post_type_objects[ $attached ]['label'] ) ) {
																		$label = $post_type_objects[ $attached ]['label'];
																	}
																} elseif ( array_key_exists( $attached, $builtin ) ) {

																	if ( isset( $builtin[ $attached ]->label ) ) {
																		$label = $builtin[ $attached ]->label;
																	}
																}

																if ( $label ) {
																	$text .= $label . '<br />';
																}
															}
														}
													} else {

														if ( $is_registered_cpt_onomy ) {

															$tax = get_taxonomy( $post_type );
															if ( ! empty( $tax->object_type ) ) {

																foreach ( $tax->object_type as $attached ) {
																	if ( post_type_exists( $attached ) ) {
																		$text .= '<a href="' . admin_url( 'edit.php?post_type=' . $attached ) . '">' . get_post_type_object( $attached )->label . '</a><br />';
																	}
																}
															}
														}
													}

													if ( empty( $text ) ) {
														echo '&nbsp;';
													} else {
														echo $text;
													}

													?>
												</td>
												<?php

												if ( ! $this->is_network_admin ) :

													?>
													<td class="ability">
														<?php

														$text = null;
														if ( $is_registered_cpt_onomy ) {

															$tax = get_taxonomy( $post_type );
															if ( $tax ) {

																/*
																 * Get roles if capabilities are restriced.
																 */
																$wp_roles = new WP_Roles();
																if ( isset( $tax->restrict_user_capabilities ) && ! empty( $tax->restrict_user_capabilities ) ) {
																	foreach ( $wp_roles->role_names as $role => $name ) {
																		if ( in_array( $role, $tax->restrict_user_capabilities ) ) {
																			$text .= $name . '<br />';
																		}
																	}
																} else {
																	$text = __( 'All user roles', 'cpt-onomies' );
																}
															}
														}

														if ( empty( $text ) ) {
															echo '&nbsp;';
														} else {
															echo $text;
														}

														?>
													</td>
													<?php

												endif;

												?>
											</tr>
											<?php

										endif;
									endforeach;
								endif;

								if ( ! $other ) {
									?><tr valign="top" class="add">
	                                	<td colspan="6"><a class="add_new_cpt_onomies_custom_post_type" href="<?php echo esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => 'new' ), $this->admin_url ) ); ?>"><?php _e( 'Add a new custom post type', 'cpt-onomies' ); ?></a></td>
	                                </tr><?php
	                            }

	                        ?>
	                        </tbody>
	                    </table>
	                </div> <!-- .custom-post-type-onomies-manage-postbox -->
					<?php

					break;

				// Save Changes Meta Box
				case 'save_changes':

					?>
					<div class="custom-post-type-onomies-button-postbox">
						<?php

						submit_button( __( 'Save Your Changes', 'cpt-onomies' ), 'primary', 'save_cpt_onomies_changes', false, array( 'id' => 'custom-post-type-onomies-save-changes' ) );

						?>
					</div> <!-- .custom-post-type-onomies-button-postbox -->
					<?php

					break;

				// Delete CPT Meta Box
				case 'delete_custom_post_type':

					// Define some info.
					$edit = $_REQUEST['edit'];
					$delete_url = esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'delete' => $edit, '_wpnonce' => wp_create_nonce( 'delete-cpt-' . $edit ) ), $this->admin_url ), 'delete-cpt-' . $edit );

					?>
					<p><?php printf( __( 'Deleting your custom post type %1$sDOES NOT%2$s delete the actual posts. They\'ll be waiting for you if you decide to register this post type again. Just make sure you use the same name.', 'cpt-onomies' ), '<strong>', '</strong>' ); ?></p>
					<p><strong><?php _e( 'However, there is no "undo" and, once you click "Delete", all of your settings will be gone.', 'cpt-onomies' ); ?></p>
					<a class="delete_cpt_onomy_custom_post_type button" href="<?php echo $delete_url; ?>" title="<?php esc_attr_e( 'Delete this custom post type', 'cpt-onomies' ); ?>"><?php _e( 'Delete this custom post type', 'cpt-onomies' ); ?></a><?php
	                break;

				// Edit CPT Meta Box
				case 'edit_custom_post_type':

					/*
					 * Detects page variables, i.e. if we're creating a new CPT,
					 * or editing a CPT, and whether or not it's an 'other' CPT.
					 *
					 * Will create $new, $edit, and $other.
					 */
					extract( $this->detect_settings_page_variables() );

					// The info for the object we're editing.
					$cpt = array();

					if ( $edit ) {

						if ( $this->is_network_admin ) {
							if ( isset( $cpt_onomies_manager->user_settings['network_custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['network_custom_post_types'][ $edit ] ) ) {
								$cpt = (object) $cpt_onomies_manager->user_settings['network_custom_post_types'][ $edit ];
							}
						} else {

							/*
							 * If it's not an other post type...
							 */
							if ( ! $other ) {
								if ( isset( $cpt_onomies_manager->user_settings['custom_post_types'] ) && isset( $cpt_onomies_manager->user_settings['custom_post_types'][ $edit ] ) ) {
									$cpt = (object) $cpt_onomies_manager->user_settings['custom_post_types'][ $edit ];
								}
							} else {

								// Get the post type object.
								$cpt = get_post_type_object( $edit );

								// Define as other.
								$cpt->other = true;

								// Get other settings.
								if ( is_array( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) && array_key_exists( $edit, $cpt_onomies_manager->user_settings['other_custom_post_types'] ) ) {

									// Convert CPT to array.
									$cpt = (array) $cpt;

									// Merge with settings.
									$cpt = array_merge( $cpt, $cpt_onomies_manager->user_settings['other_custom_post_types'][ $edit ] );

									// Convert back to an object.
									$cpt = (object) $cpt;

								}
							}
						}
					}

					// Check to see if attached post types exist.
					$attach_to_post_type_not_exist = array();
					if ( ! empty( $cpt->attach_to_post_type ) ) {
						foreach ( $cpt->attach_to_post_type as $attached ) {
							if ( ! post_type_exists( $attached ) ) {
								$attach_to_post_type_not_exist[] = $attached;
							}
						}
					}

					/*
					 * Detects if we have any issues with the custom post type and/or CPT-onomy settings.
					 *
					 * Will create $inactive_cpt, $is_registered_cpt, $overwrote_network_cpt,
					 * $is_registered_cpt_onomy, $programmatic_cpt_onomy, $should_be_cpt_onomy,
					 * $attention_cpt and $attention_cpt_onomy.
					 */
					extract( $this->detect_custom_post_type_message_variables( $edit, $cpt, $other ) );

					?>
					<div class="custom-post-type-onomies-edit-postbox">
						<?php

						// Create the header label.
						$label = null;

						// If not new, set from label property.
						if ( $new ) {
							$label = __( 'Creating a New Custom Post Type', 'cpt-onomies' );
						} else {
							$label = $cpt->label;
						}

						// Set information text.
						$information = null;

						if ( ! $this->is_network_admin ) {

							if ( $overwrote_network_cpt ) {
								$information = __( 'This site-wide custom post type is overwriting a custom post type registered by your network admin.', 'cpt-onomies' );
							} elseif ( $other ) {
								$information = sprintf( __( 'This custom post type is probably setup in your theme, or another plugin, but you can still register it for use as a %s. You cannot, however, manage the actual custom post type. Sorry, but that\'s up to the plugin and/or theme.', 'cpt-onomies' ), 'CPT-onomy' );
							}
						}

						// Print the header.
						?>
						<div id="custom-post-type-onomies-edit-header"<?php echo ! empty( $information ) ? ' class="information"' : null; ?>>
							<span class="label"><?php echo $label; ?></span>
	                   		<?php

							if ( $information ) :

								?>
	                    		<span class="information"><?php echo $information; ?></span>
								<?php

	                   		endif;

	                   		?>
	                    </div>
						<?php

						// Print errors.
						if ( $edit ) :

							// Figure out classes for the edit message.
							$edit_message_class = array();

							/*
							 * If inactive...
							 *
							 * Or if it needs attention...
							 */
							if ( $inactive_cpt ) {
								$edit_message_class[] = ' inactive';
							} elseif ( $attention_cpt || $attention_cpt_onomy || ( $is_registered_cpt_onomy && $attach_to_post_type_not_exist && count( $attach_to_post_type_not_exist ) != count( $cpt->attach_to_post_type ) ) || ( $is_registered_cpt_onomy && $programmatic_cpt_onomy ) ) {
								$edit_message_class[] = ' attention';
							}

			                ?>
							<div id="custom-post-type-onomies-edit-message"<?php echo $edit_message_class ? ' class="' . implode( ' ', $edit_message_class ) . '"' : null; ?>>
								<?php

			                	if ( $inactive_cpt ) {

				                	?><p><?php _e( 'This custom post type is currently inactive.', 'cpt-onomies' ); ?></p><?php

								} elseif ( $attention_cpt ) {

									$builtin = get_post_types( array( '_builtin' => true ), 'objects' );

									/*
									 * Builtin conflict.
									 *
									 * Or other conflict.
									 *
									 */
									if ( array_key_exists( $edit, $builtin ) ) {

										?><p><?php echo sprintf( __( 'This custom post type is not registered because the built-in WordPress post type, \'%1$s\' is already registered under the name \'%2$s\'. Sorry, but WordPress wins on this one. You\'ll have to change the post type name if you want to get \'%3$s\' up and running.', 'cpt-onomies' ), $builtin[ $edit ]->label, $edit, $cpt->label ); ?></p><?php

									} else {

										?><p><?php echo sprintf( __( 'This custom post type is not registered because another custom post type with the same name already exists. This other custom post type is probably setup in your theme or another plugin. %1$sCheck out the \'Manage Your Other Custom Post Types\'%2$s to see what else has been registered.', 'cpt-onomies' ), '<a href="' . esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE ), $this->admin_url ) ) . '#custom-post-type-onomies-other-custom-post-types-mb">', '</a>' ); ?></p><?php

									}
								} elseif ( ! $is_registered_cpt_onomy && $should_be_cpt_onomy ) {

									if ( taxonomy_exists( $edit ) ) {
										?><p><?php echo sprintf( __( 'This custom post type\'s %1$s is not registered because another taxonomy with the same name already exists. If you would like this %2$s to work, please remove the conflicting taxonomy.', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy' ); ?></p><?php
									} else {
										?><p><?php echo sprintf( __( 'This custom post type\'s %1$s is not registered because the post type(s) it is attached to is not active/registered. If you would like this %2$s to work, please activate/register said post type(s).', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy' ); ?></p><?php
									}
				                } elseif ( $is_registered_cpt_onomy && $attach_to_post_type_not_exist && count( $attach_to_post_type_not_exist ) != count( $cpt->attach_to_post_type ) ) {

					                /*
					                 * This means this CPT-onomy is registered but
					                 * not for ALL of its assigned custom post types.
					                 */

									if ( count( $attach_to_post_type_not_exist ) > 1 ) {

										$attach_to_post_type_not_exist_string = null;
										foreach ( $attach_to_post_type_not_exist as $not_exist_index => $not_exist ) {

											if ( ( count( $attach_to_post_type_not_exist ) - 1 ) == $not_exist_index ) {
												$attach_to_post_type_not_exist_string .= ' and ';
											} elseif ( $not_exist_index > 0 ) {
												$attach_to_post_type_not_exist_string .= ', ';
											}

											$attach_to_post_type_not_exist_string .= "'" . $not_exist . "'";

										}

										?><p><?php echo sprintf( __( 'This custom post type\'s %1$s is not attached to the %2$s custom post types because they are not active/registered. If you would like this %3$s to work, please activate/register said post types.', 'cpt-onomies' ), 'CPT-onomy', $attach_to_post_type_not_exist_string, 'CPT-onomy' ); ?></p><?php

									} else {

										?><p><?php echo sprintf( __( 'This custom post type\'s %1$s is not attached to the \'%2$s\' custom post type because it is not active/registered. If you would like this %3$s to work, please activate/register said post type.', 'cpt-onomies' ), 'CPT-onomy', $attach_to_post_type_not_exist[0], 'CPT-onomy' ); ?></p><?php

									}
								} elseif ( ! $this->is_network_admin
									&& $attention_cpt_onomy
									&& ( $conflicting_terms_count = $this->get_conflicting_taxonomy_terms_count( $edit ) ) ) {

					                /*
					                 * This means we have conflicting
					                 * taxonomy terms for our CPT-onomy.
					                 */

									// "Delete conflicting terms" URL.
									$delete_conflicting_terms_url = esc_url( add_query_arg( array( 'page' => CPT_ONOMIES_OPTIONS_PAGE, 'edit' => $edit, 'other' => ( $other ? '1' : null ), 'delete_conflicting_terms' => $edit, '_wpnonce' => wp_create_nonce( 'delete-conflicting-terms-' . $edit ) ), $this->admin_url ), 'delete-conflicting-terms-' . $edit );

									?><p><?php echo sprintf( __( 'Did this %1$s used to be registered as a taxonomy? I found some taxonomy terms stored in your database that could conflict with your %2$s terms. %3$s are not stored in the database in the same manner as taxonomies so when taxonomy and %4$s terms exist under the same name, term queries can get confused and sometimes return incorrect results.', 'cpt-onomies' ), 'CPT-onomy', 'CPT-onomy', 'CPT-onomies', 'CPT-onomy' ); ?></p><p><a class="delete-conflicting-tax-terms action button" href="<?php echo $delete_conflicting_terms_url; ?>" title="<?php echo sprintf( __( 'Delete the conflicting taxonomy terms for the \'%1$s\' %2$s', 'cpt-onomies' ), $edit, 'CPT-onomy' ); ?>"><?php _e( 'Delete the conflicting taxonomy terms', 'cpt-onomies' ); ?></a> <a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/incorrect-query-results/#remove-conflicting-taxonomy-terms" target="_blank"><?php _e( 'Learn how to manually delete your conflicting terms', 'cpt-onomies' ); ?></a></p><?php

								} elseif ( $is_registered_cpt_onomy && $programmatic_cpt_onomy ) {

									?><p><?php echo sprintf( __( 'This custom post type is being programmatically registered as a %1$s, which overrides any settings defined below. %2$sCheck out the %3$s documentation%4$s to learn more.', 'cpt-onomies' ), 'CPT-onomy', '<a href="http://wpdreamer.com/plugins/cpt-onomies/documentation/register_cpt_onomy/" target="_blank">', 'CPT-onomy', '</a>' ); ?></p><?php

								} else {

									?><p><?php _e( 'This custom post type is registered and working.', 'cpt-onomies' ); ?></p><?php

								}

							?>
							</div>
							<?php

						endif;

	                  	// Let Javascript know we're in the network admin.
						?>
						<input type="hidden" id="<?php echo 'custom-post-type-onomies-is-network-admin'; ?>" value="<?php echo $this->is_network_admin ? '1' : ''; ?>" />
						<?php

						// Provide the original "name" for AJAX testing and back-end validation.
						?>
						<input type="hidden" id="<?php echo 'custom-post-type-onomies-custom-post-type-original-name'; ?>" name="<?php

						echo 'custom_post_type_onomies_custom_post_types[';

						if ( $edit && ! $other && ! empty( $cpt ) ) {
							echo $edit;
						} else {
							echo 'new_custom_post_type';
						}

						echo '][original_name]'; ?>" value="<?php echo ( $edit && ! $other && ! empty( $cpt ) ) ? $edit : ''; ?>" />
						<?php

						// This allows each user to dismiss messages.
						$this->dismiss_ids = get_user_option( 'custom_post_type_onomies_dismiss', $user_ID );
						if ( ! is_array( $this->dismiss_ids ) ) {
							$this->dismiss_ids = array();
						}

						// This allows each user to have a preference on whether to show the "advanced" tables.
						$show_edit_tables = get_user_option( 'custom_post_type_onomies_show_edit_tables', $user_ID );
						if ( ! is_array( $show_edit_tables ) ) {
							$show_edit_tables = array();
						}

						// Get the properties.
						$cpt_properties = $this->get_plugin_options_page_cpt_properties( $edit && ! empty( $edit ) ? $edit : null );

						foreach ( $cpt_properties as $section => $section_properties ) :

							// Only show "other" sections on "other" tables.
							if ( ! $other || ( $other && isset( $section_properties->other ) && $section_properties->other ) ) :

								?>
								<table id="custom-post-type-onomies-edit-table" class="<?php echo $section; echo in_array( $section, $show_edit_tables ) ? ' show' : null; ?>" cellpadding="0" cellspacing="0" border="0">
									<tbody>
		                            	<?php

			                            if ( isset( $section_properties->type )
			                                && 'group' == $section_properties->type
			                                && isset( $section_properties->data ) ) :

				                            ?>
		                                	<tr>
		                                    	<td class="label"><?php echo $section_properties->label; ?></td>
		                                        <td class="group<?php echo ( isset( $section_properties->advanced ) && $section_properties->advanced ) ? ' advanced' : ''; ?>">
		                                        	<table cellpadding="0" cellspacing="0" border="0">
														<?php

														foreach ( $section_properties->data as $property_key => $property ) :

															?>
															<tr>
																<td class="label"><?php echo $property->label; ?></td>
																<td class="field"><?php $this->print_plugin_options_edit_custom_post_type_field( $edit, $cpt, $property, $property_key ); ?></td>
															</tr>
															<?php

														endforeach;

														?>
													</table>
		                                      	</td>
		                                  	</tr>
		                            	    <?php

		                            	else :

											foreach ( $section_properties as $property_key => $property ) :

												?>
												<tr>
													<td class="label"><?php echo $property->label; ?></td>
													<td class="field<?php echo ( isset( $property->advanced ) && $property->advanced ) ? ' advanced' : ''; ?>"><?php $this->print_plugin_options_edit_custom_post_type_field( $edit, $cpt, $property, $property_key ); ?></td>
												</tr>
												<?php

											endforeach;
										endif;

										?>
									</tbody>
								</table>
								<?php

							endif;
						endforeach;

						?>
					</div> <!-- .custom-post-type-onomies-edit-postbox -->
					<?php

					break;

			}
		}
	}

	/**
	 * This function is invoked on the edit screen and prints the html for the form fields.
	 *
	 * You can set default values for all of the CPT-onomies settings by hooking into the
	 * 'custom_post_type_onomies_default_property_value' filter which passes two paramters:
	 * the $property_key and the $property_parent_key.
	 *
	 * @since   1.0
	 * @uses    $cpt_onomies_manager
	 * @param   $cpt_key - the name for the custom post type we're editing
	 * @param   $cpt - saved information for the custom post type we're editing
	 * @param   object $property - info pulled from $this->get_plugin_options_page_cpt_properties() about this specific field
	 * @param   string $property_key - name for property so information can be pulled from $property_info object.
	 * @param   string $property_parent_key - allows for pulling property info from within an array.
	 * @filters 'custom_post_type_onomies_default_property_value' - $property_key, $property_parent_key
	 */
	public function print_plugin_options_edit_custom_post_type_field( $cpt_key, $cpt, $property, $property_key, $property_parent_key = null ) {
		global $cpt_onomies_manager;

		if ( ! current_user_can( $this->manage_options_capability ) ) {
			return;
		}

		$new = empty( $cpt ) ? true : false;
		$cpt_key = ( $new ) ? 'new_custom_post_type' : $cpt_key;

		// Create field name.
		$field_name = 'custom_post_type_onomies_';

		// Add "other".
		if ( isset( $cpt->other ) ) {
			$field_name .= 'other_';
		}

		// Build the key.
		$field_name .= 'custom_post_types[' . $cpt_key . ']';

		if ( isset( $property_parent_key ) ) {
			$field_name .= '[' . $property_parent_key . ']';
		}

		$field_name .= '[' . $property_key . ']';

		switch ( $property->type ) {

			case 'group':

				if ( isset( $property->data ) ) :

					?>
					<table cellpadding="0" cellspacing="0" border="0">
						<?php

						foreach ( $property->data as $subproperty_key => $subproperty ) :

	                        ?>
							<tr>
								<td class="label"><?php echo $subproperty->label; ?></td>
								<td class="field"><?php $this->print_plugin_options_edit_custom_post_type_field( $cpt_key, $cpt, $subproperty, $subproperty_key, $property_key ); ?></td>
							</tr>
							<?php

						endforeach;

						?>
					</table>
					<?php

				endif;
				break;

			case 'text':
			case 'textarea':

				// Get saved value.
				$saved_property_value = null;

				if ( ! $new ) {

					if ( isset( $property_parent_key ) && isset( $cpt->$property_parent_key ) ) {
						$property_parent = $cpt->$property_parent_key;

						if ( isset( $property_parent[ $property_key ] ) && ! empty( $property_parent[ $property_key ] ) ) {
							$saved_property_value = $property_parent[ $property_key ];
						}
					} elseif ( isset( $cpt->$property_key ) ) {
						$saved_property_value = $cpt->$property_key;
					}
				} else {

					// Allows you to set default values for the properties.
					$saved_property_value = apply_filters( 'custom_post_type_onomies_' . ( $this->is_network_admin ? 'network_admin_' : null ) . 'default_property_value', isset( $property->default ) ? $property->default : null, $property_key, $property_parent_key );

				}

				if ( is_array( $saved_property_value ) && ! empty( $saved_property_value ) ) {
					$saved_property_value = esc_attr( strip_tags( implode( ', ', $saved_property_value ) ) );
				} elseif ( ! empty( $saved_property_value ) ) {
					$saved_property_value = esc_attr( strip_tags( $saved_property_value ) );
				}

				// Repairing 'read_private_post' bug, if necessary.
				if ( 'capabilities' == $property_parent_key
				    && 'read_private_posts' == $property_key
				    && empty( $saved_property_value )
					&& isset( $cpt->capabilities )
				    && isset( $cpt->capabilities['read_private_post'] )
				    && ! empty( $cpt->capabilities['read_private_post'] ) ) {

					$saved_property_value = $cpt->capabilities['read_private_post'];

				}

				if ( 'text' == $property->type ) {

					?>
					<input<?php echo ( isset( $property->fieldid ) ) ? ' id="' . $property->fieldid . '"' : ''; ?><?php echo ( isset( $property->validation ) ) ? ' class="' . $property->validation . '"' : ''; ?> type="text" name="<?php echo $field_name; ?>" value="<?php echo ( ! empty( $saved_property_value ) ) ? $saved_property_value : ''; ?>"<?php echo ( isset( $property->readonly ) && $property->readonly ) ? ' readonly="readonly"' : ''; ?> />
					<?php

				} elseif ( 'textarea' == $property->type ) {

					?>
					<textarea<?php echo ( isset( $property->fieldid ) ) ? ' id="' . $property->fieldid . '"' : ''; ?><?php echo ( isset( $property->validation ) ) ? ' class="' . $property->validation . '"' : ''; ?> name="<?php echo $field_name; ?>"><?php echo ( ! empty( $saved_property_value ) ) ? $saved_property_value : ''; ?></textarea>
					<?php

				}

				if ( ( isset( $property->message ) && isset( $property->message['text'] ) && ! empty( $property->message['text'] ) )
				    || ( isset( $property->description ) && ! empty( $property->description ) ) ) {

					?>
					<span class="description">
						<?php

						if ( isset( $property->message['text'] ) ) :

							// Figure it if its a dismiss message.
							$dismiss_id = ( isset( $property->message['dismiss'] ) && ! empty( $property->message['dismiss'] ) ) ? $property->message['dismiss'] : false;

							// Make sure its not supposed to be printed first.
							if ( ! $this->dismiss_ids || ( $this->dismiss_ids && ! in_array( $dismiss_id, $this->dismiss_ids ) ) ) :
								?><p<?php echo ( $dismiss_id ) ? ' id="' . $dismiss_id . '"' : ''; ?> class="message<?php echo ( $dismiss_id ) ? ' dismiss' : ''; ?>"><?php echo $property->message['text']; ?></p><?php
							endif;
						endif;

						if ( isset( $property->description ) ) {
							echo $property->description;
						}

						?>
					</span>
					<?php

				}

				break;

			case 'radio':
			case 'checkbox':

				?>
				<table class="<?php echo $property->type; ?>" cellpadding="0" cellspacing="0" border="0">
					<?php

					// If no data is available, which could happen via filter, displays message.
					if ( ! isset( $property->data ) || empty( $property->data ) ) :

						?>
						<tr>
							<td><strong><?php _e( 'There are no options available for selection.', 'cpt-onomies' ); ?></strong></td>
						</tr>
						<?php

					else :

						$td = 1;
						$index = 1;
						foreach ( $property->data as $data_name => $data ) {

							if ( 'true' == $data_name ) {
								$data_name = 1;
							} elseif ( 'false' == $data_name ) {
								$data_name = 0;
							}

							if ( 1 == $td ) {
								echo '<tr>';
							}

							// Allows you to set default values for the properties.
							$default_value = apply_filters( 'custom_post_type_onomies_' . ( $this->is_network_admin ? 'network_admin_' : null ) . 'default_property_value', isset( $property->default ) ? $property->default : null, $property_key, $property_parent_key );

							// Make sure value is clean.
							if ( 'checkbox' == $property->type && isset( $default_value ) && ! is_array( $default_value ) ) {
								$default_value = explode( ',', str_replace( ', ', ',', $default_value ) );
							}

							$is_default = false;

							/*
							 * If default value is an array.
							 */
							if ( isset( $default_value ) && is_array( $default_value ) && in_array( $data_name, $default_value ) ) {
								$is_default = true;
							} elseif ( isset( $default_value ) && $data_name == $default_value ) {
								$is_default = true;
							}

							$is_set = false;
							if ( ! $new ) {

								/*
								 * If property is not set, then set to default.
								 *
								 * If "other", check to make sure this particular post type
								 * has NO settings in the database before using the defaults.
								 *
								 * If "other" custom post type has no settings in the database,
								 * then its settings have not been "saved" and should therefore show the defaults.
								 */
								if ( isset( $property_parent_key ) && isset( $cpt->$property_parent_key ) ) {

									$property_parent = $cpt->$property_parent_key;

									if ( isset( $property_parent[ $property_key ] ) && is_array( $property_parent[ $property_key ] ) && in_array( $data_name, $property_parent[ $property_key ] ) ) {
										$is_set = true;
									} elseif ( isset( $property_parent[ $property_key ] ) && $data_name == $property_parent[ $property_key ] ) {
										$is_set = true;
									}
								} elseif ( isset( $cpt->$property_key ) && is_array( $cpt->$property_key ) && in_array( $data_name, $cpt->$property_key ) ) {
									$is_set = true;
								} elseif ( isset( $cpt->$property_key ) && $data_name == $cpt->$property_key ) {
									$is_set = true;
								} elseif ( ! isset( $cpt->other ) && ! isset( $cpt->$property_key ) && $is_default ) {
									$is_set = true;
								} elseif ( isset( $cpt->other ) && ! isset( $cpt->$property_key ) && $is_default ) {

									if ( empty( $cpt_onomies_manager->user_settings['other_custom_post_types'] ) || empty( $cpt_onomies_manager->user_settings['other_custom_post_types'][ $cpt_key ] ) ) {
										$is_set = true;
									}
								}
							} elseif ( $is_default ) {

								// Set the defaults.
								$is_set = true;

							}

							?>
							<td<?php

							if ( count( $property->data ) == $index && 1 == $td ) {
								echo ' colspan="2"';
							}

							?>>
								<label><input<?php

								if ( isset( $property->validation ) ) {
									echo ' class="' . $property->validation . '"';
								}

								// Build field name.
								$item_field_name = $field_name;

								if ( 'checkbox' == $property->type && count( $property->data ) > 1 ) {
									$item_field_name .= '[]';
								}

								?> type="<?php echo $property->type; ?>" name="<?php echo $item_field_name; ?>" value="<?php echo $data_name; ?>"<?php checked( $is_set, true );

								?> />
									<?php

									if ( $is_default ) {
										?><strong><?php echo $data->label; ?></strong><?php
									} else {
										echo $data->label;
									}

									?>
								</label>
							</td>
							<?php

							if ( 1 == $td ) {
								$td = 2;
							} elseif ( 2 == $td ) {
								$td = 1;
								echo '</tr>';
							}

							$index++;

						}
					endif;

					if ( ( isset( $property->message ) && isset( $property->message['text'] ) && ! empty( $property->message['text'] ) )
						|| ( isset( $property->description ) && ! empty( $property->description ) ) ) :

						?>
						<tr>
							<td<?php echo ( count( $property->data ) > 1 ) ? ' colspan="2"' : ''; ?>>
								<span class="description"><?php

								if ( isset( $property->message['text'] ) ) {

									// Figure it if its a dismiss message.
									$dismiss_id = ( isset( $property->message['dismiss'] ) && ! empty( $property->message['dismiss'] ) ) ? $property->message['dismiss'] : false;

									// Make sure its not supposed to be printed first.
									if ( ! $this->dismiss_ids || ( $this->dismiss_ids && ! in_array( $dismiss_id, $this->dismiss_ids ) ) ) {
										?><p<?php echo ( $dismiss_id ) ? ' id="' . $dismiss_id . '"' : ''; ?> class="message<?php echo ( $dismiss_id ) ? ' dismiss' : ''; ?>"><?php echo $property->message['text']; ?></p><?php
									}
								}

								if ( isset( $property->description ) ) {
									echo $property->description;
								}

								if ( 'radio' == $property->type && ! isset( $property->default ) ) {
									echo ' <span class="reset_property">Reset property</span>';
								}

								?></span>
							</td>
						</tr>
						<?php

					endif;

				?>
				</table>
				<?php

				break;

		}
	}

}

/**
 * Returns the instance of our CPT_onomies_Admin_Settings class.
 *
 * Will come in handy when we need to access the
 * class to retrieve data throughout the plugin.
 *
 * @since	1.3.5
 * @access	public
 * @return	CPT_onomies_Admin_Settings
 */
function cpt_onomies_admin_settings() {
	return CPT_onomies_Admin_Settings::instance();
}

// Let's get this show on the road.
cpt_onomies_admin_settings();
