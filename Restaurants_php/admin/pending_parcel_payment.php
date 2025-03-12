<?php include("../adminsession.php");
$pagename ="pending_parcel_payment.php";   
$module = "Pending Parcel Payment";
$submodule = "Pending Parcel Payment";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
$paydate = $obj->getvalfield("day_close","day_date","1=1");

if(isset($_GET['billid']))

{
  $keyvalue = $_GET['billid'];

}
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $_GET['action'];
else
$action = 0;

$crit = " where 1 = 1 ";
if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
  $from_date = $obj->dateformatusa($_GET['from_date']);
  $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  /*$to_date =date('Y-m-d');
  $from_date =date('Y-m-d');*/
  $to_date ='';
  $from_date ='';
  
}
if(isset($_GET['from_date']) && isset($_GET['to_date']))
{
  $crit .= " and billdate between '$from_date' and '$to_date'"; 
}

$search_sql = "";




?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>

<script type="text/javascript">
    
function rec_payment()
 {
//alert('jii');
    var result = 'true';

    net_bill_amt = jQuery('#hidden_net_bill_amt').val();

   // alert(net_bill_amt);

    zomato = jQuery('#zomato').val();
    swiggy = jQuery('#swiggy').val();
    counter_parcel = jQuery('#counter_parcel').val();
    table_id = jQuery('#table_id').val();
    billid = jQuery('#billid').val();
    paydate = jQuery('#paydate').val();

 

      jQuery('#loaderimg').css("display", "block");

      jQuery('#savepayment').css("display", "blobk");

      jQuery('#disacrdpayment').css("display", "blobk");

      

      jQuery.ajax({

        type: 'POST',

        url: 'parcel_payment.php',

        data: 'zomato=' + zomato + '&swiggy=' + swiggy + '&counter_parcel=' + counter_parcel + '&table_id='+table_id+'&billid='+billid+'&paydate='+paydate,

        dataType: 'html',

        success: function(data){

       // alert(data);
         
         jQuery("#zomato").val(""); 
         jQuery("#swiggy").val(""); 
         jQuery("#counter_parcel").val(""); 
         jQuery("#savepayment").removeAttr("disabled"); 
      
        location='pending_parcel_payment.php';

          if(data==1)

          {
            jQuery("#save_bill_order").removeAttr("disabled");
           location='pending_parcel_payment.php';
          }
       }

    });//ajax close

     jQuery('#payment_modal').modal('hide');

}


function show_payment_modal(billid)
{

   jQuery.ajax({
        type: 'POST',
        url: 'ajax_parcel_load_payments.php',
        data: 'billid=' + billid,
        dataType: 'html',
        success: function(data){
       // alert(data);
        jQuery("#showpaymnentinput").html(data);
       }


    });//ajax close


   jQuery('#payment_modal').modal('show');

}

</script>
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

             
              <td><input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
               value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

               <td><input type="text" name="to_date" id="to_date" class="input-medium"  placeholder='dd-mm-yyyy'
                 value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>


                 <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>
                 <td>&nbsp; <a href="pending_parcel_payment.php"  name="reset" id="reset" class="btn btn-success">Reset</a></td>
               </tr>
             </table>
           <div>      
           </form>
              
              
                       
              
                
                <!--widgetcontent-->
                 <?php $chkview = $obj->check_pageview("pending_parcel_payment.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                <h4 class="widgettitle"><?php echo $submodule; ?></h4>
                
              <table class="table table-bordered table-condensed" id="dyntable">
                    <colgroup>
                        <col class="con0" style="align: center; width: 4%" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th  width="7%" class="head0 nosort">S.No.</th>
                            <th  class="head0">Bill Info</th>
                            <th  class="head0">Table Info</th>
                            <th  class="head0">Paid Amt details</th>
                            <th  class="head0">CreditAmt</th>
                            <th  class="head0">Edit Payment</th>
                           <!--  <th  class="head0">Print Bill</th> -->
                          
                        </tr>
                    </thead>
                    <tbody id="record">
                    
                        <?php
                        $slno=1;
                        $tot_disc_rs=0;
                        $tot_settlement_amt=0;
                        $subtotal=0;
                        $tot_rec_amt = 0;
                        $total_cancelled_amt = 0;
                        $net_balance = 0;

                        $res = $obj->executequery("Select * from bills $crit and is_parcel_order=1 and is_paid=1 order by billid desc");
                        foreach($res as $row_get)
                        {

                        $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
                        $settlement_amt = $row_get['settlement_amt'];
                        $disc_rs = $row_get['disc_rs'];
                        $disc_percent = $row_get['disc_percent'];
                        $cust_name = $row_get['cust_name'];
                        $cust_mobile = $row_get['cust_mobile'];
                        $remarks = $row_get['remarks'];
                        $credit_amt1 = $row_get['credit_amt'];
                      
                        $billid = $row_get['billid'];

                        $balance = $row_get['net_bill_amt'] - $row_get['cash_amt'] - $row_get['paytm_amt'] - $row_get['card_amt']- $row_get['settlement_amt'] - $row_get['google_pay'] - $row_get['zomato'] - $row_get['swiggy'] - $row_get['counter_parcel'];

                        if($row_get['is_paid'] == 1)
                        {
                          $billstatus = "<span style='color: green';>PAID</span>";
                        }
                        else
                        {
                          $billstatus = "<span style='color: red';>PENDING</span>";
                        }

                        if($balance >= $row_get['basic_bill_amt'])
                        {
                        ?> 
                        <tr> 
                        <td style="text-align:center;"><?php echo $slno++; ?></td> 
                        <td>
                          <?php echo $row_get['billnumber']; ?><br>
                          <?php echo "BillDate".$obj->dateformatindia($row_get['billdate']); ?><br>
                          <?php echo "Bill Time".$row_get['billtime']; ?><br>
                          <?php echo "Payment: ".$billstatus; ?>
                        </td>
                        <td style="text-align:center;">
                          <?php echo "Table: ".strtoupper($table_no); ?><br>
                          <?php echo "BillAmt: ".number_format(round($row_get['basic_bill_amt']),2); ?><br>
                          <?php echo strtoupper($row_get['parsal_status']); ?>
                        </td>
                        
                        <td>
                          <?php echo "Cash: ".number_format($row_get['cash_amt'],2); ?><br>
                          <?php echo "Card: ".number_format($row_get['card_amt'],2); ?><br>
                          <?php echo "Paytm: ".number_format($row_get['paytm_amt'],2); ?><br>
                          <?php echo "G-Pay: ".number_format($row_get['google_pay'],2); ?><br>
                          <?php echo "Zomato: ".number_format($row_get['zomato'],2); ?><br>
                          <?php echo "Swiggy: ".number_format($row_get['swiggy'],2); ?><br>
                          <?php echo "Counter Parcel: ".number_format($row_get['counter_parcel'],2); ?><br>
                          <?php echo "Settlement: ".number_format($row_get['settlement_amt'],2); ?>
                          
                        </td>
                        <td>
                          <?php echo number_format($row_get['credit_amt'],2); ?><br>
                          <?php echo "Customer: ".strtoupper($cust_name); ?><br>
                          <?php echo "Mobile: ".$cust_mobile; ?><br>
                          <?php echo "Remark: ".$remarks; ?>
                        </td>

                      
                       <td>
                        <button style="margin: 3px;" type="button" class="btn btn-primary" id="btn_paybill" onclick="show_payment_modal(<?php echo $billid; ?>)"><i class="icon-file icon-white"></i> Add Payment</button>
                      </td>
                     <!--  <td><a target="_blank" class="btn btn-info" href="pdf_restaurant_recipt.php?billid=<?php echo $billid;?>" ><i  class="icon-print" aria-hidden="true"></i></a></td> -->

                           
                       
                                
                                  </tr>
                      <?php
                       }//close if loop
                      }
                      ?>
                    </tbody>
                </table>
                <br>
              
              <?php  } ?>
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

    
</div><!--mainwrapper-->

 <!--product add modal-->

  <div id="payment_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-body" id="showpaymnentinput">

     
    </div>

   

  </div>
  <script type="text/javascript">
    jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();
  </script>
</body>
</html>
