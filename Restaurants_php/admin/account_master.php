<?php include("../adminsession.php");
$pagename = "account_master.php";
$module = "Account Master";
$submodule = "ACCOUNT MASTER";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "m_account";
$tblpkey = "bank_id";

if (isset($_GET['bank_id']))
  $keyvalue = $_GET['bank_id'];
else
  $keyvalue = 0;
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$status = "0";
$dup = "";
$bank_name = "";
$account_no = "";
$ifsc_code = "";
$bank_address = "";

if (isset($_POST['submit'])) {
  //print_r($_POST); die;

  $bank_name = $obj->test($_POST['bank_name']);
  $account_no = $obj->test($_POST['account_no']);
  $ifsc_code = $obj->test($_POST['ifsc_code']);
  $bank_address = $obj->test($_POST['bank_address']);

  //check Duplicate

  $count = $obj->getvalfield("m_account", "count(*)", "bank_name='$bank_name' and account_no='$account_no' and bank_id!='$keyvalue'");
  if ($count > 0) {

    $dup = "<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
  } else {
    //insert
    if ($keyvalue == 0) {
      $form_data = array('bank_name' => $bank_name, 'account_no' => $account_no, 'ifsc_code' => $ifsc_code, 'bank_address' => $bank_address, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate);
      $obj->insert_record($tblname, $form_data);
      $action = 1;
      $process = "insert";
      echo "<script>location='$pagename?action=$action'</script>";
    } else {
      //update
      $form_data = array('bank_name' => $bank_name, 'account_no' => $account_no, 'ifsc_code' => $ifsc_code, 'bank_address' => $bank_address, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate);
      $where = array($tblpkey => $keyvalue);
      $obj->update_record($tblname, $where, $form_data);
      $action = 2;
      $process = "update";
    }
    echo "<script>location='$pagename?action=$action'</script>";
  }
}
if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $bank_name =  $sqledit['bank_name'];
  $account_no =  $sqledit['account_no'];
  $ifsc_code =  $sqledit['ifsc_code'];
  $bank_address =  $sqledit['bank_address'];
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
              <?php echo  $dup;  ?>
              <div class="lg-12 md-12 sm-12">
                <table class="table table-bordered">
                  <tr>
                    <th>Bank Name <span style="color:#F00;">*</span></th>
                    <th>Account Number <span style="color:#F00;">*</span></th>
                    <th>IFSC Code <span style="color:#F00;">*</span></th>

                  </tr>
                  <tr>
                    <td> <input type="text" name="bank_name" id="bank_name" class="input-xlarge" value="<?php echo $bank_name; ?>" autofocus autocomplete="off" placeholder="Enter Bank Name" /></td>

                    <td> <input type="text" name="account_no" id="account_no" class="input-xlarge" maxlength="18" value="<?php echo $account_no; ?>" autofocus autocomplete="off" placeholder="Enter Account Number" /></td>

                    <td> <input type="text" name="ifsc_code" id="ifsc_code" class="input-xlarge" maxlength="11" value="<?php echo $ifsc_code; ?>" autofocus autocomplete="off" placeholder="Enter IFSC Code" /></td>

                  </tr>
                  <tr>
                    <th colspan="3">Bank Details / Address <span style="color:#F00;">*</span></th>


                  </tr>
                  <tr>
                    <td> <input type="text" name="bank_address" id="bank_address" class="input-xlarge" value="<?php echo $bank_address; ?>" autofocus autocomplete="off" placeholder="Enter Bank Details / Address" /></td>

                    <td colspan="3"> <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('bank_name,account_no,ifsc_code,bank_address'); ">
                        <?php echo $btn_name; ?></button>
                      <a href="account_master.php" name="reset" id="reset" class="btn btn-success">Reset</a>
                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </td>
                  </tr>

                </table>
              </div>
            </form>
          </div>


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
                <th width="18%" class="head0">Bank Name</th>
                <th width="18%" class="head0">Account Number</th>
                <th width="15%" class="head0">IFSC Code</th>
                <th width="15%" class="head0">Bank Details / Address</th>

                <?php $chkedit = $obj->check_editBtn("account_master.php", $loginid);

                if ($chkedit == 1 || $loginid == 1) {  ?>
                  <th width="9%" class="head0">Edit</th>
                <?php  }
                $chkdel = $obj->check_delBtn("account_master.php", $loginid);

                if ($chkdel == 1 || $loginid == 1) {  ?>
                  <th width="10%" class="head0">Delete</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>

              <?php
              $slno = 1;

              $res = $obj->executequery("select * from m_account order by bank_id desc");
              foreach ($res as $row_get) {


              ?>
                <tr>
                  <td><?php echo $slno++; ?></td>
                  <td><?php echo $row_get['bank_name']; ?></td>
                  <td><?php echo $row_get['account_no']; ?></td>
                  <td><?php echo $row_get['ifsc_code']; ?></td>
                  <td><?php echo $row_get['bank_address']; ?></td>
                  <?php

                  if ($chkedit == 1 || $loginid == 1) {  ?>
                    <td><a class='icon-edit' title="Edit" href='account_master.php?bank_id=<?php echo $row_get['bank_id']; ?>'></a></td>
                  <?php  }
                  if ($chkdel == 1 || $loginid == 1) {  ?>
                    <td>
                      <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['bank_id']; ?>);' style='cursor:pointer'></a>
                    </td>
                  <?php } ?>
                </tr>

              <?php
              }
              ?>
            </tbody>
          </table>


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
    function funDel(id) {
      //alert(id);   
      var tblname = '<?php echo $tblname; ?>';
      var tblpkey = '<?php echo $tblpkey; ?>';
      var pagename = '<?php echo $pagename; ?>';
      var submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';

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