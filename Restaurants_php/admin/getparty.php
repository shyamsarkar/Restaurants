<?php
include("../adminsession.php");

$vendorgrp_id = addslashes($_REQUEST['vendorgrp_id']);

if($vendorgrp_id !='')
{ 
  
	$sqlget = $obj->executequery("select * from master_customer where vendorgrp_id = '$vendorgrp_id'");
echo "<option value=''>--All--</option>";
	for($i=0;$i< sizeof($sqlget);$i++)

	{
	?>
    <option value="<?php echo $sqlget[$i]['customer_id']; ?>"><?php echo $sqlget[$i]['customer_name']; ?></option>
    <?php

	}
}
?>
