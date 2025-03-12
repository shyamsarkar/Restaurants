<?php include("../adminsession.php");
$pcatid = (int)$obj->test($_GET['pcatid']);
$table_id = $obj->test($_GET['table_id']);
$condition = $pcatid == 0 ? " where 1 " : " where pcatid='$pcatid' ";
?>
<table class="table table-condensed table-hover" id="myTable">
  <?php
  $serial_number = 1;
  $all_products = $obj->executequery("SELECT m_product.*, m_food_beverages.food_type_name, m_unit.unit_name from m_product LEFT JOIN m_food_beverages USING(foodtypeid) LEFT JOIN m_unit USING(unitid) $condition ORDER BY productid DESC");
  foreach ($all_products as $product_row) {
    $productid = $product_row['productid'];
    $prodname = $product_row['prodname'];
    $rate = $product_row['rate'];
    $unitid = $product_row['unitid'];
    $unit_name = $product_row["unit_name"];
    $food_type_name = $product_row['food_type_name'];
    $foodtypeid = $product_row['foodtypeid'];
    $product_code = $obj->get_first_letters($prodname);
  ?>
    <tr>
      <td><span class="btn-block adjust"><?php echo $serial_number++; ?></span></td>
      <td><span class="btn btn-danger btn-block adjust"><?php echo $product_code; ?></span></td>
      <td>
        <img src="images/icon.jpg" class="img-circle adjust" style="width:auto;height:35px;margin: auto;" alt="">
      </td>
      <td>
        <h6><?php echo $prodname; ?></h6>
        <span><i class="fa fa-inr"></i> <?php echo $rate . "/-" . $unit_name; ?></span>
      </td>
      <td>
        <button type="submit" class="btn btn-inverse adjust inputbtn" style="float: right;" id="addlistbtn" onclick="addlist('<?php echo $productid; ?>','<?php echo $rate; ?>','<?php echo $unitid; ?>',1, this);">ADD</button>
      </td>
    </tr>
  <?php } ?>
</table>