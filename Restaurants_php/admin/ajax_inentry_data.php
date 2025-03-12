<?php
 include("../adminsession.php");
$tblname = $obj->test_input($_POST['tblname']);
$tblpkey = $obj->test_input($_POST['tblpkey']);
$pcatid = $_REQUEST['pcatid'];
$zomato = $_REQUEST['zomato'];

if(!empty($tblname) && !empty($tblpkey))
{
  if($pcatid == 0)
  $crit = " where 1 = 1 ";
  else
  $crit = " where pcatid='$pcatid' ";
  if($zomato=="zomato") 
              {
              $class = "alert-danger"; 
              $type = "zomato Rate";
              }
              else
              {
              $class = "";
              $type = "Table Rate";
              }
              ?>
                   <table class="table table-condensed table-bordered <?php echo $class; ?>" border="10px" id="myTable">
                           <tr class="alert-success" id="tr">
                             <td id="td">Sno.</td>
                             <td>ITEM NAME</td>
                             <td>CGST</td>
                             <td>SGST</td>
                             <td>TYPES</td>
                             <td style="text-align: right;">PRICE</td>
                             
                           </tr>
                           <tr>
                            <?php
                            $sno = 1;
                            $fetch = $obj->executequery("select *, m_product.foodtypeid, food_type_name from m_product left join m_food_beverages on m_product.foodtypeid = m_food_beverages.foodtypeid $crit order by productid desc");
                            foreach ($fetch as $data)
                             {

                              $productid = $data['productid'];
                              $prodname = $data['prodname'];
                              $rate1 = $data['rate'];
                              $zomato_rate = $data['zomato_rate'];
                              $unitid = $data['unitid'];
                              $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
                              $food_type_name = $data['food_type_name'];
                              $foodtypeid = $data['foodtypeid'];

                              $sgst = $obj->getvalfield("tax_setting_new","sgst","foodtypeid='$foodtypeid' and is_applicable=1");
                              $cgst = $obj->getvalfield("tax_setting_new","cgst","foodtypeid='$foodtypeid' and is_applicable=1");
                              
                              if($zomato=='zomato')
                              {
                                  $rate = $data['zomato_rate'];
                              }
                              else
                              {
                                $rate = $data['rate'];
                              }
                             
                             
                             ?>
                            
                           </tr>
                          <tr onClick="addproduct('<?php echo $data['productid'];  ?>','<?php echo $data['prodname']; ?>','<?php echo $unitid ?>','<?php echo $unit_name; ?>','<?php echo $rate; ?>','<?php echo $cgst; ?>','<?php echo $sgst; ?>');" style="cursor: pointer;">
                            <td><?php echo $productid; ?></td>
                             <td><b><?php echo strtoupper($prodname); ?></b></td>
                             <td><b><?php echo strtoupper($cgst); ?></b></td>
                             <td><b><?php echo strtoupper($sgst); ?></b></td>
                             <td><?php echo $type; ?></td>
                             <td style="text-align: right;"><b><?php echo number_format($rate,2); ?></b></td>
                        </tr>
                            <?php } ?>
                         
                         </table>           
   <?php 
}

?>