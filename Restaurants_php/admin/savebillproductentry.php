<?php
include("../adminsession.php");
$productid = $obj->test_input($_GET['productid']);
$unitid = $obj->test_input($_GET['unitid']);
$qty = (float)$obj->test_input($_GET['qty']);
$rate = (float)$obj->test_input($_GET['rate']);
$table_id = $obj->test_input($_GET['table_id']);
define("TABLE_NAME", "bill_details");
$taxable_value = $rate * $qty;

$issaved = $obj->get("bills", "count(*)", "table_id='$table_id' and is_paid='0'");
if ($issaved == 0) {
	if (!empty($productid) && !empty($unitid) && !empty($rate) && $table_id > 0) {
		//check product exist before kot
		$prevqty = (float)$obj->get(TABLE_NAME, "qty", "productid='$productid' and table_id='$table_id' and kotid=0 and isbilled=0");
		if ($prevqty > 0) {
			$qty += $prevqty;
			$taxable_value = $rate * $qty;
			$form_data = ['productid' => $productid, 'unitid' => $unitid, 'rate' => $rate, 'table_id' => $table_id, 'ipaddress' => $ipaddress, 'createdate' => $createdate, 'createdby' => $loginid, 'qty' => $qty, 'taxable_value' => $taxable_value];
			$where = ['productid' => $productid, 'table_id' => $table_id, 'kotid' => 0, 'isbilled' => 0];
			$obj->update_record(TABLE_NAME, $where, $form_data);
		} else {
			$form_data = ['productid' => $productid, 'billid' => 0, 'waiter_id' => 0, 'checked_nc' => 0, 'zomato_order' => 0, 'isbilled' => 0, 'kotid' => 0, 'cancel_remark' => 0, 'is_cancelled_product' => 0, 'unitid' => $unitid, 'rate' => $rate, 'table_id' => $table_id, 'ipaddress' => $ipaddress, 'createdate' => $createdate, 'lastupdated' => $createdate, 'createdby' => $loginid, 'qty' => $qty, 'taxable_value' => $taxable_value];
			$obj->save(TABLE_NAME, $form_data);
		}
		echo '1';
	} else {
		echo "0";
	}
} else {
	echo "2";
}
