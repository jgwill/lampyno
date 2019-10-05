<?php
/**
* Register widget area.
*
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/
function advance_blog_widgets_init() {
    register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'advance-blog' ),
    'id'            => 'sidebar-1',
    'description'   => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Col-1', 'advance-blog' ),
        'id'            => 'footer-1',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Col-2', 'advance-blog' ),
        'id'            => 'footer-2',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__( 'Footer Col-3', 'advance-blog' ),
        'id'            => 'footer-3',
        'description'   => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'advance_blog_widgets_init' );

/**
 * function for google fonts
 */
if (!function_exists('advance_blog_fonts_url')) :

    /**
     * Return fonts URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function advance_blog_fonts_url()
    {

        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        if ('off' !== _x('on', 'Open Sans font: on or off', 'advance-blog')) {
            $fonts[] = 'Open+Sans:300,300i,400,400i';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urldecode(implode('|', $fonts)),
                'subset' => urldecode($subsets),
            ), '//fonts.googleapis.com/css');
        }
        return $fonts_url;
    }
endif;