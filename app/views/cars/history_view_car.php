<?php if (!empty($histories)): ?>
    <div class="mb-3">
        <div class="card shadow-sm rounded-4">
            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-warning mb-0">
                        <i class="bi bi-clock-history me-1"></i>
                        <?= ($_SESSION["user"]["gender"] == 1 ? 'Anh' : 'Chị') ?> <?= htmlspecialchars($_SESSION["user"]["full_name"] ?? 'Không xác định') ?> đã xem
                    </h6>

                    <form action="/clear_history/<?= $_SESSION["user"]["id"] ?>" method="POST" class="m-0">
                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">
                            <i class="bi bi-trash3-fill me-1"></i> Xoá
                        </button>
                    </form>
                </div>

                <!-- Danh sách cuộn ngang -->
                <div class="d-flex flex-nowrap overflow-auto gap-2 pb-1">
                    <?php foreach ($histories as $history): ?>
                        <div class="card flex-shrink-0 border-0 shadow-sm d-flex flex-row align-items-center p-1" style="width: 260px; min-height: 70px;">
                            <!-- Hình ảnh -->
                            <div style="width: 70px;">
                                <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>">
                                    <img src="<?= htmlspecialchars($history['image_url'] ?? '/uploads/cars/default.jpg') ?>"
                                        alt="<?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>"
                                        class="rounded" style="width: 100%; height: 65px; object-fit: cover;" loading="lazy">
                                </a>
                            </div>

                            <!-- Nội dung -->
                            <div class="ps-2 w-100">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>"
                                       class="text-decoration-none text-dark fw-semibold text-truncate"
                                       style="max-width: 140px;">
                                        <?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>
                                    </a>
                                    <!-- Nút xoá -->
                                    <a href="/remove_history/<?= htmlspecialchars($history['hvc_id'] ?? '') ?>"
                                       class="btn btn-light border rounded-circle ms-1 p-0"
                                       aria-label="Xoá" title="Xoá"
                                       style="width: 22px; height: 22px;">
                                        <i class="bi bi-x-lg small text-danger" style="font-size: 0.65rem;"></i>
                                    </a>
                                </div>
                                <span class="badge <?= ($history['stock'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' ?> small">
                                    <?= ($history['stock'] ?? 0) > 0 ? 'Còn hàng' : 'Hết hàng' ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>