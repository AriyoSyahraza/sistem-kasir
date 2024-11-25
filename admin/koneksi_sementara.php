<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'coffeeshopdb';

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if (mysqli_connect_error()) {
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}
