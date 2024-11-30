<?php
// require 'koneksi.php';
$title = 'Pesanan';
require 'koneksi.php';



$query_customer = "SELECT customer_id, name FROM customers";
$result_customer = mysqli_query($conn, $query_customer);

$query_kasir = "SELECT user_id, username FROM user";
$result_kasir = mysqli_query($conn, $query_kasir);

$query_diskon = "SELECT discount_id, name FROM discount";
$result_diskon = mysqli_query($conn, $query_diskon);

if (isset($_POST['submit'])) {

    $customer_id = $_POST['customer_id'];
    $cashier = $_SESSION['user_id'];
    $discount_id = $_POST['discount_id'];
    $total_amount = $_POST['total_amount'];

    $query1 = mysqli_query($conn, "insert into orders(customer_id,cashier,discount_id,total_amount) values('$customer_id','$cashier','$discount_id','$total_amount')");
    $query2 = mysqli_query($conn, "select * from orders order by order_id DESC limit 1");

    while($row = mysqli_fetch_array($query2)){
        $id_order = $row['order_id'];
    }

    $query3 = mysqli_query($conn, "select count(menu_item_id) as jumlahmenu from menu_items order by menu_item_id asc");

    while($row2 = mysqli_fetch_array($query3)){
        $jumlah_menu = $row['jumlahmenu'];
    }

    $count_incre = 1;

    while($count_incre < 3){
        $menu_id = $count_incre;
        $quantity = 1;
        $price = $_POST["price{$count_incre}"];

        if($quantity > 0){
            $query4 = mysqli_query($conn, "insert into order_items(order_id,menu_item_id,quantity,price) values('$id_order','$menu_id','$quantity','$price')");
        }
            
        
        
        $count_incre++; 
    }


$customer_id = $_POST['customer_id'];
$cashier = $_POST['cashier'];
$discount_id = $_POST['discount_id'];

// Query untuk insert ke tabel orders
// $query = "INSERT INTO orders (customer_id, cashier, discount_id, order_date) 
//           VALUES ('$customer_id', '$cashier', '$discount_id', CURRENT_TIMESTAMP)";
// $conn->query($query);

// Redirect ke halaman tambah order item dengan ID order terbaru
// $order_id = $conn->insert_id; // Ambil ID order terakhir
header("Location: tambah_order_item.php?order_id=$id_order");

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
                                <label for="id_komponen">Customer</label>
                                <select class="form-control" id="customer_id" name="customer_id" required>
                                    <option value="">Pilih Customer</option>
                                    <?php while ($row = mysqli_fetch_assoc($result_customer)) { ?>
                                        <option value="<?= $row['customer_id'] ?>" <?= isset($form_data['customer_id']) && $form_data['customer_id'] == $row['customer_id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_komponen">Kasir</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">Pilih Kasir</option>
                                    <?php while ($row = mysqli_fetch_assoc($result_kasir)) { ?>
                                        <option value="<?= $row['user_id'] ?>" <?= isset($form_data['user_id']) && $form_data['user_id'] == $row['user_id'] ? 'selected' : '' ?>><?= $row['username'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            
                            <div class="form-group">
                                <label for="id_komponen">Discount</label>
                                <select class="form-control" id="discount_id" name="discount_id" required>
                                    <option value="">Pilih Diskon</option>
                                    <?php while ($row = mysqli_fetch_assoc($result_diskon)) { ?>
                                        <option value="<?= $row['discount_id'] ?>" <?= isset($form_data['discount_id']) && $form_data['discount_id'] == $row['discount_id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Menu 1</label>
                                <input type="text" name="price1" class="form-control form-control" id="defaultInput" placeholder="Harga Menu 1...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Menu 2</label>
                                <input type="text" name="price2" class="form-control form-control" id="defaultInput" placeholder="Harga Menu 2...">
                            </div>
                            <div class="form-group">
                                <label for="largeInput">Total</label>
                                <input type="text" name="total_amount" class="form-control form-control" id="defaultInput" placeholder="Total...">
                            </div>
                  
                            
                        
                            <div class="card-action">
                                <button type="submit" name="submit" class="btn btn-success">Submit</button>
                                <!-- <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-danger">Batal</a> -->
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