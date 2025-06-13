<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
        <h2 class="text-center mb-4">
            <i class="bi bi-heart-fill text-danger me-2"></i>
            Danh sách yêu thích của <?= htmlspecialchars($user['full_name']) ?>
        </h2>

        <?php if (empty($favorites)): ?>
            <div class="alert alert-info text-center fs-5">
                <i class="bi bi-info-circle-fill me-2"></i>Không có xe nào trong danh sách yêu thích.
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($favorites as $favorite): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <i class="bi bi-car-front-fill me-1 text-primary"></i>
                                    <?= htmlspecialchars($favorite['car_name']) ?>
                                </h5>
                                <div class="d-flex flex-wrap gap-2 mt-3">
                                    <a href="/favarite_delete/<?= $favorite['id'] ?>" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Xóa
                                    </a>
                                    <a href="/car_detail/<?= $favorite['car_id'] ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye-fill"></i> Xem chi tiết
                                    </a>
                                    <form action="/OrderForm" method="POST" class="d-inline">
                                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($favorite['car_id']) ?>">
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-cart-check-fill"></i> Đặt mua
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-end mt-4">
            <a href="/home" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại trang chủ
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>