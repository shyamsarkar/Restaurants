<?php
include("../adminsession.php");

$floor_id = addslashes($_REQUEST['floor_id']);

// if($floor_id !='')
// { 
    ?><option value=''>--Select Table--</option><?php
	$sqlget = $obj->executequery("select * from m_table where floor_id = '$floor_id'");
	for($i=0;$i< sizeof($sqlget);$i++)
	{
	?>
    <option value="<?php echo $sqlget[$i]['table_id']; ?>"><?php echo $sqlget[$i]['table_no']; ?></option>
    <?php

	}
//}
?>
