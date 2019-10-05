<?php

// Exit if accessed directly.
if ( ! defined('ABSPATH')) {
    exit;
}

/**
 * Run the extension after UpStream is loaded.
 */
add_action('upstream_loaded', 'upstream_run_styles');
function upstream_run_styles()
{
    return UpStream_Style_Output::instance();
}

/**
 * Main UpStream Style Output Class.
 *
 * @since 1.0.0
 */
class UpStream_Style_Output
{

    /**
     * @var UpStream The one true UpStream Style Output
     * @since 1.0.0
     */
    protected static $_instance = null;
    private $opt = '';

    public function __construct()
    {
        $this->init_hooks();
        $this->opt = get_option('upstream_style');
    }

    /**
     * Hook into actions and filters.
     *
     * @since  1.0.0
     */
    private function init_hooks()
    {
        add_action('upstream_footer_text', [$this, 'footer_text']);

        $this->registerDeprecatedAlertHooks();
    }

    /**
     * Register hooks that alert users about other deprecated frontend hooks.
     *
     * @since   1.12.2
     * @access  private
     */
    private function registerDeprecatedAlertHooks()
    {
        add_action('upstream_before_single_message', [$this, 'deprecatedBeforeSingleMessageAlert']);
        add_action('upstream_after_single_message', [$this, 'deprecatedAfterSingleMessageAlert']);
    }

    /**
     * @since 1.0.0
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Enqueues
     *
     * @since  1.0.0
     */
    public function footer_text($text)
    {
        if (isset($this->opt['footer_text']) && ! empty($this->opt['footer_text'])) {
            $text = $this->opt['footer_text'];
        }

        return $text;
    }

    /**
     * Deprecated alert for the hook "upstream_before_single_message" that became
     * "upstream:project.discussion:before_comment".
     *
     * @since   1.12.2
     */
    public function deprecatedBeforeSingleMessageAlert()
    {
        _deprecated_function(
            'The action "upstream_before_single_message"',
            UPSTREAM_VERSION,
            '"upstream:project.discussion:before_comment"'
        );
    }

    /**
     * Deprecated alert for the hook "upstream_after_single_message" that became
     * "upstream:project.discussion:after_comment".
     *
     * @since   1.12.2
     */
    public function deprecatedAfterSingleMessageAlert()
    {
        _deprecated_function(
            'The action "upstream_after_single_message"',
            UPSTREAM_VERSION,
            '"upstream:project.discussion:after_comment"'
        );
    }

    /**
     * Check if we have this CSS
     *
     * @since  1.0.0
     */
    private function css($item)
    {
        $css = isset($this->opt[$item]) && $this->opt[$item] != '' ? $this->opt[$item] : '';

        return esc_html($css);
    }
}
