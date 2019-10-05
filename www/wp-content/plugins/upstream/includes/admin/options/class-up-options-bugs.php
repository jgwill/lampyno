<?php

// Exit if accessed directly
if ( ! defined('ABSPATH')) {
    exit;
}

if ( ! class_exists('UpStream_Options_Bugs')) :

    /**
     * CMB2 Theme Options
     *
     * @version 0.1.0
     */
    class UpStream_Options_Bugs
    {

        /**
         * ID of metabox
         *
         * @var array
         */
        public $id = 'upstream_bugs';

        /**
         * Page title
         *
         * @var string
         */
        protected $title = '';

        /**
         * Menu Title
         *
         * @var string
         */
        protected $menu_title = '';

        /**
         * Menu Title
         *
         * @var string
         */
        protected $description = '';

        /**
         * Holds an instance of the object
         *
         * @var Myprefix_Admin
         **/
        public static $instance = null;

        /**
         * Constructor
         *
         * @since 0.1.0
         */
        public function __construct()
        {
            // Set our title
            $this->title      = upstream_bug_label_plural();
            $this->menu_title = $this->title;
            //$this->description = sprintf( __( '%s Description', 'upstream' ), upstream_bug_label() );

            add_filter('cmb2_field_new_value', [$this, 'cmb2_field_new_value'], 10, 4);
        }

        /**
         * Returns the running object
         *
         * @return Myprefix_Admin
         **/
        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Add the options metabox to the array of metaboxes
         *
         * @since  0.1.0
         */
        public function options()
        {
            $options = apply_filters(
                $this->id . '_option_fields',
                [
                    'id'         => $this->id, // upstream_tasks
                    'title'      => $this->title,
                    'menu_title' => $this->menu_title,
                    'desc'       => $this->description,
                    'show_on'    => ['key' => 'options-page', 'value' => [$this->id],],
                    'show_names' => true,
                    'fields'     => [
                        [
                            'name' => __('Statuses', 'upstream'),
                            'id'   => 'status_title',
                            'type' => 'title',
                            'desc' => sprintf(__(
                                'The statuses and colors that can be used for the status of %s.<br>These will become available in the %s Status dropdown within each %s',
                                'upstream'
                            ), upstream_bug_label_plural(), upstream_bug_label(), upstream_bug_label()),
                        ],
                        [
                            'id'              => 'statuses',
                            'type'            => 'group',
                            'name'            => 'Statuses',
                            'description'     => '',
                            'options'         => [
                                'group_title'   => __('Status {#}', 'upstream'),
                                'add_button'    => __('Add Status', 'upstream'),
                                'remove_button' => __('Remove Entry', 'upstream'),
                                'sortable'      => true, // beta
                            ],
                            'sanitization_cb' => ['UpStream_Admin', 'onBeforeSave'],
                            'fields'          => [
                                [
                                    'name' => __('Hidden', 'upstream'),
                                    'id'   => 'id',
                                    'type' => 'hidden',
                                ],
                                [
                                    'name'       => __('Status Color', 'upstream'),
                                    'id'         => 'color',
                                    'type'       => 'colorpicker',
                                    'attributes' => [
                                        'data-colorpicker' => json_encode([
                                            // Iris Options set here as values in the 'data-colorpicker' array
                                            'palettes' => upstream_colorpicker_default_colors(),
                                            'width'    => 300,
                                        ]),
                                    ],
                                ],
                                [
                                    'name' => __('Status Name', 'upstream'),
                                    'id'   => 'name',
                                    'type' => 'text',
                                ],
                                [
                                    'name'    => __('Type of Status', 'upstream'),
                                    'id'      => 'type',
                                    'type'    => 'radio',
                                    'default' => 'open',
                                    'desc'    => __(
                                                     "A Status Name such as 'In Progress' or 'Overdue' would be considered Open.",
                                                     'upstream'
                                                 ) . '<br>' . __(
                                                     "A Status Name such as 'Complete' or 'Cancelled' would be considered Closed.",
                                                     'upstream'
                                                 ),
                                    'options' => [
                                        'open'   => __('Open', 'upstream'),
                                        'closed' => __('Closed', 'upstream'),
                                    ],
                                ],
                            ],
                        ],
                        [
                            'name' => __('Severity', 'upstream'),
                            'id'   => 'severity_title',
                            'type' => 'title',
                            'desc' => sprintf(__(
                                'The severity and colors that can be used for the severity of %s.<br>These will become available in the %s Severity dropdown within each %s',
                                'upstream'
                            ), upstream_bug_label_plural(), upstream_bug_label(), upstream_bug_label()),
                        ],
                        [
                            'id'          => 'severities',
                            'type'        => 'group',
                            'name'        => 'Severities',
                            'description' => '',
                            'options'     => [
                                'group_title'   => __('Severity {#}', 'upstream'),
                                'add_button'    => __('Add Severity', 'upstream'),
                                'remove_button' => __('Remove Entry', 'upstream'),
                                'sortable'      => true, // beta
                            ],
                            'fields'      => [
                                [
                                    'name' => __('Hidden', 'upstream'),
                                    'id'   => 'id',
                                    'type' => 'hidden',
                                ],
                                [
                                    'name'       => __('Severity Color', 'upstream'),
                                    'id'         => 'color',
                                    'type'       => 'colorpicker',
                                    'attributes' => [
                                        'data-colorpicker' => json_encode([
                                            // Iris Options set here as values in the 'data-colorpicker' array
                                            'palettes' => upstream_colorpicker_default_colors(),
                                            'width'    => 300,
                                        ]),
                                    ],
                                ],
                                [
                                    'name' => __('Severity Name', 'upstream'),
                                    'id'   => 'name',
                                    'type' => 'text',
                                ],
                            ],
                        ],


                    ],
                ]
            );

            return $options;
        }

        /**
         * Create ids for all existent bugs statuses/severities.
         *
         * @since   1.17.0
         * @static
         */
        public static function createBugsStatusesIds()
        {
            $continue = ! (bool)get_option('upstream:created_bugs_args_ids');
            if ( ! $continue) {
                return;
            }


            $bugs = get_option('upstream_bugs');
            if (isset($bugs['statuses']) && isset($bugs['severities'])) {
                $bugs['statuses']   = UpStream_Admin::createMissingIdsInSet($bugs['statuses']);
                $bugs['severities'] = UpStream_Admin::createMissingIdsInSet($bugs['severities']);

                update_option('upstream_bugs', $bugs);

                // Update existent Bugs statuses/severities across all Projects.
                global $wpdb;

                $metas = $wpdb->get_results(sprintf(
                    'SELECT `post_id`, `meta_value`
                FROM `%s`
                WHERE `meta_key` = "_upstream_project_bugs"',
                    $wpdb->prefix . 'postmeta'
                ));

                if (count($metas) > 0) {
                    $getBugArgIdByTitle = function ($needle, $argName = 'statuses') use (&$bugs) {
                        foreach ($bugs[$argName] as $bug) {
                            if ($needle === $bug['name']) {
                                return $bug['id'];
                            }
                        }

                        return false;
                    };

                    $replaceBugArgsWithItsIds = function ($bug) use (&$getBugArgIdByTitle) {
                        if (isset($bug['status'])
                            && ! empty($bug['status'])
                        ) {
                            $bugArgId = $getBugArgIdByTitle($bug['status']);
                            if ($bugArgId !== false) {
                                $bug['status'] = $bugArgId;
                            }
                        }

                        if (isset($bug['severity'])
                            && ! empty($bug['severity'])
                        ) {
                            $bugArgId = $getBugArgIdByTitle($bug['severity'], 'severities');
                            if ($bugArgId !== false) {
                                $bug['severity'] = $bugArgId;
                            }
                        }

                        return $bug;
                    };

                    foreach ($metas as $meta) {
                        if (empty($meta->meta_value)) {
                            continue;
                        }

                        $projectId = (int)$meta->post_id;

                        $data = array_filter(maybe_unserialize((string)$meta->meta_value));
                        $data = array_map($replaceBugArgsWithItsIds, $data);

                        update_post_meta($projectId, '_upstream_project_bugs', $data);
                    }
                }

                update_option('upstream:created_bugs_args_ids', 1);
            }
        }

        public function cmb2_field_new_value($new_value, $single, $args, $field)
        {
            if ( ! isset($field->data_to_save) || ! isset($field->data_to_save['object_id']) || ! $field->data_to_save['object_id'] === 'upstream_bugs') {
                return $new_value;
            }

            if (isset($args['name']) && in_array($args['name'], ['Severities', 'Statuses'])) {
                $new_value = UpStream_Admin::createMissingIdsInSet($new_value);
            }

            return $new_value;
        }
    }


endif;
