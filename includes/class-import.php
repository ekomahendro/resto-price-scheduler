<?php

if (!defined('ABSPATH')) {
    exit;
}

class RPS_Import
{

    public function __construct()
    {

        add_action(
            'admin_post_rps_import_preview',
            [$this, 'preview']
        );

    }

    public function preview()
    {

        if (!current_user_can('manage_woocommerce')) {
            wp_die('Access Denied');
        }

        if (empty($_FILES['excel_file']['tmp_name'])) {
            wp_die('File tidak ditemukan.');
        }

        $rows = RPS_Excel::read($_FILES['excel_file']['tmp_name']);

        require RPS_PLUGIN_PATH . 'admin/import-preview.php';

        exit;

    }

}