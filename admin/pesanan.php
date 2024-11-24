<?php
// require 'koneksi.php';
$title = 'Pesanan';
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="container my-5">
    <!-- Tombol Tambah Pesanan -->
    <div class="text-end mb-3">
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Pesanan
        </button>
    </div>

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
                <i class="icon-loop"></i> 
                <span>Reset</span>
            </button>
        </div>
    </div>


    <!-- Tabel Pesanan -->
    <div class="table-responsive">
        <table id="multi-filter-select" class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pesanan = [
                    ['no' => 1, 'kasir' => 'John Doe', 'date' => '2024-11-01', 'total' => 150000],
                    ['no' => 2, 'kasir' => 'Jane Smith', 'date' => '2024-11-02', 'total' => 200000],
                    ['no' => 3, 'kasir' => 'Emily Johnson', 'date' => '2024-11-03', 'total' => 250000],
                ];

                foreach ($pesanan as $item) {
                    echo "
                    <tr>
                        <td>{$item['no']}</td>
                        <td>{$item['date']}</td>
                        <td>{$item['kasir']}</td>
                        <td>Rp " . number_format($item['total'], 0, ',', '.') . "</td>
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
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require 'afooter.php';
?>