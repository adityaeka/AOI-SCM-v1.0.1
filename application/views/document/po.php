<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require($root.'/fpdf/fpdf.php');
require($root.'/fpdf/add_class.php');

$header = $this->db2->where('c_order_id',$_GET['id'])->get('f_print_header_pobuyer')->result()[0];

$item = $this->db2->order_by('poreference','ASC')->where('c_order_id',$_GET['id'])->get('f_print_detail_pobuyer')->result();

$pdf = new FPDF_();
$pdf->add_dataheader($header);
$pdf->SetMargins(10,10,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetWidths(array(20,33,40,15,15,20,20,25));
$pdf->SetAligns(array('C','C','L','C','R','R','R','C'));
$pdf->SetFont('Arial','',7);
$qty = 0;
$total = 0;
$page = 0;
foreach($item as $item){
	//ganti halaman baru ketika posisi sekarang > 20cm
	if($pdf->GetY() > 230){
		$pdf->AddPage();
	}
	//header table
	if($page != $pdf->PageNo()){
		$pdf->SetFont('Arial','B',8);
        $pdf->Cell(20,6,'PO BUYER',1,0,'C');
        $pdf->Cell(33,6,'ITEM CODE',1,0,'C');
        $pdf->Cell(40,6,'PRODUCT CODE',1,0,'L');
        $pdf->Cell(15,6,'UOM',1,0,'C');
        $pdf->Cell(15,6,'QTY',1,0,'C');
        $pdf->Cell(20,6,'AMOUNT',1,0,'C');
        $pdf->Cell(20,6,'TOTAL',1,0,'C');
        $pdf->Cell(25,6,'RECEIVED DATE',1,1,'C');
	}
	//menentukan angka dibelakang koma
	if($item->iso_code == 'IDR')
		$c = 2;
	else
		$c = 4;
	
	$pdf->SetFont('Arial','',8);
	$pdf->Row(
		array(
			$item->poreference,
			$item->itemcode,
			$item->name."\n".$item->productdescription,
			$item->uom,
			number_format($item->qtyentered,0),
			number_format($item->hargasatuan,$c),
			number_format($item->total,$c),
			(($item->datepromised == NULL) ? '' : date("d/m/Y",strtotime($item->datepromised)))
		)
	);
	$page = $pdf->PageNo();
	$qty += $item->qtyentered;
	$total += $item->total;
}
$pdf->Cell(108,6,'TOTAL',1,0,'L');
$pdf->Cell(15,6,number_format($qty,0),1,0,'R');
$pdf->Cell(40,6,number_format($total,$c),1,0,'R');
$pdf->Cell(25,6,'',1,1,'R');

//$total = number_format($total,2,'.','');
//$total2 = explode('.',$total);
//$total2 = $total2[1];

$pdf->Cell(188,6,$item->iso_code.' '.$this->Addons->GetText($total),1,1,'L');
$pdf->Cell(188,6,'Currency Rate = '.$header->rate,0,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,6,'PAYMENT TERM',0,0,'L');	
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,$header->paymentterm, 0,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,6,'NOTE',0,0,'L');	
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(80,6, $header->onote, 0,'L',0,1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,6,'STYLE',0,0,'L');	
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(60, 6, $header->so, 0,'L',0,1);
$pdf->SetFont('Arial','B',8); 
$pdf->Cell(0,6,"***Please note we need your confirmation within 24 Hours of receiving this PO***",0,1,'l');
$pdf->SetFont('Arial','',8);
if($pdf->GetY() > 230){
	$pdf->AddPage();
}
$pdf->SetX(120);
$pdf->MultiCell(60, 4, "FOR AND ON BEHALF OF\nPT. APPAREL ONE INDONESIA\n\n\n\n\n", 'B','L',0,1);
$pdf->SetX(120);
$pdf->Cell(20,6,'DATE',0,0,'L');	
$pdf->Code128(11,$pdf->GetY()-20,$header->docno,80,15);
$pdf->Output('Purchase Order - '.str_replace('/','_',	$header->docno).'.pdf','D');
?>