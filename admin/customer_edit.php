<?php
require 'koneksi.php';
$title = 'Edit Customer';

// Ambil ID pelanggan dari URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: customer.php");
    exit();
}

// Ambil data pelanggan berdasarkan ID
$query = "SELECT * FROM customers WHERE customer_id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: customer.php?status=error_demo_3_2&message=" . urlencode("Pelanggan tidak ditemukan."));
    exit();
}

$customer = mysqli_fetch_assoc($result);

$status = null;
$message = null;

// Proses update data pelanggan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? $customer['name'];
    $phone_number = $_POST['phone_number'] ?? $customer['phone_number'];
    $points = $_POST['points'] ?? $customer['points'];
    $status = $_POST['status'] ?? $customer['status'];

    // Validasi
    if (strlen($name) > 40) {
        $status = 'error_demo_3_2';
        $message = 'Nama tidak boleh lebih dari 40 karakter.';
    } elseif (!is_numeric($phone_number) || strlen($phone_number) > 13) {
        $status = 'error_demo_3_2';
        $message = 'Nomor telepon tidak valid (harus angka dan maksimal 13 karakter).';
    } elseif (!is_numeric($points) || $points > 9999) {
        $status = 'error_demo_3_2';
        $message = 'Poin harus berupa angka maksimal 4 digit.';
    } else {
        // Cek apakah nomor HP sudah digunakan oleh pelanggan lain
        $check_query = "SELECT * FROM customers WHERE phone_number = '$phone_number' AND customer_id != $id";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $status = 'error_demo_3_2';
            $message = 'Nomor telepon sudah digunakan oleh pelanggan lain.';
        } else {
            // Update data pelanggan
            $update_query = "UPDATE customers SET 
                                name = '$name', 
                                phone_number = '$phone_number', 
                                points = $points,
                                status = '$status'
                             WHERE customer_id = $id";

            if (mysqli_query($conn, $update_query)) {
                header("Location: customer.php?status=success_demo_3_3&message=" . urlencode("Data pelanggan berhasil diperbarui."));
                exit();
            } else {
                $status = 'error_demo_3_2';
                $message = 'Gagal memperbarui data pelanggan: ' . mysqli_error($conn);
            }
        }
    }
}
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <form id="customer-edit-form" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($customer['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($customer['phone_number']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Poin</label>
            <input type="number" class="form-control" id="points" name="points" value="<?= htmlspecialchars($customer['points']); ?>" required>
        </div>

        <!-- Field Status Ditambahkan -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="active" <?= $customer['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= $customer['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <button type="button" id="save-btn" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
            </button>
            <button type="button" id="cancel-btn" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Konfirmasi sebelum menyimpan
    document.getElementById('save-btn').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pelanggan akan diperbarui!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('customer-edit-form').submit();
            }
        });
    });

    // Konfirmasi sebelum batal
    document.getElementById('cancel-btn').addEventListener('click', function () {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Perubahan yang belum disimpan akan hilang.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Batal',
            cancelButtonText: 'Kembali Mengedit'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'customer.php?status=info_demo_3_4&message=' + encodeURIComponent('Perubahan dibatalkan.');
            }
        });
    });

    // Menampilkan notifikasi jika ada kesalahan
    <?php if ($message): ?>
        Swal.fire({
            title: "<?= $status === 'success_demo_3_3' ? 'Berhasil!' : 'Gagal!'; ?>",
            text: "<?= $message; ?>",
            icon: "<?= $status === 'success_demo_3_3' ? 'success' : 'error'; ?>",
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

<?php require 'afooter.php'; ?>
