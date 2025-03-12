<?php
include("../adminsession.php");
$raw_id= $obj->test_input($_REQUEST['raw_id']);
$unit_name= $obj->test_input($_REQUEST['unit_name']);
$qty= $obj->test_input($_REQUEST['qty']);

$issueid_detail=$obj->test_input($_REQUEST['issueid_detail']);  
$issueid = $obj->test_input($_REQUEST['issueid']);


if($raw_id !='' && $qty !='')
{
	if($issueid_detail==0)
	{
	
	$form_data = array('raw_id'=>$raw_id,'unit_name'=>$unit_name,'qty'=>$qty,'issueid'=>$issueid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
			
    $obj->insert_record("issue_entry_details",$form_data);
	$action=1;
	//$process = "insert";
	//echo "1";
	}
	else
	{
	$form_data = array('raw_id'=>$raw_id,'unit_name'=>$unit_name,'qty'=>$qty,'issueid'=>$issueid,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid);
	
	$where = array("issueid_detail"=>$issueid_detail);
	$keyvalue = $obj->update_record("issue_entry_details",$where,$form_data);
	//$action=2;
	//$process = "update";
	}
	
}
?>