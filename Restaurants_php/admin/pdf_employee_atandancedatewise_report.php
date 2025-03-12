<?php
include("../adminsession.php");
require("../fpdf185/fpdf.php");

$title1 = $obj->getvalfield("company_setting", "comp_name", "1 = '1'");

$crit = " where 1 = 1";
if (isset($_GET['from_date'])) {
    $from_date = $obj->dateformatindia($_GET['from_date']);
} else {
    $from_date = date('Y-m-d');
}



// $qry = $obj->executequery("select * from emp_attendance_entry where waiter_id='$waiter_id'");
// foreach ($qry as $key) 
// {
//    $waiter_id = $key['waiter_id'];
//    $waiter_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id'");
// }

class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;

    function Header()
    {
        global $title1, $title2, $waiter_name, $title3;
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


        $this->Ln(5);
        $this->Cell(-1);
        $this->SetFont('courier', 'b', 11);
        $this->setX(6);
        $this->Cell(50, 10, "Date : " . $title3, 0, 1, 'L');



        // $this->SetFont('courier','b',11);
        // $this->setY(22);
        // $this->setX(60);
        // $this->Cell(100,10,"Employee : ".$waiter_name,0,1,'L');

        // $this->SetFont('courier','b',11);
        // $this->setY(22);
        // $this->setX(220);
        // $this->Cell(40,10,"Year : ".$year,0,1,'L');

        // $this->SetFont('courier','b',11);
        // $this->setY(22);
        // $this->setX(170);
        // $this->Cell(40,10,"Month : ".$month_name,0,1,'L');



        $this->Ln(5);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(23, 8, 'SNo', '1', 0, 'L', 0);
        $this->Cell(100, 8, 'Employee Name', '1', 0, 'L', 0);
        $this->Cell(50, 8, 'Status', 1, 0, 'L', 0);
        $this->Cell(50, 8, 'Date', 1, 0, 'L', 0);
        $this->Cell(50, 8, 'Time', 1, 1, 'L', 0);



        $this->SetWidths(array(23, 100, 50, 50, 50));
        $this->SetAligns(array('L', 'L', 'L', 'L', 'L'));
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

$pdf->SetTitle($title1);
$title2 = "(EMPLOYEE ATTENDANCE DATEWISE REPORT LIST)";
$pdf->SetTitle($title2);
$title3 = $obj->dateformatindia($from_date);
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4');

$slno = 1;
$res = $obj->executequery("select * from m_waiter");
foreach ($res as $key) {
    $waiter_id = $key['waiter_id'];
    $waiter_name = $key['waiter_name'];

    $emp_attendance_date = $obj->getvalfield("emp_attendance_entry", "emp_attendance_date", "waiter_id='$waiter_id' and emp_attendance_date='$from_date'");

    $attendance_time = $obj->getvalfield("emp_attendance_entry", "attendance_time", "waiter_id='$waiter_id' and emp_attendance_date='$from_date'");

    if ($attendance_time == "")
        $atype = "Absent";
    else
        $atype = "Present";

    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno++, $waiter_name, $atype, $obj->dateformatindia($emp_attendance_date), $attendance_time));
}


// $pdf->SetFont('courier','b',15);
// $pdf->setX(210);
// $pdf->Cell(40,10,"Total Present : ".$tot_present.' Days',0,1,'L');

// $pdf->SetFont('courier','b',15);
// $pdf->setX(210);
// $pdf->Cell(40,10,"Total Absent  : ".$total_absnt.' Days',0,1,'L');

$pdf->Output('Company List', 'I');
?>
