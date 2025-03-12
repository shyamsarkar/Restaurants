<?php
include("../adminsession.php");

$tblname = "cap_stw_table";
$tblpkey = "cap_stw_id";
//echo "hii"; die;
$table_id = $obj->test($_REQUEST['table_id']);
$waiter_id_cap = $obj->test($_REQUEST['waiter_id_cap']);
$waiter_id_stw = $obj->test($_REQUEST['waiter_id_stw']);
$cap_stw_id = $obj->getvalfield("cap_stw_table", "count(cap_stw_id)", "table_id='$table_id'");
/*$cap_stw_id = $obj->getvalfield("cap_stw_table","count(cap_stw_id)","table_id='$table_id' and close_order=0");*/
//print_r($_REQUEST);die;
/*if($waiter_id_cap > 0 && $waiter_id_stw > 0)
{
	//save 
  $form_data = array('table_id'=>$table_id,'waiter_id_cap'=>$waiter_id_cap,'waiter_id_stw'=>$waiter_id_stw,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
    $obj->insert_record($tblname,$form_data);
}*/
// delete all table setting 

$where = array('table_id' => $table_id);
$obj->delete_record($tblname, $where);
/*if($cap_stw_id == 0)
{*/




if ($table_id == 'all') {


  $sql = $obj->executequery("select * from m_table");
  $count = sizeof($sql);
  if ($count > 0) {
    foreach ($sql as $key) {
      $where = array('table_id' => $key['table_id']);
      $obj->delete_record($tblname, $where);
      //save 
      $form_data = array('table_id' => $key['table_id'], 'waiter_id_cap' => $waiter_id_cap, 'waiter_id_stw' => $waiter_id_stw, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
      $obj->insert_record($tblname, $form_data);
    }
  }
} else {

  //save 
  $form_data = array('table_id' => $table_id, 'waiter_id_cap' => $waiter_id_cap, 'waiter_id_stw' => $waiter_id_stw, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
  $obj->insert_record($tblname, $form_data);

  //update 
  /*$form_data = array('waiter_id_cap'=>$waiter_id_cap,'waiter_id_stw'=>$waiter_id_stw,'lastupdated'=>$createdate);
  $where = array('table_id'=>$table_id);
    $obj->update_record($tblname,$where,$form_data);*/
  //echo "0";
}
//}
