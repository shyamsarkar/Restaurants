<?php include("../adminsession.php");
$pagename = "edit_bill.php";
$module = "Edit Bill";
$submodule = "Edit Bill";
$btn_name = "Save";
$keyvalue = 0;
$tblname = "bills";
$tblpkey = "billid";

if (isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";

/*if(isset($_GET['billid']))
$keyvalue = $_GET['billid'];
else
$keyvalue = 0;*/

$disc_amt = '';
if (isset($_GET['billid'])) {
  $billid = $_GET['billid'];
  $bill_date = $obj->dateformatindia($obj->getvalfield("bills", "billdate", "billid='$billid'"));
  $table_id = $obj->getvalfield("bills", "table_id", "billid='$billid'");
  $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$table_id'");
} else
  $billid = "";

if (isset($_POST['submit'])) {
  //print_r($_POST);die;
  $billid = $obj->test_input($_POST['billid']);
  $food_amt = $obj->test_input($_POST['food_amt']);
  $bev_total = $obj->test_input($_POST['bev_total']);
  if (isset($_POST['disc_amt'])) {
    $disc_amt = $obj->test_input($_POST['disc_amt']);
  }

  $sgst = $obj->getvalfield("tax_setting_new", "sgst", "1=1 and is_applicable='1'");
  $cgst = $obj->getvalfield("tax_setting_new", "cgst", "1=1 and is_applicable='1'");
  $basic_bill_amt = $obj->test_input($_POST['basic_bill_amt']);
  $gst = $sgst + $cgst;
  $final_amt = $basic_bill_amt * $gst / 100;
  $net_bill_amt = round($basic_bill_amt + $final_amt);


  if ($billid > 0) {
    $form_data = array('food_amt' => $food_amt, 'bev_amt' => $bev_total, 'disc_rs' => $disc_amt, 'sgst' => $sgst, 'cgst' => $cgst, 'basic_bill_amt' => $basic_bill_amt, 'net_bill_amt' => $net_bill_amt);
    $where = array('billid' => $billid);
    $obj->update_record($tblname, $where, $form_data);
    $action = 2;
    $process = "updated";
  }

  echo "<script>location='$pagename?action=$action'</script>";

  // echo "<script> window.open('pdf_restaurant_recipt.php?billid=$billid','_blank');  </script>";
}
?>

<!DOCTYPE html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>

</head>

<body onLoad="getrecord('<?php echo $billid; ?>');">

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

          <form action="" method="post" onSubmit="return checkinputmaster('supplier_id,billno,bill_date,bill_type');">

            <div class="row-fluid">
              <table class="table table-condensed table-bordered">

                <tr>

                  <td width="15%"><strong>Bill No : <span style="color:#F00;"> * </span> </strong></td>
                  <?php if ($billid > 0) { ?>
                    <td width="15%"><strong>Bill Date : </strong></td>
                    <td width="15%"><strong>Table No : </strong></td>
                  <?php } ?>

                </tr>
                <tr>
                  <td>
                    <select name="billid" id="billid" class="chzn-select" onchange="getid(this.value);">
                      <option value="">--All--</option>
                      <?php
                      $res = $obj->executequery("select * from bills where is_paid=0");

                      foreach ($res as $row_get) {
                      ?>
                        <option value="<?php echo $row_get['billid'];  ?>"> <?php echo $row_get['billnumber']; ?></option>
                      <?php } ?>
                    </select>
                    <script>
                      document.getElementById('billid').value = '<?php echo $billid; ?>';
                    </script>
                  </td>
                  <?php if ($billid > 0) { ?>
                    <td><input type="text" readonly value="<?php echo $bill_date; ?>"></td>
                    <td><input type="text" readonly value="<?php echo $table_no; ?>"></td>
                  <?php } ?>

                </tr>

              </table>
            </div>
            <br>
            <div>


              <div class="alert alert-success">
                <table width="100%" class="table table-bordered table-condensed">
                  <tr>
                    <th width="15%">PRODUCT</th>
                    <th>UOM</th>
                    <th>RATE</th>
                    <th>QTY</th>
                    <th>Action</th>
                  </tr>
                  <tr>
                    <td>

                      <select name="productid" id="productid" class="chzn-select" style="width:243px;" onChange="getproductdetail(this.value);">
                        <option value="">---Select---</option>
                        <?php
                        $crow = $obj->executequery("select * from m_product order by productid asc");
                        foreach ($crow as $cres) {

                        ?>
                          <option value="<?php echo $cres['productid']; ?>"> <?php echo strtoupper($cres['prodname']); ?></option>
                        <?php
                        }

                        ?>

                      </select>
                      <script>
                        document.getElementById('productid').value = '<?php echo $productid; ?>';
                      </script>
                    </td>

                    <td><input class="input-mini form-control" type="text" name="unit_name" id="unit_name" value="" style="width:90%;" readonly>
                      <input class="input-mini form-control" type="hidden" name="unit_id" id="unit_id" value="" style="width:90%;">
                    </td>

                    <td><input class="input-mini" type="text" name="rate_amt" id="rate_amt" value="" style="width:90%;"></td>
                    <td><input class="input-mini" type="text" name="qty" id="qty" value="" style="width:90%;"></td>

                    <td>
                      <input type="button" class="btn btn-success" onClick="addlist();" style="margin-left:20px;" value="Add Product">
                    </td>
                    <td></td>
                  </tr>

                </table>

              </div>
            </div>

            <div class="row-fluid">
              <div class="span12">
                <h4 class="widgettitle nomargin"> <span style="color:#00F;"> Product Details : <span id="inentryno"> </span>
                  </span></h4>
                <div class="widgetcontent bordered" id="showrecord">
                </div><!--widgetcontent-->
              </div>
              <!--span8-->
            </div>
          </form>

        </div><!--maincontent-->
      </div>
      <!--mainright-->
      <!-- END OF RIGHT PANEL -->




    </div><!--mainwrapper-->
    <div class="clearfix"></div>
    <?php include("inc/footer.php"); ?>


    <div class="modal fade" id="myModal" role="dialog" aria-hidden="true" style="display:none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Product</h4>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-condensed">
              <tr>
                <th width="18%">Product Name &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">Unit &nbsp;<span style="color:#F00;">*</span></th>
              </tr>
              <tr>
                <td>
                  <input class="form-control" name="mproduct_name" id="mproduct_name" value="" autofocus="" type="text" readonly style="z-index:-44;">
                  <input type="hidden" name="mproductid" id="mproductid" readonly>
                </td>
                <td>
                  <input class="form-control" name="munit_name" id="munit_name" autocomplete="off" autofocus="" type="text" placeholder="Enter Unit" readonly>
                </td>
              </tr>

              <tr>
                <th>Qty &nbsp;<span style="color:#F00;">*</span></th>
                <th width="18%">Rate &nbsp;<span style="color:#F00;">*</span></th>
              </tr>
              <tr>
                <td>
                  <input class="form-control" name="mqty" id="mqty" value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Quantity">
                </td>
                <td>
                  <input class="form-control" name="mrate_amt" id="mrate_amt" value="" autocomplete="off" autofocus="" type="text" placeholder="Enter Rate">
                </td>
              </tr>

            </table>
          </div>
          <div class="modal-footer clearfix">
            <input type="hidden" id="m_billdetailid" value="0">
            <input type="submit" class="btn btn-primary" name="submit" value="Add" onClick="updatelist();" id="saveitem">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->

    </div>

    <script>
      function getid(billid) {
        location = 'edit_bill.php?billid=' + billid;
      }
    </script>
    <script>
      // jQuery(document).ready(function(){

      //  jQuery('#menues').click();

      //  });


      function getrecord(billid) {
        // var emp_id=jQuery("#emp_id").val();

        jQuery.ajax({
          type: 'POST',
          url: 'show_billeditproduct.php',
          data: "billid=" + billid,
          dataType: 'html',
          success: function(data) {
            //alert(data);
            jQuery('#showrecord').html(data);


          }

        }); //ajax close

      }

      function getproductdetail(productid) {

        //alert(productid);
        if (!isNaN(productid)) {
          jQuery.ajax({
            type: 'POST',
            url: 'ajaxgetproductdetail_finishgood.php',
            data: 'productid=' + productid,
            dataType: 'html',
            success: function(data) {
              //alert(data);

              arr = data.split('|');
              unit_id = arr[0].trim();
              unit_name = arr[1].trim();
              rate_amt = arr[2].trim();
              jQuery('#unit_id').val(unit_id);
              jQuery('#unit_name').val(unit_name);
              jQuery('#rate_amt').val(rate_amt);
              jQuery('#rate_amt').focus();
            }

          }); //ajax close
        }
      }

      function addlist() {

        var productid = document.getElementById('productid').value;
        var unit_name = document.getElementById('unit_name').value;
        var unit_id = document.getElementById('unit_id').value;
        var qty = document.getElementById('qty').value;
        var rate_amt = document.getElementById('rate_amt').value;
        var billid = '<?php echo $billid; ?>';
        var billdetailid = 0;

        if (productid == '') {
          alert('Product cant be blank');
          return false;
        }
        if (qty == '') {
          alert('Quantity Cant be blank');
          return false;
        } else {

          jQuery.ajax({
            type: 'POST',
            url: 'save_billproduct.php',
            data: 'productid=' + productid + '&unit_id=' + unit_id + '&qty=' + qty + '&rate_amt=' + rate_amt + '&billid=' + billid + '&billdetailid=' + billdetailid,
            dataType: 'html',
            success: function(data) {
              //alert(data);    

              jQuery('#productid').val('');
              jQuery('#rate_amt').val('');
              jQuery('#qty').val('');
              jQuery('#unit_name').val('');
              getrecord('<?php echo $billid ?>');

              jQuery("#productid").val('').trigger("liszt:updated");
              document.getElementById('product_id').focus();
              jQuery(".chzn-single").focus();
            }

          }); //ajax close
        }
      }


      function updaterecord(product_name, productid, unit_name, qty, rate_amt, billdetailid) {

        jQuery("#myModal").modal('show');
        jQuery("#saveitem").attr('value', 'Update');
        jQuery("#mproduct_name").val(product_name);
        jQuery("#mproductid").val(productid);
        jQuery("#munit_name").val(unit_name);
        jQuery("#mqty").val(qty);
        jQuery("#mrate_amt").val(rate_amt);
        jQuery("#m_billdetailid").val(billdetailid);
        jQuery("#qty").focus();

      }

      function updatelist() {

        var productid = document.getElementById('mproductid').value;
        var unit_name = document.getElementById('munit_name').value;
        var qty = document.getElementById('mqty').value;
        var rate_amt = document.getElementById('mrate_amt').value;
        var billdetailid = document.getElementById('m_billdetailid').value;
        var billid = '<?php echo $billid; ?>';



        if (qty == '') {
          alert('Quantity cant be blank');
          return false;
        }
        if (rate_amt == '') {
          alert('Rate Cant be blank');
          return false;
        } else {

          jQuery.ajax({
            type: 'POST',
            url: 'save_billproduct.php',
            data: 'productid=' + productid + '&unit_name=' + unit_name + '&qty=' + qty + '&rate_amt=' + rate_amt + '&billdetailid=' + billdetailid + '&billid=' + billid,
            dataType: 'html',
            success: function(data) {
              //alert(data);

              //setTotalrate();
              jQuery('#mproductid').val('');
              jQuery('#mrate_amt').val('');
              jQuery('#munit_name').val('');
              jQuery('#mqty').val('');
              jQuery('#billdetailid').val('');
              jQuery("#myModal").modal('hide');
              getrecord(<?php echo $billid ?>);

            }

          }); //ajax close
        }
      }
      /*function add()
      {   
          //jQuery("#new").toggle(); 
          jQuery("#list").toggle();
          jQuery("#new2").toggle();
          var button_name=jQuery("#addnew").val();
          
          if(button_name =="Show List")
          {
            jQuery("#addnew").val("+ Add New");
          }
          else
          {
            jQuery("#addnew").val("Show List");
          }
      } */


      function deleterecord(billdetailid) {

        tblname = 'bill_details';
        tblpkey = 'billdetailid';
        pagename = '<?php echo $pagename; ?>';
        submodule = '<?php echo $submodule; ?>';
        module = '<?php echo $module; ?>';
        if (confirm("Are you sure! You want to delete this record.")) {
          jQuery.ajax({
            type: 'POST',
            url: 'ajax/delete_master.php',
            data: 'id=' + billdetailid + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
            dataType: 'html',
            success: function(data) {
              //alert(data);
              getrecord('<?php echo $billid; ?>');

            }

          }); //ajax close
        } //confirm close

      }
      <?php
      if (isset($_GET['search'])) {
      ?>
        jQuery(document).ready(function() {
          jQuery("#new2").hide();
          jQuery("#list").show();

        });
      <?php
      }
      ?>
    </script>
</body>

</html>