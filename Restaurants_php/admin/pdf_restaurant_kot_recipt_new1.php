<?php
include("../adminsession.php");
require("../fpdf181/fpdf.php");
require("../pdf_js.php");

if(isset($_GET['table_id']))
{	
	$table_id  = $obj->test_input($_GET['table_id']);
	$billid  = $obj->test_input($_GET['billid']);

    $waiter_id_cap = $obj->getvalfield("cap_stw_table","waiter_id_cap","table_id='$table_id' and close_order=0 or close_order=1");
    $waiter_id_stw = $obj->getvalfield("cap_stw_table","waiter_id_stw","table_id='$table_id' and close_order=0 or close_order=1");
    $captain_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap'");
    $steward_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw'");
	//update kot 
	//$kotdate = date('Y-m-d'); 
     $kotdate = $obj->getvalfield("day_close","day_date","1=1");
	$kottime  = date('h:i A');
	$billdate = "";
    $for_foods_check = $obj->getvalfield("view_bill_details","count(*)","table_id='$table_id' and foodtypeid='2'");
    $for_bev_check = $obj->getvalfield("view_bill_details","count(*)","table_id='$table_id' and foodtypeid='1'");


	$kotid = $obj->getvalfield("kot_entry","kotid","table_id='$table_id' and billid=0 limit 0,1");
	if($kotid!='')
	{
		$lastkotid = $kotid;


	}
     $kotid = $obj->getvalfield("kot_entry","kotid","table_id='$table_id' and billid='$billid' limit 0,1");
    if($kotid > 0)
    {
        $lastkotid = $kotid;


    }
	if($table_id!="" && $billid == 0)
	{
        //echo "hi";die;
        $count_added_cart_item = $obj->getvalfield("bill_details","count(*)","table_id='$table_id' and billid=0 and kotid=0");
        $for_foods_check = $obj->getvalfield("view_bill_details","count(*)","kotid='$kotid' and foodtypeid='2'");
        $for_bev_check = $obj->getvalfield("view_bill_details","count(*)","kotid='$kotid' and foodtypeid='1'");
        if($count_added_cart_item > 0)
        {
            $sql_ins = array('kotdate'=>$kotdate, 'kottime'=>$kottime,'table_id'=>$table_id,'billid'=>$billid);
    		//$res_ins = $obj->insert_record('kot_entry',$sql_ins);
    		$lastkotid = $obj->insert_record_lastid('kot_entry',$sql_ins);
            
        }
        // else
        // {
        //     echo "No Prouct in cart for new kot!";
        //     die;
        //     //echo "0";
        // }
	}

    if($table_id!="" && $billid > 0)
    {
        //echo "hi";die;
        $count_added_cart_item = $obj->getvalfield("bill_details","count(*)","table_id='$table_id' and billid='$billid' and kotid=0");
        $for_foods_check = $obj->getvalfield("view_bill_details","count(*)","kotid='$kotid' and foodtypeid='2'");
        $for_bev_check = $obj->getvalfield("view_bill_details","count(*)","kotid='$kotid' and foodtypeid='1'");
        if($count_added_cart_item > 0)
        {
            $sql_ins = array('kotdate'=>$kotdate, 'kottime'=>$kottime,'table_id'=>$table_id,'billid'=>$billid);
            //$res_ins = $obj->insert_record('kot_entry',$sql_ins);
            $lastkotid = $obj->insert_record_lastid('kot_entry',$sql_ins);
            
        }
       
    }
	
	
    $qry = array('kotid'=>$lastkotid);
    $where = array('table_id'=>$table_id,'billid'=>$billid,'kotid'=>'0');
    $obj->update_record('bill_details',$where,$qry);
	$height = $obj->getvalfield("bill_details","count(*)","kotid='$lastkotid'");
	$pageheight = 10 * 120;
    //echo "ji";die;
}

//$billdate1=date('d-m-Y h:i A');
$kotdate = $obj->getvalfield("day_close","day_date","1=1");
$kottime  = date('h:i A');
$billdate1=$kotdate. " ".$kottime;


if(isset($_GET['kotid']))
{   
    $kotid  = $obj->test_input($_GET['kotid']);
    $kotdate = $obj->getvalfield("kot_entry","kotdate","kotid='$kotid'");
    $kottime  = $obj->getvalfield("kot_entry","kottime","kotid='$kotid'");
    $billdate = "";
    $billdate1=$kotdate. " ".$kottime;
     $for_foods_check = $obj->getvalfield("view_bill_details","count(*)","kotid='$kotid' and foodtypeid='2'");
   $for_bev_check = $obj->getvalfield("view_bill_details","count(*)","kotid='$kotid' and foodtypeid='1'");

    if($kotid!='')
    {
        $lastkotid = $kotid;
        $table_id  = $obj->getvalfield("kot_entry","table_id","kotid='$lastkotid'");
        $billid = 0;
    }
    
    $height = $obj->getvalfield("bill_details","count(*)","kotid='$lastkotid'");
    $pageheight = 10 * 120;

     $waiter_id_cap = $obj->getvalfield("cap_stw_table","waiter_id_cap","table_id='$table_id' and close_order=0 or close_order=1");
    $waiter_id_stw = $obj->getvalfield("cap_stw_table","waiter_id_stw","table_id='$table_id' and close_order=0 or close_order=1");
    $captain_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_cap'");
    $steward_name = $obj->getvalfield("m_waiter","waiter_name","waiter_id='$waiter_id_stw'");

}

class PDF_AutoPrint extends PDF_JavaScript
{
  var $widths;
  var $aligns;

	function Header()
	{
		global $title1,$title2,$title3,$title4,$lastkotid,$for_foods_check,$for_bev_check,$captain_name,$steward_name;
		 // courier 25
        
		//$this->SetFont('courier','b',25);
		// Move to the right
		//$this->Cell(10);
		//$this->SetY(7);
		$this->SetX(2);
		// Title
        $this->SetFont('courier','b',15);
        //$this->Cell(60,0,$title2,0,0,'C');
        $this->MultiCell(60,0,"KOT FOR FOODS",0,'C');
		//$this->Ln(5);
		/*$this->SetX(2);
        $this->SetFont('courier','b',10);*/
        //$this->Cell(60,0,$title1,0,0,'C');
        
		
		
		/*$this->Cell(-1);
		$this->SetFont('courier','b',8);*/
		//$this->Cell(95,5,"".$collect_from,0,0,'L');
		//$this->Cell(192,5,"Date : ".date('d-m-Y'),0,1,'R');
		 //$this->Ln(1);

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
?>
<?php
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

 $title1 = $obj->getvalfield("company_setting","comp_name","1 = 1");
 
 $pdf->SetTitle($title1);

$table_no = ucwords($obj->getvalfield("m_table","table_no","table_id='$table_id'"));


$is_parsal = $obj->getvalfield("bills","is_parsal","billid='$billid'");


$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak('off','0');

$pdf->SetFont('Arial','b',10);
$pdf->SetY(16);
$pdf->SetX(30);
$pdf->Cell(30,6,"Date :".$billdate1,'0',0,'R',0); 


$pdf->Ln(7);
$pdf->SetFont('Arial','',10);
$pdf->SetX(2);
if($is_parsal == 0)
{
$pdf->Cell(10,6,"Table",'0',0,'L',0); 
$pdf->SetFont('Arial','b',10);
$pdf->Cell(25,6,"$table_no",'0',0,'L',0); 
}
else
{
$pdf->Cell(35,6,"Parcel",'0',0,'L',0); 	
}
$pdf->SetFont('Arial','',10);
$pdf->Cell(20,6,"Kot No.:",'0',0,'R',0); 
$pdf->SetFont('Arial','b',10);
$pdf->Cell(5,6,"$lastkotid",'0',0,'R',0); 

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,22,62,22);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,29,62,29);
$pdf->Ln(8);

$pdf->SetDash(1,1); //5mm on, 5mm off
$pdf->Line(3,36,62,36);

 //$pdf->SetDash(1,1); //5mm on, 5mm off
 //$pdf->Line(3,60,62,60);


$pdf->SetFont('Arial','',10);
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

    $sql_get = $obj->executequery("select * from view_bill_details  where kotid='$lastkotid'");
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
	
	
    $pdf->SetFont('Arial','',10);
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
$pdf->SetFont('Arial','b',10);
$pdf->SetX(5);
$pdf->Cell(46,5,"Total Qty"."   ",'0',0,'R',0);
$pdf->Cell(12,5,number_format($totqty,2),'1',0,'R',0);

//$pdf->Ln(25);

// next Bevrages table
//$pdf->Ln(69);
// if($for_bev_check > 0){
// $pdf->SetX(2);
// // Title
// $pdf->SetFont('courier','b',10);
// //$this->Cell(60,0,$title2,0,0,'C');
// $pdf->MultiCell(60,0,"KOT FOR BEVERAGES",0,'C');

// //$pdf->Ln(5);
// $pdf->SetX(2);
// //$pdf->SetFont('courier','b',10);
// //$pdf->Cell(60,0,$title1,0,0,'C');

// $pdf->SetFont('Arial','b',8);
// $pdf->Ln(5);
// $pdf->SetX(30);
// $pdf->Cell(30,6,"Date :".$billdate1,'0',0,'R',0);
// $pdf->Ln(2);
// $pdf->SetX(1);
// $pdf->Cell(2,6,"----------------------------------------------------------------",'0',0,'L',0);

// $pdf->Ln(7);
// $pdf->SetFont('Arial','',9);
// $pdf->SetX(2);
// if($is_parsal == 0)
// {
// $pdf->Cell(10,6,"Table",'0',0,'L',0); 
// $pdf->SetFont('Arial','b',9);
// $pdf->Cell(25,6,"$table_no",'0',0,'L',0); 
// }
// else
// {
// $pdf->Cell(35,6,"Parcel",'0',0,'L',0);  
// }

// $pdf->SetFont('Arial','',9);
// $pdf->Cell(20,6,"Kot No.:",'0',0,'R',0); 
// $pdf->SetFont('Arial','b',9);
// $pdf->Cell(5,6,"$lastkotid",'0',0,'R',0);
// $pdf->Ln(2);
// $pdf->SetX(1);
// $pdf->Cell(2,6,"----------------------------------------------------------------",'0',0,'L',0);

// // $pdf->SetDash(1,1); //5mm on, 5mm off
// // $pdf->Line(3,115,62,115);

// // $pdf->SetDash(1,1); //5mm on, 5mm off
// // $pdf->Line(3,29,62,29);
// // $pdf->Ln(8);

// // $pdf->SetDash(1,1); //5mm on, 5mm off
// // $pdf->Line(3,36,62,36);

// $pdf->Ln(8);
// $pdf->SetFont('Arial','',8);
// $pdf->SetX(2);
// $pdf->SetDrawColor('255','255','255');
// //$pdf->Cell(9,5,' Sno','0',0,'C',0);  
// $pdf->Cell(38,5,'Particular',0,0,'L',0);
// $pdf->Cell(11,5,'Unit',0,0,'C',0);
// $pdf->Cell(10,5,'Qty',0,1,'R',0);
// $pdf->SetWidths(array(38,11,10));
// $pdf->SetAligns(array('L','C','R'));
// //$pdf->Ln(2);
// $pdf->SetX(1);
// $pdf->Cell(2,2,"----------------------------------------------------------------",'0',0,'L',0);
// $pdf->Ln(2);


// //$pdf->Cell(50,6,"Qty Unit Item Name  Rate  Amount",'0',1,'L',0); 
// $total=0;
// $totqty = 0;
// $slno=1;

//     $sql_get = $obj->executequery("select * from view_bill_details  where kotid='$lastkotid' and foodtypeid='1'");
//     foreach($sql_get as $row_get)
//     {
//     $amount=0;
//     $productid=$row_get['productid'];
//     $qty=$row_get['qty'];
//     $unitid=$row_get['unitid'];
//     $cancel_remark = $row_get['cancel_remark'];
//     $is_cancelled_product = $row_get['is_cancelled_product'];
//     $prodname=$obj->getvalfield("m_product","prodname","productid='$productid'");
//     $unit_name=$obj->getvalfield("m_unit","unit_name","unitid='$unitid'"); 
//     $rate=$row_get['rate'];
//     $amount= number_format($qty * $rate,2);

//     if($is_cancelled_product==1)
//     {
//         $prodname .= '(Cencelled)';
//         $unit_name='X';
//         $qty='X'; 
//     }
    
    
//     $pdf->SetFont('Arial','',7);
//     $pdf->SetDash(0,0); //5mm on, 5mm off
//     $pdf->SetX(2);
//     //$pdf->Cell(50,5,"$qty $unit_name $prodname $rate $amount",'0',1,'L',0);  
//     $pdf->Row(array($prodname,$unit_name,$qty),1,1,'L',0); 

//     $totqty +=$qty;
//     }

// // $pdf->Ln(2);
// // $pdf->SetDash(1,1); //5mm on, 5mm off
// // $pdf->Line(3,60,62,60);
// $pdf->Ln(2);
// $pdf->SetFont('Arial','b',8);
// $pdf->SetX(5);
// $pdf->Cell(46,5,"Total Qty"."   ",'0',0,'R',0);
// $pdf->Cell(12,5,number_format($totqty,2),'1',0,'R',0);
// }
$pdf->Ln(5);


$pdf->SetX(2);

$pdf->Cell(50,5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ','0',0,'L',0);

$pdf->Ln(5);

$pdf->SetFont('Arial','',10);

$pdf->SetX(2);

$pdf->Cell(50,5,'Captain Name : '.$captain_name,'0',0,'L',0);

$pdf->Ln(4);
$pdf->SetX(2);

$pdf->Cell(50,5,'Steward Name : '.$steward_name,'0',0,'L',0);

$pdf->Ln(5);

$pdf->AutoPrint();
$pdf->Output();

$pdf->Ln(2);
// $pdf->SetDash(1,1); //5mm on, 5mm off
// $pdf->Line(3,60,62,60);
?>    

<?php
mysql_close($db_link);
?>