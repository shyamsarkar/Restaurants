<?php 
include("../adminsession.php");
//include("../lib/smsinfo.php");
//$ok = $obj->sendsmsGET($username,$pass,$senderid,"hiie",$serverUrl,'8319358163');
if(isset($_REQUEST['table_id']))
{

    $cash_amt = trim(addslashes($_REQUEST['cash_amt']));
    $cust_name = trim(addslashes($_REQUEST['cust_name']));
    $paytm_amt = trim(addslashes($_REQUEST['paytm_amt']));
    $zomato = trim(addslashes($_REQUEST['zomato']));
    $settlement_amt = trim(addslashes($_REQUEST['settlement_amt']));
    $card_amt = trim(addslashes($_REQUEST['card_amt']));
    $cust_mobile = $_REQUEST['cust_mobile'];
    $remarks = trim(addslashes($_REQUEST['remarks']));
    $table_id = trim(addslashes($_REQUEST['table_id']));
    $billid = trim(addslashes($_REQUEST['billid']));
    $paydate = $obj->dateformatusa($_REQUEST['paydate']);
    $credit_amt = trim(addslashes($_REQUEST['credit_amt']));
    $google_pay = trim(addslashes($_REQUEST['google_pay']));
    $swiggy = trim(addslashes($_REQUEST['swiggy']));
    $counter_parcel = trim(addslashes($_REQUEST['counter_parcel']));
    $send_sms1 = trim(addslashes($_REQUEST['send_sms1']));
    $is_paid = 1;
//print_r($_REQUEST);die;
	if($billid > 0)
	{
			//update payment data
			$form_data = array('isbilled'=>1);
			$where = array('billid'=>$billid);
			$obj->update_record("bill_details", $where, $form_data);
			//dbRowUpdate("bill_details", $form_data,"billid='$billid'");

			 // parcel order update_record
			$where1 = array('table_id'=>$table_id,'close_order'=>0,'billid'=>$billid);
			$data1 = array('close_order'=>1);
			$obj->update_record("parcel_order", $where1, $data1);
			
			// cap stw table order update_record
			$where1 = array('table_id'=>$table_id,'close_order'=>0,'billid'=>$billid);
			$data1 = array('close_order'=>1);
			$obj->update_record("cap_stw_table", $where1, $data1);
			
			// isbill update to 1
			$form_data = array('is_paid'=>$is_paid,'cash_amt'=>$cash_amt,'cust_name'=>$cust_name,'paytm_amt'=>$paytm_amt,'settlement_amt'=>$settlement_amt,'card_amt'=>$card_amt, 'remarks'=>$remarks,'table_id'=>$table_id,'billid'=>$billid,'paydate'=>$paydate,'credit_amt'=>$credit_amt,'google_pay'=>$google_pay,'cust_mobile'=>$cust_mobile,'zomato'=>$zomato,'swiggy'=>$swiggy,'counter_parcel'=>$counter_parcel);
			$where = array('billid'=>$billid);
			$obj->update_record("bills", $where,  $form_data);
            echo "1";
			if($send_sms1 > 0)
			{

                $company_name = $obj->getvalfield("company_setting","comp_name","compid=1");
				$msg = "Dear Customer, Thankyou For Dining With Us. kindly visit again From $company_name";
			
			if(strlen($cust_mobile) == 10)
			{

				$ok = $obj->send_sms_indor($cust_mobile,$msg);
			

		    if($ok)
		    {
		    	echo '2';
		    }
		    else
		    {
		    	echo '3';
		    }
			}
			}
			
			
			
			
	}//if close
	else
	echo "0";
}


?>