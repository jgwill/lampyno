<?php
/**
 * Custom template tags for this theme.
 *   
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package modulus
 */

if ( ! function_exists( 'modulus_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */    
function modulus_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {     
		return;
	}     
	?>   
	<nav class="navigation paging-navigation clearfix" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'modulus' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous rippler rippler-default"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'modulus' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next rippler rippler-default"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'modulus' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'modulus_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function modulus_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation clearfix" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'modulus' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous rippler rippler-default">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'modulus' ) );
				next_post_link(     '<div class="nav-next rippler rippler-default">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'modulus' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'modulus_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function modulus_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('') ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'modulus' ),
		'<i class="fa fa-clock-o"></i> <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( '%s', 'post author', 'modulus' ),
		'<i class="fa fa-user"></i> <span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
	edit_post_link( __( 'Edit', 'modulus' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' );
}
endif;

if ( ! function_exists( 'modulus_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function modulus_entry_footer() {
	// Hide category and tag text for pages.
	
	if ( 'post' == get_post_type() ) {    
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'modulus' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links"><i class="fa fa-folder-open"></i> ' . __( '%1$s ', 'modulus' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'modulus' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . __( '%1$s ', 'modulus' ) . '</span>', $tags_list );
		}
	}
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function modulus_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'modulus_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'modulus_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so modulus_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so modulus_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in modulus_categorized_blog.
 */
function modulus_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'modulus_categories' );
}
add_action( 'edit_category', 'modulus_category_transient_flusher' );
add_action( 'save_post',     'modulus_category_transient_flusher' );   

// Recent Posts with featured Images to be displayed on home page
if( ! function_exists('modulus_recent_posts') ) {
	function modulus_recent_posts() {      
		$output = '';
		$posts_per_page  = get_theme_mod('recent_posts_count', get_option('post_per_page') );
		$post_ID  = explode (',',get_theme_mod('recent_posts_exclude'));
		// WP_Query arguments
		$args = array (
			'post_type'              => 'post',
			'post_status'            => 'publish',   
			'posts_per_page'         => $posts_per_page,
			'ignore_sticky_posts'    => true, 
			'order'                  => 'DESC',
			'post__not_in'           => $post_ID,
		); 

		// The Query
		$query = new WP_Query( $args );

		// The Loop
		if ( $query->have_posts() && get_theme_mod('enable_recent_post_service',true) ) {   
			$output .= '<div class="post-wrapper">';  
			$output .= '<div class="container">';  
			 
			$output .= '<h1 class="title-divider">' . apply_filters('modulus_post_title',__('Recent Post','modulus') ) . '</h1>';
			$output .= '<div class="latest-posts">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$output .= '<div class="one-third column">';
				$output .= '<div class="latest-post">';
						$output .= '<div class="latest-post-thumb">'; 
								if ( has_post_thumbnail() ) {
									$output .= get_the_post_thumbnail($query->post->ID ,'modulus-recent_posts_img');
								}
								else {
									$output .= '<img src="' . get_stylesheet_directory_uri() . '/images/no-image.png" alt="" >';
								}
							$output .= '</div><!-- .latest-post-thumb -->';
					    $output .= '<h3><a href="'. get_permalink() . '">' . get_the_title() . '</a></h3>';
						$output .='<div class="entry-meta">';
							$output .='<span class="data-structure"><span class="dd"><i class="fa fa-calendar"></i>' . get_the_time('j M Y').'</span></span>';
							$output .= modulus_get_author();
							$output .= modulus_get_comments_meta();
						$output .='</div><!-- entry-meta -->';
							
						$output .= '<div class="latest-post-content">';
						$output .= '<p>' . get_the_excerpt() . '</p>';
					$output .= '</div><!-- .latest-post-content -->';
					$more_text = get_theme_mod('more_text');
					if( $more_text && !empty( $more_text ) ) {
						$more_link_text = sprintf(__('%1$s','modulus'), $more_text );
					}else{
						$more_link_text = __('Read More','modulus');
					}
					$output .= '<p><a href="' . get_permalink() . '" class="btn-readmore ">' .$more_link_text.'</a></p>';
					$output .= '</div>';
				$output .= '</div><!-- .latest-post -->';
			}
			$output .= '</div><!-- latest post end -->';
			$output .= '</div><!-- container close -->';
			$output .= '</div><!-- .post-wrapper -->';
		} 
		$query = null;
		// Restore original Post Data
		wp_reset_postdata();
		echo $output;
	}
}

/**
  * Generates Breadcrumb Navigation
  */
 
 if( ! function_exists( 'modulus_breadcrumbs' )) {
 
	function modulus_breadcrumbs() {
		/* === OPTIONS === */
		$text['home']     = __( '<i class="fa fa-home"></i>','modulus' ); // text for the 'Home' link
		$text['category'] = __( 'Archive by Category "%s"','modulus' ); // text for a category page
		$text['search']   = __( 'Search Results for "%s" Query','modulus' ); // text for a search results page
		$text['tag']      = __( 'Posts Tagged "%s"','modulus' ); // text for a tag page
		$text['author']   = __( 'Articles Posted by %s','modulus' ); // text for an author page
		$text['404']      = __( 'Error 404','modulus' ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$breadcrumb_char = get_theme_mod( 'breadcrumb_char', '1' );
		if ( $breadcrumb_char ) {
		 switch ( $breadcrumb_char ) {
		 	case '2' :
		 		$delimiter = ' // ';
		 		break;
		 	case '3':
		 		$delimiter = ' > ';
		 		break;
		 	case '1':
		 	default:
		 		$delimiter = ' &raquo; ';
		 		break;
		 }
		}

		$before      = '<span class="current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$homeLink = home_url() . '/';
		$linkBefore = '<span typeof="v:Breadcrumb">';
		$linkAfter = '</span>';
		$linkAttr = ' rel="v:url" property="v:title"';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

		if (is_home() || is_front_page()) {

			if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

		} else {

			echo '<div id="crumbs" xmlns:v="http://rdf.data-vocabulary.org/#">' . sprintf($link, $homeLink, $text['home']) . $delimiter;

			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;

			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				}
   
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				echo $before . $post_type->labels->singular_name . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				printf($link, get_permalink($parent), $parent->post_title);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

			} elseif ( is_author() ) {
		 		global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;

			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}

			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				echo __('Page', 'modulus' ) . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}

			echo '</div>';

		}
	
	} // end modulus_breadcrumbs()

}

function modulus_author() {
	$byline = sprintf(
		_x( '%s', 'post author', 'modulus' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i> ' . esc_html( get_the_author() ) . '</a></span>'
	);	

	echo $byline;
}
function modulus_get_author() {
	$byline = sprintf(
		_x( '%s', 'post author', 'modulus' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i> ' . esc_html( get_the_author() ) . '</a></span>'
	);	

	return $byline;
}
function modulus_comments_meta() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo ' <span class="comments-link"><i class="fa fa-comments"></i>';
		comments_popup_link( __( 'Leave a comment', 'modulus' ), __( '1 Comment', 'modulus' ), __( '% Comments', 'modulus' ) );
		echo '</span>';

	}	
}

function modulus_get_comments_meta() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		$comments_meta = '<span class="comments-link"><i class="fa fa-comments"></i>';
		$comments_meta .= get_comments_popup_link( __( 'Leave a comment', 'modulus' ), __( '1 Comment', 'modulus' ), __( '% Comments', 'modulus' ) );
		$comments_meta .=  '</span>';
		return $comments_meta;

	}	
}


function modulus_edit() {
	edit_post_link( __( 'Edit', 'modulus' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' );
}


function get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
	global $wpcommentspopupfile, $wpcommentsjavascript;

	$id = get_the_ID();
	$title = get_the_title();
	$number = get_comments_number( $id );

	if ( false === $zero ) {
		/* translators: %s: post title */
		$zero = sprintf( __( 'No Comments<span class="screen-reader-text"> on %s</span>','modulus' ), $title );
	}

	if ( false === $one ) {
		/* translators: %s: post title */
		$one = sprintf( __( '1 Comment<span class="screen-reader-text"> on %s</span>','modulus' ), $title );
	}

	if ( false === $more ) {
		/* translators: 1: Number of comments 2: post title */
		$more = _n( '%1$s Comment<span class="screen-reader-text"> on %2$s</span>', '%1$s Comments<span class="screen-reader-text"> on %2$s</span>', $number, 'modulus' );
		$more = sprintf( $more, number_format_i18n( $number ), $title );
	}

	if ( false === $none ) {
		/* translators: %s: post title */
		$none = sprintf( __( 'Comments Off<span class="screen-reader-text"> on %s</span>','modulus' ), $title );
	}

	if ( 0 == $number && !comments_open() && !pings_open() ) {
		return '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
	}

	if ( post_password_required() ) {
		return __('Enter your password to view comments.','modulus');
	}

	$link_anchor =  '<a href="';
	if ( $wpcommentsjavascript ) {
		if ( empty( $wpcommentspopupfile ) )
			$home = home_url();
		else
			$home = get_option('siteurl');
		$link_anchor .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
		$link_anchor .= '" onclick="wpopen(this.href); return false"';
	} else { 
		if ( 0 == $number ){
			$link_anchor .= get_permalink() . '#respond';	
		} else {
			$link_anchor .= get_comments_link();
		}
		$link_anchor .= '"';
	}

	if ( !empty( $css_class ) ) {
		$link_anchor .= ' class="'.$css_class.'" ';
	}

	$attributes = '';
	$link_anchor .= apply_filters( 'comments_popup_link_attributes', $attributes );
	$link_anchor .= '>';
	$link_anchor .= get_comments_number_text( $zero, $one, $more );
	$link_anchor .= '</a>';
	return $link_anchor;
}




// free-extra functions //

	// Related Posts Function by Tags (call using modulus_related_posts(); ) /NecessarY/ May be write a shortcode?
	function modulus_related_posts() {
		echo '<ul id="webulous-related-posts">';
		global $post;
		$post_hierarchy = get_theme_mod('related_posts_hierarchy','1');
		$relatedposts_per_page  =  get_option('post_per_page') ;
		if($post_hierarchy == '1') {
			$related_post_type = wp_get_post_tags($post->ID);
			$tag_arr = '';
			if($related_post_type) {
				foreach($related_post_type as $tag) { $tag_arr .= $tag->slug . ','; }
		        $args = array(
		        	'tag' => $tag_arr,
		        	'numberposts' => $relatedposts_per_page, /* you can change this to show more */
		        	'post__not_in' => array($post->ID)
		     	);
		   }
		}else {
			$related_post_type = get_the_category($post->ID); 
			if ($related_post_type) {
				$category_ids = array();
				foreach($related_post_type as $category) {
				     $category_ids = $category->term_id; 
				}  
				$args = array(
					'category__in' => $category_ids,
					'post__not_in' => array($post->ID),
					'numberposts' => $relatedposts_per_page,
		        );
		    }
		}
		if( $related_post_type ) {
	        $related_posts = get_posts($args);
	        if($related_posts) {
	        	foreach ($related_posts as $post) : setup_postdata($post); ?>
		           	<li class="related_post">
		           		<a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail('recent-work'); ?></a>
		           		<a class="entry-unrelated" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		           	</li>
		        <?php endforeach; }
		    else {
	            echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'modulus' ) . '</li>'; 
			 }
		}else{
			echo '<li class="no_related_post">' . __( 'No Related Posts Yet!', 'modulus' ) . '</li>';
		}
		wp_reset_query();
		
		echo '</ul>';
	}



if( ! function_exists( 'modulus_pagination' )) {

	/**
	 * Generates Pagination without WP-PageNavi Plugin
	 */
	
	function modulus_pagination($before = '', $after = '') {
		global $wpdb, $wp_query;
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));
		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		if ( $numposts <= $posts_per_page ) { return; }
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 7;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		echo $before.'<nav class="page-navigation"><ol class="webulous_page_navi pagination">'."";
		if ($start_page >= 2 && $pages_to_show < $max_page) {
			$first_page_text = __( "First", 'modulus' );
			echo '<li class="bpn-first-page-link rippler rippler-default"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
		}
		echo '<li class="bpn-prev-link rippler rippler-default">';
		previous_posts_link('&nbsp;');
		echo '</li>';
		for($i = $start_page; $i  <= $end_page; $i++) {
			if($i == $paged) {
				echo '<li class="bpn-current">'.$i.'</li>';
			} else {
				echo '<li class="rippler rippler-default"><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
			}
		}
		echo '<li class="bpn-next-link rippler rippler-default">';
		next_posts_link('&nbsp;');
		echo '</li>';
		if ($end_page < $max_page) {
			$last_page_text = __( "Last", 'modulus' );
			echo '<li class="bpn-last-page-link rippler rippler-default"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
		}
		echo '</ol></nav>'.$after."";
	}
} /* modulus_pagination */

/* kirki options function */

/*  Site Layout Option  */
if( !function_exists('modulus_layout_class') ) {
	function modulus_layout_class() {
		if( is_home() &&  ( get_theme_mod('blog_layout',1) == 3 || get_theme_mod('blog_layout',1) == 5 || get_theme_mod('blog_layout',1) == 6) ) {
	       echo 'sixteen';
	       return;
		}
	     $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
		     if( 'fullwidth' == $sidebar_position ) {
		     	echo 'sixteen';
		     }elseif('two-sidebar' == $sidebar_position || 'two-sidebar-left' == $sidebar_position || 'two-sidebar-right' == $sidebar_position ) {
		     	echo 'eight';
		     }
		     else{
		     	echo 'eleven';
		     }
		     if ( 'no-sidebar' == $sidebar_position ) {
		     	echo ' no-sidebar';
		     }
	}
}

/* Two Sidebar Left action */

add_action('modulus_two_sidebar_left','modulus_double_sidebar_left');   
if( !function_exists('modulus_double_sidebar_left') ) { 
 function modulus_double_sidebar_left() {
    $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
		if( 'two-sidebar' == $sidebar_position || 'two-sidebar-left' == $sidebar_position ) :
			 get_sidebar('left'); 
		endif; 
		if('two-sidebar-left' == $sidebar_position || 'left' == $sidebar_position ):
			get_sidebar(); 
		endif; 
 }	
}

/* Two Sidebar Right action */     

 add_action('modulus_two_sidebar_right','modulus_double_sidebar_right'); 	
if( !function_exists('modulus_double_sidebar_right') ) { 
  function modulus_double_sidebar_right() {
  	 $sidebar_position = get_theme_mod( 'sidebar_position', 'right' ); 
		 if( 'two-sidebar' == $sidebar_position || 'two-sidebar-right' == $sidebar_position || 'right' == $sidebar_position) :
			 get_sidebar(); 
		endif; 	
		if('two-sidebar-right' == $sidebar_position ):
			get_sidebar('left'); 
		endif; 
 }
}


add_action('modulus_single_flexslider_featured_image','modulus_single_flexslider_featured_image_top');
if( !function_exists('modulus_single_flexslider_featured_image_top') ) { 
	function modulus_single_flexslider_featured_image_top() {
		$single_featured_image = get_theme_mod( 'single_featured_image',true );
		$single_featured_image_size = get_theme_mod ('single_featured_image_size',1);
		if( $single_featured_image && $single_featured_image_size == 3 ) {
		    if( has_post_thumbnail() && ! post_password_required() ) :   
				the_post_thumbnail( 'post-thumbnail', array('class' => "single_page_flexslider_feature_image") ); 
			endif;
		}
	}
}


add_action('modulus_single_page_flexslider_featured_image','modulus_single_page_flexslider_featured_image_top');
if( !function_exists('modulus_single_page_flexslider_featured_image_top') ) { 
	function modulus_single_page_flexslider_featured_image_top() {
		$single_page_featured_image = get_theme_mod( 'single_page_featured_image',true );
		$single_page_featured_image_size = get_theme_mod ('single_page_featured_image_size',1);
		if( $single_page_featured_image && $single_page_featured_image_size == 2) {
		    if( has_post_thumbnail() && ! post_password_required() ) :   
				the_post_thumbnail( 'post-thumbnail', array('class' => "single_page_flexslider_feature_image") ); 
			endif;
		}
	}
}		

/* modulus Custom Logo */

add_filter( 'get_custom_logo', 'modulus_custom_logo' );
if( !function_exists('modulus_custom_logo') ) { 
	function modulus_custom_logo($html) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo = get_theme_mod( 'logo', '' );
		echo '<h1 class="site-title img-logo">';
		if(!$custom_logo_id && $logo!= '') {	
		    echo '<img src="'.$logo.'">';
		}else{
			echo $html;
		}
		echo '<h1>';  
	}
}

if( !function_exists('modulus_masonry_blog_layout_class') ) { 
	function modulus_masonry_blog_layout_class() {
		if( is_home() && get_theme_mod('blog_layout',1) == 4 ||  get_theme_mod('blog_layout',1) == 5 ) {
			echo 'masonry-blog-content';  
		}
	}
}
if( ! function_exists( 'modulus_featured_image' ) ) {
	function modulus_featured_image() {
		$featured_image_size = get_theme_mod ('featured_image_size', 1);
		if ( has_post_thumbnail() && ! post_password_required() ) :
			if( $featured_image_size == 1 ) :
				the_post_thumbnail('modulus-blog-full-width');
			elseif( $featured_image_size == 2 ) :
				the_post_thumbnail('modulus-small-featured-image-width');
			elseif( $featured_image_size == 3 ) :
				the_post_thumbnail('full');
			elseif( $featured_image_size == 4 ) :
				the_post_thumbnail('medium');
			elseif( $featured_image_size == 5 ) :
				the_post_thumbnail('large');
			endif;
		endif;
	}
}
/* Page site style class ( layout )*/

if( !function_exists('modulus_site_style_class') ) {     
	function  modulus_site_style_class(){
       $site_style = get_theme_mod('site-style');
	    if( $site_style == 'boxed' )  { 
		  $site_style_class = 'container boxed-container';
		}elseif( $site_style == 'fluid' ){    
	       $site_style_class = 'fluid-container';	 
		}
		else{
			 $site_style_class = '';
		} 
		return $site_style_class; 
	}
}

/* Page site style header class ( layout )*/

if( !function_exists('modulus_site_style_header_class') ) { 
	function  modulus_site_style_header_class(){
        $site_style = get_theme_mod('site-style');
	    if( $site_style == 'boxed' )  { 
		  $site_style_header_class = 'boxed-header';
		}elseif( $site_style == 'fluid' ){
	       $site_style_header_class = 'fluid-header';
		}
		else{
			 $site_style_header_class = '';
		} 
		return $site_style_header_class;
	}
}
add_action('modulus_sidebar_right_widget','modulus_sidebar_right_widget');
if( !function_exists('modulus_sidebar_right_widget') ) { 
	function modulus_sidebar_right_widget() {
		    if (  is_active_sidebar( 'sidebar-1' ) ) {
				 dynamic_sidebar('sidebar-1');
			}else { ?>
				<aside id="meta" class="widget">
					<h4 class="widget-title"><?php _e( 'Meta', 'modulus' ); ?></h4>
					<ul>
						<?php wp_register(); ?>
						<li><?php wp_loginout(); ?></li>
						<?php wp_meta(); ?>
					</ul>
		        </aside><?php 
		   }  
	}
}
if ( ! function_exists( 'modulus_entry_top_meta' ) ) : 
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function modulus_entry_top_meta() {   
	// Post meta data 
	
	  $single_post_top_meta = get_theme_mod('single_post_top_meta', array(1,2,6) );
      // echo '<pre>',print_r($single_post_top_meta),'</pre>';
	
    if ( 'post' == get_post_type() ) {  
		foreach ($single_post_top_meta as $key => $value) {
		    if( $value == '1') { 
		    	global $post;?>
		  	    <span class="date-structure">				
					<span class="dd"><a class="url fn n" href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'),get_the_time('d')); ?>"><i class="fa fa-clock-o"></i><?php the_time('j M Y'); ?></a></span>		
				</span>
	<?php   }elseif( $value == 2) {
				printf(
					_x( '%s', 'post author', 'modulus' ),
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i> ' . esc_html( get_the_author() ) . '</a></span>'
				);	
			}elseif( $value == 3)  {
				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
					echo ' <span class="comments-link"><i class="fa fa-comments"></i>';
					comments_popup_link( __( 'Leave a comment', 'modulus' ), __( '1 Comment', 'modulus' ), __( '% Comments', 'modulus' ) );
					echo '</span>';
			    }
	        }elseif( $value == 4) {
				$categories_list = get_the_category_list( __( ', ', 'modulus' ) );
				if ( $categories_list ) {
					printf( '<span class="cat-links"><i class="fa fa-folder-open"></i> ' . __( '%1$s ', 'modulus' ) . '</span>', $categories_list );
				}	
		    }elseif( $value == 5)  {
	    		/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'modulus' ) );
				if ( $tags_list ) {
					printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . __( '%1$s ', 'modulus' ) . '</span>', $tags_list );
				}			
		    }elseif( $value == 6) {
		        edit_post_link( __( 'Edit', 'modulus' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' );
		    }
	    }
	}
}

endif;
if ( ! function_exists( 'modulus_entry_bottom_meta' ) ) : 
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function modulus_entry_bottom_meta() {   
	// Post meta data 
	
	$single_post_bottom_meta = get_theme_mod('single_post_bottom_meta', array(4,5) );

	if ( 'post' == get_post_type() ) {  
		foreach ($single_post_bottom_meta as $key => $value) {
		    if( $value == '1') { ?>
		  	    <span class="date-structure">				
					<span class="dd"><a class="url fn n" href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'),get_the_time('d')); ?>"><i class="fa fa-clock-o"></i><?php the_time('j M Y'); ?></a></span>	
				</span>
	<?php   }elseif( $value == 2) {
				printf(
					_x( '%s', 'post author', 'modulus' ),
					'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"><i class="fa fa-user"></i> ' . esc_html( get_the_author() ) . '</a></span>'
				);	
			}elseif( $value == 3)  {
				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
					echo ' <span class="comments-link"><i class="fa fa-comments"></i>';
					comments_popup_link( __( 'Leave a comment', 'modulus' ), __( '1 Comment', 'modulus' ), __( '% Comments', 'modulus' ) );
					echo '</span>';
			    }
	        }elseif( $value == 4) {
				$categories_list = get_the_category_list( __( ', ', 'modulus' ) );
				if ( $categories_list ) {
					printf( '<span class="cat-links"><i class="fa fa-folder-open"></i> ' . __( '%1$s ', 'modulus' ) . '</span>', $categories_list );
				}	
		    }elseif( $value == 5)  {
	    		/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'modulus' ) );
				if ( $tags_list ) {
					printf( '<span class="tags-links"><i class="fa fa-tags"></i> ' . __( '%1$s ', 'modulus' ) . '</span>', $tags_list );
				}			
		    }elseif( $value == 6) {
		        edit_post_link( __( 'Edit', 'modulus' ), '<span class="edit-link"><i class="fa fa-pencil"></i> ', '</span>' );
		    }
	    }
	}
}

endif;

/* Free home Sidebar - container class */
if(!function_exists('modulus_free_home_container') ) {
	function modulus_free_home_container() {
       if( get_theme_mod('home_sidebar',false) ) {
          echo 'container';
       }
	}
}

/* Free home Sidebar - primary class */
if(!function_exists('modulus_free_home_primary') ) {  
	function modulus_free_home_primary() {
		if( get_theme_mod('home_sidebar',false) ) {
          echo 'eleven columns';
       }
	}
}

/* Admin notice */
/* Activation notice */
add_action( 'load-themes.php',  'modulus_one_activation_admin_notice'  );

if( !function_exists('modulus_one_activation_admin_notice') ) {
	function modulus_one_activation_admin_notice() {
        global $pagenow;
	    if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
	        add_action( 'admin_notices', 'modulus_admin_notice' );
	    } 
	} 
}    



/**
 * Add admin notice when active theme
 *
 * @return bool|null
 */
function modulus_admin_notice() { ?>
    <div class="updated notice notice-alt notice-success is-dismissible">  
        <p><?php printf( __( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our <a href="%2$s">Welcome page</a>', 'modulus' ), 'Modulus', esc_url( admin_url( 'themes.php?page=modulus_upgrade' ) ) ); ?></p>
    	<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=modulus_upgrade' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Modulus', 'modulus' ); ?></a></p>
    </div><?php
}