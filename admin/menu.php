<?php
// require 'koneksi.php';
$title = 'Menu';
require 'aheader.php';
?>

<div class="page-header">
    <h1 class="fw-bold mb-3">
        <?= $title; ?>
    </h1>
</div>

<div class="container my-5">
    <!-- Tombol Create Menu -->
    <div class="text-end mb-3">
        <button class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Menu
        </button>
    </div>

    <!-- Navpills -->
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-food-tab" data-bs-toggle="pill" data-bs-target="#pills-food" type="button" role="tab" aria-controls="pills-food" aria-selected="true">
                <i class="fas fa-utensils"></i> Food
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-beverage-tab" data-bs-toggle="pill" data-bs-target="#pills-beverage" type="button" role="tab" aria-controls="pills-beverage" aria-selected="false">
                <i class="fas fa-coffee"></i> Beverage
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="pills-tabContent">
        <!-- Food Section -->
        <div class="tab-pane fade show active" id="pills-food" role="tabpanel" aria-labelledby="pills-food-tab">
            <div class="row g-4">
                <?php
                $foods = [
                    ['img' => 'food1.jpg', 'name' => 'Burger', 'price' => 'Rp 25.000'],
                    ['img' => 'food2.jpg', 'name' => 'Pizza', 'price' => 'Rp 50.000'],
                    ['img' => 'food3.jpg', 'name' => 'Pasta', 'price' => 'Rp 30.000'],
                    ['img' => 'food4.jpg', 'name' => 'Salad', 'price' => 'Rp 20.000'],
                    ['img' => 'food5.jpg', 'name' => 'Sushi', 'price' => 'Rp 40.000'],
                    ['img' => 'food6.jpg', 'name' => 'Steak', 'price' => 'Rp 70.000']
                ];
                foreach ($foods as $food) {
                    echo "
                        <div class='col-md-4'>
                            <div class='card'>
                                <img src='images/{$food['img']}' class='card-img-top' alt='{$food['name']}'>
                                <div class='card-body'>
                                    <h5 class='card-title'>{$food['name']}</h5>
                                    <p class='card-text'>{$food['price']}</p>
                                    <div class='d-flex justify-content-between'>
                                        <button class='btn btn-warning btn-sm'>
                                            <i class='fas fa-edit'></i> Edit
                                        </button>
                                        <button class='btn btn-danger btn-sm'>
                                            <i class='fas fa-trash'></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                ?>
            </div>
        </div>

        <!-- Beverage Section -->
        <div class="tab-pane fade" id="pills-beverage" role="tabpanel" aria-labelledby="pills-beverage-tab">
            <div class="row g-4">
                <?php
                $beverages = [
                    ['img' => 'beverage1.jpg', 'name' => 'Coffee', 'price' => 'Rp 15.000'],
                    ['img' => 'beverage2.jpg', 'name' => 'Tea', 'price' => 'Rp 10.000'],
                    ['img' => 'beverage3.jpg', 'name' => 'Smoothie', 'price' => 'Rp 20.000'],
                    ['img' => 'beverage4.jpg', 'name' => 'Juice', 'price' => 'Rp 12.000'],
                    ['img' => 'beverage5.jpg', 'name' => 'Milkshake', 'price' => 'Rp 18.000'],
                    ['img' => 'beverage6.jpg', 'name' => 'Soda', 'price' => 'Rp 8.000']
                ];
                foreach ($beverages as $beverage) {
                    echo "
                        <div class='col-md-4'>
                            <div class='card'>
                                <img src='images/{$beverage['img']}' class='card-img-top' alt='{$beverage['name']}'>
                                <div class='card-body'>
                                    <h5 class='card-title'>{$beverage['name']}</h5>
                                    <p class='card-text'>{$beverage['price']}</p>
                                    <div class='d-flex justify-content-between'>
                                        <button class='btn btn-warning btn-sm'>
                                            <i class='fas fa-edit'></i> Edit
                                        </button>
                                        <button class='btn btn-danger btn-sm'>
                                            <i class='fas fa-trash'></i> Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                ?>
            </div>
        </div>
    </div>
</div>



<?php
require 'afooter.php';
?>