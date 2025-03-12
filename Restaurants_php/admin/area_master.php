<?php include("../adminsession.php");
$pagename = "area_master.php";
$module = "AreaMaster";
$submodule = "AREA MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_area";
$tblpkey = "area_id";
if(isset($_GET['area_id']))
$keyvalue = $_GET['area_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$area_name = "";
$area_code = "";
if(isset($_POST['submit']))
{
	//print_r($_POST);die;
 $area_name = $_POST['area_name'];
 $area_code = $_POST['area_code'];
 $city_id = $_POST['city_id'];
  
	 //check Duplicate
		$cwhere = array("area_name"=>$_POST['area_name'],"area_code"=>$_POST['area_code']);
		 $count = $obj->count_method("m_area",$cwhere);
         // print_r($count);
		if ($count > 0 && $keyvalue == 0) 
				{ 
			$dup="<div class='alert alert-danger'>
			<strong>Error!</strong> Duplicate Record.
			</div>";
			//echo $dup; die;
				} 
			else //insert
			 {	
				if($keyvalue == 0)
			  {    
				$form_data = array('area_name'=>$area_name,'area_code'=>$area_code,'city_id'=>$city_id,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
				$obj->insert_record($tblname,$form_data);
				$action=1;
				$process = "insert";
				echo "<script>location='$pagename?action=$action'</script>";
			  }
				else
				{
					//update
					$form_data = array('area_name'=>$area_name,'area_code'=>$area_code,'city_id'=>$city_id,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
					$where = array($tblpkey=>$keyvalue);
					$keyvalue = $obj->update_record($tblname,$where,$form_data);
					$action=2;
					$process = "updated";
				}
				echo "<script>location='$pagename?action=$action'</script>";
} }
if(isset($_GET[$tblpkey]))
{ 

	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$area_name =  $sqledit['area_name'];
    $area_code =  $sqledit['area_code'];
	$city_id =  $sqledit['city_id'];
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
                       <div class="lg-12 md-12 sm-12">
                       <table class="table table-bordered"> 
                       <tr> 
                       <th>City Name<span style="color:#F00;">*</span></th>
                      <th>Area Name<span style="color:#F00;">*</span></th>
                      <th>Area Code</th>
                       </tr>
                       <tr> 
                       <td>
                                <select name="city_id" id="city_id"  class="chzn-select" style="width:200px;" >
                                <option value="" >---Select---</option>
                               <?php
                                $slno=1;
                                $res = $obj->fetch_record("m_city");
                                foreach($res as $row_get)
                                {
                                ?> 
                                <option value="<?php echo $row_get['city_id']; ?>"> <?php echo $row_get['city_name']; ?></option>						<?php }
                                ?>
                                </select>
                                <script>document.getElementById('city_id').value = '<?php echo $city_id ; ?>';</script>
                                </td>  
                                                              
         
                                <td> <input type="text" name="area_name" id="area_name" class="input-xlarge"  value="<?php echo $area_name;?>" autofocus autocomplete="off"  placeholder="Enter Area Name"/></td>
 
                                <td> <input type="text" name="area_code" id="area_code" class="input-xlarge"  value="<?php echo $area_code;?>" autofocus autocomplete="off"  placeholder="Enter Area Code"/></td>
                                
                                
                                <td><button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('city_id,area_name'); ">
                                <?php echo $btn_name; ?></button>
                                <a href="area_master.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>"></td>
                       </tr>
                       
                       </table>
                       </div>
                        </form>
                    </div>
                      
                    <!--<p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_class_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>-->
                <!--widgetcontent-->
                 <?php   $chkview = $obj->check_pageview("area_master.php",$loginid);							
						  if($chkview == 1 || $loginid == 1){  ?>
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
                        	
                            <th width="11%" class="head0 nosort">Sno.</th>
                            <th width="18%" class="head0">City Name</th>
                            <th width="18%" class="head0">Area Name</th>
                            <th width="18%" class="head0">Area Code</th>
							<?php   $chkedit = $obj->check_editBtn("area_master.php",$loginid);							
						  if($chkedit == 1 || $loginid == 1){  ?>
                            <th width="9%" class="head0">Edit</th>
                              <?php } ?>
                              
                                <?php  $chkdel = $obj->check_delBtn("area_master.php",$loginid);							
						  if($chkdel == 1 || $loginid == 1){  ?>                              
                            <th width="10%" class="head0">Delete</th> <?php } ?> 
                         </tr>
                    </thead>
                    <tbody>
                           </span>
				<?php
						$slno=1;
						//$res = $obj->fetch_record("m_area");
            $res = $obj->executequery("select * from m_area order by area_id desc");
						foreach($res as $row_get)
                {
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td>
                        <td><?php echo $obj->getvalfield("m_city","city_name","city_id='$row_get[city_id]'"); ?></td>
                        <td><?php echo $row_get['area_name']; ?></td>
                        <td><?php echo $row_get['area_code']; ?></td>
                        <?php if($chkedit == 1 || $loginid == 1){  ?>
                       <td><a class='icon-edit' title="Edit" href='area_master.php?area_id=<?php echo $row_get['area_id'] ; ?>'></a></td><?php } ?>
                        <?php  if($chkdel == 1 || $loginid == 1){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['area_id']; ?>);' style='cursor:pointer'></a>
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
				 // alert(data);
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close

  </script>
</body>
</html>
