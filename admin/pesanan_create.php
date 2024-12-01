<?php
// require 'koneksi.php';
$title = 'Pesanan';
require 'koneksi.php';



$query_customer = "SELECT customer_id, name FROM customers";
$result_customer = mysqli_query($conn, $query_customer);

$query_kasir = "SELECT user_id, username FROM user";
$result_kasir = mysqli_query($conn, $query_kasir);

$query_diskon = "SELECT discount_id, name, percentage FROM discount";
$result_diskon = mysqli_query($conn, $query_diskon);

$query_menu = "SELECT menu_item_id, name, price, stok FROM menu_items";
$result_menu = mysqli_query($conn, $query_menu);

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

    $query_discount = mysqli_query($conn, "SELECT percentage FROM discount WHERE discount_id = '$discount_id'");
    $discount_percentage = 0;
    if ($row = mysqli_fetch_assoc($query_discount)) {
        $discount_percentage = $row['percentage'];
    }

    $discount_amount = ($total_amount * $discount_percentage) / 100;
    $final_total = $total_amount - $discount_amount;


    $count_incre = 1;

    while($count_incre < $jumlah_menu){
        $menu_id = $_POST["menu_item_id{$count_incre}"];;
        $quantity = $_POST["quantity{$count_incre}"];
        $price = $_POST["price{$count_incre}"];

        if($quantity > 0){
            $query4 = mysqli_query($conn, "insert into order_items(order_id,menu_item_id,quantity,price) values('$id_order','$menu_id','$quantity','$price')");
        }
            
        
        
        $count_incre++; 
    }

    while ($row = mysqli_fetch_assoc($result_diskon)) {
        var_dump($row);
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
header("Location: pesanan.php");

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
                                        <option value="<?= $row['discount_id'] ?>" <?= isset($form_data['discount_id']) && $form_data['discount_id'] == $row['discount_id'] ? 'selected' : '' ?> data-percentage="<?= $row['percentage'] ?>"><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="id_komponen">Discount</label>
                                <select class="form-control" id="discount_id" name="discount_id" required>
                                    <option value="" data-percentage="0">Pilih Diskon</option>
                                    <?php while ($row = mysqli_fetch_assoc($result_diskon)) { ?>
                                        <option 
                                            value="<?= $row['discount_id'] ?>" 
                                            data-percentage="<?= $row['percentage'] ?>">
                                            <?= $row['name'] ?> (<?= $row['percentage'] ?>%)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div> -->



                            
                            <div class="form-group">
                                <label for="menu_list">Daftar Menu</label>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Menu</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="menuTable">
                                        <?php while ($row = mysqli_fetch_assoc($result_menu)) { ?>
                                            <tr>
                                                <td name = "menu_item_id<?=$row['menu_item_id']?>"><?= $row['menu_item_id']?></td>
                                                <td><?= $row['name'] ?></td>
                                                <td name="price<?= $row['menu_item_id'] ?>" id="price<?= $row['menu_item_id'] ?>"><?= $row['price'] ?></td>
                                                <td>
                                                    <input name="quantity<?= $row['menu_item_id'] ?>"  type="number" id="quantity<?= $row['menu_item_id'] ?>" class="form-control quantity" 
                                                          data-price="<?= $row['price'] ?>" value="0" min="0" style="width: 100px;">
                                                </td>
                                                
                                                <td>
                                                    <button type="button" class="btn btn-primary addMenu" data-id="<?= $row['menu_item_id'] ?>" 
                                                            data-name="<?= $row['name'] ?>" data-price="<?= $row['price'] ?>">Tambah</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label for="orderList">Pesanan</label>
                                <table class="table table-bordered" id="orderList">
                                    <thead>
                                        <tr>
                                            <th>Nama Menu</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Pesanan akan ditambahkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="form-group">
                                <label for="discountAmount">Diskon</label>
                                <input type="text" id="discountAmount" class="form-control" value="" readonly>
                            </div>
                            <div class="form-group">
                                <label for="totalAmount">Total Amount</label>
                                <input type="number" id="totalAmount"  class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="finalTotal">Total Setelah Diskon</label>
                                <input type="text" id="finalTotal" class="form-control" name="total_amount" value="" readonly>
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