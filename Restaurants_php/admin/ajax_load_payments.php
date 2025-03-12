<?php include("../adminsession.php");
if (isset($_REQUEST['billid'])) {
  $billid = $obj->test_input($_REQUEST['billid']);
  $where = array('billid' => $billid);
  $bill_info = $obj->select_record('bills', $where);
  $paydate =  $bill_info['paydate'];
  $billnumber =  $bill_info['billnumber'];
  $table_id =  $bill_info['table_id'];
  $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$table_id'");
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
  <thead>
    <h3 class="widgettitle" style="color: black;">Date :&nbsp;<b><?php echo $obj->dateformatindia($paydate); ?></b>
      <input type="hidden" name="paydate" id="paydate" value="<?php echo $obj->dateformatindia($paydate); ?>" readonly style="width: 40%;">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice : <b><span style="font-weight:bold;"><?php echo $billnumber; ?></span></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Table : <b><span style="font-weight:bold;"><?php echo $table_no; ?></span></b>
    </h3>
    <tr>
      <th>Net Bill Amount</th>
      <td><input type="text" name="net_bill_amt" id="payment_amt" value="<?php echo $basic_bill_amt; ?>" readonly="true" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Cash</th>
      <td><input type="text" name="cash_amt" id="cash_amt" value="<?php echo $cash_amt; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Paytm</th>
      <td><input type="text" name="paytm_amt" id="paytm_amt" value="<?php echo $paytm_amt; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Card</th>
      <td><input type="text" name="card_amt" id="card_amt" value="<?php echo $card_amt; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Zomato</th>
      <td><input type="text" name="zomato" id="zomato" value="<?php echo $zomato; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Swiggy</th>
      <td><input type="text" name="swiggy" id="swiggy" value="<?php echo $swiggy; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Counter Parcel</th>
      <td><input type="text" name="counter_parcel" id="counter_parcel" value="<?php echo $counter_parcel; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Google Pay</th>
      <td><input type="text" name="google_pay" id="google_pay" value="<?php echo $google_pay; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Settlement Amt</th>
      <td><input type="text" name="settlement_amt" id="settlement_amt" value="<?php echo $settlement_amt; ?>" onkeyup="settotal();" value="0" style="width: 120px;"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th>Credit Amt</th>
      <td><input type="text" name="credit_amt" id="credit_amt" value="<?php echo $credit_amt; ?>" style="width: 120px;"></td>
      <td> <small id="credit_amt_error" style="color: red;" class="form-text text-muted"></small></td>
    </tr>
    <tr>
      <th>Mobile</th>
      <td><input type="text" name="cust_mobile" id="cust_mobile" value="<?php echo $cust_mobile; ?>" maxlength="10" style="width: 120px;"></td>
      <td><input type="text" name="cust_name" id="cust_name" value="<?php echo $cust_name; ?>" placeholder="Enter Customer Name"></td>
    </tr>
    <tr>
      <th>Remark</th>
      <td><input type="text" name="remarks" id="remarks" style="width: 90%;"></td>
      <td> <label><input type="checkbox" name="send_sms" id="send_sms" value="1"> SEND SMS </label></td>
    </tr>
  </thead>
</table>
<div class="modal-footer">
  <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
  <input type="hidden" name="billid" id="billid" value="<?php echo $billid; ?>">
  <input type="hidden" name="table_id" id="table_id" value="<?php echo $table_id; ?>">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  <button class="btn btn-primary" onClick="return rec_payment();" id="savepayment">Received Payment</button>
</div>