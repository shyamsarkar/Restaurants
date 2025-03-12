<?php
include("../adminsession.php");
require("fpdf17/fpdf.php");

$comp_name = $obj->getvalfield("company_setting","comp_name","1 = 1");
$slno=1;

if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $_GET['from_date'];
    $to_date  =  $_GET['to_date'];
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
}

$crit = " where 1 = 1 and kotdate between '$from_date' and '$to_date'"; 

$fromdate = $obj->dateformatindia($from_date);
$todate = $obj->dateformatindia($to_date);
class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$comp_name,$todate,$fromdate;
        
        $this->Rect(5,5,200,287);
        $this->SetFont('courier','b',15);
        $this->Line(5,20,205,20);
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
        
        // $this->Cell(-1);

        $this->SetFont('courier','b',8);
        //$this->Cell(95,5,"".$collect_from,0,0,'L');
        $this->SetX(5);
        $this->Cell(192,5,"From Date : ".$fromdate,0,1,'L');
        $this->SetX(5);
        $this->SetY(22);
        $this->Cell(192,5,"To Date : ".$todate,0,1,'R');
         $this->Ln(1);
         
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
$title2 = "KOT Report";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,6,'Sno','1',0,'L',0);
$pdf->Cell(20,6,'KOT No.',1,0,'L',0);
$pdf->Cell(40,6,'KOT Date / Time',1,0,'L',0);
$pdf->Cell(30,6,'Count_Product',1,0,'L',0);
$pdf->Cell(30,6,'Table No.',1,0,'L',0);
$pdf->Cell(30,6,'Floor No.',1,0,'L',0);
$pdf->Cell(40,6,'Bill No.',1,1,'L',0); 
$pdf->SetX(5);
$pdf->SetWidths(array(10,20,40,30,30,30,40));
$pdf->SetAligns(array('L','L','L','L','L','L','L'));
$pdf->SetFont('Arial','',6);
$tot_kot_no = 0;                                        
$res = $obj->executequery("select * from kot_entry $crit");
foreach($res as $row_get)
{
  $table_id = $row_get['table_id'];
  $kotid = $row_get['kotid'];
  $kotdate = $obj->dateformatindia($row_get['kotdate']);
  $kottime = $row_get['kottime'];
  $billid = $row_get['billid'];
  $table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");
  $billnumber = $obj->getvalfield("bills","billnumber","billid='$billid'");
  $floor_id = $obj->getvalfield("m_table","floor_id","table_id='$table_id'");
  $floor_name = $obj->getvalfield("m_floor","floor_name","floor_id='$floor_id'");
  $count_product = $obj->getvalfield("bill_details","count(productid)","kotid='$kotid' and table_id='$table_id' and billid='$billid'");

    $pdf->SetX(5);  
    $pdf->SetFont('Arial','',8);
    $pdf->SetTextColor(0,0,0);
    $pdf->Row(array($slno++,$kotid,$kotdate." / ".$kottime,$count_product,$table_no,$floor_name,$billnumber));
    $tot_kot_no = $slno - 1;
}
$pdf->SetX(5);
 $pdf->SetFont('Arial','B',8);
 $pdf->SetTextColor(0,0,0);
$pdf->Cell(160,7,' Total KOT No.  :-',1,'L',1);  
$pdf->Cell(40,7,$tot_kot_no,1,'R',0);
$pdf->Output();
?> 
                            
<?php
mysqli_close($db_link);
?>