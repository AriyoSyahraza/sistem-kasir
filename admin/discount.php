<?php
require 'koneksi.php';
$title = 'Discount';
require 'aheader.php';

// Query untuk mengambil data dari tabel discount
$query = "SELECT * FROM discount ORDER BY discount_id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error pada query: " . mysqli_error($conn));
}

// Simpan data
$discounts = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
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
                        <td>" . date('D, d M Y', strtotime($discount['start_date'])) . "</td>
                        <td>{$discount['name']}</td>
                        <td>{$discount['percentage']}%</td>
                        <td>{$discount['usage']}</td>
                        <td>{$discount['range_days']} days</td>
                        <td>
                            <div class='d-flex justify-content-around'>
                                <button class='btn btn-info btn-sm'>
                                    <i class='fas fa-eye'></i> Detail
                                </button>
                                <button class='btn btn-warning btn-sm'>
                                    <i class='fas fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-sm'>
                                    <i class='fas fa-trash'></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    ";
                    $no++; // Increment nomor
                }
            } else {
                echo "
                <tr>
                    <td colspan='7' class='text-center text-muted'>Tidak ada diskon yang tersedia.</td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>
</div>
</div>





<?php
require 'afooter.php';
?>