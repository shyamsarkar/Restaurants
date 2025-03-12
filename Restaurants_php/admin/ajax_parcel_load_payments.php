<?php include("../adminsession.php");
if (isset($_REQUEST['billid'])) {
  $billid = $obj->test_input($_REQUEST['billid']);
  $where = array('billid' => $billid);
  $bill_info = $obj->select_record('bills', $where);
  $paydate =  $bill_info['paydate'];
  $billnumber =  $bill_info['billnumber'];
  $table_id =  $bill_info['table_id'];
  $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$table_id'");
  $parcel_type = $obj->getvalfield("m_table", "parcel_type", "table_id='$table_id'");
  $basic_bill_amt =  $bill_info['basic_bill_amt'];
  $cash_amt =  $bill_info['cash_amt'];
  $paytm_amt =  $bill_info['paytm_amt'];
  $card_amt =  $bill_info['card_amt'];
  $google_pay =  $bill_info['google_pay'];
  $credit_amt =  $bill_info['credit_amt'];
  $card_amt =  $bill_info['card_amt'];
  $swiggy =  $bill_info['swiggy'];
  $counter_parcel =  $bill_info['counter_parcel'];
  $google_pay =  $bill_info['google_pay'];
  $zomato =  $bill_info['zomato'];
  $settlement_amt =  $bill_info['settlement_amt'];
  $cust_mobile =  $bill_info['cust_mobile'];
  $cust_name =  $bill_info['cust_name'];
}
?>
<style type="text/css">
  .color1 {
    background: #ff7e5f;
    background: -webkit-linear-gradient(to right, #feb47b, #ff7e5f);
    background: linear-gradient(to right, #feb47b, #ff7e5f);
  }
</style>
<table class="table table-bordered table-condensed">
  <div class="modal-header color1">
    <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>
    <h3 id="myModalLabel">Payment Entry <?php echo $parcel_type; ?></h3>
  </div>
  <br>
  <thead>
    <h3 class="widgettitle" style="color: black;">Date :&nbsp;<b><?php echo $obj->dateformatindia($paydate); ?></b>
      <input type="hidden" name="paydate" id="paydate" value="<?php echo $obj->dateformatindia($paydate); ?>" readonly style="width: 40%;">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice : <b><span style="font-weight:bold;"><?php echo $billnumber; ?></span></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Table : <b><span style="font-weight:bold;"><?php echo $table_no; ?></span></b>
    </h3>
    <tr>
      <th>Net Bill Amount</th>
      <td><input type="text" name="net_bill_amt" id="payment_amt" value="<?php echo $basic_bill_amt; ?>" readonly="true" style="width: 120px;" onkeyup="settotal();"></td>
      <td>&nbsp;</td>
    </tr>
    <?php if ($parcel_type == 'Zomato') { ?>
      <tr>
        <th>Zomato</th>
        <td><input type="text" name="zomato" id="zomato" value="<?php echo $zomato; ?>" onkeyup="settotal();" value="0" style="width: 120px;" onclick="setzero(this);" onfocusout="setzero1(this);"></td>
        <td>&nbsp;</td>
      </tr>
    <?php }
    if ($parcel_type == 'Swiggy') { ?>
      <tr>
        <th>Swiggy</th>
        <td><input type="text" name="swiggy" id="swiggy" value="<?php echo $swiggy; ?>" onkeyup="settotal();" value="0" style="width: 120px;" onclick="setzero(this);" onfocusout="setzero1(this);"></td>
        <td>&nbsp;</td>
      </tr>
    <?php }
    if ($parcel_type == 'Counter_Parcel') { ?>
      <tr>
        <th>Counter Parcel</th>
        <td><input type="text" name="counter_parcel" id="counter_parcel" value="<?php echo $counter_parcel; ?>" onkeyup="settotal();" value="0" style="width: 120px;" onclick="setzero(this);" onfocusout="setzero1(this);"></td>
        <td>&nbsp;</td>
      </tr>
    <?php } ?>
  </thead>
</table>
<div class="modal-footer">
  <h2 class="pull-left">Total : <?php echo number_format($basic_bill_amt, 2);  ?></h2>
  <input type="hidden" name="billid" id="billid" value="<?php echo $billid; ?>">
  <input type="hidden" name="table_id" id="table_id" value="<?php echo $table_id; ?>">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  <button class="btn btn-primary" onClick="return rec_payment();" id="savepayment">Received Payment</button>
</div>
<script type="text/javascript">
  function settotal() {
    var payment_amt = document.getElementById("payment_amt").value;
    var zomato = document.getElementById("zomato").value;
    var swiggy = document.getElementById("swiggy").value;
    var counter_parcel = document.getElementById("counter_parcel").value;
    if (payment_amt != '' && zomato != '') {
      netamt = payment_amt - zomato;
      jQuery('#netamt').val(netamt);
    }
  }

  function setzero(currobj) {
    if (currobj.value == 0)
      currobj.value = '';
  }

  function setzero1(currobj) {
    if (currobj.value == '')
      currobj.value = 0;
  }
</script>