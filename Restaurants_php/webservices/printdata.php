<?php
//include("../config.php");
$database_link_for_connection = mysql_connect("45.40.164.55","platinumgym","PAndari@RefMah8401");
mysql_select_db("platinumgym",$database_link_for_connection);

include("../lib/getval.php");
$cmn = new Comman();

$res = mysql_query("select * from save_querystr where sid = 3");


while($row = mysql_fetch_assoc($res))
{
	//print_r($row);
	$data = $row['qrstr'];
	$data = json_decode($data);

	foreach ($data as $key => $value) {
		# code...
		//print_r($value);
		//echo "<br>";
		//die;
		//echo $index = array_search("OPLOG", $value);
		//die;
		array_filter($value);
		$example = $value;
		$searchword = 'OPLOG';
		$matches = array();

		if(sizeof($example) > 0)
		{
			foreach($example as $k=>$v) {
			    if(preg_match("/\b$searchword\b/i", $v)) {
			        $matches[$k] = $v;
			        //echo $k;
			        //echo "<br>";
			        unset($example[$k]);
			        //echo $keyid = array_search($matches[$k],$value);

			    }
			}
			//print_r($example);
			//clear data array
			foreach ($example as $value) {
				# code...
				if($value!="")
				{
					mysql_query("insert into bio_command set cmd='$value'");
				}
			}
		}
		//die;
	}

	print_r($data);
	die;

}



?>