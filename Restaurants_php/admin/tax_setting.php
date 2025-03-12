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


if(isset($_POST['submit']))
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
	$sercharge = $_POST['sercharge'];
	//check Duplicate
		//update
    
    $form_data = array('sgst'=>$sgst,'cgst'=>$cgst,'sercharge'=>$sercharge,'is_applicable'=>$is_applicable);
    $where = array($tblpkey=>$keyvalue);
    $keyvalue = $obj->update_record($tblname,$where,$form_data);
    $action=2;
    $process = "updated";
    echo "<script>location='$pagename?action=$action'</script>";
}
	
$btn_name = "Update";
$where = array($tblpkey=>$keyvalue);
$sqledit = $obj->select_record($tblname,$where);
$cgst =  $sqledit['cgst'];
$sgst = $sqledit['sgst'];
$sercharge = $sqledit['sercharge'];
$is_applicable  = $sqledit['is_applicable'];



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
                   <table align="center" class="table table-bordered table-condensed"  >
                    <tr> 
						<th>SGST</th>
						<th>CGST</th>
						<th>SERVICE CHARGE</th>
						<th>Is Applicable</th>
                    </tr>
                    <tr>
                    <td><input type="text" name="sgst" id="sgst" class="input-medium" 
                    placeholder='SGST' value="<?php echo $sgst; ?>"/> </td>
                    <td><input type="text" name="cgst" id="cgst" class="input-medium" 
                    placeholder='Tax Name' value="<?php echo $cgst; ?>"/> </td>
                    <td><input type="text" name="sercharge" id="sercharge" class="input-medium" 
                    placeholder='Tax' value="<?php echo $sercharge; ?>"/> </td>
                   <td><label><input type="checkbox" name="is_applicable" value="1"<?php if($is_applicable == "1") echo 'checked';?> > yes</label></td>
                    </tr>
                    </table>
          			  <center> <p class="stdformbutton">
                                <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster(''); ">
								<?php echo $btn_name; ?></button>
                                <a href="tax_setting.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
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
