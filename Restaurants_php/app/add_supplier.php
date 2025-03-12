<?php
include("../adminsession.php");
$pagename = "add_supplier.php";
$module = "supplier_master Master";
$submodule = "SUPPLIER MASTER";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "master_supplier";
$tblpkey = "supplier_id";
if(isset($_GET['supplier_id']))
{
  $keyvalue = $_GET['supplier_id'];
  $btn_name = "Update";
}
else
{
   $keyvalue = "0";
  $btn_name = "Save";
}
$supplier_status = "1";
$dup = "";
$city_name = "";
$priv_bal = "";
$supplier_name = $mobile = $address = $openingbal = $bank_name = $bank_ac = $bank_address = $state_id = $ifsc_code = $gstno = "";
$pincode = "";
$city = "";
$open_bal_date = date("Y-m-d");
if(isset($_GET[$tblpkey]))
{ 

   $btn_name = "Update";
   $where = array($tblpkey=>$keyvalue);
   $sqledit = $obj->select_record($tblname,$where);
   $supplier_name =  $sqledit['supplier_name'];
   $mobile =  $sqledit['mobile'];
   $address =  $sqledit['address'];
  $pincode =  $sqledit['pincode']; 
  $bank_name =  $sqledit['bank_name'];
  $bank_ac =  $sqledit['bank_ac'];
  $ifsc_code =  $sqledit['ifsc_code'];
  $bank_address =  $sqledit['bank_address'];
  $state_id =  $sqledit['state_id'];
  $gstno =  $sqledit['gstno'];
  $openingbal =  $sqledit['openingbal'];
  $open_bal_date = $sqledit['open_bal_date'];
 // $city = $sqledit['city'];

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parakh</title>
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
   td{
    padding: 5px 5px;
   }
   .page-footer {
      padding-top: 0px;
      color: #fff;
      background-color: #18253a;
   }
   .btn{
      width: 80%;
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
  </style>
</head>
<body class="white">
   <?php include('inc/topmenu.php'); ?>
   <?php include('inc/sidemenu.php'); ?>
  <div class="container" style="width:100%;">
      <div class="row">
         <div class="col s12 m6 offset-m3">
            <ul class="tabs tabs-fixed-width tab-demo z-depth-1">
               <li class="tab col s6"><a href="#test1" class="active">Add</a></li>
               <li class="tab col s6"><a  href="#test2">View</a></li>
            </ul>
         </div>
         <div id="test1" class="col m6 offset-m3 s12" style="margin-top:20px;">
            <!-- <form  style="margin-top:20px;"> -->
               <div class="row">
                  <div class="input-field col s6">
                     <input type="text" name="supplier_name" id="supplier_name" placeholder="Enter Customer Name" value="<?php echo $supplier_name;?>">
                     <label for="">Supplier Name <span style="color:#F00;"> * </span></label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="mobile" id="mobile" placeholder="Enter Mobile No." value="<?php echo $mobile;?>" maxlength="10">
                     <label for="">Mobile No./Land Line No. <span style="color:#F00;"> * </span></label>
                  </div>
                  <div class="input-field col s12">
                     <textarea name="address" id="address" placeholder="Enter Address" class="materialize-textarea" ><?php echo $address;?></textarea>
                     <label for="address">Address</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="pincode" id="pincode" placeholder="Enter Pin Code" value="<?php echo $pincode;?>">
                     <label for="">Pin Code</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="gstno" id="gstno" value="<?php echo $gstno;?>" placeholder="Enter GST No.">
                     <label for="">GST No.</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="openingbal" id="openingbal" placeholder="Enter Opening Balance" value="<?php echo $openingbal;?>">
                     <label for="">Opening Balance</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="open_bal_date" id="open_bal_date" value="<?php echo $obj->dateformatindia($open_bal_date);?>" placeholder="Enter Balance Date" class="datepicker">
                     <label for="">Balance Date</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name;?>" placeholder="Enter Bank Name">
                     <label for="">Bank Name</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="bank_ac" id="bank_ac" value="<?php echo $bank_ac;?>" placeholder="Enter Bank A/C">
                     <label for="">Bank A/C</label>
                  </div>
                  <div class="input-field col s6">
                     <input type="text" name="ifsc_code" id="ifsc_code" value="<?php echo $ifsc_code;?>" placeholder="Enter IFSC Code">
                     <label for="">IFSC Code</label>
                  </div>
                  <div class="input-field col s6">
                     <select name="supplier_status" id="supplier_status" class="js-example-basic-single browser-default">
                        <option value="">Status</option>
                        <option value="1">Active</option>
                        <option value="0">In-Active</option>
                     </select>
                      <script>document.getElementById('supplier_status').value = '<?php echo $supplier_status ; ?>';</script>
                     <label class="active">Status <span class="red-text">*</span></label>
                  </div>
                  <div class="input-field col s12">
                     <input type="text" name="bank_address" id="bank_address" value="<?php echo $bank_address;?>" placeholder="Enter Bank Address">
                     <label for="">Bank Address</label>
                  </div>
                  
                  <div class="input-field col s6 right-align">
                     <button type="submit" class="btn" onclick="save_supp();">Save</button>
                  </div>
                  <div class="input-field col s6">
                     <a href="add_supplier.php" class="btn red">Reset</a>
                  </div>
               </div>
            <!-- </form> -->
         </div>
        
         <div id="test2" class="col m6 offset-m3 s12">
           <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
            <?php
              $slno=1;
              $res = $obj->executequery("select * from master_supplier order by supplier_id desc");
              foreach ($res as $row_get )
              { 
               ?>
            <div class="card-panel" style="padding: 1rem;">
               <table id="myTable">
                  <tr>
                     <td><strong>Supplier</strong></td>
                     <td class="right-align"><?php echo $row_get['supplier_name']; ?></td>
                  </tr>
                  <tr>
                      <td><strong>Mobile</strong></td>
                     <td class="right-align"><?php echo $row_get['mobile']; ?></td>
                  </tr>
                  <tr>
                     <td><strong>Address</strong></td>
                     <td class="right-align"><?php echo $row_get['address']; ?></td>
                  </tr>
                 
                  <tr>
                     <td><strong>Pincode</strong></td>
                     <td class="right-align"><?php echo $row_get['pincode']; ?></td>
                     
                  </tr>
                  <tr>
                     <td><strong>GST No.</strong> </td>
                     <td class="right-align"><?php echo $row_get['gstno']; ?></td>
                  </tr>
                  <tr>
                     <td><strong>Bank Name</strong></td>
                     <td class="right-align"><?php echo $row_get['bank_name']; ?></td>
                  </tr>
                  <tr>
                     <td><strong>Bank A/C</strong></td>
                     <td class="right-align"><?php echo $row_get['bank_ac']; ?></td>
                  </tr>
                  <tr>
                     <td><strong>IFSC Code</strong></td>
                     <td class="right-align"><?php echo $row_get['ifsc_code']; ?></td>
                  </tr>
                  <tr>
                     <td><strong>Bank Address</strong></td>
                     <td class="right-align"><?php echo $row_get['bank_address']; ?></td>
                  </tr>
                  <tr>
                     <td><strong>Balance Date</strong></td>
                     <td class="right-align"><?php echo $obj->dateformatindia($row_get['open_bal_date']); ?></td>
                  </tr>
                  <tr class="indigo lighten-5">
                     <td><strong>Opening Bal.</strong></td>
                     <td class="right-align"><strong>&#x20B9; <?php echo number_format($row_get['openingbal'],2); ?></strong></td>
                  </tr>
               </table>
               <div class="row" style="margin-top: 10px;margin-bottom:0px;">
                  <div class="col s6">
                     <a href="add_supplier.php?supplier_id=<?php echo $row_get['supplier_id'] ; ?>" class="btn btn-small white-text green" style="width: 100%;"><i class="material-icons left">edit</i> Edit</a>
                  </div>
                  <div class="col s6">
                     <button type="button" class="btn btn-small white-text red" style="width: 100%;" onclick="funDel(<?php echo $row_get['supplier_id']; ?>);"><i class="material-icons left">delete_forever</i> Delete</button>
                  </div>
               </div>
            </div>
         <?php } ?>
         </div>
      </div>
   </div>

   <script src="materialize/js/jquery.min.js"></script>
   <script src="materialize/js/materialize.min.js"></script>
   <script src="materialize/js/app.js"></script>
   <script src="js/commonfun2.js"></script>
   <script src="js/sweetalert.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   <script type="text/javascript">
      $(document).ready(function() {
         $('.js-example-basic-single').select2();
      });
      $(document).ready(function(){
         $('.tabs').tabs();
      });

       function save_supp()
   {
   
   var  supplier_name= document.getElementById('supplier_name').value;
   var  mobile= document.getElementById('mobile').value;
   var  address= document.getElementById('address').value;
   var  supplier_status= document.getElementById('supplier_status').value;
   var  pincode= document.getElementById('pincode').value;
   var  gstno= document.getElementById('gstno').value;
   var  openingbal= document.getElementById('openingbal').value;
   var  open_bal_date= document.getElementById('open_bal_date').value;
   var  bank_name= document.getElementById('bank_name').value;
   var  bank_ac= document.getElementById('bank_ac').value;
   var  ifsc_code= document.getElementById('ifsc_code').value;
   var  bank_address= document.getElementById('bank_address').value;
   var supplier_id = '<?php echo $keyvalue; ?>';
   //alert(customer_name);alert(mobile);alert(address);alert(supplier_status);alert(pincode);alert(gstno);alert(openingbal);alert(open_bal_date);alert(place_supply);
   if(supplier_name =='')
   {
      alert('Supplier Name cant be blank');  
      document.getElementById("supplier_name").focus();
  
      return false;
   }
   if(mobile=='')
   {
      alert('Mobile No. Cant be blank');
      document.getElementById("mobile").focus();
      return false;
   }
   else
   {
      jQuery.ajax({
        type: 'POST',
        url: 'save_supplier.php',
        data: 'supplier_name='+supplier_name+'&mobile='+mobile+'&address='+address+'&supplier_status='+supplier_status+'&pincode='+pincode+'&gstno='+gstno+'&openingbal='+openingbal+'&open_bal_date='+open_bal_date+'&bank_name='+bank_name+'&supplier_id='+supplier_id+'&bank_ac='+bank_ac+'&ifsc_code='+ifsc_code+'&bank_address='+bank_address,
        dataType: 'html',
        success: function(data){ 
       // console.log(data);          
         //alert(data); 
        
             if(data==1)

             {

               swal("Data Save successfully!")
               .then((value) => {

                  var gourl = 'add_supplier.php';

                  location = gourl;

               });

             }

              if(data==2)

             {

               swal("Data Update successfully!")
               .then((value) => {

                  var gourl = 'add_supplier.php';

                  location = gourl;

               });

             }

             if(data==3)

             {

               swal(" Error : Duplicate Record!");
                 e.preventDefault();

             }
         }
        });//ajax close
     // jQuery('#addlist_btn').prop('disabled', false);
   }
}

function funDel(id)
  {  //alert(id);   
      tblname = '<?php echo $tblname; ?>';
      tblpkey = '<?php echo $tblpkey; ?>';
      pagename = '<?php echo $pagename; ?>';
      submodule = '<?php echo $submodule; ?>';
      module = '<?php echo $module; ?>';
    
    swal({
        title: "Are you sure! You want to delete this record.",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })

      .then((willDelete) => {
        if (willDelete) {
          
          jQuery.ajax({
          type: 'POST',
          url: '../admin/ajax/delete_master.php',
          data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
          dataType: 'html',
          success: function(data){ 
          var gourl = 'add_supplier.php';

            location = gourl;
        }
      });
      }
     
    });
  } //fun close

   </script>

   <script>

    $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $(".card-panel").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
});

</script>
</body>
</html>