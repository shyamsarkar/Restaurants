<?php include("../adminsession.php");
$pagename ="total_sale_report.php";   
$module = "Category Wise Sale Report";
$submodule = "Category Wise Sale Report List";
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

//$crit = " where 1 = 1 and billdate between '$fromdate' and '$todate'"; 


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
                        
                        <th>&nbsp;</th>
                    </tr>
                    <tr>
                    
                     <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                    
                     <td><input type="text" name="todate" id="todate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                    
                     <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="total_sale_report.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    </form>
                    </div>
                   
                <!--widgetcontent-->

                <?php $chkview = $obj->check_pageview("category_wise_sale_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                     
                     <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_category_wise_sale_report.php?fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>       
              
                
                <!--widgetcontent-->
                 
                <h4 class="widgettitle"><?php echo $submodule; ?></h4>
                
            	<table class="table table-bordered">
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
                            <th  class="head0">Menu Heading Name</th>
                            <th style="text-align:right;" class="head0">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                        $slno=1;
                      
                        $res = $obj->executequery("Select * from m_product_category");
                        foreach($res as $row_get)
                        {
                            $pcatid = $row_get['pcatid'];
                            $amount = $obj->getvalfield("view_bill_details left join bills on view_bill_details.billid = bills.billid","sum(cash_amt+paytm_amt+google_pay+swiggy+paytm_amt+card_amt+credit_amt)","billdate between '$fromdate' and '$todate' and bills.checked_nc=0 and pcatid='$pcatid'");

                       /* $billdate = $row_get['billdate'];
                        $settlement_amt += $row_get['settlement_amt'];
                        $cash_amt += $row_get['cash_amt'];
                        $paytm_amt += $row_get['paytm_amt'];
                        $google_pay += $row_get['google_pay'];
                        $swiggy += $row_get['swiggy'];
                        $paytm_amt += $row_get['paytm_amt'];
                        $card_amt += $row_get['card_amt'];
                        $credit_amt += $row_get['credit_amt'];
                        $total_sale = $settlement_amt + $cash_amt + $paytm_amt + $google_pay + $swiggy + $paytm_amt + $card_amt;
                        $online_pay = $paytm_amt + $google_pay + $swiggy + $paytm_amt;
                        $expense = $obj->getvalfield("expanse","sum(exp_amount)","exp_date='$billdate' group by exp_date");*/
                       

                        ?> 
                        <tr> 
                          <td style="text-align:center;"><?php echo $slno++; ?></td> 
                          <td><?php echo $row_get['catname']; ?></td> 
                          <td style="text-align:right;"><?php echo number_format($amount,2); ?></td>
                         
                        </tr>
                        <?php
                        //$tot_total_sale += $total_sale;
						}
						?>

                    </tbody>

                </table>
                <br>
                 <!-- <table class="table tab-content" style="font-size:16px;" >
                	<tr>
                        <td style="text-align:right;width:85%">Total Sale Amount :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_total_sale,2); ?></td>
                        
                    </tr>	
                     
                    <tr>
                        <td style="text-align:right;width:85%">Total Cash :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_cash_amt,2); ?></td>
                        
                    </tr>	
                    <tr>
                        <td style="text-align:right;width:85%">Total Online :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_online_pay,2); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;width:85%">Total Settelment Amt :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_settlement_amt,2); ?></td>
                        
                    </tr>
                    <tr>
                        <td style="text-align:right;width:85%">Total Credit :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_credit_amt,2); ?></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;width:85%">Total Expence :</td>
                        <td style="text-align:right;"><?php echo number_format($tot_expense,2); ?></td>
                    </tr>	
                    
                </table>  -->
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
<script type="text/javascript">
  jQuery('#fromdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#fromdate').focus();
</script>
</body>
</html>
