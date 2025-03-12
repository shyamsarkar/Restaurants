<?php include("../adminsession.php");

$purchaseid=trim(addslashes($_REQUEST['purchaseid']));
//$purchase_type=trim(addslashes($_REQUEST['purchase_type']));


	// if($purchaseid !='')
	// {
		// $product_id=$obj->getvalfield("purchasentry_detail","product_id","purchaseid='$purchaseid'");
  //       $product_name=$obj->getvalfield("m_product","product_name","product_id='$product_id'");
        
		// echo $product_name; 
	// }
	 if($purchaseid !='')
	{
   $sql = $obj->executequery("select * from purchasentry_detail where purchaseid='$purchaseid'");
   foreach ($sql as $row) {
   	 // $product_id=$obj->getvalfield("purchasentry_detail","product_id","purchaseid='$purchaseid'");
   	$product_id = $row['product_id'];
        $product_name=$obj->getvalfield("m_product","product_name","product_id='$product_id'");
        
   ?>
   <option value="<?php echo $product_id; ?>"><?php echo $product_name; ?></option>
  <?php }
  
}
?>