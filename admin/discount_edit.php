<?php
require 'koneksi.php';
$title = 'Edit Discount';

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: discount.php");
    exit();
}

// Ambil data berdasarkan ID
$query = "SELECT * FROM discount WHERE discount_id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: discount.php");
    exit();
}

$discount = mysqli_fetch_assoc($result);

// Proses update diskon
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $percentage = $_POST['percentage'];
    $range_days = $_POST['range_days'];
    $applied_at = $_POST['applied_at'];

    $update_query = "UPDATE discount 
                     SET name = '$name', 
                         percentage = $percentage, 
                         range_days = $range_days, 
                         applied_at = '$applied_at'
                     WHERE discount_id = $id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: discount.php?status=success_demo_3_3&message=" . urlencode("Diskon berhasil diperbarui."));
        exit();
    } else {
        header("Location: discount.php?status=error_demo_3_2&message=" . urlencode("Gagal memperbarui diskon."));
        exit();
    }
}

require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <form id="edit-form" action="" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Discount</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $discount['name']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Percentage</label>
            <input type="number" step="1" class="form-control" id="percentage" name="percentage" value="<?= $discount['percentage']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="range_days" class="form-label">Range (Days)</label>
            <input type="number" class="form-control" id="range_days" name="range_days" value="<?= $discount['range_days']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="applied_at" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="applied_at" name="applied_at" value="<?= $discount['applied_at']; ?>" required>
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" id="btn-save" class="btn btn-success">Simpan</button>
            <button type="button" id="btn-cancel" class="btn btn-secondary">Batal</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Tombol Simpan dengan konfirmasi
document.getElementById('btn-save').addEventListener('click', function () {
    Swal.fire({
        title: 'Konfirmasi Simpan',
        text: 'Apakah Anda yakin ingin menyimpan perubahan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form jika dikonfirmasi
            document.getElementById('edit-form').submit();
        }
    });
});

// Tombol Batal dengan konfirmasi
document.getElementById('btn-cancel').addEventListener('click', function () {
    Swal.fire({
        title: 'Konfirmasi Batal',
        text: 'Apakah Anda ingin membatalkan perubahan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Lanjutkan Mengedit'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke halaman discount jika dikonfirmasi
            window.location.href = 'discount.php?status=info_demo_3_4&message=' + encodeURIComponent('Perubahan dibatalkan.');
        }
    });
});
</script>

<?php require 'afooter.php'; ?>
