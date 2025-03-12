<?php include("../adminsession.php");
$pagename = "sale_entry.php";
$module = "Add Sale Entry";
$submodule = "Sale Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "purchaseentry";
$tblpkey = "purchaseid";

$company_id= $_SESSION['company_id'];

if(isset($_GET['bill_type']))
$bill_type = addslashes(trim($_GET['bill_type']));
else
$bill_type = "";



if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = ""; 
$duplicate = "";
$billno = "";
$bill_date = "";
$supplier_id = "";
$packing_charge = "";
$purchase_type = "";
$billno_challan = "";
$company_id = $_SESSION['company_id'];
$company_name = "";
//$bill_type = "";
$unit_id = "";
$rate_amt = 0;
$remark = "";
$supplier_status = "";
$cgst = "";
$type = "saleentry";
if(isset($_GET['purchaseid']))
$keyvalue = $_GET['purchaseid'];
else
$keyvalue = 0;

if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
  $customer_id = "";
}

$crit = " where 1 = 1 and bill_date between '$from_date' and '$to_date'"; 



if(isset($_GET['customer_id']))
{
  
  $customer_id = $_GET['customer_id'];
  if(!empty($customer_id))
    $crit .= " and customer_id = '$customer_id'";
}

if(isset($_POST['submit']))
{ 

  $purchaseid=trim(addslashes($_POST['purchaseid']));
  $billno = trim(addslashes($_POST['billno']));
  $customer_id = trim(addslashes($_POST['customer_id']));
  $bill_date = $obj->dateformatusa(trim(addslashes($_POST['bill_date'])));
  $bill_type = trim(addslashes($_POST['bill_type']));
  $net_amount = trim(addslashes($_POST['net_amount']));
  $remark = trim(addslashes($_POST['remark']));
 
	
	if($purchaseid == 0)
	{
		$form_data = array('type'=>$type,'net_amount'=>$net_amount,'billno'=>$billno,'customer_id'=>$customer_id,'bill_date'=>$bill_date,'company_id'=>$company_id,'purchase_type'=>$purchase_type,'bill_type'=>$bill_type,'remark'=>$remark,'ipaddress'=>$ipaddress,'sessionid'=>$sessionid,'createdate'=>$createdate,'createdby'=>$loginid);
 
		$lastid = $obj->insert_record_lastid($tblname,$form_data);
		$action=1;
		$process = "insert";
		$form_data2 = array('purchaseid'=>$lastid);
		echo "<script>location='$pagename?action=$action&bill_type=$bill_type'</script>";
		$where = array("purchaseid"=>0);
		$keyvalue = $obj->update_record("purchasentry_detail",$where,$form_data2);
		die;
      }
	else
	{
		$form_data = array('type'=>$type,'net_amount'=>$net_amount,'billno'=>$billno,'customer_id'=>$customer_id,'bill_date'=>$bill_date,'packing_charge'=>$packing_charge,'company_id'=>$company_id,'purchase_type'=>$purchase_type,'bill_type'=>$bill_type,'remark'=>$remark,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid);
		$where = array($tblpkey=>$keyvalue);
		$keyvalue = $obj->update_record($tblname,$where,$form_data);
		$action=2;
		$process = "updated";
					
    }
		echo "<script>location='$pagename?action=$action&bill_type=$bill_type'</script>";

}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  
  $billno  =  $sqledit['billno'];
 
  $packing_charge  =  $sqledit['packing_charge'];
  $customer_id =  $sqledit['customer_id'];
  $bill_date  =  $obj->dateformatindia($sqledit['bill_date']);
  $company_id  =  $sqledit['company_id'];
  $company_name = $obj->getvalfield("company_setting","company_name","company_id = '$company_id'");
  $purchase_type  =  $sqledit['purchase_type'];
  $bill_type  =  $sqledit['bill_type'];
  $net_amount  =  $sqledit['net_amount'];
  $remark  =  $sqledit['remark'];
  $type  =  $sqledit['type'];
	
}
else
{
	  
    $bill_date=date('d-m-Y');
    $stock_date = date('d-m-Y');
    $company_id = $_SESSION['company_id'];
	  $company_name = $obj->getvalfield("company_setting","company_name","company_id = '$company_id'");
    $billno = $obj->getcode($tblname,$tblpkey,"bill_type='invoice'");
    $billno_challan = $obj->getcode_challan($tblname,$tblpkey,"bill_type='challan'");
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
        <!-- <div style="float:left; margin:10px;" class="par control-group success input-prepend">
         <span class="add-on">BARCODE</span>
      <input type="text" style="height:26px;"  id="productbarcode" placeholder="Search From Barcode" onChange="getproductfrombarcode(this.value);" class="form-control span3" >
          </div>-->
      <div style="float:right;">
     
            <input type="button" class="btn btn-primary" style="float:right; margin-top:10px" name="addnew" id="addnew" onClick="add();" 
            value="Show List">
           </div>
        <div class="maincontent">
        	 <div class="contentinner content-dashboard">
               <div id="new2">               
         <form action="" method="post" onSubmit="return checkinputmaster('bill_type,customer_id,billno,bill_date');">
                
         <div class="row-fluid">
        <table class="table table-condensed table-bordered">
                    <tr>
                          <td colspan="9"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                    </tr>
                    <tr>
                          <td width="15%"><strong>Bill Type:<span style="color:#F00;"> * </span></strong></td>
                          <td width="15%" ><strong>Customer:<span style="color:#F00;"> * </span><a class="btn btn-success btn-small" onClick="getcomid('<?php echo $company_id; ?>');" data-toggle="modal_party" style="margin-left:20px;"><strong> + </strong></a></td>
                          <?php if ($bill_type == 'invoice') {
                            
                           ?>
                          <td width="15%"><strong>Bill No : <span style="color:#F00;"> * </span> </strong></td>
                        <?php } else { ?>
                           <td width="15%"><strong>Challan No : <span style="color:#F00;"> * </span> </strong></td>
                         <?php } ?>
                          <td width="15%"><strong>Billed Date: <span style="color:#F00;"> * </span> :</strong></td>
                         
                          <td width="15%"><strong>Remark:<span style="color:#F00;"> * </span></td>
                    </tr>
                    <tr>  
                          <td>
                          <select id="bill_type" name="bill_type" class="form-control text-red chzn-select" onchange="getbill(this.value);">
                         <option value="">--Select--</option>
                          <option value="invoice">Invoice</option>
                          <option value="challan">Challan</option>
                          </select>
                          <script type="text/javascript">
                            document.getElementById('bill_type').value = '<?php echo $bill_type; ?>';
                          </script>
                          </td>

                          <td>
                          <select name="customer_id" id="customer_id" class="chzn-select" >
                          <option value="">--Choose Customer--</option>
                          <?php
                          $slno=1;

                          $res = $obj->executequery("select * from master_customer");
                          foreach($res as $row_get)

                          {               
                          ?>
                          <option value="<?php echo $row_get['customer_id']; ?>"> <?php echo $row_get['customer_name']; ?></option>
                          <?php } ?>
                          </select>
                          <script> document.getElementById('customer_id').value='<?php echo $customer_id; ?>'; </script>                    
                          </td>
                          <?php if ($bill_type == 'invoice') {
                            
                           ?>
                          <td><input type="text" name="billno" id="billno" class="form-control text-red"  value="<?php echo $billno;?>" autofocus autocomplete="off" placeholder="Bill No." readonly></td>
                            <?php } else { ?>
                          <td><input type="text" name="billno" id="billno" class="form-control text-red"  autofocus autocomplete="off" placeholder="Challan No." readonly value="<?php echo $billno_challan; ?>"></td>
                            <?php } ?>
                          <td>                                           
                          <input type="text" name="bill_date" id="bill_date" class="form-control text-red"  value="<?php echo $bill_date;?>" autofocus autocomplete="off" maxlength="10" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask >
                          </td>
                          
                          
                          <td>    
                          <input type="text" name="remark" id="remark" class="form-control text-red"  value="<?php echo $remark;?>" autofocus autocomplete="off" placeholder="Enter Remark">                                  
                          </td>
                    </tr>
                   
							  </table>
                    </div>
                     <br>
                     <div>
                 	 <div class="alert alert-success">
                     <table width="100%" class="table table-bordered table-condensed">
                     <tr>
                     	<th width="15%">PRODUCT <a class="btn btn-success btn-small" onClick="jQuery('#myModal_product').modal('show');" data-toggle="modal_product" style="margin-left:20px;"><strong> + </strong></a> </th>
                        <th>UOM</th>
                        <th>RATE</th>
                        <th>QTY</th>
                        <th>Total</th>
                        <th>DISC %</th>
                        <th>TAXABLE</th>
                        <th style="width: 5%;">CGST %</th>
                        <th style="width: 5%;">SGST %</th>
                        <th style="width: 5%;">IGST %</th>
                        
                        <th style="width: 10%;">TaxType</th>
                        <th>Action</th>
                     </tr>
                     <tr>
                     	<td>
                        <select name="product_id" id="product_id" class="form-control chzn-select" onChange="getproductdetail();" >
                         	<option value="" >--Choose Product--</option>
                         <?php
                           $slno=1;
						   $res = $obj->fetch_record("m_product");
						   foreach($res as $row_get)
                         {
                         ?>
                                <option value="<?php echo $row_get['product_id']; ?>"><?php echo $row_get['product_name']; ?></option>
                           <?php
                         }
                         ?>
                          </select>
                            <script> document.getElementById('product_id').value='<?php echo $product_id; ?>'; </script>
                          </td>
                           <td><input class="input-mini form-control" type="text" name="unit_name" id="unit_name" value="" style="width:90%;" readonly >     
                               <input class="input-mini form-control" type="hidden" name="unit_id" id="unit_id" value="" style="width:90%;">
                           </td>
                           <td><input class="input-mini" type="text" name="rate_amt" id="rate_amt" value="" style="width:90%;" onkeyup="settotal()" ></td>
                           <td><input class="input-mini" type="text" name="qty" id="qty" value="" style="width:70%;" onkeyup="settotal()"></td>
                           <td><input class="input-mini" type="text" name="total" id="total" value="" style="width:90%;" readonly ></td>

                           <td><input class="input-mini" type="text" name="disc" id="disc" value="" style="width:70%;" onkeyup="settotal()"></td>
                           <td><input class="input-mini" type="text" name="taxable" id="taxable" value="" style="width:90%;" readonly ></td>
                           
                           
                        <td><input class="input-mini" type="text" name="cgst" id="cgst" value="" style="width:70%;" onkeyup="settotal()"></td>                        
                        <td><input class="input-mini" type="text" name="sgst" id="sgst" value="" style="width:70%;" onkeyup="settotal()" ></td>
                        <td><input class="input-mini" type="text" name="igst" id="igst" value="" style="width:70%;" onkeyup="settotal()"></td>
                        
                        
                        <td><select id="inc_or_exc" name="inc_or_exc" class="input-mini" style="width:100%;">
                          <option value="">--Select--</option>
                          <option value="inclusive">Inclusive</option>
                          <option value="exclusive">Exclusive</option>
                        </select>
                        <script type="text/javascript">
                          document.getElementById('inc_or_exc').value = '<?php echo $inc_or_exc; ?>';
                        </script>
                        </td> 

                        <td>
                        <input type="button" class="btn btn-success" onClick="addlist();" style="margin-left:20px;" value="Add Product">
                        </td>
                        <td></td>
                      </tr>

                    </table>

                      </div>
                    </div>
                   
                <div class="row-fluid">
                	<div class="span12">
                    	<h4 class="widgettitle nomargin"> <span style="color:#00F;" > Product Details : <span id="inentryno" > </span>
                        </span></h4>
                        <div class="widgetcontent bordered" id="showrecord">
                        </div><!--widgetcontent-->
                  </div>
                  <!--span8-->
                </div>
                </form>
            </div>
            
             <?php   $chkview = $obj->check_pageview("sale_entry.php",$loginid);              
              if($chkview == 1 || $loginid == 1){  ?> 
            <div id="list" style="display:none;"  >
              <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                
                <th>Customer Name:</th>
                <th>From Date:</th>
                <th>To Date:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                  
                    <td>
                    <select name="customer_id" id="dcustomer_id" class="chzn-select">
                        <option value="">--All--</option>
                        <?php
                        $slno=1;
                        $company_id = $_SESSION['company_id'];
                    $res = $obj->executequery("select * from master_customer");

                        foreach($res as $row_get)
                        
                        {               
                        ?>
                        <option value="<?php echo $row_get['customer_id'];  ?>"> <?php echo $row_get['customer_name']; ?></option>
                        <?php } ?>
                    </select>
                <script>document.getElementById('customer_id').value='<?php echo $customer_id; ?>';</script>                   
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
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                
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
                            <th width="5%" class="head0 nosort">S.No.</th>
                            <th class="head0">Company Name</th>
                            <th class="head0">Customer Name</th>
                            <th class="head0">Bill No</th>
                            <th class="head0">Bill Date</th>
                            <th class="head0">Bill Type</th>
                            <th class="head0" style="text-align: right;">Amount</th>
                            <th  class="head0" style="text-align:center;">Print A4</th>
                             <?php   $chkedit = $obj->check_editBtn("sale_entry.php",$loginid);              
                              if($chkedit == 1 || $loginid == 1){  ?>
                            <th  class="head0" >Edit</th>  <?php } ?>
                             <?php  $chkdel = $obj->check_delBtn("sale_entry.php",$loginid);             
                              if($chkdel == 1 || $loginid == 1){  ?>    
                            <th  class="head0" >Delete</th>    <?php } ?>                         
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                          <?php
                          $slno=1;
                         $company_id=$_SESSION['company_id'];
                         $res = $obj->executequery("select * from purchaseentry $crit and type = 'saleentry' and company_id = '$company_id' order by bill_date desc");
                          foreach($res as $row_get)
                          {
                          $total=0;
                          $company_id = $row_get['company_id'];
                          $company_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
                          $customer_id = $row_get['customer_id'];
                          $customer_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");
                          $total = $row_get['net_amount'];
                          $bill_type = $row_get['bill_type'];
                          // $customer_type = $obj->getvalfield("master_customer","customer_type","customer_id='$row_get[customer_id]'");
                          //echo $customer_type;die;
                          

                          ?>
                        <tr>
                          <td><?php echo $slno++; ?></td>
                          <td><?php echo $company_name; ?></td>
                          <td><?php echo $customer_name; ?></td>
                          <td><?php echo $row_get['billno']; ?></td>
                          <td><?php echo $obj->dateformatindia($row_get['bill_date']); ?></td>
                          <td><?php echo $bill_type; ?></td>
                           <td style="text-align: right;"><?php echo number_format(round($total),2); ?></td>

                         <?php if($bill_type == 'invoice') {
                         ?>
                         <td><center><a class="btn btn-danger" href="pdfsaleinvoice.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Invoice A4 </a></center></td>
                       <?php }//if close
                        else

                       { ?>
                        <td><center><a class="btn btn-danger" href="pdf_challan_invoice.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Invoice A4 </a></center></td>
                      <?php }

                        ?>
                         <?php   $chkedit = $obj->check_editBtn("sale_entry.php",$loginid);             
                          if($chkedit == 1 || $loginid == 1){  ?>  
                         <td><a class='icon-edit' title="Edit" href='sale_entry.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>' style='cursor:pointer'></a></td><?php } ?>&nbsp;<?php $chkdel = $obj->check_delBtn("sale_entry.php",$loginid);  if($chkdel == 1 || $loginid == 1){  ?><td>
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['purchaseid']; ?>);' style='cursor:pointer'></a>
                         </td><?php } ?>
                        </tr>
                        <?php
						            }
						           ?>
                        
                       
                    </tbody>
                </table>
                </div>
                <?php } ?>
                
                
             </div><!--contentinner-->
        </div><!--maincontent-->
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    
    <!--footer-->

</div><!--mainwrapper-->
<div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Customer</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
             <table class="table table-condensed table-bordered">
              <tr> 
                <th style="width: 50%;">Customer Name<span style="color:#F00;"> * </span> </th>
                <th>Mobile<span style="color:#F00;">  </span> </th>
              </tr>
                  <td>
                   <input type="text" name="customer_name" id="customer_name" class="input-xxlarge"  style="width:90%;" autocomplete="off" autofocus placeholder="Enter Customer Name" /> 
                  </td>
                   <td>
                   <input type="text" name="mobile" id="mobile" class="input-xxlarge" style="width:90%;" autocomplete="off" maxlength="10" autofocus placeholder="Enter Mobile"/> 
                   <input type="hidden" id="company_id" name="company_id" value="<?php echo $company_id ; ?>">
                  </td>                              
              
            <tr> 
            <th>Email Id</th> 
            <th>Address<span style="color:#F00;"> </span> </th>
            </tr>
            <tr>
            <td>
                <input type="email" name="email" id="email" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Email Id"/>
           </td> 
          <td>
               <input type="text" name="address" id="address" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Address"/>
        </td>
          </tr>
            <tr> 
            <th>Bank Name</th>
            <th>Bank Account</th>
            </tr>
            <tr>
            <td> <input type="text" name="bank_name" id="bank_name" class="input-xxlarge" style="width:90%;" autofocus autocomplete="off" placeholder="Enter Bank Name"/></td>

            <td><input type="text" name="bank_ac" id="bank_ac" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Bank Account"/></td>
            </tr>
            <tr> 
            <th>IFSC Code</th>
            <th>Bank Address</th>
            </tr>
            <tr>
            <td> <input type="text" name="ifsc_code" id="ifsc_code" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  placeholder="Enter IFSC Code"/></td>
            <td>  
               <input type="text" name="bank_address" id="bank_address" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  placeholder="Enter Bank Address"/>
           </td>
            </tr>
            <tr> 
            <th>State Name</th>
            <th>GST No.</th>
           
            </tr>
            <tr>
            <td> <select name="state_id" id="state_id"  class="chzn-select" style="width:230px;" >
                                <option value="">---Select---</option>
                                <?php
                                $crow=$obj->executequery("select * from m_state");
                                foreach ($crow as $cres) {

                                    ?>
                                    <option value="<?php echo $cres['state_id']; ?>"><?php echo $cres['state_name']; ?></option>
                                    <?php
                                }
                                ?>
                            </select></span>
                            <script>document.getElementById('state_id').value = '<?php echo $state_id ; ?>';</script></td>
            <td><input type="text" placeholder="Enter GST Number" autocomplete="off" name="gstno" id="gstno" class="input-xxlarge" autofocus style="width:90%;"/></td>
            </tr>
            
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_party_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_product">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Product</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
            <tr> 
            
            <th>Product Name<span style="color:#F00;"> * </span> </th>
            <th>Product Category<span style="color:#F00;"> * </span> </th>
            </tr>
            <tr>
               <td><input type="text" name="product_name" id="product_name" class="input-xxlarge" placeholder="Enter Product Name"  style="width:90%;" autocomplete="off" autofocus/></td>
            <td>
                <select name="category_id" id="category_id"  class="chzn-select" style="width:230px;">
                      <option value="">---Select---</option>
                      <?php
                      $crow=$obj->executequery("select * from m_category");
                      foreach ($crow as $cres) 
                      {

                        ?>
                        <option value="<?php echo $cres['category_id']; ?>"> <?php echo $cres['category_name']; ?></option>    
                        <?php
                      }

                      ?>

                    </select>
                    <script>document.getElementById('category_id').value = '<?php echo $category_id; ?>';</script>
           </td>   
         
          </tr>
            <tr> 
            <th>Stock Date<span style="color:#F00;">*</span></th> 
            <th>Opening Stock<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td><input type="text" name="stock_date" id="stock_date" class="input-xlarge"  value="<?php echo $stock_date; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy"/ style="width:90%;"></td>
            <td> <input type="text" name="opening_stock" id="opening_stock" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Opening Stock"/></td>
            
            </tr>
            <tr> 
            <th>SGST</th>
            <th>IGST</th>
            </tr>
            <tr>
            <td> <input type="text" name="sgst" id="m_sgst" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter SGST" /></td>
            <td>  
                <input type="text" name="igst" id="m_igst" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  placeholder="Enter IGST"/>
           </td>
            </tr>
            <tr> 
            <th>CGST</th>
            <th>Product Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
              <td> <input type="text" name="cgst" id="m_cgst" class="input-xlarge"  value="<?php echo $cgst;?>" autofocus autocomplete="off"  placeholder="Enter CGST" style="width:90%;"></td>
           
            <td> <select name="product_type" id="product_type"  class="chzn-select" style="width: 230px;" >
                    <option value="" >---Select---</option>
                    <option value="finished good" >Finished Good </option>
                    <option value="raw material" >Raw Material</option>

                  </select>
                  <script>document.getElementById('product_type').value = '<?php echo $product_type ; ?>';</script></td>
            </tr>
            <tr>
            <th>UOM<span style="color:#F00;">*</span></th>
            <th>HSN No.</th>
            </tr>
            <tr>
            <td><select name="unit_id" id="m_unit_id"  class="chzn-select" style="width: 230px;">
                    <option value="" >---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_unit");
                    foreach($res as $row_get)
                    {
                     ?> 
                     <option value="<?php echo $row_get['unit_id']; ?>"> <?php echo $row_get['unit_name']; ?></option>                                          <?php }
                     ?>
                   </select>
                   <script>document.getElementById('unit_id').value = '<?php echo $unit_id ; ?>';</script></td>
            <td><input type="text" name="hsnno" id="hsnno" class="input-xxlarge" autocomplete="off" autofocus style="width:90%;" placeholder="Enter HSN No."/></td>
            </tr>

            <tr>
            <th>Purches Rate</th>
            <th>Sale Rate</th>
            </tr>
            <tr>
            <td> <input type="text" name="purches_rate" id="purches_rate" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Purches Rate"/></td>
             <td> <input type="text" name="sale_rate" id="sale_rate" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Sale Rate"/></td>
            </tr>
            <tr>
              <th>Re Order Limit</th>
              <th>Tax Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
              <td><input type="text" name="reorder_limit" id="reorder_limit" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Re Order Limit"/></td>
              <td><select name="taxtype" id="taxtype" class="chzn-select" style="width: 230px;">
                     <option value="">-Select--</option>
                     <option value="inclusive">Inclusive</option>
                     <option value="exclusive">Exclusive</option>
                   </select>
                   <script type="text/javascript">
                     document.getElementById('taxtype').value = '<?php echo $taxtype; ?>';
                   </script></td>
            </tr>
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_product_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div>   
<script>

function funDel(id)
{ // alert(id);   
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
		  url: 'ajax/delete_sale.php',
		  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			   location='<?php echo $pagename."?action=3" ; ?>';
			}
			
		  });//ajax close
	}//confirm close
} //fun close

function settotal()
{

	var qty=parseFloat(jQuery('#qty').val());	
	var rate_amt=parseFloat(jQuery('#rate_amt').val());	
  
   var disc=parseFloat(jQuery('#disc').val());

	
	if(!isNaN(qty) && !isNaN(rate_amt))
	{
		total=	qty * rate_amt;
	}	

  if(!isNaN(disc))
  {
    discamt = (total * disc)/100;
    total1 = total - discamt;
  }else
  total1 = total;

	jQuery('#total').val(total.toFixed(2));
  jQuery('#taxable').val(total1.toFixed(2));
}	


function settotalupdate()
{

	var qty=parseFloat(jQuery('#mqty').val());	
	var rate_amt=parseFloat(jQuery('#mrate_amt').val());
  var cgst=parseFloat(jQuery('#mcgst').val());
  var sgst=parseFloat(jQuery('#msgst').val());
  var igst=parseFloat(jQuery('#migst').val());
	
	
	if(!isNaN(qty) && !isNaN(rate_amt) && !isNaN(cgst) && !isNaN(sgst) && !isNaN(igst))
	{
    totall=	qty * rate_amt;
    totalc= (totall * cgst)/100;
    totals= (totall * sgst)/100;
    totali= (totall * igst)/100;
    total = totall + totalc + totals + totali;
	}
	
	jQuery('#mtotal').val(total.toFixed(2));
}	

</script>
<script>
function save_party_data()
{
  
  var customer_name = document.getElementById('customer_name').value;
  var mobile = document.getElementById('mobile').value;
  var address = document.getElementById('address').value;
  var email = document.getElementById('email').value;
  var bank_name = document.getElementById('bank_name').value;
  var bank_ac = document.getElementById('bank_ac').value;
  var ifsc_code = document.getElementById('ifsc_code').value;
  var bank_address = document.getElementById('bank_address').value;	
  var state_id = document.getElementById('state_id').value;
  var company_id = document.getElementById('company_id').value;
  var gstno = document.getElementById('gstno').value;
  //alert(company_id);

if (customer_name == '') 
{
  alert('Fill Customer Name');
  return false;
}

if (mobile == '') 
{
  alert('Fill Mobile');
  return false;
}
   jQuery.ajax({
			  type: 'POST',
			  url: 'save_customer.php',
			  data: 'customer_name='+customer_name+'&mobile='+mobile+'&address='+address+'&email='+email+'&bank_name='+bank_name+'&bank_ac='+bank_ac+'&ifsc_code='+ifsc_code+'&bank_address='+bank_address+'&state_id='+state_id+'&company_id='+company_id+'&gstno='+gstno,
			  dataType: 'html',
			  success: function(data){				  
		   		//alert(data);

             		//jQuery('#showallbtn').click();
					jQuery("#customer_name").val('');
					jQuery("#mobile").val('');
          jQuery("#address").val('');
          jQuery("#email").val('');
					jQuery("#bank_name").val('');
					jQuery("#bank_ac").val('');
          jQuery("#ifsc_code").val('');
					jQuery("#bank_address").val('');
					jQuery("#state_id").val('');
					jQuery("#company_id").val('');
          jQuery("#gstno").val('');
					jQuery("#myModal_party").modal('hide');
					jQuery('#customer_id').html(data);
					jQuery("#customer_id").trigger("liszt:updated");
					//jQuery('#customer_id').trigger('chzn-single:updated');
					jQuery('#customer_id').trigger('chzn-single:activate'); // for autofocus
					//getproductdetail();

                       }
			  });//ajax close
				
		}	

function save_product_data()
{
//alert('hiie');
    var product_name = document.getElementById('product_name').value;
    //alert(product_name);
    var category_id = document.getElementById('category_id').value;
    var unit_id = document.getElementById('m_unit_id').value;
    var product_type = document.getElementById('product_type').value;
    var hsnno = document.getElementById('hsnno').value;
    var purches_rate = document.getElementById('purches_rate').value;
    var sale_rate = document.getElementById('sale_rate').value;
    var taxtype = document.getElementById('taxtype').value;
    var opening_stock = document.getElementById('opening_stock').value;	
    var cgst = document.getElementById('m_cgst').value;
    var sgst = document.getElementById('m_sgst').value;
    var igst = document.getElementById('m_igst').value;
    var stock_date = document.getElementById('stock_date').value;
    var reorder_limit = document.getElementById('reorder_limit').value;
    // alert(reorder_limit);
    
	
		if(product_name == "")
    {
      alert('Please Fill Product Name');
      return false;
    }

    if(category_id == "")
    {
      alert('Please Fill Category Name');
      return false;
    }

     if(stock_date == "")
    {
      alert('Please Fill Stock Date');
      return false;
    }
    if(opening_stock == "")
    {
      alert('Please Fill Opening Stock');
      return false;
    }
    if(product_type == "")
    {
      alert('Please Fill Product Type');
      return false;
    }
    if(unit_id == "")
    {
      alert('Please Fill Unit Name');
      return false;
    }
    
    if(taxtype == "")
    {
      alert('Please Fill Tax Type');
      return false;
    }
    
    else
    {
			
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_product.php',
			  data: 'product_name='+product_name+'&category_id='+category_id+'&unit_id='+unit_id+'&product_type='+product_type+'&hsnno='+hsnno+'&purches_rate='+purches_rate+'&taxtype='+taxtype+'&stock_date='+stock_date+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst+'&opening_stock='+opening_stock+'&reorder_limit='+reorder_limit+'&sale_rate='+sale_rate,
			  dataType: 'html',
			  success: function(data){				  
		    //alert(data);
			 		
          jQuery('#showallbtn').click();
          jQuery("#product_name").val('');
          jQuery("#category_id").val('');
          jQuery("#unit_id").val('');
          jQuery("#product_type").val('');
          jQuery("#hsnno").val('');
          jQuery("#purches_rate").val('');
          jQuery("#sale_rate").val('');
          jQuery("#taxtype").val('');
          jQuery("#cgst").val('');
          jQuery("#sgst").val('');
          jQuery("#igst").val('');
          jQuery("#stock_date").val('');
          jQuery("#opening_stock").val('');
          jQuery("#reorder_limit").val('');
          jQuery("#myModal_product").modal('hide');
          jQuery('#product_id').html(data);
          jQuery("#product_id").val('').trigger("liszt:updated");
          jQuery('#product_id').val('').trigger('chzn-single:updated');
          jQuery('#product_id').trigger('chzn-single:activate'); // for autofocus
          //getproductdetail();
				}
				
			  });//ajax close
				
		}	
}

  jQuery(document).ready(function(){
   
   jQuery('#menues').click();
  
   });

   
	function getrecord(keyvalue){
	 // var emp_id=jQuery("#emp_id").val();
	
			  jQuery.ajax({
			  type: 'POST',
			  url: 'show_salerecord.php',
			   data: "purchaseid="+keyvalue,
			  dataType: 'html',
			  success: function(data){				  
				//alert(data);
					jQuery('#showrecord').html(data);
					setTotalrate();
					
				}
				
			  });//ajax close
							  
	}

function getproductdetail(product_id)
{ 
    var product_id=jQuery("#product_id").val();

	if(!isNaN(product_id))
	{
		jQuery.ajax({
					type: 'POST',
					url: 'ajaxgetproductdetailsale.php',
					data: 'product_id='+product_id,
					dataType: 'html',
					success: function(data){				  
					//alert(data);
					
					arr=data.split('|');
          unit_id=arr[0].trim();		
					unit_name=arr[1].trim();
					rate_amt=arr[2].trim();
					cgst=arr[3].trim();
					sgst=arr[4].trim();
					igst=arr[5].trim();
          inc_or_exc=arr[6].trim();

					jQuery('#unit_id').val(unit_id);							
					jQuery('#unit_name').val(unit_name);
					jQuery('#rate_amt').val(rate_amt);
					jQuery('#cgst').val(cgst);
					jQuery('#sgst').val(sgst);
          jQuery('#igst').val(igst);
          jQuery('#inc_or_exc').val(inc_or_exc);
					jQuery('#rate_amt').focus();
					}
				
			  });//ajax close
	}
}

function addlist()
{
	var  product_id= document.getElementById('product_id').value;
	var  unit_id= document.getElementById('unit_id').value;
	var  unit_name= document.getElementById('unit_name').value;
	var  qty= document.getElementById('qty').value;
	var  rate_amt= document.getElementById('rate_amt').value;
  var disc= document.getElementById('disc').value;
  var taxable= document.getElementById('taxable').value;
	var cgst= document.getElementById('cgst').value;
	var sgst= document.getElementById('sgst').value;
	var igst= document.getElementById('igst').value;	
  var inc_or_exc= document.getElementById('inc_or_exc').value;
	var purchaseid='<?php echo $keyvalue; ?>';
	var purdetail_id=0;
    //alert(ratefrmplant);
	if(product_id =='')
	{
		alert('Product cant be blank');	
		return false;
	}
	if(qty=='')
	{
		alert('Quantity Cant be blank');
		return false;
	} 
	else
	{

		jQuery.ajax({
		  type: 'POST',
		  url: 'save_saleproduct.php',
		  data: 'product_id='+product_id+'&unit_name='+unit_name+'&qty='+qty+'&rate_amt='+rate_amt+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst+'&purchaseid='+purchaseid+'&purdetail_id='+purdetail_id+'&inc_or_exc='+inc_or_exc+'&disc='+disc+'&taxable='+taxable,
		  dataType: 'html',
		  success: function(data){				  
			//alert(data);		
		
			jQuery('#product_id').val('');		
			jQuery('#rate_amt').val('');
			jQuery('#qty').val('');
			jQuery('#unit_name').val('');
      jQuery('#inc_or_exc').val('');
			jQuery('#cgst').val('');
			jQuery('#sgst').val('');
			jQuery('#igst').val('');
      jQuery('#disc').val('');
      jQuery('#taxable').val('');
			//jQuery('#productbarcode').val('');
			jQuery('#total').val('');	
			getrecord('<?php echo $keyvalue ?>');
			
			jQuery("#product_id").val('').trigger("liszt:updated");
			document.getElementById('product_id').focus();
			jQuery(".chzn-single").focus();
			}
			
		  });//ajax close
	}
}
function getbill(bill_type)
{
  location='sale_entry.php?bill_type='+bill_type;
}
  
function updatelist()
{

 	var  product_id= document.getElementById('mproduct_id').value;
	var  unit_name= document.getElementById('munit_name').value;
	var  qty= document.getElementById('mqty').value;
	var  rate_amt= document.getElementById('mrate_amt').value;
	var cgst= document.getElementById('mcgst').value;
	var sgst= document.getElementById('msgst').value;
	var igst= document.getElementById('migst').value;	
	var purdetail_id= document.getElementById('m_purdetail_id').value;
	var keyvalue = '<?php echo $keyvalue; ?>';
	
	
	
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
		  url: 'save_purchaseproduct.php',
		  data: 'product_id='+product_id+'&unit_name='+unit_name+'&qty='+qty+'&rate_amt='+rate_amt+'&cgst='+cgst+
		   '&sgst='+sgst+'&igst='+igst+'&purdetail_id='+purdetail_id+'&purchaseid='+keyvalue,
		  dataType: 'html',
		  success: function(data){				  
		//alert(data);
			
			//setTotalrate();
			jQuery('#mproduct_id').val('');
			jQuery('#mrate_amt').val('');
			jQuery('#munit_name').val('');
			jQuery('#mqty').val('');
			jQuery('#mcgst').val('');
			jQuery('#msgst').val('');
			jQuery('#migst').val('');
			jQuery('#purdetail_id').val('');
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
  
 
function add()
{		
	//jQuery("#new").toggle(); 
	jQuery("#list").toggle();
	jQuery("#new2").toggle();
	var button_name=jQuery("#addnew").val();
	
	if(button_name =="Show List")
	{
		jQuery("#addnew").val("+ Add New");
	}
	else
	{
		jQuery("#addnew").val("Show List");
	}
} 
	
	
 function deleterecord(purdetail_id)
  {
	 	tblname = 'purchasentry_detail';
		tblpkey = 'purdetail_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+purdetail_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }

function getcomid(company_id) {
  //alert(company_id);
    jQuery('#myModal_party').modal('show');
    jQuery("#company_id").val(company_id);
}

jQuery('#bill_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#bill_date').focus();

<?php
if(isset($_GET['search']))
{
?>
jQuery(document).ready(function(){
    //jQuery("p").slideToggle();
    //alert('hi');
    jQuery("#new2").hide();
    jQuery("#list").show();
    
});

<?php
}
?>

</script>
</body>
</html>
