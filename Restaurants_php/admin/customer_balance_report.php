<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "customer_balance_report.php";
$module = "Customer Balance Report";
$submodule = "Customer Balance Report";
$btn_name = "Save";
$keyvalue =0 ;

$company_id = $_SESSION['company_id'];
$crit = " where 1 = 1 ";

if(isset($_GET['customer_id']))
{
  
  $customer_id = $_GET['customer_id'];
  if(!empty($customer_id))
  $crit .= " and customer_id = '$customer_id'";
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
                <th>Party Name</th>
                <th>&nbsp</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                  <td>
                    <select name="customer_id" id="customer_id" class="chzn-select">
                       <option value="">--All--</option>
                        <?php
                        $slno=1;
                        $res = $obj->executequery("select * from master_customer");
                        foreach($res as $row_get)
                        {               
                        ?>
                        <option value="<?php echo $row_get['customer_id'];  ?>"> <?php echo $row_get['customer_name']; ?></option>
                        <?php } ?>
                    </select>
                <script>document.getElementById('customer_id').value='<?php echo $customer_id; ?>';</script>                   
                    </td>
               
                <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>
                 <td><a href="customer_balance_report.php" class="btn btn-success">Reset</a></td>
              </tr>
            </table>
            <div>
            </form>
               <p align="right" style="margin-top:7px; margin-right:10px;"> 
             <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
             </p>
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="tblData">
                    <thead>
                        <tr>
                            <th  class="head0 nosort">S.No.</th>
                            <th  class="head0">Customer Name</th>
					                  <th style="text-align: right;" class="head0">Total_Bill_Amt</th>
                          	<th style="text-align: right;" class="head0">Total_Paid_Amt</th>
                            <th style="text-align: right;" class="head0">Total_Balance</th>
                           
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                  <?php
                  $slno = 1;
                  $totalbal = 0;
                  $totalbill = 0;
                  $totalpaid = 0;
                  $sql = "select * from master_customer $crit and company_id = '$company_id'";
                  $res = $obj->executequery($sql);
                  foreach($res as $row_get)
          				 {
          					  $customer_name = $row_get['customer_name'];
                      $customer_id = $row_get['customer_id'];
                      $overall_amt = $obj->get_overall_blls_amt($customer_id);
                     
                      $amount_vreceive = $obj->getvalfield("voucherentry","sum(paid_amt)","payment_type = 'Received' and customer_id='$customer_id'");
                     
                      $balance_amt =  $overall_amt - $amount_vreceive ;
                      
					        ?> 
                    <tr>

                         <td><?php echo $slno++; ?></td>
                        <td><?php echo $customer_name; ?></td>
                        <td style="text-align: right;"><?php echo number_format($overall_amt,2); ?></td> 
                        <td style="text-align: right;"><?php echo number_format($amount_vreceive,2); ?></td> 
                        <td style="text-align: right;"><?php echo number_format($balance_amt,2); ?></td>
                            
                    </tr>
                            <?php
                            $totalbal += $balance_amt;
                            $totalbill += $overall_amt;
                            $totalpaid += $amount_vreceive;
                           }
                            ?>
                            </tbody>
                            </table>
                             <div class="well well-sm text"><h3 class="text-info text-right">Total Bill Amt: <?php echo number_format($totalbill,2); ?></h3>
                              <br>
                            <h3 class="text-info text-right">Total Paid Amt: <?php echo number_format($totalpaid,2); ?></h3>
                            <br>
                          <h3 class="text-info text-right">Total Balance: <?php echo number_format($totalbal,2); ?></h3></div>
                             <!-- <div class="well well-sm text"><h3 class="text-info text-right">Total Paid Amt: <?php echo number_format($totalpaid,2); ?></h3></div> 
                             <div class="well well-sm text"><h3 class="text-info text-right">Total Balance: <?php echo number_format($totalbal,2); ?></h3></div> -->
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
<script>

function funDel(id)
{  //alert(id);   
	tblname = '<?php echo $tblname; ?>';
	tblpkey = '<?php echo $tblpkey; ?>';
	pagename = '<?php echo $pagename; ?>';
	submodule = '<?php echo $submodule; ?>';
	module = '<?php echo $module; ?>';
	 //alert(module); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajax/delete_master.php',
		  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			   location='<?php echo $pagename."?action=3" ; ?>';
			}
			
		  });//ajax close
	}//confirm close
} //fun close

jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();
	
 function deleterecord(saledetail_id)
  {
	 	tblname = 'saleentry_details';
		tblpkey = 'saledetail_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+saledetail_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }
function getamt(vendorgrp_id)
{
  var vendorgrp_id = document.getElementById('vendorgrp_id').value;
  jQuery.ajax({
        type: 'POST',
        url: 'ajax_getcustrep.php',
        data: 'vendorgrp_id='+vendorgrp_id,
        dataType: 'html',
        success: function(data){          
           //alert(data);
           jQuery("#customer_id").html(data);
             jQuery("#customer_id").val('').trigger("liszt:updated");
            // //document.getElementById('hcf_id').focus();
             jQuery(".chzn-single").focus();
        }
        });//ajax close
}

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
