<?php
require_once 'function.php'; // File koneksi dan fungsi yang dibutuhkan
require 'vendor/autoload.php'; // Memuat PHPExcel

// use PHPExcel;
// use PHPExcel_IOFactory;

// Pastikan ada nilai yang diterima dari URL
if (isset($_GET['tanggal_awal'], $_GET['tanggal_akhir'], $_GET['jenis_kas'])) {
    $tanggal_awal = mysqli_real_escape_string($conn, $_GET['tanggal_awal']);
    $tanggal_akhir = mysqli_real_escape_string($conn, $_GET['tanggal_akhir']);
    $jenis_kas = mysqli_real_escape_string($conn, $_GET['jenis_kas']);

    // Menentukan query berdasarkan jenis kas
    if ($jenis_kas == 'rekapitulasi') {
        $query = "SELECT * FROM kas WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC";
    } else {
        $query = "SELECT * FROM kas WHERE jenis_kas = '$jenis_kas' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Membuat Spreadsheet baru
        $spreadsheet = new PHPExcel();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        // Menambahkan header ke sheet
        $sheet->setCellValue('A1', 'Rekapitulasi Kas');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2', 'Jl.Wibawamukti II, Kel Jatisari, Kec. Jatiasih kota Bekasi');
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getFont()->setItalic(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', "Periode $tanggal_awal sampai $tanggal_akhir");
        $sheet->mergeCells('A3:G3');
        $sheet->getStyle('A3')->getFont()->setItalic(true);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Menambahkan header kolom
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'No Kwitansi');
        $sheet->setCellValue('C5', 'Tanggal');
        $sheet->setCellValue('D5', 'Keterangan');
        $sheet->setCellValue('E5', 'Jenis Kas');
        $sheet->setCellValue('F5', 'Kas Masuk');
        $sheet->setCellValue('G5', 'Kas Keluar');

        // Iterasi hasil query dan output baris-baris data
        $no = 1;
        $total_masuk = 0;
        $total_keluar = 0;
        $rowNumber = 6; // Mulai dari baris ke-6
        while ($row = mysqli_fetch_assoc($result)) {
            $kas_masuk = $row['jenis_kas'] == 'masuk' ? $row['jumlah'] : 0;
            $kas_keluar = $row['jenis_kas'] == 'keluar' ? $row['jumlah'] : 0;
            $total_masuk += $kas_masuk;
            $total_keluar += $kas_keluar;

            $sheet->setCellValue('A' . $rowNumber, $no++);
            $sheet->setCellValue('B' . $rowNumber, $row['no_kwitansi']);
            $sheet->setCellValue('C' . $rowNumber, $row['tanggal']);
            $sheet->setCellValue('D' . $rowNumber, $row['keterangan']);
            $sheet->setCellValue('E' . $rowNumber, 'Kas ' . $row['jenis_kas']);
            $sheet->setCellValue('F' . $rowNumber, number_format($kas_masuk, 0, ',', '.'));
            $sheet->setCellValue('G' . $rowNumber, number_format($kas_keluar, 0, ',', '.'));
            $rowNumber++;
        }

        // Tampilkan total kas masuk atau keluar sesuai jenis_kas
        if ($jenis_kas == 'masuk' || $jenis_kas == 'rekapitulasi') {
            $sheet->setCellValue('F' . $rowNumber, 'Total Kas Masuk');
            $sheet->setCellValue('G' . $rowNumber, 'Rp. ' . number_format($total_masuk, 0, ',', '.'));
            $rowNumber++;
        }
        if ($jenis_kas == 'keluar' || $jenis_kas == 'rekapitulasi') {
            $sheet->setCellValue('F' . $rowNumber, 'Total Kas Keluar');
            $sheet->setCellValue('G' . $rowNumber, 'Rp. ' . number_format($total_keluar, 0, ',', '.'));
            $rowNumber++;
        }

        // Menambahkan footer
        $sheet->setCellValue('F' . ($rowNumber + 2), 'Bekasi, ' . date('Y-m-d'));
        $sheet->setCellValue('F' . ($rowNumber + 3), '_____________________');
        $sheet->setCellValue('F' . ($rowNumber + 4), 'DKM Al-Hidayah');

        // Mengatur properti header untuk pengunduhan file Excel
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rekapitulasi_kas_' . date('Ymd') . '.xls"');
        header('Cache-Control: max-age=0');

        // Menulis file Excel ke output
        $writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel5');
        $writer->save('php://output');

        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: Data not complete";
}
?>
