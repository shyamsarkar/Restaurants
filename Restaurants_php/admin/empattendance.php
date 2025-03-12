<?php include("../adminsession.php");
$waiter_id = trim(addslashes($_REQUEST['waiter_id']));
$attendance_date = $obj->dateformatusa(trim(addslashes($_REQUEST['attendance_date'])));
$attendance_time=date('H:i:s');
$attendance_stamp=date('Y-m-d H:i:s');

$machine_userid = $obj->getvalfield("m_waiter","biometric_id","waiter_id='$waiter_id'");
if($waiter_id !='0')
{
	$count=$obj->getvalfield("attendance_entry","count(*)","attendance_date='$attendance_date' && waiter_id='$waiter_id'");
	
	if($count==0)
	{

		$form_data = array('waiter_id'=>$waiter_id,'attendance_time'=>$attendance_time,'attendance_date'=>$attendance_date,'ipaddress'=>$ipaddress,'sessionid'=>$sessionid,'attendance_stamp'=>$attendance_stamp,'machine_userid'=>$machine_userid,'createdate'=>$createdate);
        $obj->insert_record("attendance_entry",$form_data);
		$msg="Present";
		$arrayName = array('status' => $msg,'date'=> $attendance_date,'time'=> $attendance_time);
	}
	else
	{
		$where = array('attendance_date'=>$attendance_date,'waiter_id'=>$waiter_id);
		$obj->delete_record("attendance_entry",$where);
		$msg="Absent";
		$arrayName = array('status' => $msg,'date'=> '','time'=> '');
	}
	echo json_encode($arrayName);
	//echo $msg;
	
}
?>