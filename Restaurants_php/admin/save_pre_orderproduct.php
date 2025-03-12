<?php
include("../adminsession.php");
$productid= addslashes($_REQUEST['productid']);
$unit_name= addslashes($_REQUEST['unit_name']);
$qty= addslashes($_REQUEST['qty']);
$rate_amt= trim(addslashes($_REQUEST['rate_amt']));
$disc= trim(addslashes($_REQUEST['disc']));
$cgst= trim(addslashes($_REQUEST['cgst']));
$sgst= trim(addslashes($_REQUEST['sgst']));
$igst= trim(addslashes($_REQUEST['igst']));
$taxable= trim(addslashes($_REQUEST['taxable']));
$inc_or_exc= trim(addslashes($_REQUEST['inc_or_exc']));
$pre_detail_id=trim(addslashes($_REQUEST['pre_detail_id']));  
$pre_orderid = trim(addslashes($_REQUEST['pre_orderid']));
$taxable_value = $rate_amt * $qty;
$gst_cal1 = $obj->gst_calculation($qty,$rate_amt,$disc,$cgst,$sgst,$igst,$inc_or_exc);

$taxable_value = $gst_cal1['taxable_value'];
$sgst_amt = $gst_cal1['sgst_amt'];
$cgst_amt = $gst_cal1['cgst_amt'];
$igst_amt = $gst_cal1['igst_amt'];
$final_price = $gst_cal1['final_price'];
//print_r($_REQUEST);die;

if($productid !='' && $qty !='')
{
	if($pre_detail_id==0)
	{
	
	$form_data = array('inc_or_exc'=>$inc_or_exc,'productid'=>$productid,'unit_name'=>$unit_name,'qty'=>$qty,'rate_amt'=>$rate_amt,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'pre_orderid'=>$pre_orderid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'disc'=>$disc,'taxable'=>$taxable,'taxable_value'=>$taxable_value,'sgst_amt'=>$sgst_amt,'cgst_amt'=>$cgst_amt,'igst_amt'=>$igst_amt,'final_price'=>$final_price);
			
    $obj->insert_record("preentry_detail",$form_data);
	$action=1;
	$process = "insert";
	//echo "1";
	}
	
	
}
?>