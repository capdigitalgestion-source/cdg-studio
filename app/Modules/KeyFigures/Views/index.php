<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * @var array<int, array<string, mixed>> $figures
 * @var int $total
 * @var int $visible
 * @var int $hidden
 */
?>

<div class="wrap">
    <h1>Chiffres clés</h1>

    <p>Module KeyFigures chargé avec succès.</p>

    <hr>

    <h2>Résumé</h2>

    <ul>
        <li><strong>Total :</strong> <?php echo esc_html((string) $total); ?></li>
        <li><strong>Visibles :</strong> <?php echo esc_html((string) $visible); ?></li>
        <li><strong>Masqués :</strong> <?php echo esc_html((string) $hidden); ?></li>
    </ul>

    <h2>Liste temporaire</h2>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Icône</th>
                <th>Libellé</th>
                <th>Valeur</th>
                <th>Couleur</th>
                <th>Animation</th>
                <th>Visible</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($figures as $figure) : ?>
                <tr>
                    <td><?php echo esc_html((string) ($figure['display_order'] ?? '')); ?></td>
                    <td>
                        <span class="dashicons <?php echo esc_attr((string) ($figure['icon'] ?? '')); ?>"></span>
                    </td>
                    <td><?php echo esc_html((string) ($figure['label'] ?? '')); ?></td>
                    <td>
                        <?php echo esc_html((string) ($figure['value'] ?? '')); ?>
                        <?php echo esc_html((string) ($figure['suffix'] ?? '')); ?>
                    </td>
                    <td>
                        <code><?php echo esc_html((string) ($figure['color'] ?? '')); ?></code>
                    </td>
                    <td><?php echo esc_html((string) ($figure['animation'] ?? '')); ?></td>
                    <td><?php echo ! empty($figure['is_visible']) ? 'Oui' : 'Non'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>