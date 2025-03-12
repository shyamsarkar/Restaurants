<?php
include("../adminsession.php");
$tblname = "m_department";
$tblpkey = "department_id";
$department_name= $obj->test_input($_REQUEST['department_name']);

	if($tblpkey == 0){
	$form_data = array('department_name'=>$department_name,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
		
	//$obj->insert_record($tblname,$form_data);
	$lastid = $obj->insert_record_lastid($tblname,$form_data);
	$action=1;
}
?>

<option value="">--Select--</option>
<?php
	$res = $obj->fetch_record($tblname);
		foreach($res as $row_get)

			{
			?>
			<option <?php if($lastid == $row_get['department_id']){ echo "selected";} ?> value="<?php echo $row_get['department_id']; ?>"><?php echo $row_get['department_name']; ?></option>
			<?php
			}
			?>
