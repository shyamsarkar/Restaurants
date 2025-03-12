<?php include("../../adminsession.php");
$purchaseid =$_REQUEST['id'];
$tblname =$_REQUEST['tblname'];
$tblpkey =$_REQUEST['tblpkey'];
$module =$_REQUEST['module'];
$submodule =$_REQUEST['submodule'];
if($purchaseid > 0)
{
	
$where = array($tblpkey=>$purchaseid);
$obj->delete_record("purchasentry_detail",$where);

$where = array($tblpkey=>$purchaseid);
$obj->delete_record($tblname,$where);

}


?>