<?php 
include("../adminsession.php");



$billid = $obj->test_input($_REQUEST['billid']);
$table_id = $obj->test_input($_REQUEST['table_id']);

if($billid > 0 && $table_id > 0)
{

	//update payment data
	$form_data = array('isbilled'=>1);
	$where = array('billid'=>$billid,'table_id'=>$table_id);
    $keyvalue = $obj->update_record("bill_details",$where,$form_data);
	//echo $billid;

	$form_data1 = array('is_paid'=>1);
	$where1 = array('billid'=>$billid,'table_id'=>$table_id);
    $keyvalue = $obj->update_record("bills",$where1,$form_data1);
    echo "1";
	
}
else
{
	echo "0";
}


?>