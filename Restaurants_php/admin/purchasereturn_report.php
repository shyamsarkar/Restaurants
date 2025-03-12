<?php include("../adminsession.php");


$pagename = "purchasereturn_report.php";
$module = "Report Purchese Return";
$submodule = "Purchese Return Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "purchaseentry";
$tblpkey = "purchaseid";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$company_id = $_SESSION['company_id'];

if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
  $customer_id = "";
}

$crit = " where 1 = 1 and bill_date between '$from_date' and '$to_date'"; 



if(isset($_GET['supplier_id']))
{
  
  $supplier_id = $_GET['supplier_id'];
  if(!empty($supplier_id))
    $crit .= " and purchaseentry.supplier_id = '$supplier_id'";
}


?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
</head>
<body onLoad="getrecord('<?php echo $keyvalue; ?>');">

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
                
                <th>Supplier Name:</th>
                <th>From Date:</th>
                <th>To Date:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                  
                    <td>
                    <select name="supplier_id" id="supplier_id" class="chzn-select">
                        <option value="">--All--</option>
                        <?php
                        $slno=1;
                        $company_id = $_SESSION['company_id'];
                    $res = $obj->executequery("select * from master_supplier where company_id =  $company_id");

                        foreach($res as $row_get)
                        
                        {               
                        ?>
                        <option value="<?php echo $row_get['supplier_id'];  ?>"> <?php echo $row_get['supplier_name']; ?></option>
                        <?php } ?>
                    </select>
                <script>document.getElementById('supplier_id').value='<?php echo $supplier_id; ?>';</script>                   
                    </td>
                    <td><input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                <td><input type="text" name="to_date" id="to_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                
                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                	 <a href="purchasereturn_report.php" class="btn btn-primary" > Reset </a>
                </td>
              </tr>
            </table>
            <div>
            </form>


                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <thead>
                        <tr>
                            <th  class="head0 nosort">S.No.</th>
                            <th  class="head0">Company_Name</th>
							<th  class="head0">Bill_No</th>
                          	<th  class="head0">Customer Name</th>
                            <th  class="head0">Bill Type</th>
                            <th  class="head0">Qty</th>
                            <th  class="head0">Return_Qty</th>
                            <th  class="head0">Balance_Qty</th>
                            <th  class="head0">Return_Date</th>
                           
                            <th  class="head0" style="text-align:center;">Print A5</th>
                                                   
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
					<?php
					$slno=1;
					$totalamt=0;
					 $sql = "select * from purchaseentry left join purchasentry_detail on purchaseentry.purchaseid = purchasentry_detail.purchaseid $crit and type='purchaseentry'";
					$res = $obj->executequery($sql);
					foreach($res as $row_get)
					{
					///$total=0;
					$purchaseid = $row_get['purchaseid'];
					$ret_qty = $row_get['ret_qty'];
					$qty = $row_get['qty'];
					$supplier_id = $row_get['supplier_id'];
					$billno = $row_get['billno'];
					$supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
					$company_id = $row_get['company_id'];
					$company_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");

					$bill_date =$obj->dateformatindia($row_get['bill_date']);
					$bill_type =$row_get['bill_type'];
					$net_amount =$row_get['net_amount'];
                    $bal_qty = $qty - $ret_qty;
					?> 
					<tr>
						<td><?php echo $slno++; ?></td>
						<td><?php echo $company_name; ?></td>
						<td><?php echo $billno; ?></td>
						<td><?php echo $supplier_name; ?></td> 
						<td><?php echo $bill_type; ?></td>
						<td><?php echo $qty; ?></td>
						<td><?php echo $ret_qty; ?></td>
						<td><?php echo $bal_qty; ?></td>
						<td><?php echo $bill_date; ?></td>
						
						
						 <?php if ($bill_type == 'invoice')
						{  ?> 
						<td><center><a class="btn btn-danger" href="pdf_purchase_return.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Invoice A4 </a></center></td>
						<?php }else{ ?>
						<td><center><a class="btn btn-danger" href="pdf_purchase_return.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Invoice A4</a></center></td>
						<?php    } ?>
                    </tr>
                            <?php
                           // $totalamt += $net_amount;
                            }//looop close

                            ?>
                            </tbody>
                            </table>
                          <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalamt,2); ?></h3></div>
                            </div>  -->
                     </div><!--contentinner-->
      			 	 </div><!--maincontent-->
    				</div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    
    <!--footer-->

</div><!--mainwrapper-->
<div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>


    <?php //include("modal_voucher_entry.php"); ?>
 
<script>
jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();
</script>
</body>
</html>
