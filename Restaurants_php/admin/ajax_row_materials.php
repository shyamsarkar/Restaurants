<?php include("../adminsession.php");
$fun = $_POST['fun'];
if ($fun=="inser_row_material") {
	$myArray = array(
		"product_raw"=>$_POST['product_raw'],
		"rawm_qty"=>$_POST['rawm_qty'],
		"product_id"=>$_POST['product_id'],
		"unit_id"=>$_POST['unit_id']
	);
	$whereDbl = array("product_id"=>$_POST['product_id'],"product_raw"=>$_POST['product_raw']);
	$check_dubl = $obj->count_method("raw_materialmaster",$whereDbl);
	if ($check_dubl == 0) {
		$result = $obj->insert_record("raw_materialmaster", $myArray);
		if ($result > 0) {
			echo "ADDED_SUCCESSFULLY";
		}
	}else{
		echo "ALREDY_EXIST";
	}
	

}

if ($fun=="fetch_row_materials") {
	$product_id = $_POST['product_id'];
	$where = array("product_id"=>$product_id);
    $row_material = $obj->select_data("raw_materialmaster",$where);
	?>
	<table class="table table-bordered">
    <thead>
      <tr>
        <th>Product Name</th>
        <th>Row Material</th>
        <th>Qty</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php
    	
    	foreach ($row_material as $mrow) {   
    	$product_name = $obj->getvalfield("m_product","product_name","product_id=".$mrow['product_id']); 
    	$row_material_name = $obj->getvalfield("m_product","product_name","product_id=".$mrow['product_raw']); 	
    	?>
      <tr>
        <td><?php echo $product_name; ?></td>
        <td><?php echo $row_material_name; ?></td>
        <td><?php echo $mrow['rawm_qty']; ?></td>
        <td><img src="logo/del.png" width="20" style="cursor: pointer;" onclick="delete_rowmaterial(<?php echo $mrow['raw_materialid']; ?>);"></td>
      </tr>
     <?php } ?>
    </tbody>
  </table>
  <?php
}


if ($fun=="delete_row_materials") {
	$where = array("raw_materialid"=>$_POST['id']);
	$result = $obj->delete_record("raw_materialmaster",$where);
	// if ($result > 0) {
	// 	echo "DELETE_SUCCESSFULLY";
	// }
}

?>