<?php include("../adminsession.php");
$pagename = "company_master.php";
$module = "CompanyMaster";
$submodule = "COMPANY MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "company_setting";
$tblpkey = "compid";
$keyvalue = 1;

if(isset($_GET['action']))
    $action = $obj->test_input($_GET['action']);
else
    $action = "";
$status = "";
$dup = "";
$comp_name = $mobile = $mobile2 = $gstno = $address = $address2 = $term_cond = $email1= $email2 = $landlineno = $fssai_no = "";
if(isset($_POST['submit']))
{	//print_r($_POST); die;

  $comp_name = $obj->test_input($_POST['comp_name']);
  $mobile = $obj->test_input($_POST['mobile']);
  $mobile2 = $obj->test_input($_POST['mobile2']);
  $gstno = $obj->test_input($_POST['gstno']);
  $address = $obj->test_input($_POST['address']); 
  $address2 = $obj->test_input($_POST['address2']);
  $term_cond  = $obj->test_input($_POST['term_cond']);
  $email1  = $obj->test_input($_POST['email1']);
  $email2  = $obj->test_input($_POST['email2']);  
  $landlineno =  $obj->test_input($_POST['landlineno']);  
  $fssai_no =  $obj->test_input($_POST['fssai_no']);  

    
	//update
  $form_data = array('comp_name'=>$comp_name,'mobile'=>$mobile,'mobile2'=>$mobile2,'gstno'=>$gstno,'address'=>$address,'address2'=>$address2,'term_cond'=>$term_cond,'email1'=>$email1,'email2'=>$email2,'landlineno'=>$landlineno,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'fssai_no'=>$fssai_no);
  $where = array($tblpkey=>$keyvalue);
  $keyvalue = $obj->update_record($tblname,$where,$form_data);
  $action=2;
  $process = "updated";
  echo "<script>location='$pagename?action=$action'</script>";
       

}
if($keyvalue!=0)
{ 

	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$comp_name =  $sqledit['comp_name'];
	$mobile =  $sqledit['mobile'];
  $mobile2 = $sqledit['mobile2'];
  $gstno =  $sqledit['gstno'];
	$address =  $sqledit['address'];
  $address2 =  $sqledit['address2'];
  $term_cond =  $sqledit['term_cond'];
	$email1 =  $sqledit['email1'];
  $email2 =  $sqledit['email2'];
  $landlineno = $sqledit['landlineno'];
  $fssai_no = $sqledit['fssai_no'];
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
                                <label>Company Name <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="comp_name" id="comp_name" class="input-xxlarge" value="<?php echo $comp_name;?>" placeholder="Enter Company Name" autofocus/></span>
                            </p>
                            <p>
                                <label>GSTIN Number <span class="text-error"></span></label>
                                <span class="field"><input type="text" name="gstno" id="gstno" class="input-xxlarge" value="<?php echo $gstno;?>" autofocus/></span>
                            </p>
                            <p>
                                <label>Landline Number <span class="text-error"></span></label>
                                <span class="field"><input type="text" name="landlineno" id="landlineno" maxlength="12" class="input-xxlarge" value="<?php echo $landlineno;?>" autofocus/></span>
                            </p>
                            <p>
                                <label>Mobile No 1:</label>
                                <span class="field"><input type="text" name="mobile" id="mobile" class="input-xxlarge" value="<?php echo $mobile;?>" maxlength="10"/></span>
                            </p>
                            
                             <p>
                                <label>Mobile No 2:</label>
                                <span class="field"><input type="text" name="mobile2" id="mobile2" class="input-xxlarge" value="<?php echo $mobile2;?>" maxlength="10"/></span>
                            </p>
                            <p>
                                <label>Address1: <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="address" id="address" class="input-xxlarge" value="<?php echo $address;?>" /></span>
                            </p>
                            
                             <p>
                                <label>Address2: <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="address2" id="address2" class="input-xxlarge" value="<?php echo $address2;?>" autofocus/></span>
                            </p>
                            
                             <p>
                                <label>Email1: </label>
                                <span class="field"><input type="text" name="email1" id="email1" class="input-xxlarge" value="<?php echo $email1;?>" /></span>
                            </p>
                            
                             <p>
                                <label>Email2: </label>
                                <span class="field"><input type="text" name="email2" id="email2" class="input-xxlarge" value="<?php echo $email2;?>" /></span>
                            </p>

                             <p>
                                <label>Fssai No.: </label>
                                <span class="field"><input type="text" name="fssai_no" id="fssai_no" class="input-xxlarge" value="<?php echo $fssai_no;?>" /></span>
                            </p>
                            
                            
                           <p>
                                <label>Terms & Condition: </label>
                                <span class="field"><textarea id="term_cond" name="term_cond" class="input-xxlarge"> <?php echo $term_cond;?></textarea>
                               </span>
                            </p>


                        <center> <p class="stdformbutton">
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('comp_name,address,address2');">
                                <?php echo $btn_name; ?></button>
                                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
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
</body>
</html>
