<?php

if (!defined('ABSPATH')) {
    exit;
}

$paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
$keyword = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$category = isset($_GET['category']) ? intval($_GET['category']) : 0;
$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 20;

if (!in_array($per_page, [20,50,100])) {
    $per_page = 20;
}

$args = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'paged'          => $paged,
    'orderby'        => 'title',
    'order'          => 'ASC'
];

if (!empty($keyword)) {
    $args['s'] = $keyword;
}

if ($category > 0) {

    $args['tax_query'] = [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $category
        ]
    ];

}

$query = new WP_Query($args);

$categories = get_terms([
    'taxonomy'=>'product_cat',
    'hide_empty'=>false
]);

?>

<div class="wrap">

<h1 class="wp-heading-inline">Product List</h1>

<hr class="wp-header-end">

<form method="get">

<input type="hidden" name="page" value="rps-products">

<input
type="search"
name="s"
placeholder="Search Product..."
value="<?php echo esc_attr($keyword); ?>"
style="width:280px;"
>

<select name="category">

<option value="0">All Category</option>

<?php foreach($categories as $cat){ ?>

<option
value="<?php echo $cat->term_id;?>"
<?php selected($category,$cat->term_id);?>
>

<?php echo esc_html($cat->name);?>

</option>

<?php } ?>

</select>

<select name="per_page">

<option value="20" <?php selected($per_page,20);?>>20</option>

<option value="50" <?php selected($per_page,50);?>>50</option>

<option value="100" <?php selected($per_page,100);?>>100</option>

</select>

<input
type="submit"
class="button button-primary"
value="Search">

</form>

<br>

<p>

<strong>

Total Product :

<?php echo number_format($query->found_posts);?>

</strong>

</p>

<table class="widefat striped">

<thead>

<tr>

<th width="70">ID</th>

<th>Product</th>

<th width="200">Category</th>

<th width="120">Regular Price</th>

<th width="120">Sale Price</th>

<th width="120">Stock</th>

</tr>

</thead>

<tbody>

<?php

if($query->have_posts()):

while($query->have_posts()):

$query->the_post();

$product = wc_get_product(get_the_ID());

$cats = wp_get_post_terms(
$product->get_id(),
'product_cat',
['fields'=>'names']
);

?>

<tr>

<td><?php echo $product->get_id();?></td>

<td>

<a href="<?php echo get_edit_post_link($product->get_id());?>">

<?php echo esc_html($product->get_name());?>

</a>

</td>

<td><?php echo esc_html(implode(', ',$cats));?></td>

<td><?php echo wc_price($product->get_regular_price());?></td>

<td><?php echo wc_price($product->get_sale_price());?></td>

<td><?php echo esc_html($product->get_stock_status());?></td>

</tr>

<?php

endwhile;

else:

?>

<tr>

<td colspan="6">

No Product Found

</td>

</tr>

<?php

endif;

wp_reset_postdata();

?>

</tbody>

</table>

<?php

$total_pages = $query->max_num_pages;

if($total_pages>1){

echo '<div style="margin-top:20px;">';

echo paginate_links([

'base'=>add_query_arg('paged','%#%'),

'format'=>'',

'current'=>$paged,

'total'=>$total_pages,

'prev_text'=>'« Previous',

'next_text'=>'Next »'

]);

echo '</div>';

}

?>

</div>