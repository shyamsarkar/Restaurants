<?php 
include("../adminsession.php");

if(isset($_REQUEST['table_id']))
{ //print_r($_REQUEST['is_parsal']);
	$table_id = trim(addslashes($_REQUEST['table_id']));
	$basic_bill_amt = trim(addslashes($_REQUEST['basic_bill_amt']));
	//$disc_percent = trim(addslashes($_REQUEST['disc_percent']));
	$net_bill_amt = trim(addslashes($_REQUEST['net_bill_amt']));
	$cust_name = trim(addslashes($_REQUEST['cust_name']));
	$parsal_status = trim(addslashes($_REQUEST['parsal_status']));
	//$disc_rs =  trim(addslashes($_REQUEST['disc_rs']));
	$billnumber = $obj->getcode("bills","billid","1=1");
	$is_parsal =  trim(addslashes($_REQUEST['is_parsal']));
    $food_amt = trim(addslashes($_REQUEST['food_amt']));
    $bev_amt = trim(addslashes($_REQUEST['bev_amt']));
	if($is_parsal == 'on')
	$is_parsal = '1';
	else
	$is_parsal = 0;
	
	$sgst = trim(addslashes($_REQUEST['sgst']));
	$cgst = trim(addslashes($_REQUEST['cgst']));
	
	
	$billdate = $obj->getvalfield("day_close","day_date","1=1");
	$billtime =  date("h:i A");
	//echo $billtime; 
	
	
	if($table_id !='')
	{
		//restricte order bill to save duplicate
		$check_billed = $obj->getvalfield("bills","count(*)","table_id='$table_id' and is_paid = 0");
		
		if($check_billed > 0)
		{
			echo "0";
		}
		else
		{
			//ALTER TABLE `bills` ADD `disc_rs` FLOAT NOT NULL AFTER `disc_percent` 
			$form_data = array('is_parsal'=>$is_parsal,'table_id'=>$table_id,'billdate'=>$billdate,'billtime'=>$billtime,'billnumber'=>$billnumber,'cgst'=>$cgst,'sgst'=>$sgst,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'net_bill_amt'=>$net_bill_amt,'basic_bill_amt'=>$basic_bill_amt,'parsal_status'=>$parsal_status,'cust_name'=>$cust_name,'food_amt'=>$food_amt,'bev_amt'=>$bev_amt);
			
			$keyvalue = $obj->insert_record_lastid("bills", $form_data);
			$action=1;
			$process = "insert";
			$where = array('table_id'=>$table_id,'billid'=>0);
			$data = array('billid'=>$keyvalue);
			$obj->update_record("bill_details", $where, $data);

			$obj->update_record("kot_entry", $where, $data);

			// mysql_query("update bill_details set billid='$keyvalue' where table_id='$table_id' and billid=0");	
			// mysql_query("update kot_entry set billid='$keyvalue' where table_id='$table_id' and billid=0");	
			echo $keyvalue;
		}//else close
	}
}


?>