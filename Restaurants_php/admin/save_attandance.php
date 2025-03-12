<?php
include("../adminsession.php");
$is_half_day = $_REQUEST['is_half_day'];
$waiter_id = $_REQUEST['waiter_id']; 
$attendance_date = $_REQUEST['attendance_date'];
$attendance_time=date('H:i:s');

	if($is_half_day == 1)
	{
		//echo 'hii';
		$form_data = array('is_half_day'=>0);
		$where = array('waiter_id'=>$waiter_id,'attendance_date'=>$attendance_date,'is_half_day'=>1);
		$obj->update_record('attendance_entry', $where, $form_data);
		
		 $msg="Present";
		 $arrayName = array('status' => $msg,'date'=> '','time'=> '');
		 
	   
	}
	if($is_half_day == 0)
	{
		//echo 'byy';
		$form_data = array('is_half_day'=>1);
		$where = array('waiter_id'=>$waiter_id,'attendance_date'=>$attendance_date,'is_half_day'=>0);
		$obj->update_record('attendance_entry', $where, $form_data);
		
		$msg="Present";
		$arrayName = array('status' => $msg,'date'=> $attendance_date,'time'=> $attendance_time);
		
	   
	}
	echo json_encode($arrayName);

?>







