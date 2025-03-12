<?php include("../adminsession.php");
$pagename ="payment_report_new.php";   
$module = "Payment Receiving Report";
$submodule = "Payment Report List";
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
                    
                    
                    
                    <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="payment_report_new.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    
                    
                        </form>
                    </div>
                   
                <!--widgetcontent-->

                <?php $chkview = $obj->check_pageview("payment_report_new.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                     
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_payment_entry_master.php?from_date=<?php echo $obj->dateformatindia($from_date);?>&to_date=<?php echo $obj->dateformatindia($to_date);?>" class="btn btn-info" target="_blank">
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
                           <!--  <th  class="head0" >Bill_No</th> -->
                            <th  class="head0" >Bill_No / Bill_Amount</th>
                            <th  class="head0" >Bill_Date / Bill_Time</th>
                            <th  class="head0" >Custname / Mobile</th>
                            <th  class="head0" >Cancelled / Pay_Date</th>
                          <!--   <th  class="head0" >Bill_Date</th>
                            <th  class="head0" >Bill_Time</th> -->
                           <!--  <th  class="head0" >Cancelled</th> -->
                           <!--  <th  class="head0" >Bill_Amount</th> -->
                            <!-- <th  class="head0" >Customer</th>
                            <th  class="head0" >Mobile</th> -->
                            <!-- <th  class="head0" >Pay_Date</th> -->
                            <th  class="head0" >Cash</th>
                            <th  class="head0" >Card</th>
                            <th  class="head0" >Paytm</th>
                            <th  class="head0" >Google_Pay</th>
                            <th  class="head0" >Zomato</th>
                            <th  class="head0" >Swiggy</th>
                            <th  class="head0" >Counter_parcel</th>
                            <th  class="head0" >Settlement</th>
                            <th  class="head0" >Credit</th>
                           
                           
                        </tr>
                    </thead>
                    <tbody id="record">
                                <?php
									$slno=1;
									$subtotal=0;
									$tot_rec_amt = 0;
									$total_cancelled_amt = 0;
                                     $tot_cash_amt = 0;
                                     $tot_credit_amt = 0;
                                     $tot_card_amt = 0;
                                     $tot_pay_amt = 0;
                                     $tot_google_amt = 0;
                                     $tot_settlement_amt = 0;
                                     $net_balance = 0;
                                     $tot_zomato = 0;
                                     $tot_swiggy = 0;
                                     $tot_counter_parcel = 0;
									

                                      $sql = "Select * from bills $crit and checked_nc=0 order by billid desc";
                                        $res = $obj->executequery($sql);
                                        foreach($res as $row_get)
                                        {
                                           $cust_name = $row_get['cust_name'];
                                           $cust_mobile = $row_get['cust_mobile'];
                                           $remarks = $row_get['remarks'];
                                          /* $customer_name = $obj->getvalfield("m_customer","customer_name","customer_id='$cust_name'");
                                           $mobile = $obj->getvalfield("m_customer","mobile","customer_id='$cust_name'");*/
										                       $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
                                           $billid = $row_get['billid'];
                                          $waiter_id_cap = $obj->getvalfield("cap_stw_table","waiter_id_cap","billid='$billid' and close_order=1 or close_order=0");
                                          $waiter_id_stw = $obj->getvalfield("cap_stw_table","waiter_id_stw","billid='$billid' and close_order=1 or close_order=0");
                                          $captain_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap'");
                                          $steward_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw'");
                                        $is_cancelled = $row_get['is_cancelled'];
                                        if($is_cancelled==1)
                                            $status_cancelled = "<span style='color:red;'>Cancelled</span>";
                                        else
                                             $status_cancelled = '';
										
									   ?> 
                                       <tr>
                                                <td style="text-align:center;"><?php echo $slno++; ?></td> 
                                                <td>Bill_No :   <a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $row_get['billnumber']; ?></a><br>
                                                    Bill_Amount : <?php echo $row_get['net_bill_amt']; ?>
                                                </td>
                                                 <td>Bill_Date : <?php echo $obj->dateformatindia($row_get['billdate']); ?><br>
                                                    Bill_Time : <?php echo $row_get['billtime']; ?>
                                                </td>
                                                  <td>Customer Name : <?php echo strtoupper($customer_name); ?><br>
                                                    Mobile : <?php echo $cust_mobile; ?><br>
                                                    Captain : <?php echo strtoupper($captain_name); ?><br>
                                                    Steward : <?php echo strtoupper($steward_name); ?>
                                                </td>
                                                 <td>Cancelled : <?php echo $status_cancelled; ?><br>
                                                    Pay_Date : <?php echo $obj->dateformatindia($row_get['paydate']); ?>
                                                </td>
                                               <!--  <td style="text-align:center;"><?php //echo $obj->dateformatindia($row_get['billdate']); ?></td>
                                                <td style="text-align:center;"><?php //echo $row_get['billtime']; ?></td> -->
                                                 <!-- <td style="text-align:center;"><?php //echo $status_cancelled; ?></td> -->
                                               <!--  <td style="text-align:right;"><?php //echo number_format(round($row_get['net_bill_amt']),2); ?></td> -->
                                               <!--  <td style="text-align:center;"><?php //echo strtoupper($customer_name); ?></td>
                                                <td style="text-align:center;"><?php //echo $mobile; ?></td> -->
                                               <!--  <td style="text-align:center;"><?php //echo $obj->dateformatindia($row_get['paydate']); ?></td> -->
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['cash_amt']); ?></td>
                                               
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['card_amt']); ?></td>
                                                <td style="text-align:center;"><?php echo strtoupper($row_get['paytm_amt']); ?></td>
                                                 <td style="text-align:center;"><?php echo strtoupper($row_get['google_pay']); ?></td>
                                                 <td style="text-align:center;"><?php echo strtoupper($row_get['zomato']); ?></td>
                                                 <td style="text-align:center;"><?php echo strtoupper($row_get['swiggy']); ?></td>
                                                 <td style="text-align:center;"><?php echo strtoupper($row_get['counter_parcel']); ?></td>
                                                 <td style="text-align:center;"><?php echo strtoupper($row_get['settlement_amt']); ?></td>
                                                 <td style="text-align:center;"><?php echo strtoupper($row_get['credit_amt']); ?></td>
                                                
                        					</tr>

								<?php
                                $subtotal += $row_get['net_bill_amt'];
                                $tot_rec_amt += $row_get['rec_amt'];
								
								if($row_get['is_cancelled'])
								$total_cancelled_amt += $row_get['net_bill_amt'];
                                $tot_cash_amt += $row_get['cash_amt'];
                                $tot_credit_amt += $row_get['credit_amt'];
                                $tot_card_amt += $row_get['card_amt'];
                                $tot_pay_amt += $row_get['paytm_amt'];
                                $tot_google_amt += $row_get['google_pay'];
                                $tot_zomato += $row_get['zomato'];
                                $tot_swiggy += $row_get['swiggy'];
                                $tot_counter_parcel += $row_get['counter_parcel'];
                                $tot_settlement_amt += $row_get['settlement_amt'];
                                

                                //$net_balance = $subtotal - $total_cancelled_amt - $tot_rec_amt;
                                $net_balance = $subtotal - $tot_cash_amt - $tot_credit_amt - $tot_card_amt - $tot_pay_amt - $tot_google_amt - $tot_settlement_amt - $total_cancelled_amt - $tot_zomato - $tot_swiggy - $tot_counter_parcel;
                                
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
                        <td style="text-align:right;width:85%">Cancelled Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($total_cancelled_amt,2); ?></td>
                    </tr>	
                    
                    <tr>
                        <td style="text-align:right;width:85%">Total Cash :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_cash_amt,2); ?></td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:right;width:85%">Total Card :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_card_amt,2); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;width:85%">Total Paytm :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_pay_amt,2); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;width:85%">Total Google Pay :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_google_amt,2); ?></td>
                    </tr>
                     <tr>
                        <td style="text-align:right;width:85%">Total Zomato :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_zomato,2); ?></td>
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Total Swiggy :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_swiggy,2); ?></td>
                    </tr>   
                    <tr>
                        <td style="text-align:right;width:85%">Total Counter_parcel :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_counter_parcel,2); ?></td>
                    </tr>   
                    <tr>
                        <td style="text-align:right;width:85%">Total Settlement :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_settlement_amt,2); ?></td>
                    </tr> 
                    <tr>
                        <td style="text-align:right;width:85%">Total Credit :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_credit_amt,2); ?></td>
                    </tr>  
                    <tr>
                        <td style="text-align:right;width:85%">Balance Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($net_balance,2); ?></td>
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

<script> 

jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();

</script>

</body>

</html>
