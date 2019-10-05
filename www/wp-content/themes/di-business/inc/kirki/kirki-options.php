<?php
// Disable kirki telemetry
add_filter( 'kirki_telemetry', '__return_false' );

//set Kirki config
Kirki::add_config( 'di_business_config', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );

//the main panel
Kirki::add_panel( 'di_business_options', array(
    'title'       => esc_attr__( 'Di Business Options', 'di-business' ),
    'description' => esc_attr__( 'All options of Di Business theme', 'di-business' ),
) );

//typography
Kirki::add_section( 'typography_options', array(
	'title'          => esc_attr__( 'Typography Options', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'body_typog',
	'label'       => esc_attr__( 'Body Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Lora',
		'variant'        => 'regular',
		'font-size'      => '14px',
	),
	'output'      => array(
		array(
			'element' => 'body',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'site_title_typog',
	'label'       => esc_attr__( 'Site Title Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '22px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => '.headermain h3.site-name-pr',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'h1_typog',
	'label'       => esc_attr__( 'H1 / Headline 1 Typography', 'di-business' ),
	'description' => esc_attr__( 'Used as Headline of Single Post and page.', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '22px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => 'body h1, .h1',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'h2_typog',
	'label'       => esc_attr__( 'H2 / Headline 2 Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '22px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => 'body h2, .h2',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'h3_typog',
	'label'       => esc_attr__( 'H3 / Headline 3 Typography', 'di-business' ),
	'description' => esc_attr__( 'Used as Headline of Widgets, Posts on Archive, Comment Box.', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '22px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => 'body h3, .h3',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'h4_typog',
	'label'       => esc_attr__( 'H4 / Headline 4 Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '20px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => 'body h4, .h4',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'h5_typog',
	'label'       => esc_attr__( 'H5 / Headline 5 Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '20px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => 'body h5, .h5',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'h6_typog',
	'label'       => esc_attr__( 'H6 / Headline 6 Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Arvo',
		'variant'        => 'regular',
		'font-size'      => '20px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => 'body h6, .h6',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'p_typog',
	'label'       => esc_attr__( 'Paragraph Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Fauna One',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '1.7',
		'letter-spacing' => '0',
		'text-transform' => 'inherit',
	),
	'output'      => array(
		array(
			'element' => '.maincontainer p',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'top_bar_typog',
	'label'       => esc_attr__( 'Top Bar Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '22px',
		'letter-spacing' => '0px',
		'text-transform' => 'inherit',
	),
	'output'      => array(
		array(
			'element' => '.bgtoph',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'top_menu_typog',
	'label'       => esc_attr__( 'Main Menu Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Rajdhani',
		'variant'        => '500',
		'font-size'      => '18px'
	),
	'output'      => array(
		array(
			'element' => '.navbarprimary ul li a',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'sb_menu_typo',
	'label'       => esc_attr__( 'Sidebar Menu Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Rajdhani',
		'variant'        => '500',
		'font-size'      => '18px',
		'line-height'    => '25px',
		'letter-spacing' => '0.1px',
		'text-transform' => 'inherit',
	),
	'output'      => array(
		array(
			'element' => '.side-menu-menu-wrap ul li a',
		),
	),
	'transport' => 'auto',
	'active_callback'  => array(
		array(
			'setting'  => 'sb_menu_onoff',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'widget_ul_ol_typog',
	'label'       => esc_attr__( 'Widgets UL/OL Typography', 'di-business' ),
	'description' => esc_attr__( 'Widgets Unordered List / Ordered List Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '1.5',
		'letter-spacing' => '0.1px',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => '.widget_sidebar_main ul li, .widget_sidebar_main ol li',
		),
		array(
			'element' => '.widgets_footer ul li, .widgets_footer ol li',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'body_ul_ol_li_typog',
	'label'       => esc_attr__( 'Container UL/OL Typography', 'di-business' ),
	'description' => esc_attr__( 'Typography for list in main contents.', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Fjord One',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '1.7',
		'letter-spacing' => '0',
		'text-transform' => 'inherit',
	),
	'output'      => array(
		array(
			'element' => '.entry-content ul li, .entry-content ol li',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'mn_footer_typog',
	'label'       => esc_attr__( 'Footer Widgets Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '1.7',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => '.footer',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'mn_footer_hdln_typog',
	'label'       => esc_attr__( 'Footer Widgets Headline Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    	=> 'Roboto',
		'variant'        	=> 'regular',
		'font-size'      	=> '17px',
		'line-height'    	=> '1.1',
		'letter-spacing' 	=> '1px',
		'text-transform' 	=> 'uppercase',
		'text-align' 		=> 'left',
	),
	'output'      => array(
		array(
			'element' => '.footer h3.widgets_footer_title',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'typography',
	'settings'    => 'cprt_footer_typog',
	'label'       => esc_attr__( 'Footer Copyright Typography', 'di-business' ),
	'section'     => 'typography_options',
	'default'     => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '1',
		'letter-spacing' => '0',
		'text-transform' => 'inherit'
	),
	'output'      => array(
		array(
			'element' => '.footer-copyright',
		),
	),
	'transport' => 'auto',
) );

//typography END

//top bar
Kirki::add_section( 'top_bar', array(
	'title'          => esc_attr__( 'Top Bar Options', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'display_top_bar',
	'label'       => esc_attr__( 'Top Bar Feature', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Top Bar', 'di-business' ),
	'section'     => 'top_bar',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'display_sicons_top_bar',
	'label'       => esc_attr__( 'Social Icons', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Social Icons', 'di-business' ),
	'section'     => 'top_bar',
	'default'     => '1',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 's_link_open',
	'label'       => esc_attr__( 'Social Links in New Tab?', 'di-business' ),
	'description' => esc_attr__( 'Open social links in new tab or same.', 'di-business' ),
	'section'     => 'top_bar',
	'default'     => '1',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'display_sicons_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

do_action( 'di_business_top_bar' );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'select',
	'settings'    => 'tpbr_left_view',
	'label'       => esc_attr__( 'Top Bar Left Content View', 'di-business' ),
	'description' => esc_attr__( 'Simply phone, email or Text/HTML or Disable ?', 'di-business' ),
	'section'     => 'top_bar',
	'default'     => '1',
	'choices'     => array(
		'1' => esc_attr__( 'Phone and Email', 'di-business' ),
		'2' => esc_attr__( 'Text / HTML', 'di-business' ),
		'3' => esc_attr__( 'Disable', 'di-business' ),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'tpbr_lft_phne',
	'label'			=> esc_attr__( 'Phone Number', 'di-business' ),
	'description' 	=> esc_attr__( 'Leave empty for disable.', 'di-business' ),
	'section'		=> 'top_bar',
	'default'		=> esc_attr__( '0123456789', 'di-business' ),
	'partial_refresh' => array(
		'tpbr_lft_phne' => array(
			'selector'        => '.tpbr_lft_phne_ctmzr',
			'render_callback' => function() {
				if( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ) {
				?>
					<span class="fa fa-phone"></span><?php _e( ' Call: ', 'di-business' ) ?><a href="tel:<?php echo esc_attr( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ); ?></a>
				<?php
				}
				?>
				
				<?php
				if( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) && get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ) {
					_e( ' | ', 'di-business' );
				}
				?>
				
				<?php
				if( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ) {
				?>
					<span class="fa fa-envelope-o"></span><?php _e( ' Email: ', 'di-business' ) ?><a href="mailto:<?php echo esc_attr( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ); ?></a>
				<?php
				}
			},
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'tpbr_left_view',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'tpbr_lft_email',
	'label'			=> esc_attr__( 'Email Address', 'di-business' ),
	'description' 	=> esc_attr__( 'Leave empty for disable.', 'di-business' ),
	'section'		=> 'top_bar',
	'default'		=> esc_attr__( 'info@example.com', 'di-business' ),
	'partial_refresh' => array(
		'tpbr_lft_email' => array(
			'selector'        => '.tpbr_lft_phne_ctmzr',
			'render_callback' => function() {
				if( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ) {
				?>
					<span class="fa fa-phone"></span><?php _e( ' Call: ', 'di-business' ) ?><a href="tel:<?php echo esc_attr( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) ); ?></a>
				<?php
				}
				?>
				
				<?php
				if( get_theme_mod( 'tpbr_lft_phne', '0123456789' ) && get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ) {
					_e( ' | ', 'di-business' );
				}
				?>
				
				<?php
				if( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ) {
				?>
					<span class="fa fa-envelope-o"></span><?php _e( ' Email: ', 'di-business' ) ?><a href="mailto:<?php echo esc_attr( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ); ?>"><?php echo esc_attr( get_theme_mod( 'tpbr_lft_email', 'info@example.com' ) ); ?></a>
				<?php
				}
			},
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'tpbr_left_view',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'editor',
	'settings'    => 'top_bar_left_content',
	'label'       => esc_attr__( 'Top Bar Left Content', 'di-business' ),
	'description' => esc_attr__( 'Text / HTML of Top Bar Left', 'di-business' ),
	'section'     => 'top_bar',
	'default'     => '<p><span class="fa fa-phone"></span> ' . esc_attr__( 'Call:', 'di-business' ) . ' <a href="tel:0123456789">' . esc_attr__( '0123456789', 'di-business' ) . '</a> | <span class="fa fa-envelope-o"></span> ' . esc_attr__( 'Email:', 'di-business' ) . ' <a href="mailto:info@example.com">' . esc_attr__( 'info@example.com', 'di-business' ) . '</a></p>',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.topbar_ctmzr',
			'function' => 'html',
		),
	),
	'partial_refresh' => array(
		'top_bar_left_content' => array(
			'selector'        => '.topbar_ctmzr',
			'render_callback' => function() {
				echo wp_kses_post( get_theme_mod( 'top_bar_left_content', '<p><span class="fa fa-phone"></span> ' . __( 'Call:', 'di-business' ) . ' <a href="tel:0123456789">0123456789</a> | <span class="fa fa-envelope-o"></span> ' . __( 'Email:', 'di-business' ) . ' <a href="mailto:info@example.com">info@example.com</a></p>' ) );
			},
		),
	),
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'tpbr_left_view',
			'operator' => '==',
			'value'    => 2,
		),
	)
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'top_bar_seach_icon',
	'label'       => esc_attr__( 'Search Icon', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Search Icon', 'di-business' ),
	'section'     => 'top_bar',
	'default'     => '1',
	'active_callback'  => array(
		array(
			'setting'  => 'display_top_bar',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

do_action( 'di_business_top_bar_search_form' );

//top bar END

//Header layout
Kirki::add_section( 'header_layout_section', array(
	'title'          => esc_attr__( 'Header Layout Options', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'radio-image',
	'settings'		=> 'header_layout',
	'label'			=> esc_attr__( 'Select Header Layout', 'di-business' ),
	'description'	=> esc_attr__( 'Save and reload front page for alignment', 'di-business' ),
	'section'		=> 'header_layout_section',
	'default'		=> '1',
	'choices'		=> array(
		'1'		=> get_template_directory_uri() . '/assets/images/header-1.png',
		'2'		=> get_template_directory_uri() . '/assets/images/header-2.png',
		'3'		=> get_template_directory_uri() . '/assets/images/header-3.png',
		'4'		=> get_template_directory_uri() . '/assets/images/header-4.png',
		'5'		=> get_template_directory_uri() . '/assets/images/header-5.png',
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'slider',
	'settings'    => 'custom_logo_width',
	'label'       => esc_attr__( 'Logo Width', 'di-business' ),
	'description' => esc_attr__( 'To resize selected logo image.', 'di-business' ),
	'section'     => 'title_tagline',
	'default'     => '360',
	'priority'    => 9,
	'choices'     => array(
		'min'  => '10',
		'max'  => '600',
		'step' => '1',
	),
	'output' => array(
		array(
			'element'	=> '.custom-logo',
			'property'	=> 'width',
			'suffix'	=> 'px',
		),
	),
	'transport' => 'auto',
	'active_callback'  => 'has_custom_logo',
) );
//Header layout END

//color options
Kirki::add_section( 'color_options', array(
	'title'          => esc_attr__( 'Color Options', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        	=> 'color',
	'settings'    	=> 'default_a_color',
	'label'       	=> esc_attr__( 'Default Links Color', 'di-business' ),
	'description'	=> esc_attr__( 'This will be color of all default links.', 'di-business' ),
	'section'     	=> 'color_options',
	'default'     	=> apply_filters( 'di_business_default_a_color', '#68ac10' ),
	'choices'     	=> array(
		'alpha' => true,
	),
	'output' => array(
		array(
			'element'  => 'body a, .woocommerce .woocommerce-breadcrumb a, .woocommerce .star-rating span',
			'property' => 'color',
		),
		array(
			'element'  => '.widget_sidebar_main ul li::before',
			'property' => 'color',
		),
		array(
			'element'  => '.navigation.pagination .nav-links .page-numbers, .navigation.pagination .nav-links .page-numbers:last-child',
			'property' => 'border-color',
		),
		array(
			'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active',
			'property' => 'border-top-color',
		),
		array(
			'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active',
			'property' => 'border-bottom-color',
		),
		array(
			'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active',
			'property' => 'color',
		),
	),
	'transport' => 'auto',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        	=> 'color',
	'settings'    	=> 'default_a_mover_color',
	'label'       	=> esc_attr__( 'Default Links Color Mouse Over', 'di-business' ),
	'description'	=> esc_attr__( 'This will be color of all default links on mouse over.', 'di-business' ),
	'section'     	=> 'color_options',
	'default'     	=> apply_filters( 'di_business_default_a_mover_color', '#a0ce4e' ),
	'choices'     	=> array(
		'alpha' => true,
	),
	'output' => array(
		array(
			'element'  => 'body a:hover, body a:focus, .woocommerce .woocommerce-breadcrumb a:hover',
			'property' => 'color',
		),
		array(
			'element'  => '.widget_sidebar_main ul li:hover::before',
			'property' => 'color',
		),
		array(
			'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li:hover a',
			'property' => 'color',
		),
	),
	'transport' => 'auto',
) );

do_action( 'di_business_color_options' );

//color options END

//social profile
Kirki::add_section( 'social_options', array(
	'title'          => esc_attr__( 'Social Profile', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_facebook',
	'label'			=> esc_attr__( 'Facebook Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> 'http://facebook.com',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_twitter',
	'label'			=> esc_attr__( 'Twitter Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> 'http://twitter.com',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_youtube',
	'label'			=> esc_attr__( 'YouTube Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> 'http://youtube.com',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_vk',
	'label'			=> esc_attr__( 'VK Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_okru',
	'label'			=> esc_attr__( 'Ok.ru (odnoklassniki) Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_linkedin',
	'label'			=> esc_attr__( 'Linkedin Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_pinterest',
	'label'			=> esc_attr__( 'Pinterest Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_instagram',
	'label'			=> esc_attr__( 'Instagram Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_telegram',
	'label'			=> esc_attr__( 'Telegram Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_snapchat',
	'label'			=> esc_attr__( 'Snapchat Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_flickr',
	'label'			=> esc_attr__( 'Flickr Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_reddit',
	'label'			=> esc_attr__( 'Reddit Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_tumblr',
	'label'			=> esc_attr__( 'Tumblr Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_yelp',
	'label'			=> esc_attr__( 'Yelp Link', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_whatsappno',
	'label'			=> esc_attr__( 'WhatsApp Number', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'text',
	'settings'		=> 'sprofile_link_skype',
	'label'			=> esc_attr__( 'Skype Id', 'di-business' ),
	'description'	=> esc_attr__( 'Leave empty for disable', 'di-business' ),
	'section'		=> 'social_options',
	'default'		=> '',
) );
//social profile END


// Blog
Kirki::add_section( 'blog_options', array(
	'title'          => esc_attr__( 'Blog Options', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );
	
Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'breadcrumbx_setting',
	'label'       => esc_attr__( 'Breadcrumb', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Breadcrumb', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'toggle',
	'settings'		=> 'archive_post_thumbnail',
	'label'			=> esc_attr__( 'Thumbnail on Archive Post', 'di-business' ),
	'description'	=> esc_attr__( 'Enable/Disable Thumbnail on Archive/Loop Page', 'di-business' ),
	'section'		=> 'blog_options',
	'default'		=> '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'single_post_thumbnail',
	'label'       => esc_attr__( 'Thumbnail on Single Post', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Thumbnail on Single Post', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'posts_meta_disply',
	'label'       => esc_attr__( 'Display Post Meta on Archive', 'di-business' ),
	'description' => esc_attr__( 'Show/Hide post meta on archive / loop posts like: author, category, date.', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'post_meta_disply',
	'label'       => esc_attr__( 'Display Post Meta on Single Post', 'di-business' ),
	'description' => esc_attr__( 'Show/Hide post meta on single post like: author, category, date.', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'post_tags_disply',
	'label'       => esc_attr__( 'Display Tags on Single Post', 'di-business' ),
	'description' => esc_attr__( 'Show/Hide tags on single post below content.', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'sticky_dt_disply',
	'label'       => esc_attr__( 'Display Sticky Post Date', 'di-business' ),
	'description' => esc_attr__( 'Show/Hide date of sticky post on archive/loop page.', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
	'active_callback'  => array(
		array(
			'setting'  => 'posts_meta_disply',
			'operator' => '==',
			'value'    => 1,
			),
		)
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'select',
	'settings'    => 'post_date_view',
	'label'       => esc_attr__( 'Post Date View', 'di-business' ),
	'description' => esc_attr__( 'Which date do you want to display for single post?', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => '1',
	'choices'     => array(
		'1' => esc_attr__( 'Display Updated Date', 'di-business' ),
		'2' => esc_attr__( 'Display Publish Date', 'di-business' ),
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'select',
	'settings'    => 'excerpt_or_content',
	'label'       => esc_attr__( 'Display Excerpt or Content on Archive', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => 'excerpt',
	'choices'     => array(
		'excerpt' => esc_attr__( 'Display Excerpt', 'di-business' ),
		'content' => esc_attr__( 'Display Content', 'di-business' ),
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'number',
	'settings'    => 'excerpt_length',
	'label'       => esc_attr__( 'Excerpt Length', 'di-business' ),
	'description' => esc_attr__( 'How much words you want to display on Archive page?', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => 40,
	'choices'     => array(
		'min'  => 1,
		'step' => 1,
	),
	'active_callback'  => array(
		array(
			'setting'  => 'excerpt_or_content',
			'operator' => '==',
			'value'    => 'excerpt',
		),
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'select',
	'settings'    => 'display_archive_pagination',
	'label'       => esc_attr__( 'Display Pagination on Archive', 'di-business' ),
	'description' => esc_attr__( 'Which type of pagination, you want to display?', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => 'nextprev',
	'choices'     => array(
		'nextprev'	=> esc_attr__( 'Next Previous Pagination', 'di-business' ),
		'number' 	=> esc_attr__( 'Number Pagination', 'di-business' ),
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'select',
	'settings'    => 'blog_list_grid',
	'label'       => esc_attr__( 'Posts View on Archive', 'di-business' ),
	'description' => esc_attr__( 'Display List or Grid?', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => 'list',
	'choices'     => array(
		'list'		=> esc_attr__( 'List', 'di-business' ),
		'grid2c'	=> esc_attr__( 'Grid 2 Column', 'di-business' ),
		'grid3c'	=> esc_attr__( 'Grid 3 Column', 'di-business' ),
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'radio-image',
	'settings'    => 'blog_archive_layout',
	'label'       => esc_attr__( 'Archive / Loop Layout', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => 'rights',
	'choices'     => array(
		'fullw'	  => get_template_directory_uri() . '/assets/images/fullw.png',
		'rights'  => get_template_directory_uri() . '/assets/images/rights.png',
		'lefts'   => get_template_directory_uri() . '/assets/images/lefts.png',
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'radio-image',
	'settings'    => 'blog_single_layout',
	'label'       => esc_attr__( 'Single Post Layout', 'di-business' ),
	'section'     => 'blog_options',
	'default'     => 'rights',
	'choices'     => array(
		'fullw'	  => get_template_directory_uri() . '/assets/images/fullw.png',
		'rights'  => get_template_directory_uri() . '/assets/images/rights.png',
		'lefts'   => get_template_directory_uri() . '/assets/images/lefts.png',
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'     => 'text',
	'settings' => 'comment_panel_title',
	'label'    => esc_attr__( 'Comment Box Headline', 'di-business' ),
	'section'  => 'blog_options',
	'default'  => esc_attr__( 'Have any Question or Comment?', 'di-business' ),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.cmnthdlne_ctmzr',
			'function' => 'html',
		),
	),
	'partial_refresh' => array(
		'comment_panel_title' => array(
			'selector'        => '.cmnthdlne_ctmzr',
			'render_callback' => function() {
				return wp_kses_post( get_theme_mod( 'comment_panel_title' ) );
			},
		),
	),
) );

do_action( 'di_business_blog_options' );

// Blog END

// Sidebar menu options
Kirki::add_section( 'sidebarmenu_options', array(
	'title'          => esc_attr__( 'Sidebar Menu Options', 'di-business' ),
	'panel'          => 'di_business_options',
	'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'sb_menu_onoff',
	'label'       => esc_attr__( 'SideBar Menu', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable SideBar Menu', 'di-business' ),
	'section'     => 'sidebarmenu_options',
	'default'     => '1',
) );

do_action( 'di_business_sidebar_menu_options' );

// Sidebar menu options END

//woocommerce section
if( class_exists( 'WooCommerce' ) ) {
	Kirki::add_section( 'woocommerce_options', array(
		'title'          => esc_attr__( 'Woocommerce Options', 'di-business' ),
		'panel'          => 'di_business_options',
		'capability'     => 'edit_theme_options',
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'display_shop_link_top_bar',
		'label'       => esc_attr__( 'Display shop icon in Top Bar?', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable shop icon in Top Bar', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '1',
		'partial_refresh' => array(
			'display_shop_link_top_bar' => array(
				'selector'        => '.woo_icons_top_bar_ctmzr',
				'render_callback' => function() {
					get_template_part( 'template-parts/partial/content', 'woo-icons-topbar' );
				},
			),
		),
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'display_cart_link_top_bar',
		'label'       => esc_attr__( 'Display cart icon in Top Bar?', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable cart icon in Top Bar', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '1',
		'partial_refresh' => array(
			'display_cart_link_top_bar' => array(
				'selector'        => '.woo_icons_top_bar_ctmzr',
				'render_callback' => function() {
					get_template_part( 'template-parts/partial/content', 'woo-icons-topbar' );
				},
			),
		),
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'display_myaccount_link_top_bar',
		'label'       => esc_attr__( 'Display My Account icon in Top Bar?', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable My Account icon in Top Bar', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '1',
		'partial_refresh' => array(
			'display_myaccount_link_top_bar' => array(
				'selector'        => '.woo_icons_top_bar_ctmzr',
				'render_callback' => function() {
					get_template_part( 'template-parts/partial/content', 'woo-icons-topbar' );
				},
			),
		),
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'display_wc_breadcrumbs',
		'label'       => esc_attr__( 'WC Breadcrumbs', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable WooCommerce Breadcrumbs.', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '0',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'display_related_prdkt',
		'label'       => esc_attr__( 'Related Products', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable WooCommerce Related Products,', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '1',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'support_gallery_zoom',
		'label'       => esc_attr__( 'Gallery Zoom', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable gallery zoom support on single product.', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '1',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'        => 'toggle',
		'settings'    => 'support_gallery_lightbox',
		'label'       => esc_attr__( 'Gallery Light Box', 'di-business' ),
		'description' => esc_attr__( 'Enable/Disable gallery light box support on single product.', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => '1',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'			=> 'toggle',
		'settings'		=> 'support_gallery_slider',
		'label'			=> esc_attr__( 'Gallery Slider', 'di-business' ),
		'description'	=> esc_attr__( 'Enable/Disable gallery slider support on single product.', 'di-business' ),
		'section'		=> 'woocommerce_options',
		'default'		=> '1',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'			=> 'toggle',
		'settings'		=> 'order_again_btn',
		'label'			=> esc_attr__( 'Display Order Again Button?', 'di-business' ),
		'description'	=> esc_attr__( 'It will show / hide order again button on singe order page.', 'di-business' ),
		'section'		=> 'woocommerce_options',
		'default'		=> '1',
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'number',
		'settings'    => 'product_per_page',
		'label'       => esc_attr__( 'Number of products display on loop page', 'di-business' ),
		'description' => esc_attr__( 'How much products you want to display on loop page?', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => 12,
		'choices'     => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'slider',
		'settings'    => 'product_per_column',
		'label'       => esc_attr__( 'Number of products display per column', 'di-business' ),
		'description' => esc_attr__( 'How much products you want to display in single line?', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => 4,
		'choices'     => array(
			'min'  => '2',
			'max'  => '5',
			'step' => '1',
			),
	) );
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'color',
		'settings'    => 'woo_onsale_lbl_clr',
		'label'       => esc_attr__( 'OnSale Sign Color', 'di-business' ),
		'description' => esc_attr__( 'This will be color of OnSale Sign of products.', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => apply_filters( 'di_business_woo_onsale_lbl_clr', '#ffffff' ),
		'choices'     => array(
			'alpha' => true,
		),
		'output' => array(
			array(
				'element'	=> '.woocommerce span.onsale',
				'property'	=> 'color',
			),
		),
		'transport' => 'auto'
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'        => 'color',
		'settings'    => 'woo_onsale_lbl_bg_clr',
		'label'       => esc_attr__( 'OnSale Sign Background Color', 'di-business' ),
		'description' => esc_attr__( 'This will be background color of OnSale Sign of products.', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => apply_filters( 'di_business_woo_onsale_lbl_bg_clr', '#68ac10' ),
		'choices'     => array(
			'alpha' => true,
		),
		'output' => array(
			array(
				'element'	=> '.woocommerce span.onsale',
				'property'	=> 'background-color',
			),
		),
		'transport' => 'auto'
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'        => 'color',
		'settings'    => 'woo_price_clr',
		'label'       => esc_attr__( 'Product Price Color', 'di-business' ),
		'description' => esc_attr__( 'This will be color of product price.', 'di-business' ),
		'section'     => 'woocommerce_options',
		'default'     => apply_filters( 'di_business_woo_price_clr', '#68ac10' ),
		'choices'     => array(
			'alpha' => true,
		),
		'output' => array(
			array(
				'element'	=> '.woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price',
				'property'	=> 'color',
			),
		),
		'transport' => 'auto'
	) );
	
	Kirki::add_field( 'di_business_config', array(
		'type'        => 'custom',
		'settings'    => 'info_woo_layout',
		'section'     => 'woocommerce_options',
		'default'     => '<hr /><div style="padding: 10px;background-color: #333; color: #fff; border-radius: 8px;">' . esc_attr__( 'Layouts: For Cart, Checkout and My Account pages layout, use: Template option under Page Attributes on page edit screen.', 'di-business' ) . '</div>',
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'			=> 'radio-image',
		'settings'		=> 'woo_layout',
		'label'			=> esc_attr__( 'Shop / Archive Page Layout', 'di-business' ),
		'description'	=> esc_attr__( 'This layout will apply on shop, archive, search (products loop) pages.', 'di-business' ),
		'section'		=> 'woocommerce_options',
		'default'		=> 'fullw',
		'choices'		=> array(
			'fullw' => get_template_directory_uri() . '/assets/images/fullw.png',
			'rights' => get_template_directory_uri() . '/assets/images/rights.png',
			'lefts' => get_template_directory_uri() . '/assets/images/lefts.png',
		),
	) );

	Kirki::add_field( 'di_business_config', array(
		'type'			=> 'radio-image',
		'settings'		=> 'woo_singleprod_layout',
		'label'			=> esc_attr__( 'Single Product Page Layout', 'di-business' ),
		'description'	=> esc_attr__( 'This layout will apply on single product page.', 'di-business' ),
		'section'		=> 'woocommerce_options',
		'default'		=> 'fullw',
		'choices'		=> array(
			'fullw' => get_template_directory_uri() . '/assets/images/fullw.png',
			'rights' => get_template_directory_uri() . '/assets/images/rights.png',
			'lefts' => get_template_directory_uri() . '/assets/images/lefts.png',
		),
	) );

	do_action( 'di_business_woo_options' );
}
//woocommerce section END

//footer widgets section - footer means footer widget section (footer copyright not covered)
Kirki::add_section( 'footer_options', array(
    'title'          => esc_attr__( 'Footer Widget Options', 'di-business' ),
    'panel'          => 'di_business_options',
    'capability'     => 'edit_theme_options',
) );


Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'endis_ftr_wdgt',
	'label'       => esc_attr__( 'Footer Widgets', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Footer Widgets.', 'di-business' ),
	'section'     => 'footer_options',
	'default'     => '0',
) );

Kirki::add_field( 'di_business_config', array(
	'type'			=> 'radio-image',
	'settings'		=> 'ftr_wdget_lyot',
	'label'			=> esc_attr__( 'Footer Widget Layout', 'di-business' ),
	'description'	=> esc_attr__( 'Save and go to Widgets page to add.', 'di-business' ),
	'section'		=> 'footer_options',
	'default'		=> '3',
	'choices'		=> array(
		'1'		=> get_template_directory_uri() . '/assets/images/ftrwidlout1.png',
		'2'		=> get_template_directory_uri() . '/assets/images/ftrwidlout2.png',
		'3'		=> get_template_directory_uri() . '/assets/images/ftrwidlout3.png',
		'4'		=> get_template_directory_uri() . '/assets/images/ftrwidlout4.png',
		'48'	=> get_template_directory_uri() . '/assets/images/ftrwidlout48.png',
		'84'	=> get_template_directory_uri() . '/assets/images/ftrwidlout84.png',
	),
	'active_callback'  => array(
		array(
			'setting'  => 'endis_ftr_wdgt',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );

do_action( 'di_business_footer_widget_options' );

//footer section END

//footer copyright section
Kirki::add_section( 'footer_copy_options', array(
    'title'          => esc_attr__( 'Footer Copyright Options', 'di-business' ),
    'panel'          => 'di_business_options',
    'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'editor',
	'settings'    => 'left_footer_setting',
	'label'       => esc_attr__( 'Footer Left', 'di-business' ),
	'description' => esc_attr__( 'Content of Footer Left Side', 'di-business' ),
	'section'     => 'footer_copy_options',
	'default'     => '<p>' . esc_attr__( 'Site Title, Some rights reserved.', 'di-business' ) . '</p>',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.cprtlft_ctmzr',
			'function' => 'html',
		),
	),
	'partial_refresh' => array(
		'left_footer_setting' => array(
			'selector'        => '.cprtlft_ctmzr',
			'render_callback' => function() {
				return wp_kses_post( get_theme_mod( 'left_footer_setting' ) );
			},
		),
	),
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'editor',
	'settings'    => 'center_footer_setting',
	'label'       => esc_attr__( 'Footer Center', 'di-business' ),
	'description' => esc_attr__( 'Content of Footer Center Side', 'di-business' ),
	'section'     => 'footer_copy_options',
	'default'     => '<p><a href="#">' . esc_attr__( 'Terms of Use - Privacy Policy', 'di-business' ) . '</a></p>',
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.cprtcntr_ctmzr',
			'function' => 'html',
		),
	),
	'partial_refresh' => array(
		'center_footer_setting' => array(
			'selector'        => '.cprtcntr_ctmzr',
			'render_callback' => function() {
				return wp_kses_post( get_theme_mod( 'center_footer_setting' ) );
			},
		),
	),
) );

do_action( 'di_business_footer_copyright_right_setting' );

do_action( 'di_business_footer_copyright' );

//footer copyright section END

//misc section
Kirki::add_section( 'misc_options', array(
    'title'          => esc_attr__( 'MISC Options', 'di-business' ),
    'panel'          => 'di_business_options',
    'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'stickymenu_setting',
	'label'       => esc_attr__( 'Sticky Menu', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Sticky Menu (for Large Devices)', 'di-business' ),
	'section'     => 'misc_options',
	'default'     => '0',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'back_to_top',
	'label'       => esc_attr__( 'Back To Top Button', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Back To Top Button', 'di-business' ),
	'section'     => 'misc_options',
	'default'     => '1',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'toggle',
	'settings'    => 'loading_icon',
	'label'       => esc_attr__( 'Page Loading Icon', 'di-business' ),
	'description' => esc_attr__( 'Enable/Disable Page Loading Icon', 'di-business' ),
	'section'     => 'misc_options',
	'default'     => '0',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'image',
	'settings'    => 'loading_icon_img',
	'label'       => esc_attr__( 'Upload Custom Loading Icon', 'di-business' ),
	'description' => esc_attr__( 'It will replace default loading icon.', 'di-business' ),
	'section'     => 'misc_options',
	'default'     => '',
	'active_callback'  => array(
		array(
			'setting'  => 'loading_icon',
			'operator' => '==',
			'value'    => 1,
		),
	)
) );
//misc section END

//Theme Info section
Kirki::add_section( 'theme_info', array(
    'title'          => esc_attr__( 'Theme Info', 'di-business' ),
    'panel'          => 'di_business_options',
    'capability'     => 'edit_theme_options',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'custom',
	'settings'    => 'custom_dib_demo',
	'label'       => esc_attr__( 'Di Business Demo', 'di-business' ),
	'section'     => 'theme_info',
	'default'     => '<div style="background-color: #333;border-radius: 9px;color: #fff;padding: 13px 7px;">' . esc_attr__( 'You can check demo of ', 'di-business' ) . ' <a target="_blank" href="http://demo.dithemes.com/di-business/">' . esc_attr__( 'Di Business Theme Here', 'di-business' ) . '</a>.</div>',
) );

Kirki::add_field( 'di_business_config', array(
	'type'        => 'custom',
	'settings'    => 'custom_dib_docs',
	'label'       => esc_attr__( 'Di Business Docs', 'di-business' ),
	'section'     => 'theme_info',
	'default'     => '<div style="background-color: #333;border-radius: 9px;color: #fff;padding: 13px 7px;">' . esc_attr__( 'You can check documentation of ', 'di-business' ) . ' <a target="_blank" href="https://dithemes.com/di-business-free-wordpress-theme-documentation/">' . esc_attr__( 'Di Business Theme Here', 'di-business' ) . '</a>.</div>',
) );

do_action( 'di_business_cutmzr_theme_info' );

//Theme Info section END
