<?php include("../adminsession.php");
//print_r($_SESSION);die;
$pagename = "user_master.php";
$module = "Add Users";
$submodule = "User Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "user";
$tblpkey = "userid";

if(isset($_GET['userid']))
$keyvalue = $_GET['userid'];
else
$keyvalue = 0;
$dup = "";
$userid = '';
$username = "";
$email = "";
$password = "";
$usertype = "";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
  $email = $_POST['email'];
	$password = $_POST['password'];
	$usertype = $_POST['usertype'];
  $enable="enable";

	//check Duplicate
	$cwhere = array("username"=>$_POST['username']);
	$count = $obj->count_method("user",$cwhere);
	
    	if($count > 0 && $keyvalue == 0)
			{
			/*$dup = " Error : Duplicate Record";*/
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Error : Duplicate Record.
			</div>";
			} 
			
		else{
				if($keyvalue == 0)
				{
					//insert
					$form_data = array('username'=>$username,'email'=>$email,'password'=>$password,'enable'=>$enable,'usertype'=>$usertype,'createdby'=>$loginid,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
					$obj->insert_record($tblname,$form_data);
					$action = 1;
					$process = "insert";
				}
          		 else 
          		{
				//update
				$form_data = array('username'=>$username,'email'=>$email,'password'=>$password,'enable'=>$enable,'usertype'=>$usertype,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
				$where = array($tblpkey=>$keyvalue);
				$keyvalue = $obj->update_record($tblname,$where,$form_data);
				$action = 2;
				$process = "updated";
		 	 }
		 echo "<script>location='$pagename?action=$action'</script>";
		 }
 }

if(isset($_GET[$tblpkey]))
{   
    $where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	//print_r($sqledit); die;
	$username =  $sqledit['username'];
  $email = $sqledit['email'];
	$password =  $sqledit['password'];
	$usertype =  $sqledit['usertype'];
  
  
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
<?php echo $dup; ?>
<table width="100%" class="table table-bordered table-condensed">
    <tr>
        <td>User Name <span class="text-error">*</span></td>
        <td>Password <span class="text-error">*</span></td>
        <td>User Type <span class="text-error">*</span></td>
    </tr>
    <tr>
        <td><input type="text" name="username" id="username" class="input-large" value="<?php echo $username;?>" autocomplete="off" autofocus placeholder="Enter User Name"/></td>
        <td><input type="password" name="password" id="password" class="input-large" value="<?php echo $password;?>" autocomplete="off" autofocus placeholder="Enter Password"/></td>
        <td>
          <select name="usertype" id="usertype" class="chzn-select">
            <option value="user" selected>User</option>
            <option value="admin">Admin</option>
          </select>
          <script>document.getElementById('usertype').value = '<?php echo $usertype; ?>';</script>
        </td>
    </tr>
    <tr>
        <td>Email Id<span class="text-error">*</span></td>
        <td><span class="text-error"></span></td>
        <td><span class="text-error"></span></td>
    </tr>
    <tr>
        <td><input type="text" name="email" id="email" class="input-large" value="<?php echo $email;?>" autocomplete="off" autofocus placeholder="Enter Email Id"/></td>
        <td></td>
        <td></td>
    </tr>

</table>

            <p class="stdformbutton">
            <center><button  type="submit" name="submit"class="btn btn-primary" 
            onClick="return checkinputmaster('username,password,usertype,email'); "> <?php echo $btn_name; ?></button>
            <a href="<?php echo $pagename; ?>" class="btn btn-primary" name="reset_dept" value="Reset" tabindex="5">Reset</a>                           </center>
            <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
            </p>
            </form>
          </div>
                   
                          
                <!--widgetcontent-->
                 <?php  $chkview = $obj->check_pageview("user_master.php",$loginid);             
                  if($chkview == 1 ||  $_SESSION['usertype']=='admin'){  ?> 
                
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

                <th width="5%" class="head0 nosort">S.No.</th>
                <th width="13%" class="head0">User Name</th>
                <th width="13%" class="head0">Email Id</th>
                <th width="10%" class="head1">Password</th>
                <th width="9%" class="head1">User Type</th>
                <?php  $chkedit = $obj->check_editBtn("user_master.php",$loginid);              
                if($chkedit == 1 ||  $_SESSION['usertype']=='admin'){  ?>
                <th width="9%" class="head0">Edit</th><?php } ?>
                <?php  $chkdel = $obj->check_delBtn("user_master.php",$loginid);             
                if($chkdel == 1 ||  $_SESSION['usertype']=='admin'){  ?>
                <th width="10%" class="head0">Delete</th> <?php } ?>
                </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $slno=1;
                      $sql_get=0;
                      $sql_get = $obj->fetch_record("user");
                                        
                      foreach($sql_get as $row_get)
                      { 
                      ?>
                      <td> <?php echo $slno++; ?></td> 
                      <td><?php echo $row_get['username'] ; ?></td>    
                      <td><?php echo $row_get['email'] ; ?></td>    
                      <td><?php echo $row_get['password'] ; ?></td>
                      <td><?php echo $row_get['usertype'] ; ?></td>
                      <?php if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                      <td style="text-align:center;" width="11%"><a class='icon-edit' title="Edit" href='user_master.php?userid=<?php echo  $row_get['userid'] ; ?>'></a> </td><?php } ?>
                      <?php  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?> 
                      <td width="7%" style="text-align:center;"><a class='icon-remove' onclick='funDel(<?php echo  $row_get['userid'] ; ?>);' style='cursor:pointer' title="Delete"></a></td><?php } ?>
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


  </script>
</body>
</html>
