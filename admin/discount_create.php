<?php
require 'koneksi.php';
$title = 'Discount';

if (isset($_POST['submit'])) {
  $nama_discount = $_POST['nama_discount'];
    $percent = $_POST['percent'];
    $range = $_POST['range'];
    $date = $_POST['date'];
    
    // Query untuk menyimpan data
    $sql = "INSERT INTO discount(name, percentage, range_days, applied_at) 
            VALUES('$nama_discount', $percent, $range, '$date')";

if (mysqli_query($conn, $sql)) {
  // Redirect ke halaman discount dengan status sukses
  header("Location: discount.php?status=success_demo_3_3&message=" . urlencode("Diskon berhasil ditambahkan."));
  exit();
} else {
  // Redirect ke halaman discount dengan status error
  $error_message = urlencode(mysqli_error($conn));
  header("Location: discount.php?status=error_demo_3_2&message=$error_message");
  exit();
}
}
require 'aheader.php';
?>

<div class="page-header">
  <h1 class="fw-bold mb-3">
    <?= $title; ?>
  </h1>
</div>

<div class="container my-5">
    <form action="" method="POST">
        <div class="mb-3">
            <label for="nama_discount" class="form-label">Nama Discount</label>
            <input type="text" class="form-control" id="nama_discount" name="nama_discount" required>
        </div>

        <div class="mb-3">
            <label for="percent" class="form-label">Percentage</label>
            <input type="number" class="form-control" id="percent" name="percent" required>
        </div>

        <div class="mb-3">
            <label for="range" class="form-label">Range (Days)</label>
            <input type="number" class="form-control" id="range" name="range" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>

        <button type="submit" name="submit" class="btn btn-success">Tambah Diskon</button>
    </form>
</div>

<?php
require 'afooter.php';
?>
