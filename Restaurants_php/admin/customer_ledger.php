<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "customer_ledger.php";
$module = "Report Customer Ledger";
$submodule = "Customer Ledger Report";
$btn_name = "Save";
$keyvalue =0 ;


if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$duplicate = "";
$company_id = $_SESSION['company_id'];
$crit = " where 1 = 1 ";
if(isset($_GET['customer_id']))
{
  $customer_id = $_GET['customer_id'];
  $crit .= " and customer_id = '$customer_id'";
}
else
{
	$customer_id = 0;
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
<script type="text/javascript">
  function getid(customer_id)
  {
    location = 'customer_ledger.php?customer_id='+customer_id;
  }
</script>
</head>
<body>

<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
     <!-- START OF RIGHT PANEL -->
   <div class="rightpanel">
    	<?php include("inc/header.php"); ?>
       
      
        <div class="maincontent">
        	 <div class="contentinner content-dashboard">

            <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                <th>Party Name:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                    <td>
                  <select name="customer_id" id="customer_id" class="chzn-select" onchange="getid(this.value);">
                        <option value="">--All--</option>
                        <?php
                        $slno=1;
                        $company_id = $_SESSION['company_id'];
                    $res = $obj->executequery("select * from master_customer where company_id =  $company_id");

                        foreach($res as $row_get)
                        
                        {               
                        ?>
                        <option value="<?php echo $row_get['customer_id'];  ?>"> <?php echo $row_get['customer_name']; ?></option>
                        <?php } ?>
                    </select>
                <script>document.getElementById('customer_id').value='<?php echo $customer_id; ?>';</script>                   
                    </td>
                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                    <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <hr>
            <div>
            </form>
            <?php if($customer_id > 0){ ?>
            <p align="right" style="margin-top:7px; margin-right:10px;"> 
             <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
             </p>
                
                    <?php
                    //show if customer selected
                    if($customer_id > 0)
                    {

                    $slno = 1;
                    $arrayName = array();
                 // echo "select * from master_customer $crit and company_id = $company_id";die;
                    $sql = $obj->executequery("select * from master_customer $crit and company_id = $company_id");
					foreach($sql as $row_get)
					{
						$openingbal = $row_get['openingbal'];
						$open_bal_date = $obj->dateformatindia($row_get['open_bal_date']);
						$particular = "Opening Balance";
						$company_id = $row_get['company_id'];
					  $company_name = $obj->getvalfield("company_setting","company_name","company_id=$company_id");
						$arrayName[]=array('led_date'=>$open_bal_date,'particular'=>$particular,'billtype'=>'openingbal','company_name'=>$company_name,'total'=>$openingbal,'led_type'=>'debit');
						//echo "<pre>";
						//print_r($arrayName);die;

					}
          
          $sql = $obj->executequery("select * from purchaseentry $crit and company_id = $company_id and type = 'saleentry'");
                  
                    
					foreach($sql as $row_get)
					{
					    $purchaseid = $row_get['purchaseid'];
              $net_amount = $row_get['net_amount'];
					    $bill_date = $obj->dateformatindia($row_get['bill_date']);
					    $billno = $row_get['billno'];
					    $customer_id = $row_get['customer_id'];
					 
					    $company_id = $row_get['company_id'];
					    $company_name = $obj->getvalfield("company_setting","company_name","company_id=$company_id");
					   
					    $particular = "By saleentry Entry $billno";
					 
					   
					$arrayName[]=array('led_date'=>$bill_date,'particular'=>$particular,'billtype'=>'saleentry','company_name'=>$company_name,'total'=>$net_amount,'led_type'=>'debit');
					 }

           $sql = $obj->executequery("select * from voucherentry $crit and is_security = '0' and company_id = $company_id");
          foreach($sql as $row_get)
          {
          $pay_date = $row_get['pay_date'];
          $voucher_no = $row_get['voucher_no'];
          $customer_id = $row_get['customer_id'];
          //$customer_name = $obj->getvalfield("master_customer","customer_name","customer_id=$customer_id");
          $company_id = $row_get['company_id'];
          $company_name = $obj->getvalfield("company_setting","company_name","company_id=$company_id");
          $paid_amt = $row_get['paid_amt'];
          $payment_type = $row_get['payment_type'];
          if($payment_type == 'Received' ){  $led_type = 'credit'; }else{ $led_type = 'debit'; }

          if($payment_type == 'Received' ){  $vou_type = 'Received'; }else{ $vou_type = 'Payment'; }

          $particular = "By voucher Entry $voucher_no ($vou_type)";

          $arrayName[]=array('led_date'=>$pay_date,'particular'=>$particular,'billtype'=>'voucher','company_name'=>$company_name,'total'=>$paid_amt,'led_type'=>$led_type);

              ?>
                         
              <?php 
              } 

              ?>
                         
							<?php 
							} 

							function date_compare($a, $b)
							{

							$t1 = strtotime($a['led_date']);
							$t2 = strtotime($b['led_date']);
						  return $t1 - $t2;
							}    
							usort($arrayName, 'date_compare');

							//echo "<pre>";
							//print_r($arrayName);

							?>
							<br>
							<?php if(isset($customer_id) !='')
							{
							?>
							
							<h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
							
            	             <table class="table table-bordered" id="tblData">
							<tr>
								<td>Slno</td>
								<td>Date</td>
								<td>Particular</td>
								<td>Ledgertype</td>
								<td>Debit</td>
								<td>Credit</td>
								<td>Balance</td>
							</tr>

                    <?php
                        $balance = 0;
                        $total_debit = 0;
                        $total_credit = 0;
                        $total_balance = 0;
                        foreach ($arrayName as $key)
                      {
                    	if($key['led_type'] == 'debit')
                    	{ 
                    		$credit = 0;
                    		$debit = $key['total'];
                    		$total_debit +=  $debit;
                    	}
                    	else
                    	{
                    		$debit = 0;
                    		$credit = $key['total'];
                    		$total_credit += $credit;
                    	}

                    	$balance +=  $debit - $credit;
                    ?>
                    <tr>
                         	<td><?php echo $slno++; ?></td>
                         	<td><?php echo $key['led_date']; ?></td>
                         	<td><?php echo $key['particular']; ?></td>
                         	<td><?php echo $key['billtype']; ?></td>
                         	<td style="text-align: right;"><?php echo number_format($debit,2); ?></td>
                         	<td style="text-align: right;"><?php echo number_format($credit,2); ?></td>
                         	<td style="text-align: right;"><?php echo number_format($balance,2); ?></td>
                         </tr>
                     <?php
                 		} //close foreach loop
                 		?>
                 		<tr>
                 				<td colspan="4">Total : </td>
                 				<td style="text-align: right;"><?php echo number_format($total_debit,2); ?></td>
                 				<td style="text-align: right;"><?php echo number_format($total_credit,2); ?></td>
                 				<td style="text-align: right;">Balance: <?php echo number_format(($total_debit - $total_credit),2); ?></td>
                 			</tr>
                 			</table>
                            
                        <?php }

                        }//if close (most outer if)
                        ?>
                            </div>
		           	  </div><!--contentinner-->
      			 	 </div><!--maincontent-->
    				</div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->
</div><!--mainwrapper-->
<script type="text/javascript">
	
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}


</script>
</body>
</html>
