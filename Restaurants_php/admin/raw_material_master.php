<?php include("../adminsession.php");
//print_r($_SESSION);

$pagename = "raw_material_master.php";
$module = "Material Master";
$submodule = "MATERIAL MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "raw_material";
$tblpkey = "raw_id";
//$imgpath = "uploaded/img/";



if(isset($_GET['raw_id']))
  $keyvalue = $_GET['raw_id'];
else
  $raw_id = "";

if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$status = "";
$dup = "";
//$pcatid = $obj->getvalfield("m_product","pcatid","1=1 order by productid desc limit 0,1");
//$unitid = $obj->getvalfield("m_product","unitid","1=1 order by productid desc limit 0,1");
$raw_name = "";
$unitid = "";
$unit_name = "";
$qty = $rate = "";
$reorder_limit = "";
//$company_id= $_SESSION['company_id'];

if(isset($_POST['submit']))
{	
	//print_r($_FILES); die;

	$raw_name = $obj->test_input($_POST['raw_name']);
	$qty = $obj->test_input($_POST['qty']);
	$unitid  = $obj->test_input($_POST['unitid']);
  $rate  = $obj->test_input($_POST['rate']);
  $open_date  = $obj->dateformatusa($_POST['open_date']);
  $reorder_limit = $obj->test_input($_POST['reorder_limit']);
  $product_type = $obj->test_input($_POST['product_type']);
  //$imgname= $_FILES['imgname'];
//check Duplicate
  $cwhere = array("raw_name"=>$_POST['raw_name']);
  $count = $obj->count_method("raw_material",$cwhere);
    if($count > 0 && $keyvalue == 0 )
      {
      
      $dup="<div class='alert alert-danger'>
      <strong>Error!</strong> Error : Duplicate Record.
      </div>";
      } 
    else{
      //insert
      //echo $keyvalue; die;
      if($keyvalue == 0)
      {   
        $form_data = array('raw_name'=>$raw_name,'qty'=>$qty,'rate'=>$rate,'unitid'=>$unitid,'open_date'=>$open_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'reorder_limit'=>$reorder_limit,'product_type'=>$product_type);
           // $obj->insert_record($tblname,$form_data); 
            $obj->insert_record($tblname,$form_data); 
            //print_r($form_data); die;
            $action=1;
            $process = "insert";
            echo "<script>location='$pagename?action=$action'</script>";
          
        }
        else{
                    //update
              $form_data = array('raw_name'=>$raw_name,'qty'=>$qty,'rate'=>$rate,'unitid'=>$unitid,'open_date'=>$open_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'reorder_limit'=>$reorder_limit,'product_type'=>$product_type);
              $where = array($tblpkey=>$keyvalue);
              $keyvalue = $obj->update_record($tblname,$where,$form_data);
              $action=2;
              $process = "updated";

            }
        echo "<script>location='$pagename?action=$action'</script>";

    //}
  }
}
if(isset($_GET[$tblpkey]))
{ 

	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$raw_name = $sqledit['raw_name'];
  $qty = $sqledit['qty'];
  $rate = $sqledit['rate'];
  $open_date = $sqledit['open_date'];
  $unitid = $sqledit['unitid'];
  $reorder_limit = $sqledit['reorder_limit'];
  $product_type = $sqledit['product_type'];

}
else
{
  $open_date = date('Y-m-d');
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

             

            <p>
              <label>Raw Material Name<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="raw_name" placeholder="Raw Material Name" id="raw_name" autocomplete="off" class="input-xxlarge" value="<?php echo $raw_name;?>" autofocus/></span>
            </p>
            
            <p>
              <label> Unit <span class="text-error">*</span></label>
              <span class="field">
               
               <select name="unitid" id="unitid"  class="chzn-select" style="width:543px;" >
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
              <script>document.getElementById('unitid').value = '<?php echo $unitid; ?>';</script></span>
            </p>

             <p>
              <label>Product Type<span class="text-error">*</span></label>
              <span class="field"> <select name="product_type" id="product_type"  class="chzn-select" style="width:540px;">
                <option value="" >---Select---</option>
                    <option value="packed item">Packed item</option>
                    <option value="raw material">Raw Material</option>

              </select>
              <script>document.getElementById('product_type').value = '<?php echo $product_type; ?>';</script></span>
            </p>

            <p>
              <label>Opening Stock Quantity<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="qty" placeholder="Enter Quantity" id="qty" autocomplete="off" class="input-xxlarge" value="<?php echo $qty;?>" autofocus/></span>
            </p>
            <p>
              <label>Opening Date<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="open_date" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($open_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask  id="open_date" autocomplete="off" class="input-xxlarge" autofocus/></span>
            </p>
            <p>
              <label>Purchase Rate<span class="text-error"></span></label>
              <span class="field"><input type="text" name="rate" placeholder="Enter Price" id="rate" autocomplete="off" class="input-xxlarge" value="<?php echo $rate;?>" autofocus/></span>
            </p>

            <p>
              <label>Reorder Limit<span class="text-error"></span></label>
              <span class="field"><input type="text" name="reorder_limit" id="reorder_limit" class="input-xlarge"  value="<?php echo $reorder_limit;?>" autofocus autocomplete="off"  placeholder="Enter Reorder Limit"/>
                 </span>
            </p>
            
            
            
                <center> <p class="stdformbutton">
                  <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('raw_name,unitid,product_type,qty,open_date');" />
                  <?php echo $btn_name; ?></button>
                  <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                  <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                </p> </center>
              </form>
            </div>
               <!-- for print pdf -->
            <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_menuitem_master.php" class="btn btn-info" target="_blank">
                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

                   <?php  $chkview = $obj->check_pageview("raw_material_master.php",$loginid);             
                  if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                    
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <table class="table table-bordered" id="dyntable">

                      <thead>
                        <tr>
                          <th class="head0 nosort">S.No.</th>
                          <th class="head0">Raw Material Name</th>  
                          <th class="head0">Unit</th>
                          <th class="head0">Product Type</th>
                          <th class="head0">Opening Stock Quantity</th> 
                          <th class="head0">Opening Date</th>
                           <th class="head0">Rate</th>
                            <th class="head0">Reorder Limit</th>
                          <?php  $chkedit = $obj->check_editBtn("raw_material_master.php",$loginid);              
                            if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                          <th class="head0">Edit</th><?php } ?>
                          <?php  $chkdel = $obj->check_delBtn("raw_material_master.php",$loginid);             
                            if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                          <th class="head0">Delete</th><?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                      
                      <?php
                      $slno=1;
                        //$where = array("company_id"=>$company_id);
                      $res = $obj->executequery("select * from  raw_material order by raw_id desc");

                      foreach($res as $row_get)
                      {
                       $product_type = $row_get['product_type'];
                       //$category_name = $obj->getvalfield("m_product_category","catname","pcatid='$pcatid'");

                       $unitid = $row_get['unitid'];
                       $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
                       ?> 
                       <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $row_get['raw_name']; ?></td>
                         <td><?php echo $unit_name; ?></td>
                         <td><?php echo $product_type; ?></td>
                        <td><?php echo $row_get['qty']; ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['open_date']); ?></td>
                        <td><?php echo number_format($row_get['rate'],2); ?></td> 
                         <td><?php echo $row_get['reorder_limit']; ?></td> 
                        
                        
                        <?php if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                        <td>
                          <a class='icon-edit' title="Edit" href='raw_material_master.php?raw_id=<?php echo $row_get['raw_id'] ; ?>'></a>
                        </td><?php } ?>
                        <?php  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                        <td>
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['raw_id']; ?>);' style='cursor:pointer'></a>
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
 <script>
 function funDel(id)
  {  //alert(id);   
    tblname = '<?php echo $tblname; ?>';
    tblpkey = '<?php echo $tblpkey; ?>';
    pagename = '<?php echo $pagename; ?>';
    submodule = '<?php echo $submodule; ?>';
    module = '<?php echo $module; ?>';
    
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

 jQuery('#open_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});


</script>
</body>
</html>
