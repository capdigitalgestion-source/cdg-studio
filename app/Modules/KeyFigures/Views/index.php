<?php

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Variables disponibles :
 *
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
                <th>Libellé</th>
                <th>Valeur</th>
                <th>Visible</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($figures as $figure) : ?>
                <tr>
                    <td><?php echo esc_html((string) ($figure['label'] ?? '')); ?></td>
                    <td><?php echo esc_html((string) ($figure['value'] ?? '')); ?></td>
                    <td><?php echo ! empty($figure['visible']) ? 'Oui' : 'Non'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>