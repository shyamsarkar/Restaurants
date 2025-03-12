<?php
include("../adminsession.php");

 $purchaseid=$obj->test_input($_REQUEST['purchaseid']); 
$res = $obj->executequery("select * from purchasentry_detail where purchaseid='$purchaseid' and sale_pur_type = 'purchase'");
$sn=1;
$amount=0;
?>

<form action="" method="post" >

<table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Product Name</th>
                                                <th>Unit</th>
                                                <th>Bill No.</th>
                                                <th>Expiry Date</th>
                                                <th>Qty.</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
									
			foreach($res as $row_get)
                       {
				
				
				$purchaseid=$rowget['purchaseid'];
				$product_id=$rowget['product_id'];
        $unit_name=$rowget['unit_name'];
				//$unitid=$obj->getvalfield("m_product","unitid","product_id='$product_id'");
		    $qty=$rowget['ret_qty'];
				$billno=$rowget['billno'];
				//$expirydate= $obj->dateformatindia($rowget['expirydate']);
				$product_name=$obj->getvalfield("m_product","product_name","product_id='$product_id'");
			  $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
				
				?>
                <tr>
                    <td><?php echo $sn; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $unit_name; ?></td>
                    <td><?php echo $billno; ?></td>
                    <td></td>
                    <td><?php echo $qty;  ?></td>
                    <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $purchaseid; ?>');"> X </a>
                    </td>
                </tr>
                                            
        <?php
			
$sn++;
}

?>                                   
      <tr>
      </tr>    
                                           
     </tbody>
  </table>
 <input type="hidden" name="purchaseid" value="<?php echo $purchaseid; ?>"  />
 <p align="center">                                   
                                    
       <input type="submit" name="save" id="save" class="btn btn-primary" value="save"  />
        <a href="purchasereturn.php" class="btn btn-danger">Reset</a>
      <input type="hidden" name="purchaseid" value="<?php echo $purchaseid; ?>"  />
   
     </p>
     
</form>
