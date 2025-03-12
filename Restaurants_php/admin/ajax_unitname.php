<?php include("../adminsession.php");
$productid = $obj->test_input($_REQUEST['productid']);
if($productid > 0)
{
	$unitid = $obj->getvalfield("m_product","unitid","productid='$productid'");
	echo $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
}

?>