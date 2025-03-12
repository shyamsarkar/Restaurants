<?php include("../adminsession.php");
require("../fpdf185/fpdf.php");
$slno = "";
$tot_qty = "";
$tot_amt = "";
$totcgst = "";
$totsgcst = "";
$totigst  = "";
$product_name = "";
$unit_name = "";
$qty = "";
$disc = "";
$amount = "";
$cgst = "";
$cgstamt = "";
$sgst = "";
$sgstamt = "";
$igst = "";
$igstamt = "";
$company_name = "";
$supplier_name = "";
$customer_id = "";
$total = "";
$total_amt = "";
$company_address = "";
$mobile = "";
$date = "";
$address = "";
if (isset($_GET['purchaseid']))
    $purchaseid = $_GET['purchaseid'];
else
    $purchaseid = 0;

$res = $obj->executequery("select * from purchaseentry where purchaseid='$_GET[purchaseid]'");
foreach ($res as $rowget) {

    $supplier_id = $rowget['supplier_id'];
    $supplier_name = $obj->getvalfield("master_supplier", "supplier_name", "supplier_id='$supplier_id'");


    $billno = $rowget['billno'];

    //$address = $obj->getvalfield("master_customer","address","customer_id='$customer_id'");
    // $company_id= $rowget['company_id'];
    $address1 = $obj->getvalfield("company_setting", "address", "1=1");
    $company_name = $obj->getvalfield("company_setting", "comp_name", "1=1");
    $mobile = $obj->getvalfield("company_setting", "mobile", "1=1");
    $bill_date  = $obj->dateformatindia($rowget['bill_date']);
    //echo $gsttinno; die;
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
        global $title1, $title2, $company_name, $customer_name, $billno, $purchasedate, $address, $gsttinno, $gsttinNno, $company_address, $mobile, $company_code, $company_state, $cus_code, $gsttinno, $challan_no, $title3, $title4, $tinno, $address1, $comp_name, $mobile, $tinno, $date, $date1, $supplier_name, $bill_date;
        //courier 25
        $this->Rect(5, 5, 200, 287, 'D');
        //for first Rect
        $this->Rect(5, 28, 100, 42, 'D');
        //for second Rect
        $this->Rect(105, 28, 100, 42, 'D');
        //$this->SetFont('courier','b',20);
        ///for Second part
        //$this->Rect(5,40,100,20,'D');
        //for second Rect
        //$this->Rect(5,70,200,14,'D');
        $this->SetFont('courier', 'b', 18);
        $this->SetY(8);
        $this->Cell(90);
        $this->Cell(10, 0, "TAX PURCHASE INVOICE FOR FINISHED GOODS", 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('courier', 'b', 11);
        $this->Cell(90);
        $this->Cell(10, 0, "(Under Section 31 and rule 46 of GST Act,2017)", 0, 1, 'C');
        $this->Ln(5);

        // Move to the right
        $this->Cell(90);
        // Title
        $this->Cell(10, 0, strtoupper($company_name), 0, 1, 'C');
        // Line break
        $this->Ln(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(90);
        $this->Ln(5);
        $this->Line(5, 28, 205, 28);
        $this->Line(5, 33, 205, 33);

        //for Company GST
        $this->SetY(5);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(28, 51, "Billed From -", 0, 0, 'L');
        $this->Cell(68, 51, '', 0, 0, 'L');
        //for Supplier Name
        $this->SetFont('courier', 'b', 9);
        $this->SetX(110);
        $this->Cell(33, 51, "Billed To -", 0, 0, 'L');
        $this->Cell(75, 51, '', 0, 0, 'L');



        $this->SetX(5);
        $this->SetY(33);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(30, 10, "Supplier Name", 0, 0, 'L');
        $this->Cell(71, 10, ":" . strtoupper($supplier_name), 0, 0, 'L');
        //for Supplier Name
        $this->SetFont('courier', 'b', 9);
        $this->Cell(40, 10, "Name", 0, 0, 'L');
        $this->SetX(132);
        $this->Cell(5, 9, ":", 0, 0, 'L');
        $this->SetX(138);
        $this->Cell(12, 9, $company_name, 0, 1, 'L');

        //    //for Company Invoice
        $this->SetY(8);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(30, 70, "Invoice No", 0, 0, 'L');
        $this->Cell(71, 70, ":" . $billno, 0, 0, 'L');
        //for Supplier GST
        $this->SetFont('courier', 'b', 9);
        $this->Cell(27, 70, "Mobile No  :", 0, 0, 'L');
        $this->Cell(60, 70, $mobile, 0, 1, 'L');


        // //for Company Invoice
        $this->SetY(8);
        $this->SetFont('courier', 'b', 9);
        $this->Cell(30, 80, "Invoice Date", 0, 0, 'L');
        $this->Cell(71, 80, ":" . $bill_date, 0, 0, 'L');

        //for Supplier GST
        $this->SetFont('courier', 'b', 9);
        $this->Cell(27, 80, "State      :", 0, 0, 'L');
        $this->Cell(60, 80, "Chhaattisgarh(22) ", 0, 1, 'L');


        //for Company Address
        // $this->SetY(8);
        // $this->SetFont('courier','b',9);
        // $this->Cell(30,90,"Place of Supply",0,0,'L');
        // $this->Cell(71,90,":".$address,0,0,'L');


        // $this->SetFont('courier','b',9);
        // $this->Cell(28,90,"Address    :",0,0,'L');
        // //$this->SetY(50.56);
        // $this->SetX(138);
        // $this->MultiCell(48,5,$address1,0,'L');

        $this->Ln(7);
        $this->SetY(75);
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(170, 170, 170); //gray
        //$this->SetTextColor(0,0,0);
        $this->Cell(7, 5, 'Sno', '1', 0, 'L', 1);
        $this->Cell(22, 5, 'Product Name', 1, 0, 'L', 1);
        //$this->MultiCell(15,5,'HSE/SAC Code',1,0,'L');
        $this->Cell(13, 5, 'HSNNO', 1, 0, 'L', 1);
        $this->Cell(12, 5, 'QTY', 1, 0, 'C', 1);
        $this->Cell(10, 5, 'UNIT', 1, 0, 'C', 1);
        $this->Cell(12, 5, 'RATE', 1, 0, 'C', 1);
        $this->Cell(19, 5, 'TOTALSALE', 1, 0, 'C', 1);
        $this->Cell(10, 5, 'DISC.', 1, 0, 'C', 1);
        $this->Cell(15, 5, 'TAXABLE', 1, 0, 'L', 1);
        //$this->Cell(14,5,'TAXABLE',1,0,'L',1);
        $this->Cell(22, 5, 'CGST', 1, 0, 'C', 1);
        $this->Cell(22, 5, 'SGST', 1, 0, 'C', 1);
        $this->Cell(20, 5, 'IGST', 1, 0, 'C', 1);
        $this->MultiCell(16, 5, 'Amount', 1, 1, 'C', 1);
        $this->SetX(5);

        $this->SetFont('Arial', 'B', 8);
        //$this->SetFillColor(170, 170, 170); //gray
        //$this->SetTextColor(0,0,0);
        $this->Cell(120, 7, '', 1, 0, 'L', 1);
        $this->Cell(9, 7, 'Rate%', 1, 0, 'L', 1);
        $this->Cell(13, 7, 'Amt.', 1, 0, 'L', 1);

        $this->Cell(9, 7, 'Rate%', 1, 0, 'L', 1);
        $this->Cell(13, 7, 'Amt.', 1, 0, 'L', 1);

        $this->Cell(9, 7, 'Rate%', 1, 0, 'L', 1);
        $this->Cell(11, 7, 'Amt.', 1, 0, 'L', 1);
        $this->Cell(16, 7, '', 1, 0, 'R', 1);

        $this->Cell(1, 7, '', 0, 1, 'L', 0);

        $this->SetWidths(array(7, 22, 13, 12, 10, 12, 19, 10, 15, 9, 13, 9, 13, 9, 11, 16));
        $this->SetAligns(array("C", "L", "L", "R", "R", "R", "R", "R", "R", "R", "R", "R", "R", "R", "R", "R"));
    }
    // Page footer
    function Footer()
    {
        // global $comp_name;
        // Position at 1.5 cm from bottom
        $this->SetY(-11);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->SetX(5);
        $this->MultiCell(200, 5, '|| Developed By Trinity Solutions Raipur,Visit us- www.trinitysolutions.in ||', 0, 'C');
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
$title1 = "PURCHASE INVOICE";

$pdf->SetTitle($title1);

$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4');
$slno = 1;
$totcgst = 0;
$totsgst = 0;
$totigst = 0;
$tot_amt = 0;
$total_amt = 0;
$total_disc = 0;
$total_taxable = 0;
$total_cgst_amt = 0;
$total_sgst_amt = 0;
$total_igst_amt = 0;
$total_final_price = 0;
$total_discount_amt = 0;


$res = $obj->executequery("Select * from purchasentry_detail where purchaseid='$purchaseid'");
foreach ($res as $row_get) {
    $unit_name = 0;

    $transport_charge = 0;
    $unit_name = $row_get['unit_name'];
    $productid = $row_get['productid'];
    $prodname = $obj->getvalfield("m_product", "prodname", "productid='$productid'");
    $hsnno = "";

    $rate = $row_get['rate_amt'];
    $qty = $row_get['qty'];
    $igst = $row_get['igst'];
    $sgst = $row_get['sgst'];
    $cgst = $row_get['cgst'];
    $disc = $row_get['disc'];
    $disc = $row_get['disc'];
    $inc_or_exc = $row_get['inc_or_exc'];
    $final_price = $row_get['final_price'];
    $amount = $qty * $rate;

    $tot_dic = ($amount * $disc) / 100;



    $taxable_value = $row_get['taxable_value'];
    $cgst_amt = $row_get['cgst_amt'];
    $sgst_amt = $row_get['sgst_amt'];
    $igst_amt = $row_get['igst_amt'];


    $totalc = ($amount * $cgst) / 100;
    $totals = ($amount * $sgst) / 100;
    $totali = ($amount * $igst) / 100;
    $total = $totalc + $totals + $totali + $amount;



    $pdf->SetX(5);
    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Row(array($slno, strtoupper($prodname), $hsnno, $qty, strtoupper($unit_name), number_format($rate, 2), number_format($amount, 2), $disc . '%', strtoupper(substr($inc_or_exc, 0, 2)) . '-' . $taxable_value, $cgst . '%', $cgst_amt, $sgst . '%', $sgst_amt, $igst . '%', $igst_amt, number_format($final_price, 2)));
    $tot_amt += $amount;
    $totcgst += $totalc;
    $totsgst += $totals;
    $totigst += $totali;
    $total_amt += $total;
    $total_disc += $disc;
    $total_taxable += $taxable_value;
    $total_cgst_amt += $cgst_amt;
    $total_sgst_amt += $sgst_amt;
    $total_igst_amt += $igst_amt;
    $total_final_price += $final_price;
    $total_discount_amt += $tot_dic;
    $slno++;
}

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
//$pdf->SetTextColor(0,0,0);
$pdf->Cell(54, 7, 'TOTAL', '1', 0, 'L', 1);
$pdf->Cell(10, 7, '', 1, 0, 'R', 1);
$pdf->Cell(12, 7, '', 1, 0, 'L', 1);
$pdf->Cell(19, 7, number_format($tot_amt, 2), 1, 0, 'R', 1);
$pdf->Cell(10, 7, $total_discount_amt, 1, 0, 'R', 1);
$pdf->Cell(15, 7, $total_taxable, 1, 0, 'R', 1);
$pdf->Cell(9, 7, '', 1, 0, 'R', 1);
$pdf->Cell(13, 7, $total_cgst_amt, 1, 0, 'R', 1);
$pdf->Cell(9, 7, '', 1, 0, 'R', 1);
//$pdf->Cell(9,7,'',1,0,'R',1);
$pdf->Cell(13, 7, $total_sgst_amt, 1, 0, 'R', 1);
$pdf->Cell(9, 7, '', 1, 0, 'R', 1);
$pdf->Cell(11, 7, $total_igst_amt, 1, 0, 'R', 1);
$pdf->Cell(16, 7, number_format($total_final_price, 2), 1, 1, 'R', 1);



$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
//$pdf->SetTextColor(0,0,0);
$pdf->Cell(120, 7, 'REMARKS', '1', 0, 'L', 1);
$pdf->Cell(44, 7, 'SUMMARY', 1, 0, 'C', 1);
$pdf->Cell(36, 7, 'AMOUNT', 1, 1, 'R', 1);


$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->SetX(125);
$pdf->Cell(44, 7, 'TOTAL INVOICE VALUE', 1, 0, 'C', 1);
$pdf->Cell(36, 7, number_format($tot_amt, 2), 1, 1, 'R', 1);


$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->Cell(143, 7, '', '1', 0, 'L', 1);
$pdf->SetX(125);
$pdf->Cell(44, 7, 'TOTAL DISCOUNT', 1, 0, 'C', 1);
$pdf->Cell(36, 7, number_format($total_discount_amt, 2), 1, 1, 'R', 1);

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->Cell(143, 7, '', '1', 0, 'L', 1);
$pdf->SetX(125);
$pdf->Cell(44, 7, 'TOTAL TAXABLE VALUE', 1, 0, 'C', 1);
$pdf->Cell(36, 7, number_format($total_taxable, 2), 1, 1, 'R', 1);

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->Cell(143, 7, '', '1', 0, 'L', 1);
$pdf->SetX(125);
$pdf->Cell(44, 7, 'TOTAL CGST', 1, 0, 'C', 1);
$pdf->Cell(36, 7, $total_cgst_amt, 1, 1, 'R', 1);

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->Cell(143, 7, '', '1', 0, 'L', 1);
$pdf->SetX(125);
$pdf->Cell(44, 7, 'TOTAL SGST', 1, 0, 'C', 1);
$pdf->Cell(36, 7, $total_sgst_amt, 1, 1, 'R', 1);


$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->Cell(143, 7, '', '1', 0, 'L', 1);
$pdf->SetX(125);
$pdf->Cell(44, 7, 'TOTAL IGST', 1, 0, 'C', 1);
$pdf->Cell(36, 7, $total_igst_amt, 1, 1, 'R', 1);

$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(170, 170, 170); //gray
$pdf->Cell(143, 7, '', '1', 0, 'L', 1);
$pdf->SetX(125);
$pdf->Cell(44, 7, 'GRAND TOTAL', 1, 0, 'C', 1);
$pdf->Cell(36, 7, number_format(round($total_final_price), 2), 1, 1, 'R', 1);
//echo $transport_charge; die;
// if($transport_charge !='0')
// {
// $pdf->SetX(5);
// $pdf->SetFont('arial','b',9);
// $pdf->SetTextColor(0,0,0);
// $pdf->Cell(172,5,'Transport Charge(Rs) :',0,0,'R',0);
// $pdf->Cell(28,5,number_format($transport_charge,2),'0',1,'R',0);
// }
// $net_total = $total_amt + $transport_charge;

// $pdf->SetX(5);
// $pdf->SetFont('arial','b',9);
// $pdf->SetTextColor(0,0,0);
// $pdf->Cell(172,5,'NET TOTAL :',0,0,'R',0);
// $pdf->Cell(28,5,number_format(round($net_total),2),'0',1,'R',0);

$pdf->Ln(7);
$pdf->SetX(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(200, 5, 'Total Amount in Words : ' . ucfirst(convert_number_to_words(round($total_final_price))) . " Rupees ONLY", 0, 1, 'L', 0);
$pdf->Ln(5);
$pdf->Output();
?> 
