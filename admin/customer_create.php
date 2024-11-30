<?php
require 'koneksi.php';
$title = 'Tambah Customer';

$message = null; // Pesan untuk notifikasi SweetAlert
$status = null;

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $points = $_POST['points'] ?? 0; // Default ke 0 jika kosong
    
    // Cek apakah nomor HP sudah ada
    $check_query = "SELECT * FROM customers WHERE phone_number = '$phone_number'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
      // Nomor HP sudah terdaftar
      $status = 'error_demo_3_2';
      $message = 'Nomor telepon sudah pernah terdaftar.';
    } else {
      // Insert data pelanggan baru
      $insert_query = "INSERT INTO customers (name, phone_number, points, status) 
                         VALUES ('$name', '$phone_number', $points, 'active')";

if (mysqli_query($conn, $insert_query)) {
  // Redirect dengan notifikasi sukses
  $status = 'success_demo_3_3';
  $message = 'Pelanggan berhasil ditambahkan.';
} else {
  // Redirect dengan notifikasi gagal
  $status = 'error_demo_3_2';
  $message = 'Gagal menambahkan pelanggan.';
}
}
}
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <form id="customer-form" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama pelanggan" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan nomor HP" required>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Poin</label>
            <input type="number" class="form-control" id="points" name="points" placeholder="Masukkan poin (opsional)">
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" id="submit-btn" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="customer.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('submit-btn').addEventListener('click', function () {
        // Konfirmasi sebelum menyimpan
        Swal.fire({
            title: 'Apakah data sudah benar?',
            text: "Pastikan data yang Anda masukkan sudah sesuai!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika konfirmasi, submit form
                document.getElementById('customer-form').submit();
            }
        });
    });

    // Notifikasi SweetAlert untuk hasil proses
    <?php if ($status === 'success_demo_3_3'): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: "<?= $message; ?>",
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'customer.php';
        });
    <?php elseif ($status === 'error_demo_3_2'): ?>
        Swal.fire({
            title: 'Gagal!',
            text: "<?= $message; ?>",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

<?php require 'afooter.php'; ?>
