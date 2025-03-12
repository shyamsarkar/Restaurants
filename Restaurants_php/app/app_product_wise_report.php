<?php
include("../adminsession.php");
$pagename = "app_product_wise_report.php";
$search_sql = "";

if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
   $from_date = $obj->dateformatusa($_GET['from_date']);
   $to_date  =  $obj->dateformatusa($_GET['to_date']);
} else {
   $to_date = date('Y-m-d');
   $from_date = date('Y-m-d');
   $productid = "";
}

$crit = " where 1 = 1 and billdate between '$from_date' and '$to_date'";



if (isset($_GET['productid'])) {

   $productid = $_GET['productid'];
   if (!empty($productid))
      $crit .= " and bill_details.productid = '$productid'";
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

      td,
      th {
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

      .pointer {
         cursor: pointer;
      }
   </style>
</head>

<body class="">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
   <div class="container" style="width:100%;"><br>
      <div class="row" style="margin-bottom:0px;">
         <form class="col m6 offset-m3 s12">
            <div class="row" style="margin-bottom:0px;">
               <div class="input-field col s12">
                  <select name="productid" id="productid" class="js-example-basic-single browser-default">
                     <option value="">--All--</option>
                     <?php
                     $res = $obj->executequery("select * from m_product order by prodname");

                     foreach ($res as $row_get) {
                     ?>
                        <option value="<?php echo $row_get['productid'];  ?>"> <?php echo $row_get['prodname']; ?></option>
                     <?php } ?>
                  </select>
                  <script>
                     document.getElementById('productid').value = '<?php echo $productid; ?>';
                  </script>
                  </select>
                  <label class="active">Product Name </label>
               </div>
               <div class="input-field col s6">
                  <input type="text" name="from_date" id="from_date" value="<?php echo $obj->dateformatindia($from_date); ?>" class="datepicker">
                  <label>From Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s6">
                  <input type="text" name="to_date" id="to_date" value="<?php echo $obj->dateformatindia($to_date); ?>" class="datepicker">
                  <label>To Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s6 offset-s3">
                  <button class="btn waves-effect waves-light" type="submit" name="search" onClick="return checkinputmaster('from_date,to_date'); " value="Search" style="width: 100%;">Search<i class="material-icons right">search</i>
                  </button>
               </div>
               <!-- <div class="input-field col s6">
                  <a class="waves-effect waves-light red btn" href="../admin/pdf_total_sale_report.php?fromdate=<?php echo $from_date; ?>&todate=<?php echo $to_date; ?>" style="width: 100%;" target="_blank" class="pointer"><i class="material-icons right">print</i>print</a>
               </div> -->
            </div>
         </form>
      </div>

      <div class="row">
         <div class="col m6 offset-m3 s12">
            <blockquote>
               <h6>Product Wise Sale Report List</h6>
            </blockquote>

            <?php
            $slno = 1;
            $totalamt = 0;
            $grand_tot = 0;

            $sql = "Select sum(bill_details.qty) as totqty, sum(bill_details.qty*bill_details.rate) as totamt, bill_details.productid ,bills.billdate from bill_details left join bills on bills.billid = bill_details.billid $crit group by bill_details.productid";
            $res = $obj->executequery($sql);
            foreach ($res as $row_get) {
               $totqty = $row_get['totqty'];
               $productid = $row_get['productid'];
               $totamt = $row_get['totamt'];
               $grand_tot += $totamt;
               $prodname = $obj->getvalfield("m_product", "prodname", "productid='$productid'");

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
                              <td>Product Name</td>
                              <td class="right-align"><?php echo $prodname; ?></td>
                           </tr>

                           <tr>
                              <td>Date</td>
                              <td class="right-align"><?php echo $obj->dateformatindia($row_get['billdate']); ?></td>
                           </tr>

                           <tr>
                              <td>Total Qty</td>
                              <td class="right-align"><?php echo $totqty; ?></td>
                           </tr>
                           <tr>
                              <td>Total Amount</td>
                              <td class="right-align"><?php echo number_format(round($totamt), 2); ?></td>
                           </tr>
                           <tr>
                              <td class="center" colspan="2">
                                 <button type="button" class="btn blue white-text" onClick="show_viewdetails_modal('<?php echo $row_get['productid']; ?>');">View Details</button>
                                 <!-- <a class="btn btn-success btn-small"  >
                           <strong> View Details </strong></a> -->
                              </td>
                           </tr>

                           <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                           Open modal
                        </button> -->

                        </tbody>
                     </table>
                  </div>
               </div>
            <?php
               $totalamt += $totamt;
            }
            ?>

            <footer class="page-footer">
               <div class="footer-copyright">
                  <table>
                     <tr>
                        <th>Total Amount</th>
                        <th class="right-align"><?php echo number_format($totalamt, 2); ?></th>
                     </tr>
                  </table>
               </div>
            </footer>
         </div>
      </div>
   </div>

   <!-- The Modal -->
   <div id="modal1" class="modal" style="width: 100%;height:100%;max-height:100%;">
      <div class="modal-content" style="padding: 5px 10px;">
         <h5><a href="#!" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons">keyboard_backspace</i></a> View Product Details</h5>
         <table class="striped white">
            <thead>
               <th>Bill No.</th>
               <th>Product Details</th>
               <th>Qty</th>
               <th>Table Details</th>
            </thead>
            <tbody>
            <tbody id="showprodetails">

            </tbody>

            </tbody>
         </table>

         <div class="modal-footer">
            <center> <button data-dismiss="modal" value="Close" class="btn btn-danger modal-close waves-effect waves-green btn-flat" style="color: white;">Close</button></center>
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
      $('.modal').modal({
         endingTop: '0%'
      });

      function show_viewdetails_modal(productid) {


         $('#modal1').modal('open');
         var from_date = document.getElementById('from_date').value;
         var to_date = document.getElementById('to_date').value;



         jQuery.ajax({

            type: 'POST',

            url: 'app_ajax_show_productdetails_view.php',

            data: 'productid=' + productid + '&from_date=' + from_date + '&to_date=' + to_date,

            dataType: 'html',

            success: function(data) {

               // alert(data);

               jQuery('#showprodetails').html(data);


            }

         }); //ajax close

      }
   </script>
</body>

</html>