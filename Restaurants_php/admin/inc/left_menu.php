<?php $pagename = basename($_SERVER['PHP_SELF']);
$pages = [
    ['dropdown' => false, 'heading' => 'Dashboard', 'pagename' => 'index.php'],
    [
        'dropdown' => true,
        'heading' => 'Master',
        'child' => [
            ['pagename' => 'master_session.php', 'heading' => 'Session Master'],
            ['pagename' => 'company_master.php', 'heading' => 'Company Master'],
            ['pagename' => 'customer_master.php', 'heading' => 'Customer Master'],
            ['pagename' => 'state_master.php', 'heading' => 'State Master'],
            ['pagename' => 'm_floor.php', 'heading' => 'Floor Master'],
            ['pagename' => 'm_table.php', 'heading' => 'Table Master'],
            ['pagename' => 'waiter_master.php', 'heading' => 'Employee Master'],
            ['pagename' => 'unit_master.php', 'heading' => 'Unit Master'],
            ['pagename' => 'menu_heading.php', 'heading' => 'Menu Heading Master'],
            ['pagename' => 'menu_item.php', 'heading' => 'Item Master'],
            ['pagename' => 'user_master.php', 'heading' => 'User Master']
        ]
    ],
    [
        'dropdown' => true,
        'heading' => 'Account Entry',
        'child' => [
            ['pagename' => 'account_master.php', 'heading' => 'Bank Master'],
            ['pagename' => 'm_expanse_group.php', 'heading' => 'TRANSACTION GROUP'],
            ['pagename' => 'supplier_master.php', 'heading' => 'Supplier MASTER'],
            ['pagename' => 'cash_in_master.php', 'heading' => 'Cash In'],
            ['pagename' => 'cash_out_master.php', 'heading' => 'Cash Out'],
            ['pagename' => 'cash_book.php', 'heading' => 'Cash Book'],
            ['pagename' => 'cash_book_report.php', 'heading' => 'Cash Book Report']
        ]
    ],
    [
        'dropdown' => true,
        'heading' => 'Finished Goods Management',
        'child' => [
            ['pagename' => 'finished_goods_opening_stock.php', 'heading' => 'Finished Goods Opening Stock'],
            ['pagename' => 'wastage_entry.php', 'heading' => 'WASTAGE ENTRY'],
            ['pagename' => 'production_entry.php', 'heading' => 'PRODUCTION ENTRY'],
            ['pagename' => 'adjustment_entry.php', 'heading' => 'ADJUSTMENT ENTRY'],
            ['pagename' => 'finished_goods_purchase_entry.php', 'heading' => 'Finished Goods Purchase Entry'],
            ['pagename' => 'stock_report_new.php', 'heading' => 'Finished Good Stock Report'],
        ]
    ],
    [
        'dropdown' => true,
        'heading' => 'Raw Material Management',
        'child' => [
            ['pagename' => 'raw_material_master.php', 'heading' => 'Raw Material Master'],
            ['pagename' => 'finished_goods_row_material.php', 'heading' => 'Finished Goods Row Material Setting'],
            ['pagename' => 'purchaseentry.php', 'heading' => 'Purchase Entry'],
            ['pagename' => 'stock_report.php', 'heading' => 'Raw Material Stock Report'],
        ]
    ],
    [
        'dropdown' => true,
        'heading' => 'Supplier Voucher',
        'child' => [
            ['pagename' => 'supplier_payment.php', 'heading' => 'Supplier Payment Entry'],
            ['pagename' => 'supplier_ledger.php', 'heading' => 'Supplier Ledger Report'],
        ]
    ],
    ['dropdown' => false, 'heading' => 'Bill Entry', 'pagename' => 'in_entry_new.php'],
    ['dropdown' => false, 'heading' => 'Edit Payment', 'pagename' => 'edit_payment.php'],
    ['dropdown' => false, 'heading' => 'Edit Bill', 'pagename' => 'edit_bill.php'],
    ['dropdown' => false, 'heading' => 'Pending Parcel Payment', 'pagename' => 'pending_parcel_payment.php'],
    ['dropdown' => false, 'heading' => 'Tax Setting', 'pagename' => 'tax_setting.php'],
    ['dropdown' => false, 'heading' => 'Employee Attendance Report', 'pagename' => 'employee_manual_attendence.php'],
    ['dropdown' => false, 'heading' => 'User Privilage Master', 'pagename' => 'user_privilage.php'],
    [
        'dropdown' => true,
        'heading' => 'Reports',
        'child' => [
            ['pagename' => 'total_sale_report.php', 'heading' => 'Day Wise Payment Report List'],
            ['pagename' => 'category_wise_sale_report.php', 'heading' => 'Category Wise Sale Report List'],
            ['pagename' => 'cash_inout_report.php', 'heading' => 'Cash In Out Report List'],
            ['pagename' => 'bill_report_list.php', 'heading' => 'Bill Wise Sale Report List'],
            ['pagename' => 'nc_bill_report.php', 'heading' => 'Not Chargeable Bill Report List'],
            ['pagename' => 'billcredit_report_list.php', 'heading' => 'Bill Wise Credit Sale Report List'],
            ['pagename' => 'payment_report_new.php', 'heading' => 'Payment Report List'],
            ['pagename' => 'product_wise_report.php', 'heading' => 'Product Wise Sale List'],
            ['pagename' => 'expanse_report.php', 'heading' => 'Expense Report Master'],
            ['pagename' => 'employee_attendence_report.php', 'heading' => 'Employee Attendance Monthly Report'],
            ['pagename' => 'employee_attendence_datewise_report.php', 'heading' => 'Employee Attendance Datewise Report'],
            ['pagename' => 'kot_report.php', 'heading' => 'KOT Report'],
            ['pagename' => 'product_search_qty.php', 'heading' => 'Match Product Qty Ledger Report'],
            ['pagename' => 'gst_report.php', 'heading' => 'GST REPORT'],
        ]
    ],
    ['dropdown' => false, 'heading' => 'Change Password', 'pagename' => 'changepassword.php']
];

?>
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
            <?php
            foreach ($pages as $page) {
                if (isset($page['dropdown']) && $page['dropdown']) {
                    $is_same_page = $obj->is_page_exists($pagename, $page['child']);
            ?>
                    <li class="dropdown  <?php if ($is_same_page) { ?> active <?php } ?>">
                        <a href="#"><span class="icon-pencil"></span> <?php echo $page['heading']; ?> </a>
                        <ul <?php if ($is_same_page) { ?>style="display: block" <?php } ?>>
                            <?php
                            foreach ($page['child'] as $child) {
                            ?>
                                <li><a href="<?php echo $child['pagename']; ?>"><?php echo $child['heading']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li <?php if ($pagename == $page['pagename']) { ?>class="active" <?php } ?>>
                        <a href="<?php echo $page['pagename']; ?>"><i class="icon-user"></i>&emsp;<?php echo $page['heading']; ?></a>
                    </li>
            <?php }
            } ?>
        </ul>
    </div><!--leftmenu-->

</div>