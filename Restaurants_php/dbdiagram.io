
Table "user" {
  "userid" int [pk, not null, increment]
  "username" varchar(100) [not null]
  "email" varchar(100) [not null]
  "password" varchar(50) [not null]
  "usertype" varchar(10) [not null]
  "enable" varchar(20) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(30) [not null]
  "createdate" datetime [not null]
  "lastupdated" date [not null]
}

Table "bill_details" {
  "billdetailid" int [pk, not null, increment]
  "billid" int [not null]
  "waiter_id" int [not null]
  "productid" int [not null]
  "unitid" int [not null]
  "qty" float [not null]
  "rate" float [not null]
  "taxable_value" double [not null]
  "checked_nc" int [not null]
  "table_id" int [not null]
  "zomato_order" varchar(10) [not null]
  "isbilled" tinyint [not null]
  "kotid" int [not null]
  "cancel_remark" varchar(100) [not null]
  "is_cancelled_product" int [not null]
  "createdby" int [not null]
  "ipaddress" varchar(50) [not null]
  "lastupdated" datetime [not null]
  "createdate" datetime [not null]

    Indexes {
    billid [name: "billid"]
    }
}

Table "kot_entry" {
  "kotid" int [pk, not null, increment]
  "table_id" int [not null]
  "kotdate" date [not null]
  "kottime" varchar(10) [not null]
  "billid" int [not null]
}

Table "bills" {
  "billid" int [pk, not null, increment]
  "waiter_id" int [not null]
  "billnumber" varchar(100) [not null]
  "billtime" varchar(50) [not null]
  "billdate" date [not null]
  "table_id" int [not null]
  "is_completed" int [not null, note: '0=no, yes=1']
  "is_parsal" varchar(10) [not null, note: '0=no, yes=1']
  "basic_bill_amt" double [not null]
  "disc_percent" float [not null]
  "disc_rs" float [not null]
  "sgst" float [not null]
  "cgst" float [not null]
  "food_amt" double [not null]
  "bev_amt" double [not null]
  "sercharge" float [not null]
  "net_bill_amt" double [not null]
  "parsal_status" varchar(100) [not null]
  "is_paid" tinyint [not null]
  "rec_amt" double [not null]
  "cash_amt" double [not null]
  "paytm_amt" double [not null]
  "paytm_trans_no" varchar(100) [not null]
  "card_amt" double [not null]
  "google_pay" float [not null]
  "credit_amt" double [not null]
  "zomato" double [not null]
  "swiggy" double [not null]
  "counter_parcel" float [not null]
  "card_trans_number" varchar(100) [not null]
  "paydate" date [not null]
  "paymode" varchar(100) [not null]
  "tran_no" varchar(100) [not null, default: "0"]
  "bank_name" varchar(200) [not null]
  "cust_mobile" varchar(10) [not null]
  "cust_name" varchar(100) [not null, note: 'customer_id']
  "gst_no" varchar(50) [not null]
  "settlement_amt" float [not null]
  "mobile" varchar(50) [not null]
  "remarks" text [not null]
  "is_cancelled" tinyint [not null]
  "checked_nc" int [not null]
  "is_parcel_order" int [not null]
  "nc_amount" double [not null]
  "cancel_remark" varchar(500) [not null]
  "waiter_id_stw" int [not null]
  "waiter_id_cap" int [not null]
  "createdby" int [not null]
  "ipaddress" varchar(50) [not null]
  "lastupdated" datetime [not null]
  "createdate" datetime [not null]
}

Table "m_state" {
  "state_id" int [pk, not null, increment]
  "state_name" varchar(100) [not null]
  "state_code" varchar(50) [not null]
  "ipaddress" varchar(200) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "m_table" {
  "table_id" int [pk, not null, increment]
  "table_no" varchar(100) [not null]
  "floor_id" int [not null]
  "enable" varchar(20) [not null]
  "parcel_status" int [not null, default: "0"]
  "parcel_type" varchar(50) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(25) [not null]
  "lastupdated" datetime [not null, default: `CURRENT_TIMESTAMP`]
  "createdate" date [not null]
}


Table "m_session" {
  "sessionid" int [pk, not null, increment]
  "fromdate" date [not null]
  "todate" date [not null]
  "session_name" varchar(200) [not null]
  "status" int [not null]
  "createdby" int [not null]
  "ipaddress" varchar(25) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "m_floor" {
  "floor_id" int [pk, not null, increment]
  "floor_name" varchar(100) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "lastupdated" datetime [not null, default: `CURRENT_TIMESTAMP`]
  "createdate" date [not null]
}

Table "m_unit" {
  "unitid" int [pk, not null, increment]
  "unit_name" varchar(100) [not null]
  "enable" varchar(20) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(25) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "purchaseentry" {
  "purchaseid" int [pk, not null, increment]
  "billno" varchar(100) [not null]
  "packing_charge" float [not null]
  "supplier_id" int [not null]
  "cust_id" int [not null]
  "bill_date" date [not null]
  "company_id" int [not null]
  "purchase_type" varchar(100) [not null]
  "bill_type" varchar(20) [not null]
  "type" varchar(50) [not null]
  "net_amount" float [not null]
  "remark" text [not null]
  "is_cancelled" int [not null]
  "sessionid" int [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "purchasentry_detail" {
  "purdetail_id" int [pk, not null, increment]
  "purchaseid" int [not null]
  "raw_id" int [not null]
  "productid" int [not null]
  "unit_name" varchar(100) [not null]
  "qty" float [not null]
  "rate_amt" float [not null]
  "inc_or_exc" varchar(50) [not null]
  "disc" float [not null]
  "taxable" float [not null]
  "taxable_value" double [not null]
  "cgst" float [not null]
  "cgst_amt" float [not null]
  "sgst" float [not null]
  "sgst_amt" float [not null]
  "igst" float [not null]
  "igst_amt" float [not null]
  "final_price" double [not null]
  "sale_pur_type" varchar(50) [not null]
  "ret_date" date [not null]
  "ret_qty" float [not null]
  "bal_qty" float [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
}


Table "activitylogreport" {
  "actid" int [pk, not null, increment]
  "userid" int [default: NULL]
  "usertype" varchar(50) [default: NULL]
  "module" varchar(100) [default: NULL]
  "submodule" varchar(50) [not null]
  "pagename" varchar(200) [default: NULL]
  "primarykeyid" varchar(50) [default: NULL]
  "tablename" varchar(50) [default: NULL]
  "activitydatetime" datetime [default: NULL]
  "action" varchar(50) [default: NULL]
  "sessionid" int [not null]
}

Table "adjustment_entry" {
  "adjustment_id" int [pk, not null, increment]
  "productid" int [not null]
  "adjustment_qty" float [not null]
  "unit_name" varchar(100) [not null]
  "remark" text [not null]
  "type" varchar(10) [not null]
  "adjustment_date" date [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "attendance_entry" {
  "attendance_id" int [pk, not null, increment]
  "waiter_id" int [not null]
  "machine_userid" int [not null]
  "attendance_time" varchar(100) [not null]
  "attendance_date" date [not null]
  "attendance_stamp" datetime [not null]
  "verifyiedby" tinyint [not null, note: '0 - pwe, 1 - finger, 2 - card']
  "machineid" varchar(100) [not null]
  "attendanceby" int [not null]
  "data1" int [not null]
  "is_half_day" int [not null]
  "sessionid" int [not null]
  "ipaddress" varchar(100) [not null]
  "createdate" date [not null]
}

Table "bio_command" {
  "cmdid" int [pk, not null, increment]
  "regid" int [not null]
  "machine_userid" int [not null]
  "cmd" longtext [not null]
  "status" tinyint [not null]
  "createdate" datetime [not null]
}

Table "cap_stw_table" {
  "cap_stw_id" int [pk, not null, increment]
  "table_id" int [not null]
  "billid" int [not null]
  "waiter_id_cap" int [not null]
  "waiter_id_stw" int [not null]
  "close_order" int [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "cash_in_out" {
  "cash_inout_id" int [pk, not null, increment]
  "ex_group_id" int [not null]
  "supplier_id" int [not null]
  "voucher_no" varchar(100) [not null]
  "time_at" time [not null]
  "pay_mode" varchar(100) [not null]
  "amount" double [not null]
  "inout_date" date [not null]
  "bank_id" int [not null]
  "narration" varchar(100) [not null]
  "type" varchar(100) [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "company_setting" {
  "compid" int [pk, not null, increment]
  "comp_name" varchar(100) [not null]
  "gstno" varchar(100) [not null]
  "landlineno" varchar(100) [not null]
  "mobile" varchar(50) [not null]
  "mobile2" varchar(10) [not null]
  "address" text [not null]
  "address2" text [not null]
  "email1" varchar(200) [not null]
  "email2" varchar(200) [not null]
  "fssai_no" varchar(50) [not null]
  "term_cond" text [not null]
  "ipaddress" varchar(25) [not null]
  "createdby" int [not null]
  "createdate" datetime [not null]
  "lastupdated" datetime [not null]
}

Table "day_close" {
  "day_id" int [pk, not null, increment]
  "day_date" date [not null]
  "ipaddress" text [not null]
  "createdate" date [not null]
  "createdby" int [not null]
  "lastupdated" date [not null]
}

Table "employee_payment" {
  "employee_payid" int [pk, not null, increment]
  "waiter_id" int [not null]
  "pay_date" date [not null]
  "paid_amt" double [not null]
  "voucher_no" varchar(100) [not null]
  "payment_type" varchar(100) [not null]
  "remark" text [not null]
  "payment_mode" varchar(100) [not null]
  "cheque_no" varchar(100) [not null]
  "bank_name" varchar(100) [not null]
  "advanced_type" varchar(100) [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
}

Table "expanse" {
  "expanse_id" int [pk, not null, increment]
  "ex_group_id" int [not null]
  "exp_name" varchar(200) [not null]
  "exp_date" date [not null]
  "exp_amount" float [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "finished_goods_opening_stock" {
  "finished_opening_id" int [pk, not null, increment]
  "productid" int [not null]
  "finish_opening_qty" float [not null]
  "unit_name" varchar(100) [not null]
  "remark" text [not null]
  "finish_opening_date" date [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "issue_entry" {
  "issueid" int [pk, not null, increment]
  "issueno" varchar(50) [not null]
  "issuedate" date [not null]
  "department_id" int [not null]
  "remark" varchar(100) [not null]
  "compid" int [not null]
  "sessionid" int [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "issue_entry_details" {
  "issueid_detail" int [pk, not null, increment]
  "issueid" int [not null]
  "raw_id" int [not null]
  "unit_name" varchar(100) [not null]
  "qty" varchar(100) [not null]
  "ret_qty" varchar(50) [not null]
  "ret_date" date [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
}

Table "issue_return" {
  "issue_id" int [pk, not null, increment]
  "raw_id" int [not null]
  "unit_name" varchar(110) [not null]
  "ret_qty" float [not null]
  "ret_date" date [not null]
  "ipaddress" text [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "loginlogoutreport" {
  "id" int [pk, not null, increment]
  "userid" int [default: NULL]
  "usertype" varchar(20) [default: NULL]
  "process" varchar(10) [default: NULL]
  "sessionid" int [not null]
  "loginlogouttime" datetime [default: NULL]
  "createdate" date [default: NULL]
  "ipaddress" varchar(45) [default: NULL]
}

Table "m_account" {
  "bank_id" int [pk, not null, increment]
  "bank_name" varchar(100) [not null]
  "account_no" varchar(100) [not null]
  "ifsc_code" varchar(100) [not null]
  "bank_address" text [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "m_customer" {
  "customer_id" int [pk, not null, increment]
  "customer_name" varchar(100) [not null]
  "mobile" varchar(50) [not null]
  "email" varchar(100) [not null]
  "address" text [not null]
  "status" varchar(50) [not null]
  "ipaddress" varchar(200) [not null]
  "createdate" date [not null]
  "createdby" int [not null]
  "lastupdated" date [not null]
}

Table "m_expanse_group" {
  "ex_group_id" int [pk, not null, increment]
  "group_name" varchar(100) [not null]
  "enable" varchar(20) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(25) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}


Table "m_food_beverages" {
  "foodtypeid" int [pk, not null, increment]
  "food_type_name" varchar(100) [not null]
}

Table "m_product" {
  "productid" int [pk, not null, increment]
  "pcatid" int [not null]
  "foodtypeid" int [not null]
  "prodname" varchar(200) [not null]
  "product_code" varchar(20) [not null]
  "qty" float [not null]
  "unitid" int [not null]
  "rate" float [not null]
  "imgname" varchar(300) [not null]
  "enable" varchar(20) [not null]
  "status" int [not null]
  "checked_status" int [not null]
  "description" text [not null]
  "createdby" int [not null]
  "ipaddress" varchar(25) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "m_product_category" {
  "pcatid" int [pk, not null, increment]
  "catname" varchar(150) [not null]
  "type" varchar(50) [not null]
  "status" varchar(20) [not null]
  "checked_status" int [not null]
  "createdby" int [not null]
  "ipaddress" varchar(25) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "m_shop" {
  "shop_id" int [pk, not null, increment]
  "shop_name" varchar(100) [not null]
  "telphone" varchar(25) [not null]
  "address" text [not null]
  "status" varchar(100) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}


Table "m_userprivilege" {
  "page_id" int [pk, not null, increment]
  "menuname" varchar(200) [not null]
  "page_heading" varchar(100) [not null]
  "pagelink" varchar(200) [not null]
  "enable" varchar(10) [not null]
  "createdby" int [not null]
  "ipaddress" text [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "m_waiter" {
  "waiter_id" int [pk, not null, increment]
  "sessionid" int [not null]
  "waiter_name" varchar(100) [not null]
  "mobile" varchar(10) [not null]
  "email" varchar(100) [not null]
  "password" varchar(100) [not null]
  "biometric_id" varchar(10) [not null]
  "address" varchar(100) [not null]
  "job_type" varchar(50) [not null]
  "designation" varchar(50) [not null]
  "status" varchar(10) [not null]
  "openingbal" float [not null]
  "open_bal_date" date [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "master_supplier" {
  "supplier_id" int [pk, not null, increment]
  "supplier_name" varchar(100) [not null]
  "mobile" varchar(50) [not null]
  "address" text [not null]
  "email" varchar(200) [not null]
  "supplier_status" varchar(50) [not null]
  "bank_name" varchar(200) [not null]
  "ifsc_code" varchar(50) [not null]
  "bank_ac" varchar(50) [not null]
  "bank_address" text [not null]
  "state_id" int [not null]
  "gstno" varchar(50) [not null]
  "openingbal" float [not null]
  "open_bal_date" date [not null]
  "type" varchar(30) [not null]
  "compid" int [not null]
  "ipaddress" varchar(200) [not null]
  "createdate" date [not null]
}

Table "material_setting" {
  "material_set_id" int [pk, not null, increment]
  "finish_id" int [not null]
  "row_id" int [not null]
  "qty" varchar(20) [not null]
  "ipaddress" varchar(200) [not null]
  "createdate" date [not null]
  "createdby" int [not null]
}

Table "parcel_order" {
  "parcel_id" int [pk, not null, increment]
  "table_id" int [not null]
  "billid" int [not null]
  "otp" varchar(100) [not null]
  "rider_name" varchar(100) [not null]
  "order_number" varchar(100) [not null]
  "parcel_type" varchar(50) [not null]
  "close_order" int [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
}

Table "payment_status" {
  "payid" int [pk, not null, increment]
  "payment_id" varchar(100) [not null]
  "payment_status" varchar(100) [not null]
  "payment_request_id" text [not null]
  "createdate" datetime [not null]
}

Table "pre_order_entry" {
  "pre_orderid" int [pk, not null, increment]
  "delivery_time" time [not null]
  "order_time" time [not null]
  "order_date" date [not null]
  "delivery_date" date [not null]
  "order_no" varchar(100) [not null]
  "cust_name" varchar(100) [not null]
  "mobile_no" varchar(100) [not null]
  "address" varchar(100) [not null]
  "order_description" text [not null]
  "net_amount" double [not null]
  "advance_amt" double [not null]
  "sessionid" int [not null]
  "createdate" date [not null]
  "createdby" int [not null]
  "lastupdated" date [not null]
  "ipaddress" varchar(100) [not null]
}

Table "preentry_detail" {
  "pre_detail_id" int [pk, not null, increment]
  "pre_orderid" int [not null]
  "productid" int [not null]
  "unit_name" varchar(100) [not null]
  "qty" float [not null]
  "rate_amt" double [not null]
  "cgst" float [not null]
  "sgst" float [not null]
  "igst" float [not null]
  "sgst_amt" float [not null]
  "cgst_amt" float [not null]
  "igst_amt" float [not null]
  "disc" float [not null]
  "taxable" double [not null]
  "taxable_value" float [not null]
  "final_price" double [not null]
  "inc_or_exc" varchar(100) [not null]
  "ipaddress" varchar(100) [not null]
  "createdate" date [not null]
  "createdby" int [not null]
}

Table "privilage_setting" {
  "privilage_id" int [pk, not null, increment]
  "userid" int [not null]
  "page_id" int [not null]
  "pagedit" tinyint [not null]
  "pageview" tinyint [not null]
  "pagedel" tinyint [not null]
  "privilage" varchar(100) [not null]
  "createdby" int [not null]
  "ipaddress" varchar(100) [not null]
  "lastupdated" date [not null]
  "createdate" date [not null]
}

Table "production_entry" {
  "production_id" int [pk, not null, increment]
  "productid" int [not null]
  "production_qty" float [not null]
  "unit_name" varchar(100) [not null]
  "remark" text [not null]
  "production_date" date [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "raw_material" {
  "raw_id" int [pk, not null, increment]
  "raw_name" varchar(100) [not null]
  "unitid" int [not null]
  "qty" float [not null]
  "open_date" date [not null]
  "rate" float [not null]
  "reorder_limit" varchar(50) [not null]
  "product_type" varchar(100) [not null]
  "ipaddress" text [not null]
  "createdate" date [not null]
  "createdby" int [not null]
  "lastupdated" date [not null]
}

Table "software_expired" {
  "soft_exp_id" int [pk, not null, increment]
  "start_date" date [not null]
  "expired_date" date [not null]
  "payment_id" text [not null]
  "payment_status" varchar(100) [not null]
  "payment_request_id" text [not null]
  "createdate" varchar(100) [not null]
}

Table "supplier_payment" {
  "supplier_payid" int [pk, not null, increment]
  "supplier_id" int [not null]
  "pay_date" date [not null]
  "paid_amt" float [not null]
  "voucher_no" varchar(100) [not null]
  "payment_type" varchar(100) [not null]
  "remark" text [not null]
  "payment_mode" varchar(100) [not null]
  "cheque_no" varchar(100) [not null]
  "bank_name" varchar(100) [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}

Table "tax_setting_new" {
  "taxid" int [pk, not null, increment]
  "sgst" float [not null]
  "cgst" float [not null]
  "sercharge" float [not null]
  "is_applicable" int [not null, note: '(1=applicable,0=not applicable)']
}

Table "view_consumption" {
  "material_set_id" int [default: NULL]
  "finish_id" int [default: NULL]
  "row_id" int [default: NULL]
  "qty" varchar(20) [default: NULL]
  "createdate" date [default: NULL]
  "billdetailid" int [default: NULL]
  "billid" int [default: NULL]
  "productid" int [default: NULL]
  "bill_qty" float [default: NULL]
  "table_id" int [default: NULL]
  "isbilled" tinyint [default: NULL]
  "raw_name" varchar(100) [default: NULL]
  "raw_id" int [default: NULL]
  "raw_qty" float [default: NULL]
  "open_date" date [default: NULL]
}

Table "wastage_entry" {
  "wastage_id" int [pk, not null, increment]
  "productid" int [not null]
  "wastage_qty" float [not null]
  "unit_name" varchar(50) [not null]
  "wastage_date" date [not null]
  "remark" text [not null]
  "ipaddress" varchar(100) [not null]
  "createdby" int [not null]
  "createdate" date [not null]
  "lastupdated" date [not null]
}
