<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<!-- Banner cố định 2 bên -->
<?php require_once __DIR__ . '/../../views/slice-bar/left_right.php'; ?>

<div class="overlay">
    <div class="container">
        <div class="text-center">
            <!-- Lịch sử xem xe -->
            <?php require_once __DIR__ . '/history_view_car.php'; ?>

            <!-- Slice Bar -->
            <?php require_once __DIR__ . '/../../views/slice-bar/slider.php'; ?>

            <!-- Bộ lọc và ô tìm kiếm -->
            <?php require_once __DIR__ . '/../../views/cars/filter.php'; ?>

            <div id="car-list-container">
                <div class="mt-4 bg-light rounded-4 shadow p-4 border">
                    <?php if (!empty($cars)): ?>
                        <div class="row g-4 justify-content-center">
                            <?php foreach ($cars as $index => $car): ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 car-item <?= $index >= 8 ? 'd-none' : '' ?>">
                                    <div class="card car-card p-0 h-100 shadow-lg rounded-3 overflow-hidden">
                                        <!-- Hình ảnh xe -->
                                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                                            <img loading="lazy" src="<?= htmlspecialchars(!empty($car["normal_image_url"]) ? $car["normal_image_url"] : '/uploads/cars/default.jpg') ?>"
                                                class="card-img-top car-image"
                                                alt="<?= htmlspecialchars($car['name']) ?>"
                                                style="height: 200px; object-fit: cover; transition: transform 0.3s ease-in-out;">
                                        </a>

                                        <div class="card-body text-center bg-dark text-light">
                                            <h5 class="card-title fw-bold mb-3" style="height: 60px;">
                                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-decoration-none text-light">
                                                    <?= htmlspecialchars($car['name']) ?>
                                                </a>
                                            </h5>
                                            <p class="card-text fw-bold">
                                                <i class="fas fa-money-bill-wave me-1"></i>
                                                <?= number_format($car['price'], 0, ',', '.') ?> VNĐ
                                            </p>
                                            <p class="card-text text-light">
                                                <i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?> |
                                                <i class="fas fa-car"></i> <?= htmlspecialchars($car['category_name']) ?>
                                            </p>

                                            <!-- Phần nút hành động -->
                                            <div class="row mt-3 g-3">
                                                <!-- Nút Đặt mua -->
                                                <div class="col-md-6">
                                                    <form action="/OrderForm" method="POST">
                                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']); ?>">
                                                        <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center shadow-sm rounded-3 hover-scale px-4 py-2">
                                                            <i class="fas fa-shopping-cart me-2"></i> <span>Đặt mua</span>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Nút So sánh -->
                                                <div class="col-md-6">
                                                    <form action="/compare" method="POST">
                                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                                        <button type="submit" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center shadow-sm rounded-3 hover-scale px-4 py-2">
                                                            <i class="fas fa-plus-circle me-2"></i> <span>So sánh</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (count($cars) > 8): ?>
                            <div class="text-center mt-5 pt-2">
                                <button id="loadMoreCars" class="btn btn-primary">
                                    <i class="bi bi-chevron-down me-1"></i> <span>Xem thêm</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-warning text-center" role="alert">
                            ⚠️ Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm của bạn.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php require_once __DIR__ . '/../../views/used_cars/list_used_cars.php'; ?>

            <?php require_once __DIR__ . '/../../views/news/news.php' ?>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>

<script>
    const loadMoreBtn = document.getElementById('loadMoreCars');
    const carItems = document.querySelectorAll('.car-item');
    const batchSize = 8;
    let visibleCount = batchSize;
    let isExpanded = false;

    if (loadMoreBtn) {
        const icon = loadMoreBtn.querySelector('i');
        const label = loadMoreBtn.querySelector('span');

        loadMoreBtn.addEventListener('click', function() {
            if (!isExpanded) {
                for (let i = visibleCount; i < carItems.length; i++) {
                    carItems[i].classList.remove('d-none');
                }
                isExpanded = true;
                icon.className = 'bi bi-chevron-up me-1';
                label.textContent = 'Thu gọn';
            } else {
                for (let i = batchSize; i < carItems.length; i++) {
                    carItems[i].classList.add('d-none');
                }
                isExpanded = false;
                icon.className = 'bi bi-chevron-down me-1';
                label.textContent = 'Xem thêm';
            }
        });
    }
</script>