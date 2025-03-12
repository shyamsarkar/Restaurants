<?php
include("../adminsession.php");
$pagename = "app_kot_report.php";
$crit = " where 1 = 1 ";
if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
  $from_date = $obj->dateformatusa($_GET['from_date']);
  $to_date  =  $obj->dateformatusa($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
  
}

$crit .= " and kotdate between '$from_date' and '$to_date'";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Indian Chilly</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes, viewport-fit=cover user-scalable=no">
  <link rel="stylesheet" href="materialize/css/materialize.min.css">
  <link rel="stylesheet" href="materialize/css/icon.css">
  <link rel="stylesheet" href="materialize/css/animate.min.css"/>
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
   .bg{
      background: #141E30;  
      background: -webkit-linear-gradient(to bottom, #243B55, #141E30);  
      background: linear-gradient(to bottom, #243B55, #141E30); 
    }
   .card .card-content {
    padding: 10px;
    border-radius: 0 0 2px 2px;
   }
   td{
    padding: 6px 5px;
   }
   .page-footer {
      padding-top: 0px;
      color: #fff;
      background-color: #18253a;
   }
   .btn{
      width: 50%;
    border-radius: 50px;
    background: #1c2c42;
   }
   .select2-container .select2-selection--single {
      box-sizing: border-box;
      cursor: pointer;
      display: block;
      height: 35px;
      user-select: none;
      -webkit-user-select: none;
   }
   .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
      line-height: 35px;
   }
   .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 26px;
      position: absolute;
      top: 10px;
      right: 1px;
      width: 20px;
   }
   .select2-container--default .select2-selection--single {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-top: 5px;
   }
   .pointer {cursor: pointer;}
  </style>
</head>
<body class="">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
  <div class="container" style="width:100%;"><br>
      <div class="row">
         <form class="col m6 offset-m3 s12">
            <div class="row">
               
               <div class="input-field col s6">
                  <input type="text" name="from_date" id="from_date" value="<?php echo $obj->dateformatindia($from_date); ?>" class="datepicker">
                  <label>From Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s6">
                  <input type="text" name="to_date" id="to_date" value="<?php echo $obj->dateformatindia($to_date); ?>" class="datepicker">
                  <label>To Date <span style="color:#F00;">*</span></label>
               </div>
               <div class="input-field col s12">
                  <button class="btn waves-effect waves-light" type="submit" name="search" onClick="return checkinputmaster('from_date,to_date'); " value="Search" style="width: 100%;">Search<i class="material-icons right">search</i>
                  </button>
               </div>
               <!-- <div class="input-field col s6">
                  <a class="waves-effect waves-light red btn" href="../admin/pdf_kot_report.php?from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" style="width: 100%;" target="_blank" class="pointer"><i class="material-icons right">print</i>print</a>
                 
               </div> -->
            </div>
         </form>
      </div>
      
      <div class="row">
         <div class="col m6 offset-m3 s12">
            <blockquote>
               <h6>KOT Report</h6>
            </blockquote>

             <?php
            $slno=1;
            $tot_kot_no=0;
            $res = $obj->executequery("select * from kot_entry $crit");
            foreach($res as $row_get)
            {
              $table_id = $row_get['table_id'];
              $kotid = $row_get['kotid'];
              $kotdate = $obj->dateformatindia($row_get['kotdate']);
              $kottime = $row_get['kottime'];
              $billid = $row_get['billid'];
              $table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");
              $billnumber = $obj->getvalfield("bills","billnumber","billid='$billid'");
              $floor_id = $obj->getvalfield("m_table","floor_id","table_id='$table_id'");
              $floor_name = $obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");
              $count_product = $obj->getvalfield("bill_details","count(productid)","kotid='$kotid' and table_id='$table_id' and billid='$billid'");
              ?>

            <div class="card">
               <div class="card-content">
                  <table class="striped">
                     <tbody>
                        
                        <tr>
                           <td><strong>Serial No.</strong></td>
                           <td class="right-align"><strong><?php echo $slno++; ?></strong></td>
                        </tr>
                        <tr>
                           <td>KOT No.</td>
                           <td class="right-align"><a target="_blank" href="../admin/pdf_restaurant_kot_recipt_new.php?kotid=<?php echo $kotid; ?>">
                  <?php echo "KOT No: ".$row_get['kotid']; ?></a></td>
                        </tr>
                        <tr>
                           <td>Bill No.</td>
                           <td class="right-align"><a href="pdf_restaurant_recipt.php?billid=<?php echo $row_get['billid'] ?>" target="_blank"><?php echo $billnumber; ?></a></td>
                        </tr>

                         <tr>
                           <td>KOT Date</td>
                           <td class="right-align"><?php echo $kotdate; ?></td>
                        </tr>
                        <tr>
                           <td>KOT Time</td>
                           <td class="right-align"><?php echo $kottime; ?></td>
                        </tr>
                        <tr>
                           <td>Total_Count_Product</td>
                           <td class="right-align"><?php echo $count_product; ?></td>
                        </tr>
                        <tr>
                           <td>Table No.</td>
                           <td class="right-align"><?php echo $table_no; ?></td>
                        </tr>
                        <tr>
                           <td>Floor No.</td>
                           <td class="right-align"><?php echo $floor_name; ?></td>
                        </tr>
                        
                        
                     </tbody>
                  </table>
               </div>
            </div>
            <?php 
                   $tot_kot_no = $slno - 1;
              }
              ?>
           
            <footer class="page-footer">
               <div class="footer-copyright">
                  <div class="container">
                  <strong>Total KOT No.</strong>
                  <strong class="right">&#x20B9; <?php echo $tot_kot_no;  ?></strong>

                  </div>

               </div>
            </footer>
         </div>
      </div>
  </div>

   <script src="materialize/js/jquery.min.js"></script>
   <script src="materialize/js/materialize.min.js"></script>
   <script src="materialize/js/app.js"></script>
   <script src="js/commonfun2.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

   <script type="text/javascript">
      $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });
   </script>
</body>
</html>