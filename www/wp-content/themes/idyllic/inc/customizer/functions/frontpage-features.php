<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Idyllic
 * @since Idyllic 1.0
 */
class Idyllic_Category_Control extends WP_Customize_Control {
	public $type = 'select';
	public function render_content() {
	$idyllic_settings = idyllic_get_theme_options();
	$idyllic_categories = get_categories(); ?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?>>
			<?php
				foreach ( $idyllic_categories as $category) :?>
						<option value="<?php echo $category->cat_ID; ?>" <?php if ( in_array( $category->cat_ID, $idyllic_settings) ) { echo 'selected="selected"';}?>><?php echo esc_attr($category->cat_name); ?></option>
					<?php endforeach; ?>
			</select>
		</label>
	<?php 
	}
}

/******************** IDYLLIC FRONTPAGE  *********************************************/
/* Frontpage Idyllic Section */
$idyllic_settings = idyllic_get_theme_options();

$wp_customize->add_section( 'idyllic_frontpage_features', array(
	'title' => __('Frontpage Features Section','idyllic'),
	'priority' => 400,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_frontpage_about_us', array(
	'title' => __('About Us Section','idyllic'),
	'priority' => 500,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_frontpage_fact_figure_box', array(
	'title' => __('Fact Figure Box Section','idyllic'),
	'priority' => 600,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_portfolio_box_features', array(
	'title' => __('Portfolio Section','idyllic'),
	'priority' => 700,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_our_testimonial_features', array(
	'title' => __('Our Testimonial Section','idyllic'),
	'priority' => 800,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_latest_blog_features', array(
	'title' => __('Latest from Blog Section','idyllic'),
	'priority' => 1000,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_team_member', array(
	'title' => __('Our Team Member','idyllic'),
	'priority' => 1100,
	'panel' =>'idyllic_frontpage_panel'
));

$wp_customize->add_section( 'idyllic_frontpage_display_position', array(
	'title' => __('Change Position frontpage features','idyllic'),
	'priority' => 1200,
	'panel' =>'idyllic_frontpage_panel'
));

/* About Us Section */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_about_us]', array(
	'default' => $idyllic_settings['idyllic_disable_about_us'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_about_us]', array(
	'priority' => 410,
	'label' => __('Disable About Us Section', 'idyllic'),
	'section' => 'idyllic_frontpage_about_us',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_about_us_remove_link]', array(
	'default' => $idyllic_settings['idyllic_about_us_remove_link'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_about_us_remove_link]', array(
	'priority' => 420,
	'label' => __('Remove link from Title and Image', 'idyllic'),
	'section' => 'idyllic_frontpage_about_us',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic-about-flip-content]', array(
	'default' => $idyllic_settings['idyllic-about-flip-content'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic-about-flip-content]', array(
	'priority' => 430,
	'label' => __('Flip content', 'idyllic'),
	'section' => 'idyllic_frontpage_about_us',
	'type' => 'checkbox',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_about_title]', array(
	'default' =>$idyllic_settings['idyllic_about_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_about_title]', array(
	'priority' =>440,
	'label' => __('Title', 'idyllic'),
	'section' => 'idyllic_frontpage_about_us',
	'type' => 'text',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_about_description]', array(
	'default' =>$idyllic_settings['idyllic_about_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_about_description]', array(
	'priority' =>450,
	'label' => __('Description', 'idyllic'),
	'section' => 'idyllic_frontpage_about_us',
	'type' => 'text',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic-img-upload-aboutus-bg-image]',array(
		'default'	=> $idyllic_settings['idyllic-img-upload-aboutus-bg-image'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type' => 'option',
	));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'idyllic_theme_options[idyllic-img-upload-aboutus-bg-image]', array(
	'label' => __('About Us Background Image','idyllic'),
	'description' => __('Image will be displayed on background','idyllic'),
	'priority'	=> 460,
	'section' => 'idyllic_frontpage_about_us',
	)
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_about_us]', array(
	'default' =>$idyllic_settings['idyllic_about_us'],
	'sanitize_callback' =>'idyllic_sanitize_page',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_about_us]', array(
	'priority' => 470,
	'label' => __('Idyllic Page', 'idyllic'),
	'section' => 'idyllic_frontpage_about_us',
	'type' => 'dropdown-pages',
	'allow_addition' => true,
));

/* Fact Figure Box Section */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_fact_figure_box]', array(
	'default' => $idyllic_settings['idyllic_disable_fact_figure_box'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_fact_figure_box]', array(
	'priority' => 410,
	'label' => __('Disable Fact Figure Box Section', 'idyllic'),
	'section' => 'idyllic_frontpage_fact_figure_box',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_fact_figure_number_count]', array(
	'default' => $idyllic_settings['idyllic_disable_fact_figure_number_count'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_fact_figure_number_count]', array(
	'priority' => 415,
	'label' => __('Disable Fact Figure Number Count', 'idyllic'),
	'section' => 'idyllic_frontpage_fact_figure_box',
	'type' => 'checkbox',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_fact_figure_box_title]', array(
	'default' =>$idyllic_settings['idyllic_fact_figure_box_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_fact_figure_box_title]', array(
	'priority' =>420,
	'label' => __('Title', 'idyllic'),
	'section' => 'idyllic_frontpage_fact_figure_box',
	'type' => 'text',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_fact_figure_box_description]', array(
	'default' =>$idyllic_settings['idyllic_fact_figure_box_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
));
$wp_customize->add_control('idyllic_theme_options[idyllic_fact_figure_box_description]', array(
	'priority' =>430,
	'label' => __('Description', 'idyllic'),
	'section' => 'idyllic_frontpage_fact_figure_box',
	'type' => 'text',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic-img-fact-fig-box-bg-image]',array(
		'default'	=> $idyllic_settings['idyllic-img-fact-fig-box-bg-image'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type' => 'option',
	));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'idyllic_theme_options[idyllic-img-fact-fig-box-bg-image]', array(
	'label' => __('Fact Figure Box Background Image','idyllic'),
	'description' => __('Image will be displayed on background','idyllic'),
	'priority'	=> 440,
	'section' => 'idyllic_frontpage_fact_figure_box',
	)
));

for ( $i=1; $i <= 4; $i++ ) {
	$wp_customize->add_setting('idyllic_theme_options[idyllic_fact_figure_box_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'idyllic_sanitize_page',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'idyllic_theme_options[idyllic_fact_figure_box_'. $i .']', array(
		'priority' => 45 . absint($i),
		'label' => __('Idyllic Fact Figure Box Page #', 'idyllic'). absint($i),
		'section' => 'idyllic_frontpage_fact_figure_box',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));

	$wp_customize->add_setting( 'idyllic_fact_figure_color_box_'. $i, array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'idyllic_fact_figure_color_box_'. $i, array(
		'priority'					=> 45 . absint($i),
		'label' => __('Idyllic Fact Figure Box Color #', 'idyllic'). absint($i),
		'section'     => 'idyllic_frontpage_fact_figure_box',
	) ) );
}
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_img_fact_fig_boxlink]', array(
		'default' => $idyllic_settings['idyllic_img_fact_fig_boxlink'],
		'sanitize_callback' => 'esc_url_raw',
		'type' => 'option',
	));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_img_fact_fig_boxlink]', array(
	'priority' => 460,
	'label' => __('Button Link', 'idyllic'),
	'section' => 'idyllic_frontpage_fact_figure_box',
	'type' => 'text',
));

$wp_customize->add_setting( 'idyllic_fact_figure_button_color', array(
	'default'           => '#333333',
	'sanitize_callback' => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'idyllic_fact_figure_button_color', array( // Fact and Figure Button Color
	'priority'					=> 470,
	'label'=> __('Fact and Figure Button Color', 'idyllic'),
	'section'     => 'idyllic_frontpage_fact_figure_box',
) ) );

/* Frontpage Features */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_features]', array(
	'default' => $idyllic_settings['idyllic_disable_features'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_features]', array(
	'priority' => 500,
	'label' => __('Disable Front Page Features', 'idyllic'),
	'section' => 'idyllic_frontpage_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_frontpage_feature_design]', array(
		'default' => $idyllic_settings['idyllic_frontpage_feature_design'],
		'sanitize_callback' => 'idyllic_sanitize_select',
		'type' => 'option',
	));
$wp_customize->add_control('idyllic_theme_options[idyllic_frontpage_feature_design]', array(
	'priority' =>510,
	'label' => __(' Our feature Design Layout', 'idyllic'),
	'section' => 'idyllic_frontpage_features',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'' => __('Default ','idyllic'),
		'our-feature-one' => __('Our Feature One','idyllic'),
		'our-feature-two' => __('Our Feature Two','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_features_image]', array(
	'default' => $idyllic_settings['idyllic_disable_features_image'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_features_image]', array(
	'priority' => 520,
	'label' => __('Disable Image from Front Page features', 'idyllic'),
	'section' => 'idyllic_frontpage_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_features_title]', array(
	'default' => $idyllic_settings['idyllic_features_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_features_title]', array(
	'priority' => 530,
	'label' => __( 'Title', 'idyllic' ),
	'section' => 'idyllic_frontpage_features',
	'type' => 'text',
	)
);

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_features_description]', array(
	'default' => $idyllic_settings['idyllic_features_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_features_description]', array(
	'priority' => 540,
	'label' => __( 'Description', 'idyllic' ),
	'section' => 'idyllic_frontpage_features',
	'type' => 'text',
	)
);

for ( $i=1; $i <= $idyllic_settings['idyllic_total_features'] ; $i++ ) {
	$wp_customize->add_setting('idyllic_theme_options[idyllic_frontpage_features_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'idyllic_sanitize_page',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'idyllic_theme_options[idyllic_frontpage_features_'. $i .']', array(
		'priority' => 501 . absint($i),
		'label' => __(' Feature #', 'idyllic') . ' ' . absint($i) ,
		'section' => 'idyllic_frontpage_features',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));

	$wp_customize->add_setting( 'idyllic_feature_wrap_icon_color_'. $i, array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'idyllic_feature_wrap_icon_color_'. $i, array(
		'priority'					=> 501 . absint($i),
		'label'=> __('Feature Wrap/ Icon Color #', 'idyllic'). absint($i),
		'section'     => 'idyllic_frontpage_features',
	) ) );

}

/* Portfolio Box */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_portfolio_box]', array(
	'default' => $idyllic_settings['idyllic_disable_portfolio_box'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_portfolio_box]', array(
	'priority' => 10,
	'label' => __('Disable Portfolio Box', 'idyllic'),
	'section' => 'idyllic_portfolio_box_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_portfolio_fullwidth_layout]', array(
	'default' => $idyllic_settings['idyllic_portfolio_fullwidth_layout'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_portfolio_fullwidth_layout]', array(
	'priority'=>20,
	'label' => __('Full width layout', 'idyllic'),
	'section' => 'idyllic_portfolio_box_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_portfolio_noborder_layout]', array(
	'default' => $idyllic_settings['idyllic_portfolio_noborder_layout'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_portfolio_noborder_layout]', array(
	'priority'=>30,
	'label' => __('No border layout', 'idyllic'),
	'section' => 'idyllic_portfolio_box_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_portfolio_show_title_layout]', array(
	'default' => $idyllic_settings['idyllic_portfolio_show_title_layout'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_portfolio_show_title_layout]', array(
	'priority'=>40,
	'label' => __('Show title layout', 'idyllic'),
	'section' => 'idyllic_portfolio_box_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_portfolio_title]', array(
	'default' => $idyllic_settings['idyllic_portfolio_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_portfolio_title]', array(
	'priority' => 50,
	'label' => __( 'Title', 'idyllic' ),
	'section' => 'idyllic_portfolio_box_features',
	'type' => 'text',
	)
);
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_portfolio_description]', array(
	'default' => $idyllic_settings['idyllic_portfolio_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);

$wp_customize->add_control( 'idyllic_theme_options[idyllic_portfolio_description]', array(
	'priority' => 60,
	'label' => __( 'Description', 'idyllic' ),
	'section' => 'idyllic_portfolio_box_features',
	'type' => 'text',
	)
);
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_portfolio_category_list]', array(
		'default'				=>array(),
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'idyllic_sanitize_latest_from_blog_select',
		'type'				=> 'option'
	));

$wp_customize->add_control(
	new Idyllic_Category_Control(
	$wp_customize,
	'idyllic_theme_options[idyllic_portfolio_category_list]',
		array(
			'priority' 				=> 70,
			'label'					=> __('Select Portfolio Category','idyllic'),
			'section'				=> 'idyllic_portfolio_box_features',
			'settings'				=> 'idyllic_theme_options[idyllic_portfolio_category_list]',
			'type'					=>'select'
		)
	)
);

/* Testimonial Box */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_our_testimonial]', array(
	'default' => $idyllic_settings['idyllic_disable_our_testimonial'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_our_testimonial]', array(
	'priority'	=> 10,
	'label' => __('Disable Testimonial', 'idyllic'),
	'section' => 'idyllic_our_testimonial_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic-testimonial-bg-image]',array(
		'default'	=> $idyllic_settings['idyllic-testimonial-bg-image'],
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'esc_url_raw',
		'type' => 'option',
	));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'idyllic_theme_options[idyllic-testimonial-bg-image]', array(
	'label' => __('Testimonial Background Image','idyllic'),
	'description' => __('Image will be displayed on background','idyllic'),
	'priority'	=> 20,
	'section' => 'idyllic_our_testimonial_features',
	)
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_testimonial_title]', array(
	'default' => $idyllic_settings['idyllic_testimonial_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_testimonial_title]', array(
	'priority' => 30,
	'label' => __( 'Title', 'idyllic' ),
	'section' => 'idyllic_our_testimonial_features',
	'type' => 'text',
	)
);

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_testimonial_description]', array(
	'default' => $idyllic_settings['idyllic_testimonial_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_testimonial_description]', array(
	'priority' => 40,
	'label' => __( 'Description', 'idyllic' ),
	'section' => 'idyllic_our_testimonial_features',
	'type' => 'text',
	)
);

for ( $i=1; $i <= $idyllic_settings['idyllic_total_our_testimonial'] ; $i++ ) {
	$wp_customize->add_setting('idyllic_theme_options[idyllic_our_testimonial_features_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'idyllic_sanitize_page',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'idyllic_theme_options[idyllic_our_testimonial_features_'. $i .']', array(
		'priority'	=> 50 . absint($i),
		'label' => __(' Testimonial #', 'idyllic') . ' ' . absint($i) ,
		'section' => 'idyllic_our_testimonial_features',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));

	$wp_customize->add_setting( 'idyllic_theme_options[idyllic_our_testimonial_name_'. $i .']', array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'type' => 'option',
		'capability' => 'manage_options'
		)
	);
	$wp_customize->add_control( 'idyllic_theme_options[idyllic_our_testimonial_name_'. $i .']', array(
		'priority'	=> 50 . absint($i),
		'label' => __( 'Name #', 'idyllic' ) . ' ' . absint($i) ,
		'section' => 'idyllic_our_testimonial_features',
		'type' => 'text',
		)
	);

}

/* Latest from Blog Idyllic */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_latest_blog]', array(
	'default' => $idyllic_settings['idyllic_disable_latest_blog'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_latest_blog]', array(
	'priority' => 10,
	'label' => __('Disable Latest Blog/Category', 'idyllic'),
	'section' => 'idyllic_latest_blog_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting('idyllic_theme_options[idyllic_display_blog_design_layout]', array(
		'default' => $idyllic_settings['idyllic_display_blog_design_layout'],
		'sanitize_callback' => 'idyllic_sanitize_select',
		'type' => 'option',
	));
$wp_customize->add_control('idyllic_theme_options[idyllic_display_blog_design_layout]', array(
	'priority' =>20,
	'label' => __('Latest blog Design Layout', 'idyllic'),
	'section' => 'idyllic_latest_blog_features',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'' => __('Default ','idyllic'),
		'full-image-latest-blog' => __('Full image blog layout','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_latest_blog_title]', array(
	'default' => $idyllic_settings['idyllic_latest_blog_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_latest_blog_title]', array(
	'priority' => 30,
	'label' => __( 'Title', 'idyllic' ),
	'section' => 'idyllic_latest_blog_features',
	'type' => 'text',
	)
);

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_latest_blog_description]', array(
	'default' => $idyllic_settings['idyllic_latest_blog_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_latest_blog_description]', array(
	'priority' => 40,
	'label' => __( 'Description', 'idyllic' ),
	'section' => 'idyllic_latest_blog_features',
	'type' => 'text',
	)
);

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_display_blog_category]', array(
	'default' => $idyllic_settings['idyllic_display_blog_category'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_display_blog_category]', array(
	'priority'=> 50,
	'label' => __('Display Latest Blog/Category', 'idyllic'),
	'section' => 'idyllic_latest_blog_features',
	'type' => 'radio',
	'checked' => 'checked',
	'choices' => array(
		'blog' => __('Display Latest Blog','idyllic'),
		'category' => __('Display Category','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_latest_from_blog_category_list]', array(
		'default'				=>array(),
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'idyllic_sanitize_latest_from_blog_select',
		'type'				=> 'option'
	));
$wp_customize->add_control(
	new Idyllic_Category_Control(
	$wp_customize,
	'idyllic_theme_options[idyllic_latest_from_blog_category_list]',
		array(
			'priority' 				=> 60,
			'label'					=> __('Select Category','idyllic'),
			'section'				=> 'idyllic_latest_blog_features',
			'settings'				=> 'idyllic_theme_options[idyllic_latest_from_blog_category_list]',
			'type'					=>'select'
		)
	)
);

/* Our Team Member */
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_disable_team_member]', array(
	'default' => $idyllic_settings['idyllic_disable_team_member'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_disable_team_member]', array(
	'priority' => 10,
	'label' => __('Disable Team Member', 'idyllic'),
	'section' => 'idyllic_team_member',
	'type' => 'checkbox',
));
$wp_customize->add_setting( 'idyllic_theme_options[idyllic_our_team_remove_link]', array(
	'default' => $idyllic_settings['idyllic_our_team_remove_link'],
	'sanitize_callback' => 'idyllic_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'idyllic_theme_options[idyllic_our_team_remove_link]', array(
	'priority' => 15,
	'label' => __('Remove link from Title and Image', 'idyllic'),
	'section' => 'idyllic_team_member',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_team_member_title]', array(
	'default' => $idyllic_settings['idyllic_team_member_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_team_member_title]', array(
	'priority' => 30,
	'label' => __( 'Title', 'idyllic' ),
	'section' => 'idyllic_team_member',
	'settings' => 'idyllic_theme_options[idyllic_team_member_title]',
	'type' => 'text',
	)
);

$wp_customize->add_setting('idyllic_theme_options[idyllic_team_member_design_layout]', array(
		'default' => $idyllic_settings['idyllic_team_member_design_layout'],
		'sanitize_callback' => 'idyllic_sanitize_select',
		'type' => 'option',
	));
$wp_customize->add_control('idyllic_theme_options[idyllic_team_member_design_layout]', array(
	'priority' =>20,
	'label' => __('Team Box Design Layout', 'idyllic'),
	'section' => 'idyllic_team_member',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'' => __('Default ','idyllic'),
		'team-content-hover' => __('Hide text content','idyllic'),
	),
));

$wp_customize->add_setting( 'idyllic_theme_options[idyllic_team_member_description]', array(
	'default' => $idyllic_settings['idyllic_team_member_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type' => 'option',
	'capability' => 'manage_options'
	)
);
$wp_customize->add_control( 'idyllic_theme_options[idyllic_team_member_description]', array(
	'priority' => 40,
	'label' => __( 'Description', 'idyllic' ),
	'section' => 'idyllic_team_member',
	'settings' => 'idyllic_theme_options[idyllic_team_member_description]',
	'type' => 'text',
	)
);

for ( $i=1; $i <= $idyllic_settings['idyllic_total_team_member'] ; $i++ ) {
	$wp_customize->add_setting('idyllic_theme_options[idyllic_display_team_member_'. $i .']', array(
		'default' =>'',
		'sanitize_callback' =>'idyllic_sanitize_page',
		'type' => 'option',
		'capability' => 'manage_options'
	));
	$wp_customize->add_control( 'idyllic_theme_options[idyllic_display_team_member_'. $i .']', array(
		'priority' => 50 . absint($i),
		'label' => __(' Team Member #', 'idyllic') . ' ' . absint($i) ,
		'section' => 'idyllic_team_member',
		'type' => 'dropdown-pages',
		'allow_addition' => true,
	));

}
/* Display Frontpage Position Section */
$wp_customize->add_setting('idyllic_theme_options[idyllic_frontpage_position]', array(
	'default' => $idyllic_settings['idyllic_frontpage_position'],
	'sanitize_callback' => 'idyllic_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('idyllic_theme_options[idyllic_frontpage_position]', array(
	'priority' =>1100,
	'label' => __('Display Frontpage Position', 'idyllic'),
	'section' => 'idyllic_frontpage_display_position',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'default' => __('Default','idyllic'),
		'design_second_position_display' => __('Second Position Design','idyllic'),
		'design_third_position_display' => __('Third Position Design','idyllic'),
		'design_fourth_position_display' => __('Fourth Position Design','idyllic'),
		'design_fifth_position_display' => __('Fifth Position Design','idyllic'),
		'design_sixth_position_display' => __('Sixth Position Design','idyllic'),
		'design_seventh_position_display' => __('Seventh Position Design','idyllic'),
		'design_eigth_position_display' => __('Eighth Position Design','idyllic'),
		'design_ninth_position_display' => __('Ninth Position Design','idyllic'),
		'design_tenth_position_display' => __('Tenth Position Design','idyllic'),
),
));