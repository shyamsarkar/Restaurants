<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "stock_report_new.php";
$module = "Report Finished Good Stock";
$submodule = "Finished Good Stock Report";
$btn_name = "Save";
$keyvalue = 0;

if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$duplicate = "";
$crit = " where 1=1 ";


if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
  $from_date = $obj->dateformatusa($_GET['from_date']);
  $to_date  =  $obj->dateformatusa($_GET['to_date']);
} else {
  $to_date = date('Y-m-d');
  $from_date = date('Y-m-d');
  $pcatid = "";
}

if (isset($_GET['pcatid'])) {

  $pcatid = $_GET['pcatid'];
  if (!empty($pcatid))
    $crit .= " and pcatid = '$pcatid' ";
}

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

          <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                <th>From Date:</th>
                <th>To Date:</th>
                <!-- <th>Menu Item Name:</th> -->
                <th>Menu Heading Name:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                <td><input type="text" name="from_date" id="from_date" class="input-medium" style="width: 200px;" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                <td><input type="text" name="to_date" id="to_date" class="input-medium" style="width: 200px;" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                <td>
                  <select name="pcatid" id="pcatid" class="chzn-select" style="width:200px;">
                    <option value="">---All---</option>
                    <?php
                    $crow = $obj->executequery("select * from m_product_category");
                    foreach ($crow as $cres) {

                    ?>
                      <option value="<?php echo $cres['pcatid']; ?>"> <?php echo $cres['catname']; ?></option>
                    <?php
                    }

                    ?>

                  </select>
                  <script>
                    document.getElementById('pcatid').value = '<?php echo $pcatid; ?>';
                  </script>
                </td>

                <td><input type="submit" name="search" class="btn btn-success" value="Search" onClick="return checkinputmaster('from_date,to_date');">
                  <a href="stock_report_new.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <hr>

          </form>
          <div>
            <?php $chkview = $obj->check_pageview("stock_report_new.php", $loginid);
            if ($chkview == 1 || $loginid == 1) {  ?>

              <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_finished_good_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&pcatid=<?php echo $pcatid; ?>" class="btn btn-info" target="_blank">
                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a>&nbsp;<button class="btn btn-info" onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> </p>
              <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> 
             <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> 
             </p> -->

              <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
              <div id="mydata">
                <table class="table table-bordered table-hover table-striped" id="tblData">
                  <thead>
                    <tr>
                      <th class="head0 nosort">S.No.</th>
                      <th class="head0">Product_Name</th>
                      <th class="head0">Unit</th>
                      <th class="head0">Opening_stock(+)</th>
                      <th class="head0">Purchase_entry(+)</th>
                      <th class="head0">Production(+)</th>
                      <th class="head0">Adjustment(+)</th>
                      <th class="head0">Adjustment(-)</th>
                      <th class="head0">Wastage(-)</th>
                      <th class="head0">Sale(-)</th>
                      <th class="head0">Stock_In_Hand</th>
                    </tr>
                  </thead>
                  <tbody id="record">

                    <?php
                    $slno = 1;
                    $totalamt = 0;
                    $totOpening_stock = 0;
                    $totpurchase_qty = 0;
                    $totproduction_qty = 0;
                    $totadjustment_qty_plus = 0;
                    $totadjustment_qty_minus = 0;
                    $totwastage_qty = 0;
                    $totsale_qty = 0;
                    if ($pcatid > 0) {
                      $sql = "select * from m_product where pcatid = '$pcatid'";
                      //$sql = "select * from m_product $crit";
                    } else {
                      $sql = "select * from m_product";
                    }

                    $res = $obj->executequery($sql);
                    $stock_in_hand = 0;
                    $open_stock = 0;
                    foreach ($res as $row_get) {

                      //$total=0;
                      $productid = $row_get['productid'];
                      $prodname = $row_get['prodname'];
                      $qty = $row_get['qty'];
                      $unitid = $row_get['unitid'];
                      $unit_name = $obj->getvalfield("m_unit", "unit_name", "unitid='$unitid'");



                      //count purchase entry
                      $purchase_qty = 0;
                      $purchaseentry = "select qty from purchasentry_detail left join purchaseentry on purchasentry_detail.purchaseid = purchaseentry.purchaseid 
                    where productid = '$productid' and purchaseentry.bill_date between '$from_date' and '$to_date'";


                      $res = $obj->executequery($purchaseentry);
                      foreach ($res as $row_get) {

                        $purchase_qty += (float)$row_get['qty'];
                      }


                      //count production
                      $production_qty = 0;
                      $productionquery = "select production_qty from production_entry where productid = '$productid' and production_date between '$from_date' and '$to_date'";

                      $res = $obj->executequery($productionquery);
                      foreach ($res as $row_get) {

                        $production_qty += (float)$row_get['production_qty'];
                      }

                      //count adjustment plus
                      $adjustment_qty_plus = 0;
                      $adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'plus' and adjustment_date between '$from_date' and '$to_date'";

                      $res = $obj->executequery($adjustmentquery);
                      foreach ($res as $row_get) {

                        $adjustment_qty_plus += (float)$row_get['adjustment_qty'];
                      }

                      //count adjustment minus
                      $adjustment_qty_minus = 0;
                      $adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'minus' and adjustment_date between '$from_date' and '$to_date'";

                      $res = $obj->executequery($adjustmentquery);
                      foreach ($res as $row_get) {

                        $adjustment_qty_minus += (float)$row_get['adjustment_qty'];
                      }

                      //     //count wastage
                      $wastage_qty = 0;
                      $wastagequery = "select wastage_qty from wastage_entry where productid = '$productid' and wastage_date between '$from_date' and '$to_date'";

                      $res = $obj->executequery($wastagequery);
                      foreach ($res as $row_get) {

                        $wastage_qty += (float)$row_get['wastage_qty'];
                      }

                      // //count sale
                      $sale_qty = 0;
                      $salequery = "select qty from bill_details left join bills on bill_details.billid = bills.billid 
                    where productid = '$productid' and bills.billdate between '$from_date' and '$to_date'";
                      $res = $obj->executequery($salequery);
                      foreach ($res as $row_get) {

                        $sale_qty += (float)$row_get['qty'];
                      }


                      $Opening_stock = $obj->get_opening_stock_for_finished($productid, $from_date);
                      $stock_in_hand = $Opening_stock + $purchase_qty + $adjustment_qty_plus - $adjustment_qty_minus + $production_qty - $wastage_qty - $sale_qty;

                    ?>
                      <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo strtoupper($prodname); ?></td>
                        <td><?php echo strtoupper($unit_name); ?></td>
                        <td style="text-align: right;"><?php echo $Opening_stock; ?></td>
                        <td style="text-align: right;"><?php echo $purchase_qty; ?></td>
                        <td style="text-align: right;"><?php echo $production_qty; ?></td>
                        <td style="text-align: right;"><?php echo $adjustment_qty_plus; ?></td>
                        <td style="text-align: right;"><?php echo $adjustment_qty_minus; ?></td>

                        <td style="text-align: right;"><?php echo $wastage_qty; ?></td>
                        <td style="text-align: right;"><?php echo $sale_qty; ?></td>
                        <td style="text-align: right;"><?php echo $stock_in_hand; ?></td>
                      </tr>
                    <?php
                      $totOpening_stock += $Opening_stock;
                      $totpurchase_qty += $purchase_qty;
                      $totproduction_qty += $production_qty;
                      $totadjustment_qty_plus += $adjustment_qty_plus;
                      $totadjustment_qty_minus += $adjustment_qty_minus;
                      $totwastage_qty += $wastage_qty;
                      $totsale_qty += $sale_qty;
                      $totalamt += $stock_in_hand;
                    }  //1st foreach loop closed

                    ?>
                  </tbody>

                  <tr>
                    <th class="head0 nosort" colspan="3"></th>

                    <th class="head0">Opening_stock(+)</th>
                    <th class="head0">Purchase_entry(+)</th>
                    <th class="head0">Production(+)</th>
                    <th class="head0">Adjustment(+)</th>
                    <th class="head0">Adjustment(-)</th>
                    <th class="head0">Wastage(-)</th>
                    <th class="head0">Sale(-)</th>
                    <th class="head0">Stock_In_Hand</th>
                  </tr>

                  <tr>
                    <th class="head0 nosort" colspan="3">Total : </th>
                    <th class="head0" style="text-align: right;"><?php echo $totOpening_stock; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totpurchase_qty; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totproduction_qty; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totadjustment_qty_plus; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totadjustment_qty_minus; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totwastage_qty; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totsale_qty; ?></th>
                    <th class="head0" style="text-align: right;"><?php echo $totalamt; ?></th>

                  </tr>
                </table>
              </div>
              <!--  <div class="well well-sm text"><h3 class="text-info text-right">Total Qty: <?php //echo number_format($totalamt,2); 
                                                                                                ?></h3></div> -->
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


  <script>
    jQuery('#from_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#to_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#from_date').focus();



    function exportTableToExcel(tableID, filename = '') {
      var downloadLink;
      var dataType = 'application/vnd.ms-excel';
      var tableSelect = document.getElementById(tableID);
      var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

      // Specify file name
      filename = filename ? filename + '.xls' : 'excel_data.xls';

      // Create download link element
      downloadLink = document.createElement("a");

      document.body.appendChild(downloadLink);

      if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
      } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
      }
    }
  </script>
</body>

</html>