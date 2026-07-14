    <?php

if (!defined('ABSPATH')) {
    exit;
}

class RPS_Install
{

    public static function activate()
    {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $table1 = $wpdb->prefix . 'rps_schedule';

        $sql = "CREATE TABLE $table1 (

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            product_id BIGINT UNSIGNED NOT NULL,

            old_price DECIMAL(12,2),

            new_price DECIMAL(12,2),

            schedule_date DATETIME,

            status VARCHAR(20) DEFAULT 'pending',

            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

            PRIMARY KEY(id)

        ) $charset_collate;";

        dbDelta($sql);

        $table2 = $wpdb->prefix . 'rps_history';

        $sql = "CREATE TABLE $table2 (

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            product_id BIGINT UNSIGNED,

            old_price DECIMAL(12,2),

            new_price DECIMAL(12,2),

            executed_at DATETIME,

            action_by VARCHAR(100),

            PRIMARY KEY(id)

        ) $charset_collate;";

        dbDelta($sql);

    }

}