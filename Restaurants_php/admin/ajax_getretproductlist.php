<?php
include("../adminsession.php");
$id=addslashes($_REQUEST['id']);
$tblname=addslashes($_REQUEST['tblname']);
$tblkey=addslashes($_REQUEST['tblkey']);
?>
    
    <table class="table table-condensed table-bordered" style="width:100%; border-radius:5px; float:left" id="myTable">
<tr class="header" style="font-size:12px;color:#000;">
    <th>SL</th>
    <th>Item</th>
    <th>Unit</th>
    <th>Bill No</th>
    <th>EXP_Date</th>
    <th>Quantity</th>
    <th>Prev. Ret.</th>
    <!-- <th>Bal Qty</th> -->
</tr>
    
<?php
$slnos = 1;
	 $res = $obj->executequery("select * from purchasentry_detail where sale_pur_type='purchase'");
	    foreach($res as $row)
       {
		 $product_name = $obj->getvalfield("m_product","product_name","product_id='$row[product_id]'");
		 $billno = $obj->getvalfield("purchaseentry","billno","purchaseid='$id'");
		 
		 $unit_name = $row['unit_name'];
		 $qty = $row['qty'];
		 $ret_qty = $obj->getvalfield("purchasentry_detail","sum(ret_qty)","product_id='$row[product_id]'");
		 
		 
		 //$billno = $row['billno'];
		 //$expirydate = $obj->dateformatindia($row['expirydate']);
		 
		 if($ret_qty =='')
		 {
			$ret_qty=0; 
		 }
		 $bal_qty=$qty - $ret_qty;
			
		//$stock=$cmn->get_stock($row['productid']);
 ?>	
 <tr onClick="addproduct('<?php echo $row['product_id'];?>','<?php echo $product_name; ?>','<?php echo $unit_name; ?>','<?php echo $qty; ?>','<?php echo $ret_qty; ?>','<?php echo $billno; ?>','<?php echo $bal_qty; ?>');" style="cursor:pointer;">
            	<td><span style="font-weight:bold;font-size:12px;"><?php echo $slnos++; ?></span></td>
                <td><span style="font-weight:bold;font-size:12px;" ><?php echo $product_name; ?> </span></td>
                <td><span style="font-weight:bold;font-size:12px;"> <?php echo $unit_name; ?> </span></td>
                <td><span style="font-weight:bold;font-size:12px;"> <?php echo $billno; ?> </span></td>
                <td><span style="font-weight:bold;font-size:12px;"></span></td>
                <td style="text-align:right;"><span style="font-weight:bold;font-size:12px;"> <?php echo $qty; ?></span>&nbsp;</td>
                <td style="text-align:right;"><span style="font-weight:bold;font-size:12px;"> <?php echo $ret_qty; ?></span>&nbsp;</td>
                <td style="text-align:right;"><span style="font-weight:bold;font-size:12px;"> <?php echo $bal_qty; ?></span>&nbsp;</td>
                </tr>
<?php 		
	}




?>


