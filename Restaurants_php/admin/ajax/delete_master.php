<?php include("../../adminsession.php");

$id  = (int)$obj->test($_POST['id']);
$tblname  = $obj->test($_POST['tblname']);
$tblpkey  = $obj->test($_POST['tblpkey']);
if ($id > 0) {
    $where = [$tblpkey => $id];
    $obj->delete($tblname, $where);
}
