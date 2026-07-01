<?php

if (! defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'cdg_studio_register_menu');

function cdg_studio_register_menu(): void
{
    add_menu_page(
        __('CDG Studio', 'cdg-studio'),
        __('CDG Studio', 'cdg-studio'),
        'manage_options',
        'cdg-studio',
        'cdg_studio_dashboard_page',
        'dashicons-chart-area',
        58
    );

    add_submenu_page(
        'cdg-studio',
        __('Tableau de bord', 'cdg-studio'),
        __('Tableau de bord', 'cdg-studio'),
        'manage_options',
        'cdg-studio',
        'cdg_studio_dashboard_page'
    );
}