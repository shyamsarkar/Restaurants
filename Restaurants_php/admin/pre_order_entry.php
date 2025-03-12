<?php include("../adminsession.php");
$pagename = "pre_order_entry.php";
$module = "Add Pre Order Entry";
$submodule = "Pre Order Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "pre_order_entry";
$tblpkey = "pre_orderid";
//$company_id= $_SESSION['company_id'];

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$duplicate = "";
//$order_date = "";
$order_time = "";
$order_no = "";
$delivery_date = "";
$delivery_time = "";
$cust_name = $mobile_no = $address = $order_description = $advance_amt = "";
$unit_id = "";
$rate_amt = 0;
$remark = "";
$supplier_status = "";
$cgst = "";
if(isset($_GET['pre_orderid']))
$keyvalue = $_GET['pre_orderid'];
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
  //$supplier_id = "";
}

$crit = " where 1 = 1 and order_date between '$from_date' and '$to_date'"; 


if(isset($_POST['submit']))
{ 

  $pre_orderid=$obj->test_input($_POST['pre_orderid']);
  $delivery_time = $obj->test_input($_POST['delivery_time']);
  $order_time = $obj->test_input($_POST['order_time']);
  $order_date = $obj->dateformatusa($_POST['order_date']);
  $delivery_date = $obj->dateformatusa($_POST['delivery_date']);
  $order_no = $obj->test_input($_POST['order_no']);
  $cust_name = $obj->test_input($_POST['cust_name']);
  $mobile_no = $obj->test_input($_POST['mobile_no']);
  $address = $obj->test_input($_POST['address']);
  $order_description = $obj->test_input($_POST['order_description']);
  $net_amount = $obj->test_input($_POST['net_amount']);
  $advance_amt = $obj->test_input($_POST['advance_amt']);
	
	if($pre_orderid == 0)
	{
		$form_data = array('delivery_time'=>$delivery_time,'order_time'=>$order_time,'order_date'=>$order_date,'delivery_date'=>$delivery_date,'order_no'=>$order_no,'cust_name'=>$cust_name,'mobile_no'=>$mobile_no,'address'=>$address,'order_description'=>$order_description,'ipaddress'=>$ipaddress,'sessionid'=>$sessionid,'createdate'=>$createdate,'createdby'=>$loginid,'net_amount'=>$net_amount,'advance_amt'=>$advance_amt);
 
		$lastid = $obj->insert_record_lastid($tblname,$form_data);
		$action=1;
		$process = "insert";
		$form_data2 = array('pre_orderid'=>$lastid);
		echo "<script>location='$pagename?action=$action'</script>";
		$where = array("pre_orderid"=>0);
		$obj->update_record("preentry_detail",$where,$form_data2);
		
      }
	else
	{
		$form_data = array('delivery_time'=>$delivery_time,'order_time'=>$order_time,'order_date'=>$order_date,'delivery_date'=>$delivery_date,'order_no'=>$order_no,'cust_name'=>$cust_name,'mobile_no'=>$mobile_no,'address'=>$address,'order_description'=>$order_description,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'createdby'=>$loginid,'net_amount'=>$net_amount,'advance_amt'=>$advance_amt);
		$where = array($tblpkey=>$keyvalue);
		$obj->update_record($tblname,$where,$form_data);
		$action=2;
		$process = "updated";
					
    }
		echo "<script>location='$pagename?action=$action'</script>";

}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  
  $delivery_time  =  $sqledit['delivery_time'];
  $order_time  =  $sqledit['order_time'];
  $delivery_date  =  $obj->dateformatindia($sqledit['delivery_date']);
  $order_date  = $sqledit['order_date'];
  $order_no  =  $sqledit['order_no'];
  $cust_name  =  $sqledit['cust_name'];
  $mobile_no  =  $sqledit['mobile_no'];
  $address  =  $sqledit['address'];
  $order_description  =  $sqledit['order_description'];
	$net_amount = $sqledit['net_amount'];
  $advance_amt = $sqledit['advance_amt'];
}
else
{
  $order_no = $obj->getprecode("pre_order_entry","order_no","1=1 and sessionid='$sessionid'");
$order_date = date('Y-m-d');
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
         <form action="" method="post" onSubmit="return checkinputmaster('order_date,order_time,order_no,delivery_date,delivery_time,cust_name,mobile_no,address,advance_amt,order_description');">
                
         <div class="row-fluid">
        <table class="table table-condensed table-bordered">
                    <tr>
                          <td colspan="9"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                    </tr>
                    <tr>
                      
                          <td width="15%" ><strong>Order Date:<span style="color:#F00;"> * </span></td>
                          <td width="15%"><strong>Order Time: <span style="color:#F00;"> * </span> :</strong></td>
                          <td width="15%"><strong>Order No : <span style="color:#F00;"> * </span> </strong></td>
                          <td width="15%"><strong>Delivery Date:<span style="color:#F00;"> * </span></td>
                          <td width="15%"><strong>Delivery Time:<span style="color:#F00;"> * </span></td>
                    </tr>
                    <tr>
                          <td>
                                <input type="text" name="order_date" id="order_date" class="form-control text-red"  value="<?php echo $obj->dateformatindia($order_date);?>" autofocus autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask >              
                          </td>
                          <td>
                          <input type="time" name="order_time" id="order_time" class="form-control text-red"  value="<?php echo $order_time;?>" autofocus autocomplete="off">
                          </td>
                          <td>                                           
                          <input type="text" name="order_no" id="order_no" class="form-control text-red"  value="<?php echo $order_no;?>" autofocus autocomplete="off">
                          </td>
                          
                          <td>
                           <input type="text" name="delivery_date" id="delivery_date" class="form-control text-red"  value="<?php echo $delivery_date;?>" autofocus autocomplete="off" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask >
                          </td>
                          <td>    
                          <input type="time" name="delivery_time" id="delivery_time" class="form-control text-red"  value="<?php echo $delivery_time;?>" autofocus autocomplete="off">                                  
                          </td>
                    </tr>

                     <tr>
                      
                          <td width="15%" ><strong>Customer Name:<span style="color:#F00;"> * </span></td>
                          <td width="15%"><strong>Mobile No.: <span style="color:#F00;"> * </span> :</strong></td>
                          <td width="15%"><strong>Address : <span style="color:#F00;"> * </span> </strong></td>
                          <td width="15%"><strong>Advance Amount : <span style="color:#F00;"> * </span> </strong></td>
                          <td width="15%"><strong>Order Description:<span style="color:#F00;"> * </span></td>
                         
                          
                    </tr>
                    <tr>
                        <td>    
                          <input type="text" name="cust_name" id="cust_name" class="form-control text-red"  value="<?php echo $cust_name;?>" autofocus autocomplete="off" placeholder="Enter Customer Name">                                  
                          </td>
                            <td>    
                          <input type="text" name="mobile_no" id="mobile_no" maxlength="10" class="form-control text-red"  value="<?php echo $mobile_no;?>" autofocus autocomplete="off" placeholder="Enter Mobile No.">                                  
                          </td>
                            <td>    
                          <input type="text" name="address" id="address" class="form-control text-red"  value="<?php echo $address;?>" autofocus autocomplete="off" placeholder="Enter Address">                                  
                          </td>
                           <td>    
                          <input type="text" name="advance_amt" id="advance_amt" class="form-control text-red"  value="<?php echo $advance_amt;?>" autofocus autocomplete="off" placeholder="Enter Advance Amount">                                  
                          </td>
                            <td>    
                          <input type="text" name="order_description" id="order_description" class="form-control text-red"  value="<?php echo $order_description;?>" style="height: 50px;" autofocus autocomplete="off" placeholder="Enter Order Description">                                  
                          </td>
                          
                    </tr>
                   
							  </table>
                    </div>
                     <br>
                     <div>
                 	 <div class="alert alert-success">
                     <table width="100%" class="table table-bordered table-condensed">
                     <tr>
                     	<th width="15%">PRODUCT <!-- <a class="btn btn-success btn-small" onClick="getproductmodel();"  data-toggle="modal_product" style="margin-left:20px;"><strong> + </strong></a> --> </th>
                        <th>UOM</th>
                        <th>RATE</th>
                        <th>QTY</th>
                        <th>Total</th>
                        <th>Disc %</th>
                        <th>Taxable</th>
                        <th style="width: 5%;">CGST %</th>
                        <th style="width: 5%;">SGST %</th>
                        <th style="width: 5%;">IGST %</th>
                        <th style="width: 10%;">TaxType</th>
                        <th>Action</th>
                     </tr>
                     <tr>
                     	<td>
                       
                      <select name="productid" id="productid"  class="chzn-select" style="width:243px;" onChange="getproductdetail();">
                      <option value="">---Select---</option>
                      <?php
                      $crow=$obj->executequery("select * from m_product order by prodname asc");
                      foreach ($crow as $cres) 
                      {

                        ?>
                        <option value="<?php echo $cres['productid']; ?>"> <?php echo strtoupper($cres['prodname']); ?></option>    
                        <?php
                      }

                      ?>

                    </select>
                    <script>document.getElementById('productid').value = '<?php echo $productid; ?>';</script>
                          </td>
                           <td><input class="input-mini form-control" type="text" name="unit_name" id="unit_name" value="" style="width:90%;" readonly >     
                               <input class="input-mini form-control" type="hidden" name="unit_id" id="unit_id" value="" style="width:90%;">
                           </td>
                           <td><input class="input-mini" type="text" name="rate_amt" id="rate_amt" value="" style="width:90%;" onkeyup="settotal()" ></td>
                           <td><input class="input-mini" type="text" name="qty" id="qty" value="" style="width:90%;" onkeyup="settotal()"></td>
                           <td><input class="input-mini" type="text" name="total" id="total" value="" style="width:90%;" readonly ></td>

                            <td><input class="input-mini" type="text" name="disc" id="disc" value="" style="width:90%;" onkeyup="settotal()"></td>

                              <td><input class="input-mini" type="text" name="taxable" id="taxable" value="" style="width:90%;"></td>
                           
                        <td><input class="input-mini" type="text" name="cgst" id="cgst" value="" style="width:70%;" onKeyUp="settotal()"></td>                        
                        <td><input class="input-mini" type="text" name="sgst" id="sgst" value="" style="width:70%;" onKeyUp="settotal()" ></td>
                        <td><input class="input-mini" type="text" name="igst" id="igst" value="" style="width:70%;" onKeyUp="settotal()"></td>
                        
                        
                        <td><select id="inc_or_exc" name="inc_or_exc" class="input-mini" style="width:100%;">
                          
                          <option value="inclusive">Inclusive</option>
                          <option value="exclusive">Exclusive</option>
                        </select>
                        
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
            
            <?php   $chkview = $obj->check_pageview("pre_order_entry.php",$loginid);              
              if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>     
            <div id="list" style="display:none;"  >
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
                            <th class="head0">Customer Name</th>
                            <th class="head0">Mobile</th>
                            <th class="head0">Order No</th>
                            <th class="head0">Order Date</th>
                            <th class="head0">Order Time</th>
                             <th class="head0">Delivery Date</th>
                            <th class="head0">Delivery Time</th>
                            <th class="head0" style="text-align: right;">Amount</th>
                            <th  class="head0" style="text-align:center;">Print</th>
                             <?php   $chkedit = $obj->check_editBtn("pre_order_entry.php",$loginid);              
                              if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th  class="head0" >Edit</th>  <?php } ?>
                             <?php  $chkdel = $obj->check_delBtn("pre_order_entry.php",$loginid);             
                              if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>    
                            <th  class="head0" >Delete</th>    <?php } ?>                      
                        </tr>
                    </thead>
                    <tbody id="record">
                           
                          <?php
                          $slno=1;
                         $res = $obj->executequery("select * from pre_order_entry $crit");
                          foreach($res as $row_get)
                          { 
                          $total=0;
                          $pre_orderid = $row_get['pre_orderid'];
                         
                          ?>
                        <tr>
                          <td><?php echo $slno++; ?></td>
                          <td><?php echo $row_get['cust_name']; ?></td>
                          <td><?php echo $row_get['mobile_no']; ?></td>
                          <td><?php echo $row_get['order_no']; ?></td>
                          <td><?php echo $obj->dateformatindia($row_get['order_date']); ?></td>
                          <td><?php echo $row_get['order_time']; ?></td>
                          <td><?php echo $obj->dateformatindia($row_get['delivery_date']); ?></td>
                          <td><?php echo $row_get['delivery_time']; ?></td>
                          <td style="text-align: right;"><?php echo number_format(round($row_get['net_amount']),2); ?></td>

                         <td><center><a class="btn btn-danger" href="pdf_pre_order_invoice.php?pre_orderid=<?php echo  $row_get['pre_orderid']; ?>" target="_blank" > Print </a></center></td>

                          <?php   $chkedit = $obj->check_editBtn("pre_order_entry.php",$loginid);             
                          if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>  
                         <td><a class='icon-edit' title="Edit" href='pre_order_entry.php?pre_orderid=<?php echo  $row_get['pre_orderid']; ?>' style='cursor:pointer'></a></td><?php } ?>&nbsp;
                          <?php $chkdel = $obj->check_delBtn("pre_order_entry.php",$loginid);  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?> <td>
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['pre_orderid']; ?>);' style='cursor:pointer'></a>
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
              <h3 id="myModalLabel">ADD New Supplier</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
             <table class="table table-condensed table-bordered">
              <tr> 
                <th style="width: 50%;">Supplier Name<span style="color:#F00;"> * </span> </th>
                <th>Mobile<span style="color:#F00;">  *</span> </th>
              </tr>
                  <td>
                   <input type="text" name="supplier_name" id="supplier_name" class="input-xxlarge"  style="width:90%;" autocomplete="off" autofocus placeholder="Enter Supplier Name"/> 
                  </td>
                   <td>
                   <input type="text" name="mobile" id="mobile" class="input-xxlarge" style="width:90%;" autocomplete="off" maxlength="10" autofocus placeholder="Enter Mobile"/> 
                   
                  </td>                              
              
            <tr> 
            <th>Email Id</th> 
            <th>Address</th>
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
               <input type="text" name="bank_address" id="bank_address" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Bank Address" />
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
            <td><input type="text" name="gstno" id="gstno" class="input-xxlarge" style="width:90%;" placeholder="Enter GST Number" autocomplete="off" autofocus/></td>
            </tr>
            
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_party_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
</div>


<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModalproduct">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Product</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
            <tr> 
            
            <th>Raw Material Name<span style="color:#F00;"> * </span> </th>
            <th>Unit<span style="color:#F00;"> * </span> </th>
            </tr>
            <tr>
               <td><input type="text" name="raw_name" id="raw_name" class="input-xxlarge"  style="width:90%;" autocomplete="off" autofocus placeholder="Enter Product Name" /></td>
            <td>
                <select name="unitid" id="unitid"  class="chzn-select" style="width:230px;">
                      <option value="">---Select---</option>
                      <?php
                      $crow=$obj->executequery("select * from m_unit");
                      foreach ($crow as $cres) 
                      {

                        ?>
                        <option value="<?php echo $cres['unitid']; ?>"> <?php echo $cres['unit_name']; ?></option>    
                        <?php
                      }

                      ?>

                    </select>
                    
           </td>   
         
          </tr>
            <tr>
            <th>Product Type<span style="color:#F00;"> * </span></th> 
            <th>Opening Stock Quantity<span style="color:#F00;"> * </span></th> 
            <!-- <th>Opening Date<span style="color:#F00;"> * </span></th> -->
            </tr>
            <tr>
              <td><select name="product_type" id="product_type"  class="chzn-select" style="width:230px;">
                <option value="" >---Select---</option>
                    <option value="packed item">Packed item</option>
                    <option value="raw material">Raw Material</option>

              </select></td>
            
            <td> <input type="text" name="qty" id="qty1" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus placeholder="Enter Opening Stock"/></td>
            
            
            </tr>
            <tr> 
            <th>Rate</th>
            <th>Opening Date<span style="color:#F00;"> * </span></th>
            </tr>
            <tr>
            <td> <input type="text" name="rate" id="rate" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  placeholder="Enter SGST"/></td>

            <td><input type="text" name="open_date" id="open_date" class="input-xlarge"  value="<?php echo $open_date; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy"/ style="width:90%;"></td>
            
            </tr>

            <tr>
              <th>Reorder Limit</th>
              <th></th>
            </tr>
             <tr>
            <td> <input type="text" name="reorder_limit" id="reorder_limit" class="input-xxlarge" style="width:90%;" autocomplete="off" autofocus  placeholder="Enter SGST"/></td>
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
		  url: 'ajax/delete_pre_order.php',
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
  // var cgst=parseFloat(jQuery('#cgst').val()); 
  // var sgst=parseFloat(jQuery('#sgst').val());
  // var igst=parseFloat(jQuery('#igst').val());
	var disc=parseFloat(jQuery('#disc').val());
 
	// var totsgst = 0;
 //  var totcgst = 0;
 //  var totigst = 0;
  
  if(!isNaN(qty) && !isNaN(rate_amt))
  {
    total = qty * rate_amt;
  } 
  
 if(!isNaN(disc))
  {
    discamt = (total * disc)/100;
    total1 = total - discamt;
  }else
  total1 = total;

  //   if(!isNaN(cgst))
  // {
  //   totcgst = (total * cgst)/100;
  // } 
  
  // if(!isNaN(sgst))
  // {
  //       totsgst = (total * sgst)/100;
  // } 
  
  // if(!isNaN(igst))
  // {
  //   totigst = (total * igst)/100;
  // } 
  
  // totgst = totcgst + totsgst + totigst;
  // total += totgst;
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
  
  var supplier_name = document.getElementById('supplier_name').value;
  var mobile = document.getElementById('mobile').value;
  var address = document.getElementById('address').value;
  var email = document.getElementById('email').value;
  var bank_name = document.getElementById('bank_name').value;
  var bank_ac = document.getElementById('bank_ac').value;
  var ifsc_code = document.getElementById('ifsc_code').value;
  var bank_address = document.getElementById('bank_address').value;	
  var state_id = document.getElementById('state_id').value;
  
  //alert(company_id);

if (supplier_name == '') 
{
  alert('Fill Supplier Name');
  return false;
}

if (mobile == '') 
{
  alert('Fill Mobile');
  return false;
}

else
    {
   jQuery.ajax({
			  type: 'POST',
			  url: 'save_party.php',
			  data: 'supplier_name='+supplier_name+'&mobile='+mobile+'&address='+address+'&email='+email+'&bank_name='+bank_name+'&bank_ac='+bank_ac+'&ifsc_code='+ifsc_code+'&bank_address='+bank_address+'&state_id='+state_id,
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
          if(data == 4)
        {
          alert('Duplicate Record');
        }

					jQuery('#supplier_id').html(data);
          //jQuery('#supplier_id').val('').trigger('chzn-single:updated');
					jQuery("#supplier_id").trigger("liszt:updated");
          jQuery('#supplier_id').trigger('chzn-single:activate'); // for autofocus
					
					//getproductdetail();

                       }
			  });//ajax close
    }
				
		}	

function save_product_data()
{
//alert('hiie');
    var raw_name = document.getElementById('raw_name').value;
    //alert(product_name);
    var unitid = document.getElementById('unitid').value;
    var qty = document.getElementById('qty1').value;
    var open_date = document.getElementById('open_date').value;
    var rate = document.getElementById('rate').value;
    var product_type = document.getElementById('product_type').value;
    var reorder_limit = document.getElementById('reorder_limit').value;
	
		if(raw_name == "")
		{
			alert('Please Fill Product Name');
			return false;
		}

    if(unitid == "")
    {
      alert('Please Fill Category Name');
      return false;
    }

		
		else
		{
			
			jQuery.ajax({
			  type: 'POST',
			  url: 'save_product.php',
			  data: 'raw_name='+raw_name+'&unitid='+unitid+'&qty='+qty+'&open_date='+open_date+'&rate='+rate+'&reorder_limit='+reorder_limit+'&product_type='+product_type,
			  dataType: 'html',
			  success: function(data){				  
		   // alert(data);
			 		
          jQuery('#showallbtn').click();
          jQuery("#raw_name").val('');
          jQuery("#unitid").val('');
          jQuery("#qty1").val('');
          jQuery("#rate").val('');
          jQuery("#reorder_limit").val('');
          jQuery("#product_type").val('');
          
          jQuery("#myModalproduct").modal('hide');
          jQuery('#raw_id').html(data);
           jQuery("#unitid").val('').trigger("liszt:updated");
           jQuery("#product_type").val('').trigger("liszt:updated");
          // jQuery('#product_id').val('').trigger('chzn-single:updated');
          // jQuery('#product_id').trigger('chzn-single:activate'); // for autofocus
          jQuery("#raw_id").trigger("liszt:updated");
          jQuery('#raw_id').trigger('chzn-single:activate');
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
			  url: 'show_pre_orderrecord.php',
			   data: "pre_orderid="+keyvalue,
			  dataType: 'html',
			  success: function(data){				  
				//alert(data);
					jQuery('#showrecord').html(data);
					setTotalrate();
					
				}
				
			  });//ajax close
							  
	}

function getproductdetail()
{ 
    var productid=jQuery("#productid").val();
    //alert(product_id);
	if(!isNaN(productid))
	{
		jQuery.ajax({
					type: 'POST',
					url: 'ajaxgetproductdetail_preorder.php',
					data: 'productid='+productid,
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
	var  productid= document.getElementById('productid').value;
  //alert(raw_id);
	var  unit_id= document.getElementById('unit_id').value;
	var  unit_name= document.getElementById('unit_name').value;
	var  qty= document.getElementById('qty').value;
	var  rate_amt= document.getElementById('rate_amt').value;
	var cgst= document.getElementById('cgst').value;
	var sgst= document.getElementById('sgst').value;
	var igst= document.getElementById('igst').value;
  var disc= document.getElementById('disc').value;	
  var taxable= document.getElementById('taxable').value; 
  var inc_or_exc= document.getElementById('inc_or_exc').value;
	var pre_orderid='<?php echo $keyvalue; ?>';
	var pre_detail_id=0;
    //alert(ratefrmplant);
	if(productid =='')
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
		  url: 'save_pre_orderproduct.php',
		  data: 'productid='+productid+'&unit_name='+unit_name+'&qty='+qty+'&rate_amt='+rate_amt+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst+'&pre_orderid='+pre_orderid+'&pre_detail_id='+pre_detail_id+'&inc_or_exc='+inc_or_exc+'&disc='+disc+'&taxable='+taxable+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst,
		  dataType: 'html',
		  success: function(data){				  
			//alert(data);		
		
			jQuery('#productid').val('');		
			jQuery('#rate_amt').val('');
			jQuery('#qty').val('');
			jQuery('#unit_name').val('');
      jQuery('#inc_or_exc').val('');
      jQuery('#disc').val('');
			jQuery('#cgst').val('');
			jQuery('#sgst').val('');
			jQuery('#igst').val('');
      jQuery('#taxable').val('');
			//jQuery('#productbarcode').val('');
			jQuery('#total').val('');	
			getrecord('<?php echo $keyvalue ?>');
			
			jQuery("#raw_id").val('').trigger("liszt:updated");
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
	
	
 function deleterecord(pre_detail_id)
  {
	 	tblname = 'preentry_detail';
		tblpkey = 'pre_detail_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+pre_detail_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }

function getcomid() {
  //alert(company_id);
    jQuery('#myModal_party').modal('show');
    //jQuery("#company_id").val(company_id);
}

function getproductmodel()
{
  //alert('hiie');
  jQuery('#myModalproduct').modal('show');
}

jQuery('#delivery_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#order_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#delivery_date').focus();

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

jQuery(function() {
                //Datemask dd/mm/yyyy
                jQuery("#from_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});               
                jQuery("[data-mask]").inputmask();
              });

jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#to_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#sale_date').focus();
</script>
</body>
</html>
