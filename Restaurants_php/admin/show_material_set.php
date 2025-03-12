<?php
include("../adminsession.php");
$finish_id=trim(addslashes($_REQUEST['finish_id'])); 


if($finish_id =='')
{
	$finish_id=0;	
}

$where = array("finish_id"=>$finish_id);

$res = $obj->select_data("material_setting",$where);

$sn=1;

?>
<table width="100%" class="table table-bordered table-condensed">
      <thead>
          <tr>
              <th>Sl.No</th>
              <th>Row Material</th>
              <th>Unit</th>
              <th>Qty</th>
              <th class="center">Action</th>
          </tr>
      </thead>
      <tbody>
                                        
   <?php
				//$toal_disc=0;					
			foreach($res as $rowget)
			{
					
				 $material_set_id = $rowget['material_set_id'];
         $row_id = $rowget['row_id'];
         $row_name = $obj->getvalfield("raw_material","raw_name","raw_id='$row_id'");
         $unitid = $obj->getvalfield("raw_material","unitid","raw_id='$row_id'");
         $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");
         $qty = $rowget['qty'];


			?>
        <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $row_name; ?></td>
          <td><?php echo $unit_name; ?></td>
          <td><?php echo $qty; ?></td>
          <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $material_set_id; ?>');"> X </a></td>

     </tr>
                                            
             <?php
			 		
				
$sn++;
}//loop close
?>    
           
    </tbody>
                                    </table>
