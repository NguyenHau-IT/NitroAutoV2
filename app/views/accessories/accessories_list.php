<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 mb-5 bg-light  text-primary  rounded-4 shadow-lg p-4">
        <h2 class="mb-4 text-center"><i class="bi bi-nut me-2"></i>Danh sách phụ kiện cho xe</h2>

        <div class="row">
            <?php if (!empty($accessories)): ?>
                <?php foreach ($accessories as $accessory): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm rounded-4 border-0">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary">
                                    <i class="bi bi-box-seam me-1"></i> <?= htmlspecialchars($accessory['name']) ?>
                                </h5>
                                <p class="card-text text-muted small"><?= htmlspecialchars($accessory['description']) ?></p>
                                <p class="mt-auto fw-bold text-success fs-5">
                                    <i class="bi bi-currency-dollar me-1"></i><?= number_format($accessory['price'], 0, ',', '.') ?> VNĐ
                                </p>
                                <a href="/add_to_cart/<?= $accessory['id'] ?>" class="btn btn-success w-100 mt-2">
                                    <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ hàng
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-1"></i> Hiện chưa có phụ kiện nào để hiển thị.
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-end mt-4">
            <a href="/home" class="btn btn-danger">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
