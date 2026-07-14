<?php
/**
 * Plugin Name: Resto Price Scheduler
 * Plugin URI: https://github.com/ekomahendro/resto-price-scheduler
 * Description: Schedule and manage WooCommerce product prices.
 * Version: 1.0.0
 * Author: Eko Mahendro
 * License: GPL2
 * Text Domain: rps
 */

if (!defined('ABSPATH')) {
    exit;
}

define('RPS_VERSION', '1.0.0');
define('RPS_PLUGIN_FILE', __FILE__);
define('RPS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('RPS_PLUGIN_URL', plugin_dir_url(__FILE__));
require_once RPS_PLUGIN_PATH . 'vendor/autoload.php';

require_once RPS_PLUGIN_PATH . 'includes/class-install.php';
require_once RPS_PLUGIN_PATH . 'includes/class-admin.php';
require_once RPS_PLUGIN_PATH . 'includes/class-product.php';
require_once RPS_PLUGIN_PATH . 'includes/class-excel.php';
require_once RPS_PLUGIN_PATH . 'includes/class-export.php';
require_once RPS_PLUGIN_PATH . 'includes/class-import.php';
require_once RPS_PLUGIN_PATH . 'includes/class-validator.php';

register_activation_hook(__FILE__, ['RPS_Install', 'activate']);

function rps_init()
{
    new RPS_Admin();
    new RPS_Export();
    new RPS_Import();
}

add_action('plugins_loaded', 'rps_init');