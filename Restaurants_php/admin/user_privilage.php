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
$action = $obj->test_input($_GET['action']);
else
$action = "";
$page_id="";
$pagedit="";
$pagedel="";
$pageview="";

if(isset($_POST['submit']))
{

  //print_r($_POST);die;
	$userid = $obj->test_input($_POST['userid']); 
  $page_id = $_POST['page_id']; 
  $pagedit = $_POST['pagedit'];
  $pagedel = $_POST['pagedel'];
  $pageview = $_POST['pageview'];
  
		
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

         if(sizeof($pagedit) > 0)
         {
           foreach ($pagedit as $key_edit => $value_edit) {
             # code...
              $where = array('userid'=>$userid, 'page_id'=>$key_edit);
              $fdata = array('pagedit' => $value_edit);
              $obj->update_record($tblname,$where, $fdata);
           }
         }

         if(sizeof($pagedel) > 0)
         {
           foreach ($pagedel as $key_del => $value_del) {
             # code...
              $where = array('userid'=>$userid, 'page_id'=>$key_del);
              $fdata = array('pagedel' => $value_del);
              $obj->update_record($tblname,$where, $fdata);
           }
         }

         if(sizeof($pageview) > 0)
         {
           foreach ($pageview as $key_view => $value_view) {
             # code...
              $where = array('userid'=>$userid, 'page_id'=>$key_view);
              $fdata = array('pageview' => $value_view);
              $obj->update_record($tblname,$where, $fdata);
           }
         }
			}
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
                   
                  <p>
                 <!--  <?php $result //= $obj->select_data_condition_orderby("user","userid","1","userid");
                   ?> -->
                  <label>Select User :<span class="text-error">*</span></label>
                  <span class="formwrapper">
                  <select data-placeholder="Select User Type" class="chzn-select" name="userid" id="userid" onChange="getusertype(this.value);">
                    <option value="">-Select User Type-</option>
                    <?php
                     $result=$obj->executequery("select * from user where usertype='user'");
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
                          
                <?php if($userid !='')
						  {
						  ?>
                          
                    <div class="row-fluid">
                    <div class="span12" style="width:100%">
                    <h4 class="widgettitle">Master Entry</h4>
                    
                    <table class="table table-condensed table-hover table-invoice">
                    <?php
                    $sql1=$obj->executequery("select * from m_userprivilege where menuname='Master'");
                    foreach($sql1 as $row1)

                    {  
                      $page_id=$row1['page_id'];	

                     $where = array("page_id"=>$page_id,"userid"=>$userid);
                     $module_page = $obj->count_method("privilage_setting",$where);	
                     
                      $pagedel = $obj->getvalfield("privilage_setting","pagedel","page_id=$page_id and userid ='$userid'");
                      $pageview = $obj->getvalfield("privilage_setting","pageview","page_id=$page_id and userid ='$userid'");
                      $pagedit = $obj->getvalfield("privilage_setting","pagedit","page_id=$page_id and userid ='$userid'");
                    ?>
                        <tr>
                            <td style="width:50%"><label style="width:100%"> <input type="checkbox" name="page_id[]" value="<?php echo $row1['page_id']; ?>" <?php if($module_page !='0') { ?> checked <?php } ?> /> <?php echo $row1['page_heading']; ?> </label></td>

                            <td><label> <input type="checkbox" name="pagedit[<?php echo $page_id; ?>]" value="1"  <?php if($pagedit =='1') { ?> checked <?php } ?> /> <span style="color:#00F">Edit</span></label></td>
                            <td><label> <input type="checkbox" name="pageview[<?php echo $page_id; ?>]" value="1"  <?php if($pageview =='1') { ?> checked <?php } ?> /> <span style="color:#000">View</span></label></td>
                            <td><label>  <input type="checkbox" name="pagedel[<?php echo $page_id; ?>]" value="1"  <?php if($pagedel =='1') { ?> checked <?php } ?>/><span style="color:#F00">Delete</span></label></td>
                        </tr>
                    <?php 
                    }
                    ?>
                    </table>
                    </div>
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
            </div><!--contentinner-->
            </div><!--mainwrapper-->
            </div><!--rightpanel-->
     <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    <!--footer-->
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
