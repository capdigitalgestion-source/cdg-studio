<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$message = sanitize_text_field($_GET['message'] ?? '');
?>

<div class="wrap">
    <h1>Key Figures</h1>

    <?php if ($message === 'created') : ?>
        <div class="notice notice-success is-dismissible"><p>Chiffre clé ajouté.</p></div>
    <?php elseif ($message === 'updated') : ?>
        <div class="notice notice-success is-dismissible"><p>Chiffre clé mis à jour.</p></div>
    <?php elseif ($message === 'deleted') : ?>
        <div class="notice notice-success is-dismissible"><p>Chiffre clé supprimé.</p></div>
    <?php endif; ?>

    <h2>Ajouter un chiffre clé</h2>

    <form method="post">
        <?php wp_nonce_field('cdg_key_figures_action', 'cdg_key_figures_nonce'); ?>
        <input type="hidden" name="cdg_action" value="create">

        <table class="form-table" role="presentation">
            <tr>
                <th><label for="title">Titre</label></th>
                <td><input name="title" id="title" type="text" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="value">Valeur</label></th>
                <td><input name="value" id="value" type="text" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="unit">Unité</label></th>
                <td><input name="unit" id="unit" type="text" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="description">Description</label></th>
                <td><textarea name="description" id="description" class="large-text" rows="3"></textarea></td>
            </tr>
            <tr>
                <th><label for="position">Position</label></th>
                <td><input name="position" id="position" type="number" min="0" value="0"></td>
            </tr>
            <tr>
                <th>Actif</th>
                <td><label><input name="is_active" type="checkbox" value="1" checked> Afficher</label></td>
            </tr>
        </table>

        <?php submit_button('Ajouter'); ?>
    </form>

    <hr>

    <h2>Chiffres clés enregistrés</h2>

    <table class="widefat striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Valeur</th>
                <th>Unité</th>
                <th>Description</th>
                <th>Position</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($figures)) : ?>
            <tr>
                <td colspan="8">Aucun chiffre clé enregistré.</td>
            </tr>
        <?php else : ?>
            <?php foreach ($figures as $figure) : ?>
                <tr>
                    <form method="post">
                        <?php wp_nonce_field('cdg_key_figures_action', 'cdg_key_figures_nonce'); ?>
                        <input type="hidden" name="id" value="<?php echo esc_attr((string) $figure['id']); ?>">

                        <td><?php echo esc_html((string) $figure['id']); ?></td>
                        <td><input name="title" type="text" value="<?php echo esc_attr($figure['title']); ?>" required></td>
                        <td><input name="value" type="text" value="<?php echo esc_attr($figure['value']); ?>" required></td>
                        <td><input name="unit" type="text" value="<?php echo esc_attr($figure['unit'] ?? ''); ?>"></td>
                        <td><textarea name="description" rows="2"><?php echo esc_textarea($figure['description'] ?? ''); ?></textarea></td>
                        <td><input name="position" type="number" min="0" value="<?php echo esc_attr((string) $figure['position']); ?>"></td>
                        <td>
                            <input name="is_active" type="checkbox" value="1" <?php checked((int) $figure['is_active'], 1); ?>>
                        </td>
                        <td>
                            <button type="submit" name="cdg_action" value="update" class="button button-primary">
                                Enregistrer
                            </button>

                            <button type="submit" name="cdg_action" value="delete" class="button button-link-delete" onclick="return confirm('Supprimer ce chiffre clé ?');">
                                Supprimer
                            </button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>