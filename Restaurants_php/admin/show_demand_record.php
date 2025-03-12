<?php
include("../adminsession.php");
$demand_id=trim(addslashes($_REQUEST['demand_id'])); 

if($demand_id =='')
{
	$demand_id=0;	
}
else
{
	$demand_id=$demand_id;
}
//$sn=1;
$where = array("demand_id"=>$demand_id);
$res = $obj->select_data("demand_detail",$where);
$sn=1;


?>
<table width="100%" class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product Name</th>
                                                <th>Unit</th>
                                                <th>Qty.</th>
                                                <th width="10%" class="center" style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
				//$toal_disc=0;					
			foreach($res as $rowget)
			{
					
					$demand_detail_id=$rowget['demand_detail_id'];
					$product_id=$rowget['product_id'];
					$product_name = $obj->getvalfield("m_product","product_name","product_id='$product_id'");
					$demand_id=$rowget['demand_id'];
          $unit_name = $rowget['unit_name'];
					$qty=$rowget['qty'];
				  

			?>
        <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $product_name; ?></td>
          <td><?php echo $unit_name; ?></td>
          <td><?php echo $qty;  ?></td>
          
          
          <!-- <td style="text-align:right;"><?php echo $inc_or_exc;  ?></td> -->
          <td class="center">
            <a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $demand_detail_id; ?>');"> X </a>
           <!--  <a  class="btn btn-primary btn-small" title="Edit" onclick="updaterecord('<?php echo $product_name; ?>','<?php echo $product_id; ?>','<?php echo $unit_name; ?>','<?php echo $qty; ?>','<?php echo $rate_amt; ?>','<?php echo $cgst; ?>','<?php echo $sgst; ?>','<?php echo $igst; ?>','<?php echo $total; ?>','<?php echo $purdetail_id; ?>');">
          <span class='icon-edit' ></span> 
          </a> --></td>

     </tr>
                                            
             <?php
            $sn++;
            }
            ?>    
           
      <tr>
      <td colspan="12"><p align="center"> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
      <input type="hidden" name="demand_id" value="<?php echo $demand_id; ?>"  />
      <a href="purchaseentry.php" class="btn btn-primary" >Reset </a>
      
       </p>  </td>
      </tr>                                      
               
                                           
                                        </tbody>
                                    </table>
