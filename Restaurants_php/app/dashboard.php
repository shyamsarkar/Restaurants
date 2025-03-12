<?php
include("../adminsession.php");
$pagename = "dashboard.php";

$day_close = $obj->getvalfield("day_close", "day_date", "1=1");

$curr_date = date('Y-m-d');
$month1 = date("m-Y");
$today_kot_no = $obj->getvalfield("kot_entry", "count(*)", "1=1");
$today_nc_amount = $obj->getvalfield("bills", "sum(nc_amount)", "1=1 and paydate='$day_close'");
$month_nc_amount = $obj->getvalfield("bills", "sum(nc_amount)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_cash = $obj->getvalfield("bills", "sum(cash_amt)", "1=1 and paydate='$day_close'");
$month_cash = $obj->getvalfield("bills", "sum(cash_amt)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_credit = $obj->getvalfield("bills", "sum(credit_amt)", "1=1 and billdate='$day_close'");
$month_credit = $obj->getvalfield("bills", "sum(credit_amt)", "DATE_FORMAT(billdate,'%m-%Y')='$month1'");
$today_sale = $obj->getvalfield("bills", "sum(net_bill_amt)", "1=1 and billdate='$day_close' and checked_nc='0'");
$month_sale = $obj->getvalfield("bills", "sum(net_bill_amt)", "DATE_FORMAT(billdate,'%m-%Y')='$month1' and checked_nc='0'");
$today_paytm = $obj->getvalfield("bills", "sum(paytm_amt)", "1=1 and paydate='$day_close'");
$month_paytm = $obj->getvalfield("bills", "sum(paytm_amt)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_card = $obj->getvalfield("bills", "sum(card_amt)", "1=1 and paydate='$day_close'");
$month_card = $obj->getvalfield("bills", "sum(card_amt)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_g_pay = $obj->getvalfield("bills", "sum(google_pay)", "1=1 and paydate='$day_close'");
$month_g_pay = $obj->getvalfield("bills", "sum(google_pay)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_zomato = $obj->getvalfield("bills", "sum(zomato)", "1=1 and paydate='$day_close'");
$month_zomato = $obj->getvalfield("bills", "sum(zomato)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_swiggy = $obj->getvalfield("bills", "sum(swiggy)", "1=1 and paydate='$day_close'");
$month_swiggy = $obj->getvalfield("bills", "sum(swiggy)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_cparcel = $obj->getvalfield("bills", "sum(counter_parcel)", "1=1 and paydate='$day_close'");
$month_cparcel = $obj->getvalfield("bills", "sum(counter_parcel)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_table = $obj->getvalfield("bills", "sum(cash_amt+credit_amt+paytm_amt+card_amt+google_pay)", "1=1 and paydate='$day_close'");
$month_table = $obj->getvalfield("bills", "sum(cash_amt+credit_amt+paytm_amt+card_amt+google_pay)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_settle = $obj->getvalfield("bills", "sum(settlement_amt)", "1=1 and paydate='$day_close'");
$month_settl = $obj->getvalfield("bills", "sum(settlement_amt)", "DATE_FORMAT(paydate,'%m-%Y')='$month1'");
$today_balance = $today_sale - $today_cash - $today_paytm - $today_card - $today_settle - $today_g_pay - $today_zomato - $today_swiggy - $today_cparcel;
$month_balance = $month_sale - $month_cash - $month_paytm - $month_card - $month_settl - $month_g_pay - $month_zomato - $month_swiggy - $today_cparcel;

$today_purchase = $obj->getvalfield("purchaseentry", "sum(net_amount)", "1=1 and bill_date='$curr_date'");
$month_purchase = $obj->getvalfield("purchaseentry", "sum(net_amount)", "DATE_FORMAT(bill_date,'%m-%Y')='$month1'");

$tot_menuitem = $obj->getvalfield("m_product", "count(*)", "1=1");

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Indian Chilly</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes, viewport-fit=cover user-scalable=no">
   <link rel="stylesheet" href="materialize/css/materialize.min.css">
   <link rel="stylesheet" href="materialize/css/icon.css">
   <link rel="stylesheet" href="materialize/css/animate.min.css" />
   <link rel="stylesheet" href="https://unpkg.com/placeholder-loading/dist/css/placeholder-loading.min.css">

   <style>
      .bg {
         background: #141E30;
         background: -webkit-linear-gradient(to bottom, #243B55, #141E30);
         background: linear-gradient(to bottom, #243B55, #141E30);
      }

      nav .nav-title {
         display: inline-block;
         font-size: 25px;
         padding: 0px 0px 40px 0;
      }

      .card .card-content {
         padding: 10px;
         border-radius: 0 0 2px 2px;
      }

      .bg-1 {
         background: #9D50BB;
         background: -webkit-linear-gradient(to right, #6E48AA, #9D50BB);
         background: linear-gradient(to right, #6E48AA, #9D50BB);
         color: white;
      }

      .bg-2 {
         background: #f2709c;
         background: -webkit-linear-gradient(to right, #ff9472, #f2709c);
         background: linear-gradient(to right, #ff9472, #f2709c);
         color: white;
      }

      .bg-3 {
         background: #4b6cb7;
         background: -webkit-linear-gradient(to right, #182848, #4b6cb7);
         background: linear-gradient(to right, #182848, #4b6cb7);
         color: white;
      }

      .bg-4 {
         background: #e43a15;
         background: -webkit-linear-gradient(to right, #e65245, #e43a15);
         background: linear-gradient(to right, #e65245, #e43a15);
         color: white;
      }

      .bg-5 {
         background: #52c234;
         background: -webkit-linear-gradient(to right, #061700, #52c234);
         background: linear-gradient(to right, #061700, #52c234);
         color: white;
      }

      .bg-6 {
         background: #00c6ff;
         background: -webkit-linear-gradient(to right, #0072ff, #00c6ff);
         background: linear-gradient(to right, #0072ff, #00c6ff);
         color: white;
      }

      .bg-7 {
         background: #B993D6;
         background: -webkit-linear-gradient(to right, #8CA6DB, #B993D6);
         background: linear-gradient(to right, #8CA6DB, #B993D6);
         color: white;
      }

      .bg-8 {
         background: #a73737;
         background: -webkit-linear-gradient(to right, #7a2828, #a73737);
         background: linear-gradient(to right, #7a2828, #a73737);
         color: white;
      }

      .bg-9 {
         background: #FF8008;
         background: -webkit-linear-gradient(to right, #fa8619, #FF8008);
         background: linear-gradient(to right, #fa8619, #FF8008);
         color: white;
      }

      .bg-10 {
         background: #bc4e9c;
         background: -webkit-linear-gradient(to right, #f80759, #bc4e9c);
         background: linear-gradient(to right, #f80759, #bc4e9c);
         color: white;
      }

      .bg-11 {
         background: #3C3B3F;
         background: -webkit-linear-gradient(to right, #605C3C, #3C3B3F);
         background: linear-gradient(to right, #605C3C, #3C3B3F);
         color: white;
      }

      .bg-12 {
         background: #159957;
         background: -webkit-linear-gradient(to right, #155799, #159957);
         background: linear-gradient(to right, #155799, #159957);
         color: white;
      }

      .bg-13 {
         background: #C33764;
         background: -webkit-linear-gradient(to right, #1D2671, #C33764);
         background: linear-gradient(to right, #1D2671, #C33764);
         color: white;
      }

      .icon {
         font-size: 3rem;
         padding-left: 5px;
      }

      small {
         font-size: 81%;
      }

      blockquote {
         margin: 5px 0;
      }

      i.medium {
         font-size: 3rem;
      }

      .collection .collection-item {
         background: #2b5876;
         color: white;
         background: -webkit-linear-gradient(to right, #4e4376, #2b5876);
         background: linear-gradient(to right, #4e4376, #2b5876);
      }

      .collection .collection-item.avatar i.circle {
         font-size: 22px;
      }

      .mr-0 {
         margin-bottom: 0px;
      }
   </style>
</head>

<body class="grey lighten-5">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
   <div class="container" style="width: 95%;">
      <div class="row">
         <div class="col s12 m6 offset-m3">
            <blockquote style="margin:10px 0;">
               <strong>Dashboard</strong>
            </blockquote>
            <div class="row" style="margin-bottom:10px;">
               <div class="col s12">
                  <div class="card-panel bg-1" style="padding:5px 15px;">
                     <h5 class="center">Sale</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Sale</h6>
                           <h6><strong><?php echo number_format($today_sale, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Sale</h6>
                           <h6><strong><?php echo number_format($month_sale, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-5" style="padding:5px 15px;">
                     <h5 class="center">Cash</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Cash</h6>
                           <h6><strong><?php echo number_format($today_cash, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Cash</h6>
                           <h6><strong><?php echo number_format($month_cash, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-4" style="padding:5px 15px;">
                     <h5 class="center">Credit</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Credit</h6>
                           <h6><strong><?php echo number_format($today_credit, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Credit</h6>
                           <h6><strong><?php echo number_format($today_credit, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-6" style="padding:5px 15px;">
                     <h5 class="center">Paytm</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Paytm</h6>
                           <h6><strong><?php echo number_format($today_paytm, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Paytm</h6>
                           <h6><strong><?php echo number_format($month_paytm, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-3" style="padding:5px 15px;">
                     <h5 class="center">Google Pay</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today G Pay</h6>
                           <h6><strong><?php echo number_format($today_g_pay, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month G Pay</h6>
                           <h6><strong><?php echo number_format($month_g_pay, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-2" style="padding:5px 15px;">
                     <h5 class="center">Settlement</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Sale</h6>
                           <h6><strong><?php echo number_format($today_settle, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Sale</h6>
                           <h6><strong><?php echo number_format($month_settl, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-7" style="padding:5px 15px;">
                     <h5 class="center">Card</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Sale</h6>
                           <h6><strong><?php echo number_format($today_card, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Sale</h6>
                           <h6><strong><?php echo number_format($month_card, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-8" style="padding:5px 15px;">
                     <h5 class="center">Zomato</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Zomato</h6>
                           <h6><strong><?php echo number_format($today_zomato, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Zomato</h6>
                           <h6><strong><?php echo number_format($month_zomato, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-9" style="padding:5px 15px;">
                     <h5 class="center">Swiggy</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Swiggy</h6>
                           <h6><strong><?php echo number_format($today_swiggy, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Swiggy</h6>
                           <h6><strong><?php echo number_format($month_swiggy, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-10" style="padding:5px 15px;">
                     <h5 class="center">Counter Parcel</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Parcel</h6>
                           <h6><strong><?php echo number_format($today_cparcel, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Parcel</h6>
                           <h6><strong><?php echo number_format($month_cparcel, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-11" style="padding:5px 15px;">
                     <h5 class="center">Table Billing Amount</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today Billing Amt</h6>
                           <h6><strong><?php echo number_format($today_table, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month Billing Amt</h6>
                           <h6><strong><?php echo number_format($month_table, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-12" style="padding:5px 15px;">
                     <h5 class="center">Balance</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today</h6>
                           <h6><strong><?php echo number_format($today_balance, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month</h6>
                           <h6><strong><?php echo number_format($month_balance, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col s12">
                  <div class="card-panel bg-13" style="padding:5px 15px;">
                     <h5 class="center">Not Chargeable</h5>
                     <div class="row mr-0">
                        <div class="col s6">
                           <h6>Today</h6>
                           <h6><strong><?php echo number_format($today_nc_amount, 2); ?></strong></h6>
                        </div>
                        <div class="col s6 right-align">
                           <h6>Month</h6>
                           <h6><strong><?php echo number_format($month_nc_amount, 2); ?></strong></h6>
                        </div>
                     </div>
                  </div>
               </div>

               <div class="col s12">
                  <div class="card-panel bg-13" style="padding:5px 15px;">

                     <div class="" style="padding: 10px;width:100%;" onclick="window.location='todayview_billandnc.php'">
                        <h5 class="center">View Todays Bills And NC</h5>

                     </div>
                  </div>
               </div>



            </div>
            <!--   <blockquote>
               <strong>Master</strong>
            </blockquote>
            <div class="row" style="margin-bottom:0px;">
               <div class="col s4">
                  <div class="card-panel center waves-yellow waves-effect" style="padding: 10px;width:100%;" onclick="window.location='add_customer.php'">
                     <i class="material-icons medium red-text">contacts</i>
                     <h6 style="font-size: 85%;">Add Customer</h6>
                  </div>
               </div>
               <div class="col s4">
                  <div class="card-panel center waves-yellow waves-effect" style="padding: 10px;width:100%;" onclick="window.location='add_supplier.php'">
                     <i class="material-icons medium green-text">group_add</i>
                     <h6 style="font-size: 85%;">Add Suppliers</h6>
                  </div>
               </div>
               <div class="col s4">
                  <div class="card-panel center waves-yellow waves-effect" style="padding: 10px;width:100%;" onclick="window.location='add_payment.php'">
                     <i class="material-icons medium orange-text">account_balance_wallet</i>
                     <h6 style="font-size: 85%;">Payment Entry</h6>
                  </div>
               </div>
            </div> -->
            <blockquote>
               <strong>Report</strong>
            </blockquote>
            <div class="row">
               <div class="col s12">
                  <ul class="collection">
                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='day_wise_payment_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Day Wise Payment Report
                        </p>
                        <a href="day_wise_payment_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>
                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_category_wise_sale_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Category Wise Sale Report
                        </p>
                        <a href="app_category_wise_sale_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>
                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_cash_inout_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Cash In Out Report
                        </p>
                        <a href="app_cash_inout_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>

                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='bill_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Bill Wise Sale Report List
                        </p>
                        <a href="bill_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>

                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_nc_bill_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Not Chargeable Bill Report List
                        </p>
                        <a href="app_nc_bill_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>

                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_billcredit_report_list.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Bill Wise Credit Sale Report List
                        </p>
                        <a href="app_billcredit_report_list.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>

                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_payment_report_new.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Payment Entry Report

                        </p>
                        <a href="app_payment_report_new.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>

                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_product_wise_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>Product Wise Sale Report

                        </p>
                        <a href="app_product_wise_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>




                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_expanse_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo number_format($total_due,2); 
                                                      ?></strong></span>
                        <p>Expanse Report Entry
                        </p>
                        <a href="app_expanse_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>
                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_kot_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>KOT Report
                        </p>
                        <a href="app_kot_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>

                     <li class="collection-item avatar" style="min-height: 65px;" onclick="window.location='app_gst_report.php'">
                        <i class="material-icons white indigo-text circle z-depth-3">description</i>
                        <span class="title"><strong><?php //echo $total_bills; 
                                                      ?></strong></span>
                        <p>GST Report
                        </p>
                        <a href="app_gst_report.php" class="secondary-content"><i class="material-icons white-text">send</i></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script src="materialize/js/jquery.min.js"></script>
   <script src="materialize/js/materialize.min.js"></script>
   <script src="materialize/js/app.js"></script>
   <script>
      // $(window).on('load',function() { 
      //       $(".preloading").fadeOut("slow"); 
      // });
   </script>
</body>

</html>