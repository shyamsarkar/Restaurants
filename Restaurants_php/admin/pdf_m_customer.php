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
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(15, 8, ' SNo', '1', 0, 'L', 0);
        $this->Cell(57, 8, 'Customer Name', 1, 0, 'L', 0);
        $this->Cell(35, 8, 'Mobile No.', 1, 0, 'L', 0);
        $this->Cell(30, 8, 'PAN No', 1, 0, 'L', 0);
        $this->Cell(30, 8, 'GSTIN No', 1, 0, 'L', 0);
        $this->Cell(30, 8, 'Address', 1, 0, 'L', 0);
        $this->Cell(35, 8, 'Ope.Bal.Date', 1, 0, 'L', 0);
        $this->Cell(45, 8, 'Opening Balance', 1, 1, 'L', 0);
        $this->SetWidths(array(15, 57, 35, 30, 30, 30, 35, 45));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L', 'L', 'L', 'L'));
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
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
$title2 = "(Customer Report Details)";
$pdf->SetTitle($title2);
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4');
$slno = 1;
$slno = 1;

$sql_list = mysql_query("Select * from m_supplier_party where type_supparty ='party' and suppartyid <> 0 order by suppartyid desc");
if ($sql_list) {
    while ($row_list = mysql_fetch_array($sql_list)) {
        $supparty_name = $row_list['supparty_name'];
        $mobile = $row_list['mobile'];
        $address = $row_list['address'];
        $panno = $row_list['panno'];
        $tinno = $row_list['tinno'];
        $bank_address = $row_list['address'];
        $prevbalance = $row_list['prevbalance'];
        $prevbal_date = $row_list['prevbal_date'];


        $pdf->setCellMargin(2);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Row(array($slno++, $supparty_name, $mobile, $panno, $tinno, $address, $cmn->dateformatindia($prevbal_date), number_format($prevbalance, 2)));
    }
}

$pdf->Output('Customer Report', 'I');
?>