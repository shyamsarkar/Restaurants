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
$where = array("purchaseid"=>$purchaseid,"sale_pur_type"=>'purchase');
$res = $obj->select_data("purchasentry_detail",$where);
$sn=1;


?>
<table width="100%" class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product Name</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Return Qty</th>
                                                <th>Balance Qty</th>
                                                <th class="center">Action</th>
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
          $ret_qty=$rowget['ret_qty'];
          $bal_qty=$qty - $ret_qty;
        
      ?>
        <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $product_name; ?></td>
          <td><?php echo $unit_name; ?></td>
          <td><?php echo $qty;  ?></td>
          <td><?php echo $ret_qty;  ?></td>
          <td><?php echo $bal_qty;  ?></td>
          <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $purdetail_id; ?>');"> X </a></td>

     </tr>
                                            
             <?php
          
          
         
$sn++;
}
?>    
           







               <!--  <td>&nbsp;</td> -->

               </tr>
               
                                
     <!--  <tr>
      <td colspan="15"><p align="center"> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
      <input type="hidden" name="purchaseid" value="<?php echo $purchaseid; ?>"  />
      <a href="purchaseentry.php" class="btn btn-primary" >Reset </a>
      
       </p>  </td>
      </tr>   -->                                    
               
                                           
                                        </tbody>
                                    </table>
