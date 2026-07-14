<?php

if (!defined('ABSPATH')) {
    exit;
}

class RPS_Admin
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_enqueue_scripts',[$this,'assets']);
    }
    public function assets()
    {
        wp_enqueue_style(
            'rps-admin',
            RPS_PLUGIN_URL . 'admin/assets/admin.css',
            [],
            RPS_VERSION
        );
    }
    public function admin_menu()
    {

        add_menu_page(
            'Resto Price Scheduler',
            'RPS',
            'manage_woocommerce',
            'rps-dashboard',
            [$this, 'dashboard'],
            'dashicons-tag',
            56
        );

        add_submenu_page(
            'rps-dashboard',
            'Dashboard',
            'Dashboard',
            'manage_woocommerce',
            'rps-dashboard',
            [$this, 'dashboard']
        );

        add_submenu_page(
            'rps-dashboard',
            'Product List',
            'Product List',
            'manage_woocommerce',
            'rps-products',
            [$this, 'products']
        );

        add_submenu_page(
            'rps-dashboard',
            'Export',
            'Export',
            'manage_woocommerce',
            'rps-export',
            [$this, 'export']
        );
        add_submenu_page(
            'rps-dashboard',
            'Import',
            'Import',
            'manage_woocommerce',
            'rps-import',
            [$this, 'import']
        );
    }

    public function dashboard()
    {
        require RPS_PLUGIN_PATH . 'admin/dashboard.php';
    }

    public function products()
    {
        require RPS_PLUGIN_PATH . 'admin/products.php';
    }

    public function export()
    {
        require RPS_PLUGIN_PATH . 'admin/export.php';
    }
    public function import()
    {
        require RPS_PLUGIN_PATH . 'admin/import.php';
    }
}