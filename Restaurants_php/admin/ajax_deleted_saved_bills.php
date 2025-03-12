<?php 
include("../adminsession.php");
$table_id = $obj->test_input($_REQUEST['table_id']);
$billid = $obj->test_input($_REQUEST['billid']);

if($table_id > 0 && $billid > 0)
{

	if($billid > 0)
	{

			//delete bill details
			$where = array('billid'=>$billid,'table_id'=>$table_id);
	        $obj->delete_record("bill_details",$where);

			//delete bill data
			$where = array('billid'=>$billid,'table_id'=>$table_id);
	       $obj->delete_record("bills",$where);

	        //delete kot data
			$where = array('billid'=>$billid,'table_id'=>$table_id);
	       $obj->delete_record("kot_entry",$where);

	        //delete parcel data
			$where = array('billid'=>$billid,'table_id'=>$table_id);
	       $obj->delete_record("parcel_order",$where);

	       //delete capstw data
			$where = array('billid'=>$billid,'table_id'=>$table_id);
	       $obj->delete_record("cap_stw_table",$where);
	        //$ok = $obj->sendsmsGET($username,$pass,$senderid,$message,$serverUrl,$mobile2);
	}
}


?>