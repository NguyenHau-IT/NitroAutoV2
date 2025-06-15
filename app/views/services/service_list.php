    <?php require_once 'includes/header.php'; ?>

    <div class="overlay">
        <div class="container text-dark mt-2 mb-4 bg-light text-primary shadow rounded-4 p-4">
            <h2 class="text-center mb-4"><i class="bi bi-tools me-2"></i>Dịch vụ ô tô</h2>

            <div class="row mt-2">
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary">
                                        <i class="bi bi-gear-wide-connected me-1"></i> <?= htmlspecialchars($service['ServiceName']) ?>
                                    </h5>
                                    <p class="card-text text-muted small mb-2">
                                        <?= htmlspecialchars($service['Description']) ?>
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge bg-success">
                                            <i class="bi bi-currency-dollar me-1"></i>
                                            <?= number_format($service['Price'], 0, ',', '.') ?> đ
                                        </span>
                                        <span class="badge bg-info text-dark ms-2">
                                            <i class="bi bi-clock me-1"></i>
                                            <?= $service['EstimatedTime'] ?> phút
                                        </span>
                                    </div>
                                    <div class="mt-auto">
                                        <form action="/order_service_form" method="post">
                                            <input type="hidden" name="service_id" value="<?= $service['ServiceID'] ?>">
                                            <button type="submit" class="btn btn-primary w-100 mt-2">
                                                <i class="bi bi-calendar-check me-1"></i> Đặt lịch hẹn
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Hiện chưa có dịch vụ nào được hiển thị.
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