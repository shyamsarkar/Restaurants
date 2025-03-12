<?php
include("../adminsession.php");
$tblname = "m_product";
$tblpkey = "product_id";
$servicename = test_input($_REQUEST['servicename']);  
$rate = test_input($_REQUEST['rate']);
$disc = test_input($_REQUEST['disc']);
$barcode = test_input($_REQUEST['barcode']); 
$pcatid = test_input($_REQUEST['pcatid']); 
$service_type = test_input($_REQUEST['service_type']); 
$unitid = test_input($_REQUEST['unitid']);
$cgst = test_input($_REQUEST['cgst']); 
$sgst = test_input($_REQUEST['sgst']); 
$igst = test_input($_REQUEST['igst']); 
$enable='enable';?>