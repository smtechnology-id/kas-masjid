<?php
require 'top.php';
?>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
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
                    </script> © Al-Hidayah
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>


<?php
require 'bottom.php';
?>