<?php

defined('ABSPATH') || exit;

?>

<div class="wrap cdg-key-figures">
    <h1>Chiffres clÃ©s</h1>

    <?php settings_errors('cdg_key_figures'); ?>

    <div class="cdg-kf-actions">
        <a class="button button-secondary" href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=cdg-studio-key-figures&export=json'), 'cdg_key_figures_export')); ?>">
            Exporter JSON
        </a>
    </div>

    <h2>Ajouter un chiffre clÃ©</h2>

    <form method="post" enctype="multipart/form-data" class="cdg-kf-form">
        <?php wp_nonce_field('cdg_key_figures_action'); ?>
        <input type="hidden" name="action_type" value="save">

        <input type="hidden" name="id" value="">

        <table class="form-table">
            <tr>
                <th><label for="title">LibellÃ©</label></th>
                <td><input type="text" id="title" name="title" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="value">Valeur</label></th>
                <td><input type="text" id="value" name="value" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="unit">UnitÃ©</label></th>
                <td><input type="text" id="unit" name="unit" class="regular-text" placeholder="â‚¬, %, h, jours..."></td>
            </tr>
            <tr>
                <th><label for="category">CatÃ©gorie</label></th>
                <td><input type="text" id="category" name="category" class="regular-text"></td>
            </tr>
        </table>

        <?php submit_button('Ajouter le chiffre clÃ©'); ?>
    </form>

    <h2>Import JSON</h2>

    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('cdg_key_figures_action'); ?>
        <input type="hidden" name="action_type" value="import">
        <input type="file" name="json_file" accept="application/json">
        <?php submit_button('Importer JSON', 'secondary'); ?>
    </form>

    <h2>Liste des chiffres clÃ©s</h2>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>LibellÃ©</th>
                <th>Valeur</th>
                <th>UnitÃ©</th>
                <th>CatÃ©gorie</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($figures === []): ?>
                <tr>
                    <td colspan="5">Aucun chiffre clÃ© pour le moment.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($figures as $figure): ?>
                <tr>
                    <td><?php echo esc_html((string) $figure['title']); ?></td>
                    <td><?php echo esc_html((string) $figure['value']); ?></td>
                    <td><?php echo esc_html((string) $figure['unit']); ?></td>
                    <td><?php echo esc_html((string) $figure['category']); ?></td>
                    <td>
                        <form method="post">
                            <?php wp_nonce_field('cdg_key_figures_action'); ?>
                            <input type="hidden" name="action_type" value="delete">
                            <input type="hidden" name="id" value="<?php echo esc_attr((string) $figure['id']); ?>">
                            <?php submit_button('Supprimer', 'delete small', '', false); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
