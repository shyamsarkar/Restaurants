<?php include("../adminsession.php");
$pagename ="bill_report_list.php";   
$module = "Bill Wise Sale Report";
$submodule = "Bill Wise Sale Report List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
$paydate = $obj->getvalfield("day_close","day_date","1=1");

if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $_GET['action'];
else
$action = 0;
$search_sql = "";

if(isset($_GET['fromdate']) && isset($_GET['todate']))
{ 
  $fromdate = $obj->dateformatusa($_GET['fromdate']);
  $todate  =  $obj->dateformatusa($_GET['todate']);
}
else
{
  $todate =date('Y-m-d');
  $fromdate =date('Y-m-d');
  
}

$crit = " where 1 = 1 and billdate between '$fromdate' and '$todate'"; 

if(isset($_GET['table_id']))
{
  $table_id = $_GET['table_id'];
  if($table_id!='')
  {
     $crit .= "and table_id='$table_id'";
  }
}
else
{
  $table_id = ""; 
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>

<script type="text/javascript">
    
function show_payment_modal(billnumber,table_no,credit_amt1,billid)
{
  
  jQuery('#payment_bill_number').html(billnumber);
  jQuery('#payment_table_no').html(table_no);
  jQuery('#credit_amt').val(credit_amt1);
  jQuery('#billid').val(billid);
  jQuery('#balance').val(credit_amt1);
  jQuery('#payment_modal').modal('show');
  jQuery('#loaderimg').css("display", "none");
  
}


function funDel(id)
  {  //alert(id);   
  

    tblname = '<?php echo $tblname; ?>';
    tblpkey = '<?php echo $tblpkey; ?>';
    pagename = '<?php echo $pagename; ?>';
    submodule = '<?php echo $submodule; ?>';
    module = '<?php echo $module; ?>';
    fromdate = '<?php echo $obj->dateformatindia($fromdate); ?>';
    todate = '<?php echo $obj->dateformatindia($todate); ?>';
    // alert(fromdate); 
    if(confirm("Are you sure! You want to delete this record."))
    {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax/delete_salemsg.php',
        data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
        dataType: 'html',
        success: function(data){
          //alert(data);
          if(data > 0)
          {
            alert("Msg Send successfully")
            
          }
          else
          {
            alert("Not Send")
          }
          //alert(pagename+'?action=3&fromdate='+fromdate+'&todate='+todate);
          location=pagename+'?action=3&fromdate='+fromdate+'&todate='+todate;
        }
        
        });//ajax close
    }//confirm close
  } //fun close

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
        	<div class="contentinner">
              <?php include("../include/alerts.php"); ?>
            	<!--widgetcontent-->        
                <div class="widgetcontent  shadowed nopadding">
                    <form class="stdform stdform2" method="get" action="">
                    <table id="mytable01" align="center" class="table table-bordered table-condensed"  >
                    <tr>
                      <th>Table No.</th>
                       <th>From Date<span class="text-error">*</span></th>
                        <th>To Date<span class="text-error">*</span></th>
                        
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                     
                      <td>
                        <select name="table_id" id="table_id" class="chzn-select">
                          <option value="">--All--</option>
                          <?php
                          $slno=1;
                          $res = $obj->executequery("select * from m_table");

                          foreach($res as $row_get)

                          {               
                            ?>
                            <option value="<?php echo $row_get['table_id'];  ?>"> <?php echo $row_get['table_no']; ?></option>
                          <?php } ?>
                        </select>
                        <script>document.getElementById('table_id').value='<?php echo $table_id; ?>';</script>                   
                      </td>
                    
                     <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                    
                     <td><input type="text" name="todate" id="todate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                    
                     <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="bill_report_list.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    </form>
                    </div>
                   
                <!--widgetcontent-->

                <?php $chkview = $obj->check_pageview("bill_report_list.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                     
                    <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_bill_report.php?table_id=<?php echo $table_id; ?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" class="btn btn-info" target="_blank">
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
                            <th  class="head0">Bill Info</th>
                            <th  class="head0">Table Info</th>
                            <th  class="head0">Paid Amt details</th>
                            <th  class="head0">CreditAmt</th>
                            <th  class="head0">Settlement</th>
                            <th  class="head0">Print Bill</th>
                            <th  class="head0">Cancel Bill</th>
                             <?php  $chkdel = $obj->check_delBtn("bill_report_list.php",$loginid);             
                            if($chkdel == 1 || $loginid == 1){  ?>
                            <th class="head0" >Delete</th>  <?php } ?>                         
                        </tr>
                    </thead>
                    <tbody id="record">
                    
                        <?php
                        $slno=1;
                        $tot_disc_rs=0;
                        $tot_settlement_amt=0;
                        $subtotal=0;
                        $tot_rec_amt = 0;
                        $total_cancelled_amt = 0;
                        $net_balance = 0;
                        $res = $obj->executequery("Select * from bills $crit and checked_nc=0 order by billid desc");
                        foreach($res as $row_get)
                        {

                        $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
                        $settlement_amt = $row_get['settlement_amt'];
                        $disc_rs = $row_get['disc_rs'];
                        $disc_percent = $row_get['disc_percent'];
                        $cust_name = $row_get['cust_name'];
                        $cust_mobile = $row_get['cust_mobile'];
                        $remarks = $row_get['remarks'];
                        $credit_amt1 = $row_get['credit_amt'];
                        $billid = $row_get['billid'];

                        $waiter_id_cap = $obj->getvalfield("cap_stw_table","waiter_id_cap","billid='$billid' and close_order=1 or close_order=0");
                        $waiter_id_stw = $obj->getvalfield("cap_stw_table","waiter_id_stw","billid='$billid' and close_order=1 or close_order=0");
                        $captain_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap'");
                        $steward_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw'");

                        if($row_get['is_paid'] == 1)
                        {
                          $billstatus = "<span style='color: green';>PAID</span>";
                        }
                        else
                        {
                          $billstatus = "<span style='color: red';>PENDING</span>";
                        }

                        ?> <tr> 
                        <td style="text-align:center;"><?php echo $slno++; ?></td> 
                        <td>
                         <a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $row_get['billnumber']; ?></a><br>
                          <?php echo "BillDate".$obj->dateformatindia($row_get['billdate']); ?><br>
                          <?php echo "Bill Time".$row_get['billtime']; ?><br>
                          <?php //echo "Payment: ".$billstatus; ?>
                        </td>
                        <td style="text-align:center;">
                          <?php echo "Table: ".strtoupper($table_no); ?><br>
                          <?php echo "BillAmt: ".number_format(round($row_get['net_bill_amt']),2); ?><br>
                          <?php echo strtoupper($row_get['parsal_status']); ?>
                        </td>
                        
                        <td>
                          <?php echo "Cash: ".number_format($row_get['cash_amt'],2); ?><br>
                          <?php echo "Card: ".number_format($row_get['card_amt'],2); ?><br>
                          <?php echo "Paytm: ".number_format($row_get['paytm_amt'],2); ?><br>
                          <?php echo "G-Pay: ".number_format($row_get['google_pay'],2); ?><br>
                          <?php echo "Zomato: ".number_format($row_get['zomato'],2); ?><br>
                          <?php echo "Swiggy: ".number_format($row_get['swiggy'],2); ?><br>
                          <?php echo "Counter Parcel: ".number_format($row_get['counter_parcel'],2); ?><br>
                          <?php echo "Settlement: ".number_format($row_get['settlement_amt'],2); ?>
                          
                        </td>
                        <td>
                          <?php echo number_format($row_get['credit_amt'],2); ?><br>
                          <?php echo "Customer: ".strtoupper($cust_name); ?><br>
                          <?php echo "Mobile: ".$cust_mobile; ?><br>
                          <?php echo "Captain: ".strtoupper($captain_name); ?><br>
                          <?php echo "Steward: ".strtoupper($steward_name); ?><br>
                          <?php echo "Remark: ".$remarks; ?>
                        </td>

                        <td><?php if($row_get['credit_amt']>0){ ?><input type="button" name="is_completed" id="is_completed" value="Pay Amt" onClick="show_payment_modal('<?php echo $row_get['billnumber']; ?>','<?php echo $table_no; ?>','<?php  echo $credit_amt1; ?>','<?php echo $billid; ?>');" class="btn btn-success" ><?php } ?></td> 
                        
                        <td style="text-align:center;"><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" class="btn btn-primary btn-xm" target="_blank" >Print</a></td>

                           
                        <td style="text-align:center;">
                        <?php
                        if($row_get['is_cancelled']==0 && $row_get['is_paid']==0)
                        {
                        ?>
                        <a class='btn btn-danger' onclick='cancel_bill(<?php echo  $row_get['billid']; ?>,<?php echo  $row_get['is_paid']; ?>);' style='cursor:pointer'>Cancel Bill</a>
                        <?php
                        }
                        

                        if($row_get['is_cancelled']==1)
                        echo "<code>Cancelled</code>";
                        

                        ?>
                                 </td>
                                <?php  $chkdel = $obj->check_delBtn("bill_report_list.php",$loginid);             
                                if($chkdel == 1 || $loginid == 1){  ?>
                                 <td style="text-align:center;"><a class='icon-remove' title="delete" onclick='funDel(<?php echo  $row_get['billid']; ?>);' style='cursor:pointer'></a></td>
												         <?php } ?>
                        					</tr>
                        <?php
                        $tot_settlement_amt += $settlement_amt;
                        $tot_disc_rs += $disc_rs;
            						$subtotal += $row_get['net_bill_amt'];
                        //$tot_rec_amt += $row_get['rec_amt'];
            						$tot_rec_amt += $row_get['cash_amt'] + $row_get['card_amt'] + $row_get['paytm_amt'] + $row_get['google_pay'] + $row_get['zomato'] + $row_get['swiggy'] + $row_get['counter_parcel'];
            						
            						if($row_get['is_cancelled'])
            						$total_cancelled_amt += $row_get['net_bill_amt'];
            						
            						$net_balance = $subtotal - $total_cancelled_amt - $tot_rec_amt - $tot_settlement_amt;
						}
						?>
                    </tbody>
                </table>
                <br>
                <table class="table tab-content" style="font-size:16px;" >
                	<tr>
                        <td style="text-align:right;width:85%">Total Sale Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($subtotal,2); ?></td>
                        
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Total Settelment Amt :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_settlement_amt,2); ?></td>
                        
                    </tr>
                     
                    <tr>
                        <td style="text-align:right;width:85%">Cancelled Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($total_cancelled_amt,2); ?></td>
                        
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Total Rec Amt :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_rec_amt,2); ?></td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Balance Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($net_balance,2); ?></td>
                        
                    </tr>	
                </table>
              <?php  } ?>
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
                              <td>Payment Date</td>
                              <td><input type="text" name="paydate" id="paydate" value="<?php echo $obj->dateformatindia($paydate); ?>"></td>
                            </tr>
                              <tr>
                                 <input type="hidden" name="billid" id="billid">
                                  <td style="width:40%">Invoice Number </td>
                                    <td id="payment_bill_number" style="font-weight:bold" value="<?php echo $billid; ?>"></td>
                                </tr>
                                <tr>
                                  <td>Table Number</td>
                                    <td id="payment_table_no" style="font-weight:bold"></td>
                                </tr>
                                
                                <tr>
                                  <td>Credit Amount</td>
                                    <td><input type="text" name="credit_amt" id="credit_amt" readonly="">
                                    <!-- <td id="payment_amt" style="font-weight:bold"> --></td>
                                </tr>
                                 <tr>
                                  <td>Google Pay.</td>
                                  <td><input type="text" name="google_pay" id="google_pay"style="font-weight:bold" onkeyup="settotal();">
                                    </td>
                                </tr>
                                <tr>
                                  <td>Cash</td>
                                  <td><input type="text" name="cash_amt" id="cash_amt" onkeyup="settotal();">
                                    </td>
                                </tr>
                                <tr>
                                  <td>Paytm</td>
                                  <td><input type="text" name="paytm_amt" id="paytm_amt" onkeyup="settotal();">
                                    </td>
                                </tr>
                                <tr>
                                  <td>Card</td>
                                  <td><input type="text" name="card_amt" id="card_amt" onkeyup="settotal();">
                                    </td>
                                </tr>
                                <tr>
                                  <td>Balance Amount</td>
                                  <td><input type="text" name="balance" id="balance">
                                    </td>
                                </tr>

                               
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
                           <!-- <img src="../img/loaders/loader6.gif" alt="" id="loaderimg" class="pull-right"/> -->
                           <input type="button" class="btn btn-primary" value="Recive Payment" onClick="rec_credit_pay();">
                           <button type="button" class="btn btn-danger" data-dismiss="modal" id="disacrdpayment" ><i class="fa fa-times"></i> Discard</button>
                           
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>

<script>

function rec_credit_pay()
{
  //alert(google_pay);
  var billid = document.getElementById('billid').value;
  var google_pay = document.getElementById('google_pay').value;
  var cash_amt = document.getElementById('cash_amt').value;
  var paytm_amt = document.getElementById('paytm_amt').value;
  var card_amt = document.getElementById('card_amt').value;
  var paydate = document.getElementById('paydate').value;
  var credit_amt = document.getElementById('credit_amt').value;
  var balance = document.getElementById('balance').value;
  //alert(credit_amt);

  jQuery.ajax({
        type: 'POST',
        url: 'save_rec_credit_pay.php',
        data: 'billid='+billid+'&google_pay='+google_pay+'&cash_amt='+cash_amt+'&paytm_amt='+paytm_amt+'&card_amt='+card_amt+'&paydate='+paydate+'&credit_amt='+credit_amt+'&credit_amt='+balance,
        dataType: 'html',
        success: function(data){
        //alert(data);
         jQuery("#google_pay").val("");
         jQuery("#cash_amt").val("");
         jQuery("#paytm_amt").val("");
         jQuery("#card_amt").val("");

         if(data == 1)
         {
          alert("successfully Saved");
         }
         location='bill_report_list.php';
        
          
       }
        
    });//ajax close
}  

function settotal()
{
  var credit_amt=parseFloat(jQuery('#credit_amt').val());
  var google_pay=parseFloat(jQuery('#google_pay').val());
  var cash_amt=parseFloat(jQuery('#cash_amt').val()); 
  var credit_amt=parseFloat(jQuery('#credit_amt').val());
  var card_amt=parseFloat(jQuery('#card_amt').val()); 
  var paytm=parseFloat(jQuery('#paytm_amt').val()); 

  if(!isNaN(credit_amt) && !isNaN(google_pay))
  {
    total = credit_amt - google_pay;
  }
  else
    total = credit_amt;

  if(!isNaN(cash_amt))
  {
    total1 = total - cash_amt;
  }
  else
  total1 = total;

  if(!isNaN(paytm))
  {
    total2 = total1 - paytm;
  }
  else
  total2 = total1;

  if(!isNaN(card_amt))
  {
    total3 = total2 - card_amt;
  }
  else
  total3 = total2;
  jQuery('#balance').val(total3.toFixed(2));
}
// function rec_payment(billid)
// {

//   alert(billid);

  // var result = 'true';
  // net_bill_amt = jQuery('#net_bill_amt').val();

  // cust_name = jQuery('#cust_name').val();
  // cash_amt = jQuery('#cash_amt').val();
  // credit_amt = jQuery('#credit_amt').val();
  // paytm_amt = jQuery('#paytm_amt').val();
  // card_amt = jQuery('#card_amt').val();
  // google_pay = jQuery('#google_pay').val();
  // settlement_amt = jQuery('#settlement_amt').val();
  // remarks = jQuery('#remarks').val();
  //table_id = <?php// echo $table_id; ?>;
  // billid = <?php //echo $billid; ?>;
  // billid = jQuery('#billid').val();
  // paydate = jQuery('#paydate').val();
  //alert(paydate);

  // if(credit_amt=="")
  //   {
  //        jQuery('#credit_amt_error').html("Please Enter Credit Amount.");
  //        //return false;
  //   }
  //   else
  //   {
  //       jQuery('#credit_amt_error').html("");
  //        //return false;
  //   }
    
  // if (credit_amt!="") 
  // {
  //     // jQuery('#loaderimg').css("display", "block");
  //     jQuery('#savepayment').css("display", "blobk");
  //     jQuery('#disacrdpayment').css("display", "blobk");
      
  //     jQuery.ajax({
  //       type: 'POST',
  //       url: 'save_order_payment.php',
  //       data: 'cash_amt=' + cash_amt + '&paytm_amt=' + paytm_amt + '&card_amt=' + card_amt + '&google_pay=' + google_pay + '&settlement_amt=' + settlement_amt + '&remarks='+remarks + '&table_id='+table_id+'&billid='+billid+'&paydate='+paydate+'&credit_amt='+credit_amt+'&cust_name='+cust_name,
  //       dataType: 'html',
  //       success: function(data){
  //       //alert(data);
  //        jQuery("#cash_amt").val("");
  //        jQuery("#paytm_amt").val("");
  //        jQuery("#card_amt").val("");
  //        jQuery("#google_pay").val("");
  //        jQuery("#settlement_amt").val("");
  //        jQuery("#credit_amt").val("");     
  //         if(data > 0)
  //         {
  //           location='in_entry.php?table_id='+table_id+'&floor_id='+floor_id;
  //         }
  //         else{
  //           // alert("Error");
  //       }
          
  //      }
        
  //   });//ajax close
      
  //}//if close
  
jQuery('#fromdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#fromdate').focus();
	
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

function hide_text_pay_options(credit)
{
    if (credit=="credit") {
        jQuery(".hidden-tr").show();
        jQuery("#cust_name").val("");
       
    }else{
        jQuery(".hidden-tr").hide();
    }
}


// function hide_text_pay_options(paymode)
// {
	
// 	if(paymode == '')
// 	{
// 		jQuery('#td_tran_no').hide();
// 		jQuery('#td_bank_name').hide();
// 	}
// 	if(paymode == 'cash')
// 	{
// 		jQuery('#td_tran_no').hide();
// 		jQuery('#td_bank_name').hide();
// 	}
	
// 	if(paymode == 'checque' || paymode == 'card')
// 	{
// 		jQuery('#td_tran_no').show();
// 		jQuery('#td_bank_name').show();
// 	}
	
// 	if(paymode == 'paytm')
// 	{
// 		jQuery('#td_tran_no').show();
// 		jQuery('#td_bank_name').hide();
// 	}
// }


// function rec_payment1()
// {
// 	paymode = '';
// 	tran_no = jQuery('#tran_no').val();
// 	bank_name = jQuery('#bank_name').val();
// 	remarks = jQuery('#remarks').val();
// 	table_id = jQuery('#m_table_id').val();
// 	billid = jQuery('#m_billid').val();
// 	paytm_amt = jQuery('#paytm_amt').val();
//     paytm_trans_no = jQuery('#paytm_trans_no').val();
//     card_amt = jQuery('#card_amt').val();
//     card_trans_number = jQuery('#card_trans_number').val();
//     cash_amt = jQuery('#cash_amt').val();
//     rec_amt = jQuery('#rec_amt').val();
//     jQuery("#getpaid").attr("disabled", true);
    
//     //alert(rec_amt);
	
	
// 	if(cash_amt =="" && paytm_amt =="" && card_amt =="")
// 	{
// 		alert("Enter Amount Atleast One Field");
// 		return false;
// 	}
// 		jQuery.ajax({
// 		  type: 'POST',
// 		  url: 'save_order_payment.php',
// 		  data: 'paymode=' + paymode +'&tran_no=' + tran_no + '&bank_name=' + bank_name + '&remarks=' + remarks + '&table_id=' + table_id + '&billid=' + billid + '&paytm_amt=' + paytm_amt + '&paytm_trans_no=' + paytm_trans_no + '&card_amt=' + card_amt + '&card_trans_number=' + card_trans_number + '&cash_amt=' + cash_amt + '&rec_amt=' + rec_amt,
// 		  dataType: 'html',
// 		  success: function(data){
// 			  //alert(data);
// 			  if(data > 0)
// 			  {
// 					location='in-entry.php?table_id='+table_id;
// 			  }
// 			  else{
// 				  alert("Error");
// 				  jQuery("#getpaid").attr("disabled", false);
// 			}
			  
// 		 }
// 	});//ajax close
			
// }

hide_text_pay_options('');

function rec_payment()
{

  
    // var result = 'true';
   
    net_bill_amt = jQuery('#payment_amt').val();
    paymode = jQuery('#paymode').val();
    //alert(paymode);
    cust_name = jQuery('#cust_name').val();
    rec_amt = jQuery('#rec_amt').val();
    settlement_amt = jQuery('#settlement_amt').val();
    card_amt = jQuery('#card_amt').val();
    remarks = jQuery('#remarks').val();
    table_id = jQuery('#table_id').val();
    floor_id = jQuery('#floor_id').val();
    billid = jQuery('#billid').val();
    paydate = jQuery('#paydate').val();
   //alert();

  
    
  if (rec_amt!="" && cust_name!="") 
  {
      jQuery('#loaderimg').css("display", "block");
      jQuery('#savepayment').css("display", "none");
      jQuery('#disacrdpayment').css("display", "none");
      
      jQuery.ajax({
        type: 'POST',
        url: 'save_order_payment.php',
        data: 'paymode=' + paymode + '&cust_name=' + cust_name + '&rec_amt=' + rec_amt + '&settlement_amt=' + settlement_amt + '&card_amt=' + card_amt + '&remarks='+remarks + '&table_id='+table_id+'&billid='+billid+'&paydate='+paydate,
        dataType: 'html',
        success: function(data){
        //alert(data);
          if(data > 0)
          {
            location='in_entry.php?table_id='+table_id+'&floor_id='+floor_id;
          }
          else{
            alert("Error");
        }
          
       }
        
    });//ajax close
  }//if close
  else{
        jQuery('#rec_amt_error').html("Invalid Receve Amount.");
    }//else close
}

function cancel_bill(billid,is_paid)
{
	//alert(billid);
    //alert(is_paid);
	if(is_paid == 0)
	{
		var is_cancelled = confirm("Do you want to cancell this bill?");
		if(is_cancelled)
		{
			if(billid!="")
			{
				var cancel_remark = prompt("Enter Reson to cancell...");
				jQuery.ajax({
					  type: 'POST',
					  url: 'ajax_cancell_bill.php',
					  data: "billid=" + billid + '&cancel_remark=' +cancel_remark,
					  dataType: 'html',
					  success: function(data){
						  //alert(data);
						  if(data > 0)
						  {
								location='bill_report_list.php';
						  }
						  else{
							  alert("Error");
						}
						  
					 }
						
				});//ajax close
			}
		}
	}//outer if
	else
	alert('Order can not be cancelled after payment.');
}


function cal_rec_amt()
{
	rec_amt = 0;
	cash_amt = jQuery('#cash_amt').val();
	paytm_amt = jQuery('#paytm_amt').val();
	card_amt = jQuery('#card_amt').val();
	payment_amt = jQuery('#payment_amt').html();
	//alert(card_amt);

	if(cash_amt!='')
	{
		rec_amt += parseFloat(cash_amt);
	}
	if(paytm_amt!='')
	{
		rec_amt += parseFloat(paytm_amt);
	}
	if(card_amt!='')
	{
		rec_amt += parseFloat(card_amt);
	}

	if(rec_amt > parseFloat(payment_amt))
	{
		jQuery('#error_rec').html('Received amt can not more than bill amount');
		jQuery("#getpaid").attr("disabled", true);
	}
	else
	{
		jQuery('#error_rec').html('');
		jQuery("#getpaid").attr("disabled", false);
	}

	jQuery('#rec_amt').val(rec_amt);
	
}

</script>

</body>

</html>
