<?php

function EWD_URP_add_ob_start() {
    ob_start();
}
add_action('init', 'EWD_URP_add_ob_start');

function EWD_URP_flush_ob_end() {
    ob_end_flush();
}
add_action('wp_footer', 'EWD_URP_flush_ob_end');