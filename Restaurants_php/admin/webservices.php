<?php
include("../action.php");

$currdate = date('Y-m-d');
$currtime = date('h:i:s');
$currdatetime = date('Y-m-d h:i:s');

$login_success = "FALSE";
$res=array();
$msg = "failed";

if(isset($_REQUEST['tag']))
$tag = addslashes(trim($_REQUEST['tag']));
else
$tag = "";

if(isset($_REQUEST['token']))
$token = addslashes(trim($_REQUEST['token']));
else
$token = "";



if($token == "watermelon")
{
	if($tag!="")
	{
		//login check 
		if($tag == 'login')
		{
			$username = addslashes(trim($_REQUEST['username']));
			$password = addslashes(trim($_REQUEST['password']));
			if($username!="" && $password!="")
			{
				$is_exist = $obj->getvalfield("user","count(*)","username='$username' and password='$password'");

				if($is_exist>0)
				{
					$where = array('username'=>$username,'password'=>$password,'logintype'=>'appuser');
					$res = $obj->select_data("user",$where);
					$msg = "Logged in sucess";
					$login_success = "TRUE";
					
				}
				
			}
		}//END LOGIN

		//production entry
		if($tag == 'production')
		{
			$qrcode = addslashes(trim($_REQUEST['qrcode']));
			$userid = addslashes(trim($_REQUEST['userid']));

			if($qrcode!="" && $userid!="")
			{
				$qrcode_arr = explode("/", $qrcode);
				$prod_code = $qrcode_arr[0];
				$seprator_alphabet = $qrcode_arr[1];
				$last_qrcode = $qrcode_arr[2];
				$produced_qty = 1;
				$production_date = $currdate;

				//check duplicate qr code entry
				$is_exist = $obj->getvalfield("production","count(*)","qrcode='$qrcode'");
				//die;
				if($is_exist == 0)
				{
					//echo $prod_code;
					//die;
					$product_id = $obj->getvalfield("m_product","product_id","prod_code = '$prod_code'");
					//die;
					if($product_id!="")
					{
						$fields = array('createdby'=>$userid,'qrcode'=>$qrcode,'product_id'=>$product_id,'produced_qty'=>$produced_qty,'production_date'=>$production_date,'createdate'=>$currdatetime,'production_remarks'=>'Entry From App');
						$obj->insert_record("production", $fields);
						$msg = "sucessfull";
						$login_success = "TRUE";
					}
					else
						$msg="Invalid qr code";
				}//isexist close
				else
					$msg="Duplicate qr code";
				
			}
		}//END PRODUCTION


		//dispatch entry
		if($tag == 'dispatch')
		{
			$qrcode = addslashes(trim($_REQUEST['qrcode']));
			$userid = addslashes(trim($_REQUEST['userid']));
			$vid = addslashes(trim($_REQUEST['vid']));
			$process_type = "dispatch";

			if($qrcode!="" && $userid!="" && $vid!="")
			{
				$qrcode_arr = explode("/", $qrcode);
				$prod_code = $qrcode_arr[0];
				$seprator_alphabet = $qrcode_arr[1];
				$last_qrcode = $qrcode_arr[2];
				$disp_qty = 1;
				$disp_date = $currdate;

				//check duplicate qr code entry
				$returned_pending = $obj->getvalfield("dispatch_entry","count(*)","qrcode='$qrcode' and is_return=0 and process_type = '$process_type'");

				if($returned_pending == 0)
				{
					$product_id = $obj->getvalfield("m_product","product_id","prod_code='$prod_code'");
					if($product_id!="")
					{
						$fields = array('createdby'=>$userid,'qrcode'=>$qrcode,'product_id'=>$product_id,'disp_qty'=>$disp_qty,'disp_date'=>$disp_date,'createdate'=>$currdatetime,'disp_remarks'=>'Entry From App','vid'=>$vid,'process_type'=>$process_type);
						$obj->insert_record("dispatch_entry", $fields);
						$msg = "sucessfull";
						$login_success = "TRUE";
					}
					else
						$msg="Qr Code Invalid";
				}//isexist close
				else
					$msg="Dispatch Return is Pending For This Product";
				
			}
		}//END dispatch return


		//dispatch return 
		if($tag == 'return')
		{
			$qrcode = addslashes(trim($_REQUEST['qrcode']));
			$userid = addslashes(trim($_REQUEST['userid']));
			$process_type = 'dispatch';
			//$vid = addslashes(trim($_REQUEST['vid']));

			if($qrcode!="" && $userid!="")
			{
				$qrcode_arr = explode("/", $qrcode);
				$prod_code = $qrcode_arr[0];
				$seprator_alphabet = $qrcode_arr[1];
				$last_qrcode = $qrcode_arr[2];
				$returndate = $currdate;
				

				//check duplicate qr code entry
				$check_exist = $obj->getvalfield("dispatch_entry","count(*)","qrcode='$qrcode'");
				if($check_exist > 0)
				{
					$product_id = $obj->getvalfield("m_product","product_id","prod_code='$prod_code'");
					if($product_id!="")
					{
						$where = array('qrcode'=>$qrcode,'process_type'=>$process_type);
						$fields = array('is_return'=>'1','returnedby'=>$userid,'returndate'=>$returndate);
						$obj->update_record("dispatch_entry",$where,$fields);
						$msg = "sucessfull";
						$login_success = "TRUE";
					}
					else
						$msg="Qr Code Invalid";
				}//isexist close
				else
					$msg="Qr Code Not Found";
				
			}
		}//END dispatch 

		//delivery to customer
		if($tag == 'delivery')
		{
			$qrcode = addslashes(trim($_REQUEST['qrcode']));
			$userid = addslashes(trim($_REQUEST['userid']));
			$vid = addslashes(trim($_REQUEST['vid']));
			$process_type = "delivery";

			if($qrcode!="" && $userid!="" && $vid!="")
			{
				$qrcode_arr = explode("/", $qrcode);
				$prod_code = $qrcode_arr[0];
				$seprator_alphabet = $qrcode_arr[1];
				$last_qrcode = $qrcode_arr[2];
				$disp_qty = 1;
				$disp_date = $currdate;

				//check duplicate qr code entry
				$returned_pending = $obj->getvalfield("dispatch_entry","count(*)","qrcode='$qrcode' and is_return=0 and process_type = '$process_type'");

				if($returned_pending == 0)
				{
					$product_id = $obj->getvalfield("m_product","product_id","prod_code='$prod_code'");
					if($product_id!="")
					{
						$fields = array('createdby'=>$userid,'qrcode'=>$qrcode,'product_id'=>$product_id,'disp_qty'=>$disp_qty,'disp_date'=>$disp_date,'createdate'=>$currdatetime,'disp_remarks'=>'Entry From App','vid'=>$vid,'process_type'=>$process_type);
						$obj->insert_record("dispatch_entry", $fields);
						$msg = "sucessfull";
						$login_success = "TRUE";
					}
					else
						$msg="Qr Code Invalid";
				}//isexist close
				else
					$msg="Delivery Return is Pending For This Product";
				
			}
		}//END dispatch


		// return from customer
		if($tag == 'delivery-return')
		{
			$qrcode = addslashes(trim($_REQUEST['qrcode']));
			$userid = addslashes(trim($_REQUEST['userid']));
			$process_type = "delivery";

			//$vid = addslashes(trim($_REQUEST['vid']));

			if($qrcode!="" && $userid!="")
			{
				$qrcode_arr = explode("/", $qrcode);
				$prod_code = $qrcode_arr[0];
				$seprator_alphabet = $qrcode_arr[1];
				$last_qrcode = $qrcode_arr[2];
				$returndate = $currdate;

				//check duplicate qr code entry
				$check_exist = $obj->getvalfield("dispatch_entry","count(*)","qrcode='$qrcode'");
				if($check_exist > 0)
				{
					$product_id = $obj->getvalfield("m_product","product_id","prod_code='$prod_code'");
					if($product_id!="")
					{
						$where = array('qrcode'=>$qrcode,'process_type'=>$process_type);
						$fields = array('is_return'=>'1','returnedby'=>$userid,'returndate'=>$returndate);
						$obj->update_record("dispatch_entry",$where,$fields);
						$msg = "sucessfull";
						$login_success = "TRUE";
					}
					else
						$msg="Qr Code Invalid";
				}//isexist close
				else
					$msg="Qr Code Not Found";
				
			}
		}//END dispatch 


		//GET VEHICLE 
		if($tag == 'get_vehicle')
		{
			$res2 = $obj->executequery("select vid, vehicle_number from  vehicle_entry");
			foreach ($res2 as $key) {
				$vid = $key['vid'];
				$vehicle_number = $key['vehicle_number'];
				
				$qty = $obj->getvalfield("dispatch_entry","sum(disp_qty)","vid=$vid and process_type = 'dispatch' and disp_date = '$currdate'");
				
				if($qty == "")
				$qty = 0;

				array_push($res, array('vid'=>$vid, 'vehicle_number'=>$vehicle_number, 'qty'=>$qty));

			}
			$msg = "sucessfull";
			$login_success = "TRUE";
		}//vehcle list end


		//GET VEHICLE 
		if($tag == 'get_customer')
		{
			$res = $obj->executequery("select * from  master_customer where customer_type = 'customer' or customer_type='both' order by customer_name");
			$msg = "sucessfull";
			$login_success = "TRUE";

		}//vehcle list end


		//GET VEHICLE 
		if($tag == 'get_count')
		{
			$disp_date = date('Y-m-d');
			//disp and disp return
			$dispatch = $obj->getvalfield("dispatch_entry","count(*)","process_type = 'dispatch' and disp_date = '$disp_date'");
			$dispatch_return = $obj->getvalfield("dispatch_entry","count(*)","process_type = 'dispatch'
			 and returndate = '$disp_date' and is_return = 1");

			//del and del return
			$delivery = $obj->getvalfield("dispatch_entry","count(*)","process_type = 'delivery' and disp_date = '$disp_date'");
			$delivery_return = $obj->getvalfield("dispatch_entry","count(*)","process_type = 'delivery' and returndate = '$disp_date' and is_return = 1");
			
			$res = array("dispatch"=>$dispatch,"dispatch_return"=>$dispatch_return,"delivery"=>$delivery,"delivery_return"=>$delivery_return);
			// $res['dispatch'] = $dispatch;
			// $res['dispatch_return'] = $dispatch_return;
			// $res['delivery'] = $delivery;
			// $res['delivery_return'] = $delivery_return;

			$msg = "sucessfull";
			$login_success = "TRUE";
		}//vehcle list end


		if($tag == 'get_app_privilege')
		{
			$userid = addslashes(trim($_REQUEST['userid']));
			$isexist = $obj->getvalfield("app_user_previlleg","count(*)","userid='$userid'");
			if($isexist > 0)
			{	
				$res = $obj->executequery("select * from  app_user_previlleg where userid = '$userid'");
				$msg = "sucessfull";
				$login_success = "TRUE";
			}
			else
			$msg = "User Not Found";
		}//vehcle list end

	}
	else
		$msg = "tag missing";
}
else
	$msg= "token missing";



echo json_encode(array("sucess"=>$login_success,"msg"=>$msg,"data"=>$res));

?>
            	

 