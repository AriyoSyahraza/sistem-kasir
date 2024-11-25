<?php
// require 'koneksi.php';
$title = 'Customer';

require 'koneksi.php';

$query = 'SELECT * FROM customers ORDER BY customer_id ASC ';
$data = mysqli_query($conn, $query);

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
        <!-- <button class="btn btn-primary" >
            <i class="fas fa-plus"></i> Tambah Customer
        </button> -->
        <a href="customer_create.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Customer
        </a>
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
                    <th>Status</th>
                    <th>Actions</th>
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
                            <td><?= $plg['name']; ?></td>
                            
                            <td><?= $plg['phone_number']; ?></td>
                            <td><?= $plg['points']; ?></td>
                            <td><?= $plg['status']; ?></td>
                            <td>
                                <div class="form-button-action">
                                    <a href="detail_staff.php?id=<?= $plg['customer_id']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Detail">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    <a href="edit_staff.php?id=<?= $plg['customer_id']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="hapus_staff.php?id=<?= $plg['customer_id']; ?>" onclick="return confirm('Are you sure you want to deactivate this staff?');" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                <?php }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>







<?php
require 'afooter.php';
?>