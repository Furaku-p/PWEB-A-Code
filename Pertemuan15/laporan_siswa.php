<?php
ob_start();

require __DIR__ . '/config.php';
require __DIR__ . '/fpdf/fpdf.php';

$query = mysqli_query($connect, "SELECT * FROM mahasiswa");
if (!$query) {
    ob_end_clean();
    die("Query gagal: " . mysqli_error($connect));
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 7, 'SEKOLAH MENENGAH KEJURUSAN NEGERI 2 LANGSA', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 7, 'DAFTAR SISWA KELAS IX JURUSAN REKAYASA PERANGKAT LUNAK', 0, 1, 'C');

$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'NIM', 1, 0, 'C');
$pdf->Cell(60, 10, 'NAMA MAHASISWA', 1, 0, 'C');
$pdf->Cell(40, 10, 'NO HP', 1, 0, 'C');
$pdf->Cell(40, 10, 'TANGGAL LHR', 1, 1, 'C');

$pdf->SetFont('Arial', '', 11);

while ($row = mysqli_fetch_assoc($query)) {
    $pdf->Cell(40, 10, $row['nim'], 1, 0, 'C');
    $pdf->Cell(60, 10, $row['nama_lengkap'], 1, 0);
    $pdf->Cell(40, 10, $row['no_hp'], 1, 0, 'C');
    $pdf->Cell(40, 10, $row['tanggal_lahir'], 1, 1, 'C');
}

ob_end_clean();
$pdf->Output('I', 'laporan_siswa.pdf');
