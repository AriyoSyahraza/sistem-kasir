<?php
require 'koneksi.php'; // Pastikan koneksi ke database

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    // Jika ID tidak ditemukan, redirect ke halaman menu
    header("Location: menu.php");
    exit();
}

// Update status menu menjadi inactive
$query = "UPDATE menu_items SET status = 'inactive' WHERE menu_item_id = $id";
if (mysqli_query($conn, $query)) {
    // Redirect kembali ke halaman menu dengan pesan sukses
    header("Location: menu.php?message=deleted");
    exit();
} else {
    // Redirect kembali dengan pesan error
    header("Location: menu.php?message=error");
    exit();
}
