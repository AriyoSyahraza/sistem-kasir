<?php
ob_start();
$title = 'Menu';
require 'koneksi.php';
require 'aheader.php';

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    // Jika ID tidak ditemukan, redirect kembali ke halaman menu
    header("Location: menu.php");
    exit();
}

// Ambil data menu berdasarkan ID
$query = "SELECT * FROM menu_items WHERE menu_item_id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    // Jika menu tidak ditemukan, redirect kembali ke halaman menu
    header("Location: menu.php");
    exit();
}

$menu = mysqli_fetch_assoc($result);

// Proses update menu jika form disubmit
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $redeem_points = $_POST['redeem_points'];

    $update_query = "UPDATE menu_items 
                     SET name = '$name', price = $price, type = '$type', redeemable_points = $redeem_points 
                     WHERE menu_item_id = $id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: menu.php");
        exit();
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

            <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?= $message; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $menu['name']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $menu['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipe Menu</label>
            <select class="form-select" id="type" name="type" required>
                <option value="food" <?= $menu['type'] === 'food' ? 'selected' : ''; ?>>Food</option>
                <option value="beverage" <?= $menu['type'] === 'beverage' ? 'selected' : ''; ?>>Beverage</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="redeem_points" class="form-label">Redeem Points</label>
            <input type="number" class="form-control" id="redeem_points" name="redeem_points" value="<?= $menu['redeemable_points']; ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            <a href="menu.php" class="btn btn-secondary">Batal</a>
        </div>
    </form>
        </div>
    </div>
</div>


<?php
require 'afooter.php';
?>