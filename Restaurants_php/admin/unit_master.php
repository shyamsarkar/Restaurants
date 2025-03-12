<?php include("../adminsession.php");
$pagename = "unit_master.php";
$module = "Unit Master";
$submodule = "UNIT MASTER";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "m_unit";
$tblpkey = "unitid";
if (isset($_GET['unitid']))
  $keyvalue = $_GET['unitid'];
else
  $keyvalue = 0;
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$status = "";
$dup = "";
$unit_name = "";
if (isset($_POST['submit'])) {  //print_r($_POST); die;

  $unit_name = $_POST['unit_name'];

  //check Duplicate
  $cwhere = array("unit_name" => $_POST['unit_name']);
  $count = $obj->count_method("m_unit", $cwhere);
  if ($count > 0 && $keyvalue == 0) {
    /*$dup = " Error : Duplicate Record";*/
    $dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
  } else {
    //insert
    if ($keyvalue == 0) {
      $form_data = array('unit_name' => $unit_name, 'enable' => '', 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'lastupdated' => $createdate);
      $obj->insert_record($tblname, $form_data);
      //print_r($form_data); die;
      $action = 1;
      $process = "insert";
      echo "<script>location='$pagename?action=$action'</script>";
    } else {
      //update
      $form_data = array('unit_name' => $unit_name, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate);
      $where = array($tblpkey => $keyvalue);
      $keyvalue = $obj->update_record($tblname, $where, $form_data);
      $action = 2;
      $process = "updated";
    }
    echo "<script>location='$pagename?action=$action'</script>";
  }
}
if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $unit_name =  $sqledit['unit_name'];
  //$status =  $sqledit['status'];
} else {
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
                <label>Unit Name <span class="text-error">*</span></label>
                <span class="field"><input type="text" name="unit_name" id="unit_name" class="input-xxlarge" placeholder="Unit Name" value="<?php echo $unit_name; ?>" autocomplete="off" autofocus /></span>
              </p>

              <center>
                <p class="stdformbutton">
                  <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('unit_name');">
                    <?php echo $btn_name; ?></button>
                  <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                  <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                </p>
              </center>
            </form>
          </div>
          <!-- for print pdf -->
          <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_unit_master.php" class="btn btn-info" target="_blank">
              <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

          <?php $chkview = $obj->check_pageview("unit_master.php", $loginid);
          if ($chkview == 1 || $usertype == 'admin') {  ?>

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
                  <th width="18%" class="head0">Unit Name</th>
                  <?php $chkedit = $obj->check_editBtn("unit_master.php", $loginid);
                  if ($chkedit == 1 || $usertype == 'admin') {  ?>
                    <th width="9%" class="head0">Edit</th> <?php } ?>
                  <?php $chkdel = $obj->check_delBtn("unit_master.php", $loginid);
                  if ($chkdel == 1 || $usertype == 'admin') {  ?>
                    <th width="10%" class="head0">Delete</th><?php } ?>
                </tr>
              </thead>
              <tbody>

                <?php
                $slno = 1;
                $res = $obj->executequery("select * from m_unit order by unitid desc");
                foreach ($res as $row_get) {
                ?>
                  <tr>
                    <td><?php echo $slno++; ?></td>
                    <td><?php echo $row_get['unit_name']; ?></td>
                    <?php if ($chkedit == 1 || $usertype == 'admin') {  ?>
                      <td><a class='icon-edit' title="Edit" href='unit_master.php?unitid=<?php echo $row_get['unitid']; ?>'></a></td><?php } ?>
                    <?php if ($chkdel == 1 || $usertype == 'admin') {  ?>
                      <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['unitid']; ?>);' style='cursor:pointer'></a>
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
    function funDel(id) { //alert(id);   
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
      //alert(module); 
      if (confirm("Are you sure! You want to delete this record.")) {
        jQuery.ajax({
          type: 'POST',
          url: 'ajax/delete_master.php',
          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
          dataType: 'html',
          success: function(data) {
            // alert(data);
            location = '<?php echo $pagename . "?action=3"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close
  </script>
</body>

</html>