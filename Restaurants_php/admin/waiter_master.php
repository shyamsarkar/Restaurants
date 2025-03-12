<?php include("../adminsession.php");

//print_r($_SESSION);



$pagename = "waiter_master.php";

$module = "Employee Master";

$submodule = "EMPLOYEE MASTER";

$btn_name = "Save";

$keyvalue =0 ;

$tblname = "m_waiter";

$tblpkey = "waiter_id";

if(isset($_GET['waiter_id']))

    $keyvalue = $_GET['waiter_id'];

else

    $waiter_id = "";



if(isset($_GET['action']))

    $action = addslashes(trim($_GET['action']));

else

$action = "";

$status = "";

$duplicate = "";



//$password = "";

$waiter_name = $mobile = $address = $email = $status = $password = $designation = $biometric_id = $job_type = "";



//$company_id= $_SESSION['company_id'];



if(isset($_POST['submit']))

{	

	//print_r($_POST); die;



	$waiter_name = $obj->test_input($_POST['waiter_name']);

	$mobile = $obj->test_input($_POST['mobile']);

  $email = $obj->test_input($_POST['email']);

	$address = $obj->test_input($_POST['address']);

  $status = $obj->test_input($_POST['status']);

  $password = $obj->test_input($_POST['password']);

  $designation = $obj->test_input($_POST['designation']);

  $biometric_id = $obj->test_input($_POST['biometric_id']);

  $job_type = $obj->test_input($_POST['job_type']);



    //check Duplicate

   /* $cwhere = array("biometric_id"=>$_POST['biometric_id']);

    $count = $obj->count_method("m_waiter",$cwhere);

    if($count > 0 && $keyvalue == 0 )

    {



     $duplicate="<div class='alert alert-danger'>

     <strong>Error!</strong> Error : Duplicate Record.

     </div>";

 } 

 else{*/

			//insert

			//echo $keyvalue; die;

    if($keyvalue == 0)

    {   

        $form_data = array('designation'=>$designation,'biometric_id'=>$biometric_id,'waiter_name'=>$waiter_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'password'=>$password,'status'=>$status,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'job_type'=>$job_type);

        $obj->insert_record($tblname,$form_data); 

	//print_r($form_data); die;

        $action=1;

        $process = "insert";

        echo "<script>location='$pagename?action=$action'</script>";

    }

    else{

				//update

       $form_data = array('designation'=>$designation,'biometric_id'=>$biometric_id,'waiter_name'=>$waiter_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'status'=>$status,'password'=>$password,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'job_type'=>$job_type);

        $where = array($tblpkey=>$keyvalue);

        $keyvalue = $obj->update_record($tblname,$where,$form_data);

        $action=2;

        $process = "updated";



    }

    echo "<script>location='$pagename?action=$action'</script>";



}

//}

if(isset($_GET[$tblpkey]))

{ 



	$btn_name = "Update";

	$where = array($tblpkey=>$keyvalue);

	$sqledit = $obj->select_record($tblname,$where);

	$waiter_name =  $sqledit['waiter_name'];

	$mobile =  $sqledit['mobile'];

	$address =  $sqledit['address'];

	$email =  $sqledit['email'];

  $password  = $sqledit['password'];

  $status  = $sqledit['status'];

  $designation  = $sqledit['designation'];

  $biometric_id  = $sqledit['biometric_id'];

  $job_type  = $sqledit['job_type'];

   

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

                            <label>Employee Name <span class="text-error">*</span></label>

                            <span class="field"><input type="text" name="waiter_name" id="waiter_name" class="input-xxlarge" value="<?php echo $waiter_name;?>" placeholder="Employee Name" autocomplete="off" autofocus/></span>

                        </p>

                        <p>

                            <label>Biometric Id <span class="text-error"></span></label>

                            <span class="field"><input type="text" name="biometric_id" id="biometric_id" class="input-xxlarge" value="<?php echo $biometric_id;?>" placeholder="Enter Biometric Id" autocomplete="off" autofocus/></span>

                        </p>







                        <p>

                            <label>Mobile No:<span class="text-error">*</span></label>

                            <span class="field"><input type="text" name="mobile" placeholder="Mobile No." id="mobile" autocomplete="off" class="input-xxlarge" value="<?php echo $mobile;?>" maxlength="10" autofocus/></span>

                        </p>

                        <p>

                            <label>Email Id : </label>

                            <span class="field"><input type="email" placeholder="Email Id" autocomplete="off" name="email" id="email" class="input-xxlarge" value="<?php echo $email;?>" autofocus/></span>

                        </p>

                         <p>

                            <label>Password:<span class="text-error">*</span></label>

                            <span class="field"><input type="text" placeholder="Password" autocomplete="off" name="password" id="password" class="input-xxlarge" value="<?php echo $password;?>" autofocus/></span>

                        </p>

                        <p>

                            <label>Address : </label>

                            <span class="field"><input type="text" placeholder="Address" autocomplete="off" name="address" id="address" class="input-xxlarge" value="<?php echo $address;?>" autofocus/></span>

                        </p> 

                        <p>

                            <label>Designation:<span class="text-error"></span></label>

                            <span class="field"><input type="text" placeholder="Enter Designation" autocomplete="off" name="designation" id="designation" class="input-xxlarge" value="<?php echo $designation;?>" autofocus/></span>

                        </p>



                        <p>

                            <label>Job Type:<span class="text-error"></span></label>

                            <span class="field"> <select name="job_type" id="job_type"  class="chzn-select" style="width:283px;" >

                                <option value="">---Select---</option>

                                <option value="md">MD</option>

                                <option value="manager">Manager</option>

                                <option value="captain">Captain</option>

                                <option value="steward">Waiter</option>

                                <option value="chef">Chef</option>

                                <option value="cook">Cook</option>

                                <option value="security_guard">Security Guard</option>

                            </select></span>

                            <script>document.getElementById('job_type').value = '<?php echo $job_type ; ?>';</script> </span>

                        </p>

                        

                        <div class="lg-12 md-12 sm-12">

                            <label>Status</label>

                            <span class="field">

                              <label><input type="radio" checked name="status"  value="enable" <?php if($status == "enable") echo 'checked';?>>&nbsp;&nbsp;Active </label>

                              <label><input type="radio" name="status"  value="disable"  <?php if($status == "disable") echo 'checked';?>>&nbsp;&nbsp;Inactive</label>

                          </span>            

                      </div>   



                      <center> <p class="stdformbutton">

                        <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('waiter_name,mobile nu,password');" />

                        <?php echo $btn_name; ?></button>

                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>

                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">

                    </p> </center>

                </form>

            </div>

            <!-- for print pdf -->

            <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_waiter_master.php" class="btn btn-info" target="_blank">

                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>



              <?php  $chkview = $obj->check_pageview("waiter_master.php",$loginid);             

              if($chkview == 1 || $usertype == 'admin'){  ?>

                   

                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>

                    <table class="table table-bordered" id="dyntable">

                        

                        <thead>

                            <tr>

                                <th class="head0 nosort">S.No.</th>

                                <th class="head0">Employee Name</th>    

                                <th class="head0">Mobile No</th> 

                                <th class="head0">Biometric Id</th> 

                                <th class="head0">Email</th>  

                                <th class="head0">Password</th>  

                                <th class="head0">Address</th>

                                <th class="head0">Job Type</th>

                                <th class="head0">Designation</th>

                                <th class="head0">Status</th>

                                <?php  $chkedit = $obj->check_editBtn("waiter_master.php",$loginid);              

                                if($chkedit == 1 || $usertype == 'admin'){  ?>

                                <th class="head0">Edit</th><?php } ?>

                                <?php  $chkdel = $obj->check_delBtn("waiter_master.php",$loginid);             

                                if($chkdel == 1 || $usertype == 'admin'){  ?>

                                <th class="head0">Delete</th><?php } ?>

                            </tr>

                        </thead>

                        <tbody>

                        

                        <?php

                        $slno=1;

                        //$where = array("waiter_id"=>$waiter_id);

                        $res = $obj->executequery("select * from m_waiter  order by waiter_id desc");

                        foreach ($res as $row_get )



                        {

                            // $state_id = $row_get['state_id'];

                            // $state_name = $obj->getvalfield("m_state","state_name","state_id='$state_id'");

                          $job_type = $row_get['job_type'];

                          if($job_type=='steward')

                            $job_type = 'Waiter';

                         ?> 

                         <tr>

                            <td><?php echo $slno++; ?></td> 

                            <td><?php echo strtoupper($row_get['waiter_name']); ?></td>  

                            <td><?php echo $row_get['mobile']; ?></td> 

                            <td><?php echo $row_get['biometric_id']; ?></td> 

                            <td><?php echo $row_get['email']; ?></td> 

                            <td><?php echo $row_get['password']; ?></td> 

                            <td><?php echo strtoupper($row_get['address']); ?></td> 

                            <td><?php echo strtoupper($job_type); ?></td> 

                            <td><?php echo strtoupper($row_get['designation']); ?></td> 

                            <td><?php 

                            $status = $row_get['status'];

                            if ($status =='enable') {

                                echo "<span style=color:green;>Enable</span>";

                            }

                            else{echo "<span style=color:red;>Disable</span>";}

                             ?></td> 

                            <?php if($chkedit == 1 || $usertype == 'admin'){  ?>

                            <td><a class='icon-edit' title="Edit" href='waiter_master.php?waiter_id=<?php echo $row_get['waiter_id'] ; ?>'></a></td><?php } ?>

                             <?php  if($chkdel == 1 || $usertype == 'admin'){  ?>

                            <td>

                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['waiter_id']; ?>);' style='cursor:pointer'></a>

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

