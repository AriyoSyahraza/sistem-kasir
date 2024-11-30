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
ORDER BY c.customer_id ASC;";
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
                                <div class='d-flex justify-content-around'>
                                    <a href='customer_detail.php?id={$customer['customer_id']}' class='btn btn-info btn-sm'>
                                        <i class='fas fa-eye'></i> Detail
                                    </a>
                                    <a href='customer_edit.php?id={$customer['customer_id']}' class='btn btn-warning btn-sm'>
                                        <i class='fas fa-edit'></i> Edit
                                    </a>
                                    <button onclick='deleteCustomer({$customer['customer_id']})' class='btn btn-danger btn-sm'>
                                        <i class='fas fa-trash'></i> Delete
                                    </button>
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
    // Notifikasi SweetAlert
    <?php if ($status === 'success_demo_3_3'): ?>
        Swal.fire({
            title: 'Berhasil!',
            text: "<?= urldecode($message); ?>",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    <?php elseif ($status === 'error_demo_3_2'): ?>
        Swal.fire({
            title: 'Gagal!',
            text: "<?= urldecode($message); ?>",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    <?php elseif ($status === 'info_demo_3_4'): ?>
        Swal.fire({
            title: 'Informasi!',
            text: "<?= urldecode($message); ?>",
            icon: 'info',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>

    // Konfirmasi Hapus SweetAlert
    function deleteCustomer(id) {
        // Konfirmasi pertama
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
                // Konfirmasi kedua
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Pelanggan ini akan dihapus dan statusnya akan diubah menjadi inactive!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result2) => {
                    if (result2.isConfirmed) {
                        // Redirect ke halaman penghapusan customer
                        window.location.href = `customer_delete.php?id=${id}`;
                    }
                });
            }
        });
    }
</script>

<?php require 'afooter.php'; ?>
