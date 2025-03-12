<?php
include("../adminsession.php");
$pagename = "view_payment.php";
$module = " Payment Entry";
$submodule = " PAYMENT ENTRY";
$tblname = "bill_payment";
$tblpkey = "bill_pay_id";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parakh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes, viewport-fit=cover user-scalable=no">
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <link rel="stylesheet" href="materialize/css/icon.css">
  <link rel="stylesheet" href="materialize/css/animate.min.css"/>
  <style>
   .bg{
      background: #141E30;  
      background: -webkit-linear-gradient(to bottom, #243B55, #141E30);  
      background: linear-gradient(to bottom, #243B55, #141E30); 
   }
   nav .nav-title {
      display: inline-block;
      font-size: 25px;
      padding: 0px 0px 40px 0;
   }
   td, th {
      padding: 5px 5px;
      font-size: small;
   }
   tr {
      border-bottom: none;
   }
  </style>
</head>
<body>
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
   <div class="container" style="width: 95%;">
      <div class="row">
         <div class="col s12 m6 offset-m3">
             <ul class="tabs z-depth-2">
               <li class="tab bg col s2">
                  <a target="_self" href="add_payment.php">Add</a>
               </li>
               <li class="tab bg col s2">
                  <a class="active" href="#">View</a>
               </li>
            </ul><br>
              <?php
              $slno = 1;

              $res = $obj->executequery("select * from bill_payment order by bill_pay_id desc");
              foreach($res as $row_get)
              {

                 $bill_pay_id = $row_get['bill_pay_id'];
                  $customer_id = $row_get['customer_id'];
                  $supplier_id = $row_get['supplier_id'];
                  $curr_paid_amt = $row_get['curr_paid_amt'];

                  if($row_get['saleid']==0)
                   $sale_ids = $row_get['sale_ids'];
                  else
                   $sale_ids = $row_get['saleid'];

                  $check_date = $obj->dateformatindia($row_get['check_date']);
                  $check_no = $row_get['check_no'];
                  $bank_name = $row_get['bank_name'];
                  $cust_id = $obj->getvalfield("saleentry","customer_id","saleid='$sale_ids'");
                  $cust_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");
                  $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
                 

                  $bill_no = '';
                  if($sale_ids!="")
                  {
                    $arr = explode(',',$sale_ids);
                    foreach($arr as $i)
                    {
                      $bill_no .= $obj->getvalfield("saleentry","billno","saleid='$i'").', ';
                    }// for each close
                  }//if close

              ?>
                <div class="card-panel" style="padding: 10px;">
               <table>
                  <tr style="border-bottom:1px solid #ddd;">
                     <td>Bill No.</td><td><strong><?php echo $bill_no; ?></strong></td>
                     <td>Pay_Date: </td><td class="right-align"><strong><?php echo $obj->dateformatindia($row_get['pay_date']); ?></strong></td>
                  </tr>
                  <tr>
                     <td>Supplier</td>
                     <td colspan="3" class="right-align"><strong><?php echo $supplier_name; ?></strong></td>
                  </tr>
                  <tr>
                     <td>Customer</td>
                     <td colspan="3" class="right-align"><strong><?php echo $cust_name; ?></strong></td>
                  </tr>
                  <tr>
                     <td>Bank Name</td>
                     <td colspan="3" class="right-align"><strong><?php echo $bank_name; ?></strong></td>
                  </tr>
                  <tr>
                     <td>Cheque No.</td>
                     <td colspan="3" class="right-align"><strong><?php echo $check_no; ?></strong></td>
                  </tr>
                  <tr>
                     <td>Cheque Date</td>
                     <td colspan="3" class="right-align"><strong><?php echo $check_date; ?></strong></td>
                  </tr>
                  <tr>
                     <td>Payment Mode</td>
                     <td colspan="3" class="right-align"><strong><?php echo $row_get['payment_mode']; ?></strong></td>
                  </tr>
                   <tr>
                     <td>Remark</td>
                     <td colspan="3" class="right-align"><strong><?php echo $row_get['remark']; ?></strong></td>
                  </tr>
                  <tr class="blue lighten-5">
                     <td >Paid Amount</td>
                     <td colspan="3" class="right-align"><strong>&#x20b9; <?php echo round($curr_paid_amt,2); ?>/-</strong></td>
                  </tr>
                  <tr>
                     <td colspan="4">
                        <a href="../admin/pdf_pay_slip.php?bill_pay_id=<?php echo $bill_pay_id; ?>" target="_blank" class="btn orange btn-small" style="width: 49%;border-radius: 50px;"><i class="material-icons left">print</i> Print</a>
                        <button type="button" class="btn red btn-small"  style="width: 49%;border-radius: 50px;" onclick='funDel(<?php echo $row_get['bill_pay_id']; ?>);'><i class="material-icons left">delete_sweep</i> Delete</button>
                        
                     </td>
                  </tr>
               </table>
            </div>
           <?php } ?> 
         </div>
      </div>
   </div>
 
  <script src="materialize/js/jquery.min.js"></script>
  <script src="materialize/js/materialize.min.js"></script>
  <script src="materialize/js/app.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script>
   $(document).ready(function(){
      $('.tabs').tabs();
   });

   function funDel(id)
  { // alert(id);   
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
    
    swal({
        title: "Are you sure! You want to delete this record.",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })

      .then((willDelete) => {
        if (willDelete) {
          
          jQuery.ajax({
          type: 'POST',
          url: '../admin/ajax/delete_master_payment.php',
          data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
          dataType: 'html',
          success: function(data){ 
          var gourl = 'view_payment.php';

            location = gourl;
        }
      });
      }
     
    });
  } //fun close
  </script>
</body>
</html>