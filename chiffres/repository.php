<?php
if (!defined('ABSPATH')) exit;

function cdg_chiffres_all($only_active = false) {
    global $wpdb;
    $table = cdg_studio_table('chiffres');
    $where = $only_active ? 'WHERE actif = 1' : '';
    return $wpdb->get_results("SELECT * FROM $table $where ORDER BY ordre ASC, id ASC");
}

function cdg_chiffres_get($id) {
    global $wpdb;
    $table = cdg_studio_table('chiffres');
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
}

function cdg_chiffres_save_from_post() {
    if (!current_user_can('manage_options')) wp_die('Accès refusé.');
    check_admin_referer('cdg_chiffre_save');

    global $wpdb;
    $table = cdg_studio_table('chiffres');
    $id = isset($_POST['id']) ? absint($_POST['id']) : 0;
    $visual_type = cdg_studio_clean_text($_POST['visuel_type'] ?? 'emoji');
    if (!in_array($visual_type, cdg_studio_allowed_visual_types(), true)) {
        $visual_type = 'emoji';
    }

    $data = array(
        'ordre' => absint($_POST['ordre'] ?? 0),
        'actif' => !empty($_POST['actif']) ? 1 : 0,
        'titre' => cdg_studio_clean_text($_POST['titre'] ?? ''),
        'valeur' => cdg_studio_clean_text($_POST['valeur'] ?? ''),
        'texte' => sanitize_textarea_field(wp_unslash($_POST['texte'] ?? '')),
        'visuel_type' => $visual_type,
        'emoji' => cdg_studio_clean_text($_POST['emoji'] ?? ''),
        'dashicon' => cdg_studio_clean_text($_POST['dashicon'] ?? ''),
        'fontawesome' => cdg_studio_clean_text($_POST['fontawesome'] ?? ''),
        'image_id' => !empty($_POST['image_id']) ? absint($_POST['image_id']) : null,
        'source_label' => cdg_studio_clean_text($_POST['source_label'] ?? ''),
        'source_url' => esc_url_raw(wp_unslash($_POST['source_url'] ?? '')),
        'updated_at' => current_time('mysql'),
    );

    if ($id > 0) {
        $wpdb->update($table, $data, array('id' => $id));
    } else {
        $data['created_at'] = current_time('mysql');
        if ($data['ordre'] === 0) {
            $data['ordre'] = (int) $wpdb->get_var("SELECT COALESCE(MAX(ordre), 0) + 1 FROM $table");
        }
        $wpdb->insert($table, $data);
    }

    wp_safe_redirect(admin_url('admin.php?page=cdg-chiffres&cdg_saved=1'));
    exit;
}

function cdg_chiffres_delete_from_request() {
    if (!current_user_can('manage_options')) wp_die('Accès refusé.');
    $id = absint($_GET['id'] ?? 0);
    check_admin_referer('cdg_chiffre_delete_' . $id);
    global $wpdb;
    $wpdb->delete(cdg_studio_table('chiffres'), array('id' => $id));
    wp_safe_redirect(admin_url('admin.php?page=cdg-chiffres&cdg_deleted=1'));
    exit;
}

function cdg_chiffres_duplicate_from_request() {
    if (!current_user_can('manage_options')) wp_die('Accès refusé.');
    $id = absint($_GET['id'] ?? 0);
    check_admin_referer('cdg_chiffre_duplicate_' . $id);

    global $wpdb;
    $table = cdg_studio_table('chiffres');
    $item = cdg_chiffres_get($id);
    if (!$item) {
        wp_safe_redirect(admin_url('admin.php?page=cdg-chiffres&cdg_error=notfound'));
        exit;
    }

    $max_order = (int) $wpdb->get_var("SELECT COALESCE(MAX(ordre), 0) FROM $table");
    $data = array(
        'ordre' => $max_order + 1,
        'actif' => 0,
        'titre' => $item->titre . ' - copie',
        'valeur' => $item->valeur,
        'texte' => $item->texte,
        'visuel_type' => $item->visuel_type,
        'emoji' => $item->emoji,
        'dashicon' => $item->dashicon,
        'fontawesome' => $item->fontawesome,
        'image_id' => $item->image_id,
        'source_label' => $item->source_label,
        'source_url' => $item->source_url,
        'created_at' => current_time('mysql'),
        'updated_at' => current_time('mysql'),
    );
    $wpdb->insert($table, $data);

    wp_safe_redirect(admin_url('admin.php?page=cdg-chiffres&cdg_duplicated=1'));
    exit;
}

function cdg_chiffres_toggle_from_request() {
    if (!current_user_can('manage_options')) wp_die('Accès refusé.');
    $id = absint($_GET['id'] ?? 0);
    check_admin_referer('cdg_chiffre_toggle_' . $id);

    global $wpdb;
    $table = cdg_studio_table('chiffres');
    $item = cdg_chiffres_get($id);
    if ($item) {
        $wpdb->update($table, array(
            'actif' => $item->actif ? 0 : 1,
            'updated_at' => current_time('mysql'),
        ), array('id' => $id));
    }

    wp_safe_redirect(admin_url('admin.php?page=cdg-chiffres&cdg_toggled=1'));
    exit;
}

function cdg_chiffres_ajax_reorder() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Accès refusé.'), 403);
    }
    check_ajax_referer('cdg_studio_admin_nonce', 'nonce');

    $ids = isset($_POST['ids']) && is_array($_POST['ids']) ? array_map('absint', $_POST['ids']) : array();
    if (empty($ids)) {
        wp_send_json_error(array('message' => 'Aucun ordre reçu.'), 400);
    }

    global $wpdb;
    $table = cdg_studio_table('chiffres');
    foreach ($ids as $index => $id) {
        $wpdb->update($table, array(
            'ordre' => $index + 1,
            'updated_at' => current_time('mysql'),
        ), array('id' => $id));
    }

    wp_send_json_success(array('message' => 'Ordre enregistré.'));
}


function cdg_chiffres_stats() {
    global $wpdb;
    $table = cdg_studio_table('chiffres');
    $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table");
    $active = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE actif = 1");
    $last_update = $wpdb->get_var("SELECT MAX(updated_at) FROM $table");
    return array(
        'total' => $total,
        'active' => $active,
        'inactive' => max(0, $total - $active),
        'last_update' => $last_update,
        'last_update_label' => $last_update ? mysql2date('d/m/Y H:i', $last_update) : '—',
    );
}

function cdg_chiffres_export_from_request() {
    if (!current_user_can('manage_options')) wp_die('Accès refusé.');
    check_admin_referer('cdg_chiffres_export');
    $items = cdg_chiffres_all(false);
    $payload = array(
        'plugin' => 'CDG Studio',
        'version' => CDG_STUDIO_VERSION,
        'exported_at' => current_time('mysql'),
        'type' => 'chiffres',
        'items' => $items,
    );
    nocache_headers();
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="cdg-chiffres-' . date('Y-m-d-His') . '.json"');
    echo wp_json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

add_action('admin_post_cdg_chiffre_save', 'cdg_chiffres_save_from_post');
add_action('admin_post_cdg_chiffre_delete', 'cdg_chiffres_delete_from_request');
add_action('admin_post_cdg_chiffre_duplicate', 'cdg_chiffres_duplicate_from_request');
add_action('admin_post_cdg_chiffre_toggle', 'cdg_chiffres_toggle_from_request');
add_action('admin_post_cdg_chiffres_export', 'cdg_chiffres_export_from_request');
add_action('wp_ajax_cdg_chiffres_reorder', 'cdg_chiffres_ajax_reorder');
