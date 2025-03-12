<?php include("../adminsession.php");
$table_id = (int)$obj->test($_GET['table_id']);
$billdetailid = $obj->test($_GET['billdetailid']);
$qty = $obj->test($_GET['qty']);
$rate = $obj->test($_GET['rate']);
$taxable_value = $rate * $qty;

if ($billdetailid > 0) {
        $form_data = array('qty' => $qty, 'taxable_value' => $taxable_value, 'rate' => $rate);
        $where = array('table_id' => $table_id, 'billdetailid' => $billdetailid);
        $obj->update("bill_details", $where, $form_data);
        echo 1;
}
