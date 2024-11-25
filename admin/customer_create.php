<?php
// require 'koneksi.php';
$title = 'Tambah Customer';

if (isset($_POST['btn-simpan'])) {
    $nama = $_POST['nama'];
    
    $query = "INSERT INTO costumer (nama) values ('$nama')";

    $insert = mysqli_query($conn, $query);
    if ($insert == 1) {
        $_SESSION['msg'] = 'Berhasil menambahkan pelanggan baru';
        header('location:pelanggan.php?');
    } else {
        $_SESSION['msg'] = 'Gagal menambahkan data baru!!!';
        header('location: pelanggan.php');
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
                  <div class="card-body">
                    <div class="row">
                      
                      <div class="col-md-6 col-lg-4">
                        
                        

                        <div class="form-group">
                          <label for="largeInput">Nama</label>
                          <input
                            type="text"
                            class="form-control form-control"
                            id="defaultInput"
                            placeholder="Default Input"
                          />
                        </div>
                        <div class="form-group">
                          <label for="defaultSelect">Pilihan</label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                          >
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-action">
                    <button class="btn btn-success" name="btn-simpan">Submit</button>
                  </div>
                </div>
              </div>
            </div>

<?php
require 'afooter.php';
?>