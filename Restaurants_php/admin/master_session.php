<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "master_session.php";
$module = "Master";
$submodule = "SESSION MASTER";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "m_session";
$tblpkey = "sessionid";
if (isset($_GET['sessionid']))
  $keyvalue = $_GET['sessionid'];
else
  $keyvalue = 0;
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$dup = "";
$fromdate = $todate = $session_name = "";
if (isset($_GET['st'])) {
  $st = $_GET['st'];
  $s = $_GET['status'];
  if ($s != '') {
    $where = array('status' => 1);
    $myArray = array("status" => 0);
    $obj->update_record($tblname, $where, $myArray);
    echo "<script>location='$pagename'</script>";
    $where = array($tblpkey => $st);
    $myArray = array("status" => 1);
    $obj->update_record($tblname, $where, $myArray);
    echo "<script>location='$pagename'</script>";
  }
}
if (isset($_POST['submit'])) {
  $keyvalue = $_POST['sessionid'];
  $fromdate =  $obj->dateformatusa($_POST['fromdate']);
  $todate  =  $obj->dateformatusa($_POST['todate']);
  $session_name =  $_POST['session_name'];
  //check Duplicate
  $cwhere = array("session_name" => $_POST['session_name']);
  $count = $obj->count_method("m_session", $cwhere);
  //print_r($count);
  if ($count > 0 && $keyvalue == 0) {
    $dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Duplicate Record.
			</div>";
    //echo $dup; die;
  } else //insert
  {
    if ($keyvalue == 0) {
      $form_data = array('fromdate' => $fromdate, 'todate' => $todate, 'session_name' => $session_name, 'ipaddress' => $ipaddress, 'createdate' => $createdate, 'createdby' => $loginid);
      $obj->insert_record($tblname, $form_data);

      $action = 1;
      $process = "insert";
    } else {
      //update
      $form_data = array('fromdate' => $fromdate, 'todate' => $todate, 'session_name' => $session_name, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate);
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
  $fromdate = $sqledit['fromdate'];
  $todate = $sqledit['todate'];
  $session_name = $sqledit['session_name'];
} else {
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
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
              <div class="lg-12 md-12 sm-12">
                <table id="mytable01" align="center" class="table table-bordered table-condensed">
                  <tr>
                    <th>From Date<span style="color:#F00;"> * </span></th>
                    <th>To Date<span style="color:#F00;"> * </span></th>
                    <th>Session<span style="color:#F00;"> * </span></th>
                    <th>&nbsp;</th>
                  </tr>
                  <tr>
                    <td><input type="text" name="fromdate" id="fromdate" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>

                    <td><input type="text" name="todate" id="todate" class="input-medium" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($todate); ?>" data-inputmask="alias:'dd-mm-yyyy'" data-mask /> </td>
                    <td><input type="text" name="session_name" id="session_name" class="input-medium" value="<?php echo $session_name; ?>"></td>
                    <td> <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('fromdate,todate,session_name'); ">
                        <?php echo $btn_name; ?></button>
                      <a href="master_session.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                    </td>
                  </tr>
                </table>
              </div>
              <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">

            </form>
          </div>

          <?php $chkview = $obj->check_pageview("master_session.php", $loginid);
          if ($chkview == 1 || $usertype == 'admin') {  ?>


            <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
            <table class="table table-bordered" id="dyntable">
              <colgroup>
                <col class="con0" style="text-align: center; width: 4%" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
              </colgroup>
              <thead>
                <tr>

                  <th width="6%" class="head0 nosort">S.No.</th>
                  <th width="18%" class="head0">From Date</th>
                  <th width="18%" class="head0">To Date</th>
                  <th width="20%" class="head0">Session Name</th>
                  <th width="18%" class="head0">Status</th>
                  <?php $chkedit = $obj->check_editBtn("master_session.php", $loginid);
                  if ($chkedit == 1 || $usertype == 'admin') {  ?>
                    <th width="9%" class="head0">Edit</th><?php } ?>
                  <?php $chkdel = $obj->check_delBtn("master_session.php", $loginid);
                  if ($chkdel == 1 || $usertype == 'admin') {  ?>
                    <th width="10%" class="head0">Delete</th><?php } ?>
                </tr>
                </tr>
              </thead>
              <tbody>

                <?php
                $slno = 1;

                $res = $obj->executequery("select * from m_session order by sessionid desc");
                foreach ($res as $row_get) {
                ?> <tr>
                    <td><?php echo $slno++; ?></td>
                    <td><?php echo $obj->dateformatindia($row_get['fromdate']); ?></td>
                    <td><?php echo $obj->dateformatindia($row_get['todate']); ?></td>
                    <td><?php echo $row_get['session_name']; ?></td>
                    <td align="center">
                      <small class="badge pull-right bg-<?php if ($row_get['status'] == 1) echo 'green';
                                                        else echo 'red'; ?>" style="cursor:pointer;" onClick="return change_status('<?php echo $row_get['sessionid']; ?>','<?php echo $row_get['status']; ?>');">&nbsp;</small>
                      <?php if ($row_get['status'] == 1) echo "<span style='color:green'> Active </span> ";
                      else echo "<span style='color:Red'>In-Active </span> "; ?>
                    </td>

                    <?php if ($chkedit == 1 || $usertype == 'admin') {  ?>
                      <td width="12%" style="text-align:center;"><a class='icon-edit' title="Edit" href='master_session.php?sessionid=<?php echo $row_get['sessionid']; ?>'></a></td>
                    <?php } ?>
                    <?php if ($chkdel == 1 || $usertype == 'admin') {  ?>

                      <td width="8%" style="text-align:center;">
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo  $row_get['sessionid']; ?>);' style='cursor:pointer'></a>
                      </td><?php }
                        } ?>
                  </tr>
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
            //alert(data);
            location = '<?php echo $pagename . "?action=3"; ?>';
          }

        }); //ajax close
      } //confirm close
    } //fun close

    function change_status(st, status) {
      if (st != "") {
        if (confirm("Are you sure! You want to active this session.")) {
          location = '<?php echo $pagename; ?>?st=' + st + '&status=' + status;
        }

      }
    }
    jQuery('#fromdate').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#todate').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#fromdate').focus();
  </script>
</body>

</html>