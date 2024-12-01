<?php
require 'koneksi.php';

// Ambil ID pelanggan dari URL
$id = $_GET['id'] ?? null;

if ($id) {
    // Update status menjadi inactive
    $query = "UPDATE customers SET status = 'inactive' WHERE customer_id = '$id'";
    $update = mysqli_query($conn, $query);

    if ($update) {
        // Redirect dengan notifikasi sukses
        header("Location: customer.php?status=success_demo_3_3&message=" . urlencode("Pelanggan berhasil di Non-Aktifkan."));
        exit();
    } else {
        // Redirect dengan notifikasi gagal
        header("Location: customer.php?status=error_demo_3_2&message=" . urlencode("Gagal meng Non-Aktifkan pelanggan."));
        exit();
    }
} else {
    // Redirect jika ID tidak valid
    header("Location: customer.php?status=error_demo_3_2&message=" . urlencode("ID pelanggan tidak valid."));
    exit();
}
?>
