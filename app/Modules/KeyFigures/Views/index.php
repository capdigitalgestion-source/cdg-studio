<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$message = sanitize_text_field($_GET['message'] ?? '');
?>

<div class="wrap cdg-kf-admin">
    <div class="cdg-kf-hero">
        <div>
            <span class="cdg-kf-label">CDG Studio</span>
            <h1>Key Figures</h1>
            <p>Gérez les chiffres clés, icônes et indicateurs affichés dans vos interfaces.</p>
        </div>

        <div class="cdg-kf-hero-stat">
            <strong><?php echo esc_html((string) count($figures)); ?></strong>
            <span>chiffre(s)</span>
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
        <section class="cdg-kf-panel">
            <div class="cdg-kf-panel-header">
                <div>
                    <h2>Ajouter un chiffre clé</h2>
                    <p>Ajoutez un indicateur avec son icône, sa valeur et son ordre d’affichage.</p>
                </div>
            </div>

            <form method="post" class="cdg-kf-form">
                <?php wp_nonce_field('cdg_key_figures_action', 'cdg_key_figures_nonce'); ?>
                <input type="hidden" name="cdg_action" value="create">

                <div class="cdg-kf-form-grid">
                    <label>
                        <span>Icône</span>
                        <input name="icon" type="text" placeholder="📊">
                    </label>

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
                        <input name="unit" type="text" placeholder="+, %, €, jours">
                    </label>

                    <label>
                        <span>Position</span>
                        <input name="position" type="number" min="0" value="0">
                    </label>
                </div>

                <label class="cdg-kf-textarea">
                    <span>Description</span>
                    <textarea name="description" rows="3"></textarea>
                </label>

                <div class="cdg-kf-form-footer">
                    <label class="cdg-kf-toggle">
                        <input name="is_active" type="checkbox" value="1" checked>
                        <span>Afficher ce chiffre clé</span>
                    </label>

                    <button type="submit" class="button button-primary cdg-kf-button-primary">
                        Ajouter
                    </button>
                </div>
            </form>
        </section>

        <section class="cdg-kf-panel">
            <div class="cdg-kf-panel-header">
                <div>
                    <h2>Chiffres clés enregistrés</h2>
                    <p>Chaque chiffre est présenté sous forme de carte éditable.</p>
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

                            <div class="cdg-kf-card-preview">
                                <div class="cdg-kf-icon">
                                    <?php echo esc_html($figure['icon'] ?? '📊'); ?>
                                </div>

                                <div>
                                    <div class="cdg-kf-value">
                                        <?php echo esc_html($figure['value']); ?><span><?php echo esc_html($figure['unit'] ?? ''); ?></span>
                                    </div>
                                    <div class="cdg-kf-title">
                                        <?php echo esc_html($figure['title']); ?>
                                    </div>
                                    <div class="cdg-kf-description">
                                        <?php echo esc_html($figure['description'] ?? ''); ?>
                                    </div>
                                </div>

                                <div class="cdg-kf-status <?php echo ((int) $figure['is_active'] === 1) ? 'is-active' : 'is-inactive'; ?>">
                                    <?php echo ((int) $figure['is_active'] === 1) ? 'Actif' : 'Inactif'; ?>
                                </div>
                            </div>

                            <div class="cdg-kf-edit-grid">
                                <label>
                                    <span>Icône</span>
                                    <input name="icon" type="text" value="<?php echo esc_attr($figure['icon'] ?? ''); ?>">
                                </label>

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

                            <label class="cdg-kf-textarea">
                                <span>Description</span>
                                <textarea name="description" rows="3"><?php echo esc_textarea($figure['description'] ?? ''); ?></textarea>
                            </label>

                            <div class="cdg-kf-card-footer">
                                <label class="cdg-kf-toggle">
                                    <input name="is_active" type="checkbox" value="1" <?php checked((int) $figure['is_active'], 1); ?>>
                                    <span>Afficher</span>
                                </label>

                                <div class="cdg-kf-actions">
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