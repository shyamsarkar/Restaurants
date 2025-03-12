<?php include("../adminsession.php");
//print_r($_SESSION); die;


$crit = " where 1 = 1 ";
if(isset($_REQUEST['supplier_id']))
{
  $supplier_id = $_REQUEST['supplier_id'];
  if(!empty($supplier_id))
  $crit .= " and supplier_id = '$supplier_id'";
}
else
{
    $supplier_id = 0;
}


?>

  <div class="col-lg-6">                     

    <div class="panel panel-default toggle panelMove panelClose panelRefresh">
  <!-- Start .panel -->
      <div class="panel-heading">
      <h4 class="panel-title">&nbsp; Previouse Paid List</h4>

      </div>
        <?php
        //show if customer selected
        //echo $customer_id; die;
        if($supplier_id > 0)
        {

             $slno = 1;
            $arrayName = array();
            //echo "select * from master_supplier $crit";die;
            $sql = $obj->executequery("select * from master_supplier $crit");
            foreach($sql as $row_get)
            {
            $openingbal = $row_get['openingbal'];
            $open_bal_date = $row_get['open_bal_date'];
            $particular = "Opening Balance";
           
            $arrayName[]=array('led_date'=>$open_bal_date,'particular'=>$particular,'billtype'=>'openingbal','total'=>$openingbal,'led_type'=>'debit');

             //echo "<pre>";
            // print_r($arrayName);die;

            }
          
          //echo "select * from purchaseentry $crit and type = 'purchaseentry'";die;
            $sql1 = $obj->executequery("select * from purchaseentry $crit and type = 'purchaseentry'");
              foreach($sql1 as $rowget1)
              {
                $purchaseid = $rowget1['purchaseid'];
                $net_amount = $rowget1['net_amount'];
                $bill_date = $rowget1['bill_date'];
                $billno = $rowget1['billno'];
                $discount = $obj->get_total_discamt_on_bill($purchaseid);
                $netamount = $net_amount - $discount;
                $particular = "By purchaseentry Entry $billno";

              $arrayName[]=array('led_date'=>$bill_date,'particular'=>$particular,'billtype'=>'purchaseentry','total'=>$netamount,'led_type'=>'debit');
              //echo "<pre>";
               //print_r($arrayName);die;
              }

            //echo "select * from supplier_payment $crit"; die;
            $sql2 = $obj->executequery("select * from supplier_payment $crit");
              foreach($sql2 as $row_get2)
              {
              $pay_date = $row_get2['pay_date'];
              $voucher_no = $row_get2['voucher_no'];
              $paid_amt = $row_get2['paid_amt'];
              $payment_type = $row_get2['payment_type'];

              if($payment_type == 'Received' ){  $led_type = 'credit'; }else{ $led_type = 'debit'; }

              if($payment_type == 'Received' ){  $vou_type = 'Received'; }else{ $vou_type = 'Payment'; }

              $particular = "By voucher Entry $voucher_no ($vou_type)";

              $arrayName[]=array('led_date'=>$pay_date,'particular'=>$particular,'billtype'=>'voucher','total'=>$paid_amt,'led_type'=>$led_type);

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

                             //echo "<pre>";
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
                            <td><?php echo $obj->dateformatindia($key['led_date']); ?></td>
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