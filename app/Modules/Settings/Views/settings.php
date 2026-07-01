<?php

defined('ABSPATH') || exit;

?>

<div class="wrap cdg-settings">
    <h1>Réglages CDG Studio</h1>

    <?php settings_errors('cdg_studio_settings'); ?>

    <form method="post">
        <?php wp_nonce_field('cdg_studio_save_settings'); ?>

        <?php foreach ($sections as $section): ?>
            <div class="cdg-settings-section">
                <h2><?php echo esc_html($section->title); ?></h2>

                <?php if ($section->description !== ''): ?>
                    <p class="description">
                        <?php echo esc_html($section->description); ?>
                    </p>
                <?php endif; ?>

                <table class="form-table" role="presentation">
                    <tbody>
                        <?php foreach ($this->registry->fieldsForSection($section->id) as $field): ?>
                            <tr>
                                <th scope="row">
                                    <label for="cdg_<?php echo esc_attr($field->key); ?>">
                                        <?php echo esc_html($field->label); ?>
                                    </label>
                                </th>
                                <td>
                                    <?php
                                    $value = $settings[$field->key] ?? $field->default;
                                    ?>

                                    <?php if ($field->type === 'checkbox'): ?>
                                        <label>
                                            <input
                                                type="checkbox"
                                                id="cdg_<?php echo esc_attr($field->key); ?>"
                                                name="cdg_studio_settings[<?php echo esc_attr($field->key); ?>]"
                                                value="1"
                                                <?php checked((bool) $value); ?>
                                            >
                                            <?php echo esc_html($field->description); ?>
                                        </label>

                                    <?php elseif ($field->type === 'select'): ?>
                                        <select
                                            id="cdg_<?php echo esc_attr($field->key); ?>"
                                            name="cdg_studio_settings[<?php echo esc_attr($field->key); ?>]"
                                        >
                                            <?php foreach ($field->choices as $choiceValue => $choiceLabel): ?>
                                                <option
                                                    value="<?php echo esc_attr((string) $choiceValue); ?>"
                                                    <?php selected((string) $value, (string) $choiceValue); ?>
                                                >
                                                    <?php echo esc_html((string) $choiceLabel); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <?php if ($field->description !== ''): ?>
                                            <p class="description">
                                                <?php echo esc_html($field->description); ?>
                                            </p>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        <input
                                            type="text"
                                            id="cdg_<?php echo esc_attr($field->key); ?>"
                                            name="cdg_studio_settings[<?php echo esc_attr($field->key); ?>]"
                                            value="<?php echo esc_attr((string) $value); ?>"
                                            class="regular-text"
                                        >

                                        <?php if ($field->description !== ''): ?>
                                            <p class="description">
                                                <?php echo esc_html($field->description); ?>
                                            </p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>

        <?php submit_button('Enregistrer les réglages'); ?>
    </form>
</div>