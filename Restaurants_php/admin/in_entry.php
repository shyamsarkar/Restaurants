<?php include("../adminsession.php");
//print_r($_SESSION);

if(isset($_GET['zomato']))
$zomato = $_GET['zomato'];
else
$zomato = "";
$floor_idt = "";
$table_idt = "";
$pagename = "in_entry.php";
$module = "Bill Entry";
if($zomato!=""){
$submodule = "Bill Entry For Zomato Order";
}
else
{
  $submodule = "Bill Entry For Table Order";
}
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "bill_details";
$tblpkey = "billdetailid";


$paydate = $obj->getvalfield("day_close","day_date","1=1");

if(isset($_GET['floor_id']))
{
	
$floor_id = $_GET['floor_id'];
$floor_name = $obj->getvalfield("m_floor","UPPER(floor_name)","floor_id='$floor_id'");
}
else
$floor_id = "";


$table_id = "";
$billid =0;

if(isset($_GET['table_id']))
{
  $table_id = $_GET['table_id'];
  $table_no = $obj->getvalfield("m_table","UPPER(table_no)","table_id='$table_id'");

  $billid = $obj->getvalfield("bills","billid","table_id='$table_id' and is_paid = 0");

   $floor_id_zr = $obj->getvalfield("m_table","floor_id","table_id='$table_id'");

  if($billid == "")
  $billid = 0;
  
}
else
$floor_id_zr = 0;
// if(isset($_GET['table_id']))
// $table_id_search = addslashes(trim($_GET['table_id']));
// else
// $table_id_search = "";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
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
    <script type="text/javascript">
function get_table_no()
{
  //alert('hiii');
  var floor_id = document.getElementById('floor_id').value;
  
  jQuery.ajax({
        type: 'POST',
        url: 'showsubpaymenthead.php',
        data: 'floor_id='+floor_id,
        dataType: 'html',
        success: function(data){          
        //alert(data);
        jQuery("#table_id").html(data);
     
        }
        });//ajax close
      
}

function rec_payment()
 {

    var result = 'true';
    net_bill_amt = jQuery('#hidden_net_bill_amt').val();
   // alert(net_bill_amt);
   
    cust_name = jQuery('#cust_name').val();
    cash_amt = jQuery('#cash_amt').val();
    credit_amt = jQuery('#credit_amt').val();
    paytm_amt = jQuery('#paytm_amt').val();
    card_amt = jQuery('#card_amt').val();
    google_pay = jQuery('#google_pay').val();
    settlement_amt = jQuery('#settlement_amt').val();
    cust_mobile = jQuery('#cust_mobile').val();
    remarks = jQuery('#remarks').val();
    table_id = '<?php echo $table_id; ?>';
    floor_id = '<?php echo $floor_id; ?>';
    billid = '<?php echo $billid; ?>';
    billid = jQuery('#billid').val();
    paydate = jQuery('#paydate').val();
    zomato = '<?php echo $zomato; ?>';
    if(zomato!="")
    {
      zomato1 = zomato;
    }
    else
    {
      zomato1 = "";
    }
    //alert(paydate);
  
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
        url: 'save_order_payment.php',
        data: 'cash_amt=' + cash_amt + '&paytm_amt=' + paytm_amt + '&card_amt=' + card_amt + '&google_pay=' + google_pay + '&settlement_amt=' + settlement_amt + '&remarks='+remarks + '&table_id='+table_id+'&billid='+billid+'&paydate='+paydate+'&credit_amt='+credit_amt+'&cust_name='+cust_name+'&cust_mobile='+cust_mobile,
        dataType: 'html',
        success: function(data){
        //alert(data);
         jQuery("#cash_amt").val("");
         jQuery("#paytm_amt").val("");
         jQuery("#card_amt").val("");
         jQuery("#google_pay").val("");
         jQuery("#settlement_amt").val("");
         jQuery("#credit_amt").val(""); 
         
         jQuery("#savepayment").removeAttr("disabled"); 
         location='in_entry.php?zomato='+zomato1+'&floor_id='+floor_id+'&table_id='+table_id;   
         
          if(data > 0)
          {
            jQuery("#save_bill_order").removeAttr("disabled"); 
            location='in_entry.php?zomato='+zomato1+'&floor_id='+floor_id+'&table_id='+table_id;
           
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
}


    </script>
</head>

<!-- onload="show_product_data();" -->
<body onLoad="getrecord();show_product_data();get_notification();">
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
                  <div class="widgetcontent  shadowed nopadding">
                    <form class="stdform stdform2" method="get" action="">
                        <?php echo $duplicate; ?>


      <table class="table table-condensed table-bordered alert alert-info">

        <tr>

          <td><strong style="color: black;">Table / Floor<span style="color:#F00;"> * </span></strong></td>
            <td>
              <select class="chzn-select" name="table_id" id="table_id" onchange="get_urlfloor_table('<?php echo $zomato ; ?>',this.value,'<?php echo $floor_id_zr; ?>',);">
              <option value="">--select--</option>
              <?php
             $res = $obj->executequery("select * from m_table order by table_no asc");
             foreach ($res as $row) { 
              $floor_id = $row['floor_id'];
              $floor_name = $obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");

              ?>
               <option value="<?php echo $row['table_id']; ?>"><?php echo $row['table_no']." / ".$floor_name; ?></option>
           <?php  }
               ?>
              </select>
              <script type="text/javascript">
                document.getElementById('table_id').value = '<?php echo $table_id; ?>';
              </script>
            </td>
            <!-- <td><strong style="color: black;">Floor<span style="color:#F00;"> * </span></strong></td>
            <td>
              <select class="chzn-select" name="floor_id" id="floor_id" onchange="get_urlfloor('<?php echo $zomato ; ?>',this.value);">
              <option value="">--select--</option>
              <?php
             $res = $obj->executequery("select * from m_floor");
             foreach ($res as $row) { ?>
               <option value="<?php echo $row['floor_id']; ?>"><?php echo $row['floor_name']; ?></option>
           <?php  }
               ?>
              </select>
              <script type="text/javascript">
                document.getElementById('floor_id').value = '<?php echo $floor_id; ?>';
              </script>
            </td>
        
            <td><strong style="color: black;">Table:<span style="color:#F00;">* </span>: </strong></td>
            <td>

               <select name="table_id" id="table_id" onchange="get_urlsearch('<?php echo $zomato ; ?>','<?php echo $floor_id ;?>',this.value);">
                <option value="" >---Select---</option>
               <?php
                $slno=1;
                $res = $obj->executequery("select * from m_table where floor_id = '$floor_id'");
                foreach($res as $row_get)
                {
                ?> 
                <option value="<?php echo $row_get['table_id']; ?>"> <?php echo $row_get['table_no']; ?></option>          
                <?php 
                }
                ?>
               </select>
              <script type="text/javascript">
                document.getElementById('table_id').value = '<?php echo $table_id; ?>';
              </script>
            </td> -->
        
            <!-- <td><input type="submit" name="search" class="btn btn-success" style="width: 100%;" value="Search" onClick="return checkinputmaster('floor_id');"></td> -->
            <!-- <td><a href="in_entry.php" class="btn btn-primary" > Reset </a></td> -->
        </tr>

      </table>
      </form>

<br>
<?php if($floor_id!="" && $table_id!="" )
{ 
  ?>
      <table class="table table-condensed table-bordered alert alert-info">


        <tr>
          <td>
            <input type="button" class="btn btn-success" value="Show All" style="margin-bottom:3px;" onClick="show_product_data('0',<?php echo $table_id; ?>);"/>
           
          <?php 
          $qry  = $obj->executequery("select * from m_product_category");
          foreach ($qry as $rows){
             
             $catname = $rows['catname'];
             $pcatid = $rows['pcatid'];
           ?>
           <input type="button" value="<?php echo strtoupper($catname); ?>" onClick="show_product_data('<?php echo $pcatid; ?>','<?php echo $table_id; ?>');" style="margin-bottom:3px; background-color: #001a1a; color: white; font-size: 15; font-family: bold;"/>
           
            
         <?php }
           ?>
            </td>
        </tr>

      </table>


   <!--   graph -->
      <div class="maincontent">
          <div class="row-fluid" style="margin-top: 10px;">
            
                <div class="row-fluid" >
                    <div class="span8" >
                      <h4 class="widgettitle" style="color: blue;">ORDER ENTRY FOR <b>(<?php echo $floor_name;?>)</b> and TABLE No. &nbsp;<b>(<?php echo $table_no; ?>)</b>&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-success btn-xm" value="Transfer Table" name="submit" onclick="show_transfer_modal()">  
                      </h4>
                        <div style="border: 1px solid #D3D3D3;" id="showrecord"></div>

                        <img src="images/giphy.gif" alt="" id="loader" class="pull-center"/>
                </div><!-- div one close -->

                    <div class="span4">
                      <h4 class="widgettitle">
                        <input type="text" id="myInput" onKeyUp="myFunction()" name="" placeholder="Search For Names or Serial Number"></h4>
                        
                       <div id="myUl" style="height: 400px; width: 390px; border: 1px solid #D3D3D3; overflow-y: scroll;" >
                         <!-- data fetch through ajax page -->
                       </div>
                    </div><!-- div 2 close -->
                
        </div>
    </div><!-- graph close -->
                </div><!--row-fluid-->
        <?php }//if close ?> 
         <div class="span8" >
                      <h4 class="widgettitle" style="margin-top: 10px;">App Order Notification</h4>
                        
                       <div id="show_notification" style="height: 400px; border: 1px solid #D3D3D3; overflow-y: scroll;" >
                         <!-- data fetch through ajax page -->
                       </div>
                    </div><!-- div 2 close -->
            </div>
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
<div class="modal fade" id="myModal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
                    </div>
                        <div class="modal-body">
              <table class="table table-bordered table-condensed">
                            
                            
                                      <tr>
                                          <td colspan="5"><p id="dup_err" class="text-red"><?php echo $duplicate; ?></p></td>
                                        </tr>
                    <tr>
                                            <th width="18%">Product Name &nbsp;<span style="color:#F00;">*</span></th>
                                            <th width="18%">Unit &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>
                                            <td>                                           
                                           <input class="form-control" name="mprodname" id="prodname" value="" autofocus="" type="text" readonly style="z-index:-44;" >
                                           <input type="hidden" name="mproductid" id="productid"  readonly > </td>
                                           <td>                                           
                                           <input class="form-control" name="unit_name" id="unit_name"  value="" autocomplete="off" autofocus="" type="text" readonly >
                                            <input type="hidden" name="unitid" id="unitid" readonly > 
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                         <th width="18%">Rate &nbsp;<span style="color:#F00;">*</span></th>
                                          <th colspan="2" width="18%">Quantity &nbsp;<span style="color:#F00;">*</span></th>
                                        </tr>
                                        <tr>  
                                        <td>                                           
                                           <input class="form-control" name="rate" id="rate" autofocus="" autocomplete="off" type="text" onkeyup="gettotal();">
                                          <!--  <input name="rate" id="rate" type="hidden"> -->
                                           <input name="hiddenrate" id="hiddenrate" type="hidden">                   
                                        </td>                                          
                                            <td> 
                                            <input class="form-control" name="qty" id="qty"  value="1" autocomplete="off" autofocus="" type="text" onkeyup="gettotal();" placeholder="Enter Quantity" style="width:50%"  >  
                                            <input type="button" style="font-size:16px;" class="btn-sm btn btn-success btn-plus" id="add" value="+" onClick="addqty()" >  
                                            <input type="button"  style="font-size:16px;" class="btn-sm btn btn-danger" id="minus" value="--" onClick="minusqty();" >                                        
                                           </td>
                                         </tr>
                                          <tr>
                                         <th width="18%">Discount (In %)</th>
                                          <th colspan="2" width="18%">Discount (Rs)</th>
                                        </tr>
                                            <tr> 
                                             <td>                                           
                                           <input class="form-control" name="disc_percent" id="disc_percent" autofocus="" autocomplete="off" type="text" onkeyup="gettotal();">
                                                              
                                        </td>  
                                          <td>                                           
                                           <input class="form-control" name="disc_rs" id="disc_rs" autofocus="" autocomplete="off" type="text" onkeyup="gettotal();">
                                                             
                                        </td>  
                                        </tr>
                                        <tr>
                                          <th width="18%" colspan="2"> <label><input type="checkbox" name="checked_nc" id="checked_nc" value="1" onclick="set_nc();"> Not Chargeable </label></th>
                                        </tr>
                                        <tr>
                  
                                        </tr>
                                    </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="total"></span></h2>
                           <input type="submit" class="btn btn-primary" name="submit" value="Add" id="addlistbtn" onClick="addlist();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   ><i class="fa fa-times"></i> Discard</button>
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div><!-- product add modal close -->
<!--Payment modal-->
<div class="modal fade" id="payment_modal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>Payment Entry</h4>

                    </div>
                        <div class="modal-body">
                          <input type="hidden" name="billid" id="billid" value="<?php echo $billid; ?>">
                          <h3 class="widgettitle" style="color: black;">Date :&nbsp;<b><?php echo $obj->dateformatindia($paydate); ?></b>
                            <input type="hidden" name="paydate" id="paydate" value="<?php echo $obj->dateformatindia($paydate); ?>" readonly style="width: 40%;">
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice :  <b><span id="payment_bill_number" style="font-weight:bold;"></span></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Table : <b><span id="payment_table_no" style="font-weight:bold;"></span></b></h3>

                          <table class="table table-condensed">

                                
                                <tr>
                                  <td>Net Bill Amount</td>
                                    <td><input type="text" name="net_bill_amt" id="payment_amt" readonly="" style="width: 120px;"></td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                  <td>Cash</td>
                                  <td><input type="text" name="cash_amt" id="cash_amt" onkeyup="settotal();" value="0" style="width: 120px;"></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Paytm</td>
                                  <td><input type="text" name="paytm_amt" id="paytm_amt" onkeyup="settotal();" value="0" style="width: 120px;"></td>
                                  <td>&nbsp;</td>
                                </tr>
                                 <tr>
                                  <td>Card</td>
                                  <td><input type="text" name="card_amt" id="card_amt" onkeyup="settotal();" value="0" style="width: 120px;"></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Google Pay</td>
                                  <td><input type="text" name="google_pay" id="google_pay" onkeyup="settotal();" value="0" style="width: 120px;"></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>Settlement Amt</td>
                                  <td><input type="text" name="settlement_amt" id="settlement_amt" onkeyup="settotal();" value="0" style="width: 120px;">
                                    <td>&nbsp;</td>
                                    </td>
                                </tr>
                                <tr>
                                  <td>Credit Amt</td>
                                  <td><input type="text" name="credit_amt" 
                                    id="credit_amt" readonly="readonly" style="width: 120px;"></td>
                                    <td> <small id="credit_amt_error"style="color: red;" class="form-text text-muted"></small></td>
                                    
                                </tr>
                              
                                <tr>
                                  <td>Mobile</td>
                                  <td><input type="text" class="form-control" id="cust_mobile" name="cust_mobile" maxlength="10" style="width: 120px;"></td>
                                  <td><input type="text" name="cust_name" id="cust_name" placeholder="Enter Customer Name" ></td>
                                  
                                </tr>

                                 <tr>
                                  <td>Remark</td>
                                    <td>
                                      <input type="text" class="form-control" id="remarks" name="remarks" style="width: 120px;">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                               
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="payment_total"></span></h2>
                          <img src="../img/loaders/loader6.gif" alt="" id="loaderimg" class="pull-right"/>
                           <input type="button" class="btn btn-primary" name="submit" value="Recive Payment" onClick="return rec_payment();" id="savepayment">
                           <button type="button" class="btn btn-danger" data-dismiss="modal"   id="disacrdpayment" ><i class="fa fa-times"></i> Discard</button>
                           
                           
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div><!-- close payment model -->
<!--discount modal-->
 <div class="modal fade" id="myModal_disc"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <!-- <h4 class="modal-title"><i class="fa fa-plus"></i> Save Bill For <?php //echo $table_no; ?></h4> -->
                    </div>
                        <div class="modal-body">
                          <table class="table table-bordered table-condensed" style="font-size:16px;">
                            
                              <tr>
                                  <th width="40%">Order Type &nbsp;<span style="color:#F00;">*</span></th>
                              <td><input class="form-control" name="parsal_status" id="parsal_status" value="" autofocus="" type="text" readonly ></td>
                                </tr> 
                                <tr>
                                  <th width="40%">Food Total &nbsp;<span style="color:#F00;">*</span></th>
                                  <td><input class="form-control" name="food_amt" id="food_amt" value="" autofocus="" type="text"  readonly></td>
                                </tr>

                                <tr>
                                  <th width="40%">Beverages Total &nbsp;<span style="color:#F00;">*</span></th>
                                  <td><input class="form-control" name="bev_amt" id="bev_amt" value="" autofocus="" type="text"  readonly></td>
                                </tr> 
                                <tr>
                                  <th width="40%">Gross Total &nbsp;<span style="color:#F00;">*</span></th>
                                  <td><input class="form-control" name="basic_bill_amt" id="basic_bill_amt" value="" autofocus="" type="text"  readonly></td>
                                </tr>  
                               
                               <tr>
                                  <th width="18%">SGST&nbsp;<span style="color:#F00;">*</span></th>
                                  <td><input class="form-control" name="total_bill_sgst" id="sgst" value="" autofocus="" type="text"  readonly>
                                    </td>
                                </tr> 
                             
                                 <tr>
                                  <th width="18%">CGST&nbsp;<span style="color:#F00;">*</span></th>
                                  <td><input class="form-control" id="cgst" name="total_bill_cgst" value="" autofocus="" type="text" readonly ></td>
                                </tr>
                                 
                                <tr>
                                  <th width="18%">Net Bill Amt &nbsp;<span style="color:#F00;">*</span></th>
                                  <td><input class="form-control" name="net_bill_amt" id="net_bill_amt" value="" autofocus="" type="text" readonly ></td>
                                </tr> 
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                         <h2 class="pull-left">Total : <span id="nettotal"></span></h2>

                           <input type="submit" class="btn btn-primary" name="submit" value="Save Bill" id="save_bill_order" onClick="save_order();">

                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>

                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>       

<!--Transfer modal-->
 <div class="modal fade" id="myModal_transfer"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1>Transfer Table</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                       
                    </div>
                        <div class="modal-body" style="height: 350px;">
                          <table class="table table-bordered table-condensed" style="font-size:16px;">
                            
                            <tr>
                              <th width="40%">Floor No.&nbsp;<span style="color:#F00;">*</span></th>
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
                            </tr> 
                            <tr>
                                <th width="40%">Table No. &nbsp;<span style="color:#F00;">*</span></th>
                                <td>
                                  <input type="hidden" name="table_id" id="table_id" value="<?php echo $table_id; ?>">
                                <select name="table_idt" id="table_idt" onchange="get_urlsearch_tran('<?php echo $floor_idt ;?>',this.value);">
                                <option value="" >---Select---</option>
                                <?php
                                $slno=1;
                                $res = $obj->executequery("select * from m_table where floor_id = '$floor_id'");
                                foreach($res as $row_get)
                                {
                                ?> 
                                <option value="<?php echo $row_get['table_id']; ?>"> <?php echo $row_get['table_no']; ?></option>          
                                <?php 
                                }
                                ?>
                                </select>
                                <script type="text/javascript">
                                document.getElementById('table_idt').value = '<?php echo $table_idt; ?>';
                                </script>
                                </td>
                            </tr> 
                            </table>
                        </div>
                        <div class="modal-footer clearfix">
                           <input type="submit" class="btn btn-primary" name="submit" value="Transfer" id="transfer_order" onClick="transfer_order();"  >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>       



<script>

  function get_urlfloor_table(zomato,table_id,floor_id_zr)
  {
    //alert('kii');
   location = 'in_entry.php?zomato='+zomato+'&floor_id='+floor_id_zr+'&table_id='+table_id;
  }

function get_urlfloor(zomato,floor_id)
{
  //alert('hiie');
  //alert(zomato);
  if(zomato!="")
  {
  location = 'in_entry.php?zomato='+zomato+'&floor_id='+floor_id;
  }
  else
  {
  location = 'in_entry.php?floor_id='+floor_id;
  }
}

function get_urlsearch(zomato,floor_id,table_id)
{
  //alert('hiie');
  if(zomato!="")
  {
  location = 'in_entry.php?zomato='+zomato+'&floor_id='+floor_id+'&table_id='+table_id;
  }
  else
  {
    location = 'in_entry.php?floor_id='+floor_id+'&table_id='+table_id;
  }
}

function get_urlfloor_tran(floor_idt)
{
  jQuery.ajax({
           type: 'POST',
           url: 'get_tabletransfer.php',
           data: 'floor_idt='+floor_idt,
           dataType: 'html',
           success: function(data){
          //alert(data);
          
          jQuery("#table_idt").html(data);
          jQuery("#table_idt").val('').trigger("liszt:updated");
          document.getElementById('table_idt').focus();
          jQuery(".chzn-single").focus();
           }
           });//ajax close
}

// function get_urlsearch_tran(floor_idt,table_idt)
// {

//   location = 'in_entry.php?floor_id='+floor_idt+'&table_id='+table_idt;
// }


  
	function funDel(id)
	{  //alert(id);   
		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';
		 //alert(module); 
       if(confirm("Are you sure! You want to delete this record."))
       {
         jQuery.ajax({
           type: 'POST',
           url: 'ajax/delete_master.php',
           data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
           dataType: 'html',
           success: function(data){
				  //alert(data);
               location='<?php echo $pagename."?action=3" ; ?>';
           }

			  });//ajax close
		}//confirm close
	} //fun close
   jQuery('#open_bal_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
//jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});

jQuery('#open_bal_date').focus();

 

jQuery(document).ready(function(){
   
   jQuery('#menues').click();
  
   });

function myFunction() {
  //alert('hi');
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[0];
  td2 = tr[i].getElementsByTagName("td")[1];
  //alert(td);
    if(td1 || td2) {
      if(td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function set_nc()
{
  var is_checked = document.getElementById('checked_nc').checked;
  
  if(is_checked)
  {
    //alert("");
    jQuery("#rate").val(0);
    jQuery("#disc_percent").val('');
    jQuery("#disc_rs").val('');
    jQuery("#total").html('0.00');
  }
  else
  {
     var hiddenrate = jQuery("#hiddenrate").val();
     jQuery("#rate").val(hiddenrate);
  }
}

function show_product_data(pcatid,table_id)
  {  
    //alert(pcatid,table_id);
    //alert(zomato);   
    tblname = '<?php echo $tblname; ?>';
    tblpkey = '<?php echo $tblpkey; ?>';
    zomato = '<?php echo $zomato; ?>';

      jQuery.ajax({
        type: 'POST',
        url: 'ajax_inentry_data.php',
        data: '&tblname='+tblname+'&tblpkey='+tblpkey+'&pcatid='+pcatid+'&zomato='+zomato,
        dataType: 'html',
        success: function(data){
          //alert(data);
          jQuery("#myUl").html(data);
          
           //location='<?php echo $pagename ; ?>';
        }
        
        });//ajax close
  } //fun close
// });
// productid,prodname,unitid,unit_name,product_price
function addproduct(productid,prodname,unitid,unit_name,rate,cgst,sgst)
  {
       //alert(rate); 
    jQuery("#myModal").modal('show');     
    jQuery("#prodname").val(prodname);
    jQuery("#productid").val(productid);
    jQuery("#unitid").val(unitid);
    jQuery("#unit_name").val(unit_name);    
    jQuery("#rate").val(rate);
    jQuery("#hiddenrate").val(rate);
    jQuery("#disc_percent").val('');
    jQuery("#disc_rs").val('');
    jQuery("#uniform-checked_nc").find('span').removeClass('checked');
    jQuery('#checked_nc').prop('checked', false);
    jQuery("#total").html(rate);
    jQuery("#qty").val('1');
    jQuery("#qty").focus();

    
  } 

  function gettotal()
  {
    var rate=document.getElementById('rate').value;
    var qty=document.getElementById('qty').value;
    var disc_percent=document.getElementById('disc_percent').value;
    var disc_rs=document.getElementById('disc_rs').value;
    if(! isNaN(rate) && ! isNaN(qty))
    {
      total=  rate * qty; 

    }

     if(! isNaN(disc_percent))
    {
      // disc in percent
      disc_per_amt = total * disc_percent/100;
      total = total - disc_per_amt;
    }

    if(! isNaN(disc_rs))
    {
      // disc in rate
      total = total - disc_rs;
    }
    
    document.getElementById('total').innerHTML=total;
  }


  function addqty()
  {
  var qty = parseInt(document.getElementById('qty').value);
  var rate = parseFloat(document.getElementById('rate').value);
  var disc_percent = parseFloat(document.getElementById('disc_percent').value);
  var disc_rs = parseFloat(document.getElementById('disc_rs').value);
  var addqty1;
  //alert(addqty1);
  if(!isNaN(qty))
    {
       addqty1 = parseInt(qty)+1;
    }
    document.getElementById('qty').value=addqty1;
    prodamt = rate * addqty1;
    if(!isNaN(disc_percent))
    {
       prodamt = prodamt - (prodamt * disc_percent/100);
    }

    if(!isNaN(disc_rs))
    {
       prodamt = prodamt - disc_rs;
    }
    jQuery("#total").html(prodamt);
    
    //alert(prodamt);
    
    
  }
  
  
  function minusqty()
  {
    
    var qty = parseInt(document.getElementById('qty').value); 
    var rate = parseFloat(document.getElementById('rate').value);
    var disc_percent = parseFloat(document.getElementById('disc_percent').value);
    var disc_rs = parseFloat(document.getElementById('disc_rs').value);
    var addqty1;
  
  if(!isNaN(qty) && qty > 1)
  {
     addqty1 = parseInt(qty)-1;
     document.getElementById('qty').value=addqty1;
      prodamt = rate * addqty1;
      if(!isNaN(disc_percent))
    {
       prodamt =  prodamt - (prodamt * disc_percent/100);
    }

    if(!isNaN(disc_rs))
    {
       prodamt = prodamt - disc_rs;
    }
     jQuery("#total").html(prodamt);
     
  }else
  alert("Quntity can not be less than 1");
  
  }

  
  function addlist()
  {

    jQuery('#addlistbtn').prop('disabled', true);
    var  productid= document.getElementById('productid').value;
    var  prodname= document.getElementById('prodname').value;
    var  unit_name= document.getElementById('unit_name').value;
    var  unitid= document.getElementById('unitid').value;
    var  qty= document.getElementById('qty').value;
    var  rate= document.getElementById('rate').value;
    var  total= document.getElementById('total').innerHTML;
    var  table_id = "<?php echo $table_id; ?>";
    var  zomato = "<?php echo $zomato; ?>";
    var  disc_percent= document.getElementById('disc_percent').value;
    var  disc_rs= document.getElementById('disc_rs').value;
    var  is_checked_nc = document.getElementById('checked_nc').checked;
    
    if(is_checked_nc)
    {
      var checked_nc = 1;
    }
    else
    {
      var checked_nc = 0;
    }


    if(qty =='' && rate =='')
    {
      alert('Quantity and rate cant be blank'); 
      jQuery('#addlistbtn').prop('disabled', false);
    }
    else
    {
      
      jQuery.ajax({
        type: 'POST',
        url: 'savebillentry.php',
        data: 'productid='+productid+'&unitid='+unitid+'&qty='+qty+'&rate='+rate+'&table_id='+table_id+'&zomato='+zomato+'&disc_percent='+disc_percent+'&disc_rs='+disc_rs+'&checked_nc='+checked_nc,
        dataType: 'html',
        success: function(data){  
        //alert(data);        
        if(data == 0)
        {
          alert("This Bill is Saved, Cant add product.");
        }
        else
        {
          getrecord();
          jQuery('#productid').val('');
          jQuery('#prodname').val('');
          jQuery('#qty').val('');
          jQuery('#unit_name').val('');
          jQuery('#rate').val('');
          jQuery('#unitid').val('');
          jQuery('#is_checked_nc').val('');
          jQuery('#disc_percent').val('');
          jQuery('#disc_rs').val('');
          jQuery('#total').html('');        
          jQuery("#myModal").modal('hide');
          jQuery('#myInput').val('');
          jQuery('#myInput').focus();
          jQuery('#addlistbtn').prop('disabled', false);
        }
        
        
        }
        
        });//ajax close
        
    }
        
  }
  
  function getrecord()
  {
    //alert('hiie');
    var table_id='<?php echo $table_id; ?>';  
    var floor_id='<?php echo $floor_id; ?>'; 
    var zomato='<?php echo $zomato; ?>';   
    //alert(zomato);
    if(zomato!="")
    {
      zomato1 = "zomato";
    }
    else
    {
      zomato1 = "";
    }
    jQuery('#loader').css("display", "block");

    //alert('hii');
    if(table_id !=0)
    {
        jQuery.ajax({
        type: 'POST',
        url: 'showbillrecord.php',  
        data: 'table_id='+table_id+'&floor_id='+floor_id+'&zomato='+zomato1,
        dataType: 'html',
        success: function(data){          
        //alert(data);
          jQuery('#showrecord').html(data);
        }
        });//ajax close
        // sleep(3000);
        jQuery('#loader').css("display", "none");
    }
                
  }


function get_notification()
  {
    //alert('hiie');
    var table_id='<?php echo $table_id; ?>';  
    var floor_id='<?php echo $floor_id; ?>'; 
    var zomato='<?php echo $zomato; ?>';   
    //alert(table_id);
    if(zomato!="")
    {
      zomato1 = "zomato";
    }
    else
    {
      zomato1 = "";
    }
    

    //alert('hii');
    // if(floor_id !=0)
    // {
        jQuery.ajax({
        type: 'POST',
        url: 'show_nitification.php',  
        data: 'table_id='+table_id+'&floor_id='+floor_id+'&zomato='+zomato1,
        dataType: 'html',
        success: function(data){          
        //alert(data);
          jQuery('#show_notification').html(data);
        }
        });//ajax close
       
    //}
                
  }

  

function get_floor_id(floor_id,table_id)
{
  //alert('hiie');
  location= 'in_entry.php?floor_id='+floor_id+'&table_id='+table_id;
}



  function deleterecord(zomato,billdetailid,billid)
  {
    if(billid == 0)
    {
      tblname = 'bill_details';
      tblpkey = 'billdetailid';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';    
      if(confirm("Are you sure! You want to delete this record."))
      {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_master.php',
          data: 'id='+billdetailid+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
          dataType: 'html',
          success: function(data){
           // alert(data);
           getrecord('<?php echo $keyvalue; ?>');
           
          }
          
          });//ajax close
      }//confirm close
    }//if close billid
    else
      alert('Item Can not deleted after bill saved!');
  
  }
   

function show_payment_modal(net_bill_amt,billnumber,table_no,customer_name)
{
  //alert('hi');
  net_bill_amt = parseFloat(net_bill_amt);
  net_bill_amt = net_bill_amt.toFixed(2);
  jQuery('#payment_bill_number').html(billnumber);
  jQuery('#payment_table_no').html(table_no);
  jQuery('#payment_amt').val(net_bill_amt);
  jQuery('#credit_amt').val(net_bill_amt);

  jQuery('#payment_total').html(net_bill_amt);
  jQuery('#customer_name').html(customer_name);
  jQuery('#payment_modal').modal('show');
  jQuery('#loaderimg').css("display", "none");
  
}

function refreshkot(billid,zomato,table_id,floor_id)
{
   //alert(table_id);
   //alert(floor_id);
   jQuery.ajax({
      type: 'POST',
      url: 'ajax_check_kot_products.php',
      data: "billid=" + billid + '&table_id=' + table_id,
      dataType: 'html',
      success: function(data){
        var count_prod = data.trim();
        //alert(data);
        if(count_prod == 0)
        alert('Please add product to generate new KOT!');
        else{
          var myurl = "pdf_restaurant_kot_recipt_new.php?billid="+billid+"&table_id="+table_id;
          window.open(myurl,'_blank');  
          getrecord();  
          location='in_entry.php?zomato='+zomato+'&table_id='+table_id+'&floor_id='+floor_id;
      }
        
     }
      
  });//ajax close
}

function gourl(zomato,floor_id,table_id) 
{
 //alert(zomato);
  url = 'in_entry.php?zomato='+zomato+'&floor_id='+floor_id+'&table_id='+table_id+'&search=Search';

  location=url;
}

jQuery(document).ready(function(){
myVar = setInterval("getrecord()", 10000);
});

jQuery(document).ready(function(){
myVar = setInterval("get_notification()", 10000);
});


function settotal()
{
  
  var net_bill_amt=parseFloat(jQuery('#payment_amt').val()); 
  var card_amt=parseFloat(jQuery('#card_amt').val()); 
  var cash_amt=parseFloat(jQuery('#cash_amt').val()); 
  var google_pay=parseFloat(jQuery('#google_pay').val());
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

  if(!isNaN(google_pay))
  {
    total3 = total2 - google_pay;
  }
  else
  total3 = total2;
 
  if(!isNaN(settlement_amt))
  {
    total4 = total3 - settlement_amt;
  }
  else
  total4 = total3;

  jQuery('#credit_amt').val(total4.toFixed(2));
} 


 
  function save_order()
{
  
  basic_bill_amt = jQuery("#basic_bill_amt").val();
  food_amt = jQuery("#food_amt").val();
  bev_amt = jQuery("#bev_amt").val();
  net_bill_amt = jQuery("#net_bill_amt").val();
  table_id = jQuery("#table_id").val();
  floor_id = jQuery("#floor_id").val();
  cust_name = jQuery("#cust_name").val();
  sgst = jQuery("#sgst").val();
  cgst = jQuery("#cgst").val();
  parsal_status = jQuery("#parsal_status").val();
  is_parsal = jQuery("#is_parsal").val();
  zomato = '<?php echo $zomato; ?>';
  if(zomato==zomato)
  {
    zomato1 = zomato
  }
  else
  {
    zomato1 = ""
  }
  //alert(is_parsal);

  if(net_bill_amt !="")
  {
    //alert(net_bill_amt);
    jQuery("#save_bill_order").attr("disabled", "disabled");
    jQuery.ajax({
        type: 'POST',
        url: 'save_order_bill.php',
        data: "basic_bill_amt=" + basic_bill_amt + '&table_id=' + table_id + '&net_bill_amt=' + net_bill_amt + '&sgst='+ sgst + '&cgst=' + cgst + '&parsal_status=' + parsal_status +'&cust_name='+cust_name+'&is_parsal='+is_parsal+'&food_amt='+food_amt+'&bev_amt='+bev_amt,
        dataType: 'html',
        success: function(data){
        // alert(data);
         
          if(data > 0)
          {
            var myurl1 = "pdf_restaurant_recipt.php?billid="+data;
            window.open(myurl1,'_blank'); 
            //var myurl2 = "in-entry.php?table_id="+table_id;
           // jQuery("#save_bill_order").removeAttr("disabled"); 
            location='in_entry.php?zomato='+zomato1+'&table_id='+table_id+'&floor_id='+floor_id;
          }
          else{
              alert("This Bill is already Saved, Go to Payment"); 
              event.preventDefault()

              //location='in_entry.php?zomato='+zomato1+'&table_id='+table_id+'&floor_id='+floor_id;     
              }
          
       }
        
    });//ajax close
  }
}

function transfer_order()
{
   table_idt = jQuery("#table_idt").val();
   table_id = jQuery("#table_id").val();
   floor_idt = jQuery("#floor_idt").val();

   if(table_idt!="" && table_id!="")
   {
     jQuery("#transfer_order").attr("disabled", "disabled");
     jQuery.ajax({
          type: 'POST',
          url: 'transfer_order_table.php',
          data: "table_idt=" + table_idt+'&table_id='+table_id,
          dataType: 'html',
          success: function(data){
           //alert(data);
           jQuery("#table_idt").val(data);
           jQuery("#transfer_order").removeAttr("disabled");
           var gourl = 'in_entry.php?floor_id='+ floor_idt + '&table_id='+data;
           location = gourl;
         }
         });//ajax close
       jQuery("#myModal_transfer").modal('hide');
    }//if close
    else
    {
      alert('Please select table for transfer orders');
    }
}


function cancel_product(zomato,billdetailid,rate,table_id)
{
   floor_id = jQuery("#floor_id").val();
   var cancel_remark = prompt("Enter Reson to cancell...");
   //alert(cancel_remark);
   if(cancel_remark)
   {
        jQuery.ajax({
            type: 'POST',
            url: 'ajax_cancell_product.php',
            data: "billdetailid=" + billdetailid + '&cancel_remark=' +cancel_remark + '&rate=' + rate + '&table_id=' + table_id,
            dataType: 'html',
            success: function(data){
              //alert(data);
              var gourl = 'in_entry.php?zomato='+zomato+'&floor_id='+ floor_id + '&table_id='+table_id;
           location = gourl;
           }
            
        });//ajax close
      }
      else
      {
        alert('Cancel Remark is mandatory');
        return false;
      }
}


// function get_discount()
// {
//   basic_bill_amt = parseFloat(jQuery("#basic_bill_amt").val()); 
//   disc_percent = parseFloat(jQuery("#disc_percent").val()); 
//   disc_rs = parseFloat(jQuery("#disc_rs").val()); 
//   sgst = parseFloat(jQuery("#sgst").val()); 
//   cgst = parseFloat(jQuery("#cgst").val()); 
//   sercharge = parseFloat(jQuery("#sercharge").val()); 
  
//   //alert(cgst);
  
//   if(disc_percent > 0)
//   {
//     disc_amt =  basic_bill_amt * (disc_percent / 100) ;
//   }else
//   disc_amt = 0;
  
//   if(disc_rs > 0)
//   disc_amt_rs = disc_rs;
//   else
//   disc_amt_rs = 0;
//   net_bill_amt = basic_bill_amt - disc_amt - disc_amt_rs;
  
//   if(sgst > 0)
//   sgst_amt =  net_bill_amt * (sgst/100);
//   else
//   sgst_amt = 0;
  
//   if(cgst > 0)
//   cgst_amt =  net_bill_amt * (cgst/100);
//   else
//   cgst_amt = 0;
  
//   if(sercharge > 0)
//   sercharge_amt =  net_bill_amt * (sercharge/100);
//   else
//   sercharge_amt = 0;
  
//   //alert(sercharge);
//   //total net bill
//   net_bill_amt = net_bill_amt + sgst_amt + cgst_amt + sercharge_amt;
  
//   net_bill_amt = Math.round(net_bill_amt.toFixed(2));
//   jQuery("#net_bill_amt").val(net_bill_amt);
//   jQuery("#nettotal").html(net_bill_amt);
  
// }

  function show_discount_modal()
{
  //alert('hiie');
  //alert(is_parsal);
  jQuery("#myModal_disc").modal('show');  
    food_amt = jQuery("#hidden_food_amt").val();
    bev_amt = jQuery("#hidden_bev_amt").val();
    basic_bill_amt = jQuery("#hidden_basic_amt").val();
    total_bill_cgst = jQuery("#hidden_cgst_amt").val();
    total_bill_sgst = jQuery("#hidden_sgst_amt").val();
    net_bill_amt = jQuery("#hidden_net_bill_amt").val();
   
//alert(net_bill_amt);
  // //check parcel
  if(jQuery('#is_parsal').prop("checked"))
  jQuery("#parsal_status").val('Parcel');
  else
  jQuery("#parsal_status").val('Table Order');

 jQuery("#food_amt").val(food_amt);  
 jQuery("#bev_amt").val(bev_amt);  
 jQuery("#basic_bill_amt").val(basic_bill_amt);  
 jQuery("#cgst").val(total_bill_cgst);  
 jQuery("#sgst").val(total_bill_sgst);
 jQuery("#net_bill_amt").val(net_bill_amt);  
 //Math.round(net_bill_amt.toFixed(2));
 jQuery("#nettotal").html(net_bill_amt);
  //get_discount();
  // if(basic_bill_amt == 0)
  // {
  //   //jQuery("#save_bill_order").attr("disabled", "disabled");
  // }
  // else
  // jQuery('#save_bill_order').removeAttr('disabled');
  
}


function show_transfer_modal()
{
  jQuery("#myModal_transfer").modal('show');
}



function close_nc_bill(net_bill_amt,billid,table_id)
{
  floor_id = '<?php echo $floor_id; ?>';
  table_id = '<?php echo $table_id; ?>';

  if(net_bill_amt == 0)
  {
    if(confirm('Are your sure want to save bill as N/C'))
    {
      jQuery.ajax({
              type: 'POST',
              url: 'ajax_close_nc_bill.php',
              data: "billid=" + billid + '&table_id=' +table_id,
              dataType: 'html',
              success: function(data){
                //alert(data);
                var gourl = 'in_entry.php?zomato='+'&floor_id='+ floor_id  + '&table_id='+ table_id;
                location = gourl;
             }
              
          });//ajax close
    }
  }
  else
  {
    alert('This bill can not be closed in N/C');
  }
}

</script>
</body>
</html>
