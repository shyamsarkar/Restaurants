<?php
include("../adminsession.php");
$pagename = "customer_ladger.php";
if(isset($_GET['from_date']) && isset($_GET['to_date']))
{

  $from_date = $obj->dateformatusa($_GET['from_date']);
  $to_date = $obj->dateformatusa($_GET['to_date']);
}
else
{

  $from_date = date('Y-m-d');
  $to_date = date('Y-m-d');
}

if(isset($_GET['customer_id']))
{

  $customer_id = $obj->test_input($_GET['customer_id']);
  $customer_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");
}
else
{

  $customer_id = "";

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

                        $res = $obj->executequery("select * from master_customer");



                        foreach($res as $row)

                        {

                        ?> 

                        <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>

                        <?php

                        }

                        ?>

                      </select>
                      <label class="active">Customers Name <span class="red-text">*</span></label>
                      <script>document.getElementById('customer_id').value='<?php echo $customer_id; ?>';</script>
                  
               </div>
               <div class="input-field col s12 center">
                  <button class="btn waves-effect waves-light" type="submit" name="search" onclick="return checkinputmaster('customer_id');"><i class="material-icons right">search</i>Search
                  </button>
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
                  
                    $slno=1;
                    $net_amount_total=0;
                    $sql = $obj->executequery("select * from ledger_report where customer_id='$customer_id' order by bill_date desc");

                    foreach($sql as $row_get)
                    {

                      $id = $row_get['id'];
                      $net_amount = $row_get['net_amount'];
                      $bill_date = $obj->dateformatindia($row_get['bill_date']);
                      $bill_type = $row_get['bill_type'];
                      $billno = $row_get['billno'];
                      $remark = $row_get['remark'];
                      $payment_mode = $row_get['payment_mode'];
                      $bank_name =  $row_get['bank_name'];
                      $check_no =  $row_get['check_no'];
                      $sale_ids =  $row_get['sale_ids'];
                      $customer_id = $row_get['customer_id'];
                      $supplier_id = $row_get['supplier_id'];

                      $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");

                      $customer_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");

                       if($bill_type = "invoice")
                        $particular = "By Bill Entry $billno";
                        else
                        $particular = "By Receiving Entry $billno";

                      ?>
            <div class="card">
               <div class="card-content">
                  <table class="striped">
                     <tbody>
                        <tr>
                           <td><strong>Serial No.</strong></td>
                           <td class="center-align"><strong>Bill No.</strong></td>
                           <td class="right-align"><strong>Date</strong></td>
                        </tr>
                        <tr>
                           <td><?php echo $slno++; ?></td>
                           <td class="center-align"><?php echo $row_get['billno']; ?></td>
                           <td class="right-align"><?php echo $bill_date; ?></td>
                        </tr>
                        <tr>
                           <td><strong>Supplier Name</strong></td>
                           <td colspan="2" class="right-align"><?php echo $supplier_name; ?></td>
                        </tr>
                        <tr>
                           <td><strong>Particular</strong></td>
                           <td colspan="2" class="right-align"><?php echo $particular; ?></td>
                        </tr>
                        <tr>
                           <td><strong>Ledgertype</strong></td>
                           <td colspan="2" class="right-align"><?php echo $row_get['bill_type']; ?></td>
                        </tr>
                        <tr class="red lighten-5">
                           <td><strong>Amount</strong></td>
                           <td colspan="2" class="right-align"><strong>&#x20B9; <?php echo $row_get['net_amount']; ?></strong></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
           <?php 
           $net_amount_total += $row_get['net_amount'];
           } 
           ?>
            <footer class="page-footer">
               <div class="footer-copyright">
                  <div class="container">
                  <strong>Total</strong>
                  <strong class="right">&#x20B9; <?php echo number_format($net_amount_total,2); ?></strong> 
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