<?php include("../adminsession.php");
//print_r($_SESSION);

$pagename = "customer_master.php";
$module = "Bill Entry";
$submodule = "Bill Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "bill_details";
$tblpkey = "billdetailid";


$paydate = $obj->getvalfield("day_close","day_date","1=1");

if(isset($_GET['floor_id']))
{
	
$floor_id = $_GET['floor_id'];
$floor_name = $obj->getvalfield("m_floor","UPPER(floor_name)","floor_id='$floor_id'");
}
else
$floor_id = "";

if(isset($_GET['table_id']))
{
$table_id = $_GET['table_id'];
$table_no = $obj->getvalfield("m_table","UPPER(table_no)","table_id='$table_id'");

$billid = $obj->getvalfield("bills","billid","table_id='$table_id' and is_paid = 0");
  if($billid == "")
  $billid = 0;
}
else
$table_id = "";

// if(isset($_GET['table_id']))
// $table_id_search = addslashes(trim($_GET['table_id']));
// else
// $table_id_search = "";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$duplicate = "";

$paymode1 = "cash";
$paymode2 = "card_mode"; 
$paymode3 = "paytm";
?>
<!DOCTYPE html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("inc/top_files.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      div.scrollmenu {
        overflow: auto;
        white-space: nowrap;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        padding:5px;
      }
      div.scrollmenu button {
        display: inline-block;
      }
      .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        padding: 10px;
        min-height: 635px;
      }
      hr.rounded {
        border-top: 3px solid #bbb;
        margin: 5px 0 10px !important;
        width: 50%;
      }
      hr.solid {
        border-top: 1px solid #ddd;
        margin: 6px 0px;
      }
      .adjust{
        margin: 5px 0px;
      }
      .autooverflow{
        height:500px;overflow:auto;
      }
      .control{
        min-height: 22px !important;
      }
      h5{
        font-family:'sans-serif';
      }
      .net-amount{
        background-color: blanchedalmond;
        text-align: right;
        font-weight: 800;
        font-size:13px;
      }
      .mr-b{
        margin-bottom:10px;
      }
      .table-condensed td {
          padding: 4px 0px;
      }
    </style>
  </head>
<!-- onload="show_product_data();" -->
  <body onLoad="getrecord();show_product_data();get_notification();">
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
            <div class="nopadding">
              <div class="container-fluid">
                <div class="row-fluid">
                  <!-- MENU LIST -->
                  <div class="scrollmenu">
                    <div class="btn-group" data-toggle="buttons-radio">
                      <button type="menu" class="btn btn-success">Show all</button>
                      <button type="menu" class="btn btn-success">BURGER</button>
                      <button type="menu" class="btn btn-success">CHINESE</button>
                      <button type="menu" class="btn btn-success">PIZZA</button>
                      <button type="menu" class="btn btn-success">SANDWICH</button>
                      <button type="menu" class="btn btn-success">TEA AND COFFE</button>
                      <button type="menu" class="btn btn-success">PASTA</button>
                      <button type="menu" class="btn btn-success">MOCKTAILS</button>
                      <button type="menu" class="btn btn-success">SHOOOTERS</button>
                      <button type="menu" class="btn btn-success">BURGER</button>
                      <button type="menu" class="btn btn-success">CHINESE</button>
                      <button type="menu" class="btn btn-success">PIZZA</button>
                      <button type="menu" class="btn btn-success">SANDWICH</button>
                      <button type="menu" class="btn btn-success">TEA AND COFFE</button>
                      <button type="menu" class="btn btn-success">PASTA</button>
                      <button type="menu" class="btn btn-success">MOCKTAILS</button>
                      <button type="menu" class="btn btn-success">SHOOOTERS</button>
                      <button type="menu" class="btn btn-success">BURGER</button>
                      <button type="menu" class="btn btn-success">CHINESE</button>
                      <button type="menu" class="btn btn-success">PIZZA</button>
                      <button type="menu" class="btn btn-success">SANDWICH</button>
                      <button type="menu" class="btn btn-success">TEA AND COFFE</button>
                      <button type="menu" class="btn btn-success">PASTA</button>
                      <button type="menu" class="btn btn-success">MOCKTAILS</button>
                      <button type="menu" class="btn btn-success">SHOOOTERS</button>
                    </div>
                  </div>
                  <!-- MENU LIST -->
                </div>
                <hr class="solid">
                <div class="row-fluid">
                  <!-- FIRST SECTION -->
                  <div class="span3">
                    <div class="card">
                      <h5>Select Table/Floor</h5>
                      <select name="" id="" class="chzn-select">
                        <option value="">Select</option>
                      </select>
                      <hr class="solid">
                      <div class="row-fluid">
                        <div class="span6">
                          <h5>Release Table</h5>
                          <hr class="rounded">
                        </div>
                        <div class="span6">
                          <h5>Reserved Table</h5>
                          <hr class="rounded">
                        </div>
                      </div>
                      <div class="autooverflow">
                        <div class="row-fluid">
                          <div class="span6">
                            <button type="button" class="btn btn-success btn-block">H-1</button>
                            <button type="button" class="btn btn-success btn-block">H-2</button>
                            <button type="button" class="btn btn-success btn-block">H-3</button>
                            <button type="button" class="btn btn-success btn-block">G-1</button>
                            <button type="button" class="btn btn-success btn-block">G-2</button>
                            <button type="button" class="btn btn-success btn-block">G-3</button>
                            <button type="button" class="btn btn-success btn-block">H-1</button>
                            <button type="button" class="btn btn-success btn-block">H-2</button>
                            <button type="button" class="btn btn-success btn-block">H-3</button>
                            <button type="button" class="btn btn-success btn-block">G-1</button>
                            <button type="button" class="btn btn-success btn-block">H-1</button>
                            <button type="button" class="btn btn-success btn-block">H-2</button>
                            <button type="button" class="btn btn-success btn-block">H-3</button>
                           
                          </div>
                          <div class="span6">
                            <button type="button" class="btn btn-danger btn-block">H1</button>
                            <button type="button" class="btn btn-danger btn-block">H1</button>
                            <button type="button" class="btn btn-danger btn-block">H1</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- SECOND SECTION -->
                  <div class="span5">
                    <div class="card">
                      <h5>Search Menu-Item</h5>
                      <div class="control-group" style="margin-bottom: 5px;">
                        <div class="controls">
                          <div class="input-prepend">
                            <span class="add-on" style="padding: 4px 5px;"><i class="icon-search"></i></span>
                            <input  class="search-query" id="myInput" type="text">
                          </div>
                        </div>
                      </div>
                      <hr class="solid">
                      <!-- ITERM LIST  -->
                      <div class="row-fluid">
                        <div class="span2">
                          <h5>Item List</h5>
                          <hr class="rounded">
                        </div>
                      </div>
                      <div class="autooverflow">
                        <table class="table table-condensed table-hover" id="myTable">
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>BURGER</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" data-toggle="modal" data-target="#myModal" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                          <tr>
                            <td><button type="button" class="btn btn-danger btn-block adjust">200</button></td>
                            <td>
                              <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
                            </td>
                            <td>
                              <h6>CHINESE</h6>
                              <span><i class="fa fa-inr"></i> 120/- pcs</span>
                            </td>
                            <td>
                              <button type="button" class="btn btn-inverse adjust" style="float: right;">Add Item</button>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- THIRD SECTION -->
                  <div class="span4">
                    <div class="card">
                      <h5>Table</h5>
                      <select name="" id="" class="chzn-select">
                        <option value="">Parsal</option>
                        <option value="">H1</option>
                        <option value="">H2</option>
                      </select>
                      <hr class="solid">
                      <div class="row-fluid">
                        <div class="span8">
                          <h5>Product</h5>
                          <hr class="rounded" style="width:16%;">
                        </div>
                        <div class="span4">
                          <h5>Total</h5>
                          <hr class="rounded" style="width:16%;">
                        </div>
                      </div>
                      <div style="min-height:300px;overflow: auto;max-height: 300px;">
                      <table class="table table-condensed table-hover">
                        <tbody>
                          <tr>
                            <td width="200px">
                              <strong>Italian Burger</strong>
                              <div class="form-inline">
                                <button type="button" class="btn btn-mini btn-primary">-</button>
                                <input type="text" class="span2 control" name="" id="">
                                <button type="button" class="btn btn-mini btn-primary">+</button>
                                &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr">120/- pcs</i>
                              </div>
                            </td>
                            <td width="200px">
                              <div class="form-inline" style="margin-top:14px;float:right;">
                                <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> 12000/-</span>
                                <label class="label label-important" style="padding:5px;"><i class="icon-trash icon-white"></i></label>
                                <label class="label label-warning" style="padding:5px;">NC</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="200px">
                              <strong>Italian Burger</strong>
                              <div class="form-inline">
                                <button type="button" class="btn btn-mini btn-primary">-</button>
                                <input type="text" class="span2 control" name="" id="">
                                <button type="button" class="btn btn-mini btn-primary">+</button>
                                &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr">120/- pcs</i>
                              </div>
                            </td>
                            <td width="200px">
                              <div class="form-inline" style="margin-top:14px;float:right;">
                                <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> 12000/-</span>
                                <label class="label label-important" style="padding:5px;"><i class="icon-trash icon-white"></i></label>
                                <label class="label label-warning" style="padding:5px;">NC</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="200px">
                              <strong>Italian Burger</strong>
                              <div class="form-inline">
                                <button type="button" class="btn btn-mini btn-primary">-</button>
                                <input type="text" class="span2 control" name="" id="">
                                <button type="button" class="btn btn-mini btn-primary">+</button>
                                &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr">120/- pcs</i>
                              </div>
                            </td>
                            <td width="200px">
                              <div class="form-inline" style="margin-top:14px;float:right;">
                                <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> 12000/-</span>
                                <label class="label label-important" style="padding:5px;"><i class="icon-trash icon-white"></i></label>
                                <label class="label label-warning" style="padding:5px;">NC</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="200px">
                              <strong>Italian Burger</strong>
                              <div class="form-inline">
                                <button type="button" class="btn btn-mini btn-primary">-</button>
                                <input type="text" class="span2 control" name="" id="">
                                <button type="button" class="btn btn-mini btn-primary">+</button>
                                &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr">120/- pcs</i>
                              </div>
                            </td>
                            <td width="200px">
                              <div class="form-inline" style="margin-top:14px;float:right;">
                                <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> 12000/-</span>
                                <label class="label label-important" style="padding:5px;"><i class="icon-trash icon-white"></i></label>
                                <label class="label label-warning" style="padding:5px;">NC</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="200px">
                              <strong>Italian Burger</strong>
                              <div class="form-inline">
                                <button type="button" class="btn btn-mini btn-primary">-</button>
                                <input type="text" class="span2 control" name="" id="">
                                <button type="button" class="btn btn-mini btn-primary">+</button>
                                &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr">120/- pcs</i>
                              </div>
                            </td>
                            <td width="200px">
                              <div class="form-inline" style="margin-top:14px;float:right;">
                                <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> 12000/-</span>
                                <label class="label label-important" style="padding:5px;"><i class="icon-trash icon-white"></i></label>
                                <label class="label label-warning" style="padding:5px;">NC</label>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td width="200px">
                              <strong>Italian Burger</strong>
                              <div class="form-inline">
                                <button type="button" class="btn btn-mini btn-primary">-</button>
                                <input type="text" class="span2 control" name="" id="">
                                <button type="button" class="btn btn-mini btn-primary">+</button>
                                &nbsp; <span>X</span>&nbsp; <i class="fa fa-inr">120/- pcs</i>
                              </div>
                            </td>
                            <td width="200px">
                              <div class="form-inline" style="margin-top:14px;float:right;">
                                <span class="label label-info" style="padding:5px;margin-top:3px;"><i class="fa fa-inr"></i> 12000/-</span>
                                <label class="label label-important" style="padding:5px;"><i class="icon-trash icon-white"></i></label>
                                <label class="label label-warning" style="padding:5px;">NC</label>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                      <br>
                      <table class="table table-condensed table-bordered">
                        <tr>
                          <td style="padding:2px;">
                            <h6 class="text-right">After Disc. Food Total: <i class="fa fa-inr"></i> 200.00</h6>
                            <h6 class="text-right">After Disc. Beverages Total: <i class="fa fa-inr"></i> 200.00</h6>
                            <h6 class="text-right">Gross Total: <i class="fa fa-inr"></i> 200.00</h6>
                            <h6 class="text-right">CGST: <i class="fa fa-inr"></i> 200.00</h6>
                            <h6 class="text-right">SGST: <i class="fa fa-inr"></i> 200.00</h6>
                          </td>
                        </tr>
                        <tr>
                          <td class="net-amount">
                            <span style="float:right;padding-right:2px;">Net Bill Amt: <i class="fa fa-inr"></i> 200.00</span>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <center>
                              <button type="button" class="btn btn-primary" id="save"><i class="icon-file icon-white"></i> Save</button>
                              <button class="btn btn-success"><i class="icon-print icon-white"></i> Print KOT</button>
                              <button class="btn  btn-inverse"><i class="icon-refresh icon-white"></i> Reset</button>
                            </center>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!--contentinner-->
        </div><!--maincontent-->
      </div>
      <!--mainright-->
      <!-- END OF RIGHT PANEL -->
     <div class="clearfix"></div>
      <?php include("inc/footer.php"); ?>
      <!--footer-->
  </div><!--mainwrapper-->

<!--product add modal-->
  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Add New Product</h3>
    </div>
    <div class="modal-body">
      <div class="row-fluid mr-b">
        <div class="span6">
          <h6>Product Name</h6>
          <input type="text" name="product" id="">
        </div>
        <div class="span6">
          <h6>Unit</h6>
          <input type="text" name="product" id="">
        </div>
      </div>
      <div class="row-fluid mr-b">
        <div class="span6">
          <h6>Rate</h6>
          <input type="text" name="product" id="">
        </div>
        <div class="span6">
          <h6>Quantity</h6>
          <input type="text" name="product" id="">
        </div>
      </div>
      <div class="row-fluid mr-b">
        <div class="span6">
          <h6>Discount (In%)</h6>
          <input type="text" name="product" id="">
        </div>
        <div class="span6">
          <h6>Discount (Rs)</h6>
          <input type="text" name="product" id="">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button class="btn btn-primary">Save changes</button>
    </div>
  </div>
<!-- close modal tag -->
<script src="inc/blockui.js"></script>
<script>
// add operation 
jQuery(document).ready(function() { 
  jQuery('#save').click(function() { 
      jQuery.blockUI(); 
      setTimeout(jQuery.unblockUI, 2000); 
    }); 
}); 

// delete operation
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
				  //alert(data);
               location='<?php echo $pagename."?action=3" ; ?>';
           }

			  });//ajax close
		}//confirm close
	} //fun close
// close 

// menu
jQuery(document).ready(function(){
   
   jQuery('#menues').click();
  
});

// search for product item
jQuery(document).ready(function(){
  jQuery("#myInput").on("keyup", function() {
    var value = jQuery(this).val().toLowerCase();
    jQuery("#myTable tr").filter(function() {
      jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</body>
</html>
