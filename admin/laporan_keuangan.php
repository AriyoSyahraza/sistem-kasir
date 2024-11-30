<?php
require 'koneksi.php';
$title = 'Laporan Keuangan';
require 'aheader.php';

$query = "
    SELECT 
        order_date, 
        SUM(total_amount) AS total_amount
    FROM 
        orders
    GROUP BY 
        order_date
    ORDER BY 
        order_date ASC;
";

$result = mysqli_query($conn, $query);

// Simpan hasil dalam array
$data = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            'order_date' => $row['order_date'],
            'total_amount' => $row['total_amount']
        ];
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>


<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="container my-5">
    

    <!-- Filter Tanggal -->
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="start-date">Dari Tanggal</label>
            <input type="date" id="start-date" class="form-control">
        </div>
        <div class="col-md-4">
            <label for="end-date">Ke Tanggal</label>
            <input type="date" id="end-date" class="form-control">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button id="reset-filter" class="btn btn-primary w-100">
                <i class="icon-loop"></i> Reset
            </button>
        </div>
    </div>

    <!-- Tabel Discount -->
    <div class="table-responsive">
        <table id="multi-filter-select" class="table table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Total Omset (Rp)</th>

                </tr>
            </thead>
            <tbody>
            <?php
                if (!empty($data)) {
                    $i=1;
                    foreach ($data as $row) {
                        // Format tanggal ke Day, Date Month Year
                        $formatted_date = date('l, d F Y', strtotime($row['order_date']));
                        echo "
                        <tr>
                            
                            <td>$i</td>
                            <td>{$formatted_date}</td>
                            <td>". number_format($row['total_amount'], 0, ',', '.') . "</td>
                        </tr>
                        ";
                        $i++;
                    }
                } else {
                    echo "
                    <tr>
                        <td colspan='2' class='text-center'>No data available</td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>





<?php
require 'afooter.php';
?>