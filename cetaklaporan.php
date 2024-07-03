<?php
require 'top.php';
?>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid p-3 mt-3" style="background-color: #fff; border-radius: 10px">

            <h2>Cetak Laporan</h2>
            <br>
            <form action="docprint.php" method="post">
                <div class="form-group mb-3">
                    <label for="tanggal_awal">Tanggal</label>
                    <input type="date" name="tanggal_awal" id="tanggal" class="form-control" required style="max-width: 300px;">
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal">tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required style="max-width: 300px;">
                </div>
                <div class="form-group mb-3">
                    <label for="jenis_kas">Jenis Kas</label>
                    <select name="jenis_kas" id="jenis_kas" required class="form-control" style="max-width: 300px;">
                        <option value="keluar">Kas Keluar</option>
                        <option value="masuk">Kas Masuk</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="search"><i class="bi bi-search"></i> Search Data</button>
                </div>
            </form>


        </div>
        <!-- container -->
    </div>
    <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-center">
                </div>
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
                    </script> © Al-Hidayah
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
<?php
require 'bottom.php';
?>