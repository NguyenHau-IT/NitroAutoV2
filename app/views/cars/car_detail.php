<?php require_once 'includes/header.php'; ?>

<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <!-- spell-check-ignore -->
                <a href="/home" class="text-decoration-none">Trang chủ</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="/cars_brand/<?= urlencode($car['brand_id']) ?>?brand=<?= urlencode($car['brand_name']) ?>" class="text-decoration-none">
                    Xe <?= htmlspecialchars($car['brand_name']) ?>
                </a>
            </li>
            <li class="breadcrumb-item active text-secondary" aria-current="page">
                <?= htmlspecialchars($car['name']) ?>
            </li>
        </ol>
    </nav>
    <h1 class="text-center text-info-emphasis fs-1 fw-bold mb-5">
        <?= htmlspecialchars($car['name']) ?>
    </h1>

    <div class="row g-4">
        <!-- Thông tin xe -->
        <div class="col-lg-6">
            <div class="rounded-4 shadow-lg p-4 bg-light text-black">
                <h3 class="text-success fs-4 mb-3"><i class="bi bi-info-circle me-2"></i>Thông tin xe</h3>
                <div class="d-flex flex-column gap-3">
                    <!-- Hãng & Giá & Mã lực -->
                    <div class='d-flex justify-content-between border-bottom pb-2'>
                        <div class='w-100'>
                            <span class='fw-bold'>Hãng xe:</span>
                            <span class='fs-5'><?= htmlspecialchars($car['brand_name']) ?></span>
                        </div>
                    </div>

                    <div class='d-flex justify-content-between border-bottom pb-2'>
                        <div class='w-50'>
                            <span class='fw-bold'>Giá:</span>
                            <span class='fs-5 text-danger fw-bold'><?= number_format($car['price'], 0, ',', '.') ?> VNĐ</span>
                        </div>
                        <div class='w-50 text-end'>
                            <span class='fw-bold'>Mã lực:</span>
                            <span class='fs-5'><?= htmlspecialchars($car['horsepower']) ?> HP</span>
                        </div>
                    </div>

                    <?php
                    $carInfoPairs = [
                        ['Năm sản xuất', $car['year'], 'Loại nhiên liệu', $car['fuel_type']],
                        ['Hộp số', $car['transmission'], 'Màu sắc', $car['color']],
                        ['Quãng đường', number_format($car['mileage'], 0, ',', '.') . ' km', 'Loại xe', $car['category_name']]
                    ];

                    foreach ($carInfoPairs as $pair) {
                        echo "<div class='d-flex justify-content-between border-bottom pb-2'>
                                <div class='w-50'><span class='fw-bold'>{$pair[0]}:</span> <span class='fs-5'>" . htmlspecialchars($pair[1]) . "</span></div>
                                <div class='w-50 text-end'><span class='fw-bold'>{$pair[2]}:</span> <span class='fs-5'>" . htmlspecialchars($pair[3]) . "</span></div>
                              </div>";
                    }
                    ?>

                    <!-- Mô tả -->
                    <div class='d-flex flex-column border-bottom pb-2'>
                        <span class='fw-bold'>Mô tả:</span>
                        <div class="fs-5" style="height: 150px; overflow-y: auto;">
                            <?= nl2br(htmlspecialchars($car['description'] ?? '')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hình ảnh -->
        <div class="col-lg-6">
            <div class="rounded-4 shadow-lg p-4 bg-light text-center">

                <?php
                // Chuẩn bị danh sách media
                $mediaSlides = [];

                if (!empty($images)) {
                    foreach ($images as $img) {
                        if (in_array($img['image_type'], ['normal', '3D'])) {
                            $mediaSlides[] = $img;
                        }
                    }
                }

                // Nếu không có ảnh nào thì dùng ảnh mặc định
                if (empty($mediaSlides)) {
                    $mediaSlides[] = [
                        'image_type' => 'normal',
                        'image_url' => '/uploads/cars/default.jpg'
                    ];
                }
                ?>

                <div id="mediaCarousel" class="carousel slide rounded-4 overflow-hidden" data-bs-ride="carousel">
                    <div class="carousel-inner">

                        <?php foreach ($mediaSlides as $index => $media): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <?php if ($media['image_type'] === '3D'): ?>
                                    <iframe src="<?= htmlspecialchars($media['image_url']) ?>"
                                        allow="autoplay; fullscreen; xr-spatial-tracking"
                                        allowfullscreen
                                        style="height: 500px; width: 100%; border: none;"></iframe>
                                <?php else: ?>
                                    <img src="<?= htmlspecialchars($media['image_url']) ?>"
                                        class="d-block w-100 img-fluid"
                                        style="height: 500px; object-fit: cover;"
                                        alt="Ảnh xe">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>

                    <?php if (count($mediaSlides) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <!-- Nút hành động -->
    <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
        <a href="/home" class="btn btn-primary btn-lg">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>

        <form action="/compare" method="POST">
            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle me-2"></i> <span>So sánh</span>
            </button>
        </form>

        <!-- Nút yêu thích bằng AJAX -->
        <div id="favorite-toggle" data-car-id="<?= htmlspecialchars($car['id']) ?>" data-favorited="<?= $favorites ? '1' : '0' ?>">
            <button type="button" class="btn btn-lg <?= $favorites ? 'btn-secondary' : 'btn-danger' ?>" id="favorite-btn">
                <i class="bi <?= $favorites ? 'bi-heartbreak-fill' : 'bi-heart-fill' ?>"></i>
                <span><?= $favorites ? 'Bỏ yêu thích' : 'Yêu thích' ?></span>
            </button>
        </div>

        <?php if ($car['stock'] > 0): ?>
            <form action="/OrderForm" method="POST">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-cart"></i> Đặt mua
                </button>
            </form>

            <form action="/testdriveform" method="POST">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                <button type="submit" class="btn btn-warning btn-lg text-dark">
                    <i class="bi bi-car-front-fill"></i> Đăng ký lái thử
                </button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center w-100 mt-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Xe hiện <strong>tạm hết hàng</strong>. Vui lòng quay lại sau hoặc chọn mẫu xe khác.
            </div>
        <?php endif; ?>
    </div>

    <!-- Danh sách xe khác -->
    <div class="bg-info rounded-4 mt-4 p-4">
        <h2 class="text-center text-white mb-4">
            <i class="bi bi-car-front me-2"></i>Các mẫu xe khác
        </h2>
        <?php require_once 'list.php'; ?>
    </div>

    <div class="bg-info rounded-4 mt-4 p-4">
        <?php
        $carLocal = $car;
        require_once 'app/views/reviews/reviews_car.php'; ?>
    </div>
</div>

<?php require_once  'includes/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const favToggle = document.getElementById("favorite-toggle");

        if (!favToggle) return;

        const button = document.getElementById("favorite-btn");
        const carId = favToggle.dataset.carId;
        let isFavorited = favToggle.dataset.favorited === '1';

        button?.addEventListener("click", function() {
            const url = isFavorited ? "/remove_favorite" : "/add_favorite";
            const formData = new FormData();
            formData.append("car_id", carId);

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error("Không thể cập nhật trạng thái yêu thích.");
                    return response.text();
                })
                .then(() => {
                    isFavorited = !isFavorited;
                    favToggle.dataset.favorited = isFavorited ? '1' : '0';

                    // Cập nhật giao diện nút
                    button.classList.toggle("btn-danger", !isFavorited);
                    button.classList.toggle("btn-secondary", isFavorited);
                    button.querySelector("i").className = isFavorited ? "bi bi-heartbreak-fill" : "bi bi-heart-fill";
                    button.querySelector("span").textContent = isFavorited ? "Bỏ yêu thích" : "Yêu thích";
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Đã xảy ra lỗi. Vui lòng thử lại.");
                });
        });
    });
</script>