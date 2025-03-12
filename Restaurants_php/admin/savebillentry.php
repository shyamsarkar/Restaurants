<?php
include("../adminsession.php");
$productid=$_REQUEST['productid'];
$unitid=$_REQUEST['unitid'];
$qty=$_REQUEST['qty'];
$rate=$_REQUEST['rate'];
$zomato=$_REQUEST['zomato'];
$table_id=$_REQUEST['table_id'];
$tblname="bill_details";
$disc_percent=$_REQUEST['disc_percent'];
$disc_rs=$_REQUEST['disc_rs'];
$checked_nc=$_REQUEST['checked_nc'];


//restrict produc to add if biill is saved
$issaved = $obj->getvalfield("bills","count(*)","table_id='$table_id' and is_paid='0'");

if($issaved == 0)
 {
	if($productid !='' && $unitid !='' && $qty !='' && $rate !='' )
	{
		$foodtypeid = $obj->getvalfield("m_product","foodtypeid","productid='$productid'");
		$sgst = $obj->getvalfield("tax_setting_new","sgst","foodtypeid='$foodtypeid' and is_applicable=1");
        $cgst = $obj->getvalfield("tax_setting_new","cgst","foodtypeid='$foodtypeid' and is_applicable=1");

		$form_data = array('productid'=>$productid,'unitid'=>$unitid,'qty'=>$qty,'rate'=>$rate, 'cgst'=>$cgst, 'sgst'=>$sgst, 'table_id'=>$table_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'zomato_order'=>$zomato,'disc_percent'=>$disc_percent,'disc_rs'=>$disc_rs,'checked_nc'=>$checked_nc);
		$obj->insert_record($tblname, $form_data);
		echo '1';
		
	}
}
else
{
	echo "0";	
}

?>