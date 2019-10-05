<?php


class business_directory_Customizer {

    public static function business_directory_Register($wp_customize) {
        self::business_directory_Sections($wp_customize);
        self::business_directory_Controls($wp_customize);
    }

    public static function business_directory_Sections($wp_customize) {
        /**
         * General Section
         */
        $wp_customize->add_section('nav_menus', array(
            'title' => __('test', 'business-directory'),
            'description' => __('Allows you to customize header logo, background etc settings for business directory Theme.', 'business-directory'), //Descriptive tooltip
            'priority' => '11',
            'capability' => 'edit_theme_options'
                )
        );
         $wp_customize->add_section('general_setting_section', array(
            'title' => __('Header logo Settings', 'business-directory'),
            'description' => __('Allows you to customize header logo, background etc settings for business directory Theme.', 'business-directory'), //Descriptive tooltip
            'panel' => '',
            'priority' => '10',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Home Page Feature area setting
         */
        $wp_customize->add_section('home_top_feature_area', array(
            'title' => __('Home Page Heading', 'business-directory'),
            'description' => __('Allows you to setup feature area section heading for business directory Theme.', 'business-directory'),
            'panel' => '',
            'priority' => '11',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Social Icon Section
         */
        $wp_customize->add_section('social_icon_section', array(
            'title' => __('Social Icons', 'business-directory'),
            'description' => __('Allows you to setup social site link for business directory Theme.', 'business-directory'),
            'panel' => '',
            'priority' => '12',
            'capability' => 'edit_theme_options'
                )
        );
        /**
         * Style Section
         */
        // $wp_customize->add_section('style_section', array(
        //     'title' => __('Style Setting', 'business-directory'),
        //     'description' => __('Allows you to change style using custom css for business directory Theme.', 'business-directory'),
        //     'panel' => '',
        //     'priority' => '13',
        //     'capability' => 'edit_theme_options'
        //         )
        // );
    }

    public static function business_directory_Section_Content() {
        $section_content = array(
            'general_setting_section' => array(
                'business_directory_logo',
                // 'business_directory_favicon',
                // 'bodybg'
            ),
            'home_top_feature_area' => array(
                'home_feature_txt'
            ),
            'social_icon_section' => array(
                'facebook',
                'twitter',
                'rss',
                'googleplus',
                'youtube',
                'pinterest',
                'instagram',
                'tumblr',
                'flickr',
            ),
            // 'style_section' => array(
            //     'customcss'
            // )
        );
        return $section_content;
    }

    public static function business_directory_Settings() {
        $business_directory_settings = array(
            'business_directory_logo' => array(
                'id' => 'business_directory_options[business_directory_logo]',
                'label' => __('Custom Logo', 'business-directory'),
                'description' => __('Here you can upload a Logo for your Website.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'image',
                'default' => ''
            ),
            // 'business_directory_favicon' => array(
            //     'id' => 'business_directory_options[business_directory_favicon]',
            //     'label' => __('Custom Favicon', 'business-directory'),
            //     'description' => __('Here you can upload a Favicon for your Website. Specified size is 16px x 16px.', 'business-directory'),
            //     'type' => 'option',
            //     'setting_type' => 'image',
            //     'default' => ''
            // ),
            // 'bodybg' => array(
            //     'id' => 'business_directory_options[bodybg]',
            //     'label' => __('Body Background', 'business-directory'),
            //     'description' => __('Here you can upload a background image for your Website.', 'business-directory'),
            //     'type' => 'option',
            //     'setting_type' => 'image',
            //     'default' => '/images/frontpagebg.png'
            // ),
            'home_feature_txt' => array(
                'id' => 'business_directory_options[home_feature_txt]',
                'label' => __('Home Page Main Heading', 'business-directory'),
                'description' => __('Mention the punch line for your business here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => __('BUSINESS DIRECTORY LISTING THEME', 'business-directory')
            ),
            'customcss' => array(
                'id' => 'business_directory_options[customcss]',
                'label' => __('Custom CSS', 'business-directory'),
                'description' => __('Quickly add your custom CSS code to your theme by writing the code in this block.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'textarea',
                'default' => ''
            ),
            'facebook' => array(
                'id' => 'business_directory_options[facebook]',
                'label' => __('Facebook URL', 'business-directory'),
                'description' => __('Mention the URL of your Facebook here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
            'twitter' => array(
                'id' => 'business_directory_options[twitter]',
                'label' => __('Twitter URL', 'business-directory'),
                'description' => __('Mention the URL of your Twitter here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
            'rss' => array(
                'id' => 'business_directory_options[rss]',
                'label' => __('RSS URL', 'business-directory'),
                'description' => __('Mention the URL of your RSS here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),

            'googleplus' => array(
                'id' => 'business_directory_options[googleplus]',
                'label' => __('googleplus URL', 'business-directory'),
                'description' => __('Mention the google plus URL here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),

            'youtube' => array(
                'id' => 'business_directory_options[youtube]',
                'label' => __('youtube URL', 'business-directory'),
                'description' => __('Mention the youtube URL here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),

              
            'pinterest' => array(
                'id' => 'business_directory_options[pinterest]',
                'label' => __('pinterest URL', 'business-directory'),
                'description' => __('Mention the pinterest URL here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),

            'instagram' => array(
                'id' => 'business_directory_options[instagram]',
                'label' => __('instagram URL', 'business-directory'),
                'description' => __('Mention the instagram URL here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),

            'tumblr' => array(
                'id' => 'business_directory_options[tumblr]',
                'label' => __('tumblr URL', 'business-directory'),
                'description' => __('Mention the tumblr URL here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),

            'flickr' => array(
                'id' => 'business_directory_options[flickr]',
                'label' => __('flickr URL', 'business-directory'),
                'description' => __('Mention the flickr URL here.', 'business-directory'),
                'type' => 'option',
                'setting_type' => 'link',
                'default' => '#'
            ),
        );
        return $business_directory_settings;
    }

    public static function business_directory_Controls($wp_customize) {
        $sections = self::business_directory_Section_Content();
        $settings = self::business_directory_Settings();
        foreach ($sections as $section_id => $section_content) {
            foreach ($section_content as $section_content_id) {
                switch ($settings[$section_content_id]['setting_type']) {
                    case 'image':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'business_directory_sanitize_url');
                        $wp_customize->add_control(new WP_Customize_Image_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id']
                                )
                        ));
                        break;
                    case 'text':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'business_directory_sanitize_text');
                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'text'
                                )
                        ));
                        break;
                    case 'textarea':
                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'business_directory_sanitize_textarea');

                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'textarea'
                                )
                        ));
                        break;
                    case 'link':

                        self::add_setting($wp_customize, $settings[$section_content_id]['id'], $settings[$section_content_id]['default'], $settings[$section_content_id]['type'], 'business_directory_sanitize_url');

                        $wp_customize->add_control(new WP_Customize_Control(
                                $wp_customize, $settings[$section_content_id]['id'], array(
                            'label' => $settings[$section_content_id]['label'],
                            'description' => $settings[$section_content_id]['description'],
                            'section' => $section_id,
                            'settings' => $settings[$section_content_id]['id'],
                            'type' => 'text'
                                )
                        ));

                        break;
                    default:
                        break;
                }
            }
        }
    }

    public static function add_setting($wp_customize, $setting_id, $default, $type, $sanitize_callback) {
        $wp_customize->add_setting($setting_id, array(
            'default' => $default,
            'capability' => 'edit_theme_options',
            'sanitize_callback' => array('business_directory_Customizer', $sanitize_callback),
            'type' => $type
                )
        );
    }

    /**
     * adds sanitization callback funtion : textarea
     * @package business_directory
     */
    public static function business_directory_sanitize_textarea($value) {
        $array = wp_kses_allowed_html('post');
        $allowedtags = array(
            'iframe' => array(
                'width' => array(),
                'height' => array(),
                'frameborder' => array(),
                'scrolling' => array(),
                'src' => array(),
                'marginwidth' => array(),
                'marginheight' => array()
            )
        );
        $data = array_merge($allowedtags, $array);
        $value = wp_kses($value, $data);
        return $value;
    }

    /**
     * adds sanitization callback funtion : url
     * @package business_directory
     */
    public static function business_directory_sanitize_url($value) {
        $value = esc_url($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : text
     * @package business_directory
     */
    public static function business_directory_sanitize_text($value) {
        $value = sanitize_text_field($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : email
     * @package business_directory
     */
    public static function business_directory_sanitize_email($value) {
        $value = sanitize_email($value);
        return $value;
    }

    /**
     * adds sanitization callback funtion : number
     * @package business_directory
     */
    public static function business_directory_sanitize_number($value) {
        $value = preg_replace("/[^0-9+ ]/", "", $value);
        return $value;
    }

}

// Setup the Theme Customizer settings and controls...
add_action('customize_register', array('business_directory_Customizer', 'business_directory_Register'));


function inkthemes_registers() {
    wp_register_script('inkthemes_jquery_ui', '//code.jquery.com/ui/1.11.0/jquery-ui.js', array("jquery"), true);
    wp_register_script('inkthemes_customizer_script', get_template_directory_uri() . '/js/inkthemes_customizer.js', array("jquery", "inkthemes_jquery_ui"), true);
    wp_enqueue_script('inkthemes_customizer_script');
    wp_localize_script('inkthemes_customizer_script', 'ink_advert', array(
        'pro' => __('View PRO version', 'business-directory'),
        'url' => esc_url('https://www.inkthemes.com/market/geocraft-directory-listing-wordpress-theme/'),
        'support_text' => __('Need Help!', 'business-directory'),
        'support_url' => esc_url('https://www.inkthemes.com/contact-us/')
    ));
}

add_action('customize_controls_enqueue_scripts', 'inkthemes_registers');






