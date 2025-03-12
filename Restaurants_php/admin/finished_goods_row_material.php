<?php include("../adminsession.php");
$pagename = "finished_goods_row_material.php";
$module = "Finished Goods Row Material Setting";
$submodule = "Finished Goods Row Material Setting";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "material_setting";
$tblpkey = "material_set_id";

$sql = $obj->executequery("select * from material_setting");
foreach ($sql as $row) {

	$keyvalue = $row['material_set_id'];
	# code...
}



if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";



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
            <form class="stdform stdform2" method="get" action="" enctype="multipart/form-data">
              <?php echo $dup; ?>
              <div class="lg-12 md-12 sm-12">
               <!--  -->
          </div>
        </form>
      </div>
                    
                     <?php  $chkview = $obj->check_pageview("finished_goods_row_material.php",$loginid);             
                  if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                     
                     
                        <h4 class="widgettitle"><?php echo $submodule; ?> List </h4>
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
                              <th class="head0">Menu Item</th>
                               <th class="head0">Unit Name</th>
                              <th class="head0">Rate</th>
                              <th class="head0">Menu Item Category</th>
                               <th class="head0">Product Type</th>
                              <th class="head0">Setting</th>
                              </tr>
                            </thead>
                            <tbody>
                          
                            <?php
                            $slno=1;
                           
                             $res = $obj->executequery("select * from m_product order by productid desc");
                            foreach($res as $row_get)
                            {
                              $foodtypeid = $row_get['foodtypeid']; 
                              $productid = $row_get['productid'];	
                              $unitid = $row_get['unitid'];
                             $pcatid = $obj->getvalfield("m_product","pcatid","productid='$productid'");
                             $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
                             $category_name = $obj->getvalfield("m_product_category","catname","pcatid='$pcatid'");
                             $food_type_name = $obj->getvalfield("m_food_beverages","food_type_name","foodtypeid='$foodtypeid'");
                              ?>   
                              <tr>
                                <td><?php echo $slno++; ?></td>
                               
                              <td><?php echo $row_get['prodname']; ?></td>
                              <td><?php echo $unit_name; ?></td>
                              <td><?php echo $row_get['rate']; ?></td>
                              <td><?php echo $category_name; ?></td>
                              <td><?php echo $food_type_name; ?></td>
                             

                              <td><input type="submit" name="" value="Setting" class="btn btn-success" onclick="open_modal('<?php echo $row_get['prodname']; ?>','<?php echo $productid; ?>','<?php echo $unit_name; ?>');"></td>
                               
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
              <h3 id="myModalLabel">Material Setting</h3>
            </div>
           <input type="hidden" name="finish_id" id="finish_id">
            <div class="modal-body">
            <span style="color:#F00;" id="suppler_model_error"></span>
             <table class="table table-condensed table-bordered">
             	<tr>
             		<h2><span id="product_name"></span> (<span id="unit_name"></span>)</h2>
             	</tr>
              <tr> 
                <th>Material<span style="color:#F00;"> * </span> </th>
                <th>Unit<span style="color:#F00;"></span> </th>
                <th>Qty<span style="color:#F00;"> * </span> </th>
                <th>Save<span style="color:#F00;"> * </span> </th>
                
              </tr>
                  <td>
                   <select name="row_id" id="row_id" class="chzn-select" onchange="getunit(this.value);">
                   	<option value="">--Select--</option>
                   	<?php 
                   	$sql = $obj->executequery("select * from raw_material");
                   	foreach ($sql as $row_get) 
                   	{ ?>

                   		<option value="<?php echo $row_get['raw_id']; ?>"><?php echo $row_get['raw_name']; ?></option>

                   <?php	}
                   	?>
                   </select>
                  </td>
                  <td>
                   <input type="text" name="unit_name" id="unit_name1" class="input-xxlarge"  style="width:80%;" placeholder="Unit" autocomplete="off" autofocus readonly="readonly" /> 
                  </td>
                  <td>
                   <input type="text" name="qty" id="qty" class="input-xxlarge"  style="width:80%;" placeholder="Enter Qty" autocomplete="off" autofocus/> 
                  </td>
                  <td> <input type="button" class="btn btn-success" onClick="save_party_data();" style="margin-left:20px;" value="Add Product"></td>
                  

                 
            </table>
            <br>
            <div class="row-fluid">
                	<div class="span12">
                    	<h4 class="widgettitle nomargin"> <span style="color:#00F;" > Product Details : <span id="inentryno" > </span>
                        </span></h4>
                        <div class="widgetcontent bordered" id="showrecord">
                        </div><!--widgetcontent-->
                  </div>
                  <!--span8-->
                </div>
            </div>
            <div class="modal-footer">
               
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


function getunit(row_id)
{
   jQuery.ajax({
       type: 'POST',
       url: 'ajax_getunit.php',
       data: 'row_id='+row_id,
       dataType: 'html',
       success: function(data){
          //alert(data);
         
          jQuery('#unit_name1').val(data);
         
        
       }

        });//ajax close
}

  function save_party_data()
{
  //alert('hiie');
  var finish_id = document.getElementById('finish_id').value;
  var row_id = document.getElementById('row_id').value;
  var qty = document.getElementById('qty').value;
  //var qty = document.getElementById('qty').value;

  //alert(qty);
  //alert(qty);
  
  //alert(company_id);

if(row_id == '') 
{
  alert('Fill Row Material');
  return false;
}
if(qty == '') 
{
  alert('Fill Qty');
  return false;
}

else
    {
   jQuery.ajax({
        type: 'POST',
        url: 'save_material_setting.php',
        data: 'row_id='+row_id+'&qty='+qty+'&finish_id='+finish_id,
        dataType: 'html',
        success: function(data){          
          //alert(data);

          //jQuery("#row_id").val('');
          jQuery("#qty").val('');
          jQuery("#row_id").val('').trigger("liszt:updated");
          jQuery('#row_id').val('').trigger('chzn-single:updated');
          jQuery('#row_id').trigger('chzn-single:activate');
          if(data > 0)
          {
          	alert("Duplicate Record");
          }
          //alert(finish_id);
          getrecord(finish_id);

           }
        });//ajax close
    }//else close
        
    } 

function open_modal(prodname,productid,unit_name)
  {
     //var product_name = document.getElementById('product_name').value;
     jQuery("#myModal_party").modal('show');
     jQuery('#product_name').html(prodname);
     jQuery('#unit_name').html(unit_name);
     jQuery('#finish_id').val(productid);
     getrecord(productid);

  }

function getrecord(keyvalue)
	{
		//alert(keyvalue);
		//var emp_id=jQuery("#emp_id").val();

		jQuery.ajax({
		type: 'POST',
		url: 'show_material_set.php',
		data: "finish_id="+keyvalue,
		dataType: 'html',
		success: function(data){				  
		//alert(data);
		jQuery('#showrecord').html(data);
		//setTotalrate();

		}

		});//ajax close

	}
	function deleterecord(material_set_id)
  {
	 	tblname = 'material_setting';
		tblpkey = 'material_set_id';
		pagename = '<?php echo $pagename; ?>';
		submodule = '<?php echo $submodule; ?>';
		module = '<?php echo $module; ?>';		
	if(confirm("Are you sure! You want to delete this record."))
		{
			jQuery.ajax({
			  type: 'POST',
			  url: 'ajax/delete_master.php',
			  data: 'id='+material_set_id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
				 // alert(data);
				var finish_id = document.getElementById('finish_id').value;
				 getrecord(finish_id);
				}
				
			  });//ajax close
		}//confirm close
	
  }
</script>
</body>
</html>
