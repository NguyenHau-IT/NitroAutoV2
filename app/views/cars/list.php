<div class="mt-4 bg-light rounded-4 shadow p-4 border z-0">
    <?php if (!empty($cars)): ?>
        <div class="row g-4 justify-content-center" id="car-list-container">
            <?php foreach ($cars as $index => $car): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 car-item <?= $index >= 8 ? 'd-none' : '' ?>">
                    <div class="card car-card p-0 h-100 shadow-lg rounded-3 overflow-hidden">
                        <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="car-img-container">
                            <img loading="lazy"
                                src="<?= htmlspecialchars($car["normal_image_url"] ?? '/public/uploads/cars/default.jpg') ?>"
                                class="card-img-top car-image"
                                alt="<?= htmlspecialchars($car['name']) ?>"
                                style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body text-center bg-dark text-light">
                            <h5 class="card-title fw-bold mb-3" style="height: 60px;">
                                <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>"
                                    class="text-decoration-none text-light">
                                    <?= htmlspecialchars($car['name']) ?>
                                </a>
                            </h5>
                            <p class="card-text fw-bold">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                <?= number_format($car['price'], 0, ',', '.') ?> VNĐ
                            </p>
                            <p class="card-text">
                                <i class="fas fa-gas-pump"></i> <?= htmlspecialchars($car['fuel_type']) ?> |
                                <i class="fas fa-car"></i> <?= htmlspecialchars($car['category_name']) ?>
                            </p>
                            <div class="row mt-3 g-3">
                                <!-- Nút đặt mua -->
                                <div class="col-md-6">
                                    <?php if ($car['stock'] > 0): ?>
                                        <form action="/OrderForm" method="POST">
                                            <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']); ?>">
                                            <button type="submit" class="btn btn-success w-100 d-flex align-items-center justify-content-center shadow-sm rounded-3 hover-scale px-4 py-2">
                                                <i class="fas fa-shopping-cart me-2"></i> <span>Đặt mua</span>
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <div class="text-danger fw-semibold text-center mt-2">
                                            <i class="fas fa-truck-loading me-1"></i> Xe hiện đang nhập hàng
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- Nút so sánh -->
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

        <!-- Nút xem thêm & thu gọn -->
        <?php if (count($cars) > 8): ?>
            <div class="text-center mt-5 pt-2 d-flex justify-content-center gap-2">
                <button id="loadMoreCars" class="btn btn-primary d-flex align-items-center">
                    <i class="bi bi-chevron-down me-1"></i> <span>Xem thêm</span>
                </button>
                <button id="collapseCars" class="btn btn-outline-secondary d-none d-flex align-items-center">
                    <i class="bi bi-chevron-up me-1"></i> <span>Thu gọn</span>
                </button>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            ⚠️ Không tìm thấy xe nào phù hợp với tiêu chí tìm kiếm của bạn.
        </div>
    <?php endif; ?>
</div>

<!-- Script xử lý hiển thị -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const loadMoreBtn = document.getElementById('loadMoreCars');
        const collapseBtn = document.getElementById('collapseCars');
        const carItems = document.querySelectorAll('.car-item');
        const batchSize = 8;
        let visibleCount = batchSize;

        function updateVisibility() {
            carItems.forEach((item, index) => {
                item.classList.toggle('d-none', index >= visibleCount);
            });
        }

        if (loadMoreBtn && collapseBtn) {
            loadMoreBtn.addEventListener('click', () => {
                visibleCount += batchSize;
                if (visibleCount >= carItems.length) {
                    visibleCount = carItems.length;
                    loadMoreBtn.classList.add('d-none');
                }
                updateVisibility();
                collapseBtn.classList.remove('d-none');
            });

            collapseBtn.addEventListener('click', () => {
                visibleCount = batchSize;
                updateVisibility();
                loadMoreBtn.classList.remove('d-none');
                collapseBtn.classList.add('d-none');

                // Scroll to top of car list (optional)
                const firstCar = document.querySelector('.car-item');
                if (firstCar) {
                    window.scrollTo({
                        top: firstCar.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        }
    });
</script>