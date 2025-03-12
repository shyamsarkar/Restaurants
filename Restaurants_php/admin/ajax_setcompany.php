<?php
include("../adminsession.php");

$branch_id = addslashes($_REQUEST['branch_id']);

if($branch_id !='')
{
	$where = array('branch_id'=>$_REQUEST['branch_id']);
	$res = $obj->select_record2("company_setting",$where);

	if($res !=''){
	foreach($res as $rowget)
	{		
	?>   
    <option value="<?php echo $rowget['company_id']; ?>"><?php echo $rowget['company_name']; ?></option>
    <?php
	}
}
}
?>