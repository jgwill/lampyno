<?php

if (!class_exists('inkthemes_About_Page')) {

    // Include utils functions
    require_once( get_template_directory() . '/cw-notifications/functions/cw-notifications-utils.php' );

    /**
     * Singleton class used for generating the about page of the theme.
     */
    class inkthemes_About_Page {

        /**
         * Define the version of the class.
         *
         * @var string $version The inkthemes_About_Page class version.
         */
        private $version = '1.0.0';

        /**
         * Used for loading the texts and setup the actions inside the page.
         *
         * @var array $config The configuration array for the theme used.
         */
        private $config;

        /**
         * Get the theme name using wp_get_theme.
         *
         * @var string $theme_name The theme name.
         */
        private $theme_name;

        /**
         * Get the theme slug ( theme folder name ).
         *
         * @var string $theme_slug The theme slug.
         */
        private $theme_slug;

        /**
         * The current theme object.
         *
         * @var WP_Theme $theme The current theme.
         */
        private $theme;

        /**
         * Holds the theme version.
         *
         * @var string $theme_version The theme version.
         */
        private $theme_version;

        /**
         * Define the menu item name for the page.
         *
         * @var string $menu_name The name of the menu name under Appearance settings.
         */
        private $menu_name;

        /**
         * Define the page title name.
         *
         * @var string $page_name The title of the About page.
         */
        private $page_name;

        /**
         * Define the page tabs.
         *
         * @var array $tabs The page tabs.
         */
        private $tabs;

        /**
         * Define the html notification content displayed upon activation.
         *
         * @var string $notification The html notification content.
         */
        private $notification;

        /**
         * The single instance of inkthemes_About_Page
         *
         * @var inkthemes_About_Page $instance The  inkthemes_About_Page instance.
         */
        private static $instance;

        /**
         * The Main inkthemes_About_Page instance.
         *
         * We make sure that only one instance of inkthemes_About_Page exists in the memory at one time.
         *
         * @param array $config The configuration array.
         */
        public static function init($config) {
            if (!isset(self::$instance) && !( self::$instance instanceof inkthemes_About_Page )) {
                self::$instance = new inkthemes_About_Page;
                if (!empty($config) && is_array($config)) {
                    self::$instance->config = $config;
                    self::$instance->setup_config();
                    self::$instance->setup_actions();
                }
            }
        }

        /**
         * Setup the class props based on the config array.
         */
        public function setup_config() {
            $theme = wp_get_theme();
            if (is_child_theme()) {
                $this->theme_name = $theme->parent()->get('Name');
                $this->theme = $theme->parent();
            } else {
                $this->theme_name = $theme->get('Name');
                $this->theme = $theme->parent();
            }
            $this->theme_version = $theme->get('Version');
            $this->theme_slug = $theme->get_template();
            $this->menu_name = isset($this->config['menu_name']) ? $this->config['menu_name'] : 'About ' . $this->theme_name;
            $this->page_name = isset($this->config['page_name']) ? $this->config['page_name'] : 'About ' . $this->theme_name;
            $this->notification = isset($this->config['notification']) ? $this->config['notification'] : ( apply_filters('traffica_welcome_notice_filter', ( '<p>' . sprintf('Welcome! Thank you for choosing <b> %1$s!</b> To fully take advantage of the best our theme can offer please make sure you visit our %2$swelcome page%3$s.', $this->theme_name, '<a href="' . esc_url(admin_url('themes.php?page=' . $this->theme_slug . '-welcome')) . '">', '</a>') . '</p><p><a href="' . esc_url(admin_url('themes.php?page=' . $this->theme_slug . '-welcome')) . '" class="button" style="text-decoration: none;">' . sprintf('Get started with %s', $this->theme_name) . '</a></p>')) );
            $this->tabs = isset($this->config['tabs']) ? $this->config['tabs'] : array();
        }

        /**
         * Setup the actions used for this page.
         */
        public function setup_actions() {

            add_action('admin_menu', array($this, 'register'));
            /* activation notice */
            add_action('load-themes.php', array($this, 'activation_admin_notice'));
            /* enqueue script and style for about page */
            add_action('admin_enqueue_scripts', array($this, 'style_and_scripts'));

            /* ajax callback for dismissable required actions */
            add_action('wp_ajax_ti_about_page_dismiss_required_action', array($this, 'dismiss_required_action_callback'));
            add_action('wp_ajax_nopriv_ti_about_page_dismiss_required_action', array($this, 'dismiss_required_action_callback'));
        }

        /**
         * Hide required tab if no actions present.
         *
         * @return bool Either hide the tab or not.
         */
        public function hide_required($value, $tab) {
            if ($tab != 'recommended_actions') {
                return $value;
            }
            $required = $this->get_required_actions();
            if (count($required) == 0) {
                return false;
            } else {
                return true;
            }
        }

        /**
         * Register the menu page under Appearance menu.
         */
        function register() {
            if (!empty($this->menu_name) && !empty($this->page_name)) {

                $count = 0;

                $actions_count = $this->get_required_actions();

                if (!empty($actions_count)) {
                    $count = count($actions_count);
                }

                $title = $count > 0 ? $this->page_name . '<span class="badge-action-count">' . esc_html($count) . '</span>' : $this->page_name;

                add_theme_page(
                        $this->menu_name, $title, 'activate_plugins', $this->theme_slug . '-welcome', array(
                    $this,
                    'inkthemes_about_page_render',
                        )
                );
            }
        }

        /**
         * Adds an admin notice upon successful activation.
         */
        public function activation_admin_notice() {
            global $pagenow;
            if (is_admin() && ( 'themes.php' == $pagenow ) && isset($_GET['activated'])) {
                add_action('admin_notices', array($this, 'inkthemes_about_page_welcome_admin_notice'), 99);
            }
        }

        /**
         * Display an admin notice linking to the about page
         */
        public function inkthemes_about_page_welcome_admin_notice() {
            if (!empty($this->notification)) {
                echo '<div class="updated notice is-dismissible">';
                echo wp_kses_post($this->notification);
                echo '</div>';
            }
        }

        /**
         * Render the main content page.
         */
        public function inkthemes_about_page_render() {

            if (!empty($this->config['welcome_title'])) {
                $welcome_title = $this->config['welcome_title'];
            }
            if (!empty($this->config['welcome_content'])) {
                $welcome_content = $this->config['welcome_content'];
            }

            if (!empty($welcome_title) || !empty($welcome_content) || !empty($this->tabs)) {

                echo '<div class="wrap about-wrap epsilon-wrap">';

                if (!empty($welcome_title)) {
                    echo '<h1>';
                    echo esc_html($welcome_title);
                    if (!empty($this->theme_version)) {
                        echo esc_html('') . ' </sup>';
                    }
                    echo '</h1>';
                }
                if (!empty($welcome_content)) {
                    echo '<div class="about-text">' . wp_kses_post($welcome_content) . '</div>';
                }

                echo '<a href="' . esc_url('https://inkthemes.com/') . '" target="_blank" class="wp-badge epsilon-welcome-logo"></a>';

                /* Display tabs */
                if (!empty($this->tabs)) {
                    $active_tab = isset($_GET['tab']) ? wp_unslash($_GET['tab']) : 'getting_started';

                    echo '<h2 class="nav-tab-wrapper wp-clearfix">';

                    $actions_count = $this->get_required_actions();

                    $count = 0;

                    if (!empty($actions_count)) {
                        $count = count($actions_count);
                    }

                    foreach ($this->tabs as $tab_key => $tab_name) {

                        if (( $tab_key != 'changelog' ) || ( ( $tab_key == 'changelog' ) && isset($_GET['show']) && ( $_GET['show'] == 'yes' ) )) {

                            if (( $count == 0 ) && ( $tab_key == 'recommended_actions' )) {
                                continue;
                            }

                            echo '<a href="' . esc_url(admin_url('themes.php?page=' . $this->theme_slug . '-welcome')) . '&tab=' . esc_html($tab_key) . '" class="nav-tab ' . ( $active_tab == $tab_key ? 'nav-tab-active' : '' ) . '" role="tab" data-toggle="tab">';
                            echo esc_html($tab_name);
                            if ($tab_key == 'recommended_actions') {
                                $count = 0;

                                $actions_count = $this->get_required_actions();

                                if (!empty($actions_count)) {
                                    $count = count($actions_count);
                                }
                                if ($count > 0) {
                                    echo '<span class="badge-action-count">' . esc_html($count) . '</span>';
                                }
                            }
                            echo '</a>';
                        }
                    }

                    echo '</h2>';

                    /* Display content for current tab */
                    if (method_exists($this, $active_tab)) {
                        $this->$active_tab();
                    }
                }// End if().

                echo '</div><!--/.wrap.about-wrap-->';
            }// End if().
        }

        /**
         * Display button for recommended actions or
         *
         * @param array $data Data for an item.
         */
        public function display_button($data) {
            $button_new_tab = '_self';
            $button_class = '';
            if (isset($tab_data['is_new_tab'])) {
                if ($data['is_new_tab']) {
                    $button_new_tab = '_blank';
                }
            }

            if ($data['is_button']) {
                $button_class = 'button button-primary';
            }
            echo '<a target="_blank" href="' . esc_url($data['button_link']) . '"class="' . esc_attr($button_class) . '">' . $data['button_label'] . '</a>';
        }

        /**
         * Getting started tab
         */
        public function getting_started() {

            if (!empty($this->config['getting_started'])) {

                $getting_started = $this->config['getting_started'];

                if (!empty($getting_started)) {

                    echo '<div class="feature-section two-col">';

                    foreach ($getting_started as $getting_started_item) {

                        echo '<div class="col">';
                        if (!empty($getting_started_item['title'])) {
                            echo '<h3>' . $getting_started_item['title'] . '</h3>';
                        }
                        if (!empty($getting_started_item['text'])) {
                            echo '<p>' . $getting_started_item['text'] . '</p>';
                        }
                        if (!empty($getting_started_item['button_link']) && !empty($getting_started_item['button_label'])) {

                            echo '<p>';

                            $count = 0;

                            $actions_count = $this->get_required_actions();

                            if (!empty($actions_count)) {
                                $count = count($actions_count);
                            }

                            if ($getting_started_item['recommended_actions'] && isset($count)) {
                                if ($count == 0) {
                                    echo '<span class="dashicons dashicons-yes"></span>';
                                } else {
                                    echo '<span class="dashicons dashicons-no-alt"></span>';
                                }
                            }
                            $this->display_button($getting_started_item);
                            echo '</p>';
                        }

                        echo '</div><!-- .col -->';
                    }// End foreach().
                    echo '</div><!-- .feature-section three-col -->';
                }// End if().
            }// End if().
        }

        /**
         * Getting started theme tab
         */
        public function getting_started_theme() {

            if (!empty($this->config['getting_started_theme'])) {

                $getting_started = $this->config['getting_started_theme'];

                if (!empty($getting_started)) {

                    echo '<div class="feature-section two-col">';

                    foreach ($getting_started as $getting_started_item) {

                        echo '<div class="col">';
                        if (!empty($getting_started_item['title'])) {
                            echo '<h3>' . $getting_started_item['title'] . '</h3>';
                        }
                        if (!empty($getting_started_item['text'])) {
                            echo '<p>' . $getting_started_item['text'] . '</p>';
                        }
                        if (!empty($getting_started_item['button_link']) && !empty($getting_started_item['button_label'])) {

                            echo '<p>';

                            $count = 0;

                            $actions_count = $this->get_required_actions();

                            if (!empty($actions_count)) {
                                $count = count($actions_count);
                            }

                            if ($getting_started_item['recommended_actions'] && isset($count)) {
                                if ($count == 0) {
                                    echo '<span class="dashicons dashicons-yes"></span>';
                                } else {
                                    echo '<span class="dashicons dashicons-no-alt"></span>';
                                }
                            }
                            $this->display_button($getting_started_item);
                            echo '</p>';
                        }

                        echo '</div><!-- .col -->';
                    }// End foreach().
                    echo '</div><!-- .feature-section three-col -->';
                }// End if().
            }// End if().
        }

        /**
         * Child themes
         */
        public function child_themes() {
            echo '<div id="child-themes" class="cw-about-page-tab-pane">';
            $child_themes = isset($this->config['child_themes']) ? $this->config['child_themes'] : array();
            if (!empty($child_themes)) {
                if (!empty($child_themes['content']) && is_array($child_themes['content'])) {
                    echo '<div class="cw-about-row">';
                    for ($i = 0; $i < count($child_themes['content']); $i ++) {
                        if (( $i !== 0 ) && ( $i / 3 === 0 )) {
                            echo '</div>';
                            echo '<div class="cw-about-row">';
                        }
                        $child = $child_themes['content'][$i];
                        if (!empty($child['image'])) {
                            echo '<div class="cw-about-child-theme">';
                            echo '<div class="cw-about-page-child-theme-image">';
                            echo '<img src="' . esc_url($child['image']) . '" alt="' . (!empty($child['image_alt']) ? esc_html($child['image_alt']) : '' ) . '" />';
                            if (!empty($child['title'])) {
                                echo '<div class="cw-about-page-child-theme-details">';
                                if ($child['title'] != $this->theme_name) {
                                    echo '<div class="theme-details">';
                                    echo '<span class="theme-name">' . $child['title'] . '</span>';
                                    if (!empty($child['download_link']) && !empty($child_themes['download_button_label'])) {
                                        echo '<a href="' . esc_url($child['download_link']) . '" class="button button-primary install right">' . esc_html($child_themes['download_button_label']) . '</a>';
                                    }
                                    if (!empty($child['preview_link']) && !empty($child_themes['preview_button_label'])) {
                                        echo '<a class="button button-secondary preview right" target="_blank" href="' . $child['preview_link'] . '">' . esc_html($child_themes['preview_button_label']) . '</a>';
                                    }
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                            echo '</div><!--cw-about-page-child-theme-image-->';
                            echo '</div><!--cw-about-child-theme-->';
                        }// End if().
                    }// End for().
                    echo '</div>';
                }// End if().
            }// End if().
            echo '</div>';
        }

        /**
         * Support tab
         */
        public function support() {
            echo '<div class="feature-section three-col">';

            if (!empty($this->config['support_content'])) {

                $support_steps = $this->config['support_content'];

                if (!empty($support_steps)) {

                    foreach ($support_steps as $support_step) {

                        echo '<div class="col">';

                        if (!empty($support_step['title'])) {
                            echo '<h3>';
                            if (!empty($support_step['icon'])) {
                                echo '<i class="' . $support_step['icon'] . '"></i>';
                            }
                            echo $support_step['title'];
                            echo '</h3>';
                        }

                        if (!empty($support_step['text'])) {
                            echo '<p><i>' . $support_step['text'] . '</i></p>';
                        }

                        if (!empty($support_step['button_link']) && !empty($support_step['button_label'])) {
                            echo '<p>';
                            $this->display_button($support_step);
                            echo '</p>';
                        }

                        echo '</div>';
                    }// End foreach().
                }// End if().
            }// End if().

            echo '</div>';
        }

        /**
         * Changelog tab
         */
        public function changelog() {
            $changelog = $this->parse_changelog();
            if (!empty($changelog)) {
                echo '<div class="featured-section changelog">';
                foreach ($changelog as $release) {
                    if (!empty($release['title'])) {
                        echo '<h2>' . $release['title'] . ' </h2 > ';
                    }
                    if (!empty($release['changes'])) {
                        echo implode('<br/>', $release['changes']);
                    }
                }
                echo '</div><!-- .featured-section.changelog -->';
            }
        }

        /**
         * Return the releases changes array.
         *
         * @return array The releases array.
         */
        private function parse_changelog() {
            WP_Filesystem();
            global $wp_filesystem;
            $changelog = $wp_filesystem->get_contents(get_template_directory() . '/changelog.txt');
            echo "<pre>";
            print_r($changelog);
            echo "</pre>";
            if (is_wp_error($changelog)) {
                $changelog = '';
            }
        }

        /**
         * Display feature title and description
         *
         * @param array $feature Feature data.
         */
        public function display_feature_title_and_description($feature) {
            if (!empty($feature['title'])) {
                echo '<h3>' . wp_kses_post($feature['title']) . '</h3>';
            }
            if (!empty($feature['description'])) {
                echo '<p>' . wp_kses_post($feature['description']) . '</p>';
            }
        }

        /**
         * Free vs PRO tab
         */
        public function free_pro() {
            $free_pro = isset($this->config['free_pro']) ? $this->config['free_pro'] : array();
            if (!empty($free_pro)) {
                if (!empty($free_pro['free_theme_name']) && !empty($free_pro['pro_theme_name']) && !empty($free_pro['features']) && is_array($free_pro['features'])) {
                    echo '<div class="feature-section">';
                    echo '<div id="free_pro" class="cw-about-page-tab-pane cw-about-page-fre-pro">';
                    echo '<table class="free-pro-table">';
                    echo '<thead>';
                    echo '<tr class="cw-about-page-text-right">';
                    echo '<th></th>';
                    echo '<th>' . esc_html($free_pro['free_theme_name']) . '</th>';
                    echo '<th>' . esc_html($free_pro['pro_theme_name']) . '</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($free_pro['features'] as $feature) {
                        echo '<tr>';
                        if (!empty($feature['title']) || !empty($feature['description'])) {
                            echo '<td>';
                            $this->display_feature_title_and_description($feature);
                            echo '</td>';
                        }
                        if (!empty($feature['is_in_lite']) && ( $feature['is_in_lite'] == 'true' )) {
                            echo '<td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>';
                        } else {
                            echo '<td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>';
                        }
                        if (!empty($feature['is_in_pro']) && ( $feature['is_in_pro'] == 'true' )) {
                            echo '<td class="only-lite"><span class="dashicons-before dashicons-yes"></span></td>';
                        } else {
                            echo '<td class="only-pro"><span class="dashicons-before dashicons-no-alt"></span></td>';
                        }
                        echo '</tr>';
                    }
                    if (!empty($free_pro['pro_theme_link']) && !empty($free_pro['get_pro_theme_label'])) {
                        echo '<tr>';
                        echo '<td>';
                        echo '</td>';
                        echo '<td colspan="2" class="cw-about-page-text-right"><a href="' . esc_url($free_pro['pro_theme_link']) . '" target="_blank" class="button button-primary button-hero">' . wp_kses_post($free_pro['get_pro_theme_label']) . '</a></td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';

                    echo '</div>';
                    echo '</div>';
                }// End if().
            }// End if().
        }

        /**
         * Load css and scripts for the about page
         */
        public function style_and_scripts($hook_suffix) {

            // this is needed on all admin pages, not just the about page, for the badge action count in the WordPress main sidebar
            wp_enqueue_style('cw-about-page-css', get_template_directory_uri() . '/cw-notifications/cw-about-page/css/cw_about_page_css.css', array());

            if ('appearance_page_' . $this->theme_slug . '-welcome' == $hook_suffix) {

                wp_enqueue_script('cw-about-page-js', get_template_directory_uri() . '/cw-notifications/cw-about-page/js/cw_about_page_scripts.js', array('jquery'));

                wp_enqueue_style('plugin-install');
                wp_enqueue_script('plugin-install');
                wp_enqueue_script('updates');

                $recommended_actions = isset($this->config['recommended_actions']) ? $this->config['recommended_actions'] : array();
                $required_actions = $this->get_required_actions();
                wp_localize_script(
                        'cw-about-page-js', 'cwAboutPageObject', array(
                    'nr_actions_required' => count($required_actions),
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'template_directory' => get_template_directory_uri(),
                    'activating_string' => esc_html__('Activating', 'business-directory'),
                        )
                );
            }
        }

        /**
         * Return the valid array of required actions.
         *
         * @return array The valid array of required actions.
         */
        private function get_required_actions() {
            $saved_actions = get_option($this->theme_slug . '_required_actions');
            if (!is_array($saved_actions)) {
                $saved_actions = array();
            }
            $req_actions = isset($this->config['recommended_actions']) ? $this->config['recommended_actions'] : array();
            $valid = array();
//			foreach ( $req_actions['content'] as $req_action ) {
//				if ( ( ! isset( $req_action['check'] ) || ( isset( $req_action['check'] ) && ( $req_action['check'] == false ) ) ) && ( ! isset( $saved_actions[ $req_action['id'] ] ) ) ) {
//					$valid[] = $req_action;
//				}
//			}

            return $valid;
        }

        /**
         * Dismiss required actions
         */
//        public function dismiss_required_action_callback() {
//
//            $recommended_actions = array();
//            $req_actions = isset($this->config['recommended_actions']) ? $this->config['recommended_actions'] : array();
//            foreach ($req_actions['content'] as $req_action) {
//                $recommended_actions[] = $req_action;
//            }
//
//            $action_id = ( isset($_GET['id']) ) ? $_GET['id'] : 0;
//
//            echo esc_html(wp_unslash($action_id)); /* this is needed and it's the id of the dismissable required action */
//
//            if (!empty($action_id)) {
//
//                /* if the option exists, update the record for the specified id */
//                if (get_option($this->theme_slug . '_required_actions')) {
//
//                    $ti_about_page_show_required_actions = get_option($this->theme_slug . '_required_actions');
//
//                    switch (esc_html($_GET['todo'])) {
//                        case 'add':
//                            $ti_about_page_show_required_actions[absint($action_id)] = true;
//                            break;
//                        case 'dismiss':
//                            $ti_about_page_show_required_actions[absint($action_id)] = false;
//                            break;
//                    }
//
//                    update_option($this->theme_slug . '_required_actions', $ti_about_page_show_required_actions);
//
//                    /* create the new option,with false for the specified id */
//                } else {
//
//                    $ti_about_page_show_required_actions_new = array();
//
//                    if (!empty($recommended_actions)) {
//
//                        foreach ($recommended_actions as $ti_about_page_required_action) {
//
//                            if ($ti_about_page_required_action['id'] == $action_id) {
//                                $ti_about_page_show_required_actions_new[$ti_about_page_required_action['id']] = false;
//                            } else {
//                                $ti_about_page_show_required_actions_new[$ti_about_page_required_action['id']] = true;
//                            }
//                        }
//
//                        update_option($this->theme_slug . '_required_actions', $ti_about_page_show_required_actions_new);
//                    }
//                }
//            }// End if().
//        }
    }

}// End if().
