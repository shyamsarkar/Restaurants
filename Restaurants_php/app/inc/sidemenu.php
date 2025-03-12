   <ul id="slide-out" class="sidenav">
      <li>
         <div class="user-view">
            <div class="background bg">
            <!-- <img src="images/office.jpg"> -->
            </div>
            <a href="#user"><img class="circle" src="img/avtar.png"></a>
            <a href="#name"><span class="white-text name"><?php echo $obj->getvalfield("user","username","userid='$loginid'"); ?></span></a>
            <a href="#email"><span class="white-text email"><?php echo $obj->getvalfield("user","email","userid='$loginid'"); ?></span></a>
         </div>
      </li>
      <li><a class="waves-effect" href="dashboard.php"><i class="material-icons purple-text circle">home</i>Dashboard</a></li>
      <li><a class="waves-effect" href="day_wise_payment_report.php"><i class="material-icons indigo-text">person</i>Day Wise Payment Report</a></li>
      <li><a class="waves-effect" href="app_category_wise_sale_report.php"><i class="material-icons blue-text">local_shipping</i>Category Wise Sale Report</a></li>
      <li><a class="waves-effect" href="app_cash_inout_report.php"><i class="material-icons blue-text">local_shipping</i>Cash In Out Report</a></li>
      <li><a class="waves-effect" href="bill_report.php"><i class="material-icons blue-text">local_shipping</i>Bill Wise Sale Report List</a></li>
      <li><a class="waves-effect" href="app_nc_bill_report.php"><i class="material-icons blue-text">local_shipping</i>Not Chargeable Bill Report List</a></li>
      <li><a class="waves-effect" href="app_billcredit_report_list.php"><i class="material-icons blue-text">local_shipping</i>Bill Wise Credit Sale Report List</a></li>
      <li><a class="waves-effect" href="app_payment_report_new.php"><i class="material-icons blue-text">local_shipping</i>Payment Entry Report</a></li>
      <li><a class="waves-effect" href="app_product_wise_report.php"><i class="material-icons blue-text">local_shipping</i>Product Wise Sale Report</a></li>
      
      <li><a class="waves-effect" href="app_expanse_report.php"><i class="material-icons blue-text">local_shipping</i>Expanse Report Entry</a></li>
      <li><a class="waves-effect" href="app_kot_report.php"><i class="material-icons cyan-text">description</i>KOT Report</a></li>
       <li><a class="waves-effect" href="app_gst_report.php"><i class="material-icons cyan-text">description</i>GST Report</a></li>
       <li><a class="waves-effect" href="logout.php"><i class="material-icons red-text ">logout</i>Logout</a></li>
  </ul>