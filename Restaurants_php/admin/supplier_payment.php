<?php include("../adminsession.php");
//include("../lib/smsinfo.php");
$pagename = "supplier_payment.php";
$module = "Supplier Payment Entry";
$submodule = "Supplier Payment Entry";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "supplier_payment";
$tblpkey = "supplier_payid";


if(isset($_GET['supplier_id']))
{
  $supplier_id = $_GET['supplier_id'];
  
}
else
{
  $supplier_id = 0;
  
}


if(isset($_GET['supplier_payid']))
{
  $keyvalue = $_GET['supplier_payid'];
}
else
{
  $keyvalue = 0;
  $voucher_no = $obj->getcode_suppay($tblname,"voucher_no","1=1");
}

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
 $paid_amt = $remark = $cheque_no= $bank_name = "";
if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$supplier_id = $_POST['supplier_id'];
	$pay_date = $obj->dateformatusa($_POST['pay_date']);
	$paid_amt  = $_POST['paid_amt'];
	$voucher_no = $_POST['voucher_no'];
	$payment_type = $_POST['payment_type'];
	$remark = $_POST['remark'];
  $payment_mode = $_POST['payment_mode'];
  $cheque_no = $_POST['cheque_no'];
  $bank_name = $_POST['bank_name'];
  //$is_security  = isset($_POST['is_security']);
		
	if($keyvalue == 0)
	{    


    $form_data = array('supplier_id'=>$supplier_id,'pay_date'=>$pay_date,'paid_amt'=>$paid_amt,'voucher_no'=>$voucher_no,'payment_type'=>$payment_type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'remark'=>$remark,'payment_mode'=>$payment_mode,'cheque_no'=>$cheque_no,'bank_name'=>$bank_name);
    $obj->insert_record($tblname,$form_data);
    $action=1;
    $process = "insert";
    
	}
	else
	{
		//update
		$form_data = array('supplier_id'=>$supplier_id,'pay_date'=>$pay_date,'paid_amt'=>$paid_amt,'voucher_no'=>$voucher_no,'payment_type'=>$payment_type,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'remark'=>$remark,'payment_mode'=>$payment_mode,'cheque_no'=>$cheque_no,'bank_name'=>$bank_name);
		$where = array($tblpkey=>$keyvalue);
		 $obj->update_record($tblname,$where,$form_data);
		$action=2;
		$process = "updated";
	}
	echo "<script>location='$pagename?action=$action&supplier_id=$supplier_id'</script>";
}

if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $supplier_id =  $sqledit['supplier_id'];
  $pay_date =  $obj->dateformatindia($sqledit['pay_date']);
  $paid_amt =  $sqledit['paid_amt'];
  $voucher_no =  $sqledit['voucher_no'];
  $payment_type =  $sqledit['payment_type'];
  $remark = $sqledit['remark'];
  $payment_mode = $sqledit['payment_mode'];
 
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
  function getid(supplier_id)
{
  var url = 'supplier_payment.php?supplier_id=' + supplier_id;
  location = url;
}

function getdetails(supplier_id)
{
  if(supplier_id !='' || !isNaN(supplier_id))
  {
  jQuery.ajax({
        type: 'POST',
        url: 'getsupplier_paymentdetail.php',
        data: 'supplier_id='+supplier_id,
        dataType: 'html',
        success: function(data){
        //alert(data);
        
        jQuery('#showrecord').html(data);
        }
      
        });//ajax close
  }
}


<?php
if(isset($_GET['supplier_id']) && $_GET['supplier_id'] > 0)
{ ?>
  getdetails(<?php echo $_GET['supplier_id']; ?>);
<?php
}
?>
</script>
</head>
<body onload="hide_text_bank_options();">
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
                        <th>Supplier Name<span style="color:#F00;">*</span></th>
                        <td> <select name="supplier_id" id="supplier_id"  class="chzn-select" style="width:283px;" onChange="getid(this.value);">
                        <option value="">-select-</option>
                        <?php
                        $res = $obj->executequery("select * from master_supplier");
                        foreach($res as $row)
                        {
                          
                        ?> 
                        <option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supplier_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <script>document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>' ;</script></td></tr> 

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
                        <select  class="chzn-select" style="width:283px;" name="payment_mode" id="payment_mode" onChange="hide_text_bank_options(this.value)">
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
                      <tr class="hidden-tr">
                       <th>Bank Name<span style="color:#F00;"></span></th>
                       <td> <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" class="input-xlarge" placeholder="Bank Name"/></td></tr>
                       <tr class="hidden-tr">
                       <th>Cheque No.<span style="color:#F00;"></span></th>
                       <td> <input type="text" maxlength="6" name="cheque_no" id="cheque_no" value="<?php echo $cheque_no; ?>" class="input-xlarge" placeholder="Cheque No."/></td></tr>
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
                            <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('supplier_id,pay_date dt,voucher_no,paid_amt nu,payment_type,payment_mode');">
                            <?php echo $btn_name; ?></button>

                            <a href="supplier_payment.php" name="reset" id="reset" class="btn btn-success">Reset</a></td>
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
                    <?php $loginid = $_SESSION['userid'];  ?>
                    <?php $usertype = $_SESSION['usertype']; ?>
                    <?php $chkview = $obj->check_pageview("supplier_payment.php",$loginid);             
                    if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?>
                      <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
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
                            <?php  $chkdel = $obj->check_delBtn("supplier_payment.php",$loginid);              
                            if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th width="5%" class="head0">Delete</th><?php } ?> 
                         </tr>
                    </thead>
                    <tbody>
			      <?php
            $slno = 1;
            $res = $obj->executequery("select * from supplier_payment where supplier_id = '$supplier_id' order by supplier_payid desc");
						foreach($res as $row_get)
                {

                  $supplier_payid = $row_get['supplier_payid'];
                  $supplier_id = $row_get['supplier_id'];
                  $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
                         
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td>
					            	<td><?php echo $row_get['voucher_no']; ?></td>
                        <td><?php echo $obj->dateformatindia($row_get['pay_date']); ?></td>
                        <td><?php echo $supplier_name; ?></td>
                        <td><?php echo $row_get['payment_type']; ?></td>
                        <td><?php echo $row_get['payment_mode']; ?></td>
                        <td style="text-align: right;"><?php echo number_format(round($row_get['paid_amt']),2); ?></td>
                        
                        <td><a class="btn btn-danger" href="pdf_pay_slip.php?supplier_payid=<?php echo $supplier_payid; ?>" target="_blank">Print</a></td>
                        <?php  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                        <td>
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $supplier_payid; ?>);' style='cursor:pointer'></a>
                        </td><?php } ?>
                </tr>
                
                <?php
                }
                ?>      
                    </tbody>
                </table>
              <?php } ?>
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
           location='<?php echo $pagename."?supplier_id=$supplier_id" ; ?>';
				}
				
			  });//ajax close
		}//confirm close
	} //fun close


jQuery('#pay_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#pay_date').focus();

function hide_text_bank_options(payment_mode)
{
    if (payment_mode=="cheque") 
    {
        
        jQuery(".hidden-tr").show();
        jQuery("#bank_name").val("");
        jQuery("#cheque_no").val("");
        
    }
    else
    {
        jQuery(".hidden-tr").hide();
    }
}

</script>
</body>

</html>
