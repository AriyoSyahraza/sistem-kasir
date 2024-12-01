<?php
 require 'koneksi.php';

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

    <div class="container">
        <h1>Detail Pesanan #<?= $order_id; ?></h1>
        <div class="order-info">
            <h3>Informasi Pesanan</h3>
            <p><strong>Customer:</strong> <?= $order['customer_name']; ?></p>
            <p><strong>Kasir:</strong> <?= $order['cashier']; ?></p>
            <p><strong>Diskon:</strong> <?= $order['discount_name'] ? $order['discount_name'] . " ({$order['discount_percentage']}%)" : 'Tidak ada'; ?></p>
            <p><strong>Total :</strong> Rp <?= number_format($order['total_amount'], 2, ',', '.'); ?></p>
            
        </div>

        <div class="order-items">
            <h3>Item Pesanan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
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
<?php  
require  'afooter.php';
?>