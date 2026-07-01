<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

require_once '../libs/fpdf.php';
include_once '../controller/BarangController.php';

class PDF_Laporan extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', '15');
        $this->SetTextColor(27, 94, 32); 
        $this->Cell(0, 10, 'LAPORAN DATA ASET BARANG MAINAN', 0, 1, 'C');
        
        $this->SetFont('Arial', 'I', '10');
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 5, 'Sistem Informasi Manajemen Aset - Universitas Pamulang', 0, 1, 'C');
        $this->SetDrawColor(46, 125, 50);
        $this->SetLineWidth(1);
        $this->Line(10, 30, 200, 30);
        $this->Ln(12);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$controller = new BarangController();
$dataBarang = $controller->index();
$pdf = new PDF_Laporan('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(46, 125, 50);
$pdf->SetTextColor(255, 255, 255); 
$pdf->SetDrawColor(150, 150, 150); 
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Kode Barang', 1, 0, 'C', true);
$pdf->Cell(65, 8, 'Nama Mainan', 1, 0, 'L', true);
$pdf->Cell(35, 8, 'Kategori', 1, 0, 'C', true);
$pdf->Cell(15, 8, 'Stok', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Harga Aset', 1, 1, 'R', true); 


$pdf->SetTextColor(0, 0, 0); 
$pdf->SetFont('Arial', '', 10);

$no = 1;
$fill = false;

while ($row = $dataBarang->fetch_assoc()) {
    if ($fill) {
        $pdf->SetFillColor(232, 245, 233); 
    } else {
        $pdf->SetFillColor(255, 255, 255);
    }
    
    $pdf->Cell(10, 8, $no++, 1, 0, 'C', true);
    $pdf->Cell(30, 8, $row['kode_barang'], 1, 0, 'C', true);
    $pdf->Cell(65, 8, ' ' . $row['nama_mainan'], 1, 0, 'L', true);
    $pdf->Cell(35, 8, $row['kategori'], 1, 0, 'C', true);
    $pdf->Cell(15, 8, $row['stok'], 1, 0, 'C', true);
    $pdf->Cell(35, 8, 'Rp ' . number_format($row['harga'], 0, ',', '.'), 1, 1, 'R', true);
    
    $fill = !$fill; 
}

$pdf->Output('I', 'Laporan_Aset_Mainan.pdf');
?>