<?php require_once 'includes/header.php'; ?>

<!-- Banner cố định 2 bên -->
<?php require_once 'app/views/slice-bar/left_right.php'; ?>

<div class="overlay">
    <div class="container">
        <!-- Lịch sử xem xe -->
        <?php require_once 'app/views/cars/history_view_car.php'; ?>

        <!-- Slider -->
        <?php require_once 'app/views/slice-bar/banner.php'; ?>

        <!-- Bộ lọc và ô tìm kiếm -->
        <div class="row">
            <!-- Cột bên trái: Bộ lọc -->
            <div class="col-lg-3">
                <?php require_once 'app/views/cars/filter.php'; ?>
            </div>

            <!-- Cột bên phải: Danh sách xe -->
            <div class="col-lg-9">
                <?php require_once 'app/views/cars/car_list.php'; ?>
            </div>
        </div>

        <!-- Xe đã qua sử dụng -->
        <div class="mb-5">
            <?php require_once 'app/views/used_cars/list_used_cars.php'; ?>
        </div>

        <!-- Tin tức -->
        <div>
            <?php require_once 'app/views/news/news.php'; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>