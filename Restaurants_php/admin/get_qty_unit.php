<?php include("../adminsession.php");

$purdetail_id=$obj->test_input($_REQUEST['purdetail_id']);

if($purdetail_id !='')
{
	$rowinfo = $obj->executequery("select * from purchasentry_detail where purdetail_id = '$purdetail_id'");

	$product_id = $rowinfo[0]['product_id'];
	$unit_name = $rowinfo[0]['unit_name'];
	$qty = $rowinfo[0]['qty'];
	$ret_qty = $rowinfo[0]['ret_qty'];
	$bal_qty = $qty - $ret_qty;

	//echo $unit_name.'|'.$qty.'|'.$bal_qty;
	$arrayName = array('unit_name' => $unit_name, 'qty'=>$qty, 'bal_qty'=>$bal_qty);
	echo json_encode($arrayName);
}

?>