<?php
/**
 * Plugin Name: CDG Studio
 * Description: Back-office personnalisé pour Cap Digital Gestion.
 * Version: 0.8.0
 * Author: Cap Digital Gestion
 * Text Domain: cdg-studio
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CDG_STUDIO_VERSION', '0.8.0');
define('CDG_STUDIO_DB_VERSION', '0.5.0');
define('CDG_STUDIO_PATH', plugin_dir_path(__FILE__));
define('CDG_STUDIO_URL', plugin_dir_url(__FILE__));

require_once CDG_STUDIO_PATH . 'includes/helpers.php';
require_once CDG_STUDIO_PATH . 'database/install.php';
require_once CDG_STUDIO_PATH . 'admin/menu.php';
require_once CDG_STUDIO_PATH . 'admin/dashboard.php';
require_once CDG_STUDIO_PATH . 'chiffres/repository.php';
require_once CDG_STUDIO_PATH . 'chiffres/admin.php';
require_once CDG_STUDIO_PATH . 'frontend/shortcodes.php';
// Chargement progressif du nouveau Core CDG Studio.
require_once CDG_STUDIO_PATH . 'app/Core/Application.php';
require_once CDG_STUDIO_PATH . 'app/Core/Loader.php';
require_once CDG_STUDIO_PATH . 'app/Core/Plugin.php';

if (class_exists('\CDGStudio\Core\Plugin')) {
    \CDGStudio\Core\Plugin::boot();
}
register_activation_hook(__FILE__, 'cdg_studio_activate');

function cdg_studio_activate() {
    cdg_studio_install_database();
}

add_action('admin_enqueue_scripts', 'cdg_studio_admin_assets');
function cdg_studio_admin_assets($hook) {
    if (strpos($hook, 'cdg-studio') === false && strpos($hook, 'cdg-chiffres') === false) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_style('dashicons');
    wp_enqueue_style('cdg-studio-admin', CDG_STUDIO_URL . 'assets/css/admin.css', array('dashicons'), CDG_STUDIO_VERSION);
    wp_enqueue_script('cdg-studio-admin', CDG_STUDIO_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), CDG_STUDIO_VERSION, true);
    wp_localize_script('cdg-studio-admin', 'CDGStudioAdmin', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('cdg_studio_admin_nonce'),
        'copyOk' => __('Shortcode copié.', 'cdg-studio'),
        'copyFail' => __('Copie impossible.', 'cdg-studio'),
        'version' => CDG_STUDIO_VERSION,
    ));
}

add_action('wp_enqueue_scripts', 'cdg_studio_front_assets');
function cdg_studio_front_assets() {
    wp_enqueue_style('cdg-studio-front', CDG_STUDIO_URL . 'assets/css/front.css', array(), CDG_STUDIO_VERSION);
    wp_enqueue_script('cdg-studio-front', CDG_STUDIO_URL . 'assets/js/front.js', array(), CDG_STUDIO_VERSION, true);
}
