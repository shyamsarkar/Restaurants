<?php
include("../adminsession.php");
$pagename = "bill_report.php";
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
   td, th{
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
      <div class="row" style="margin-bottom:0px;">
         <form class="col m6 offset-m3 s12">
            <div class="row">
               <div class="input-field col s4">
                  <select name="table_id" id="table_id" class="js-example-basic-single browser-default">
                     <option value="">Table No.</option>
                     <?php
                         
                          $res = $obj->executequery("select * from m_table");

                          foreach($res as $row_get)

                          {               
                            ?>
                            <option value="<?php echo $row_get['table_id'];  ?>"> <?php echo $row_get['table_no']; ?></option>
                          <?php } ?>
                        </select>
                        <script>document.getElementById('table_id').value='<?php echo $table_id; ?>';</script> 
                  </select>
                  <label class="active">Table No. <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s4">
                  <input type="text" name="fromdate" id="fromdate" value="<?php echo $obj->dateformatindia($fromdate); ?>" class="datepicker">
                  <label>From Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s4">
                  <input type="text" name="todate" id="todate" value="<?php echo $obj->dateformatindia($todate); ?>" class="datepicker">
                  <label>To Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                  <button class="btn waves-effect waves-light" type="submit" name="search" onClick="return checkinputmaster('fromdate,todate'); " value="Search" style="width: 100%;">Search<i class="material-icons right">search</i>
                  </button>
               </div>
               <!-- <div class="input-field col s6">
                  <a class="waves-effect waves-light red btn" href="../admin/pdf_total_sale_report.php?fromdate=<?php echo $from_date;?>&todate=<?php echo $to_date;?>" style="width: 100%;" target="_blank" class="pointer"><i class="material-icons right">print</i>print</a>
               </div> -->
            </div>
         </form>
      </div>
      
      <div class="row">
         <div class="col m6 offset-m3 s12">
            <blockquote>
               <h6>Bill Wise Sale Report List</h6>
            </blockquote>

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
                         <?php } ?>
                        <tr>
                           <td colspan="2" class="center yellow lighten-5"><strong>Credit Amount</strong></td>
                        </tr>
                        <tr>
                           <td>Amount</td>
                           <td class="right-align"><?php echo number_format($row_get['credit_amt'],2); ?></td>
                        </tr>
                        <tr>
                           <td>Customer</td>
                           <td class="right-align"><?php echo strtoupper($cust_name); ?></td>
                        </tr>
                        <tr>
                           <td>Mobile</td>
                           <td class="right-align"><?php echo $cust_mobile; ?></td>
                        </tr>
                        <tr>
                           <td>Captain</td>
                           <td class="right-align"><?php echo strtoupper($captain_name); ?></td>
                        </tr>
                        <tr>
                           <td>Steward</td>
                           <td class="right-align"><?php echo strtoupper($steward_name); ?></td>
                        </tr>
                        <tr>
                           <td>Remark</td>
                           <td class="right-align"><?php echo $remarks; ?></td>
                        </tr>
                       <!--  <tr>
                           <td>Payment</td>
                           <td class="right-align"><?php //echo $billstatus; ?></td>
                        </tr> -->
                       
                     </tbody>
                  </table>
               </div>
            </div>
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
           
            <footer class="page-footer">
               <div class="footer-copyright">
                  <table>
                     <tr>
                        <th>Total Sale Amount</th><th class="right-align"><?php echo number_format($subtotal,2); ?></th>
                     </tr>
                     <tr>
                        <th>Total Settelment Amt</th><th class="right-align"><?php echo number_format($tot_settlement_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Cancelled Amount</th><th class="right-align"><?php echo number_format($total_cancelled_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Total Rec Amt</th><th class="right-align"><?php echo number_format($tot_rec_amt,2); ?></th>
                     </tr>
                     <tr>
                        <th>Balance Amount</th><th class="right-align"><?php echo number_format($net_balance,2); ?></th>
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