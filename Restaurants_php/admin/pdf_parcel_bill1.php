<?php

include("../adminsession.php");

require("../fpdf181/fpdf.php");

require("../pdf_js.php");



if(isset($_GET['billid']))

{   
    $billid  = $obj->test_input($_GET['billid']);

    $table_id  = $obj->getvalfield("bills","table_id","billid='$billid'");

    //update kot 

    $kotdate = date('Y-m-d'); 
    $kottime  = date('h:i A');

    $billdate = "";

   $order_otp = $obj->getvalfield("parcel_order","otp","table_id='$table_id' and billid='$billid'");

   $order_number = $obj->getvalfield("parcel_order","order_number","table_id='$table_id' and billid='$billid'");


    $kotid = $obj->getvalfield("kot_entry","kotid","table_id='$table_id' and billid='$billid'");

    if($kotid!='')

    {

        $lastkotid = $kotid;

    }
    else
    $lastkotid = 0;

    if($table_id!="" && $billid!="")

    {
        $count_added_cart_item = $obj->getvalfield("bill_details","count(*)","table_id='$table_id' and billid=0 and kotid=0");

        if($count_added_cart_item > 0)

        {

            $sql_ins = array('kotdate'=>$kotdate, 'kottime'=>$kottime,'table_id'=>$table_id,'billid'=>$billid);

            $lastkotid = $obj->insert_record_lastid('kot_entry',$sql_ins);

        }

    }


    $qry = array('kotid'=>"$lastkotid");

    $where = array('table_id'=>$table_id,'billid'=>$billid,'kotid'=>'0');

    $obj->update_record('bill_details',$where,$qry);

    $height = $obj->getvalfield("bill_details","count(*)","kotid='$lastkotid'");

    $pageheight = 10 * 120;

    //echo "ji";die;

}



$billdate1=date('d-m-Y h:i A');



if(isset($_GET['kotid']))

{   

    $kotid  = $obj->test_input($_GET['kotid']);

    $kotdate = $obj->getvalfield("kot_entry","kotdate","kotid='$kotid'");

    $kottime  = $obj->getvalfield("kot_entry","kottime","kotid='$kotid'");

    $billdate = "";

    $billdate1=$kotdate. " ".$kottime;


    if($kotid!='')

    {

        $lastkotid = $kotid;

        $table_id  = $obj->getvalfield("kot_entry","table_id","kotid='$lastkotid'");

        $billid = 0;

    }

    

    $height = $obj->getvalfield("bill_details","count(*)","kotid='$lastkotid'");

    $pageheight = 10 * 120;



}



class PDF_AutoPrint extends PDF_JavaScript

{

  var $widths;

  var $aligns;



    function Header()

    {

        global $title1,$title2,$title3,$title4,$lastkotid,$address2,$title5,$order_number,$order_otp;

         // courier 25
        $this->Image("images/indianchilly_logo.jpeg", 6, 5,55,50);
        $this->SetFont('courier','b',17);

        // Move to the right

        //$this->Cell(10);

        //$this->SetY(4);
        $this->Ln(48);

        $this->SetX(2);

        // Title

        $this->SetFont('courier','b',11);

        //$this->Cell(60,0,$title2,0,0,'C');

        $this->MultiCell(60,0,"KOT FOR FOODS",0,'C');

        $this->Ln(47);

        $this->SetX(2);

        $this->SetFont('courier','b',11);

       // $this->Cell(60,0,$title1,0,0,'C');

        $this->Cell(-5);

        $this->SetFont('courier','b',11);

        //$this->Cell(95,5,"".$collect_from,0,0,'L');

        $this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');

        
    }

    //Printer

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



function SetDash($black=null, $white=null)

    {

        if($black!==null)

            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);

        else

            $s='[] 0 d';

        $this->_out($s);

    }



//$pdf=new PDF_MC_Table('P', 'mm',array(65 ,$pageheight));

$pdf = new PDF_AutoPrint('P', 'mm',array(65 ,$pageheight));



/*$title1 = $obj->getvalfield("company_setting","comp_name","1 = 1");

$pdf->SetTitle($title1);*/

$address1 = ucwords($obj->getvalfield("company_setting","address","1 = 1"));

$title3 = ucwords($obj->getvalfield("company_setting","gstno","1 = 1"));

$mobile = $obj->getvalfield("company_setting","mobile","1 = 1");

$mobile1 = $obj->getvalfield("company_setting","mobile2","1 = 1");
$gstc = ucwords($obj->getvalfield("company_setting","gstno","1 = 1"));
$fssai_no = $obj->getvalfield("company_setting","fssai_no","1 = 1");
$pdf->SetTitle($fssai_no);

$address2 = ucwords($obj->getvalfield("company_setting","address2","1 = 1"));

//$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));

$title4 = "Mobile No: $mobile ,$mobile1";

$table_no = ucwords($obj->getvalfield("m_table","table_no","table_id='$table_id'"));

$is_parsal = $obj->getvalfield("bills","is_parsal","billid='$billid'");

$pdf->AliasNbPages();

$pdf->AddPage();

$pdf->SetAutoPageBreak('off','0');


$pdf->SetFont('Arial','b',11);

//$pdf->SetY(12);
$pdf->Ln(-50);

$pdf->SetX(30);

$pdf->Cell(30,6,"Date :".$billdate1,'0',0,'R',0); 


$pdf->Ln(7);

$pdf->SetFont('Arial','',11);

$pdf->SetX(2);

if($is_parsal == 0)

{

$pdf->Cell(10,6,"Table",'0',0,'L',0); 

$pdf->SetFont('Arial','b',11);

$pdf->Cell(25,6,"$table_no",'0',0,'L',0); 

}

else

{

$pdf->Cell(35,6,"Parcel",'0',0,'L',0);  

}

$pdf->SetFont('Arial','',11);

$pdf->Cell(20,6,"Kot No.:",'0',0,'R',0); 

$pdf->SetFont('Arial','b',11);

$pdf->Cell(5,6,"$lastkotid",'0',0,'R',0); 



$pdf->SetDash(1,1); //5mm on, 5mm off

$pdf->Line(3,65,62,65);

$pdf->Ln(2);

$pdf->SetDash(1,1); //5mm on, 5mm off

$pdf->Line(3,72,62,72);

$pdf->Ln(2);

$pdf->SetDash(1,1); //5mm on, 5mm off

$pdf->Line(3,78,62,78);

 //$pdf->SetDash(1,1); //5mm on, 5mm off

 //$pdf->Line(3,60,62,60);

$pdf->Ln(2);

$pdf->SetFont('Arial','',11);

$pdf->SetX(2);

$pdf->SetDrawColor('255','255','255');

//$pdf->Cell(9,5,' Sno','0',0,'C',0);  

$pdf->Cell(38,5,'Particular',0,0,'L',0);

$pdf->Cell(11,5,'Unit',0,0,'C',0);

$pdf->Cell(10,5,'Qty',0,1,'R',0);

$pdf->SetWidths(array(38,11,10));

$pdf->SetAligns(array('L','C','R'));



$pdf->Ln(2);

//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 

$total=0;

$totqty = 0;

$slno=1;



    $sql_get = $obj->executequery("select * from view_bill_details  where billid='$billid'");

    foreach($sql_get as $row_get)

    {

    $amount=0;

    $productid=$row_get['productid'];

    $qty=$row_get['qty'];

    $unitid=$row_get['unitid'];

    $cancel_remark = $row_get['cancel_remark'];

    $is_cancelled_product = $row_get['is_cancelled_product'];

    $prodname=$obj->getvalfield("m_product","prodname","productid='$productid'");

    $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'"); 

    $rate=$row_get['rate'];

    $amount= number_format($qty * $rate,2);



    if($is_cancelled_product==1)

    {

        $prodname .= '(Cencelled)';

        $unit_name='X';

        $qty='X'; 

    }

    

    

    $pdf->SetFont('Arial','',8);

    $pdf->SetDash(0,0); //5mm on, 5mm off

    $pdf->SetX(2);

    //$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  

    $pdf->Row(array($prodname,$unit_name,$qty),1,1,'L',0); 



    $totqty +=$qty;

    }



// $pdf->Ln(2);

// $pdf->SetDash(1,1); //5mm on, 5mm off

// $pdf->Line(3,60,62,60);

$pdf->Ln(2);

$pdf->SetFont('Arial','b',11);

$pdf->SetX(5);

$pdf->Cell(46,5,"Total Qty"."   ",'0',0,'R',0);

$pdf->Cell(12,5,number_format($totqty,2),'1',0,'R',0);

$pdf->Ln(5);

$pdf->SetFont('Arial','b',11);

$pdf->SetX(0);

$pdf->Cell(5,5,"-------------------------------------------------------------------",'0',0,'L',0);





//  BILL PRINT

$pdf->Ln(15);

       $pdf->SetFont('courier','b',11);

        // Move to the right

        //$this->Cell(10);

        //$pdf->SetY(100);

        /*$pdf->SetX(2);

        // Title

        $pdf->Cell(60,0,strtoupper($title1),0,0,'C');*/

        

        $pdf->Ln(5);

        $pdf->SetX(2);

        $pdf->SetFont('courier','b',11);

        //$this->Cell(60,0,$title2,0,0,'C');

        $pdf->MultiCell(60,0,$title2."",0,'C');

        

        

        $pdf->Ln(3);

        $pdf->SetX(2);

        $pdf->SetFont('courier','b',10);

        //$this->Cell(60,0,$title2,0,0,'C');

        //$pdf->MultiCell(60,0,$address2."",0,'C');
        $pdf->MultiCell(60,5,$address1." GST ".$gstc." FSSAI No.".$fssai_no." ".$title4,0,'C');

        

       /* $pdf->Ln(3);

        if($title3!="")

        {

        $pdf->SetX(2);

        $pdf->SetFont('courier','b',8);

        $pdf->Cell(60,0,strtoupper("GSTIN: ".$title3),0,0,'C');

        }*/

        //$pdf->Ln(3);

        

        

        

        /*$pdf->SetX(2);

        $pdf->SetFont('courier','b',8);

        $pdf->Cell(60,0,$title4,0,0,'C');
*/
        $pdf->Ln(1);

    

$resbills = $obj->executequery("select * from bills where billid='$billid'");


foreach ($resbills as $rowbills) 

{

$billnumber = $rowbills['billnumber'];

$billdate   = $rowbills['billdate'];

$billtime   = $rowbills['billtime'];

$table_id   = $rowbills['table_id'];

$table_no = ucwords($obj->getvalfield("m_table","table_no","table_id='$table_id'"));



$basic_bill_amt = $rowbills['basic_bill_amt'];

$disc_percent  = $rowbills['disc_percent'];

$disc_rs  = $rowbills['disc_rs'];

$balance_amt = $basic_bill_amt - $disc_percent;

$sgst = $rowbills['sgst'];

$cgst =  $rowbills['cgst'];

$sercharge = $rowbills['sercharge'];

$is_parsal = $rowbills['is_parsal'];

$parsal_status = $rowbills['parsal_status'];


 }//loop close

$pdf->SetFont('Arial','',11);

$pdf->Ln(1);
$pdf->SetX(2);
$pdf->SetX(34);
$pdf->Cell(30,6,"Date :".$obj->dateformatindia($billdate).' '.$billtime,'0',0,'R',0);  
$pdf->Ln(3);


$pdf->SetX(2);
$pdf->Cell(30,6,"----------------------------------------------------------------",'0',1,'L',0); 
$pdf->SetX(3);

$pdf->SetFont('Arial','b',11);

$pdf->Cell(20,6,"Order No. : ",'0',0,'L',0);

$pdf->SetX(24);
$pdf->SetFont('Arial','b',11);
$pdf->Cell(20,6,$order_number,'0',0,'L',0);
$pdf->SetX(34);
$pdf->SetFont('Arial','b',11);
$pdf->Cell(30,6,"OTP Code : ".$order_otp,'0',0,'R',0);  
$pdf->Ln(5);


$pdf->SetX(3);

if($is_parsal == 0)
{ 

    $pdf->SetX(3);
    $pdf->Cell(10,6,"For :",'0',0,'L',0); 

    $pdf->SetFont('Arial','b',11);

    $pdf->Cell(25,6,"$table_no",'0',0,'L',0); 

}

else

{

    $pdf->Cell(35,6,"Parcel",'0',0,'L',0);  

}

$pdf->SetX(30);

$pdf->SetFont('Arial','',11);

$pdf->Cell(12,6,"Bill No :",'0',0,'R',0); 

$pdf->SetFont('Arial','b',11);

$pdf->Cell(15,6,"$billnumber",'0',0,'L',0);

$pdf->Ln(5);


$pdf->SetX(2);
//$pdf->SetFont('Arial','',9);
$pdf->Cell(30,6,"----------------------------------------------------------",'0',1,'L',0); 


$pdf->SetFont('Arial','',11);

$pdf->SetX(2);
$pdf->SetDrawColor('255','255','255');
//$pdf->Cell(9,5,' Sno','0',0,'C',0);  
$pdf->Cell(25,2,'Particular',0,0,'L',0);
$pdf->Cell(7,2,'Qty.',0,0,'C',0);
$pdf->Cell(12,2,'Rate',0,0,'R',0);
$pdf->Cell(15,2,'Total',0,1,'R',0);
$pdf->SetWidths(array(25,7,12,15));
$pdf->SetAligns(array('L','C','R','R'));
$pdf->SetX(2);
//$pdf->SetFont('Arial','',9);
$pdf->Cell(30,3,"-----------------------------------------------------------------",'0',1,'L',0); 
//$pdf->Ln(2);

$total=0;

$slno=1;

$net_bill=0;


$sql_get = $obj->executequery("select * from bill_details where billid=$billid and is_cancelled_product = 0");

foreach ($sql_get as $row_get) 

{


    $amount=0;

    $productid=$row_get['productid'];

    $is_cancelled_product = $row_get['is_cancelled_product'];

    $qty=$row_get['qty'];

    $unitid=$row_get['unitid'];

    $rate=$row_get['rate'];

    $prodname=$obj->getvalfield("m_product","prodname","productid='$productid'");

    $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'"); 

    $amount = $qty * $rate;



    if($is_cancelled_product == 1)

    {

        //$prodname = $pdf->SetFont('Arial','b',15);

        $pdf->SetDrawColor('255','255','255');

        $prodname = $pdf->Cell(12,6,"$prodname",'1',0,'L',0);

    }



    $pdf->SetFont('Arial','',9);

    //$pdf->SetDash(0,0); //5mm on, 5mm off

    $pdf->SetX(2);

    //$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  

    $pdf->Row(array( $prodname,$row_get['qty'],number_format($row_get['rate'],2),$amount),1,1,'L',0); 

    $total += $amount;

     $net_bill += $row_get['taxable_value'];

}



$pdf->Ln(10);

$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(3);



$pdf->SetFont('Arial','',11);

$pdf->SetX(5);

$pdf->Cell(46,5,"Sub Total:"."   ",'0',0,'R',0);

$pdf->Cell(12,5,number_format($total,2),'1',0,'R',0);



$pdf->Ln(3);

$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(6);


if($disc_percent != '0')
{
    $disc_amt = ($total * $disc_percent)/100;
    $pdf->SetFont('Arial','',11);
    $pdf->SetX(5);
    $pdf->Cell(46,5,"DISC ($disc_percent%)"."   ",'0',0,'R',0);
    $pdf->Cell(12,5,number_format($disc_amt,2),'1',1,'R',0);
    $total -= $disc_amt;
}


if($disc_rs != '0')
{
    $disc_amt = $disc_rs;
    $pdf->SetFont('Arial','',11);
    $pdf->SetX(5);
    $pdf->Cell(46,5,"DISC (Rs. $disc_rs)"."   ",'0',0,'R',0);
    $pdf->Cell(12,5,number_format($disc_amt,2),'1',1,'R',0);
    $total -= $disc_amt;
}


    
$subtotal = $total;
if($sgst != '0')
{
    $taxamount = ($subtotal * $sgst)/100;
    $pdf->SetFont('Arial','',11);
    $pdf->SetX(5);
    $pdf->Cell(46,5,"SGST ($sgst%)"."   ",'0',0,'R',0);
    $pdf->Cell(12,5,number_format($taxamount,2),'1',1,'R',0);
    $total += $taxamount;
}



if($cgst != '0')
{
    $taxamount=($subtotal * $cgst)/100;
    $pdf->SetFont('Arial','',11);
    $pdf->SetX(5);
    $pdf->Cell(46,5,"CGST ($cgst%)"."   ",'0',0,'R',0);
    $pdf->Cell(12,5,number_format($taxamount,2),'0',1,'R',0);
    $total +=$taxamount;
}



//$total_taxable = $obj->getvalfield("bill_details","sum(taxable_value)","billid='$billid'");





// if($disc_rs != '0')

// {

//  $disc_amt = $disc_rs;

//  $pdf->SetFont('Arial','',8);

//  $pdf->SetX(5);

//  $pdf->Cell(46,5,"DISC (Rs. $disc_rs)"."   ",'0',0,'R',0);

//  $pdf->Cell(12,5,number_format($disc_amt,2),'1',1,'R',0);

//  $total -= $disc_amt;

// }



// $pdf->SetFont('Arial','',8);

// $pdf->Ln(1);

// $pdf->SetX(5);

// $pdf->Cell(46,5,"Taxable Amt"."   ",'0',0,'R',0);

// $pdf->Cell(12,5,number_format($total_taxable,2),'1',0,'R',0);



//$pdf->Ln(5);





// $subtotal = $total;

// if($sgst_amt != '0')

// {

//  //$taxamount = ($subtotal * $sgst)/100;

//  $pdf->SetFont('Arial','',8);

//  $pdf->SetX(5);

//  $pdf->Cell(46,5,"SGST"."   ",'0',0,'R',0);

//  $pdf->Cell(12,5,number_format($sgst_amt,2),'1',1,'R',0);

//  //$total += $taxamount;

// }







// if($cgst != '0')

// {

//  $taxamount=($subtotal * $cgst)/100;

//  $pdf->SetFont('Arial','',8);

//  $pdf->SetX(5);

//  $pdf->Cell(46,5,"CGST"."   ",'0',0,'R',0);

//  $pdf->Cell(12,5,number_format($cgst_amt,2),'0',1,'R',0);

//  //$total +=$taxamount;

// }


$roundval = round($total)-$total;

if($roundval !='0')

{

    $pdf->SetFont('Arial','',11);

    $pdf->SetX(5);

    $pdf->Cell(46,5,"Round"."   ",'1',0,'R',0);

    $pdf->Cell(12,5,number_format($roundval,2),'0',1,'R',0);

}



$pdf->SetFont('Arial','b',11);

$pdf->SetX(5);

$pdf->Cell(46,5,"Net Total"."   ",'1',0,'R',0);

$pdf->Cell(12,5,number_format(round($total),2),'1',1,'R',0);

$pdf->Ln(5);


$is_cancelled_product = $obj->getvalfield("bill_details","is_cancelled_product","billid='$billid' and is_cancelled_product=1");

if($is_cancelled_product=='1'){

$pdf->Ln(6);

$pdf->SetFont('Arial','',11);

$pdf->SetX(5);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(6);

$pdf->SetFont('Arial','',11);

$pdf->SetX(2);

$pdf->SetDrawColor('255','255','255');

//$pdf->Cell(9,5,' Sno','0',0,'C',0);  

$pdf->Cell(25,5,'Particular',0,0,'L',0);

$pdf->Cell(50,5,'Cencelled Remark.',0,1,'L',0);



$pdf->SetWidths(array(25,50));

$pdf->SetAligns(array('L','L'));



$pdf->Ln(2);

//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 

$total=0;

$slno=1;

//echo "select * from bill_details where billid=$billid and is_cancelled_product = 1";

$sql_get = $obj->executequery("select * from bill_details where billid=$billid and is_cancelled_product = '1'");

foreach ($sql_get as $row_get) 

{

    

    $productid=$row_get['productid'];

    $cancel_remark=$row_get['cancel_remark'];

    

    $prodname=$obj->getvalfield("m_product","prodname","productid='$productid'");

    

    $pdf->SetFont('Arial','',11);

    $pdf->SetX(2);

    $pdf->Row(array( strtoupper($prodname),$cancel_remark),1,1,'L',0); 

    

    

}



}



$pdf->Output();

$pdf->Ln(2);



?>    

<?php

mysql_close($db_link);

?>