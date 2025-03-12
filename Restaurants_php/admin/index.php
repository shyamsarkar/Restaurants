<?php include("../adminsession.php");
$pagename = "index.php";
$module = "Dashboard";
$submodule = "Dashboard";
$delivery_date = "";
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

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <style>
    .card {
      padding: 10px;
      color: white;
      text-align: center;
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    hr {
      margin: 5px 0;
      border: 0;
      border-bottom: 1px solid #fff;
    }

    a:hover,
    a:focus {
      color: white;
    }

    .text-white {
      color: white;
    }
  </style>
</head>

<body>
  <div class="mainwrapper">
    <?php include("inc/left_menu.php"); ?>
    <!--mainleft-->
    <div class="rightpanel">
      <?php include("inc/header.php"); ?>
      <div class="maincontent">
        <div class="contentinner">
          <div class="row-fluid">
            <div class="span12">
              <?php if ($_SESSION['usertype'] == 'admin') { ?>
                <ul class="widgeticons row-fluid">

                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #ad5389; 
                        background: -webkit-linear-gradient(to right, #3c1053, #ad5389);  
                        background: linear-gradient(to right, #3c1053, #ad5389);
                        ">
                      <h3 class="text-white"> Sale</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today Sale</span>
                          <span><?php echo number_format($today_sale, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month Sale</span>
                          <span><?php echo number_format($month_sale, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #11998e; background: -webkit-linear-gradient(to right, #11998e, #36b467); background: linear-gradient(to right, #11998e, #36b467);">
                      <h3 class="text-white">Cash</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today Cash</span>
                          <span><?php echo number_format($today_cash, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month Cash</span>
                          <span><?php echo number_format($month_cash, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #0f0c29; background: -webkit-linear-gradient(to right, #24243e, #302b63, #0f0c29); background: linear-gradient(to right, #24243e, #302b63, #0f0c29);">
                      <h3 class="text-white">Credit</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today Credit</span>
                          <span><?php echo number_format($today_credit, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month Credit</span>
                          <span><?php echo number_format($month_credit, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #000046; background: -webkit-linear-gradient(to right, #0a0a79, #1CB5E0); background: linear-gradient(to right, #0a0a79, #1CB5E0);">
                      <h3 class="text-white">PayTm</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today Paytm</span>
                          <span><?php echo number_format($today_paytm, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month Paytm</span>
                          <span><?php echo number_format($month_paytm, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #0575E6;
                        background: -webkit-linear-gradient(to right, #021B79, #0575E6); background: linear-gradient(to right, #021B79, #0575E6);">
                      <h3 class="text-white">Google Pay</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today GPay</span>
                          <span><?php echo number_format($today_g_pay, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month GPay</span>
                          <span><?php echo number_format($month_g_pay, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #ff7e5f;background: -webkit-linear-gradient(to right, #f5a364, #ff7e5f);background: linear-gradient(to right, #f5a364, #ff7e5f);">
                      <h3 class="text-white">Settlement</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today Sale</span>
                          <span><?php echo number_format($today_settle, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month Sale</span>
                          <span><?php echo number_format($month_settl, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #cb2d3e; background: -webkit-linear-gradient(to right, #ef473a, #cb2d3e);background: linear-gradient(to right, #ef473a, #cb2d3e);">
                      <h3 class="text-white">Card</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today Sale</span>
                          <span><?php echo number_format($today_card, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month Sale</span>
                          <span><?php echo number_format($month_card, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>

                  <li class="one_fifth">
                    <a href="#" class="card" style="border-radius: 0px 0px 20px 20px;background: #000000; background: -webkit-linear-gradient(to right, #434343, #000000); background: linear-gradient(to right, #434343, #000000);">
                      <h6 class="text-left">Zomato</h6>
                      <div class="row-fluid">
                        <div class="span6 text-left" style="min-height: 20px !important; ">
                          <small>Today - <?php echo number_format($today_zomato, 2); ?> </small>
                        </div>
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Month - <?php echo number_format($month_zomato, 2); ?> </small>
                        </div>
                      </div>
                      <h6 class="text-left">Swiggy</h6>
                      <div class="row-fluid">
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Today - <?php echo number_format($today_swiggy, 2); ?> </small>
                        </div>
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Month - <?php echo number_format($month_swiggy, 2); ?> </small>
                        </div>
                      </div>
                      <h6 class="text-left">Counter Parcel</h6>
                      <div class="row-fluid">
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Today - <?php echo number_format($today_cparcel, 2); ?> </small>
                        </div>
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Month - <?php echo number_format($month_cparcel, 2); ?> </small>
                        </div>
                      </div>

                      <h6 class="text-left">Table Billing Amt </h6>
                      <div class="row-fluid">
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Today - <?php echo number_format($today_table, 2); ?> </small>
                        </div>
                        <div class="span6 text-left" style="min-height: 20px !important;">
                          <small>Month - <?php echo number_format($month_table, 2); ?> </small>
                        </div>
                      </div>

                    </a>
                  </li>

                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #42275a; background: -webkit-linear-gradient(to right, #734b6d, #42275a); background: linear-gradient(to right, #734b6d, #42275a);">
                      <h3 class="text-white">Balance</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span6">
                          <span>Today </span>
                          <span><?php echo number_format($today_balance, 2); ?></span>
                        </div>
                        <div class="span6">
                          <span>Month </span>
                          <span><?php echo number_format($month_balance, 2); ?></span>
                        </div>
                      </div>
                    </a>
                  </li>

                  <li class="one_fifth">
                    <a href="#" class="card" style="background: #8E0E00;background: -webkit-linear-gradient(to right, #1F1C18, #8E0E00); background: linear-gradient(to right, #1F1C18, #8E0E00);">
                      <h3 class="text-white">Not Chargeable</h3>
                      <hr>
                      <div class="row-fluid">
                        <div class="span12">
                          <div class="span6">
                            <span>Today </span>
                            <span><?php echo number_format($today_nc_amount, 2); ?></span>
                          </div>
                          <div class="span6">
                            <span>Month </span>
                            <span><?php echo number_format($month_nc_amount, 2); ?></span>
                          </div>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              <?php } ?>
              <!--widgetcontent-->
              <br />

              <h4 class="widgettitle">Today's Transactions (<?php echo $obj->dateformatindia($day_close); ?>)</h4>

              <div class="row-fluid">
                <div class="span12">
                  <div class="widgetcontent">
                    <div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
                      <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">

                        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><span class="icon-forward"></span>Todays Bills</a></li>

                        <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1"><span class="icon-forward"></span>Todays Not Chargeable Bills</a></li>


                      </ul>
                      <div id="tabs-1" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                        <table class="table table-bordered">
                          <colgroup>
                            <col class="con0" style="text-align: center; width: 4%" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                          </colgroup>
                          <thead>
                            <tr>
                              <th width="7%" class="head0 nosort">S.No.</th>
                              <th class="head0">Bill No.</th>
                              <th class="head0">Bill Date</th>
                              <th class="head0">Bill Time</th>
                              <th class="head0">Table</th>

                              <th class="head0">OrderType</th>
                              <th class="head0" style="text-align: right;">Bill Amount</th>
                              <th class="head0" style="text-align: right;">Cash</th>
                              <th class="head0" style="text-align: right;">Paytm</th>
                              <th class="head0" style="text-align: right;">Card</th>
                              <th class="head0" style="text-align: right;">Google Pay</th>
                              <th class="head0" style="text-align: right;">Zomato</th>
                              <th class="head0" style="text-align: right;">Swiggy</th>
                              <th class="head0" style="text-align: right;">Conuter_parcel</th>
                              <th class="head0" style="text-align: right;">Settlement</th>
                              <th class="head0" style="text-align: right;">Credit</th>
                              <th class="head0" style="text-align: right;">Balance</th>
                            </tr>
                          </thead>
                          <tbody id="record">
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
                            foreach ($res as $row_get) {
                              $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$row_get[table_id]'");
                              $cust_name = $row_get['cust_name'];
                              $customer_name = $obj->getvalfield("m_customer", "customer_name", "customer_id='$cust_name'");
                              //check bill balance amt

                              $balance = $row_get['net_bill_amt'] - $row_get['cash_amt'] - $row_get['paytm_amt'] - $row_get['card_amt'] - $row_get['settlement_amt'] - $row_get['google_pay'] - $row_get['zomato'] - $row_get['swiggy'] - $row_get['counter_parcel'];

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


                              if ($balance > 0) {
                                $clsname = "alert-danger";
                              } else {
                                $clsname = "alert-success";
                              }

                            ?>
                              <tr class="<?php echo $clsname; ?>">
                                <td style="text-align:center;"><?php echo $slno++; ?></td>
                                <td><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $row_get['billnumber']; ?></a></td>
                                <td style="text-align:center;"><?php echo $obj->dateformatindia($row_get['billdate']); ?></td>
                                <td style="text-align:center;"><?php echo $row_get['billtime']; ?></td>
                                <td style="text-align:center;"><?php echo strtoupper($table_no); ?></td>

                                <td style="text-align:center;"><?php echo strtoupper($row_get['parsal_status']); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['net_bill_amt']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['cash_amt']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['paytm_amt']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['card_amt']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['google_pay']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['zomato']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['swiggy']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['counter_parcel']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['settlement_amt']), 2); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['credit_amt']), 2); ?></td>
                                <td style="text-align:right;"><?php
                                                              echo number_format(round($balance), 2); ?></td>
                              </tr>
                            <?php
                              if ($row_get['is_cancelled'])
                                $total_cancelled_amt += $row_get['net_bill_amt'];

                              // $net_balance = $subtotal - $total_cancelled_amt - $tot_rec_amt;
                            }

                            ?>

                            <th colspan="6" class="head0"></th>
                            <th class="head0" style="text-align: right;">Bill_Amt</th>
                            <th class="head0" style="text-align: right;">Cash</th>
                            <th class="head0" style="text-align: right;">Paytm</th>
                            <th class="head0" style="text-align: right;">Card</th>
                            <th class="head0" style="text-align: right;">Google_Pay</th>
                            <th class="head0" style="text-align: right;">Zomato</th>
                            <th class="head0" style="text-align: right;">Swiggy</th>
                            <th class="head0" style="text-align: right;">Conuter_parcel</th>
                            <th class="head0" style="text-align: right;">Settlement</th>
                            <th class="head0" style="text-align: right;">Credit</th>
                            <th class="head0" style="text-align: right;">Balance</th>

                            <tr>
                              <td colspan="6"><b>Total</b></td>
                              <td style="text-align: right;"><b><?php echo number_format($net_total, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($cash_amt, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($paytm_amt, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($card_amt, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($google_pay, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($zomato, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($swiggy, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($counter_parcel, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($settlement_amt, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($credit_amt, 2); ?></b></td>
                              <td style="text-align: right;"><b><?php echo number_format($net_bal, 2); ?></b></td>

                            </tr>

                          </tbody>
                        </table>
                      </div>

                      <div id="tabs-2" aria-labelledby="ui-id-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom" role="tabpanel" aria-expanded="true" aria-hidden="false">
                        <table class="table table-bordered">
                          <colgroup>
                            <col class="con0" style="text-align: center; width: 4%" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                          </colgroup>
                          <thead>
                            <tr>
                              <th width="7%" class="head0 nosort">S.No.</th>
                              <th class="head0">Bill No.</th>
                              <th class="head0">Bill Date</th>
                              <th class="head0">Bill Time</th>
                              <th class="head0">Table</th>
                              <th class="head0">OrderType</th>
                              <th class="head0" style="text-align: right;">Bill Amount</th>

                            </tr>
                          </thead>
                          <tbody id="record">
                            <?php
                            $slno = 1;
                            $net_total = 0;
                            $res = $obj->executequery("Select * from bills where billdate='$day_close' and checked_nc='1' order by billid desc");
                            foreach ($res as $row_get) {
                              $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$row_get[table_id]'");
                              $cust_name = $row_get['cust_name'];
                              $customer_name = $obj->getvalfield("m_customer", "customer_name", "customer_id='$cust_name'");
                              //check bill balance amt

                              $net_total += $row_get['net_bill_amt'];

                            ?>
                              <tr class="alert-success">
                                <td style="text-align:center;"><?php echo $slno++; ?></td>
                                <td><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $row_get['billnumber']; ?></a></td>
                                <td><?php echo $obj->dateformatindia($row_get['billdate']); ?></td>
                                <td><?php echo $row_get['billtime']; ?></td>
                                <td><?php echo strtoupper($table_no); ?></td>
                                <td><?php echo strtoupper($row_get['parsal_status']); ?></td>
                                <td style="text-align:right;"><?php echo number_format(round($row_get['net_bill_amt']), 2); ?></td>
                              </tr>
                            <?php

                            }

                            ?>

                            <tr>
                              <td colspan="6"><b>Total NC Bill</b></td>
                              <td style="text-align: right;"><b><?php echo number_format($net_total, 2); ?></b></td>
                            </tr>

                          </tbody>
                        </table>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <!--widgetcontent-->
            </div>
            <!--span8-->
            <!--span4-->
          </div>
          <!--<h4 class="widgettitle">Alloted Files</h4>-->

          <!--row-fluid-->
        </div>
        <!--contentinner-->


      </div>
      <!--maincontent-->

    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->

    <div class="clearfix"></div>
    <?php include("inc/footer.php"); ?>
    <!--footer-->


  </div>
  <!--mainwrapper-->
  <script>
    jQuery(document).ready(function() {

      jQuery('#menues').click();

    });
  </script>
</body>

</html>