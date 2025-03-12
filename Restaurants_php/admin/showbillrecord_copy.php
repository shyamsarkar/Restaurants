<?php
include("../adminsession.php");
$table_id = $_REQUEST['table_id'];
$floor_id = $_REQUEST['floor_id'];

$net_bill_amt = $obj->getvalfield("bills","net_bill_amt","table_id='$table_id' and is_paid=0");

$customer_name = $obj->getvalfield("bills","net_bill_amt","table_id='$table_id' and is_paid=0");

$billnumber = $obj->getvalfield("bills","billnumber","table_id='$table_id' and is_paid=0");
$billid = $obj->getvalfield("bills","billid","table_id='$table_id' and is_paid=0");

$table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");

?>
<table class="table table-condensed table-bordered" border="10px">
                           <tr class="alert-success">
                             <td>Sno.</td>
                             <td>PRODUCT NAME</td>
                             <td>KOTNo</td>
                             <td>UNIT</td>
                             <td>QTY</td>
                             <td>RATE</td>
                             <td>AMOUNT</td>
                             <td>Cencelled Remark</td>
                             <td>Action</td>
                             <td>Cancelled</td>
                             
                           </tr>
                           
                          
                            <?php 
                            $sno = 1;
                            $total = 0;
                            $sqlget = $obj->executequery("select * from bill_details where table_id='$table_id' && isbilled='0'");
                            foreach ($sqlget as $rowget) 
                            {
                                $billdetailid=$rowget['billdetailid'];
                                $cancel_remark = $rowget['cancel_remark'];
                                $table_id = $rowget['table_id'];
                                $productid=$rowget['productid'];
                                $unitid=$rowget['unitid'];
                                $qty=$rowget['qty'];
                                $rate=$rowget['rate'];
                                $kotid = $rowget['kotid'];
                                $amount= $qty * $rate;
                                $prodname=$obj->getvalfield("m_product","prodname","productid='$productid'");
                                $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
                                $waiter_id=$rowget['waiter_id'];
                                $waiter_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id'");
                               $billid = $rowget['billid'];
                             ?>
                              <tr style="cursor: pointer;">
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $prodname; ?></td>
                                <td style="text-align: center;"><?php echo $kotid; ?></td>
                                <td><?php echo $unit_name; ?></td>
                                <td><?php echo $qty;  ?></td>
                                <td align="right"><?php echo number_format($rate,2);  ?></td>
                                <td><?php echo $cancel_remark; ?></td>
                                <td style="color:#900; font-weight:bold" align="right"><?php echo number_format($amount,2); ?></td>
                                <td class="center"><a class="btn btn-danger btn-small <?php if($billid >0 ){ echo "disabled"; } ?>" onClick="deleterecord('<?php echo $billdetailid; ?>',<?php echo $billid; ?>);"> X </a></td>
                                <td class="center"><a class="btn btn-primary btn-small" onclick='cancel_product(<?php echo  $rowget['productid']; ?>,<?php echo  $rowget['rate']; ?>,<?php echo  $rowget['table_id']; ?>);'> C </a></td>
                            
                        </tr>
                        <?php  
                        $total += $amount;
                            } //loop close
                            ?>
                           <tr>
 <td colspan="3"><label> <strong>Is Parcel</strong>  &nbsp; 
 <input type="checkbox" name="is_parsal" id="is_parsal" value="1" class="form-control"/> </label> </td>
 <td colspan="6" align="right" style="text-align:right;">
  <h3> <strong>Basic Total : <span  style="color:#00F;" > <?php echo number_format($total,2); ?> </span></strong> </h3> 
               <input type="hidden" name="hidden_basic_amt" id="hidden_basic_amt" value="<?php echo $total; ?>" /></td>
 </tr>
 <tr>
    <td colspan="8">KOT's : 
    <?php
    $slno = 0;
   // echo "select * from kot_entry where table_id = '$table_id' and billid=0";
    $res_kot = $obj->executequery("select * from kot_entry where table_id = '$table_id' and billid=0");
    foreach ($res_kot as $row_kot) 
    
    {
      
         ++$slno;
      
        ?>
       
        <a target="_blank" href="pdf_restaurant_kot_recipt.php?kotid=<?php echo $row_kot['kotid']; ?>" class="btn  btn-danger"><?php echo $slno; ?></a> 
    <?php
    } 
    ?>
    
    </td>
    </tr>
      <tr>
      <td colspan="8">
          <p align="center"> 
          <input type="button" class="btn btn-danger btn-xm" value="Save BiLL" name="submit" onclick="show_discount_modal()">  
          <input type="hidden" name="table_id" value="<?php echo $table_id; ?>"  />&nbsp;
          <a  onclick="refreshkot(0,'<?php echo $table_id;?>','<?php echo $floor_id; ?>');" class="btn btn-info btn-xm" target="_blank" >
          <i class="iconfa-print"></i> Print KOT</a>&nbsp;
          <?php if($net_bill_amt > 0){ ?>
          <a class="btn btn-success btn-xm" onclick="show_payment_modal('<?php echo $net_bill_amt; ?>','<?php echo $billnumber; ?>','<?php echo $table_no; ?>');">
          <i class="iconfa-money"></i> Payment</a>&nbsp;
          <?php } ?>
          
          <a href="in_entry.php" class="btn btn-primary" > Reset </a>
          </p>
      </td>
      </tr>    

                                      </tbody>
                                    </table>
             <!--  <?php if($waiter_id > 0)
              {
              ?>     
            <center><h4 style="color: red;">Order From App</h4>
                     <h4>Waiter Name :&nbsp;<b><?php echo strtoupper($waiter_name); ?></b></h4>  </center>   

              <?php 
            }
               ?> -->
                                    <!-- '<?php //echo $net_bill_amt; ?>','<?php //echo $billnumber; ?>','<?php //echo $table_no; ?>' -->
                         
                         </table>

