<?php
// require 'koneksi.php';
$title = 'Pesanan';
require 'koneksi.php';

$query = 'SELECT * FROM orders ORDER BY order_id ASC ';
$data = mysqli_query($conn, $query);





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
    <a href="pesanan_create.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Pesanan
        </a>
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
                $no = 1;
                if (mysqli_num_rows($data) > 0) {
                    while ($plg = mysqli_fetch_assoc($data)) {
                ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $plg['order_date']; ?></td>
                            
                            <td><?= $plg['cashier']; ?></td>
                            <td><?= $plg['total_amount']; ?></td>
                           
                            <td>
                                <div class="form-button-action">
                                    <a href="detail_order.php?id=<?= $plg['order_id']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Detail">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    <a href="pesanan_edit.php?id=<?= $plg['order_id']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="pesanan_delete.php?order_id=<?= $plg['order_id']; ?>" onclick="return confirm('Yakin mau menghapus orderan ini?');" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                <?php }
                }?>
            </tbody>
        </table>
    </div>
</div>

<?php
require 'afooter.php';
?>