<?php
include("../adminsession.php");
$issueid_detail= addslashes($_REQUEST['issueid_detail']);

$form_data = array('ret_qty'=>'0');
$where = array("issueid_detail"=>$issueid_detail);
$keyvalue = $obj->update_record("issue_entry_details",$where,$form_data);
$action = 2;
$process = "update";
	
?>