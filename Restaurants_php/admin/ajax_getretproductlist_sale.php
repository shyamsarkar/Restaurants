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
    <!-- <th>Batch_No</th>
    <th>EXP_Date</th> -->
    <th>Quantity</th>
    <th>Prev. Ret.</th>
    <!-- <th>Bal Qty</th> -->
</tr>
    
<?php
$slnos = 1;
$ret_qty = 0;
	$sql=$obj->executequery("select * from purchasentry_detail where sale_pur_type='sale'");
	foreach ($sql as $row) {
		
	
	
		 $product_name = $obj->getvalfield("m_product","product_name","product_id='$row[product_id]'");
		 $unit_name = $row['unit_name'];
		 
		
		 $qty = $row['qty'];
		 $ret_qty = $row['ret_qty'];
		
 ?>	
 <tr onClick="addproduct('<?php echo $row['product_id'];?>','<?php echo $product_name; ?>','<?php echo $row['unit_name']; ?>');" style="cursor:pointer;">
            	<td><span style="font-weight:bold;font-size:12px;"><?php echo $slnos++; ?></span></td>
                <td><span style="font-weight:bold;font-size:12px;" ><?php echo $product_name; ?> </span></td>
                <td><span style="font-weight:bold;font-size:12px;"> <?php echo $unit_name; ?> </span></td>
             
                <td style="text-align:right;"><span style="font-weight:bold;font-size:12px;"> <?php echo $qty; ?></span>&nbsp;</td>
                <td style="text-align:right;"><span style="font-weight:bold;font-size:12px;"> <?php echo $ret_qty; ?></span>&nbsp;</td>
               
<?php 		
	}




?>


