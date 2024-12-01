<?php
require 'koneksi.php';
$title = 'Customer';

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
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Informasi Pelanggan</h5>
            <div class="mb-3">
                <strong>Nama:</strong>
                <p><?= htmlspecialchars($customer['name']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Nomor Telepon:</strong>
                <p><?= htmlspecialchars($customer['phone_number']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Poin:</strong>
                <p><?= htmlspecialchars($customer['points']); ?></p>
            </div>
            <div class="mb-3">
                <strong>Status:</strong>
                <span class="badge bg-<?= $customer['status'] === 'active' ? 'success' : 'warning'; ?>">
                    <?= ucfirst($customer['status']); ?>
                </span>
            </div>
            <div class="d-flex justify-content-end">
                <a href="customer_edit.php?id=<?= $customer['customer_id']; ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

<?php require 'afooter.php'; ?>
