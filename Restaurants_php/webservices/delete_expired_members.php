<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
//include("../config.php");
$database_link_for_connection = mysql_connect("45.40.164.55","platinumgym","PAndari@RefMah8401");
mysql_select_db("platinumgym",$database_link_for_connection);

include("../lib/getval.php");
$cmn = new Comman();


//delete close
$deldate = date('Y-m-d');
// echo $sql_del = "select saveplan_details.regid, expirydate, biometricid
// FROM saveplan_details left join member_registration as B on B.regid = saveplan_details.regid
// WHERE
// (select max(expirydate) from saveplan_details as f  where f.regid= saveplan_details.regid)
// AND expirydate < '$deldate' and biometricid<>0  ORDER BY `saveplan_details`.`expirydate`  DESC";
// die;

$delfrom = date('Y-m-d',strtotime("-7 days"));
$sql_del = "select A.regid, expirydate, biometricid
FROM saveplan_details as A left join member_registration as B on A.regid = B.regid
WHERE biometricid <> 0 and expirydate between '$delfrom' and '$deldate'  ORDER BY A.expirydate  DESC";
//die;

$res_del = mysql_query($sql_del);
$cmd_del = "";
while($row_del = mysql_fetch_assoc($res_del)) {
	# code...
	$regid = $row_del['regid'];
	$biometricid = $row_del['biometricid'];
	$expirydate = $row_del['expirydate'];
	$cmd_del .= "PIN=".$biometricid."#";
}

//echo $cmd_del;
//die;
$del_isexist = 0;
if($cmd_del!="")
{
	$del_isexist = $cmn->getvalfield("bio_command","count(*)","cmd='$cmd_del'");
	if($del_isexist == 0)
	{
		mysql_query("insert into bio_command set cmd = '$cmd_del', createdate = '$createdate'");
	}
	echo $cmd_del;
}

?>