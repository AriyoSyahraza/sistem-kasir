<?php
// require 'koneksi.php';
$title = 'Discount';
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="container my-5">
    <!-- Tombol Tambah Discount -->
    <div class="text-end mb-3">
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Discount
        </button>
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
                $discounts = [
                    ['no' => 1, 'name' => 'Holiday Sale', 'percentage' => 20, 'usage' => 50, 'range' => 7, 'start' => '2024-11-25'],
                    ['no' => 2, 'name' => 'Black Friday', 'percentage' => 50, 'usage' => 120, 'range' => 3, 'start' => '2024-11-22'],
                    ['no' => 3, 'name' => 'Weekend Special', 'percentage' => 30, 'usage' => 80, 'range' => 2, 'start' => '2024-11-23'],
                ];

                foreach ($discounts as $discount) {
                    echo "
                    <tr>
                        <td>{$discount['no']}</td>
                        <td>{$discount['start']}</td>
                        <td>{$discount['name']}</td>
                        <td>{$discount['percentage']}%</td>
                        <td>{$discount['usage']}</td>
                        <td>{$discount['range']} days</td>
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