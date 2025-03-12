<?php include("../adminsession.php");
$pagename = "employee_attendence_report.php";
$module = "Employee Attendance Monthly Report";
$submodule = "Employee Attendance Monthly Report";
$btn_name = "Search";
$keyvalue =0 ;
$tblname = "attendance_entry";
$tblpkey = "attendance_id";
if(isset($_GET['attendance_id']))
$keyvalue = $_GET['attendance_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = $obj->test_input($_GET['action']);
else
$action = "";
$month = "";
$waiter_id = "";


$crit = " where 1 = 1";
//$crit2 = " where 1 = 1";

if(isset($_GET['month']) && isset($_GET['year']) )
{
    $month = $obj->test_input($_GET['month']);  
    $year = $obj->test_input($_GET['year']);
    $year_month = $year.'-'.$month;
    $crit .= " and DATE_FORMAT(attendance_date,'%Y-%m')='$year_month' ";
}

if(isset($_GET['waiter_id']) || $waiter_id !='')
{
    $waiter_id = $obj->test_input($_GET['waiter_id']);  
    $crit .= " and waiter_id='$waiter_id' ";      
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
                                 <th width="22%">Month</th>
                                 <th width="22%">Year</th>
                                 <th width="22%">Employee Name</th>
                                 
                               </tr>
                                <tr> 
                               <td>
                                <select name="month" id="month"  class="chzn-select" style="width: 200px;" >
                                  <option value="">-select-</option>
                                  <option value="01">JAN</option>
                                  <option value="02">FEB</option>
                                  <option value="03">MARCH</option>
                                  <option value="04">APRIL</option>
                                  <option value="05">MAY</option>
                                  <option value="06">JUNE</option>
                                  <option value="07">JULY</option>
                                  <option value="08">AUG</option>
                                  <option value="09">SEP</option>
                                  <option value="10">OCT</option>
                                  <option value="11">NOV</option>
                                  <option value="12">DEC</option>
                                </select>
                               
                                <script>document.getElementById("month").value="<?php echo $month; ?>" ;</script>
                                </td>
                                <td>
                                   <select name="year" id="year"  class="chzn-select" style="width: 200px;">
                                  <option value="">-select-</option>
                                  <option value="2017">2017</option>
                                  <option value="2018">2018</option>
                                  <option value="2019">2019</option>
                                  <option value="2020">2020</option>
                                  <option value="2021">2021</option>
                                  <option value="2022">2022</option>
                                  <option value="2023">2023</option>
                                  <option value="2024">2024</option>
                                  <option value="2025">2025</option>
                                </select>
                                <script>document.getElementById("year").value="<?php echo $year; ?>" ;</script>
                                </td>
                                <td>
                                <select name="waiter_id" id="waiter_id"  class="chzn-select" style="width:200px;">
                                <option value="">-select-</option>
                                <?php

                                $res = $obj->fetch_record("m_waiter");
                                foreach($res as $row)
                                {
                                ?> 
                                <option value="<?php echo $row['waiter_id']; ?>"><?php echo $row['waiter_name']; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                <script>document.getElementById("waiter_id").value="<?php echo $waiter_id; ?>" ;</script>
                                </td>          
                                 </tr>

                                 <tr>
                                <td colspan="4">
                        <center><button  type="submit" name="search" class="btn btn-primary" onClick="return checkinputmaster('month,year,waiter_id'); ">
                        <?php echo $btn_name; ?></button>
                        <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a></center>
                     
                                </td>
                                </tr>
                                </table>   
                        </form>
                     </div>  
                       
                    </div>
                    <?php $chkview = $obj->check_pageview("employee_attendence_report.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                    <?php if($waiter_id > 0)
                    {
                      ?>
                      <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_employee_atandance_report.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>&waiter_id=<?php echo $waiter_id; ?>" class="btn btn-info" target="_blank">
                    
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
                    <th width="10%" class="head0 nosort">S.No.</th>
                    <th width="21%" class="head0">Date</th>  
                    <th width="22%" class="head0">Status</th>
                    <th width="22%" class="head0">Time</th>
                    </tr>
                    </thead>
                    <tbody>
                   
                    <?php
                       $slno=1;
                      //echo "select * from emp_attendance_entry  $crit";die;
                        $res1 = $obj->executequery("select * from attendance_entry $crit");
                        $month_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                       

                         $searh_year_month = $year.'-'.$month;
                        
                         for($d=1; $d<=$month_days; $d++) {

                          if($d < 10)
                          $d='0'.$d; 
                          $mydate = "$year-$month-$d";
                         
                           $attendance_time = $obj->getvalfield("attendance_entry","attendance_time","waiter_id='$waiter_id' and attendance_date='$mydate'");

                           if($attendance_time == "")
                           $atype = "<span style='color:red'>Absent</span>";
                           else
                           $atype = "<span style='color:green'>Present</span>";
                          
                    ?>
                 <tr>
                         
                      <td><?php echo $slno++; ?></td>
                      <td><?php echo $obj->dateformatindia($mydate); ?></td>
                      <td><?php echo $atype; ?></td>
                      <td><?php echo $attendance_time; ?></td>

                 </tr>
                    <?php  
                    }//1st for loop
                    //}//2st for loop
                    ?>         
                    </tbody>
                    </table>
                    
                  <?php
                  } }
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
    
  // int main()  
  // {  

  // int day = dayofweek($mydate);  
  // cout << day;  

  // return 0;  
  // } 


</script>
</body>
</html>
