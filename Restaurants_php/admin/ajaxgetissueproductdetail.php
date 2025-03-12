<?php include("../adminsession.php");

$product_id=trim(addslashes($_REQUEST['product_id']));
if($product_id !='')
	{
			$unit_id =$obj->getvalfield("m_product","unit_id","product_id='$product_id'");
			$unit_name=$obj->getvalfield("m_unit","unit_name","unit_id='$unit_id'");
            $rate_amt = $obj->getvalfield("m_product","product_rate","product_id='$product_id'");
		 echo $unit_name."|".$rate_amt;
	}
	?>