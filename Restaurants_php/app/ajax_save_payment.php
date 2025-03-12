<?php
include("../adminsession.php");
$supplier_id= $obj->test_input($_REQUEST['supplier_id']);
$customer_id= $obj->test_input($_REQUEST['customer_id']);
$voucher_no= $obj->test_input($_REQUEST['voucher_no']);
$pay_date= $obj->test_input($_REQUEST['pay_date']);
$curr_paid_amt= $obj->test_input($_REQUEST['curr_paid_amt']);
$payment_mode= $obj->test_input($_REQUEST['payment_mode']);
$check_no= $obj->test_input($_REQUEST['check_no']);
$bank_name=$obj->dateformatusa($_REQUEST['bank_name']);  
$check_date = $obj->test_input($_REQUEST['check_date']);
$remark = $obj->test_input($_REQUEST['remark']);


	if($supplier_id > 0 && $customer_id > 0 && $curr_paid_amt > 0)
	{
	
	$form_data = array('customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'supplier_status'=>$supplier_status,'pincode'=>$pincode,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'place_supply'=>$place_supply,'createdate'=>$createdate,'createdby'=>$loginid,'ipaddress'=>$ipaddress);
			
    $obj->insert_record("master_customer",$form_data);
	$process = "insert";
	echo "1";
	}//close if loop
	else
	{
		echo "0";
	}
	
?>