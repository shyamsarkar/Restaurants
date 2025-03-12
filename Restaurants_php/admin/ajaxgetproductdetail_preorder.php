<?php include("../adminsession.php");

$productid=$obj->test_input($_REQUEST['productid']);



	if($productid !='')
	{
		$unit_id=$obj->getvalfield("m_product","unitid","productid='$productid'");
        $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unit_id'");
		$purches_rate=$obj->getvalfield("m_product","rate","productid='$productid'");
		$cgst=$obj->getvalfield("m_product","cgst","productid='$productid'");
		$sgst=$obj->getvalfield("m_product","sgst","productid='$productid'");
		$igst=0;
		$inc_or_exc=$obj->getvalfield("m_product","taxtype","productid='$productid'");

		echo $unit_id."|".$unit_name."|".$purches_rate."|".$cgst."|".$sgst."|".$igst."|".$inc_or_exc;
	}

?>