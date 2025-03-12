<?php include("../adminsession.php");

$pagename = "cash_out_master.php";
$module = "Cash Out Master";
$submodule = "Cash Out";
$btn_name = "Save";
$keyvalue = 0 ;
$tblname = "cash_in_out";
$tblpkey = "cash_inout_id";
if(isset($_GET['cash_inout_id']))
$keyvalue = $_GET['cash_inout_id'];
else
$keyvalue = 0;
$cashier_name = $obj->getvalfield("user","username","userid='$loginid'");
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$count = "";
$ex_group_id = $supplier_id = $amount  = "";
$voucher_no = $narration  = $balance = '';
$type = 'cash_out';
$time_at = date('H:i:s');
$inout_date=date('Y-m-d');
if(isset($_POST['submit']))
{ //print_r($_POST); die;
   $ex_group_id = $obj->test_input($_POST['ex_group_id']);  
   $supplier_id = $obj->test_input($_POST['supplier_id']);
   $voucher_no = $obj->test_input($_POST['voucher_no']);
   $time_at = $obj->test_input($_POST['time_at']);
   $pay_mode = $obj->test_input($_POST['pay_mode']);
   $amount = $obj->test_input($_POST['amount']);
   $bank_id = $obj->test_input($_POST['bank_id']);
   $narration = $obj->test_input($_POST['narration']);
   $inout_date = $obj->dateformatusa($_POST['inout_date']);

    
      //insert
        if($keyvalue == 0)
        {    
        $form_data = array('ex_group_id'=>$ex_group_id,'supplier_id'=>$supplier_id,'voucher_no'=>$voucher_no,'time_at'=>$time_at,'pay_mode'=>$pay_mode,'amount'=>$amount,'bank_id'=>$bank_id,'narration'=>$narration,'inout_date'=>$inout_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate,'type'=>$type);
        $obj->insert_record($tblname,$form_data); 
        // print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
        
      }
  
         else{
        //update
        $form_data = array('ex_group_id'=>$ex_group_id,'supplier_id'=>$supplier_id,'voucher_no'=>$voucher_no,'time_at'=>$time_at,'pay_mode'=>$pay_mode,'amount'=>$amount,'bank_id'=>$bank_id,'narration'=>$narration,'inout_date'=>$inout_date,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate,'type'=>$type);
        $where = array($tblpkey=>$keyvalue);
        $keyvalue = $obj->update_record($tblname,$where,$form_data);
        $action=2;
        $process = "updated";
          
               }
    echo "<script>location='$pagename?action=$action'</script>";
   
    
  }
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $ex_group_id =  $sqledit['ex_group_id'];
  $supplier_id =  $sqledit['supplier_id'];
  $voucher_no =  $sqledit['voucher_no'];
  $time_at =  $sqledit['time_at'];
  $pay_mode =  $sqledit['pay_mode'];
  $amount =  $sqledit['amount'];
  $bank_id =  $sqledit['bank_id'];
  $narration =  $sqledit['narration'];
  $inout_date =  $sqledit['inout_date'];
}
else
{
  $voucher_no = $obj->getcode_inout($tblname,"voucher_no","1=1 and type='cash_out'");
  
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
                     <form class="stdform stdform2" method="post" action="">
            <?php echo  $dup;  ?>

             <p>
              <label>Date:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="inout_date" id="inout_date" class="input-xxlarge" readonly  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($inout_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></span>
            </p>

              <p>
              <label>Time At:<span class="text-error">*</span></label>
              <span class="field"><input type="time" name="time_at" placeholder="Voucher No" id="time_at" readonly autocomplete="off" class="input-xxlarge" value="<?php echo $time_at;?>" autofocus/></span>
            </p>

            <p>
              <label>Voucher No:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="voucher_no" placeholder="Voucher No" id="voucher_no" readonly autocomplete="off" class="input-xxlarge" value="<?php echo $voucher_no;?>" autofocus/></span>
            </p>

            <p>
              <label>Cashier Name:</label>
              <span class="field"><input type="text" readonly value="<?php echo $cashier_name;?>" autofocus/></span>
            </p>
             <p>
              <label>Transaction Name <span class="text-error">*</span></label>
              <span class="field"><select name="ex_group_id" id="ex_group_id"  class="chzn-select" style="width:543px;" >
                <option value="">--Select--</option>
                <?php
                $row=$obj->executequery("select * from m_expanse_group");
                foreach ($row as $res) 
                {

                  ?>
                  <option value="<?php echo $res['ex_group_id']; ?>"> <?php echo $res['group_name']; ?></option>    
                  <?php
                }

                ?>

              </select>
              <script>document.getElementById('ex_group_id').value = '<?php echo $ex_group_id; ?>';</script></span>
            </p>
           
             <p>
              <label>Party Name <span class="text-error">*</span></label>
              <span class="field"><select name="supplier_id" id="supplier_id"  class="chzn-select" style="width:543px;" onchange="getbal(this.value);">
                <option value="">--Select--</option>
                <?php
                $row=$obj->executequery("select * from master_supplier");
                foreach ($row as $res) 
                {

                  ?>
                  <option value="<?php echo $res['supplier_id']; ?>"> <?php echo $res['supplier_name'].' ( '.$res['type'].' )'; ?></option>    
                  <?php
                }

                ?>

              </select>
              <script>document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>';</script></span>
            </p>

            <p>
              <label>Payment Mode <span class="text-error">*</span></label>
              <span class="field"><select name="pay_mode" id="pay_mode"  class="chzn-select" style="width:543px;" >
                <option value="">--Select--</option>
              <option value="cash">Cash</option>
              <option value="cheque">Cheque</option>
              <option value="neft">NEFT</option>
              <option value="rtgs">RTGS</option>
              <option value="paytm">PAYTM</option>
              <option value="advance">Advance</option>
              </select>
              <script>document.getElementById('pay_mode').value = '<?php echo $pay_mode; ?>';</script></span>
            </p>
            <p>
              <label>Amount:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="amount" placeholder="Amount" id="amount" autocomplete="off" class="input-xxlarge" value="<?php echo $amount;?>" autofocus/></span>
            </p>

            <p>
              <label>Balance:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="balance" placeholder="Balance" id="balance" readonly autocomplete="off" class="input-xxlarge" autofocus/></span>
            </p>


            <p>
              <label>Bank Name <span class="text-error"></span></label>
              <span class="field"><select name="bank_id" id="bank_id"  class="chzn-select" style="width:543px;" >
               <option value="">--Select--</option>
                        <?php
                        $res = $obj->executequery("select * from m_account");
                        foreach($res as $row_get)
                        {               
                        ?>
                        <option value="<?php echo $row_get['bank_id'];  ?>"> <?php echo $row_get['bank_name']; ?></option>
                        <?php } ?>
                    
              </select>
              <script>document.getElementById('bank_id').value = '<?php echo $bank_id; ?>';</script></span>
            </p>

            <p>
              <label>Narration If Apply:<span class="text-error"></span></label>
              <span class="field"><input type="text" name="narration" id="narration" value="<?php echo $narration; ?>" class="input-xlarge" placeholder="Remark"/></span>
            </p>
             
            <center> <p class="stdformbutton">
              <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('inout_date,time_at,voucher_no,ex_group_id,supplier_id,pay_mode,amount nu');">
                <?php echo $btn_name; ?></button>
                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
              </p> </center>
            </form>
                    </div>
            <!-- for print pdf -->
              <!-- <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_expense_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p> -->

                      <?php  $chkview = $obj->check_pageview("cash_out_master.php",$loginid);             
                  if($chkview == 1 || $_SESSION['usertype']=='admin'){  ?> 
 
                <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
              <table class="table table-bordered" id="dyntable">
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
                          
                            <th class="head0 nosort">Sno.</th>
                            <th class="head0">Transaction_Name</th>
                            <th class="head0">Party_Name</th>
                            <th class="head0">Voucher_No</th>
                            <th class="head0">Time_At</th>
                            <th class="head0">Payment_Mode</th>
                            <th class="head0" style="text-align: right;">Amount</th>
                            <th class="head0">Date</th>
                            <th class="head0">Bank_Name</th>
                            <th class="head0">Narration</th>
                           
                            
                             <?php  $chkedit = $obj->check_editBtn("cash_out_master.php",$loginid);              
                            if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th class="head0" style="text-align: center;">Edit</th> <?php } ?>
                            <?php  $chkdel = $obj->check_delBtn("cash_out_master.php",$loginid);             
                            if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th class="head0" style="text-align: center;">Delete</th><?php } ?>
                         </tr>
                    </thead>
                    <tbody>
                          
            <?php
            $slno=1;
           
            $res = $obj->executequery("select * from cash_in_out where type='cash_out' order by cash_inout_id desc");
            foreach($res as $row_get)
                {
                  $ex_group_id = $row_get['ex_group_id']; 
                  $group_name = $obj->getvalfield("m_expanse_group","group_name","ex_group_id='$ex_group_id'");
                  $supplier_id = $row_get['supplier_id']; 
                  $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
                  $bank_id = $row_get['bank_id']; 
                  $bank_name = $obj->getvalfield("m_account","bank_name","bank_id='$bank_id'");
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $group_name; ?></td>
                        <td><?php echo $supplier_name; ?></td>
                        <td><?php echo $row_get['voucher_no']; ?></td>
                        <td><?php echo $row_get['time_at']; ?></td>
                        <td><?php echo $row_get['pay_mode']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($row_get['amount'],2); ?></td>
                        <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['inout_date']); ?></td>
                        <td><?php echo $bank_name; ?></td>
                         <td><?php echo $row_get['narration']; ?></td>
                        
                        
                       <?php if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                       <td style="text-align: center;"><a class='icon-edit' title="Edit" href='cash_out_master.php?cash_inout_id=<?php echo $row_get['cash_inout_id'] ; ?>'></a></td><?php } ?>
                       <?php  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>  
                        <td style="text-align: center;">
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['cash_inout_id']; ?>);' style='cursor:pointer'></a>
                        </td><?php } ?>
                </tr>
                
                <?php
                }
                ?>     
                    </tbody>
                </table>
              <?php } ?>
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


jQuery('#inout_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#inout_date').focus();

function getbal(supplier_id)
{
//alert(supplier_id);
  jQuery.ajax({
        type: 'POST',
        url: 'getbal_supplier.php',
        data: 'supplier_id='+supplier_id,
        dataType: 'html',
        success: function(data){
          //alert(data);
          jQuery('#balance').val(data);
        
        }
        });//ajax close
}
</script>
</body>
</html>
