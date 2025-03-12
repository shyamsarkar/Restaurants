<?php include("../adminsession.php");

$table_id = $obj->test_input($_REQUEST['table_id']);
$billdetailid = $obj->test_input($_REQUEST['billdetailid']);
$checked_nc = $obj->test_input($_REQUEST['checked_nc']);
//print_r($_REQUEST);die;


if($billdetailid > 0)
{
	 if($checked_nc==0)
	 {
	 	$checked_nc1 = 1;
	 }
	 if($checked_nc==1)
	 {
	 	$checked_nc1 = 0;
	 }
	  //update Qty
        $form_data = array('checked_nc'=>$checked_nc1);
        $where = array('table_id'=>$table_id,'billdetailid'=>$billdetailid);
        $obj->update_record("bill_details",$where,$form_data);
}
      

?>