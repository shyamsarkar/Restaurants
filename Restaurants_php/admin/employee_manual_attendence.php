<?php include("../adminsession.php");
$pagename = "employee_manual_attendence.php";
$module = "Employee Manual Attendance";
$submodule = "Employee Attendance Report";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "attendance_entry";
$tblpkey = "attendance_id";
if(isset($_GET['attendance_id']))
$keyvalue = $_GET['attendance_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$crit = " where 1 = 1";

if(isset($_GET['attendance_date']))
{
    $attendance_date = $obj->dateformatusa(trim(addslashes($_GET['attendance_date'])));
    $crit .= " and attendance_date='$attendance_date' ";      
}
else
{
    $attendance_date= date('Y-m-d');
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
                        <th width="22%">Date <span style="color:#F00;"> * </span> </th>
                        <th width="31%">Action </th>
                        </tr>
                        <tr> 
                        <td><input type="text" name="attendance_date" id="attendance_date" class="input-xxlarge" style="width:80%" value="<?php echo $obj->dateformatindia($attendance_date);?>"   autocomplete="off" placeholder="dd-mm-yyyy" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/> </td>

                        <td>
                        <button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('attendance_date'); ">
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>

                        </td>

                        </tr>
                        </table>   
                    </form>
                     </div>  
                       
                    </div>

                     <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_emp_attendance_report.php?attendance_date=<?php echo $obj->dateformatindia($attendance_date); ?>" class="btn btn-info" target="_blank">
                    <span style="#000; color:#FFF">Print PDF</span></a></p>
                  

                  <?php $chkview = $obj->check_pageview("employee_manual_attendence.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
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
                    
                    <th width="10%" class="head0 nosort">S.No.</th>
                    <th width="21%" class="head0">Employee Name</th> 
                    <th width="22%" class="head0">Mobile</th>
                    <th width="22%" class="head0">Date/Time</th>
                    <th width="22%" class="head0">In Time</th>
                    <th width="22%" class="head0">Out Time</th>
                    <th width="22%" class="head0">Att_By</th>
                    <th width="22%" class="head0">Half_day</th>
                    <th width="22%" class="head0">Is_Half_day</th>
                    <th width="25%" class="head0">Action </th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    $slno=1;
                    $res = $obj->executequery("select * from m_waiter");
                    foreach($res as $rowget)
                    {
                        $waiter_id = $rowget['waiter_id'];
                        //  echo "<br>";
                        $count = $obj->getvalfield("attendance_entry","count(*)","attendance_date='$attendance_date' && waiter_id='$waiter_id'");   

                        $in_entry = $obj->getvalfield("attendance_entry","attendance_time","waiter_id='$waiter_id' and attendance_date='$attendance_date' order by attendance_id asc limit 0,1");

                        if($count > 1)
                        {
                          $out_entry = $obj->getvalfield("attendance_entry","attendance_time","waiter_id='$waiter_id' and attendance_date='$attendance_date' order by attendance_id desc limit 0,1");
                        }
                        else
                        $out_entry = "";

                        $attendanceby = $obj->getvalfield("attendance_entry","attendanceby","attendance_date='$attendance_date' && waiter_id='$waiter_id'");                    
                       if($count > 0)
                        {
                            $attendance_date=$obj->getvalfield("attendance_entry","attendance_date","attendance_date='$attendance_date' and waiter_id='$waiter_id'");

                            $attendance_time= $obj->getvalfield("attendance_entry","attendance_time","attendance_date='$attendance_date' and waiter_id='$waiter_id'");


                            $attendanceby = $obj->getvalfield("attendance_entry","attendanceby","attendance_date='$attendance_date' and waiter_id='$waiter_id'");

                            $msg='Present';
                            $class="btn btn-success";

                             $show_date_time = $attendance_date.' / '.$attendance_time;
                        }
                        else
                        {
                            $msg='Absent';
                            $class="btn btn-warning";
                            $show_date_time = "";
                           
                        }
                         if($attendanceby == 0){
                          $attype = "Manual";
                         }else
                         $attype = "Machine";

                          $half_day_status = $obj->getvalfield("attendance_entry","count(*)","waiter_id='$waiter_id' and is_half_day=1 and attendance_date='$attendance_date'");
                         $is_half_day = $obj->getvalfield("attendance_entry","is_half_day","waiter_id='$waiter_id' and attendance_date='$attendance_date'");
                         if($half_day_status > 0)
                        {
                          $half_day1 = 'Yes';
                        }
                        else
                        {
                          $half_day1 = 'No';
                        }
                        
                    ?>
                 <tr>
                      <td><?php echo $slno++; ?></td> 
                      <td><?php echo $rowget['waiter_name']; ?></td> 
                      <td><?php echo $rowget['mobile']; ?></td>
                      <td id="atte_date<?php echo $waiter_id; ?>"><?php echo $show_date_time; ?></td> 
                      <td><?php echo $in_entry; ?></td>
                      <td><?php echo $out_entry; ?></td>
                      <td><?php echo $attype; ?></td>
                      <td><?php echo $half_day1; ?></td>
                       <td>
                        <button class="btn btn-primary" onClick="save_attandance('<?php echo $is_half_day; ?>','<?php echo $waiter_id; ?>','<?php echo $rowget['waiter_name']; ?>','<?php echo $count; ?>');" > Half_Day </button>
                      </td>
                      <td>
                        
                       <?php if($attendanceby == 0){ ?>
                      <button id="attendance<?php echo $waiter_id; ?>" class="<?php echo $class; ?>" onClick="makeattendance('<?php echo $waiter_id; ?>');" > <?php echo $msg; ?> </button>
                    <?php } ?> 
                    
                      </td>
                     
                    
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

    function makeattendance(waiter_id)
    { 

        var attendance_date=document.getElementById('attendance_date').value;
//alert(emp_attendance_date);

        if(waiter_id !='')
        {
          
            jQuery.ajax({
              type: 'POST',
              url: 'empattendance.php',
              data: 'waiter_id='+waiter_id+'&attendance_date='+attendance_date,
              dataType: 'html',
              success: function(data){

                var obj = JSON.parse(data);
                //alert(data);
              //  namestr = 'atte_date' + employee_id + 'atte_time' + employee_id;
              // alert(namestr);
                if(obj.status=="Present")
                {
                    
                    document.getElementById('attendance'+waiter_id).className='btn btn-success';
                    document.getElementById('attendance'+waiter_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+waiter_id).innerHTML = obj.date+ ' ' +obj.time;
                   
                }
                else
                {
                     
                    document.getElementById('attendance'+waiter_id).className='btn btn-warning';
                    document.getElementById('attendance'+waiter_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+waiter_id).innerHTML = '';
                  
                }
                 }
              });//ajax close
        }
    }
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
                  var obj = JSON.parse(data);
                //alert(data);
              //  namestr = 'atte_date' + employee_id + 'atte_time' + employee_id;
              // alert(namestr);
                if(obj.status=="Present")
                {
                    
                    document.getElementById('attendance'+waiter_id).className='btn btn-success';
                    document.getElementById('attendance'+waiter_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+waiter_id).innerHTML = obj.date+ ' ' +obj.time;
                   
                }
                else
                {
                     
                    document.getElementById('attendance'+waiter_id).className='btn btn-warning';
                    document.getElementById('attendance'+waiter_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+waiter_id).innerHTML = '';
                  
                }
                   location='<?php echo $pagename."?action=3" ; ?>';
                }
                
              });//ajax close
        }//confirm close
    } //fun close
    
jQuery('#emp_attendance_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#emp_attendance_date').focus();

function save_attandance(is_half_day,waiter_id,waiter_name,count)
{

 
  if(count > 0)
  {

 var attendance_date='<?php echo $attendance_date; ?>';

  if(confirm("Are you sure! You want to make half day " +waiter_name))
        {

   jQuery.ajax({
        type: 'POST',
        url: 'save_attandance.php',
        data: 'waiter_id='+waiter_id+'&attendance_date='+attendance_date+'&is_half_day='+is_half_day,
        dataType: 'html',
        success: function(data){          
          //alert(data);
         var obj = JSON.parse(data);
        if(obj.status=="Present")
                {
                    
                    document.getElementById('attendance'+waiter_id).className='btn btn-success';
                    document.getElementById('attendance'+waiter_id).innerHTML = obj.status;
                    document.getElementById('atte_date'+waiter_id).innerHTML = obj.date+ ' ' +obj.time;
                   
                   
                }
               // 
                // else
                // {
                     
                //     document.getElementById('attendance'+waiter_id).className='btn btn-warning';
                //     document.getElementById('attendance'+waiter_id).innerHTML = obj.status;
                //     document.getElementById('atte_date'+waiter_id).innerHTML = '';
                  
                // }
                location = 'employee_manual_attendence.php';
         

                       }
        });//ajax close
 }//close if loop 2 st
}//close if loop 1 st
else
{
  alert("Please mention attendence!");
}
        
    }

  </script>
</body>
</html>
