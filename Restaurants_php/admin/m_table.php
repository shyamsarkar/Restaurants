<?php include("../adminsession.php");
$pagename = "m_table.php";
$module = "Table Master";
$submodule = "Table MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_table";
$tblpkey = "table_id";
if(isset($_GET['table_id']))
  $keyvalue = $_GET['table_id'];
else
  $keyvalue = 0;
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$parcel_status = 0;
$enable = "";
$dup = "";
$table_no1 = "";
$floor_id = $obj->getvalfield("m_table","floor_id","1=1 order by table_id desc limit 0,1");

if(isset($_POST['submit']))
{	//print_r($_POST); die;
	
  $table_no = $obj->test_input($_POST['table_no']);
  $floor_id = $obj->test_input($_POST['floor_id']);
  $enable = $obj->test_input($_POST['enable']);
  $parcel_type = $obj->test_input($_POST['parcel_type']);

  if(isset($_POST['parcel_status']))
    $parcel_status  = (int)$obj->test_input($_POST['parcel_status']);
  //check Duplicate
  // $cwhere = array("floor_id"=>$_POST['floor_id'],"table_no"=>$_POST['table_no'],"enable"=>$_POST['enable']);
  // //print_r($cwhere);die;

  // $count = $obj->count_method("m_table",$cwhere);
  $count = $obj->getvalfield("m_table","count(*)","floor_id='$floor_id' and table_no='$table_no' and enable='$enable' and table_id!='$keyvalue'");
 // echo $count;die;
  if($count > 0)
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
    $form_data = array('floor_id'=>$floor_id,'table_no'=>$table_no,'enable'=>$enable,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'parcel_status'=>$parcel_status,'parcel_type'=>$parcel_type);
    $obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
    $action=1;
    $process = "insert";
    echo "<script>location='$pagename?action=$action'</script>";
  }

  else{
				//update
    $form_data = array('floor_id'=>$floor_id,'table_no'=>$table_no,'enable'=>$enable,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'parcel_status'=>$parcel_status,'parcel_type'=>$parcel_type);
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
	$floor_id =  $sqledit['floor_id'];
  $table_no1 =  $sqledit['table_no'];
  $enable =  $sqledit['enable'];
  $parcel_status = $sqledit['parcel_status'];
  $parcel_type = $sqledit['parcel_type'];
}

?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
</head>
<body onload="gethide();">
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
              <span class="field"><select name="floor_id" id="floor_id"  class="chzn-select" style="width:543px;">
                <option value="">---Select---</option>
                <?php
                $crow=$obj->executequery("select * from m_floor");
                foreach ($crow as $cres) 
                {

                  ?>
                  <option value="<?php echo $cres['floor_id']; ?>"> <?php echo $cres['floor_name']; ?></option>    
                  <?php
                }

                ?>

              </select>
              <script>document.getElementById('floor_id').value = '<?php echo $floor_id; ?>';</script></span>
            </p>
            <p>
              <label>Table No. <span class="text-error">*</span></label>
              <span class="field"><input type="text" name="table_no" id="table_no" class="input-xxlarge" value="<?php echo $table_no1;?>" autocomplete="off" autofocus/></span>
            </p>

            <p>
                    <label>Parcel Status:</label>
                    <span class="field">
                    <input type="checkbox" onclick="gethide();" name="parcel_status" id="parcel_status" value="1" <?php if($parcel_status == 1){ echo "checked"; } ?>>
                    </span>
                    
                  </p>
           <div id="parcel_hide">
                   <p>
              <label>Parcel Type: <span class="text-error"></span></label>
              <span class="field"><select name="parcel_type" id="parcel_type"  class="chzn-select" style="width:543px;">
                <option value="">---Select---</option>
                <option value="Zomato">Zomato</option>
                <option value="Swiggy">Swiggy</option>
                <option value="Counter_Parcel">Counter Parcel</option>
                

              </select>
              <script>document.getElementById('parcel_type').value = '<?php echo $parcel_type; ?>';</script></span>
            </p>
          </div>
            <div class="lg-12 md-12 sm-12">
              <label>Status</label>
              <span class="field">
                <label><input type="radio" checked name="enable"  value="enable" <?php if($enable == "enable") echo 'checked';?>>&nbsp;&nbsp;Active </label>
                <label><input type="radio" name="enable"  value="disable"  <?php if($enable == "disable") echo 'checked';?>>&nbsp;&nbsp;Inactive</label>
              </span>      
            </div>   
            <center> <p class="stdformbutton">
              <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('floor_id,table_no');">
                <?php echo $btn_name; ?></button>
                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
              </p> </center>
            </form>
          </div>
           <!-- for print pdf -->
              <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_table_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

          <?php  $chkview = $obj->check_pageview("m_table.php",$loginid);             
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
                <th class="head0">Table No.</th>     
                <th class="head0">Status</th>
                 <th class="head0">Parcel_Status</th>  
                 <th class="head0">Parcel_Type</th>  
                <?php  $chkedit = $obj->check_editBtn("m_table.php",$loginid);              
                if($chkedit == 1 || $usertype == 'admin'){  ?>   
                <th class="head0">Edit</th><?php } ?>
                <?php  $chkdel = $obj->check_delBtn("m_table.php",$loginid);             
                if($chkdel == 1 || $usertype == 'admin'){  ?>
                <th class="head0">Delete</th><?php } ?>

              </tr>
            </thead>
            <tbody>
           
            <?php
            $slno=1;
            $res = $obj->fetch_record("m_table order by table_id desc");
            foreach($res as $row_get)

            {
              $floor_id = $row_get['floor_id'];
              $parcel_type = $row_get['parcel_type'];
              $parcel_status = $row_get['parcel_status'];
              $floorname = $obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'"); 
              if($parcel_status==1)
              {
                $parcel_status1 = 'Yes';
              }
              else
              {
                $parcel_status1 = 'No';
              }
              ?> <tr>
                <td><?php echo $slno++; ?></td> 
                <td><?php echo $floorname; ?></td>
                <td><?php echo $row_get['table_no']; ?></td>
                <td><?php $status = $row_get['enable'];
                    if ($status == 'enable') {
                      echo "<span style=color:green;>Enable</span>";
                    }
                    else
                    {
                      echo  "<span style=color:red;>Disable</span>";
                    }
                 ?></td>
                 <td><?php echo $parcel_status1; ?></td>
                 <td><?php echo $parcel_type; ?></td>
                 <?php if($chkedit == 1 || $usertype == 'admin'){  ?>
                <td><a class='icon-edit' title="Edit" href='m_table.php?table_id=<?php echo  $row_get['table_id'] ; ?>'></a></td><?php } ?>
                 <?php  if($chkdel == 1 || $usertype == 'admin'){  ?> 
                <td>
                  <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['table_id']; ?>);' style='cursor:pointer'></a>
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
function gethide()
{
 var parcel_status = document.getElementById('parcel_status').checked;
 if(parcel_status)
 {
  jQuery("#parcel_hide").show();
 }
 else
 {
  jQuery("#parcel_hide").hide();
  //jQuery("#parcel_type").val('');

 }

}

</script>
</body>
</html>
