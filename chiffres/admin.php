<?php
if (!defined('ABSPATH')) exit;

function cdg_studio_chiffres_page() {
    $edit_id = isset($_GET['edit']) ? absint($_GET['edit']) : 0;
    $item = $edit_id ? cdg_chiffres_get($edit_id) : null;

    if (isset($_GET['new'])) {
        $item = (object) array(
            'id' => 0, 'ordre' => 0, 'actif' => 1, 'titre' => '', 'valeur' => '', 'texte' => '',
            'visuel_type' => 'emoji', 'emoji' => '', 'dashicon' => '', 'fontawesome' => '', 'image_id' => '',
            'source_label' => '', 'source_url' => ''
        );
    }

    $items = cdg_chiffres_all(false);
    $stats = cdg_chiffres_stats();
    ?>
    <div class="wrap cdg-admin-wrap cdg-chiffres-admin">
        <div class="cdg-page-header cdg-page-header-v2">
            <div>
                <h1>Chiffres clés</h1>
                <p>Gérez les chiffres clés affichables dans le carrousel CDG.</p>
            </div>
            <div class="cdg-header-actions">
                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=cdg_chiffres_export'), 'cdg_chiffres_export')); ?>" class="button">Exporter JSON</a>
                <a href="<?php echo esc_url(admin_url('admin.php?page=cdg-chiffres&new=1')); ?>" class="button button-primary cdg-primary-action">+ Nouveau chiffre</a>
            </div>
        </div>

        <?php cdg_studio_chiffres_notices(); ?>

        <div class="cdg-module-stats">
            <div><strong><?php echo esc_html($stats['total']); ?></strong><span>Total</span></div>
            <div><strong><?php echo esc_html($stats['active']); ?></strong><span>Visibles</span></div>
            <div><strong><?php echo esc_html($stats['inactive']); ?></strong><span>Masqués</span></div>
            <div><strong><?php echo esc_html($stats['last_update_label']); ?></strong><span>Dernière modification</span></div>
        </div>

        <div class="cdg-toolbar">
            <label class="cdg-search-wrap" for="cdg-chiffres-search">
                <span>Recherche</span>
                <input id="cdg-chiffres-search" type="search" placeholder="Rechercher un chiffre clé..." data-cdg-search>
            </label>

            <label class="cdg-checkbox-filter">
                <input type="checkbox" data-cdg-visible-only>
                <span>Visible uniquement</span>
            </label>

            <div class="cdg-shortcode-box">
                <span>Utilisation</span>
                <code id="cdg-shortcode-value">[cdg_chiffres_carrousel]</code>
                <button type="button" class="button cdg-copy-shortcode" data-copy-target="cdg-shortcode-value">Copier</button>
                <button type="button" class="button" data-cdg-open-preview>Prévisualiser</button>
            </div>
        </div>

        <?php if ($item) : cdg_studio_chiffre_form($item); endif; ?>

        <div class="cdg-list" id="cdg-chiffres-list" data-reorder="1">
            <?php foreach ($items as $row) : ?>
                <div class="cdg-list-row" data-id="<?php echo esc_attr($row->id); ?>" data-active="<?php echo esc_attr($row->actif ? '1' : '0'); ?>" data-search="<?php echo esc_attr(strtolower($row->titre . ' ' . $row->valeur . ' ' . $row->source_label)); ?>">
                    <div class="cdg-handle" title="Déplacer">☰</div>
                    <div class="cdg-list-visual"><?php echo cdg_studio_chiffre_visual_html($row); ?></div>
                    <div class="cdg-list-main">
                        <strong><?php echo esc_html($row->titre); ?></strong>
                        <span><?php echo esc_html($row->valeur); ?> · <?php echo esc_html($row->source_label ?: 'Source non renseignée'); ?></span>
                    </div>
                    <a class="cdg-switch-link <?php echo $row->actif ? 'is-on' : 'is-off'; ?>" title="Afficher / masquer" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=cdg_chiffre_toggle&id=' . absint($row->id)), 'cdg_chiffre_toggle_' . absint($row->id))); ?>">
                        <span class="cdg-switch-dot"></span>
                        <span class="cdg-switch-text"><?php echo $row->actif ? 'ON' : 'OFF'; ?></span>
                    </a>
                    <div class="cdg-actions cdg-icon-actions">
                        <a class="button cdg-icon-button" title="Modifier" href="<?php echo esc_url(admin_url('admin.php?page=cdg-chiffres&edit=' . absint($row->id))); ?>">✏️</a>
                        <a class="button cdg-icon-button" title="Dupliquer" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=cdg_chiffre_duplicate&id=' . absint($row->id)), 'cdg_chiffre_duplicate_' . absint($row->id))); ?>">📄</a>
                        <a class="button cdg-icon-button cdg-danger" title="Supprimer" onclick="return confirm('Supprimer ce chiffre clé ?');" href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=cdg_chiffre_delete&id=' . absint($row->id)), 'cdg_chiffre_delete_' . absint($row->id))); ?>">🗑️</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cdg-list-empty" data-cdg-empty hidden>Aucun chiffre clé ne correspond à votre recherche.</div>

        <?php cdg_studio_chiffres_preview_modal($items); ?>
    </div>
    <?php
}

function cdg_studio_chiffres_notices() {
    if (isset($_GET['cdg_saved'])) : ?><div class="notice notice-success is-dismissible"><p>Chiffre clé enregistré.</p></div><?php endif;
    if (isset($_GET['cdg_deleted'])) : ?><div class="notice notice-success is-dismissible"><p>Chiffre clé supprimé.</p></div><?php endif;
    if (isset($_GET['cdg_duplicated'])) : ?><div class="notice notice-success is-dismissible"><p>Chiffre clé dupliqué. La copie est masquée par défaut.</p></div><?php endif;
    if (isset($_GET['cdg_toggled'])) : ?><div class="notice notice-success is-dismissible"><p>Visibilité modifiée.</p></div><?php endif;
}

function cdg_studio_chiffre_form($item) {
    $image_url = !empty($item->image_id) ? wp_get_attachment_image_url($item->image_id, 'thumbnail') : '';
    $quick_icons = array('🏢','📄','📅','🚀','📊','🧾','💶','⚙️','💡','🤝','🔐','📂');
    $dashicons = array('dashicons-building','dashicons-media-document','dashicons-calendar-alt','dashicons-chart-line','dashicons-chart-bar','dashicons-admin-tools','dashicons-lightbulb','dashicons-businessperson','dashicons-shield','dashicons-portfolio');
    ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="cdg-editor cdg-editor-panel">
        <input type="hidden" name="action" value="cdg_chiffre_save">
        <input type="hidden" name="id" value="<?php echo esc_attr($item->id); ?>">
        <?php wp_nonce_field('cdg_chiffre_save'); ?>

        <div class="cdg-editor-fields">
            <div class="cdg-editor-titlebar">
                <h2><?php echo $item->id ? 'Modifier le chiffre clé' : 'Nouveau chiffre clé'; ?></h2>
                <a class="button" href="<?php echo esc_url(admin_url('admin.php?page=cdg-chiffres')); ?>">Fermer</a>
            </div>

            <div class="cdg-editor-tabs" role="tablist">
                <button type="button" class="is-active" data-cdg-tab="general">Général</button>
                <button type="button" data-cdg-tab="visual">Visuel</button>
                <button type="button" data-cdg-tab="source">Source</button>
                <button type="button" data-cdg-tab="advanced">Avancé</button>
            </div>

            <section class="cdg-panel-section is-active" data-cdg-panel="general">
                <h3>Général</h3>
                <label class="cdg-inline-check"><input type="checkbox" name="actif" value="1" <?php checked($item->actif, 1); ?>> Visible</label>
                <label>Ordre <input type="number" name="ordre" value="<?php echo esc_attr($item->ordre); ?>" data-preview-source="order"></label>
                <label>Titre <input type="text" name="titre" value="<?php echo esc_attr($item->titre); ?>" required data-preview-source="titre"></label>
                <label>Valeur <input type="text" name="valeur" value="<?php echo esc_attr($item->valeur); ?>" required data-preview-source="valeur"></label>
                <label>Texte <textarea name="texte" rows="3" data-preview-source="texte"><?php echo esc_textarea($item->texte); ?></textarea></label>
            </section>

            <section class="cdg-panel-section" data-cdg-panel="visual">
                <h3>Visuel</h3>
                <label>Type
                    <select name="visuel_type" class="cdg-visual-type" data-preview-source="visuel_type">
                        <option value="none" <?php selected($item->visuel_type, 'none'); ?>>Aucun</option>
                        <option value="emoji" <?php selected($item->visuel_type, 'emoji'); ?>>Emoji</option>
                        <option value="dashicon" <?php selected($item->visuel_type, 'dashicon'); ?>>Dashicon WordPress</option>
                        <option value="fontawesome" <?php selected($item->visuel_type, 'fontawesome'); ?>>Font Awesome</option>
                        <option value="image" <?php selected($item->visuel_type, 'image'); ?>>Image</option>
                    </select>
                </label>

                <div class="cdg-icon-library">
                    <strong>Icônes rapides</strong>
                    <div class="cdg-icon-picks">
                        <?php foreach ($quick_icons as $icon) : ?>
                            <button type="button" data-cdg-pick-emoji="<?php echo esc_attr($icon); ?>"><?php echo esc_html($icon); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <strong>Dashicons rapides</strong>
                    <div class="cdg-icon-picks cdg-dashicon-picks">
                        <?php foreach ($dashicons as $icon) : ?>
                            <button type="button" data-cdg-pick-dashicon="<?php echo esc_attr($icon); ?>"><span class="dashicons <?php echo esc_attr($icon); ?>"></span></button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <label>Emoji <input type="text" name="emoji" value="<?php echo esc_attr($item->emoji); ?>" placeholder="🏢" data-preview-source="emoji"></label>
                <label>Dashicon <input type="text" name="dashicon" value="<?php echo esc_attr($item->dashicon); ?>" placeholder="dashicons-building" data-preview-source="dashicon"></label>
                <label>Font Awesome <input type="text" name="fontawesome" value="<?php echo esc_attr($item->fontawesome); ?>" placeholder="fa-solid fa-chart-line" data-preview-source="fontawesome"></label>
                <div class="cdg-image-field">
                    <input type="hidden" name="image_id" class="cdg-image-id" value="<?php echo esc_attr($item->image_id); ?>">
                    <button type="button" class="button cdg-select-image">Choisir une image</button>
                    <button type="button" class="button cdg-remove-image">Retirer</button>
                    <div class="cdg-image-preview"><?php if ($image_url) : ?><img src="<?php echo esc_url($image_url); ?>" alt=""><?php endif; ?></div>
                </div>
            </section>

            <section class="cdg-panel-section" data-cdg-panel="source">
                <h3>Source</h3>
                <label>Nom de la source <input type="text" name="source_label" value="<?php echo esc_attr($item->source_label); ?>" data-preview-source="source_label"></label>
                <label>URL source <input type="url" name="source_url" value="<?php echo esc_attr($item->source_url); ?>"></label>
            </section>

            <section class="cdg-panel-section" data-cdg-panel="advanced">
                <h3>Avancé</h3>
                <p class="description">Les réglages d'apparence et d'animation seront ajoutés dans la version 0.8.</p>
                <p class="description">ID interne : <strong><?php echo esc_html($item->id ?: 'nouveau'); ?></strong></p>
            </section>

            <p><button class="button button-primary button-large" type="submit">Enregistrer</button></p>
        </div>

        <div class="cdg-editor-preview">
            <div class="cdg-preview-toolbar">
                <h2>Aperçu</h2>
                <div class="cdg-device-buttons">
                    <button type="button" class="is-active" data-cdg-device="desktop">Desktop</button>
                    <button type="button" data-cdg-device="tablet">Tablette</button>
                    <button type="button" data-cdg-device="mobile">Mobile</button>
                </div>
            </div>
            <div class="cdg-preview-frame is-desktop" data-cdg-preview-frame>
                <?php echo cdg_studio_chiffre_card_html($item); ?>
            </div>
        </div>
    </form>
    <?php
}

function cdg_studio_chiffre_visual_html($item) {
    if ($item->visuel_type === 'image' && !empty($item->image_id)) {
        return wp_get_attachment_image($item->image_id, 'thumbnail');
    }
    if ($item->visuel_type === 'dashicon' && !empty($item->dashicon)) {
        return '<span class="dashicons ' . esc_attr($item->dashicon) . '"></span>';
    }
    if ($item->visuel_type === 'fontawesome' && !empty($item->fontawesome)) {
        return '<i class="' . esc_attr($item->fontawesome) . '"></i>';
    }
    if ($item->visuel_type === 'emoji') {
        return esc_html($item->emoji);
    }
    return '';
}

function cdg_studio_chiffre_card_html($item) {
    ob_start();
    ?>
    <article class="cdg-preview-card" data-cdg-preview-card>
        <div class="cdg-preview-icon" data-preview-target="visual"><?php echo cdg_studio_chiffre_visual_html($item); ?></div>
        <div class="cdg-preview-theme" data-preview-target="titre"><?php echo esc_html($item->titre); ?></div>
        <div class="cdg-preview-value" data-preview-target="valeur"><?php echo esc_html($item->valeur); ?></div>
        <div class="cdg-preview-text" data-preview-target="texte"><?php echo esc_html($item->texte); ?></div>
        <?php if (!empty($item->source_url)) : ?><a href="<?php echo esc_url($item->source_url); ?>" target="_blank" rel="noopener" data-preview-target="source_label"><?php echo esc_html($item->source_label ?: 'Source'); ?> →</a><?php endif; ?>
        <?php if (empty($item->source_url)) : ?><span class="cdg-preview-source-muted" data-preview-target="source_label"><?php echo esc_html($item->source_label ?: 'Source'); ?> →</span><?php endif; ?>
    </article>
    <?php
    return ob_get_clean();
}

function cdg_studio_chiffres_preview_modal($items) {
    ?>
    <div class="cdg-modal" data-cdg-preview-modal hidden>
        <div class="cdg-modal-backdrop" data-cdg-close-preview></div>
        <div class="cdg-modal-content" role="dialog" aria-modal="true" aria-label="Prévisualisation du carrousel">
            <div class="cdg-modal-header">
                <h2>Prévisualisation du carrousel</h2>
                <button type="button" class="button" data-cdg-close-preview>Fermer</button>
            </div>
            <div class="cdg-modal-devices cdg-device-buttons">
                <button type="button" class="is-active" data-cdg-modal-device="desktop">Desktop</button>
                <button type="button" data-cdg-modal-device="tablet">Tablette</button>
                <button type="button" data-cdg-modal-device="mobile">Mobile</button>
            </div>
            <div class="cdg-modal-preview is-desktop" data-cdg-modal-frame>
                <div class="cdg-admin-carousel" data-cdg-admin-carousel data-autoplay="1" data-interval="3500">
                    <button type="button" class="cdg-admin-carousel-arrow cdg-admin-carousel-prev" aria-label="Précédent">‹</button>
                    <div class="cdg-admin-carousel-viewport">
                        <div class="cdg-admin-carousel-track">
                            <?php foreach ($items as $row) : if (!$row->actif) continue; ?>
                                <div class="cdg-admin-carousel-slide">
                                    <?php echo cdg_studio_chiffre_card_html($row); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <button type="button" class="cdg-admin-carousel-arrow cdg-admin-carousel-next" aria-label="Suivant">›</button>
                    <div class="cdg-admin-carousel-dots" aria-label="Navigation du carrousel"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
