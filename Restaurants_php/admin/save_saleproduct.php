<?php
include("../adminsession.php");
$product_id= addslashes($_REQUEST['product_id']);
$unit_name= addslashes($_REQUEST['unit_name']);
$qty= addslashes($_REQUEST['qty']);
$rate_amt= trim(addslashes($_REQUEST['rate_amt']));
$disc= trim(addslashes($_REQUEST['disc']));
$taxable= trim(addslashes($_REQUEST['taxable']));
$cgst= trim(addslashes($_REQUEST['cgst']));
$sgst= trim(addslashes($_REQUEST['sgst']));
$igst= trim(addslashes($_REQUEST['igst']));
$inc_or_exc= trim(addslashes($_REQUEST['inc_or_exc']));
$purdetail_id=trim(addslashes($_REQUEST['purdetail_id']));  
$purchaseid = trim(addslashes($_REQUEST['purchaseid']));
$sale_pur_type = 'sale';
$taxable_value = $rate_amt * $qty;


$gst_cal1 = $obj->gst_calculation($qty,$rate_amt,$disc,$cgst,$sgst,$igst,$inc_or_exc);
//print_r($gst_cal1);die;
$taxable_value = $gst_cal1['taxable_value'];
$sgst_amt = $gst_cal1['sgst_amt'];
$cgst_amt = $gst_cal1['cgst_amt'];
$igst_amt = $gst_cal1['igst_amt'];
$final_price = $gst_cal1['final_price'];


if($product_id !='' && $qty !='')
{
	if($purdetail_id==0)
	{
	
	$form_data = array('sale_pur_type'=>$sale_pur_type,'inc_or_exc'=>$inc_or_exc,'product_id'=>$product_id,'unit_name'=>$unit_name,'qty'=>$qty,'rate_amt'=>$rate_amt,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'purchaseid'=>$purchaseid,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'disc'=>$disc,'taxable'=>$taxable,'taxable_value'=>$taxable_value,'sgst_amt'=>$sgst_amt,'cgst_amt'=>$cgst_amt,'igst_amt'=>$igst_amt,'final_price'=>$final_price);
			
    $obj->insert_record("purchasentry_detail",$form_data);
	}
	
}
?>