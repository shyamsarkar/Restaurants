<?php
include("../adminsession.php");
$tblname = "raw_material";
$tblpkey = "raw_id";

$raw_name = $_REQUEST['raw_name'];  
$unitid = $_REQUEST['unitid']; 
$qty = $_REQUEST['qty'];
$open_date = $obj->dateformatusa($_REQUEST['open_date']);
$rate =$_REQUEST['rate'];
$product_type =$_REQUEST['product_type'];
$reorder_limit =$_REQUEST['reorder_limit'];


//print_r($_REQUEST);die;

	  //save product
		$form_data = array('raw_name'=>$raw_name,'unitid'=>$unitid,'qty'=>$qty,'open_date'=>$open_date,'rate'=>$rate,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'product_type'=>$product_type,'reorder_limit'=>$reorder_limit);
			$obj->insert_record($tblname,$form_data);
		//$lastid = $obj->insert_record_lastid($tblname,$form_data);
			//$action=1;
 
?>
<option value="">--Select--</option>
<?php 
$res = $obj->executequery("select * from raw_material order by raw_id desc");

foreach($res as $row_get)
 {
	 
?>

<option value="<?php echo $row_get['raw_id']; ?>" > <?php echo $row_get['raw_name']; ?> </option>

<?php }  ?>