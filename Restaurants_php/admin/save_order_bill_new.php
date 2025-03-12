<?php
include("../adminsession.php");

if (isset($_POST['table_id'])) {
	$table_id = $obj->test_input($_POST['table_id']);
	$basic_bill_amt = (float)$obj->test_input($_POST['basic_bill_amt']);
	$disc_rs = (float)$obj->test_input($_POST['disc_rs']);
	$cgst = (float)$obj->test_input($_POST['cgst']);
	$sgst = (float)$obj->test_input($_POST['sgst']);
	$disc_percent = (float)$obj->test_input($_POST['disc_percent']);
	$net_bill_amt = (float)$obj->test_input($_POST['net_bill_amt']);
	$billnumber = $obj->getcode("bills", "billid", "1=1");
	$food_amt = $obj->test_input($_POST['food_amt']);
	$bev_amt = (float)$obj->test_input($_POST['bev_amt']);
	$checked_nc = $obj->test_input($_POST['checked_nc']);
	$waiter_id_stw = $obj->test_input($_POST['waiter_id_stw']);
	$waiter_id_cap = (int)$obj->test_input($_POST['waiter_id_cap']);
	$cust_name = $obj->test_input($_POST['cust_name']);
	$cust_mobile = $obj->test_input($_POST['cust_mobile']);
	$gst_no = $obj->test_input($_POST['gst_no']);

	$billdate = $obj->getvalfield("day_close", "day_date", "1=1");
	$billtime =  date("h:i A");

	$is_parsal = $obj->getvalfield("m_table", "parcel_status", "table_id='$table_id'");
	if (!empty($table_id)) {
		//prevent duplicate Order
		$check_billed = (int)$obj->getvalfield("bills", "count(*)", "table_id='$table_id' and is_paid = 0");
		if ($check_billed > 0)
			echo 0;
		else {
			if ($checked_nc == 1) {
				$is_paid = 1;
				$nc_amount = $net_bill_amt;
				$paydate = $billdate;
				$is_parcel_order = 0;
			} elseif ($is_parsal > 0) {
				$is_parcel_order = 1;
				$is_paid = 1;
				$nc_amount = 0;
				$paydate = $billdate;
			} else {
				$is_paid = 0;
				$nc_amount = 0;
				$paydate = "0000-00-00";
				$is_parcel_order = 0;
			}

			$form_data = array('table_id' => $table_id, 'billdate' => $billdate, 'billtime' => $billtime, 'billnumber' => $billnumber, 'ipaddress' => $ipaddress, 'createdate' => $createdate, 'net_bill_amt' => $net_bill_amt, 'basic_bill_amt' => $basic_bill_amt, 'food_amt' => $food_amt, 'bev_amt' => $bev_amt, 'disc_rs' => $disc_rs, 'cgst' => $cgst, 'sgst' => $sgst, 'checked_nc' => $checked_nc, 'nc_amount' => $nc_amount, 'is_paid' => $is_paid, 'paydate' => $paydate, 'disc_percent' => $disc_percent, 'is_parcel_order' => $is_parcel_order, 'waiter_id_stw' => $waiter_id_stw, 'waiter_id_cap' => $waiter_id_cap, 'cust_name' => $cust_name, 'cust_mobile' => $cust_mobile, 'gst_no' => $gst_no);

			$bill_id = $obj->insert_id("bills", $form_data);

			//Update Bill Details
			$where = array('table_id' => $table_id, 'billid' => 0);
			$data = array('billid' => $bill_id);
			$obj->update("bill_details", $where, $data);

			//update billid to kot table
			$obj->update("kot_entry", $where, $data);

			//Pending KOT
			$check_pending_kot = $obj->getvalfield("bill_details", "count(*)", "table_id='$table_id' and kotid = 0");
			if ($check_pending_kot > 0) {
				//kot update_record
				$form_data = array('table_id' => $table_id, 'kotdate' => $billdate, 'kottime' => $billtime, 'billid' => $bill_id);
				$lastkotid = $obj->insert_id("kot_entry", $form_data);
				// bill details in kotid update
				$qry = array('kotid' => $lastkotid);
				$where = array('table_id' => $table_id, 'billid' => $bill_id, 'kotid' => 0);
				$obj->update('bill_details', $where, $qry);
			}



			if ($checked_nc > 0) {
				//update payment data case of n/c
				$form_data = array('isbilled' => 1);
				$where = array('billid' => $bill_id);
				$obj->update("bill_details", $where, $form_data);
			}

			// parcel order update_record
			$where1 = array('table_id' => $table_id, 'close_order' => 0, 'billid' => 0);
			$data1 = array('billid' => $bill_id);
			$obj->update("parcel_order", $where1, $data1);

			// cap stw table order update_record
			$obj->update("cap_stw_table", $where1, $data1);

			if ($is_parsal > 0) {
				//update payment data case of n/c
				$form_data = array('isbilled' => 1);
				$where = array('billid' => $bill_id);
				$obj->update("bill_details", $where, $form_data);

				// parcel order update_record
				$where1 = array('table_id' => $table_id, 'close_order' => 0, 'billid' => $bill_id);
				$data1 = array('close_order' => 1);
				$obj->update("parcel_order", $where1, $data1);
			}

			echo $bill_id;
		}
	}
}
