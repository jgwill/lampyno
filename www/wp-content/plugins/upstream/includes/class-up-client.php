<?php

// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * UpStream_Client Class
 *
 * @since 1.0
 */
class UpStream_Client
{

    /**
     * The client ID
     *
     * @since 1.0
     */
    public $ID = 0;

    public $meta_prefix = '_upstream_client_';

    public $meta = [
        'logo',
        'logo_id',
        'address',
        'phone',
        'website',
        'users',
    ];

    /**
     * Declare the default properties in WP_Post as we can't extend it
     * Anything we've declared above has been removed.
     */
    public $post_author = 0;
    public $post_date = '0000-00-00 00:00:00';
    public $post_date_gmt = '0000-00-00 00:00:00';
    public $post_content = '';
    public $post_title = '';
    public $post_excerpt = '';
    public $post_status = 'publish';
    public $comment_status = 'open';
    public $ping_status = 'open';
    public $post_password = '';
    public $post_name = '';
    public $to_ping = '';
    public $pinged = '';
    public $post_modified = '0000-00-00 00:00:00';
    public $post_modified_gmt = '0000-00-00 00:00:00';
    public $post_content_filtered = '';
    public $post_parent = 0;
    public $guid = '';
    public $menu_order = 0;
    public $post_mime_type = '';
    public $comment_count = 0;
    public $filter;

    /**
     * Get things going
     *
     * @since 1.0
     */
    public function __construct($_id = false, $_args = [])
    {

        // if no id is sent, then go through the varous ways of getting the id
        // may need to check the order more closely to ensure we get it right
        if ( ! $_id) {
            $user_id = upstream_current_user_id();
            $_id     = upstream_get_users_client_id($user_id);
        }

        if ( ! $_id) {
            $_id = upstream_project_client_id();
        }


        $client = WP_Post::get_instance($_id);

        return $this->setup_client($client);
    }

    /**
     * Given the client data, let's set the variables
     *
     * @since  2.3.6
     *
     * @param  object $client The Client Object
     *
     * @return bool             If the setup was successful or not
     */
    private function setup_client($client)
    {
        if ( ! is_object($client)) {
            return false;
        }

        if ( ! is_a($client, 'WP_Post')) {
            return false;
        }

        if ('client' !== $client->post_type) {
            return false;
        }

        // sets the value of each key
        foreach ($client as $key => $value) {
            switch ($key) {
                default:
                    $this->$key = $value;
                    break;
            }
        }

        return true;
    }

    public function init()
    {
        add_action('init', [$this, 'hooks']);
    }

    public function hooks()
    {
        //add_action( 'wp_insert_post', array( $this, 'update_project_meta_admin' ), 1, 3 );
        //add_action( "cmb2_post_process_fields__upstream_project_bugs", array( $this, 'bug_changes' ), 10, 2 );
    }


    /**
     * Get a meta value
     *
     * @since 1.0.0
     *
     * @param string $meta the meta field (without prefix)
     *
     * @return mixed
     */
    public function get_meta($meta)
    {
        $result = get_post_meta($this->ID, $this->meta_prefix . $meta, true);
        if ( ! $result) {
            $result = null;
        }

        return $result;
    }
}
