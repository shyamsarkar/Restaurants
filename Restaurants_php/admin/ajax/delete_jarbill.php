<?php include("../../adminsession.php");
$mjar_billid =$_REQUEST['id'];
$tblname =$_REQUEST['tblname'];
$tblpkey =$_REQUEST['tblpkey'];
$module =$_REQUEST['module'];
$submodule =$_REQUEST['submodule'];


//print_r($_REQUEST);die;
$where = array($tblpkey=>$mjar_billid);
$obj->delete_record("monthly_jar_bill_details",$where);

$where = array($tblpkey=>$mjar_billid);
$obj->delete_record($tblname,$where);

echo "<script>location='$pagename?action=3';</script>";


?>