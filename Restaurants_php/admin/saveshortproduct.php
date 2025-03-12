<?php 
include("../adminsession.php");
$tblname = "m_product";
$tblpkey = "product_id";
$unit_id ="";
$prod_code="";

$prod_code = trim(addslashes($_REQUEST['prod_code']));  
$product_name =  trim(addslashes($_REQUEST['product_name']));
//$unit_id =  trim(addslashes($_REQUEST['unit_id'])); 
$cgst =  trim(addslashes($_REQUEST['cgst'])); 
$sgst =  trim(addslashes($_REQUEST['sgst'])); 
$igst =  trim(addslashes($_REQUEST['igst']));
$product_type =  trim(addslashes($_REQUEST['product_type'])); 
$hsnno =  trim(addslashes($_REQUEST['hsnno'])); 
$ratefrmplant =  trim(addslashes($_REQUEST['ratefrmplant'])); 
$ratefrmdelivery =  trim(addslashes($_REQUEST['ratefrmdelivery']));
$opening_stock =  trim(addslashes($_REQUEST['opening_stock'])); 
$stock_date =  trim(addslashes($_REQUEST['stock_date'])); 

if($product_name !='')
{
//echo "hiii"; 
	  //save product
		$form_data = array('prod_code'=>$prod_code,'product_name'=>$product_name,'unit_id'=>$unit_id,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'product_type'=>$product_type,'hsnno'=>$hsnno,'ratefrmplant'=>$ratefrmplant,'ratefrmdelivery'=>$ratefrmdelivery,'opening_stock'=>$opening_stock,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
	 	$obj->insert_record($tblname,$form_data);
				$action=1;
				$process = "insert";
			  }
//	}
	
 ?>
