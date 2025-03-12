<?php
include("../adminsession.php");
$tblname = "master_customer";
$tblpkey = "customer_id";


$customer_name = $_REQUEST['customer_name'];  
$mobile = $_REQUEST['mobile']; 
$address = $_REQUEST['address'];
$company_id = $_REQUEST['company_id'];
$email = $_REQUEST['email'];
$bank_name =$_REQUEST['bank_name'];
$bank_ac = $_REQUEST['bank_ac']; 
$ifsc_code = $_REQUEST['ifsc_code']; 
$bank_address = $_REQUEST['bank_address']; 
$state_id = $_REQUEST['state_id']; 
$gstno = $_REQUEST['gstno']; 
$supplier_status = "enable";

//print_r($_REQUEST);die;

if($tblpkey!=""){
	  //save product
		$form_data = array('customer_name'=>$customer_name,'mobile'=>$mobile,'company_id'=>$company_id,'address'=>$address,'email'=>$email,'bank_name'=>$bank_name,'bank_ac'=>$bank_ac,'ifsc_code'=>$ifsc_code,'bank_address'=>$bank_address,'state_id'=>$state_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'gstno'=>$gstno,'supplier_status'=>$supplier_status);
			//$obj->insert_record($tblname,$form_data);
		$lastid = $obj->insert_record_lastid($tblname,$form_data);
			
			
}
?>
<option value="">--Select--</option>
<?php 
$res = $obj->fetch_record($tblname);
foreach($res as $row_get)
 {
?>
 	<option <?php if($lastid == $row_get['customer_id']){ echo "selected";} ?> value="<?php echo $row_get['customer_id']; ?>" > <?php echo $row_get['customer_name']; ?> </option>

<?php }  ?>






