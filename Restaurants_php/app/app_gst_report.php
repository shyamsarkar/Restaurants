<?php
include("../adminsession.php");
$pagename = "app_gst_report.php";
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
<html lang="en">
<head>
 <meta charset="UTF-8">
 <title>Indian Chilly</title>
 <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes, viewport-fit=cover user-scalable=no">
 <link rel="stylesheet" href="materialize/css/materialize.min.css">
 <link rel="stylesheet" href="materialize/css/icon.css">
 <link rel="stylesheet" href="materialize/css/animate.min.css"/>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <style>
 .bg{
   background: #141E30;  
   background: -webkit-linear-gradient(to bottom, #243B55, #141E30);  
   background: linear-gradient(to bottom, #243B55, #141E30); 
}
.card .card-content {
  padding: 10px;
  border-radius: 0 0 2px 2px;
}
td{
  padding: 6px 5px;
}
.page-footer {
   padding-top: 0px;
   color: #fff;
   background-color: #18253a;
}
.btn{
   width: 50%;
   border-radius: 50px;
   background: #1c2c42;
}
.select2-container .select2-selection--single {
   box-sizing: border-box;
   cursor: pointer;
   display: block;
   height: 35px;
   user-select: none;
   -webkit-user-select: none;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
  color: #444;
  line-height: 35px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
   height: 26px;
   position: absolute;
   top: 10px;
   right: 1px;
   width: 20px;
}
.select2-container--default .select2-selection--single {
   background-color: #fff;
   border: 1px solid #ddd;
   border-radius: 4px;
   margin-top: 5px;
}
.pointer {cursor: pointer;}
</style>
</head>
<body class="">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
   <div class="container" style="width:100%;"><br>
      <div class="row">
         <form class="col m6 offset-m3 s12">
            <div class="row">

               <div class="input-field col s6">
                  <input type="text" name="from_date" id="from_date" value="<?php echo $obj->dateformatindia($from_date); ?>" class="datepicker">
                  <label>From Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s6">
                  <input type="text" name="to_date" id="to_date" value="<?php echo $obj->dateformatindia($to_date); ?>" class="datepicker">
                  <label>To Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                  <button class="btn waves-effect waves-light" type="submit" name="search" onClick="return checkinputmaster('from_date,to_date'); " value="Search" style="width: 100%;">Search<i class="material-icons right">search</i>
                  </button>
               </div>
               <!-- <div class="input-field col s6">
                  <a class="waves-effect waves-light red btn" href="../admin/pdf_kot_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" style="width: 100%;" target="_blank" class="pointer"><i class="material-icons right">print</i>print</a>

               </div> -->
            </div>
         </form>
      </div>
      
      <div class="row">
         <div class="col m6 offset-m3 s12">
            <blockquote>
               <h6>GST Report</h6>
            </blockquote>

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
             ?>

             <div class="card">
               <div class="card-content">
                  <table class="striped">
                     <tbody>

                        <tr>
                           <td><strong>Serial No.</strong></td>
                           <td class="right-align"><strong><?php echo $slno++; ?></strong></td>
                        </tr>
                        <tr>
                           <td>Bill_No</td>
                           <td class="right-align"><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $row_get['billnumber']; ?></a></td>
                           </tr>
                           <tr>
                              <td>Bill_Date</td>
                              <td class="right-align"><?php echo $obj->dateformatindia($row_get['billdate']); ?></td>
                           </tr>

                           <tr>
                              <td>Bill_Time</td>
                              <td class="right-align"><?php echo $row_get['billtime']; ?></td>
                           </tr>
                           <tr>
                              <td>Customer</td>
                              <td class="right-align"><?php echo strtoupper($customer_name); ?></td>
                           </tr>
                           <tr>
                              <td>Mobile</td>
                              <td class="right-align"><?php echo $mobile; ?></td>
                           </tr>
                           <tr>
                              <td>Gross Amount</td>
                              <td class="right-align"><?php echo number_format(round($row_get['basic_bill_amt']),2); ?></td>
                           </tr>
                           <tr>
                              <td>Disc(IN %)</td>
                              <td class="right-align"><?php echo "( ".$row_get['disc_percent']." %) ".number_format(round($disc_percent_amt),2); ?></td>
                           </tr>
                           <tr>
                              <td>Disc(Rs.)</td>
                              <td class="right-align"><?php echo number_format(round($row_get['disc_rs']),2); ?></td>
                           </tr>
                           <tr>
                              <td>GST(%)</td>
                              <td class="right-align"><?php echo $gst." %"; ?></td>
                           </tr>
                           <tr>
                              <td>CGST_Amt</td>
                              <td class="right-align"><?php echo number_format(round($cgst_amt),2); ?></td>
                           </tr>
                           <tr>
                              <td>SGST_Amt</td>
                              <td class="right-align"><?php echo number_format(round($sgst_amt),2); ?></td>
                           </tr>
                           <tr>
                              <td>Net_Bill_Amount</td>
                              <td class="right-align"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                           </tr>


                        </tbody>
                     </table>
                  </div>
               </div>
               <?php 
                  $subtotal += $row_get['net_bill_amt'];
                  $tot_cgst_amt += $cgst_amt;
                  $tot_sgst_amt += $sgst_amt;
                  $tot_disc_rs += $row_get['disc_rs'];
                  $tot_disc_percent_amt += $disc_percent_amt;
                  $tot_basic_bill_amt += $row_get['basic_bill_amt'];
            }
            ?>

            <footer class="page-footer">
               
                 
                   <div class="footer-copyright">
                  <table>
                     <tr>
                        <th>Total Gross Amount</th><th class="right-align"><?php echo number_format($tot_basic_bill_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Disc(%) Amount</th><th class="right-align"><?php echo number_format($tot_disc_percent_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Disc(Rs) Amount</th><th class="right-align"><?php echo number_format($tot_disc_rs,2); ?></th>
                     </tr>
                     <tr>
                        <th>Total CGST</th><th class="right-align"><?php echo number_format($tot_cgst_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Total SGST</th><th class="right-align"><?php echo number_format($tot_sgst_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Net Bill Amount</th><th class="right-align"><?php echo number_format($subtotal,2); ?></th>
                     </tr>
                  </table>
               </div>

               
            </footer>
         </div>
      </div>
   </div>

   <script src="materialize/js/jquery.min.js"></script>
   <script src="materialize/js/materialize.min.js"></script>
   <script src="materialize/js/app.js"></script>
   <script src="js/commonfun2.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <script type="text/javascript">
      $(document).ready(function() {
         $('.js-example-basic-single').select2();
      });
   </script>
</body>
</html>