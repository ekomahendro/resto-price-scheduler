<?php

if (!defined('ABSPATH')) {
    exit;
}

$total_product = wp_count_posts('product');

$total_category = wp_count_terms([
    'taxonomy' => 'product_cat',
    'hide_empty' => false
]);

?>

<div class="wrap">

<h1>Restaurant Price Scheduler</h1>

<table class="widefat striped" style="max-width:700px">

<tr>
    <th width="250">Plugin Version</th>
    <td><?php echo RPS_VERSION; ?></td>
</tr>

<tr>
    <th>Total Product</th>
    <td><?php echo intval($total_product->publish); ?></td>
</tr>

<tr>
    <th>Total Category</th>
    <td><?php echo intval($total_category); ?></td>
</tr>

<tr>
    <th>WooCommerce</th>
    <td><?php echo defined('WC_VERSION') ? WC_VERSION : '-'; ?></td>
</tr>

<tr>
    <th>PHP</th>
    <td><?php echo phpversion(); ?></td>
</tr>

<tr>
    <th>WordPress</th>
    <td><?php echo get_bloginfo('version'); ?></td>
</tr>

</table>

</div>