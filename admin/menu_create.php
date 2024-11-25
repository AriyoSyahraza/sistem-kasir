<?php
ob_start();
$title = 'Menu';
require 'koneksi.php';
require 'aheader.php';

$message = ''; // Variabel untuk menampilkan pesan

if (isset($_POST['submit'])) {
    // Tangkap data dari form
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $redeem_points = $_POST['redeem_points'];

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO menu_items (name, price, type, redeemable_points) 
              VALUES ('$name', $price, '$type', $redeem_points)";

    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman menu jika berhasil
        $message = "Menu berhasil ditambahkan!";
        
        header("Location: menu.php");
        exit(); // Menghentikan eksekusi skrip lebih lanjut
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
ob_end_flush(); // Akhiri output buffering
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Buat Menu</div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama menu" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Harga</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Masukkan harga menu" required>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Tipe Menu</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="food">Food</option>
                        <option value="beverage">Beverage</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="redeem_points" class="form-label">Redeem Points</label>
                    <input type="number" class="form-control" id="redeem_points" name="redeem_points" placeholder="Masukkan poin redeem" required>
                </div>

                <button type="submit" name="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>


<?php
require 'afooter.php';
?>