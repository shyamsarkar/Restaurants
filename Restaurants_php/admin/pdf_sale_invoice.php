<?php include("../adminsession.php");
require("../fpdf185/fpdf.php");
$slno = "";
$tot_qty = "";
$tot_amt = "";
$totcgst = "";
$totsgcst = "";
$totigst  = "";
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
if (isset($_GET['saleid']))
    $saleid = $_GET['saleid'];
else
    $saleid = 0;

$res = $obj->executequery("select * from saleentry where saleid='$_GET[saleid]'");
foreach ($res as $rowget) {
    $company_id = $_SESSION['company_id'];
    $customer_id = $rowget['customer_id'];
    $customer_id = $rowget['customer_id'];
    $sale_date = $obj->dateformatindia($rowget['sale_date']);
    $disc = $rowget['discount'];
    //$billno= $rowget['saleno'];
    $company_name = $obj->getvalfield("company_setting", "company_name", "company_id='$company_id'");
    $company_address = $obj->getvalfield("company_setting", "address", "company_id='$company_id'");
    $comp_mobile = $obj->getvalfield("company_setting", "mobile", "company_id='$company_id'");
    $customer_name = $obj->getvalfield("master_customer", "customer_name", "customer_id='$customer_id'");
    $address = $obj->getvalfield("master_customer", "address", "customer_id='$customer_id'");
    $gsttinno = $obj->getvalfield("master_customer", "gsttinno", "customer_id='$customer_id'");
    $gsttinNno = $obj->getvalfield("company_setting", "gsttinno", "company_id='$company_id'");
    $transport_charge = $rowget['transport_charge'];
    //echo $gsttinno; die;
}
//echo "SELECT saleno, CONCAT( 'WM-', LPAD(saleno,3,'0') ) FROM saleentry where saleid='$_GET[saleid]'"; die;
$sql_get = $obj->executequery("SELECT saleno, CONCAT( 'WM-', LPAD(saleno,3,'0') ) FROM saleentry where saleid='$_GET[saleid]'");
foreach ($sql_get as $row_get) {
    $billno = $row_get['saleno'];
    //echo $billno;	
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
        global $title1, $title2, $company_name, $customer_name, $billno, $sale_date, $address, $gsttinno, $gsttinNno, $company_address, $comp_mobile, $address, $company_code, $company_state, $cus_code, $cus_state, $challan_no, $title3, $title4, $tinno, $address2, $comp_name, $mobile, $tinno;
        //courier 25
        $this->Rect(5, 5, 200, 287, 'D');
        //for first Rect
        $this->Rect(5, 28, 100, 33, 'D');
        //for second Rect
        $this->Rect(105, 28, 100, 33, 'D');
        //$this->SetFont('courier','b',20);
        ///for Second part
        //$this->Rect(5,40,100,20,'D');
        //for second Rect
        //$this->Rect(5,70,200,14,'D');
        $this->SetFont('courier', 'b', 18);
        $this->SetY(8);
        $this->Cell(90);
        $this->Cell(10, 0, "TAX SALE INVOICE", 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(90);
        $this->Cell(10, 0, "(Under Section 31 and rule 46 of GST Act,2017)", 0, 1, 'C');
        $this->Ln(5);
        /*	$this->SetFont('courier','b',15);
		$this->Cell(90);
		$this->Cell(10,0,$customer_name,0,1,'C');
		$this->Ln(5);*/
        // Move to the right
        $this->Cell(90);
        // Title
        //$this->Cell(10,0,strtoupper($company_name),0,1,'C');
        // Line break
        $this->Ln(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(90);
        //$this->Cell(10,0,$addresss." "."Mobile No :".$mobile,0,1,'C');
        //$this->Ln(4);
        // $this->SetFont('courier','b',9);
        // $this->Cell(90);
        // $this->Cell(10,0,$title4,0,1,'C');
        $this->Ln(5);
        // $this->SetFont('courier','b',9);
        //$this->Cell(90);
        // $this->Cell(10,0,"Subject to Raipur Jurisdiction",0,1,'C');
        //$this->Ln(5);
        $this->Line(5, 28, 205, 28);
        $this->Line(5, 33, 205, 33);

        // for Company GST
        $this->SetY(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 51, "Billed To -", 0, 0, 'L');
        $this->Cell(71, 5, "", 0, 0, 'L');
        //for Supplier Name
        $this->SetFont('courier', 'b', 9);
        $this->Cell(28, 51, "Billed From  -", 0, 0, 'L');
        $this->Cell(72, 5, "", 0, 1, 'L');



        $this->SetX(5);
        $this->SetY(30);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 10, "Supplier Name", 0, 0, 'L');
        $this->Cell(71, 10, ":" . $customer_name, 0, 0, 'L');
        //for Supplier Name
        $this->SetFont('courier', 'b', 9);
        $this->Cell(40, 10, "Name", 0, 0, 'L');
        $this->Cell(30, 10, ":" . $company_name, 0, 1, 'L');

        //for Company Invoice
        $this->SetY(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 70, "Invoice No", 0, 0, 'L');
        $this->Cell(71, 70, ":" . $billno, 0, 0, 'L');
        //for Supplier GST
        $this->SetFont('courier', 'b', 9);
        $this->Cell(25, 70, "Address", 0, 0, 'L');
        $this->Cell(75, 70, ":" . $company_address, 0, 1, 'L');


        //for Company Invoice
        $this->SetY(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 80, "Invoice Date", 0, 0, 'L');
        $this->Cell(71, 80, ":" . $sale_date, 0, 0, 'L');

        /*$this->SetX(105);
		$this->SetFont('courier','b',9);
		$this->Cell(29,10,"Mobile No.",0,0,'L');
        $this->SetX(130);
		$this->Cell(71,10,":".$mobile,0,0,'L');*/
        //for Supplier GST
        $this->SetFont('courier', 'b', 9);
        $this->Cell(25, 80, "Mobile No", 0, 0, 'L');
        $this->Cell(75, 80, ":" . $comp_mobile, 0, 1, 'L');


        //for Company Address
        $this->SetY(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 90, "Place of Supply", 0, 0, 'L');
        $this->Cell(71, 90, ":" . $address, 0, 0, 'L');
        //for Supplier GST
        //$this->SetX(100);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(25, 90, "State", 0, 0, 'L');
        $this->Cell(75, 90, ":" . " Chhaattisgarh(22) ", 0, 1, 'L');

        $this->SetY(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(29, 100, "GSTIN", 0, 0, 'L');
        $this->Cell(71, 100, ":" . $gsttinno, 0, 0, 'L');
        //for Supplier Name
        $this->SetFont('courier', 'b', 9);
        $this->Cell(28, 100, "GSTIN", 0, 0, 'L');
        //$this->SetX(130);
        $this->Cell(10, 100, ":" . $gsttinNno, 0, 1, 'L');

        $this->Ln(7);
        $this->SetY(61);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(170, 170, 170); //gray
        $this->SetTextColor(0, 0, 0);
        $this->Cell(14, 5, 'Sno', '1', 0, 'L', 1);
        $this->Cell(31, 5, 'Product Name', 1, 0, 'L', 1);
        $this->Cell(11, 5, 'UNIT', 1, 0, 'L', 1);
        $this->Cell(12, 5, 'QTY', 1, 0, 'C', 1);
        $this->Cell(13, 5, 'RATE', 1, 0, 'C', 1);
        $this->Cell(18, 5, 'AMOUNT', 1, 0, 'C', 1);
        $this->Cell(26, 5, 'CGST', 1, 0, 'C', 1);
        $this->Cell(26, 5, 'SGST', 1, 0, 'C', 1);
        $this->Cell(26, 5, 'IGST', 1, 0, 'C', 1);
        $this->Cell(23, 5, 'Total', 1, 1, 'C', 1);
        $this->SetX(5);

        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(170, 170, 170); //gray
        $this->SetTextColor(0, 0, 0);
        $this->Cell(99, 7, '', 1, 0, 'L', 1);
        $this->Cell(13, 7, 'Rate', 1, 0, 'L', 1);
        $this->Cell(13, 7, 'Amt.', 1, 0, 'L', 1);

        $this->Cell(13, 7, 'Rate', 1, 0, 'L', 1);
        $this->Cell(13, 7, 'Amt.', 1, 0, 'L', 1);

        $this->Cell(13, 7, 'Rate', 1, 0, 'L', 1);
        $this->Cell(13, 7, 'Amt.', 1, 0, 'L', 1);

        $this->Cell(23, 7, '', 1, 1, 'L', 1);

        $this->SetWidths(array(14, 31, 11, 12, 13, 18, 13, 13, 13, 13, 13, 13, 23));
        $this->SetAligns(array("C", "L", "L", "R", "R", "R", "R", "R", "R", "R", "R", "R", "R"));
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
        $this->MultiCell(200, 5, '|| Developed By Trinity Solutions Raipur, Contact us- +91-9770131555,+91-8871181890,Visit us- www.trinitysolutions.in ||', 0, 'C');
        $this->SetY(-22);
        $this->SetX(5);
        $this->SetFont('Arial', 'b', 8);
        $this->SetTextColor(0, 0, 0);
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
        $h = 8 * $nb;
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
$title1 = "SALE INVOICE";

$pdf->SetTitle($title1);

$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
$slno = 1;
//echo "Select * from saleentry_details where saleid='$saleid'"; die;
$res = $obj->executequery("Select * from saleentry_details where saleid='$saleid'");
foreach ($res as $row_get) {
    $unit_id = 0;
    $amount = 0;
    $gsttax = 0;
    $gstamt = 0;
    $unit_id = "";
    $cgstamt = 0;
    $sgstamt = 0;
    $igstamt = 0;
    $unit_id = "";
    $discount = "";
    $product_id = $row_get['product_id'];
    $prodname = $obj->getvalfield("m_product", "product_name", "product_id='$product_id'");
    $hsn_no = $obj->getvalfield("m_product", "hsnno", "product_id='$product_id'");
    $unit_name = $row_get['unit_name'];
    $rate = $row_get['rate_amt'];
    $qty = $row_get['qty'];
    $igst = $row_get['igst'];
    $sgst = $row_get['sgst'];
    $cgst = $row_get['cgst'];
    $amount = $rate * $qty;

    if ($cgst != '0' && $sgst != '0') {
        $cgstamt = ($amount * $cgst) / 100;
        $sgstamt = ($amount * $sgst) / 100;
    }

    if ($igst != '0') {
        $gstamt = ($amount * $igst) / 100;

        $igstamt = $gstamt;
        $igstamt;
    }
    $total = ($cgstamt + $sgstamt + $igstamt) + $amount;

    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno, $prodname, $unit_name, $qty, $rate, $amount, $cgst . ' %', number_format($cgstamt, 2), $sgst . ' %', number_format($sgstamt, 2), $igst . ' %', number_format($igstamt, 2), number_format($total, 2)));
    $tot_amt += $amount;
    $totcgst += $cgst . '%';
    $totsgcst += $sgst . '%';
    $totigst += $igst . '%';
    $total_amt += $total;
    $slno++;
}

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(56, 7, 'Total', '1', 0, 'R', 1);
$pdf->Cell(12, 7, '', 1, 0, 'R', 1);
$pdf->Cell(13, 7, '', 1, 0, 'L', 1);
$pdf->Cell(18, 7, number_format($tot_amt, 2), 1, 0, 'R', 1);
$pdf->Cell(13, 7, '', 1, 0, 'L', 1);
$pdf->Cell(13, 7, '', 1, 0, 'L', 1);
$pdf->Cell(13, 7, '', 1, 0, 'R', 1);
$pdf->Cell(13, 7, '', 1, 0, 'R', 1);
$pdf->Cell(13, 7, '', 1, 0, 'R', 1);
$pdf->Cell(13, 7, '', 1, 0, 'R', 1);
$pdf->Cell(23, 7, number_format($total_amt, 2), 1, 1, 'R', 1);

if ($disc != '0') {
    $discount = $total_amt - $disc;
    $pdf->SetX(5);
    $pdf->SetFont('arial', 'b', 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(172, 5, 'Disc(Rs) :', 0, 0, 'R', 0);
    $pdf->Cell(28, 5, "( - ) " . number_format($disc, 2), '0', 1, 'R', 0);
}

if ($transport_charge != '0') {
    $pdf->SetX(5);
    $pdf->SetFont('arial', 'b', 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(172, 5, 'Transport Charge(Rs) :', 0, 0, 'R', 0);
    $pdf->Cell(28, 5, number_format($transport_charge, 2), '0', 1, 'R', 0);
}
$pdf->SetX(5);
$pdf->SetFont('arial', 'b', 9);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(172, 5, 'NET TOTAL :', 0, 0, 'R', 0);
$pdf->Cell(28, 5, number_format(round($discount + $transport_charge), 2), '0', 1, 'R', 0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 5, 'Total Amount in Words' . ucfirst(convert_number_to_words(round($discount + $transport_charge))) . " ONLY", 0, 1, 'L', 0);
$pdf->Ln(5);

$pdf->Output();
?> 
