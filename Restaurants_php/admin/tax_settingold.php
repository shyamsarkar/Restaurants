<?php include("../adminsession.php");
$pagename = "tax_setting.php";
$module = "Add Tax";
$submodule = "Tax Setting";
$btn_name = "Update";
$tblname = "tax_setting_new";
$tblpkey = "taxid";
$keyvalue= "1";


if(isset($_GET['action']))
    $action = $obj->test_input($_GET['action']);
else
    $action = "";

// for food
if(isset($_POST['save_food']))
{
   //print_r($_POST);die;

    $sgst = $obj->test_input($_POST['sgst']);
    $cgst = $obj->test_input($_POST['cgst']);
    if(isset($_POST['is_applicable1']))
    {
      $is_applicable = $_POST['is_applicable1'];    
    }
    else
    {
      $is_applicable = 0;
    }  


        //check Duplicate
            //update
     $form_data = array('sgst'=>$sgst,'cgst'=>$cgst,'is_applicable'=>$is_applicable);
     //print_r($form_data);die;
     $where = array('foodtypeid'=>2);

     $obj->update_record($tblname,$where,$form_data);

     $action=2;
     $process = "updated";
     echo "<script>location='$pagename?action=$action'</script>";
}

// for bevrages

//$foodtypeid = "1";
if(isset($_POST['save_bevrages']))
{

    $sgst = $obj->test_input($_POST['sgst']);
    $cgst = $obj->test_input($_POST['cgst']);
    if(isset($_POST['is_applicable']))
    {
        $is_applicable = $_POST['is_applicable'];   
    }
    else
    {
     $is_applicable = "";
    } 
            //check Duplicate
                //update
     $form_data = array('sgst'=>$sgst,'cgst'=>$cgst,'is_applicable'=>$is_applicable);
     $where = array('foodtypeid'=>1);
     $obj->update_record($tblname,$where,$form_data);

     $action=2;
     $process = "updated";
    echo "<script>location='$pagename?action=$action'</script>";
}



// for food
$btn_name = "Update";
$where = array('foodtypeid'=>2);
$sqledit = $obj->select_record($tblname,$where);
$cgst_food =  $sqledit['cgst'];
$sgst_food = $sqledit['sgst'];
$is_applicable_food  = $sqledit['is_applicable'];



// for bevrages
$btn_name = "Update";
$cwhere = array('foodtypeid'=>1);
$sqledit = $obj->select_record($tblname,$cwhere);
$cgst_bev =  $sqledit['cgst'];
$sgst_bev = $sqledit['sgst'];
$is_applicable_bev  = $sqledit['is_applicable'];
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
                   
                        <div class="row-fluid">
                          <table class="table table-condensed table-bordered">
                            <tr>
                                <tr>
                                  <td>For Food Tax Setting :</td>
                                  <td>For Bevrages Tax Setting :</td>
                                </tr>
                              <tr>
                                
                                <td>
                                <form  method="post" action="">
                                  <table class="table table-condensed table-bordered">
                                    <tr>
                                        <td>
                                           SGST : <span style="color: red;">*</span>
                                       </td>
                                       <td>     
                                           <input type="text" name="sgst" id="sgst" placeholder="SGST" value="<?php echo $sgst_food; ?>">
                                       </td>
                                    </tr>
                                    <tr>

                                      <td>CGST : <span style="color: red;">*</span></td>

                                      <td>
                                        <input type="text" name="cgst" id="cgst" placeholder='CGST' value="<?php echo $cgst_food; ?>"/>
                                      </td>

                                    </tr>
                                    <tr>
                                       <td>Is Applicable : </td>

                                       <td><label><input type="checkbox" name="is_applicable1" value="1" <?php if($is_applicable_food == "1") echo 'checked';?> > yes</label></td>
                                    </tr>

                                    <tr>
                                       <td></td>
                                       <td> <button  type="submit" name="save_food" class="btn btn-primary" onClick="return checkinputmaster('sgst,cgst'); ">
                                        <?php echo $btn_name; ?></button>
                                        <a href="tax_setting.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>"> 
                                        <input type="hidden" name="foodtypeid" class="input-medium" value="2"/>
                                       </td>
                                    </tr>

                                </table>
                               </form>
                            </td>
                          
                           
                            <td>
                                <form  method="post" action=""> 
                                <table class="table table-condensed table-bordered">

                                    <tr>

                                        <td>
                                           SGST : <span style="color: red;">*</span>
                                       </td>

                                       <td>     
                                           <input type="text" name="sgst" id="sgst" placeholder="SGST" value="<?php echo $sgst_bev; ?>">
                                       </td>

                                   </tr>
                                   <tr>

                                        <td>CGST : <span style="color: red;">*</span></td>

                                        <td>
                                           <input type="text" name="cgst" id="cgst" placeholder='CGST' value="<?php echo $cgst_bev; ?>"/>
                                        </td>

                                    </tr>

                                    <tr>

                                      <td>Is Applicable : <span style="color:#F00;"></span></td>

                                      <td><label><input type="checkbox" name="is_applicable" value="1" <?php if($is_applicable_bev == "1") echo 'checked';?> > yes</label></td>

                                   </tr>
                                    <tr>
                                        <td></td>
                                        <td><button  type="submit" name="save_bevrages" class="btn btn-primary" onClick="return checkinputmaster('sgst,cgst'); ">
                                        <?php echo $btn_name; ?></button>
                                        <a href="tax_setting.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                                        <input type="hidden" name="foodtypeid" class="input-medium" value="1"/> </td>
                                    </tr>
                                </table>
                                </form>
                            </td>
                        
                           </tr>
                        </tr>

                    </table>

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
</body>
</html>
