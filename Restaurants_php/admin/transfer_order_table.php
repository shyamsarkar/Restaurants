<?php 
include("../adminsession.php");

 
	$table_idt = trim(addslashes($_REQUEST['table_idt']));
	$table_id = trim(addslashes($_REQUEST['table_id']));

	if($table_id > 0)
	{
		
	$form_data = array('table_id'=>$table_idt);
	$where = array('table_id'=>$table_id,'isbilled'=>0);
	$wherekot = array('table_id'=>$table_id,'billid'=>0);
	$obj->update_record("bill_details", $where, $form_data);
	$obj->update_record("kot_entry", $wherekot, $form_data);
	$obj->update_record("parcel_order", $wherekot, $form_data);
	echo $table_idt;
	}

?>