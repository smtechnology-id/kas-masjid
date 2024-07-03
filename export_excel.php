<?php
require 'function.php'; // File koneksi dan fungsi yang dibutuhkan

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
        // Set header untuk file Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=rekapitulasi_kas_" . date('Ymd') . ".xls");
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Rekapitulasi Kas</title>
            <style>
                /* Desain CSS untuk tabel */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f2f2f2;
                }
                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                    background-color: #fff;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .judul {
                    font-size: 24px;
                    font-weight: bold;
                    text-align: center;
                    margin-bottom: 20px;
                }
                .tanggal {
                    text-align: center;
                    margin-bottom: 10px;
                }
                .total-kas {
                    margin-top: 20px;
                    text-align: right;
                }
                .footer {
                    margin-top: 20px;
                    text-align: right;
                }
                .footer-text {
                    font-style: italic;
                }
                .btn {
                    display: inline-block;
                    padding: 8px 16px;
                    font-size: 14px;
                    text-decoration: none;
                    background-color: #007bff;
                    color: #fff;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
                .btn:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="judul">Rekapitulasi Kas</div>
                <div class="tanggal">Periode <?= $tanggal_awal ?> sampai <?= $tanggal_akhir ?></div>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Kwitansi</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jenis Kas</th>
                            <th>Kas Masuk</th>
                            <th>Kas Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
        // Iterasi hasil query dan output baris-baris data
        $no = 1;
        $total_masuk = 0;
        $total_keluar = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $kas_masuk = $row['jenis_kas'] == 'masuk' ? $row['jumlah'] : 0;
            $kas_keluar = $row['jenis_kas'] == 'keluar' ? $row['jumlah'] : 0;
            $total_masuk += $kas_masuk;
            $total_keluar += $kas_keluar;
?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['no_kwitansi'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['keterangan'] ?></td>
                            <td><?= "Kas " . $row['jenis_kas'] ?></td>
                            <td><?= number_format($kas_masuk, 0, ',', '.') ?></td>
                            <td><?= number_format($kas_keluar, 0, ',', '.') ?></td>
                        </tr>
<?php
        }
?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="float-end mt-3 mt-sm-0">
<?php
        // Tampilkan total kas masuk atau keluar sesuai jenis_kas
        if ($jenis_kas == 'masuk' || $jenis_kas == 'rekapitulasi') {
?>
                            <h4 class="total-kas">Total Kas Masuk: <?= 'Rp. ' . number_format($total_masuk, 0, ',', '.') ?></h4>
<?php
        }
        if ($jenis_kas == 'keluar' || $jenis_kas == 'rekapitulasi') {
?>
                            <h4 class="total-kas">Total Kas Keluar: <?= 'Rp. ' . number_format($total_keluar, 0, ',', '.') ?></h4>
<?php
        }
?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <p class="footer-text">Bekasi, <?= date('Y-m-d') ?></p>
                    <p class="footer-text">_____________________</p>
                    <p class="footer-text">DKM Al-Hidayah</p>
                </div>
                <div class="text-center">
                    <a href="javascript:window.print()" class="btn"><i class="ri-printer-line"></i> Print</a>
                    <a href="export_excel.php?tanggal_awal=<?= urlencode($_GET['tanggal_awal']) ?>&tanggal_akhir=<?= urlencode($_GET['tanggal_akhir']) ?>&jenis_kas=<?= urlencode($_GET['jenis_kas']) ?>" class="btn"><i class="bi bi-file-earmark-excel"></i> Export to Excel</a>
                </div>
            </div>
        </body>
        </html>
<?php
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: Data not complete";
}
?>
