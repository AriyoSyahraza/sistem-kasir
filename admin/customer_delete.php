<?php
 require 'koneksi.php';

 $id = $_GET['customer_id'];
 $query = "DELETE FROM customers WHERE customer_id = '$id'";
 $delete = mysqli_query($conn, $query);
 
 
 if ($delete) {
     $_SESSION['msg'] = 'Berhasil menghapus pesanan';
     header('location:customer.php');
 } else {
     $_SESSION['msg'] = 'Gagal Hapus Data!!!';
     header('location:customer.php');
 }
?>