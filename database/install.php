<?php
if (!defined('ABSPATH')) exit;

function cdg_studio_install_database() {
    global $wpdb;

    $table = cdg_studio_table('chiffres');
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        ordre int(11) NOT NULL DEFAULT 0,
        actif tinyint(1) NOT NULL DEFAULT 1,
        titre varchar(255) NOT NULL DEFAULT '',
        valeur varchar(100) NOT NULL DEFAULT '',
        texte text NOT NULL,
        visuel_type varchar(50) NOT NULL DEFAULT 'emoji',
        emoji varchar(50) DEFAULT '',
        dashicon varchar(100) DEFAULT '',
        fontawesome varchar(120) DEFAULT '',
        image_id bigint(20) DEFAULT NULL,
        source_label varchar(255) DEFAULT '',
        source_url text DEFAULT '',
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);

    $count = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table");

    if ($count === 0) {
        $defaults = array(
            array(1, 1, 'Facturation électronique', '4 M', 'd’entreprises concernées', 'emoji', '🏢', 'Source officielle', 'https://www.economie.gouv.fr/actualites/generalisation-de-la-facturation-electronique-pour-les-entreprises-devenez-pilote-de'),
            array(2, 1, 'Flux de factures', '2 Md', 'de factures échangées chaque année', 'emoji', '📄', 'Source officielle', 'https://presse.economie.gouv.fr/19042023-cp-facturation-electronique-lancement-dun-pilote-et-dun-appel-a-candidatures/'),
            array(3, 1, 'Calendrier officiel', '2026', 'réception obligatoire des factures électroniques', 'emoji', '📅', 'Service Public', 'https://entreprendre.service-public.gouv.fr/actualites/A18759'),
            array(4, 1, 'TPE / PME', '2027', 'émission obligatoire des factures électroniques', 'emoji', '🚀', 'Service Public', 'https://entreprendre.service-public.gouv.fr/actualites/A18759'),
        );

        foreach ($defaults as $item) {
            $wpdb->insert($table, array(
                'ordre' => $item[0],
                'actif' => $item[1],
                'titre' => $item[2],
                'valeur' => $item[3],
                'texte' => $item[4],
                'visuel_type' => $item[5],
                'emoji' => $item[6],
                'source_label' => $item[7],
                'source_url' => $item[8],
            ));
        }
    }

    update_option('cdg_studio_db_version', CDG_STUDIO_DB_VERSION);
}
