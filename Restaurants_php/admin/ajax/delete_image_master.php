<?php include("../../adminsession.php");
$id  = $_REQUEST['id'];
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
$imgpath = $_REQUEST['imgpath'];
$where = array($tblpkey => $id);

$res = $obj->select_data($tblname, $where);
foreach ($res as $rowimg) {
	$oldimg = $rowimg['imgname'];
	if (!empty($oldimg)) {
		unlink("../uploaded/img/" . $oldimg);
	}
	$where = array($tblpkey => $id);
	$keyvalue = $obj->delete_record($tblname, $where);
	if ($keyvalue) {
		echo "<script>location='$pagename?action=3';</script>";
	}
}
