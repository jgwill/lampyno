<?php

namespace UpStream\Migrations;

// Prevent direct access.
if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * This class transform all existent project comments into WordPress Comments.
 *
 * @since   1.13.0
 */
final class Comments
{
    /**
     * Run the migration if needed.
     *
     * @since   1.13.0
     * @static
     */
    public static function run()
    {
        if ( ! self::isMigrationNeeded()) {
            return;
        }

        $rowset = self::fetchMetasRowset();
        if (count($rowset) > 0) {
            global $wpdb;

            foreach ($rowset as $project_id => $legacyComments) {
                foreach ($legacyComments as $legacyComment) {
                    if ( ! isset($legacyComment['created_by'])
                         || ! isset($legacyComment['created_time'])
                         || ! isset($legacyComment['comment'])
                         || empty($legacyComment['comment'])
                    ) {
                        continue;
                    }

                    $user = get_user_by('id', $legacyComment['created_by']);

                    $date = \DateTime::createFromFormat('U', $legacyComment['created_time']);

                    $newCommentData = [
                        'comment_post_ID'      => $project_id,
                        'comment_author'       => $user->display_name,
                        'comment_author_email' => $user->user_email,
                        'comment_date_gmt'     => $date->format('Y-m-d H:i:s'),
                        'comment_content'      => $legacyComment['comment'],
                        'user_id'              => $user->ID,
                        'comment_approved'     => 1,
                    ];

                    $newCommentData['comment_date'] = $date->format('Y-m-d H:i:s');

                    $wpdb->insert($wpdb->prefix . 'comments', $newCommentData);

                    update_comment_meta($wpdb->insert_id, 'type', "project");
                }
            }
        }

        update_option('upstream:migration.comments', 'yes');
    }

    /**
     * Check if migration is needed.
     *
     * @since   1.13.0
     * @access  private
     * @static
     */
    private static function isMigrationNeeded()
    {
        return (string)get_option('upstream:migration.comments') !== 'yes';
    }

    /**
     * Fetch all discussion metas from all projects.
     * It returns an associative array with project ID as keys and a list of comments as values.
     *
     * @since   1.13.0
     * @access  private
     * @static
     *
     * @global  $wpdb
     *
     * @return  array
     */
    private static function fetchMetasRowset()
    {
        global $wpdb;

        $data = [];

        // Fetch all existent discussion metas.
        $metasRowset = $wpdb->get_results(
            '
            SELECT `post_id`, `meta_key`, `meta_value`
            FROM `' . $wpdb->prefix . 'postmeta`
            WHERE `meta_key` = "_upstream_project_discussion"'
        );

        if (count($metasRowset) > 0) {
            foreach ($metasRowset as $meta) {
                $project_id = (int)$meta->post_id;
                $metaValue  = (array)maybe_unserialize($meta->meta_value);

                if ( ! empty($metaValue)) {
                    $metaValue = isset($metaValue[0]) ? $metaValue[0] : $metaValue;
                }

                if ( ! empty($metaValue) && is_array($metaValue)) {
                    if ( ! isset($data[$project_id])) {
                        $data[$project_id] = [];
                    }

                    $data[$project_id][] = $metaValue;
                }
            }
        }

        return $data;
    }
}
