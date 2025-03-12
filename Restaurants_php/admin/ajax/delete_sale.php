<?php include("../../adminsession.php");
$billid =$_REQUEST['id'];
$tblname =$_REQUEST['tblname'];
$tblpkey =$_REQUEST['tblpkey'];
$module =$_REQUEST['module'];
$submodule =$_REQUEST['submodule'];
if($billid > 0)
{
	//print_r($_REQUEST);die;
$where = array($tblpkey=>$billid);
$obj->delete_record("kot_entry",$where);

$where = array($tblpkey=>$billid);
$obj->delete_record("bill_details",$where);

$where = array($tblpkey=>$billid);
$obj->delete_record($tblname,$where);

}


?>