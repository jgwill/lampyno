<?php
/***********************************************
* Custom Function Related to Theme
*
* http://www.insertcart.com/republic
***********************************************/


/* ----------------------------------------------------------------------------------- */
/* Breadcrumbs Support
  /*----------------------------------------------------------------------------------- */

function republic_breadcrumbs() {
    $delimiter = '';
    $home = __('Home', 'republic'); // text for the 'Home' link
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb
    echo '<ul class="breadcrumbs">';
    global $post;
    $homeLink = esc_url(home_url('/'));
    echo '<li><a href="' . esc_url($homeLink) . '">' . esc_html($home) . '</a></li> ' . esc_html($delimiter) . ' ';

    if (is_category()) {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        $thisCat = $cat_obj->term_id;
        $thisCat = get_category($thisCat);
        $parentCat = get_category($thisCat->parent);
        if ($thisCat->parent != 0)
            echo(esc_html(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ')));
        echo esc_html($before) . esc_attr('Archive by category','republic'). single_cat_title('', false) . $after;
    } elseif (is_day()) {
        echo '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('d') . $after;
    } elseif (is_month()) {
        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
        echo $before . get_the_time('F') . $after;
    } elseif (is_year()) {
        echo $before . get_the_time('Y') . $after;
    } elseif (is_single() && !is_attachment()) {
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<li><a href="' . esc_url($homeLink) . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li> ' . $delimiter . ' ';
            echo $before . esc_html(get_the_title()) . $after;
        } else {
            $cat = get_the_category();
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo $before . esc_html(get_the_title()) . $after;
        }
    } elseif (is_attachment()) {
        $parent = get_post($post->post_parent);
        //$cat = get_the_category($parent->ID); $cat = $cat[0];
        //echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo '<li><a href="' . esc_url(get_permalink($parent)) . '">' . esc_attr($parent->post_title). '</a></li> ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_page() && !$post->post_parent) {
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_page() && $post->post_parent) {
        $parent_id = $post->post_parent;
        $breadcrumbs = array();
        while ($parent_id) {
            $page = get_page($parent_id);
            $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a></li>';
            $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        foreach ($breadcrumbs as $crumb)
            echo $crumb . ' ' . $delimiter . ' ';
        echo $before . esc_html(get_the_title()) . $after;
    } elseif (is_search()) {
        echo $before .__('Search results for','republic') . get_search_query() . $after;
    } elseif (is_tag()) {
        echo $before . __('Posts tagged','republic'). single_tag_title('', false) . $after;
    } elseif (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo $before . __('Articles posted by ','republic') . esc_attr($userdata->display_name) . $after;
    } elseif (is_404()) {
        echo $before . __('Error 404','republic') . $after;
    }

    if (get_query_var('paged')) {
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            echo ' (';
        echo __('Page','republic') . ' ' . get_query_var('paged','republic');
        if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
            echo ')';
    }

    echo '</ul>';
}




/* ----------------------------------------------------------------------------------- */
/* Customize Comment Form
  /*----------------------------------------------------------------------------------- */
add_filter( 'comment_form_default_fields', 'republic_comment_form_fields' );
function republic_comment_form_fields( $fields ) {
    $commenter = wp_get_current_commenter();
    
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html5    = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
    
    $fields   =  array(
        'author' => '<div class="medium-6 large-6 columns"><div class="row collapse prefix-radius"><div class="small-2 columns">' . '<span class="prefix"><i class="fa fa-user"></i>' . ( $req ? ' <span class="required">*</span>' : '' ) . '</span> </div>' .
                    '<div class="small-10 columns"><input class="form-control" placeholder="'. __( 'Name','republic' ).'" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'email'  => '<div class="medium-6 large-6 columns"><div class="row collapse prefix-radius"><div class="small-2 columns">' . '<span class="prefix"><i class="fa fa-envelope-o"></i>' . ( $req ? ' <span class="required">*</span>' : '' ) . '</span></div> ' .
                    '<div class="small-10 columns"><input class="form-control" id="email" placeholder="'. __( 'Email','republic' ).'"  name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="20"' . $aria_req . ' /></div></div></div>',
        'url'    => '<div class="medium-6 large-6 columns"><div class="row collapse prefix-radius"><div class="small-2 columns">' . '<span class="prefix"><i class="fa fa-external-link"></i>' . '</span> </div>' .
                    '<div class="small-10 columns"><input class="form-control" id="url" placeholder="'. __( 'Website','republic' ).'"  name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div></div>'        
    );
    
    return $fields;
    
    
}

add_filter( 'comment_form_defaults', 'republic_comment_form' );
function republic_comment_form( $argsbutton ) {
        $argsbutton['class_submit'] = 'button'; 
    
    return $argsbutton;
}


/* ----------------------------------------------------------------------------------- */
/* Custom Search Form
  /*----------------------------------------------------------------------------------- */
function republic_search_form( $form ) {
	$form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url( '/' )) . '" >
            <div class="row">
            <div class="large-12 columns">
            <div class="row collapse">
            <div class="small-10 columns">
             <input type="text" placeholder="'.__('Search','republic').'" value="' . get_search_query() . '" name="s" id="s" />
            </div>
            <div class="small-2 columns">
           <i class="fa fa-search"></i><input type="submit" class="button postfix" value="'. esc_attr__( 'Go','republic' ) .'" />
            </div>
            </div>
            </div>
            </div>  
        </form>';

	return $form;
}

add_filter( 'get_search_form', 'republic_search_form' );


/**
 * Primary Menu
 */
function republic_display_primary_menu() {
	wp_nav_menu( array(
		'theme_location' => 'topmenu',
		'menu' => __('Top Menu','republic'),

		'container' => false, // remove nav container
		'container_class' => '', // class of container
		'menu_class' => 'top-bar-menu right', // adding custom nav class
		'before' => '', // before each link <a>
		'after' => '', // after each link </a>
		'link_before' => '', // before each link text
		'link_after' => '', // after each link text
		'depth' => 5, // limit the depth of the nav
		'fallback_cb' => true, // fallback function (see below)
		'walker' => new republic_top_bar_walker()
	) );
}


/**
 * Customized menu output
 */
class republic_top_bar_walker extends Walker_Nav_Menu {

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $element->has_children = !empty( $children_elements[$element->ID] );
        $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';
        $element->classes[] = ( $element->has_children ) ? 'has-dropdown' : '';

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 ) {
        $item_html = '';
        parent::start_el( $item_html, $object, $depth, $args ); 

        // $output .= ( $depth == 0 ) ? '<li class="divider"></li>' : '';

        $classes = empty( $object->classes ) ? array() : (array) $object->classes;  

        if( in_array('label', $classes) ) {
            $output .= '<li class="divider"></li>';
            $item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '<label>$1</label>', $item_html );
        }

    if ( in_array('divider', $classes) ) {
        $item_html = preg_replace( '/<a[^>]*>( .* )<\/a>/iU', '', $item_html );
    }

        $output .= $item_html;
    }

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "\n<ul class=\"sub-menu dropdown\">\n";
    }

}



/* ----------------------------------------------------------------------------------- */
/* Woocommerce account infobar
  /*----------------------------------------------------------------------------------- */


function republic_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr( 'View your shopping cart' ,'republic'); ?>"><?php echo sprintf (_n( '%d item', '%d items','republic'), WC()->cart->cart_contents_count, WC()->cart->cart_contents_count ); ?> - <?php echo wp_kses_post(WC()->cart->get_cart_total()); ?></a> 
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'republic_woocommerce_header_add_to_cart_fragment' );

 function republic_wooaccinfo(){
        if ( is_user_logged_in() ) {

	echo '<li>';
	echo '<a class="myacc" href="';
	echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id') ));
	echo '" title="'.esc_attr('My Account','republic').'">'.esc_attr('My Account','republic').'</a></li>';
	}
else {

	echo '<li><a class="myacclo" href="';
	echo esc_url(get_permalink( get_option('woocommerce_myaccount_page_id')) ); 
	echo '" title="'.esc_attr('Login / Register','republic').'">'.esc_attr('Login / Register','republic').'</a></li>';
	}
	global $woocommerce;
		
	echo '<li><a class="cart-contents" href="';
	echo esc_url($woocommerce->cart->get_cart_url());
	echo '" title="'.esc_attr('View your shopping cart','republic').'">';
	echo esc_html(sizeof( WC()->cart->get_cart()));
	echo esc_attr(' items - ','republic');
	$wcsubcart = WC()->cart->get_cart_subtotal();
	$wcsubcart = preg_replace('/<(span).*?class="\s*(?:.*\s)?target(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $wcsubcart);
	echo $wcsubcart;
	echo '</a></li>';

        }
        
        
 function republic_before_shop_item_buttons() {
				global $post;
				$html = '';
				$buttons_container = '<div class="product-buttons"><div class="product-buttons-container clearfix">';
				if( isset( $_SERVER['QUERY_STRING'] ) ) {
					parse_str( $_SERVER['QUERY_STRING'], $params );
					if( isset ( $params['product_view'] ) ){
						$product_view = $params['product_view'];
						if( $product_view == 'list' ){
							$html = '<div class="product-excerpt product-' . esc_attr($product_view) . '">';
							$html .= '<div class="product-excerpt-container">';
							$html .= '<div class="post-content">';
							$html .= apply_filters( 'woocommerce_short_description', esc_html($post->post_excerpt ));
							$html .= '</div>';
							$html .= '</div>';
							$html .= $buttons_container;
							$html .= ' </div>';
							
							echo $html;
						} else {
							echo $buttons_container;
						}
					} else {
						echo $buttons_container;
					}
				} else {
					echo $buttons_container;
				}
			}
                        
                        
                        
function republic_after_shop_item_buttons() {
             global $product;

             $styles = '';
             if ( ! $product->is_purchasable() || 
                      ! $product->is_in_stock()
             ) {
                     $styles = ' style="float:none;max-width:none;text-align:center;"';
             }
             echo sprintf( '<a href="%s" class="show_details_button"%s>%s</a></div></div>', esc_url(get_permalink()), $styles, esc_attr( 'Details', 'republic' ) );
     }

    add_action( 'woocommerce_after_shop_loop_item','republic_before_shop_item_buttons', 9 );
    add_action( 'woocommerce_after_shop_loop_item', 'republic_after_shop_item_buttons', 11 );
	
	
    // add_action( 'woocommerce_before_shop_loop_item_title', 'republic_woocommerce_thumbnail', 10 );
    // remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

 // function republic_woocommerce_thumbnail() {
		// global $product, $woocommerce;

		// $items_in_cart = array();

		// if ( $woocommerce->cart->get_cart() && is_array( $woocommerce->cart->get_cart() ) ) {
			// foreach ( $woocommerce->cart->get_cart() as $cart ) {
				// $items_in_cart[] = $cart['product_id'];
			// }
		// }

		// $id      = get_the_ID();
		// $in_cart = in_array( $id, $items_in_cart );
		// $size    = 'shop_catalog';

		// $gallery          = get_post_meta( $id, '_product_image_gallery', true );
		// $attachment_image = '';
		// if ( ! empty( $gallery ) ) {
			// $gallery          = explode( ',', $gallery );
			// $first_image_id   = $gallery[0];
			// $attachment_image = wp_get_attachment_image( $first_image_id, $size, false, array( 'class' => 'hover-image' ) );
		// }
		// $thumb_image = get_the_post_thumbnail( $id, $size );

		// if ( $attachment_image ) {
			// $classes = 'crossfade-images';
		// } else {
			// $classes = '';
		// }

		// echo '<span class="' . $classes . '">';
		// echo $attachment_image;
		// echo $thumb_image;
		
		// echo '</span>';
	// }
                        

/* ----------------------------------------------------------------------------------- */
/* single Post share
/*----------------------------------------------------------------------------------- */
        
function republic_close_summary_div()
{
	$currentlink = esc_url( get_permalink() ); ?>
	<div class='woosingle-sidebar2'>
	<div class="republic-social">
  <a href="http://www.facebook.com/sharer.php?u=<?php echo esc_url($currentlink); ?>" class="item facebook">
   <i class="fa fa-facebook-f"></i>  </a>
  <a href="https://twitter.com/share?url=<?php echo esc_url($currentlink); ?>" class="item twitter">
    <i class="fa fa-twitter"></i>
  </a>
  <a href="https://plus.google.com/share?url=<?php echo esc_url($currentlink); ?>" class="item google">
    <i class="fa fa-google-plus"></i>
   </a>
  
  <a href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20' . esc_url($currentlink) .'" class="item envelope">
   <i class="fa fa-envelope"></i> </a>
  <a href="http://pinterest.com/pin/create/button/?url=<?php echo  esc_url($currentlink); ?>" class="item pinterest">
    <i class="fa fa-pinterest-p"></i> </a>	
  <a href="http://www.linkedin.com/shareArticle?url=<?php echo  esc_url($currentlink); ?>" class="item linkedin">
    <i class="fa fa-linkedin"></i> </a> 
	<a href="http://tumblr.com/widgets/share/tool?canonicalUrl=<?php echo  esc_url($currentlink); ?> " class="item tumblr">
    <i class="fa fa-tumblr"></i> </a> 
	<a class="item print" id="printpagebutton" onclick="printpage()"><i class="fa fa-print"></i></a>
	
	
</div>
	</div>
	<?php
}

/*----------------------------------------------------------------------------------- */
/* Footer scroll to top
/*----------------------------------------------------------------------------------- */

if(get_theme_mod('republic_backtotop') !='1') {
function republic_backtotop_function() {
    echo '<a href="#" class="scrollup backtoup"><i class="fa fa-chevron-up"></i></a>';
    
}
add_action( 'wp_footer', 'republic_backtotop_function' );}

/* ----------------------------------------------------------------------------------- */
/* Tabs Blog Post
/*----------------------------------------------------------------------------------- */
function republic_blogpoststabs(){ 
    $args = array( 
    'ignore_sticky_posts' => true,
    'showposts' => 6,
    'orderby' => 'date',  );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();

     echo '<div class="latest-post">';
    if ( has_post_thumbnail() ) {the_post_thumbnail();}
    else {
    echo '<img src="';
    echo esc_url(get_template_directory_uri()); 
    echo '/images/thumb.jpg" class="blog-post-img"/>';
    }
    echo '<a title="';
    the_title();
    echo'" href="';
    the_permalink();
    echo '" rel="bookmark">';
     the_title();
    echo '</a><br />';
    echo '<div class="clear"></div></div>';
    endwhile; endif; wp_reset_postdata(); 
    echo '<div style="clear:both;"></div>';

}
add_action('republic_tabs_blog_posts', 'republic_blogpoststabs');

/* ----------------------------------------------------------------------------------- */
/* Comment Reply Link
  /*----------------------------------------------------------------------------------- */

function republic_comment_reply_link_filter($content){
    return '<div class="button replybutton">' . wp_kses_post($content) . '</div>';
}
add_filter('comment_reply_link', 'republic_comment_reply_link_filter', 99);

/* ----------------------------------------------------------------------------------- */
/* Excerpt for Post
/*----------------------------------------------------------------------------------- */
function republic_custom_excerpt_length( $length ) {
        $length = 20;
	return $length;
}
add_filter( 'excerpt_length', 'republic_custom_excerpt_length', 999 );

/* ----------------------------------------------------------------------------------- */
/* Popular\Recent Post Wedget Hide or show
/*----------------------------------------------------------------------------------- */
function republic_custom_widget1(){
if (get_theme_mod("hide_sidebar_widget")!='1'){
    get_template_part('template-parts/widget-sidebar');
  
}}
  add_action('before_sidebar','republic_custom_widget1');

/* ----------------------------------------------------------------------------------- */
/* News Ticker
/*----------------------------------------------------------------------------------- */
function republic_ticker(){
	$tickercat = get_theme_mod('tickercategory');
      echo '<ul class="ticker" >';
     $republic_ticker_args = array( 
    'ignore_sticky_posts' => true,
	'cat' => $tickercat, 
    'showposts' => 8,
	'orderby' => 'post_date',
     );
    $the_query = new WP_Query( $republic_ticker_args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();

    echo '<li><h5><span>'.esc_attr(get_theme_mod('ticker_name','News')).' <i class="fa fa-bar-chart"></i></span><a title="';
    the_title();
    echo'" href="';
    the_permalink();
    echo '" rel="bookmark">';
     the_title();
    echo '</a></h5>';
    echo '<div class="clear"></div></li>';
    endwhile; endif; wp_reset_postdata();
    echo '</ul>';
}

/* ----------------------------------------------------------------------------------- */
/* Custom CSS Output
/*----------------------------------------------------------------------------------- */


function republic_css(){
	$custom_css = '
	span.label.front-label.one{background-color:'.esc_html(get_theme_mod('republic_catecolorone')).' !important;}
	   #main > div.large-8.column > div.large-12.column.republic.one{border-color:'.esc_html(get_theme_mod('republic_catecolorone')).' !important; }
	  #main > div.large-8.column > div.large-12.column.republic.two{border-color:'.esc_html(get_theme_mod('republic_catecolortwo')).' !important; }
	   span.label.front-label.two{background-color:'.esc_html(get_theme_mod('republic_catecolortwo')).' !important;}
	  #main > div.large-8.column > div.large-12.column.republic.three{border-color:'.esc_html(get_theme_mod('republic_catecolorthree')).' !important; }
	   span.label.front-label.three{background-color:'.esc_html(get_theme_mod('republic_catecolorthree')).' !important;}
	  #main > div.large-8.column > div.large-12.column.republic.blog{border-color:'.esc_html(get_theme_mod('bloglabel_color')).' !important; }
	   span.label.front-label.blog{background-color:'.esc_html(get_theme_mod('bloglabel_color')).' !important;}
	    .orbit-caption{	display:'.esc_html(get_theme_mod('slider_caption','block')).' !important;}
	 
	'.html_entity_decode(get_theme_mod('custom_css')).'';

	wp_add_inline_style( 'republic-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'republic_css' );
	

/* ----------------------------------------------------------------------------------- */
/* Pagination
  /*----------------------------------------------------------------------------------- */

if ( ! function_exists( 'republic_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function republic_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 2,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&laquo; Previous', 'republic' ),
		'next_text' => __( 'Next &raquo;', 'republic' ),
                'type'     => 'list',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_attr( 'Posts navigation', 'republic' ); ?></h1>
		<ul class="pagination loop-pagination">
			<?php echo $links; ?>
		</ul><!-- .pagination -->
	</nav><!-- .navigation -->
	<style>div#infinite-handle{display:none;} </style>
	<?php
	endif;
}
endif;