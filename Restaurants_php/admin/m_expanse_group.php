<?php include("../adminsession.php");
$pagename = "m_expanse_group.php";
$module = "Transaction Group";
$submodule = "TRANSACTION GROUP";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_expanse_group";
$tblpkey = "ex_group_id";
if(isset($_GET['ex_group_id']))
  $keyvalue = $_GET['ex_group_id'];
else
  $keyvalue = 0;
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$status = "";
$dup = "";
$group_name = "";
if(isset($_POST['submit']))
{ //print_r($_POST); die;
  
  $group_name = $_POST['group_name'];

    //check Duplicate
  $cwhere = array("group_name"=>$_POST['group_name']);
  $count = $obj->count_method("m_expanse_group",$cwhere);
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
    $form_data = array('group_name'=>$group_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
    $obj->insert_record($tblname,$form_data); 
  //print_r($form_data); die;
    $action=1;
    $process = "insert";
    echo "<script>location='$pagename?action=$action'</script>";
  }

  else{
        //update
    $form_data = array('group_name'=>$group_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
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
  $group_name =  $sqledit['group_name'];
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
              <label>Transaction Group <span class="text-error">*</span></label>
              <span class="field"><input type="text" name="group_name" id="group_name" class="input-xxlarge" placeholder="Group Name" value="<?php echo $group_name;?>" autocomplete="off" autofocus/></span>
            </p>

            <center> <p class="stdformbutton">
              <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('group_name');">
                <?php echo $btn_name; ?></button>
                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
              </p> </center>
            </form>
          </div>
          <?php  $chkview = $obj->check_pageview("m_expanse_group.php",$loginid);             
          if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
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
                <th class="head0">Transaction Group</th>  
                <?php  $chkedit = $obj->check_editBtn("m_expanse_group.php",$loginid);              
                if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>   
                <th class="head0">Edit</th><?php } ?>
                <?php  $chkdel = $obj->check_delBtn("m_expanse_group.php",$loginid);             
                if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                <th class="head0">Delete</th><?php } ?>

              </tr>
            </thead>
            <tbody>
           
            <?php
            $slno=1;
            $res = $obj->fetch_record("m_expanse_group order by ex_group_id desc");
            foreach($res as $row_get)

            {

              ?> <tr>
                <td><?php echo $slno++; ?></td> 
                <td><?php echo $row_get['group_name']; ?></td>
                <?php if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                <td><a class='icon-edit' title="Edit" href='m_expanse_group.php?ex_group_id=<?php echo  $row_get['ex_group_id'] ; ?>'></a></td><?php } ?>
                <?php  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                <td>
                  <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['ex_group_id']; ?>);' style='cursor:pointer'></a>
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
