<?php include("../adminsession.php");
$pagename = "user_privilage.php";
$module = "Master";
$submodule = "User Privilage Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "privilage_setting";
$tblpkey = "privilage_id";
if(isset($_GET['userid']))
$userid = $_GET['userid'];
else
$userid ='';
$dup='';
$page_id='';
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{	//print_r($_POST);die;
	$userid = $_POST['userid']; 
	$page_id = $_POST['page_id']; 
//	$pagedit = $_POST['pagedit'];
	//$pagedel = $_POST['pagedel'];
	//$pageview = $_POST['pageview'];
		
			if($userid != '')
		{
         
            $where = array('userid'=>$userid);
            $obj->delete_record($tblname,$where);

		     for($i=0; $i < sizeof($page_id); $i++)
		    { 
				$form_data = array('userid'=>$userid,'page_id'=>$page_id[$i],'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
			$sql = $obj->insert_record($tblname,$form_data);
			$action=1;
			$process = "insert";
			  }
            }
		//$obj->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $keyvalue, $process);
		echo "<script>location='$pagename?userid='$userid'&action=$action'</script>";
	 	
}
if(isset($_GET[$tblpkey]))
{
	$btn_name = "Update";
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
                    <?php echo $dup;  ?>
                      <p>
                        <?php $result = $obj->select_data_condition_orderby("user","userid","1","userid");
									//print_r($result); die; ?>
								<label>Select User :<span class="text-error">*</span></label>
                                <span class="formwrapper">
                            	<select data-placeholder="Select User Type" class="chzn-select" name="userid" id="userid" onChange="getusertype(this.value);">
                                  <option value="">-Select User Type-</option>
                                  <?php
									foreach($result as $row_get)
								  {
								  ?>
                                  <option value="<?php echo $row_get['userid']; ?>"><?php echo $row_get['username']; ?></option> 
                                  <?php
								  }								  
								  ?>
                                </select>
                            </span>
                         <hr>
                          <script>document.getElementById('userid').value='<?php echo $userid; ?>'; </script>  
                           </p>
                          <div class="row-fluid">
                           <?php if($userid !='')
						  {
						  ?>
                    <div class="span12" style="width:100%">
                    <h4 class="widgettitle">Master Entry</h4>
                    
                    <table class="table table-condensed table-hover table-invoice">
                    <?php
						$where = array("menuname"=>"Master");
						$sql_get = $obj->select_data("m_userprivilege",$where);
						foreach($sql_get as $row_get)
                    {
						 $page_id = $row_get['page_id'];
						$where = array("page_id"=>$page_id,"userid"=>$userid);						
						$module_page = $obj->count_method("privilage_setting",$where);
						//$pagedel = $obj->check_duplicate("privilage_setting","pagedel",$where);
						//$pageview = $obj->check_duplicate("privilage_setting","pageview",$where);
						//$pagedit = $obj->check_duplicate("privilage_setting","pagedit",$where);
						$pagedel = $obj->getvalfield("privilage_setting","pagedel","page_id=$page_id and userid ='$userid'");
						$pageview = $obj->getvalfield("privilage_setting","pageview","page_id=$page_id and userid ='$userid'");
						$pagedit = $obj->getvalfield("privilage_setting","pagedit","page_id=$page_id and userid ='$userid'");
						//print_r($pagedit); die;
						
                    ?>
                        <tr>
                            <td style="width:50%"><label style="width:100%"> <input type="checkbox" name="page_id[]" value="<?php echo $row_get['page_id']; ?>" <?php if($module_page !='0') { ?> checked <?php }?>/> <?php echo $row_get['page_heading']; ?> </label></td>
                            
                        </tr>
                    <?php 
                    }
                    ?>
                    </table>
                    </div>
                    <hr>
                    <center> <p class="stdformbutton">
                    <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('userid'); ">
                    <?php echo $btn_name; ?></button>
                    <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a></p>
                    
                    </center>
                    
                    <?php }  ?>
                            
                        </form>
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
<script>
function getusertype(userid)
{
	if(userid !='')
	{
		window.location.href='?userid='+userid;
	}
}
</script>
</body>
</html>
