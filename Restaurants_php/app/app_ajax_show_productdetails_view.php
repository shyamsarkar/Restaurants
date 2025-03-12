<?php 
include '../adminsession.php';
$productid = $_REQUEST['productid'];
$from_date = $obj->dateformatusa($_REQUEST['from_date']);
$to_date = $obj->dateformatusa($_REQUEST['to_date']);

    $sno = 1;
   
    $sql = $obj->executequery("Select bills.billnumber,bills.createdby,bills.billdate, bill_details.* from bill_details left join bills on bills.billid = bill_details.billid where productid='$productid' and billdate between '$from_date' and '$to_date'");
    foreach ($sql as $key) 
    {
      $productid = $key['productid'];
      $billnumber = $key['billnumber'];
      $unitid = $key['unitid'];
      $kotid = $key['kotid'];
      $qty = $key['qty'];
      $createdby = $key['createdby'];
      $username = $obj->getvalfield("user","username","userid='$createdby'");
      $table_id = $key['table_id'];
      $table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");
      $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
      $billdate = $obj->dateformatindia($key['billdate']);
      $product_name = $obj->getvalfield("m_product","prodname","productid='$productid'");
      $is_cancelled_product = $key['is_cancelled_product'];
      if($is_cancelled_product > 0)
      {
        $status = "Cencelled";
        $color = 'red lighten-4';
      }
       
      else
      {
         $status = "";
         $color = 'green lighten-4';
      }
        


     
     ?>

      <tr class="<?php echo $color; ?>" style="border-bottom:none;">
                 <td>
                    <span>No.- <?php echo $billnumber; ?></span><br>
                    <span><?php echo $billdate; ?></span>
                 </td>
                 <td>
                    <span><?php echo $product_name; ?></span><br>
                    <span>Rate : <?php echo $key['rate']; ?> / <?php echo $unit_name; ?></span>
                 </td>
                 <td><?php echo $qty; ?></td>
                 <td>
                    <span>KotNo.- <?php echo $kotid; ?></span><br>
                    <span>TableNo.- <?php echo $table_no; ?></span>
                 </td>
              </tr>
              <tr class="<?php echo $color; ?>">
                 <td colspan="4"><span>Remark: <?php echo $key['cancel_remark']; ?></span> &nbsp;&nbsp;&nbsp; <span class="">Status: <?php echo $status; ?></span>  &nbsp;&nbsp;&nbsp; <span class="green-text">By: <?php echo $username; ?></span></td>
              </tr> 
                
   
  <?php } ?>
