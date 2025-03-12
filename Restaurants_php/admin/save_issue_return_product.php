<?php
include("../adminsession.php");
$ret_qty = trim(addslashes($_REQUEST['ret_qty']));
$raw_id = trim(addslashes($_REQUEST['raw_id']));
$ret_date = $obj->dateformatusa($_REQUEST['ret_date']);
$unit_name = trim(addslashes($_REQUEST['unit_name']));
if (!empty($raw_id)) {
	$form_data = array('raw_id' => $raw_id, 'unit_name' => $unit_name, 'ret_qty' => $ret_qty, 'ret_date' => $ret_date, 'ipaddress' => $ipaddress, 'createdate' => $createdate, 'createdby' => $loginid);
	$obj->insert_record("issue_return", $form_data);
	$action = 1;
}
