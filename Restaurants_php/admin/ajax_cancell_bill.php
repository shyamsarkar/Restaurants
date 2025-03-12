<?php 
include("../adminsession.php");
include("../lib/smsinfo.php");
//echo $ok = $obj->sendsmsGET($username,$pass,$senderid,"hiii",$serverUrl,"8962796755");die;
//$mobile = $obj->getvalfield("company_setting","mobile","1=1");
$mobile2 = $obj->getvalfield("company_setting","mobile2","1=1");


if(isset($_REQUEST['billid']))
{
	$cancel_remark = $obj->test_input($_REQUEST['cancel_remark']);
	$billid = $obj->test_input($_REQUEST['billid']);
	
	if($billid > 0)
	{
			//update payment data
			$form_data = array('is_cancelled'=>1,'cancel_remark'=>$cancel_remark,'is_paid'=>1);
			$where = array('billid'=>$billid);
            $keyvalue = $obj->update_record("bills",$where,$form_data);

            $form_data2 = array('isbilled'=>1);
			$where2 = array('billid'=>$billid);
            $keyvalue = $obj->update_record("bill_details",$where2,$form_data2);

			echo $billid;
			if($mobile2 == 10)
			{
				$message = "Bill Cancelled";
				$ok = $obj->sendsmsGET($username,$pass,$senderid,$message,$serverUrl,$mobile2);
                if($ok) 
                { 
                echo "<script>alert('Message sent successfully!');</script>";
                }
                else 
                {
                
                echo "<script>alert('Message could not be sent. Sorry!');</script>";
                }
			}

			
	}
	else
	echo "0";
}


?>