<div class="mt-4 bg-light rounded-4 shadow p-4 border z-0">
    <?php if (!empty($cars)): ?>
        <div class="row g-4" id="car-list-container">
            <?php foreach ($cars as $index => $car): ?>
                <div class="col-12 col-lg-6 car-item <?= $index >= 4 ? 'd-none' : '' ?>">
                    <div class="card car-card shadow-lg rounded-3 overflow-hidden d-flex flex-row flex-wrap h-100">
                        <div class="car-img-container" style="flex: 1 1 40%; min-width: 220px;">
                            <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>">
                                <img loading="lazy"
                                    src="<?= htmlspecialchars($car["normal_image_url"] ?? '/public/uploads/cars/default.jpg') ?>"
                                    alt="<?= htmlspecialchars($car['name']) ?>"
                                    class="w-100 h-100 object-fit-cover"
                                    style="object-fit: cover; height: 100%; max-height: 200px;">
                            </a>
                        </div>

                        <div class="card-body bg-dark text-light d-flex flex-column justify-content-between" style="flex: 1 1 60%;">
                            <div class="text-center text-lg-start">
                                <h5 class="card-title fw-bold mb-2" style="min-height: 40px;">
                                    <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-decoration-none text-light">
                                        <?= htmlspecialchars($car['name']) ?>
                                    </a>
                                </h5>
                                <p class="card-text fw-bold mb-2">
                                    <i class="fas fa-money-bill-wave me-1"></i>
                                    <?= number_format($car['price'], 0, ',', '.') ?> VNĐ
                                </p>
                                <p class="card-text small mb-2">
                                    <i class="fas fa-gas-pump me-1"></i> <?= htmlspecialchars($car['fuel_type']) ?> |
                                    <i class="fas fa-car me-1"></i> <?= htmlspecialchars($car['category_name']) ?>
                                </p>
                            </div>

                            <div class="row mt-3 g-2">
                                <div class="col-6">
                                    <?php if ($car['stock'] > 0): ?>
                                        <form action="/OrderForm" method="POST">
                                            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                            <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center px-2 py-2">
                                                <i class="fas fa-shopping-cart me-2"></i> <span>Đặt mua</span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="text-danger fw-semibold text-center small">
                                            <i class="fas fa-truck-loading me-1"></i> Đang nhập hàng
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-6">
                                    <form action="/compare" method="POST">
                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                                        <button type="submit" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center px-2 py-2">
                                            <i class="fas fa-plus-circle me-2"></i> <span>So sánh</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (count($cars) > 4): ?>
                <div class="text-center mt-5 pt-2 d-flex justify-content-center gap-2 w-100">
                    <button id="loadMoreCars" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-chevron-down me-1"></i> <span>Xem thêm</span>
                    </button>
                    <button id="collapseCars" class="btn btn-outline-secondary d-none d-flex align-items-center">
                        <i class="bi bi-chevron-up me-1"></i> <span>Thu gọn</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            ⚠️ Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm của bạn.
        </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Khởi động lần đầu
        if (typeof window.resetCarListAfterFilter === 'function') {
            window.resetCarListAfterFilter();
        }
    });

    // ✅ Định nghĩa lại hàm này sau khi innerHTML thay đổi
    window.resetCarListAfterFilter = function() {
        const batchSize = 4;
        let visibleCount = batchSize;

        const loadMoreBtn = document.getElementById('loadMoreCars');
        const collapseBtn = document.getElementById('collapseCars');
        const getCarItems = () => document.querySelectorAll('.car-item');

        const updateVisibility = () => {
            const carItems = getCarItems();
            carItems.forEach((item, index) => {
                item.classList.toggle('d-none', index >= visibleCount);
            });

            if (visibleCount >= carItems.length) {
                loadMoreBtn?.classList.add('d-none');
            } else {
                loadMoreBtn?.classList.remove('d-none');
            }

            collapseBtn?.classList.toggle('d-none', visibleCount <= batchSize);
        };

        // Gắn lại sự kiện (vì nút mới render lại nên phải gắn lại)
        if (loadMoreBtn && collapseBtn) {
            loadMoreBtn.onclick = () => {
                visibleCount += batchSize;
                updateVisibility();
            };

            collapseBtn.onclick = () => {
                visibleCount = batchSize;
                updateVisibility();

                const firstCar = document.querySelector('.car-item');
                if (firstCar) {
                    window.scrollTo({
                        top: firstCar.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            };
        }

        // Hiển thị ban đầu
        updateVisibility();
    };
</script>