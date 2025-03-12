<?php
include("../adminsession.php");
$floor_id = $_REQUEST['floor_id'];


if($floor_id !='')
{ 
  // echo "select * from payment_subhead where paymt_id = '$paymt_id'";die;
    $sqlget = $obj->executequery("select * from m_table where floor_id = '$floor_id'");
    for($i=0;$i< sizeof($sqlget);$i++)
    {
    ?>
    <option value="<?php echo $sqlget[$i]['table_id']; ?>"><?php echo $sqlget[$i]['table_no']; ?></option>
    <?php

    }
}


