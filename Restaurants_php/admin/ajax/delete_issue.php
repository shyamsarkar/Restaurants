<?php include("../../adminsession.php");
$issueid =$_REQUEST['id'];
$tblname =$_REQUEST['tblname'];
$tblpkey =$_REQUEST['tblpkey'];
$module =$_REQUEST['module'];
$submodule =$_REQUEST['submodule'];


//print_r($_REQUEST);die;
$where = array($tblpkey=>$issueid);
$obj->delete_record("issue_entry_details",$where);

$where = array($tblpkey=>$issueid);
$obj->delete_record($tblname,$where);

echo "<script>location='$pagename?action=3';</script>";


?>