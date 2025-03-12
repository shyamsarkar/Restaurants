<?php
include("../adminsession.php");
$issue_id=trim(addslashes($_REQUEST['issue_id'])); 

if($issue_id =='')
{
  $issue_id=0;  
}
else
{
  $issue_id=$issue_id;
}
//$sn=1;
$where = array("issue_id"=>$issue_id);
$res = $obj->select_data("issue_return",$where);
$sn=1;


?>
<table width="100%" class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th>Sl.No</th>
      <th>Product Name</th>
      <th>Unit</th>
      <th>Qty</th>
      <th>Return Date</th>
      <th class="center">Action</th>
    </tr>

  </thead>
  <tbody>

    <?php
        //$toal_disc=0;         
    foreach($res as $rowget)
    {

      $raw_id=$rowget['raw_id'];
          //$product_id=$rowget['product_id'];
     $raw_name = $obj->getvalfield("raw_material","raw_name","raw_id='$raw_id'");
      $issue_id=$rowget['issue_id'];
      $unit_name = $rowget['unit_name'];
      $ret_qty=$rowget['ret_qty'];
      $ret_date=$rowget['ret_date'];

      ?>
      <tr>
        <td><?php echo $sn++; ?></td>
        <td><?php echo $raw_name; ?></td>
        <td><?php echo $unit_name; ?></td>
        <td><?php echo $ret_qty;  ?></td>
        <td><?php echo $ret_date;  ?></td>
        <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $issue_id; ?>');"> X </a></td>

      </tr>

      <?php



      
    }
    ?>   
    <tr>
                  <td colspan="10"><p align="center"> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
                  <input type="hidden" name="issue_id" value="<?php echo $issue_id; ?>"  />
                  <a href="issue_return.php" class="btn btn-primary" > Reset </a>

                  
                   </p>  </td>
        </tr> 
</tbody>
</table>
