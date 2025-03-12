<?php include("../adminsession.php");
$pagename = "userprivilege_master.php";
$module = "Add Privilege Master";
$submodule = "Privilege Master";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_userprivilege";
$tblpkey = "page_id";
if(isset($_GET['page_id']))
$keyvalue = $_GET['page_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

if(isset($_POST['submit']))
{
	$menuname = test_input($_POST['menuname']);
	$pagelink = test_input($_POST['pagelink']);
	$page_heading = test_input($_POST['page_heading']);

	
	//check Duplicate
	//$check = check_duplicate($tblname,"pagelink = '$pagelink' and $tblpkey <> '$keyvalue'");
	if($check > 0)
	{
		$dup = " Error : Duplicate Record";
	}
	else
	{
		if($keyvalue == 0)
		{
			//insert
			$form_data = array('menuname'=>$menuname,'pagelink'=>$pagelink,'page_heading'=>$page_heading,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			  $obj->insert_record($tblname,$form_data);
			  $action=1;
			  $process = "insert";
		}
		else
		{
			//update
			$form_data = array('menuname'=>$menuname,'pagelink'=>$pagelink,'page_heading'=>$page_heading,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
				$where = array($tblpkey=>$keyvalue);
				$keyvalue = $obj->update_record($tblname,$where,$form_data);
				$action=2;
				$process = "updated";
		}
		 $cmn->InsertLog($pagename, $module, $submodule, $tblname, $tblpkey, $keyvalue, $process);
		 echo "<script>location='$pagename?action=$action'</script>";
		
	}
}

if(isset($_GET[$tblpkey]))
{
	$btn_name = "Update";
	$where = array($tblpkey=>$keyvalue);
	$sqledit = $obj->select_record($tblname,$where);
	$menuname =  $sqledit['menuname'];	 
	$pagelink = $sqledit['pagelink'];
	$page_heading = $sqledit['page_heading'];
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
                                <label>Menu Name  <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="menuname" id="menuname" class="input-xxlarge" value="<?php echo $menuname;?>" autofocus/></span>
                            </p>
                             <p>
                                <label>Sub Menu<span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="page_heading" id="page_heading" class="input-xxlarge" value="<?php echo $page_heading;?>"/></span>
                            </p>
                             <p>
                                <label>Page Link <span class="text-error">*</span></label>
                                <span class="field"><input type="text" name="pagelink" id="pagelink" class="input-xxlarge" value="<?php echo $pagelink;?>"/></span>
                            </p>
                            
                            
                            
                            
                            
                            
                             <center> <p class="stdformbutton">
                                <button  type="submit" name="submit"class="btn btn-primary" onClick="return checkinputmaster('menuname,pagelink,state_id'); "><?php echo $btn_name; ?></button>
                                <button type="reset" class="btn">Reset</button>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                            </p> </center>
                        </form>
                    </div>
                    
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
                            <th class="head0">Heading </th>
                            <th class="head0">Page Link</th>                            
                            <th class="head0">Edit / Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                           </span></td>
                               <?php
											  $slno=1;
                                              $where = array(1=1);
                                              $sql_get = $obj->select_data("m_userprivilege",$where);
                                              foreach($res as $row_get)
											{
											 
												
												?> <tr>
                                                <td><?php echo $slno++; ?></td> 
                                                <td><?php echo $row_get['menuname'] ; ?></td>                                                 
                                                <td><?php echo $row_get['pagelink'] ; ?></td>  
                             
                              <td><a class='icon-edit' href='userprivilege_master.php?page_id=<?php echo $row_get['page_id'] ; ?>'></a>
                              <a class='icon-remove' onclick='funDel(<?php echo $row_get['page_id'] ; ?>);' style='cursor:pointer'></a></td>
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
    <!--footer-->

    
</div><!--mainwrapper-->

<script type="text/javascript">
    
 // $('#partyid').trigger('chosen:activate'); // for autofocus
 
</script>
</body>

</html>
