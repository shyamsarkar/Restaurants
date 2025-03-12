<?php 
include '../adminsession.php';
//$btn_name = "Save";

$customer_id = $obj->test_input($_REQUEST['customer_id']);
$supplier_id = $obj->test_input($_REQUEST['supplier_id']);
//print_r($_REQUEST);die;
?>  
     <div class="modal-content" style="padding:0px;">
         <div class="bg" style="padding: 10px 0px;position: sticky;top: 0%;z-index: 1;">
            <div class="row" style="margin-bottom: 0px;">
               <div class="col s2">
                  <a href="#!" class="modal-close"><i class="material-icons white-text">chevron_left</i></a>
               </div>
               <div class="col s10">
                  <strong class="white-text">Bill List (Session : 2021-2022)</strong>
               </div>
            </div>
         </div>
            <div class="row">
            <div class="col s12">
              
                <?php
                // for ($i=0; $i < 5; $i++) {
                       // $arrayName=array();
                //echo "select * from saleentry where supplier_id='$supplier_id' and customer_id='$customer_id' order by bill_date";
                        $sql = $obj->executequery("select * from saleentry where supplier_id='$supplier_id' and customer_id='$customer_id' order by bill_date");

                        //get all bill ids
                        $all_bills_ids = $obj->getvalfield("saleentry","group_concat(saleid)","supplier_id='$supplier_id' and customer_id='$customer_id' order by bill_date");


                        foreach($sql as $row_get)
                        {
                          $saleid = $row_get['saleid'];
                          $net_amount = $row_get['net_amount'];
                          $bill_date = $obj->dateformatindia($row_get['bill_date']);
                          $billno = $row_get['billno'];
                          $customer_id = $row_get['customer_id'];
          

                          $particular = "By saleentry Entry $billno";

                         // $arrayName[]=array('saleid'=>$saleid,'led_date'=>$bill_date,'particular'=>$particular,'billtype'=>'saleentry','billno'=>$billno,'total'=>$net_amount,'led_type'=>'debit');



                          $ispaid = $obj->getvalfield("payment_details","count(*)","sale_id='$saleid' and is_completed=1");
                          $recamt = $obj->getvalfield("payment_details","sum(recamt)","sale_id='$saleid'");
                          $bill_balance = $row_get['net_amount'] - $recamt;
                         
                             //echo($i.'<br>');
                            if($ispaid > 0 || $bill_balance == 0)
                            {

                               $disabled = 'disabled';
                               $color = 'red';
                            }
                            else
                            {
                              $disabled='';
                              $color = 'green';
                            }
                        
                         ?>
                         

               <div class="card horizontal">
                  <div class="card-image">
                     <label style="padding:10px;line-height:10;">
                        <!-- <input type="checkbox" class="filled-in" checked="checked" /> -->
                        <input  type="checkbox" class="filled-in" <?php echo $disabled; ?> name="saleid[]" id="<?php echo $row_get['saleid']; ?>" value="<?php echo $bill_balance; ?>" onclick="set_rec_amt('<?php echo $saleid; ?>','<?php echo $bill_balance; ?>');">
                        <span style="z-index: 0;"><?php //echo $i; ?></span>
                     </label>
                  </div>
                  <div class="card-stacked">
                     <div class="card-content" style="padding: 10px 10px 0px;">
                        <div class="row" style="margin-bottom: 5px;">
                           <div class="col s6">
                              <span class="grey-text">Bill No.:- </span>
                              <span><?php echo $row_get['billno']; ?></span>
                           </div>
                           <div class="col s6">
                              <span class="grey-text">Bill Amt:- </span>
                              <span><?php echo number_format($net_amount,2); ?></span>
                           </div>
                           <div class="col s6">
                              <span class="grey-text">Date:- </span>
                              <span><?php echo $bill_date; ?></span>
                           </div>
                           <div class="col s6">
                              <span class="grey-text">Paid Amt:- </span>
                              <span><?php echo number_format($recamt,2); ?></span>
                           </div>
                        </div>
                        <div class="row" style="margin-bottom: 0px;">
                           <div class="input-field col s6">
                              <label class="active">Recieved Amount</label>
                             <!--  <input type="text" name="" id="" placeholder="000000" style="height: 2rem;"> -->
                              <input style="text-align: right;height: 2rem;" onkeyup="get_total_rec_amt();" class="recamt" type="number" name="recamt<?php echo $saleid; ?>" id="recamt<?php echo $saleid; ?>" value="" <?php echo $disabled; ?> >
                           </div>
                           <div class="input-field col s6">
                              <label class="active">Discount Amount</label>
                              <!-- <input type="text" name="" id="" placeholder="000000" style="height: 2rem;"> -->
                              <input style="text-align: right;height: 2rem;" onkeyup="get_total_rec_amt();" class="disc_amt" type="number" name="disc_amt<?php echo $saleid; ?>" id="disc_amt<?php echo $saleid; ?>" value="" <?php echo $disabled; ?> >
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <?php } ?>
               
               
            </div>
         </div>
         </div>

          <div class="modal-footer indigo lighten-5">
         <div class="row" style="margin-bottom: 0;">
            <div class="col s2">
               <button type="button" class="btn left" style="padding: 0px 10px;" onclick="hidemodal();">Add</button>
                <input type="hidden" name="all_bills_ids" id="all_bills_ids" value="<?php echo $all_bills_ids; ?>">
                <input type="hidden" name="sale_ids" id="sale_ids" value="0">
            </div>
            <div class="input-field col s5" style="margin-bottom: 0rem;">
               <input type="text"  name="totalvalue" id="totalvalue" class="black-text" value="0" disabled style="height: 2rem;">
               <label class="active" class="black-text">Recieved Amount</label>
            </div>
            <div class="input-field col s5" style="margin-bottom: 0rem;">
               <input type="text" name="totaldisc" id="totaldisc" value="0" class="black-text" disabled style="height: 2rem;">
               <label class="active" class="black-text">Discount Amount</label>
            </div>
         </div>
      </div>
<script type="text/javascript">
function set_rec_amt(saleid,billamt)
{
  // alert(saleid); alert(billamt);
  inputid = "#recamt"+saleid;
  inputid2 = "#disc_amt"+saleid;
  checkboxid = saleid;
  //alert(inputid2);
  ischecked = document.getElementById(checkboxid).checked;
  var recamt_txtname = '#recamt'+saleid;

  //alert(ischecked);
   if(ischecked == true){
     jQuery(inputid).val(billamt);
     //alert(recamt_txtname);
     jQuery(recamt_txtname).attr('readonly', true);
  }
  else
  {
    jQuery(inputid).val("");
    //jQuery(inputid2).val("");

    //alert(recamt_txtname);
    //jQuery(recamt_txtname).attr('readonly', false);
    jQuery(recamt_txtname).attr('readonly', false);

    //alert(jQuery(this).val());
    // inputid = '#'+inputid;
    // jQuery(inputid).val(billamt);
  }

  var totalvalue = jQuery("#totalvalue").val();
  var totaldisc = jQuery("#totaldisc").val();
  cur_balance = totalvalue - totaldisc;
  jQuery("#curr_paid_amt").val(cur_balance);
  
  
}

function get_total_rec_amt(){

    var sum = 0;
    var disc = 0;
    
    jQuery(".recamt").each(function(){
        //x = jQuery(this).val();
        //alert(this.value);
        billamt = parseFloat(this.value);
        if(!isNaN(billamt))
        {
          
          sum += billamt;
          
        }
        
    });


    jQuery(".disc_amt").each(function(){
        //x = jQuery(this).val();
        //alert(this.value);
        disc_amt = parseFloat(this.value);
        if(!isNaN(disc_amt))
        {
          
          disc += disc_amt;
          
        }
        
    });

    //alert(sum);
    jQuery("#totalvalue").val(sum);
    curr_paid_amt = sum - disc;
    jQuery("#totaldisc").val(disc);
    //alert(curr_paid_amt);
    jQuery("#curr_paid_amt").val(curr_paid_amt);

}

function check_final_amt()
{
  var totalvalue = jQuery("#totalvalue").val();
  var totaldisc = jQuery("#totaldisc").val();

  totalvalue = totalvalue - totaldisc;
  var curr_paid_amt = jQuery("#curr_paid_amt").val();

  if(totalvalue == curr_paid_amt && curr_paid_amt > 0)
  {
    return true;
  }
  else
  {
    alert('Bill Amount can not matched paid this amt or Inavlid Payment Amount');
    return false;
  }
}

jQuery('input:checkbox').change(function ()
{
      var totalv = 0;
      var sale_ids = 0;
    
      var totalvalue = jQuery("#totalvalue").val();
      //alert(jQuery(this).val());

      jQuery('input:checkbox:checked').each(function(){ // iterate through each checked element.
        totalvalue = isNaN(parseFloat(jQuery(this).val())) ? 0 : parseFloat(jQuery(this).val());
        totalv += parseFloat(totalvalue);

        sale_ids += ","+jQuery(this).attr('id');
  
        //alert(totalv);
      });     

       //var ids =  jQuery("input[type='checkbox']:checked").serialize();
       //alert(sale_ids);
      //alert(jQuery(this).val());


      

      jQuery("#totalvalue").val(totalv);
      var totaldisc = jQuery("#totaldisc").val();

      cur_balance = totalv - totaldisc;
      jQuery("#curr_paid_amt").val(cur_balance);
      jQuery("#sale_ids").val(sale_ids);
   
     

});



         </script>