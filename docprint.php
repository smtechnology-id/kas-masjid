<?php
require 'top.php';
?>
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <!-- end page title -->

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

                            <!-- Invoice Detail-->
                            <!-- end row -->

                            <div class="row mt-4">
                                <div class="col-6">
                                    <h6 class="fs-14">Billing Address</h6>
                                    <address>
                                        <?php
                                        if (isset($_POST['search'])) {
                                            $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
                                            $jenis_kas = mysqli_real_escape_string($conn, $_POST['jenis_kas']);

                                            // Query dengan filter tanggal dan jenis_kas
                                        }
                                        ?>
                                        Jenis Laporan : Laporan <?= $jenis_kas ?><br>
                                        Tanggal : <?= $tanggal ?><br>
                                    </address>
                                </div> <!-- end col-->

                            </div>
                            <!-- end row -->

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
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            // Inisialisasi variabel untuk filter
                                            $tanggal = "";
                                            $jenis_kas = "";

                                            if (isset($_POST['search'])) {
                                                $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
                                                $jenis_kas = mysqli_real_escape_string($conn, $_POST['jenis_kas']);

                                                // Query dengan filter tanggal dan jenis_kas
                                                $sql = mysqli_query($conn, "SELECT * FROM kas WHERE jenis_kas = '$jenis_kas' AND tanggal = '$tanggal' ORDER BY id_kas DESC");
                                            } else {
                                                // Query default tanpa filter
                                                $sql = mysqli_query($conn, "SELECT * FROM kas WHERE jenis_kas = 'masuk' ORDER BY id_kas DESC");
                                            }
                                            ?>

                                            <tbody>
                                                <?php
                                                $no = 1;
                                                while ($row = mysqli_fetch_array($sql)) {
                                                ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= $row['no_kwitansi'] ?></td>
                                                        <td><?= $row['tanggal'] ?></td>
                                                        <td><?= $row['keterangan'] ?></td>
                                                        <td><?= 'Rp. ' . number_format($row['jumlah'], 3, '.', '.') ?></td>

                                                    </tr>
                                                <?php
                                                    $no++;
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
                                    <div class="float-end mt-3 mt-sm-0">
                                        <?php

                                        if (isset($_POST['search'])) {
                                            $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
                                            $jenis_kas = mysqli_real_escape_string($conn, $_POST['jenis_kas']);

                                            // Query dengan filter tanggal dan jenis_kas
                                            $query = "SELECT * FROM kas WHERE jenis_kas = '$jenis_kas' AND tanggal = '$tanggal' ORDER BY id_kas DESC";
                                        }

                                        $sql = mysqli_query($conn, $query);

                                        // Inisialisasi total jumlah
                                        $total_jumlah = 0;

                                        while ($row = mysqli_fetch_array($sql)) {
                                            $total_jumlah += $row['jumlah'];
                                            $data[] = $row; // Simpan hasil query untuk digunakan dalam tabel
                                        }
                                        ?>
                                        <h3 class="me-3"><?= 'Rp. ' . number_format($total_jumlah, 3, '.', '.')?> </h3>
                                    </div>
                                <div class="clearfix"></div>
                                    <div class="float-end">
                                    <h4 class="m-0 d-print-none"></h4>
                                    <br>
                                    <br>
                                    Bekasi, <?= $tanggal ?><br>
                                    <br>
                                    <br>
                                    <br>
                                    _____________________
                                    <br>
                                    DKM Al-Hidayah
                                </div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end row-->

                            <div class="d-print-none mt-4">
                                <div class="text-center">
                                    <a href="javascript:window.print()" class="btn btn-primary"><i class="ri-printer-line"></i> Print</a>
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