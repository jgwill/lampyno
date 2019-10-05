<?php
function EWD_URP_Frontend_AJAX_URL() {
    ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
<?php
}
add_action('wp_head','EWD_URP_Frontend_AJAX_URL');
?>