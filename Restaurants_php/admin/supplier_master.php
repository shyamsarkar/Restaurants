<?php include("../adminsession.php");
//print_r($_SESSION);

$pagename = "supplier_master.php";
$module = "supplier_master Master";
$submodule = "ACCOUNT MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "master_supplier";
$tblpkey = "supplier_id";
if(isset($_GET['supplier_id']))
    $keyvalue = $_GET['supplier_id'];
else
    $supplier_id = "";

if(isset($_GET['action']))
    $action = addslashes(trim($_GET['action']));
else
    $action = "";
$status = "";
$dup = "";
$city_name = "";
$priv_bal = "";

$supplier_name = $mobile = $address = $email = $supplier_status = $bank_name = $bank_ac = $bank_address = $state_id = $ifsc_code = $gstno = $type = "";

$openingbal = "";

if(isset($_POST['submit']))
{	
	//print_r($_POST); die;

	$supplier_name = $obj->test_input($_POST['supplier_name']);
	$mobile   = $obj->test_input($_POST['mobile']);
	$address  = $obj->test_input($_POST['address']);
	$email  = $obj->test_input($_POST['email']);
    $supplier_status  = $obj->test_input($_POST['supplier_status']);
    $bank_name = $obj->test_input($_POST['bank_name']);
    $ifsc_code   = $obj->test_input($_POST['ifsc_code']);
    $bank_ac  = $obj->test_input($_POST['bank_ac']);
    $bank_address  = $obj->test_input($_POST['bank_address']);
    if(isset($_POST['state_id']))
    {
        $state_id  = $obj->test_input($_POST['state_id']);
    }
    
    $gstno = $obj->test_input($_POST['gstno']);
    $openingbal  = $obj->test_input($_POST['openingbal']);
    $type  = $obj->test_input($_POST['type']);
    $open_bal_date = $obj->dateformatusa($_POST['open_bal_date']);


    //check Duplicate
    //$cwhere = array("supplier_name"=>$_POST['supplier_name'],"mobile"=>$_POST['mobile']);
   // $count = $obj->count_method("master_supplier",$cwhere);
    $count = $obj->getvalfield("master_supplier","count(*)","supplier_name='$supplier_name' and mobile='$mobile' and supplier_id!='$keyvalue'");
    if($count > 0)
    {

     $dup="<div class='alert alert-danger'>
     <strong>Error!</strong> Error : Duplicate Record.
     </div>";
 } 
 else{
			//insert
			//echo $keyvalue; die;
    if($keyvalue == 0)
    {   
        $form_data = array('supplier_name'=>$supplier_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'supplier_status'=>$supplier_status,'bank_name'=>$bank_name,'ifsc_code'=>$ifsc_code,'bank_ac'=>$bank_ac,'bank_address'=>$bank_address,'state_id'=>$state_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'type'=>$type);
        $obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
    }
    else{
				//update
        $form_data = array('supplier_name'=>$supplier_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'supplier_status'=>$supplier_status,'bank_name'=>$bank_name,'ifsc_code'=>$ifsc_code,'bank_ac'=>$bank_ac,'bank_address'=>$bank_address,'state_id'=>$state_id,'ipaddress'=>$ipaddress,'createdate'=>$createdate,'gstno'=>$gstno,'openingbal'=>$openingbal,'open_bal_date'=>$open_bal_date,'type'=>$type);
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
	$supplier_name =  $sqledit['supplier_name'];
	$mobile =  $sqledit['mobile'];
	$address =  $sqledit['address'];
	$email =  $sqledit['email'];
    $bank_name =  $sqledit['bank_name'];
    $bank_ac =  $sqledit['bank_ac'];
    $ifsc_code =  $sqledit['ifsc_code'];
    $bank_address =  $sqledit['bank_address'];
    $state_id =  $sqledit['state_id'];
    $gstno =  $sqledit['gstno'];
    $openingbal =  $sqledit['openingbal'];
    $type =  $sqledit['type'];
    $open_bal_date =  $obj->dateformatindia($sqledit['open_bal_date']);
    

}
else
{
    $open_bal_date = date('d-m-Y');
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
                            <label>Supplier / Party Name <span class="text-error">*</span></label>
                            <span class="field"><input type="text" name="supplier_name" id="supplier_name" class="input-xxlarge" value="<?php echo $supplier_name;?>" placeholder="Supplier / Party Name" autocomplete="off" autofocus/></span>
                        </p>


                        <p>
                            <label>Mobile No:<span class="text-error">*</span></label>
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

                        <p>
                            <label>GST No. <span class="text-error"></span></label>
                            <span class="field"><input type="text" name="gstno" id="gstno" class="input-xxlarge" value="<?php echo $gstno;?>" placeholder="Enter GST Number" autocomplete="off" autofocus/></span>
                        </p>

                         <p>
                            <label>Opening Balance: <span class="text-error"></span></label>
                            <span class="field"><input type="text" name="openingbal" id="openingbal" class="input-xxlarge" value="<?php echo $openingbal;?>" placeholder="Enter Opening Balance" autocomplete="off" autofocus/></span>
                        </p>

                         <p>
                            <label>Opening Date: <span class="text-error"></span></label>
                            <span class="field"><input type="text" name="open_bal_date" id="open_bal_date" class="input-xlarge"  value="<?php echo $open_bal_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></span>
                        </p>

                        <p>
                            <label>Bank Name <span class="text-error"></span></label>
                            <span class="field"><input type="text" name="bank_name" id="bank_name" class="input-xxlarge" value="<?php echo $bank_name;?>" placeholder="Bank Name" autocomplete="off" autofocus/></span>
                        </p>

                        <p>
                            <label>Bank A/C:<span class="text-error"></span></label>
                            <span class="field"><input type="text" name="bank_ac" placeholder="Bank A/C" id="bank_ac" autocomplete="off" class="input-xxlarge" value="<?php echo $bank_ac;?>" autofocus/></span>
                        </p>
                        <p>
                            <label>IFSC Code :<span class="text-error"></span> </label>
                            <span class="field"><input type="text" placeholder="IFSC Code" autocomplete="off" name="ifsc_code" id="ifsc_code" class="input-xxlarge" value="<?php echo $ifsc_code;?>" autofocus/></span>
                        </p>
                        <p>
                            <label>Bank Address :<span class="text-error"></span> </label>
                            <span class="field"><input type="text" placeholder="Bank Address" autocomplete="off" name="bank_address" id="bank_address" class="input-xxlarge" value="<?php echo $bank_address;?>" autofocus/></span>
                        </p> 
                        <p>
                            <label>State Name : </label>
                            <span class="field">
                                <select name="state_id" id="state_id"  class="chzn-select" style="width:283px;" >
                                <option value="">---Select---</option>
                                <?php
                                $crow=$obj->executequery("select * from m_state");
                                foreach ($crow as $cres) {

                                    ?>
                                    <option value="<?php echo $cres['state_id']; ?>"><?php echo $cres['state_name']; ?></option>
                                    <?php
                                }
                                ?>

                            </select></span>
                            <script>document.getElementById('state_id').value = '<?php echo $state_id ; ?>';</script> 

                        </p> 

                        <p>
                            <label>Type : <span class="text-error">*</span></label>
                            <span class="field">
                                <select name="type" id="type"  class="chzn-select" style="width:283px;" >
                                <option value="">---Select---</option>
                                <option value="Supplier">Supplier</option>
                                <option value="Party">Party</option>
                               

                            </select></span>
                            <script>document.getElementById('type').value = '<?php echo $type ; ?>';</script> 

                        </p> 
                        <div class="lg-12 md-12 sm-12">
                            <label>Status</label>
                            <span class="field">
                              <label><input type="radio" checked name="supplier_status"  value="enable" <?php if($supplier_status == "enable") echo 'checked';?>>&nbsp;&nbsp;Active </label>
                              <label><input type="radio" name="supplier_status"  value="disable"  <?php if($supplier_status == "disable") echo 'checked';?>>&nbsp;&nbsp;Inactive</label>
                          </span>            
                      </div>   

                      <center> <p class="stdformbutton">
                        <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('supplier_name,mobile,type');" />
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                    </p> </center>
                </form>
            </div>

                  <?php   $chkview = $obj->check_pageview("supplier_master.php",$loginid);             
              if($chkview == 1 || $usertype == 'admin'){  ?>
                    <!--widgetcontent-->
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <table class="table table-bordered">
                        
                        <thead>
                            <tr>
                                <th class="head0 nosort">S.No.</th>
                                <th class="head0">Supplier Name</th>    
                                <th class="head0">Mobile No</th>   
                                <th class="head0">Address</th>
                                <th class="head0">Email</th>
                                <th class="head0">Bank Name</th>    
                                <th class="head0">Bank A/C</th>   
                                <th class="head0">IFSC code</th> 
                                <th class="head0">Bank Address</th> 
                                <th class="head0">State Name</th> 
                                 <?php  $chkedit = $obj->check_editBtn("supplier_master.php",$loginid);              
                            if($chkedit == 1 || $usertype == 'admin'){  ?>
                                <th class="head0">Edit</th><?php } ?>
                                <?php  $chkdel = $obj->check_delBtn("supplier_master.php",$loginid);             
                            if($chkdel == 1 || $usertype == 'admin'){  ?>
                                <th class="head0">Delete</th><?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                       
                        <?php
                        $slno=1;
                       
                        $res = $obj->executequery("select * from master_supplier order by supplier_id desc");
                        foreach ($res as $row_get )

                        {
                            $state_id = $row_get['state_id'];
                            $state_name = $obj->getvalfield("m_state","state_name","state_id='$state_id'");
                         ?> 
                         <tr>
                            <td><?php echo $slno++; ?></td> 
                            <td><?php echo $row_get['supplier_name']; ?></td>  
                            <td><?php echo $row_get['mobile']; ?></td> 
                            <td><?php echo $row_get['address']; ?></td> 
                            <td><?php echo $row_get['email']; ?></td>  
                            <td><?php echo $row_get['bank_name']; ?></td> 
                            <td><?php echo $row_get['bank_ac']; ?></td>
                            <td><?php echo $row_get['bank_address']; ?></td>  
                            <td><?php echo $row_get['ifsc_code']; ?></td>
                            <td><?php echo $state_name; ?></td>  
                            <?php if($chkedit == 1 || $usertype == 'admin'){  ?>   
                            <td><a class='icon-edit' title="Edit" href='supplier_master.php?supplier_id=<?php echo $row_get['supplier_id'] ; ?>'></a></td><?php } ?>
                            <?php  if($chkdel == 1 || $usertype == 'admin'){  ?>  
                            <td>
                                <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['supplier_id']; ?>);' style='cursor:pointer'></a>
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
