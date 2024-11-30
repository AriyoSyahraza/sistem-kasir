<?php
require 'koneksi.php';

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: discount.php");
    exit();
}

// Update status diskon menjadi 'inactive'
$delete_query = "UPDATE discount SET status = 'inactive' WHERE discount_id = $id";


    if (mysqli_query($conn, $delete_query)) {
        // Redirect ke halaman discount dengan notifikasi sukses
        header("Location: discount.php?status=success_demo_3_3&message=" . urlencode("Diskon berhasil dihapus."));
        exit();
    } else {
        // Redirect ke halaman discount dengan notifikasi gagal
        header("Location: discount.php?status=error_demo_3_2&message=" . urlencode("Gagal menghapus diskon."));
        exit();
    }


?>

