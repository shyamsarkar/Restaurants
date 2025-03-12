<?php include("../adminsession.php");
$pagename = "product.php";
$module = "ProductMaster";
$submodule = "PRODUCT MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_product";
$tblpkey = "product_id";

if(isset($_GET['product_id']))
  $keyvalue = $_GET['product_id'];
else
  $keyvalue = 0;
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$product_name = "";
$company_id = "";
$cgst = "";
$sgst = "";
$igst = "";
$unit_id = "";
$product_type = "";
$opening_stock ="";
$stock_date ="";
$hsnno="";
$prod_code="";
$ratefrmplant ="";
$ratefrmdelivery="";
$validity_day="";
$imgname="";
$show_month_bill = "";
$taxtype ="";
$reorder_limit = "";
$purches_rate = "";
$sale_rate = "";
$company_name = $obj->getvalfield("company_setting","company_name","company_id='$_SESSION[company_id]'");

if(isset($_POST['submit']))
{
	
	$product_name  = $_POST['product_name'];
	$category_id = $_POST['category_id'];
  $unit_id =  $_POST['unit_id'];
  $cgst = $_POST['cgst'];
  $sgst = $_POST['sgst'];
  $igst = $_POST['igst'];
  $product_type = $_POST['product_type'];
  $opening_stock = $_POST['opening_stock'];
  $stock_date = $obj->dateformatusa($_POST['stock_date']);
  $hsnno = $_POST['hsnno'];
  $reorder_limit = $_POST['reorder_limit'];
  $sale_rate = $_POST['sale_rate'];
  $purches_rate = $_POST['purches_rate'];
  $taxtype = $_POST['taxtype'];
	
	 //check Duplicate
  $cwhere = array("product_name"=>$_POST['product_name']);
       // print_r($cwhere);die;
  $count = $obj->count_method("m_product",$cwhere);
  if ($count > 0 && $keyvalue == 0) 
  { 
   $dup="<div class='alert alert-danger'>
   <strong>Error!</strong> Duplicate Record.
   </div>";
			//echo $dup; die;
 } 
			else //insert
      {	
        if($keyvalue == 0)
        {    
          $form_data = array('product_name'=>$product_name,'category_id'=>$category_id,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'unit_id'=>$unit_id,'product_type'=>$product_type,'hsnno'=>$hsnno,'taxtype'=>$taxtype,'opening_stock'=>$opening_stock,'stock_date'=>$stock_date,'reorder_limit'=>$reorder_limit,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sale_rate'=>$sale_rate,'purches_rate'=>$purches_rate);
			
          $keyvalue = $obj->insert_record_lastid($tblname,$form_data);
          $action=1;
          $process = "insert";
          echo "<script>location='$pagename?action=$action'</script>";
        }
        else
        {
					//update
         $form_data = array('product_name'=>$product_name,'category_id'=>$category_id,'cgst'=>$cgst,'sgst'=>$sgst,'igst'=>$igst,'unit_id'=>$unit_id,'product_type'=>$product_type,'hsnno'=>$hsnno,'taxtype'=>$taxtype,'opening_stock'=>$opening_stock,'stock_date'=>$stock_date,'reorder_limit'=>$reorder_limit,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sale_rate'=>$sale_rate,'purches_rate'=>$purches_rate);
         $where = array($tblpkey=>$keyvalue);
         $obj->update_record($tblname,$where,$form_data);
         $action=2;
         $process = "updated";
       }
       echo "<script>location='$pagename?action=$action'</script>";
     } 
   }
   if(isset($_GET[$tblpkey]))
   { 

    $btn_name = "Update";
    $where = array($tblpkey=>$keyvalue);
    $sqledit = $obj->select_record($tblname,$where);
    $product_name =  $sqledit['product_name'];
    $category_id =  $sqledit['category_id'];
    $unit_id =  $sqledit['unit_id'];
    $cgst = $sqledit['cgst'];
    $sgst = $sqledit['sgst'];
    $igst =  $sqledit['igst'];
    $product_type = $sqledit['product_type'];
    $opening_stock = $sqledit['opening_stock'];
    $stock_date = $obj->dateformatindia($sqledit['stock_date']);
    $taxtype = $sqledit['taxtype'];
    $hsnno = $sqledit['hsnno'];
    $reorder_limit = $sqledit['reorder_limit'];
    $sale_rate = $sqledit['sale_rate'];
    $purches_rate = $sqledit['purches_rate'];
  }
  else
  {
    $stock_date = date('d-m-Y');
  }
  ?>
  <!DOCTYPE html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("inc/top_files.php"); ?>
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
          <div class="widgetcontent  shadowed nopadding">
            <form class="stdform stdform2" method="post" action="" enctype="multipart/form-data">
              <?php echo $dup; ?>
              <div class="lg-12 md-12 sm-12">
               <table class="table table-bordered"> 
                <!--tr open-->
                <tr> 
                  <th>Product Name<span style="color:#F00;">*</span></th>
                  <th>Product Category<span style="color:#F00;">*</span><a class="btn btn-success btn-small" onClick="jQuery('#myModal_party').modal('show');" data-toggle="modal_party" style="margin-left:20px;"><strong> + </strong></a></th>
                  <th>Product Type<span style="color:#F00;"></span></th>
                  <!-- <th>Stock Date<span style="color:#F00;"> *</span></th> -->
                </tr>
                <tr>      
                  <td> <input type="text" name="product_name" id="product_name" class="input-xlarge"  value="<?php echo $product_name;?>" autofocus autocomplete="off"  placeholder="Enter Product Name"/>
                  </td>

                  <td>
                    <select name="category_id" id="category_id"  class="chzn-select" style="width:283px;" >
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

                  <td>
                  <select name="product_type" id="product_type"  class="chzn-select" style="width:283px;" >
                    <option value="" >---Select---</option>
                    <option value="finished good" >Finished Good </option>
                    <option value="raw material" >Raw Material</option>

                  </select>
                  <script>document.getElementById('product_type').value = '<?php echo $product_type ; ?>';</script>
                 </td>  
                 
                </tr><!--tr close-->
                <tr><!--tr open-->
                  <th>CGST<span style="color:#F00;"></span></th>
                  <th>SGST<span style="color:#F00;"></span></th>
                  <th>IGST<span style="color:#F00;"></span></th>
                </tr>
                <tr>
                   <td> <input type="text" name="cgst" id="cgst" class="input-xlarge"  value="<?php echo $cgst;?>" autofocus autocomplete="off"  placeholder="Enter CGST"/></td>

                   <td> <input type="text" name="sgst" id="sgst" class="input-xlarge"  value="<?php echo $sgst;?>" autofocus autocomplete="off"  placeholder="Enter SGST"/></td>

                   <td> <input type="text" name="igst" id="igst" class="input-xlarge"  value="<?php echo $igst;?>" autofocus autocomplete="off"  placeholder="Enter IGST"/></td>
                </tr><!--tr close-->
                <tr> <!--tr open--> 
                   <th>UOM<span style="color:#F00;">*</span></th>
                   <th>Stock Date<span style="color:#F00;"> *</span></th>
                   <!-- <th>Product Type<span style="color:#F00;"></span></th> -->
                   <th>Opening Stock<span style="color:#F00;">*</span></th>
                </tr>
                <tr>
                 <td>
                  <select name="unit_id" id="unit_id"  class="chzn-select" style="width:283px;" >
                    <option value="" >---Select---</option>
                    <?php
                    $slno=1;
                    $res = $obj->fetch_record("m_unit");
                    foreach($res as $row_get)
                    {
                     ?> 
                     <option value="<?php echo $row_get['unit_id']; ?>"> <?php echo $row_get['unit_name']; ?></option>						                              <?php }
                     ?>
                   </select>
                   <script>document.getElementById('unit_id').value = '<?php echo $unit_id ; ?>';</script>
                 </td>  
                 
                 <td><input type="text" name="stock_date" id="stock_date" class="input-xlarge"  value="<?php echo $stock_date; ?>" autofocus autocomplete="off" placeholder="dd-mm-yyyy"/>
                  </td>       

                 <td> <input type="text" name="opening_stock" id="opening_stock" class="input-xlarge"  value="<?php echo $opening_stock;?>" autofocus autocomplete="off"  placeholder="Enter Opening Stock"/></td>
              </tr><!--tr close-->

              <tr> <!--tr open--> 
                  <th>HSN No.<span style="color:#F00;"></span></th>
                  <th>Purches Rate<span style="color:#F00;"></span></th>
                  <th>Sale Rate<span style="color:#F00;"></span></th>
                </tr>
                <tr>
                 <td><input type="text" name="hsnno" id="hsnno" class="input-xlarge"  value="<?php echo $hsnno;?>" autofocus autocomplete="off"  placeholder="HSN No."/>
                 </td>
                 <td> <input type="text" name="purches_rate" id="purches_rate" class="input-xlarge"  value="<?php echo $purches_rate;?>" autofocus autocomplete="off"  placeholder="Enter Purchase Rate"/>
                 </td>

                <td> <input type="text" name="sale_rate" id="sale_rate" class="input-xlarge"  value="<?php echo $sale_rate;?>" autofocus autocomplete="off"  placeholder="Enter Sale Rate"/>
                 </td>
              </tr><!--tr open-->
              <tr> <!--tr open--> 
                  <th>Reorder Limit</th>
                  <th>Tax Type<span style="color:#F00;">*</span></th>
                  <th></th>
                </tr>
                <tr>
                 <td><input type="text" name="reorder_limit" id="reorder_limit" class="input-xlarge"  value="<?php echo $reorder_limit;?>" autofocus autocomplete="off"  placeholder="Enter Reorder Limit"/>
                 </td>
                 <td>
                     <select name="taxtype" id="taxtype" class="chzn-select" style="width:283px;"><?php echo $taxtype; ?>
                     <option value="exclusive">Exclusive</option>
                     <option value="inclusive">Inclusive</option>
                     
                   </select>
                   <script type="text/javascript">
                     document.getElementById('taxtype').value = '<?php echo $taxtype; ?>';
                   </script>
                 </td>
                 <td></td>
              </tr><!--tr open-->
          
            <td colspan="3">
                <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('product_name,category_id,unit_id,stock_date,opening_stock,taxtype'); ">
                <?php echo $btn_name; ?></button>
                <a href="product.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">		</td>								
              </tr>

            </table>
          </div>
        </form>
      </div>
                    
                      <!--widgetcontent-->
                      <?php   $chkview = $obj->check_pageview("product.php",$loginid);							
                      if($chkview == 1 || $loginid == 1){  ?>
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
                              <th  class="head0 nosort">Sno.</th>
                              <th  class="head0">Company Name</th>
                              <th class="head0">Product_Info</th>
                              <th class="head0">Tax_Info</th>
                              <th class="head0">Stock_Info</th>
                             <?php   $chkedit = $obj->check_editBtn("product.php",$loginid);							
                              if($chkedit == 1 || $loginid == 1){  ?>
                                <th width="4%" class="head0">Edit</th>
                              <?php } ?>
                              
                              <?php  $chkdel = $obj->check_delBtn("product.php",$loginid);							
                              if($chkdel == 1 || $loginid == 1){  ?>                              
                                <th width="5%" class="head0">Delete</th> <?php } ?> 
                              </tr>
                            </thead>
                            <tbody>
                            </span>
                            <?php
                            $slno=1;
						
                            $res = $obj->executequery("select * from m_product order by product_id desc");
                            foreach($res as $row_get)
                            {
                              $category_id = $row_get['category_id'];
                              $categoryname = $obj->getvalfield("m_category","category_name","category_id='$category_id'");
                              ?>   
                              <tr>
                                <td><?php echo $slno++; ?></td>
                                <td><?php echo $company_name ?></td>
                                <td>
                                  <b>Product Name:</b>&nbsp;<?php echo $row_get['product_name']; ?><br>
                                  <b>Purches Rate:</b>&nbsp;<?php echo $row_get['purches_rate']; ?><br>
                                  <b>Sale Rate:</b>&nbsp;<?php echo $row_get['sale_rate']; ?><br>
                                  <b>Product Category:</b>&nbsp;<?php echo $categoryname; ?><br>
                                  <b>Product Type:</b>&nbsp;<?php echo $row_get['product_type']; ?><br>
                                  <b>HSN_no:</b>&nbsp;<?php echo $row_get['hsnno']; ?>
                              </td>
                                <td>
                                  <b>Tax_Type:</b>&nbsp;<?php echo $row_get['taxtype']; ?><br>
                                  <b>CGST:</b>&nbsp;<?php echo $row_get['cgst']; ?><br>
                                  <b>SGST:</b>&nbsp;<?php echo $row_get['sgst']; ?><br>
                                  <b>IGST:</b>&nbsp;<?php echo $row_get['igst']; ?>
                              </td>
                                <td>
                                  <b>Opening Stock:</b>&nbsp;<?php echo $row_get['opening_stock']; ?><br>
                                  <b>Reorder Limit:</b>&nbsp;<?php echo $row_get['reorder_limit']; ?><br>
                                  <b>Stock Date:</b>&nbsp;<?php echo $obj->dateformatindia($row_get['stock_date']); ?>

                                </td>
                                
                                <?php if($chkedit == 1 || $loginid == 1){  ?>
                                 <td><a class='icon-edit' title="Edit" href='product.php?product_id=<?php echo $row_get['product_id'] ; ?>'></a></td><?php } ?>
                                 <?php  if($chkdel == 1 || $loginid == 1){  ?>
                                  <td>
                                    <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['product_id']; ?>);' style='cursor:pointer'></a>
                                    </td><?php } ?>
                                  </tr>

                                  <?php
                                }
                                ?>     
                              </tbody>
                            </table>

                          <?php } ?>
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
                <th style="width: 50%;">Category Name<span style="color:#F00;"> * </span> </th>
                
              </tr>
                  <td>
                   <input type="text" name="category_name" id="category_name" class="input-xxlarge"  style="width:90%;" placeholder="Add New Category" autocomplete="off" autofocus/> 
                  </td>
                 
            </table>
            </div>
            <div class="modal-footer">
               <button class="btn btn-primary" name="s_save" id="s_save" onClick="save_party_data();">Save</button>
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


  jQuery('#stock_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
  jQuery('#stock_date').focus();


  function save_party_data()
{
  
  var category_name = document.getElementById('category_name').value;
  
  //alert(company_id);

if (category_name == '') 
{
  alert('Fill Category Name');
  return false;
}

else
    {
   jQuery.ajax({
        type: 'POST',
        url: 'save_category.php',
        data: 'category_name='+category_name,
        dataType: 'html',
        success: function(data){          
          //alert(data);

                //jQuery('#showallbtn').click();
          jQuery("#category_name").val('');
          jQuery("#myModal_party").modal('hide');
          jQuery('#category_id').html(data);
          jQuery("#category_id").val('').trigger("liszt:updated");
          jQuery('#category_id').val('').trigger('chzn-single:updated');
          jQuery('#category_id').trigger('chzn-single:activate'); // for autofocus
          //getproductdetail();

                       }
        });//ajax close
    }
        
    } 
</script>
</body>
</html>
