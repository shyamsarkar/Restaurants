<?php
include("../adminsession.php");
$tblname = "m_category";
$tblpkey = "category_id";


$category_name = $_REQUEST['category_name'];  


//print_r($_REQUEST);die;
 $cwhere = array("category_name"=>$_REQUEST['category_name']);
    $count = $obj->count_method("m_category",$cwhere);
    if($count > 0 )
    {
    	echo "4";

    } 
    else{
if($tblpkey!=""){
	  //save product
		$form_data = array('category_name'=>$category_name,'ipaddress'=>$ipaddress,'createdate'=>$createdate);
			$obj->insert_record($tblname,$form_data);
			//$action=1;

}
}
?>
<option value="">--Select--</option>
<?php 
$res = $obj->executequery("select * from m_category order by category_id desc");
foreach($res as $row_get)

 {
?>
 	<option value="<?php echo $row_get['category_id']; ?>" > <?php echo $row_get['category_name']; ?> </option>


<?php }  ?>






