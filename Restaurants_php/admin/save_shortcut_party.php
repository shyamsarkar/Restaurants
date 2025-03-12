<?php
include("../adminsession.php");
$tblname = "master_customer";
$tblpkey = "customer_id";
$customer_type = $_REQUEST['customer_type']; 
$customer_name = $_REQUEST['customer_name']; 
$mobile = $_REQUEST['mobile'];
$cgst = $_REQUEST['cgst'];
$sgst =$_REQUEST['sgst'];
$igst = $_REQUEST['igst']; 
$address = $_REQUEST['address']; 
$email = $_REQUEST['email']; 
$panno = $_REQUEST['panno']; 
$gsttinno = $_REQUEST['gsttinno'];
$openingbal =  $_REQUEST['openingbal'];
//print_r($_REQUEST);die;

	  //save product
		$form_data = array('customer_name'=>$customer_name,'customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'panno'=>$panno,'gsttinno'=>$gsttinno,'openingbal'=>$openingbal,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			$productid = $obj->insert_record_lastid($tblname,$form_data);
			$form_data2 = array('customer_id'=>"$customer_id");
			$where = array("customer_id"=>"$customer_id");
			$keyvalue = $obj->update_record("master_customer",$where,$form_data2);
 

$res = $obj->fetch_record($tblname);
foreach($res as $row_get)
 {
	 
?>
<option value="<?php echo $row_get['customer_id']; ?>" > <?php echo $row_get['customer_name']; ?> </option>

<?php }  ?>