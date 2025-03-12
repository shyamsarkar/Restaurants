<?php session_start();

class DatabaseConfiguration
{
	public $conn;
	public $server_name = "mysql";
	public $user_name = "root";
	public $password = "123";
	public $database_name = "restaurant";

	function __construct()
	{
		$this->conn = mysqli_connect($this->server_name, $this->user_name, $this->password, $this->database_name);
		if (!$this->conn) {
			die('Connection Failed:' . mysqli_connect_error());
		}
	}

	function pre($val)
	{
		echo "<pre>";
		print_r($val);
		echo "</pre>";
	}

	function sendResponse($success, $message)
	{
		$response = [
			'success' => $success,
			'message' => $message
		];
		header('Content-Type: application/json');
		echo json_encode($response);
	}


	function utc_to_ist($utc_time)
	{
		date_default_timezone_set('Asia/Kolkata');
		$indian_time = strtotime($utc_time . ' UTC');
		$indian_time_str = date('Y-m-d H:i:s', $indian_time);
		return $indian_time_str;
	}

	function getSequence($num)
	{
		return sprintf("%'.06d\n", $num + 1);
	}

	function login_method($table, $username, $password)
	{
		$sql = "SELECT * from $table WHERE username='$username' AND password='$password'";
		$query = mysqli_query($this->conn, $sql);
		$count = mysqli_num_rows($query);
		if ($count > 0) {
			$row = mysqli_fetch_array($query);
			if ($row['usertype'] == 'Admin' || $row['usertype'] == 'admin') {
				$_SESSION['usertype'] = $row['usertype'];
				$_SESSION['userid'] = $row['userid'];
			}
			return $count;
		}
	}

	function opening_bal_exp_income($from_date)
	{
		$expanse_amt = (float)$this->getvalfield("cash_in_out", "amount", "type = 'cash_out' and inout_date < '$from_date'");
		$income_amt = (float)$this->getvalfield("cash_in_out", "amount", "type = 'cash_in' and inout_date < '$from_date'");
		$openingbal = $expanse_amt - $income_amt;
		return $openingbal;
	}

	function balance_amt($supplier_id)
	{
		$cash_in =  $this->getvalfield("cash_in_out", "sum(amount)", "supplier_id='$supplier_id' and type='cash_in'");

		$cash_out =  $this->getvalfield("cash_in_out", "sum(amount)", "supplier_id='$supplier_id' and type='cash_out'");
		$balance = $cash_in - $cash_out;
		return $balance;
	}

	function getIndianCurrency(float $number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = [];
		$words = [
			0 => '', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
		];
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_length) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		$paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
		return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
	}



	function send_sms_indor($mobile, $message)

	{

		$message = urlencode($message);

		$authKey = '5126f0f2ab1769f9c4a0e3595317a6b9';
		$senderid = 'TBTSGN';

		$url = "http://msg.icloudsms.com/rest/services/sendSMS/sendGroupSms?AUTH_KEY=$authKey&message=$message&senderId=$senderid&routeId=1&mobileNos=$mobile&smsContentType=english";

		// init the resource

		$ch = curl_init();

		curl_setopt_array($ch, array(

			CURLOPT_URL => $url,

			CURLOPT_RETURNTRANSFER => true,

			CURLOPT_SSL_VERIFYHOST => 0,

			CURLOPT_SSL_VERIFYPEER => 0



		));



		//get response

		$output = curl_exec($ch);

		//Print error if any

		if (curl_errno($ch)) {

			// echo 'error:' . curl_error($ch);

		}



		curl_close($ch);

		return 1;
	}

	// for mobile app login
	function login_method_app($table, $username, $password)
	{
		//this code for checking admin login from appuser table
		$count = 0;
		$exist = 0;

		//this code is for checking employee login 
		$sql = "SELECT * from $table WHERE (mobile ='$username') AND password='$password'";
		$query = mysqli_query($this->conn, $sql);
		$count = mysqli_num_rows($query);

		if ($count > 0) {
			$row = mysqli_fetch_array($query);
			$_SESSION['waiter_id'] = $row['waiter_id'];
			//$_SESSION['user_type'] = "employee";
			$_SESSION['login_name'] = $row['waiter_name'];
			setcookie("w_username", $username, time() + (86400 * 30 * 30), "/"); // 30 days
			setcookie("w_password", $password, time() + (86400 * 30 * 30), "/"); // 30 days
			//echo $sql;die;	
			$exist = 1;
		}

		//print_r($_SESSION);die;

		//echo $exist;die;
		return $exist;
	}


	function login_method_woner($table, $username, $password)
	{
		$sql = "SELECT * from $table WHERE username ='$username' AND password='$password'";
		$query = mysqli_query($this->conn, $sql);
		$count = mysqli_num_rows($query);
		if ($count > 0) {

			$row = mysqli_fetch_array($query);


			$_SESSION['userid'] = $row['userid'];

			setcookie("username", $username, time() + (86400 * 30 * 30), "/"); // 30 days
			setcookie("password", $password, time() + (86400 * 30 * 30), "/"); // 30 days
			return $count;
			// echo $sql;die;	
		}
	}

	function get_first_letters($str)
	{
		$result = '';
		foreach (explode(' ', $str) as $word)
			if (!empty($word)) $result .= strtoupper($word[0]);
		return $result;
	}

	function uploadImage($imgpath, $docname)
	{

		if (1 == 1) {

			$doc_name = $docname['name'];
			$tm = "DOC";
			$tm .= microtime(true) * 1000;
			$ext = pathinfo($doc_name, PATHINFO_EXTENSION);
			$doc_name = $tm . "." . $ext;
			//echo $imgpath."$doc_name";die;
			if (move_uploaded_file($docname['tmp_name'], $imgpath . "$doc_name")) {
				// echo ($imgpath.$doc_name);die;
				return ($doc_name);
			} else {
				return ("");
			}
		} else {
			return ("0");
		}
	}

	function total_sundays($month, $year)
	{
		$sundays = 0;
		$total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		for ($i = 1; $i <= $total_days; $i++)
			if (date('N', strtotime($year . '-' . $month . '-' . $i)) == 7)
				$sundays++;
		return $sundays;
	}

	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function session_method($table, $username, $password)
	{
		$sql = "SELECT * from $table WHERE  username='$username' AND password='$password'";
		$query = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row;
	}

	function max_method($tbl_id, $date)
	{
		$sql = "SELECT MAX(kotnumber) FROM kot_entry WHERE tbl_id=$tbl_id AND created_date = '$date'";
		$query = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row['MAX(kotnumber)'];
	}

	function last_val($column1, $table, $column2)
	{
		$sql = "SELECT $column1 FROM $table ORDER BY $column2 DESC LIMIT 1";
		$query = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_array($query);
		return $row['billnumber'];
	}

	function gst_calculation($qty, $rate, $disc_per = 0, $cgst=0, $sgst=0, $igst=0, $inc_or_exc = 'exclusive')
	{

		$total_value =  $qty * $rate;
		$disc_amt = $total_value * $disc_per / 100;
		$taxable_value = $total_value - $disc_amt;

		if ($inc_or_exc == 'exclusive') {
			if ($sgst > 0)
				$sgst_amt = round(($taxable_value * $sgst / 100), 2);
			else
				$sgst_amt = 0;

			if ($cgst > 0)
				$cgst_amt = round(($taxable_value * $cgst / 100), 2);
			else
				$cgst_amt = 0;

			if ($igst > 0)
				$igst_amt = round(($taxable_value * $igst / 100), 2);
			else
				$igst_amt = 0;

			$final_price = $taxable_value + $sgst_amt + $cgst_amt + $igst_amt;

			$all_values = array('taxable_value' => $taxable_value, 'sgst_amt' => $sgst_amt, 'cgst_amt' => $cgst_amt, 'igst_amt' => $igst_amt, 'final_price' => $final_price);
		} else {
			$final_price = $taxable_value;
			$taxable_value = round((100 * $final_price) / (100 + $sgst + $cgst + $igst), 2);


			if ($sgst > 0)
				$sgst_amt = round(($taxable_value * $sgst / 100), 2);
			else
				$sgst_amt = 0;

			if ($cgst > 0)
				$cgst_amt = round(($taxable_value * $cgst / 100), 2);
			else
				$cgst_amt = 0;

			if ($igst > 0)
				$igst_amt = round(($taxable_value * $igst / 100), 2);
			else
				$igst_amt = 0;


			$all_values = array('taxable_value' => $taxable_value, 'sgst_amt' => $sgst_amt, 'cgst_amt' => $cgst_amt, 'igst_amt' => $igst_amt, 'final_price' => $final_price);
		}

		return ($all_values);
		// echo $all_values;

	}

	function gst_calculation_for_neworder($qty, $rate, $cgst, $sgst, $inc_or_exc = 'exclusive', $disc_per = 0)
	{

		$total_value =  $qty * $rate;
		$disc_amt = $total_value * $disc_per / 100;
		$taxable_value = $total_value - $disc_amt;

		if ($inc_or_exc == 'exclusive') {
			if ($sgst > 0)
				$sgst_amt = round(($taxable_value * $sgst / 100), 2);
			else
				$sgst_amt = 0;

			if ($cgst > 0)
				$cgst_amt = round(($taxable_value * $cgst / 100), 2);
			else
				$cgst_amt = 0;


			$final_price = $taxable_value + $sgst_amt + $cgst_amt;

			$all_values = array('taxable_value' => $taxable_value, 'sgst_amt' => $sgst_amt, 'cgst_amt' => $cgst_amt, 'final_price' => $final_price);
		} else {
			$final_price = $taxable_value;
			$taxable_value = round((100 * $final_price) / (100 + $sgst + $cgst), 2);


			if ($sgst > 0)
				$sgst_amt = round(($taxable_value * $sgst / 100), 2);
			else
				$sgst_amt = 0;

			if ($cgst > 0)
				$cgst_amt = round(($taxable_value * $cgst / 100), 2);
			else
				$cgst_amt = 0;

			$all_values = array('taxable_value' => $taxable_value, 'sgst_amt' => $sgst_amt, 'cgst_amt' => $cgst_amt, 'final_price' => $final_price);
		}

		return ($all_values);
	}


	function executequery($sql, $print = false)
	{
		if ($print) {
			echo $sql;
			die;
		}
		$array = [];
		$query = mysqli_query($this->conn, $sql);

		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}


	function get_total_discamt_on_bill($purchaseid)
	{

		if ($purchaseid > 0) {
			//total disc amt on bill
			$total_disc_on_bill = $this->getvalfield("purchasentry_detail", "sum((qty*rate_amt) - taxable)", "purchaseid = '$purchaseid'");

			return $total_disc_on_bill;
		}
	}


	function dbRowInsert($table_name, $form_data)
	{
		// retrieve the keys of the array (column titles)
		$fields = array_keys($form_data);

		// build the query
		$sql = "INSERT INTO " . $table_name . "
    (`" . implode('`,`', $fields) . "`)
    VALUES('" . implode("','", $form_data) . "')";
		//echo $sql;
		//die;
		// run and return the query result resource
		return mysqli_query($this->conn, $sql);
		// echo $sql;die;
	}

	function insert_record($table, $fields, $print = false)
	{
		$sql = "";
		$sql .= "INSERT INTO " . $table;
		$sql .= " (" . implode(",", array_keys($fields)) . ") VALUE ";
		$sql .= "('" . implode("','", array_values($fields)) . "')";
		// if ($print) {
			echo $sql;
			die;
		// }
		$query = mysqli_query($this->conn, $sql);
		$last_id = mysqli_insert_id($this->conn);
		return !empty($query) ? $last_id : '';
	}

	function save($table, $fields, $print = false)
	{
		$sql = "";
		$sql .= "INSERT INTO " . $table;
		$sql .= " (" . implode(",", array_keys($fields)) . ") VALUE ";
		$sql .= "('" . implode("','", array_values($fields)) . "')";
		if ($print) {
			echo $sql;
			die;
		}
		$query = mysqli_query($this->conn, $sql);
		$last_id = mysqli_insert_id($this->conn);
		return !empty($query) ? $last_id : '';
	}

	function getcode_demand($tablename, $tablepkey, $cond)
	{
		$num =  $this->getvalfield($tablename, "max($tablepkey)", $cond);

		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 10; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}

	function getcode_inout($tablename, $tablepkey, $cond)
	{
		$num =  $this->getvalfield($tablename, "max($tablepkey)", $cond);

		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 5; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}

	function getcode($tablename, $tablepkey, $cond)
	{
		$num =  $this->getvalfield($tablename, "max($tablepkey)", $cond);
		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 1; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}

	function getprecode($tablename, $tablepkey, $cond)
	{
		$num =  $this->getvalfield($tablename, "max($tablepkey)", $cond);
		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 5; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}



	function getcode_challan($tablename, $tablepkey, $cond)
	{
		$num =  $this->getvalfield($tablename, "max(billno)", $cond);

		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 10; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}


	function get_overall_blls_amt($customer_id)
	{
		$prev_balance = $this->getvalfield("master_customer", "openingbal", "customer_id='$customer_id'");
		//get all sale entry bill amt
		$sql_sale = "select * from purchaseentry where customer_id = '$customer_id' and type = 'saleentry'";
		$row_sale = $this->executequery($sql_sale);
		$total_sale = 0;

		if (sizeof($row_sale) > 0) {
			$sale_amt = 0;
			foreach ($row_sale as $saleinfo) {
				# code...

				$sale_amt = $this->getTotalPerchaseBillAmt1($saleinfo['purchaseid']);
				//$sale_amt = 0;
				$total_sale += $sale_amt;
			}
		} //if close


		$voucher_payment = $this->getvalfield("voucherentry", "sum(paid_amt)", "customer_id='$customer_id' and payment_type = 'Payment'");

		$overall_amt = $total_sale + $voucher_payment + $prev_balance;
		return ($overall_amt);
	}

	function getcode_bookingno($tablename, $tablepkey, $cond)
	{
		$num = $this->getvalfield($tablename, "max($tablepkey)", "1=1");
		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 5; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}


	function get_product_total($product_id, $fromdate, $todate)
	{
		$sql = "select A.*,  (qty * rate_amt) as totalamt, (((cgst + sgst + igst)/100) * (qty * rate_amt)) as gsttax_rs  from saleentry_details as A left join saleentry as B on A.saleid = B.saleid where sale_date between '$fromdate' and '$todate' and product_id='$product_id'";

		$query = mysqli_query($this->conn, $sql);
		$total = 0;
		$nettotal = 0;
		$total_tax = 0;
		while ($row = mysqli_fetch_assoc($query)) {
			$totalamt = $row['totalamt'];
			$gsttax_rs = $row['gsttax_rs'];


			//total value with tax
			$nettotal += ($totalamt + $gsttax_rs);
		}
		return $nettotal;
	}

	function getcode_saleno($tablename, $tablepkey, $cond)
	{
		$num = 0;
		$sessionid = $this->getvalfield("m_session", "sessionid", "status=1");
		$company_id = $_SESSION['company_id'];
		$num = $this->getvalfield($tablename, "max(saleno)", "company_id=$company_id and sessionid = $sessionid");
		$num = sprintf("%'.06d\n", ++$num);
		return $num;
	}

	function getcode_issueno($tablename, $tablepkey, $cond)
	{
		$num = 0;
		$sessionid = $this->getvalfield("m_session", "sessionid", "status=1");
		//$company_id = $_SESSION['company_id'];
		$num = $this->getvalfield($tablename, "max(issueno)", "sessionid = $sessionid");
		$num = sprintf("%'.06d\n", ++$num);
		return $num;
	}

	function getcode_jarbillno($tablename, $tablepkey, $cond)
	{
		$num = 0;
		$sessionid = $this->getvalfield("m_session", "sessionid", "status=1");
		$company_id = $_SESSION['company_id'];
		$num = $this->getvalfield($tablename, "max(jar_billno)", "company_id=$company_id and sessionid = $sessionid");
		$num = sprintf("%'.06d\n", ++$num);
		return $num;
	}

	function getvalMultiple($table, $field, $where)
	{
		$sql = "select $field from $table where $where";
		//echo $sql;
		$getvalue = mysqli_query($this->conn, $sql);;
		while ($row = mysqli_fetch_row($getvalue)) {
			if (!empty($row[0]))
				$getval[] = $row[0];
		}
		return $getval;
	}

	function getcode_voucher($tablename, $tablepkey, $cond)
	{
		$sessionid = $this->getvalfield("m_session", "sessionid", "status=1");
		$company_id = $_SESSION['company_id'];
		$num = $this->getvalfield($tablename, "max(voucher_no)", "sessionid = '$sessionid' and company_id = '$company_id'");
		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 5; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}

	function getcode_suppay($tablename, $tablepkey, $cond)
	{
		$num = $this->getvalfield($tablename, "max(voucher_no)", "1=1");
		++$num; // add 1;
		$len = strlen($num);
		for ($i = $len; $i < 5; ++$i) {
			$num = '0' . $num;
		}
		return $num;
	}

	function insert_record_lastid($table, $fields)
	{
		//"INSERT INTO table_name ( , , ) VALUE ('', '')";
		$sql = "";
		$sql .= "INSERT INTO " . $table;
		$sql .= " (" . implode(",", array_keys($fields)) . ") VALUE ";

		$sql .= "('" . implode("','", array_values($fields)) . "')";
		
		$query = mysqli_query($this->conn, $sql);
		$last_id = mysqli_insert_id($this->conn);
		return !empty($query) ? $last_id : '';
	}

	function insert_id($table, $fields, $print = false)
	{
		$sql = "INSERT INTO " . $table;
		$sql .= " (" . implode(",", array_keys($fields)) . ") VALUE ";
		$sql .= "('" . implode("','", array_values($fields)) . "')";
		if ($print) {
			echo $sql;
			die;
		}
		$query = mysqli_query($this->conn, $sql);
		$last_id = mysqli_insert_id($this->conn);
		return !empty($query) ? $last_id : '';
	}

	function insert_record_return_id($table, $fields)
	{
		$sql = "";
		$sql .= "INSERT INTO " . $table;
		$sql .= " (" . implode(",", array_keys($fields)) . ") VALUE ";
		$sql .= "('" . implode("','", array_values($fields)) . "')";
		$query = mysqli_query($this->conn, $sql);
		$last_id = mysqli_insert_id($this->conn);
		return !empty($query) ? $last_id : '';
	}

	function fetch_record($table)
	{
		$sql = "SELECT * FROM " . $table;
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}


	function opening_balance($customer_id, $lastdate)
	{

		//opening balance
		$openingbal = $this->getvalfield("master_customer", "openingbal", "customer_id = '$customer_id' and open_bal_date < '$lastdate'");

		//sum total bill of customer (monthly jar)
		$sql = "select sum(nettotal) as totalamt from monthly_jar_bill_details as A left join monthly_jar_bill As B on A.mjar_billid = B.mjar_billid where customer_id = '$customer_id' and jar_billdate < '$lastdate'";
		$res = $this->executequery($sql);
		$nettotal = 0;
		foreach ($res as $row_get) {
			$nettotal += $row_get['totalamt'];
		}


		//sum total bill of customer (sale entry jar)
		$sql_sale = "select qty, rate_amt, disc, cgst, sgst, igst from saleentry_details as A left join saleentry As B on A.saleid = B.saleid where customer_id = '$customer_id' and sale_date < '$lastdate'";
		$res_sale = $this->executequery($sql_sale);
		$net_sale_total = 0;
		foreach ($res_sale as $row_sale) {
			$qty = $row_sale['qty'];
			$rate_amt = $row_sale['rate_amt'];
			$cgst = $row_sale['cgst'];
			$sgst = $row_sale['sgst'];
			$igst = $row_sale['igst'];

			$total_amt = $qty * $rate_amt;
			if ($total_amt > 0) {
				if ($cgst > 0) {
					$cgst_amt = $total_amt * $cgst / 100;
				}
				if ($sgst > 0) {
					$sgst_amt = $total_amt * $sgst / 100;
				}

				$net_amt = $total_amt + $cgst_amt + $sgst_amt;
			}

			$net_sale_total += $net_amt;
		}


		$total_payment = $this->getvalfield("voucherentry", "amount", "customer_id = '$customer_id' and vdate < '$lastdate' and paymt_id=3");

		$prev_balance = $openingbal + $nettotal + $net_sale_total - $total_payment;


		return $prev_balance;
	}


	function fetch_record_desc_condition($table, $where, $field)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);

		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql .= "SELECT * FROM " . $table . " WHERE " . $condition . " ORDER BY " . $field . " DESC";
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}

	function fetch_record_desc($table, $field)
	{
		$sql = "SELECT * FROM " . $table . " ORDER BY $field DESC LIMIT 10";
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}

	function getvalfield($tablename, $column, $condition, $print = false)
	{
		$sql = "select $column  from $tablename where $condition";
		if ($print) {
			echo $sql;
			die;
		}
		$result = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$count = mysqli_num_rows($result);
		return $count ? $row[$column] : "";
	}
	function get($tablename, $column, $condition, $print = false)
	{
		$sql = "select $column  from $tablename where $condition limit 1";
		if ($print) {
			echo $sql;
			die;
		}
		$result = mysqli_query($this->conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$count = mysqli_num_rows($result);
		return $count ? $row[$column] : "";
	}

	function dateindia($date)
	{
		if (empty($date) || $date == "0000-00-00") return "";
		return date('d-m-Y', strtotime($date));
	}

	function dateiso($date)
	{
		if (empty($date) || $date == "0000-00-00") return "";
		return date('Y-m-d', strtotime($date));
	}

	function dateformatindia($date)
	{
		if (empty($date) || $date == "0000-00-00") return "";
		$ndate = explode("-", $date);
		$year = $ndate[0];
		$day = $ndate[2];
		$month = $ndate[1];
		return $day . "-" . $month . "-" . $year;
	}

	function dateformatusa($date)
	{
		if (empty($date) || $date == "0000-00-00")
			return "";
		$ndate = explode("-", $date);
		$year = $ndate[2];
		$day = $ndate[0];
		$month = $ndate[1];
		return $year . "-" . $month . "-" . $day;
	}

	function select_record($table, $where)
	{
		// id = '5' AND m_name = 'something'
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql .= "SELECT * FROM " . $table . " WHERE " . $condition;
		$query = mysqli_query($this->conn, $sql);
		//echo $sql; die;
		$row = mysqli_fetch_assoc($query);
		return $row;
	}


	function InsertLog($pagename, $module, $submodule, $tablename, $tablekey, $keyvalue, $action)
	{

		$sessionid = $_SESSION['sessionid'];
		$userid = $_SESSION['userid'];
		$usertype = $_SESSION['usertype'];
		$activitydatetime  = date('Y-m-d H:m:s');

		$sqlquery = "insert into activitylogreport(userid, usertype, module, submodule, pagename, primarykeyid ,tablename, activitydatetime, action,sessionid) values('$userid', '$usertype', '$module', '$submodule',  '$pagename', '$keyvalue','$tablename', '$activitydatetime', '$action','$sessionid')";
		//echo $sqlquery;die;
		mysqli_query($this->conn, $sqlquery);
	}
	function select_record2($table, $where)
	{
		// id = '5' AND m_name = 'something'
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql .= "SELECT * FROM " . $table . " WHERE " . $condition;
		$query = mysqli_query($this->conn, $sql);
		//echo $query; die;
		while ($row = mysqli_fetch_assoc($query)) {
			$row1[] = $row;
		}
		return $row1;
	}

	function select_data($table, $where)
	{
		// id = '5' AND m_name = 'something'
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql .= "SELECT * FROM " . $table . " WHERE " . $condition;
		// echo $sql;die;
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}


	function select_crit($table, $field, $method, $date1, $date2)
	{
		$sql = "SELECT * FROM $table WHERE $field $method '$date1' AND '$date2'";
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}


	function select_data_orderby($table, $where, $orderby)
	{
		// id = '5' AND m_name = 'something'
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}

		$condition = substr($condition, 0, -5);
		$sql .= "SELECT * FROM " . $table . " WHERE " . $condition . " order by " . $orderby;
		//		echo $sql;
		//die;
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}

	function select_data_condition_orderby($table, $field, $val, $orderby)
	{
		$sql = "";
		$sql .= "SELECT * FROM " . $table . " WHERE " . $field . "  != " . $val . " ORDER BY " . $orderby . " DESC ";
		//echo $sql ;die;
		$array = [];
		$query = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($query)) {
			$array[] = $row;
		}
		return $array;
	}

	function count_method($table, $where)
	{
		// id = '5' AND m_name = 'something'
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql .= "SELECT * FROM " . $table . " WHERE " . $condition;
		$query = mysqli_query($this->conn, $sql);
		$count = mysqli_num_rows($query);
		//echo $count ;die;
		return $count;
	}


	function count_method2($table)
	{
		$sql = "SELECT * FROM " . $table;
		$query = mysqli_query($this->conn, $sql);
		$count = mysqli_num_rows($query);
		return $count;
	}



	function check_duplicate($table, $fields, $where)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql .= "SELECT " . $fields . " FROM " . $table . " WHERE " . $condition;
		$query = mysqli_query($this->conn, $sql);
		$duplicate = mysqli_num_rows($query);
		// echo $count ;die;
		return $sql;
	}

	function check_duplicatep($table_name, $where)
	{
		$sqledit = mysqli_query($this->conn, "SET NAMES utf8");
		//echo "select * from $table_name where $where";die;
		$sql = "select * from $table_name where $where";
		$res = mysqli_query($this->conn, $sql);
		$cnt = mysqli_num_rows($res);
		return $cnt;
	}


	function update_record($table, $where, $fields)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value) {
			// id = 5 AND m_name = 'something'
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		foreach ($fields as $key => $value) {
			// UPDATE table SET m_name = '', qty = '' WHERE id = '';
			$sql .= $key . "='" . $value . "', ";
		}
		$sql = substr($sql, 0, -2);
		$sql = "UPDATE " . $table . " SET " . $sql . " WHERE " . $condition;
		if (mysqli_query($this->conn, $sql)) {
			return mysqli_insert_id($this->conn);
		}
	}

	function update($table, $where, $fields, $print = false)
	{
		$sql = "";
		$condition = "";
		foreach ($where as $key => $value)  $condition .= $key . "='" . $value . "' AND ";
		$condition = substr($condition, 0, -5);
		foreach ($fields as $key => $value) $sql .= $key . "='" . $value . "', ";
		$sql = substr($sql, 0, -2);
		$sql = "UPDATE " . $table . " SET " . $sql . " WHERE " . $condition;
		if ($print) {
			echo $sql;
			die;
		}
		return mysqli_query($this->conn, $sql) ? mysqli_insert_id($this->conn) : '';
	}

	function delete_record($table, $where)
	{
		$sql = '';
		$condition = '';
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql = "DELETE FROM " . $table . " WHERE " . $condition;
		return mysqli_query($this->conn, $sql) ? mysqli_insert_id($this->conn) : '';
	}

	function delete($table, $where, $print = false)
	{
		$sql = '';
		$condition = '';
		foreach ($where as $key => $value) {
			$condition .= $key . "='" . $value . "' AND ";
		}
		$condition = substr($condition, 0, -5);
		$sql = "DELETE FROM " . $table . " WHERE " . $condition;
		if ($print) {
			echo $sql;
			die;
		}
		return mysqli_query($this->conn, $sql) ? mysqli_insert_id($this->conn) : '';
	}


	function add3dots($string, $repl, $limit)
	{
		if (strlen($string) > $limit) {
			return substr($string, 0, $limit) . $repl;
		} else {
			return $string;
		}
	}
	function checkmenu($mudule_setting, $loginid)
	{

		$sql = mysqli_query($this->conn, "SELECT B.* FROM privilage_setting AS A LEFT JOIN m_userprivilege AS B ON A.page_id = B.page_id where B.menuname='$mudule_setting' and A.userid='$loginid'");
		$numrows = mysqli_num_rows($sql);

		return $numrows;
	}

	function check_menuname($location, $loginid)
	{

		$sql = mysqli_query($this->conn, "select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
		$numrows = mysqli_num_rows($sql);

		return $numrows;
	}




	function getTotalPerchaseBillAmt($id)
	{

		$rate_amt = 0;
		$amount = 0;
		$totgst = 0;
		$totalamount = 0;
		$totsgst = 0;
		$totigst = 0;

		$sql = mysqli_query($this->conn, "Select * from purchasentry_detail where purchaseid = '$id'");
		if ($sql) {


			while ($row = mysqli_fetch_array($sql)) {
				$total = 0;
				$qty = $row['qty'];
				$rate_amt = $row['rate_amt'];
				$cgst = $row['cgst'];
				$sgst = $row['sgst'];
				$igst = $row['igst'];
				$total =	$qty * $rate_amt;
				$totalc = ($total * $cgst) / 100;
				$totals = ($total * $sgst) / 100;
				$totali = ($total * $igst) / 100;

				$amount += $total;
				$totgst += $totalc;
				$totigst += $totali;
				$totsgst += $totals;
				$totalgst = $totgst + $totsgst + $totigst;
				$totalamount = $amount + $totalgst;
			}
		}


		return $totalamount;
	}

	function getTotalPerchaseBillAmt1($id)
	{

		$rate_amt = 0;
		$amount = 0;
		$totgst = 0;
		$totalamount = 0;
		$totsgst = 0;
		$totigst = 0;

		$sql = mysqli_query($this->conn, "Select * from purchasentry_detail where purchaseid = '$id' and sale_pur_type = 'sale'");
		if ($sql) {


			while ($row = mysqli_fetch_array($sql)) {
				$total = 0;
				//$purchaseid = $row['purchaseid'];
				$qty = $row['qty'];
				$rate_amt = $row['rate_amt'];
				$cgst = $row['cgst'];
				$sgst = $row['sgst'];
				$igst = $row['igst'];
				$cgst_amt = $row['cgst_amt'];
				$sgst_amt = $row['sgst_amt'];
				$igst_amt = $row['igst_amt'];
				//$net_amount = $obj->getvalfield("purchaseentry","net_amount","purchaseid='$purchaseid'");
				$taxable_value = $row['taxable_value'];

				$amount += $taxable_value;
				$totgst += $cgst_amt;
				$totigst += $igst_amt;
				$totsgst += $sgst_amt;
				$totalgst = $totgst + $totsgst + $totigst;
				$totalamount = $amount + $totalgst;
			}
		}


		return $totalamount;
	}



	function getTotalSaleentryBillAmt($id)
	{

		$rate_amt = 0;
		$amount = 0;
		$totgst = 0;
		$totalamount = 0;
		$totsgst = 0;
		$totigst = 0;

		$sql = mysqli_query($this->conn, "Select * from saleentry_details where saleid = '$id'");
		if ($sql) {


			while ($row = mysqli_fetch_array($sql)) {
				$total = 0;
				$qty = $row['qty'];
				$rate_amt = $row['rate_amt'];
				$cgst = $row['cgst'];
				$sgst = $row['sgst'];
				$igst = $row['igst'];
				$total = $qty * $rate_amt;
				$totalc = ($total * $cgst) / 100;
				$totals = ($total * $sgst) / 100;
				$totali = ($total * $igst) / 100;

				$amount += $total;
				$totgst += $totalc;
				$totigst += $totali;
				$totsgst += $totals;
				$totalgst = $totgst + $totsgst + $totigst;
				$totalamount = $amount + $totalgst;
			}
		}


		return $totalamount;
	}

	function getTotalBookingBillAmt($id)
	{

		$rate_amt = 0;
		$amount = 0;
		$totgst = 0;
		$totalamount = 0;
		$totsgst = 0;
		$totigst = 0;

		$sql = mysqli_query($this->conn, "Select * from booking_order_detail where booking_order_id = '$id'");
		if ($sql) {


			while ($row = mysqli_fetch_array($sql)) {
				$total = 0;
				$qty = $row['qty'];
				$rate_amt = $row['rate_amt'];
				$cgst = $row['cgst'];
				$sgst = $row['sgst'];
				$igst = $row['igst'];
				$total =	$qty * $rate_amt;
				$totalc = ($total * $cgst) / 100;
				$totals = ($total * $sgst) / 100;
				$totali = ($total * $igst) / 100;

				$amount += $total;
				$totgst += $totalc;
				$totigst += $totali;
				$totsgst += $totals;
				$totalgst = $totgst + $totsgst + $totigst;
				$totalamount = $amount + $totalgst;
			}
		}

		return $totalamount;
	}


	function getTotalMonthlyJarBillAmt($id)
	{

		$totalamount = 0;
		$sql = mysqli_query($this->conn, "Select * from monthly_jar_bill_details where mjar_billid = '$id'");
		if ($sql) {
			while ($row = mysqli_fetch_array($sql)) {
				$totalamount += $row['nettotal'];
			}
		}
		return $totalamount;
	}

	function convert_image($fname, $path, $wid, $hei)
	{
		$wid = intval($wid);
		$hei = intval($hei);
		//$fname = $sname;
		$sname = "$path$fname";
		//echo $sname;
		//header('Content-type: image/jpeg,image/gif,image/png');
		//image size
		list($height, $width) = getimagesize($sname);


		if ($hei == "") {
			if ($width < $wid) {
				$wid = $width;
				$hei = $height;
			} else {
				$percent = $wid / $width;
				$wid = $wid;
				$hei = round($height * $percent);
			}
		}

		//$wid=469;
		//$hei=290;
		$thumb = imagecreatetruecolor($wid, $hei);
		//image type
		$type = exif_imagetype($sname);
		//check image type
		switch ($type) {
			case 2:
				$source = imagecreatefromjpeg($sname);
				break;
			case 3:
				$source = imagecreatefrompng($sname);
				break;
			case 1:
				$source = imagecreatefromgif($sname);
				break;
		}
		// Resize
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $wid, $hei, $width, $height);
		//echo "converted";
		//else
		//echo "not converted";
		// source filename
		$file = basename($sname);
		//destiantion file path
		//$path="uploaded/flashgallery/";
		$dname = $path . $fname;
		//display on browser
		//imagejpeg($thumb);
		//store into file path
		imagejpeg($thumb, $dname);
	}

	function get_client_ip()
	{
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if (getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if (getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if (getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if (getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if (getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}

	function test($data)
	{
		$data = trim($data);
		$data = addslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	function test_input($data)
	{
		$data = trim($data);
		$data = addslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function check_editBtn($location, $loginid)
	{

		$sql = mysqli_query($this->conn, "select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
		$rowedit = mysqli_fetch_array($sql);
		return !empty($rowedit) ? $rowedit['pagedit'] : '';
	}

	function check_delBtn($location, $loginid)
	{

		$sql = mysqli_query($this->conn, "select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
		$rowedit = mysqli_fetch_array($sql);
		return !empty($rowedit) ? $rowedit['pagedel'] : '';
	}

	function check_pageview($location, $loginid)
	{

		$sql = mysqli_query($this->conn, "select * from privilage_setting as A left join m_userprivilege as B on A.page_id = B.page_id  where A.userid='$loginid' && B.pagelink='$location'");
		$rowedit = mysqli_fetch_array($sql);
		return !empty($rowedit) ? $rowedit['pageview'] : '';
	}

	function sendsmsGET($username, $pass, $senderid, $message, $serverUrl, $mobile)
	{
		//    echo $authKey; die;
		//username=beyondcg&pass=welcome@123&senderid=BEYOND&message=Testt&dest_mobileno=9179432534&response=Y
		$getData = 'username=' . $username . '&pass=' . $pass . '&senderid=' . $senderid . '&message=' . urlencode($message) . '&dest_mobileno=' . $mobile . '&response=Y';

		//API URL
		$url = "http://" . $serverUrl . "?" . $getData;



		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0

		));

		//get response
		$output = curl_exec($ch);

		//Print error if any

		if (curl_errno($ch)) {
			// echo 'error:' . curl_error($ch);
		}

		curl_close($ch);

		return 1;
	}

	function selectMultiple($table, $where)
	{
		$table = "SELECT * FROM `$table` WHERE product_id=1 and ratefrmplant=ratefrmplant";
	}

	function software_expire()
	{

		$currentdate = date('Y-m-d');
		$cntrow = $this->getvalfield("software_expired", "count(*)", "'$currentdate' between start_date and expired_date");

		return $cntrow;
	}

	function software_expire_info()
	{
		$row = $arrayName = array('soft_exp_id' => 0, 'start_date' => "", 'expired_date' => "");
		$currentdate = date('Y-m-d');

		$cntrow = $this->executequery("select * from software_expired where '$currentdate' between start_date and expired_date order by expired_date");

		if (sizeof($cntrow) > 0) {
			$row['soft_exp_id'] = $cntrow['0']['soft_exp_id'];
			$row['start_date'] = $cntrow['0']['start_date'];
			$row['expired_date'] = $cntrow['0']['expired_date'];
		}
		return $row;
	}


	function get_opening_stock($raw_id, $from_date)
	{

		//opening stock form product master
		$opening_stock_master = $this->getvalfield("raw_material", "qty", "raw_id = '$raw_id' and open_date <= '$from_date'");
		//count purchaseentry


		$purchase = 0;
		$purchasequery = "select qty from purchasentry_detail left join purchaseentry on  purchasentry_detail.purchaseid = purchaseentry.purchaseid 
                    where raw_id = '$raw_id' and purchaseentry.bill_date < '$from_date'";
		$res = $this->executequery($purchasequery);
		foreach ($res as $row_get) {

			$purchase += (float)$row_get['qty'];
		}


		// issue 
		$issue = 0;
		$sql_issue = "select qty from issue_entry_details left join issue_entry on  issue_entry_details.issueid < issue_entry.issueid 
			where raw_id = '$raw_id' and issue_entry.issuedate < '$from_date'";
		// $sql_issue = "select ret_qty as issue_ret from issue_return where ret_date = '$from_date' and raw_id = '$raw_id'";
		$res1 = $this->executequery($sql_issue);
		foreach ($res1 as $row_get1) {

			//$issue = (float)$row_get1['issue'];
			$issue += (float)$row_get['qty'];
			//$issue_ret = (float)$row_get1['issue_ret'];
		}

		//return
		$issue_ret = 0;
		$sql_issue1 = "select sum(ret_qty) as issue_ret from issue_return where ret_date < '$from_date' and raw_id = '$raw_id'";
		$res12 = $this->executequery($sql_issue1);
		foreach ($res12 as $row_get12) {


			$issue_ret = (float)$row_get12['issue_ret'];
		}

		$open_stock = $opening_stock_master + $purchase + $issue - $issue_ret;
		return $open_stock;
	}



	function get_opening_stock_for_finished($productid, $from_date)
	{

		//opening stock form product master
		$opening_stock_master = $this->getvalfield("finished_goods_opening_stock", "finish_opening_qty", "productid = '$productid' and finish_opening_date < '$from_date'");


		//count purchase entry
		$purchase_qty = 0;
		$purchaseentry = "select qty from purchasentry_detail left join purchaseentry on purchasentry_detail.purchaseid = purchaseentry.purchaseid 
                    where productid = '$productid' and purchaseentry.bill_date < '$from_date'";
		$res = $this->executequery($purchaseentry);
		foreach ($res as $row_get) {

			$purchase_qty += (float)$row_get['qty'];
		}


		//count production
		$production_qty = 0;
		$productionquery = "select production_qty from production_entry where productid = '$productid' and production_date < '$from_date'";

		$res = $this->executequery($productionquery);
		foreach ($res as $row_get) {

			$production_qty += (float)$row_get['production_qty'];
		}

		//count adjustment plus
		$adjustment_qty_plus = 0;
		$adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'plus' and adjustment_date < '$from_date'";

		$res = $this->executequery($adjustmentquery);
		foreach ($res as $row_get) {

			$adjustment_qty_plus += (float)$row_get['adjustment_qty'];
		}

		//count adjustment minus
		$adjustment_qty_minus = 0;
		$adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'minus' and adjustment_date < '$from_date'";

		$res = $this->executequery($adjustmentquery);
		foreach ($res as $row_get) {

			$adjustment_qty_minus += (float)$row_get['adjustment_qty'];
		}

		//count wastage
		$wastage_qty = 0;
		$wastagequery = "select wastage_qty from wastage_entry where productid = '$productid' and wastage_date < '$from_date'";

		$res = $this->executequery($wastagequery);
		foreach ($res as $row_get) {
			$wastage_qty += (float)$row_get['wastage_qty'];
		}

		//count sale
		$sale_qty = 0;
		$salequery = "select qty from bill_details left join bills on bill_details.billid = bills.billid 
                    where bills.billdate < '$from_date' and productid = '$productid'";
		$res = $this->executequery($salequery);
		foreach ($res as $row_get) {

			$sale_qty += (float)$row_get['qty'];
		}


		$open_stock = $opening_stock_master + $purchase_qty + $adjustment_qty_plus - $adjustment_qty_minus + $production_qty - $wastage_qty - $sale_qty;
		return $open_stock;
	}
	function is_page_exists($pagename, $pages)
	{
		// $pageNames = array_column($pages, 'pagename');
    	// return in_array($pagename, $pageNames);
		foreach ($pages as $page) {
			if ($page['pagename'] === $pagename) {
				return true;
			}
		}
		return false;
	}
}



$obj = new DatabaseConfiguration;
