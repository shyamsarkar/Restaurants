<?php
include("../adminsession.php");
$purdetail_id= addslashes($_REQUEST['purdetail_id']);
//$purchaseid= addslashes($_REQUEST['purchaseid']);	
$form_data = array('ret_qty'=>'0');
$where = array("purdetail_id"=>$purdetail_id);
$keyvalue = $obj->update_record("purchasentry_detail",$where,$form_data);
$action = 2;
$process = "update";
	
?>