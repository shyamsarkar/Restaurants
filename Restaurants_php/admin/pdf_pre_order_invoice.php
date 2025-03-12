<?php
include("../adminsession.php");
require("../fpdf181/fpdf.php");
require("../pdf_js.php");

if(isset($_GET['pre_orderid']))
{
	$pre_orderid = addslashes($_GET['pre_orderid']);
  	//$height = $obj->getvalfield("bill_details","count(*)","billid='$billid'");
	$pageheight = 10 * 150;
}

class PDF_AutoPrint extends PDF_JavaScript
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$title3,$title4,$address2;
		 // courier 25
		$this->SetFont('courier','b',11);
		// Move to the right
		//$this->Cell(10);
		$this->SetY(7);
		$this->SetX(2);
		// Title
		$this->Cell(60,0,strtoupper($title1),0,0,'C');
		
		$this->Ln(5);
		$this->SetX(2);
		$this->SetFont('courier','b',8);
		//$this->Cell(60,0,$title2,0,0,'C');
		$this->MultiCell(60,0,$title2."",0,'C');
		
		
		$this->Ln(3);
		$this->SetX(2);
		$this->SetFont('courier','b',8);
		//$this->Cell(60,0,$title2,0,0,'C');
		$this->MultiCell(60,0,$address2."",0,'C');
		
	    $this->Ln(3);
	    if($title3!="")
		{
	    $this->SetX(2);
		$this->SetFont('courier','b',8);
		$this->Cell(60,0,strtoupper("GSTIN: ".$title3),0,0,'C');
		}
		$this->Ln(3);
	    
		
		
	    $this->SetX(2);
		$this->SetFont('courier','b',8);
		$this->Cell(60,0,$title4,0,0,'C');
		$this->Ln(5);


		 $this->SetX(2);
		$this->SetFont('courier','b',8);
		$this->Cell(60,0,"Pre Order",0,0,'C');
		$this->Ln(1);
		
		// $this->Cell(-1);
		// $this->SetFont('courier','b',8);
		// //$this->Cell(95,5,"".$collect_from,0,0,'L');
		// $this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
		 //$this->Ln(1);
		 
	}
	  // Page footer
	function Footer()
	{
	// Position at 1.5 cm from bottom
		$this->SetY(-1);
		// Arial italic 8
		$this->SetFont('Arial','I',8); 
		// Page number
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	
	function SetBorder($b)
	{
		//Set the array of column widths
		$this->border=$b;
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

 function AutoPrint($printer='')
    {
        // Open the print dialog
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
	 }

function SetDash($black=null, $white=null)
    {
        if($black!==null)
            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
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
// for dash nLine 


	
$pdf = new PDF_AutoPrint('P', 'mm',array(65 ,$pageheight));
//$pdf=new PDF_MC_Table('P', 'mm',array(65 ,$pageheight));
//$title1 = 
$pdf->SetTitle('title1');
$title1 = $obj->getvalfield("company_setting","comp_name","1 = 1");
$title2 = ucwords($obj->getvalfield("company_setting","address","1 = 1"));
$title3 = ucwords($obj->getvalfield("company_setting","gstno","1 = 1"));
$mobile = $obj->getvalfield("company_setting","mobile","1 = 1");
$mobile1 = $obj->getvalfield("company_setting","mobile2","1 = 1");
$address2 = ucwords($obj->getvalfield("company_setting","address2","1 = 1"));
//$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));
$title4 = "Mobile No: $mobile ,$mobile1";
$pdf->SetTitle($title1);

$resbills = $obj->executequery("select * from pre_order_entry where pre_orderid='$pre_orderid'");
// $resbills = mysql_query("select * from bills where billid='$billid'");
foreach ($resbills as $rowbills) 
{
	

// $rowbills = mysql_fetch_array($resbills);

$billnumber = $rowbills['order_no'];
$billdate = $rowbills['order_date'];
$delivery_date = $rowbills['delivery_date'];
$delivery_time = $rowbills['delivery_time'];
$billtime = $rowbills['order_time'];
$cust_name = $rowbills['cust_name'];
$mobile_no = $rowbills['mobile_no'];
$address = $rowbills['address'];
$order_description = $rowbills['order_description'];
$advance_amt = $rowbills['advance_amt'];
$net_amount = $rowbills['net_amount'];

	
}//loop close
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak('off','0');
// $pdf->SetFont('Arial','',8);
// $pdf->SetY(22);
// $pdf->SetX(2);

$pdf->SetY(30);
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(12,6,"Order No :",'0',0,'R',0); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,6,"$billnumber",'0',0,'L',0);

$pdf->SetFont('Arial','',8);	
$pdf->SetY(35);
$pdf->SetX(5);
$pdf->Cell(53,6,"Order Date and Time :".$obj->dateformatindia($billdate).' '.$billtime,'0',0,'R',0);
$pdf->SetY(40);
$pdf->SetFont('Arial','',8);
$pdf->SetX(8);
$pdf->Cell(53,6,"Delivery Date and Time :".$obj->dateformatindia($delivery_date).' '.$delivery_time,'0',0,'R',0); 


$pdf->SetY(45);
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(21,6,"Customer Name :",'0',0,'R',0); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,6,$cust_name,'0',0,'L',0);


$pdf->SetY(50);
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(14,6,"Mobile No. :",'0',0,'R',0); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,6,$mobile_no,'0',0,'L',0);

 
$pdf->SetY(55);
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(11,6,"Advance :",'0',0,'R',0); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,6,$advance_amt,'0',0,'L',0);


$pdf->SetY(59);
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(11,6,"Address :",'0',0,'R',0); 
$pdf->SetFont('Arial','',9);
$pdf->SetY(61);
$pdf->SetX(15);
$pdf->MultiCell(52,3,$address,0,'L',0);
//$pdf->Cell(15,6,$address,'0',0,'L',0);

$pdf->SetY(68);
$pdf->SetX(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(22,6,"Order Description :",'0',0,'R',0); 
$pdf->SetFont('Arial','',9);
$pdf->SetY(70);
$pdf->SetX(27);
$pdf->MultiCell(40,3,$order_description,0,'L',0);
//$pdf->Cell(15,6,$order_description,'0',0,'L',0);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,28,62,28);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,85,62,85);
$pdf->Ln(3);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,93,62,93);

//$pdf->SetDash(1,1); //5mm on, 5mm off
//$pdf->Line(3,96,62,96);

$pdf->Ln(1);
$pdf->SetFont('Arial','',8);
$pdf->SetX(2);
$pdf->SetDrawColor('255','255','255');
//$pdf->Cell(9,5,' Sno','0',0,'C',0);  
$pdf->Cell(25,5,'Particular',0,0,'L',0);
$pdf->Cell(7,5,'Qty.',0,0,'C',0);
$pdf->Cell(12,5,'Rate',0,0,'R',0);
$pdf->Cell(15,5,'Total',0,1,'R',0);
$pdf->SetWidths(array(25,7,12,15));
$pdf->SetAligns(array('L','C','R','R'));

$pdf->Ln(2);
//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 
$total=0;
$slno=1;
$disc_rs=0;
$net_bill=0;
$cgst_amt=0;
$sgst_amt=0;
$sql_get = $obj->executequery("select * from preentry_detail where pre_orderid=$pre_orderid");
foreach ($sql_get as $row_get) 
{

	
	$amount=0;
	$productid=$row_get['productid'];
	$qty=$row_get['qty'];
	$disc = $row_get['disc'];
	$unit_name=$row_get['unit_name'];
	$rate=$row_get['rate_amt'];
	$cgst_amt += $row_get['cgst_amt'];
	$sgst_amt += $row_get['sgst_amt'];
	$cgst = $row_get['cgst'];
	$sgst = $row_get['sgst'];
	$prodname=$obj->getvalfield("m_product","prodname","productid='$productid'");
	
	$amount = $qty * $rate;

  $disc_rs += $amount * $disc / 100;

	$pdf->SetFont('Arial','',7);
	//$pdf->SetDash(0,0); //5mm on, 5mm off
	$pdf->SetX(2);
	//$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  
	$pdf->Row(array( $prodname,$row_get['qty'],number_format($row_get['rate_amt'],2),$amount),1,1,'L',0); 
	$total += $amount;
	 $net_bill += $row_get['final_price'];
}

$pdf->Ln(10);
$pdf->SetX(2);
$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);
$pdf->Ln(3);

$pdf->SetFont('Arial','',8);
$pdf->SetX(5);
$pdf->Cell(46,5,"Sub Total:"."   ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($net_amount,2),'1',0,'R',0);

$pdf->Ln(3);
$pdf->SetX(2);
$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);
$pdf->Ln(6);

$pdf->Output();
?>                          	
<?php
mysqli_close($db_link);
?>