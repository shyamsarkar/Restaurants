<?php include("../adminsession.php");
//print_r($_SESSION);

$pagename = "customer_master.php";
$module = "Customer Master";
$submodule = "CUSTOMER MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_customer";
$tblpkey = "customer_id";
if(isset($_GET['customer_id']))
    $keyvalue = $_GET['customer_id'];
else
$customer_id = "";

if(isset($_GET['action']))
    $action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$duplicate = "";
$city_name = "";
$priv_bal = "";
//$password = "";
$customer_name = $mobile = $address = $email = $status = "";

if(isset($_POST['submit']))
{	
	//print_r($_POST); die;

	$customer_name =$obj->test_input($_POST['customer_name']);
	$mobile   = $obj->test_input($_POST['mobile']);
	$address  = $obj->test_input($_POST['address']);
	$email  = $obj->test_input($_POST['email']);
  $status  = $obj->test_input($_POST['status']);

    //check Duplicate
    $cwhere = array("customer_name"=>$_POST['customer_name'],'mobile'=>$_POST['mobile']);
    $count = $obj->count_method("m_customer",$cwhere);
    if($count > 0 && $keyvalue == 0 )
    {

     $duplicate="<div class='alert alert-danger'>
     <strong>Error!</strong> Error : Duplicate Record.
     </div>";
 } 
 else{
			//insert
			//echo $keyvalue; die;
    if($keyvalue == 0)
    {   
        $form_data = array('customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'status'=>$status,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid);
        $obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
    }
    else{
				//update
        $form_data = array('customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'status'=>$status,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'createdby'=>$loginid,'lastupdated'=>$createdate);
        $where = array($tblpkey=>$keyvalue);
        $keyvalue = $obj->update_record($tblname,$where,$form_data);
        $action=2;
        $process = "updated";

    }
    echo "<script>location='$pagename?action=$action'</script>";

}
}
if(isset($_GET[$tblpkey]))
{ 

	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$customer_name =  $sqledit['customer_name'];
	$mobile =  $sqledit['mobile'];
	$address =  $sqledit['address'];
	$email =  $sqledit['email'];
    $status =  $sqledit['status'];
    
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
                        <?php echo $duplicate; ?>

                        <p>
                            <label>Customer Name <span class="text-error">*</span></label>
                            <span class="field"><input type="text" name="customer_name" id="customer_name" class="input-xxlarge" value="<?php echo $customer_name;?>" placeholder="Enter Customer Name" autocomplete="off" autofocus/></span>
                        </p>



                        <p>
                            <label>Mobile No:<span class="text-error"></span></label>
                            <span class="field"><input type="text" name="mobile" placeholder="Contact No." id="mobile" autocomplete="off" class="input-xxlarge" value="<?php echo $mobile;?>" maxlength="10" autofocus/></span>
                        </p>
                        <p>
                            <label>Email Id : </label>
                            <span class="field"><input type="email" placeholder="Email Id" autocomplete="off" name="email" id="email" class="input-xxlarge" value="<?php echo $email;?>" autofocus/></span>
                        </p>
                        <p>
                            <label>Address : </label>
                            <span class="field"><input type="text" placeholder="Address" autocomplete="off" name="address" id="address" class="input-xxlarge" value="<?php echo $address;?>" autofocus/></span>
                        </p> 
                        
                        
                        <div class="lg-12 md-12 sm-12">
                            <label>Status</label>
                            <span class="field">
                              <label><input type="radio" checked name="status"  value="enable" <?php if($status == "enable") echo 'checked';?>>&nbsp;&nbsp;Active </label>
                              <label><input type="radio" name="status"  value="disable"  <?php if($status == "disable") echo 'checked';?>>&nbsp;&nbsp;Inactive</label>
                          </span>            
                      </div>   

                      <center> <p class="stdformbutton">
                        <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('customer_name');" />
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </p> </center>
                </form>
            </div>

            <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_customer_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

                  <?php  $chkview = $obj->check_pageview("customer_master.php",$loginid);             
                   if($chkview == 1 || $usertype == 'admin'){  ?>
                    
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <table class="table table-bordered" id="dyntable">
                        
                        <thead>
                            <tr>
                                <th class="head0 nosort">S.No.</th>
                                <th class="head0">Customer Name</th>    
                                <th class="head0">Mobile No</th>   
                                <th class="head0">Address</th>
                                <th class="head0">Email</th>
                                <th class="head0">Status</th>
                                <?php  $chkedit = $obj->check_editBtn("customer_master.php",$loginid);              
                                 if($chkedit == 1 || $usertype == 'admin'){  ?>
                                <th class="head0">Edit</th><?php } ?>
                                <?php  $chkdel = $obj->check_delBtn("customer_master.php",$loginid);             
                                if($chkdel == 1 || $usertype == 'admin'){  ?>
                                <th class="head0">Delete</th><?php } ?>
                                 
                            </tr>
                        </thead>
                        <tbody>
                       
                        <?php
                        $slno=1;
                        
                        $res = $obj->executequery("select * from m_customer order by customer_id desc");
                        foreach ($res as $row_get )
                        {
                            $status = $row_get['status'];
                            if($status == 'enable')
                            {
                                $status = "<span style=color:green;>Enable</span>";
                            }
                            else
                            {
                              $status = "<span style=color:red;>In-Active</span>"; 
                            }
                            
                         ?> 
                         <tr>
                            <td><?php echo $slno++; ?></td> 
                            <td><?php echo strtoupper($row_get['customer_name']); ?></td>  
                            <td><?php echo $row_get['mobile']; ?></td> 
                            <td><?php echo $row_get['address']; ?></td> 
                            <td><?php echo $row_get['email']; ?></td>  
                            <td><?php echo $status; ?></td>  
                            <?php if($chkedit == 1 || $usertype == 'admin'){  ?>
                            <td><a class='icon-edit' title="Edit" href='customer_master.php?customer_id=<?php echo $row_get['customer_id'] ; ?>'></a></td><?php } ?>
                              <?php  if($chkdel == 1 || $usertype == 'admin'){  ?> 
                            <td>
                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['customer_id']; ?>);' style='cursor:pointer'></a>
                            </td><?php } ?>

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
   jQuery('#open_bal_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
//jQuery('#todate').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});

jQuery('#open_bal_date').focus();
</script>
</body>
</html>
