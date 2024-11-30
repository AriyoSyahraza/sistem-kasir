<?php
require 'koneksi.php';
$title = 'Discount';
require 'aheader.php';

// Query untuk mengambil data dari tabel discount
$query = "SELECT 
    d.discount_id, 
    d.name, 
    d.percentage, 
    d.range_days, 
    d.applied_at, 
    d.status,
    (SELECT COUNT(o.order_id) 
     FROM orders o 
     WHERE o.discount_id = d.discount_id) AS `usage`
FROM discount d
ORDER BY d.discount_id ASC;";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error pada query: " . mysqli_error($conn));
}

// Simpan data
$discounts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Ambil parameter untuk notifikasi
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;
?>

<div class="page-header">
    <h1 class="fw-bold mb-3"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <!-- Tombol Tambah Discount -->
    <div class="text-end mb-3">
        <a href="discount_create.php">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Discount
            </button>
        </a>
    </div>

    <!-- Filter Tanggal -->
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="start-date">Dari Tanggal</label>
            <input type="date" id="start-date" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="end-date">Ke Tanggal</label>
            <input type="date" id="end-date" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button id="reset-filter" class="btn btn-primary w-100">
                <i class="icon-loop"></i> Reset
            </button>
        </div>
    </div>

    <!-- Tabel Discount -->
    <div class="table-responsive">
        <table id="multi-filter-select" class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Start</th>
                    <th>Nama Discount</th>
                    <th>Percentage</th>
                    <th>Usage</th>
                    <th>Range (Days)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($discounts)) {
                    $no = 1; // Counter untuk nomor
                    foreach ($discounts as $discount) {
                        // Tambahkan kelas 'table-warning' jika status adalah 'inactive'
                        $rowClass = $discount['status'] === 'inactive' ? 'table-warning' : '';

                        echo "
                        <tr class='{$rowClass}'>
                            <td>{$no}</td>
                            <td>" . date('D, d M Y', strtotime($discount['applied_at'])) . "</td>
                            <td>{$discount['name']}</td>
                            <td>{$discount['percentage']}%</td>
                            <td>{$discount['usage']}</td>
                            <td>{$discount['range_days']}</td>
                            <td>
                                <div class='d-flex justify-content-around'>
                                <a href='discount_detail.php?id={$discount['discount_id']}' class='btn btn-info btn-sm'>
                                    <i class='fas fa-eye'></i> Detail
                                </a>
                                <a href='discount_edit.php?id={$discount['discount_id']}' class='btn btn-warning btn-sm'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <button onclick='deleteDiscount({$discount['discount_id']})' class='btn btn-danger btn-sm'>
                                    <i class='fas fa-trash'></i> Delete
                                </button>
                            </div>
                            </td>
                        </tr>";
                        $no++; // Increment nomor
                    }
                } else {
                    echo "
                    <tr>
                        <td colspan='7' class='text-center text-muted'>Tidak ada diskon yang tersedia.</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// SweetAlert untuk notifikasi
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
function deleteDiscount(id) {
    // Konfirmasi pertama
    Swal.fire({
        title: 'Konfirmasi Penghapusan',
        text: 'Apakah Anda yakin ingin menghapus diskon ini?',
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
                text: 'Diskon ini akan dihapus dan statusnya akan diubah menjadi inactive!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result2) => {
                if (result2.isConfirmed) {
                    // Redirect ke halaman untuk mengupdate status menjadi inactive
                    window.location.href = `discount_delete.php?id=${id}`;
                }
            });
        }
    });
}
</script>


<?php require 'afooter.php'; ?>
