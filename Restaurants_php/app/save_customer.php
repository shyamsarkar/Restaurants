<?php
include("../adminsession.php");
$customer_name= $obj->test_input($_REQUEST['customer_name']);
$mobile= $obj->test_input($_REQUEST['mobile']);
$address= $obj->test_input($_REQUEST['address']);
$supplier_status= $obj->test_input($_REQUEST['supplier_status']);
$pincode= $obj->test_input($_REQUEST['pincode']);
$gstno= $obj->test_input($_REQUEST['gstno']);
$openingbal= $obj->test_input($_REQUEST['openingbal']);
$open_bal_date=$obj->dateformatusa($_REQUEST['open_bal_date']);  
$place_supply = $obj->test_input($_REQUEST['place_supply']);
$keyvalue = $obj->test_input($_REQUEST['customer_id']);

$count = $obj->getvalfield("master_customer","count(*)","customer_name='$customer_name' and mobile='$mobile' and customer_id!='$keyvalue'");
if($count > 0)
{
  echo "3";
}//close if loop
else
{


	if($keyvalue==0)
	{
	
	$form_data = array('customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'supplier_status'=>$supplier_status,'pincode'=>$pincode,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'place_supply'=>$place_supply,'createdate'=>$createdate,'createdby'=>$loginid,'ipaddress'=>$ipaddress);
			
    $obj->insert_record("master_customer",$form_data);
	$process = "insert";
	echo "1";
	}//close if loop
	else
	{
	$form_data = array('customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'supplier_status'=>$supplier_status,'pincode'=>$pincode,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'place_supply'=>$place_supply,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid);
	
	$where = array("customer_id"=>$keyvalue);
	$obj->update_record("master_customer",$where,$form_data);
	$process = "update";
	echo "2";
	}//close else loop
	
}//close else loop
?>