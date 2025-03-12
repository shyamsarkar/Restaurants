<?php 
include '../adminsession.php';
?>   
       
<?php
$sno = 1;
$sql = $obj->executequery("select * from cap_stw_table");
?>
<table class="table table-bordered table-condensed">
<tr>
	<td>S No</td>
    <td>Table No.</td>
	<td>Captain</td>
	<td>Steward</td>
	<td>Delete</td>
</tr>     
<?php     
foreach ($sql as $key)
{ 
	$cap_stw_id = $key['cap_stw_id'];
	$table_id = $key['table_id'];
	$table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");
    $waiter_id_cap = $key['waiter_id_cap'];
	$waiter_id_stw = $key['waiter_id_stw'];
	$cap_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap' and job_type = 'captain'");
	$stw_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw' and job_type = 'steward'");
	
	?>
	     
	     <tr>
	     	<td><?php echo $sno++; ?></td>
            <td><?php echo $table_no; ?></td>
            <td><?php echo $cap_name; ?></td>
            <td><?php echo $stw_name; ?></td>
            <td><a class='icon-remove' title="Delete" onclick='funDel_project_img(<?php echo $cap_stw_id; ?> );' style='cursor:pointer;font-size: 20px;'></a></td>
        </tr>
         
<?php
}
?>
 </table>

 
 