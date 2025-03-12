<?php 
include("../adminsession.php");

	$cancel_remark = $obj->test_input($_REQUEST['cancel_remark']);
	$billdetailid = $obj->test_input($_REQUEST['billdetailid']);
	$rate = $obj->test_input($_REQUEST['rate']);
	$table_id = $obj->test_input($_REQUEST['table_id']);
	//update payment data
	$form_data = array('cancel_remark'=>$cancel_remark,'is_cancelled_product'=>1,'rate'=>0);
	$where = array('billdetailid'=>$billdetailid,'table_id'=>$table_id,'isbilled'=>0);
    $keyvalue = $obj->update_record("bill_details",$where,$form_data);
	//echo $billid;
	
?>