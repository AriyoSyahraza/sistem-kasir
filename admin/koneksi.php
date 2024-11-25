    <?php
session_start();

if ($_SESSION) {
    if ($_SESSION['level'] == 'admin') {
    } else {
        header("location:../index.php");
    }
} else {
    header('location:../index.php');
}

$conn = mysqli_connect("localhost", "root", "", "coffeeshopdb");

if (mysqli_connect_error()) {
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    session_unset();
    session_destroy();
    header("Location: index.php?message=Session expired. Please log in again.");
    exit();
}
$_SESSION['last_activity'] = time();
