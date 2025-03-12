<?php include("../adminsession.php");

$raw_id=trim(addslashes($_REQUEST['raw_id']));
if($raw_id !='')
	{
			$unitid =$obj->getvalfield("raw_material","unitid","raw_id='$raw_id'");
			$unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
            $rate = $obj->getvalfield("raw_material","rate","raw_id='$raw_id'");
		    echo $unit_name."|".$rate;
	}
	?>