<?php
include("../adminsession.php");
require("../fpdf185/fpdf.php");
$title1 = $obj->get("company_setting", "comp_name", "1 = 1");
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date  =  $_GET['to_date'];
} else {
    $to_date = date('Y-m-d');
    $from_date = date('Y-m-d');
}
$crit = " where 1 = 1 and inout_date between '$from_date' and '$to_date'";
$fromdate = $obj->dateformatindia($from_date);
$todate = $obj->dateformatindia($to_date);
$exp_inc = $obj->opening_bal_exp_income($from_date);
class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;
    function Header()
    {
        global $title1, $title2, $stu_name, $transferid, $exp_inc, $fromdate, $todate;
        // courier 25
        $this->Rect('5', '5', '287', '289');
        $this->SetFont('courier', 'b', 20);
        // Move to the right
        $this->SetFont('courier', 'b', 25);
        $this->Cell(90);
        $this->Cell(90, 0, $title1, 0, 1, 'C');
        // Line break
        $this->Ln(7);
        $this->SetFont('courier', 'b', 15);
        $this->Cell(90);
        $this->Cell(90, 0, $title2, 0, 1, 'C');
        // Move to the right
        if ($transferid != "") {
            $this->Ln(8);
            $this->SetFont('courier', 'b', 15);
            $this->Cell(90);
            $this->Cell(90, 0, $stu_name, 0, 1, 'C');
        }
        if ($transferid == "") {
            $this->Ln(8);
            $this->SetFont('courier', 'b', 15);
            $this->Cell(90);
            $this->Cell(90, 0, "All Record Selected", 0, 1, 'C');
        }
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(275, 5, "From Date : " . $fromdate, 0, 1, 'R');
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(275, 5, "To Date : " . $todate, 0, 1, 'R');
        if ($this->PageNo() == 1) {
            $this->Ln(1);
            $this->SetFont('courier', 'b', 15);
            $this->Cell(1);
            $this->Cell(90, 0, "Opening Balance : " . $exp_inc, 0, 1, 'L');
        }
        $this->Ln(8);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(15, 8, 'SNo', '1', 0, 'L', 0);
        $this->Cell(42, 8, 'Transaction Name', 1, 0, 'L', 0);
        $this->Cell(60, 8, 'Party Name', 1, 0, 'L', 0);
        $this->Cell(28, 8, 'Voucher No', 1, 0, 'L', 0);
        $this->Cell(22, 8, 'Date', 1, 0, 'L', 0);
        $this->Cell(20, 8, 'Time At', 1, 0, 'L', 0);
        $this->Cell(30, 8, 'Particular', 1, 0, 'L', 0);
        $this->Cell(20, 8, 'Mode', 1, 0, 'L', 0);
        $this->Cell(20, 8, 'Type', 1, 0, 'L', 0);
        $this->Cell(30, 8, 'Amount', 1, 1, 'R', 0);
        $this->SetWidths(array(15, 42, 60, 28, 22, 20, 30, 20, 20, 30));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'L', 'R'));
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
$pdf->SetTitle($title1);
$title2 = "(CASH BOOK REPORT)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4');
$slno = 1;
$totalamt_expence = 0;
$totalamt_income = 0;
$sql = "select * from cash_in_out $crit";
$res = $obj->executequery($sql);
foreach ($res as $row_get) {
    $cash_inout_id = $row_get['cash_inout_id'];
    $amount = $row_get['amount'];
    $voucher_no = $row_get['voucher_no'];
    $time_at = $row_get['time_at'];
    $cash_inout_id = $row_get['cash_inout_id'];
    $ex_group_id = $row_get['ex_group_id'];
    $gup_name = $obj->getvalfield("m_expanse_group", "group_name", "ex_group_id=$ex_group_id");
    $supplier_id = $row_get['supplier_id'];
    $supplier_name = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id=$supplier_id");
    $type = $row_get['type'];
    if ($type == 'cash_in') {
        $particular = "Cash In";
        $color = 'red';
    } else {
        $particular = "Cash Out";
        $color = 'green';
    }
    //$pdf->setCellMargin(5);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno++, $gup_name, $supplier_name, $voucher_no, $obj->dateformatindia($row_get['inout_date']), $time_at, $particular, $mode, $type, number_format($amount, 2)));
    if ($type == 'cash_out') {
        $totalamt_expence += $row_get['amount'];
    } else {
        $totalamt_income += $row_get['amount'];
    }
}
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(195, 8, 'Total Cash Out: ', 1, 0, 'R', 0);
$pdf->Cell(92, 8, number_format(round($totalamt_expence), 2), 1, 0, 'R', 0);
$pdf->Ln(8);
$pdf->SetX(5);
$pdf->Cell(195, 8, 'Total Cash In: ', 1, 0, 'R', 0);
$pdf->Cell(92, 8, number_format(round($totalamt_income), 2), 1, 0, 'R', 0);
$pdf->Ln(8);
$pdf->SetX(5);
$pdf->Cell(195, 8, 'Total Balance: ', 1, 0, 'R', 0);
$pdf->Cell(92, 8, number_format(round($totalamt_income - $totalamt_expence), 2), 1, 0, 'R', 0);
$pdf->Output('Company List', 'I');
