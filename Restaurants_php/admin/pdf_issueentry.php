<?php include("../adminsession.php");

require("../fpdf185/fpdf.php");
$slno = "";
$tot_qty = "";
$tot_amt = "";
$unit_name = "";
$qty = "";
$disc = 0;
$amount = "";
$cgst = "";
$cgstamt = "";
$sgst = "";
$sgstamt = "";
$igst = "";
$saleno = "";
$igstamt = "";
$company_name = "";
$customer_id = "";
$total = "";
$total_amt = "";
$company_address = "";
$comp_mobile = "";
$unit_id = "";
$disc = "";
$transport_charge = "";
// $issueid="";
if (isset($_GET['issueid']))
    $issueid = $_GET['issueid'];
else
    $issueid = 0;

$res = $obj->executequery("select * from issue_entry where issueid='$_GET[issueid]'");
foreach ($res as $rowget) {

    $department_id = $rowget['department_id'];
    if ($department_id == 1) {
        $kitchen = "Kitchen 1";
    } else {
        $kitchen = "Kitchen 2";
    }
    $issueno = $rowget['issueno'];
    $remark = $rowget['remark'];
    $issuedate = $obj->dateformatindia($rowget['issuedate']);

    $company_name = $obj->getvalfield("company_setting", "comp_name", "1=1");
    $company_address = $obj->getvalfield("company_setting", "address", "1=1");
    $comp_mobile = $obj->getvalfield("company_setting", "mobile", "1=1");

    //$department_name = $obj->getvalfield("m_department","department_name","department_id='$department_id'");

    $gsttinNno = $obj->getvalfield("company_setting", "gstno", "1=1");
}


function getinwordsbyindia()
{
    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? 'and ' : null;
            $str[] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
        } else $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';



    if ($points != '' && $points != '0') {
        $words =  "$result Rupees $points  Paise";
    } else {
        $words =  "$result Rupees ";
    }

    return $words;
}

function convert_number_to_words($number)
{
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
        global $title1, $title2, $company_name, $address, $gsttinNno, $company_address, $comp_mobile, $address, $company_code, $company_state, $title3, $title4, $tinno, $address2, $comp_name, $mobile, $tinno, $issueno, $issuedate, $department_name, $remark, $kitchen;
        //courier 25
        $this->Rect(5, 5, 140, 287, 'D');
        //$this->Image("../img/logo.jpg", 7, 7,20,15);
        $this->SetFont('courier', 'b', 18);
        $this->SetY(8);
        $this->Cell(63);
        $this->Cell(10, 0, $company_name, 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(63);
        $this->Cell(10, 0, $company_address, 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(63);
        $this->Cell(10, 0, "Contact :" . $comp_mobile, 0, 1, 'C');
        $this->Ln(5);
        $this->SetY(26);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(63);
        $this->Cell(10, 0, "Issue", 0, 1, 'C');
        // Move to the right
        $this->Cell(90);
        // Title
        //$this->Cell(10,0,strtoupper($company_name),0,1,'C');
        // Line break
        $this->Ln(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(90);
        $this->Ln(5);
        $this->Line(5, 28, 145, 28);
        $this->Line(5, 33, 145, 33);

        $this->Line(75, 28, 75, 85); //3rd

        // for Company GST
        $this->SetY(28);
        $this->SetX(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(20, 5, "Issue To", 0, 0, 'L');
        //$this->Cell(71,5,"",0,0,'L');
        //for Supplier Name
        $this->SetX(75);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(20, 5, "Issue From", 0, 0, 'L');
        //$this->Cell(72,5,"",0,1,'L');

        $this->SetY(33);
        $this->SetX(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "Name", 0, 0, 'L');

        $this->SetY(33);
        $this->SetX(25);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(33);
        $this->SetX(30);
        $this->Cell(45, 5, $kitchen, 0, 0, 'L');

        // $this->SetY(38);
        //       $this->SetX(5);
        // $this->SetFont('courier','b',9);
        // $this->Cell(10,5,"Party Type",0,0,'L');

        //       $this->SetY(38);
        //       $this->SetX(25);
        // $this->SetFont('courier','b',9);
        // $this->Cell(3,5,":",0,0,'L');
        //       $this->SetY(38);
        // $this->SetX(29);
        // //$this->Cell(45,5,$sale_type,0,0,'L');

        // $this->SetY(43);
        //       $this->SetX(5);
        // $this->SetFont('courier','b',9);
        // $this->Cell(10,5,"Mobile No",0,0,'L');
        //       $this->SetY(43);
        //       $this->SetX(25);
        // $this->SetFont('courier','b',9);
        // $this->Cell(3,5,":",0,0,'L');
        //       $this->SetY(43);
        // $this->SetX(29);
        // $this->Cell(45,5,$mobile,0,0,'L');

        //       $this->SetY(48);
        //       $this->SetX(5);
        // $this->SetFont('courier','b',9);
        // $this->Cell(10,5,"GSTIN NO",0,0,'L');
        //       $this->SetY(48);
        //       $this->SetX(25);
        // $this->SetFont('courier','b',9);
        // $this->Cell(3,5,":",0,0,'L');
        //       $this->SetY(48);
        // $this->SetX(29);
        //	$this->Cell(45,5,$gsttinno,0,0,'L');

        $this->SetY(38);
        $this->SetX(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "Issue No", 0, 0, 'L');
        $this->SetY(38);
        $this->SetX(25);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(38);
        $this->SetX(29);
        $this->Cell(45, 5, $issueno, 0, 0, 'L');

        $this->SetY(43);
        $this->SetX(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "Date", 0, 0, 'L');
        $this->SetY(43);
        $this->SetX(25);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(43);
        $this->SetX(29);
        $this->Cell(45, 5, $issuedate, 0, 0, 'L');

        if ($remark != "") {
            $this->SetY(49);
            $this->SetX(5);
            $this->SetFont('courier', 'b', 9);
            $this->Cell(10, 5, "Remark", 0, 0, 'L');
            $this->SetY(49);
            $this->SetX(25);
            $this->SetFont('courier', 'b', 9);
            $this->Cell(3, 5, ":", 0, 0, 'L');
            $this->SetY(49);
            $this->SetX(29);
            $this->MultiCell(45, 5, $remark, 0, 'L');
        }
        $this->SetY(33);
        $this->SetX(75);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "Company Name", 0, 0, 'L');
        $this->SetY(33);
        $this->SetX(100);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(33);
        $this->SetX(105);
        $this->MultiCell(40, 3, $company_name, 0, 'L');
        //$this->Cell(45,5,$company_name,0,0,'L');

        $this->SetY(38);
        $this->SetX(75);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "Mobile No", 0, 0, 'L');
        $this->SetY(38);
        $this->SetX(100);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(38);
        $this->SetX(105);
        $this->Cell(45, 5, $comp_mobile, 0, 0, 'L');


        $this->SetY(43);
        $this->SetX(75);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "GSTIN NO", 0, 0, 'L');
        $this->SetY(43);
        $this->SetX(100);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(43);
        $this->SetX(105);
        $this->Cell(45, 5, $gsttinNno, 0, 0, 'L');

        $this->SetY(48);
        $this->SetX(75);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(10, 5, "Address", 0, 0, 'L');
        $this->SetY(48);
        $this->SetX(100);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(3, 5, ":", 0, 0, 'L');
        $this->SetY(48);
        $this->SetX(105);
        $this->MultiCell(40, 5, $company_address, 0, 'L');


        $this->Ln(1);
        $this->SetY(80);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(170, 170, 170); //gray
        $this->SetTextColor(0, 0, 0);
        $this->Cell(14, 5, 'Sno', '1', 0, 'L', 1);
        $this->Cell(110, 5, 'Description', 1, 0, 'L', 1);
        $this->Cell(15, 5, 'Qnty', 1, 1, 'R', 1);
        $this->SetWidths(array(14, 110, 15));
        $this->SetAligns(array("C", "L", "R"));
    }
    // Page footer
    function Footer()
    {
        global $comp_name;
        // Position at 1.5 cm from bottom
        $this->SetY(-11);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->SetX(5);
        $this->MultiCell(140, 5, '|| Developed By Trinity Solutions Raipur,Visit us- www.trinitysolutions.in ||', 0, 'C');



        $this->SetY(180);
        $this->SetX(120);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 10, "Signature", 0, 0, 'L');
        /*$this->SetY(-22);
	   $this->SetX(5);
	   $this->SetFont('Arial','b',8);
	   $this->SetTextColor(0,0,0);*/
        //$this->Cell(195,5, "For "." ".$comp_name,0,'1','R',0);
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
            $this->MultiCell($w, 8, $data[$i], 0, $a);
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
$title1 = "ISSUE INVOICE";

$pdf->SetTitle($title1);

$pdf->AliasNbPages();
$pdf->AddPage('P', 'A5');
$slno = 1;
$totalqty = 0;
$res = $obj->executequery("Select * from issue_entry_details where issueid='$issueid'");
foreach ($res as $row_get) {


    $raw_id = $row_get['raw_id'];
    $prodname = $obj->getvalfield("raw_material", "raw_name", "raw_id='$raw_id'");
    $hsn_no = "";

    $qty = $row_get['qty'];

    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno, $prodname, $qty));
    $totalqty += $qty;
    $slno++;
}
$pdf->Ln(0);
$pdf->SetX(5);
$pdf->SetFont('arial', 'b', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(109, 8, 'Total Qty', 0, 0, 'R', 0);
$pdf->SetX(116);
$pdf->Cell(3, 8, ':', 0, 0, 'L', 0);
$pdf->SetX(135);
$pdf->Cell(10, 8, number_format($totalqty, 2), '0', 1, 'R', 0);
$pdf->Output();
?>                      	
