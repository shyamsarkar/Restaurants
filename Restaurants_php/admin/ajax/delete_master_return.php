<?php include("../../adminsession.php");
//print_r($_REQUEST); die;
$purchaseid  = $_POST['purchaseid'];
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
 
  $form_data = array('ret_qty'=>0);
  $where = array($tblpkey=>$id);
$keyvalue = $obj->update_record($tblname,$where,$form_data);
if($keyvalue)
 {
 	echo "<script>location='$pagename';</script>";
 }
// $where = array($tblpkey=>$id);
// $keyvalue = $obj->delete_record($tblname,$where);
// 
?>