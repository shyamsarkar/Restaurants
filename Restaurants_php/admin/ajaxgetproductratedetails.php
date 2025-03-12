<?php include("../adminsession.php");

 $product_rate=trim(addslashes($_REQUEST['product_rate']));
$product_id=trim(addslashes($_REQUEST['product_id']));
//print_r($_REQUEST);
//echo $product_id;
	if($product_rate !='' and $product_rate=="ratefrmplant")
{
	//echo "SELECT ratefrmplant FROM `m_product`"; die;
 	$sqlget = "select ratefrmplant from m_product";
	$rate_amount = mysqli_fetch_array(mysqli_query($sqlget));
	echo $rate_amount['ratefrmplant'];
}
else
	{
	$sqlget = "SELECT ratefrmdelivery FROM `m_product`";
	$rate_amount = mysqli_fetch_array(mysqli_query($sqlget));
	echo $rate_amount['ratefrmdelivery'];
	}

?>