<?php
include("../adminsession.php");
$column = $_POST['column'];
$userid = $_POST['userid'];

$where = array("previd"=>$previd);
$myArray = array("production"=>$production,"dispatch"=>$dispatch,"dispatch_return"=>$dispatch_return,"delivery"=>$delivery,"delivery_return"=>$delivery_return);
$result = $obj->update_record("app_user_previlleg",$where,$myArray);
?>