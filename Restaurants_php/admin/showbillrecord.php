<?php
include("../adminsession.php");
$table_id = $_REQUEST['table_id'];
$floor_id = $_REQUEST['floor_id'];
$zomato = $_REQUEST['zomato'];
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
                             <td>Total</td>
                             <td>Disc(Rs)</td>
                             <td>Taxable</td>
                             <td>Canc_Remark</td>
                             <td>Action</td>
                             <td>Cancelled</td>
                           </tr>
                            <?php 
                            $sno = 1;
                            $total = 0;
                            $sqlget = $obj->executequery("select * from view_bill_details where table_id='$table_id' && isbilled='0'");
                            $bev_cgst = 0;
                            $bev_sgst = 0;
                            $food_cgst = 0;
                            $food_sgst = 0;
                            $total_bill_cgst = 0;
                            $total_bill_sgst = 0;
                            $total_taxable_bev = 0;
                            $total_taxable_food = 0;
                            foreach ($sqlget as $rowget) 
                            {
                                $billdetailid=$rowget['billdetailid'];
                                $cancel_remark = $rowget['cancel_remark'];
                                $table_id = $rowget['table_id'];
                                $productid=$rowget['productid'];
                                $unitid=$rowget['unitid'];
                                $qty=$rowget['qty'];
                                $rate=$rowget['rate'];
                                $disc_percent=$rowget['disc_percent'];
                                $disc_rs = $rowget['disc_rs'];
                                $taxable = $rowget['taxable'];
                                $kotid = $rowget['kotid'];
                                $amount= $qty * $rate;

                                $calc_disc_rs =  $rowget['total'] - $rowget['taxable'];
                                $prodname =$obj->getvalfield("m_product","prodname","productid='$productid'");
                                $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
                                $waiter_id=$rowget['waiter_id'];
                                $waiter_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id'");
                               $billid = $rowget['billid'];
                               $foodtypeid = $rowget['foodtypeid'];

                               //beverages
                               if($foodtypeid == 1)
                               {
                                 $total_taxable_bev +=  $rowget['taxable'];
                                 $bev_cgst += $rowget['taxable'] * $rowget['cgst']/100;
                                 $bev_sgst += $rowget['taxable'] * $rowget['sgst']/100;
                                 //$tot_bev_gst += ($bev_cgst + $bev_sgst);
                               }

                               //food
                               if($foodtypeid == 2)
                               {
                                  $total_taxable_food +=  $rowget['taxable'];
                                  $food_cgst += $rowget['taxable'] * $rowget['cgst']/100;
                                  $food_sgst += $rowget['taxable'] * $rowget['sgst']/100;
                                  //$tot_food_gst += ($food_cgst + $food_sgst);
                               }


                             ?>
                              <tr style="cursor: pointer;">
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $prodname; ?></td>
                                <td style="text-align: center;"><?php echo $kotid; ?></td>
                                <td><?php echo $unit_name; ?></td>
                                <td><?php echo $qty;  ?></td>
                                <td align="right"><?php echo number_format($rate,2);  ?></td>
                                <td align="right"><?php echo number_format($amount,2);  ?></td>
                                <td align="right"><?php echo number_format($calc_disc_rs,2);  ?></td>
                                <td style="color:#900; font-weight:bold" align="right"><?php echo number_format($taxable,2); ?></td>
                                <td><?php echo $cancel_remark; ?></td>
                                 <?php if($kotid > 0) { ?>
                                <td class="center"><a class="btn btn-danger btn-small disabled"> X </a></td>
                              <?php } else { ?> <td class="center"><a class="btn btn-danger btn-small <?php if($billid > 0 ){ echo "disabled"; } ?>" onClick="deleterecord('<?php echo $zomato; ?>','<?php echo $billdetailid; ?>',<?php echo $billid; ?>);"> X </a></td><?php } ?>

                                <?php if($cancel_remark!='') { ?>
                                <td class="center"><a class="btn btn-primary btn-small" disabled> C </a></td>
                               <?php } else { ?> <td class="center"><a class="btn btn-primary btn-small" onclick="cancel_product('<?php echo $zomato; ?>','<?php echo  $rowget['billdetailid']; ?>','<?php echo  $rowget['rate']; ?>','<?php echo  $rowget['table_id']; ?>');"> C </a></td><?php } ?>
                            
                        </tr>
                        <?php  
                        $total += $rowget['taxable'];
                        } //loop close

                        $total_bill_cgst = $bev_cgst + $food_cgst;
                        $total_bill_sgst = $bev_sgst + $food_sgst; 

                        $net_bill_amt1 = round($total + $total_bill_cgst + $total_bill_sgst);
                            ?>
                           <tr>
 <td colspan="3"><label> <strong>Is Parcel</strong>  &nbsp; 
 <input type="checkbox" name="is_parsal" id="is_parsal" value="1" class="form-control"/> </label> </td>
 <td colspan="9" align="right" style="text-align:right;">

<h3> <strong>After Disc. Food Total : <span  style="color:#00F;" > <?php echo number_format($total_taxable_food,2); ?> </span></strong> </h3>
<h3> <strong>After Disc. Beverages Total : <span  style="color:#00F;" > <?php echo number_format($total_taxable_bev,2); ?> </span></strong> </h3>
<h3> <strong>Gross Total : <span  style="color:#00F;" > <?php echo number_format($total,2); ?> </span></strong> </h3> 
<h3> <strong>CGST: <span  style="color:#00F;" > <?php echo number_format($total_bill_cgst,2); ?> </span></strong> </h3> 
<h3> <strong>SGST: <span  style="color:#00F;" > <?php echo number_format($total_bill_sgst,2); ?> </span></strong> </h3> 
<h3> <strong>Net Bill Amt: <span  style="color:#00F;" > <?php echo $net_bill_amt1; ?> </span></strong> </h3> 
<input type="hidden" name="hidden_basic_amt" id="hidden_basic_amt" value="<?php echo $total; ?>" />
<input type="hidden" name="hidden_cgst_amt" id="hidden_cgst_amt" value="<?php echo $total_bill_cgst; ?>" />
<input type="hidden" name="hidden_sgst_amt" id="hidden_sgst_amt" value="<?php echo $total_bill_sgst; ?>" /> 
<input type="hidden" name="hidden_net_bill_amt" id="hidden_net_bill_amt" value="<?php echo $net_bill_amt1; ?>" /> 
<input type="hidden" name="hidden_food_amt" id="hidden_food_amt" value="<?php echo $total_taxable_food; ?>" /> 
<input type="hidden" name="hidden_bev_amt" id="hidden_bev_amt" value="<?php echo $total_taxable_bev; ?>" /> 
</td>
 </tr>
 <tr>
    <td colspan="12">KOT's : 
    <?php
    $slno = 0;
   // echo "select * from kot_entry where table_id = '$table_id' and billid=0";
    $res_kot = $obj->executequery("select * from kot_entry where table_id = '$table_id' and billid=0");
    foreach ($res_kot as $row_kot) 
    
    {
      
         ++$slno;
      
        ?>
       
        <a target="_blank" href="pdf_restaurant_kot_recipt_new.php?kotid=<?php echo $row_kot['kotid']; ?>" class="btn  btn-danger"><?php echo $slno; ?></a> 
    <?php
    } 
    ?>
    
    </td>
    </tr>
      <tr>
      <td colspan="12">
          <p align="center"> 


          <?php if($net_bill_amt == 0){ ?>
          <input type="button" class="btn btn-danger btn-xm" value="Save BiLL" name="submit" onclick="show_discount_modal();">  
          <?php } ?>


          <input type="hidden" name="table_id" value="<?php echo $table_id; ?>"  />&nbsp;
          <a  onclick="refreshkot(0,'<?php echo $zomato;?>','<?php echo $table_id;?>','<?php echo $floor_id; ?>');" class="btn btn-info btn-xm" target="_blank" >
          <i class="iconfa-print"></i> Print KOT</a>&nbsp;
          
          <?php if($net_bill_amt > 0 ){ ?>
          <a class="btn btn-success btn-xm" onclick="show_payment_modal('<?php echo $net_bill_amt1; ?>','<?php echo $billnumber; ?>','<?php echo $table_no; ?>');">
          <i class="iconfa-money"></i> Payment</a>&nbsp;
          <?php }

          else{
            $check_billed = $obj->getvalfield("bills","count(*)","table_id='$table_id' and is_paid = 0");

            if($check_billed == 1)
            {
            ?>
              <a class="btn btn-success btn-xm" onclick="close_nc_bill('<?php echo $net_bill_amt; ?>','<?php echo $billid; ?>','<?php echo $table_id; ?>');">
              <i class="iconfa-money"></i>Close N/C Bill</a>&nbsp;
            <?php
            }
          }
          ?>

          <?php if($net_bill_amt > 0){
            $rec_billid = $obj->getvalfield("bills","billid","table_id='$table_id' and is_paid = 0 and net_bill_amt > 0");
           ?>
          <a class="btn btn-warning btn-xm" target="_blank" href="pdf_restaurant_recipt.php?billid=<?php echo $rec_billid; ?>">
          <i class="iconfa-print"></i> PRINT BILL</a>&nbsp;
          <?php } ?>
        
          
          <a href="in_entry.php" class="btn btn-primary"> Reset </a>
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

