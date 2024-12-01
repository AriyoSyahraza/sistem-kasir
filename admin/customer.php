<?php
require 'koneksi.php';
$title = 'Customer';

// Query untuk mengambil data pelanggan
$query = "SELECT 
    c.customer_id, 
    c.name, 
    c.phone_number, 
    c.points, 
    c.status 
FROM customers c
ORDER BY FIELD(c.status, 'active', 'inactive'), c.customer_id ASC;";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error pada query: " . mysqli_error($conn));
}

$customers = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Ambil parameter untuk notifikasi
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;

require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <!-- Tombol Tambah Customer -->
    <div class="text-end mb-3">
        <a href="customer_create.php">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Customer
            </button>
        </a>
    </div>

    <!-- Tabel Customer -->
    <div class="table-responsive">
        <table id="multi-filter-select" class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Poin</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($customers)) {
                    $no = 1; // Counter untuk nomor
                    foreach ($customers as $customer) {
                        $rowClass = $customer['status'] === 'inactive' ? 'table-warning' : '';

                        echo "
                        <tr class='{$rowClass}'>
                            <td>{$no}</td>
                            <td>{$customer['name']}</td>
                            <td>{$customer['phone_number']}</td>
                            <td>{$customer['points']}</td>
                            <td>" . ucfirst($customer['status']) . "</td>
                            <td>
                                <div class='d-flex justify-content-around'>";
                        
                        // Jika pelanggan tidak aktif, tampilkan tombol "Tambahkan Lagi"
                        if ($customer['status'] === 'inactive') {
                            echo "
                                    <button onclick='reactivateCustomer({$customer['customer_id']})' class='btn btn-success btn-sm'>
                                        <i class='fas fa-undo'></i> Tambahkan Lagi
                                    </button>";
                        } else {
                            echo "
                                    <a href='customer_detail.php?id={$customer['customer_id']}' class='btn btn-info btn-sm'>
                                        <i class='fas fa-eye'></i> Detail
                                    </a>
                                    <a href='customer_edit.php?id={$customer['customer_id']}' class='btn btn-warning btn-sm'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                    <button onclick='deleteCustomer({$customer['customer_id']})' class='btn btn-danger btn-sm'>
                                        <i class='fas fa-trash'></i> Hapus
                                    </button>";
                        }

                        echo "
                                </div>
                            </td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "
                    <tr>
                        <td colspan='6' class='text-center text-muted'>Tidak ada pelanggan yang tersedia.</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Menampilkan notifikasi jika ada
    <?php if ($status && $message): ?>
        Swal.fire({
            title: "<?= $status === 'success_demo_3_3' ? 'Berhasil!' : 'Gagal!'; ?>",
            text: "<?= $message; ?>",
            icon: "<?= $status === 'success_demo_3_3' ? 'success' : 'error'; ?>",
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    // Konfirmasi Hapus SweetAlert
    function deleteCustomer(id) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Apakah Anda yakin ingin menghapus pelanggan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Pelanggan ini akan diubah statusnya menjadi inactive!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result2) => {
                    if (result2.isConfirmed) {
                        window.location.href = `customer_delete.php?id=${id}`;
                    }
                });
            }
        });
    }

    // Konfirmasi Tambah Lagi SweetAlert
    function reactivateCustomer(id) {
        Swal.fire({
            title: 'Konfirmasi Penambahan',
            text: 'Apakah Anda yakin ingin mengaktifkan kembali pelanggan ini?',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tambahkan Lagi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `customer_reactivate.php?id=${id}`;
            }
        });
    }
</script>

<?php require 'afooter.php'; ?>
