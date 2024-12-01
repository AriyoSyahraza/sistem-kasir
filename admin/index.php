<?php

 require 'koneksi.php';

$title = 'Dashboard';
require 'aheader.php';

// Ambil bulan, tahun, dan minggu yang dipilih dari parameter GET atau gunakan default
$selectedMonth = $_GET['month'] ?? date('m');
$selectedYear = $_GET['year'] ?? date('Y');
$selectedWeek = $_GET['week'] ?? 1;

// Query untuk mendapatkan daftar bulan dan tahun dari tabel orders
$queryMonths = "SELECT DISTINCT DATE_FORMAT(order_date, '%m') AS month FROM orders ORDER BY month ASC";
$queryYears = "SELECT DISTINCT DATE_FORMAT(order_date, '%Y') AS year FROM orders ORDER BY year DESC";
$resultMonths = mysqli_query($conn, $queryMonths);
$resultYears = mysqli_query($conn, $queryYears);

$months = [];
$years = [];
if ($resultMonths) {
    while ($row = mysqli_fetch_assoc($resultMonths)) {
        $months[] = $row['month'];
    }
}
if ($resultYears) {
    while ($row = mysqli_fetch_assoc($resultYears)) {
        $years[] = $row['year'];
    }
}

// Data total orders dan revenue untuk bulan dan tahun yang dipilih
$queryMonthlyData = "SELECT COUNT(order_id) AS total_orders, SUM(total_amount) AS total_revenue 
                     FROM orders 
                     WHERE MONTH(order_date) = $selectedMonth AND YEAR(order_date) = $selectedYear";
$resultMonthlyData = mysqli_query($conn, $queryMonthlyData);
$monthlyOrders = 0;
$monthlyRevenue = 0;
if ($resultMonthlyData && mysqli_num_rows($resultMonthlyData) > 0) {
    $monthlyData = mysqli_fetch_assoc($resultMonthlyData);
    $monthlyOrders = $monthlyData['total_orders'] ?? 0;
    $monthlyRevenue = $monthlyData['total_revenue'] ?? 0;
}

// Data untuk total orders dan revenue hari ini
$currentDate = date('Y-m-d');
$queryDailyData = "SELECT COUNT(order_id) AS total_orders, SUM(total_amount) AS total_revenue 
                   FROM orders 
                   WHERE DATE(order_date) = '$currentDate'";
$resultDailyData = mysqli_query($conn, $queryDailyData);
$dailyOrders = 0;
$dailyRevenue = 0;
if ($resultDailyData && mysqli_num_rows($resultDailyData) > 0) {
    $dailyData = mysqli_fetch_assoc($resultDailyData);
    $dailyOrders = $dailyData['total_orders'] ?? 0;
    $dailyRevenue = $dailyData['total_revenue'] ?? 0;
}

// Data untuk grafik berdasarkan minggu
$startOfWeek = date("Y-m-d", strtotime("{$selectedYear}-{$selectedMonth}-01 + " . ($selectedWeek - 1) . " weeks"));
$endOfWeek = date("Y-m-d", strtotime("{$startOfWeek} +6 days"));

$queryWeeklyData = "SELECT DATE(order_date) AS date, COUNT(order_id) AS total_orders, SUM(total_amount) AS total_revenue 
                    FROM orders 
                    WHERE order_date BETWEEN '$startOfWeek' AND '$endOfWeek'
                    GROUP BY DATE(order_date)";
$resultWeeklyData = mysqli_query($conn, $queryWeeklyData);

$weeklyData = [];
for ($i = 0; $i < 7; $i++) {
    $day = date("Y-m-d", strtotime("{$startOfWeek} +{$i} days"));
    $weeklyData[$day] = ['total_orders' => 0, 'total_revenue' => 0];
}

if ($resultWeeklyData) {
    while ($row = mysqli_fetch_assoc($resultWeeklyData)) {
        $weeklyData[$row['date']] = [
            'total_orders' => $row['total_orders'],
            'total_revenue' => $row['total_revenue']
        ];
    }
}
?>

<div class="page-header">
    <h1 class="fw-bold mb-3 text-center"><?= $title; ?></h1>
</div>

<div class="container my-5">
    <!-- Dropdown untuk memilih bulan dan tahun -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="" method="GET" class="d-flex align-items-center">
            <label for="month" class="form-label me-2 fw-bold">Bulan:</label>
            <select id="month" name="month" class="form-select w-auto me-3" onchange="this.form.submit()">
                <?php foreach ($months as $month): ?>
                    <option value="<?= $month; ?>" <?= $month == $selectedMonth ? 'selected' : ''; ?>>
                        <?= date('F', mktime(0, 0, 0, $month, 10)); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="year" class="form-label me-2 fw-bold">Tahun:</label>
            <select id="year" name="year" class="form-select w-auto me-3" onchange="this.form.submit()">
                <?php foreach ($years as $year): ?>
                    <option value="<?= $year; ?>" <?= $year == $selectedYear ? 'selected' : ''; ?>>
                        <?= $year; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <!-- Card besar dengan total orders dan revenue -->
    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="fw-bold text-primary">Total Orders</p>
                    <p class="display-4 text-primary"><?= $monthlyOrders; ?></p>
                </div>
                <div class="col-md-6">
                    <p class="fw-bold text-success">Total Revenue</p>
                    <p class="display-4 text-success">Rp <?= number_format($monthlyRevenue, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Line Chart dan Card Kecil -->
    <div class="row g-4">
        <!-- Grafik -->
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Grafik Mingguan</h5>
                    <form action="" method="GET" class="d-flex align-items-center mb-4">
                        <label for="week" class="form-label me-2 fw-bold">Minggu:</label>
                        <select id="week" name="week" class="form-select w-auto" onchange="this.form.submit()">
                            <?php for ($w = 1; $w <= 5; $w++): ?>
                                <option value="<?= $w; ?>" <?= $w == $selectedWeek ? 'selected' : ''; ?>>Minggu Ke-<?= $w; ?></option>
                            <?php endfor; ?>
                        </select>
                        <input type="hidden" name="month" value="<?= $selectedMonth; ?>">
                        <input type="hidden" name="year" value="<?= $selectedYear; ?>">
                    </form>
                    <canvas id="weeklyChart" style="height: 200px;"></canvas>
                </div>
            </div>
        </div>
        <!-- Card Today -->
        <div class="col-md-4">
            <div class="card shadow-sm border-info mb-3">
                <div class="card-body">
                    <h5 class="card-title text-info">Total Orders Today</h5>
                    <p class="card-text display-5 text-info"><?= $dailyOrders; ?></p>
                </div>
            </div>
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">Total Revenue Today</h5>
                    <p class="card-text display-5 text-warning">Rp <?= number_format($dailyRevenue, 0, ',', '.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    const data = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Total Orders',
            data: [
                <?php foreach ($weeklyData as $day => $data): ?>
                    <?= $data['total_orders']; ?>,
                <?php endforeach; ?>
            ],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true,
            tension: 0.4
        }]
    };

    const options = {
        plugins: {
            tooltip: {
                callbacks: {
                    afterLabel: function(context) {
                        const revenue = <?= json_encode(array_column($weeklyData, 'total_revenue')); ?>[context.dataIndex];
                        return `Total: Rp ${new Intl.NumberFormat('id-ID').format(revenue)}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1,
                ticks: {
                    precision: 0
                }
            }
        }
    };

    new Chart(ctx, {
        type: 'line',
        data: data,
        options: options
    });
</script>

<?php require 'afooter.php'; ?>
