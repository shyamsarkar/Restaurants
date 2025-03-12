<?php
include("../adminsession.php");
require("../fpdf185/fpdf.php");
//$acc_type = "student";
$title1 = $cmn->getvalfield("company_setting", "comp_name", "1 = '1'");
class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;


    function Header()
    {
        global $title1, $title2;


        $this->Rect(5, 5, 287, 200);
        $this->SetFont('courier', 'b', 25);
        $this->Cell(90);
        $this->Cell(90, 0, $title1, 0, 1, 'C');
        $this->Ln(7);
        $this->SetFont('courier', 'b', 15);
        $this->Cell(90);
        $this->Cell(90, 0, $title2, 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(-1);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(275, 5, "Date : " . date('d-m-Y'), 0, 1, 'R');
        $this->Ln(1);
        $this->setCellMargin(2);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(15, 8, 'SNo', '1', 0, 'L', 0);
        $this->Cell(65, 8, 'Company Name', 1, 0, 'L', 0);
        $this->Cell(70, 8, 'Mobile No', 1, 0, 'L', 0);
        $this->Cell(70, 8, 'GSTIIN No', 1, 0, 'L', 0);
        $this->Cell(67, 8, 'Address', 1, 1, 'L', 0);

        $this->SetWidths(array(15, 65, 70, 70, 67));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L'));
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', fbggh8);
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
    function SetCellMargin($margin)
    {
        // Set cell margin
        $this->cMargin = $margin;
    }
    function Row($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 7 * $nb;
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
            $this->MultiCell($w, 7, $data[$i], 0, $a);
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
?>
<?php


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
//$title1 = "Library Management";
$pdf->SetTitle($title1);
$title2 = "(Company Details)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4');
$slno = 1;
$sql_get = mysql_query("select * from company_setting where 1=1 order by compid desc");
while ($row_get = mysql_fetch_assoc($sql_get)) {

    $comp_name = $row_get['comp_name'];
    $mobile = $row_get['mobile'];
    $address = $row_get['address'];
    $gsttinno = $row_get['gsttinno'];
    $pdf->setCellMargin(2);
    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno++, $comp_name, $mobile, $address, $gsttinno));
}

$pdf->Output('Company List', 'I');
?>