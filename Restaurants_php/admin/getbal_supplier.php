<?php
include("../adminsession.php");
$supplier_id = $obj->test_input($_REQUEST['supplier_id']);
echo $balance = $obj->balance_amt($supplier_id);
?>