<?php include("../adminsession.php");
$pagename = "sale_return.php";
$module = "Add Sale Return Entry";
$submodule = "Sale Return Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "purchaseentry";
$tblpkey = "purchaseid";


//$ret_date = "";
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$comp_name = "";
$bill_date = "";
$qty = "";
$ret_qty = "";
$unit_name = "";
$blns_qty = "";
//$mnproduct_id = "";

if(isset($_GET['purchaseid']))
$purchaseid = $_GET['purchaseid'];
else
$purchaseid = 0;

$ret_date=date('d-m-Y'); 

$bill_date = "";
// $mnproduct_id = "";
// $product_name = "";
if(isset($_GET['purchaseid']))
{
	$purchaseid = $_GET['purchaseid'];
  //$company_id = $_GET['company_id'];
  //$bill_date = $_GET['bill_date'];
	$bill_date = $obj->getvalfield("purchaseentry","bill_date","purchaseid='$purchaseid'");
  $bill_date = $obj->dateformatindia($bill_date);
	//$compid = $obj->getvalfield("purchaseentry","bill_date","purchaseid='$purchaseid'");
	$comp_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
}
else
{
	$purchaseid=0;

}



if(isset($_POST['save']))
{
	 $ret_no=$obj->getret("pur_return","pret_id","ret_no!='' group by ret_no");
	mysql_query("update $tblname set isconfirm=1,ret_no='$ret_no' where purchaseid='$purchaseid' and isconfirm='0'");
	
	 echo "<script>location='$pagename?action=1'</script>";
	
}


// if(isset($_GET[$tblpkey]))
// {
// 	 $btn_name = "Update";
// 	 $where = array($tblpkey=>$keyvalue);
//    $sqledit = $obj->select_record($tblname,$where);
// 	 $keyvalue 	 = $sqledit['purchaseid'];
// 	 $billno     =  $sqledit['billno'];
// 	 $bill_date   =  $sqledit['bill_date'];
// 	 $bill_type   =  $sqledit['bill_type'];
//    //$ret_date   =  $sqledit['ret_date'];
// 	 //$billtype    =  $sqledit['billtype'];
// 	 //$disc  		 =  $sqledit['disc'];
// 	 $company_id  =  $sqledit['company_id'];
  
// }


?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>

<script type="text/javascript">
  function getsuppitemlist(purchaseid)
{
  //alert('hiie');
  if(!isNaN(purchaseid) && purchaseid !='')
  {
    window.location.href='sales_return.php?purchaseid='+purchaseid; 
  }
}
</script>
<script>

   function addqty()
  {
    var qty = parseInt(document.getElementById('qty').value);
  
  var addqty1;
  //alert(qty);
  if(!isNaN(qty))
    {
       addqty1 = parseInt(qty)+1;
    }
    document.getElementById('qty').value=addqty1;
    
  }
  
  
  function minusqty()
  {
    
    var qty = parseInt(document.getElementById('qty').value); 
  var addqty1;
  alert(qty);
  
  if(!isNaN(qty) && qty > 1)
  {
     addqty1 = parseInt(qty)-1;
     document.getElementById('qty').value=addqty1;
     settotal();
         
  }else
  alert("Quntity can not be less than 1");
  
  }
  
  
  
  
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
   jQuery('#ret_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});

// function checkqty(qty)
// {
//   var bal_qty = document.getElementById('bal_qty').value;
//    bal_qty = parseInt(bal_qty);
//     qty = parseInt(qty);
  
//   if(qty==0)
//   {
//     alert('Quantity Cant be Zero'); 
//     jQuery('#qty').val('');
//     return false;
//   }
  
//   if(qty !=0 && !isNaN(qty))
//   {
//     if(qty > bal_qty)
//     {
//       alert('Quantity Cant be Greater Than Balance Quantity');
//       jQuery('#qty').val('');
//       return false;
//     }
//   }
  
// }

function addlist()
  {
    var productid= document.getElementById('productid').value;
    var prodname= document.getElementById('prodname').value;
    var unit_name= document.getElementById('unit_name').value;
    var unitid= document.getElementById('unitid').value;
    var qty= document.getElementById('qty').value;
    var batchno= document.getElementById('batchno').value;
    var expirydate= document.getElementById('expirydate').value;
    var ret_date= document.getElementById('ret_date').value;
    var purchaseid='<?php echo $purchaseid; ?>';
    //alert(ret_date);
    if(prodname=='')
    {
      alert('Product Name Can not be blank');
      return false;
    }
    
    if(qty =='')
    {
      alert('Quantity can not be blank'); 
      return false;
      
    }
    else
    {
      
      jQuery.ajax({
        type: 'POST',
        url: 'save_salereturn.php',
        data: 'productid='+productid+'&unitid='+unitid+'&qty='+qty+'&ret_date='+ret_date+'&purchaseid='+purchaseid+'&batchno='+batchno+'&expirydate='+expirydate,
        dataType: 'html',
        success: function(data){          
          //alert(data);
        getrecord(purchaseid);
        getretproduct(purchaseid);
        
        jQuery('#productid').val('');
        jQuery('#prodname').val('');
        jQuery('#qty').val('');
        jQuery('#unit_name').val('');
        jQuery('#batchno').val('');
        jQuery('#expirydate').val('');
        jQuery('#unitid').val('');
        //jQuery("#myModal").modal('hide');
        
        
        }
        
        });//ajax close
        
    }
    
  }
  
function getrecord(purchaseid){
    //alert("suppartyid="+suppartyid+'&pret_id='+keyvalue);
    //alert('hiie');
    if(purchaseid !='0' && !isNaN(purchaseid))
    {
  
        jQuery.ajax({
        type: 'POST',
        url: 'show_saleretrecord.php',
        data: "purchaseid="+purchaseid,
        dataType: 'html',
        success: function(data){          
        //alert(data);
          jQuery('#showrecord').html(data);
        
        }
        
        });//ajax close
    }
                
    
                
  } 
  
  
  //getrecord(<?php echo $purchaseid; ?>);
  
  
  //  function deleterecord(pret_id)
  // {
  //   tblname = 'pur_return';
  //   tblpkey = 'pret_id';
  //   pagename = '<?php echo $pagename; ?>';
  //   submodule = '<?php echo $submodule; ?>';
  //   module = '<?php echo $module; ?>';
    
    
  // if(confirm("Are you sure! You want to delete this record."))
  //   {
  //     jQuery.ajax({
  //       type: 'POST',
  //       url: 'ajax/delete_master.php',
  //       data: 'id='+pret_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
  //       dataType: 'html',
  //       success: function(data){
  //        // alert(data);
  //        getrecord('<?php echo $purchaseid; ?>');
  //        getretproduct('<?php echo $purchaseid; ?>');
         
  //       }
        
  //       });//ajax close
  //   }//confirm close
  
  // }
  jQuery(document).ready(function(){
   jQuery('#menues').click();
  
   });
   function funDel(purchaseid)
  {
    tblname = 'purchaseentry';
    tblpkey = 'purchaseid';
    pagename = '<?php echo $pagename; ?>';
    submodule = '<?php echo $submodule; ?>';
    module = '<?php echo $module; ?>';
    
    
  if(confirm("Are you sure! You want to delete this record."))
    {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax/delete_master.php',
        data: 'id='+purchaseid+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
        dataType: 'html',
        success: function(data){
         // alert(data);
         location='<?php echo $pagename;?>'+'?action=3';
         getrecord('<?php echo $purchaseid; ?>');
         getretproduct('<?php echo $purchaseid; ?>');
         
        }
        
        });//ajax close
    }//confirm close
  
  }
  
  
<?php
if($_GET['action']==3)
{
?>
  
  add();
  
<?php } ?>
  
  
  
</script>
<script type="text/javascript">
  function getretproduct(purchaseid)
{
//alert('hiiie');
  var tblname='purchasentry_detail';
  var tblkey='purchaseid';

  if(!isNaN(purchaseid) && purchaseid !=0)
  {
    
     jQuery.ajax({
        type: 'POST',
        url: 'ajax_getretproductlist_sale.php',
        data: "id="+purchaseid+'&tblname='+tblname+'&tblkey='+tblkey,
        dataType: 'html',
        success: function(data){          
      //  alert(data);
          document.getElementById('mnproduct_id').innerHTML=data;
        
        }
        
        });//ajax close
  
  }
  
}
</script>
<script type="text/javascript">
  // function addproduct(purchaseid,product_id,product_name,unit_name) 
  // // product_id,product_name,unit_name
  // {  
  //   //alert('hii'); 
  //   //alert
  //   //var purchaseid= document.getElementById('purchaseid').value;  
  //   // if(bal_qty==0)
  //   // {
  //   //   alert('You cant return this product');  
  //   //   return false;
  //   // }
    
  //   // if(purchaseid=='')
  //   // {
  //   //   alert('Please Select Bill No');
  //   //   return false;
  //   // }
    
  //   jQuery("#myModal1").modal('show');     
  //   jQuery("#mproduct_name").val(product_name);
  //   jQuery("#mproduct_id").val(product_id);
  //   jQuery("#munit_name").val(unit_name);
    
  //   // jQuery("#pur_qty").val(pur_qty);
  //   // // jQuery("#batchno").val(batchno);
  //   // // jQuery("#expirydate").val(expirydate);
  //   //jQuery("#ret_qty").val(ret_qty);
  //   // // jQuery("#bal_qty").val(bal_qty);
  //   //jQuery("#qty").val('1');
  //   // jQuery("#qty").focus();
    
  // }

  function getproductdetail(purchaseid)
{ 
    //alert('hiie');
    var purchaseid=jQuery("#purchaseid").val();

  if(!isNaN(purchaseid))
  {
    jQuery.ajax({
          type: 'POST',
          url: 'get_product_detail.php',
          data: 'purchaseid='+purchaseid,
          dataType: 'html',
          success: function(data){          
          alert(data);
          jQuery('#mnproduct_id').val(product_id); 
          jQuery('#product_name').val(product_name);  
         // arr=data.split('|');
          //product_id=arr[0].trim();    
          // product_name=arr[0].trim();
          //qty=arr[1].trim();
          // cgst=arr[3].trim();
          // sgst=arr[4].trim();
          // igst=arr[5].trim();
          // inc_or_exc=arr[6].trim();

          //jQuery('#product_id').val(unit_id);              
         // jQuery('#mnproduct_id').val(product_name);
          //jQuery('#qty').val(qty);
          location = 'sales_return.php?purchaseid='+purchaseid;
          }
        
        });//ajax close
  }
}

</script>
</head>

<body onLoad="getrecord('<?php echo $keyvalue; ?>')">

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
                <form action="" method="post" >
                
                <div class="row-fluid">
                	<table width="100%" class="table table-condensed table-bordered" >
							  
							  <tr>
                              <td><strong>Bill No : <span style="color:#F00;">*</span> </strong></td>
                              <td><strong>Return Date: <span style="color:#F00;">*</span> </strong></td>
							                <th>Purchase Date:</th> 
                              <th>Purchase  by:</th> 
                              
						      </tr>
                              
							  <tr>
							     <td>
                                    <select name="purchaseid" id="purchaseid" class="chzn-select" autofocus onChange="getproductdetail(this.value);">
                                    <option value="">-select-</option>
                                    <?php
                                    $row = $obj->executequery("select * from purchaseentry where type = 'saleentry'");
                                    foreach ($row as $row_get) 
                                    {
                                      //$bill_date = $row_get['bill_date'];
                                      $company_id = $row_get['company_id'];
                                      $company_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
                                      $customer_id = $row_get['customer_id'];
                                      $customer_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");
                                        ?>
                                        <option value="<?php echo $row_get['purchaseid']; ?>"><?php echo $row_get['billno'].' / '.$customer_name; ?></option>
                                    <?php } ?>
                                    
                                    </select>
									                  <script>document.getElementById('purchaseid').value = '<?php echo $purchaseid; ?>';</script>
                                      </td>
                                   
                                  <td> <input type="text" name="ret_date" id="ret_date" class="form-control text-red"  value="<?php echo $ret_date ;?>"  style="font-weight:bold;" placeholder="dd-mm-yyyy"  tabindex="4" autocomplete="off"  >   
                                  </td>
                                  <td><?php echo $bill_date; ?></td>
                                  <td style="width:40%"><?php echo $comp_name; ?></td>
                                  
							   </tr>
                    </table>
                           
                    </div>
                    <br>
                    <div class="row-fluid">
                  <table width="80%" class="table table-condensed table-bordered" >
                
                <tr>
                              
                              <td><strong>Product: <span style="color:#F00;">*</span> </strong></td>
                              <th>Unit:</th> 
                              <th>Qty:</th> 
                              <th>Return Qty:</th>
                              
                              
                  </tr>
                              
                <tr>
                                   <td>
                                    <select name="mnproduct_id" id="mnproduct_id" class="chzn-select" autofocus tabindex="4">
                                    <option value="">-select-</option>
                                    <?php 
                                     $sql = $obj->executequery("select * from purchasentry_detail where purchaseid='$purchaseid'");
                                       foreach ($sql as $row) {
                                        $product_id = $row['product_id'];
                                        $product_name=$obj->getvalfield("m_product","product_name","product_id='$product_id'");
                                      ?>
                                    <option value="<?php echo $product_id; ?>"><?php echo $product_name; ?></option>
                                    <?php } ?>
                                    </select>

                                    <script>document.getElementById('mnproduct_id').value = '<?php echo $mnproduct_id; ?>';</script>
                                      </td>
                                   
                                  <td> <input type="text" name="unit_name" id="unit_name" class="form-control text-red"  value="<?php echo $unit_name ;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"  >   
                                  </td>
                                  <td> <input type="text" name="qty" id="qty" class="form-control text-red"  value="<?php echo $qty ;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"></td>
                                  <td> <input type="text" name="ret_qty" id="ret_qty" class="form-control text-red"  value="<?php echo $ret_qty;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"></td>

                                  <td> <input type="submit" name="submit" id="submit" class="form-control text-red btn-primary" value="Add"></td>
                                  
                                  
                 </tr>
                    </table>
                           
                    </div>
                      <br>
                <div class="row-fluid">
                	<div class="span6">
                    	<h4 class="widgettitle nomargin"> <span style="color:#00F;" >Product Details : <span id="inentryno" > <?php //echo $inentry_no; ?> </span>
                        </span></h4>
                    
                        <div class="widgetcontent bordered" id="showrecord">
                        	
                        </div><!--widgetcontent-->
                   
                        
                      
                    </div>
                    
                  
                    
                    <!--span8-->
                    <div class="span6">

                    		 <div class="alert alert-success" >
                             <input type="text" id="myInput" onKeyUp="myFunction()" placeholder="Search for names or serial number.." title="Type in a name">	
                             <code> &nbsp;&nbsp;(Click on below record for return)</code>
                             </div>
                 			 <div class="widgetcontent  padding" id="productnamelist" style="overflow:scroll; height:400px;">
                             
                        	 </div>
                    </div><!--span4-->
                </div>
                
                </form>
                
                
                <!--row-fluid-->
                
                
            </div>
           
            <div id="list" style="display:none">
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
                        	
                          	<th width="7%" class="head0 nosort">S.No.</th>
                            <th width="16%" class="head0" >Bill No</th>
                             <th width="11%" class="head0">Return Date</th>
                             <th width="16%" class="head0" >Customer Name</th>  
                                <th width="16%" class="head0" >Return Qty</th>
                                 <th width="16%" class="head0" >Print</th>                                                     
                             <th width="14%" class="head0" >Action </th>                          
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                                <?php
									$slno=1;
								
									$sql_get = executequery("Select * from purchaseentry where type = 'saleentry'");
                  foreach ($sql_get as $row_get) {
									
                            $purchaseidl =$row_get['purchaseid'];
                            $billno = $obj->getvalfield("purchaseentry","billno","purchaseid='$purchaseidl'");
                            $suppartyid = $obj->getvalfield("purchaseentry","suppartyid","purchaseid='$purchaseidl'");
                            $customer_id = $row_get['customer_id'];
                            $customer_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");
                            $supparty_name = $obj->getvalfield("m_supplier_party","supparty_name","suppartyid='$suppartyid'");
                            // $ret_qty = $obj->getvalfield("pur_return","sum(ret_qty)","purchaseid='$purchaseidl'");

                            ?> <tr>
                            <td><?php echo $slno++; ?></td> 
                            <td><?php echo $billno; ?></td>
                            <td><?php echo $obj->dateformatindia($row_get['ret_date']); ?></td>
                            <td><?php echo $customer_name; ?></td> 
                           <!--  <td><?php echo $ret_qty; ?></td>                                    -->          
                            <td>												
                            <a class="btn btn-danger" href="pdf_purchase_returnbill.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Print A5 </a></td>
                            <td>                                                  
                            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['purchaseid']; ?>);' style='cursor:pointer'></a>                                        </td>
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



      
        

</body>

</html>
