<?php 
include("../../adminsession.php");
//print_r($_SESSION); die;
//include("../../lib/smsinfo.php");

$loginid = $_SESSION['userid']; 
$username1 = $obj->getvalfield("user","username","userid='$loginid'");

$billid =$_REQUEST['id'];
$tblname =$_REQUEST['tblname'];
$tblpkey =$_REQUEST['tblpkey'];
$module =$_REQUEST['module'];
$submodule =$_REQUEST['submodule'];
$res = $obj->executequery("Select * from bills  where billid='$billid'");
foreach($res as $row_get)
{
	$billnumber = $row_get['billnumber'];
	$billdate = $obj->dateformatindia($row_get['billdate']);
	$basic_bill_amt = $row_get['basic_bill_amt'];
	$table_id = $row_get['table_id'];
	$table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");
	$del_date = date('d-m-Y');
  
}
//print_r($_REQUEST);die;
$where = array($tblpkey=>$billid);
$obj->delete_record("kot_entry",$where);

$where = array($tblpkey=>$billid);
$obj->delete_record("bill_details",$where);

$where = array($tblpkey=>$billid);
$obj->delete_record($tblname,$where);

//  $msg = "Dear Admin, Bill Deleted From Sale Report\nBill No:$billnumber\nBill Date:$billdate\nBill Amount:$basic_bill_amt\nTable No:$table_no\nDeleted Date:$del_date\nDeleted By:$username1\nFrom THE CORNER HOUSE";
//   //$ok = 1;
// //7879373566
//   $ok = $obj->sendsmsGET($username,$pass,$senderid,$msg,$serverUrl,"7879373566");
//     if($ok) 
//       { 
//         echo "1";
//       }
//       else 
//       {
//         echo "0";
//       }
    
?>