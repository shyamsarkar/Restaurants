<?php include("../adminsession.php");

$tblname = "parcel_order";
$tblpkey = "parcel_id";
$table_id = $obj->test($_GET['table_id']);
$order_number = $obj->test($_GET['order_number']);
$otp = $obj->test($_GET['otp']);
$rider_name = $obj->test($_GET['rider_name']);

if ($table_id > 0 && $order_number != '' && $otp != "") {

  //save product
  $form_data = array('table_id' => $table_id, 'order_number' => $order_number, 'otp' => $otp, 'rider_name' => $rider_name, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
  echo $parcel_id = $obj->insert_record_lastid($tblname, $form_data);
} else {
  echo "0";
}
