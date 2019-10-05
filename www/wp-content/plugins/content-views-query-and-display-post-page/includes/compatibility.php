<?php
/**
 * Resolved conflict with other plugins
 *
 * @package   PT_Content_Views
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2016 PT Guy
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if a plugin is active
 * @since 1.9.9.3
 */
$cv_active_plugins_list = array();
function cv_is_active_plugin( $plugin ) {
	global $cv_active_plugins_list;
	if ( empty( $cv_active_plugins_list ) ) {
		// get blog active plugins
		$plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

		if ( is_multisite() ) {
			// get active plugins for the network
			$network_plugins = get_site_option( 'active_sitewide_plugins' );
			if ( $network_plugins ) {
				$network_plugins = array_keys( $network_plugins );
				$plugins		 = array_merge( $plugins, $network_plugins );
			}
		}

		if ( is_array( $plugins ) ) {
			foreach ( $plugins as $string ) {
				$parts = explode( '/', $string );
				if ( !empty( $parts[ 0 ] ) ) {
					$cv_active_plugins_list[] = $parts[ 0 ];
				}
			}
		}
	}

	return in_array( $plugin, $cv_active_plugins_list );
}

/**
 * Autoptimize
 * Disable "Force JavaScript in <head>"
 *
 * @since 1.8.6
 */
add_filter( 'autoptimize_filter_js_defer', 'cv_comp_plugin_autoptimize', 10, 1 );
function cv_comp_plugin_autoptimize( $defer ) {
	$defer = "defer ";
	return $defer;
}

/**
 * Page Builder by SiteOrigin
 * Excerpt is incorrect (not updated)
 * @update 1.9.9 Apply the "the_content" to work with any verion of that plugin
 * @since 1.8.8
 */
add_filter( 'pt_cv_field_content_excerpt', 'cv_comp_plugin_siteoriginbuilder', 9, 3 );
function cv_comp_plugin_siteoriginbuilder( $args, $fargs, $this_post ) {

	if ( defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
		if ( !isset( $this_post->cv_so_content ) ) {
			$this_post->cv_so_content = apply_filters( 'the_content', $args );
		}

		$args = $this_post->cv_so_content;
	}

	return $args;
}

/**
 * Cornerstone Page Builder
 * Excerpt/thumbnal is incorrect (can't get)
 * @since 2.0
 */
add_filter( 'the_content', 'cv_comp_plugin_cornerstone_single', PHP_INT_MAX );
function cv_comp_plugin_cornerstone_single( $content ) {
	if ( isset( $_REQUEST[ 'cv_comp_cs_content' ] ) ) {
		// Save the content, which is already processed by Cornerstone
		update_post_meta( get_the_ID(), 'cv_comp_cornerstone_content', array(
			'expires'	 => time() + DAY_IN_SECONDS,
			'data'		 => $content,
		) );
	}

	return $content;
}

add_filter( 'pt_cv_field_content_excerpt', 'cv_comp_plugin_cornerstone_core', 9, 3 );
add_filter( 'pt_cv_field_content_full', 'cv_comp_plugin_cornerstone_core', 9, 3 );
function cv_comp_plugin_cornerstone_core( $args, $fargs, $this_post ) {
	if ( cv_is_active_plugin( 'cornerstone' ) ) {
		$cache = $this_post->cv_comp_cornerstone_content;
		if ( empty( $cache ) || ( isset( $cache[ 'expires' ] ) && $cache[ 'expires' ] < time() ) ) {
			// Simulate the frontend, to get processed output by Cornerstone
			@file_get_contents( add_query_arg( 'cv_comp_cs_content', 1, get_permalink( $this_post->ID ) ) );
			// Get the processed content
			$cache = get_post_meta( $this_post->ID, 'cv_comp_cornerstone_content', true );
		}

		if ( isset( $cache[ 'data' ] ) ) {
			$args = $cache[ 'data' ];
		}
	}

	return $args;
}

// Prevent error "The preview was unresponsive after loading"
add_action( 'cornerstone_load_builder', 'cv_comp_plugin_cornerstone_builder' );
add_action( 'cornerstone_before_boot_app', 'cv_comp_plugin_cornerstone_builder' );
add_action( 'cornerstone_before_ajax', 'cv_comp_plugin_cornerstone_builder' );
add_action( 'cornerstone_before_load_preview', 'cv_comp_plugin_cornerstone_builder' );
function cv_comp_plugin_cornerstone_builder() {
	if ( defined( 'PT_CV_POST_TYPE' ) ) {
		remove_shortcode( PT_CV_POST_TYPE );
	}
}

/** Beaver Builder plugin (tested with version 2.1.7.2): style of full content is not applied in View
 * @since 2.1.3
 */
add_filter( 'pt_cv_field_content_full', 'cv_comp_plugin_beaverbuilder', 9, 3 );
function cv_comp_plugin_beaverbuilder( $content, $fargs, $post ) {
	if ( class_exists( 'FLBuilderModel' ) && method_exists( 'FLBuilderModel', 'is_builder_enabled' ) ) {
		$enabled = FLBuilderModel::is_builder_enabled( $post->ID );
		if ( $enabled ) {
			if ( class_exists( 'FLBuilder' ) && method_exists( 'FLBuilder', 'render_content_by_id' ) ) {
				ob_start();
				FLBuilder::render_content_by_id( $post->ID );
				$content = ob_get_clean();
			}
		}
	}

	return $content;
}

/**
 * FacetWP
 * Missing posts in output when access page with parameters 'fwp_*' of FacetWP plugin
 *
 * @since 1.9.3
 */
add_filter( 'facetwp_is_main_query', 'cv_comp_plugin_facetwp', 999, 2 );
function cv_comp_plugin_facetwp( $is_main_query, $query ) {
	if ( $query->get( 'cv_get_view' ) || $query->get( 'by_contentviews' ) ) {
		$is_main_query = false;
	}

	return $is_main_query;
}

# "View maybe not exist" error, caused by custom filter hook (which modifies `post_type` in WordPress query) of another plugin
add_action( 'pre_get_posts', 'cv_comp_no_view_found', 999 );
function cv_comp_no_view_found( $query ) {
	if ( $query->get( 'cv_get_view' ) ) {
		$query->set( 'post_type', PT_CV_POST_TYPE );
	}

	return $query;
}

/**
 * Divi theme
 * Remove line break holder of Divi theme from excerpt
 *
 * @since 1.9.5
 */
add_filter( 'pt_cv_before_generate_excerpt', 'cv_comp_theme_divi_linebreak' );
function cv_comp_theme_divi_linebreak( $args ) {
	if ( defined( 'ET_CORE_VERSION' ) ) {
		$args = str_replace( array( '<!-- [et_pb_line_break_holder] -->', '&lt;!-- [et_pb_line_break_holder] --&gt;' ), '', $args );
	}

	return $args;
}

/**
 * Divi theme
 * Collapsible doesn't toggle on click heading, Scrollable doesn't slide on click next/prev button
 *
 * @since 1.9.7.1
 */
add_filter( PT_CV_PREFIX_ . 'wrapper_class', 'cv_comp_theme_divi_scroll' );
function cv_comp_theme_divi_scroll( $args ) {
	if ( defined( 'ET_CORE_VERSION' ) ) {
		$args .= ' ' . 'et_smooth_scroll_disabled';
	}
	return $args;
}

/**
 * Visual Composer
 * Shortcode is visible in content, when do Ajax pagination
 *
 * @since 1.9.6
 */
add_action( 'pt_cv_before_content', 'cv_comp_plugin_visualcomposer', 9 );
function cv_comp_plugin_visualcomposer() {
	if ( (defined( 'PT_CV_DOING_PAGINATION' ) || defined( 'PT_CV_DOING_PREVIEW' )) && class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
		WPBMap::addAllMappedShortcodes();
	}
}

// Fix: Sort by doesn't work
add_action( 'pre_get_posts', 'cv_comp_wrong_sortby', 9 );
function cv_comp_wrong_sortby( $query ) {
	if ( $query->get( 'by_contentviews' ) ) {
		/**
		 * "Post Types Order" plugin
		 * @since 1.9.6
		 */
		if ( cv_is_active_plugin( 'post-types-order' ) ) {
			$query->set( 'ignore_custom_sort', true );
		}

		/**
		 * "Simple Custom Post Order" plugin
		 * @since 1.9.8
		 */
		if ( cv_is_active_plugin( 'simple-custom-post-order' ) ) {
			add_filter( 'option_scporder_options', '__return_false', 10, 2 );
		}

		/**
		 * "Intuitive Custom Post Order" plugin
		 * @since 1.9.9.3
		 */
		if ( cv_is_active_plugin( 'intuitive-custom-post-order' ) ) {
			add_filter( 'option_hicpo_options', '__return_false', 10, 2 );
		}
	}

	return $query;
}

/**
 * OptimizePress plugin
 * Content Views style & script were not loaded in page created by OptimizePress plugin
 * @since 1.9.8
 */
if ( function_exists( 'opRemoveScripts' ) ) {
	remove_action( 'wp_print_scripts', 'opRemoveScripts', 10 );
}
if ( function_exists( 'opRemoveStyles' ) ) {
	remove_action( 'wp_print_styles', 'opRemoveStyles', 10 );
}

add_action( PT_CV_PREFIX_ . 'before_query', 'cv_comp_action_before_query' );
function cv_comp_action_before_query() {
	/* Fix: Posts don't appear in View output, when excludes categories by "Ultimate category excluder" plugin
	 * @since 1.9.9
	 */
	if ( function_exists( 'ksuce_exclude_categories' ) ) {
		remove_filter( 'pre_get_posts', 'ksuce_exclude_categories' );
	}

	/** Fix: woo-event-manager plugin sets DESC order for all Views query
	 * @since 2.0.3
	 */
	if ( function_exists( 'rc_modify_query_get_posts_by_date' ) ) {
		remove_action( 'pre_get_posts', 'rc_modify_query_get_posts_by_date' );
	}
}

/**
 * Backup & restore View settings for pagination
 * @param string $action
 * @param array $view_settings
 */
function cv_comp_pagination_settings( $action, $view_settings ) {
	global $cv_unique_id;
	$cv_unique_id = ''; // reset to prevent using existing value of previous views
	if ( $action === 'set' ) {
		$key	 = $case	 = '';

		if ( defined( 'PT_CV_DOING_PREVIEW' ) ) {
			$key	 = 'preview';
			$case	 = 'preview';
		} elseif ( isset( $view_settings[ PT_CV_PREFIX . 'rebuild' ] ) ) {
			global $wp_query;
			$key	 = $wp_query->query_vars_hash;
			$case	 = 'rebuild';
		} else if ( defined( 'PT_CV_VIEW_REUSE' ) || PT_CV_Functions::get_global_variable( 'reused_view' ) ) {
			$key	 = md5( serialize( $view_settings[ PT_CV_PREFIX . 'shortcode_atts' ] ) );
			$case	 = 'reuse';
		}

		if ( !empty( $key ) && !empty( $case ) ) {
			$cv_unique_id = $key;

			// Simplify the array
			foreach ( $view_settings as $key => $value ) {
				if ( strpos( $key, PT_CV_PREFIX . 'font-' ) === 0 ) {
					unset( $view_settings[ $key ] );
				}
			}

			set_transient( PT_CV_PREFIX . 'view-settings-' . $cv_unique_id, $view_settings, 30 * MINUTE_IN_SECONDS );
		}
	} else if ( $action === 'get' ) {
		$cv_unique_id = cv_sanitize_vid( $_POST[ 'unid' ] );
		return get_transient( PT_CV_PREFIX . 'view-settings-' . $cv_unique_id );
	}
}

/**
 * https://wordpress.org/plugins/lazy-load/ causes pagination loading icon is broken
 * @since 1.9.9.2
 */
add_action( 'pt_cv_add_global_variables', 'cv_comp_plugin_lazyload_break_loading' );
function cv_comp_plugin_lazyload_break_loading() {
	if ( cv_is_active_plugin( 'lazy-load' ) ) {
		remove_filter( 'the_content', array( 'LazyLoad_Images', 'add_image_placeholders' ), 99 );
	}
}

/**
 * Post content begins with a slider shortcode
 * Issue: slider number shows at beginning of generated excerpt
 */
add_filter( 'pt_cv_before_generate_excerpt', 'cv_comp_common_slider_number_in_excerpt' );
function cv_comp_common_slider_number_in_excerpt( $args ) {
	$args	 = preg_replace( '/<a[^>]*>(\d+)<\/a>/', '', $args );
	$args	 = preg_replace( '/<li[^>]*>(\d+)<\/li>/', '', $args );
	return $args;
}

/** Fix error "View * may not exist" caused by the "Shortcodes Anywhere or Everywhere" plugin
 * @since 2.0
 */
add_action( 'pt_cv_get_view_settings', 'cv_comp_plugin_saoe' );
function cv_comp_plugin_saoe() {
	remove_filter( 'get_post_metadata', 'jr_saoe_get_post_metadata', 10 );
}

/** Compatible with Timeline layout which uses old param
 * @since 2.0
 */
add_action( PT_CV_PREFIX_ . 'view_process_start', 'cv_comp_pro_timeline' );
function cv_comp_pro_timeline() {
	$pagenum = cv_comp_get_page_number();
	if ( !empty( $pagenum ) ) {
		$_GET[ 'vpage' ] = $pagenum;
	}
}

/** Get the page number for Normal pagination
 *
 * @return type
 */
function cv_comp_get_page_number() {
	$paged = null;

	// Get old params
	foreach ( array( 'vpage', '_page' ) as $op ) {
		if ( !empty( $_GET[ $op ] ) ) {
			$paged = absint( $_GET[ $op ] );
		}
	}

	if ( !$paged ) {
		$paged = get_query_var( PT_CV_PAGE_VAR );
	}
	// Static front page
	if ( !$paged ) {
		$paged = get_query_var( 'page' );
	}

	return $paged;
}

function cv_comp_pagination_remove_old_param( $link ) {
	$link = remove_query_arg( array( 'vpage', '_page', 'page' ), $link );

	// Visit /?pagevar=N, pagination links wrong
	global $wp_rewrite;
	if ( $wp_rewrite->using_permalinks() ) {
		$link = remove_query_arg( PT_CV_PAGE_VAR, $link );
	}

	return $link;
}

// Make pagination endpoint works with "custom taxonomy"
add_filter( 'register_taxonomy_args', 'cv_add_mask_to_custom_taxonomy', 10, 3 );
function cv_add_mask_to_custom_taxonomy( $args, $name, $object_type ) {
	$args = array_merge( array(
		'rewrite' => true,
		), $args );

	if ( false !== $args[ 'rewrite' ] && ( is_admin() || '' != get_option( 'permalink_structure' ) ) ) {
		$args[ 'rewrite' ] = wp_parse_args( $args[ 'rewrite' ], array(
			'ep_mask' => EP_ALL,
			) );
	}

	return $args;
}

// Register pagination endpoint
add_action( 'init', 'cv_pretty_nonajax_pagination', 999999 );
function cv_pretty_nonajax_pagination() {
	add_rewrite_endpoint( PT_CV_PAGE_VAR, EP_ALL );

	if ( false === get_option( 'cv_pretty_pagination_url_212' ) ) {
		flush_rewrite_rules( false );
		add_option( 'cv_pretty_pagination_url_212', 1 );
	}
}

/** Prevent (no title) issue caused by other plugins */
add_action( PT_CV_PREFIX_ . 'view_process_start', 'cv_comp_prevent_no_title' );
function cv_comp_prevent_no_title() {
	// title-remover plugin
	remove_filter( 'the_title', 'wptr_supress_title', 10, 2 );
}
