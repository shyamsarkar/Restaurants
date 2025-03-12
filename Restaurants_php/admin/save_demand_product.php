<?php
include("../adminsession.php");
$product_id= addslashes($_REQUEST['product_id']);
$unit_name= addslashes($_REQUEST['unit_name']);
$qty= addslashes($_REQUEST['qty']);
$demand_detail_id=trim(addslashes($_REQUEST['demand_detail_id']));  
$demand_id = trim(addslashes($_REQUEST['demand_id']));

if($product_id !='' && $qty !='')
{
	if($demand_detail_id==0)
	{
	
	$form_data = array('product_id'=>$product_id,'unit_name'=>$unit_name,'qty'=>$qty,'demand_id'=>$demand_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
			
    $obj->insert_record("demand_detail",$form_data);
	$action=1;
	$process = "insert";
	//echo "1";
	}
	// else
	// {
	// $form_data = array('inc_or_exc'=>$inc_or_exc,'product_id'=>$product_id,'unit_name'=>$unit_name,'qty'=>$qty,'rate_amt'=>$rate_amt,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'purchaseid'=>$purchaseid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
	
	// $where = array("purdetail_id"=>$purdetail_id);
	// $keyvalue = $obj->update_record("purchasentry_detail",$where,$form_data);
	// $action=2;
	// $process = "update";
	// }
	
}
?>