<?php
include("../adminsession.php");
$productid=$obj->test_input($_REQUEST['productid']);
$unitid=$obj->test_input($_REQUEST['unit_id']);
$qty=$obj->test_input($_REQUEST['qty']);
$rate=$obj->test_input($_REQUEST['rate_amt']);
$billid=$obj->test_input($_REQUEST['billid']);
$billdetailid=$obj->test_input($_REQUEST['billdetailid']);
$table_id=$obj->getvalfield("bills","table_id","billid='$billid'");
$tblname="bill_details";
$taxable_value = $rate * $qty;

    if($billid > 0 && $table_id > 0)
    {
    	if($billdetailid==0)
	{
		$form_data = array('productid'=>$productid,'unitid'=>$unitid,'rate'=>$rate,'table_id'=>$table_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'qty'=>$qty,'taxable_value'=>$taxable_value,'billid'=>$billid);
		$obj->insert_record($tblname, $form_data);
    }     
    else
	{
	$form_data = array('qty'=>$qty,'rate'=>$rate,'taxable_value'=>$taxable_value);
	$where = array("billdetailid"=>$billdetailid);
	$obj->update_record("bill_details",$where,$form_data);
	$action=2;
	$process = "update";
	}   

}


?>