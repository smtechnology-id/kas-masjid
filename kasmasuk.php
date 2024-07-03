<?php
require 'top.php';
?>

<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid p-3 mt-3" style="background-color: #fff; border-radius: 10px">

            <h2>Kas Masuk</h2>
            <div class="table-responsive">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-file-earmark-plus-fill"></i> Add Data </button>
                <?php if (isset($success)) : ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Kwitansi</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = mysqli_query($conn, "SELECT * FROM kas WHERE jenis_kas = 'masuk' ORDER BY id_kas DESC");
                        while ($row = mysqli_fetch_array($sql)) {
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['no_kwitansi'] ?></td>
                                <td><?= $row['tanggal'] ?></td>
                                <td><?= $row['keterangan'] ?></td>
                                <td><?= 'Rp. ' . number_format($row['jumlah'], 3, '.', '.') ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#update<?= $row['id_kas'] ?>"><i class="bi bi-pencil-square"></i></button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $row['id_kas'] ?>"><i class="bi bi-trash"></i></button>

                                    <div id="update<?= $row['id_kas'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="standard-modalLabel">Update Kas Masuk</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post">
                                                        <div class="form-group mb-2">
                                                            <label for="no_kwitansi">Nomor Kwitansi</label>
                                                            <input type="text" name="no_kwitansi" id="no_kwitansi" class="form-control" required value="<?= $row['no_kwitansi'] ?>">
                                                            <input type="hidden" name="id_kas" id="id_kas" class="form-control" required value="<?= $row['id_kas'] ?>">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="tanggal">Tanggal</label>
                                                            <input type="date" name="tanggal" id="tanggal" class="form-control" required value="<?= $row['tanggal'] ?>">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="keterangan">Keterangan</label>
                                                            <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control" required><?= $row['keterangan'] ?></textarea>
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <label for="jumlah">Jumlah</label>
                                                            <input type="number" name="jumlah" id="jumlah" class="form-control" required value="<?= $row['jumlah'] ?>">
                                                        </div>
                                                        <div class="form-group mb-2">
                                                            <input type="submit" value="Simpan" name="updateKas" class="btn btn-primary">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    <div id="delete<?= $row['id_kas'] ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="standard-modalLabel">Update Kas Masuk</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Anda Yakin Ingin Menghapus Data ini ? Data tidak akan tersimpan!</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <form method="post">
                                                        <input type="hidden" name="id_kas" id="id_kas" value="<?= $row['id_kas'] ?>">
                                                        <button type="submit" name="deleteKas" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                                                    </form>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
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

<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Kas Masuk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group mb-2">
                        <label for="no_kwitansi">Nomor Kwitansi</label>
                        <input type="text" name="no_kwitansi" id="no_kwitansi" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" cols="30" rows="3" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <input type="submit" value="Simpan" name="addKas" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
require 'bottom.php';
?>