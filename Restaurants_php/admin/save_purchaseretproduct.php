<?php
include("../adminsession.php");
$product_id= addslashes($_REQUEST['product_id']);
$unit_name= addslashes($_REQUEST['unit_name']);
$qty= addslashes($_REQUEST['qty']);
$purchaseid = addslashes($_REQUEST['purchaseid']);
$ret_qty = addslashes($_REQUEST['ret_qty']);
$bal_qty = addslashes($_REQUEST['bal_qty']);

	
	$form_data = array('ret_qty'=>$ret_qty,'bal_qty'=>$bal_qty);
	$where = array("purchaseid"=>$purchaseid);
	$keyvalue = $obj->update_record("purchasentry_detail",$where,$form_data);
	$action=2;
	$process = "update";
	
?>