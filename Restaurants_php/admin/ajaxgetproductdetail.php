<?php include("../adminsession.php");

$raw_id=trim(addslashes($_REQUEST['raw_id']));
//$purchase_type=trim(addslashes($_REQUEST['purchase_type']));


	if($raw_id !='')
	{
		$unit_id=$obj->getvalfield("raw_material","unitid","raw_id='$raw_id'");
        $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unit_id'");
		$purches_rate=$obj->getvalfield("raw_material","rate","raw_id='$raw_id'");
		$cgst=$obj->getvalfield("raw_material","cgst","raw_id='$raw_id'");
		$sgst=$obj->getvalfield("raw_material","sgst","raw_id='$raw_id'");
		$igst=$obj->getvalfield("raw_material","igst","raw_id='$raw_id'");
		$inc_or_exc=$obj->getvalfield("raw_material","taxtype","raw_id='$raw_id'");

		echo $unit_id."|".$unit_name."|".$purches_rate."|".$cgst."|".$sgst."|".$igst."|".$inc_or_exc;
	}

?>