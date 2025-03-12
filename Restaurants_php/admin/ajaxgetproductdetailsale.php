<?php include("../adminsession.php");

$product_id=trim(addslashes($_REQUEST['product_id']));
//$purchase_type=trim(addslashes($_REQUEST['purchase_type']));


	if($product_id !='')
	{
		$unit_id=$obj->getvalfield("m_product","unit_id","product_id='$product_id'");
        $unit_name=$obj->getvalfield("m_unit","unit_name","unit_id='$unit_id'");
		$sale_rate=$obj->getvalfield("m_product","sale_rate","product_id='$product_id'");
		$cgst=$obj->getvalfield("m_product","cgst","product_id='$product_id'");
		$sgst=$obj->getvalfield("m_product","sgst","product_id='$product_id'");
		$igst=$obj->getvalfield("m_product","igst","product_id='$product_id'");
		$inc_or_exc=$obj->getvalfield("m_product","taxtype","product_id='$product_id'");

		echo $unit_id."|".$unit_name."|".$sale_rate."|".$cgst."|".$sgst."|".$igst."|".$inc_or_exc;
	}

?>