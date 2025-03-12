<?php include("../adminsession.php");
$billid = $obj->test($_GET['billid']);
$table_id = $obj->test($_GET['table_id']);

$count_kot_product = $obj->get("bill_details", "count(*)", "table_id='$table_id' and billid='$billid' and kotid=0");
echo $count_kot_product;
