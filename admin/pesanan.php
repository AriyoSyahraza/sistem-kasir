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
    <!-- Tombol Create Pesanan -->
    <div class="text-end mb-3">
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Pesanan
        </button>
    </div>

    <!-- Tabel Pesanan -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kasir</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Data contoh pesanan
                $pesanan = [
                    ['no' => 1, 'kasir' => 'John Doe', 'date' => '2024-11-01', 'total' => 'Rp 150.000'],
                    ['no' => 2, 'kasir' => 'Jane Smith', 'date' => '2024-11-02', 'total' => 'Rp 200.000'],
                    ['no' => 3, 'kasir' => 'Emily Johnson', 'date' => '2024-11-03', 'total' => 'Rp 250.000'],
                ];

                foreach ($pesanan as $item) {
                    echo "
                    <tr>
                        <th scope='row'>{$item['no']}</th>
                        <td>{$item['kasir']}</td>
                        <td>{$item['date']}</td>
                        <td>{$item['total']}</td>
                        <td>
                            <div class='d-flex justify-content-around'>
                                <button class='btn btn-warning btn-sm mx-1'>
                                    <i class='fas fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-info btn-sm mx-1'>
                                    <i class='fas fa-eye'></i> Detail
                                </button>
                                <button class='btn btn-danger btn-sm mx-1'>
                                    <i class='fas fa-trash'></i> Hapus
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