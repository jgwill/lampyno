<?php
/**
 * Customize Control for Taxonomy Select.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Advance_Blog_Dropdown_Taxonomies_Control extends WP_Customize_Control
{
    /**
     * Control type.
     *
     * @access public
     * @var string
     */
    public $type = 'dropdown-taxonomies';

    /**
     * Taxonomy.
     *
     * @access public
     * @var string
     */
    public $taxonomy = '';

    /**
     * Constructor.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string $id Control ID.
     * @param array $args Optional. Arguments to override class property defaults.
     */
    public function __construct($manager, $id, $args = array())
    {

        $our_taxonomy = 'category';
        if (isset($args['taxonomy'])) {
            $taxonomy_exist = taxonomy_exists(esc_attr($args['taxonomy']));
            if (true === $taxonomy_exist) {
                $our_taxonomy = esc_attr($args['taxonomy']);
            }
        }
        $args['taxonomy'] = $our_taxonomy;
        $this->taxonomy = esc_attr($our_taxonomy);

        parent::__construct($manager, $id, $args);
    }

    /**
     * Render content.
     *
     * @since 1.0.0
     */
    public function render_content()
    {

        $tax_args = array(
            'hierarchical' => 0,
            'taxonomy' => $this->taxonomy,
        );
        $all_taxonomies = get_categories($tax_args);

        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <select <?php $this->link(); ?>>
                <?php
                printf('<option value="%s" %s>%s</option>', '', selected($this->value(), '', false), ' ');
                ?>
                <?php if (!empty($all_taxonomies)): ?>
                    <?php foreach ($all_taxonomies as $key => $tax): ?>
                        <?php
                        printf('<option value="%s" %s>%s</option>', esc_attr($tax->term_id), selected($this->value(), $tax->term_id, false), esc_html($tax->name));
                        ?>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </label>
        <?php
    }
}

if (!function_exists('advance_blog_sanitize_select')):

    /**
     * Sanitize select.
     *
     * @since 1.0.0
     *
     * @param mixed                $input The value to sanitize.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return mixed Sanitized value.
     */
    function advance_blog_sanitize_select($input, $setting) {

        // Ensure input is a slug.
        $input = sanitize_text_field($input);

        // Get list of choices from the control associated with the setting.
        $choices = $setting->manager->get_control($setting->id)->choices;

        // If the input is a valid key, return it; otherwise, return the default.
        return (array_key_exists($input, $choices)?$input:$setting->default);

    }

endif;

if (!function_exists('advance_blog_sanitize_checkbox')):

    /**
     * Sanitize checkbox.
     *
     * @since 1.0.0
     *
     * @param bool $checked Whether the checkbox is checked.
     * @return bool Whether the checkbox is checked.
     */
    function advance_blog_sanitize_checkbox($checked) {

        return ((isset($checked) && true === $checked)?true:false);

    }

endif;

if ( ! function_exists( 'advance_blog_sanitize_image' ) ) :

    /**
     * Sanitize image.
     *
     * @since 1.0.0
     *
     * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
     *
     * @param string               $image Image filename.
     * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
     * @return string The image filename if the extension is allowed; otherwise, the setting default.
     */
    function advance_blog_sanitize_image( $image, $setting ) {

        /**
         * Array of valid image file types.
         *
         * The array includes image mime types that are included in wp_get_mime_types().
         */
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon',
        );

        // Return an array with file extension and mime_type.
        $file = wp_check_filetype( $image, $mimes );

        // If $image has a valid mime_type, return it; otherwise, return the default.
        return ( $file['ext'] ? $image : $setting->default );

    }

endif;