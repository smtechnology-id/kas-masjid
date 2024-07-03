<?php
$conn = mysqli_connect("localhost", "root", "", "db-pengelolaan-kas");
function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db-pengelolaan-kas";

    // Buat koneksi
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check koneksi
    if (!$conn) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    return $conn;
}

// Function to check if a kwitansi number already exists
function isKwitansiExists($conn, $no_kwitansi) {
    $no_kwitansi = mysqli_real_escape_string($conn, $no_kwitansi);
    $query = "SELECT * FROM kas WHERE no_kwitansi = '$no_kwitansi'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Handling form submission for adding kas masuk
if (isset($_POST['addKas'])) {
    $no_kwitansi = mysqli_real_escape_string($conn, $_POST['no_kwitansi']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jumlah = $_POST['jumlah'];
    $jenis_kas = 'masuk';

    // Check if kwitansi number already exists
    if (isKwitansiExists($conn, $no_kwitansi)) {
        // Nomor kwitansi sudah ada, kirim respons ke JavaScript
        echo '<script>';
        echo 'alert("Nomor kwitansi sudah digunakan!");';
        echo 'window.location.href = "kasmasuk.php";'; // Redirect to kasmasuk.php or another page
        echo '</script>';
        exit(); // Stop further execution
    }

    // Query to insert data into database
    $query = "INSERT INTO kas (no_kwitansi, tanggal, keterangan, jumlah, jenis_kas) 
                  VALUES ('$no_kwitansi', '$tanggal', '$keterangan', $jumlah, '$jenis_kas')";

    if (mysqli_query($conn, $query)) {
        // Redirect to success page or another desired page
        header('Location: kasmasuk.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Handling form submission for adding kas keluar
if (isset($_POST['addKasKeluar'])) {
    $no_kwitansi = mysqli_real_escape_string($conn, $_POST['no_kwitansi']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jumlah = $_POST['jumlah'];
    $jenis_kas = 'keluar';

    // Check if kwitansi number already exists
    if (isKwitansiExists($conn, $no_kwitansi)) {
        // Nomor kwitansi sudah ada, kirim respons ke JavaScript
        echo '<script>';
        echo 'alert("Nomor kwitansi sudah digunakan!");';
        echo 'window.location.href = "kaskeluar.php";'; // Redirect to kaskeluar.php or another page
        echo '</script>';
        exit(); // Stop further execution
    }

    // Query to insert data into database
    $query = "INSERT INTO kas (no_kwitansi, tanggal, keterangan, jumlah, jenis_kas) 
                  VALUES ('$no_kwitansi', '$tanggal', '$keterangan', $jumlah, '$jenis_kas')";

    if (mysqli_query($conn, $query)) {
        // Redirect to success page or another desired page
        header('Location: kaskeluar.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}


if (isset($_POST['updateKas'])) {
    $id_kas = mysqli_real_escape_string($conn, $_POST['id_kas']);
    $no_kwitansi = mysqli_real_escape_string($conn, $_POST['no_kwitansi']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);

    // Query untuk memperbarui data kas berdasarkan ID
    $query = "UPDATE kas SET no_kwitansi='$no_kwitansi', tanggal='$tanggal', keterangan='$keterangan', jumlah='$jumlah' WHERE id_kas='$id_kas'";

    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman sukses atau halaman lain yang diinginkan
        header('Location: kasmasuk.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
if (isset($_POST['updateKasKeluar'])) {
    $id_kas = mysqli_real_escape_string($conn, $_POST['id_kas']);
    $no_kwitansi = mysqli_real_escape_string($conn, $_POST['no_kwitansi']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);

    // Query untuk memperbarui data kas berdasarkan ID
    $query = "UPDATE kas SET no_kwitansi='$no_kwitansi', tanggal='$tanggal', keterangan='$keterangan', jumlah='$jumlah' WHERE id_kas='$id_kas'";

    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman sukses atau halaman lain yang diinginkan
        header('Location: kaskeluar.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

if (isset($_POST['deleteKasKeluar'])) {
    $id_kas = mysqli_real_escape_string($conn, $_POST['id_kas']);

    // Query untuk menghapus data kas berdasarkan ID
    $query = "DELETE FROM kas WHERE id_kas='$id_kas'";

    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman sukses atau halaman lain yang diinginkan
        header('Location: kaskeluar.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
if (isset($_POST['deleteKas'])) {
    $id_kas = mysqli_real_escape_string($conn, $_POST['id_kas']);

    // Query untuk menghapus data kas berdasarkan ID
    $query = "DELETE FROM kas WHERE id_kas='$id_kas'";

    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman sukses atau halaman lain yang diinginkan
        header('Location: kasmasuk.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
