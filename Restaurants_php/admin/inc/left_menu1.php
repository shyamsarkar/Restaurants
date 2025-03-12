<?php $pagename = basename($_SERVER['PHP_SELF']); ?>
<div class="leftpanel">
  <div class="logopanel">
    <h1 style="font-size:18px;">
      <center>
        <a href="index.php">RESTAURANT</a>
      </center>
    </h1>
  </div><!--logopanel-->

  <div class="datewidget"><span style="font-size:15px"><b>Session <?php echo $obj->getvalfield("m_session", "session_name", "sessionid = '$sessionid'"); ?></b></span></div>

  <div class="leftmenu">
    <ul class="nav nav-tabs nav-stacked" id="mymenu">
      <li <?php if ($pagename == "index.php") { ?>class="active" <?php } ?>><a href="index.php"><span class="icon-align-justify"></span>Dashboard</a></li>
      <?php
      $master_chk = $obj->checkmenu("Master", $loginid);
      if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {
      ?>

        <li class="dropdown  <?php if ($pagename == "master_session.php" || $pagename == "user_master.php" || $pagename == "m_floor.php" || $pagename == "m_table.php" || $pagename == "waiter_master.php" || $pagename == "menu_item.php" || $pagename == "menu_heading.php" || $pagename == "m_expense_group.php"  || $pagename == "unit_master.php" || $pagename == "customer_master.php" || $pagename == "company_master.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span> Master </a>
          <ul <?php if ($pagename == "master_session.php" ||  $pagename == "company_master.php" || $pagename == "user_master.php" || $pagename == "m_floor.php" || $pagename == "m_table.php" || $pagename == "waiter_master.php" || $pagename == "menu_item.php" || $pagename == "menu_heading.php" || $pagename == "m_expense_group.php" || $pagename == "unit_master.php" || $pagename == "customer_master.php" || $pagename == "state_master.php") { ?>style="display: block" <?php } ?>>
            <?php
            $chkmenu = $obj->check_menuname("master_session.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="master_session.php">Session Master</a></li>

            <?php
            }
            $chkmenu = $obj->check_menuname("company_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="company_master.php">Company Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("customer_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="customer_master.php">Customer Master</a></li>
            <?php

            }
            $chkmenu = $obj->check_menuname("state_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="state_master.php">State Master</a></li>
            <?php }
            $chkmenu = $obj->check_menuname("m_floor.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="m_floor.php">Floor Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("m_table.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="m_table.php">Table Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("waiter_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="waiter_master.php">Employee Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("unit_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="unit_master.php">Unit Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("menu_heading.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="menu_heading.php">Menu Heading Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("menu_item.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="menu_item.php">Menu Master</a></li>
            <?php }

            $chkmenu = $obj->check_menuname("user_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="user_master.php">User Master</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php  }
      $master_chk = $obj->checkmenu("Master", $loginid);
      if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {
      ?>
        <li class="dropdown  <?php if ($pagename == "cash_in_master.php" || $pagename == "m_expanse_group.php" || $pagename == "account_master.php" || $pagename == "cash_out_master.php" || $pagename == "supplier_master.php" || $pagename == "cash_book.php" || $pagename == "cash_book_report.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Account Entry </a>
          <ul <?php if ($pagename == "m_expanse_group.php" || $pagename == "cash_in_master.php" || $pagename == "account_master.php" || $pagename == "cash_out_master.php" || $pagename == "supplier_master.php" || $pagename == "cash_book.php" || $pagename == "cash_book_report.php") { ?>style="display: block" <?php } ?>>
          <?php }
        $chkmenu = $obj->check_menuname("account_master.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="account_master.php"><i class="icon-user"></i>
                Bank Master</a></li>
          <?php }


        $chkmenu = $obj->check_menuname("m_expanse_group.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="m_expanse_group.php"><i class="icon-user"></i>
                Transaction Group</a></li>
          <?php

        }
        $chkmenu = $obj->check_menuname("supplier_master.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="supplier_master.php"><i class="icon-user"></i>Supplier Master</a></li>
          <?php
        }
        $chkmenu = $obj->check_menuname("cash_in_master.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="cash_in_master.php"><i class="icon-user"></i>
                Cash In </a></li>
          <?php }
        $chkmenu = $obj->check_menuname("cash_out_master.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="cash_out_master.php"><i class="icon-user"></i>
                Cash Out </a></li>

          <?php }
        $chkmenu = $obj->check_menuname("cash_book.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="cash_book.php"><i class="icon-user"></i>
                Cash Book </a></li>

          <?php }
        $chkmenu = $obj->check_menuname("cash_book_report.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
          ?>
            <li><a href="cash_book_report.php"><i class="icon-user"></i>
                Cash Book Report</a></li>


          </ul>
        </li>
      <?php  }
        $master_chk = $obj->checkmenu("Master", $loginid);
        if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {
      ?>
        <li class="dropdown  <?php if ($pagename == "finished_goods_opening_stock.php" || $pagename == "wastage_entry.php" || $pagename == "production_entry.php" || $pagename == "finished_goods_purchase_entry.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Finished Goods Management</a>
          <ul <?php if ($pagename == "finished_goods_opening_stock.php" || $pagename == "wastage_entry.php" || $pagename == "production_entry.php" || $pagename == "finished_goods_purchase_entry.php" || $pagename == "stock_report_new.php" || $pagename == "adjustment_entry.php") { ?>style="display: block" <?php } ?>>
            <?php

            $chkmenu = $obj->check_menuname("finished_goods_opening_stock.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="finished_goods_opening_stock.php"><i class="icon-user"></i>
                  Opening Stock Entry</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("wastage_entry.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="wastage_entry.php"><i class="icon-user"></i>
                  Wastage Entry</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("production_entry.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="production_entry.php"><i class="icon-user"></i>
                  Production Entry</a></li>
            <?php

            }
            $chkmenu = $obj->check_menuname("adjustment_entry.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="adjustment_entry.php"><i class="icon-user"></i>
                  Adjustment Entry</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("finished_goods_purchase_entry.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="finished_goods_purchase_entry.php"><i class="icon-user"></i>
                  Finished Good Purchase Entry</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("stock_report_new.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="stock_report_new.php"><i class="icon-user"></i>
                  Finished Goods Stock Report</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php  }

        $master_chk = $obj->checkmenu("Master", $loginid);
        if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {
      ?>
        <li class="dropdown  <?php if ($pagename == "raw_material_master.php" || $pagename == "finished_goods_row_material.php" || $pagename == "stock_report.php" || $pagename == "purchaseentry.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Raw Material Management</a>
          <ul <?php if ($pagename == "raw_material_master.php" || $pagename == "finished_goods_row_material.php" || $pagename == "stock_report.php" || $pagename == "purchaseentry.php") { ?>style="display: block" <?php } ?>>
            <?php

            $chkmenu = $obj->check_menuname("raw_material_master.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="raw_material_master.php"><i class="icon-user"></i>
                  Raw Material Master</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("finished_goods_row_material.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="finished_goods_row_material.php"><i class="icon-user"></i>
                  Raw Material Setting</a></li>

            <?php

            }

            $chkmenu = $obj->check_menuname("purchaseentry.php", $loginid);

            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {

            ?>

              <li><a href="purchaseentry.php"><i class="icon-user"></i>

                  Raw Material Purchase Entry</a></li>
            <?php
            }
            $chkmenu = $obj->check_menuname("stock_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="stock_report.php"><i class="icon-user"></i>
                  Raw Material Stock Report</a></li>
            <?php
            } ?>

          </ul>
        </li>
      <?php  }

        $master_chk = $obj->checkmenu("Master", $loginid);
        if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {
      ?>


        <li class="dropdown  <?php if ($pagename == "supplier_payment.php" || $pagename == "supplier_ledger.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Supplier voucher</a>
          <ul <?php if ($pagename == "supplier_payment.php" || $pagename == "supplier_ledger.php") { ?>style="display: block" <?php } ?>>

            <?php
            $chkmenu = $obj->check_menuname("supplier_payment.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="supplier_payment.php"><i class="icon-user"></i>
                  Supplier Payment Entry</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("supplier_ledger.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="supplier_ledger.php"><i class="icon-user"></i>
                  Supplier Ledger</a></li>

            <?php } ?>

          </ul>
        </li>

      <?php }
        $chkmenu = $obj->check_menuname("in_entry_new.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
      ?>

        <li <?php if ($pagename == "in_entry_new.php") { ?>class="active" <?php } ?>><a href="in_entry_new.php"><i class="icon-user"></i>
            &nbsp;&nbsp;&nbsp;
            Bill Entry</a></li>

      <?php }
        $chkmenu = $obj->check_menuname("edit_payment.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
      ?>

        <li <?php if ($pagename == "edit_payment.php") { ?>class="active" <?php } ?>><a href="edit_payment.php"><i class="icon-user"></i>
            &nbsp;&nbsp;&nbsp;
            Edit Payment</a></li>

      <?php }
        $chkmenu = $obj->check_menuname("edit_bill.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
      ?>

        <li <?php if ($pagename == "edit_bill.php") { ?>class="active" <?php } ?>><a href="edit_bill.php"><i class="icon-user"></i>
            &nbsp;&nbsp;&nbsp;
            Edit Bill</a></li>

      <?php }
        $chkmenu = $obj->check_menuname("pending_parcel_payment.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
      ?>

        <li <?php if ($pagename == "pending_parcel_payment.php") { ?>class="active" <?php } ?>><a href="pending_parcel_payment.php"><i class="icon-user"></i>
            &nbsp;&nbsp;&nbsp;
            Pending Parcel Payment</a></li>

      <?php }
        $chkmenu = $obj->check_menuname("tax_setting.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
      ?>

        <li <?php if ($pagename == "tax_setting.php") { ?>class="active" <?php } ?>><a href="tax_setting.php"><i class="icon-home"></i>
            &nbsp;&nbsp;&nbsp;
            Tax Setting</a></li>


      <?php }

        $chkmenu = $obj->check_menuname("employee_manual_attendence.php", $loginid);
        if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
      ?>

        <li <?php if ($pagename == "employee_manual_attendence.php") { ?>class="active" <?php } ?>><a href="employee_manual_attendence.php"><i class="icon-user"></i>
            &nbsp;&nbsp;&nbsp;
            Employee Manual Attendence</a></li>
      <?php } ?>

      <?php if ($usertype == "admin") { ?>
        <li <?php if ($pagename == "user_privilage.php") { ?>class="active" <?php } ?>><a href="user_privilage.php"><i class="icon-user"></i>
            &nbsp;&nbsp;&nbsp;
            User Privilage Setting</a></li>
      <?php } ?>


      <?php
      $master_chk = $obj->checkmenu("Master", $loginid);
      if ($master_chk != '0' || $_SESSION['usertype'] == 'admin') {
      ?>
        <li class="dropdown  <?php if ($pagename == "bill_report_list.php" || $pagename == "billcredit_report_list.php" || $pagename == "payment_report_new.php" || $pagename == "product_wise_report.php" || $pagename == "expanse_report.php" || $pagename == "employee_attendence_report.php" || $pagename == "employee_attendence_datewise_report.php" || $pagename == "nc_product_report.php" || $pagename == "kot_report.php" || $pagename == "pre_order_report.php" || $pagename == "product_search_qty.php" || $pagename == "gst_report.php" || $pagename == "nc_bill_report.php" || $pagename == "total_sale_report.php" || $pagename == "category_wise_sale_report.php" || $pagename == "cash_inout_report.php") { ?> active <?php } ?>"><a href="#"><span class="icon-pencil"></span>Report</a>
          <ul <?php if ($pagename == "bill_report_list.php" || $pagename == "billcredit_report_list.php" || $pagename == "payment_report_new.php" || $pagename == "product_wise_report.php" || $pagename == "expanse_report.php" || $pagename == "employee_attendence_report.php" || $pagename == "employee_attendence_datewise_report.php" || $pagename == "kot_report.php" || $pagename == "nc_product_report.php"  || $pagename == "product_search_qty.php" || $pagename == "gst_report.php" || $pagename == "nc_bill_report.php" || $pagename == "total_sale_report.php" || $pagename == "category_wise_sale_report.php" || $pagename == "cash_inout_report.php") { ?>style="display: block" <?php } ?>>

            <?php
            $chkmenu = $obj->check_menuname("total_sale_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="total_sale_report.php"><i class="icon-user"></i>Day Wise Payment Report</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("category_wise_sale_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="category_wise_sale_report.php"><i class="icon-user"></i>Category Wise Sale Report</a></li>
            <?php }
            $chkmenu = $obj->check_menuname("cash_inout_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="cash_inout_report.php"><i class="icon-user"></i>Cash In Out Report</a></li>


            <?php }
            $chkmenu = $obj->check_menuname("bill_report_list.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="bill_report_list.php"><i class="icon-user"></i>Bill Wise Sale Report</a></li>

            <?php } ?>

            <li><a href="nc_bill_report.php"><i class="icon-user"></i>NC Bill Report</a></li>

            <?php
            $chkmenu = $obj->check_menuname("billcredit_report_list.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="billcredit_report_list.php"><i class="icon-user"></i>Bill Wise Credit Sale Report</a></li>
            <?php }
            $chkmenu = $obj->check_menuname("payment_report_new.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="payment_report_new.php"><i class="icon-user"></i>Payment Entry Report</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("product_wise_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="product_wise_report.php"><i class="icon-user"></i>Product Wise Sale Report</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("expanse_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="expanse_report.php"><i class="icon-user"></i>Expanse Report</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("employee_attendence_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="employee_attendence_report.php"><i class="icon-user"></i>Emp Attendence Monthly</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("employee_attendence_datewise_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>
              <li><a href="employee_attendence_datewise_report.php"><i class="icon-user"></i>Emp Attendence Datewise</a></li>
            <?php }
            $chkmenu = $obj->check_menuname("kot_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="kot_report.php"><i class="icon-user"></i>KOT Report</a></li>
            <?php }
            $chkmenu = $obj->check_menuname("product_search_qty.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="product_search_qty.php"><i class="icon-user"></i>Matching Product Qty Report</a></li>

            <?php }
            $chkmenu = $obj->check_menuname("gst_report.php", $loginid);
            if ($chkmenu > 0 || $_SESSION['usertype'] == 'admin') {
            ?>

              <li><a href="gst_report.php"><i class="icon-user"></i>GST Report</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>



      <li <?php if ($pagename == "changepassword.php") { ?>class="active" <?php } ?>><a href="changepassword.php"><i class="icon-user"></i>
          &nbsp;&nbsp;&nbsp;
          Change Password</a></li>
    </ul>
  </div><!--leftmenu-->

</div>