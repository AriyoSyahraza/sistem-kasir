<?php
 require 'koneksi.php';



$id = $_GET['order_id'];
$query = "DELETE FROM orders WHERE order_id = '$id'";
$delete = mysqli_query($conn, $query);


if ($delete) {
    $_SESSION['msg'] = 'Berhasil menghapus pesanan';
    header('location:pesanan.php');
} else {
    $_SESSION['msg'] = 'Gagal Hapus Data!!!';
    header('location:pesanan.php');
}
?>