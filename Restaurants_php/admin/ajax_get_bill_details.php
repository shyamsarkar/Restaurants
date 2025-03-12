<?php include("../adminsession.php");

$customer_id = $_POST['customer_id'];
$billyear = $_POST['billyear'];
$billmonth = $_POST['billmonth'];
$vendorgrp_id = $_POST['vendorgrp_id'];
$fun = $_POST['fun'];

$remark = "";
$company_id = $_SESSION['company_id'];
$jar_billdate = date('d-m-Y');
$jar_billno = $obj->getcode_jarbillno("monthly_jar_bill","jar_billno","1=1");

$mjar_billid = $obj->getvalfield("monthly_jar_bill","mjar_billid","customer_id='$customer_id' and billyear = '$billyear' and billmonth='$billmonth'");

$startdate = "$billyear-$billmonth-01";
$enddate = date("Y-m-t", strtotime($startdate));
$crow = 0;


if ($fun=="getbilldata") {
	
	//echo "select vid, `product_id`, sum(`disp_qty`)  from  dispatch_entry where process_type = 'delivery' and disp_date between '$startdate' and '$enddate' and vid = '$customer_id' GROUP by product_id";
	//die;

	if($mjar_billid > 0)
	{
		$jar_billno = $obj->getvalfield("monthly_jar_bill","jar_billno","mjar_billid=$mjar_billid");
		$jar_billdate = $obj->getvalfield("monthly_jar_bill","jar_billdate","mjar_billid=$mjar_billid");
		$remark = $obj->getvalfield("monthly_jar_bill","remark","mjar_billid=$mjar_billid");

		
		?>
		<table class="table table-condensed table-bordered">
			<tr>
				<td>Bill No.:</td> 
				<td>Bill Date :</td> 
				<td>Remark :</td> 
				<td>Send SMS :</td> 
				<td>Send Email :</td> 
			</tr>
			<tr>
				<td><input type="text" name="jar_billno" id="jar_billno" value="<?php echo $jar_billno; ?>"></td>
				<td><input type="text" name="jar_billdate" id="jar_billdate" value="<?php echo $obj->dateformatindia($jar_billdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask ></td>
				<td><input type="text" name="remark" id="remark" value="<?php echo $remark;?>" placeholder="Remark">
				</td>
				<td><input type="checkbox" name="sms" id="sms" value="1"></td>
				<td><input type="checkbox" name="email" id="email" value="1"></td>
			</tr>
			</table>
			<hr>
			<table class="table table-bordered table-condensed"  >
		                <thead>
		                  <tr>
		                    <th>Slno</th>
		                    <th>Product</th>
		                    <th>Rate</th>
		                    <th>Qty</th>
		                    <th>CGST</th>
		                    <th>SGST</th>
		                    <th>IGST</th>
		                    <th>Amt</th>
		                  </tr>
		                </thead>
		   
			<?php
			$row_material = $obj->executequery("select * from monthly_jar_bill_details where mjar_billid = '$mjar_billid'");
			$slno = 1;
			foreach ($row_material as $key) {

				//print_r($key);
				//die;
				$product_id = $key['product_id'];
				$totalqty = $key['qty'];
				$rate = $key['rate'];
				$amount = $rate * $totalqty;

				//gst tax
				$cgst = $key['cgst'];
				$sgst = $key['sgst'];
				$igst = $key['igst'];
				$nettotal = $key['nettotal'];
				//if()
				$product_name = $obj->getvalfield("m_product","product_name","product_id=$product_id");

			 ?>

				<tr>
					<td>
						<?php echo $slno++; ?>
						<input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
					</td>
					<td><?php echo $product_name; ?></td>

					<td><input style="width: 100px;" type="text" name="rate[]" value="<?php echo $rate; ?>" id="rate_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>

					<td><input style="width: 100px;" type="text" name="qty[]" value="<?php echo $totalqty; ?>" id="qty_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="cgst[]" value="<?php echo $cgst; ?>" id="cgst_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="sgst[]" value="<?php echo $sgst; ?>" id="sgst_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="igst[]" value="<?php echo $igst; ?>" id="igst_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="nettotal[]" value="<?php echo $nettotal; ?>" id="nettotal_<?php echo $product_id; ?>" readonly></td>
				</tr>
					
			<?php
			}
		?>
					
		                <tr>
		                  <td colspan="12"><p align="center"><br> <input type="submit" class="btn btn-danger" value="Update" name="submit"  >  &nbsp; &nbsp; 
		                  <input type="hidden" name="mjar_billid" value="<?php echo $mjar_billid; ?>"  />
		                  <input type="hidden" name="vendorgrp_id" value="<?php echo $vendorgrp_id; ?>">
		                  <a href="monthly_jar_billing.php" class="btn btn-primary" > Reset </a>
		                   </p>  </td>
		     	 	  </tr>
		     	 	   </table>  
		<?php
	}
	else
	{
		$row_material = $obj->executequery("select * from m_product where product_type = 'finished good' and show_month_bill = 1 order by product_name");
		//"select vid, `product_id`, sum(`disp_qty`) as totalqty  from  dispatch_entry where process_type = 'delivery' and disp_date between '$startdate' and '$enddate' and vid = '$customer_id' GROUP by product_id"
		$crow = sizeof($row_material);
		//print_r ($row_material );
		//die;


		if($crow > 0)
		{
			$slno = 1;
			$cgst_amt = 0;
			$sgst_amt = 0;
			$igst_amt = 0;
			?>
			<table class="table table-condensed table-bordered">
			<tr>
				<td>Bill No.:</td> 
				<td>Bill Date :</td> 
				<td>Remark :</td> 
				<td>Send SMS:</td>
				<td>Send Email:</td> 
			</tr>
			<tr>
				<td><input type="text" name="jar_billno" id="jar_billno" value="<?php echo $jar_billno; ?>"></td>
				<td><input type="text" name="jar_billdate" id="jar_billdate" value="<?php echo $jar_billdate; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask ></td>
				<td><input type="text" name="remark" id="remark" value="<?php echo $remark;?>" placeholder="Remark">
				</td>
				<td><input type="checkbox" name="sms" id="sms" value="1"></td>
				<td><input type="checkbox" name="email" id="email" value="1"></td>
			</tr>
			</table>
			<hr>
			<table class="table table-bordered"  >
		                <thead>
		                  <tr>
		                    <th>Slno</th>
		                    <th>Product</th>
		                    <th>Rate</th>
		                    <th>Qty</th>
		                    <th>CGST</th>
		                    <th>SGST</th>
		                    <th>IGST</th>
		                    <th>Amt</th>
		                  </tr>
		                </thead>
		   
			<?php
			foreach ($row_material as $key) {

				//print_r($key);
				//die;
				$product_id = $key['product_id'];
				$totalqty = $obj->getvalfield("dispatch_entry","sum(disp_qty)","process_type = 'delivery' and disp_date between '$startdate' and '$enddate' and vid = '$customer_id' and product_id='$product_id'");

				$rate = $obj->getvalfield("m_product","ratefrmdelivery","product_id=$product_id");
				$amount = $rate * $totalqty;

				//gst tax
				$cgst = $obj->getvalfield("m_product","cgst","product_id=$product_id");
				$sgst = $obj->getvalfield("m_product","sgst","product_id=$product_id");
				$igst = $obj->getvalfield("m_product","igst","product_id=$product_id");

				if($cgst > 0)
				$cgst_amt = $amount * $cgst/100;

				if($sgst > 0)
				$sgst_amt = $amount * $sgst/100;

				if($igst > 0)
				$igst_amt = $amount * $igst/100;

				$nettotal =  $amount + $cgst_amt + $sgst_amt + $igst_amt;
				//if()
				$product_name = $obj->getvalfield("m_product","product_name","product_id=$product_id");

			 ?>

				<tr>
					<td>
						<?php echo $slno++; ?>
						<input type="hidden" name="product_id[]" value="<?php echo $product_id; ?>">
					</td>
					<td><?php echo $product_name; ?></td>

					<td><input style="width: 100px;" type="text" name="rate[]" value="<?php echo $rate; ?>" id="rate_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>

					<td><input style="width: 100px;" type="text" name="qty[]" value="<?php echo $totalqty; ?>" id="qty_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="cgst[]" value="<?php echo $cgst; ?>" id="cgst_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="sgst[]" value="<?php echo $sgst; ?>" id="sgst_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="igst[]" value="<?php echo $igst; ?>" id="igst_<?php echo $product_id; ?>" onchange="set_total_amt(<?php echo $product_id; ?>);"></td>
					<td><input style="width: 100px;" type="text" name="nettotal[]" value="<?php echo $nettotal; ?>" id="nettotal_<?php echo $product_id; ?>" readonly></td>
				</tr>
					
			<?php
			}

		}
		?>
					
		                <tr>
		                  <td colspan="12"><p align="center"><br> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
		                  <input type="hidden" name="mjar_billid" value="<?php echo $mjar_billid; ?>"  />
		                  <input type="hidden" name="vendorgrp_id" value="<?php echo $vendorgrp_id; ?>">
		                  <a href="monthly_jar_billing.php" class="btn btn-primary" > Reset </a>
		                   </p>  </td>
		     	 	  </tr>
		     	 	   </table>  

				<?php
	}//else close
}//top outer if close 
?>
	     	 	       