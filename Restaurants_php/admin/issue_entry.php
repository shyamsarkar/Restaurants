<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "issue_entry.php";
$module = "Add Issue Entry";
$submodule = "Issue Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "issue_entry";
$tblpkey = "issueid";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

$duplicate = "";
//$company_id = $_SESSION['company_id'];
$company_name = "";
$stock_date = $cgst = $sgst = $igst = $opening_stock = $hsnno = $product_rate = $reorder_limit="";
$issueno = $issueto = $remark ="";


if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatusa($_GET['from_date']);
    $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
  $ddepartment_id = "";
}

$crit = " where 1 = 1 and issuedate between '$from_date' and '$to_date'"; 



if(isset($_GET['department_id']))
{
  
  $ddepartment_id = $_GET['department_id'];
  if(!empty($ddepartment_id))
    $crit .= " and department_id = '$ddepartment_id'";
}

if(isset($_GET['issueid']))
$keyvalue = $_GET['issueid'];
else
$keyvalue = 0;

if(isset($_POST['submit']))
{ 
  //print_r($_POST);die();
//	$issueid = $_POST['issueid'];
	$issueno = $obj->test_input($_POST['issueno']);
  $issuedate = $obj->dateformatusa($_POST['issuedate']);
	$department_id = $obj->test_input($_POST['department_id']);
	$remark = $obj->test_input($_POST['remark']);

	if($keyvalue == 0)
	{
		$form_data = array('issueno'=>$issueno,'issuedate'=>$issuedate,'department_id'=>$department_id,'remark'=>$remark,'sessionid'=>$sessionid,'createdby'=>$loginid,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
		$lastid = $obj->insert_record_lastid($tblname,$form_data);
		$action=1;
		$process = "insert";
		$form_data2 = array('issueid'=>$lastid);
		$where = array("issueid"=>0);
		$keyvalue = $obj->update_record("issue_entry_details",$where,$form_data2);
   
	}
	else
	{
		$form_data = array('issueno'=>$issueno,'issuedate'=>$issuedate,'department_id'=>$department_id,'remark'=>$remark,'sessionid'=>$sessionid,'createdby'=>$loginid,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
		$where = array($tblpkey=>$keyvalue);
		$keyvalue = $obj->update_record($tblname,$where,$form_data);
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
  $issueid = $sqledit['issueid'];
  $issueno  =  $sqledit['issueno'];
  $issuedate  =  $obj->dateformatindia($sqledit['issuedate']);
  $department_id  =  $sqledit['department_id'];
  $remark =  $sqledit['remark'];
}
else
{
	$issuedate=date('d-m-Y');
  $stock_date=date('d-m-Y');
  $issueno = $obj->getcode_issueno($tblname,$tblpkey,"1=1");
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
       
      <div style="float:right;">
            <input type="button" class="btn btn-primary" style="float:right; margin-top:10px" name="addnew" id="addnew" onClick="add();" 
            value="Show List">
           </div>
        <div class="maincontent">
        	 <div class="contentinner content-dashboard">
<div id="new2">               
         <form action="" method="post" onSubmit="return checkinputmaster('issueno,issuedate,department_id');"   >
                
 <div class="row-fluid">
     <table class="table table-condensed table-bordered">
      <tr>
          <td colspan="9"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
      </tr>
      <tr>
        <td width="15%" ><strong>Issue No:<span style="color:#F00;"> * </span></strong></td>
        <td width="25%"><strong>Date:<span style="color:#F00;">* </span>: </strong></td>
        <td width="15%" ><strong>Kitchen Name:<span style="color:#F00;"> * </span></strong></td>
        <td width="15%" ><strong>Remark:</strong></td>
      </tr>
      <tr>
        <td>
        <input type="text" name="issueno" id="issueno" class="form-control text-red"  value="<?php echo $issueno;?>"  autofocus autocomplete="off" readonly> 
        </td>
        <td><input type="text" name="issuedate" id="issuedate" class="form-control text-red"  placeholder='dd-mm-yyyy'
        value="<?php echo $issuedate; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask />
        </td>
        <td> 
          <select name="department_id" id="department_id" class="chzn-select">
              <option value="" >--Choose kitchen--</option>
              <option value="1" >Kitchen 1</option>
              <option value="2" >Kitchen 2</option>
              
          </select>
          <script> document.getElementById('department_id').value='<?php echo $department_id; ?>'; </script>               
        </td>
        <td> <input type="text" name="remark" id="remark" class="form-control text-red"  value="<?php echo $remark;?>" autofocus autocomplete="off">                      
        </td>
      </tr>
   </div>
 </table>
</div>
      <br>
          <div>
             <div class="alert alert-success">
                <table width="100%" class="table table-bordered table-condensed">
                  <tr>
                      <th width="25%">PRODUCT <a class="btn btn-success btn-small"onClick="jQuery('#myModal_product').modal('show');" data-toggle="modal_product" style="margin-left:20px;"><strong> + </strong></a> </th>
                      <th >UOM</th>
                      
                      <th>QTY</th>
                      
                      <th >Action</th>
                  </tr>
                   <tr>
                      <td>
                      <select name="raw_id" id="raw_id" class="form-control chzn-select" onChange="getproductdetail();" >
                      <option value="" >--Choose Product--</option>
                      <?php
                      $slno=1;
                      //$where = array('product_type'=>'finished good');
                      $res = $obj->executequery("select * from raw_material");
                      foreach($res as $row_get)
                      {
                      ?>
                      <option value="<?php echo $row_get['raw_id']; ?>"><?php echo strtoupper($row_get['raw_name']); ?></option>
                      <?php
                      }
                      ?>
                      </select>
                      <script> document.getElementById('raw_id').value='<?php echo $raw_id; ?>'; </script>
                      </td>
                      <td><input class="input-mini form-control" type="text" name="unit_name" id="unit_name" value="" style="width:90%;" readonly >    			
                      </td>
                     
                      <td><input class="input-mini" type="text" name="qty" id="qty" value="" style="width:90%;" onkeyup="settotal()"></td>

                      
                      <td>
                      <input type="button" class="btn btn-success" onClick="addlist();" style="margin-left:20px;" value="Add Product" id="addlist_btn">
                      </td>
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
            
 <?php   $chkview = $obj->check_pageview("issue_entry.php",$loginid);              
              if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>  
            <div id="list" style="display:none;"  >
              <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                
                <th>Kitchen Name:</th>
                <th>From Date:</th>
                <th>To Date:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                  
                    <td>
                    <select name="department_id" id="ddepartment_id" class="chzn-select">
                        <option value="">--All--</option>
                        <option value="1">Kitchen 1</option>
                        <option value="2">Kitchen 2</option>
                    </select>
                <script>document.getElementById('department_id').value='<?php echo $department_id; ?>';</script>                   
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
                            <th class="head0 nosort">S.No.</th>
                            
							              <th class="head0">Issue_No.</th>
                            <th class="head0">Issue_Date</th>
                            <th class="head0">Kitchen_Name</th>
                            
                            <th class="head0" style="text-align:center;">Print A5</th>
                           <?php   $chkedit = $obj->check_editBtn("issue_entry.php",$loginid);              
                              if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th  class="head0" >Edit</th>  <?php } ?>
                             <?php  $chkdel = $obj->check_delBtn("issue_entry.php",$loginid);             
                              if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>    
                            <th  class="head0" >Delete</th>    <?php } ?>                             
                        </tr>
                    </thead>
                    <tbody id="record">
                         
                        <?php
                        $slno=1;
                        //$company_id=$_SESSION['company_id'];
                      // echo "select * from issue_entry $crit order by issueid desc";
                    $res = $obj->executequery("select * from issue_entry $crit  order by issueid desc");
                        foreach($res as $row_get)
									     { 
                       // echo "<pre>";
                        //print_r($row_get); 
      										$total=0;
      										$issueid = $row_get['issueid'];
      										$issueno = $row_get['issueno'];
                          $department_id = $row_get['department_id'];
                          if ($department_id == 1) 
                          {
                            $department_name = "Kitchen 1";
                          }
                          else
                          {
                            $department_name = "Kitchen 2";
                          }
                          
                          // $department_name = $obj->getvalfield("m_department","department_name","department_id='$department_id'");
                //           $company_id = $row_get['company_id'];
      										// $company_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
      										$issuedate =$obj->dateformatindia($row_get['issuedate']);
      										$qty = $obj->getvalfield("issue_entry_details","qty","issueid ='$issueid'");
      										
                          //$total = $obj->getTotalSaleentryBillAmt($row_get['saleid']);	
                   
									   ?> <tr>
                            <td><?php echo $slno++; ?></td>
                            
                            <td><?php echo $issueno; ?></td>
                            <td><?php echo $issuedate; ?></td>
                            <td><?php echo $department_name; ?></td>
                            
                            
                            <!-- <td style="text-align: right;"><?php echo number_format(round($total),2); ?></td> -->
                            <!-- <td><a class="btn btn-danger" href="pdf_csale_invoice.php?saleid=<?php echo  $row_get['saleid']; ?>" target="_blank" >Challan</a></td> -->
                            <td style="text-align: center;"><a class="btn btn-danger" href="pdf_issueentry.php?issueid=<?php echo $row_get['issueid']; ?>" target="_blank">InvoiceA5</a></td>
                            <?php   $chkedit = $obj->check_editBtn("issue_entry.php",$loginid);             
                          if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <td>
                            <a class='icon-edit' title="Edit" href='issue_entry.php?issueid=<?php echo  $row_get['issueid']; ?>' style='cursor:pointer'></a></td><?php } ?>
                            &nbsp;<?php $chkdel = $obj->check_delBtn("issue_entry.php",$loginid);  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?> <td>
                            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['issueid']; ?>);' style='cursor:pointer'></a>
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

<div class="modal fade" id="myModal" role="dialog" aria-hidden="true" style="display:none;" >
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Product</h4>
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
                <input class="form-control" name="munit_name" id="munit_name"  value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Unit" readonly >
                </td>
           </tr>
            <tr>
                  <th>Qty &nbsp;<span style="color:#F00;">*</span></th>
                  
            </tr>
            <tr>  
                <td> 
                <input class="form-control" name="mqty" id="mqty"  value="" autocomplete="off" autofocus="" type="text"  placeholder="Enter Quantity" onkeyup="settotalupdate();"> 
                </td>
                <td>                                           
               
                </td>
           </tr>
           
           
                        
      </table>
  </div>
        <div class="modal-footer clearfix">
            <input type="hidden" id="m_issueid_detail" value="0" >
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

              <td><input type="text" name="product_name" id="product_name" class="input-xxlarge"  style="width:90%;" placeholder="Enter Product Name" autocomplete="off" autofocus/></td>

            <td>

              <select name="category_id" id="category_id"  class="chzn-select" style="width:230px;" >
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
                 <script>document.getElementById('category_id').value = '<?php echo $category_id ; ?>';</script>
           </td>   
          
          </tr>
            <tr> 
              <th>Stock Date<span style="color:#F00;"> * </span></th>
              <th>Opening Stock<span style="color:#F00;"> * </span></th> 
            
            </tr>
            <tr>
               <td><input type="text" name="stock_date" id="stock_date" class="input-xlarge"  value="<?php echo $stock_date; ?>" style="width:90%;" autofocus autocomplete="off" placeholder="dd-mm-yyyy"/>
               </td>

                <td> <input type="text" name="opening_stock" id="opening_stock" class="input-xlarge"  value="<?php echo $opening_stock;?>" autofocus autocomplete="off"  placeholder="Enter Opening Stock" style="width:90%;"/></td>
            
            </tr>
            <tr> 
            <th>SGST</th>
            <th>IGST</th>
            </tr>
            <tr>
                <td> <input type="text" name="sgst" id="sgst" class="input-xlarge"  value="<?php echo $sgst;?>" style="width:90%;" autofocus autocomplete="off"  placeholder="Enter SGST"/></td>

                <td> <input type="text" name="igst" id="igst" class="input-xlarge"  value="<?php echo $igst;?>" style="width:90%;" autofocus autocomplete="off"  placeholder="Enter IGST"/></td>
            </tr>
            <tr> 
            <th>CGST</th> 
            <th>Product Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
              <td> <input type="text" name="cgst" id="cgst" class="input-xlarge"  value="<?php echo $cgst;?>" style="width:90%;" autofocus autocomplete="off"  placeholder="Enter CGST"/></td>

            <td>
                  <select name="product_type" id="product_type"  class="chzn-select" style="width:230px;" >
                    <option value="" >---Select---</option>
                    <option value="finished good" >Finished Good </option>
                    <option value="raw material" >Raw Material</option>

                  </select>
                  <script>document.getElementById('product_type').value = '<?php echo $product_type ; ?>';</script>
                 </td>        
           
            </tr>
            <tr>
            <th>UOM<span style="color:#F00;">*</span></th>
            <th>HSN No</th>
            </tr>
            <tr>

              <td>
                 <select name="unit_id" id="unit_id"  class="chzn-select" style="width:230px;" >
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
                   <script>document.getElementById('unit_id').value = '<?php echo $unit_id ; ?>';</script>
           </td> 

               <td><input type="text" name="hsnno" id="hsnno" class="input-xlarge"  value="<?php echo $hsnno;?>" style="width:90%;" autofocus autocomplete="off"  placeholder="HSN No."/>
              </td>
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
            <th>Reorder Limit</th>
            <th>Tax Type<span style="color:#F00;">*</span></th>
            </tr>
            <tr>
            <td><input type="text" name="reorder_limit" id="reorder_limit" class="input-xlarge"  value="<?php echo $reorder_limit;?>" autofocus autocomplete="off"  placeholder="Enter Reorder Limit" style="width:90%;"/>
                 </td>
               <td>
                     <select name="taxtype" id="taxtype" class="chzn-select" style="width:230px;"><?php echo $taxtype; ?>
                     <option value="">-Select--</option>
                     <option value="inclusive">Inclusive</option>
                     <option value="exclusive">Exclusive</option>
                   </select>
                   <script type="text/javascript">
                     document.getElementById('taxtype').value = '<?php echo $taxtype; ?>';
                   </script>
                 </td>
            </tr> 
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_product_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div> 


 <!-- department -->
 <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_department">
            <div class="modal-header alert-info">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="myModalLabel">ADD New Department</h3>
            </div>
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
            <table class="table table-condensed table-bordered">
            <tr> 
            <th>Department Name<span style="color:#F00;"> * </span> </th>
          
            </tr>
            <tr>
                <td><input type="text" name="department_name" id="department_name" class="input-xxlarge"  style="width:80%;" placeholder="Enter Department Name" autocomplete="off" autofocus/></td>
                
           </tr>
            
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_department_data();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
            </div>
    </div> 
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
		  url: 'ajax/delete_issue.php',
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
	var rate=parseFloat(jQuery('#rate').val());	
	
	if(!isNaN(qty) && !isNaN(rate))
	{
		total =	qty * rate;
	}	
	
	jQuery('#total').val(total.toFixed(2));
}	


function settotalupdate()
{
	var qty=parseFloat(jQuery('#mqty').val());	
	var rate=parseFloat(jQuery('#mrate').val());
	
	if(!isNaN(qty) && !isNaN(rate))
	{
    totall=	qty * rate;
    total = totall;
    
	}
  
	jQuery('#mtotal').val(total.toFixed(2));
}	

</script>

<script>
function save_product_data()
{
  var product_name = document.getElementById('product_name').value;
  var category_id = document.getElementById('category_id').value;
  var stock_date = document.getElementById('stock_date').value;
  var cgst = document.getElementById('cgst').value;
  var sgst = document.getElementById('sgst').value;
  var igst = document.getElementById('igst').value;
  var unit_id = document.getElementById('unit_id').value;
  var product_type = document.getElementById('product_type').value;
  var opening_stock = document.getElementById('opening_stock').value;
  var hsnno = document.getElementById('hsnno').value;
  var product_rate = document.getElementById('product_rate').value;
  var taxtype = document.getElementById('taxtype').value;
  var reorder_limit = document.getElementById('reorder_limit').value;
  var purches_rate = document.getElementById('purches_rate').value;
  var sale_rate = document.getElementById('sale_rate').value;
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
			  url: 'save_issueshortcutproduct.php',
			  data: 'product_name='+product_name+'&category_id='+category_id+'&stock_date='+stock_date+'&cgst='+cgst+'&sgst='+sgst+'&igst='+igst+'&unit_id='+unit_id+'&product_type='+product_type+'&opening_stock='+opening_stock+'&hsnno='+hsnno+'&purches_rate='+purches_rate+'&taxtype='+taxtype+'&reorder_limit='+reorder_limit+'&sale_rate='+sale_rate,
			  dataType: 'html',
			  success: function(data){				  
		    //alert(data);
			 		
					jQuery('#showallbtn').click();
					jQuery("#product_name").val('');
          jQuery("#category_id").val('');
          jQuery("#stock_date").val('');
          jQuery("#cgst").val('');
          jQuery("#sgst").val('');
          jQuery("#igst").val('');
					jQuery("#unit_id").val('');
					jQuery("#product_type").val('');
          jQuery("#opening_stock").val('');
					jQuery("#hsnno").val('');
          jQuery("#purches_rate").val('');
          jQuery("#sale_rate").val('');
          jQuery("#taxtype").val('');
          jQuery("#reorder_limit").val('');
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
   
   function save_department_data()
   {
    var department_name = document.getElementById('department_name').value;
    if(department_name == "")
    {
      alert('Please Fill Product Name');
      return false;
    }
  
    else
    {
      
      jQuery.ajax({
        type: 'POST',
        url: 'save_department.php',
        data: 'department_name='+department_name,
        dataType: 'html',
        success: function(data){          
        //alert(data);
          
          jQuery('#showallbtn').click();
          jQuery("#department_name").val('');
          jQuery("#myModal_department").modal('hide');
          jQuery('#department_name').html(data);
          // jQuery("#department_id").val('').trigger("liszt:updated");
          // jQuery('#department_id').val('').trigger('chzn-single:updated');
          // jQuery('#department_id').trigger('chzn-single:activate'); // for autofocus
          jQuery("#department_name").trigger("liszt:updated");
          //jQuery('#customer_id').trigger('chzn-single:updated');
          jQuery('#department_name').trigger('chzn-single:activate');
         
        }
        });//ajax close
    } 
}

	function getrecord(keyvalue){
	 // var emp_id=jQuery("#emp_id").val();
	
			  jQuery.ajax({
			  type: 'POST',
			  url: 'show_issuerecord.php',
			   data: "issueid="+keyvalue,
			  dataType: 'html',
			  success: function(data){				  
				//alert(data);
					jQuery('#showrecord').html(data);
					setTotalrate();
					
				}
				
			  });//ajax close
							  
	}
 

function getproductdetail(raw_id)
{ 
 
	var raw_id =jQuery("#raw_id").val();

		jQuery.ajax({
					type: 'POST',
					url: 'ajax_getissue_productdetail.php',
					data: 'raw_id='+raw_id,
					dataType: 'html',
					success: function(data){				  
					//alert(data);
					
					arr=data.split('|');	
					unit_name=arr[0];
					rate=arr[1].trim();
					
					jQuery('#unit_name').val(unit_name);
					jQuery('#rate').val(rate);
					jQuery('#unit_name').focus();

					}
			  });//ajax close
	
    //jQuery("#product_id").val('').trigger("liszt:updated");
    //jQuery(".chzn-single").focus();
 
}


function addlist()
{
  jQuery('#addlist_btn').prop('disabled', true);
	var  raw_id= document.getElementById('raw_id').value;
	var  unit_name= document.getElementById('unit_name').value;
	var  qty= document.getElementById('qty').value;
	
	//alert('hi');
  //alert(total);
	
	var issueid='<?php echo $keyvalue; ?>';
	var issueid_detail=0;
 //alert(saleid);
	if(raw_id =='')
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
		  url: 'save_issueproduct.php',
		  data: 'raw_id='+raw_id+'&unit_name='+unit_name+'&qty='+qty+'&issueid='+issueid+'&issueid_detail='+issueid_detail,
		  dataType: 'html',
		  success: function(data){				  
			//alert(data);		
		
			jQuery('#raw_id').val('');		
		
			jQuery('#qty').val('');
			jQuery('#unit_name').val('');
      //jQuery('#unit_id').val('');
			
			getrecord('<?php echo $keyvalue ?>');

			jQuery("#raw_id").val('').trigger("liszt:updated");
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
  //alert('jhgsdjkhg');
 	var  raw_id= document.getElementById('mproduct_id').value;
	var  unit_name= document.getElementById('munit_name').value;
	var  qty= document.getElementById('mqty').value;

	var issueid_detail= document.getElementById('m_issueid_detail').value;
	var keyvalue = '<?php echo $keyvalue; ?>';

	
	if(qty =='')
	{
		alert('Quantity cant be blank');	
		return false;
	}

	else
	{
		jQuery.ajax({
		  type: 'POST',
		  url: 'save_issueproduct.php',
		  data: 'raw_id='+raw_id+'&unit_name='+unit_name+'&qty='+qty+'&issueid_detail='+issueid_detail+'&issueid='+keyvalue,
		  dataType: 'html',
		  success: function(data){				  
		//alert(data);
			
			
			jQuery('#mproduct_id').val('');
			jQuery('#mrate').val('');
			jQuery('#munit_name').val('');
			jQuery('#mqty').val('');
      jQuery('#mtotal').val('');
			jQuery('#issueid_detail').val('');
			jQuery("#myModal").modal('hide');
			getrecord(<?php echo $keyvalue ?>);
			
			}
		  });//ajax close
	}
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
	
	
	
 function deleterecord(issueid_detail)
  {
	 	tblname = 'issue_entry_details';
		tblpkey = 'issueid_detail';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+issueid_detail+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				 getrecord('<?php echo $keyvalue; ?>');
				 setTotalrate();
				}
				
			  });//ajax close
		}//confirm close
	
  }
   

function updaterecord(product_id,product_name,unit_name,qty,rate_amt,total,issueid_detail)
{
			jQuery("#myModal").modal('show');
			jQuery("#saveitem").attr('value', 'Update');
			jQuery("#mproduct_name").val(product_name);
			jQuery("#mproduct_id").val(product_id);
			jQuery("#munit_name").val(unit_name);
			jQuery("#mqty").val(qty);
			jQuery("#mrate").val(rate_amt);
			jQuery("#mtotal").val(total);		
			jQuery("#m_issueid_detail").val(issueid_detail);
			settotalupdate();
			jQuery("#qty").focus();
		
}
jQuery('#issuedate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#stock_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#issuedate').focus();


   // jQuery(document).ready(function(){
   
   // jQuery('#menues').click();
  
   // });

//referesh hone pe page change ni hoga
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
