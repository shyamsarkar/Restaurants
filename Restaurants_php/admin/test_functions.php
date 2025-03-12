<?php include("../adminsession.php");



function get_bill_info($billid)
{

    if($billid!='')
    {
      $sub_total = $obj->getvalfield("view_bill_details","sum(total)","billid='$billid'");
      $total_taxable = $obj->getvalfield("view_bill_details","sum(taxable)","billid='$billid'");
      $total_discount_rs = $sub_total - $total_taxable;

      
      

    }
}

?>