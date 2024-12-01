<?php
 require 'koneksi.php';
 $title = 'Detail Pesanan';
// Ambil order_id dari URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// Ambil data pesanan
$query_order = "
    SELECT o.*, c.name AS customer_name, u.username AS cashier_name, d.name AS discount_name, d.percentage AS discount_percentage
    FROM orders o
    JOIN customers c ON o.customer_id = c.customer_id
    JOIN user u ON o.cashier = u.user_id
    LEFT JOIN discount d ON o.discount_id = d.discount_id
    WHERE o.order_id = $order_id ";

// $query_order =" SELECT o.* , c.name, u.username, d.name , d.percentage FROM orders o JOIN customers c ON o.customer_id = c.customer_id JOIN user u ON o.cashier = user_id JOIN discount d ON o.discount_id = d.discount_id WHERE o.order_id = $order_id";
$result_order = mysqli_query($conn, $query_order);
$order = mysqli_fetch_assoc($result_order);

if (!$order) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

$query_items = "
    SELECT oi.*, mi.name 
    FROM order_items oi
    JOIN menu_items mi ON oi.menu_item_id = mi.menu_item_id
    WHERE oi.order_id = $order_id ";
$result_items = mysqli_query($conn, $query_items);

if (!$result_items) {
    die("Query gagal: " . mysqli_error($conn));
}

require 'aheader.php';
?>
<div class="row">
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">
                        <div class="card-title"><?= $title; ?></div>
                    </div>
                    <form action="" method="POST">
                        
                            
                            
                            <div class="form-group">
                                <label >Customer</label>
                                <input type="text"  class="form-control" value="<?= $order['customer_name']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Kasir</label>
                                <input type="text"  class="form-control" value="<?= $order['cashier']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Diskon</label>
                                <input type="text"  class="form-control" value="<?= $order['discount_name']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label >Total Harga</label>
                                <input type="text"  class="form-control" value=" Rp <?= number_format($order['total_amount'], 2, ',', '.'); ?>" readonly>
                            </div>
    
                         
        

        

        
        <div class="form-group">
                                <label for="menu_list">Daftar Menu</label>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Menu</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="menuTable">
                                        <?php while ($item = mysqli_fetch_assoc($result_items)) { ?>
                                            <tr>
                                            <td><?= htmlspecialchars($item['name']); ?></td>
                                            <td>Rp <?= number_format($item['price']); ?></td>
                                            <td><?= $item['quantity']; ?></td>
                                            <td>Rp <?= number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></td> 
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
    </div>

</div>
<?php  
require  'afooter.php';
?>