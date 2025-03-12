<?php include("../adminsession.php");
$pagename = "issue_return.php";
$module = "Add Issue Return Entry";
$submodule = "Issue Return Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "issue_return";
$tblpkey = "issue_id";


//$ret_date = "";
if(isset($_GET['action']))
  $action = addslashes(trim($_GET['action']));
else
  $action = "";
$comp_name = "";
$issuedate = "";
$qty = "";
$ret_qty = "";
$unit_name = "";
$blns_qty = "";
$bal_qty = "";
//$mnproduct_id = "";

if(isset($_GET['issue_id']))
  $issue_id = $_GET['issue_id'];
else
  $issue_id = 0;

if(isset($_POST['submit']))
{ 
  //print_r($_POST); die;

  $raw_id = $obj->test_input($_POST['raw_id']);
  $unit_name = $obj->test_input($_POST['unit_name']);
  $ret_qty = $obj->test_input($_POST['ret_qty']);
  $ret_date = $obj->dateformatusa($_POST['ret_date']);


  if($issue_id == 0)
  {   
    $form_data = array('raw_id'=>$raw_id,'unit_name'=>$unit_name,'ret_qty'=>$ret_qty,'ret_date'=>$ret_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
    $obj->insert_record($tblname,$form_data); 
  //print_r($form_data); die;
    $action=1;
    $process = "insert";
   
  }

  else{
        //update
    $form_data = array('raw_id'=>$raw_id,'unit_name'=>$unit_name,'ret_qty'=>$ret_qty,'ret_date'=>$ret_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
    //print_r($form);
    $where = array('issue_id'=>$issue_id);
    $issue_id = $obj->update_record($tblname,$where,$form_data);
    $action=2;
    $process = "updated";

  }
  echo "<script>location='$pagename?action=$action'</script>";
}
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array('issue_id'=>$issue_id);
  $sqledit = $obj->select_record($tblname,$where);
  $raw_id =  $sqledit['raw_id'];
  $unit_name =  $sqledit['unit_name'];
  $ret_qty =  $sqledit['ret_qty'];
  $ret_date =  $sqledit['ret_date'];
}
else
{
  $ret_date=date('Y-m-d'); 
}


?>
<!DOCTYPE html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include("inc/top_files.php"); ?>
  <script type="text/javascript">

    function getproductdetail(raw_id)
    {
      //alert("hi");
      location = 'issue_return.php?raw_id='+raw_id;
    }

    function getissueretdetail(raw_id)
    { 

      if(!isNaN(raw_id))
      {
        jQuery.ajax({
          type: 'POST',
          url: 'getissueretdetail.php',
          data: 'raw_id='+raw_id,
          dataType: 'html',
          success: function(data){          
          //alert(data);

          obj = JSON.parse(data);
          
          jQuery('#unit_name').val(obj.unit_name);
          //jQuery('#qty').val(obj.qty);
          //jQuery('#bal_qty').val(obj.bal_qty);
          
        }
        
        });//ajax close
      }

      if(raw_id == 0)
      {
     //alert('hi');
     jQuery('#unit_name').val('');
     //jQuery('#qty').val('');
     //jQuery('#bal_qty').val('');
   }
 }

</script>
</head>

<body >

  <div class="mainwrapper">

    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    <!-- START OF RIGHT PANEL -->
    <div class="rightpanel">
      <?php include("inc/header.php"); ?>


      <div style="float:right;">
            <!-- <input type="button" class="btn btn-primary" style="float:right; margin-top:10px" name="addnew" id="addnew" onClick="add();" 
              value=""> --><!--Show List-->
            </div>
            <div class="maincontent">
             <div class="contentinner content-dashboard">

               <div id="new2">               
                <form action="" method="post" >
                  <div class="row-fluid">
                    <table width="80%" class="table table-condensed table-bordered" >

                      <tr>

                        <th><strong>Product: <span style="color:#F00;">*</span> </strong></th>
                        <th>Unit:</th> 
                        <th>Qty:<span style="color:#F00;">*</span></th> 
                        <th>Return Date:</th>
                        <th></th>

                      </tr>

                      <tr>
                       <td>

                        <select name="raw_id" id="raw_id"  class="chzn-select" style="width:233px;" onchange="getissueretdetail(this.value);">
                          <option value="">---Select---</option>
                          <?php
                          $crow=$obj->executequery("select * from raw_material");
                          foreach ($crow as $cres) 
                          {

                            ?>
                            <option value="<?php echo $cres['raw_id']; ?>"> <?php echo strtoupper($cres['raw_name']); ?></option>    
                            <?php
                          }

                          ?>

                        </select>
                        <script>document.getElementById('raw_id').value = '<?php echo $raw_id; ?>';</script>
                      </td>

                      <td> <input type="text" name="unit_name" id="unit_name" class="form-control text-red"  value="<?php echo $unit_name ;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"  >   
                      </td>

                      <td> <input type="text" name="ret_qty" id="ret_qty" class="form-control text-red"  value="<?php echo $ret_qty ;?>"  style="font-weight:bold;" placeholder=""  tabindex="4" autocomplete="off"></td>

                      <td> <input type="text" name="ret_date" id="ret_date" class="form-control text-red"  value="<?php echo $obj->dateformatindia($ret_date) ;?>"  style="font-weight:bold;" placeholder="dd-mm-yyyy"  tabindex="4" autocomplete="off"  ></td>


                      <td>
                        <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('raw_id,ret_qty');">
                          <?php echo $btn_name; ?></button>
                          <!-- <a href="<?php //echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a> -->
                          <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $issue_id; ?>">
                        </td>


                      </tr>
                    </table>

                  </div>
                </form>
                  <br>
                  <?php   $chkview = $obj->check_pageview("issue_return.php",$loginid);              
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
                        <th  class="head0 nosort">Sno.</th>
                        <th class="head0">Product Name</th>
                        <th class="head0">Unit</th>
                        <th  class="head0">Return Qty</th>
                        <th class="head0">Return Date</th>
                        <th width="4%" class="head0">Edit</th>
                        <th width="5%" class="head0">Delete</th> 
                      </tr>
                    </thead>
                    <tbody>
                   
                    <?php
                    $slno=1;
            //$res = $obj->fetch_record("m_product");
                    $res = $obj->executequery("select * from issue_return order by issue_id desc");
                    foreach($res as $row_get)
                    {
                      $raw_id = $row_get['raw_id'];
                      $raw_name = $obj->getvalfield("raw_material","raw_name","raw_id='$raw_id'");
                      ?>   
                      <tr>
                        <td><?php echo $slno++; ?></td>

                        <td><?php echo strtoupper($raw_name); ?></td>
                        <td><?php echo strtoupper($row_get['unit_name']); ?></td>
                        <td><?php echo $row_get['ret_qty']; ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['ret_date']); ?></td>

                         <?php   $chkedit = $obj->check_editBtn("issue_return.php",$loginid);              
                              if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                        <td><a class='icon-edit' title="Edit" href='issue_return.php?issue_id=<?php echo $row_get['issue_id'] ; ?>'></a></td>
                        <?php } ?>
                        <?php  $chkdel = $obj->check_delBtn("issue_return.php",$loginid);             
                              if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>  
                        <td>
                          <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['issue_id']; ?>);' style='cursor:pointer'></a>
                        </td> 
                      <?php } ?>
                      </tr>

                      <?php
                    }
                    ?>     
                  </tbody>
                </table>
              <?php } ?>
             
            </div>
          </div>
        </div>
        <!--mainright-->
        <!-- END OF RIGH-->
        <!--footer-->
      </div><!--mainwrapper-->
      <div class="clearfix"></div>
      <?php include("inc/footer.php"); ?>
    </body>
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
</html>
