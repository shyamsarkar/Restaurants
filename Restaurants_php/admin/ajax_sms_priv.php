<?php
include("../adminsession.php");
$status = $_POST['status'];
$sms_id = $_POST['sms_id'];
$where = array("sms_id"=>$sms_id);
$myArray = array("status"=>$status);
$result = $obj->update_record("sms_setting",$where,$myArray);
?>