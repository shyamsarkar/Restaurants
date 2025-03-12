<?php include("../adminsession.php");
$pagename = "expense.php";
$module = "Expense";
$submodule = "EXPENSE";
$btn_name = "Save";
$keyvalue = 0 ;
$tblname = "expanse";
$tblpkey = "expanse_id";
if(isset($_GET['expanse_id']))
$keyvalue = $_GET['expanse_id'];
else
$keyvalue = 0;
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
$status = "";
$dup = "";
$count = "";
$group_name = $exp_name = $exp_date= $exp_amount = "";

if(isset($_POST['submit']))
{ //print_r($_POST); die;
   $ex_group_id = $_POST['ex_group_id'];  
   $exp_name = $_POST['exp_name'];
   $exp_amount = $_POST['exp_amount'];
   $exp_date = $obj->dateformatusa($_POST['exp_date']);

    //check Duplicate
  $cwhere = array("ex_group_id"=>$_POST['ex_group_id'],"exp_name"=>$_POST['exp_name']);
  $count = $obj->count_method("expanse",$cwhere);
      if($count > 0 && $keyvalue == 0)
      {
      
      $dup="<div class='alert alert-danger'>
      <strong>Error!</strong> Error : Duplicate Record.
      </div>";
      } 
      
    else{
      //insert
        if($keyvalue == 0)
        {    
        $form_data = array('ex_group_id'=>$ex_group_id,'exp_name'=>$exp_name,'exp_date'=>$exp_date,'exp_amount'=>$exp_amount,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'createdate'=>$createdate);
        $obj->insert_record($tblname,$form_data); 
 // print_r($form_data); die;
        $action=1;
        $process = "insert";
        echo "<script>location='$pagename?action=$action'</script>";
        
      }
  
         else{
        //update
        $form_data = array('ex_group_id'=>$ex_group_id,'exp_name'=>$exp_name,'exp_date'=>$exp_date,'exp_amount'=>$exp_amount,'ipaddress'=>$ipaddress,'createdby'=>$loginid,'lastupdated'=>$createdate);
        $where = array($tblpkey=>$keyvalue);
        $keyvalue = $obj->update_record($tblname,$where,$form_data);
        $action=2;
        $process = "updated";
          
               }
    echo "<script>location='$pagename?action=$action'</script>";
   
    }
  }
if(isset($_GET[$tblpkey]))
{ 

  $btn_name = "Update";
  $where = array($tblpkey=>$keyvalue);
  $sqledit = $obj->select_record($tblname,$where);
  $ex_group_id =  $sqledit['ex_group_id'];
  $exp_name =  $sqledit['exp_name'];
  $exp_amount =  $sqledit['exp_amount'];
  $exp_date =  $sqledit['exp_date'];
}
else
{
//$status = "enable";
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
              <label>Expence Group Name <span class="text-error">*</span></label>
              <span class="field"><select name="ex_group_id" id="ex_group_id"  class="chzn-select" style="width:543px;" >
                <option value=""></option>
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
              <label>Expense Name:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="exp_name" placeholder="Expense Name" id="exp_name" autocomplete="off" class="input-xxlarge" value="<?php echo $exp_name;?>" autofocus/></span>
            </p>
            <p>
              <label>Amount:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="exp_amount" placeholder="Amount" id="exp_amount" autocomplete="off" class="input-xxlarge" value="<?php echo $exp_amount;?>" autofocus/></span>
            </p>
            <p>
              <label>Date:<span class="text-error">*</span></label>
              <span class="field"><input type="text" name="exp_date" id="exp_date" class="input-xxlarge"  placeholder='dd-mm-yyyy'
                     value="<?php echo $obj->dateformatindia($exp_date); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></span>
            </p>
             
            <center> <p class="stdformbutton">
              <button  type="submit" name="submit" class="btn btn-primary" onClick="return checkinputmaster('ex_group_id,exp_name,exp_amount nu,exp_date');">
                <?php echo $btn_name; ?></button>
                <a href="<?php echo $pagename; ?>"  name="reset" id="reset" class="btn btn-success">Reset</a>
                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
              </p> </center>
            </form>
                    </div>
            <!-- for print pdf -->
              <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="pdf_expense_master.php" class="btn btn-info" target="_blank">
                    <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>

                      <?php  $chkview = $obj->check_pageview("expense.php",$loginid);             
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
                            <th class="head0">Expense Group Name</th>
                            <th class="head0">Name</th>
                            <th class="head0" style="text-align: center;">Date</th>
                            <th class="head0" style="text-align: right;">Amount</th>
                            
                             <?php  $chkedit = $obj->check_editBtn("expense.php",$loginid);              
                            if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th class="head0" style="text-align: center;">Edit</th> <?php } ?>
                            <?php  $chkdel = $obj->check_delBtn("expense.php",$loginid);             
                            if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>
                            <th class="head0" style="text-align: center;">Delete</th><?php } ?>
                         </tr>
                    </thead>
                    <tbody>
                          
        <?php
            $slno=1;
            //$res = $obj->fetch_record("m_unit");
            $res = $obj->executequery("select * from expanse order by expanse_id desc");
            foreach($res as $row_get)
                {
                  $ex_group_id = $row_get['ex_group_id']; 
                  $group_name = $obj->getvalfield("m_expanse_group","group_name","ex_group_id='$ex_group_id'");
                ?>   
                   <tr>
                        <td><?php echo $slno++; ?></td> 
                        <td><?php echo $group_name; ?></td>
                        <td><?php echo $row_get['exp_name']; ?></td>
                        <td style="text-align: center;"><?php echo $obj->dateformatindia($row_get['exp_date']); ?></td>
                        <td style="text-align: right;"><?php echo number_format($row_get['exp_amount'],2); ?></td>
                        
                       <?php if($chkedit == 1 || $_SESSION['usertype']=='admin'){  ?>
                       <td style="text-align: center;"><a class='icon-edit' title="Edit" href='expense.php?expanse_id=<?php echo $row_get['expanse_id'] ; ?>'></a></td><?php } ?>
                       <?php  if($chkdel == 1 || $_SESSION['usertype']=='admin'){  ?>  
                        <td style="text-align: center;">
                        <a class='icon-remove' title="Delete" onclick='funDel(<?php echo $row_get['expanse_id']; ?>);' style='cursor:pointer'></a>
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


jQuery('#exp_date').mask('99-99-9999',{placeholder:"dd-mm-yyyy"});
jQuery('#exp_date').focus();
  </script>
</body>
</html>
