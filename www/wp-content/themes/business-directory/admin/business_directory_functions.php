<?php

function business_directory_theme_function() {
    add_editor_style();
    //Load languages file
    load_theme_textdomain('business-directory', get_template_directory() . '/langlanglang');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_image_size('business_directory-post_thumbnail', 205, 143, true);
    add_image_size('business_directory-home_post_thumbnail', 205, 143, true);
    register_nav_menu('custom_menu', __('Main Menu', 'business-directory'));
}

add_action('after_setup_theme', 'business_directory_theme_function');
/* ----------------------------------------------------------------------------------- */
/* Custom Menus Function
  /*----------------------------------------------------------------------------------- */

function business_directory_add_menuclass($ulclass) {
    return preg_replace('/<ul>/', '<ul class="ddsmoothmenu">', $ulclass, 1);
}

add_filter('wp_page_menu', 'business_directory_add_menuclass');

function business_directory_nav() {
    if (function_exists('wp_nav_menu')) {
        echo '<div id="menu">';
        wp_nav_menu(array('theme_location' => 'custom_menu', 'menu_class' => 'sf-menu', 'fallback_cb' => 'business_directory_nav_fallback'));
        echo "</div>";
    } else {
        business_directory_nav_fallback();
    }
}

function business_directory_nav_fallback() {
    ?>
    <div id="menu">
        <ul class="sf-menu">
            <?php
            $notify_pid = get_option('geo_notify_page');
            $dashboard_pid = get_option('geo_dashboard_page');
            $search = get_option('geo_search_page');
            wp_list_pages("title_li=&show_home=1&sort_column=menu_order&exclude=$notify_pid,$dashboard_pid,$dashboard_pid");
            ?>
        </ul>
    </div>
    <?php
}

function business_directory_home_nav_menu_items($items) {
    if (is_home()) {
        $homelink = '<li class="current_page_item">' . '<a href="' . home_url('/') . '">' . __('Home', 'business-directory') . '</a></li>';
    } else {
        $homelink = '<li>' . '<a href="' . home_url('/') . '">' . __('Home', 'business-directory') . '</a></li>';
    }
    $items = $homelink . $items;
    return $items;
}

add_filter('wp_list_pages', 'business_directory_home_nav_menu_items');
/* ----------------------------------------------------------------------------------- */
/* Function to call first uploaded image in functions file
  /*----------------------------------------------------------------------------------- */

function business_directory_main_image() {
    global $post, $posts;
    //This is required to set to Null
    $id = '';
    $the_title = '';
    // Till Here
    $permalink = get_permalink($id);
    $homeLink = get_template_directory_uri();
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if (isset($matches [1] [0])) {
        $first_img = $matches [1] [0];
    }
    if (empty($first_img)) { //Defines a default image 
        echo '';
    } else {
        print "<a href='$permalink'><img src='$first_img' width='250px' height='160px' class='postimg wp-post-image' alt='$the_title' /></a>";
    }
}

/* ----------------------------------------------------------------------------------- */
/* Attachment Page Design
  /*----------------------------------------------------------------------------------- */
//For Attachment Page
if (!function_exists('business_directory_posted_in')) :

    /**
     * Prints HTML with meta information for the current post (category, tags and permalink).
     *
     */
    function business_directory_posted_in() {
        // Retrieves tag list of current post, separated by commas.
        $tag_list = get_the_tag_list('', ', ');
        if ($tag_list) {
            $posted_in = __('This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>', 'business-directory');
        } elseif (is_object_in_taxonomy(get_post_type(), 'category')) {
            $posted_in = __('This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'business-directory');
        } else {
            $posted_in = __('Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'business-directory');
        }
        // Prints the string, replacing the placeholders.
        printf(
                $posted_in, get_the_category_list(', '), $tag_list, get_permalink(), the_title_attribute('echo=0')
        );
    }

endif;

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if (!isset($content_width))
    $content_width = 472;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override business_directory_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @uses register_sidebar
 */
function business_directory_widgets_init() {
    //Area 4 Default widget area for pages
    register_sidebar(array(
        'name' => __('Pages Widget Area', 'business-directory'),
        'id' => 'pages-widget-area',
        'description' => __('The default pages for pages widget area', 'business-directory'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
    // Area 6, located in the footer. Sample content by default.
    register_sidebar(array(
        'name' => __('First Footer Widget Area', 'business-directory'),
        'id' => 'first-footer-widget-area',
        'description' => __('First Footer Widget Area', 'business-directory'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
    // Area 7, located in the footer. Sample content by default.
    register_sidebar(array(
        'name' => __('Second Footer Widget Area', 'business-directory'),
        'id' => 'second-footer-widget-area',
        'description' => __('Second Footer Widget Area', 'business-directory'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
    // Area 8, located in the footer. Sample content by default.
    register_sidebar(array(
        'name' => __('Third Footer Widget Area', 'business-directory'),
        'id' => 'third-footer-widget-area',
        'description' => __('Third Footer Widget Area', 'business-directory'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
    // Area 9, located in the footer. Sample content by default.
    register_sidebar(array(
        'name' => __('Fourth Footer Widget Area', 'business-directory'),
        'id' => 'fourth-footer-widget-area',
        'description' => __('Fourth Footer Widget Area', 'business-directory'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
}

/** Register sidebars by running business_directory_widgets_init() on the widgets_init hook. */
add_action('widgets_init', 'business_directory_widgets_init');

/**
 * business_directory_business_directory_pagination
 *
 */
function business_directory_pagination($pages = '', $range = 2) {
    $showitems = ($range * 2) + 1;
    global $paged;
    if (empty($paged))
        $paged = 1;
    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if (!$pages) {
            $pages = 1;
        }
    }
    if (1 != $pages) {
        echo "<ul class='paging'>";
        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link(1) . "'>&laquo;</a></li>";
        if ($paged > 1 && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a></li>";
        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                echo ($paged == $i) ? "<li><a href='" . get_pagenum_link($i) . "' class='current' >" . $i . "</a></li>" : "<li><a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a></li>";
            }
        }
        if ($paged < $pages && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a></li>";
        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
            echo "<li><a href='" . get_pagenum_link($pages) . "'>&raquo;</a></li>";
        echo "</ul>\n";
    }
}

/////////Theme Options

/* ----------------------------------------------------------------------------------- */
/* Custom CSS Styles */
/* ----------------------------------------------------------------------------------- */

function business_directory_of_head_css() {
    $output = '';
    $custom_css = esc_html(business_directory_get_option('customcss'));
    if ($custom_css <> '') {
        $output .= $custom_css . "\n";
    }
    // Output styles
    if ($output <> '') {
        $output = "<!-- Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
        echo $output;
    }
}

add_action('wp_head', 'business_directory_of_head_css');
/* ----------------------------------------------------------------------------------- */
/* Styles Enqueue */
/* ----------------------------------------------------------------------------------- */

function business_directory_add_stylesheet() {
    wp_enqueue_style('business-directory-theme-font', "//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic", '', '', 'all');
    wp_enqueue_style('business-directory-animate', get_template_directory_uri() . "/css/animate.css", '', '', 'all');
    wp_enqueue_style('business-directory-960-framework', get_template_directory_uri() . "/css/960_24_col_responsive.css", '', '', 'all');
    wp_enqueue_style('media-screen', get_template_directory_uri() . "/css/media-screen.css", '', '', 'all');
}

add_action('wp_enqueue_scripts', 'business_directory_add_stylesheet');
/* ----------------------------------------------------------------------------------- */
/* jQuery Enqueue */
/* ----------------------------------------------------------------------------------- */

function business_directory_wp_enqueue_scripts() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('business-directory-superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'));
        wp_enqueue_script('business-directory-responsive-menu-2', get_template_directory_uri() . '/js/menu/jquery.meanmenu.2.0.js', array('jquery'));
        wp_enqueue_script('business-directory-responsive-menu-2-options', get_template_directory_uri() . '/js/menu/jquery.meanmenu.options.js', array('jquery'));
        wp_enqueue_script('business-directory-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'));
    }
}

add_action('wp_enqueue_scripts', 'business_directory_wp_enqueue_scripts');

//Enqueue comment thread js
function business_directory_enqueue_scripts() {
    if (is_singular() and get_site_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'business_directory_enqueue_scripts');

function business_directory_bodybg() {
    if (business_directory_get_option('bodybg') != '') {
        ?>
        <style type="text/css">
            body{
                background-image: url('<?php echo esc_url(business_directory_get_option('bodybg')); ?>');
            }
        </style>
        <?php
    }
}

add_action('wp_head', 'business_directory_bodybg');
add_filter('wp_title', 'business_directory_filter_wp_title');

/**
 * Filters the page title appropriately depending on the current page
 *
 * This function is attached to the 'wp_title' fiilter hook.
 *
 * @uses	get_bloginfo()
 * @uses	is_home()
 * @uses	is_front_page()
 */
function business_directory_filter_wp_title($title) {
    global $page, $paged;

    if (is_feed())
        return $title;

    $site_description = get_bloginfo('description');

    $filtered_title = $title . get_bloginfo('name');
    $filtered_title .= (!empty($site_description) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description : '';
    return $filtered_title;
}
