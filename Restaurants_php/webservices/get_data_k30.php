<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//include("../config.php");
include("../action.php");

//$database_link_for_connection = myql_connect("45.40.164.55","platinumgym","PAndari@RefMah8401");
//mysql_select_db("platinumgym",$database_link_for_connection);




$inputJSON = file_get_contents('php://input');
//$inputJSON = '{"data":["OPLOG 4#0#2019-07-03 18:25:45#0#0#0#0","OPLOG 30#0#2019-07-03 18:25:57#3#0#0#0","USER PIN=3#Name=#Pri=0#Passwd=#Card=[0000000000]#Grp=254#TZ=0000000000000000","OPLOG 6#0#2019-07-03 18:25:58#3#0#0#1018","USER PIN=3#Name=#Pri=0#Passwd=#Card=[0000000000]#Grp=254#TZ=0000000000000000","FP PIN=3#FID=0#Size=1368#Valid=1#TMP=SrlTUzIxAAAD+voECAUHCc7QAAAb+2kBAAAAgycjYfpGAIIPogCmABf1XAB2AHgPLQB9+pIPQQCAADMPuvqAAJMP1gBDABD1iQCcAIkPKADG+hoO1ADHAFEPAfvUAJsOyQAZABr1iADdAIAPiwDc+loPugDkAEoPmPrvAIEP3AArAJr1QgD1AN0PqAD5+l8PmgABAbkPfvoLAV8PSADJAVL1YwAdAd8PTwAe+0oOdQAfAY4P2/omAZgO6gDqAR/00QAwAZIPawAx+xQNXwA4AYQP9Po4AZwOsgD4ARj3pQBDASINZwBM+ycP9QBVAVwORPZWjxNzkoJ6j4T5f4TP+CfymIFs+i57foBjd15v9nmXgu8AXYEwgwT55vqXEst3JIqCec8HQX7peo8GgnlPB3MI1Yz4hop5IAIyBmImvIJFBG8P3XhmEDv5Qv+cAvb0iYOzDaH83I55hqqDgAJxe1sWyf16HJ8wcuzAAkkW6XaPdB0MpJXlozqQdAHeFA/QuW0xAcDuR/H4ff79gYAwheZ1zf/te154Wf/CD7/wBWce+CrxgnooB3oFGAsQ+MYMpf9NCDUN5Qc69C8Qrf+efk4J+J//VAUgOwHHMx+zCACSIhBYncAP+ogoEFVdSjoNA4AoFsFaSkoFBgNAKAz+/10QxVku9mFVwf//wYD/DfpEOAM9/sGdwEb+ATdBAFEFxWZL9v9oAwA6SsX/D/o1Vvf+wP84R8MFwAYApmETBcBm/wGkZxptDMUqax38/UHA/v+oCAPLbu3+/v1U1gA2g+j++0xTVZD/VOgBRYH6wCs6Ufw6wP7ATwgAeIQQq1QFANqFDPMFAyKLFlMIAIVSjHp2EAAqnOL+OP8ztktTDACMncpYQjtlCQCEnoY6ksE7ww4ALsDaOC79Ov7//8IxFMUvyST/Lv9AwMCUPj7vASnc4EYjBf5QBVr/wDYJAJfc7tD8wWQGAIUYg447CQDN3RdRO8D8/AFK3mTEbsgAuxqWf4DCwo7MAL0dFmhGwBAA7+zVBP/BIUdBWcIAlBWHwcP/pQ/FcfQA/0//S1VWzwBqAmrEwsLAegQEA8X4V8HBCQCu/mM5eYsGAJb+RsLBPMMHEJ4CBjv/OPIRfA5a/8MBwHr5EUMQU8AF1UkTtkwLEI0b7T7+/r3BwMAHEIXYUMB4wAYQYCFMOpMF6nIhTMGJBtWKIrOQwA4Q1CRfwY85xcSXhRYQ9CfTOv87/UAywPv+w6EKEMwvlsEHwco8w50GELEx1f/DqgYQsDYXwI/DBeqnNyJx/gTVXji6cwYQtD8cBP/DOAQQqEQgwATBB+qiRyJgDhAwUZSodMTNkcFShwAIuQAAAAtFUgPEgU0RZg==",""],"table":"OPERLOG","SN":"OIN7070597060502671"}';


//$inputJSON = '{"data":["105#2019-12-17 12:31:52#255#1","105#2019-12-17 12:31:55#255#1",""],"table":"ATTLOG","SN":"OIN7070597060502671"}';

// if(!empty($inputJSON))
// {
// 	 //$myfile = fopen("testfile.txt", "w");
// 	 //fwrite($myfile, $inputJSON);
// 	 //fclose($myfile);

// 	$form_data_att = array('inputdata' => $inputJSON);
// 	$obj->dbRowInsert("attlogtest",$form_data_att);
// }


if (!empty($inputJSON)) {
	// 	//$qrstr = serialize($_REQUEST);
	// 	//$qrstr = serialize($_POST);

	$input = json_decode($inputJSON, TRUE); //convert JSON into array
	//print_r($input); die;

	$data = $input['data'];
	$table = $input['table'];
	$SN = $input['SN'];
	$machineid = $SN;
	$createdate = date('Y-m-d h:i:s');
	//$qrstr = serialize($input);

	//mysql_query("insert into save_querystr set qrstr = '$inputJSON'");
	//attendance code
	if ($table == 'ATTLOG') {
		$waiter_id = 0;
		foreach ($data as $value) {
			//echo $value;die;
			$datstr = explode('#', $value);

			if (isset($datstr[0]))
				$machine_userid = $datstr[0];
			else
				$machine_userid = "";


			if (isset($datstr[1]))
				$attendance_stamp = $datstr[1];
			else
				$attendance_stamp = "";

			if (isset($datstr[2]))
				$data1 = $datstr[2];
			else
				$data1 = "";

			if (isset($datstr[3]))
				$verifyiedby = $datstr[3];
			else
				$verifyiedby = "";


			$waiter_id = $obj->getvalfield("m_waiter", "waiter_id", "biometric_id='$machine_userid'");

			if ($machine_userid != '') {
				$attendance_date = date('Y-m-d', strtotime($attendance_stamp));
				$attendance_time = date('h:i:s', strtotime($attendance_stamp));
				$createdate = date('Y-m-d');


				if ($waiter_id > 0) {
					//echo "hee"; die;
					$form_data1 = array('waiter_id' => $waiter_id, 'machine_userid' => $machine_userid, 'attendance_time' => $attendance_time, 'attendance_date' => $attendance_date, 'attendance_stamp' => $attendance_stamp, 'attendanceby' => '1', 'verifyiedby' => $verifyiedby, 'createdate' => $createdate, 'machineid' => $SN);
					$obj->dbRowInsert("attendance_entry", $form_data1);
				}
			}
			//mysql_query("insert into attendance_entry set machine_userid = '$machine_userid', attendance_stamp = '$attendance_stamp', verifyiedby = '$verifyiedby', machineid = '$machineid'");
		}
	}
}
