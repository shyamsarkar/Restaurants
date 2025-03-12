<?php include("../adminsession.php");
$pagename ="cash_inout_report.php";   
$module = "Cash In Out Report";
$submodule = "Cash In Out Report List";
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

//$crit = " where 1 = 1 and inout_date between '$fromdate' and '$todate'"; 


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
                    
                     <td>&nbsp; <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('fromdate,todate');"> Search 
                    </button></td>
                    <td>&nbsp; <a href="cash_inout_report.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
                    
                    </tr>
                    </table>
                    </form>
                    </div>
                   
                <!--widgetcontent-->

                <?php $chkview = $obj->check_pageview("category_wise_sale_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                     
                     <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_cash_inout_report.php?fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>       
              
                
                <!--widgetcontent-->
                 
                <h2 class="widgettitle" style="text-align: center;">Cash In</h2>
                
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
                            <th  class="head0">Category Name</th>
                            <th style="text-align:right;" class="head0">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                        $slno=1;
                        $tot_amount=0;
                      
                        $res = $obj->executequery("Select * from m_expanse_group");
                        foreach($res as $row_get)
                        {
                            $ex_group_id = $row_get['ex_group_id'];
                            $amount = $obj->getvalfield("cash_in_out","sum(amount)","ex_group_id='$ex_group_id' and type = 'cash_in' and inout_date between '$fromdate' and '$todate'");

                        ?> 
                        <tr> 
                          <td style="text-align:center;"><?php echo $slno++; ?></td> 
                          <td><?php echo $row_get['group_name']; ?></td> 
                          <td style="text-align:right;"><?php echo number_format($amount,2); ?></td>
                         
                        </tr>
                        <?php
                        $tot_amount += $amount;
						}
						?>

                    </tbody>

                    <tr> 
                          <td colspan="2" style="text-align:right;">Total Amount In:</td> 
                          <td style="text-align:right;"><?php echo number_format($tot_amount,2); ?></td>
                    </tr>

                </table>
                <br>

                 <h2 class="widgettitle" style="text-align: center;">Cash Out</h2>
                
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
                            <th  class="head0">Category Name</th>
                            <th style="text-align:right;" class="head0">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                        $slno=1;
                        $tot_amount=0;
                      
                        $res = $obj->executequery("Select * from m_expanse_group");
                        foreach($res as $row_get)
                        {
                            $ex_group_id = $row_get['ex_group_id'];
                            $amount = $obj->getvalfield("cash_in_out","sum(amount)","ex_group_id='$ex_group_id' and type = 'cash_out' and inout_date between '$fromdate' and '$todate'");

                        ?> 
                        <tr> 
                          <td style="text-align:center;"><?php echo $slno++; ?></td> 
                          <td><?php echo $row_get['group_name']; ?></td> 
                          <td style="text-align:right;"><?php echo number_format($amount,2); ?></td>
                         
                        </tr>
                        <?php
                        $tot_amount += $amount;
                        }
                        ?>

                    </tbody>

                    <tr> 
                          <td colspan="2" style="text-align:right;">Total Amount Out:</td> 
                          <td style="text-align:right;"><?php echo number_format($tot_amount,2); ?></td>
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
<script type="text/javascript">
  jQuery('#fromdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#fromdate').focus();
</script>
</body>
</html>
