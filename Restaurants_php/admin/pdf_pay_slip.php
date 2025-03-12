<?php include("../adminsession.php");
include("fpdf17/fpdf.php");
//$tblname="fee_payment";
//$tblpkey = "fee_payid";
//$module = "Masters";
//$keyvalue="";
$company_name = $obj->getvalfield("company_setting","comp_name","1=1");
$mobile = $obj->getvalfield("company_setting","mobile","1=1");
$mobile2 = $obj->getvalfield("company_setting","mobile2","1=1");
$email = $obj->getvalfield("company_setting","email1","1=1");
//$city = $obj->getvalfield("company_setting","city","company_id = '$company_id'");
$address = $obj->getvalfield("company_setting","address","1=1");

// if(isset($_GET['fee_payid']))
// {
// 	 $fee_payid = addslashes(trim($_GET['fee_payid']));
// }
if(isset($_GET['supplier_payid']))
{
	$supplier_payid = addslashes(trim($_GET['supplier_payid']));
	
    //echo "select * from fee_payment where fee_payid = '$fee_payid'";die;
    $res = $obj->executequery("select * from supplier_payment where supplier_payid = '$supplier_payid'");
    foreach($res as $rowedit)
    {
    
   // $transferid  = $rowedit['transferid'];
    $supplier_payid  = $rowedit['supplier_payid']; 
    $voucher_no = $rowedit['voucher_no'];
    $pay_date  = $obj->dateformatindia($rowedit['pay_date']);
    $paid_amt  = $rowedit['paid_amt'];
    $supplier_id = $rowedit['supplier_id'];
    $supplier_name = $obj->getvalfield("master_supplier","supplier_name","supplier_id='$supplier_id'");
   $payment_type  = $rowedit['payment_type']; 
   $yrdata= strtotime($pay_date);
   $yrdata =  date('M-Y', $yrdata);
}
}

function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}


class PDF_MC_Table extends FPDF
{
  var $widths;
  var $aligns;
	function Header()
	{ 
	   global $title1,$title2,$company_name,$mobile,$email,$address,$supplier_name,$voucher_no,$payment_type,$mobile2;
	
		$this->SetFont('courier','b',15);
		$this->Cell(30);
		$this->Cell(90,0,$title1,0,1,'L');
		$this->Ln(6);
		$this->SetFont('courier','b',15);
		$this->Cell(80);
		$this->Cell(90,0,$title2,0,1,'C');
		$this->Ln(3);
		$this->Cell(-1);
		$this->SetFont('courier','b',11);
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		//$this->Cell(280,5,"Date : ".date('d-m-Y'),0,1,'R');
		$this->Ln(1);
		//$this->Ln(10);
		
		    $this->SetFont('courier','b',9);
	       // $this->Rect(5, 5, 200, 80, 'D'); //For A4
		
		
	}
	function Footer()
	{ 
	    $this->SetY(-15);
		$this->SetFont('Arial','I',9);
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
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
$pdf->SetTitle("Payment Receipt");
$pdf->AliasNbPages();
$pdf->AddPage('P','A5');
//$pdf->MultiCell(80,5,"Customer Copy",0,'L');

$pdf->SetY(10);
 $pdf->SetX(20);
//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])

//Line(float x1, float y1, float x2, float y2)

// $pdf->SetFont('courier','b',9);
 //$pdf->Line(30,52, 130, 52 ); //For A4
 
 // $pdf->SetFont('courier','b',9);
  //$pdf->Line(20,61, 185, 61 ); //For A4
 


 $pdf->SetFont('courier','b',9);
 $pdf->Rect(4,10, 140, 80, 'D'); //For A4
 
$pdf->SetFont('courier','b',9);
$pdf->Rect(4,10, 140, 16, 'D'); //For A4
 
  //$pdf->SetFont('courier','b',9);
  //$pdf->Rect(10,71, 95, 25, 'D'); //For A4
 
 //$pdf->SetFont('courier','b',9);
 //$pdf->Rect(105,71, 95, 25, 'D'); //For A4
 
  //$pdf->SetY(25);
//$pdf->SetX(8);
//$pdf->Image('Chrysanthemum.jpg',10,10,20,15);//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
 //$pdf->SetFont('courier','b',9);
// $pdf->Rect(10,10, 20, 15, 'D'); //For A4
 
$pdf->SetY(13);
//$pdf->SetX(13);
 //$comp_name = $obj->getvalfield("school_setting","school_name","1 = 1");
  //$address = $obj->getvalfield("school_setting","school_address","1 = 1");
   // $school_cont = $obj->getvalfield("school_setting","school_cont","1 = 1");
$pdf->SetFont('Arial','b',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(120,4,$company_name,'0',1,'C',0);
$pdf->Ln(2);

$pdf->SetFont('Arial','b',7);
$pdf->Cell(80,1,"Mobile No:".$mobile.",".$mobile2,'0',1,'C',0);

$pdf->SetFont('Arial','b',7);
$pdf->Cell(135,-1,"Email Id:".$email.",",'0',1,'C',0);

 //$pdf->SetFont('Arial','b',7);
 //$pdf->Cell(138,1,"Email Id:".$email,'0',1,'C',0);
 $pdf->Ln(2);
  $pdf->SetFont('Arial','b',7);
  $pdf->Cell(120,4,"Address:".ucwords($address),'0',1,'C',0);
$pdf->Ln(4);

$pdf->SetFont('Arial','b',13);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(130,5,'Voucher Receipt','0',1,'C',0);
$pdf->Ln(3);
$pdf->SetFont('Arial','b',9);
 $pdf->SetTextColor(0,0,0);
 $pdf->SetY(35);
 $pdf->Cell(30,4,'Voucher No. : '.$voucher_no,'0',0,'L',0);
// //$pdf->Ln(2);
$pdf->SetX(90);
$pdf->SetFont('Arial','b',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,4,'Payment Date : '.$pay_date,'0',1,'L',0);

//$pdf->SetFont('Arial','b',9);
//$pdf->SetTextColor(0,0,0);
//$pdf->SetX(150);
//$pdf->Cell(30,4,'Class : '.$class_name,'0',1,'L',0);
$pdf->Ln(3);
		$pdf->SetY(44);
		$pdf->SetX(10);
		$pdf->SetFont('Arial','b',8);
		$pdf->Cell(100,5,"$payment_type"." with thanks from ".$supplier_name,0,1,'L');
		
		$pdf->Ln(4);
		$pdf->SetX(10);
		$pdf->SetFont('Arial','b',8);
		$pdf->MultiCell(150,0,"Rs.".$paid_amt." In Word ".strtoupper(convert_number_to_words(round($paid_amt))),0,'L');
		
		// $pdf->Ln(6);
		// $pdf->SetX(10);
		// $pdf->SetFont('Arial','b',8);
		// $pdf->MultiCell(150,0,"Account of Monthly Fee for the Month of ".$yrdata." Registration / Course Fee.",0,'L');

$pdf->SetY(84);
$pdf->SetX(4);

$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(90,5,'Sign of Supplier',0,0,'L',0);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(40,5,'For :-'.$company_name,0,0,'R',0);
$pdf->Ln(3);



// $pdf->SetY(300);
//  $pdf->SetX(300);
//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])

//Line(float x1, float y1, float x2, float y2)

// $pdf->SetFont('courier','b',9);
 //$pdf->Line(30,52, 130, 52 ); //For A4
 
 // $pdf->SetFont('courier','b',9);
  //$pdf->Line(20,61, 185, 61 ); //For A4
 


 $pdf->SetFont('courier','b',9);
 $pdf->Rect(4,110, 140, 80, 'D'); //For A4
 
$pdf->SetFont('courier','b',9);
$pdf->Rect(4,110, 140, 18, 'D'); //For A4
 
 
 
$pdf->SetY(115);
$pdf->SetX(13);
// $comp_name = $obj->getvalfield("school_setting","school_name","1 = 1");
 //  $address = $obj->getvalfield("school_setting","school_address","1 = 1");
 //  $school_cont = $obj->getvalfield("school_setting","school_cont","1 = 1");
$pdf->SetFont('Arial','b',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(120,4,$company_name,'0',1,'C',0);
$pdf->Ln(2);
$pdf->SetFont('Arial','b',7);
$pdf->Cell(80,1,"Mobile No:".$mobile.",".$mobile2,'0',1,'C',0);

 $pdf->SetFont('Arial','b',7);
 $pdf->Cell(135,-1,"Email Id:".$email.",",'0',1,'C',0);

 //$pdf->SetFont('Arial','b',7);
 //$pdf->Cell(111,1,"Email Id:".$email,'0',1,'R',0);
 $pdf->Ln(3);
  $pdf->SetFont('Arial','b',7);
  $pdf->Cell(120,1,"Address:".ucwords($address),'0',1,'C',0);
$pdf->Ln(4);

$pdf->SetFont('Arial','b',13);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(130,12,'Voucher Receipt','0',1,'C',0);
$pdf->Ln(3);
$pdf->SetFont('Arial','b',9);
$pdf->SetTextColor(0,0,0);
$pdf->SetY(138);
$pdf->Cell(30,4,'Receipt No : '.$voucher_no,'0',0,'L',0);
//$pdf->Ln(2);
$pdf->SetX(90);
$pdf->SetFont('Arial','b',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,4,'Payment Date : '.$pay_date,'0',1,'L',0);

//$pdf->SetFont('Arial','b',9);
//$pdf->SetTextColor(0,0,0);
//$pdf->SetX(150);
//$pdf->Cell(30,4,'Class : '.$class_name,'0',1,'L',0);
$pdf->Ln(3);
	$pdf->SetY(145);
		$pdf->SetX(10);
		$pdf->SetFont('Arial','b',8);
        //Received
		$pdf->Cell(100,5,"$payment_type"." with thanks from ".$supplier_name,0,1,'L');
		
		$pdf->Ln(3);
		$pdf->SetX(10);
		$pdf->SetFont('Arial','b',8);
		$pdf->MultiCell(150,0,"Rs.".$paid_amt." In Word ".strtoupper(convert_number_to_words(round($paid_amt))),0,'L');
		
		// $pdf->Ln(6);
		// $pdf->SetX(10);
		// $pdf->SetFont('Arial','b',8);
		// $pdf->MultiCell(150,0,"Account of Monthly Fee for the Month of ".$yrdata." Registration / Course Fee.",0,'L');

$pdf->SetY(184);
$pdf->SetX(4);

$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(90,5,'Sign of Supplier',0,0,'L',0);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(40,5,'For :- '.$company_name,0,0,'R',0);

$pdf->SetY(5);
$pdf->SetX(114);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,5,'For Restaurant',0,0,'R',0);

$pdf->SetY(105);
$pdf->SetX(114);
$pdf->SetFont('Arial','b',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,5,'For Supplier',0,0,'R',0);



  $pdf->Output();	
?>
