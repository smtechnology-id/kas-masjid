<?php
require 'top.php';
if (isset($_POST['export_excel'])) {
    // Redirect to export_excel.php with POST data
?>
    <form id="export_form" action="export_excel.php" method="post">
        <input type="hidden" name="tanggal_awal" value="<?php echo $_POST['tanggal_awal']; ?>">
        <input type="hidden" name="tanggal_akhir" value="<?php echo $_POST['tanggal_akhir']; ?>">
        <input type="hidden" name="jenis_kas" value="<?php echo $_POST['jenis_kas']; ?>">
    </form>
    <script>
        document.getElementById("export_form").submit();
    </script>
<?php
    exit();
}
?>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Invoice Logo-->
                            <div class="clearfix">
                                <div class="float-start mb-3">
                                    <img src="assets/images/logo1.jpg" alt="dark logo" height="300px">
                                    <br>jl.Wibawamukti II, Kel Jatisari
                                    <br>Kec. Jatiasih kota Bekasi
                                </div>
                                <div class="float-end">
                                    <h4 class="m-0 d-print-none">Laporan</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
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
                                                // Inisialisasi variabel untuk filter
                                                if (isset($_POST['cetak_rekap'])) {
                                                    $tanggal_awal = mysqli_real_escape_string($conn, $_POST['tanggal_awal']);
                                                    $tanggal_akhir = mysqli_real_escape_string($conn, $_POST['tanggal_akhir']);
                                                    $jenis_kas = mysqli_real_escape_string($conn, $_POST['jenis_kas']);

                                                    // Menentukan query berdasarkan jenis kas
                                                    if ($jenis_kas == 'rekapitulasi') {
                                                        $query = "SELECT * FROM kas WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC";
                                                    } else {
                                                        $query = "SELECT * FROM kas WHERE jenis_kas = '$jenis_kas' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ORDER BY tanggal ASC";
                                                    }

                                                    $fetch = mysqli_query($conn, $query);
                                                    $no = 1;

                                                    while ($result = mysqli_fetch_array($fetch)) {
                                                ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $result['no_kwitansi'] ?></td>
                                                            <td><?= $result['tanggal'] ?></td>
                                                            <td><?= $result['keterangan'] ?></td>
                                                            <td>Kas <?= $result['jenis_kas'] ?></td>
                                                            <td><span class="text-primary">
                                                                    <?php
                                                                    if ($result['jenis_kas'] == 'masuk') {
                                                                        echo 'Rp. ' . number_format($result['jumlah'], 3, '.', '.');
                                                                    } else {
                                                                        echo '0';
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td><span class="text-danger">
                                                                    <?php
                                                                    if ($result['jenis_kas'] == 'keluar') {
                                                                        echo 'Rp. ' . number_format($result['jumlah'], 3, '.', '.');
                                                                    } else {
                                                                        echo '0';
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive-->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="clearfix pt-3">
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-sm-6">
                                    <div class="float-end mt-3 mt-sm-0 me-2">
                                        <?php
                                        if (isset($_POST['cetak_rekap'])) {
                                            $tanggal_awal = mysqli_real_escape_string($conn, $_POST['tanggal_awal']);
                                            $tanggal_akhir = mysqli_real_escape_string($conn, $_POST['tanggal_akhir']);
                                            $jenis_kas = mysqli_real_escape_string($conn, $_POST['jenis_kas']);

                                            if ($jenis_kas == 'rekapitulasi' || $jenis_kas == 'masuk') {
                                                $queryjumlahmasuk = mysqli_query($conn, "SELECT SUM(jumlah) AS total_kas_masuk FROM kas WHERE jenis_kas = 'masuk' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                                                if ($queryjumlahmasuk) {
                                                    $row_masuk = mysqli_fetch_assoc($queryjumlahmasuk);
                                                    $total_kas_masuk = $row_masuk['total_kas_masuk'];
                                        ?>
                                                    <h3 class="text-primary">Total Kas Masuk = <?= 'Rp. ' . number_format($total_kas_masuk, 3, '.', '.') ?></h3>
                                                <?php
                                                } else {
                                                    echo "Error: " . mysqli_error($conn);
                                                }
                                            }

                                            if ($jenis_kas == 'rekapitulasi' || $jenis_kas == 'keluar') {
                                                $queryjumlahkeluar = mysqli_query($conn, "SELECT SUM(jumlah) AS total_kas_keluar FROM kas WHERE jenis_kas = 'keluar' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'");
                                                if ($queryjumlahkeluar) {
                                                    $row_keluar = mysqli_fetch_assoc($queryjumlahkeluar);
                                                    $total_kas_keluar = $row_keluar['total_kas_keluar'];
                                                ?>
                                                    <h3 class="text-danger">Total Kas Keluar = <?= 'Rp. ' . number_format($total_kas_keluar, 3, '.', '.') ?></h3>
                                        <?php
                                                } else {
                                                    echo "Error: " . mysqli_error($conn);
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>
                                    <div class="float-end">
                                        <h4 class="m-0 d-print-none"></h4>
                                        <br>
                                        Bekasi, <?= date('Y-m-d') ?><br>
                                        <br>
                                        <br>
                                        _____________________
                                        <br>
                                        DKM Al-Hidayah
                                    </div>
                                </div>
                                <!-- end row-->

                                <div class="d-print-none mt-4">
                                    <div class="text-center">
                                        <a href="javascript:window.print()" class="btn btn-primary"><i class="ri-printer-line"></i> Print</a>
                                        <a href="export_excel.php?tanggal_awal=<?php echo urlencode($_POST['tanggal_awal']); ?>&tanggal_akhir=<?php echo urlencode($_POST['tanggal_akhir']); ?>&jenis_kas=<?php echo urlencode($_POST['jenis_kas']); ?>" class="btn btn-primary"><i class="bi bi-file-earmark-excel"></i> Export to Excel</a>
                                        <a href="export_word.php?tanggal_awal=<?php echo urlencode($_POST['tanggal_awal']); ?>&tanggal_akhir=<?php echo urlencode($_POST['tanggal_akhir']); ?>&jenis_kas=<?php echo urlencode($_POST['jenis_kas']); ?>" class="btn btn-primary"><i class="bi bi-file-earmark-word"></i> Export to Word</a>
                                        </div>
                                </div>
                                <!-- end buttons -->

                            </div> <!-- end card-body-->
                        </div> <!-- end card -->

                    </div> <!-- end col-->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                </div>
            </div>
        </footer>
        <!-- end Footer -->

    </div>
    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                    <script>
                        document.write(new Date().getFullYear())
                    </script>© Al-Hidayah
                </div>
            </div>
        </div>
    </footer>

    <!-- end Footer -->

    <?php
    require 'bottom.php';
    ?>