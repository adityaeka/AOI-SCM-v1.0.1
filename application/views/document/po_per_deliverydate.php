<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require($root.'/fpdf/fpdf.php');
require($root.'/fpdf/convert.php');
require($root.'/fpdf/add_class.php');

$header = $this->db2->where('c_order_id',$_GET['id'])->get('f_print_header_pobuyer')->result()[0];
$item = $this->db2->where('c_order_id',$_GET['id'])->get('f_print_detail_deliverydate')->result();

$pdf = new FPDF_();
$num = new NumbersToWords();
$pdf->add_dataheader($header);
$pdf->SetMargins(10,10,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetWidths(array(25,33,58,15,15,20,22));
$pdf->SetAligns(array('C','C','L','C','C','C','C'));
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
		$pdf->Row(
		array(
				'REQUEST ARRIVAL DATE',
				'ITEMCODE',
				'PRODUCT CODE',
				'UOM',
				'QTY',
				'AMOUNT',
				'TOTAL'
		)
	);

	}
	//menentukan angka dibelakang koma
	if($item->iso_code == 'IDR')
		$c = 2;
	else
		$c = 4;
	
	$pdf->SetFont('Arial','',8);
	$pdf->Row(
		array(
			(($item->datepromised == NULL) ? '' : date("d/m/Y",strtotime($item->datepromised))),
			$item->itemcode,
			$item->name."\n".$item->productdescription,
			$item->uom,
			number_format($item->qtyentered,0),
			number_format($item->hargasatuan,$c),
			number_format($item->total,$c)
		)
	);
	$page = $pdf->PageNo();
	$qty += $item->qtyentered;
	$total += $item->total;
}
$pdf->Cell(116,6,'TOTAL',1,0,'L');
$pdf->Cell(30,6,number_format($qty,0),1,0,'R');
$pdf->Cell(42,6,number_format($total,$c),1,1,'R');

$total = number_format($total,2,'.','');
$total2 = explode('.',$total);
$total2 = $total2[1];

$pdf->Cell(188,6,$item->iso_code.' '.$num->convert($total).(($total2 != 0) ? ', '.$total2.'/100' : ''),1,1,'L');
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
$pdf->Cell(30,6,'STYLE',0,0,'L');	
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(160, 6, $header->so, 0,'L',0,1);
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