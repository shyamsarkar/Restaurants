<?php
include("../adminsession.php");
$pagename = "customer_wise_report.php";
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
   $from_date = $obj->dateformatusa($_GET['from_date']);
   $to_date  =  $obj->dateformatusa($_GET['to_date']);
} else {
   $from_date = date('Y-m-d');
   $to_date = date('Y-m-d');
   $dcustomer_id = "";
   $product_name = "";
   $customer_name = "";
}

if ($from_date != '' && $to_date != '') {
   $crit = " where 1 = 1 and bill_date between '$from_date' and '$to_date'";
}

if (isset($_GET['customer_id'])) {

   $dcustomer_id = $_GET['customer_id'];
   if (!empty($dcustomer_id))
      $crit .= " and customer_id = '$dcustomer_id'";
   $customer_name = $obj->getvalfield("master_customer", "customer_name", "customer_id='$dcustomer_id'");
}



if (isset($_GET['product_name'])) {

   $product_name = $_GET['product_name'];
   if (!empty($product_name))
      $crit .= " and product_name = '$product_name'";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Parakh</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes, viewport-fit=cover user-scalable=no">
   <link rel="stylesheet" href="materialize/css/materialize.min.css">
   <link rel="stylesheet" href="materialize/css/icon.css">
   <link rel="stylesheet" href="materialize/css/animate.min.css" />
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   <style>
      .bg {
         background: #141E30;
         background: -webkit-linear-gradient(to bottom, #243B55, #141E30);
         background: linear-gradient(to bottom, #243B55, #141E30);
      }

      .card .card-content {
         padding: 10px;
         border-radius: 0 0 2px 2px;
      }

      td {
         padding: 6px 5px;
      }

      .page-footer {
         padding-top: 0px;
         color: #fff;
         background-color: #18253a;
      }

      .btn {
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
   </style>
</head>

<body class="">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
   <div class="container" style="width:100%;"><br>
      <div class="row">
         <form class="col m6 offset-m3 s12">
            <div class="row">
               <div class="input-field col s12">

                  <select name="customer_id" id="customer_id" class="js-example-basic-single browser-default">
                     <option value="">Choose your option</option>
                     <?php
                     $slno = 1;

                     $res = $obj->executequery("select * from master_customer");
                     foreach ($res as $row_get) {
                     ?>
                        <option value="<?php echo $row_get['customer_id']; ?>"> <?php echo $row_get['customer_name']; ?></option>
                     <?php } ?>
                  </select>
                  <label class="active">Customer <span class="red-text">*</span></label>
                  <script>
                     document.getElementById('customer_id').value = '<?php echo $dcustomer_id; ?>';
                  </script>


               </div>
               <div class="input-field col s12">

                  <select name="product_name" id="product_name" class="js-example-basic-single browser-default">
                     <option value="">Choose your option</option>
                     <?php
                     $slno = 1;

                     $res = $obj->executequery("select * from saleentry group by product_name");
                     foreach ($res as $row_get) {
                     ?>
                        <option value="<?php echo $row_get['product_name']; ?>"> <?php echo $row_get['product_name']; ?></option>
                     <?php } ?>
                  </select>
                  <script>
                     document.getElementById('product_name').value = '<?php echo $product_name; ?>';
                  </script>
                  <label class="active">Goods Name</label>

               </div>
               <div class="input-field col s6">
                  <input type="text" name="from_date" id="from_date" value="<?php echo $obj->dateformatindia($from_date); ?>" class="datepicker">
                  <label>From Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s6">
                  <input type="text" name="to_date" id="to_date" value="<?php echo $obj->dateformatindia($to_date); ?>" class="datepicker">
                  <label>To Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s6">
                  <button class="btn waves-effect waves-light" type="submit" name="search" onClick="return checkinputmaster('customer_id,from_date,to_date'); " value="Search" style="width: 100%;">Search<i class="material-icons right">search</i>
                  </button>
               </div>
               <div class="input-field col s6">
                  <a class="waves-effect waves-light red btn" href="../admin/pdf_customer_bill_report.php?customer_id=<?php echo $dcustomer_id; ?>&product_name=<?php echo $product_name; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" style="width: 100%;" target="_blank"><i class="material-icons right">print</i>print</a>

               </div>
            </div>
         </form>
      </div>

      <div class="row">
         <div class="col m6 offset-m3 s12">
            <blockquote>
               <h6>Customer Wise Report List</h6>
            </blockquote>

            <?php
            $sno = 1;
            $final_price = 0;
            $sale_ids  = '';
            $sql = $obj->executequery("select * from saleentry $crit order by bill_date asc");
            foreach ($sql as $key) {
               $saleid = $key['saleid'];
               $supplier_id = $key['supplier_id'];
               $customer_id = $key['customer_id'];
               $lr_no = $key['lr_no'];
               $tot_taxable = $key['tot_taxable'];
               $net_amount = $key['net_amount'];

               $sale_payamt = $obj->getvalfield("payment_details", "sum(recamt - disc_amt)", "sale_id='$saleid'");
               $disc_amt = $obj->getvalfield("payment_details", "sum(disc_amt)", "sale_id='$saleid'");

               $product_name = $key['product_name'];
               $rate_amt = $key['rate_amt'];

               $product_desc = $key['product_desc'];

               $billno = $key['billno'];
               $billdate = $key['bill_date'];

               $suppliername = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id='$supplier_id'");
               $customername = $obj->getvalfield("master_customer", "customer_name", "customer_id='$customer_id'");
               $bank_name = $obj->getvalfield("master_supplier", "bank_name", "supplier_id='$supplier_id'");
               $curr_amt = $obj->getvalfield("bill_payment", "sum(curr_paid_amt)", "saleid='$saleid'");

               $pay_date = $obj->getvalfield("bill_payment", "pay_date", "saleid='$saleid'");
               $check_date = $obj->getvalfield("bill_payment", "check_date", "saleid='$saleid'");
               $check_no = $obj->getvalfield("bill_payment", "check_no", "saleid='$saleid'");

               $sale_ids = '';
               if ($curr_amt == 0 || $curr_amt == '') {

                  $payinfo = $obj->executequery("select * from bill_payment where FIND_IN_SET($saleid,sale_ids)");
                  foreach ($payinfo as $value) {
                     # code...
                     $curr_amt = $value['curr_paid_amt'];
                     $pay_date = $value['pay_date'];
                     $bank_name = $value['bank_name'];
                     $check_no = $value['check_no'];
                     $check_date = $value['check_date'];
                     $payment_mode = $value['payment_mode'];
                     $sale_ids = $value['sale_ids'];
                  }
               }



               $trans_name = $key['trans_name'];
               $remark = $key['remark'];
               //$netamt = $net_amount - $curr_amt;


               $bill_no = '';
               if ($sale_ids != '') {
                  $arr = explode(',', $sale_ids);
                  foreach ($arr as $i) {
                     $bill_no .= $obj->getvalfield("saleentry", "billno", "saleid='$i'") . ', ';
                  }
               }



            ?>

               <div class="card">
                  <div class="card-content">
                     <table class="striped">
                        <tbody>

                           <tr>
                              <td><strong>Serial No.</strong></td>
                              <td class="right-align"><strong><?php echo $sno++; ?></strong></td>
                           </tr>
                           <tr>
                              <td>Bill No</td>
                              <td class="right-align"><?php echo $billno; ?></td>
                           </tr>
                           <tr>
                              <td>Bill Date</td>
                              <td class="right-align"><?php echo $obj->dateformatindia($billdate); ?></td>
                           </tr>

                           <tr>
                              <td>Supplier</td>
                              <td class="right-align"><?php echo $suppliername; ?></td>
                           </tr>
                           <tr>
                              <td>Goods Name</td>
                              <td class="right-align"><?php echo $product_name; ?></td>
                           </tr>
                           <tr>
                              <td>Descrption</td>
                              <td class="right-align"><?php echo $product_desc; ?></td>
                           </tr>
                           <tr>
                              <td>Rate</td>
                              <td class="right-align"><?php echo $rate_amt; ?></td>
                           </tr>
                           <?php if ($sale_payamt > 0) { ?>
                              <tr>

                                 <td>Rec Date</td>
                                 <td class="right-align"><?php echo $obj->dateformatindia($pay_date); ?></td>
                              </tr>
                              <tr>

                                 <td>Cheq./DD No</td>
                                 <td class="right-align"><?php echo $check_no; ?></td>
                              </tr>
                              <tr>

                                 <td>Cheq.Amt</td>
                                 <td><?php echo $curr_amt; ?></td>
                              </tr>
                              <?php if ($bill_no != '') { ?>
                                 <tr>

                                    <td>Bills</td>
                                    <td class="right-align"><?php echo "(Bills: " . $bill_no . ")"; ?></td>
                                 </tr>
                           <?php }
                           }
                           $payable_amt = $net_amount - $disc_amt;
                           $netamt = $payable_amt - $sale_payamt;
                           ?>
                           <tr>
                              <td>Transport</td>
                              <td class="right-align"><?php echo $trans_name; ?></td>
                           </tr>
                           <tr>
                              <td>LR.No</td>
                              <td class="right-align"><?php echo $lr_no; ?></td>
                           </tr>
                           <tr>
                              <td>Remark</td>
                              <td class="right-align"><?php echo $remark; ?></td>
                           </tr>
                           <tr>
                              <td>Bill Amount</td>
                              <td class="right-align"><?php echo round($net_amount, 2); ?></td>
                           </tr>
                           <tr>
                              <td>Discount Amount</td>
                              <td class="right-align"><?php echo round($disc_amt, 2); ?></td>
                           </tr>
                           <tr>
                              <td>Payable</td>
                              <td class="right-align"><?php echo round($payable_amt, 2); ?></td>
                           </tr>
                           <tr>
                              <td>Recieved Amount</td>
                              <td class="right-align"><?php echo round($sale_payamt, 2); ?></td>
                           </tr>
                           <tr class="red lighten-5">
                              <td><strong>Net Amount</strong></td>
                              <td class="right-align"><strong>&#x20B9; <?php echo round($netamt, 2); ?></strong></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            <?php
               $final_price += $netamt;
            }
            ?>

            <footer class="page-footer">
               <div class="footer-copyright">
                  <div class="container">
                     <strong>Total</strong>
                     <strong class="right">&#x20B9; <?php echo number_format(round($final_price), 2);  ?></strong>
                  </div>
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