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
    $is_paid = 1;
//print_r($_REQUEST);die;
	if($billid > 0)
	{
			
			// isbill update to 1
			$form_data = array('is_paid'=>$is_paid,'cash_amt'=>$cash_amt,'cust_name'=>$cust_name,'paytm_amt'=>$paytm_amt,'settlement_amt'=>$settlement_amt,'card_amt'=>$card_amt,'remarks'=>$remarks,'table_id'=>$table_id,'paydate'=>$paydate,'credit_amt'=>$credit_amt,'google_pay'=>$google_pay,'cust_mobile'=>$cust_mobile,'zomato'=>$zomato,'swiggy'=>$swiggy,'counter_parcel'=>$counter_parcel);
			$where = array('billid'=>$billid);
			$obj->update_record("bills",$where,$form_data);
            echo "1";
			
	}//if close
	else
	echo "0";
}


?>