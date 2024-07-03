<?php
// Memulai session
session_start();

// Menghapus semua data session
session_destroy();

// Mengarahkan pengguna kembali ke halaman login atau halaman lain yang sesuai
header("Location: index.php");
exit;
?>
