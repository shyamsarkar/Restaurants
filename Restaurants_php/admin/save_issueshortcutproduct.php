<?php
include("../adminsession.php");
$tblname = "m_product";
$tblpkey = "product_id";
$product_name= $obj->test_input($_REQUEST['product_name']);
$category_id= $obj->test_input($_REQUEST['category_id']);
$stock_date= $obj->test_input($_REQUEST['stock_date']);
$cgst= $obj->test_input($_REQUEST['cgst']);
$sgst=$obj->test_input($_REQUEST['sgst']);  
$igst = $obj->test_input($_REQUEST['igst']);
$unit_id = $obj->test_input($_REQUEST['unit_id']);
$product_type = $obj->test_input($_REQUEST['product_type']);
$opening_stock =  $obj->test_input($_REQUEST['opening_stock']);
$hsnno = $obj->test_input($_REQUEST['hsnno']);
$taxtype = $obj->test_input($_REQUEST['taxtype']);
$reorder_limit =  $obj->test_input($_REQUEST['reorder_limit']);
$purches_rate = $obj->test_input($_REQUEST['purches_rate']);
$sale_rate =  $obj->test_input($_REQUEST['sale_rate']);

	
	if($tblpkey == 0){
			$form_data = array('product_name'=>$product_name,'category_id'=>$category_id,'stock_date'=>$stock_date,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'unit_id'=>$unit_id,'product_type'=>$product_type,'opening_stock'=>$opening_stock,'hsnno'=>$hsnno,'purches_rate'=>$purches_rate,'taxtype'=>$taxtype,'reorder_limit'=>$reorder_limit,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'sale_rate'=>$sale_rate);

			$obj->insert_record("m_product",$form_data);
			$action=1;
	}
	?>
	<option value="">--Select--</option>
	<?php 
	
        $res = $obj->fetch_record($tblname);
		foreach($res as $row_get)
			{
			?>
			<option value="<?php echo $row_get['product_id']; ?>"><?php echo $row_get['product_name']; ?></option>
			<?php
			}
			?>
