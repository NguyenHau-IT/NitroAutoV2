<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 mb-5 bg-light p-4 rounded-4 shadow-lg">
        <h2 class="text-center mb-4 fs-3 fw-bold text-success">🧾 Xác nhận đơn hàng</h2>

        <form action="/check_out_selected_process" method="post">

            <!-- Danh sách sản phẩm -->
            <div class="mb-4">
                <?php $total = 0; ?>
                <?php foreach ($selectedItems as $item): ?>
                    <?php
                        $itemTotal = $item['accessory_price'] * $item['quantity'];
                        $total += $itemTotal;
                    ?>
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="mb-2 mb-md-0">
                                <h5 class="mb-1"><?= htmlspecialchars($item['accessory_name']) ?></h5>
                                <div class="text-muted">Giá: <span class="text-primary"><?= number_format($item['accessory_price'], 0, ',', '.') ?> VNĐ</span></div>
                                <div>Số lượng: <?= $item['quantity'] ?></div>
                                <input type="hidden" name="selected_ids[]" value="<?= $item['id'] ?>">
                                <input type="hidden" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>">
                            </div>
                            <div class="text-success fw-bold fs-5 text-end">
                                <?= number_format($itemTotal, 0, ',', '.') ?> VNĐ
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Tổng tiền -->
            <div class="text-end fs-5 mb-4">
                <strong class="text-dark fw-semibold">Tổng tiền:</strong>
                <span class="text-danger fw-bold fs-4"><?= number_format($total, 0, ',', '.') ?> VNĐ</span>
            </div>

            <!-- Thông tin nhận hàng -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <label for="address" class="text-dark form-label fw-semibold">📍 Địa chỉ nhận hàng</label>
                    <input type="text" name="address" id="address" class="form-control fs-5" placeholder="Nhập địa chỉ" required>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="text-dark form-label fw-semibold">📞 Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control fs-5" placeholder="Nhập số điện thoại" required>
                </div>
            </div>

            <!-- Hành động -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="/cart" class="btn btn-outline-secondary fs-5">
                    <i class="bi bi-arrow-left-circle me-1"></i> Quay lại giỏ hàng
                </a>
                <button type="submit" class="btn btn-success fs-5 px-4">
                    <i class="bi bi-bag-check-fill me-1"></i> Xác nhận đặt hàng
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
