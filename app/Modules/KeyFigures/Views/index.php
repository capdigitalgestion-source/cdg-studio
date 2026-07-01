<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$message = sanitize_text_field($_GET['message'] ?? '');
?>

<div class="wrap cdg-key-figures-admin">
    <div class="cdg-kf-header">
        <div>
            <p class="cdg-kf-eyebrow">CDG Studio</p>
            <h1>Key Figures</h1>
            <p class="cdg-kf-subtitle">
                Gérez les chiffres clés affichés par le module.
            </p>
        </div>

        <div class="cdg-kf-count">
            <span><?php echo esc_html((string) count($figures)); ?></span>
            <small>élément(s)</small>
        </div>
    </div>

    <?php if ($message === 'created') : ?>
        <div class="notice notice-success is-dismissible"><p>Chiffre clé ajouté.</p></div>
    <?php elseif ($message === 'updated') : ?>
        <div class="notice notice-success is-dismissible"><p>Chiffre clé mis à jour.</p></div>
    <?php elseif ($message === 'deleted') : ?>
        <div class="notice notice-success is-dismissible"><p>Chiffre clé supprimé.</p></div>
    <?php endif; ?>

    <div class="cdg-kf-layout">
        <section class="cdg-kf-panel cdg-kf-panel-form">
            <h2>Ajouter un chiffre clé</h2>
            <p class="cdg-kf-help">
                Créez une nouvelle donnée métier : valeur, unité, description et ordre d’affichage.
            </p>

            <form method="post" class="cdg-kf-form">
                <?php wp_nonce_field('cdg_key_figures_action', 'cdg_key_figures_nonce'); ?>
                <input type="hidden" name="cdg_action" value="create">

                <div class="cdg-kf-grid">
                    <label>
                        <span>Titre</span>
                        <input name="title" type="text" required>
                    </label>

                    <label>
                        <span>Valeur</span>
                        <input name="value" type="text" required>
                    </label>

                    <label>
                        <span>Unité</span>
                        <input name="unit" type="text" placeholder="+, %, €, jours...">
                    </label>

                    <label>
                        <span>Position</span>
                        <input name="position" type="number" min="0" value="0">
                    </label>
                </div>

                <label class="cdg-kf-full">
                    <span>Description</span>
                    <textarea name="description" rows="3"></textarea>
                </label>

                <label class="cdg-kf-checkbox">
                    <input name="is_active" type="checkbox" value="1" checked>
                    <span>Afficher ce chiffre clé</span>
                </label>

                <button type="submit" class="button button-primary cdg-kf-primary">
                    Ajouter
                </button>
            </form>
        </section>

        <section class="cdg-kf-panel">
            <div class="cdg-kf-section-title">
                <div>
                    <h2>Chiffres clés enregistrés</h2>
                    <p class="cdg-kf-help">
                        Modifiez, activez, désactivez ou supprimez les éléments existants.
                    </p>
                </div>
            </div>

            <?php if (empty($figures)) : ?>
                <div class="cdg-kf-empty">
                    Aucun chiffre clé enregistré.
                </div>
            <?php else : ?>
                <div class="cdg-kf-cards">
                    <?php foreach ($figures as $figure) : ?>
                        <form method="post" class="cdg-kf-card">
                            <?php wp_nonce_field('cdg_key_figures_action', 'cdg_key_figures_nonce'); ?>

                            <input type="hidden" name="id" value="<?php echo esc_attr((string) $figure['id']); ?>">

                            <div class="cdg-kf-card-top">
                                <div>
                                    <span class="cdg-kf-id">#<?php echo esc_html((string) $figure['id']); ?></span>
                                    <?php if ((int) $figure['is_active'] === 1) : ?>
                                        <span class="cdg-kf-badge is-active">Actif</span>
                                    <?php else : ?>
                                        <span class="cdg-kf-badge is-inactive">Inactif</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="cdg-kf-grid">
                                <label>
                                    <span>Titre</span>
                                    <input name="title" type="text" value="<?php echo esc_attr($figure['title']); ?>" required>
                                </label>

                                <label>
                                    <span>Valeur</span>
                                    <input name="value" type="text" value="<?php echo esc_attr($figure['value']); ?>" required>
                                </label>

                                <label>
                                    <span>Unité</span>
                                    <input name="unit" type="text" value="<?php echo esc_attr($figure['unit'] ?? ''); ?>">
                                </label>

                                <label>
                                    <span>Position</span>
                                    <input name="position" type="number" min="0" value="<?php echo esc_attr((string) $figure['position']); ?>">
                                </label>
                            </div>

                            <label class="cdg-kf-full">
                                <span>Description</span>
                                <textarea name="description" rows="3"><?php echo esc_textarea($figure['description'] ?? ''); ?></textarea>
                            </label>

                            <div class="cdg-kf-card-actions">
                                <label class="cdg-kf-checkbox">
                                    <input name="is_active" type="checkbox" value="1" <?php checked((int) $figure['is_active'], 1); ?>>
                                    <span>Afficher</span>
                                </label>

                                <div>
                                    <button type="submit" name="cdg_action" value="update" class="button button-primary">
                                        Enregistrer
                                    </button>

                                    <button
                                        type="submit"
                                        name="cdg_action"
                                        value="delete"
                                        class="button button-link-delete"
                                        onclick="return confirm('Supprimer ce chiffre clé ?');"
                                    >
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>