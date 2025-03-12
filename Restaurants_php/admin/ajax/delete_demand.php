<?php include("../../adminsession.php");
$demand_id =$_REQUEST['id'];
$tblname =$_REQUEST['tblname'];
$tblpkey =$_REQUEST['tblpkey'];
$module =$_REQUEST['module'];
$submodule =$_REQUEST['submodule'];


//print_r($_REQUEST);die;
$where = array($tblpkey=>$demand_id);
$obj->delete_record("demand_detail",$where);

$where = array($tblpkey=>$demand_id);
$obj->delete_record($tblname,$where);

echo "<script>location='$pagename?action=3';</script>";


?>