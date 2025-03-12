<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "cash_book_report.php";
$module = "Cash Book Report";
$submodule = "Cash Book Report";
$btn_name = "Save";
$keyvalue = 0;

if (isset($_GET['action']))
    $action = addslashes(trim($_GET['action']));
else
    $action = "";
$duplicate = "";
$crit = " where 1 = 1 ";


if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
} else {
    $to_date = date('Y-m-d');
    $from_date = date('Y-m-d');
}

$crit = " where 1 = 1 and inout_date between '$from_date' and '$to_date'";
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
                                <th>&nbsp</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="from_date" id="from_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                                <td><input type="text" name="to_date" id="to_date" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                                <td><input type="submit" name="search" class="btn btn-success" value="Search">
                                    <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <div>
                    </form>
                    <p align="right" style="margin-top:7px; margin-right:10px;">
                        <button onclick="exportTableToExcel('tblData')">Export Table Data To Excel File</button>
                    </p>

                    <?php

                    $slno = 1;
                    $arrayName = array();

                    $sql = $obj->executequery("select * from cash_in_out $crit and type = 'cash_out'");


                    foreach ($sql as $row_get) {

                        $voucher_no = $row_get['voucher_no'];
                        $time_at = $row_get['time_at'];

                        $supplier_id = $row_get['supplier_id'];
                        $supplier_name = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id=$supplier_id");
                        $type = $row_get['type'];
                        $pay_mode = $row_get['pay_mode'];
                        $inout_date = $row_get['inout_date'];

                        $ex_group_id = $row_get['ex_group_id'];

                        $ex_groupname = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id='$ex_group_id'");
                        $amount = $row_get['amount'];
                        $particular = "By Cash Out ( $voucher_no )";

                        $arrayName[] = array('led_date' => $inout_date, 'particular' => $particular, 'total' => $amount, 'led_type' => 'debit', 'ex_groupname' => $ex_groupname, 'supplier_name' => $supplier_name, 'time_at' => $time_at, 'pay_mode' => $pay_mode);
                    }


                    $sql = $obj->executequery("select * from cash_in_out $crit and type = 'cash_in'");
                    foreach ($sql as $row_get) {
                        $inout_date = $row_get['inout_date'];

                        $amount = $row_get['amount'];
                        $voucher_no = $row_get['voucher_no'];
                        $time_at = $row_get['time_at'];
                        $pay_mode = $row_get['pay_mode'];
                        $supplier_id = $row_get['supplier_id'];
                        $supplier_name = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id=$supplier_id");
                        $ex_group_id = $row_get['ex_group_id'];
                        $ex_groupname = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id='$ex_group_id'");

                        $particular = "By Cash In ( $voucher_no )";

                        $arrayName[] = array('led_date' => $inout_date, 'particular' => $particular, 'total' => $amount, 'led_type' => 'credit', 'ex_groupname' => $ex_groupname, 'supplier_name' => $supplier_name, 'time_at' => $time_at, 'pay_mode' => $pay_mode);

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



                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

                    <table class="table table-bordered" id="tblData">
                        <tr>
                            <td>Slno</td>
                            <td>Date</td>
                            <th>Time At</th>
                            <th>Transaction Name</th>
                            <th>Party Name</th>
                            <th>Mode</th>
                            <td>Particular</td>
                            <td>Debit</td>
                            <td>Credit</td>
                            <td>Balance</td>
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
                                <td><?php echo $key['time_at']; ?></td>
                                <td><?php echo $key['ex_groupname']; ?></td>
                                <td><?php echo $key['supplier_name']; ?></td>
                                <td><?php echo $key['pay_mode']; ?></td>
                                <td><?php echo $key['particular']; ?></td>

                                <td style="text-align: right;"><?php echo number_format($debit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($credit, 2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($balance, 2); ?></td>
                            </tr>
                        <?php
                        } //close foreach loop
                        ?>
                        <tr>
                            <td colspan="7">Total : </td>
                            <td style="text-align: right;"><?php echo number_format($total_debit, 2); ?></td>
                            <td style="text-align: right;"><?php echo number_format($total_credit, 2); ?></td>
                            <td style="text-align: right;">Balance: <?php echo number_format(($total_debit - $total_credit), 2); ?></td>
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