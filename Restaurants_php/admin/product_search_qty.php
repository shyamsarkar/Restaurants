<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "product_search_qty.php";
$module = "Report Search Product Qty Ledger";
$submodule = "Search Product Qty Ledger Report";
$btn_name = "Save";
$keyvalue = 0;
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$duplicate = "";
$crit = " where 1 = 1 ";
if (isset($_GET['productid'])) {
  $productid  = $_GET['productid'];
  $crit .= " and productid = '$productid'";
} else {
  $productid = 0;
}
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <script type="text/javascript">
    function getid(productid) {
      location = 'product_search_qty.php?productid=' + productid;
    }
  </script>
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
                <th>Product Name:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                <td>
                  <select name="productid" id="productid" class="chzn-select" onchange="getid(this.value);">
                    <option value="">--All--</option>
                    <?php
                    $slno = 1;

                    $res = $obj->executequery("select * from m_product");
                    foreach ($res as $row_get) {
                    ?>
                      <option value="<?php echo $row_get['productid'];  ?>"> <?php echo $row_get['prodname']; ?></option>
                    <?php } ?>
                  </select>
                  <script>
                    document.getElementById('productid').value = '<?php echo $productid; ?>';
                  </script>
                </td>
                <td>
                  <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <hr>
            <div>
          </form>
          <?php $chkview = $obj->check_pageview("product_search_qty.php", $loginid);
          if ($chkview == 1 || $_SESSION['usertype'] == 'admin') {  ?>
            <?php if ($productid > 0) { ?>
              <p align="right" style="margin-top:7px; margin-right:10px;">
                <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
              </p>
              <?php
              //show if customer selected
              if ($productid > 0) {
                $slno = 1;
                $arrayName = array();
                $opening_stock_master = "select * from finished_goods_opening_stock $crit";
                $res = $obj->executequery($opening_stock_master);
                foreach ($res as $row_get) {
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
                  $opening_stock = $row_get['finish_opening_qty'];
                  $bill_date =  $row_get['finish_opening_date'];
                  $particular = "By Opening Balance";
                  $arrayName[] = array('led_date' => $bill_date, 'product_name' => $product_name, 'particular' => $particular, 'billtype' => 'Opening Balance', 'total' => $opening_stock, 'led_type' => 'debit');
                  // echo "<pre>";
                  // print_r($arrayName);die;
                }
                // sale entry qty
                $sql2 = "select qty,billdate,billnumber from bill_details left join bills on  bill_details.billid = bills.billid $crit and bill_details.billid!=0";
                $res2 = $obj->executequery($sql2);
                foreach ($res2 as $row_get2) {
                  // $purchaseid = $row_get['purchaseid'];
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
                  $sale_qty = $row_get2['qty'];
                  $bill_date = $row_get2['billdate'];
                  $billno = $row_get2['billnumber'];
                  $particular = "By sale entry $billno";
                  if ($sale_qty > 0) {
                    $arrayName[] = array('led_date' => $bill_date, 'product_name' => $product_name, 'particular' => $particular, 'billtype' => 'sale entry', 'total' => $sale_qty, 'led_type' => 'credit');
                  }
                }
                // waste entry qty
                $sql2 = "select wastage_qty,wastage_date from wastage_entry $crit";
                $res2 = $obj->executequery($sql2);
                foreach ($res2 as $row_get2) {
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
                  $wastage_qty = $row_get2['wastage_qty'];
                  $bill_date = $row_get2['wastage_date'];
                  $particular = "By wastage entry";
                  if ($wastage_qty > 0) {
                    $arrayName[] = array('led_date' => $bill_date, 'product_name' => $product_name, 'particular' => $particular, 'billtype' => 'wastage entry', 'total' => $wastage_qty, 'led_type' => 'credit');
                  }
                }
                // count adjustment plus qty
                $sql2 = "select adjustment_qty,adjustment_date from adjustment_entry $crit and type = 'plus'";
                $res2 = $obj->executequery($sql2);
                foreach ($res2 as $row_get2) {
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
                  $adjustment_qty = $row_get2['adjustment_qty'];
                  $bill_date = $row_get2['adjustment_date'];
                  $particular = "By adjustment plus entry";
                  if ($adjustment_qty > 0) {
                    $arrayName[] = array('led_date' => $bill_date, 'product_name' => $product_name, 'particular' => $particular, 'billtype' => 'adjustment plus entry', 'total' => $adjustment_qty, 'led_type' => 'debit');
                  }
                }
                // count adjustment plus qty
                $sql2 = "select adjustment_qty,adjustment_date from adjustment_entry $crit and type = 'minus'";
                $res2 = $obj->executequery($sql2);
                foreach ($res2 as $row_get2) {
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
                  $adjustment_qty = $row_get2['adjustment_qty'];
                  $bill_date = $row_get2['adjustment_date'];
                  $particular = "By adjustment minus entry";
                  if ($adjustment_qty > 0) {
                    $arrayName[] = array('led_date' => $bill_date, 'product_name' => $product_name, 'particular' => $particular, 'billtype' => 'adjustment minus entry', 'total' => $adjustment_qty, 'led_type' => 'credit');
                  }
                }
                // //count adjustment plus
                // $adjustment_qty_plus = 0;
                // $adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'plus' and adjustment_date between '$from_date' and '$to_date'";
                // $res = $obj->executequery($adjustmentquery);
                // foreach($res as $row_get)
                // {

                //     $adjustment_qty_plus += (float)$row_get['adjustment_qty'];

                // }
                // //count adjustment minus
                // $adjustment_qty_minus = 0;
                // $adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'minus' and adjustment_date between '$from_date' and '$to_date'";
                // $res = $obj->executequery($adjustmentquery);
                // foreach($res as $row_get)
                // {

                //     $adjustment_qty_minus += (float)$row_get['adjustment_qty'];

                // }

                //production
                $qty_production = 0;
                $sql_production = "select * from production_entry $crit";
                $res1 = $obj->executequery($sql_production);
                foreach ($res1 as $row_get1) {
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
                  $qty_production = $row_get1['production_qty'];
                  $bill_date = $row_get1['production_date'];
                  $particular = "By Production Entry";
                  if ($qty_production > 0) {
                    $arrayName[] = array('led_date' => $bill_date, 'product_name' => $product_name, 'particular' => $particular, 'billtype' => 'Production Entry', 'total' => $qty_production, 'led_type' => 'debit');
                  }
              ?>
                <?php
                }
                ?>
              <?php
              }
              function date_compare($a, $b)
              {
                $t1 = strtotime($a['led_date']);
                $t2 = strtotime($b['led_date']);
                return $t1 - $t2;
              }
              usort($arrayName, 'date_compare');
              //echo "<pre>";
              //print_r($arrayName);
              ?>
              <br>
              <?php if (isset($productid) != '') {
              ?>

                <br>
                <table class="table table-bordered" id="tblData">

                  <tr>
                    <td>Slno</td>
                    <td>Date</td>
                    <td>Product Name</td>
                    <td>Particular</td>
                    <td>Ledgertype</td>
                    <td>(+)</td>
                    <td>(-)</td>
                    <td>Balance Qty</td>
                  </tr>
                  <?php
                  $balance = 0;
                  $total_debit = 0;
                  $total_credit = 0;
                  $total_balance = 0;
                  foreach ($arrayName as $key) {
                    if ($key['led_type'] == 'debit') {
                      $credit = 0;
                      $debit = $key['total'];
                      $total_debit +=  $debit;
                    } else {
                      $debit = 0;
                      $credit = $key['total'];
                      $total_credit += $credit;
                    }
                    $balance +=  $debit - $credit;
                  ?>
                    <tr>
                      <td><?php echo $slno++; ?></td>
                      <td><?php echo $obj->dateformatindia($key['led_date']); ?></td>
                      <td><?php echo $key['product_name']; ?></td>
                      <td><?php echo $key['particular']; ?></td>
                      <td><?php echo $key['billtype']; ?></td>
                      <td><?php echo $debit; ?></td>
                      <td><?php echo $credit; ?></td>
                      <td><?php echo $balance; ?></td>
                    </tr>
                  <?php
                  } //close foreach loop
                  ?>
                  <tr>
                    <td colspan="5">Total : </td>
                    <td><?php echo $total_debit; ?></td>
                    <td><?php echo $total_credit; ?></td>
                    <td>Balance: <?php echo ($total_debit - $total_credit); ?></td>
                  </tr>
                </table>
          <?php }
            } //if close (most outer if)
          } //closed privilage
          ?>
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
  <script type="text/javascript">
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