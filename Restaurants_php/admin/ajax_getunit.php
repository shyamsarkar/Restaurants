<?php include("../adminsession.php");

$row_id = $obj->test_input($_REQUEST['row_id']);
//print_r($_REQUEST);die;
if($row_id > 0)
{
	$unitid = $obj->getvalfield("raw_material","unitid","raw_id='$row_id'");
    $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
    echo $unit_name;
}
 
?>