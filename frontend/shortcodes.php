<?php
if (!defined('ABSPATH')) exit;

add_shortcode('cdg_chiffres_carrousel', 'cdg_shortcode_chiffres_carrousel');

function cdg_shortcode_chiffres_carrousel() {
    $items = cdg_chiffres_all(true);
    if (empty($items)) return '';

    ob_start();
    ?>
    <section class="cdg-front-carousel" data-cdg-carousel data-autoplay="1" data-interval="5000">
        <button type="button" class="cdg-front-prev" aria-label="Précédent">‹</button>
        <div class="cdg-front-viewport">
            <div class="cdg-front-track">
                <?php foreach ($items as $item) : ?>
                    <article class="cdg-front-card">
                        <div class="cdg-front-icon"><?php echo cdg_studio_chiffre_visual_html($item); ?></div>
                        <div class="cdg-front-theme"><?php echo esc_html($item->titre); ?></div>
                        <div class="cdg-front-value"><?php echo esc_html($item->valeur); ?></div>
                        <div class="cdg-front-text"><?php echo esc_html($item->texte); ?></div>
                        <?php if (!empty($item->source_url)) : ?><a class="cdg-front-source" href="<?php echo esc_url($item->source_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($item->source_label ?: 'Source'); ?> →</a><?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <button type="button" class="cdg-front-next" aria-label="Suivant">›</button>
        <div class="cdg-front-dots" aria-label="Navigation du carrousel"></div>
    </section>
    <?php
    return ob_get_clean();
}
