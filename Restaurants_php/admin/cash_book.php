<?php include("../adminsession.php");
$pagename = "cash_book.php";
$module = "Cash Book";
$submodule = "Cash Book";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "cash_in_out";
$tblpkey = "cash_inout_id";
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
  $from_date = $obj->dateformatusa($_GET['from_date']);
  $to_date  =  $obj->dateformatusa($_GET['to_date']);
} else {
  $to_date = date('Y-m-d');
  $from_date = date('Y-m-d');
}
$crit = " where 1 and inout_date between '$from_date' and '$to_date'";
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
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
                <th>&nbsp</th>
              </tr>
              <tr>
                <td><input type="text" name="from_date" id="from_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                <td><input type="text" name="to_date" id="to_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>
                <td><a href="cash_book.php" class="btn btn-success">Reset</a></td>
              </tr>
            </table>
            <div>
          </form>
          <br>
          <p align="right" style="margin-top:7px; margin-right:10px;">
            <a href="pdf_cashbook_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" class="btn btn-info" target="_blank">
              <span style="color:#FFF">Print PDF</span></a>
            <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
          </p>
          <hr>
          <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
          <table class="table table-bordered" id="tblData">
            <thead>
              <tr>
                <th>S.No.</th>
                <th style="text-align: center;">Transaction Name</th>
                <th style="text-align: center;">Party Name</th>
                <th style="text-align: center;">Voucher No</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Time At</th>
                <th style="text-align: center;">Particular</th>
                <th style="text-align: center;">Mode</th>
                <th style="text-align: center;">Type</th>
                <th style="text-align: right;">Amount</th>
              </tr>
            </thead>
            <tbody id="record">
              <h4>Opening Balance : <?php echo $obj->opening_bal_exp_income($from_date); ?></h4>
              <?php
              $slno = 1;
              $totalamt_expence = 0;
              $totalamt_income = 0;
              $sql = "select * from cash_in_out $crit";
              $res = $obj->executequery($sql);
              foreach ($res as $row_get) {
                $cash_inout_id = $row_get['cash_inout_id'];
                $voucher_no = $row_get['voucher_no'];
                $time_at = $row_get['time_at'];
                $ex_group_id = $row_get['ex_group_id'];
                $gup_name = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id=$ex_group_id");
                $supplier_id = $row_get['supplier_id'];
                $supplier_name = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id=$supplier_id");
                $type = $row_get['type'];
                if ($type == 'cash_in') {
                  $particular = "Cash In";
                  $color = 'red';
                } else {
                  $particular = "Cash Out";
                  $color = 'green';
                }
              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td style="text-align: center;"><?php echo $gup_name; ?></td>
                  <td style="text-align: center;"><?php echo $supplier_name; ?></td>
                  <td style="text-align: center;"><?php echo $voucher_no; ?></td>
                  <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['inout_date']); ?></td>
                  <td style="text-align: center;"><?php echo $time_at; ?></td>
                  <td style="text-align: center;"><?php echo $particular; ?></td>
                  <td style="text-align: center;"><?php echo $row_get['pay_mode']; ?></td>
                  <td style="text-align: center;"><?php echo $row_get['type']; ?></td>
                  <td style="text-align: right;color: <?php echo $color; ?>"><?php echo number_format($row_get['amount'], 2); ?></td>
                </tr>
              <?php
                if ($type == 'cash_out') {
                  $totalamt_expence += $row_get['amount'];
                } else {
                  $totalamt_income += $row_get['amount'];
                }
              }
              ?>
            </tbody>
            <tr>
              <td style="text-align: right;" colspan="11">
                <h3 class="text-info text-right">Total Cash Out : <?php echo number_format($totalamt_expence, 2); ?></h3>
                <h3 class="text-info text-right">Total Cash In : <?php echo number_format($totalamt_income, 2); ?></h3>
                <h3 class="text-info text-right">Total Balance : <?php echo number_format($totalamt_income - $totalamt_expence, 2); ?></h3>
              </td>
            </tr>
          </table>
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
  </script>
</body>

</html>