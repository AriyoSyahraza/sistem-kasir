<?php
// require 'koneksi.php';
$title = 'Discount';
require 'koneksi.php';
require 'aheader.php';

if (isset($_POST['submit'])) {
    $nama_discount = $_POST['nama_discount'];
    $percent = $_POST['percent'];
    $range = $_POST['range'];
    $date = $_POST['date'];

    // Query untuk menyimpan data
    $sql = mysqli_query($conn, "INSERT INTO discount(name, percentage, range_days, applied_at) 
            VALUES('$nama_discount', $percent, $range, '$date')");

    if ($conn->query($sql) === TRUE) {
        $message = "Data berhasil disimpan!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">Form Input</div>
      </div>
      <form action="" method="POST">
        <div class="card-body">
          <div class="form-group">
            <label for="nama_discount">Nama Discount</label>
            <input
              type="text"
              class="form-control"
              id="nama_discount"
              name="nama_discount"
              placeholder="Masukkan Nama"
              required
            />
          </div>
          
          <div class="form-group">
            <label for="percent">Presentase</label>
            <input
              type="number"
              class="form-control"
              id="percent"
              name="percent"
              placeholder="Masukkan Jumlah presentase"
              required
            />
          </div>
          <div class="form-group">
            <label for="range">Rentang Waktu</label>
            <input
              type="number"
              class="form-control"
              id="range"
              name="range"
              placeholder="Masukkan Rentang Waktu"
              required
            />
          </div>
          <div class="form-group">
            <label for="date">Tanggal Aplikasi Discount</label>
            <input
              type="date"
              class="form-control"
              id="date"
              name="date"
              required
            />
          </div>
        </div>
        <div class="card-action">
          <button type="submit" name="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>




<?php
require 'afooter.php';
?>