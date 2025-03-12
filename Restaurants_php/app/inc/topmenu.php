   <div class="navbar-fixed">
    <nav class="bg nav-extended">
      <div class="nav-wrapper">
        <?php 
        if ($pagename=="dashboard.php") { ?>
          <a href="#!" data-target="slide-out" class="sidenav-trigger" class="brand-logo">
           <i class="material-icons">menu</i> 
         </a>
         <div class="left"><strong>INDIAN CHILLY</strong></div>
         <ul class="right">
          <li><a href="#"><i class="material-icons">notifications_none</i></a></li>
          <li><a href="logout.php"><i class="material-icons">lock</i></a></li>
        </ul>
      <?php }else{ ?>
          <a href="dashboard.php" class="brand-logo left">
           <i class="material-icons">chevron_left</i> 
          </a>
          <div class="center">
            <strong>
              <?php 
              switch ($pagename) {
                case 'day_wise_payment_report.php':
                  echo "Day Wise Payment Report";
                  break;
                case 'app_category_wise_sale_report.php':
                  echo "Category Wise Sale Report";
                  break;
                case 'app_cash_inout_report.php':
                  echo "Cash In Out Report";
                  break;
                case 'bill_report.php':
                  echo "Bill Wise Sale Report List";
                  break;
                case 'app_nc_bill_report.php':
                  echo "Not Chargeable Bill Report List";
                  break;
                case 'app_billcredit_report_list.php':
                  echo "Bill Wise Credit Sale Report List";
                  break;
                case 'app_payment_report_new.php':
                    echo "Payment Entry Report";
                break;
                case 'app_product_wise_report.php':
                echo "Product Wise Sale Report";
                break;
                case 'app_expanse_report.php':
                echo "Expanse Report Entry";
                break;
                case 'app_kot_report.php':
                echo "KOT Report";
                break;
                case 'app_gst_report.php':
                echo "GST Report";
                break;
                 case 'todayview_billandnc.php':
                echo "View Todays Bills And NC";
                break;
                }
              ?>
            </strong>
          </div>
        <?php  }
        ?>
      </div>
    </nav>
  </div>