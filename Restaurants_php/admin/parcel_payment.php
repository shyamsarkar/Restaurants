<?php 
include("../adminsession.php");
if(isset($_REQUEST['table_id']))
{

    $zomato = trim(addslashes($_REQUEST['zomato']));
    $table_id = trim(addslashes($_REQUEST['table_id']));
    $billid = trim(addslashes($_REQUEST['billid']));
    $paydate = $obj->dateformatusa($_REQUEST['paydate']);
    $swiggy = trim(addslashes($_REQUEST['swiggy']));
    $counter_parcel = trim(addslashes($_REQUEST['counter_parcel']));
    
//print_r($_REQUEST);die;
	if($billid > 0)
	{
			
			// parcel order save payment
			$form_data = array('zomato'=>$zomato,'swiggy'=>$swiggy,'counter_parcel'=>$counter_parcel);
			$where = array('table_id'=>$table_id,'billid'=>$billid);
			$obj->update_record("bills",$where,$form_data);
            echo "1";
			
	}//if close
	else
	echo "0";
}


?>