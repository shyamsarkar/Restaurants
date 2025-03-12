<?php

include("../adminsession.php");

require("../fpdf181/fpdf.php");

require("../pdf_js.php");



if(isset($_GET['billid']))

{

	$billid = addslashes($_GET['billid']);

  	$height = $obj->getvalfield("bill_details","count(*)","billid='$billid'");

	$pageheight = 10 * 150;
	
    $table_id_capstw = $obj->getvalfield("bills","table_id","billid='$billid'");
	$waiter_id_cap = $obj->getvalfield("cap_stw_table","waiter_id_cap","table_id='$table_id_capstw' and close_order=1 or close_order=0");
	$waiter_id_stw = $obj->getvalfield("cap_stw_table","waiter_id_stw","table_id='$table_id_capstw' and close_order=1 or close_order=0");
	$captain_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap'");
	$steward_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw'");



}



class PDF_AutoPrint extends PDF_JavaScript

{

  var $widths;

  var $aligns;



	function Header()

	{

		global $title1,$title2,$title3,$title4,$address2,$captain_name,$steward_name;

		 // courier 25

		$this->SetFont('courier','b',11);

		// Move to the right

		//$this->Cell(10);

		$this->SetY(7);

		$this->SetX(2);

		// Title

		$this->Cell(60,0,strtoupper($title1),0,0,'C');

		

		$this->Ln(5);

		$this->SetX(2);

		$this->SetFont('courier','b',8);

		//$this->Cell(60,0,$title2,0,0,'C');

		$this->MultiCell(60,0,$title2."",0,'C');

		

		

		$this->Ln(3);

		$this->SetX(2);

		$this->SetFont('courier','b',8);

		//$this->Cell(60,0,$title2,0,0,'C');

		$this->MultiCell(60,0,$address2."",0,'C');

		

	    $this->Ln(3);

	    if($title3!="")

		{

	    $this->SetX(2);

		$this->SetFont('courier','b',8);

		$this->Cell(60,0,strtoupper("GSTIN: ".$title3),0,0,'C');

		}

		$this->Ln(3);

	    

		

		

	    $this->SetX(2);

		$this->SetFont('courier','b',8);

		$this->Cell(60,0,$title4,0,0,'C');

		$this->Ln(1);

		

		$this->Cell(-1);

		$this->SetFont('courier','b',8);

		//$this->Cell(95,5,"".$collect_from,0,0,'L');

		$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');

		 //$this->Ln(1);

		 

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



function SetDash($black=null, $white=null)

    {

        if($black!==null)

            $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);

        else

            $s='[] 0 d';

        $this->_out($s);

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





	

$pdf = new PDF_AutoPrint('P', 'mm',array(65 ,$pageheight));

//$pdf=new PDF_MC_Table('P', 'mm',array(65 ,$pageheight));

//$title1 = 

$pdf->SetTitle('title1');

$title1 = $obj->getvalfield("company_setting","comp_name","1 = 1");

$title2 = ucwords($obj->getvalfield("company_setting","address","1 = 1"));

$title3 = ucwords($obj->getvalfield("company_setting","gstno","1 = 1"));

$mobile = $obj->getvalfield("company_setting","mobile","1 = 1");

$mobile1 = $obj->getvalfield("company_setting","mobile2","1 = 1");

$address2 = ucwords($obj->getvalfield("company_setting","address2","1 = 1"));

//$title3 =  ucwords($cmn->getvalfield("company_setting","address2","1 = 1"));

$title4 = "Mobile No: $mobile ,$mobile1";

$pdf->SetTitle($title1);



$resbills = $obj->executequery("select * from bills where billid='$billid'");

// $resbills = mysql_query("select * from bills where billid='$billid'");

foreach ($resbills as $rowbills) 

{

$billnumber = $rowbills['billnumber'];

$billdate   = $rowbills['billdate'];

$billtime   = $rowbills['billtime'];

$table_id   = $rowbills['table_id'];

 $waiter_id_cap = $obj->getvalfield("cap_stw_table","waiter_id_cap","table_id='$table_id' and close_order=1 or close_order=0");
 $waiter_id_stw = $obj->getvalfield("cap_stw_table","waiter_id_stw","table_id='$table_id' and close_order=1 or close_order=0");
  $captain_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap'");
  $steward_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw'");

$table_no = ucwords($obj->getvalfield("m_table","table_no","table_id='$table_id'"));

$basic_bill_amt = $rowbills['basic_bill_amt'];

$disc_percent  = $rowbills['disc_percent'];

$disc_rs  = $rowbills['disc_rs'];

$balance_amt = $basic_bill_amt - $disc_percent;

$sgst = $rowbills['sgst'];

$cgst =  $rowbills['cgst'];
$checked_nc = $rowbills['checked_nc'];


$sercharge = $rowbills['sercharge'];

$is_parsal = $rowbills['is_parsal'];

$parsal_status = $rowbills['parsal_status'];

$zomato = ucwords($obj->getvalfield("bill_details","zomato_order","billid='$billid'"));

if($zomato=='Zomato')

{

	$zomato1 = 'zomato';

}

else

{

	$zomato1 = '';

}



}//loop close

$pdf->AliasNbPages();

$pdf->AddPage();

$pdf->SetAutoPageBreak('off','0');

$pdf->SetFont('Arial','',8);

$pdf->SetY(22);

$pdf->SetX(2);

// $pdf->Cell(30,6,"For :zomato",'0',0,'R',0);

$pdf->Cell(10,6,"For :",'0',0,'L',0); 

$pdf->SetFont('Arial','b',9);

$pdf->Cell(10,6,$zomato1,'0',0,'L',0); 

$pdf->SetFont('Arial','',8);	

$pdf->SetY(22);

$pdf->SetX(34);

$pdf->Cell(30,6,"Date :".$obj->dateformatindia($billdate).' '.$billtime,'0',0,'R',0);  

$pdf->Ln(7);

$pdf->SetFont('Arial','',9);

$pdf->SetX(2);



if($is_parsal == 0)

{

	$pdf->Cell(10,6,"Table :",'0',0,'L',0); 

	$pdf->SetFont('Arial','b',9);

	$pdf->Cell(25,6,"$table_no",'0',0,'L',0); 

}

else

{

	$pdf->Cell(35,6,"Parcel",'0',0,'L',0); 	

}

$pdf->SetX(27);

$pdf->SetFont('Arial','',8);

$pdf->Cell(12,6,"Bill No :",'0',0,'R',0); 

$pdf->SetFont('Arial','b',9);

$pdf->Cell(15,6,"$billnumber",'0',0,'L',0);



$pdf->SetDash(1,1); //5mm on, 5mm off

$pdf->Line(3,28,62,28);



$pdf->SetDash(1,1); //5mm on, 5mm off

$pdf->Line(3,36,62,36);

$pdf->Ln(8);



$pdf->SetDash(1,1); //5mm on, 5mm off

$pdf->Line(3,43,62,43);



//$pdf->SetDash(1,1); //5mm on, 5mm off

//$pdf->Line(3,96,62,96);





$pdf->SetFont('Arial','',8);

$pdf->SetX(2);

$pdf->SetDrawColor('255','255','255');

//$pdf->Cell(9,5,' Sno','0',0,'C',0);  

$pdf->Cell(25,5,'Particular',0,0,'L',0);

$pdf->Cell(7,5,'Qty.',0,0,'C',0);

$pdf->Cell(12,5,'Rate',0,0,'R',0);

$pdf->Cell(15,5,'Total',0,1,'R',0);

$pdf->SetWidths(array(25,7,12,15));

$pdf->SetAligns(array('L','C','R','R'));



$pdf->Ln(2);

//$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 

$total=0;

$slno=1;

$net_bill=0;

$sql_get = $obj->executequery("select sum(qty) as tot_qty,productid,is_cancelled_product,unitid,rate,taxable_value from bill_details where billid=$billid and is_cancelled_product = 0 group by productid");

foreach ($sql_get as $row_get) 

{

	$amount=0;

	$productid=$row_get['productid'];

	$is_cancelled_product = $row_get['is_cancelled_product'];
	
	$qty =$row_get['tot_qty'];

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



	$pdf->SetFont('Arial','',7);

	//$pdf->SetDash(0,0); //5mm on, 5mm off

	$pdf->SetX(2);

	//$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  

	$pdf->Row(array( $prodname,$qty,number_format($row_get['rate'],2),$amount),1,1,'L',0); 

	$total += $amount;

	 $net_bill += $row_get['taxable_value'];

}

$pdf->Ln(10);

$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(3);



$pdf->SetFont('Arial','',8);

$pdf->SetX(5);

$pdf->Cell(46,5,"Sub Total:"."   ",'0',0,'R',0);

$pdf->Cell(12,5,number_format($total,2),'1',0,'R',0);



$pdf->Ln(3);

$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(5);


if($disc_percent != '0')
{
	$disc_amt = ($total * $disc_percent)/100;
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(5);
	$pdf->Cell(46,5,"DISC ($disc_percent%)"."   ",'0',0,'R',0);
	$pdf->Cell(12,5,number_format($disc_amt,2),'1',1,'R',0);
	$total -= $disc_amt;
}


//$total_taxable = $obj->getvalfield("bill_details","sum(taxable_value)","billid='$billid'");





if($disc_rs != '0')

{

	$disc_amt = $disc_rs;

	$pdf->SetFont('Arial','',8);

	$pdf->SetX(5);

	$pdf->Cell(46,5,"DISC (Rs. $disc_rs)"."   ",'0',0,'R',0);

	$pdf->Cell(12,5,number_format($disc_amt,2),'1',1,'R',0);

	$total -= $disc_amt;

}



// $pdf->SetFont('Arial','',8);

// $pdf->Ln(1);

// $pdf->SetX(5);

// $pdf->Cell(46,5,"Taxable Amt"."   ",'0',0,'R',0);

// $pdf->Cell(12,5,number_format($total_taxable,2),'1',0,'R',0);

// $pdf->Ln(5);


// $subtotal = $total;

// if($sgst_amt > 0)

// {

// 	//$taxamount = ($subtotal * $sgst)/100;

// 	$pdf->SetFont('Arial','',8);

// 	$pdf->SetX(5);

// 	$pdf->Cell(46,5,"SGST"."   ",'0',0,'R',0);

// 	$pdf->Cell(12,5,number_format($sgst_amt,2),'1',1,'R',0);

// 	$total += $taxamount;

// }

// if($cgst_amt != '0')

// {

// 	$taxamount=($subtotal * $cgst)/100;

// 	$pdf->SetFont('Arial','',8);

// 	$pdf->SetX(5);

// 	$pdf->Cell(46,5,"CGST"."   ",'0',0,'R',0);

// 	$pdf->Cell(12,5,number_format($cgst_amt,2),'0',1,'R',0);

// 	$total +=$taxamount;

// }
$subtotal = $total;
if($sgst != '0')
{
	$taxamount = ($subtotal * $sgst)/100;
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(5);
	$pdf->Cell(46,5,"SGST ($sgst%)"."   ",'0',0,'R',0);
	$pdf->Cell(12,5,number_format($taxamount,2),'1',1,'R',0);
	$total += $taxamount;
}



if($cgst != '0')
{
	$taxamount=($subtotal * $cgst)/100;
	$pdf->SetFont('Arial','',8);
	$pdf->SetX(5);
	$pdf->Cell(46,5,"CGST ($cgst%)"."   ",'0',0,'R',0);
	$pdf->Cell(12,5,number_format($taxamount,2),'0',1,'R',0);
	$total +=$taxamount;
}

// if($sercharge != '0')

// {

// 	$taxamount=($subtotal * $sercharge)/100;

// 	$pdf->SetFont('Arial','',8);

// 	$pdf->SetX(5);

// 	$pdf->Cell(46,5,"SERCHARGE ($sercharge%)"."   ",'0',0,'R',0);

// 	$pdf->Cell(12,5,number_format($taxamount,2),'0',1,'R',0);

// 	$total +=$taxamount;

// }



$roundval = round($total)-$total;

if($roundval !='0')

{

	$pdf->SetFont('Arial','',8);

	$pdf->SetX(5);

	$pdf->Cell(46,5,"Round"."   ",'1',0,'R',0);

	$pdf->Cell(12,5,number_format($roundval,2),'0',1,'R',0);

}



$pdf->SetFont('Arial','b',8);

$pdf->SetX(5);

$pdf->Cell(46,5,"Net Total"."   ",'1',0,'R',0);

$pdf->Cell(12,5,number_format(round($total),2),'1',1,'R',0);

//$pdf->Ln(2);

if($checked_nc > 0)
{
$pdf->SetFont('Arial','b',10);

$pdf->SetX(5);

$pdf->Cell(55,5,"THIS BILL IS NOT CHARGEABLE ",'1',0,'C',0);

}

$pdf->Ln(3);


$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(5);

$pdf->SetFont('Arial','',7);

$pdf->SetX(2);

$pdf->Cell(50,5,'Captain Name : '.$captain_name,'0',0,'L',0);

$pdf->Ln(4);
$pdf->SetX(2);

$pdf->Cell(50,5,'Steward Name : '.$steward_name,'0',0,'L',0);

$pdf->Ln(5);

$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  - - - - -  ','0',0,'L',0);

$pdf->Ln(5);

$pdf->SetFont('Arial','',6);

$pdf->SetX(2);

$pdf->Cell(50,5,'THANK YOU  FOR DINIG WITH US !! PLEASE COME AGAIN','0',0,'L',0);

$pdf->Ln(5);


// $pdf->SetFont('Arial','',7);

// $pdf->SetX(5);

// $pdf->Cell(50,5,'PLEASE COME AGIN..','0',0,'L',0);



$pdf->SetFont('Arial','',7);

$pdf->SetX(6);

$pdf->Cell(50,5,'Soft. Developed By - Trinity Solution Raipur','0',0,'L',0);

$pdf->Ln(3);

$pdf->SetFont('Arial','',7);

$pdf->SetX(8);

$pdf->Cell(50,5,'Contact No : 9770131555, 9826150906','0',0,'L',0);

$pdf->Ln(3);

$pdf->SetFont('Arial','',7);

$pdf->SetX(12);

$pdf->Cell(50,5,'Website : www.trinitysolutions.in','0',0,'L',0);

$is_cancelled_product = $obj->getvalfield("bill_details","is_cancelled_product","billid='$billid' and is_cancelled_product=1");

if($is_cancelled_product=='1'){

$pdf->Ln(6);

$pdf->SetFont('Arial','',7);

$pdf->SetX(5);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(6);

$pdf->SetFont('Arial','',8);

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

	

	$pdf->SetFont('Arial','',7);

	$pdf->SetX(2);

	$pdf->Row(array( strtoupper($prodname),$cancel_remark),1,1,'L',0); 

	

	

}



}

$pdf->AutoPrint();

$pdf->Output();

?>                          	

<?php

mysqli_close($db_link);

?>