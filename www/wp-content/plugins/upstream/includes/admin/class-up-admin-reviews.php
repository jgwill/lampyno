<?php
/**
 * Setup message asking for review.
 *
 * @author   UpStream
 * @category Admin
 * @package  UpStream/Admin
 * @version  1.0.0
 */

// Exit if accessed directly or already defined.
if ( ! defined('ABSPATH') || class_exists('UpStream_Admin_Reviews')) {
    return;
}

/**
 * Class UpStream_Admin_Reviews
 */
class UpStream_Admin_Reviews
{
    /**
     * Checks if it should display the notification and look for actions in the URL.
     */
    public function init()
    {
        // We only check GET requests
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return;
        }

        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (defined('DOING_CRON') && DOING_CRON) {
            return;
        }

        if ($this->found_five_projects()) {
            $params = [
                'redirect_url' => 'edit.php?post_type=project',
                'review_link'  => 'http://wordpress.org/support/plugin/upstream/reviews/#new-post',
                'notice_text'  => __(
                    'Hey, I noticed you have created 5 or more projects on %sUpStream%s - that\'s awesome! May I ask you to give it a %s5-star%s rating on WordPress? Just to help us spread the word and boost our motivation.',
                    'upstream'
                ),
            ];

            // Enable the Reviews module from the Allex framework.
            do_action('allex_enable_module_reviews', $params);
        }
    }

    /**
     * @return bool
     */
    protected function found_five_projects()
    {
        $count = wp_count_posts('project');

        if (is_object($count) && isset($count->publish)) {
            return $count->publish >= 5;
        }

        return false;
    }
}
