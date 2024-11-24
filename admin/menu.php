<?php
// require 'koneksi.php';
$title = 'Menu';
require 'koneksi.php';

$query = 'SELECT * FROM menu_items';
$data = mysqli_query($conn, $query);
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="container my-5">
    <!-- Tombol Create Menu -->
    <div class="text-end mb-3">
        <a href="menu_create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Customer
        </a>
    </div>

    <!-- Navpills -->
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-food-tab" data-bs-toggle="pill" data-bs-target="#pills-food" type="button" role="tab" aria-controls="pills-food" aria-selected="true">
                <i class="fas fa-utensils"></i> Menu
            </button>
        </li>
        
    </ul>

    <!-- Tab Content -->
    <!-- Tabel Menu -->
    <div class="table-responsive">
        <table id="multi-filter-select" class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Poin</th>
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
                            
                            <td><?= $plg['price']; ?></td>
                            <td><?= $plg['redeemable_points']; ?></td>
                            <td>
                                <div class="form-button-action">
                                    <a href="detail_staff.php?id=<?= $plg['menu_item_id']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Detail">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                    <a href="edit_staff.php?id=<?= $plg['menu_item_id']; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="hapus_staff.php?id=<?= $plg['menu_item_id']; ?>" onclick="return confirm('Are you sure you want to deactivate this staff?');" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Hapus">
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