<?php include("../adminsession.php");
$pagename ="gst_report.php";   
$module = "GST REPORT";
$submodule = "GST REPORT";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $_GET['action'];
else
$action = "";
$search_sql = "";
$crit = " where 1 = 1 ";


if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
}

$crit .= " and billdate between '$from_date' and '$to_date'";

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
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
        	<div class="contentinner">
              <?php include("../include/alerts.php"); ?>
            	<!--widgetcontent-->        
                <div class="widgetcontent  shadowed nopadding">
                    <form class="stdform stdform2" method="get" action="">
                    
                    <table id="mytable01" align="center" class="table table-bordered table-condensed"  >
                    <tr>
                       <th>From Date<span class="text-error">*</span></th>
                        <th>To Date<span class="text-error">*</span></th>
                        <!-- <th>Pay Mode</th> -->
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                     <td><input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                    
                    <td><input type="text" name="to_date" id="to_date" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                    
                    
                    
                    <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate,to_date');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="gst_report.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    
                    
                        </form>
                    </div>
                   
                <!--widgetcontent-->

                <?php $chkview = $obj->check_pageview("gst_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                     
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_gst_report.php?from_date=<?php echo $obj->dateformatindia($from_date);?>&to_date=<?php echo $obj->dateformatindia($to_date);?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>        
              
                
                <!--widgetcontent-->
                <h4 class="widgettitle"><?php echo $submodule; ?></h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <colgroup>
                        <col class="con0" style="align: center; width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                        	
                          	<th  width="7%" class="head0 nosort">S.No.</th>
                            <th  class="head0" >Bill_No</th>
                            <th  class="head0" >Bill_Date</th>
                            <th  class="head0" >Bill_Time</th>
                            <th  class="head0" >Customer</th>
                            <th  class="head0" >Mobile</th>
                            <th  class="head0" >Gross Amount</th>
                            <th  class="head0" >Disc(IN %)</th>
                            <th  class="head0" >Disc(Rs.)</th>
                            <th  class="head0" >GST(%)</th>
                            <th  class="head0" >CGST_Amt</th>
                            <th  class="head0" >SGST_Amt</th>
                            <th  class="head0" >Net_Bill_Amount</th>
                           
                        </tr>
                    </thead>
                    <tbody id="record">
                                <?php
									$slno=1;
									$subtotal=0;
									$tot_cgst_amt = 0;
                                    $tot_sgst_amt = 0;
                                    $tot_disc_rs = 0;
                                    $tot_disc_percent_amt = 0;
                                    $tot_basic_bill_amt = 0;
                                      $sql = "Select * from bills $crit and checked_nc='0' order by billid desc";
                                        $res = $obj->executequery($sql);
                                        foreach($res as $row_get)
                                        {
                                            $sgst = $row_get['sgst'];
                                            $cgst = $row_get['cgst'];
                                            $disc_percent = $row_get['disc_percent'];
                                            $disc_rs = $row_get['disc_rs'];
                                            $basic_bill_amt = $row_get['basic_bill_amt'];
                                            $disc_percent_amt = $basic_bill_amt*$disc_percent/100;
                                            $disc_rs_amt = $basic_bill_amt-$disc_rs;
                                            $cgst_amt = $basic_bill_amt*$cgst/100;
                                            $sgst_amt = $basic_bill_amt*$sgst/100;
                                            $gst = $sgst + $cgst;
                                            $cust_name = $row_get['cust_name'];
                                            $customer_name = $obj->getvalfield("m_customer","customer_name","customer_id='$cust_name'");
                                            $mobile = $obj->getvalfield("m_customer","mobile","customer_id='$cust_name'");
                                            $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
                                            // $is_cancelled = $row_get['is_cancelled'];
                                            // if($is_cancelled==1)
                                            // $status_cancelled = "<span style='color:red;'>Cancelled</span>";
                                            // else
                                            // $status_cancelled = '';
										
									   ?> 
                                       <tr>
                                                <td style="text-align:center;"><?php echo $slno++; ?></td> 
                                                <td> <a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $row_get['billnumber']; ?></a></td>
                                                <td style="text-align:center;"><?php echo $obj->dateformatindia($row_get['billdate']); ?></td>
                                                <td style="text-align:center;"><?php echo $row_get['billtime']; ?></td>
                                                
                                                  <td style="text-align:center;"><?php echo strtoupper($customer_name); ?></td>
                                                <td style="text-align:center;"><?php echo $mobile; ?></td>
                                               <td style="text-align:right;"><?php echo number_format(round($row_get['basic_bill_amt']),2); ?></td>

                                               <td style="text-align:right;"><?php echo "( ".$row_get['disc_percent']." %) ".number_format(round($disc_percent_amt),2); ?></td>
                                               
                                                <td style="text-align:right;"><?php echo number_format(round($row_get['disc_rs']),2); ?></td>
                                                <td style="text-align:right;"><?php echo $gst." %"; ?></td>

                                                <td style="text-align:right;"><?php echo number_format(round($cgst_amt),2); ?></td>
                                                <td style="text-align:right;"><?php echo number_format(round($sgst_amt),2); ?></td>
                                                <td style="text-align:right;"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                                                
                        					</tr>

								<?php
                                $subtotal += $row_get['net_bill_amt'];
                                $tot_cgst_amt += $cgst_amt;
                                $tot_sgst_amt += $sgst_amt;
                                $tot_disc_rs += $row_get['disc_rs'];
                                $tot_disc_percent_amt += $disc_percent_amt;
                                $tot_basic_bill_amt += $row_get['basic_bill_amt'];
                               
                                }
						?>
                    </tbody>
                </table>
                
                 <br>
                <table class="table tab-content" style="font-size:16px;" >
                	<tr>
                        <td style="text-align:right;width:85%">Total Gross Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_basic_bill_amt,2); ?></td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Disc(%) Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_disc_percent_amt,2); ?></td>
                    </tr>	
                    
                    <tr>
                        <td style="text-align:right;width:85%">Disc(Rs) Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_disc_rs,2); ?></td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:right;width:85%">Total CGST :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_cgst_amt,2); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;width:85%">Total SGST :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_sgst_amt,2); ?></td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:right;width:85%">Net Bill Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($subtotal,2); ?></td>
                    </tr> 
                </table>
             <?php } ?>
                
               
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->
<!--Payment modal-->
<div class="modal fade" id="payment_modal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>Payment Entry</h4>
                    </div>
                        <div class="modal-body">
                        	<table class="table table-bordered">
                            	<tr>
                                	<td style="width:40%">Bill Number</td>
                                    <td id="payment_bill_number" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Table Number</td>
                                    <td id="payment_table_no" style="font-weight:bold"></td>
                                </tr>
                                <tr>
                                	<td>Net Bill Amount</td>
                                    <td id="payment_amt" style="font-weight:bold"></td>
                                </tr>
                                 <tr >
                                	<td>Payment Mode <span style="color:#F00;">*</span></td>
                                    <td>
                                    	<select id="paymode" class="form-control" onChange="hide_text_pay_options(this.value)">
                                        	<option value="">--Select--</option>
                                        	<option value="cash">Cash</option>
                                            <option value="checque">Cheque</option>
                                            <option value="card">Card</option>
                                            <option value="paytm">Paytm</option>
                                        </select>
                                    </td>
                                </tr>
                                 <tr id="td_tran_no">
                                	<td>Checque No./ Trans.No.</td>
                                    <td>
                                    	<input type="text" class="form-control" id="tran_no">
                                    </td>
                                </tr>
                                 <tr id="td_bank_name">
                                	<td>Bank Name</td>
                                    <td>
                                    	<input type="text" class="form-control" id="bank_name">
                                    </td>
                                </tr>
                                 <tr>
                                	<td>Remark</td>
                                    <td>
                                    	<input type="text" class="form-control" id="remarks">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
                           <input type="submit" class="btn btn-primary" name="submit" value="Recive Payment" onClick="return rec_payment1();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   ><i class="fa fa-times"></i> Discard</button>
                           <input type="hidden" id="m_table_id" value="" >
                           <input type="hidden" id="m_billid" value="" >
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>


<script>
	function funDel(id)
	{  //alert(id);   
	

		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';
		fromdate = '<?php echo $cmn->dateformatindia($fromdate); ?>';
		todate = '<?php echo $cmn->dateformatindia($todate); ?>';
		// alert(fromdate); 
		if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_sale.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				  //alert(pagename+'?action=3&fromdate='+fromdate+'&todate='+todate);
				   location=pagename+'?action=3&fromdate='+fromdate+'&todate='+todate;
				}
				
			  });//ajax close
		}//confirm close
	} //fun close

  </script>
<script type="text/javascript">
  'use strict';
  $(document).ready(function () {
    Admire.formGeneral();

  // Date picker
  $('#from_date').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true,
    orientation:"bottom"
  });

  $('#to_date').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true,
    orientation:"bottom"
  });
});
</script>



<script> 

function changestatus(billid,is_completed)
{
var crit="<?php echo $crit; ?>";
	
	//alert(crit);
	if(confirm("Do You want to Update this record ?"))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax_update_order.php',
			  data: "billid="+billid+'&crit='+crit+'&is_completed='+is_completed,
			  dataType: 'html',
			  success: function(data){
				//alert(data);
				 // jQuery('#record').html(data);
					arr = data.split("|");						
					status =arr[0].trim(); 
					count_product = arr[1].trim();
					
					//alert(status);
					
					if(status==1)
					{
						curr_status="Completed";
					}
					else
					{
						curr_status="Pending";
					}
					
					jQuery('#status'+billid).html(curr_status);
				 
				}
				
			  });//ajax close
		}//confirm close
}

function show_payment_modal(net_bill_amt,billnumber,table_no,table_id,bill_id)
{
	//alert('hi');
	net_bill_amt = parseFloat(net_bill_amt);
	net_bill_amt = net_bill_amt.toFixed(2);
	jQuery('#payment_bill_number').html(billnumber);
	jQuery('#payment_table_no').html(table_no);
	jQuery('#payment_amt').html(net_bill_amt);
	jQuery('#payment_total').html(net_bill_amt);
	jQuery('#m_table_id').val(table_id);
	jQuery('#m_billid').val(bill_id);
	
	jQuery('#payment_modal').modal('show');
	
}
function hide_text_pay_options(paymode)
{
	
	if(paymode == '')
	{
		jQuery('#td_tran_no').hide();
		jQuery('#td_bank_name').hide();
	}
	if(paymode == 'cash')
	{
		jQuery('#td_tran_no').hide();
		jQuery('#td_bank_name').hide();
	}
	
	if(paymode == 'checque' || paymode == 'card')
	{
		jQuery('#td_tran_no').show();
		jQuery('#td_bank_name').show();
	}
	
	if(paymode == 'paytm')
	{
		jQuery('#td_tran_no').show();
		jQuery('#td_bank_name').hide();
	}
}


function rec_payment1()
{
	paymode = jQuery('#paymode').val();
	tran_no = jQuery('#tran_no').val();
	bank_name = jQuery('#bank_name').val();
	remarks = jQuery('#remarks').val();
	table_id = jQuery('#m_table_id').val();
	billid = jQuery('#m_billid').val();
	paydate = jQuery('#paydate').val();
	
	if(paymode == "")
	{
		 alert('Please Select Payment Mode');
		 jQuery('#paymode').focus();
		 return false;
	}
	else
	{
		
			if(paymode == "")
	{
		 alert('Please Select Payment Mode');
		 jQuery('#paymode').focus();
		 return false;
	}
	else
	{
		if(paymode=="checque")
		{
			if(tran_no =="" || bank_name == "")
			{
				alert("Bank name or Checque no is mandatory, if paymode is checque.");
				return false;
			}
		}
		if(paymode=="card")
		{
			if(tran_no =="" || bank_name == "")
			{
				alert("Card Name and Transaction No is mandatory, if paymode is Card.");
				return false;
			}
		}
		if(paymode=="paytm")
		{
			if(tran_no =="")
			{
				alert("Transaction No is mandatory, if paymode is Paytm.");
				return false;
			}
		}
		
		
		
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_order_payment.php',
			  data: "paymode=" + paymode + '&tran_no=' + tran_no + '&bank_name=' + bank_name + '&remarks=' + remarks + '&table_id=' + table_id + '&billid=' + billid,
			  dataType: 'html',
			  success: function(data){
				  //alert(data);
				  if(data > 0)
				  {
						location='in-entry.php?table_id='+table_id;
				  }
				  else{
					  alert("Error");
				}
				  
			 }
				
		});//ajax close
			
	}
	
	
}

hide_text_pay_options('');
</script>

</body>

</html>
