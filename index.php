<?php
require_once 'function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sistem Pengelolaan Kas - Masjid Attaqwa Muhammadiyah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />
    <meta content="Techzaa" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="assets/vendor/daterangepicker/daterangepicker.css">

    <!-- Vector Map css -->
    <link rel="stylesheet" href="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

    <!-- Begin page -->
    <div class="wrapper">


        <div class="container-fluid">

            <div class="content">

                <!-- Start Content-->
                <div class="card">
                    <div class="card-body" style="min-height: 100vh; padding-bottom:20px">
                        <div class="container-fluid">
                            <div class="container-login d-flex align-items-center justify-content-end" style="">
                                <a href="login.php" class="btn btn-primary">Login</a>
                            </div>
                            <div class="row my-3">
                                <div class="col-xxl-4 col-sm-6">
                                    <div class="card widget-flat text-bg-primary">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="ri-arrow-left-up-line widget-icon"></i>
                                            </div>
                                            <h6 class="text-uppercase mt-0" title="Customers">Kas Masuk</h6>
                                            <h2 class="my-2">
                                                <?php
                                                // Query untuk menghitung total kas masuk
                                                $queryjumlahmasuk = mysqli_query($conn, "SELECT SUM(jumlah) AS total_kas_masuk FROM kas WHERE jenis_kas = 'masuk'");

                                                if ($queryjumlahmasuk) {
                                                    $row_masuk = mysqli_fetch_assoc($queryjumlahmasuk);
                                                    $total_kas_masuk = $row_masuk['total_kas_masuk'];
                                                    // Memformat total kas masuk menjadi format mata uang Rupiah
                                                    echo $formatted_total_kas_masuk = 'Rp. ' . number_format($total_kas_masuk, 3, '.', '.');
                                                } else {
                                                    echo "Error: " . mysqli_error($conn);
                                                }

                                                // Menutup koneksi database
                                                ?>

                                            </h2>
                                            <p class="mb-0">
                                                <span class="text-nowrap">Total Balance</span>
                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-xxl-4 col-sm-6">
                                    <div class="card widget-flat text-bg-danger">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="ri-arrow-right-up-line widget-icon"></i>
                                            </div>
                                            <h6 class="text-uppercase mt-0" title="Customers">Kas Keluar</h6>
                                            <h2 class="my-2">
                                                <?php
                                                // Query untuk menghitung total kas masuk
                                                $queryjumlahkeluar = mysqli_query($conn, "SELECT SUM(jumlah) AS total_kas_keluar FROM kas WHERE jenis_kas = 'keluar'");

                                                if ($queryjumlahkeluar) {
                                                    $row_keluar = mysqli_fetch_assoc($queryjumlahkeluar);
                                                    $total_kas_keluar = $row_keluar['total_kas_keluar'];
                                                    // Memformat total kas keluar menjadi format mata uang Rupiah
                                                    $formatted_total_kas_keluar = 'Rp. ' . number_format($total_kas_keluar, 3, '.', '.');
                                                    echo "<h2 class='my-2'>$formatted_total_kas_keluar</h2>";
                                                } else {
                                                    echo "Error: " . mysqli_error($conn);
                                                }

                                                ?></h2>
                                            <p class="mb-0">
                                                <span class="text-nowrap">Total Balance</span>
                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end col-->
                                <div class="col-xxl-4 col-sm-6">
                                    <div class="card widget-flat text-bg-success">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="ri-wallet-fill widget-icon"></i>
                                            </div>
                                            <h6 class="text-uppercase mt-0" title="Customers">Total Saldo</h6>
                                            <h2 class="my-2">
                                                <?php
                                                // Query untuk menghitung total kas masuk
                                                $saldo = $total_kas_masuk - $total_kas_keluar;

                                                // Memformat saldo menjadi format mata uang Rupiah
                                                echo $formatted_saldo = 'Rp. ' . number_format($saldo, 3, '.', '.');


                                                ?>
                                            </h2>
                                            <p class="mb-0">
                                                <?php if ($saldo >= 0) : ?>

                                                    <span class="badge bg-white bg-opacity-10 me-1">Saldo Balance</span>
                                                <?php else : ?>
                                                    <span class="badge bg-white bg-opacity-10 me-1">Saldo Anda Negatif</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div> <!-- end col-->
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-4">
                                                <img src="assets/images/bg.jpg" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h2 class="card-title">Selamat Datang di Sistem Kas Masjid Al-Hidayah</h2>
                                                    <p class="card-text">jl.Wibawamukti II, Kel Jatisari Kec. Jatiasih kota Bekasi</p>
                                                    <p class="card-text">Info lebih lanjut : 085156722608 (Ustad Tawan)</p>
                                                    <p class="d-flex flex-row align-items-center" style="font-size: 1rem;"><i class="ri-instagram-fill" style="font-size: 2rem;"></i> Instagram Kami</p>
                                                </div> <!-- end card-body -->
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container -->

            </div>
            <!-- content -->
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
            <!-- Footer Start -->
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        

    </div>
    <!-- END wrapper -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- Daterangepicker js -->
    <script src="assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- Apex Charts js -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Vector Map js -->
    <script src="assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Dashboard App js -->
    <script src="assets/js/pages/dashboard.js"></script>


    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    

</body>

</html>