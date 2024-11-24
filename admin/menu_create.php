<?php
// require 'koneksi.php';
$title = 'Menu';
 require 'koneksi.php';

if (isset($_POST['submit'])) {
    $kat = $_POST['menu_items'];
    $query1 = "INSERT INTO menu_items (name) values ('$kat')";

    $insert = mysqli_query($conn,$query1);
    if ($insert == 1) {
        $_SESSION['msg'] = 'Berhasil menambahkan kategori';
        header('location:menu.php?');
    } else {
        $_SESSION['msg'] = 'Gagal menambahkan kategori!!!';
        header('location: menu.php');
    }
}
$menu = "SELECT * from menu_items";
$data = mysqli_query($conn, $menu);


require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Forms</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="index.php">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="pelanggan.php">Pelanggan</a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#"><?= $title; ?></a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title"><?= $title; ?></div>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            
                            <div class="form-group" style="color: white;">
                                <label for="largeInput">Menu</label>
                                <input type="text" name="name" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group" style="color: white;">
                                <label for="largeInput">Harga</label>
                                <input type="text" name="price" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group" style="color: white;">
                                <label for="largeInput">stok</label>
                                <input type="text" name="stok" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group" style="color: white;">
                                <label for="largeInput">point</label>
                                <input type="text" name="redeemable_points" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="card-action">
                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                               
                                <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-danger">Batal</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'afooter.php';
?>