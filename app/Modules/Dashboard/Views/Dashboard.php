<?php

defined('ABSPATH') || exit;

?>

<div class="wrap">
    <h1>CDG Studio</h1>

    <h2>État du Framework</h2>

    <table class="widefat striped">
        <tbody>
            <tr>
                <th>Version plugin</th>
                <td><?php echo esc_html($data['plugin_version']); ?></td>
            </tr>
            <tr>
                <th>Version base</th>
                <td><?php echo esc_html($data['db_version']); ?></td>
            </tr>
            <tr>
                <th>Modules chargés</th>
                <td><?php echo esc_html((string) $data['modules_count']); ?></td>
            </tr>
        </tbody>
    </table>

    <h2>Modules</h2>

    <ul>
        <?php foreach ($data['modules'] as $module): ?>
            <li><?php echo esc_html($module); ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Services</h2>

    <ul>
        <?php foreach ($data['services'] as $service): ?>
            <li><?php echo esc_html($service); ?></li>
        <?php endforeach; ?>
    </ul>
</div>