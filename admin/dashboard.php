<?php
if (!defined('ABSPATH')) exit;

function cdg_studio_dashboard_page() {
    $stats = cdg_chiffres_stats();
    ?>
    <div class="wrap cdg-admin-wrap cdg-dashboard">
        <div class="cdg-page-header cdg-page-header-v2">
            <div>
                <h1>CDG Studio</h1>
                <p>Le cockpit d'administration de Cap Digital Gestion.</p>
            </div>
            <span class="cdg-version-badge">v<?php echo esc_html(CDG_STUDIO_VERSION); ?></span>
        </div>

        <div class="cdg-dashboard-grid">
            <div class="cdg-dashboard-tile">
                <span class="cdg-tile-icon">📊</span>
                <strong><?php echo esc_html($stats['total']); ?></strong>
                <span>Chiffres clés</span>
            </div>
            <div class="cdg-dashboard-tile">
                <span class="cdg-tile-icon">👁️</span>
                <strong><?php echo esc_html($stats['active']); ?></strong>
                <span>Visibles</span>
            </div>
            <div class="cdg-dashboard-tile">
                <span class="cdg-tile-icon">🙈</span>
                <strong><?php echo esc_html($stats['inactive']); ?></strong>
                <span>Masqués</span>
            </div>
            <div class="cdg-dashboard-tile">
                <span class="cdg-tile-icon">🕒</span>
                <strong><?php echo esc_html($stats['last_update_label']); ?></strong>
                <span>Dernière modification</span>
            </div>
        </div>

        <div class="cdg-dashboard-card cdg-dashboard-wide">
            <h2>Module actif : Chiffres clés</h2>
            <p>La version 0.8.0 ajoute le moteur de carrousel responsive, l’export JSON et l’aperçu amélioré.</p>
            <p><a class="button button-primary" href="<?php echo esc_url(admin_url('admin.php?page=cdg-chiffres')); ?>">Gérer les chiffres clés</a></p>
        </div>
    </div>
    <?php
}
