<?php include("../adminsession.php");
$pagename = "employee_attendence_datewise_report.php";
$module = "Employee Attendance Datewise Report";
$submodule = "Employee Attendance Datewise Report";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "attendance_entry";
$tblpkey = "attendance_id";

if(isset($_GET['action']))
$action = $obj->test_input($_GET['action']);
else
$action = "";
$waiter_id = "";

$crit = " where 1 = 1";
if(isset($_GET['from_date']))
{
    $from_date = $obj->dateformatusa($_GET['from_date']);
}

else
{
  $from_date =date('Y-m-d');
}



?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                    <form class="stdform stdform2" method="get" action="">
                   
                       <div class="lg-12 md-12 sm-12">
                                <table class="table table-bordered" > 
                                <tr>
                                 <th width="22%">Date</th>
                                <!--  <th width="22%">Employee Name</th> -->
                               </tr>
                                <tr> 
                                    <td><input type="text" name="from_date" id="from_date" class="input-medium"  placeholder='dd-mm-yyyy'
                                    value="<?php echo $obj->dateformatindia($from_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                                 </tr>
                                 <tr>
                                <td colspan="4">
                        <center><button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster(''); ">
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a></center>
                     
                                </td>
                                </tr>
                                </table>   
                        </form>
                     </div>  
                       
                    </div>

                    <?php $chkview = $obj->check_pageview("employee_attendence_datewise_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                   
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_employee_atandancedatewise_report.php?from_date=<?php echo $obj->dateformatindia($from_date); ?>" class="btn btn-info" target="_blank">
                    
                    <span style="#000; color:#FFF">Print PDF</span></a></p>
                 
              <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    
                    <table class="table table-bordered" id="myTable1" >
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
                    <th class="head0">Employee Name</th>
                    <th class="head0">Status</th>
                    <th class="head0">Date</th>  
                    <th class="head0">Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php

                       $slno=1;
                       $res = $obj->executequery("select * from m_waiter");
                       foreach ($res as $key) 
                       {
                         $waiter_id = $key['waiter_id'];
                         $waiter_name = $key['waiter_name'];

                         $attendance_date = $obj->getvalfield("attendance_entry","attendance_date","waiter_id='$waiter_id' and attendance_date='$from_date'");

                          $attendance_time = $obj->getvalfield("attendance_entry","attendance_time","waiter_id='$waiter_id' and attendance_date='$from_date'");

                           if($attendance_time == "")
                           $atype = "<span style='color:red'>Absent</span>";
                           else
                           $atype = "<span style='color:green'>Present</span>";

                    ?>
                 <tr>
                         
                      <td><?php echo $slno++; ?></td>
                      <td><?php echo $waiter_name; ?></td>
                      <td><?php echo $atype; ?></td>
                      <td><?php echo $obj->dateformatindia($attendance_date); ?></td>
                      <td><?php echo $attendance_time; ?></td>

                 </tr>
                    <?php  
                     }
                    ?>         
                    </tbody>
                    </table>
                    <?php  
                     }
                    ?>    
                 
               
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
    
 jQuery('#from_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});


</script>
</body>
</html>
