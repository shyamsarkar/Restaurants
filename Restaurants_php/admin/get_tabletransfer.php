<?php include("../adminsession.php");
$floor_idt = $_REQUEST['floor_idt'];

$res = $obj->executequery("select * from m_table where floor_id = '$floor_idt'");
foreach ($res as $row) { ?>
<option value="<?php echo $row['table_id']; ?>"><?php echo $row['table_no']; ?></option>
<?php  }
?>
