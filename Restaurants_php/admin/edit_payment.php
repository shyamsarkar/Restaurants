<?php include("../adminsession.php");
$pagename ="edit_payment.php";   
$module = "Edit Payment";
$submodule = "Edit Payment";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
$paydate = $obj->getvalfield("day_close","day_date","1=1");

if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $_GET['action'];
else
$action = 0;
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

   

    cust_name = jQuery('#cust_name').val();

    cash_amt = jQuery('#cash_amt').val();
     paytm_amt = jQuery('#paytm_amt').val();

    credit_amt = jQuery('#credit_amt').val();

    card_amt = jQuery('#card_amt').val();

    google_pay = jQuery('#google_pay').val();

    zomato = jQuery('#zomato').val();
    swiggy = jQuery('#swiggy').val();
    counter_parcel = jQuery('#counter_parcel').val();
    google_pay = jQuery('#google_pay').val();

    settlement_amt = jQuery('#settlement_amt').val();

    cust_mobile = jQuery('#cust_mobile').val();

    remarks = jQuery('#remarks').val();
    table_id = jQuery('#table_id').val();

    billid = jQuery('#billid').val();

    paydate = jQuery('#paydate').val();

    var send_sms1 = 0;
    var send_sms = document.getElementById('send_sms').checked;
    if(send_sms==true)
    var send_sms1 = 1;


  if(credit_amt > 0)

    {

         if(confirm('This Bill have creadit amount, are sure want to paid'))

         {

           if(cust_name == "")

           {

            jQuery('#credit_amt_error').html("Please Enter Customer Name For Creadit Bill as creadit");

            return false;

           }

           else

           jQuery('#credit_amt_error').html("");

       }

       else

        return false;

           

    }

    else

    {

        jQuery('#credit_amt_error').html("");

         //return false;

    }

    

  if(credit_amt!="") 

  {

      jQuery('#loaderimg').css("display", "block");

      jQuery('#savepayment').css("display", "blobk");

      jQuery('#disacrdpayment').css("display", "blobk");

      

      jQuery.ajax({

        type: 'POST',

        url: 'update_payment.php',

        data: 'cash_amt=' + cash_amt + '&paytm_amt=' + paytm_amt + '&card_amt=' + card_amt + '&google_pay=' + google_pay + '&settlement_amt=' + settlement_amt + '&remarks='+remarks + '&table_id='+table_id+'&billid='+billid+'&paydate='+paydate+'&credit_amt='+credit_amt+'&cust_name='+cust_name+'&cust_mobile='+cust_mobile+'&zomato='+zomato+'&send_sms1='+send_sms1+'&swiggy='+swiggy+'&counter_parcel='+counter_parcel,

        dataType: 'html',

        success: function(data){

       // alert(data);

         jQuery("#cash_amt").val("");

         jQuery("#paytm_amt").val("");

         jQuery("#card_amt").val("");

         jQuery("#google_pay").val("");

         jQuery("#settlement_amt").val("");

         jQuery("#credit_amt").val(""); 
         jQuery("#swiggy").val(""); 
         jQuery("#counter_parcel").val(""); 

         

         jQuery("#savepayment").removeAttr("disabled"); 

      
        location='edit_payment.php';
       
        //location='in_entry_new.php?table_id='+table_id;

         

          if(data==1)

          {

            jQuery("#save_bill_order").removeAttr("disabled");

         

           location='edit_payment.php';

           // location='edit_payment.php?table_id='+table_id;

           

          }

          else{

            // alert("Error");

        }



        if(data==2)

         {

          alert('successfully send');

         }

         if(data==3)

         {

          alert('not send');

        }

          

       }

        

    });//ajax close

      

  }//if close

  else{

        jQuery('#credit_amt_error').html("Invalid Receve Amount.");

    }//else close



     jQuery('#payment_modal').modal('hide');

}


function show_payment_modal(billid)
{

   jQuery.ajax({
        type: 'POST',
        url: 'ajax_load_payments.php',
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
              <?php include("../include/alerts.php"); ?>
              
                       
              
                
                <!--widgetcontent-->
                 <?php $chkview = $obj->check_pageview("edit_payment.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                <h4 class="widgettitle"><?php echo $submodule; ?></h4>
                
              <table class="table table-bordered" id="dyntable">
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
                            <th  class="head0">Print Bill</th>
                          
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
                        $res = $obj->executequery("Select * from bills where checked_nc!=1 and is_paid=1 and billdate='$paydate' order by billid desc");
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
                       // $total += $row_get['final_price'];
                        $billid = $row_get['billid'];

                        if($row_get['is_paid'] == 1)
                        {
                          $billstatus = "<span style='color: green';>PAID</span>";
                        }
                        else
                        {
                          $billstatus = "<span style='color: red';>PENDING</span>";
                        }

                        ?> <tr> 
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
                        <button style="margin: 3px;" type="button" class="btn btn-primary" id="btn_paybill" onclick="show_payment_modal(<?php echo $billid; ?>)"><i class="icon-file icon-white"></i> Edit Payment</button>
                      </td>
                      <td><a target="_blank" class="btn btn-info" href="pdf_restaurant_recipt.php?billid=<?php echo $billid;?>" ><i  class="icon-print" aria-hidden="true"></i></a></td>

                           
                       
                                
                                  </tr>
                      <?php

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

    <div class="modal-header color1">

      <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;" >×</button>

      <h3 id="myModalLabel">Payment Entry</h3>

    </div>

    <div class="modal-body" id="showpaymnentinput">

     
    </div>

   

  </div>


<script>



function settotal()

{

  

  var net_bill_amt=parseFloat(jQuery('#payment_amt').val()); 

  var card_amt=parseFloat(jQuery('#card_amt').val()); 

  var cash_amt=parseFloat(jQuery('#cash_amt').val()); 

  var google_pay=parseFloat(jQuery('#google_pay').val());

  var zomato=parseFloat(jQuery('#zomato').val());
  var counter_parcel=parseFloat(jQuery('#counter_parcel').val());
  var swiggy=parseFloat(jQuery('#swiggy').val());

  var settlement_amt=parseFloat(jQuery('#settlement_amt').val());

  var paytm_amt=parseFloat(jQuery('#paytm_amt').val());

  if(!isNaN(net_bill_amt) && !isNaN(cash_amt))

  {

    total = net_bill_amt - cash_amt;

  }

  else

    total = net_bill_amt;



  if(!isNaN(paytm_amt))

  {

    total1 = total - paytm_amt;

  }

  else

  total1 = total;



  if(!isNaN(card_amt))

  {

    total2 = total1 - card_amt;

  }

  else

  total2 = total1;



 if(!isNaN(zomato))

  {

    total3 = total2 - zomato;

  }

  else

  total3 = total2;

if(!isNaN(swiggy))

  {

    total4 = total3 - swiggy;

  }

  else

  total4 = total3;

if(!isNaN(counter_parcel))

  {

    total5 = total4 - counter_parcel;

  }

  else

  total5 = total4;




  if(!isNaN(google_pay))

  {

    total6 = total5 - google_pay;

  }

  else

  total6 = total5;

 

  if(!isNaN(settlement_amt))

  {

    total7 = total6 - settlement_amt;

  }

  else

  total7 = total6;



  jQuery('#credit_amt').val(total7.toFixed(2));

} 

  
  </script>
    

</body>

</html>
