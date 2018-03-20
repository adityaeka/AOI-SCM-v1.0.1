<?php
require('../fpdf.php');
/*
class PDF extends FPDF
{
// Page header
/*function Header()
{
	// Logo
	$this->Image('logo.jpg',11,15,40);
	$this->SetFont('Arial','B',15);
	$this->Cell(0,10,'PT. APPAREL ONE INDONESIA',0,0,'C');
	$this->SetFont('Arial','',10);
	$this->Ln(6);
	$this->Cell(0,10,'JL. TUGU WIJAYA IV, KAWASAN WIJAYAKUSUMA, TUGU',0,0,'C');
	$this->Ln(6);
	$this->Cell(0,10,'SEMARANG 50153, INDONESIA',0,0,'C');
	$this->Ln(6);
	//$this->Cell(90,10,'PHONE : 021-0293023029',0,0,'R');
	//$this->Cell(90,10,'PHONE : 021-0293023029',0,0,'L');
	
	$this->Ln(20);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}*/

// Instanciation of inherited class
$pdf = new FPDF();
$pdf->AliasNbPages();
//$pdf->SetMargins(1,1,1,1);
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,6,'PT. APPAREL ONE INDONESIA',0,1,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,'JL. TUGU WIJAYA IV, KAW. INDUSTRI WIJAYAKUSUMA, TUGU',0,1,'C');
$pdf->Cell(0,6,'SEMARANG 50153 INDONESIA',0,1,'C');
$pdf->Cell(0,6,'PHONE +62-24866-4428    FAX. +62-24866-4483',0,1,'C');
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,6,'Purchase Order [PO]',0,1,'C');
$pdf->Ln();
$pdf->Cell(90,10,'POAO012093/E1203',1,1,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,':: DRAFT ONLY ::',0,1,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Ln();
$pdf->Cell(40,10,'POAO012093/E1203adadasasas',1,0,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Cell(40,10,'POAO012093/E1203',1,0,'C');
$pdf->Output();
?>
