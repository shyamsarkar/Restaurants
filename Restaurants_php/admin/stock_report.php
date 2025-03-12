<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "stock_report.php";
$module = "Report Raw Material Stock";
$submodule = "Raw Material Stock Report";
$btn_name = "Save";
$keyvalue = 0;

if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$duplicate = "";
$crit = " where 1 = 1 ";
if (isset($_GET['from_date'])) {
  $from_date = $obj->dateformatusa($_GET['from_date']);
} else {
  $from_date = date('Y-m-d');
  $raw_id = "";
}

if (isset($_GET['raw_id'])) {

  $raw_id = $_GET['raw_id'];
  if (!empty($raw_id))
    $crit .= " and raw_id = '$raw_id' ";
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
                <th>Product Type:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                <td><input type="text" name="from_date" id="from_date" class="input-medium" style="width: 200px;" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                <td>
                  <select name="raw_id" id="raw_id" class="chzn-select" style="width:200px;">
                    <option value="">---Select---</option>
                    <?php
                    $sql3 = $obj->executequery("select * from raw_material");
                    foreach ($sql3 as $getproduct) {
                    ?>
                      <option value="<?php echo $getproduct['raw_id']; ?>"><?php echo strtoupper($getproduct['raw_name']); ?></option>
                    <?php  }
                    ?>

                  </select>
                  <script>
                    document.getElementById('raw_id').value = '<?php echo $raw_id; ?>';
                  </script>
                </td>

                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                  <a href="stock_report.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                </td>
              </tr>
            </table>
            <hr>

          </form>
          <div>
            <?php $chkview = $obj->check_pageview("stock_report.php", $loginid);
            if ($chkview == 1 || $_SESSION['usertype'] == 'admin') {  ?>

              <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_stock_report.php?from_date=<?php echo $from_date; ?>&raw_id=<?php echo $raw_id; ?>" class="btn btn-info" target="_blank">
                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a>&nbsp;<button class="btn btn-info" onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button> </p>


              <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
              <div id="mydata">
                <table class="table table-bordered" id="tblData">
                  <thead>
                    <tr>
                      <th class="head0 nosort">S.No.</th>
                      <th class="head0">Product_Name</th>
                      <th class="head0">Unit</th>
                      <th class="head0">Opening_stock(+)</th>
                      <th class="head0">Purchase(+)</th>
                      <th class="head0">Issue(+)</th>
                      <th class="head0">IssueRet(-)</th>
                      <th class="head0">Stock_In_Hand</th>
                    </tr>
                  </thead>
                  <tbody id="record">

                    <?php
                    $slno = 1;
                    $totalamt = 0;
                    $sql = "select * from raw_material $crit";
                    $res = $obj->executequery($sql);
                    $stock_in_hand = 0;
                    $open_stock = 0;
                    foreach ($res as $row_get) {

                      //$total=0;
                      $raw_id = $row_get['raw_id'];
                      $raw_name = $row_get['raw_name'];
                      $qty = $row_get['qty'];
                      $unitid = $row_get['unitid'];
                      $unit_name = $obj->getvalfield("m_unit", "unit_name", "unitid='$unitid'");


                      //count purchaseentry, sale, purchase return, sale return


                      $purchase = 0;
                      $purchasequery = "select qty from purchasentry_detail left join purchaseentry on  purchasentry_detail.purchaseid = purchaseentry.purchaseid 
                    where raw_id = '$raw_id' and purchaseentry.bill_date = '$from_date'";
                      $res = $obj->executequery($purchasequery);
                      foreach ($res as $row_get) {

                        $purchase += (float)$row_get['qty'];
                        // $purchase_ret += (float)$row_get['ret_qty'];
                      }
                      // issue and return

                      $issue = 0;
                      $issue_ret = 0;
                      $sql_issue = "select qty from issue_entry_details left join issue_entry on  issue_entry_details.issueid = issue_entry.issueid 
                           where raw_id = '$raw_id' and issue_entry.issuedate = '$from_date'";

                      // $sql_issue = "select ret_qty as issue_ret from issue_return where ret_date = '$from_date' and raw_id = '$raw_id'";


                      $res1 = $obj->executequery($sql_issue);
                      foreach ($res1 as $row_get1) {

                        //$issue = (float)$row_get1['issue'];
                        $issue += (float)$row_get['qty'];
                        //$issue_ret = (float)$row_get1['issue_ret'];
                      }





                      $issue_ret = 0;
                      $sql_issue1 = "select sum(ret_qty) as issue_ret from issue_return where ret_date = '$from_date' and raw_id = '$raw_id'";
                      $res12 = $obj->executequery($sql_issue1);
                      foreach ($res12 as $row_get12) {

                        //$issue = (float)$row_get1['issue'];
                        $issue_ret = (float)$row_get12['issue_ret'];
                      }

                      $Opening_stock = $obj->get_opening_stock($raw_id, $from_date);
                      $stock_in_hand = $Opening_stock + $purchase + $issue - $issue_ret;

                    ?>
                      <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo strtoupper($raw_name); ?></td>
                        <td><?php echo strtoupper($unit_name); ?></td>
                        <td style="text-align: right;"><?php echo $Opening_stock; ?></td>
                        <td style="text-align: right;"><?php echo $purchase; ?></td>
                        <td style="text-align: right;"><?php echo $issue; ?></td>
                        <td style="text-align: right;"><?php echo $issue_ret; ?></td>
                        <td style="text-align: right;"><?php echo $stock_in_hand; ?></td>
                      </tr>
                    <?php
                      $totalamt += $stock_in_hand;
                    }  //1st foreach loop closed

                    ?>
                  </tbody>
                </table>
              </div>
              <div class="well well-sm text">
                <h3 class="text-info text-right">Total Qty: <?php echo number_format($totalamt, 2); ?></h3>
              </div>
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

  <!-- <script>
function funDel(id)
{  //alert(id);   
	tblname = '<?php echo $tblname; ?>';
	tblpkey = '<?php echo $tblpkey; ?>';
	pagename = '<?php echo $pagename; ?>';
	submodule = '<?php echo $submodule; ?>';
	module = '<?php echo $module; ?>';
	 //alert(module); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'ajax/delete_master.php',
		  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			   location='<?php echo $pagename . "?action=3"; ?>';
			}
			
		  });//ajax close
	}//confirm close
} //fun close

</script> -->
  <script>
    jQuery('#from_date').mask('99-99-9999', {
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