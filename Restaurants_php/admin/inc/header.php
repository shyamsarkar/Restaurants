<div class="headerpanel">
  <style>
    .showmenu2 {
      display: inline-block;
      height: 35px;
      width: 40px;
      content: url('images/dashboard.png');

      background: #0b4073;
      margin: 7px 0 0 0px;
      -moz-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      -webkit-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
    }

    .showmenu3 {
      display: inline-block;
      height: 35px;
      width: 40px;
      content: url('images/order_entry.png');

      background: #0b4073;
      margin: 7px 0 0 0px;
      -moz-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      -webkit-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
    }

    .showmenu6 {
      display: inline-block;
      height: 35px;
      width: 40px;
      content: url('images/edit_bill.png');

      background: #0b4073;
      margin: 7px 0 0 0px;
      -moz-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      -webkit-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
    }

    .showmenu4 {
      display: inline-block;
      height: 35px;
      width: 40px;
      content: url('images/newitem.png');
      background: #0b4073;
      margin: 7px 0 0 0px;
      -moz-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      -webkit-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
    }

    .showmenu5 {
      display: inline-block;
      height: 35px;
      width: 40px;
      content: url('images/create_table.png');
      background: #0b4073;
      margin: 7px 0 0 0px;
      -moz-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      -webkit-box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
      box-shadow: inset 1px 1px 2px rgba(0, 0, 0, 0.2), 1px 1px 0 rgba(255, 255, 255, 0.2);
    }


    .color1 {
      background: #ff7e5f;
      background: -webkit-linear-gradient(to right, #feb47b, #ff7e5f);
      background: linear-gradient(to right, #feb47b, #ff7e5f);
    }
  </style>
  <a href="#" class="showmenu" id="menues"></a>
  <div class="headerright">
    <div class="dropdown notification">
      <div style="float:left;">
        <a class="dropdown-toggle" data-target="#">
          License End Date: <?php echo $obj->dateformatindia($obj->getvalfield("software_expired", "expired_date", "1=1")); ?>
        </a>
      </div>
      <a class="btn btn-success btn-medium" onClick="jQuery('#myModal_table').modal('show');" data-toggle="modal_table" style="margin-left:15px;">
        <strong>Table Setting</strong>
      </a>
      <a class="btn btn-success btn-medium" onClick="jQuery('#myModal_product').modal('show');" data-toggle="modal_product" style="margin-left:15px;">
        <strong>
          Billing Date: <?php echo $obj->dateformatindia($obj->getvalfield("day_close", "day_date", "1=1")); ?>
        </strong>
      </a>
    </div><!--dropdown-->

    <div class="dropdown userinfo">
      <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="">Hi,<?php echo $obj->getvalfield("user", "username", "userid = '$loginid'"); ?><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="logout.php"><span class="icon-off"></span> Logout</a></li>
      </ul>
    </div><!--dropdown-->

  </div><!--headerright-->

</div><!--headerpanel-->
<div class="breadcrumbwidget">
  <ul class="skins">
    <li class="fixed"><a href="#" class="skin-layout fixed"></a></li>
    <li class="wide"><a href="#" class="skin-layout wide"></a></li>
  </ul><!--skins-->
  <ul class="breadcrumb">
    <li><a href="index.php">Home</a> <span class="divider">/</span></li>
    <li class="active"><?php echo $module; ?></li>
  </ul>
</div><!--breadcrumbwidget-->


<div class="pagetitle">
  <h1 style="width:100%; color: red;">
    <div style="float:left; width:50%;"> <?php echo $submodule; ?> </div>
    <?php
    if ($pagename == "in_entry_new.php") {
    ?>
      <div style="float:right; width:50%; text-align:right;font-size: 12px;">
        Shortcut Keys For: || PRINT KOT:- Shift+k || Save Bill: Shift+s || Payment: Shift+p || Delete Running Bill: Shift+d
        <a id="tot_purchase">
        </a>&nbsp;
      </div>
    <?php
    } ?>
  </h1>
</div><!--pagetitle-->

<!-- Modal -->
<?php $day_date = date('d-m-Y'); ?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModal_product">
  <div class="modal-header alert-info">
    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
    <h3 id="myModalLabel">Day Close</h3>
  </div>
  <div class="modal-body">
    <span style="color:#F00;" id="suppler_model_error"></span>
    <table class="table table-condensed table-bordered">
      <tr>
        <h3 style="color: green;">Do you want to update current date?</h3><br>
        <th colspan="2">Date<span style="color:#F00;"> * </span> </th>

      </tr>
      <tr>
        <td colspan="2"><input type="text" name="day_date" id="day_date" class="input-xlarge" value="<?php echo $day_date; ?>" autofocus autocomplete="off" placeholder='dd-mm-yyyy' data-inputmask="alias:'dd-mm-yyyy'" data-mask style="width:90%;"></td>
      </tr>
    </table>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" name="s_save" id="s_save" onClick="update_date();">UPDATE</button>
    <button data-dismiss="modal" class="btn btn-danger">CLOSE</button>
  </div>
</div>

<div id="myModal_table" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">

  <div class="modal-header color1">

    <button type="button" class="btn-danger" data-dismiss="modal" aria-hidden="true" style="float: right;">×</button>

    <h3 id="myModalLabel">Table Setting</h3>

  </div>

  <div class="modal-body">

    <table class="table table-bordered table-condensed">
      <tbody>
        <tr>
          <th>Table No.:<span style="color: red"></span></th>
          <td><select name="table_id" id="table_id1" class="chzn-select">
              <option value="">--Select--</option>
              <option value="all">For All Table</option>
              <?php
              $row = $obj->executequery("select * from m_table order by table_no asc");
              foreach ($row as $res) {
              ?>
                <option value="<?php echo $res['table_id']; ?>"> <?php echo $res['table_no']; ?></option>
              <?php
              } ?>

            </select></td>
        </tr>

        <tr>
          <th>Captain:<span style="color: red"></span></th>
          <td><select name="waiter_id_cap" id="waiter_id_cap" class="chzn-select">
              <option value="">--Select--</option>
              <?php
              $row = $obj->executequery("select * from m_waiter where job_type = 'captain' order by waiter_name desc");
              foreach ($row as $res) {

              ?>
                <option value="<?php echo $res['waiter_id']; ?>"> <?php echo $res['waiter_name']; ?></option>
              <?php
              }

              ?>

            </select>
            <script>
              document.getElementById('waiter_id_cap').value = '<?php echo $waiter_id_cap; ?>';
            </script>
          </td>
        </tr>
        <tr>
          <th>Waiter:<span style="color: red">*</span></th>
          <td><select name="waiter_id_stw" id="waiter_id_stw" class="chzn-select">
              <option value="">--Select--</option>
              <?php
              $row = $obj->executequery("select * from m_waiter where job_type = 'steward' order by waiter_name desc");
              foreach ($row as $res) {

              ?>
                <option value="<?php echo $res['waiter_id']; ?>"> <?php echo $res['waiter_name']; ?></option>
              <?php
              }
              ?>
            </select>
            <script>
              document.getElementById('waiter_id_stw').value = '<?php echo $waiter_id_stw; ?>';
            </script>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;"><button class="btn btn-primary" onclick="save_table_info();">Save Setting</button></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered table-condensed">
      <thead>
        <th style="text-align: center;">S No</th>
        <th style="text-align: center;">Table No.</th>
        <th style="text-align: center;">Captain</th>
        <th style="text-align: center;">Waiter</th>
      </thead>
      <tbody>
        <?php
        $sno = 1;
        $sql = $obj->executequery("select * from cap_stw_table");
        foreach ($sql as $key) {
          $cap_stw_id = $key['cap_stw_id'];
          $table_id1 = $key['table_id'];
          $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$table_id1'");
          $waiter_id_cap = $key['waiter_id_cap'];
          $waiter_id_stw = $key['waiter_id_stw'];
          $cap_name = $obj->getvalfield("m_waiter", "waiter_name", "waiter_id='$waiter_id_cap' and job_type = 'captain'");
          $stw_name = $obj->getvalfield("m_waiter", "waiter_name", "waiter_id='$waiter_id_stw' and job_type = 'steward'");
        ?>

          <tr>
            <td style="text-align: center;"><?php echo $sno++; ?></td>
            <td style="text-align: center;"><?php echo $table_no; ?></td>
            <td style="text-align: center;"><?php echo $cap_name; ?></td>
            <td style="text-align: center;"><?php echo $stw_name; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
  function save_table_info() {
    var table_id = jQuery('#table_id1').val();
    var waiter_id_cap = jQuery('#waiter_id_cap').val();
    var waiter_id_stw = jQuery('#waiter_id_stw').val();
    if (waiter_id_stw == '') {
      alert("Steward name can not be blank");
      return false;
    } else {
      jQuery.ajax({
        type: 'POST',
        url: 'ajax_add_capstw_infotmation.php',
        data: 'table_id=' + table_id + '&waiter_id_cap=' + waiter_id_cap + '&waiter_id_stw=' + waiter_id_stw,
        dataType: 'html',
        success: function(data) {
          jQuery("#myModal_table").modal('hide');
          location = '<?php echo $pagename; ?>';
        }
      }); //ajax close
    }
  }
  jQuery('#day_date').mask('99-99-9999', {
    placeholder: "dd-mm-yyyy"
  });

  function update_date() {
    var day_date = document.getElementById('day_date').value;
    if (day_date == "") {
      alert("Please Enter Date");
      return false;
    }
    jQuery.ajax({
      type: 'POST',
      url: 'update_date.php',
      data: 'day_date=' + day_date,
      dataType: 'html',
      success: function(data) {
        if (data == 1) {
          alert("Day Closed");
          jQuery("#myModal_product").modal('hide');
          location = '<?php echo $pagename; ?>';
        } else {
          alert("All Bills Are Not Clear");
        }

        jQuery('#day_date').html(data);


      }

    }); //ajax close
  }
</script>