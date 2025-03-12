<?php
include("../adminsession.php");
require("fpdf17/fpdf.php");
$comp_name =  $obj->getvalfield("company_setting","comp_name","1 = 1");

$crit = " where 1 = 1 ";


if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $_GET['from_date'];
    $to_date  = $_GET['to_date'];
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
}

$crit .= " and billdate between '$from_date' and '$to_date'";


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;

    function Header()
    {
        global $title1,$title2,$comp_name,$to_date,$from_date;
        
        $this->Rect(5,5,287,287);
        $this->SetFont('courier','b',15);
        $this->Line(5,20,292,20);
         // courier 25
        $this->SetFont('courier','b',20);
        // Move to the right
        $this->Cell(135);
        // Title
        $this->Cell(10,0,$title1,0,0,'C');
        // Line break
        $this->Ln(6);
        // Move to the right
        $this->Cell(128);
         // courier bold 15
        $this->SetFont('courier','b',11);
        $this->Cell(20,0,$title2,0,0,'C');
          // Move to the right
       // $this->Cell(80);
        // Line break
        $this->Ln(5);
    
        $this->SetFont('courier','b',8);
        //$this->Cell(95,5,"".$collect_from,0,0,'L');
        $this->Cell(-1);
        $this->Cell(270,5,"From Date : ".$from_date,0,1,'R');

        $this->Cell(269,5,"To Date : ".$to_date,0,1,'R');
        $this->Ln(1);

        $this->SetX(5);
        $this->SetFont('Arial','B',9);
        $this->Cell(10,6,'Sno','1',0,'L',0);
        $this->Cell(30,6,'Bill_NO./Amount',1,0,'L',0);
        $this->Cell(25,6,'Bill_Date/Time',1,0,'L',0);
        $this->Cell(25,6,'name/Mobile',1,0,'L',0);
        $this->Cell(30,6,'Cancel./PayDate',1,0,'L',0);
      //  $this->Cell(20,6,'Bill_NO.',1,0,'L',0);
        $this->Cell(20,6,'Table_NO.',1,0,'L',0);
      //  $this->Cell(20,6,'Bill_Date',1,0,'L',0);
      //  $this->Cell(20,6,'Bill_Time',1,0,'L',0);
      //  $this->Cell(18,6,'Cancelled',1,0,'L',0);
       // $this->Cell(18,6,'Bill_Amt',1,0,'R',0);
       // $this->Cell(21,6,'Customer',1,0,'L',0);
     //   $this->Cell(20,6,'Mobile',1,0,'L',0);
     //   $this->Cell(20,6,'PayDate',1,0,'L',0);
        $this->Cell(15,6,'Cash',1,0,'R',0);
        $this->Cell(15,6,'Card',1,0,'R',0);
        $this->Cell(15,6,'Patym',1,0,'R',0);
        $this->Cell(20,6,'Google_Pay',1,0,'R',0);
        $this->Cell(15,6,'Zomato',1,0,'R',0);
        $this->Cell(15,6,'Swiggy',1,0,'R',0);
        $this->Cell(15,6,'C_parcel',1,0,'R',0);
        $this->Cell(18,6,'Settlement',1,0,'R',0);
        $this->Cell(17,6,'Credit',1,1,'R',0);
      


        $this->SetWidths(array(10,30,25,25,30,20,15,15,15,20,15,15,15,18,17));
        $this->SetAligns(array('L','L','L','L','L','L','R','R','R','R',"R","R","R","R","R"));
        $this->SetX(5);
        $this->SetFont('Arial','',6); 
         
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
$title2 = "
Payment Report Details";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');

$slno=1;
$crit = " where 1 = 1 ";
// date access
if(isset($_GET['from_date']) && isset($_GET['to_date']))
{ 
    $from_date = $obj->dateformatindia($_GET['from_date']);
    $to_date  =  $obj->dateformatindia($_GET['to_date']);
}
else
{
  $to_date =date('Y-m-d');
  $from_date =date('Y-m-d');
}
$crit .= " and billdate between '$from_date' and '$to_date'";

$slno=1;
$subtotal=0;
$tot_rec_amt = 0;
$total_cancelled_amt = 0;
$tot_cash_amt = 0;
$tot_zom_amt = 0;
$tot_card_amt = 0;
$tot_pay_amt = 0;
$tot_swi_amt = 0;
$tot_swiggy = 0;
$tot_counter_parcel=0;
$subtotal=0;
$tot_rec_amt = 0;
$total_cancelled_amt = 0;
 $tot_cash_amt = 0;
 $tot_zom_amt = 0;
 $tot_card_amt = 0;
 $tot_pay_amt = 0;
 $tot_swi_amt = 0;
 $tot_settlement_amt = 0;
 $net_balance = 0;
 $tot_google_amt = 0;
 $tot_credit_amt = 0;
$sql = "Select * from bills $crit and checked_nc=0 order by billid desc";
$res = $obj->executequery($sql);
foreach($res as $row_get)
{
 $cust_name = $row_get['cust_name'];
 $table_id = $row_get['table_id'];
 $table_no = $obj->getvalfield("m_table","table_no","table_id='$table_id'");
 $customer_name = $obj->getvalfield("m_customer","customer_name","customer_id='$cust_name'");
 $mobile = $obj->getvalfield("m_customer","mobile","customer_id='$cust_name'");
 $table_no = $obj->getvalfield("m_table","table_no","table_id='$row_get[table_id]'");
 $is_cancelled = $row_get['is_cancelled'];
 if($is_cancelled==1)
$status_cancelled = 'Cancelled';
else
$status_cancelled = '';

    $subtotal += $row_get['net_bill_amt'];
    $tot_rec_amt += $row_get['rec_amt'];
    
    if($row_get['is_cancelled'])
    $total_cancelled_amt += $row_get['net_bill_amt'];
    $tot_cash_amt += $row_get['cash_amt'];
    $tot_zom_amt += $row_get['zomato'];
    $tot_swiggy += $row_get['swiggy'];
    $tot_counter_parcel += $row_get['counter_parcel'];
    $tot_credit_amt += $row_get['credit_amt'];
    $tot_google_amt += $row_get['google_pay'];
    $tot_card_amt += $row_get['card_amt'];
    $tot_pay_amt += $row_get['paytm_amt'];
   // $tot_swi_amt += $row_get['swiggy'];
    $tot_settlement_amt += $row_get['settlement_amt'];
   $net_balance = $subtotal - $total_cancelled_amt - $tot_cash_amt - $tot_credit_amt - $tot_card_amt - $tot_pay_amt - $tot_google_amt - $tot_settlement_amt;
$pdf->SetX(5);  
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);
// $pdf->Row(array($slno++ ,$row_get['billnumber'],$table_no,$obj->dateformatindia($row_get['billdate']),$row_get['billtime'],$status_cancelled,number_format(round($row_get['net_bill_amt']),2),strtoupper($customer_name),$mobile,$obj->dateformatindia($row_get['paydate']),$row_get['cash_amt'],$row_get['card_amt'],$row_get['paytm_amt'],$row_get['google_pay'],$row_get['settlement_amt'],$row_get['credit_amt']));

$pdf->Row(array($slno++,$row_get['billnumber']."\n".$row_get['net_bill_amt'],$obj->dateformatindia($row_get['billdate'])."\n".$row_get['billtime'],strtoupper($customer_name)."\n".$mobile,$status_cancelled."\n".$obj->dateformatindia($row_get['paydate']),$table_no,$row_get['cash_amt'],$row_get['card_amt'],$row_get['paytm_amt'],$row_get['google_pay'],$row_get['zomato'],$row_get['swiggy'],$row_get['counter_parcel'],$row_get['settlement_amt'],$row_get['credit_amt']));


    

}
    
    

$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,' Total  :-',1,'R',0);  
$pdf->Cell(35,7,number_format(round($subtotal),2),1,'R',0);
$pdf->Ln(7);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,' Cancelled Amount  :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($total_cancelled_amt),2),1,'R',0);

// $pdf->Ln(7);
// $pdf->SetX(5);
// $pdf->SetFont('Arial','B',9);
// $pdf->SetTextColor(0,0,0);
// $pdf->Cell(251,7,' Total Rec Amt  :-',1,'L',0);  
// $pdf->Cell(36,7,number_format(round($tot_rec_amt),2),1,'R',0);



$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Cash :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_cash_amt),2),1,'R',0);



$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Card :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_card_amt),2),1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Paytm :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_pay_amt),2),1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Google Pay :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_google_amt),2),1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Zomato :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_zom_amt),2),1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Swiggy :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_swiggy),2),1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Counter Parcel :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_counter_parcel),2),1,'R',0);


$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Settlement :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_settlement_amt),2),1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,'Total Credit :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($tot_credit_amt),2),1,'R',0);


$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(252,7,' Balance Amount  :-',1,'L',0);  
$pdf->Cell(35,7,number_format(round($net_balance),2),1,'R',0);

$pdf->Output();
?> 
                            
<?php
mysql_close($db_link);
?>