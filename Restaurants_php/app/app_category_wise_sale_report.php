<?php
include("../adminsession.php");
$pagename = "app_category_wise_sale_report.php";
if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
  $from_date = $obj->dateformatusa($_GET['from_date']);
  $to_date  =  $obj->dateformatusa($_GET['to_date']);

}
else
{
  $from_date = date('Y-m-d');
  $to_date = date('Y-m-d');
  
}


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
              <!--  <div class="input-field col s6">
                  <a class="waves-effect waves-light red btn" href="../admin/pdf_category_wise_sale_report.php?fromdate=<?php echo $from_date;?>&todate=<?php echo $to_date;?>" style="width: 100%;" target="_blank" class="pointer"><i class="material-icons right">print</i>print</a>
                 
               </div> -->
            </div>
         </form>
      </div>
      
      <div class="row">
         <div class="col m6 offset-m3 s12">
            <blockquote>
               <h6>Category Wise Sale Report List</h6>
            </blockquote>

            <?php
                        $slno=1;
                      
                        $res = $obj->executequery("Select * from m_product_category");
                        foreach($res as $row_get)
                        {
                            $pcatid = $row_get['pcatid'];
                            $amount = $obj->getvalfield("view_bill_details left join bills on view_bill_details.billid = bills.billid","sum(cash_amt+paytm_amt+google_pay+swiggy+paytm_amt+card_amt+credit_amt)","billdate between '$from_date' and '$to_date' and bills.checked_nc=0 and pcatid='$pcatid'");
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
                           <td>Menu Heading Name</td>
                           <td class="right-align"><?php echo $row_get['catname']; ?></td>
                        </tr>

                         <tr>
                           <td>Amount</td>
                           <td class="right-align"><?php echo number_format($amount,2); ?></td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <?php 
              }
              ?>
           
            <footer class="page-footer">
              
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