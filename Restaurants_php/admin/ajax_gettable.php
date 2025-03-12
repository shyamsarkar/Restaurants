<?php include("../adminsession.php");

$floor_id = (int)$obj->test($_GET['floor_id']);
$condition = $floor_id == 0 ? " where 1 " : " where floor_id ='$floor_id' ";
?>

<div class="autooverflow">
  <div class="row-fluid">
    <div class="span6">
      <?php
      $free_table_list = $obj->executequery("SELECT * FROM m_table $condition AND (SELECT COUNT(billdetailid) FROM bill_details WHERE table_id = m_table.table_id AND isbilled=0) = 0 order by parcel_type DESC");
      foreach ($free_table_list as $rows) {
      ?>
        <button type="button" class="btn btn-success btn-block" onclick="gettableid('<?php echo $rows['table_id']; ?>');"><?php echo $rows['table_no']; ?></button>
      <?php } ?>
    </div>
    <div class="span6">
      <?php
      $reserved_table_list = $obj->executequery("SELECT * FROM m_table $condition AND (SELECT COUNT(billdetailid) FROM bill_details WHERE table_id = m_table.table_id AND (billid=0 or isbilled=0)) != 0 order by parcel_type DESC");
      foreach ($reserved_table_list as $rows) {
      ?>
        <button type="button" class="btn btn-danger btn-block" onclick="gettableid('<?php echo $rows['table_id']; ?>');"><?php echo $rows["table_no"]; ?></button>
      <?php } ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  function gettableid(table_id) {
    location = 'in_entry_new.php?table_id=' + table_id;
  }
</script>