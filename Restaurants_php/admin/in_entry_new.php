<?php include("../adminsession.php");
$pagename = "in_entry_new.php";
$module = "Bill Entry";
$submodule = "Bill Entry";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "bill_details";
$tblpkey = "billdetailid";
$paydate = $obj->get("day_close", "day_date", "1=2");
$sgst = "";
$cgst = "";
$net_bill_amt = "";
if (isset($_GET['floor_id']) && !empty($_GET['floor_id'])) {
  $floor_id = $obj->test($_GET['floor_id']);
  $floor_name = $obj->getvalfield("m_floor", "UPPER(floor_name)", "floor_id='$floor_id'");
} else {
  $floor_id = 0;
  $floor_name = 0;
}
$parcel_status = 0;
$parcel_id = 0;
if (isset($_GET['table_id'])) {
  $table_id = $obj->test($_GET['table_id']);
  $table_no = $obj->getvalfield("m_table", "UPPER(table_no)", "table_id='$table_id'");
  $table_no1 = $obj->getvalfield("m_table", "UPPER(table_no)", "table_id='$table_id'");
  $parcel_type = $obj->getvalfield("m_table", "UPPER(parcel_type)", "table_id='$table_id'");
  $check_trans_table = $obj->getvalfield("bill_details", "billid", "table_id='$table_id' and isbilled=0");
  //for opening zomoto swiggy order modal
  $parcel_status = $obj->getvalfield("m_table", "parcel_status", "table_id='$table_id'");
  if ($parcel_status  > 0)
    $parcel_id = $obj->getvalfield("parcel_order", "parcel_id", "table_id='$table_id' and close_order=0");
  else
    $parcel_id = 0;
  //order by CAPTAIN STEWARD order modal
  $cap_stw_id = $obj->getvalfield("cap_stw_table", "cap_stw_id", "table_id='$table_id' and close_order=0");
  $waiter_id_cap = $obj->getvalfield("cap_stw_table", "waiter_id_cap", "table_id='$table_id'");
  $waiter_id_stw = $obj->getvalfield("cap_stw_table", "waiter_id_stw", "table_id='$table_id'");
  $captain_name = $obj->getvalfield("m_waiter", "waiter_name", "waiter_id='$waiter_id_cap'");
  $steward_name = $obj->getvalfield("m_waiter", "waiter_name", "waiter_id='$waiter_id_stw'");
  //$capstw_save_table = $obj->getvalfield("cap_stw_table","billid","table_id='$table_id' and close_order = 0");
  $floor_id = $obj->getvalfield("m_table", "floor_id", "table_id='$table_id'");
  $floor_name = $obj->getvalfield("m_floor", "floor_name", "floor_id='$floor_id'");
  $billid = $obj->getvalfield("bills", "billid", "table_id='$table_id' and is_paid = 0");
  if ($billid == "")
    $billid = 0;
} else {
  $table_id = "";
  $table_no = "";
  $table_no1 = '';
  $floor_name = "";
  $check_trans_table = '';
  $cap_stw_id = '';
  $captain_name = "";
  $steward_name = '';
  $waiter_id_cap = '';
  $waiter_id_stw = '';
  $parcel_type = '';
}
if (isset($_GET['action']))
  $action = $obj->test($_GET['action']);
else
  $action = "";
$duplicate = "";
$paymode1 = "cash";
$paymode2 = "card_mode";
$paymode3 = "paytm";
?>
<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    div.scrollmenu {
      overflow: auto;
      white-space: nowrap;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      padding: 5px;
    }

    div.scrollmenu button {
      display: inline-block;
    }

    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      padding: 10px;
      min-height: 635px;
    }

    hr.rounded {
      border-top: 3px solid #bbb;
      margin: 5px 0 10px !important;
      width: 50%;
    }

    hr.solid {
      border-top: 1px solid #ddd;
      margin: 6px 0px;
    }

    .adjust {
      margin: 5px 0px;
    }

    .autooverflow {
      height: 500px;
      overflow: auto;
    }

    .control {
      min-height: 22px !important;
    }

    h5 {
      font-family: 'sans-serif';
    }

    .net-amount {
      background-color: blanchedalmond;
      text-align: right;
      font-weight: 800;
      font-size: 13px;
    }

    .mr-b {
      margin-bottom: 10px;
    }

    .table-condensed td {
      padding: 4px 0px;
    }

    .btn {
      padding: 4px 10px;
    }

    .btn:focus {
      outline: none !important;
      border: 2px solid red;
      box-shadow: 0 0 10px #719ECE;
    }
  </style>
</head>
<!-- onload="show_menu_item();" -->

<body onLoad="gettable('<?php echo $floor_id ?>');">
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
          <?php include("../include/alerts.php"); ?>
          <!--widgetcontent-->
          <div class="nopadding">
            <div class="container-fluid">
              <div class="row-fluid">
                <!-- MENU LIST -->
                <div class="scrollmenu">
                  <div class="btn-group" data-toggle="buttons-radio">
                    <input type="button" class="btn btn-danger" value="Show All" onClick="show_menu_item('0');" />
                    <?php
                    $qry  = $obj->executequery("select * from m_product_category");
                    foreach ($qry as $rows) {
                      $catname = $rows['catname'];
                      $pcatid = $rows['pcatid'];
                    ?>
                      <input type="button" value="<?php echo strtoupper($catname); ?>" onClick="show_menu_item('<?php echo $pcatid; ?>');" class="btn btn-success" />
                    <?php }
                    ?>
                  </div>
                </div>
                <!-- MENU LIST -->
              </div>
              <hr class="solid">
              <div class="row-fluid">
                <!-- FIRST SECTION -->
                <div class="span3">
                  <div class="card">
                    <h5>FLOOR</h5>
                    <select name="floor_id" id="floor_id" class="chzn-select" onchange="gettable(this.value);">
                      <option value="0">----------All----------</option>
                      <?php
                      $res = $obj->executequery("select * from m_floor order by floor_id asc");
                      foreach ($res as $row) {
                      ?>
                        <option value="<?php echo $row['floor_id']; ?>"><?php echo ucwords($row['floor_name']); ?></option>
                      <?php } ?>
                    </select>
                    <script type="text/javascript">
                      document.getElementById('floor_id').value = '<?php echo $floor_id; ?>';
                    </script>
                    <hr class="solid">
                    <div class="row-fluid">
                      <div class="span6">
                        <h5>Available Table</h5>
                        <hr class="rounded">
                      </div>
                      <div class="span6">
                        <h5>Reserved Table</h5>
                        <hr class="rounded">
                      </div>
                    </div>
                    <div id="show_table"></div>
                  </div>
                </div>
                <!-- SECOND SECTION -->
                <div class="span5">
                  <div class="card">
                    <h5>SEARCH ITEM</h5>
                    <div class="control-group" style="margin-bottom: 5px;">
                      <div class="controls">
                        <div class="input-prepend">
                          <span class="add-on" style="padding: 4px 5px;"><i class="icon-search"></i></span>
                          <input class="search-query" id="searchItem" type="text">
                        </div>
                      </div>
                    </div>
                    <hr class="solid">
                    <!-- ITERM LIST  -->
                    <div class="row-fluid">
                      <div class="span2">
                        <h5>Item List</h5>
                        <hr class="rounded">
                      </div>
                    </div>
                    <div class="autooverflow">
                      <div id="show_product_list"></div>
                    </div>
                  </div>
                </div>
                <!-- THIRD SECTION -->
                <div class="span4">
                  <div class="card">
                    <?php
                    if ($parcel_id > 0) {
                      $parcelinfo = "<br>" . $obj->getvalfield("parcel_order", "CONCAT('Order No: ',order_number,' ||  OTP: ',otp)", "parcel_id='$parcel_id'");
                      $pdf_print_reciept = "pdf_parcel_bill.php";
                    } else {
                      $pdf_print_reciept = "pdf_restaurant_recipt.php";
                      $parcelinfo = "";
                    }
                    ?>
                    <h5>Table : <?php echo $table_no1 . " ( $floor_name )" . $parcelinfo; ?>
                      <?php
                      if ($parcel_type == '') {
                        if ($check_trans_table == 0) { ?>
                          <button style="margin-top: -10px; float: right;" class="btn btn-warning btn-xm" onclick="show_transfer_modal()">Transfer Table</button>
                      <?php }
                      } ?>
                    </h5>
                    <?php if ($waiter_id_cap > 0 && $waiter_id_stw > 0) { ?>
                      <h5>Captain Name : <?php echo $captain_name; ?></h5>
                      <h5>Steward Name : <?php echo $steward_name; ?>
                      <?php } ?>
                      <hr class="solid">
                      <div class="row-fluid">
                        <div class="span8">
                          <h5>Product</h5>
                          <hr class="rounded" style="width:16%;">
                        </div>
                        <div class="span4">
                          <h5>Total</h5>
                          <hr class="rounded" style="width:16%;">
                        </div>
                      </div>
                      <!--show add product list -->
                      <div id="show_addproduct"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!--contentinner-->
      </div><!--maincontent-->
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <div class="clearfix"></div>
    <!--footer-->
  </div><!--mainwrapper-->
  <!--product add modal-->
  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header color1">
      <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>
      <h3 id="myModalLabel">Update Rate</h3>
    </div>
    <div class="modal-body">
      <h5>Item Name : <span id="prodname"></span> / <span id="unit_name"></span></h5>
      <table class="table table-bordered">
        <thead>
          <input type="hidden" name="billdetailid" id="billdetailid" value="<?php echo $billdetailid; ?>">
        </thead>
        <tbody>
          <tr>
            <th>Rate</th>
            <td style="width: 20%;"><input type="text" name="rate" id="rate" onkeyup="gettotal();">
              <input name="hiddenrate" id="hiddenrate" type="hidden" value="<?php echo $rate; ?>">
            </td>
          </tr>
          <tr>
            <th>Quantity</th>
            <td style="width: 20%;"><input type="text" name="qty" id="qty" onkeyup="gettotal();"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <h2 class="pull-left">Total : <span id="total"></span></h2>
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button class="btn btn-primary" onclick="updaterate();">Save changes</button>
    </div>
  </div>
  <!--product add modal-->
  <div id="myModal_parcel" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-header color1">
      <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>
      <h3 id="myModalLabel">Parcel Entry For <?php echo $parcel_type; ?></h3>
    </div>
    <div class="modal-body">
      <table class="table table-bordered table-condensed">
        <tbody>
          <tr>
            <th>Order No:<span style="color: red">*</span></th>
            <td><input type="text" name="order_number" id="order_number"></td>
          </tr>
          <tr>
            <th>OTP Code:<span style="color: red">*</span></th>
            <td><input type="text" name="otp" id="otp"></td>
          </tr>
          <tr>
            <th>Rider Name: (Optional)</th>
            <td><input type="text" name="rider_name" id="rider_name"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <!-- <h2 class="pull-left">Total : <span id="total"></span></h2> -->
      <!-- <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
      <button class="btn btn-primary" onclick="save_parcel_info();">Save & Proceed</button>
    </div>
  </div>
  <!--product add modal-->

  <!--product add modal-->
  <div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header color1">
      <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>
      <h3 id="myModalLabel">Save Bill</h3>
    </div>
    <div class="modal-body">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th>Customer Name</th>
            <td><input type="text" name="cust_name" id="cust_name"></td>
          </tr>
          <tr>
            <th>Mobile No.</th>
            <td><input type="text" name="cust_mobile" id="cust_mobile"></td>
          </tr>
          <tr>
            <th>Gst No.</th>
            <td><input type="text" name="gst_no" id="gst_no"></td>
          </tr>
          <tr>
            <th>Food Total</th>
            <td><input type="text" name="total_taxable_food" id="total_taxable_food" value="<?php echo $total_taxable_food; ?>" readonly=""></td>
          </tr>
          <tr>
            <th>Beverages Total</th>
            <td><input type="text" name="total_taxable_bev" id="total_taxable_bev" value="<?php echo $total_taxable_bev; ?>" readonly=""></td>
          </tr>
          <tr>
            <th>Gross Total</th>
            <td><input type="text" name="basic_bill_amt" id="basic_bill_amt" value="<?php echo $basic_bill_amt; ?>" readonly=""></td>
          </tr>
          <tr>
            <th>Discount (In %)</th>
            <td><input type="text" name="disc_percent" id="disc_percent" onKeyUp="get_discount();" autocomplete="off"></td>
          </tr>
          <tr>
            <th>Discount Amt (Rs)</th>
            <td><input type="text" name="disc_rs" id="disc_rs" onKeyUp="get_discount();" autocomplete="off"></td>
          </tr>
          <?php
          $qry = $obj->executequery("select * from tax_setting_new");
          foreach ($qry as $rows) {
            $sgst = $rows['sgst'];
            $cgst = $rows['cgst'];
            $sercharge = $rows['sercharge'];
            $is_applicable = $rows['is_applicable'];
            if ($is_applicable > 0) {
              $sgst1 = $sgst;
              $cgst1 = $cgst;
            } else {
              $sgst1 = 0;
              $cgst1 = 0;
            }
          }
          if ($cgst > 0) {
          ?>
            <tr>
              <th>CGST</th>
              <td><input type="text" name="cgst" id="cgst" value="<?php echo $cgst1; ?>" readonly></td>
            </tr>
          <?php }
          if ($sgst > 0) { ?>
            <tr>
              <th>SGST</th>
              <td><input type="text" name="sgst" id="sgst" value="<?php echo $sgst1; ?>" readonly></td>
            </tr>
          <?php } ?>
          <tr>
            <th>Net Bill Amount</th>
            <td><input type="text" name="net_bill_amt" id="net_bill_amt" readonly=""></td>
          </tr>
          <tr>
            <th width="18%" colspan="2"> <label><input type="checkbox" name="checked_nc" id="checked_nc" value="1"> Not Chargeable </label></th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="modal-footer">
      <h2 class="pull-left">Total : <span id="nettotal"></span></h2>
      <input type="hidden" id="waiter_id_stw" value="<?php echo $waiter_id_stw; ?>">
      <input type="hidden" id="waiter_id_cap" value="<?php echo $waiter_id_cap; ?>">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button id="finalsavebill" class="btn btn-primary" onclick="save_bill();">Save changes</button>
    </div>
  </div>
  <!-- close modal tag -->
  <!-- transfer table -->
  <div id="myModal_transfer" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header color1">
      <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>
      <h3 id="myModalLabel">Transfer Table</h3>
    </div>
    <div class="modal-body" style="height: 300px;">
      <table class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th width="40%">Floor No.<span style="color:#F00;">*</span></th>
            <th width="40%">Table No.<span style="color:#F00;">*</span></th>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="floor_id" id="floor_id" value="<?php echo $floor_id; ?>">
              <select class="chzn-select" name="floor_idt" id="floor_idt" onchange="get_urlfloor_tran(this.value);">
                <option value="">--select--</option>
                <?php
                $res = $obj->executequery("select * from m_floor");
                foreach ($res as $row) { ?>
                  <option value="<?php echo $row['floor_id']; ?>"><?php echo $row['floor_name']; ?></option>
                <?php  }
                ?>
              </select>
              <script type="text/javascript">
                document.getElementById('floor_idt').value = '<?php echo $floor_id; ?>';
              </script>
            </td>
            <td>
              <input type="hidden" name="table_id" id="table_id" value="<?php echo $table_id; ?>">
              <select name="table_idt" id="table_idt" class="chzn-select" onchange="get_urlsearch_tran('<?php echo $floor_id; ?>',this.value);">
                <option value="">---Select---</option>
                <?php
                $slno = 1;
                $res = $obj->executequery("select * from m_table where floor_id = '$floor_id'");
                foreach ($res as $row_get) {
                ?>
                  <option value="<?php echo $row_get['table_id']; ?>"> <?php echo $row_get['table_no']; ?></option>
                <?php
                }
                ?>
              </select>
              <script type="text/javascript">
                document.getElementById('table_idt').value = '<?php echo $table_id; ?>';
              </script>
            </td>
          </tr>
        </thead>
      </table>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button class="btn btn-primary" id="transfer_order" onClick="transfer_order();">Transfer</button>
    </div>
  </div>
  <!--product add modal-->
  <div id="payment_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="top: 3%;">
    <div class="modal-header color1">
      <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>
      <h3 id="myModalLabel">Payment Entry</h3>
    </div>
    <div class="modal-body" style="max-height: 500px;padding: 10px;">
      <div class="widgettitle" style="padding: 5px;margin-bottom:5px;">
        <div class="row-fluid">
          <div class="span4">
            <h3 style="font-size: 15px;">Date :&nbsp;<?php echo $obj->dateformatindia($paydate); ?></h3>
          </div>
          <div class="span4">
            <h3 style="font-size: 15px;">Invoice : <span id="payment_bill_number"></span></h3>
          </div>
          <div class="span4">
            <h3 style="font-size: 15px;">Table : <span id="payment_table_no"></span></h3>
          </div>
        </div>
        <input type="hidden" name="paydate" id="paydate" value="<?php echo $obj->dateformatindia($paydate); ?>" readonly style="width: 40%;">
      </div>
      <table class="table table-bordered table-condensed">

        <tr>
          <th>Net Bill Amount</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="net_bill_amt" id="payment_amt" readonly="true" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Cash</th>
          <td style="text-align: center;padding: 1px 1px;">
            <input type="text" name="cash_amt" id="cash_amt" onkeyup="settotal();" value="0" class="input-medium">
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Paytm</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="paytm_amt" id="paytm_amt" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Card</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="card_amt" id="card_amt" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Zomato</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="zomato" id="zomato" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Swiggy</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="swiggy" id="swiggy" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Counter Parcel</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="counter_parcel" id="counter_parcel" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Google Pay</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="google_pay" id="google_pay" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Settlement Amt</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="settlement_amt" id="settlement_amt" onkeyup="settotal();" value="0" class="input-medium"></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <th>Credit Amt</th>
          <td style="text-align: center;padding: 1px 1px;">
            <input type="text" name="credit_amt" id="credit_amt" class="input-medium">
          </td>
          <td> <small id="credit_amt_error" style="color: red;" class="form-text text-muted"></small></td>
        </tr>
        <tr>
          <th>Mobile</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="cust_mobile" id="cust_mobile1" maxlength="10" class="input-medium"></td>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="cust_name" id="cust_name1" class="input-large" placeholder="Enter Customer Name"></td>
        </tr>
        <tr>
          <th>Remark</th>
          <td style="text-align: center;padding: 1px 1px;"><input type="text" name="remarks" id="remarks" class="input-medium"></td>
          <td style="text-align: center;"> <label><input type="checkbox" name="send_sms" id="send_sms" value="1"> SEND SMS </label></td>
        </tr>
      </table>
    </div>
    <div class="modal-footer" style="padding: 10px 15px 10px;">
      <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
      <input type="hidden" name="billid" id="billid" value="<?php echo $billid; ?>">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button class="btn btn-primary" onClick="return rec_payment();" id="savepayment">Received Payment</button>
    </div>
  </div>
  <!-- close modal tag -->
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      jQuery('#searchItem').focus();
    })
  </script>
  <script src="inc/blockui.js"></script>
  <script>
    // add operation 
    jQuery(document).ready(function() {
      jQuery('#save').click(function() {
        jQuery.blockUI();
        setTimeout(jQuery.unblockUI, 2000);
      });
    });

    function show_transfer_modal() {
      jQuery("#myModal_transfer").modal('show');
    }

    function get_urlfloor_tran(floor_idt) {
      jQuery.ajax({
        type: 'POST',
        url: 'get_tabletransfer.php',
        data: 'floor_idt=' + floor_idt,
        dataType: 'html',
        success: function(data) {
          //alert(data);
          jQuery("#table_idt").html(data);
          jQuery("#table_idt").val('').trigger("liszt:updated");
          document.getElementById('table_idt').focus();
          jQuery(".chzn-single").focus();
        }
      });
    }

    function transfer_order() {
      table_idt = jQuery("#table_idt").val();
      table_id = jQuery("#table_id").val();
      floor_idt = jQuery("#floor_idt").val();
      if (table_idt != "" && table_id != "") {
        jQuery("#transfer_order").attr("disabled", "disabled");
        jQuery.ajax({
          type: 'POST',
          url: 'transfer_order_table.php',
          data: "table_idt=" + table_idt + '&table_id=' + table_id,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            jQuery("#table_idt").val(data);
            jQuery("#transfer_order").removeAttr("disabled");
            var gourl = 'in_entry_new.php?table_id=' + data;
            location = gourl;
          }
        });
        jQuery("#myModal_transfer").modal('hide');
      } //if close
      else {
        alert('Please select table for transfer orders');
      }
    }

    function rec_payment() {
      var result = 'true';
      net_bill_amt = jQuery('#hidden_net_bill_amt').val();
      // alert(net_bill_amt);
      cust_name = jQuery('#cust_name1').val();
      cash_amt = jQuery('#cash_amt').val();
      credit_amt = jQuery('#credit_amt').val();
      paytm_amt = jQuery('#paytm_amt').val();
      card_amt = jQuery('#card_amt').val();
      google_pay = jQuery('#google_pay').val();
      zomato = jQuery('#zomato').val();
      swiggy = jQuery('#swiggy').val();
      counter_parcel = jQuery('#counter_parcel').val();
      settlement_amt = jQuery('#settlement_amt').val();
      cust_mobile = jQuery('#cust_mobile1').val();
      remarks = jQuery('#remarks').val();
      table_id = '<?php echo $table_id; ?>';
      billid = jQuery('#billid').val();
      paydate = jQuery('#paydate').val();
      var send_sms1 = 0;
      var send_sms = document.getElementById('send_sms').checked;
      if (send_sms == true)
        var send_sms1 = 1;
      if (credit_amt > 0) {
        if (confirm('This Bill have creadit amount, are sure want to paid')) {
          if (cust_name == "") {
            jQuery('#credit_amt_error').html("Please Enter Customer Name For Creadit Bill as creadit");
            return false;
          } else
            jQuery('#credit_amt_error').html("");
        } else
          return false;
      } else {
        jQuery('#credit_amt_error').html("");
      }
      if (credit_amt != "") {
        jQuery('#loaderimg').css("display", "block");
        jQuery('#savepayment').css("display", "blobk");
        jQuery('#disacrdpayment').css("display", "blobk");
        jQuery.ajax({
          type: 'POST',
          url: 'save_order_payment.php',
          data: 'cash_amt=' + cash_amt + '&paytm_amt=' + paytm_amt + '&card_amt=' + card_amt + '&google_pay=' + google_pay + '&settlement_amt=' + settlement_amt + '&remarks=' + remarks + '&table_id=' + table_id + '&billid=' + billid + '&paydate=' + paydate + '&credit_amt=' + credit_amt + '&cust_name=' + cust_name + '&cust_mobile=' + cust_mobile + '&zomato=' + zomato + '&send_sms1=' + send_sms1 + '&swiggy=' + swiggy + '&counter_parcel=' + counter_parcel,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            jQuery("#cash_amt").val("");
            jQuery("#paytm_amt").val("");
            jQuery("#card_amt").val("");
            jQuery("#zomato").val("");
            jQuery("#swiggy").val("");
            jQuery("#counter_parcel").val("");
            jQuery("#google_pay").val("");
            jQuery("#settlement_amt").val("");
            jQuery("#credit_amt").val("");
            jQuery("#savepayment").removeAttr("disabled");
            gettable('<?php echo $floor_id ?>');
            show_table_item();
            location = 'in_entry_new.php?table_id=' + table_id;
            if (data == 1) {
              jQuery("#save_bill_order").removeAttr("disabled");
              gettable('<?php echo $floor_id ?>');
              show_table_item();
              location = 'in_entry_new.php?table_id=' + table_id;
            } else {
              // alert("Error");
            }
            if (data == 2) {
              alert('successfully send');
            }
            if (data == 3) {
              alert('not send');
            }
          }
        });
      } //if close
      else {
        jQuery('#credit_amt_error').html("Invalid Receve Amount.");
      } //else close
      jQuery('#payment_modal').modal('hide');
    }

    function settotal() {
      var net_bill_amt = parseFloat(jQuery('#payment_amt').val());
      var card_amt = parseFloat(jQuery('#card_amt').val());
      var cash_amt = parseFloat(jQuery('#cash_amt').val());
      var google_pay = parseFloat(jQuery('#google_pay').val());
      var zomato = parseFloat(jQuery('#zomato').val());
      var counter_parcel = parseFloat(jQuery('#counter_parcel').val());
      var swiggy = parseFloat(jQuery('#swiggy').val());
      var settlement_amt = parseFloat(jQuery('#settlement_amt').val());
      var paytm_amt = parseFloat(jQuery('#paytm_amt').val());
      if (!isNaN(net_bill_amt) && !isNaN(cash_amt)) {
        total = net_bill_amt - cash_amt;
      } else
        total = net_bill_amt;
      if (!isNaN(paytm_amt)) {
        total1 = total - paytm_amt;
      } else
        total1 = total;
      if (!isNaN(card_amt)) {
        total2 = total1 - card_amt;
      } else
        total2 = total1;
      if (!isNaN(zomato)) {
        total3 = total2 - zomato;
      } else
        total3 = total2;
      if (!isNaN(swiggy)) {
        total4 = total3 - swiggy;
      } else
        total4 = total3;
      if (!isNaN(counter_parcel)) {
        total5 = total4 - counter_parcel;
      } else
        total5 = total4;
      if (!isNaN(google_pay)) {
        total6 = total5 - google_pay;
      } else
        total6 = total5;
      if (!isNaN(settlement_amt)) {
        total7 = total6 - settlement_amt;
      } else
        total7 = total6;
      jQuery('#credit_amt').val(total7.toFixed(2));
    }

    function setnettot() {
      var total_bill_amount = parseFloat(jQuery('#total_bill_amount').val());
      var disc_percent = parseFloat(jQuery('#disc_percent').val());
      if (!isNaN(total_bill_amount) && !isNaN(disc_percent)) {
        total = total_bill_amount * disc_percent / 100;
        net_bill_amt = total_bill_amount - total;
        jQuery('#net_bill_amt').val(net_bill_amt.toFixed(2));
      } else {
        total = total_bill_amount;
        jQuery('#net_bill_amt').val(total.toFixed(2));
      }
    }

    function gettotal() {
      //alert('hi');
      var rate = document.getElementById('rate').value;
      var qty = document.getElementById('qty').value;
      if (!isNaN(rate) && !isNaN(qty)) {
        total = rate * qty;
      }
      document.getElementById('total').innerHTML = total;
    }

    function save_bill() {
      basic_bill_amt = jQuery("#basic_bill_amt").val();
      food_amt = jQuery("#total_taxable_food").val();
      bev_amt = jQuery("#total_taxable_bev").val();
      net_bill_amt = jQuery("#net_bill_amt").val();
      disc_rs = jQuery("#disc_rs").val();
      cgst = jQuery("#cgst").val();
      sgst = jQuery("#sgst").val();
      cust_name = jQuery("#cust_name").val();
      cust_mobile = jQuery("#cust_mobile").val();
      gst_no = jQuery("#gst_no").val();
      disc_percent = jQuery("#disc_percent").val();
      waiter_id_stw = jQuery("#waiter_id_stw").val();
      waiter_id_cap = jQuery("#waiter_id_cap").val();
      table_id = '<?php echo $table_id; ?>';
      var checked_nc1 = 0;
      var is_checked = document.getElementById('checked_nc').checked;
      if (is_checked == true)
        var checked_nc1 = 1;
      jQuery.ajax({
        type: 'POST',
        url: 'save_order_bill_new.php',
        data: "basic_bill_amt=" + basic_bill_amt + '&table_id=' + table_id + '&net_bill_amt=' + net_bill_amt + '&food_amt=' + food_amt + '&bev_amt=' + bev_amt + '&disc_rs=' + disc_rs + '&cgst=' + cgst + '&sgst=' + sgst + '&checked_nc=' + checked_nc1 + '&disc_percent=' + disc_percent + '&waiter_id_stw=' + waiter_id_stw + '&waiter_id_cap=' + waiter_id_cap + '&cust_name=' + cust_name + '&cust_mobile=' + cust_mobile + '&gst_no=' + gst_no,
        dataType: 'html',
        success: function(resp) {
          console.log(resp);
          if (resp > 0) {
            var myurl1 = "<?php echo $pdf_print_reciept; ?>" + '?billid=' + resp;
            window.open(myurl1, '_blank');
            // show_table_item();
            jQuery('#myModal1').modal('hide');
            location = 'in_entry_new.php?table_id=' + table_id;
          } else {
            alert("This Bill is already Saved, Go to Payment");
            event.preventDefault()
            //show_table_item();
            jQuery('#myModal1').modal('hide');
          }
        }
      });
    }

    function show_payment_modal(net_bill_amt, billnumber, table_no, cust_name, cust_mobile) {
      //alert(cust_name);alert(cust_mobile);
      net_bill_amt = parseFloat(net_bill_amt);
      net_bill_amt = net_bill_amt.toFixed(2);
      jQuery('#payment_bill_number').html(billnumber);
      jQuery('#payment_table_no').html(table_no);
      jQuery('#payment_amt').val(net_bill_amt);
      jQuery('#credit_amt').val(net_bill_amt);
      jQuery('#cust_name1').val(cust_name);
      jQuery('#cust_mobile1').val(cust_mobile);
      jQuery('#payment_total').html(net_bill_amt);
      // jQuery('#customer_name').html(customer_name);
      jQuery('#payment_modal').modal('show');
    }

    function updaterate() {
      var billdetailid = document.getElementById('billdetailid').value;
      var rate = document.getElementById('rate').value;
      var qty = document.getElementById('qty').value
      if (rate == '') {
        alert('Rate cant be blank');
        return false;
      }
      if (qty == '') {
        alert('Quantity cant be blank');
        return false;
      } else {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax_updaterate.php',
          data: 'billdetailid=' + billdetailid + '&rate=' + rate + '&qty=' + qty,
          dataType: 'html',
          success: function(data) {
            jQuery('#myModal').modal('hide');
            show_table_item();
          }
        });
      }
    }

    function get_discount() {
      basic_bill_amt = parseFloat(jQuery("#basic_bill_amt").val());
      disc_percent = parseFloat(jQuery("#disc_percent").val());
      disc_rs = parseFloat(jQuery("#disc_rs").val());
      sgst = parseFloat(jQuery("#sgst").val());
      cgst = parseFloat(jQuery("#cgst").val());
      //alert(cgst);
      if (disc_percent > 0) {
        disc_amt = basic_bill_amt * (disc_percent / 100);
      } else
        disc_amt = 0;
      if (disc_rs > 0)
        disc_amt_rs = disc_rs;
      else
        disc_amt_rs = 0;
      net_bill_amt = basic_bill_amt - disc_amt - disc_amt_rs;
      if (sgst > 0)
        sgst_amt = net_bill_amt * (sgst / 100);
      else
        sgst_amt = 0;
      if (cgst > 0)
        cgst_amt = net_bill_amt * (cgst / 100);
      else
        cgst_amt = 0;
      //total net bill
      net_bill_amt = net_bill_amt + sgst_amt + cgst_amt;
      net_bill_amt = Math.round(net_bill_amt.toFixed(2));
      jQuery("#net_bill_amt").val(net_bill_amt);
      jQuery("#nettotal").html(net_bill_amt);
    }

    function funaddproduct(billdetailid) {
      var tblname = 'bill_details';
      var tblpkey = 'billdetailid';
      var pagename = '<?php echo $pagename; ?>';
      var submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
      if (confirm("Are you sure! You want to delete this record.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_master.php',
          data: 'id=' + billdetailid + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            show_table_item();
          }
        });
      } //confirm close
    }
    // menu
    jQuery(document).ready(function() {
      jQuery('#menues').click();
    });
    // search for product item
    jQuery(document).ready(function() {
      jQuery("#searchItem").on("keyup", function() {
        var value = jQuery(this).val().toLowerCase();
        jQuery("#myTable tr").filter(function() {
          jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });

    function gettable(floor_id) {
      jQuery.blockUI();
      jQuery.ajax({
        url: 'ajax_gettable.php',
        data: 'floor_id=' + floor_id,
        dataType: 'html',
        success: function(resp) {
          jQuery('#show_table').html(resp);
          setTimeout(jQuery.unblockUI, 200);
        }
      });
    }

    function show_menu_item(pcatid) {
      var table_id = '<?php echo $table_id; ?>';
      jQuery.ajax({
        url: 'ajax_addproduct_data.php',
        data: 'pcatid=' + pcatid + '&table_id=' + table_id,
        dataType: 'html',
        success: function(resp) {
          jQuery('#show_product_list').html(resp);
        }
      });
    }

    function show_modal(billdetailid, prodname, qty, rate, unit_name, cgst, sgst, tax_type, disc_percent) {
      jQuery.blockUI();
      jQuery('#myModal').modal('show');
      jQuery('#billdetailid').val(billdetailid);
      jQuery('#prodname').html(prodname);
      jQuery("#total").html(rate);
      jQuery("#hiddenrate").val(rate);
      jQuery('#disc_percent1').val(disc_percent);
      jQuery('#qty').val(qty);
      jQuery('#rate').val(rate);
      jQuery('#cgst').val(cgst);
      jQuery('#sgst').val(sgst);
      jQuery('#tax_type').val(tax_type);
      jQuery('#unit_name').html(unit_name);
      gettotal();
      setTimeout(jQuery.unblockUI, 500);
    }

    function show_table_item() {
      var table_id = '<?php echo $table_id; ?>';
      jQuery.blockUI();
      jQuery.ajax({
        url: 'ajax_showaddproduct.php',
        data: 'table_id=' + table_id,
        dataType: 'html',
        success: function(data) {
          jQuery('#show_addproduct').html(data);
          setTimeout(jQuery.unblockUI, 200);
          jQuery('#textBody').scrollTop(jQuery('#textBody').scrollTop() + 500);
        }
      });
    }

    function addqty(billdetailid, rate) {
      var qtyinput = 'qty' + billdetailid;
      var qty = document.getElementById(qtyinput).value;
      var table_id = '<?php echo $table_id; ?>';
      let addedQuantity = qty;
      if (!isNaN(qty)) addedQuantity = parseFloat(qty) + 1;
      jQuery.ajax({
        url: 'ajax_updateqty.php',
        data: 'table_id=' + table_id + '&billdetailid=' + billdetailid + '&qty=' + addedQuantity + '&rate=' + rate,
        dataType: 'html',
        success: function(resp) {
          if (resp.trim()) show_table_item();
        }
      });
    }

    function minusqty(billdetailid, rate) {
      var qtyinput = 'qty' + billdetailid;
      var qty = document.getElementById(qtyinput).value;
      var table_id = '<?php echo $table_id; ?>';
      var subtracted_qty = qty;
      if (!isNaN(qty)) subtracted_qty = parseFloat(qty) - 1;
      if (qty > 1) {
        jQuery.ajax({
          url: 'ajax_updateqty.php',
          data: 'table_id=' + table_id + '&billdetailid=' + billdetailid + '&qty=' + subtracted_qty + '&rate=' + rate,
          dataType: 'html',
          success: function(resp) {
            show_table_item();
          }
        });
      } else
        alert("Quntity can not be less than 1");
    }

    function set_nc() {
      var is_checked = document.getElementById('checked_nc').checked;
      if (is_checked) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax_new_ncprocess.php',
          data: 'checked_nc=' + checked_nc + '&billdetailid=' + billdetailid + '&table_id=' + table_id,
          dataType: 'html',
          success: function(data) {
            show_table_item();
          }
        });
      } else {
        // var hiddenrate = jQuery("#hiddenrate").val();
        // jQuery("#rate").val(hiddenrate);
      }
    }

    function nc_product(billdetailid, checked_nc) {
      var table_id = '<?php echo $table_id; ?>';
      if (confirm("Are you sure! You want to NC this product.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax_ncproduct.php',
          data: 'checked_nc=' + checked_nc + '&billdetailid=' + billdetailid + '&table_id=' + table_id,
          dataType: 'html',
          success: function(data) {
            show_table_item();
          }
        });
      }
    }

    function save_show_modal(net_bill_amt, sub_total, total_taxable_food, total_taxable_bev, waiter_id_stw, waiter_id_cap) {
      jQuery('#myModal1').modal('show');
      //jQuery('#net_bill_amt').val(net_bill_amt);
      jQuery('#total_taxable_food').val(total_taxable_food);
      jQuery('#total_taxable_bev').val(total_taxable_bev);
      jQuery('#basic_bill_amt').val(sub_total);
      jQuery('#waiter_id_stw').val(waiter_id_stw);
      jQuery('#waiter_id_cap').val(waiter_id_cap);
      get_discount();
    }

    function refreshkot(billid, table_id) {
      jQuery.ajax({
        url: 'ajax_check_kot_products.php',
        data: "billid=" + billid + '&table_id=' + table_id,
        dataType: 'html',
        success: function(data) {
          var count_prod = data.trim();
          if (count_prod == 0)
            alert('Please add product for new KOT!');
          else {
            location.reload();
            var myurl = "pdf_restaurant_kot_recipt_new.php?billid=" + billid + "&table_id=" + table_id;
            window.open(myurl, '_blank');
          }
        }
      });
    }
  </script>
  <script type="text/javascript">
    function addlist(productid, rate, unitid, qty, addlistbtn) {
      addlistbtn.disabled = true;
      var table_id = '<?php echo $table_id; ?>';
      jQuery.ajax({
        url: 'savebillproductentry.php',
        data: 'productid=' + productid + '&unitid=' + unitid + '&rate=' + rate + '&table_id=' + table_id + '&qty=' + qty,
        dataType: 'html',
        success: function(resp) {
          if (resp == 2) {
            alert("This Bill is Saved, Can\'t add product.");
            jQuery('#searchItem').val('').focus();
          } else if (resp == 0) {
            alert("Please Select Table");
            jQuery('#searchItem').val('').focus();
          } else {
            jQuery('#productid').val('');
            jQuery('#rate').val('');
            jQuery('#unitid').val('');
            show_table_item();
            gettable('<?php echo $floor_id ?>');
            jQuery('#searchItem').val('').focus();
          }
          addlistbtn.disabled = false;
        }
      });
    }

    function delete_saved_bills(table_id, billid) {
      if (confirm('Are you sure Want to delete this bill?')) {
        if (table_id > 0 && billid > 0) {
          var gourl = "in_entry_new.php?table_id=" + table_id;
          jQuery.ajax({
            type: 'POST',
            url: 'ajax_deleted_saved_bills.php',
            data: 'billid=' + billid + '&table_id=' + table_id,
            dataType: 'html',
            success: function(data) {
              alert('Bill Deleted Successfully');
              location = gourl;
              //show_table_item();
            }
          });
        } else {
          alert("Can not delete bill, Beacuse order not saved yet!");
        }
      }
    }
    /*function save_table_info()
    {
        var table_id= '<?php echo $table_id; ?>';
        var waiter_id_cap = jQuery('#waiter_id_cap').val();
        var waiter_id_stw = jQuery('#waiter_id_stw').val();
        if(waiter_id_cap=='')
        {
          alert("captain name can not be blank");
          return false;
        }
        if(waiter_id_stw=='')
        {
          alert("Steward name can not be blank");
           return false;
        }
        else
        {
       
       
        //alert(order_number);
        if(table_id > 0)
        {
          //alert(order_number);
          var gourl = "in_entry_new.php?table_id="+table_id;
          jQuery.ajax({
                 type: 'POST',
                 url: 'ajax_add_capstw_infotmation.php',
                 data: 'table_id='+table_id+'&waiter_id_cap='+waiter_id_cap+'&waiter_id_stw='+waiter_id_stw,
                 dataType: 'html',
                 success: function(data){
                 //alert(data);
                // alert('In table captain and steward information saved successfully');
                 location=gourl;
                 //show_table_item();
                 }
              });
        }
        else
        {
          alert("Can not add parcel orderno and oto!");
        }
      }
    }*/
    function save_parcel_info() {
      var table_id = '<?php echo $table_id; ?>';
      var order_number = jQuery('#order_number').val();
      var otp = jQuery('#otp').val();
      var rider_name = jQuery('#rider_name').val();
      //alert(order_number);
      if (table_id > 0 && order_number != '' && otp != '') {
        //alert(order_number);
        var gourl = "in_entry_new.php?table_id=" + table_id;
        jQuery.ajax({
          url: 'ajax_add_parcel_infotmation.php',
          data: 'table_id=' + table_id + '&order_number=' + order_number + '&otp=' + otp + '&rider_name=' + rider_name,
          dataType: 'html',
          success: function(data) {
            location = gourl;
            //show_table_item();
          }
        });
      } else {
        alert("Can not add parcel orderno and oto!");
      }
    }

    function change_modal_capstw(waiter_id_cap, waiter_id_stw) {
      jQuery('#myModal_table_capstw').modal('show');
      jQuery('#waiter_id_cap').val(waiter_id_cap);
      jQuery('#waiter_id_stw').val(waiter_id_stw);
    }
    <?php if (isset($_GET['table_id']) && !empty($_GET['table_id'])) { ?>
      show_table_item();
      show_menu_item(0);
      <?php
      if ($parcel_status == 1 && $parcel_id == 0) { ?>
        jQuery('#myModal_parcel').modal('show');
      <?php }
      if ($cap_stw_id == 0) { ?>
        jQuery('#myModal_table_capstw').modal('show');
      <?php }
    } else { ?>
      show_table_item();
      show_menu_item(0);
    <?php } ?>
  </script>
  <script>
    shortcut.add("shift+k", function() {
      jQuery("#link_printkot").click();
    });
    shortcut.add("shift+s", function() {
      jQuery("#save").click();
    });
    shortcut.add("shift+d", function() {
      jQuery("#btn_deletebill").click();
    });
    shortcut.add("shift+p", function() {
      jQuery("#btn_paybill").click();
    });
  </script>
</body>

</html>