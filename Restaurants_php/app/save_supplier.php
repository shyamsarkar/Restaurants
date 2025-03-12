<?php
include("../adminsession.php");
$supplier_name= $obj->test_input($_REQUEST['supplier_name']);
$mobile= $obj->test_input($_REQUEST['mobile']);
$address= $obj->test_input($_REQUEST['address']);
$supplier_status= $obj->test_input($_REQUEST['supplier_status']);
$pincode= $obj->test_input($_REQUEST['pincode']);
$gstno= $obj->test_input($_REQUEST['gstno']);
$openingbal= $obj->test_input($_REQUEST['openingbal']);
$open_bal_date=$obj->dateformatusa($_REQUEST['open_bal_date']);  
$bank_name = $obj->test_input($_REQUEST['bank_name']);
$bank_ac = $obj->test_input($_REQUEST['bank_ac']);
$ifsc_code = $obj->test_input($_REQUEST['ifsc_code']);
$bank_address = $obj->test_input($_REQUEST['bank_address']);
$keyvalue = $obj->test_input($_REQUEST['supplier_id']);

$count = $obj->getvalfield("master_supplier","count(*)","supplier_name='$supplier_name' and mobile='$mobile' and supplier_id!='$keyvalue'");
if($count > 0)
{
  echo "3";
}//close if loop
else
{


	if($keyvalue==0)
	{
	
	$form_data = array('supplier_name'=>$supplier_name,'mobile'=>$mobile,'address'=>$address,'supplier_status'=>$supplier_status,'pincode'=>$pincode,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'bank_name'=>$bank_name,'createdate'=>$createdate,'createdby'=>$loginid,'ipaddress'=>$ipaddress,'bank_ac'=>$bank_ac,'ifsc_code'=>$ifsc_code,'bank_address'=>$bank_address);
			
    $obj->insert_record("master_supplier",$form_data);
	$process = "insert";
	echo "1";
	}//close if loop
	else
	{
	$form_data = array('supplier_name'=>$supplier_name,'mobile'=>$mobile,'address'=>$address,'supplier_status'=>$supplier_status,'pincode'=>$pincode,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'bank_name'=>$bank_name,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid,'bank_ac'=>$bank_ac,'ifsc_code'=>$ifsc_code,'bank_address'=>$bank_address);
	
	$where = array("supplier_id"=>$keyvalue);
	$obj->update_record("master_supplier",$where,$form_data);
	$process = "update";
	echo "2";
	}//close else loop
	
}//close else loop
?>