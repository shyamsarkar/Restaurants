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
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$userid = test_input($_POST['userid']); 
	$page_id = $_POST['page_id'];
	$pagedit = $_POST['pagedit'];
	$pagedel = $_POST['pagedel'];
	$pageview = $_POST['pageview'];
		
			if($userid != '')
		{	
			$where = array($tblpkey=>$keyvalue);
			$obj->delete_record($tblname,$where);
			
		    for($i=0; $i < sizeof($page_id); $i++)
		    {
				$form_data = array('userid'=>$userid,'pagedit'=>$pagedit[$i],'pagedel'=>$pagedel[$i],'pageview'=>$pageview[$i],'page_id'=>$page_id[$i],'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
			dbRowInsert($tblname, $form_data);
			$action=1;
			$process = "insert";
			  }
			}
		
		
		$cmn->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $keyvalue, $process);
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
                    <?php echo  $dup;  ?>
                      <p>
                                <label>Select User :<span class="text-error">*</span></label>
                                <span class="formwrapper">
                            	<select data-placeholder="Select User Type" class="chzn-select" name="userid" id="userid" onChange="getusertype(this.value);">
                                  <option value="">-Select User Type-</option>
                                  <?php 
								  //$sql=mysql_query("select userid,username from user where userid <> 1 order  by userid desc");
								  //while($row=mysql_fetch_assoc($sql))
									$where = array("status"=>0);
									$sql_get = $obj->select_data("user",$where);
									foreach($sql_get as $row_get)
								  {
								  ?>
                                  <option value="<?php echo $row_get['userid']; ?>"><?php echo $row_get['username']; ?></option> 
                                  <?php
								  }								  
								  ?>
                                </select>
                            </span>
                         <hr>
                          <script> document.getElementById('userid').value='<?php echo $userid; ?>'; </script>  
                           </p>
                          <?php if($userid !='')
						  {
						  ?>
                          
                    <div class="row-fluid">
                    <div class="span12" style="width:100%">
                    <h4 class="widgettitle">Master Entry</h4>
                    
                    <table class="table table-condensed table-hover table-invoice">
                    <?php
                    //$sql1=mysql_query("select * from m_userprivilege where menuname='Master'");
                    //while($row1=mysql_fetch_Assoc($sql1))
						$where = array("menuname"=>"Master");
						$sql_get = $obj->select_data("m_userprivilege",$where);
						foreach($sql_get as $row_get)
                    {
						$page_id=$row_get['page_id'];	
					
						//$page_heading= $obj->getvalfield("m_userprivilege","page_heading" "page_id ='$page_id'");
						$module_page= check_duplicate("privilage_setting","page_id = '$page_id' and userid ='$userid'");
						$pagedel = $obj->getvalfield("privilage_setting","pagedel","page_id=$page_id and userid ='$userid'");
						$pageview = $obj->getvalfield("privilage_setting","pageview","page_id=$page_id and userid ='$userid'");
						$pagedit = $obj->getvalfield("privilage_setting","pagedit","page_id=$page_id and userid ='$userid'");
                    ?>
                        <tr>
                         
                            <td><label> <input type="checkbox" name="pagedit[]" value="1"  <?php if($pagedit =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Edit</span></label></td>
                            <td><label> <input type="checkbox" name="pageview[]" value="1"  <?php if($pageview =='1') { ?> checked <?php } ?> /> <span style="color:#000">View</span></label></td>
                            <td><label>  <input type="checkbox" name="pagedel[]" value="1"  <?php if($pagedel =='1') { ?> checked <?php } ?>/><span style="color:#F00">Delete</span></label></td>
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
                    <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                    
                    </center>
                    
                    <?php } ?>
                            
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

/*jQuery(document).ready(function(){
						   
						   jQuery('#menues').click();
						  
						   });
*/
</script>

</body>

</html>
