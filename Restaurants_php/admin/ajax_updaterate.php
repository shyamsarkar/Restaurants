<?php include("../adminsession.php");
$billdetailid = $obj->test_input($_REQUEST['billdetailid']);
$rate = $obj->test_input($_REQUEST['rate']);
$qty=$obj->test_input($_REQUEST['qty']);
$taxable_value = $rate * $qty;
if($billdetailid > 0)
{
	$form_data = array('rate'=>$rate,'taxable_value'=>$taxable_value,'qty'=>$qty);
	$where = array('billdetailid'=>$billdetailid);
	$obj->update_record("bill_details",$where,$form_data);
}

?>