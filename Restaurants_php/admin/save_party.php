<?php
include("../adminsession.php");
$tblname = "master_supplier";
$tblpkey = "supplier_id";


$supplier_name = $_REQUEST['supplier_name'];  
$mobile = $_REQUEST['mobile']; 
$address = $_REQUEST['address'];

$email = $_REQUEST['email'];
$bank_name =$_REQUEST['bank_name'];
$bank_ac = $_REQUEST['bank_ac']; 
$ifsc_code = $_REQUEST['ifsc_code']; 
$bank_address = $_REQUEST['bank_address']; 
$state_id = $_REQUEST['state_id']; 
$supplier_status = "enable";

//print_r($_REQUEST);die;
 $cwhere = array("supplier_name"=>$_REQUEST['supplier_name']);
    $count = $obj->count_method("master_supplier",$cwhere);
    if($count > 0 )
    {
    	echo "4";

    } 
    else{
if($tblpkey!=""){
	  //save product
		$form_data = array('supplier_name'=>$supplier_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'bank_name'=>$bank_name,'bank_ac'=>$bank_ac,'ifsc_code'=>$ifsc_code,'bank_address'=>$bank_address,'state_id'=>$state_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'supplier_status'=>$supplier_status);
			$lastid = $obj->insert_record_lastid($tblname,$form_data);
			//$action=1;
			
}
}
?>
<option value="">--Select--</option>
<?php 
$res = $obj->executequery("select * from master_supplier order by supplier_id desc");
foreach($res as $row_get)

 {
?>
 	<option <?php if($lastid == $row_get['supplier_id']){ echo "selected";} ?> value="<?php echo $row_get['supplier_id']; ?>" > <?php echo $row_get['supplier_name']; ?> </option>


<?php }  ?>






