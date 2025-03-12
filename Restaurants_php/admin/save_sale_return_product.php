<?php
include("../adminsession.php");
$ret_qty = trim(addslashes($_REQUEST['ret_qty']));
$purdetail_id = trim(addslashes($_REQUEST['purdetail_id']));
$ret_date = $obj->dateformatusa($_REQUEST['ret_date']);
if (!empty($purdetail_id)) {
	$old_ret_qty = $obj->getvalfield("purchasentry_detail", "ret_qty", "purdetail_id='$purdetail_id'");
	$ret_qty = $old_ret_qty + $ret_qty;
	$form_data = array('ret_qty' => $ret_qty, 'ret_date' => $ret_date);
	$where = array("purdetail_id" => $purdetail_id);
	$keyvalue = $obj->update_record("purchasentry_detail", $where, $form_data);
}
