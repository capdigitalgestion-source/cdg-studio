<?php
if (!defined('ABSPATH')) exit;

function cdg_studio_table($name) {
    global $wpdb;
    return $wpdb->prefix . 'cdg_' . $name;
}

function cdg_studio_clean_text($value) {
    return sanitize_text_field(wp_unslash($value ?? ''));
}

function cdg_studio_allowed_visual_types() {
    return array('none', 'emoji', 'dashicon', 'fontawesome', 'image');
}
