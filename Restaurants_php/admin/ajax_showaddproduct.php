<?php include("../adminsession.php");
$table_id = (int)$obj->test($_GET['table_id']);
$waiter_id_cap = $obj->get("cap_stw_table", "waiter_id_cap", "table_id='$table_id'");
$waiter_id_stw = $obj->get("cap_stw_table", "waiter_id_stw", "table_id='$table_id'");
$net_bill_amt = (float)$obj->get("bills", "net_bill_amt", "table_id='$table_id' and is_paid=0");
if ($net_bill_amt > 0) {
  $basic_bill_amt = $obj->getvalfield("bills", "basic_bill_amt", "table_id='$table_id' and is_paid=0");
  $disc_percent = $obj->getvalfield("bills", "disc_percent", "table_id='$table_id' and is_paid=0");
  $disc_rs = $obj->getvalfield("bills", "disc_rs", "table_id='$table_id' and is_paid=0");
  if ($disc_percent > 0) {
    $disc_amt = $basic_bill_amt * $disc_percent / 100;
  } else
    $disc_amt = 0;
  $disc_amt = $disc_amt + $disc_rs;
  $taxable_amt = $basic_bill_amt - $disc_amt;
  $sgst = $obj->getvalfield("tax_setting_new", "sgst", "1=1");
  $cgst = $obj->getvalfield("tax_setting_new", "cgst", "1=1");
  $sgst_amt = $taxable_amt * $sgst / 100;
  $cgst_amt = $taxable_amt * $cgst / 100;
} else {
  $sgst_amt = 0;
  $cgst_amt = 0;
  $disc_amt = 0;
}
$billnumber = $obj->getvalfield("bills", "billnumber", "table_id='$table_id' and is_paid=0");
$cust_name = $obj->getvalfield("bills", "cust_name", "table_id='$table_id' and is_paid=0");
$cust_mobile = $obj->getvalfield("bills", "cust_mobile", "table_id='$table_id' and is_paid=0");
$table_no = $obj->getvalfield("m_table", "table_no", "table_id='$table_id'");
$parcel_id = $obj->getvalfield("parcel_order", "parcel_id", "table_id='$table_id' and close_order=0");
$issaved = $obj->getvalfield("bills", "count(*)", "table_id='$table_id' and is_paid='0'");
$edit_billid = $obj->getvalfield("bills", "billid", "table_id='$table_id' and is_paid='0'");
$dis_quantity = "";
$billid_for_del = "0";
if ($issaved > 0) {
  $dis_quantity = 'disabled';
  $billid_for_del = $obj->getvalfield("bills", "billid", "table_id='$table_id' and is_paid='0'");
}
?>
<div style="min-height:300px;overflow: auto;max-height: 370px;" id="textBody">
  <table class="table table-condensed table-hover">
    <tbody>
      <?php
      $sno = 1;
      $total = 0;
      $totcgst = 0;
      $totsgst = 0;
      $net_bill  = 0;
      $bev_cgst = 0;
      $bev_sgst = 0;
      $food_cgst = 0;
      $food_sgst = 0;
      $total_bill_cgst = 0;
      $total_bill_sgst = 0;
      $total_taxable_bev = 0;
      $total_taxable_food = 0;
      $fetch = $obj->executequery("select * from view_bill_details where table_id='$table_id' && isbilled='0'");
      foreach ($fetch as $data) {
        $productid = $data['productid'];
        $checked_nc = $data['checked_nc'];
        $prodname = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
        $billdetailid = $data['billdetailid'];
        $rate = $data['rate'];
        $taxable = $data['taxable'];
        $qty = $data['qty'];
        $kotid = $data['kotid'];
        $total_amt = $rate * $qty;
        $unitid = $data['unitid'];
        $unit_name = $obj->getvalfield("m_unit", "unit_name", "unitid='$unitid'");
        $foodtypeid = $data['foodtypeid'];
        if ($kotid > 0) {
          $ktoclass = "alert-danger";
          $is_disabled = "disabled";
        } else {
          $ktoclass = "alert-success";
          $is_disabled = "";
        }
        if ($checked_nc > 0) {
          $notcharge = "text-decoration: line-through;";
          $nc_font_color = 'color:red';
        } else {
          $notcharge = "";
          $nc_font_color = "";
        }
      ?>
        <tr class="<?php echo $ktoclass; ?>">
          <td width="200px" style="<?php echo $nc_font_color; ?>">
            <strong style="<?php echo $notcharge; ?>"><?php echo $prodname; ?></strong>
            <div class="form-inline">
              <button <?php echo $dis_quantity; ?> <?php echo $is_disabled; ?> type="button" class="btn btn-mini btn-primary" id="minus<?php echo $billdetailid; ?>" onClick="minusqty('<?php echo $billdetailid; ?>','<?php echo $rate; ?>');">&nbsp-&nbsp</button>
              <input type="text" class="span2 control" name="qty<?php echo $billdetailid; ?>" id="qty<?php echo $billdetailid; ?>" value="<?php echo $data['qty']; ?>" readonly>
              <button <?php echo $dis_quantity; ?> <?php echo $is_disabled; ?> type="button" class="btn btn-mini btn-primary" id="add<?php echo $billdetailid; ?>" onClick="addqty('<?php echo $billdetailid; ?>','<?php echo $rate; ?>');">&nbsp+&nbsp</button>
              &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr"><?php echo $rate . "/-" . $unit_name; ?></i>
            </div>
          </td>
          <td width="200px">
            <div class="form-inline" style="margin-top:14px;float:right;">
              <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> <?php echo $total_amt . "/-"; ?></span>
              <?php
              if ($issaved == 0) { ?>
                <label class="label label-warning " style="padding:5px;" onclick="show_modal('<?php echo $billdetailid; ?>','<?php echo $prodname; ?>','<?php echo $qty; ?>','<?php echo $rate; ?>','<?php echo $unit_name; ?>');"><i class="icon-edit icon-white"></i></label>
                <button type="button" class="btn btn-danger" style="padding:2px 5px;" onclick="funaddproduct('<?php echo $billdetailid; ?>');"><i class="icon-trash icon-white"></i></button>
              <?php } ?>
            </div>
          </td>
        </tr>
      <?php
        $total += $data['taxable'];
        $net_bill += $data['taxable'];
      }
      $net_bill_amt1 = round($total);
      ?>
    </tbody>
  </table>
</div>
<br>
<span>KOT's : </span>
<table class="table table-condensed table-bordered">
  <tr>
    <td colspan="12">
      <?php
      $slno = 0;
      $res_kot = $obj->executequery("select * from kot_entry where table_id = '$table_id' and billid=0");
      foreach ($res_kot as $row_kot) {
        ++$slno;
      ?>
        <a target="_blank" href="pdf_restaurant_kot_recipt_new.php?kotid=<?php echo $row_kot['kotid']; ?>" style="margin: 2px;" class="btn"><?php echo $slno; ?></a>
      <?php
      }
      ?>
    </td>
  </tr>
  <tr>
    <td style="padding:2px;">
      <?php
      //food total
      $food_total = $obj->getvalfield("view_bill_details", "sum(total)", "foodtypeid=2 and table_id = '$table_id' and isbilled=0");
      //bev total
      $bev_total = $obj->getvalfield("view_bill_details", "sum(total)", "foodtypeid=1 and table_id = '$table_id' and isbilled=0");
      $sub_total = $food_total + $bev_total;
      ?>
      <h6 class="text-right">Food Total: <i class="fa fa-inr"></i><?php echo number_format($food_total, 2); ?></h6>
      <h6 class="text-right">Beverages Total: <i class="fa fa-inr"></i> <?php echo number_format($bev_total, 2); ?></h6>
      <h6 class="text-right">Gross Total: <i class="fa fa-inr"></i> <?php echo number_format($sub_total, 2); ?></h6>
      <?php
      if ($disc_amt > 0) { ?>
        <h6 class="text-right">Discount: <i class="fa fa-inr"></i> <?php echo number_format($disc_amt, 2); ?></h6>
      <?php } ?>
      <?php
      if ($cgst_amt > 0) { ?>
        <h6 class="text-right">CGST: <i class="fa fa-inr"></i> <?php echo number_format($cgst_amt, 2); ?></h6>
      <?php } ?>
      <?php
      if ($sgst_amt > 0) { ?>
        <h6 class="text-right">SGST: <i class="fa fa-inr"></i> <?php echo number_format($sgst_amt, 2); ?></h6>
      <?php } ?>
    </td>
  </tr>
  <?php if ($net_bill_amt > 0) { ?>
    <tr>
      <td class="net-amount">
        <span style="float:right;padding-right:2px;">Net Bill Amt: <i class="fa fa-inr"></i> <?php echo $net_bill_amt; ?></span>
      </td>
    </tr>
  <?php } ?>
  <tr>
    <td>
      <?php if ($net_bill_amt == 0) { ?>
        <button type="button" class="btn btn-primary" id="save" onclick="save_show_modal('<?php echo $net_bill; ?>','<?php echo $sub_total; ?>','<?php echo $food_total; ?>','<?php echo $bev_total; ?>','<?php echo $waiter_id_stw; ?>','<?php echo $waiter_id_cap; ?>');"><i class="icon-file icon-white"></i> Save Bill</button>
      <?php }
      if ($net_bill_amt > 0) { ?>
        <button type="button" class="btn btn-primary" id="btn_paybill" onclick="show_payment_modal('<?php echo $net_bill_amt; ?>','<?php echo $billnumber; ?>','<?php echo $table_no; ?>','<?php echo $cust_name; ?>','<?php echo $cust_mobile; ?>');"><i class="icon-file icon-white"></i> Payment</button>
      <?php } ?>
      <a id="link_printkot" onclick="refreshkot('<?php echo $edit_billid; ?>','<?php echo $table_id; ?>');" class="btn btn-success" target="_blank">
        <i class="icon-print icon-white"></i> Print KOT</a>
      <?php
      $rec_billid = $obj->getvalfield("bills", "billid", "table_id='$table_id' and is_paid=0");
      if ($rec_billid > 0) {
        if ($parcel_id > 0) {
      ?>
          <a class="btn btn-warning" target="_blank" href="pdf_parcel_bill.php?billid=<?php echo $rec_billid; ?>">
            <i class="iconfa-print"></i> Print Bill</a>&nbsp;
        <?php } else { ?>
          <a class="btn btn-warning" target="_blank" href="pdf_restaurant_recipt.php?billid=<?php echo $rec_billid; ?>">
            <i class="iconfa-print"></i> Print Bill</a>&nbsp;
      <?php
        } //parcel if close
      } //rec_billid if close 
      ?>
      <?php if ($usertype == 'admin') { ?>
        <button id="btn_deletebill" onclick="delete_saved_bills(<?php echo $table_id; ?>,<?php echo $billid_for_del; ?>)" class="btn  btn-danger"><i class="icon-trash icon-white"></i> Delete Bill</button>
      <?php } ?>
    </td>
  </tr>
</table>