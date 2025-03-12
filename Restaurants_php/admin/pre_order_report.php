<?php include("../adminsession.php");

//print_r($_SESSION);die;
$pagename = "pre_order_report.php";
$module = "Pre Order Report";
$submodule = "Pre Order Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "";
$tblpkey = "";

if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

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

$crit .= " and order_date between '$from_date' and '$to_date'"; 


$search_sql = "";


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
              
              <th>From Date:<span style="color:#F00;"> * </span></th>
              <th>To Date:<span style="color:#F00;"> * </span></th>
              <th>&nbsp</th>
            </tr>
            <tr>
              
              <td><input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
               value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

               <td><input type="text" name="to_date" id="to_date" class="input-medium"  placeholder='dd-mm-yyyy'
                 value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>


                 <td><input type="submit" name="search" class="btn btn-success" value="Search" onclick="return checkinputmaster('from_date,to_date');"></td>
                 <td>&nbsp; <a href="pre_order_report.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
               </tr>
             </table>
           <div>      
           </form>
      <!-- for print pdf -->

      <?php $chkview = $obj->check_pageview("pre_order_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
         <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_expanse_report.php?ex_group_id=<?php echo $ex_group_id; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" class="btn btn-info" target="_blank">
          <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>   
         


          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

          <table class="table table-bordered" id="dyntable">
            <thead>
              <tr>
                <th  class="head0 nosort">S.No.</th>
                <th class="head0">Customer Name</th>
                <th class="head0">Mobile</th>
                <th class="head0">Order No</th>
                <th class="head0">Order Date</th>
                <th class="head0">Order Time</th>
                <th class="head0">Delivery Date</th>
                <th class="head0">Delivery Time</th>
                <th class="head0" style="text-align: right;">Amount</th>
              </tr>
            </thead>
            <tbody id="record">
           
            <?php
            $slno=1;
            $totalamt=0;
            //echo "select * from expanse $crit";
            $res = $obj->executequery("select * from pre_order_entry $crit");
            foreach($res as $row_get)
            {

              ?> <tr>
                <td><?php echo $slno++; ?></td>
                <td><?php echo $row_get['cust_name']; ?></td>
                <td><?php echo $row_get['mobile_no']; ?></td>
                <td><?php echo $row_get['order_no']; ?></td>
                <td><?php echo $obj->dateformatindia($row_get['order_date']); ?></td>
                <td><?php echo $row_get['order_time']; ?></td>
                <td><?php echo $obj->dateformatindia($row_get['delivery_date']); ?></td>
                <td><?php echo $row_get['delivery_time']; ?></td>
                <td style="text-align: right;"><?php echo number_format(round($row_get['net_amount']),2); ?></td>
              </tr>
              <?php
              $totalamt += $row_get['net_amount'];
              }//looop close

              ?>
            </tbody>
          </table>
          <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalamt,2); ?></h3></div>
        <?php } ?>
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


<?php //include("modal_voucher_entry.php"); ?>

<script>

 //jQuery(document).ready(function(){

   //jQuery('#menues').click();

 //});
 jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();

</script>
</body>
</html>
