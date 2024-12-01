<?php
require 'koneksi.php';

// Ambil ID pelanggan dari URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: customer.php?status=error_demo_3_2&message=" . urlencode("ID pelanggan tidak valid."));
    exit();
}

// Update status pelanggan menjadi active
$query = "UPDATE customers SET status = 'active' WHERE customer_id = $id";
$result = mysqli_query($conn, $query);

if ($result) {
    // Redirect ke halaman customer dengan notifikasi sukses
    header("Location: customer.php?status=success_demo_3_3&message=" . urlencode("Pelanggan berhasil diaktifkan kembali."));
    exit();
} else {
    // Redirect ke halaman customer dengan notifikasi gagal
    header("Location: customer.php?status=error_demo_3_2&message=" . urlencode("Gagal mengaktifkan kembali pelanggan: " . mysqli_error($conn)));
    exit();
}
?>
