<?php
include("../adminsession.php");
$table_id = $_REQUEST['table_id'];
$floor_id = $_REQUEST['floor_id'];
$zomato = $_REQUEST['zomato'];

$net_bill_amt = $obj->getvalfield("bills","net_bill_amt","table_id='$table_id' and is_paid=0");
$customer_name = $obj->getvalfield("bills","net_bill_amt","table_id='$table_id' and is_paid=0");
$billnumber = $obj->getvalfield("bills","billnumber","table_id='$table_id' and is_paid=0");
$billid = $obj->getvalfield("bills","billid","table_id='$table_id' and is_paid=0");
//$count_status = $obj->getvalfield("bills","count(table_id)","table_id='$table_id' and is_paid=0");
$table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");


?>
       <table class="table table-condensed table-bordered" border="10px">
             <tbody>
                           <tr class="alert-success" >
                             <td>Sno.</td>
                             <td>Floor</td>
                             <td>Table</td>
                             <td>Pending KOT For Qty</td>
                             <td>Billing_Status</td>
                             <td>Table_Status</td>
                             <td>Open</td>
                           </tr>
                           
                          
                            <?php 
                            $sno = 1;
                            $total = 0;
                            if($floor_id!="")
                            {
                            $sqlget = $obj->executequery("select * from m_table where floor_id='$floor_id' order by table_no");
                            }
                            else
                                $sqlget = $obj->executequery("select * from m_table order by table_no");
                            foreach ($sqlget as $rowget) 
                            {
                               
                                $table_id2 = $rowget['table_id'];
                                $table_no2 = $rowget['table_no'];
                                $floor_id2 =  $rowget['floor_id'];

                                $floor_name2 = $obj->getvalfield("m_floor","floor_name","floor_id='$floor_id2'");
                                $qty2 =  $obj->getvalfield("bill_details","sum(qty)","table_id='$table_id2' and billid = 0 and kotid = 0");
                                 
                                 
                               //check running talbe
                               $count_status = $obj->getvalfield("bill_details","billdetailid","table_id='$table_id2' and  (billid=0 or isbilled=0)");

                               //check is bill saved
                               $billsaved = $obj->getvalfield("bill_details","billdetailid","table_id='$table_id2' and  billid = 0");
                                

                                if($count_status > 0) 
                                {
                                    $status1 = "<span style='color:red'>Running</span>";
                                    if($billsaved > 0)
                                    $status2 = "Not Saved";
                                    else
                                    $status2 = "Bill Saved";

                                }
                                else
                                {
                                        $status1 = "<span style='color:green'>Free</span>";
                                        $status2 = "Not Saved";
                                }

                                                            
                             ?>
                              <tr>
                                <td><?php echo $sno++; ?></td>
                                <td><?php echo $floor_name2; ?></td> 
                                <td><?php echo $table_no2; ?></td>
                                <td><?php echo $qty2;  ?></td>
                                <td><?php echo $status2;  ?></td>
                                <td><?php echo $status1;  ?></td>
                                <td><button type="button" style="cursor: pointer;" onclick="gourl('<?php echo $zomato; ?>','<?php echo $floor_id2; ?>','<?php echo $table_id2; ?>');">OPEN</button></td>
                             
                                
                                
                            
                        </tr>
                        <?php  
                        
                            } //loop close
                            ?>
                           <tr>

 
 </tr>
 
     

            </tbody>
                                    </table>
             <!--  <?php if($waiter_id > 0)
              {
              ?>     
            <center><h4 style="color: red;">Order From App</h4>
                     <h4>Waiter Name :&nbsp;<b><?php echo strtoupper($waiter_name); ?></b></h4>  </center>   

              <?php 
            }
               ?> -->
                                    <!-- '<?php //echo $net_bill_amt; ?>','<?php //echo $billnumber; ?>','<?php //echo $table_no; ?>' -->
                         
                         </table>

