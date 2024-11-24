<?php
// require 'koneksi.php';
$title = 'Menu';
require 'koneksi.php';

// if (isset($_POST['submit'])) {
//     $customer_id = $_POST['customer_id'];
//     $cashier = $_SESSION['cashier'];
//     $discount_id = $_POST['discount_id'];
//     $total_amount = $_POST['total_amount'];

//     $query1 = mysqli_query($conn, "insert into orders(custemer_id,cashier,discount_id,total amount) values('$customer_id','$cashier','$discount_id','$total_amount')");
//     $query2 = mysqli_query($conn, "select * from orders limit 1 desc");

//     while($row = mysqli_fetch_array($query2)){
//         $id_order = $row['id'];
//     }

//     $query3 = mysqli_query($conn, "select count(menu_item_id) as jumlahmenu from menu_items");

//     while($row2 = mysqli_fetch_array($query3)){
//         $jumlah_menu = $row['jumlahmenu'];
//     }

//     $count_incre = 1;

//     while($count_incre < $jumlah_menu){
//         $menu_id = $_POST['menu_id$count_incre'];
//         $quantity = $_POST['quantity$count_incre'];
//         $price = $_POST['price$count_incre'];

//         if($quantity > 0){
//             $query4 = mysqli_query($conn, "insert into order_items(order_id,menu_item_id,quantity,price) values('$id_order','$menu_id','$quantity','$price')");
//         }
            
        
        
//         $count_incre++; 
//     }
// }

$customer_id = $_POST['customer_id'];
$cashier = $_POST['cashier'];
$discount_id = $_POST['discount_id'];

// Query untuk insert ke tabel orders
$query = "INSERT INTO orders (customer_id, cashier, discount_id, order_date) 
          VALUES ('$customer_id', '$cashier', '$discount_id', CURRENT_TIMESTAMP)";
$conn->query($query);

// Redirect ke halaman tambah order item dengan ID order terbaru
$order_id = $conn->insert_id; // Ambil ID order terakhir
header("Location: tambah_order_item.php?order_id=$order_id");

require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>
<!-- <div class="page-header">
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
                        <div class="card-body">
                            <div class="form-group">
                                <label for="largeInput">Order</label>
                                <input type="text" name="order_id" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">customer</label>
                                <input type="text" name="customer_id" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Kasir</label>
                                <input type="text" name="cashier" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">discount</label>
                                <input type="text" name="discount_id" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Oredr dare</label>
                                <input type="text" name="order_date" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">total</label>
                                <input type="text" name="total_amount" class="form-control form-control" id="defaultInput" placeholder="Nama...">
                            </div>
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
            </div> -->
            <form method="POST">
    Customer ID: <input type="text" name="customer_id"><br>
    Cashier: <input type="text" name="cashier"><br>
    Discount ID: <input type="text" name="discount_id"><br>
    <button type="submit">Buat Order</button>
</form>

<?php
require 'afooter.php';
?>