<?php

defined('ABSPATH') || exit;

$statusLabel = static function (string $status): string {
    return match ($status) {
        'ok' => 'OK',
        'warning' => 'Attention',
        'error' => 'Erreur',
        default => 'Inconnu',
    };
};

$statusClass = static function (string $status): string {
    return match ($status) {
        'ok' => 'cdg-status-ok',
        'warning' => 'cdg-status-warning',
        'error' => 'cdg-status-error',
        default => 'cdg-status-unknown',
    };
};

?>

<div class="wrap cdg-dashboard">
    <h1>CDG Studio</h1>

    <p class="description">
        Tableau de bord de diagnostic du Framework CDG Studio.
    </p>

    <div class="cdg-dashboard-grid">
        <div class="cdg-dashboard-card">
            <h2>Plugin</h2>
            <p class="cdg-dashboard-value">
                <?php echo esc_html($data['plugin']['version']); ?>
            </p>
            <span class="cdg-status <?php echo esc_attr($statusClass($data['plugin']['status'])); ?>">
                <?php echo esc_html($statusLabel($data['plugin']['status'])); ?>
            </span>
        </div>

        <div class="cdg-dashboard-card">
            <h2>Base de données</h2>
            <p class="cdg-dashboard-value">
                <?php echo esc_html($data['database']['version']); ?>
            </p>
            <span class="cdg-status <?php echo esc_attr($statusClass($data['database']['status'])); ?>">
                <?php echo esc_html($statusLabel($data['database']['status'])); ?>
            </span>
        </div>

        <div class="cdg-dashboard-card">
            <h2>Modules chargés</h2>
            <p class="cdg-dashboard-value">
                <?php echo esc_html((string) $data['modules']['count']); ?>
            </p>
            <span class="cdg-status <?php echo esc_attr($statusClass($data['modules']['status'])); ?>">
                <?php echo esc_html($statusLabel($data['modules']['status'])); ?>
            </span>
        </div>

        <div class="cdg-dashboard-card">
            <h2>Services cœur</h2>
            <p class="cdg-dashboard-value">
                <?php echo esc_html((string) count($data['services']['items'])); ?>
            </p>
            <span class="cdg-status <?php echo esc_attr($statusClass($data['services']['status'])); ?>">
                <?php echo esc_html($statusLabel($data['services']['status'])); ?>
            </span>
        </div>
    </div>

    <h2>Modules actifs</h2>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>Module</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['modules']['items'] as $module): ?>
                <tr>
                    <td><code><?php echo esc_html($module); ?></code></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Services enregistrés</h2>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>Service</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['services']['items'] as $serviceId => $service): ?>
                <tr>
                    <td><code><?php echo esc_html($serviceId); ?></code></td>
                    <td>
                        <?php if ($service['available']): ?>
                            <span class="cdg-status cdg-status-ok">Disponible</span>
                        <?php else: ?>
                            <span class="cdg-status cdg-status-error">Indisponible</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    .cdg-dashboard .description {
        margin-bottom: 20px;
    }

    .cdg-dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(160px, 1fr));
        gap: 16px;
        margin: 20px 0 30px;
    }

    .cdg-dashboard-card {
        background: #fff;
        border: 1px solid #dcdcde;
        border-radius: 8px;
        padding: 18px;
    }

    .cdg-dashboard-card h2 {
        margin-top: 0;
        font-size: 14px;
        color: #50575e;
    }

    .cdg-dashboard-value {
        font-size: 28px;
        font-weight: 600;
        margin: 8px 0 12px;
    }

    .cdg-status {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .cdg-status-ok {
        background: #edfaef;
        color: #007017;
    }

    .cdg-status-warning {
        background: #fff8e5;
        color: #996800;
    }

    .cdg-status-error {
        background: #fcf0f1;
        color: #b32d2e;
    }

    .cdg-status-unknown {
        background: #f0f0f1;
        color: #50575e;
    }

    @media (max-width: 1200px) {
        .cdg-dashboard-grid {
            grid-template-columns: repeat(2, minmax(160px, 1fr));
        }
    }

    @media (max-width: 782px) {
        .cdg-dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>