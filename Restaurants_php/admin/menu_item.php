<?php include("../adminsession.php");
//print_r($_SESSION);

$pagename = "menu_item.php";
$module = "Menu Item Master";
$submodule = "MENU ITEM MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_product";
$tblpkey = "productid";
$imgpath = "uploaded/img/";

if(isset($_GET['productid']))
  $keyvalue = $_GET['productid'];
else
  $productid = "";

if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

if(isset($_GET['pcatid']))
  $pcatid = $_GET['pcatid'];
else
  $pcatid = "";

$dup = "";
$pcatid = $obj->getvalfield("m_product","pcatid","1=1 order by productid desc limit 0,1");
$unitid = $obj->getvalfield("m_product","unitid","1=1 order by productid desc limit 0,1");
$foodtypeid = $obj->getvalfield("m_product","foodtypeid","1=1 order by productid desc limit 0,1");



$status = 1;
$prodname = "";
$product_code  = "";
$imgname = "";
$rate = "";
$checked_status = 1;
$description = "";

if(isset($_POST['submit']))
{ 
  //print_r($_FILES); die;

  $pcatid = $obj->test_input($_POST['pcatid']);
  $prodname   = $obj->test_input($_POST['prodname']);
  $product_code   = $obj->test_input($_POST['product_code']);
  $unitid  = $obj->test_input($_POST['unitid']);
  $rate  = $obj->test_input($_POST['rate']);
  $description  = $obj->test_input($_POST['description']);
  $foodtypeid = $obj->test_input($_POST['foodtypeid']);
 
  if(isset($_POST['checked_status']))
  {
    $checked_status  = $obj->test_input($_POST['checked_status']);
  }
  else
  {
    $checked_status = "";
  }

  $imgname= $_FILES['imgname'];
  $status = $obj->test_input($_POST['status']);
//check Duplicate
  $cwhere = array("prodname"=>$_POST['prodname']);
  $count = $obj->count_method("m_product",$cwhere);
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
        $form_data = array('pcatid'=>$pcatid,'foodtypeid'=>$foodtypeid, 'prodname'=>$prodname,'product_code'=>$product_code,'rate'=>$rate,'unitid'=>$unitid,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'checked_status'=>$checked_status,'description'=>$description,'status'=>$status);
           // $obj->insert_record($tblname,$form_data); 
            $lastid = $obj->insert_record_lastid($tblname,$form_data);
           
            $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
                //print_r($uploaded_filename);die;
            $form_data = array('imgname'=>$uploaded_filename);
            $where = array($tblpkey=>$lastid);
            //print_r($where);die;
            $keyvalue = $obj->update_record($tblname,$where,$form_data);
            
            $action=1;
            $process = "insert";
            echo "<script>location='$pagename?action=$action'</script>";
        }
        else{
                    //update
              $form_data = array('pcatid'=>$pcatid,'foodtypeid'=>$foodtypeid, 'prodname'=>$prodname,'product_code'=>$product_code,'rate'=>$rate,'unitid'=>$unitid,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate,'checked_status'=>$checked_status,'description'=>$description,'status'=>$status);
              $where = array($tblpkey=>$keyvalue);
              $obj->update_record($tblname,$where,$form_data);
              if($_FILES['imgname']['tmp_name']!="")
              {

                               //delete old file
                 $oldimg = $obj->getvalfield("$tblname","imgname","$tblpkey='$keyvalue'");

                 if(!empty($oldimg))
                    unlink("uploaded/img/$oldimg");

              $uploaded_filename = $obj->uploadImage($imgpath,$imgname);
              //$obj->convert_image($uploaded_filename,"uploaded/img/","100","150");

              $form_data = array('imgname'=>$uploaded_filename);
              $where = array($tblpkey=>$keyvalue);
              $keyvalue = $obj->update_record($tblname,$where,$form_data);
        }
        $action=2;
        $process = "updated";

            // }
        echo "<script>location='$pagename?action=$action'</script>";

    }
  }
}


if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $pcatid = $sqledit['pcatid'];
  $prodname = $sqledit['prodname'];
  $product_code = $sqledit['product_code'];
  $rate = $sqledit['rate'];
  $unitid = $sqledit['unitid'];
  $imgname = $sqledit['imgname'];
  $description = $sqledit['description'];
  $checked_status = $sqledit['checked_status'];
  $status = $sqledit['status'];
  $foodtypeid = $sqledit['foodtypeid'];
  

}



?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
</head>
<body onload="gettaxtype('0');">
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
              <label>Menu Heading Name <span class="text-error">*</span></label>
              <span class="field"><select name="pcatid" id="pcatid"  class="chzn-select" style="width:543px;">
                <option value="">---Select---</option>
                <?php
                $crow=$obj->executequery("select * from m_product_category");
                foreach ($crow as $cres) 
                {

                  ?>
                  <option value="<?php echo $cres['pcatid']; ?>"> <?php echo $cres['catname']; ?></option>    
                  <?php
                }

                ?>

              </select>
              <script>document.getElementById('pcatid').value = '<?php echo $pcatid; ?>';</script></span>
            </p>

            <p>
              <label>food/Beverages <span class="text-error">*</span></label>
              <span class="field"><select name="foodtypeid" id="foodtypeid"  class="chzn-select" style="width:543px;">
                <option value="">---Select---</option>
                <?php
                $crow=$obj->executequery("select * from m_food_beverages");
                foreach ($crow as $cres) 
                {

                  ?>
                  <option value="<?php echo $cres['foodtypeid']; ?>"> <?php echo $cres['food_type_name']; ?></option>    
                  <?php
                }

                ?>

              </select>
              <script>document.getElementById('foodtypeid').value = '<?php echo $foodtypeid; ?>';</script></span>
            </p>

            <p>
              <label>Menu Item Name<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="prodname" placeholder="Menu Item Name" id="prodname" autocomplete="off" class="input-xxlarge" value="<?php echo $prodname;?>" autofocus/></span>
            </p>

            <p>
              <label>Menu Item Code<span class="text-error"></span></label>
              <span class="field"><input type="text" name="product_code" placeholder="Menu Item Code" id="product_code" autocomplete="off" class="input-xxlarge" value="<?php echo $product_code;?>" autofocus/></span>
            </p>
            
            <p>
              <label> Unit <span class="text-error">*</span></label>
              <span class="field"><select name="unitid" id="unitid"  class="chzn-select" style="width:543px;" >
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
              <label>Rate<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="rate" placeholder="Enter Price" id="rate" autocomplete="off" class="input-xxlarge" value="<?php echo $rate;?>" autofocus/></span>
            </p>
            
            <p>
              <label>Product Image : </label>
              <span class="field">
                <input type="file" name="imgname" id="imgname">

                <?php
                if($imgname!="")
                  { ?>
                    <img id="blah" alt="" align="right" style="height:50px;margin-right: 50%; margin-bottom: 5px; width:50px;" title='Text Image' src='<?php if($imgname!="" && file_exists("uploaded/img/".$imgname))
                    {
                      echo "uploaded/img/".$imgname; }?>'/>
                    <?php } ?>  
                  </span>
                </p>

                 <p>
              <label>Status <span class="text-error">*</span></label>
              <span class="field"><select name="status" id="status"  class="chzn-select" style="width:543px;">
                <option value="">---Select---</option>
                  <option value="1">Enable</option>  
                  <option value="0">Disable</option> 

              </select>
              <script>document.getElementById('status').value = '<?php echo $status; ?>';</script></span>
            </p>

                <p>
                  <label>Description<span class="text-error"></span></label>
                  <span class="field"><textarea type="text" name="description" placeholder="Description" id="description" autocomplete="off" class="input-xxlarge"  autofocus><?php echo $description;?></textarea></span>
                </p>

                 <p>
                    <label>Visible On QRCode Order Menu :</label>
                    <span class="field">
                    <input type="checkbox" name="checked_status" id="checked_status" value="1" <?php if($checked_status == 1){ echo "checked"; } ?>>
                    </span>
                    
                  </p>
                <center> <p class="stdformbutton">
                  <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('pcatid,prodname,unitid,rate nu,taxtype,status');" />
                  <?php echo $btn_name; ?></button>
                  <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                  <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                </p> </center>
              </form>
            </div>
               <!-- for print pdf -->
            <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_menuitem_master.php" class="btn btn-info" target="_blank">
                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

                   <?php  $chkview = $obj->check_pageview("menu_item.php",$loginid);             
                  if($chkview == 1 || $usertype == 'admin'){  ?>
                    
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <table class="table table-bordered" id="dyntable">

                      <thead>
                        <tr>
                          <th class="head0 nosort">S.No.</th>
                          <th class="head0">Item Code</th>  
                          <th class="head0">Item Name</th>
                          <th class="head0">Menu Heading</th>
                          <th class="head0">food/Beverages</th>
                          <th class="head0">Unit</th>
                          <th class="head0">Rate</th> 
                          <th class="head0">Status</th>
                          
                          <?php  $chkedit = $obj->check_editBtn("menu_item.php",$loginid);              
                            if($chkedit == 1 || $usertype == 'admin'){  ?>
                          <th class="head0">Edit</th><?php } ?>
                          <?php  $chkdel = $obj->check_delBtn("menu_item.php",$loginid);             
                            if($chkdel == 1 || $usertype == 'admin'){  ?>
                          <th class="head0">Delete</th><?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                     
                      <?php
                      $slno=1;
                       
                      $res = $obj->executequery("select * from  m_product order by productid desc");

                      foreach($res as $row_get)
                      {
                       $pcatid = $row_get['pcatid'];
                       $foodtypeid = $row_get['foodtypeid'];
                       $product_code = $row_get['product_code'];
                       $prodname = $row_get['prodname'];
                       $catname = $obj->getvalfield("m_product_category","catname","pcatid='$pcatid'");
                       $food_type_name = $obj->getvalfield("m_food_beverages","food_type_name","foodtypeid='$foodtypeid'");
                       $unitid = $row_get['unitid'];
                       $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
                       $rate = $row_get['rate'];
                       
                        $status = $row_get['status'];
                        if($status==1)
                         $status1 = '<span>Enable</span>';
                        else
                         $status1 = '<span>Disable</span>';

                      
                       ?> 
                       <tr>
                        <td><?php echo $slno++; ?></td>
                         <td><?php echo $product_code; ?></td> 
                          <td><?php echo $prodname; ?></td>  
                          <td><?php echo $catname; ?></td> 
                        <td><?php echo $food_type_name; ?></td> 

                        <td><?php echo $unit_name; ?></td> 
                        <td><?php echo number_format($row_get['rate'],2); ?></td> 
                        
                        <td><?php echo $status1; ?></td> 
                        
                        <?php if($chkedit == 1 || $usertype == 'admin'){  ?>
                        <td>
                          <a class='icon-edit' title="Edit" href='menu_item.php?productid=<?php echo $row_get['productid'] ; ?>'></a>
                        </td><?php } ?>
                        <?php  if($chkdel == 1 || $usertype == 'admin'){  ?>
                        <td>
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['productid']; ?>);' style='cursor:pointer'></a>
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
    imgpath = '<?php echo $imgpath; ?>';
     //alert(imgpath); 
    if(confirm("Are you sure! You want to delete this record."))
    {
     jQuery.ajax({
       type: 'POST',
       url: 'ajax/delete_image_master.php',
       data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module+'&imgpath='+imgpath,
       dataType: 'html',
       success: function(data){
         // alert(data);
         location='<?php echo $pagename."?action=3" ; ?>';
       }

        });//ajax close
    }//confirm close
  } //fun close
 jQuery('#open_bal_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
//jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});

jQuery('#open_bal_date').focus();


</script>
</body>
</html>
