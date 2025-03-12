<?php 
include '../adminsession.php';


$billid = $_REQUEST['billid'];
$google_pay = $_REQUEST['google_pay'];

$paytm_amt = $_REQUEST['paytm_amt'];
$card_amt = $_REQUEST['card_amt'];
$paydate = $obj->dateformatusa($_REQUEST['paydate']);
$credit_amt = $_REQUEST['credit_amt'];
$balanceamt = $_REQUEST['credit_amt'];
$cash_amt = $_REQUEST['cash_amt'];

$prev_cash = $obj->getvalfield("bills","cash_amt","billid='$billid'");
$cash_amt = $prev_cash + $cash_amt;

$prev_google_pay = $obj->getvalfield("bills","google_pay","billid='$billid'");
$google_pay = $prev_google_pay + $google_pay;

$prev_card_amt = $obj->getvalfield("bills","card_amt","billid='$billid'");
$card_amt = $prev_card_amt + $card_amt;

$prev_paytm = $obj->getvalfield("bills","paytm_amt","billid='$billid'");
$paytm_amt = $prev_paytm + $paytm_amt;



// $tot_rec_amt = $google_pay + $cash_amt + $paytm_amt + $card_amt;
// $balanceamt = $credit_amt - $tot_rec_amt;


if($billid > 0)
{
	$formdata = array('paydate'=>$paydate,'google_pay'=>$google_pay,'cash_amt'=>$cash_amt,'paytm_amt'=>$paytm_amt,'card_amt'=>$card_amt,'credit_amt'=>$balanceamt);
	$where = array('billid'=>$billid);
	$obj->update_record("bills",$where,$formdata);
	echo "1";
}

?>