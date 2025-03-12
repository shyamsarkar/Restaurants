<?php 
include("../../adminsession.php");

 $search_supplier= trim($_REQUEST['search_supplier']);
 $productid   = trim($_REQUEST['productid']);
 $suppartyid=$cmn->getvalfield("m_supplier_party","suppartyid","supparty_name='$search_supplier'");
  $cust_type=$cmn->getvalfield("m_supplier_party","cust_type","suppartyid='$suppartyid'"); 

if($cust_type=="wholeseller")
{
   $rate=$cmn->getvalfield("m_product","wholeseller_rate","productid='$productid'");
}
else if($cust_type=="retailer" )
{	
	 $rate=$cmn->getvalfield("m_product","rate","productid='$productid'");
}
echo $rate; 
?>