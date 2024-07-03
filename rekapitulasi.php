<?php
require 'top.php';
?>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid p-3 mt-3" style="background-color: #fff; border-radius: 10px">

            <h2>Cetak Rekapitulasi</h2>
            <br>
            <form action="docprintrekap.php" method="post">
                <div class="form-group mb-3">
                    <label for="tanggal_awal">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required style="max-width: 300px;">
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal_akhir">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required style="max-width: 300px;">
                </div>
                <div class="form-group mb-3">
                    <label for="jenis_kas">Jenis Kas</label>
                    <select name="jenis_kas" id="jenis_kas" required class="form-control" style="max-width: 300px;">
                        <option value="keluar">Kas Keluar</option>
                        <option value="masuk">Kas Masuk</option>
                        <option value="rekapitulasi">Rekapitulasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="cetak_rekap"><i class="bi bi-print"></i> Cetak Rekapitulasi</button>
                </div>
            </form>



        </div>
        <!-- container -->
    </div>
    <!-- content -->

    <!-- end Footer -->
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