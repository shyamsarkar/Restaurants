<?php
include("../adminsession.php");
$issueid=trim(addslashes($_REQUEST['issueid'])); 

if($issueid =='')
{
	$issueid=0;	
}
else
{
	$issueid=$issueid;
}
//$sn=1;
$where = array("issueid"=>$issueid);
$res = $obj->select_data("issue_entry_details",$where);
$sn=1;
$amount=0;
$totgst=0;
$totalamount=0;
$totsgst=0;
$totigst=0;
?>
  <table width="100%" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Product Name</th>
            <th>Unit</th>
            <th>Qty.</th>
            
            
            <th width="10%" class="center">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
			foreach($res as $rowget)
			{		
					
					$issueid_detail=$rowget['issueid_detail'];
					$raw_id=$rowget['raw_id'];
					$raw_name = $obj->getvalfield("raw_material","raw_name","raw_id='$raw_id'");
          $issueid=$rowget['issueid'];
          $unit_name=$rowget['unit_name'];
          $qty=$rowget['qty'];
          
          

		?>
      <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $raw_name; ?></td>
          <td><?php echo $unit_name; ?></td>
          <td><?php echo $qty;  ?></td>
         

          
          <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $issueid_detail; ?>');"> X </a> / &nbsp;<a  class="btn btn-primary btn-small" title="Edit" onclick="updaterecord('<?php echo $raw_id; ?>','<?php echo $raw_name; ?>','<?php echo $unit_name; ?>','<?php echo $qty; ?>','<?php echo $rate_amt; ?>','<?php echo $total; ?>','<?php echo $issueid_detail; ?>');">
          <span class='icon-edit' ></span> 
          </a></td>
      </tr>
      <?php
      
      $sn++;
      }
      //echo $amount;
      ?>    
           
                                         
      		<tr>
                  <td colspan="10"><p align="center"> <input type="submit" class="btn btn-danger" value="Save" name="submit"  >  &nbsp; &nbsp; 
                  <input type="hidden" name="issueid" value="<?php echo $issueid; ?>"  />
                  <a href="issue_entry.php" class="btn btn-primary" > Reset </a>

                  
                   </p>  </td>
     	 	</tr>                                      
              
                </tbody>
                </table>
