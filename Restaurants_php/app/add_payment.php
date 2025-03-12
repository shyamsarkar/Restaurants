<?php
include("../adminsession.php");
$pagename = "add_payment.php";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "bill_payment";
$tblpkey = "bill_pay_id";
$all_bills_ids = "";
$disc_amt = "";
$sessionid = $obj->getvalfield("m_session","sessionid","status=1");
if(isset($_GET['bill_pay_id']))
{
  $keyvalue = $_GET['bill_pay_id'];
}
else
{
  $keyvalue = 0;
}
$supplier_id = "";
$customer_id = '';
if(isset($_GET['action']))
  $action = $obj->test_input($_GET['action']);
else
  $action = "";
$pay_date = date('d-m-Y');
$curr_paid_amt = "";
$voucher_no = $obj->getcode_supay($tblname,$tblpkey,"1=1");

if(isset($_POST['submit']))
{
  //print_r($_POST);die;

  $supplier_id = $obj->test_input($_POST['supplier_id']);
  $customer_id = $obj->test_input($_POST['customer_id']);
  $pay_date = $obj->dateformatusa($_POST['pay_date']);
  $bank_name  = $obj->test_input($_POST['bank_name']);
  $check_no  = $obj->test_input($_POST['check_no']);
  $check_date = $obj->dateformatusa($_POST['check_date']);
  $curr_paid_amt = $obj->test_input($_POST['curr_paid_amt']);
  $voucher_no = $obj->test_input($_POST['voucher_no']);
  $payment_mode = $obj->test_input($_POST['payment_mode']);
  $remark = $obj->test_input($_POST['remark']);
  $totalvalue  = $obj->test_input($_POST['sale_ids']);
  $sale_ids = $obj->test_input($_POST['sale_ids']);
  $all_bills_ids = $obj->test_input($_POST['all_bills_ids']);

 
  if($keyvalue == 0)
  {  
      $form_data = array('supplier_id'=>$supplier_id,'customer_id'=>$customer_id,'voucher_no'=>$voucher_no,'pay_date'=>$pay_date,'check_date'=>$check_date,'bank_name'=>$bank_name,'check_no'=>$check_no,'curr_paid_amt'=>$curr_paid_amt,'sessionid'=>$sessionid,'remark'=>$remark,'payment_mode'=>$payment_mode,'sale_ids'=>$sale_ids,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
      $lastid = $obj->insert_record_lastid($tblname,$form_data);

      $arr = explode(',',$all_bills_ids);

      $count = sizeof($arr);
      if($count > 0)
      {
        foreach($arr as $i)
        {
          if($i > 0)
          {

            $textboxname = "recamt".$i;
            $textboxname1 = "disc_amt".$i;
  
            if(isset($_POST["$textboxname"]))
            {


              $recamt = $_POST["$textboxname"];
             
              if(isset($_POST["$textboxname1"]))
                $disc_amt = $_POST["$textboxname1"];
              else
                $disc_amt = 0;

              if($recamt > 0)
              {
                $billamt = $obj->getvalfield("saleentry","net_amount","saleid='$i'");
                $old_pay = $obj->getvalfield("payment_details","sum(recamt)","sale_id='$i'");
                $total_paid = $recamt + $old_pay;

                if($billamt <= $total_paid)
                $is_completed = 1;
                else
                $is_completed = 0;

                $form_data = array('bill_pay_id'=>$lastid,'sale_id'=>$i,'recamt'=>$recamt, 'disc_amt'=>$disc_amt, 'is_completed'=>$is_completed);

                $obj->insert_record('payment_details',$form_data); 

                if($is_completed == 1)
                {
                  $where = array('sale_id'=>$i);
                  $form_data = array('is_completed' => $is_completed);
                  $obj->update_record("payment_details",$where,$form_data); 
                }
              }
            }
            //die;
          }
        } 
      }//if close     
    
    $action=1;
    $process = "insert";

  }
  
  echo "<script>location='$pagename?action=$action'</script>";
}
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
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
   .modal.modal-fixed-footer {
      padding: 0;
      height: 100%;
   }
   .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 35px;
      user-select: none;
      -webkit-user-select: none;
   }
   .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
      line-height: 35px;
   }
   .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 26px;
      position: absolute;
      top: 10px;
      right: 1px;
      width: 20px;
   }
   .select2-container--default .select2-selection--single {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-top: 5px;
   }
  </style>
</head>
<body class="" onload="getsuppid();">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
  <div class="container" style="width: 95%;">
     <div class="row">
        <div class="col s12 m6 offset-m3">
            <ul class="tabs z-depth-2">
               <li class="tab bg col s2">
                  <a href="add_payment.php">Add</a>
               </li>
               <li class="tab bg col s2">
                  <a target="_self" href="view_payment.php">View</a>
               </li>
            </ul><br>
             <form  method="post" action="">
            <div class="row">
               <div class="input-field col s12">
               
                  <select class="js-example-basic-single browser-default" name="supplier_id" id="supplier_id" onChange="getsuppid();">
                     <option value="">Select Supplier</option>
                     <?php
                     $res = $obj->executequery("select * from master_supplier order by supplier_name");
                     foreach($res as $row)
                     {
                     ?> 
                     <option value="<?php echo $row['supplier_id']; ?>"><?php echo strtoupper($row['supplier_name']); ?></option>
                     <?php
                     }
                     ?>
                  </select>
                  <label class="active">Supplier <span style="color:#F00;">*</span></label>
                  
                   <script>document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>' ;</script>
               </div>
               <div class="input-field col s12">
                  <select name="customer_id" id="customer_id" onChange="getsuppid();" class="js-example-basic-single browser-default">
                     <option value="">Select Customer</option>
                    <?php
                    $res = $obj->executequery("select * from master_customer order by customer_name");
                    foreach($res as $row)
                    {
                    ?> 
                    <option value="<?php echo $row['customer_id']; ?>"><?php echo strtoupper($row['customer_name']); ?></option>
                    <?php
                    }
                    ?>
                    </select>
                  
                  <label class="active">Customer <span style="color:#F00;">*</span></label>
                  <script>document.getElementById('customer_id').value = '<?php echo $customer_id; ?>' ;</script>
               </div>
              
               <div class="input-field col s12" id="hideid">

                <input type="hidden" id="customer_id1" value="<?php echo $customer_id ?>">
                <input type="hidden" id="supplier_id1" value="<?php echo $supplier_id ?>">
                 <!--  <button onclick="paymodal()" data-target="modal1" class="btn modal-trigger" style="border-radius:50px;">View Bill</button> -->
                  <button onclick="paymodal()" data-target="modal1" class="btn modal-trigger" style="border-radius:50px;">Select Bills for Payment</button>
               </div>
             
               <div class="input-field col s12">
                  <input type="text" name="voucher_no" id="voucher_no" value="<?php echo $voucher_no; ?>" class="validate" placeholder="Enter Voucher Number" readonly>
                  <label class="active">Voucher Number <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                 <!--  <input id="" type="text" name="" class="validate"  placeholder="Enter Bank Name"> -->
                   <input list="browsers" name="bank_name" id="bank_name" placeholder="Enter Bank Name" class="validate">
              <datalist id="browsers">
              <?php
              $res = $obj->executequery("select * from bill_payment group by bank_name");
              foreach ($res as $row_get )
              { 
                ?>
              <option value="<?php echo $row_get['bank_name']; ?>">
              <?php } ?>
             
              </datalist>
                  <label class="active">Bank Name</label>
               </div>
               <div class="input-field col s12">
                  <input type="text" name="check_no" id="check_no" class="validate" placeholder="Enter Cheque No.">
                  <label class="active">Cheque No.</label>
               </div>
               <div class="input-field col s12">
                  <input type="text" name="check_date" id="check_date" class="datepicker" placeholder="dd-mm-yyyy">
                  <label class="active">Cheque Date</label>
               </div>
               <div class="input-field col s12">
                  <input type="text" name="pay_date" id="pay_date" class="validate datepicker" placeholder="Enter Deposit Date">
                  <label class="active">Deposit Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                  <input type="text" name="curr_paid_amt" id="curr_paid_amt" readonly value="<?php echo $curr_paid_amt; ?>" class="validate" placeholder="Enter Paid Amount">
                  <label class="active">Paid Amount <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                  <select name="payment_mode" id="payment_mode" >
                     <option value="" selected>Select</option>
                      <option value="cash">Cash</option>
                      <option value="cheque">Cheque</option>
                      <option value="neft">NEFT</option>
                      <option value="rtgs">RTGS</option>
                      <option value="paytm">PAYTM</option>
                    </select>
                  
                  <label>Pay Mode <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                  <input type="text" name="remark" id="remark" class="validate" placeholder="Remark">
                  <label class="active">Remark</label>
               </div>
               <div class="input-field col s6 right-align">
                
             
                  <button type="submit" name="submit" class="btn bg" style="border-radius:50px;width:80%;" onClick="return checkinputmaster('supplier_id,customer_id,voucher_no,pay_date,curr_paid_amt,payment_mode'); ">Save</button>
                  <!-- onclick="save_payment();" -->
               </div>
               <div class="input-field col s6">
                  <a href="add_payment.php" class="btn red" style="border-radius:50px;width:80%;">Reset</a>
               </div>
            </div>
          <div id="modal1" class="modal modal-fixed-footer" style="top: 0%;width:100%;bottom: 10%;max-height:100%;">
          <div id="showsaleentry"></div>

          </div>
         </form>
        </div>
     </div>
  </div>
  <!-- Modal Structure -->
  
  <script src="materialize/js/jquery.min.js"></script>
  <script src="materialize/js/materialize.min.js"></script>
  <script src="materialize/js/app.js"></script>
  <script src="js/sweetalert.min.js"></script>
  <script src="js/commonfun2.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
   $(document).ready(function(){
      $('.modal').modal();
      $('.tabs').tabs();
      $('.datepicker').datepicker({
         format:'dd-mm-yyyy'
      });
   });


   <?php

if(isset($_GET['action'])==1)

{?>

 swal("Data Save successfully!")
               .then((value) => {

                  var gourl = 'add_payment.php';

                  location = gourl;

               });

<?php

}

?>

   /* function save_payment()
{
   
   var  supplier_id= document.getElementById('supplier_id').value;
   var  customer_id= document.getElementById('customer_id').value;
   var  voucher_no= document.getElementById('voucher_no').value;
   var  bank_name= document.getElementById('bank_name').value;
   var  check_no= document.getElementById('check_no').value;
   var  check_date= document.getElementById('check_date').value;
   var  pay_date= document.getElementById('pay_date').value;
   var  curr_paid_amt= document.getElementById('curr_paid_amt').value;
   var  payment_mode= document.getElementById('payment_mode').value;
   var  remark= document.getElementById('remark').value;
   
   if(supplier_id =='')
   {
      alert('Supplier Name cant be blank');  
      document.getElementById("supplier_id").focus();
  
      return false;
   }
   if(customer_id=='')
   {
      alert('Customer Name Cant be blank');
      document.getElementById("customer_id").focus();
      return false;
   }

    if(voucher_no=='')
   {
      alert('Voucher No. Cant be blank');
      document.getElementById("voucher_no").focus();
      return false;
   }
    if(pay_date=='')
   {
      alert('Deposit Date Cant be blank');
      document.getElementById("pay_date").focus();
      return false;
   }
    if(curr_paid_amt=='')
   {
      alert('Paid Amount Cant be blank');
      document.getElementById("curr_paid_amt").focus();
      return false;
   }
    if(payment_mode=='')
   {
      alert('Pay Mode Cant be blank');
      document.getElementById("payment_mode").focus();
      return false;
   }
   else
   {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax_save_payment.php',
        data: 'supplier_id='+supplier_id+'&customer_id='+customer_id+'&voucher_no='+voucher_no+'&pay_date='+pay_date+'&curr_paid_amt='+curr_paid_amt+'&payment_mode='+payment_mode+'&check_no='+check_no+'&bank_name='+bank_name+'&check_date='+check_date+'&remark='+remark,
        dataType: 'html',
        success: function(data){ 
       // console.log(data);          
         //alert(data); 
        
             if(data==1)

             {

               swal("Data Save successfully!")
               .then((value) => {

                  var gourl = 'add_customer.php';

                  location = gourl;

               });

             }
         }
        });//ajax close
    
   }
}*/
  </script>

  <script type="text/javascript">
      $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });



      function getsuppid()
      {
        var customer_id = document.getElementById('customer_id').value;
        var supplier_id = document.getElementById('supplier_id').value;
       

      if(supplier_id!='' && customer_id!='')
      {
        $("#hideid").show();
         // alert(customer_id);alert(supplier_id);
        $('#customer_id1').val(customer_id);
        $('#supplier_id1').val(supplier_id);

      }
      else
      {
        $("#hideid").hide();
        $('#customer_id1').val('');
        $('#supplier_id1').val('');
      }

      }

      function paymodal()
      {
        
         var customer_id = document.getElementById('customer_id1').value;
         var supplier_id = document.getElementById('supplier_id1').value;
        
        jQuery('#curr_paid_amt').val("");
        jQuery('#customer_id1').val(customer_id);
        jQuery('#supplier_id1').val(supplier_id);
        //alert(customer_id);alert(supplier_id);
        get_paydetails(customer_id,supplier_id);
        jQuery('#modal1').modal('show');

        
        
      }

     

      function hidemodal()
      {
      jQuery("#modal1").hide();
      }


      function get_paydetails(customer_id,supplier_id)

{
//alert(customer_id);alert(supplier_id);
if(customer_id > 0 && supplier_id > 0)
{



    jQuery.ajax({

    type: 'POST',

    url: 'ajax_show_saleentry_record.php',

    data: 'customer_id='+customer_id+'&supplier_id='+supplier_id,

    dataType: 'html',

    success: function(data){

    //alert(data);

    jQuery("#showsaleentry").html(data);
    }
    });//ajax close
   } 
}

   </script>

   
</body>
</html>