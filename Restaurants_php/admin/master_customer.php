<?php include("../adminsession.php");
//print_r($_SESSION);

$pagename = "master_customer.php";
$module = "Party Master";
$submodule = "PARTY MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "master_customer";
$tblpkey = "customer_id";
if(isset($_GET['customer_id']))
$keyvalue = $_GET['customer_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$city_name = "";
$priv_bal = "";
//$password = "";
$customer_type = $customer_name = $mobile = $address = $email = $term_cond ="";
$panno =""; $gsttinno=""; $openingbal= ""; $open_bal_date=""; $customer_status ="";
$company_id= $_SESSION['company_id'];

if(isset($_POST['submit']))
{	
	//print_r($_POST); die;
	$customer_type = $obj->test_input($_POST['customer_type']);
	$customer_name = $obj->test_input($_POST['customer_name']);
	$mobile   = $obj->test_input($_POST['mobile']);
	$address  = $obj->test_input($_POST['address']);
	$email  = $obj->test_input($_POST['email']);
	$term_cond  = $obj->test_input($_POST['term_cond']);
	$panno = $obj->test_input($_POST['panno']);
	$gsttinno = $obj->test_input($_POST['gsttinno']);
	$openingbal  = $obj->test_input($_POST['openingbal']);
	$open_bal_date  = $obj->test_input($_POST['open_bal_date']);
	$customer_status  = $obj->test_input($_POST['customer_status']);
    $vendorgrp_id = $obj->test_input($_POST['vendorgrp_id']);
    $area_id = $obj->test_input($_POST['area_id']); 
    $priv_bal = $obj->test_input($_POST['priv_bal']);
    $password = $obj->test_input($_POST['password']);

	
    //check Duplicate
	$cwhere = array("customer_name"=>$_POST['customer_name']);
	$count = $obj->count_method("master_customer",$cwhere);
    if($count > 0 && $keyvalue == 0 )
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
				$form_data = array('password'=>$password,'customer_type'=>$customer_type,'customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'term_cond'=>$term_cond,'panno'=>$panno,'gsttinno'=>$gsttinno,'openingbal'=>$openingbal,'vendorgrp_id'=>$vendorgrp_id,'area_id'=>$area_id,'priv_bal'=>$priv_bal,'open_bal_date'=>$open_bal_date,'customer_status'=>$customer_status,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'company_id'=>$company_id);
				$obj->insert_record($tblname,$form_data); 
	//print_r($form_data); die;
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
			   else{
				//update
				$form_data = array('password'=>$password,'customer_type'=>$customer_type,'customer_name'=>$customer_name,'mobile'=>$mobile,'address'=>$address,'email'=>$email,'term_cond'=>$term_cond,'panno'=>$panno,'gsttinno'=>$gsttinno,'openingbal'=>$openingbal,'vendorgrp_id'=>$vendorgrp_id,'area_id'=>$area_id,'priv_bal'=>$priv_bal,'open_bal_date'=>$open_bal_date,'customer_status'=>$customer_status,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'company_id'=>$company_id);
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
	$customer_type =  $sqledit['customer_type'];
	$customer_name =  $sqledit['customer_name'];
	$mobile =  $sqledit['mobile'];
	$address =  $sqledit['address'];
	$email =  $sqledit['email'];
	$term_cond =  $sqledit['term_cond'];
	$gsttinno =  $sqledit['gsttinno'];
	$panno =  $sqledit['panno'];
	$openingbal =  $sqledit['openingbal'];
	$open_bal_date =  $sqledit['open_bal_date'];
	$customer_status =  $sqledit['customer_status'];
    $vendorgrp_id =  $sqledit['vendorgrp_id'];
    $area_id =  $sqledit['area_id'];
    $priv_bal = $sqledit['priv_bal'];
    $password = $sqledit['password'];
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
                                <label>Vendor Group <span class="text-error">*</span></label>
                                <span class="field"><select name="vendorgrp_id" id="vendorgrp_id" class="chzn-select" style="width:538px;">
                              <option value=""> Select</option>
                            <?php
                                $slno=1;

                                $res = $obj->fetch_record("m_vendorgrp");
                                foreach($res as $row_get)
                                {       
                                           
                                ?>
                                <option value="<?php echo $row_get['vendorgrp_id'];  ?>"> <?php echo $row_get['vendorgrp_name']; ?></option>
                                <?php } ?>
                             
                             </select>
                             <script>  document.getElementById('vendorgrp_id').value=(<?php echo $vendorgrp_id;?>); </script></span>

                            </p>
                    		<p>
                                <label>Party Name <span class="text-error">*</span></label>
                               <span class="field"><input type="text" name="customer_name" id="customer_name" class="input-xxlarge" value="<?php echo $customer_name;?>" placeholder="Party Name" autocomplete="off" autofocus/></span>
                            </p>
                                <p>
                                <label>Party Type <span class="text-error">*</span></label>
                                <span class="field"><select name="customer_type" id="customer_type" class="chzn-select" style="width:538px;">
                              <option value=""> Select</option>
                            <option value="customer">Customer/Party</option>
                            <option value="supplier">Supplier/Vendors</option>
                            <option value="emlpoyee">Employee</option>
                            <option value="both">Both</option>
                             </select>
                             <script>  document.getElementById('customer_type').value='<?php echo $customer_type;?>'; </script></span>
                            </p>
                             <p>
                                <label>Area Name:<span class="text-error">*</span></label>
                                <span class="field"><select name="area_id" id="area_id" class="chzn-select" style="width:538px;">
                              <option value=""> Select</option>
                                <?php
                                $slno=1;

                                $res = $obj->fetch_record("m_area");
                                foreach($res as $row_get)
                                {       
                                $city_id = $row_get['city_id']; 
                                $city_name = $obj->getvalfield("m_city","city_name","city_id='$row_get[city_id]'");              
                                ?>
                                <option value="<?php echo $row_get['area_id'];  ?>"> <?php echo $row_get['area_name']. " / ".$city_name; ?></option>
                                <?php } ?>
                             
                             </select>
                             <script>  document.getElementById('area_id').value=(<?php echo $area_id;?>); </script></span>
                            </p>
                     
                            <p>
                                <label>Mobile No:<span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="mobile" placeholder="Contact No." id="mobile" autocomplete="off" class="input-xxlarge" value="<?php echo $mobile;?>" maxlength="10" autofocus/></span>
                            </p>
                            <p>
                                <label>Password:<span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="password" placeholder="Enter Password" id="password" autocomplete="off" class="input-xxlarge"   autofocus/></span>
                            </p>
                             <p>
                                <label>PAN No.</label>
                                <span class="field"><input type="text" placeholder="PAN No." autocomplete="off" name="panno" id="panno" class="input-xxlarge" value="<?php echo $panno;?>" autofocus/></span>
                            </p><p>
                                <label>GSTIN NO:</label>
                                <span class="field"><input type="text" placeholder="GSTIN No." autocomplete="off" name="gsttinno" id="gsttinno" class="input-xxlarge" value="<?php echo $gsttinno;?>" autofocus/></span>
                            </p>
                            <p>
                                <label>Opening Bal:</label>
                                <span class="field"><input type="text" placeholder="Opening Balance" autocomplete="off" name="openingbal" id="openingbal" class="input-xxlarge" value="<?php echo $openingbal;?>" autofocus/></span>
                            </p>
                             <p>
                                <label>Balance Date:</label>
                                <span class="field"><input type="text" placeholder="Date" autocomplete="off" name="open_bal_date" id="open_bal_date" class="input-xxlarge" value="<?php echo $open_bal_date;?>" autofocus/></span>
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
                                <label>Add Privious Balance On Bill : </label>
                                <span class="field"><select name="priv_bal" id="priv_bal">
                                    <option value="">--Select--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            <script>  document.getElementById('priv_bal').value=(<?php echo $priv_bal;?>); </script></span>
                            </p> 
                            <p>
                                <label>Term & Conditions : </label>
                                <span class="field"><textarea name="term_cond" id="term_cond"   autofocus/><?php echo $term_cond;?></textarea></span>
                            </p> 	
                            
                            <div class="lg-12 md-12 sm-12">
                                <label>Status</label>
                                <span class="field">
                              <label><input type="radio" checked name="customer_status"  value="enable" <?php if($customer_status == "enable") echo 'checked';?>>&nbsp;&nbsp;Active </label>
                              <label><input type="radio" name="customer_status"  value="disable"  <?php if($customer_status == "disable") echo 'checked';?>>&nbsp;&nbsp;Inactive</label>
                                 </span>			
                     </div>   
                              
                                
                         <center> <p class="stdformbutton">
                         <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('vendorgrp_id,customer_name,customer_type,area_id,mobile nu');" />
								<?php echo $btn_name; ?></button>
                                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                      
                   <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_class_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>-->
                <!--widgetcontent-->
                
 
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
                            <th class="head0 nosort">S.No.</th>
                            <th class="head0">Party Name</th>  
                            <th class="head0">Party Type</th>  
                            <th class="head0">Mobile No</th>   
                            <th class="head0">Address</th> 
                            <th class="head0">Vendorgrp</th>
                            <th class="head0">PAN No</th> 
                            <th class="head0">GSTIN No</th> 
                            <th class="head0">Pri_Bal_Bill</th> 
                            <th class="head0">Opening Bal.</th> 
                            <th class="head0">Balance Date</th> 
                            <th class="head0">Status</th> 
                            <th class="head0">Edit</th>
                            <th class="head0">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                           </span>
                               <?php
									$slno=1;
                                   $where = array("company_id"=>$company_id);
						           $res = $obj->executequery("select * from master_customer where company_id =$company_id order by customer_id desc");
                                   
                                   {
                                   	   ?> 
   <tr>
            <td><?php echo $slno++; ?></td> 
            <td><?php echo $row_get['customer_name']; ?></td> 
            <td><?php echo $row_get['customer_type']; ?></td> 
            <td><?php echo $row_get['mobile']; ?></td> 
        	<td><?php echo $row_get['address']; ?></td> 
            <td><?php echo $vendorgrp_name; ?></td> 
            <td><?php echo $row_get['panno']; ?></td> 
		    <td><?php echo $row_get['gsttinno']; ?></td> 
            <td><?php echo $privbal; ?></td> 
            <td><?php echo $row_get['openingbal']; ?></td> 
			<td><?php echo $row_get['open_bal_date']; ?></td> 
            <td><?php echo $row_get['customer_status']; ?></td> 
            <td><a class='icon-edit' title="Edit" href='master_customer.php?customer_id=<?php echo $row_get['customer_id'] ; ?>'></a></td>
            <td>
            <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['customer_id']; ?>);' style='cursor:pointer'></a>
            </td>
            
 </tr>
                            
    <?php
    }
   
    ?>
                        
                        
                    </tbody>
                </table>

                
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
