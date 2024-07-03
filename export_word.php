<?php
// Include the database connection function
include 'function.php';

// Check if the connection to database is successful
$conn = getConnection();
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Function to fetch data from the database
function fetchDataFromDatabase($conn, $tanggal_awal, $tanggal_akhir, $jenis_kas) {
    $tanggal_awal = mysqli_real_escape_string($conn, $tanggal_awal);
    $tanggal_akhir = mysqli_real_escape_string($conn, $tanggal_akhir);
    $jenis_kas = mysqli_real_escape_string($conn, $jenis_kas);

    // Query based on the type of financial record
    if ($jenis_kas == 'rekapitulasi') {
        $sql = "SELECT * FROM kas WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC";
    } else {
        $sql = "SELECT * FROM kas WHERE jenis_kas = '$jenis_kas' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC";
    }

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return false;
    }
}

// Fetching data from URL parameters
$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';
$jenis_kas = $_GET['jenis_kas'] ?? '';

// Ensure all required parameters are provided
if (empty($tanggal_awal) || empty($tanggal_akhir) || empty($jenis_kas)) {
    die("Parameter tanggal_awal, tanggal_akhir, atau jenis_kas tidak lengkap.");
}

// Fetch data from database
$result = fetchDataFromDatabase($conn, $tanggal_awal, $tanggal_akhir, $jenis_kas);

// Stop execution if no data found
if (!$result) {
    die("Tidak ada data yang ditemukan.");
}

// Calculate total masuk and keluar
$total_masuk = 0;
$total_keluar = 0;

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['jenis_kas'] == 'masuk' || $jenis_kas == 'rekapitulasi') {
        $total_masuk += $row['jumlah'];
    }
    if ($row['jenis_kas'] == 'keluar' || $jenis_kas == 'rekapitulasi') {
        $total_keluar += $row['jumlah'];
    }
}

// Using PHPWord library
require 'vendor/autoload.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;

// Initialize PHPWord object
$phpWord = new PhpOffice\PhpWord\PhpWord();

// Adding a new section
$section = $phpWord->addSection(array(
    'marginTop' => 600,
    'marginBottom' => 600,
    'marginLeft' => 600,
    'marginRight' => 600
));

// Add header
$header = $section->addHeader();
$table = $header->addTable();
$table->addRow();
$cell = $table->addCell(4500);
$cell->addText("Sistem Pengelolaan Kas - Masjid Al-Hidayah", array('bold' => true));
$cell = $table->addCell(4500);
$cell->addText(date('Y-m-d H:i A'), array('bold' => true), array('alignment' => 'right'));

// Add logo
$section->addImage('assets/images/logo1.jpg', array('width' => 100, 'height' => 100, 'alignment' => 'center'));

// Document title
$section->addText('Rekapitulasi Kas', array('size' => 16, 'bold' => true), array('alignment' => 'center'));

// Address
$section->addText('Jl.Wibawamukti II, Kel Jatisari, Kec. Jatiasih kota Bekasi', array('italic' => true), array('alignment' => 'center'));

// Period
$section->addText("Periode $tanggal_awal sampai $tanggal_akhir", array('italic' => true), array('alignment' => 'center'));

// Table for financial records
$table = $section->addTable(array('alignment' => 'center'));
$table->addRow();
$table->addCell(1000)->addText('No');
$table->addCell(2000)->addText('No Kwitansi');
$table->addCell(2000)->addText('Tanggal');
$table->addCell(3000)->addText('Keterangan');
$table->addCell(2000)->addText('Jenis Kas');
$table->addCell(2000)->addText('Kas Masuk');
$table->addCell(2000)->addText('Kas Keluar');

$no = 1;
mysqli_data_seek($result, 0); // Reset result pointer to start from beginning
while ($row = mysqli_fetch_assoc($result)) {
    $table->addRow();
    $table->addCell(1000)->addText($no++);
    $table->addCell(2000)->addText($row['no_kwitansi']);
    $table->addCell(2000)->addText($row['tanggal']);
    $table->addCell(3000)->addText($row['keterangan']);
    $table->addCell(2000)->addText('Kas ' . $row['jenis_kas']);
    $table->addCell(2000)->addText($row['jenis_kas'] == 'masuk' ? 'Rp. ' . number_format($row['jumlah'], 0, ',', '.') : '0');
    $table->addCell(2000)->addText($row['jenis_kas'] == 'keluar' ? 'Rp. ' . number_format($row['jumlah'], 0, ',', '.') : '0');
}

// Display total kas masuk or keluar based on jenis_kas
if ($jenis_kas == 'masuk' || $jenis_kas == 'rekapitulasi') {
    $section->addText('Total Kas Masuk = Rp. ' . number_format($total_masuk, 0, ',', '.'), array('bold' => true, 'color' => '0070C0'));
}
if ($jenis_kas == 'keluar' || $jenis_kas == 'rekapitulasi') {
    $section->addText('Total Kas Keluar = Rp. ' . number_format($total_keluar, 0, ',', '.'), array('bold' => true, 'color' => 'FF0000'));
}

// Add footer below table
$section->addText('Bekasi, ' . date('Y-m-d'), array('italic' => true), array('alignment' => Jc::RIGHT));
$section->addText('_____________________', array(), array('alignment' => Jc::RIGHT));
$section->addText('DKM Al-Hidayah', array(), array('alignment' => Jc::RIGHT));

// Save the Word document temporarily
$tempFile = tempnam(sys_get_temp_dir(), 'Rekapitulasi_Kas_');
$phpWord->save($tempFile);

// Send the document to the browser for download
header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
header("Content-Disposition: attachment; filename=rekapitulasi_kas.docx");
readfile($tempFile);

// Delete the temporary file after download
unlink($tempFile);

// Close the database connection
mysqli_close($conn);
?>
