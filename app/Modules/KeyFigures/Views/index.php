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
            <p>Gérez vos chiffres clés avec icônes, valeurs, descriptions et visibilité.</p>
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

    <div class="cdg-kf-panel">
        <h2>Ajouter un chiffre clé</h2>

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
                    <input name="unit" type="text" placeholder="+, %, €">
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

            <div class="cdg-kf-footer">
                <label class="cdg-kf-toggle">
                    <input name="is_active" type="checkbox" value="1" checked>
                    <span>Afficher</span>
                </label>

                <button type="submit" class="button button-primary">Ajouter</button>
            </div>
        </form>
    </div>

    <div class="cdg-kf-panel">
        <h2>Chiffres clés enregistrés</h2>

        <?php if (empty($figures)) : ?>
            <div class="cdg-kf-empty">Aucun chiffre clé enregistré.</div>
        <?php else : ?>
            <div class="cdg-kf-cards">
                <?php foreach ($figures as $figure) : ?>
                    <form method="post" class="cdg-kf-card">
                        <?php wp_nonce_field('cdg_key_figures_action', 'cdg_key_figures_nonce'); ?>
                        <input type="hidden" name="id" value="<?php echo esc_attr((string) $figure['id']); ?>">

                        <div class="cdg-kf-preview">
                            <div class="cdg-kf-icon">
                                <?php echo esc_html($figure['icon'] ?? '📊'); ?>
                            </div>

                            <div class="cdg-kf-preview-main">
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

                            <span class="cdg-kf-badge <?php echo ((int) $figure['is_active'] === 1) ? 'is-active' : 'is-inactive'; ?>">
                                <?php echo ((int) $figure['is_active'] === 1) ? 'Actif' : 'Inactif'; ?>
                            </span>
                        </div>

                        <div class="cdg-kf-form-grid">
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

                        <div class="cdg-kf-footer">
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
    </div>
</div>

<style>
    .cdg-kf-admin {
        max-width: 1320px;
    }

    .cdg-kf-hero {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        margin: 24px 0;
        padding: 32px;
        border-radius: 24px;
        color: #ffffff;
        background:
            radial-gradient(circle at top right, rgba(0, 173, 189, 0.58), transparent 34%),
            linear-gradient(135deg, #011031 0%, #002c73 52%, #0094aa 100%);
        box-shadow: 0 22px 55px rgba(0, 44, 115, 0.28);
    }

    .cdg-kf-label {
        display: inline-flex;
        margin-bottom: 10px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.24);
    }

    .cdg-kf-hero h1 {
        margin: 0;
        color: #ffffff;
        font-size: 34px;
        line-height: 1.15;
        font-weight: 800;
    }

    .cdg-kf-hero p {
        margin: 10px 0 0;
        color: rgba(255, 255, 255, 0.86);
        font-size: 15px;
    }

    .cdg-kf-hero-stat {
        min-width: 130px;
        padding: 22px;
        border-radius: 20px;
        text-align: center;
        background: rgba(255, 255, 255, 0.13);
        border: 1px solid rgba(255, 255, 255, 0.22);
    }

    .cdg-kf-hero-stat strong {
        display: block;
        color: #ffffff;
        font-size: 42px;
        line-height: 1;
    }

    .cdg-kf-hero-stat span {
        display: block;
        margin-top: 8px;
        color: rgba(255, 255, 255, 0.82);
    }

    .cdg-kf-panel {
        margin-bottom: 24px;
        padding: 26px;
        border-radius: 22px;
        background: #ffffff;
        border: 1px solid #dbe7ec;
        box-shadow: 0 14px 38px rgba(1, 16, 49, 0.07);
    }

    .cdg-kf-panel h2 {
        margin-top: 0;
        color: #011031;
        font-size: 22px;
        font-weight: 750;
    }

    .cdg-kf-form-grid {
        display: grid;
        grid-template-columns: 90px 1.4fr 140px 120px 120px;
        gap: 16px;
    }

    .cdg-kf-form-grid label,
    .cdg-kf-textarea {
        display: block;
    }

    .cdg-kf-form-grid span,
    .cdg-kf-textarea span {
        display: block;
        margin-bottom: 7px;
        color: #2c343e;
        font-size: 12px;
        font-weight: 700;
    }

    .cdg-kf-form-grid input,
    .cdg-kf-textarea textarea {
        width: 100%;
        max-width: none;
        min-height: 42px;
        padding: 9px 12px;
        border: 1px solid #cfdce3;
        border-radius: 12px;
        background: #ffffff;
        color: #011031;
    }

    .cdg-kf-form-grid input:focus,
    .cdg-kf-textarea textarea:focus {
        border-color: #0094aa;
        box-shadow: 0 0 0 1px #0094aa;
    }

    .cdg-kf-textarea {
        margin-top: 16px;
    }

    .cdg-kf-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-top: 18px;
    }

    .cdg-kf-toggle {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #2c343e;
        font-weight: 650;
    }

    .cdg-kf-cards {
        display: grid;
        grid-template-columns: 1fr;
        gap: 22px;
    }

    .cdg-kf-card {
        margin: 0;
        padding: 22px;
        border-radius: 22px;
        background: linear-gradient(180deg, #ffffff 0%, #f7fcfd 100%);
        border: 1px solid #dbe7ec;
        box-shadow: 0 10px 28px rgba(1, 16, 49, 0.06);
    }

    .cdg-kf-preview {
        display: grid;
        grid-template-columns: 72px 1fr auto;
        gap: 18px;
        align-items: center;
        margin-bottom: 22px;
        padding: 22px;
        border-radius: 20px;
        background:
            radial-gradient(circle at top right, rgba(0, 148, 170, 0.14), transparent 35%),
            linear-gradient(135deg, #eef8fa 0%, #ffffff 100%);
        border: 1px solid #dbe7ec;
    }

    .cdg-kf-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 62px;
        height: 62px;
        border-radius: 18px;
        background: #002c73;
        color: #ffffff;
        font-size: 28px;
        box-shadow: 0 12px 24px rgba(0, 44, 115, 0.22);
    }

    .cdg-kf-value {
        color: #011031;
        font-size: 34px;
        line-height: 1;
        font-weight: 850;
    }

    .cdg-kf-value span {
        margin-left: 3px;
        color: #0094aa;
        font-size: 24px;
    }

    .cdg-kf-title {
        margin-top: 8px;
        color: #002c73;
        font-size: 16px;
        font-weight: 800;
    }

    .cdg-kf-description {
        margin-top: 6px;
        color: #667085;
        font-size: 13px;
    }

    .cdg-kf-badge {
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .cdg-kf-badge.is-active {
        color: #137333;
        background: #e7f8ef;
    }

    .cdg-kf-badge.is-inactive {
        color: #667085;
        background: #eef2f6;
    }

    .cdg-kf-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .cdg-kf-empty {
        padding: 32px;
        border-radius: 18px;
        background: #f7fcfd;
        border: 1px dashed #b8cad3;
        color: #667085;
        text-align: center;
    }

    @media (max-width: 1200px) {
        .cdg-kf-form-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 782px) {
        .cdg-kf-hero,
        .cdg-kf-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .cdg-kf-hero-stat {
            width: 100%;
        }

        .cdg-kf-form-grid,
        .cdg-kf-preview {
            grid-template-columns: 1fr;
        }

        .cdg-kf-actions {
            width: 100%;
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>