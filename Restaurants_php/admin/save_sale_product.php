<?php
include("../adminsession.php");
$product_id= $obj->test_input($_REQUEST['product_id']);
$unit_name= $obj->test_input($_REQUEST['unit_name']);
$qty= $obj->test_input($_REQUEST['qty']);
$rate_amt= $obj->test_input($_REQUEST['rate_amt']);
$issueid_detail=$obj->test_input($_REQUEST['issueid_detail']);  
$issueid = $obj->test_input($_REQUEST['issueid']);
$total = $obj->test_input($_REQUEST['total']);

if($product_id !='' && $qty !='')
{
	if($issueid_detail==0)
	{
	
	$form_data = array('product_id'=>$product_id,'unit_name'=>$unit_name,'qty'=>$qty,'rate_amt'=>$rate_amt,'issueid'=>$issueid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'total'=>$total);
			
    $obj->insert_record("issue_entry_details",$form_data);
	$action=1;
	//$process = "insert";
	//echo "1";
	}
	else
	{
	$form_data = array('product_id'=>$product_id,'unit_name'=>$unit_name,'qty'=>$qty,'rate_amt'=>$rate_amt,'issueid'=>$issueid,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid,'total'=>$total);
	
	$where = array("issueid_detail"=>$issueid_detail);
	$keyvalue = $obj->update_record("issue_entry_details",$where,$form_data);
	//$action=2;
	//$process = "update";
	}
	
}
?>