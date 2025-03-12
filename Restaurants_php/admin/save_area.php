<?php
include("../adminsession.php");
$tblname = "m_area";
$tblpkey = "area_id";
//echo "hii"; die;
$city_id = $_REQUEST['city_id'];  
$area_name = $_REQUEST['area_name']; 
$area_code = $_REQUEST['area_code'];

//print_r($_REQUEST);die;

	  //save product
		$form_data = array('city_id'=>$city_id,'area_name'=>$area_name,'area_code'=>$area_code,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
			$area_id = $obj->insert_record($tblname,$form_data);
			//$form_data2 = array('area_id'=>$area_id);
			//$where = array("area_id"=>$tblpkey);
			//$keyvalue = $obj->update_record("m_area",$where,$form_data2);
 

//$res = $obj->fetch_record($tblname);

	 
?>

