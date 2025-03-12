<?php include("../adminsession.php");
$pagename = "purchasereturn.php";
$module = "Add Purchese Return Entry";
$submodule = "Purchese Return Entry";
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
$bal_qty = "";
//$mnproduct_id = "";

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

$crit = " where 1 = 1 and bill_date between '$from_date' and '$to_date'"; 



if(isset($_GET['supplier_id']))
{
  
  $dsupplier_id = $_GET['supplier_id'];
  if(!empty($dsupplier_id))
    $crit .= " and supplier_id = '$dsupplier_id'";
}

if(isset($_GET['purchaseid']))
$purchaseid = $_GET['purchaseid'];
else
$purchaseid = 0;

$ret_date=date('d-m-Y'); 

$bill_date = "";
$count = "";
// $mnproduct_id = "";
// $product_name = "";
if(isset($_GET['purchaseid']))
{
  $purchaseid = $_GET['purchaseid'];
  $bill_date = $obj->getvalfield("purchaseentry","bill_date","purchaseid='$purchaseid'");
  $bill_date = $obj->dateformatindia($bill_date);
  $comp_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
   
}
else
{
  $purchaseid=0;

}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
  <script type="text/javascript">
    function getproductdetail(purchaseid)
    {
      location = 'purchasereturn.php?purchaseid='+purchaseid;
    }


function get_qty_unitdetail(purdetail_id)
{ 
  //alert(purdetail_id);
  if(!isNaN(purdetail_id))
  {
    jQuery.ajax({
          type: 'POST',
          url: 'get_qty_unit.php',
          data: 'purdetail_id='+purdetail_id,
          dataType: 'html',
          success: function(data){          
          //alert(data);
          //var obj = JSON.stringify(data); 
          obj = JSON.parse(data);
          
          jQuery('#unit_name').val(obj.unit_name);
          jQuery('#qty').val(obj.qty);
          jQuery('#bal_qty').val(obj.bal_qty);
          
          }
        
        });//ajax close
  }

  if(purdetail_id == 0)
  {
     //alert('hi');
     jQuery('#unit_name').val('');
     jQuery('#qty').val('');
     jQuery('#bal_qty').val('');
  }
}

function getrecord(purchaseid){
   // var emp_id=jQuery("#emp_id").val();
  
        jQuery.ajax({
        type: 'POST',
        url: 'show_purcheseretrecord.php',
         data: "purchaseid="+purchaseid,
        dataType: 'html',
        success: function(data){          
        //alert(data);
          jQuery('#showrecord').html(data);
          
          
        }
        
        });//ajax close
                
  }

  jQuery(document).ready(function(){
   
   jQuery('#menues').click();
  
   });

function settotal()
{

  var qty=parseFloat(jQuery('#qty').val());
  var ret_qty=parseFloat(jQuery('#ret_qty').val()); 
  
  
  if(!isNaN(qty) && !isNaN(ret_qty))
  {
    balance_qty =  qty - ret_qty;
  } 

  jQuery('#bal_qty').val(balance_qty.toFixed(2));
  
} 

function addlist()
{  
  //alert('hiie');
  var ret_qty = document.getElementById('ret_qty').value;
  var purdetail_id = document.getElementById('purdetail_id').value;
  var ret_date = document.getElementById('ret_date').value;
    //alert(ratefrmplant);
  if(purdetail_id =='')
  {
    alert('Product cant be blank'); 
    return false;
  }
  if(ret_qty == '')
  {
    alert('Quantity Cant be blank');
    return false;
  } 
  else
  {

      jQuery.ajax({
      type: 'POST',
      url: 'save_sale_return_product.php',
      data: 'purdetail_id='+purdetail_id+'&ret_qty='+ret_qty+'&ret_date='+ret_date,
      dataType: 'html',
      success: function(data){          
      //alert(data);    
    
      jQuery('#purdetail_id').val('');    
      jQuery('#ret_qty').val('');
      jQuery('#qty').val('');
      jQuery('#unit_name').val('');
      getrecord('<?php echo $purchaseid ?>');
      
      jQuery("#purdetail_id").val('').trigger("liszt:updated");
       document.getElementById('purdetail_id').focus();
      // jQuery(".chzn-single").focus();
      }
      
      });//ajax close
  }
}


function deleterecord(purdetail_id)
{
    if(confirm("Are you sure! You want to delete this record."))
      {
          jQuery.ajax({
          type: 'POST',
          url: 'delete_qty.php',
          data: 'purdetail_id='+purdetail_id,
          dataType: 'html',
          success: function(data){
           //alert(data);
           getrecord('<?php echo $purchaseid; ?>');
           
          }
          
          });//ajax close
      }//confirm close
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
</head>

<body onload="getrecord('<?php echo $purchaseid; ?>');">

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
                                    $row = $obj->executequery("select * from purchaseentry where type = 'purchaseentry'");
                                    foreach ($row as $row_get) 
                                    {
                                      //$bill_date = $row_get['bill_date'];
                                      $company_id = $row_get['company_id'];
                                      $company_name = $obj->getvalfield("company_setting","company_name","company_id='$company_id'");
                                      $supplier_id = $row_get['supplier_id'];
                                      $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
                                        ?>
                                        <option value="<?php echo $row_get['purchaseid']; ?>"><?php echo $row_get['billno'].' / '.$supplier_name; ?></option>
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
                              
                    <th><strong>Product: <span style="color:#F00;">*</span> </strong></th>
                    <th>Unit:</th> 
                    <th>Qty:</th> 
                    <th>Return Qty:</th>
                    <th></th>

                </tr>
                              
                         <tr>
                                   <td>

                                    <select name="purdetail_id" id="purdetail_id" class="chzn-select" autofocus tabindex="4" onChange="get_qty_unitdetail(this.value);">
                                    <option value="0">-select-</option>
                                    <?php 
                                     $sql = $obj->executequery("select * from purchasentry_detail where purchaseid='$purchaseid'");
                                       foreach ($sql as $row) {
                                        $purdetail_id = $row['purdetail_id'];
                                        $product_id = $row['product_id'];
                                        $product_name = $obj->getvalfield("m_product","product_name","product_id='$product_id'");
                                      ?>
                                    <option value="<?php echo $purdetail_id; ?>"><?php echo $product_name; ?></option>
                                    <?php } ?>
                                    </select>
                                    </td>
                                   
                                  <td> <input type="text" name="unit_name" id="unit_name" class="form-control text-red"  value="<?php echo $unit_name ;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"  >   
                                  </td>
                                 
                                 <td> <input type="text" name="qty" id="qty" class="form-control text-red"  value="<?php echo $qty ;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"></td>
                               
                                  <td> <input type="text" name="ret_qty" id="ret_qty" class="form-control text-red"  value="<?php echo $ret_qty;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off" onkeyup="settotal();"></td>
                                  

                                  <td>
                                    <input type="hidden" name="ret_date" id="ret_date" value="<?php echo $ret_date; ?>">
                                  <input type="hidden" name="purchaseid" id="purchaseid" value="<?php echo $purchaseid; ?>"> <input type="button" class="btn btn-success" onClick="addlist();" style="margin-left:20px;" value="Add"></td>
                                  
                                  
                 </tr>
                    </table>
                           
                    </div>
                      <br>
                <div class="row-fluid">
                  <div class="span12">
                      <h4 class="widgettitle nomargin"> <span style="color:#00F;" >Product Details : <span id="inentryno" > <?php //echo $inentry_no; ?> </span>
                        </span></h4>
                    
                        <div class="widgetcontent bordered" id="showrecord">
                          
                        </div><!--widgetcontent-->
                   
                        
                      
                    </div>
                    
                  
                    
                    <!--span8-->
                    
                </div>
                
                </form>
                
                
                <!--row-fluid-->
                
                
            </div>
            
           <?php   $chkview = $obj->check_pageview("purchasereturn.php",$loginid);              
              if($chkview == 1 || $loginid == 1){  ?>
            <div id="list" style="display:none">
              <form method="get" action="">
            <table class="table table-bordered table-condensed">
              <tr>
                
                <th>Supplier Name:</th>
                <th>From Date:</th>
                <th>To Date:</th>
                <th>&nbsp</th>
              </tr>
              <tr>
                  
                    <td>
                    <select name="supplier_id" id="dsupplier_id" class="chzn-select">
                        <option value="">--All--</option>
                        <?php
                        $slno=1;
                        $company_id = $_SESSION['company_id'];
                    $res = $obj->executequery("select * from master_supplier");

                        foreach($res as $row_get)
                        
                        {               
                        ?>
                        <option value="<?php echo $row_get['supplier_id'];  ?>"> <?php echo $row_get['supplier_name']; ?></option>
                        <?php } ?>
                    </select>
                <script>document.getElementById('supplier_id').value='<?php echo $supplier_id; ?>';</script>                   
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
                          
                            <th width="7%" class="head0 nosort">S.No.</th>
                            <th width="16%" class="head0" >Bill No</th>
                            <th width="11%" class="head0">Return Date</th>
                            <th width="16%" class="head0" >Supplier Name</th>  
                            <th width="16%" class="head0" >Return Qty</th>
                            <th width="16%" class="head0" >Print</th>          
                            <!-- <th width="14%" class="head0" >Action </th> -->                          
                        </tr>
                    </thead>
                    <tbody id="record">
                           </span>
                                <?php
                  $slno=1;
                
                  $sql_get = $obj->executequery("Select * from purchaseentry $crit and type = 'purchaseentry' order by purchaseid desc");
                  foreach ($sql_get as $row_get) {
                  
                            $purchaseidl =$row_get['purchaseid'];
                            $billno = $obj->getvalfield("purchaseentry","billno","purchaseid='$purchaseidl'");
                            $supplier_id = $obj->getvalfield("purchaseentry","supplier_id","purchaseid='$purchaseidl'");
                            $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");

                           $ret_date = $obj->getvalfield("purchasentry_detail","ret_date","purchaseid='$purchaseidl'");

                            $ret_qty = $obj->getvalfield("purchasentry_detail","ret_qty","purchaseid='$purchaseidl'");
                            // $ret_qty = $obj->getvalfield("pur_return","sum(ret_qty)","purchaseid='$purchaseidl'");

                            ?> <tr>
                            <td><?php echo $slno++; ?></td> 
                            <td><?php echo $billno; ?></td>
                            <td><?php echo $obj->dateformatindia($ret_date); ?></td>
                            <td><?php echo $supplier_name; ?></td> 
                             <td><?php echo $ret_qty; ?></td>                                             
                            <td>                        
                            <a class="btn btn-danger" href="pdf_purchase_return.php?purchaseid=<?php echo  $row_get['purchaseid']; ?>" target="_blank" > Print A5 </a></td>
                            <!-- <td>                                                  
                            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['purchaseid']; ?>);' style='cursor:pointer'></a>                                        </td> -->
                            </tr>
                        <?php
            }
            ?>
                        
                       
                    </tbody>
                </table>
                </div>
                </div><?php } ?>
             </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    
    <!--footer-->

    
</div><!--mainwrapper-->

</body>

</html>
