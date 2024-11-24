<?php
// require 'koneksi.php';
$title = 'Customer';
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>


<div class="container my-5">
    <!-- Tombol Tambah Customer -->
    <div class="text-end mb-3">
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Customer
        </button>
    </div>

    <!-- Tabel Customer -->
    <div class="table-responsive">
        <table id="multi-filter-select" class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>No HP</th>
                    <th>Poin</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $customers = [
                    ['no' => 1, 'name' => 'John Doe', 'phone' => '08123456789', 'points' => 120, 'orders' => 10],
                    ['no' => 2, 'name' => 'Jane Smith', 'phone' => '08198765432', 'points' => 80, 'orders' => 5],
                    ['no' => 3, 'name' => 'Emily Johnson', 'phone' => '08122334455', 'points' => 200, 'orders' => 15],
                ];

                foreach ($customers as $customer) {
                    echo "
                    <tr>
                        <td>{$customer['no']}</td>
                        <td>{$customer['name']}</td>
                        <td>{$customer['phone']}</td>
                        <td>{$customer['points']}</td>
                        <td>{$customer['orders']}</td>
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