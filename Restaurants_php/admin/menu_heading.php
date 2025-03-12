<?php include("../adminsession.php");
$pagename = "menu_heading.php";
$module = "Menu Heading";
$submodule = "MENU HEADING MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_product_category";
$tblpkey = "pcatid";


if(isset($_GET['pcatid']))
  $keyvalue = $_GET['pcatid'];
else
  $keyvalue = 0;
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";


$status = "";
$dup = "";
$catname = $type = "";
$checked_status = 1;
$type = "menu";


if(isset($_POST['submit']))
{ 

  //print_r($_POST); die;

 $catname = $obj->test_input($_POST['catname']);
 $type = $obj->test_input($_POST['type']);

 if(isset($_POST['checked_status']))
  {
    $checked_status  = $obj->test_input($_POST['checked_status']);
  }
  else
  {
    $checked_status = "";
  }

    //check Duplicate
 $cwhere = array("catname"=>$_POST['catname'],"type"=>$_POST['type']);
 $count = $obj->count_method("m_product_category",$cwhere);
 if($count > 0 && $keyvalue == 0 )
 {
  /*$dup = " Error : Duplicate Record";*/
  $dup="<div class='alert alert-danger'>
  <strong>Error!</strong> Error : Duplicate Record.
  </div>";
} 

else{
      //insert
  if($keyvalue == 0)
  {    
    $form_data = array('catname'=>$catname,'type'=>$type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'checked_status'=>$checked_status);
    $obj->insert_record($tblname,$form_data); 
  //print_r($form_data); die;
    $action=1;
    $process = "insert";
    echo "<script>location='$pagename?action=$action'</script>";
  }
  
  else{
        //update
    $form_data = array('catname'=>$catname,'type'=>$type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'checked_status'=>$checked_status);
    $where = array($tblpkey=>$keyvalue);
    $keyvalue = $obj->update_record($tblname,$where,$form_data);
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
  $catname =  $sqledit['catname'];
  $type =  $sqledit['type'];
  $checked_status =  $sqledit['checked_status'];
}
else
{
//$status = "enable";
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
           <form class="stdform stdform2" method="post" action="">
            <?php echo  $dup;  ?>
            <p>
              <label>Menu Name <span class="text-error">*</span></label>
              <span class="field"><input type="text" name="catname" id="catname" class="input-xxlarge" placeholder="Menu Name" value="<?php echo $catname;?>" autocomplete="off" autofocus/></span>
            </p>
            <p>
              <label>Type:<span class="text-error">*</span></label>
              <span class="field">
                <select name="type" id="type" class="chzn-select input-xxlarge"><?php echo $type;?>
                <!-- <option value="">--Select--</option> -->
                <option value="menu">Menu</option>
               <!--  <option value="raw material">Raw Material</option>
                <option value="finish good">Finish Good</option> -->
              </select>
              <script type="text/javascript">
                document.getElementById('type').value = '<?php echo $type;?>'
              </script>
            </span>
          </p>
           <p>
                    <label>Visible On QRCode Order Menu :</label>
                    <span class="field">
                    <input type="checkbox" name="checked_status" id="checked_status" value="1" <?php if($checked_status == 1){ echo "checked"; } ?>>
                    </span>
                    
                  </p>
          <center> <p class="stdformbutton">
            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('catname,type');">
              <?php echo $btn_name; ?></button>
              <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
              <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
            </p> </center>
          </form>
        </div>
        <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_menu_heading.php" class="btn btn-info" target="_blank">
          <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
          <?php  $chkview = $obj->check_pageview("menu_heading.php",$loginid);             
          if($chkview == 1 || $usertype == 'admin'){  ?>  

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

                  <th width="11%" class="head0 nosort">Sno.</th>
                  <th width="18%" class="head0">Menu Name</th>
                  <th width="18%" class="head0">Menu Type</th>
                  <?php  $chkedit = $obj->check_editBtn("menu_heading.php",$loginid);              
                  if($chkedit == 1 || $usertype == 'admin'){  ?>
                    <th width="9%" class="head0">Edit</th> <?php } ?>
                    <?php  $chkdel = $obj->check_delBtn("menu_heading.php",$loginid);             
                    if($chkdel == 1 || $usertype == 'admin'){  ?>
                      <th width="10%" class="head0">Delete</th><?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                  
                  <?php
                  $slno=1;
            
                  $res = $obj->executequery("select * from m_product_category order by pcatid desc");
                  foreach($res as $row_get)
                  {
                    ?>   
                    <tr>
                      <td><?php echo $slno++; ?></td> 
                      <td><?php echo $row_get['catname']; ?></td>
                      <td><?php echo $row_get['type']; ?></td>
                      <?php if($chkedit == 1 || $usertype == 'admin'){  ?>
                       <td><a class='icon-edit' title="Edit" href='menu_heading.php?pcatid=<?php echo $row_get['pcatid'] ; ?>'></a></td><?php } ?>
                       <?php  if($chkdel == 1 || $usertype == 'admin'){  ?>
                        <td>
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['pcatid']; ?>);' style='cursor:pointer'></a>
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

</script>
</body>
</html>
