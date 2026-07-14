<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="wrap">

<h1>Import Preview</h1>

<table class="widefat striped">

<thead>

<tr>

<th>Status</th>

<th>ID</th>

<th>Product</th>

<th>Old Price</th>

<th>New Price</th>

<th>Keterangan</th>

</tr>

</thead>

<tbody>

<?php

$header = true;

foreach($rows as $row){

    if($header){

        $header=false;
        continue;

    }

    $check = RPS_Validator::validate($row);

?>

<tr>

<td>

<?php

switch($check['status']){

    case 'success':

        echo "✅";

        break;

    case 'skip':

        echo "⚪";

        break;

    default:

        echo "❌";

}

?>

</td>

<td><?=esc_html($row['A'])?></td>

<td><?=esc_html($row['C'])?></td>

<td><?=number_format((float)$row['E'])?></td>

<td>

<?php

if($check['new_price']!==null){

    echo number_format($check['new_price']);

}

?>

</td>

<td>

<?=$check['message']?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<br>

<button
class="button button-primary button-large"
disabled>

Apply Price Changes

</button>

<p>

<b>Apply masih dinonaktifkan pada Commit ini.</b>

</p>

</div>