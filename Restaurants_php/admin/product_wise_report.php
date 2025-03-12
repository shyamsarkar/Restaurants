<?php include("../adminsession.php");

//print_r($_SESSION);die;
$pagename ="product_wise_report.php";
$module = "Product Wise Sale Report";
$submodule = "Product Wise Sale List";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "bills";
$tblpkey = "billid";
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
  $productid = "";
}

$crit = " where 1 = 1 and billdate between '$from_date' and '$to_date'"; 



if(isset($_GET['productid']))
{
  
  $productid = $_GET['productid'];
  if(!empty($productid))
  	$crit .= " and bill_details.productid = '$productid'";
}





?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
</head>
<body onLoad="getrecord('<?php echo $keyvalue; ?>');">

<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
     <!-- START OF RIGHT PANEL -->
   <div class="rightpanel">
    	<?php include("inc/header.php"); ?>
       
      
        <div class="maincontent">
        	 <div class="contentinner content-dashboard">

            <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                
                <th>Product Name:</th>
                <th>From Date:</th>
                <th>To Date:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                  
                    <td>
                    <select name="productid" id="productid" class="chzn-select">
                        <option value="">--All--</option>
                        <?php
                        $slno=1;
                        
                      $res = $obj->executequery("select * from m_product order by prodname");

                        foreach($res as $row_get)
                        
                        {               
                        ?>
                        <option value="<?php echo $row_get['productid'];  ?>"> <?php echo $row_get['prodname']; ?></option>
                        <?php } ?>
                    </select>
                    <script>document.getElementById('productid').value='<?php echo $productid; ?>';</script>                   
                    </td>
                    <td><input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                <td><input type="text" name="to_date" id="to_date" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($to_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                
                <td><input type="submit" name="search" class="btn btn-success" value="Search"></td>
              </tr>
            </table>
            <div>
            </form>

             <?php $chkview = $obj->check_pageview("product_wise_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>

            	<p align="right" style="margin-top:7px; margin-right:10px;"> 
                <a href="pdf_product_wise_master.php?from_date=<?php echo $from_date;?>&to_date=<?php echo $to_date;?>&productid=<?php echo $productid;?>" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span>
                  </a>
                  </p>

                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
            	<table class="table table-bordered" id="dyntable">
                    <thead>
                        <tr>
                            <th  class="head0 nosort">S.No.</th>
                            <th  class="head0">Product Name</th>
							<th  class="head0">Date</th>
                          	<th  class="head0">Total Qty</th>
                            <th style="text-align:right" class="head0">Total Amount</th>
                            <th style="text-align:center;" class="head0">View Details</th>
                                                   
                        </tr>
                    </thead>
                    <tbody id="record">
                           
                  <?php
                  $slno=1;
                  $totalamt=0;
                  $grand_tot=0;
                  
				$sql = "Select sum(bill_details.qty) as totqty, sum(bill_details.qty*bill_details.rate) as totamt, bill_details.productid ,bills.billdate from bill_details left join bills on bills.billid = bill_details.billid $crit group by bill_details.productid";
				$res = $obj->executequery($sql);
				foreach($res as $row_get)
				{
				$totqty = $row_get['totqty'];
				//$billid = $row_get['billid'];
				$productid = $row_get['productid'];
				$totamt = $row_get['totamt'];
				$grand_tot += $totamt;
				//$prod_qty = $obj->getvalfield("bill_details","sum(qty)","productid='$productid' and billid = '$billid'");
				$prodname = $obj->getvalfield("m_product","prodname","productid='$productid'");
				//$product_sale_amt = $obj->get_product_wise_total_sale($productid);	
                   
				?> 
				<tr>
					<td><?php echo $slno++; ?></td> 
					<td><?php echo $prodname; ?></td>
					<td><?php echo $obj->dateformatindia($row_get['billdate']); ?></td>
					<td><?php echo $totqty; ?></td>
					<td style="text-align:right"><?php echo number_format(round($totamt),2); ?></td>
					<td style="text-align:center;">
						<a class="btn btn-success btn-small" onClick="show_viewdetails_modal('<?php echo $row_get['productid']; ?>');" style="margin-left:20px;">
						<!-- <input type="button" name="is_completed" id="is_completed" value="View Details" onClick="show_viewdetails_modal('<?php echo $row_get['productid']; ?>');" class="btn btn-success" > --><strong> View Details </strong></a></td> 
				</tr>
                            <?php
                            $totalamt += $totamt;
                            }//looop close

                            ?>
                            </tbody>
                            </table>
                            <div class="well well-sm text"><h3 class="text-info text-right">Total Amount: <?php echo number_format($totalamt,2); ?></h3></div> 
                        <?php } ?>
                            </div> 
                     </div><!--contentinner-->
      			 	 </div><!--maincontent-->
    				</div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>

    <!--View Details modal-->
<div class="modal fade" id="viewdetails_modal"  role="dialog" aria-hidden="true" style="display:none;" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i>View Product Details</h4>

                    </div>
                        <div class="modal-body">

                          <table class="table table-bordered">

                          	<thead>
                        <tr>
                            <th  class="head0 nosort">S.No.</th>
                            <th  class="head0">Bill_No.</th>
                            <th  class="head0">Product_Details</th>
                            <th  class="head0">Qty</th>
                            <th  class="head0">Table_Details</th>
                            <th  class="head0">Cencelled</th>
                            <th  class="head0">Createdby</th>
                          	
                        </tr>
                    </thead>
                      <tbody id="showprodetails">

                      </tbody>
                 
                            </table>
                        </div>
                        
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

</div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->

</div><!--mainwrapper-->


    <?php //include("modal_voucher_entry.php"); ?>
 
<script>
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
			 // alert(data);
			   location='<?php echo $pagename."?action=3" ; ?>';
			}
			
		  });//ajax close
	}//confirm close
} //fun close

jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#from_date').focus();


function show_viewdetails_modal(productid)
{
  jQuery('#viewdetails_modal').modal('show');

  var from_date = document.getElementById('from_date').value;
  var to_date = document.getElementById('to_date').value;



    jQuery.ajax({

        type: 'POST',

        url: 'ajax_show_productdetails_view.php',

        data: 'productid='+productid+'&from_date='+from_date+'&to_date='+to_date,

        dataType: 'html',

        success: function(data){

       // alert(data);

        

        jQuery('#showprodetails').html(data);

        

      }

    });//ajax close

  // jQuery('#payment_bill_number').html(billnumber);
  // jQuery('#payment_table_no').html(table_no);
  // jQuery('#credit_amt').val(credit_amt1);
  // jQuery('#billid').val(billid);
  // jQuery('#balance').val(credit_amt1);
 
  //jQuery('#loaderimg').css("display", "none");
  
}

function settotal()
{

	var qty=parseFloat(jQuery('#qty').val());	
	var rate_amt=parseFloat(jQuery('#rate_amt').val());	
    var cgst=parseFloat(jQuery('#cgst').val());	
	//var tax=parseFloat(jQuery('#tax').val());		
	//var disc=parseFloat(jQuery('#disc_per').val());	
	
	if(!isNaN(qty) && !isNaN(rate_amt))
	{
		total=	qty * rate_amt;
	}	
	
	if(!isNaN(cgst))
	{
		totalc= (total * cgst)/100;
		total= totalc + total;
	}
	
	/*if(!isNaN(tax))
	{
		taxamt= (total * tax)/100;
		total= total + taxamt;
	}*/
	
		
	
	jQuery('#total').val(total.toFixed(2));
}	


function settotalupdate()
{
	var qty=parseFloat(jQuery('#mqty').val());	
	var rate=parseFloat(jQuery('#mrate').val());
	var disc=parseFloat(jQuery('#m_disc_per').val());
		
	
	if(!isNaN(qty) && !isNaN(rate))
	{
		total=	qty * rate;
	}
	
	if(!isNaN(disc))
	{
		total= total - (total * disc)/100;
	}
	
	jQuery('#mtotal').val(total.toFixed(2));
}	


function addqty()
  {
  	var qty = parseInt(document.getElementById('mqty').value);
	
	var addqty1;
	//alert(qty);
	if(!isNaN(qty))
		{
			 addqty1 = parseInt(qty)+1;
		}
 		document.getElementById('mqty').value=addqty1;
		settotalupdate();				
		
  }
  function minusqty()
  {
	  
  	var qty = parseInt(document.getElementById('mqty').value);	
	var addqty1;
	
	if(!isNaN(qty) && qty > 1)
	{
		 addqty1 = parseInt(qty)-1;
		 document.getElementById('mqty').value=addqty1;
		 settotalupdate();
				 
	}else
	alert("Quantity can not be less than 1");
 	
  }
</script>
<script>

function save_voucher_data()
{
     
	var customer_id = document.getElementById('bcustomer_id').value;
	var vdate = document.getElementById('vdate').value;
	var paymt_id = document.getElementById('paymt_id').value;
	var pay_subid = document.getElementById('pay_subid').value;
	var email = document.getElementById('email').value;
  var pay_mode = document.getElementById('pay_mode').value;
	var amount = document.getElementById('amount').value;
  var voucherno = document.getElementById('voucherno').value;
  var order_id = document.getElementById('saleid').value;
   //alert(saleid);

    if(vdate == "")
		{
			alert('Please Fill Date');
			return false;
		}
		
		if(paymt_id == "")
		{
			alert('Please Selected Payment Type');
			return false;
		}

        if(pay_mode == "")
		{
			alert('Please Fill Payment Mode');
			return false;
		}
		
		if(amount == "")
		{
			alert('Please Fill Amount');
			return false;
		}
	
		else
		{
     jQuery.ajax({
			  type: 'POST',
			  url: 'save_svoucher.php',
			  data: 'customer_id='+customer_id+'&vdate='+vdate+'&paymt_id='+paymt_id+'&pay_subid='+pay_subid+'&email='+email+'&pay_mode='+pay_mode+'&amount='+amount+'&voucherno='+voucherno+'&order_id='+order_id,
			  dataType: 'html',
			  success: function(data){
                 // alert(data);

        jQuery("#customer_id").val('');
        jQuery("#order_id").val('');
        jQuery("#vdate").val('');
        jQuery("#paymt_id").val('');
        jQuery("#pay_subid").val('');
        jQuery("#email").val('');
        jQuery("#pay_mode").val('');
        jQuery("#amount").val('');
        jQuery("#voucherno").val('');
        jQuery("#voucherModal").modal('hide');
                 }
             });//ajax close
	}
}

function save_party_data()
{
   //alert("hii");
    var customer_name = document.getElementById('m_customer_name').value;
	var customer_type = document.getElementById('m_customer_type').value;
	var mobile = document.getElementById('m_mobile').value;
    var panno = document.getElementById('m_panno').value;
    var gsttinno = document.getElementById('m_gsttinno').value;
	var openingbal = document.getElementById('m_openingbal').value;
    var open_bal_date = document.getElementById('m_open_bal_date').value;
	var email = document.getElementById('m_email').value;	
	var address = document.getElementById('m_address').value;
	var term_cond = document.getElementById('m_term_cond').value;
  

   jQuery.ajax({
			  type: 'POST',
			  url: 'save_party.php',
			  data: 'customer_name='+customer_name+'&customer_type='+customer_type+'&mobile='+mobile+'&panno='+panno+'&gsttinno='+gsttinno+'&openingbal='+openingbal+'&open_bal_date='+open_bal_date+'&email='+email+'&address='+address+'&term_cond='+term_cond,
			  dataType: 'html',
			  success: function(data){				  
		   		// alert(data);

             		//jQuery('#showallbtn').click();
					jQuery("#customer_name").val('');
					jQuery("#customer_type").val('');
					jQuery("#mobile").val('');
					jQuery("#panno").val('');
          jQuery("#gsttinno").val('');
					jQuery("#openingbal").val('');
					jQuery("#open_bal_date").val('');
          jQuery("#email").val('');
					jQuery("#address").val('');
					jQuery("#term_cond").val('');
					jQuery("#myModal_party").modal('hide');
					jQuery('#customer_id').html(data);
					jQuery("#customer_id").val('').trigger("liszt:updated");
					jQuery('#customer_id').val('').trigger('chzn-single:updated');
					jQuery('#customer_id').trigger('chzn-single:activate'); // for autofocus
					//getproductdetail();

                       }
			  });//ajax close
				
		}	

function save_product_data()
{

	var m_branch_id = document.getElementById('m_branch_id').value;
	var product_name = document.getElementById('product_name').value;
	var unit_name = document.getElementById('unit_name').value;
    var product_type = document.getElementById('product_type').value;
    var rate_amt = document.getElementById('rate_amt').value;
	var rate_type = document.getElementById('rate_type').value;
    var opening_stock = document.getElementById('opening_stock').value;
	var stock_date = document.getElementById('stock_date').value;	
	var cgst = document.getElementById('cgst').value;
	var sgst = document.getElementById('sgst').value;
	var igst = document.getElementById('igst').value;
	
		if(m_branch_id == "")
		{
			alert('Please Fill Branch Name');
			return false;
		}
		
		if(product_name == "")
		{
			alert('Please Fill Product Name');
			return false;
		}
	
		else
		{
			
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_saleproduct.php',
			  data: 'm_branch_id='+m_branch_id+'&product_name='+product_name+'&unit_name='+unit_name+'&product_type='+product_type+'&rate_amt='+rate_amt+'&rate_type='+rate_type+'&opening_stock='+opening_stock+'&stock_date='+stock_date+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst,
			  dataType: 'html',
			  success: function(data){				  
		    //alert(data);
			 		
					jQuery('#showallbtn').click();
					jQuery("#product_name").val('');
					jQuery("#unit_name").val('');
					jQuery("#product_type").val('');
					jQuery("#rate_amt").val('');
                    jQuery("#rate_type").val('');
					jQuery("#opening_stock").val('');
					jQuery("#stock_date").val('');
                    jQuery("#cgst").val('');
					jQuery("#sgst").val('');
					jQuery("#igst").val('');
					jQuery("#myModal_product").modal('hide');
					jQuery('#product_id').html(data);
					jQuery("#product_id").val('').trigger("liszt:updated");
					jQuery('#product_id').val('').trigger('chzn-single:updated');
					jQuery('#product_id').trigger('chzn-single:activate'); // for autofocus
					getproductdetail();
				}
				
			  });//ajax close
				
		}	
}
   
	function getrecord(keyvalue){
	 // var emp_id=jQuery("#emp_id").val();
	
			  jQuery.ajax({
			  type: 'POST',
			  url: 'show_salerecord.php',
			   data: "saleid="+keyvalue,
			  dataType: 'html',
			  success: function(data){				  
				//alert(data);
					jQuery('#showrecord').html(data);
					setTotalrate();
					
				}
				
			  });//ajax close
							  
	}
 jQuery(function() {
                //Datemask dd/mm/yyyy
                jQuery("#sale_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});               
                jQuery("[data-mask]").inputmask();
		 });
 
jQuery(document).ready(function(){
   
   jQuery('#menues').click();
  
   });
	

function getproductdetail(product_id)
{ 
 
	var product_id =jQuery("#product_id").val();
	var product_rate =jQuery("#product_rate").val();
  var customer_id=jQuery("#customer_id").val();
  //alert(customer_id);
	if(product_rate != 0 && customer_id!="")
	{//alert(product_rate);
		jQuery.ajax({
					type: 'POST',
					url: 'ajaxgetsaleproductdetail.php',
					data: 'product_id='+product_id+'&product_rate='+product_rate+'&process='+'purchase'+'&customer_id='+customer_id,
					dataType: 'html',
					success: function(data){				  
					//alert(data);
					
					arr=data.split('|');	
					unit_name=arr[0];
					cgst=arr[1].trim();
					sgst=arr[2].trim();
					igst=arr[3].trim();
					rate_amt=arr[4].trim();
					
					jQuery('#unit_name').val(unit_name);
					jQuery('#cgst').val(cgst);
					jQuery('#sgst').val(sgst);
          jQuery('#igst').val(igst);
					jQuery('#rate_amt').val(rate_amt);
					jQuery('#unit_name').focus();
					}
			  });//ajax close
	}
  else
  {
    alert('Please Select Rate Type and Customer');
    jQuery("#product_id").val('').trigger("liszt:updated");
    jQuery(".chzn-single").focus();
  }
}
function getsubhead()
	{
	//alert('hiii');
	 var paymt_id = document.getElementById('paymt_id').value;
	//alert(paymt_id);
	jQuery.ajax({
			  type: 'POST',
			  url: 'showsubpaymenthead.php',
			  data: 'paymt_id='+paymt_id,
			  dataType: 'html',
			  success: function(data){				  
		        //alert(data);
			jQuery("#pay_subid").html(data);
				}
			  });//ajax close
			
	}

function addlist()
{
  jQuery('#addlist_btn').prop('disabled', true);
	var  product_id= document.getElementById('product_id').value;
	var  unit_name= document.getElementById('unit_name').value;
	var  qty= document.getElementById('qty').value;
	var  rate_amt= document.getElementById('rate_amt').value;
	var cgst= document.getElementById('cgst').value;
	var sgst= document.getElementById('sgst').value;
	var igst= document.getElementById('igst').value;
	//alert('hi');
	
	var saleid='<?php echo $keyvalue; ?>';
	var saledetail_id=0;
 
	if(product_id =='')
	{
		alert('Product cant be blank');	
    jQuery('#addlist_btn').prop('disabled', false);
		return false;
	}
	if(qty=='')
	{
		alert('Quantity Cant be blank');
    jQuery('#addlist_btn').prop('disabled', false);
		return false;
	}
	else
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'save_saleproduct.php',
		  data: 'product_id='+product_id+'&unit_name='+unit_name+'&qty='+qty+'&rate_amt='+rate_amt+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst+'&saleid='+saleid+'&saledetail_id='+saledetail_id,
		  dataType: 'html',
		  success: function(data){				  
			//alert(data);		
		
			jQuery('#product_id').val('');		
			jQuery('#rate_amt').val('');
			jQuery('#qty').val('');
			jQuery('#unit_name').val('');
            //jQuery('#unit_id').val('');
			jQuery('#cgst').val('');
			jQuery('#sgst').val('');
			jQuery('#igst').val('');
			//jQuery('#productbarcode').val('');
			jQuery('#total').val('');	
			getrecord('<?php echo $keyvalue ?>');
			
			
			jQuery("#product_id").val('').trigger("liszt:updated");
			document.getElementById('product_id').focus();
			jQuery(".chzn-single").focus();
		  //jQuery('#productid').focus();
	   //jQuery("#productid").val('').trigger("liszt:updated");
		
			}
		  });//ajax close
      jQuery('#addlist_btn').prop('disabled', false);
	}
}

function updatelist()
{

 	var  product_id= document.getElementById('mproduct_id').value;
	var  unit_name= document.getElementById('munit_name').value;
	var  qty= document.getElementById('mqty').value;
	var  rate_amt= document.getElementById('mrate').value;
	var cgst= document.getElementById('mcgst').value;
	var sgst= document.getElementById('msgst').value;
	var igst= document.getElementById('migst').value;	
	var saledetail_id= document.getElementById('m_saledetail_id').value;
	var keyvalue = '<?php echo $keyvalue; ?>';
	//alert(product_id);
	
	
	if(qty =='')
	{
		alert('Quantity cant be blank');	
		return false;
	}
	if(rate_amt=='')
	{
		alert('Rate Cant be blank');
		return false;
	}
	else
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'save_saleproduct.php',
		  data: 'product_id='+product_id+'&unit_name='+unit_name+'&qty='+qty+'&rate_amt='+rate_amt+'&cgst='+cgst+
		   '&sgst='+sgst+'&igst='+igst+'&saledetail_id='+saledetail_id+'&saleid='+keyvalue,
		  dataType: 'html',
		  success: function(data){				  
		//alert(data);
			
			//setTotalrate();
			jQuery('#mproduct_id').val('');
			jQuery('#mrate').val('');
			jQuery('#munit_name').val('');
			jQuery('#mqty').val('');
			jQuery('#mcgst').val('');
			jQuery('#msgst').val('');
			jQuery('#migst').val('');
			jQuery('#saledetail_id').val('');
			//jQuery('#productbarcode').val('');				
			jQuery("#myModal").modal('hide');
			getrecord(<?php echo $keyvalue ?>);
			
			}
		  });//ajax close
	}
}

function setTotalrate()
{
	var disc= parseFloat(jQuery('#disc').val());  
	var tot_amt= parseFloat(jQuery('#hidtot_amt').val());
	var tot_tax= parseFloat(jQuery('#tot_tax_gst').val());
	var packing_charge= parseFloat(jQuery('#packing_charge').val());  
	var freight_charge= parseFloat(jQuery('#freight_charge').val()); 
	var tot_disc_per=parseFloat(jQuery('#tot_disc_per').val())
	
		
	if(!isNaN(disc) && !isNaN(tot_amt))
	{
		tot_amt= tot_amt-disc;
		jQuery('#tot_amt').val(tot_amt.toFixed(2));
	}
	jQuery('#tot_amt').val(tot_amt);
	
	if(!isNaN(tot_disc_per) && !isNaN(tot_amt))
	{
		tot_amt=tot_amt-tot_disc_per;
	}
	
	if(!isNaN(tot_tax))
	{
		tot_amt = tot_amt + tot_tax;
	}
	//alert(tot_amt);
	
	if(!isNaN(packing_charge))
	{
		tot_amt = tot_amt+packing_charge 
	}
	if(!isNaN(freight_charge))
	{
		tot_amt=tot_amt+ freight_charge;
	}
	
	jQuery('#netamt').val(tot_amt.toFixed(2));
}  
  
 

	
	
 function deleterecord(saledetail_id)
  {
	 	tblname = 'saleentry_details';
		tblpkey = 'saledetail_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+saledetail_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }
   
function getproductfrombarcode(barcode)
{
	jQuery.ajax({
					type: 'POST',
					url: 'searchproductbarcode.php',
					data: 'barcode='+barcode+'&process='+'purchase',
					dataType: 'html',
					success: function(data){				  
					//alert(data);
					
					if(data !='0')
					{
						jQuery("#productid").val(data).trigger("liszt:updated");
						getproductdetail();
						document.getElementById('add_data_list').focus();
					}
					else
					{
						alert('No product found');	
					}
					
					}
				
			  });//ajax close
}

function updaterecord(product_name,product_id,unit_name,qty,rate_amt,cgst,sgst,igst,total,saledetail_id)
{

	
			jQuery("#myModal").modal('show');
			jQuery("#saveitem").attr('value', 'Update');
			jQuery("#mproduct_name").val(product_name);
			jQuery("#mproduct_id").val(product_id);
			jQuery("#munit_name").val(unit_name);
			jQuery("#mqty").val(qty);
			jQuery("#mrate").val(rate_amt);
			jQuery("#mcgst").val(cgst);
      jQuery("#msgst").val(sgst);
      jQuery("#migst").val(igst);
			jQuery("#mtotal").val(total);		
			jQuery("#m_saledetail_id").val(saledetail_id);
			settotalupdate();
			jQuery("#qty").focus();
		
}
// function datailshide()
// {
//  //alert('hi');
//  var product_rate = document.getElementById('product_rate').value;
//  // alert(sale_type);

// if(product_rate =="From Plant")
// {
//    //alert(sale_type);
//    jQuery("#vehicle_td1").hide();
//    jQuery("#vehicle_td2").hide();
// }
// else
// {
//   jQuery("#vehicle_td1").show();
//   jQuery("#vehicle_td2").show();
// }

// }

function clear_add_list()
{
  //alert('hii');
  var product_rate = document.getElementById('product_rate').value;
 //alert(product_rate);

if(product_rate =="ratefrmplant")
{
   //alert(product_rate);
   jQuery("#vehicle_td1").hide();
   jQuery("#vehicle_td2").hide();
}
else
{
  jQuery("#vehicle_td1").show();
  jQuery("#vehicle_td2").show();
}

    jQuery("#product_id").val('').trigger("liszt:updated");
    jQuery(".chzn-single").focus();
    jQuery("#unit_name").val('');
    jQuery("#rate_amt").val('');
    jQuery("#qty").val('');
    jQuery("#cgst").val('');
    jQuery("#sgst").val('');
    jQuery("#igst").val('');
    jQuery("#total").val('');
    
}


jQuery('#sale_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#vdate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#sale_date').focus();

function getvoucher(saleid,cust_name,cust_id,voucherno) {
		jQuery('#voucherModal').modal('show');
		jQuery("#customer_name").val(cust_name);
		jQuery("#bcustomer_id").val(cust_id);
        jQuery("#voucherno").val(voucherno);
		jQuery("#saleid").val(saleid);
}
// function getamt()
// {
// var customer_id = document.getElementById('customer_id').value;

// }

function getparty()
	{
	//alert('hiii');
	 var vendorgrp_id = document.getElementById('vendorgrp_id').value;
	//alert(vendorgrp_id);
	jQuery.ajax({
			  type: 'POST',
			  url: 'getparty.php',
			  data: 'vendorgrp_id='+vendorgrp_id,
			  dataType: 'html',
			  success: function(data){				  
		        //alert(data);
			jQuery("#customer_id").html(data);
			jQuery("#customer_id").val('').trigger("liszt:updated");
            document.getElementById('customer_id').focus();
            jQuery(".chzn-single").focus();
           
				}
			  });//ajax close
			
	}
</script>
</body>
</html>
