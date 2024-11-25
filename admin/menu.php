<?php
require 'koneksi.php';
$title = 'Menu';

$query = 'SELECT * FROM menu_items';
$data = mysqli_query($conn, $query);
require 'aheader.php';

$query = "
    SELECT 
        *
    FROM 
        menu_items 
        WHERE status = 'active'
    ORDER BY 
        type ASC, name ASC;
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error pada query: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="container my-5">
    <!-- Tombol Create Menu -->
    <div class="text-end mb-3">
        <a href="menu_create.php">
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Create Menu
            </button>
        </a>
    </div>

    <!-- Navpills -->
    <!-- Navpills -->
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-food-tab" data-bs-toggle="pill" data-bs-target="#pills-food" type="button" role="tab" aria-controls="pills-food" aria-selected="true">
                <i class="fas fa-utensils"></i> Food
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-beverage-tab" data-bs-toggle="pill" data-bs-target="#pills-beverage" type="button" role="tab" aria-controls="pills-beverage" aria-selected="false">
                <i class="fas fa-coffee"></i> Beverage
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="pills-tabContent">
        <!-- Food Section -->
        <div class="tab-pane fade show active" id="pills-food" role="tabpanel" aria-labelledby="pills-food-tab">
            <div class="row g-4">
                <?php foreach ($data as $item): ?>
                    <?php if ($item['type'] === 'food'): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title"><?= $item['name']; ?></h5>
                                        <p class="card-text">Rp <?= number_format($item['price'], 0, ',', '.'); ?></p>
                                    </div>
                                    <div>
                                        <span class="badge bg-success">Redeem <?= $item['redeemable_points']; ?> Points</span>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">

                                    <a href="menu_edit.php?id=<?= $item['menu_item_id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteMenu(<?= $item['menu_item_id']; ?>)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Beverage Section -->
        <div class="tab-pane fade" id="pills-beverage" role="tabpanel" aria-labelledby="pills-beverage-tab">
            <div class="row g-4">
                <?php foreach ($data as $item): ?>
                    <?php if ($item['type'] === 'beverage'): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between">
                                    <div>
                                        <h5 class="card-title"><?= $item['name']; ?></h5>
                                        <p class="card-text">Rp <?= number_format($item['price'], 0, ',', '.'); ?></p>
                                    </div>
                                    <div>
                                        <span class="badge bg-success">Redeem <?= $item['redeemable_points']; ?> Points</span>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    
                                    <a href="menu_edit.php?id=<?= $item['menu_item_id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteMenu(<?= $item['menu_item_id']; ?>)" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteMenu(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Menu ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect ke halaman delete dengan parameter ID
                window.location = `menu_delete.php?id=${id}`;
            }
        });
    }
</script>

<?php if (isset($_GET['message'])): ?>
    <script>
        Swal.fire({
            title: "<?= $_GET['message'] === 'deleted' ? 'Berhasil!' : 'Gagal!'; ?>",
            text: "<?= $_GET['message'] === 'deleted' ? 'Menu berhasil dinonaktifkan.' : 'Terjadi kesalahan, coba lagi.'; ?>",
            icon: "<?= $_GET['message'] === 'deleted' ? 'success' : 'error'; ?>"
        });
    </script>
<?php endif; ?>


<?php
require 'afooter.php';
?>