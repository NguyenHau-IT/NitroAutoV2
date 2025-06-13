<?php if (!empty($histories)): ?>
    <div class="mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-warning mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        <?= ($_SESSION["user"]["gender"] == 1 ? 'Anh' : 'Chị') ?> <?= htmlspecialchars($_SESSION["user"]["full_name"] ?? 'Không xác định') ?> đã xem
                    </h5>

                    <form action="/clear_history/<?= $_SESSION["user"]["id"] ?>" method="POST" class="m-0">
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash3-fill me-1"></i> Xoá tất cả
                        </button>
                    </form>
                </div>

                <!-- Danh sách cuộn ngang -->
                <div class="d-flex flex-nowrap overflow-auto gap-3 pb-1">
                    <?php foreach ($histories as $history): ?>
                        <div class="card flex-shrink-0 border shadow-sm d-flex flex-row align-items-center px-2" style="width: 300px; max-width: 100%; min-height: 100px;">
                            <!-- Hình ảnh -->
                            <div style="width: 90px;">
                                <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>">
                                    <img src="<?= htmlspecialchars($history['image_url'] ?? '/uploads/cars/default.jpg') ?>"
                                        alt="<?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>"
                                        class="rounded" style="width: 100%; height: 90px; object-fit: cover;" loading="lazy">
                                </a>
                            </div>

                            <!-- Nội dung bên phải -->
                            <div class="d-flex flex-column justify-content-center ps-3 w-100">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="mb-1 text-truncate" style="max-width: 160px;">
                                        <a href="/car_detail/<?= htmlspecialchars($history['car_id']) ?>"
                                            class="text-decoration-none text-dark fw-semibold">
                                            <?= htmlspecialchars($history['car_name'] ?? 'Không xác định') ?>
                                        </a>
                                    </h6>
                                    <!-- Nút xoá -->
                                    <a href="/remove_history/<?= htmlspecialchars($history['hvc_id'] ?? '') ?>"
                                        class="btn btn-sm btn-light border rounded-circle ms-2 mt-1"
                                        aria-label="Xoá" title="Xoá"
                                        style="line-height: 1; padding: 2px 6px;">
                                        <i class="bi bi-x-lg small text-danger"></i>
                                    </a>
                                </div>
                                <!-- Badge còn hàng -->
                                <span class="badge <?= ($history['stock'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' ?> mt-1" style="width: fit-content;">
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