<?php
include("../adminsession.php");
$tblname = "material_setting";
$tblpkey = "material_set_id";


$row_id = $_REQUEST['row_id'];  
$qty = $_REQUEST['qty'];  
$finish_id = $_REQUEST['finish_id'];  


//print_r($_REQUEST);die;
 $cwhere = array("finish_id"=>$_REQUEST['finish_id'],"row_id"=>$_REQUEST['row_id']);
    $count = $obj->count_method("material_setting",$cwhere);
    if($count > 0 )
    {
    	echo "4";

    } 
    else{
        //save product
        $form_data = array('finish_id'=>$finish_id,'row_id'=>$row_id,'qty'=>$qty,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
        $obj->insert_record($tblname,$form_data);
        //$action=1;
}
?>







