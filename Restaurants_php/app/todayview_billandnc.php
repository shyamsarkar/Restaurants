<?php
include("../adminsession.php");
$pagename = "todayview_billandnc.php";
$module = "View Todays Bills And NC";
$submodule = "View Todays Bills And NC";
$keyvalue =0 ;
$day_close = $obj->getvalfield("day_close","day_date","1=1");

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
   td,th{
    padding: 6px 5px;
   }
   .page-footer {
      padding-top: 0px;
      color: #fff;
      background-color: #18253a;
   }
   .btn{
      width: 80%;
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
  </style>
</head>
<body class="white">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
  <div class="container" style="width:100%;">
      <div class="row">
         <div class="col s12 m6 offset-m3">
            <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
               <li class="tab col s6"><a href="#test1" class="active">Today Bill</a></li>
               <li class="tab col s6"><a  href="#test2" >Today NC Bill</a></li>
            </ul>
         </div>
         <div id="test1" class="col m6 offset-m3 s12" style="margin-top:20px;">

          <?php
                  $slno = 1;
                  $cash_amt = 0;
                  $paytm_amt = 0;
                  $card_amt = 0;
                  $net_total = 0;
                  $net_paid = 0;
                  $net_bal = 0;
                  $total_cancelled_amt = 0;
                  $credit_amt = 0;
                  $google_pay = 0;
                  $zomato = 0;
                  $settlement_amt = 0;
                  $swiggy = 0;
                  $counter_parcel = 0;

                   
                     $res = $obj->executequery("Select * from bills where billdate='$day_close' and checked_nc='0' order by billid desc");
                     foreach($res as $row_get)
                     {
                    $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
                    $cust_name = $row_get['cust_name'];
                    $customer_name = $obj->getvalfield("m_customer","customer_name","customer_id='$cust_name'");
                    //check bill balance amt

                    $balance = $row_get['net_bill_amt'] - $row_get['cash_amt'] - $row_get['paytm_amt'] - $row_get['card_amt']- $row_get['settlement_amt'] - $row_get['google_pay'] - $row_get['zomato'] - $row_get['swiggy'] - $row_get['counter_parcel'];

                    $net_paid += ($row_get['cash_amt'] + $row_get['paytm_amt'] + $row_get['card_amt']);
                    $net_total += $row_get['net_bill_amt'];
                    $cash_amt += $row_get['cash_amt'];
                    $paytm_amt += $row_get['paytm_amt'];
                    $card_amt += $row_get['card_amt'];
                    $google_pay += $row_get['google_pay'];
                    $zomato += $row_get['zomato'];
                    $swiggy += $row_get['swiggy'];
                    $counter_parcel += $row_get['counter_parcel'];
                    $settlement_amt += $row_get['settlement_amt'];
                    $credit_amt += $row_get['credit_amt'];
                    $net_bal += $balance;


                     if($balance >0){ $clsname = "alert-danger"; }
                     else
                     { $clsname = "alert-success"; }

                     ?>
           
            <div class="card">
               <div class="card-content">
                  <table class="">
                     <tbody>
                        <tr class="indigo white-text">
                           <td><strong>Serial No.</strong></td>
                           <td class="right-align"><strong><?php echo $slno++; ?></strong></td>
                        </tr>
                        <tr>
                           <td colspan="2" class="center yellow lighten-5"><strong>Bill Info</strong></td>
                        </tr>
                        <tr>
                           <td>Bill No.</td>
                           <td class="right-align"><?php echo $row_get['billnumber']; ?></td>
                        </tr>

                         <tr>
                           <td>Date Time</td>
                           <td class="right-align"><?php echo $obj->dateformatindia($row_get['billdate']); ?> | <?php echo $row_get['billtime']; ?></td>
                        </tr>
                        
                        <tr>
                           <td>Table</td>
                           <td class="right-align"><?php echo strtoupper($table_no); ?></td>
                        </tr>
                        <tr>
                           <td>Bill Amount</td>
                           <td class="right-align"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                        </tr>
                        <tr>
                           <td colspan="2" class="center yellow lighten-5"><strong>Paid Amount Details</strong></td>
                        </tr>
                        <?php if($row_get['cash_amt'] > 0) { ?>
                        <tr>
                           <td>Cash</td>
                           <td class="right-align"><?php echo number_format($row_get['cash_amt'],2); ?></td>
                        </tr>
                       <?php } if($row_get['card_amt'] > 0) { ?>
                        <tr>
                           <td>Card</td>
                           <td class="right-align"> <?php echo number_format($row_get['card_amt'],2); ?></td>
                        </tr>
                         <?php } if($row_get['paytm_amt'] > 0) { ?>
                        <tr>
                           <td>Paytm</td>
                           <td class="right-align"><?php echo number_format($row_get['paytm_amt'],2); ?></td>
                        </tr>
                        <?php } if($row_get['google_pay'] > 0) { ?>
                        <tr>
                           <td>G-Pay</td>
                           <td class="right-align"> <?php echo number_format($row_get['google_pay'],2); ?></td>
                        </tr>
                        <?php } if($row_get['zomato'] > 0) { ?>
                        <tr>
                           <td>Zomato</td>
                           <td class="right-align"><?php echo number_format($row_get['zomato'],2); ?></td>
                        </tr>
                        <?php } if($row_get['swiggy'] > 0) { ?>
                        <tr>
                           <td>Swiggy</td>
                           <td class="right-align"><?php echo number_format($row_get['swiggy'],2); ?></td>
                        </tr>
                        <?php } if($row_get['counter_parcel'] > 0) { ?>
                        <tr>
                           <td>Counter Parcel</td>
                           <td class="right-align"> <?php echo number_format($row_get['counter_parcel'],2); ?></td>
                        </tr>
                        <?php } if($row_get['settlement_amt'] > 0){ ?>
                        <tr>
                           <td>Settlement</td>
                           <td class="right-align"><?php echo number_format($row_get['settlement_amt'],2); ?></td>
                        </tr>
                        
                         <?php } if($row_get['credit_amt'] > 0){ ?>
                        <tr>
                           <td>Credit</td>
                           <td class="right-align"><?php echo number_format($row_get['credit_amt'],2); ?></td>
                        </tr>
                         <?php } ?>

                        <tr>
                           <td>Balance</td>
                           <td class="right-align"><?php 
                               echo number_format(round($balance),2); ?></td>
                        </tr>
                        
                       
                       
                     </tbody>
                  </table>
               </div>
            </div>

               
             <?php } ?>
              <footer class="page-footer">
               <div class="footer-copyright">
                  <table>
                     <tr>
                        <th>Bill_Amt</th><th class="right-align"><?php echo number_format($net_total,2); ?></th>
                     </tr>
                     <tr>
                        <th>Cash</th><th class="right-align"><?php echo number_format($cash_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Paytm</th><th class="right-align"><?php echo number_format($paytm_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Card</th><th class="right-align"><?php echo number_format($card_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Google_Pay</th><th class="right-align"><?php echo number_format($google_pay,2); ?></th>
                     </tr>
                     <tr>
                        <th>Zomato</th><th class="right-align"><?php echo number_format($zomato,2); ?></th>
                     </tr>
                     <tr>
                        <th>Swiggy</th><th class="right-align"><?php echo number_format($swiggy,2); ?></th>
                     </tr>
                     <tr>
                        <th>Conuter_parcel</th><th class="right-align"><?php echo number_format($counter_parcel,2); ?></th>
                     </tr>
                     <tr>
                        <th>Settlement</th><th class="right-align"><?php echo number_format($settlement_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Credit</th><th class="right-align"><?php echo number_format($credit_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Balance</th><th class="right-align"><?php echo number_format($net_bal,2); ?></th>
                     </tr>
                  </table>
               </div>
            </footer>
         </div>
         <div id="test2" class="col m6 offset-m3 s12">
          <!--  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"> -->
              <?php
              $slno = 1;
              $net_total = 0;
              $res = $obj->executequery("Select * from bills where billdate='$day_close' and checked_nc='1' order by billid desc");
              foreach($res as $row_get)
              {
              $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
              $cust_name = $row_get['cust_name'];
              $customer_name = $obj->getvalfield("m_customer","customer_name","customer_id='$cust_name'");


              $net_total += $row_get['net_bill_amt'];
              ?>
          
              <div class="card">
               <div class="card-content">
                  <table class="">
                     <tbody>
                        <tr class="indigo white-text">
                           <td><strong>Serial No.</strong></td>
                           <td class="right-align"><strong><?php echo $slno++; ?></strong></td>
                        </tr>
                        <tr>
                           <td colspan="2" class="center yellow lighten-5"><strong>Bill Info</strong></td>
                        </tr>
                        <tr>
                           <td>Bill No.</td>
                           <td class="right-align"><?php echo $row_get['billnumber']; ?></td>
                        </tr>

                         <tr>
                           <td>Date Time</td>
                           <td class="right-align"><?php echo $obj->dateformatindia($row_get['billdate']); ?> | <?php echo $row_get['billtime']; ?></td>
                        </tr>
                        
                        <tr>
                           <td>Table</td>
                           <td class="right-align"><?php echo strtoupper($table_no); ?></td>
                        </tr>

                        <tr>
                           <td>OrderType</td>
                           <td class="right-align"><?php echo strtoupper($row_get['parsal_status']); ?></td>
                        </tr>
                        <tr>
                           <td>Bill Amount</td>
                           <td class="right-align"><?php echo number_format(round($row_get['net_bill_amt']),2); ?></td>
                        </tr>
                        
                     </tbody>
                  </table>
               </div>
            </div>
             <?php } ?>
           
         </div>
         
      </div>
      
  </div>

   <script src="materialize/js/jquery.min.js"></script>
   <script src="materialize/js/materialize.min.js"></script>
   <script src="materialize/js/app.js"></script>
   <script src="js/commonfun2.js"></script>
   <script src="js/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script type="text/javascript">
   $(document).ready(function() {
      $('.js-example-basic-single').select2();
   });
   $(document).ready(function(){
      $('.tabs').tabs();
   });
   
   </script>
    <script>

    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".card-panel").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
});

</script>
</body>
</html>