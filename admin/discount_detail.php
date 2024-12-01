<?php
require 'koneksi.php';
$title = 'Info Discount';

// Ambil ID dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: discount.php");
    exit();
}

// Ambil data diskon berdasarkan ID
$query = "SELECT * FROM discount WHERE discount_id = $id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: discount.php");
    exit();
}

$discount = mysqli_fetch_assoc($result);

// Hitung end date
$applied_at = new DateTime($discount['applied_at']);
$end_date = clone $applied_at;
$end_date->modify("+{$discount['range_days']} days");

// Query untuk transaksi yang menggunakan diskon ini
$order_query = "
SELECT o.order_id, o.order_date, o.total_amount 
FROM orders o 
WHERE o.discount_id = $id
ORDER BY o.order_date ASC
";
$order_result = mysqli_query($conn, $order_query);
$orders = mysqli_fetch_all($order_result, MYSQLI_ASSOC);
require 'aheader.php';
?>

<div class="container my-5">
    <h2 class="text-center mb-4"><?= $title; ?></h2>

    <!-- Card Detail Diskon -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?= $discount['name']; ?></h4>
            <p class="card-text">
                <strong>Percentage:</strong> <?= $discount['percentage']; ?>%<br>
                <strong>Range:</strong> <?= $discount['range_days']; ?> days<br>
                <strong>Applied Date:</strong> <?= $applied_at->format('D, d M Y'); ?><br>
                <strong>End Date:</strong> <?= $end_date->format('D, d M Y'); ?><br>
                <strong>Usage:</strong> <?= count($orders); ?>
                <button id="btn-toggle-table" class="btn btn-info btn-sm ms-2">Selengkapnya</button>
            </p>
        </div>
        <div class="card-body" id="transactions-table-container" style="display: none;">
            <?php if (!empty($orders)): ?>
                <table id="multi-filter-select" class="table table-bordered" data-numeric-columns="[2]">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Order</th>
                            <th>Total Transaksi (rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $index => $order): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= date('D, d M Y', strtotime($order['order_date'])); ?></td>
                                <td><?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center text-muted">Tidak ada transaksi yang menggunakan diskon ini.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Tombol toggle untuk menampilkan dan menyembunyikan tabel
    document.getElementById('btn-toggle-table').addEventListener('click', function () {
        const tableContainer = document.getElementById('transactions-table-container');
        if (tableContainer.style.display === 'none') {
            tableContainer.style.display = 'block';
            this.textContent = 'Sembunyikan';
            this.classList.remove('btn-info');
            this.classList.add('btn-danger');
        } else {
            tableContainer.style.display = 'none';
            this.textContent = 'Selengkapnya';
            this.classList.remove('btn-danger');
            this.classList.add('btn-info');
        }
    });
</script>

<?php require 'afooter.php'; ?>
