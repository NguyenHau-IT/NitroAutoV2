<div class="mt-4 bg-info-subtle rounded-4 shadow p-4 border">
    <h2 class="text-center mb-4 text-primary-emphasis fw-bold">
        <i class="bi bi-tools"></i> Phụ kiện dành cho xe
    </h2>

    <?php if (empty($accessories)): ?>
        <div class="alert alert-warning text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Không tìm thấy phụ kiện nào phù hợp với tiêu chí tìm kiếm của bạn.
        </div>
    <?php else: ?>
        <div class="d-flex overflow-auto gap-3 px-2 py-3" style="scroll-snap-type: x mandatory;">
            <?php foreach ($accessories as $item): ?>
                <div class="card flex-shrink-0 shadow-sm rounded-4 border-0" style="min-width: 250px; scroll-snap-align: start;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary-emphasis fw-semibold">
                            <i class="bi bi-box"></i> <?= htmlspecialchars($item['name']) ?>
                        </h5>
                        <p class="card-text text-muted small mb-2">
                            <?= htmlspecialchars(mb_strimwidth($item['description'], 0, 70, '...')) ?>
                        </p>
                        <p class="fw-bold text-success fs-6">
                            <i class="bi bi-currency-dollar"></i> <?= number_format($item['price'], 0, ',', '.') ?> VNĐ
                        </p>
                        <div class="mt-auto">
                            <a href="/add_to_cart/<?= $item['id'] ?>" class="btn btn-success btn-sm w-100">
                                <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
