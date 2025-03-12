<?php include("../adminsession.php");
//include("../lib/smsinfo.php");
$pagename = "voucherentry.php";
$module = "Voucher Entry";
$submodule = "VOUCHER ENTRY";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "voucherentry";
$tblpkey = "voucher_id";
$company_id = $_SESSION['company_id'];
if(isset($_GET['customer_id']))
{
  $customer_id = $_GET['customer_id'];
  
}
else
{
  $customer_id = 0;
  
}


if(isset($_GET['voucher_id']))
{
  $keyvalue = $_GET['voucher_id'];
}
else
{
  $keyvalue = 0;
  $voucher_no = $obj->getcode_voucher($tblname,"voucher_no","sessionid='$sessionid' and company_id = '$company_id'");
}

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";

// if(isset($_GET['is_security']))
// $is_security = addslashes(trim($_GET['is_security']));
// else
// $is_security = 0;
 $paid_amt = $remark = "";
if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$customer_id = $_POST['customer_id'];
	$pay_date = $obj->dateformatusa($_POST['pay_date']);
	$paid_amt  = $_POST['paid_amt'];
	$voucher_no = $_POST['voucher_no'];
	$payment_type = $_POST['payment_type'];
	$remark = $_POST['remark'];
  $payment_mode = $_POST['payment_mode'];
  //$is_security  = isset($_POST['is_security']);
		
	if($keyvalue == 0)
	{    
    $form_data = array('customer_id'=>$customer_id,'pay_date'=>$pay_date,'paid_amt'=>$paid_amt,'voucher_no'=>$voucher_no,'payment_type'=>$payment_type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'sessionid'=>$sessionid,'remark'=>$remark,'payment_mode'=>$payment_mode,'company_id'=>$company_id);
    $obj->insert_record($tblname,$form_data);
    $action=1;
    $process = "insert";
    // if($is_security > 0)
    // {
    //   $mobile = $obj->getvalfield("m_student_reg","mobile","m_student_reg_id='$m_student_reg_id'"); 
    //   if(strlen($mobile)==10)
    //   { 
    //     // echo "hii"; die;
    //     $pay_date = $obj->dateformatindia($pay_date);
    //     $stu_name = $obj->getvalfield("m_student_reg","stu_name","m_student_reg_id='$m_student_reg_id'");
    //     $fee_head_name = $obj->getvalfield("m_fee_head","fee_head_name","fee_head_id='$fee_head_id'");

    //     $msg = "Dear $stu_name\nYour Payment Received:-\nReceipt No. $reciept_no\nPayment Date: $pay_date\nFee Head: $fee_head_name\nPayment Amount: $paid_amt\nFrom SAINATH PARAMEDICAL COLLEGE";
    //     $ok = 1;
    //     $ok = $obj->sendsmsGET($username,$pass,$senderid,$msg,$serverUrl,$mobile);
    //     $obj->sendsmsGET($username,$pass,$senderid,$msg,$serverUrl,"9301824171");
    //     // echo $ok; die;
    //     if($ok) 
    //     { 
    //       echo "<script>alert('Message sent successfully!');</script>";
    //     }
    //     else 
    //     {
    //       //echo $otp .'  ' . $newparichay_id;die;
    //       echo "<script>alert('Message could not be sent. Sorry!');</script>";
    //     }
    //     echo "<script>location='$pagename?action=$action&transferid=$transferid'</script>";
    //   }
    // }
	}
	else
	{
		//update
		$form_data = array('customer_id'=>$customer_id,'pay_date'=>$pay_date,'paid_amt'=>$paid_amt,'voucher_no'=>$voucher_no,'payment_type'=>$payment_type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'remark'=>$remark,'payment_mode'=>$payment_mode,'company_id'=>$company_id);
		$where = array($tblpkey=>$keyvalue);
		 $obj->update_record($tblname,$where,$form_data);
		$action=2;
		$process = "updated";
	}
	echo "<script>location='$pagename?action=$action&customer_id=$customer_id'</script>";
}

if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $customer_id =  $sqledit['customer_id'];
  $pay_date =  $obj->dateformatindia($sqledit['pay_date']);
  $paid_amt =  $sqledit['paid_amt'];
  $voucher_no =  $sqledit['voucher_no'];
  $payment_type =  $sqledit['payment_type'];
  $remark = $sqledit['remark'];
  $payment_mode = $sqledit['payment_mode'];
 // $is_security =  $sqledit['is_security'];
}
else
{
		$pay_date = date('d-m-Y');
    
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php include("inc/top_files.php"); ?>
<script type="text/javascript">
  function getid(customer_id)
{
  var url = 'voucherentry.php?customer_id=' + customer_id;
  location = url;
}

function getdetails(customer_id)
{
  if(customer_id !='' || !isNaN(customer_id))
  {
  jQuery.ajax({
        type: 'POST',
        url: 'getpaymentdetail.php',
        data: 'customer_id='+customer_id,
        dataType: 'html',
        success: function(data){
        //alert(data);
        
        jQuery('#showrecord').html(data);
        }
      
        });//ajax close
  }
}


<?php
if(isset($_GET['customer_id']) && $_GET['customer_id'] > 0)
{ ?>
  getdetails(<?php echo $_GET['customer_id']; ?>);
<?php
}
?>
</script>
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
                    <h4 class="widgettitle nomargin shadowed">Widget Title</h4>
                    <div style="width:50%;float:left">
                    <form class="stdform stdform2" method="post" action="">
                       <table class="table table-bordered"> 
                       <tr> 
                        <th>Party Name<span style="color:#F00;">*</span></th>
                        <td> <select name="customer_id" id="customer_id"  class="chzn-select" style="width:283px;" onChange="getid(this.value);">
                        <option value="">-select-</option>
                        <?php
                        $res = $obj->executequery("select * from master_customer where company_id = $company_id");
                        foreach($res as $row)
                        {
                          
                        ?> 
                        <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script>document.getElementById('customer_id').value = '<?php echo $customer_id; ?>' ;</script></td></tr> 

                        <tr><th>Payment Date<span style="color:#F00;">*</span></th>
                        <td><input type="text" name="pay_date" id="pay_date" class="input-xlarge"  value="<?php echo $pay_date; ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask/></td></tr>

                      <tr><th>Voucher No.<span style="color:#F00;">*</span></th>
                      <td> <input type="text" class="input-xlarge" name="voucher_no" id="voucher_no"  value="<?php echo $voucher_no; ?>" data-inputmask="'alias':"placeholder="Voucher Number"/>
                      </td></tr>  
                      
                       <tr>
                       	<th>Amount<span style="color:#F00;">*</span></th>
                       	<td> <input type="text" name="paid_amt" id="paid_amt" value="<?php echo $paid_amt; ?>" class="input-xlarge" placeholder="Enter Paid Amount"/></td>
                       </tr>

                      <tr>
                       <th>Payment Type:<span style="color:#F00;">*</span></th>
                       <td> <select  class="chzn-select" style="width:283px;" name="payment_type" id="payment_type">
                        <option value="">-select-</option>
                        <option value="Received">Received</option>
                        <option value="Payment">Payment</option>
                        </select>
                        <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>' ;</script></td></tr>

                        <tr>
                        <th>Payment Mode:<span style="color:#F00;">*</span></th>
                        <td>
                        <select  class="chzn-select" style="width:283px;" name="payment_mode" id="payment_mode">
                        <option value="">-select-</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="neft">NEFT</option>
                        <option value="rtgs">RTGS</option>
                        <option value="paytm">PAYTM</option>
                        </select>
                        <script>document.getElementById('payment_mode').value = '<?php echo $payment_mode ; ?>' ;</script>
                        </td> 
                      </tr>
                       <tr>
                       <th>Remark<span style="color:#F00;"></span></th>
                       <td> <input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" class="input-xlarge" placeholder="Remark"/></td></tr>
                        <!-- <tr>
                          <th>Is Send Msg<span style="color:#F00;"></span></th>
                        <td>
                                <input type="checkbox" name="is_security" id="is_security" class="input-xxlarge" value="1" <?php if($is_security == 1){ ?> checked  <?php } ?>/>
                        </td>
                        </tr> -->
                        <tr>
                            <td colspan="2">
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('customer_id,pay_date dt,voucher_no,paid_amt nu,payment_type,payment_mode');">
                            <?php echo $btn_name; ?></button>

                            <a href="voucherentry.php" name="reset" id="reset" class="btn btn-success">Reset</a></td>
                        </tr>
                       </table>
                        </form>
                    </div>
                    
                    <div style="width:46%;float:right;">
                        <div id="showrecord"  >
                        Data will loading after student selection...
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    
                    <div class="row-fluid">
           			 <table class="table table-bordered" id="dyntable"> 
                    <thead>
                        <tr>
                            <th class="head0 nosort">Sno.</th>
                            <th class="head0">Voucher No</th>
							              <th class="head0">Payment Date</th>
                            <th class="head0">Party Name</th>
                            <th class="head0">Payment Type</th>
                            <th class="head0">Payment Mode</th>
                            <th style="text-align: right;" class="head0">Paid Amount</th>
                            <th class="head0">Print</th>
                            <th width="5%" class="head0">Delete</th> 
                         </tr>
                    </thead>
                    <tbody>
			     <?php
						
            $slno = 1;
            $res = $obj->executequery("select * from voucherentry where customer_id = '$customer_id' order by voucher_id desc");
						foreach($res as $row_get)
                {

                  $voucher_id = $row_get['voucher_id'];
                  $customer_id = $row_get['customer_id'];
                  $customer_name = $obj->getvalfield("master_customer","customer_name","customer_id='$customer_id'");
                         
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td>
					            	<td><?php echo $row_get['voucher_no']; ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['pay_date']); ?></td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $row_get['payment_type']; ?></td>
                         <td><?php echo $row_get['payment_mode']; ?></td>
                        <td style="text-align: right;"><?php echo number_format(round($row_get['paid_amt']),2); ?></td>
                        
                        <td><a class="btn btn-danger" href="pdf_pay_slip.php?voucher_id=<?php echo $voucher_id; ?>" target="_blank">Print</a></td>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $voucher_id; ?>);' style='cursor:pointer'></a>
                        </td>
                </tr>
                
                <?php
                }
                ?>      
                    </tbody>
                </table>
            		</div>
                </div>
                
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
				 //alert(data);
				  // location='<?php echo $pagename."?action=3"; ?>';
           location='<?php echo $pagename."?customer_id=$customer_id" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close


jQuery('#pay_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#pay_date').focus();


</script>
</body>

</html>
