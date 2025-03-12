<?php
include("../adminsession.php");
require("../fpdf185/fpdf.php");

$fromdate = $_GET['fromdate'];
$todate = $_GET['todate'];
$crit = " where 1 = 1 ";
if ($fromdate != "" && $todate != "") {
	$fromdate1 = $fromdate;
	$todate1   = $todate;
	$crit .= " and bills.billdate between '$fromdate1' and '$todate1'";
}


class PDF_MC_Table extends FPDF
{
	var $widths;
	var $aligns;

	function Header()
	{
		global $title1, $title2, $title3, $title4;
		// courier 25

		$this->Rect('5', '5', '200', '289');
		$this->SetFont('courier', 'b', 20);
		// Move to the right
		$this->Cell(95);
		// Title
		$this->Cell(10, 0, $title1, 0, 0, 'C');
		// Line break
		$this->Ln(6);
		// Move to the right
		$this->Cell(90);
		// courier bold 15
		$this->SetFont('courier', 'b', 11);
		$this->Cell(20, 0, $title2, 0, 0, 'C');
		// Move to the right
		$this->Ln(6);
		// Move to the right
		$this->Cell(15);
		$this->SetX(7);
		// courier bold 15
		$this->SetFont('courier', 'b', 11);
		$this->Cell(20, 0, $title3, 0, 0, 'L');

		//$this->Ln(6);
		// Move to the right
		$this->Cell(150);
		// courier bold 15
		$this->SetFont('courier', 'b', 11);
		$this->Cell(20, 0, $title4, 0, 0, 'R');


		// Line break
		$this->Ln(15);

		$this->Cell(82);
		// courier bold 15



		$this->SetY(26);
		$this->SetX(5);
		$this->SetFont('courier', 'b', 10);
		$this->Cell(200, 0, '', 0, 0, 'C');
		$this->Ln(2);


		$this->SetX(5);
		$this->SetFont('Arial', 'B', 9);
		$this->Cell(10, 5, 'Sno', 'LTR', 0, 'L', 0);
		$this->Cell(140, 5, 'Menu Heading Name', 1, 0, 'L', 0);
		$this->Cell(50, 5, 'Amount', 1, 1, 'R', 0);


		$this->SetX(5);
		$this->SetAligns(array('L', 'L', 'R'));
		$this->SetWidths(array(10, 140, 50));
		$this->SetFont('Arial', '', 6);
		$this->SetX(5);
	}
	// Page footer
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++)
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h = 5 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h);
			//Print the text
			$this->MultiCell($w, 5, $data[$i], 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	function NbLines($w, $txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}
}

function GenerateWord()
{
	//Get a random word
	$nb = rand(3, 10);
	$w = '';
	for ($i = 1; $i <= $nb; $i++)
		$w .= chr(rand(ord('a'), ord('z')));
	return $w;
}

function GenerateSentence()
{
	//Get a random sentence
	$nb = rand(1, 10);
	$s = '';
	for ($i = 1; $i <= $nb; $i++)
		$s .= GenerateWord() . ' ';
	return substr($s, 0, -1);
}
$pdf = new PDF_MC_Table();
$title1 = $obj->getvalfield("company_setting", "comp_name", "1 = 1");
$pdf->SetTitle($title1);
$title2 = "Total Category Wise Sale Report";
$pdf->SetTitle($title2);
$title3 = "From Date:" . $obj->dateformatindia($fromdate);
$pdf->SetTitle($title3);
$title4 = "To Date: " . $obj->dateformatindia($todate);
$pdf->SetTitle($title4);
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
$slno = 1;
$res = $obj->executequery("Select * from m_product_category");
foreach ($res as $row_get) {
	$pcatid = $row_get['pcatid'];
	$amount = $obj->getvalfield("view_bill_details left join bills on view_bill_details.billid = bills.billid", "sum(cash_amt+paytm_amt+google_pay+swiggy+paytm_amt+card_amt+credit_amt)", "billdate between '$fromdate' and '$todate' and bills.checked_nc=0 and pcatid='$pcatid'");
	/*$billdate = $row_get['billdate'];
	$settlement_amt += $row_get['settlement_amt'];
	$cash_amt += $row_get['cash_amt'];
	$paytm_amt += $row_get['paytm_amt'];
	$google_pay += $row_get['google_pay'];
	$swiggy += $row_get['swiggy'];
	$paytm_amt += $row_get['paytm_amt'];
	$card_amt += $row_get['card_amt'];
	$credit_amt += $row_get['credit_amt'];
	$total_sale = $settlement_amt + $cash_amt + $paytm_amt + $google_pay + $swiggy + $paytm_amt + $card_amt;
	$online_pay = $paytm_amt + $google_pay + $swiggy + $paytm_amt;
	$expense = $obj->getvalfield("expanse","sum(exp_amount)","exp_date='$billdate' group by exp_date");*/

	$pdf->SetX(5);
	$pdf->SetFont('Arial', '', 8);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Row(array($slno++, $row_get['catname'], number_format($amount, 2)));
	/* $tot_total_sale += $total_sale;
        $tot_cash_amt += $cash_amt;
        $tot_online_pay += $online_pay;
        $tot_settlement_amt += $settlement_amt;
        $tot_credit_amt += $credit_amt;
        $tot_expense += $expense;*/
}


/*$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(170,5,'Total Sale Amount: ',1,0,'R',0);
$pdf->Cell(30,5,number_format(round($tot_total_sale),2),1,1,'R',0);


$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(170,5,'Total Cash Amt: ',1,0,'R',0);
$pdf->Cell(30,5,number_format(round($tot_cash_amt),2),1,1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(170,5,'Total Online Amount: ',1,0,'R',0);
$pdf->Cell(30,5,number_format(round($tot_online_pay),2),1,1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(170,5,'Total Settelment Amt: ',1,0,'R',0);
$pdf->Cell(30,5,number_format(round($tot_settlement_amt),2),1,1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(170,5,'Total Credit Amount: ',1,0,'R',0);
$pdf->Cell(30,5,number_format(round($tot_credit_amt),2),1,1,'R',0);

$pdf->SetX(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(170,5,'Total Expence Amount: ',1,0,'R',0);
$pdf->Cell(30,5,number_format(round($tot_expense),2),1,1,'R',0);

*/
$pdf->Output();
