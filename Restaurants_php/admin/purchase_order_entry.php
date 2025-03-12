<?php include("../adminsession.php");
$pagename = "purchase_order_entry.php";
$module = "Demand Entry";
$submodule = "Demand Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "demand_entry";
$tblpkey = "demand_id";

$company_id= $_SESSION['company_id'];

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
$company_id = $_SESSION['company_id'];
$company_name = "";
$bill_type = "";
$unit_id = "";
$rate_amt = 0;
$remark = "";
$supplier_status = "";
$cgst = "";

if(isset($_GET['demand_id']))
$keyvalue = $_GET['demand_id'];
else
$keyvalue = 0;
if(isset($_POST['submit']))
{ 

	$demand_id=trim(addslashes($_POST['demand_id']));
	$demand_order_no = trim(addslashes($_POST['demand_order_no']));
	$supplier_id = trim(addslashes($_POST['supplier_id']));
	$demand_date = $obj->dateformatusa(trim(addslashes($_POST['demand_date'])));
  $remark = trim(addslashes($_POST['remark']));
	
	if($demand_id == 0)
	{
		$form_data = array('demand_order_no'=>$demand_order_no,'demand_date'=>$demand_date,'supplier_id'=>$supplier_id,'company_id'=>$company_id,'remark'=>$remark,'ipaddress'=>$ipaddress,'sessionid'=>$sessionid,'createdate'=>$createdate,'createdby'=>$loginid);
 
		$lastid = $obj->insert_record_lastid($tblname,$form_data);
		$action=1;
		$process = "insert";
		$form_data2 = array('demand_id'=>$lastid);
		echo "<script>location='$pagename?action=$action'</script>";
		$where = array("purchase_order_id"=>0);
		$keyvalue = $obj->update_record("demand_detail",$where,$form_data2);
		die;
      }
	else
	{
		$form_data = array('demand_order_no'=>$demand_order_no,'demand_date'=>$demand_date,'supplier_id'=>$supplier_id,'company_id'=>$company_id,'remark'=>$remark,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid);
		$where = array($tblpkey=>$keyvalue);
		$keyvalue = $obj->update_record($tblname,$where,$form_data);
		$action=2;
		$process = "updated";
					
    }
		echo "<script>location='$pagename?action=$action'</script>";

	echo "<script>location='$pagename?action=$action'</script>";
		
}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  
  $demand_order_no  =  $sqledit['demand_order_no'];
  $supplier_id =  $sqledit['supplier_id'];
  $demand_date  =  $obj->dateformatindia($sqledit['demand_date']);
  $company_id  =  $sqledit['company_id'];
  $company_name = $obj->getvalfield("company_setting","company_name","company_id = '$company_id'");
  $remark  =  $sqledit['remark'];
	
}
else
{
	  
    $demand_date=date('d-m-Y');
    $stock_date = date('d-m-Y');
    $company_id = $_SESSION['company_id'];
	  $company_name = $obj->getvalfield("company_setting","company_name","company_id = '$company_id'");
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
         <form action="" method="post" onSubmit="return checkinputmaster('company_id,billno,bill_date,customer_id,purchase_type');">
                
         <div class="row-fluid">
        <table class="table table-condensed table-bordered">
                    <tr>
                          <td colspan="9"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                    </tr>
                    <tr>
                          <td width="15%" ><strong>Supplier:<span style="color:#F00;"> * </span><a class="btn btn-success btn-small" onClick="getcomid('<?php echo $company_id; ?>');" data-toggle="modal_party" style="margin-left:20px;"><strong> + </strong></a></td>
                          <td width="15%"><strong>Demand No.: <span style="color:#F00;"> * </span> </strong></td>
                          <td width="15%"><strong>Demand Date: <span style="color:#F00;"> * </span> :</strong></td>
                         
                          <td width="15%"><strong>Remark:<span style="color:#F00;"> * </span></td>
                    </tr>
                    <tr>
                          <td>
                          <select name="supplier_id" id="supplier_id" class="chzn-select" >
                          <option value="">--Choose Site--</option>
                          <?php
                          $slno=1;

                          $res = $obj->executequery("select * from master_supplier");
                          foreach($res as $row_get)

                          {               
                          ?>
                          <option value="<?php echo $row_get['supplier_id']; ?>"> <?php echo $row_get['supplier_name']; ?></option>
                          <?php } ?>
                          </select>
                          <script> document.getElementById('supplier_id').value='<?php echo $supplier_id; ?>'; </script>                    
                          </td>
                          <td>
                          <input type="text" name="demand_order_no" id="demand_order_no" class="form-control text-red" autofocus autocomplete="off" placeholder="Enter Purchase Order No.">

                          </td>
                          <td>                                           
                          <input type="text" name="demand_date" id="demand_date" class="form-control text-red"  value="<?php echo $demand_date;?>" autofocus autocomplete="off" maxlength="10" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask >
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
                        <th style="width: 20%;">UOM</th>
                        <th>QTY</th>
                        <th>Action</th>
                     </tr>
                     <tr>
                     	<td>
                        <select name="product_id" id="product_id" class="form-control chzn-select" >
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
                          <td>
                        <input class="input-mini form-control" type="text" name="unit_name" id="unit_name" value="" style="width:90%;">
                        </td>   
                               <input class="input-mini form-control" type="hidden" name="unit_id" id="unit_id" value="" style="width:90%;">
                           </td>
                          
                           <td><input class="input-mini" type="text" name="qty" id="qty" value="" style="width:90%;" onkeyup="settotal()"></td>
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
            <div id="list" style="display:none;"  >
              
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
                            <th class="head0">Supplier Name</th>
                            <th class="head0">Bill No</th>
                            <th class="head0">Bill Date</th>
                            <th class="head0">Bill Type</th>
                            <th class="head0" style="text-align: right;">Amount</th>
                            <th  class="head0" style="text-align:center;">Print A4</th>
                            <th  class="head0" >Action</th>                          
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                          <?php
                          $slno=1;
                         $company_id=$_SESSION['company_id'];
                         $res = $obj->executequery("select * from purchaseentry where company_id = '$company_id' order by purchaseid desc");
                          foreach($res as $row_get)
                          {
                          $total=0;
                          $company_id = $row_get['company_id'];
                          $company_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
                          $supplier_id = $row_get['supplier_id'];
                          $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
                          // $customer_type = $obj->getvalfield("master_customer","customer_type","customer_id='$row_get[customer_id]'");
                          //echo $customer_type;die;
                          $total = $obj->getTotalPerchaseBillAmt($row_get['purchaseid']);	

                          ?>
                        <tr>
                          <td><?php echo $slno++; ?></td>
                          <td><?php echo $company_name; ?></td>
                          <td><?php echo $supplier_name; ?></td>
                          <td><?php echo $row_get['billno']; ?></td>
                          <td><?php echo $obj->dateformatindia($row_get['bill_date']); ?></td>
                          <td><?php echo $row_get['bill_type']; ?></td>
                          <td style="text-align: right;"><?php echo number_format(round($total),2); ?></td>
                         <td><center><a class="btn btn-danger" href="pdf_purches_invoice.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Invoice A4 </a></center></td>
                         <td><a class='icon-edit' title="Edit" href='purchaseentry.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>' style='cursor:pointer'></a>&nbsp;
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['purchaseid']; ?>);' style='cursor:pointer'></a>
                         </td>
                        </tr>
                        <?php
						            }
						           ?>
                        
                       
                    </tbody>
                </table>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_party">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Supplier</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
             <table class="table table-condensed table-bordered">
              <tr> 
                <th style="width: 50%;">Supplier Name<span style="color:#F00;"> * </span> </th>
                <th>Mobile<span style="color:#F00;">  </span> </th>
              </tr>
                  <td>
                   <input type="text" name="supplier_name" id="supplier_name" class="input-xxlarge"  style="width:90%;" autocomplete="off" autofocus/> 
                  </td>
                   <td>
                   <input type="text" name="mobile" id="mobile" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus/> 
                   <input type="hidden" id="company_id" name="company_id" value="<?php echo $company_id ; ?>">
                  </td>                              
              
            <tr> 
            <th>Email Id</th> 
            <th>Address<span style="color:#F00;"> </span> </th>
            </tr>
            <tr>
            <td>
                <input type="email" name="email" id="email" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus/>
           </td> 
          <td>
               <input type="text" name="address" id="address" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus/>
        </td>
          </tr>
            <tr> 
            <th>Bank Name<span style="color:#F00;"></span></th>
            <th>Bank Account</th>
            </tr>
            <tr>
            <td> <input type="text" name="bank_name" id="bank_name" class="input-xxlarge" style="width:90%;" autofocus autocomplete="off"/></td>

            <td><input type="text" name="bank_ac" id="bank_ac" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus/></td>
            </tr>
            <tr> 
            <th>IFSC Code<span style="color:#F00;"></span></th>
            <th>Bank Address<span style="color:#F00;"></span></th>
            </tr>
            <tr>
            <td> <input type="text" name="ifsc_code" id="ifsc_code" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  /></td>
            <td>  
               <input type="text" name="bank_address" id="bank_address" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  />
           </td>
            </tr>
            <tr> 
            <th>State Name<span style="color:#F00;"></span></th>
            <th></th>
           
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
            <td></td>
            </tr>
            
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_party_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div>

<div class="modal fade" id="myModal" role="dialog" aria-hidden="true" style="display:none;" >
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
                    </div>
                        <div class="modal-body">
		<table class="table table-bordered table-condensed">
            <tr>
                <th width="18%">Product Name &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">Unit &nbsp;<span style="color:#F00;">*</span></th>                                           
            </tr>
            <tr>
                <td>                                           
                <input class="form-control" name="mproduct_name" id="mproduct_name" value="" autofocus="" type="text" readonly style="z-index:-44;" >
                <input type="hidden" name="mproduct_id" id="mproduct_id"  readonly >                              
                </td>
                <td>                                           
                <input class="form-control" name="munit_name" id="munit_name"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Unit">
                </td>
           </tr>
                                        
            <tr>
                  <th>Qty &nbsp;<span style="color:#F00;">*</span></th>
                  <th width="18%">Rate &nbsp;<span style="color:#F00;">*</span></th>
            </tr>
            <tr>  
                <td> 
                <input class="form-control" name="mqty" id="mqty"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Quantity" onkeyup="settotalupdate();"> 
                </td>
                <td>                                           
                <input class="form-control" name="mrate_amt" id="mrate_amt"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Rate" onChange="settotalupdate();" >
                </td>
           </tr>
            <tr>
                <th>CGST &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">SGST &nbsp;<span style="color:#F00;">*</span></th>
            </tr>
            <tr>                                                              
                <td> 
                <input class="form-control" name="mcgst" id="mcgst"  value="" autocomplete="off" autofocus="" type="text"  placeholder="Enter CGST" onChange="settotalupdate();" >                            
                </td>
                <td>                                           
                <input class="form-control" name="msgst" id="msgst"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter SGST" onChange="settotalupdate();" >
                </td> 
           </tr>


            <tr>
                <th>IGST &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">Total &nbsp;<span style="color:#F00;">*</span></th>
            </tr>
            <tr>                                                               
                <td> 
                <input class="form-control" name="migst" id="migst"  value="" autocomplete="off" autofocus="" type="text"  placeholder="Enter IGST" onChange="settotalupdate();" >                           
                </td>
                <td>                                           
                <input class="form-control" name="mtotal" id="mtotal"  value="" autocomplete="off" autofocus="" type="text" readonly >
                </td>
           </tr>
                        
     </table>
                        </div>
                        <div class="modal-footer clearfix">
                        <input type="hidden" id="m_purdetail_id" value="0" >
                         <input type="submit" class="btn btn-primary" name="submit" value="Add" onClick="updatelist();" id="saveitem" >
                           <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

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
               <td><input type="text" name="product_name" id="product_name" class="input-xxlarge"  style="width:90%;" autocomplete="off" autofocus/></td>
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
            <th>Stock Date</th> 
            <th>CGST</th>
            </tr>
            <tr>
            <td><input type="text" name="stock_date" id="stock_date" class="input-xlarge"  value="<?php echo $stock_date; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy"/ style="width:90%;"></td>
            <td> <input type="text" name="cgst" id="m_cgst" class="input-xlarge"  value="<?php echo $cgst;?>" autofocus autocomplete="off"  placeholder="Enter CGST"/ style="width:90%;"></td>
            </tr>
            <tr> 
            <th>SGST<span style="color:#F00;">*</span></th>
            <th>IGST<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="sgst" id="m_sgst" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  /></td>
            <td>  
                <input type="text" name="igst" id="m_igst" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  />
           </td>
            </tr>
            <tr> 
            <th>UOM<span style="color:#F00;">*</span></th>
            <th>Product Type<span style="color:#F00;">*</span></th>
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
            <td> <select name="product_type" id="product_type"  class="chzn-select" style="width: 230px;" >
                    <option value="" >---Select---</option>
                    <option value="finished good" >Finished Good </option>
                    <option value="raw material" >Raw Material</option>

                  </select>
                  <script>document.getElementById('product_type').value = '<?php echo $product_type ; ?>';</script></td>
            </tr>
            <tr>
            <th>Opening Stock<span style="color:#F00;">*</span></th>
            <th>HSN No.<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="opening_stock" id="opening_stock" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus /></td>
            <td><input type="text" name="hsnno" id="hsnno" class="input-xxlarge" autocomplete="off" autofocus style="width:90%;"/></td>
            </tr>

            <tr>
            <th>Rate<span style="color:#F00;">*</span></th>
            <th>Tax Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td> <input type="text" name="ratefrmplant" id="ratefrmplant" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus /></td>
            <td><select name="taxtype" id="taxtype" class="chzn-select" style="width: 230px;">
                     <option value="">-Select--</option>
                     <option value="inclusive">Inclusive</option>
                     <option value="exclusive">Exclusive</option>
                   </select>
                   <script type="text/javascript">
                     document.getElementById('taxtype').value = '<?php echo $taxtype; ?>';
                   </script></td>
            </tr>
            <tr>
              <th>Re Order Limit<span style="color:#F00;">*</span></th>
              <th><span style="color:#F00;"></span></th>
            </tr>
            <tr>
              <td><input type="text" name="reorder_limit" id="reorder_limit" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus /></td>
              <td></td>
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

function settotal()
{

	var qty=parseFloat(jQuery('#qty').val());	
	var rate_amt=parseFloat(jQuery('#rate_amt').val());	
  var cgst=parseFloat(jQuery('#cgst').val()); 
  var sgst=parseFloat(jQuery('#sgst').val());
  var igst=parseFloat(jQuery('#igst').val());
	
	if(!isNaN(qty) && !isNaN(rate_amt))
	{
		total=	qty * rate_amt;
	}	
	
	if(!isNaN(cgst))
  {
    total_cgst = (total * cgst)/100;
  }
  else
  total_cgst = 0;

  if(!isNaN(sgst))
  {
    total_sgst = (total * sgst)/100;
  }
  else
  total_sgst = 0;

  if(!isNaN(igst))
  {
    total_igst = (total * igst)/100;
  }
  else
  total_igst = 0;

  total += total_cgst + total_sgst + total_igst;
	jQuery('#total').val(total.toFixed(2));
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
  
  var supplier_name = document.getElementById('supplier_name').value;
  var mobile = document.getElementById('mobile').value;
  var address = document.getElementById('address').value;
  var email = document.getElementById('email').value;
  var bank_name = document.getElementById('bank_name').value;
  var bank_ac = document.getElementById('bank_ac').value;
  var ifsc_code = document.getElementById('ifsc_code').value;
  var bank_address = document.getElementById('bank_address').value;	
  var state_id = document.getElementById('state_id').value;
  var company_id = document.getElementById('company_id').value;
  //alert(company_id);

if (supplier_name == '') 
{
  alert('Fill Supplier Name');
  return false;
}
   jQuery.ajax({
			  type: 'POST',
			  url: 'save_party.php',
			  data: 'supplier_name='+supplier_name+'&mobile='+mobile+'&address='+address+'&email='+email+'&bank_name='+bank_name+'&bank_ac='+bank_ac+'&ifsc_code='+ifsc_code+'&bank_address='+bank_address+'&state_id='+state_id+'&company_id='+company_id,
			  dataType: 'html',
			  success: function(data){				  
		   		//alert(data);

             		//jQuery('#showallbtn').click();
					jQuery("#supplier_name").val('');
					jQuery("#mobile").val('');
          jQuery("#address").val('');
          jQuery("#email").val('');
					jQuery("#bank_name").val('');
					jQuery("#bank_ac").val('');
          jQuery("#ifsc_code").val('');
					jQuery("#bank_address").val('');
					jQuery("#state_id").val('');
					jQuery("#company_id").val('');
					jQuery("#myModal_party").modal('hide');
					jQuery('#supplier_id').html(data);
					jQuery("#supplier_id").val('').trigger("liszt:updated");
					jQuery('#supplier_id').val('').trigger('chzn-single:updated');
					jQuery('#supplier_id').trigger('chzn-single:activate'); // for autofocus
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
    var ratefrmplant = document.getElementById('ratefrmplant').value;
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
		
		else
		{
			
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_product.php',
			  data: 'product_name='+product_name+'&category_id='+category_id+'&unit_id='+unit_id+'&product_type='+product_type+'&hsnno='+hsnno+'&ratefrmplant='+ratefrmplant+'&taxtype='+taxtype+'&stock_date='+stock_date+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst+'&opening_stock='+opening_stock+'&reorder_limit='+reorder_limit,
			  dataType: 'html',
			  success: function(data){				  
		    //alert(data);
			 		
          jQuery('#showallbtn').click();
          jQuery("#product_name").val('');
          jQuery("#category_id").val('');
          jQuery("#unit_id").val('');
          jQuery("#product_type").val('');
          jQuery("#hsnno").val('');
          jQuery("#ratefrmplant").val('');
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

  // jQuery(document).ready(function(){
   
  //  jQuery('#menues').click();
  
  //  });

   
	function getrecord(keyvalue){
	 // var emp_id=jQuery("#emp_id").val();
	
			  jQuery.ajax({
			  type: 'POST',
			  url: 'show_purcheserecord.php',
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
					url: 'ajaxgetproductdetail.php',
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
	
	var  qty= document.getElementById('qty').value;
	
	var purchase_order_id='<?php echo $keyvalue; ?>';
	var purchase_order_detail_id=0;
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
		  url: 'save_purchaseproduct.php',
		  data: 'product_id='+product_id+'&unit_id='+unit_id+'&qty='+qty+'&purchase_order_id='+purchase_order_id+'&purchase_order_detail_id='+purchase_order_detail_id,
		  dataType: 'html',
		  success: function(data){				  
			//alert(data);		
		
			jQuery('#product_id').val('');		
			jQuery('#unit_id').val('');
			jQuery('#qty').val('');
			
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

function updaterecord(product_name,product_id,unit_name,qty,rate_amt,cgst,sgst,igst,total,purdetail_id)
{
	
			jQuery("#myModal").modal('show');
			jQuery("#saveitem").attr('value', 'Update');
			jQuery("#mproduct_name").val(product_name);
			jQuery("#mproduct_id").val(product_id);
			jQuery("#munit_name").val(unit_name);
      jQuery("#mqty").val(qty);
			jQuery("#mrate_amt").val(rate_amt);
			jQuery("#mcgst").val(cgst);
      jQuery("#msgst").val(sgst);
      jQuery("#migst").val(igst);
      jQuery("#mtotal").val(total); 
			jQuery("#m_purdetail_id").val(purdetail_id);
		  settotalupdate();
			jQuery("#qty").focus();
		
}

jQuery('#bill_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#bill_date').focus();


</script>
</body>
</html>
