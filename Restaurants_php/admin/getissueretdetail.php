<?php include("../adminsession.php");

$raw_id=$obj->test_input($_REQUEST['raw_id']);

if($raw_id !='')
{
	$rowinfo = $obj->executequery("select * from issue_entry_details where raw_id = '$raw_id'");

	//$raw_id = $rowinfo[0]['raw_id'];
	$unit_name = $rowinfo[0]['unit_name'];
	//$qty = $rowinfo[0]['qty'];
	//$ret_date = $rowinfo[0]['ret_date'];
	//$bal_qty = $qty - $ret_qty;

	//echo $unit_name.'|'.$qty.'|'.$bal_qty;
	$arrayName = array('unit_name' => $unit_name);
	echo json_encode($arrayName);
}

?>