<?php
include("../adminsession.php");

$vendorgrp_id = addslashes($_REQUEST['vendorgrp_id']);
?>
<option value="">--All--</option>
<?php
if($vendorgrp_id !='')
{ 
  
	
	$res = $obj->executequery("select * from master_customer where vendorgrp_id = '$vendorgrp_id'");
	foreach($res as $row_get)
          				 
	{
	?>
    <option value="<?php echo $row_get['customer_id']; ?>"><?php echo $row_get['customer_name']; ?></option>
    <?php

	}
}
?>