<?php include("../adminsession.php");

$product_id=trim(addslashes($_REQUEST['product_id']));
$type=trim(addslashes($_REQUEST['type']));
$customer_id = trim(addslashes($_REQUEST['customer_id']));
//echo $type; 
if($product_id !='')
	{
		 $unit_id =$obj->getvalfield("m_product","unit_id","product_id='$product_id'");
		$unit_name=$obj->getvalfield("m_unit","unit_name","unit_id='$unit_id'");
			
			$cgst=$obj->getvalfield("m_product","cgst","product_id='$product_id'");
			$sgst=$obj->getvalfield("m_product","sgst","product_id='$product_id'");	
			$igst=$obj->getvalfield("m_product","igst","product_id='$product_id'");	

			if($type=="ratefrmplant") 
			{
				//check into rate setting
			 	$rate_amt = $obj->getvalfield("rate_setting","company_rate","product_id='$product_id' and customer_id='$customer_id'");	

			 	//if rate not available, get it from product table
			 	if($rate_amt == "")
			 	$rate_amt = $obj->getvalfield("m_product","ratefrmplant","product_id='$product_id'");
			}

			if($type=="ratefrmdelivery") 
			{
				//check into rate setting
				$rate_amt=$obj->getvalfield("rate_setting","delivery_rate","product_id='$product_id' and customer_id='$customer_id'");	
				//if rate not available, get it from product table
				if($rate_amt == "")
				$rate_amt=$obj->getvalfield("m_product","ratefrmdelivery","product_id='$product_id'");
			}
		
		 echo $unit_name."|".$rate_amt."|".$cgst."|".$sgst."|".$igst;
			
	}
	?>