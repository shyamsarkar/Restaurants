<?php include("../adminsession.php");
$pagename = "m_floor.php";
$module = "Floor Master";
$submodule = "FLOOR MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_floor";
$tblpkey = "floor_id";

if(isset($_GET['floor_id']))
  $keyvalue = $_GET['floor_id'];
else
  $keyvalue = 0;
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

$status = "";
$dup = "";
$floor_name = "";
if(isset($_POST['submit']))
{	//print_r($_POST); die;
	
  $floor_name = $obj->test_input($_POST['floor_name']);

    //check Duplicate
  $cwhere = array("floor_name"=>$_POST['floor_name']);
  $count = $obj->count_method("m_floor",$cwhere);
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
    $form_data = array('floor_name'=>$floor_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
    $obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
    $action=1;
    $process = "insert";
    echo "<script>location='$pagename?action=$action'</script>";
  }

  else{
				//update
    $form_data = array('floor_name'=>$floor_name,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
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
	$floor_name =  $sqledit['floor_name'];
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
              <label>Floor Name <span class="text-error">*</span></label>
              <span class="field"><input type="text" name="floor_name" id="floor_name" class="input-xxlarge" onkeyup="" placeholder="Floor Name" value="<?php echo $floor_name;?>" autocomplete="off" autofocus/></span>
            </p>

            <center> <p class="stdformbutton">
              <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('floor_name');">
                <?php echo $btn_name; ?></button>
                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
              </p> </center>
            </form>
          </div>
          <!-- for print pdf -->
            <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_floor_master.php" class="btn btn-info" target="_blank">
                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

          <?php  $chkview = $obj->check_pageview("m_floor.php",$loginid);             
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

                <th class="head0 nosort">S.No.</th>
                <th class="head0">Floor Name</th>  
                <?php  $chkedit = $obj->check_editBtn("m_floor.php",$loginid);              
                if($chkedit == 1 || $usertype == 'admin'){  ?>   
                <th class="head0">Edit</th><?php } ?>
                <?php  $chkdel = $obj->check_delBtn("m_floor.php",$loginid);             
                if($chkdel == 1 || $usertype == 'admin'){  ?>
                <th class="head0">Delete</th><?php } ?>

              </tr>
            </thead>
            <tbody>
           
            <?php
            $slno=1;
            $res = $obj->fetch_record("m_floor order by floor_id desc");
            foreach($res as $row_get)

            {

              ?> <tr>
                <td><?php echo $slno++; ?></td> 
                <td><?php echo $row_get['floor_name']; ?></td>
                <?php if($chkedit == 1 || $usertype == 'admin'){  ?>
                <td><a class='icon-edit' title="Edit" href='m_floor.php?floor_id=<?php echo  $row_get['floor_id'] ; ?>'></a></td><?php } ?>
                <?php  if($chkdel == 1 || $usertype == 'admin'){  ?> 
                <td>
                  <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['floor_id']; ?>);' style='cursor:pointer'></a>
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
