<?php
include("../adminsession.php");
require("fpdf17/fpdf.php");
$comp_name =  $obj->getvalfield("company_setting","comp_name","1 = 1");

$pagename = "pdf_finished_good_report.php";
$module = "FINISHED REPORT";
$submodule = "Finished Report";
$btn_name = "Save";
$keyvalue =0 ;
$tblname = "m_product";
$tblpkey = "productid";

$duplicate = "";
$crit = " where 1=1 ";


if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $_GET['from_date'];
    $to_date  =  $_GET['to_date'];
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
  //$productid = "";
  $pcatid = "";
}


if(isset($_GET['pcatid']))
{
  
  $pcatid = $_GET['pcatid'];
  if(!empty($pcatid))
    $crit .= " and pcatid = '$pcatid' ";
}


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$comp_name,$from_date,$to_date;
        
        $this->Rect(5,5,200,287);
        $this->SetFont('courier','b',15);
        $this->Line(5,18,205,18);
         // courier 25
        $this->SetFont('courier','b',20);
        // Move to the right
        $this->Cell(95);
        // Title
        $this->Cell(10,0,$title1,0,0,'C');
        // Line break
        $this->Ln(6);
        // Move to the right
        $this->Cell(90);
         // courier bold 15
        $this->SetFont('courier','b',11);
        $this->Cell(20,0,$title2,0,0,'C');
          // Move to the right
        $this->Cell(80);
        // Line break
        $this->Ln(5);
        
        $this->Cell(3);
        $this->SetFont('courier','b',8);
        $this->Cell(35,0,"From Date : ".$from_date,0,1,'R');
        $this->Cell(1);
        $this->SetFont('courier','b',8);
        $this->Cell(190,0,"To Date : ".$to_date,0,1,'R');

        $this->Ln(5);
        $this->SetX(5);
        $this->SetFont('Arial','B',9);
        $this->Cell(10,6,'Sno','1',0,'L',0);
        $this->Cell(40,6,'Product.',1,0,'L',0);
        $this->Cell(15,6,'Unit',1,0,'L',0);
        $this->Cell(25,6,'Open_Stock(+)',1,0,'L',0);
        $this->Cell(15,6,'Pur(+)',1,0,'L',0);
        $this->Cell(16,6,'Adjust(+)',1,0,'L',0);
        $this->Cell(15,6,'Adjust(-)',1,0,'L',0);
        $this->Cell(19,6,'Product.(+)',1,0,'L',0);
        $this->Cell(20,6,'Wastage(-)',1,0,'L',0);
        $this->Cell(13,6,'Sale(-)',1,0,'L',0);
        $this->Cell(12,6,'Stockin',1,1,'L',0);
        $this->SetX(5);
        $this->SetAligns(array('L','L','L','L','L','L','L','L','L','L'));
        $this->SetWidths(array(10,40,15,25,15,16,15,19,20,13,12));
        $this->SetFont('Arial','',6);
        $this->SetX(5);
       
    }
      // Page footer
    function Footer()
    {
    // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8); 
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}

?>
<?php
function GenerateWord()
{
    //Get a random word
    $nb=rand(3,10);
    $w='';
    for($i=1;$i<=$nb;$i++)
        $w.=chr(rand(ord('a'),ord('z')));
    return $w;
}

function GenerateSentence()
{
    //Get a random sentence
    $nb=rand(1,10);
    $s='';
    for($i=1;$i<=$nb;$i++)
        $s.=GenerateWord().' ';
    return substr($s,0,-1);
}
$pdf=new PDF_MC_Table();
$title1 = "$comp_name";
$pdf->SetTitle($title1);
$title2 = "Stock Details";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');




                  $slno=1;
                  $totalamt=0;
                  $totOpening_stock = 0;
                  $totpurchase_qty = 0;
                  $totproduction_qty = 0;
                  $totadjustment_qty_plus = 0;
                  $totadjustment_qty_minus = 0;
                  $totwastage_qty = 0;
                  $totsale_qty = 0;
                  //$sql = "select * from m_product $crit";
                   if($pcatid > 0)
                  {
                    $sql = "select * from m_product where pcatid = '$pcatid'";
                    //$sql = "select * from m_product $crit";
                  }
                  else
                  {
                    $sql = "select * from m_product";
                  }
                  $res = $obj->executequery($sql);
                  $stock_in_hand = 0;
                  $open_stock = 0;
                  foreach($res as $row_get)
                  {
                    
                      //$total=0;
                      $productid = $row_get['productid'];
                      $prodname = $row_get['prodname'];
                      $qty = $row_get['qty'];
                      $unitid = $row_get['unitid'];
                      $unit_name = $obj->getvalfield("m_unit","unit_name","unitid='$unitid'");

                       //count purchase entry
                    $purchase_qty = 0;
                     $purchaseentry = "select qty from purchasentry_detail left join purchaseentry on purchasentry_detail.purchaseid = purchaseentry.purchaseid 
                    where productid = '$productid' and purchaseentry.bill_date between '$from_date' and '$to_date'";
                  
                   
                       $res = $obj->executequery($purchaseentry);
                       foreach($res as $row_get)
                       {
                          
                            $purchase_qty += (float)$row_get['qty'];
                            
                       }


                      //count production
                    $production_qty = 0;
                     $productionquery = "select production_qty from production_entry where productid = '$productid' and production_date between '$from_date' and '$to_date'";
                   
                       $res = $obj->executequery($productionquery);
                       foreach($res as $row_get)
                       {
                          
                            $production_qty += (float)$row_get['production_qty'];
                            
                       }

                    //     //count wastage
                    $wastage_qty = 0;
                    $wastagequery = "select wastage_qty from wastage_entry where productid = '$productid' and wastage_date between '$from_date' and '$to_date'";
                   
                       $res = $obj->executequery($wastagequery);
                       foreach($res as $row_get)
                       {
                          
                            $wastage_qty += (float)$row_get['wastage_qty'];
                            
                       }

                       //count adjustment plus
                    $adjustment_qty_plus = 0;
                     $adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'plus' and adjustment_date between '$from_date' and '$to_date'";
                   
                       $res = $obj->executequery($adjustmentquery);
                       foreach($res as $row_get)
                       {
                            
                            $adjustment_qty_plus += (float)$row_get['adjustment_qty'];
                            
                       }

                       //count adjustment minus
                    $adjustment_qty_minus = 0;
                     $adjustmentquery = "select adjustment_qty from adjustment_entry where productid = '$productid' and type = 'minus' and adjustment_date between '$from_date' and '$to_date'";
                   
                       $res = $obj->executequery($adjustmentquery);
                       foreach($res as $row_get)
                       {
                            
                            $adjustment_qty_minus += (float)$row_get['adjustment_qty'];
                            
                       }
                     
                    // //count sale
                    $sale_qty = 0;
                    $salequery = "select qty from bill_details left join bills on bill_details.billid = bills.billid where productid = '$productid' and bills.billdate between '$from_date' and '$to_date'";
                   
                       $res = $obj->executequery($salequery);
                       foreach($res as $row_get)
                       {
                          
                            $sale_qty += (float)$row_get['qty'];
                           
                       }
                      

                         $Opening_stock = $obj->get_opening_stock_for_finished($productid,$from_date);
                        $stock_in_hand = $Opening_stock + $purchase_qty + $adjustment_qty_plus - $adjustment_qty_minus + $production_qty - $wastage_qty - $sale_qty;
                            

    $pdf->SetX(5);  
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,strtoupper($prodname),strtoupper($unit_name),$Opening_stock,$purchase_qty,$production_qty,$adjustment_qty_plus,$adjustment_qty_minus,$wastage_qty,$sale_qty,$stock_in_hand));

    $totOpening_stock += $Opening_stock;
    $totpurchase_qty += $purchase_qty;
    $totproduction_qty += $production_qty;
    $totadjustment_qty_plus += $adjustment_qty_plus;
    $totadjustment_qty_minus += $adjustment_qty_minus;
    $totwastage_qty += $wastage_qty;
    $totsale_qty += $sale_qty;
    $totalamt += $stock_in_hand;
    }


    $pdf->SetX(5);
$pdf->SetFont('Arial','B',8);
$pdf->SetFillColor(255, 255, 255); //gray
//$pdf->SetTextColor(0,0,0);
$pdf->Cell(65,7,'TOTAL','1',0,'L',1);  

$pdf->Cell(25,7,$totOpening_stock,1,0,'L',1);
$pdf->Cell(15,7,$totpurchase_qty,1,0,'L',1);
$pdf->Cell(16,7,$totproduction_qty,1,0,'L',1);
$pdf->Cell(15,7,$totadjustment_qty_plus,1,0,'L',1);
$pdf->Cell(19,7,$totadjustment_qty_minus,1,0,'L',1);
$pdf->Cell(20,7,$totwastage_qty,1,0,'L',1);
$pdf->Cell(13,7,$totsale_qty,1,0,'L',1);
$pdf->Cell(12,7,$totalamt,1,0,'L',1);


$pdf->Output();
?> 
                            
<?php
mysql_close($db_link);
?>