<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // Gunakan password_hash() di sistem produksi

    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        if ($data) {
            $_SESSION['level'] = $data['level'];
            $_SESSION['username'] = $data['username'];

            if ($data['level'] == 'admin') {
                header('Location: admin.php');
            } elseif ($data['level'] == 'cashier') {
                header('Location: cashier.php');
            } else {
                header('Location: index.php?message=Invalid user level.');
            }
        } else {
            header('Location: index.php?message=Username atau password salah!');
        }
    } else {
        error_log('Database query error: ' . mysqli_error($conn));
        header('Location: index.php?message=Unexpected error, please try again.');
    }
} else {
    header('Location: index.php?message=Invalid request.');
}
exit();
