<?php
include("../adminsession.php");
$purchaseid=trim(addslashes($_REQUEST['purchaseid'])); 

if($purchaseid =='')
{
	$purchaseid=0;	
}
else
{
	$purchaseid=$purchaseid;
}
//$sn=1;
$where = array("purchaseid"=>$purchaseid,"sale_pur_type"=>'sale');
$res = $obj->select_data("purchasentry_detail",$where);
$sn=1;

$amount=0;
$totgst=0;
$totalamount=0;
$totalamount1=0;
$totsgst=0;
$totigst=0;
$rate_amt=0;
$inc_or_exc = "";
//$totaldisc = "";
$discamt = 0;
$tot_taxable = 0;
$total_final_price = 0;
$totaldisc = 0;
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
                                                <th>Disc%</th>
                                                <th>TAXABLE</th>
                                                <th colspan="2">CGST%</th>
                                                <th colspan="2">SGST%</th>
                                                <th colspan="2">IGST%</th>
                                                <th>TaxType</th>
                                                <th class="center">Action</th>
                                            </tr>
                                               
                                               
                                                <tr>
                                                    <td colspan="8"></td>
                                                    <td>Rate</td>
                                                    <td>Amt</td>
                                                    <td>Rate</td>
                                                    <td>Amt</td>
                                                    <td>Rate</td>
                                                    <td>Amt</td>
                                                    <td colspan="2"></td>
                                                    
                                                </tr>
                                            
                                        </thead>
                                        <tbody>
                                        
                                        <?php
				//$toal_disc=0;					
			foreach($res as $rowget)
			{
					
					$purdetail_id=$rowget['purdetail_id'];
					$product_id=$rowget['product_id'];
					$product_name = $obj->getvalfield("m_product","product_name","product_id='$product_id'");
					$purchaseid=$rowget['purchaseid'];
          $unit_name = $rowget['unit_name'];
					$qty=$rowget['qty'];
				  $rate_amt=$rowget['rate_amt'];
          $disc=$rowget['disc'];
          $taxable=$rowget['taxable'];
          $cgst=$rowget['cgst'];
          $cgst_amt=$rowget['cgst_amt'];
					$sgst=$rowget['sgst'];
          $sgst_amt=$rowget['sgst_amt'];
					$igst = $rowget['igst'];
          $igst_amt=$rowget['igst_amt'];
          $inc_or_exc = $rowget['inc_or_exc'];
          $final_price =$rowget['final_price'];
          $taxable_value = $rowget['taxable_value'];
					$total =	$qty * $rate_amt;
          $discamt = ($total * $disc)/100;
          
					// $totalc = ($discamt * $cgst)/100;
     //      $totals = ($discamt * $sgst)/100;
     //      $totali = ($discamt * $igst)/100;

			?>
        <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $product_name; ?></td>
          <td><?php echo $unit_name; ?></td>
          <td><?php echo $rate_amt;  ?></td>
          <td><?php echo $qty;  ?></td>
          <td><?php echo $total;  ?></td>
          <td><?php echo $disc;  ?></td>
          <td><?php echo $taxable_value;  ?></td>
          <td><?php echo $cgst;  ?></td>
          <td><?php echo $cgst_amt;  ?></td>
          <td><?php echo $sgst;  ?></td>
          <td><?php echo $sgst_amt;  ?></td>
          <td><?php echo $igst;  ?></td>
          <td><?php echo $igst_amt;  ?></td>
          <td><?php echo $inc_or_exc;  ?></td>
         <!--  <td style="text-align:right;"><?php echo number_format($total,2);  ?></td> -->
          <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $purdetail_id; ?>');"> X </a></td>

     </tr>
                                            
             <?php
			 		
					$amount += $total;
					$totgst += $cgst_amt;
          $totigst += $igst_amt;
          $totsgst += $sgst_amt;
          $totaldisc += $discamt;
          $total_final_price += $final_price;
          //$totaldisc += $discamt;
          //$totaldisc1 = $amount - $totaldisc;
          $tot_taxable += $taxable_value;
				//	$totalgst = $totgst + $totsgst + $totigst;
				//	$totalamount = $totalgst + $totaldisc1;
         // $totalamount1 = $amount;
$sn++;
}
?>    
            <tr>
 
                    <td colspan="18" align="right" style="text-align:right;"><h5>Total :
                    <input type="text" id="tot_amt" value="<?php echo number_format($amount,2); ?>" style= "width:70px; border:none; font-weight:bold; text-align:right;" readonly="readonly"  />
                    <input type="hidden" id="hidtot_amt" value="<?php echo $amount; ?>" style= "width:70px; border:none; font-weight:bold;" readonly="readonly"  /> </h5> </td>
                    <td>&nbsp;</td>
           </tr>
            <tr>
               <td colspan="18" align="right" style="text-align:right;"><h5> Total DISC :
               <input type="text" id="" value="<?php echo number_format($totaldisc,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
                <td>&nbsp;</td>
               </tr>
               <tr>
               <td colspan="18" align="right" style="text-align:right;"><h5> Total TAXABLE :
               <input type="text" id="" value="<?php echo number_format($tot_taxable,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
                <td>&nbsp;</td>
               </tr>
           <tr>
               <td colspan="18" align="right" style="text-align:right;"><h5> Total CGST :
               <input type="text" id="" value="<?php echo number_format($totgst,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
                <td>&nbsp;</td>
               </tr>
               
           <tr>
           <tr>
               <td colspan="18" align="right" style="text-align:right;"><h5>Total SGST :
               <input type="text" id="" value="<?php echo number_format($totsgst,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
                <td>&nbsp;</td>
               </tr>
               
           <tr>
           <tr>
               <td colspan="18" align="right" style="text-align:right;"><h5>Total IGST :
               <input type="text" id="tot_tax_gst" value="<?php echo number_format($totigst,2); ?>" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
                </h5> </td>
                <td>&nbsp;</td>
               </tr>
              
           <tr>
               <?php if ($inc_or_exc == 'exclusive')
                { 
                  ?>
               <td colspan="18" align="right" style="text-align:right;"><h5>Net Total  :
               <input type="text" value="<?php echo number_format(round($total_final_price),2); ?>" name="net_amount" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
               <?php
               }//if close
             else
             { 
              ?>
              <td colspan="18" align="right" style="text-align:right;"><h5>Net Total  :
               <input type="text" value="<?php echo number_format(round($total_final_price),2); ?>" name="net_amount" style= "width:70px; border:none; font-weight:bold;text-align:right;" readonly="readonly"  />
            <?php
             }//else close
             ?>

                 </h5> </td>
                <td>&nbsp;</td>
               <!--  <td>&nbsp;</td> -->

               </tr>
               
                                
      <tr>
      <td colspan="15"><p align="center"> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
      <input type="hidden" name="purchaseid" value="<?php echo $purchaseid; ?>"  />
      <a href="purchaseentry.php" class="btn btn-primary" >Reset </a>
      
       </p>  </td>
      </tr>                                      
               
                                           
                                        </tbody>
                                    </table>
