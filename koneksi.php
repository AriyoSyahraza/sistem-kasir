<?php
$conn = mysqli_connect("localhost", "root", "", "coffeeshopdb");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
    session_unset();
    session_destroy();
    header("Location: index.php?message=Session expired. Please log in again.");
    exit();
}
$_SESSION['last_activity'] = time();
?>
