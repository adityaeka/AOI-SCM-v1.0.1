<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require($root.'/fpdf/fpdf.php');
$this->db->where('no_packinglist','19642229');
$this->db->where('kst_invoicevendor','19642229');
$a = $this->db->get('po_detail');

$pdf = new FPDF('L','mm',array(110,80));
$pdf->SetMargins(3,3,3,3);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
foreach($a->result() as $b){
	$pdf->AddPage();
	$pdf->Rect(1,1,108,78);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,8, "BARCODE SYSTEM AOI", 0,1,'C');
	$pdf->Cell(0,8, "NO PACKAGE : 12", 1,1,'C');
	$pdf->Cell(0,8, $b->item, 1,1,'C');
	$pdf->Cell(52,8, 'ORDER : '.number_format($b->qtyentered,2), 1,0,'C');
	$pdf->Cell(52,8, 'DLVRD : '.number_format($b->qty_upload,2).' '.$b->uomsymbol, 1,1,'C');
	$pdf->MultiCell(44,6,$b->desc_product, 1,'C');
	$pdf->Cell(44,9, trim($b->documentno), 1,1,'C');
	$pdf->MultiCell(44,6,trim($b->supplier), 1,'C');
	$pdf->Cell(44,10, 'PL : '.$b->no_packinglist, 1,1,'C');
	$pdf->SetXY(47,35);
	$pdf->Cell(60,33, "4", 1,1,'C');
	$pdf->SetX(47);
	$pdf->Cell(60,10, $b->pobuyer, 1,1,'L');
}
$pdf->Output();
?>