<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "supplier_ledger.php";
$module = "Report Supplier Ledger";
$submodule = "Supplier Ledger Report";
$btn_name = "Save";
$keyvalue = 0;


if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$duplicate = "";

$crit = " where 1 = 1 ";
if (isset($_GET['supplier_id'])) {
  $supplier_id = $_GET['supplier_id'];
  if (!empty($supplier_id))
    $crit .= " and supplier_id = '$supplier_id'";
} else {
  $supplier_id = 0;
}


$supplier_name = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id='$supplier_id'");
$mobile = $obj->getvalfield("master_supplier", "mobile", "supplier_id='$supplier_id'");
$address = $obj->getvalfield("master_supplier", "address", "supplier_id='$supplier_id'");
$gstno = $obj->getvalfield("master_supplier", "gstno", "supplier_id='$supplier_id'");

?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <script type="text/javascript">
    function getid(supplier_id) {
      location = 'supplier_ledger.php?supplier_id=' + supplier_id;
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
                <th>Supplier Name:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                <td>
                  <select name="supplier_id" id="supplier_id" class="chzn-select" onchange="getid(this.value);">
                    <option value="">--All--</option>
                    <?php
                    $slno = 1;
                    $res = $obj->executequery("select * from master_supplier");

                    foreach ($res as $row_get) {
                    ?>
                      <option value="<?php echo $row_get['supplier_id'];  ?>"> <?php echo $row_get['supplier_name']; ?></option>
                    <?php } ?>
                  </select>
                  <script>
                    document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>';
                  </script>
                </td>
                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                  <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <hr>

          </form>
          <div>
            <?php $chkview = $obj->check_pageview("supplier_ledger.php", $loginid);
            if ($chkview == 1 || $_SESSION['usertype'] == 'admin') {  ?>


              <?php if ($supplier_id > 0) { ?>
                <p align="right" style="margin-top:7px; margin-right:10px;">
                  <!-- <button id="tblData1">Print PDF</button> -->

                  <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
                </p>


                <?php
                //show if customer selected
                if ($supplier_id > 0) {

                  $slno = 1;
                  $arrayName = array();

                  $sql = $obj->executequery("select * from master_supplier $crit");
                  foreach ($sql as $row_get) {
                    $openingbal = $row_get['openingbal'];
                    $open_bal_date = $row_get['open_bal_date'];
                    $particular = "Opening Balance";

                    $arrayName[] = array('led_date' => $open_bal_date, 'particular' => $particular, 'billtype' => 'openingbal', 'total' => $openingbal, 'led_type' => 'debit', 'Disc_amt' => 0);
                    //echo "<pre>";
                    //print_r($arrayName);die;

                  }

                  $sql = $obj->executequery("select * from purchaseentry $crit and type = 'purchaseentry'");

                  $total_disc = 0;
                  foreach ($sql as $row_get) {
                    $purchaseid = $row_get['purchaseid'];
                    $net_amount = $row_get['net_amount'];
                    $bill_date = $row_get['bill_date'];
                    $billno = $row_get['billno'];
                    $particular = "By purchaseentry Entry $billno";
                    $bill_disc = $obj->get_total_discamt_on_bill($purchaseid);
                    $total_disc += $bill_disc;
                    $discount = $obj->get_total_discamt_on_bill($purchaseid);

                    $net_amt = $net_amount - $discount;


                    $arrayName[] = array('led_date' => $bill_date, 'particular' => $particular, 'billtype' => 'saleentry', 'total' => round($net_amt), 'led_type' => 'debit', 'Disc_amt' => $bill_disc);
                  }

                  $sql = $obj->executequery("select * from supplier_payment $crit");
                  foreach ($sql as $row_get) {
                    $pay_date = $row_get['pay_date'];
                    $voucher_no = $row_get['voucher_no'];
                    $paid_amt = $row_get['paid_amt'];
                    $payment_type = $row_get['payment_type'];
                    if ($payment_type == 'Received') {
                      $led_type = 'credit';
                    } else {
                      $led_type = 'debit';
                    }

                    if ($payment_type == 'Received') {
                      $vou_type = 'Received';
                    } else {
                      $vou_type = 'Payment';
                    }

                    $particular = "By voucher Entry $voucher_no ($vou_type)";

                    $arrayName[] = array('led_date' => $pay_date, 'particular' => $particular, 'billtype' => 'voucher', 'total' => $paid_amt, 'led_type' => $led_type, 'Disc_amt' => 0);

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
                //id="tblData"
                ?>
                <br>
                <?php if (isset($supplier_id) != '') {
                ?>
                  <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                  <div id="ele1">

                    <table class="table table-bordered" id="tblData">
                      <tr>
                        <td>
                          <table class="table table-bordered">
                            <tr>
                              <th colspan="8" style="text-align: center;"><?php echo $submodule; ?></th>
                            </tr>

                            <tr>
                              <td colspan="7">Name : <?php echo $supplier_name; ?></td>
                            </tr>
                            <tr>
                              <td colspan="7">Mobile : <?php echo $mobile; ?></td>
                            </tr>
                            <tr>
                              <td colspan="7">GST No. : <?php echo $gstno; ?></td>
                            </tr>
                            <tr>
                              <td colspan="7">Address : <?php echo $address; ?></td>
                            </tr>

                            <tr>
                              <td>Slno</td>
                              <td>Date</td>
                              <td>Particular</td>
                              <td>Ledgertype</td>
                              <td style="text-align: right;">Total Disc</td>
                              <td style="text-align: right;">Debit</td>
                              <td style="text-align: right;">Credit</td>
                              <td style="text-align: right;">Balance</td>
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
                                <td><?php echo $key['particular']; ?></td>
                                <td><?php echo $key['billtype']; ?></td>
                                <td style="text-align: right;"><?php echo $key['Disc_amt']; ?></td>
                                <td style="text-align: right;"><?php echo number_format($debit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($credit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($balance, 2); ?></td>
                              </tr>
                            <?php
                            } //close foreach loop
                            ?>
                            <tr>
                              <td colspan="4">Total : </td>
                              <td style="text-align: right;"><?php echo number_format($total_disc, 2); ?></td>
                              <td style="text-align: right;"><?php echo number_format($total_debit, 2); ?></td>
                              <td style="text-align: right;"><?php echo number_format($total_credit, 2); ?></td>
                              <td style="text-align: right;">Balance: <?php echo number_format(($total_debit - $total_credit), 2); ?></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>

            <?php }
              } //if close (most outer if)

            } // privilage close
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


    function printData() {
      var divToPrint = document.getElementById("tblData");
      newWin = window.open("");
      newWin.document.write(divToPrint.outerHTML);
      newWin.print();
      newWin.close();
    }

    jQuery('#tblData1').on('click', function() {
      printData();
    })
  </script>
</body>

</html>