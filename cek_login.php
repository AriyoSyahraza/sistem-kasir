<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "coffeeshopdb");


// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $username = mysqli_real_escape_string($conn, $_POST['username']);
//     $password = md5($_POST['password']); // Gunakan password_hash() di sistem produksi

//     $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
//     $result = mysqli_query($conn, $query);

//     if ($result) {
//         $data = mysqli_fetch_assoc($result);
//         if ($data) {
//             $_SESSION['level'] = $data['level'];
//             $_SESSION['username'] = $data['username'];

//             if ($data['level'] == 'admin') {
//                 header('Location: admin.php');
//             } elseif ($data['level'] == 'cashier') {
//                 header('Location: cashier.php');
//             } else {
//                 header('Location: index.php?message=Invalid user level.');
//             }
//         } else {
//             header('Location: index.php?message=Username atau password salah!');
//         }
//     } else {
//         error_log('Database query error: ' . mysqli_error($conn));
//         header('Location: index.php?message=Unexpected error, please try again.');
//     }
// } else {
//     header('Location: index.php?message=Invalid request.');
// }
// exit();

$username = $_POST['username'];
$password = md5($_POST['password']);
$query = "SELECT * FROM user WHERE  username = '$username' AND password = '$password'";
$row = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($row);
$cek = mysqli_num_rows($row);

if ($cek > 0) {
    if ($data['level'] == 'admin') {
        $_SESSION['level'] = 'admin';
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['user_id'];
       

        header('location:admin');
    } else if ($data['level'] == 'cashier') {
        $_SESSION['level'] = 'cashier';
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['user_id'];

        

        header('location:cashier');
    }
} else {
    $message = 'Username atau password salah!!!';
    header('location:index.php?message=' . $message);
}
