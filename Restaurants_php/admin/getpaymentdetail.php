<?php include("../adminsession.php");
//print_r($_SESSION); die;


$crit = " where 1 = 1 ";
if(isset($_REQUEST['customer_id']))
{
  $customer_id = $_REQUEST['customer_id'];
  if(!empty($customer_id))
    $crit .= " and customer_id = '$customer_id'";
}
else
{
    $customer_id = 0;
}


?>

  <div class="col-lg-6">                     

    <div class="panel panel-default toggle panelMove panelClose panelRefresh">
  <!-- Start .panel -->
      <div class="panel-heading">
      <h4 class="panel-title">&nbsp; Previouse Paid List (Session : <?php echo $obj->getvalfield("m_session","session_name","sessionid='$sessionid'"); ?>)</h4>

      </div>
        <?php
        //show if customer selected
        //echo $customer_id; die;
        if($customer_id > 0)
        {

            $slno = 1;
            $arrayName = array();
            //echo "select * from master_customer $crit";die;
            $sql = $obj->executequery("select * from master_customer $crit and company_id = $company_id");
            foreach($sql as $row_get)
            {
            $openingbal = $row_get['openingbal'];
            $open_bal_date = $obj->dateformatindia($row_get['open_bal_date']);
            $particular = "Opening Balance";
            $company_id = $row_get['company_id'];
            $company_name = $obj->getvalfield("company_setting","company_name","company_id=$company_id");
            $arrayName[]=array('led_date'=>$open_bal_date,'particular'=>$particular,'billtype'=>'openingbal','company_name'=>$company_name,'total'=>$openingbal,'led_type'=>'debit');

             //echo "<pre>";
            // print_r($arrayName);die;

            }
          
           //echo "select * from purchaseentry $crit and company_id = $company_id and type = 'saleentry'";die;
            $sql = $obj->executequery("select * from purchaseentry $crit and company_id = $company_id and type = 'saleentry'");


              foreach($sql as $row_get)
              {
              $purchaseid = $row_get['purchaseid'];
              $net_amount = $row_get['net_amount'];
              $bill_date = $obj->dateformatindia($row_get['bill_date']);
              $billno = $row_get['billno'];
              $customer_id = $row_get['customer_id'];

              $company_id = $row_get['company_id'];
              $company_name = $obj->getvalfield("company_setting","company_name","company_id=$company_id");

              $particular = "By saleentry Entry $billno";


              $arrayName[]=array('led_date'=>$bill_date,'particular'=>$particular,'billtype'=>'saleentry','company_name'=>$company_name,'total'=>$net_amount,'led_type'=>'debit');
             // echo "<pre>";
              // print_r($arrayName);die;
              }

            //echo "select * from voucherentry $crit and company_id = $company_id"; die;
            $sql = $obj->executequery("select * from voucherentry $crit and company_id = $company_id");
              foreach($sql as $row_get)
              {
              $pay_date = $obj->dateformatindia($row_get['pay_date']);
              $voucher_no = $row_get['voucher_no'];
              $customer_id = $row_get['customer_id'];
              //$customer_name = $obj->getvalfield("master_customer","customer_name","customer_id=$customer_id");
              $company_id = $row_get['company_id'];
              $company_name = $obj->getvalfield("company_setting","company_name","company_id=$company_id");
              $paid_amt = $row_get['paid_amt'];
              $payment_type = $row_get['payment_type'];

              if($payment_type == 'Received' ){  $led_type = 'credit'; }else{ $led_type = 'debit'; }

              if($payment_type == 'Received' ){  $vou_type = 'Received'; }else{ $vou_type = 'Payment'; }

              $particular = "By voucher Entry $voucher_no ($vou_type)";

              $arrayName[]=array('led_date'=>$pay_date,'particular'=>$particular,'billtype'=>'voucher','company_name'=>$company_name,'total'=>$paid_amt,'led_type'=>$led_type);

              // echo "<pre>";
              // print_r($arrayName);die;

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

                            // echo "<pre>";
                            // print_r($arrayName);die;

                            ?>
                            <br>
                            
                             <table class="table table-bordered table-condensed" id="tblData" style="font-size: 12px;">
                            <tr>
                                <td>Slno</td>
                                <td>Date</td>
                                <td>Particular</td>
                                <td>Ledgertype</td>
                                <td>Debit</td>
                                <td>Credit</td>
                                <td>Balance</td>
                            </tr>

                    <?php
                        $balance = 0;
                        $total_debit = 0;
                        $total_credit = 0;
                        $total_balance = 0;
                        foreach ($arrayName as $key)
                      {
                        if($key['led_type'] == 'debit')
                        { 
                            $credit = 0;
                            $debit = $key['total'];
                            $total_debit +=  $debit;
                        }
                        else
                        {
                            $debit = 0;
                            $credit = $key['total'];
                            $total_credit += $credit;
                        }

                        $balance +=  $debit - $credit;
                    ?>
                    <tr>
                            <td><?php echo $slno++; ?></td>
                            <td><?php echo $key['led_date']; ?></td>
                            <td><?php echo $key['particular']; ?></td>
                            <td><?php echo $key['billtype']; ?></td>
                            <td style="text-align: right;"><?php echo number_format($debit,2); ?></td>
                            <td style="text-align: right;"><?php echo number_format($credit,2); ?></td>
                            <td style="text-align: right;"><?php echo number_format($balance,2); ?></td>
                         </tr>
                     <?php
                        } //close foreach loop
                        ?>
                        <tr>
                                <td colspan="4">Total : </td>
                                <td style="text-align: right;"><?php echo number_format($total_debit,2); ?></td>
                                <td style="text-align: right;"><?php echo number_format($total_credit,2); ?></td>
                                <td style="text-align: right;"><?php echo number_format(($total_debit - $total_credit),2); ?></td>
                            </tr>
                            </table>
                            </div>
                        </div>