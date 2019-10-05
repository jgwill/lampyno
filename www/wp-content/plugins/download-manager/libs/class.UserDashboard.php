<?php
namespace WPDM;

class UserDashboard
{

    public $dashboard_menu;
    public $dashboard_menu_actions;

    function __construct(){
        add_action("wp", array($this, 'DashboardMenuInit'));
        add_shortcode("wpdm_user_dashboard", array($this, 'Dashboard'));
    }

    function DashboardMenuInit(){
        //$this->dashboard_menu
        $user[''] = array('name'=> __( "Profile" , "download-manager" ), 'callback' => array($this, 'Profile'));
        $user['download-history'] = array('name'=> __( "Download History" , "download-manager" ), 'callback' => array($this, 'DownloadHistory'));
        $account['edit-profile'] = array('name'=> __( "Edit Profile" , "download-manager" ), 'callback' => array($this, 'editProfile'));
        $user = apply_filters("wpdm_user_dashboard_menu", $user);
        $account = apply_filters("wpdm_user_dashboard_menu_account", $account);
        $this->dashboard_menu['user'] = array(
            'title' => '',
            'items'         => $user
        );
        $this->dashboard_menu['account'] = array(
            'title' => __("Account", "download-manager"),
            'items'         => $account
        );

        $this->dashboard_menu = apply_filters("wpdm_dashboard_menu", $this->dashboard_menu);

        $this->dashboard_menu_actions = apply_filters("wpdm_dashboard_menu_actions", $this->dashboard_menu_actions);
    }

    function Dashboard($params = array()){
        global $wp_query;

        ob_start();
        if(!is_user_logged_in()) {
            if(isset($params['signup']) && $params['signup'] == 1)
                include \WPDM\Template::Locate('wpdm-be-member.php');
            else
                include  \WPDM\Template::Locate('wpdm-login-form.php');

        } else {

            if (!isset($params) || !is_array($params)) $params = array();
            $all_dashboard_menu_items = array();
            foreach ($this->dashboard_menu as $section) {
                $all_dashboard_menu_items += $section['items'];
            }
            $udb_page = isset($wp_query->query_vars['udb_page']) ? $wp_query->query_vars['udb_page'] : '';
            $udb_page_parts = explode("/", $udb_page);
            $udb_page = $udb_page_parts[0];
            $udb_page_parts = array_merge($udb_page_parts, $params);
            if (isset($all_dashboard_menu_items[$udb_page]['callback']))
                $dashboard_contents = call_user_func($all_dashboard_menu_items[$udb_page]['callback'], $udb_page_parts);
            else if (isset($all_dashboard_menu_items[$udb_page]['shortcode']))
                $dashboard_contents = do_shortcode($all_dashboard_menu_items[$udb_page]['shortcode']);
            else if (isset($all_dashboard_menu_items[$udb_page]))
                $dashboard_contents = call_user_func($all_dashboard_menu_items[$udb_page], $udb_page_parts);
            //else if(isset($this->dashboard_menu_actions[$udb_page]['shortcode']))
            //    $dashboard_contents = do_shortcode($this->dashboard_menu_actions[$udb_page]['shortcode']);

            $default_icons[''] = 'far fa-user-circle color-primary';
            $default_icons['purchases'] = 'fas fa-file-download color-success';
            $default_icons['messages'] = 'fa fa-comments color-success';
            $default_icons['download-history'] = 'fa fa-history color-info';
            $default_icons['edit-profile'] = 'fa fa-user-edit color-green';
            $default_icons['subscription-plan'] = 'fa fa-crown color-info';
            $default_icons['subscription-download-area'] = 'fa fa-tasks color-info';
            $default_icons['affiliate-stats'] = 'fa fa-share-alt color-info';
            $default_icons['affiliates'] = 'fa fa-share-alt color-info';
            $default_icons['file-cart'] = 'fa fa-cart-arrow-down color-info';
            $default_icons['my-downloads'] = 'fa fa-arrow-down color-info';
            $default_icons['account-credits'] = 'fa fa-credit-card color-success';

            $default_icons = apply_filters("wpdm_user_dashboard_icons", $default_icons);

            include wpdm_tpl_path('wpdm-dashboard.php');
        }
        return ob_get_clean();
    }

    function profile($params = array()){
        ob_start();
        include wpdm_tpl_path('user-dashboard/profile.php');
        return ob_get_clean();
    }

    function downloadHistory(){
        global $wpdb, $current_user;
        ob_start();
        include wpdm_tpl_path('user-dashboard/download-history.php');
        return ob_get_clean();
    }

    function editProfile(){
        global $wpdb, $current_user;
        ob_start();
        include wpdm_tpl_path('user-dashboard/edit-profile.php');
        return ob_get_clean();
    }

    function logout(){
        wp_logout();
    }

}

