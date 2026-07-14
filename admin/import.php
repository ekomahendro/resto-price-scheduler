<?php

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">

<h1>Import Price Excel</h1>

<p>

Upload file Excel hasil Export RPS.

</p>

<form
method="post"
enctype="multipart/form-data"
action="<?php echo admin_url('admin-post.php');?>">

<input
type="hidden"
name="action"
value="rps_import_preview">

<input
type="file"
name="excel_file"
accept=".xlsx"
required>

<br><br>

<input
type="submit"
class="button button-primary button-large"
value="Upload & Preview">

</form>

</div>