<?php
include("../adminsession.php");
$billid=$obj->test_input($_REQUEST['billid']); 
$table_id=$obj->getvalfield("bills","table_id","billid='$billid'");
$sn=1;
$where = array("billid"=>$billid);
$res = $obj->select_data("bill_details",$where);
$amount=0;
$rate_amt=0;
?>
<table width="100%" class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product Name</th>
                                                <th>Unit</th>
                                                <th>Rate</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
								
			foreach($res as $rowget)
			{
					
					$billdetailid=$rowget['billdetailid'];
					$productid=$rowget['productid'];
					$product_name = $obj->getvalfield("m_product","prodname","productid='$productid'");
					$billid=$rowget['billid'];
          $unitid=$rowget['unitid'];
          $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
					$qty=$rowget['qty'];
				  $rate_amt=$rowget['rate'];
         // $final_price =$rowget['final_price'];
          $taxable_value = $rowget['taxable_value'];
					$total =	$qty * $rate_amt;
          //food total
        $food_total = $obj->getvalfield("view_bill_details","sum(total)","foodtypeid=2 and table_id = '$table_id' and isbilled=0");

        //bev total
        $bev_total = $obj->getvalfield("view_bill_details","sum(total)","foodtypeid=1 and table_id = '$table_id' and isbilled=0");

        $sub_total = $food_total + $bev_total;

        $net_bill_amt = $obj->getvalfield("bills","net_bill_amt","table_id='$table_id' and is_paid=0");


if($net_bill_amt > 0)
{
  $basic_bill_amt = $obj->getvalfield("bills","basic_bill_amt","table_id='$table_id' and is_paid=0");
  $disc_percent = $obj->getvalfield("bills","disc_percent","table_id='$table_id' and is_paid=0");
  $disc_rs = $obj->getvalfield("bills","disc_rs","table_id='$table_id' and is_paid=0");

  if($disc_percent > 0)
  {
    $disc_amt = $basic_bill_amt * $disc_percent/100;
  }
  else
   $disc_amt = 0; 


  $disc_amt = $disc_amt + $disc_rs;
  $taxable_amt = $basic_bill_amt - $disc_amt;


  $sgst = $obj->getvalfield("tax_setting_new","sgst","1=1");
  $cgst = $obj->getvalfield("tax_setting_new","cgst","1=1");



  $sgst_amt = $taxable_amt * $sgst / 100;
  $cgst_amt = $taxable_amt * $cgst / 100;


}
else
{
  $sgst_amt=0;
  $cgst_amt=0;
  $disc_amt = 0;
}
           if($billid > 0)
           {


			?>
        <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $product_name; ?></td>
          <td><?php echo $unit_name; ?></td>
          <td><?php echo $rate_amt;  ?></td>
          <td><?php echo $qty;  ?></td>
          <td><?php echo $total;  ?></td>
          <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $billdetailid; ?>');"> X </a> / &nbsp;<a  class="btn btn-primary btn-small" title="Edit" onclick="updaterecord('<?php echo $product_name; ?>','<?php echo $productid; ?>','<?php echo $unit_name; ?>','<?php echo $qty; ?>','<?php echo $rate_amt; ?>','<?php echo $billdetailid; ?>');">
          <span class='icon-edit' ></span></td>

     </tr>
                                            
        <?php
        $sn++;
        } }
        ?>    
            <tr>
 
                    <td colspan="7" align="right" style="text-align:right;"><h5>Food Total :
                    <input type="text" name="food_amt" value="<?php echo number_format($food_total,2); ?>" style= "width:70px; border:none; font-weight:bold; text-align:right;" readonly="readonly"  />
                   
           </tr>
            <tr>
               <td colspan="7" align="right" style="text-align:right;"><h5> Beverages total :
               <input type="text" name="bev_total" value="<?php echo number_format($bev_total,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
               
               </tr>
                <tr>
               <td colspan="7" align="right" style="text-align:right;"><h5> Gross Total :
               <input type="text" name="basic_bill_amt" value="<?php echo number_format($sub_total,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
               
               </tr>

                <?php 
                if($disc_amt > 0)
                { ?>

               <tr>
               <td colspan="7" align="right" style="text-align:right;"><h5> Discount :
               <input type="text" name="disc_amt" value="<?php echo number_format($disc_amt,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
               
               </tr>
            <?php }
            if($cgst_amt > 0)
            { ?>
           <tr>
               <td colspan="7" align="right" style="text-align:right;"><h5> CGST :
               <input type="text" id="" value="<?php echo number_format($cgst_amt,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
               
               </tr>
              <?php } 
              if($sgst_amt > 0)
              { ?>
               
          
           <tr>
               <td colspan="7" align="right" style="text-align:right;"><h5>SGST :
               <input type="text" id="" value="<?php echo number_format($sgst_amt,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
               
               </tr>
               <?php } ?>
               
          
           
              
           <tr>
              
               <td colspan="7" align="right" style="text-align:right;"><h5>Net Bill Amt  :
               <input type="text" value="<?php echo round($net_bill_amt); ?>" name="net_bill_amt" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
               

                 </h5> </td>
              
              
               </tr>
               
                                
      <tr>
        <center>
      <td colspan="8"><p align="center"> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
      <input type="hidden" name="billid" value="<?php echo $billid; ?>"  />
      <a href="edit_bill.php" class="btn btn-primary" >Reset </a>
      
       </p>  </td></center>
      </tr>                                      
               
                                           
                                        </tbody>
                                    </table>
