<?php
include("../adminsession.php");

 $pagename = basename($_SERVER['PHP_SELF']);

 
$tblpkey = "day_id";
$keyvalue = "1";
$day_date = $obj->dateformatusa($_REQUEST['day_date']); 

	//update
$count_status1 = $obj->getvalfield("bill_details","count(billid)","billid='0' or isbilled='0'");
$count_status2 = $obj->getvalfield("bills","count(billid)","is_paid='1' and paydate='' and is_parcel_order='1'");
if($count_status1 == 0 && $count_status2 == 0)
{
	$form_data = array('day_date'=>$day_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
	$where = array($tblpkey=>$keyvalue);
	$keyvalue = $obj->update_record("day_close",$where,$form_data);
	echo "1";
}

			
		
 
?>
