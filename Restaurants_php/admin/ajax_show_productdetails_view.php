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
        $color = 'alert-danger';
      }
       
      else
      {
         $status = "";
         $color = 'alert-success';
      }
        


     
     ?>
    <tr class="<?php echo $color; ?>">
        <td><?php echo $sno++; ?></td>
        <td><?php echo $billnumber; ?><br>
            <?php echo $billdate; ?></td>
        <td><?php echo $product_name; ?><br>
            Unit_Name : <?php echo $unit_name; ?><br>
            Rate : <?php echo $key['rate']; ?><br>
        </td>
        <td><?php echo $qty; ?></td>
        <td>KOT_No. : <?php echo $kotid; ?><br>
          Table_No. : <?php echo $table_no; ?>
        </td>
        
        <td>Remark : <?php echo $key['cancel_remark']; ?><br>
          Status : <?php echo $status; ?>
        </td>
        <td><?php echo $username; ?></td>

    </tr>
  <?php } ?>
