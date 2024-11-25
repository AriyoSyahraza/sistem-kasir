<?php
require 'koneksi.php';
$title = 'Tambah Customer';

if (isset($_POST['submit'])) {
    $nama = $_POST['name'];
    $telp = $_POST['phone_number'];
    $points = $_POST['points'];
    $status = $_POST['status']; 

    $query = "INSERT INTO customers (name, phone_number, points, status ) values ('$nama', '$telp', '$points', '$status')";

    $insert = mysqli_query($conn, $query);
    if ($insert == 1) {
        $_SESSION['msg'] = 'Berhasil menambahkan pelanggan baru';
        header('location:customer.php?');
    } else {
        $_SESSION['msg'] = 'Gagal menambahkan data baru!!!';
        header('location: customer.php');
    }
}



require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="page-header">
              <h3 class="fw-bold mb-3">Forms</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Forms</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Basic Form</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Judul Form</div>
                  </div>
                  <div class="row">
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title"><?= $title; ?></div>
                    </div>
                    <form action="" method="POST">
                        
                            
                            
                            
                            <div class="form-group">
                                <label for="largeInput">Nama</label>
                                <input type="text" name="name" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">No telepon</label>
                                <input type="text" name="phone_number" class="form-control form-control" id="defaultInput" placeholder="No. Telp">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Points</label>
                                <input type="text" name="points" class="form-control form-control" id="defaultInput" placeholder="Points...">
                            </div>
                            <div class="form-group">
                                <label for="defaultSelect">Status</label>
                                <select name="status" class="form-control" id="defaultSelect">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>

                  
                            
                        
                            <div class="card-action">
                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                <!-- <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-danger">Batal</a> -->
                            </div>
                    </form>
                </div>
            </div>
        </div>

<?php
require 'afooter.php';
?>