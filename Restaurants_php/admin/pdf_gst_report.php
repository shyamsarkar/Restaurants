<?php
include("../adminsession.php");
require("../fpdf185/fpdf.php");
$comp_name =  $obj->getvalfield("company_setting", "comp_name", "1 = 1");

$crit = " where 1 = 1 ";


if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date  = $_GET['to_date'];
} else {
    $to_date = date('Y-m-d');
    $from_date = date('Y-m-d');
}

$crit .= " and billdate between '$from_date' and '$to_date'";


class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;

    function Header()
    {
        global $title1, $title2, $comp_name, $to_date, $from_date;

        $this->Rect(5, 5, 287, 287);
        $this->SetFont('courier', 'b', 15);
        $this->Line(5, 20, 292, 20);
        // courier 25
        $this->SetFont('courier', 'b', 20);
        // Move to the right
        $this->Cell(135);
        // Title
        $this->Cell(10, 0, $title1, 0, 0, 'C');
        // Line break
        $this->Ln(6);
        // Move to the right
        $this->Cell(128);
        // courier bold 15
        $this->SetFont('courier', 'b', 11);
        $this->Cell(20, 0, $title2, 0, 0, 'C');
        // Move to the right
        // $this->Cell(80);
        // Line break
        $this->Ln(5);

        $this->SetFont('courier', 'b', 8);
        //$this->Cell(95,5,"".$collect_from,0,0,'L');
        $this->Cell(-1);
        $this->Cell(270, 5, "From Date : " . $from_date, 0, 1, 'R');

        $this->Cell(269, 5, "To Date : " . $to_date, 0, 1, 'R');
        $this->Ln(1);

        $this->SetX(5);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10, 6, 'Sno', '1', 0, 'L', 0);
        $this->Cell(20, 6, 'Bill_NO.', 1, 0, 'L', 0);
        //$this->Cell(20,6,'Table_NO.',1,0,'L',0);
        $this->Cell(20, 6, 'Bill_Date', 1, 0, 'L', 0);
        $this->Cell(20, 6, 'Bill_Time', 1, 0, 'L', 0);
        // $this->Cell(18,6,'Cancelled',1,0,'L',0);
        $this->Cell(25, 6, 'Customer', 1, 0, 'R', 0);
        $this->Cell(20, 6, 'Mobile', 1, 0, 'L', 0);
        $this->Cell(25, 6, 'Gross_amt', 1, 0, 'L', 0);
        $this->Cell(25, 6, 'Disc(IN%)', 1, 0, 'L', 0);
        $this->Cell(25, 6, 'Disc(Rs)', 1, 0, 'L', 0);
        $this->Cell(22, 6, 'GST(%)', 1, 0, 'L', 0);
        $this->Cell(25, 6, 'CGST_Amt', 1, 0, 'L', 0);
        $this->Cell(25, 6, 'SGST_Amt', 1, 0, 'L', 0);
        $this->Cell(25, 6, 'Net_Bill_Amt', 1, 1, 'L', 0);



        $this->SetWidths(array(10, 20, 20, 20, 25, 20, 25, 25, 25, 22, 25, 25, 25));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'R', 'L', 'L', 'L', "L", "L", "L", "L", "L"));
        $this->SetX(5);
        $this->SetFont('Arial', '', 6);
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
}

$pdf = new PDF_MC_Table();
$title1 = "$comp_name";
$pdf->SetTitle($title1);
$title2 = "
GST REPORT DETAILS";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4');

$slno = 1;
$crit = " where 1 = 1 ";
// date access
if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $obj->dateformatindia($_GET['from_date']);
    $to_date  =  $obj->dateformatindia($_GET['to_date']);
} else {
    $to_date = date('Y-m-d');
    $from_date = date('Y-m-d');
}
$crit .= " and billdate between '$from_date' and '$to_date'";

$slno = 1;
$subtotal = 0;
$tot_cgst_amt = 0;
$tot_sgst_amt = 0;
$tot_disc_rs = 0;
$tot_disc_percent_amt = 0;
$tot_basic_bill_amt = 0;
$sql = "Select * from bills $crit and checked_nc='0' order by billid desc";
$res = $obj->executequery($sql);
foreach ($res as $row_get) {
    $sgst = $row_get['sgst'];
    $cgst = $row_get['cgst'];
    $disc_percent = $row_get['disc_percent'];
    $disc_rs = $row_get['disc_rs'];
    $basic_bill_amt = $row_get['basic_bill_amt'];
    $disc_percent_amt = $basic_bill_amt * $disc_percent / 100;
    $disc_rs_amt = $basic_bill_amt - $disc_rs;
    $cgst_amt = $basic_bill_amt * $cgst / 100;
    $sgst_amt = $basic_bill_amt * $sgst / 100;
    $gst = $sgst + $cgst;
    $cust_name = $row_get['cust_name'];
    $mobile = $row_get['cust_mobile'];
    //$customer_name = $obj->getvalfield("m_customer","customer_name","customer_id='$cust_name'");
    // $mobile = $obj->getvalfield("m_customer","mobile","customer_id='$cust_name'");
    $table_no = $obj->getvalfield("m_table", "table_no", "table_id='$row_get[table_id]'");

    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno++, $row_get['billnumber'], $obj->dateformatindia($row_get['billdate']), $row_get['billtime'], $cust_name, $mobile, number_format($row_get['basic_bill_amt'], 2), "( " . $row_get['disc_percent'] . " %) " . number_format($disc_percent_amt, 2), number_format($disc_rs, 2), $gst . " %", number_format($cgst_amt, 2), number_format($sgst_amt, 2), number_format($row_get['net_bill_amt'], 2)));

    $subtotal += $row_get['net_bill_amt'];
    $tot_cgst_amt += $cgst_amt;
    $tot_sgst_amt += $sgst_amt;
    $tot_disc_rs += $row_get['disc_rs'];
    $tot_disc_percent_amt += $disc_percent_amt;
    $tot_basic_bill_amt += $row_get['basic_bill_amt'];
}



$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(252, 7, ' Total Gross Amount  :-', 1, 'R', 0);
$pdf->Cell(35, 7, number_format($tot_basic_bill_amt, 2), 1, 'R', 0);
$pdf->Ln(7);

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(252, 7, 'Disc(%) Amount :-', 1, 'L', 0);
$pdf->Cell(35, 7, number_format($tot_disc_percent_amt, 2), 1, 'R', 0);



$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(252, 7, 'Disc(Rs) Amount :-', 1, 'L', 0);
$pdf->Cell(35, 7, number_format($tot_disc_rs, 2), 1, 'R', 0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(252, 7, 'Total CGST :-', 1, 'L', 0);
$pdf->Cell(35, 7, number_format($tot_cgst_amt, 2), 1, 'R', 0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(252, 7, 'Total SGST :-', 1, 'L', 0);
$pdf->Cell(35, 7, number_format($tot_sgst_amt, 2), 1, 'R', 0);


$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(252, 7, 'Net Bill Amount :-', 1, 'L', 0);
$pdf->Cell(35, 7, number_format(round($subtotal), 2), 1, 'R', 0);

$pdf->Output();
