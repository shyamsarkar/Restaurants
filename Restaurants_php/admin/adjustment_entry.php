<?php include("../adminsession.php");
$pagename = "adjustment_entry.php";
$module = "Adjustment Entry";
$submodule = "ADJUSTMENT ENTRY";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "adjustment_entry";
$tblpkey = "adjustment_id";
if (isset($_GET['adjustment_id']))
  $keyvalue = $_GET['adjustment_id'];
else
  $keyvalue = 0;
if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$status = "";
$dup = "";
$count = "";
$adjustment_qty = $unit_name = $productid = $remark = $type = "";

if (isset($_POST['submit'])) { //print_r($_POST); die;

  $productid = $obj->test($_POST['productid']);
  $adjustment_qty = $obj->test($_POST['adjustment_qty']);
  $unit_name = $obj->test($_POST['unit_name']);
  $remark = $obj->test($_POST['remark']);
  $adjustment_date = $obj->dateformatusa($_POST['adjustment_date']);
  $type = $obj->test($_POST['type']);

  //insert
  if ($keyvalue == 0) {
    $form_data = array('productid' => $productid, 'adjustment_qty' => $adjustment_qty, 'unit_name' => $unit_name, 'adjustment_date' => $adjustment_date, 'remark' => $remark, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'createdate' => $createdate, 'type' => $type);
    $obj->insert_record($tblname, $form_data);
    // print_r($form_data); die;
    $action = 1;
    $process = "insert";
    echo "<script>location='$pagename?action=$action'</script>";
  } else {
    //update
    $form_data = array('productid' => $productid, 'adjustment_qty' => $adjustment_qty, 'unit_name' => $unit_name, 'adjustment_date' => $adjustment_date, 'remark' => $remark, 'ipaddress' => $ipaddress, 'createdby' => $loginid, 'lastupdated' => $createdate, 'type' => $type);
    $where = array($tblpkey => $keyvalue);
    $keyvalue = $obj->update_record($tblname, $where, $form_data);
    $action = 2;
    $process = "updated";
  }
  echo "<script>location='$pagename?action=$action'</script>";
}
if (isset($_GET[$tblpkey])) {

  $btn_name = "Update";
  $where = array($tblpkey => $keyvalue);
  $sqledit = $obj->select_record($tblname, $where);
  $productid = $sqledit['productid'];
  $unit_name = $sqledit['unit_name'];
  $adjustment_qty = $sqledit['adjustment_qty'];
  $adjustment_date = $sqledit['adjustment_date'];
  $remark = $sqledit['remark'];
  $type = $sqledit['type'];
} else {
  $adjustment_date = date('Y-m-d');
  $productid = $obj->getvalfield("adjustment_entry", "productid", "1=1 order by adjustment_id desc limit 0,1");
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
                <label>Menu Item Name <span class="text-error">*</span></label>
                <span class="field"><select name="productid" id="productid" class="chzn-select" style="width:543px;" onchange="getunit_name(this.value);">
                    <option value="">--Select--</option>
                    <?php
                    $row = $obj->executequery("select * from m_product order by prodname desc");
                    foreach ($row as $res) {

                      $pcatid = $res['pcatid'];
                      $catname = $obj->getvalfield("m_product_category", "catname", "pcatid='$pcatid'");

                    ?>
                      <option value="<?php echo $res['productid']; ?>"> <?php echo $res['prodname'] . " / " . $catname; ?></option>
                    <?php
                    }

                    ?>

                  </select>
                  <script>
                    document.getElementById('productid').value = '<?php echo $productid; ?>';
                  </script>
                </span>
              </p>
              <p>
                <label>Unit Name:<span class="text-error">*</span></label>
                <span class="field"><input type="text" name="unit_name" placeholder="Unit Name" id="unit_name" autocomplete="off" class="input-xxlarge" readonly="true" value="<?php echo $unit_name; ?>" autofocus /></span>
              </p>
              <p>
                <label>Adjustment Qty:<span class="text-error">*</span></label>
                <span class="field"><input type="text" name="adjustment_qty" placeholder="Enter Adjustment Quantity" id="adjustment_qty" autocomplete="off" class="input-xxlarge" value="<?php echo $adjustment_qty; ?>" autofocus onkeypress='validate(event)' /></span>
              </p>
              <p>
                <label>Adjustment Date:<span class="text-error">*</span></label>
                <span class="field"><input type="text" name="adjustment_date" id="adjustment_date" class="input-xxlarge" placeholder='dd-mm-yyyy' value="<?php echo $obj->dateformatindia($adjustment_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></span>
              </p>

              <p>
                <label>Type <span class="text-error">*</span></label>
                <span class="field"><select name="type" id="type" class="chzn-select" style="width:543px;">
                    <option value="">--Select--</option>
                    <option value="minus">Minus</option>
                    <option value="plus">Plus</option>
                  </select>
                  <script>
                    document.getElementById('type').value = '<?php echo $type; ?>';
                  </script>
                </span>
              </p>

              <p>
                <label>Remark:</label>
                <span class="field"><input type="text" name="remark" placeholder="Enter Remark" id="remark" autocomplete="off" class="input-xxlarge" value="<?php echo $remark; ?>" autofocus /></span>
              </p>

              <center>
                <p class="stdformbutton">
                  <button type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('productid,unit_name,adjustment_qty,adjustment_date,type');">
                    <?php echo $btn_name; ?></button>
                  <a href="<?php echo $pagename; ?>" name="reset" id="reset" class="btn btn-success">Reset</a>
                  <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                </p>
              </center>
            </form>
          </div>
          <!-- for print pdf -->
          <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_adjustment_entry.php" class="btn btn-info" target="_blank">
              <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

          <?php $chkview = $obj->check_pageview("adjustment_entry.php", $loginid);
          if ($chkview == 1 || $loginid == 1) {  ?>

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

                  <th class="head0 nosort">Sno.</th>
                  <th class="head0">Menu Item Name</th>
                  <th class="head0">Unit Name</th>
                  <th class="head0">Quantity</th>
                  <th class="head0">Date</th>
                  <th class="head0">Type</th>
                  <th class="head0">Remark</th>


                  <?php $chkedit = $obj->check_editBtn("adjustment_entry.php", $loginid);
                  if ($chkedit == 1 || $loginid == 1) {  ?>
                    <th class="head0" style="text-align: center;">Edit</th> <?php } ?>
                  <?php $chkdel = $obj->check_delBtn("adjustment_entry.php", $loginid);
                  if ($chkdel == 1 || $loginid == 1) {  ?>
                    <th class="head0" style="text-align: center;">Delete</th><?php } ?>
                </tr>
              </thead>
              <tbody>

                <?php
                $slno = 1;

                $res = $obj->executequery("select * from adjustment_entry order by adjustment_id desc");
                foreach ($res as $row_get) {
                  $productid = $row_get['productid'];
                  $product_name = $obj->getvalfield("m_product", "prodname", "productid='$productid'");

                ?>
                  <tr>
                    <td><?php echo $slno++; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $row_get['unit_name']; ?></td>
                    <td><?php echo $row_get['adjustment_qty']; ?></td>
                    <td><?php echo $row_get['type']; ?></td>
                    <td><?php echo $obj->dateformatindia($row_get['adjustment_date']); ?></td>
                    <td><?php echo $row_get['remark']; ?></td>


                    <?php if ($chkedit == 1 || $loginid == 1) {  ?>
                      <td style="text-align: center;"><a class='icon-edit' title="Edit" href='adjustment_entry.php?adjustment_id=<?php echo $row_get['adjustment_id']; ?>'></a></td><?php } ?>
                    <?php if ($chkdel == 1 || $loginid == 1) {  ?>
                      <td style="text-align: center;">
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['adjustment_id']; ?>);' style='cursor:pointer'></a>
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


    jQuery('#adjustment_date').mask('99-99-9999', {
      placeholder: "dd-mm-yyyy"
    });
    jQuery('#adjustment_date').focus();

    function getunit_name(productid) {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax_unitname.php',
        data: 'productid=' + productid,
        dataType: 'html',
        success: function(data) {
          // alert(data);
          jQuery('#unit_name').val(data);
        }

      }); //ajax close
    }

    function validate(evt) {
      var theEvent = evt || window.event;

      // Handle paste
      if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
      } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
      }
      var regex = /[0-9]|\./;
      if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
      }
    }
  </script>
</body>

</html>