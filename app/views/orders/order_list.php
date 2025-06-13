<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
        <h2 class="text-center mb-4"><i class="bi bi-receipt-cutoff me-2 text-primary"></i>Danh sách đơn hàng</h2>

        <!-- Bộ lọc trạng thái -->
        <div class="btn-group mb-3 sticky-top bg-light py-2 shadow-sm rounded-3 px-3" role="group" style="z-index: 1020;">
            <button class="btn btn-outline-secondary" onclick="filterOrders('all')">
                <i class="bi bi-list-ul me-1"></i> Tất cả
            </button>
            <button class="btn btn-outline-warning" onclick="filterOrders('pending')">
                <i class="bi bi-hourglass-split me-1"></i> Đang chờ
            </button>
            <button class="btn btn-outline-info" onclick="filterOrders('confirmed')">
                <i class="bi bi-check2-circle me-1"></i> Đã xác nhận
            </button>
            <button class="btn btn-outline-primary" onclick="filterOrders('shipped')">
                <i class="bi bi-truck me-1"></i> Đang giao
            </button>
            <button class="btn btn-outline-success" onclick="filterOrders('completed')">
                <i class="bi bi-check-circle-fill me-1"></i> Hoàn thành
            </button>
            <button class="btn btn-outline-danger" onclick="filterOrders('canceled')">
                <i class="bi bi-x-octagon-fill me-1"></i> Đã hủy
            </button>
        </div>

        <!-- Lọc theo ngày -->
        <div class="mb-3">
            <label for="date-range" class="form-label">Chọn khoảng thời gian:</label>
            <select id="date-range" class="form-select">
                <option value="none" selected>-- Lọc theo ngày --</option>
                <option value="today">Hôm nay</option>
                <option value="last_week">Tuần này</option>
                <option value="this_month">Tháng này</option>
                <option value="last_5_days">5 ngày qua</option>
                <option value="custom">Tùy chỉnh</option>
            </select>
        </div>

        <!-- Ngày bắt đầu / kết thúc -->
        <div id="custom-date-range" class="row g-3 mb-3" style="display: none;">
            <div class="col-md-6">
                <label for="start-date" class="form-label">Ngày bắt đầu:</label>
                <input type="date" id="start-date" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="end-date" class="form-label">Ngày kết thúc:</label>
                <input type="date" id="end-date" class="form-control">
            </div>
        </div>

        <!-- Danh sách đơn hàng -->
        <div id="order-list" class="border rounded px-2 py-3" style="min-height: 600px; max-height: 1200px; overflow-y: auto;">
            <div id="no-result-message" class="alert alert-warning text-center d-none">
                <i class="bi bi-emoji-frown"></i> Không có đơn hàng nào phù hợp với bộ lọc.
            </div>

            <?php foreach ($groupedOrders as $order): ?>
                <div class="card mb-3 order-card <?= strtolower($order['status']) ?>"
                     data-date="<?= date('Y-m-d', strtotime($order['order_date'])) ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="card-title mb-0">Đơn hàng #<?= $order['order_id'] ?></h5>
                                <?php
                                    $status = strtolower($order['status']);
                                    $map = [
                                        'pending' => ['warning', 'bi-hourglass-split', 'Đang chờ xử lý'],
                                        'confirmed' => ['info', 'bi-check2-circle', 'Đã xác nhận'],
                                        'shipped' => ['primary', 'bi-truck', 'Đang giao'],
                                        'completed' => ['success', 'bi-check-circle-fill', 'Đã hoàn thành'],
                                        'canceled' => ['danger', 'bi-x-circle-fill', 'Đã hủy'],
                                    ];
                                    $badge = $map[$status] ?? ['secondary', 'bi-question-circle', 'Không xác định'];
                                ?>
                                <span class="badge bg-<?= $badge[0] ?>">
                                    <i class="bi <?= $badge[1] ?> me-1"></i> <?= $badge[2] ?>
                                </span>
                            </div>
                            <a href="/order_detail/<?= $order['order_id'] ?>" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-eye-fill"></i> Xem chi tiết
                            </a>
                        </div>

                        <!-- Danh sách sản phẩm -->
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="row border-bottom py-1">
                                <?php if (!empty($item['car_name'])): ?>
                                    <div class="col-md-6"><strong>Xe:</strong> <?= htmlspecialchars($item['car_name']) ?></div>
                                    <div class="col-md-6"><strong>Số lượng:</strong> <?= htmlspecialchars($item['quantity']) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($item['accessory_name'])): ?>
                                    <div class="col-md-6"><strong>Phụ kiện:</strong> <?= htmlspecialchars($item['accessory_name']) ?></div>
                                    <div class="col-md-6"><strong>Số lượng:</strong> <?= htmlspecialchars($item['accessory_quantity']) ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <div class="row mt-2">
                            <div class="col-md-6"><strong>Tổng giá:</strong> <?= number_format($order['total_price']) ?> VNĐ</div>
                            <div class="col-md-6">
                                <strong>Ngày đặt:</strong>
                                <span data-bs-toggle="tooltip" title="Giờ đặt: <?= date('H:i:s', strtotime($order['order_date'])) ?>">
                                    <?= date('d/m/Y', strtotime($order['order_date'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Script lọc đơn hàng -->
<script>
    const dateRange = document.getElementById('date-range');
    const customRange = document.getElementById('custom-date-range');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const orderCards = document.querySelectorAll('.order-card');
    const noResultMessage = document.getElementById('no-result-message');

    if (dateRange && customRange && startDate && endDate && orderCards.length > 0) {
        let currentStatus = 'all';

        window.filterOrders = function (status) {
            currentStatus = status;
            applyFilter();
        };

        dateRange.addEventListener('change', function () {
            customRange.style.display = this.value === 'custom' ? 'flex' : 'none';
            if (this.value !== 'custom') applyFilter();
        });

        startDate.addEventListener('change', () => {
            if (startDate.value && endDate.value) applyFilter();
        });
        endDate.addEventListener('change', () => {
            if (startDate.value && endDate.value) applyFilter();
        });

        function applyFilter() {
            const selectedRange = dateRange.value;
            const now = new Date();
            let start = null;
            let end = new Date();

            if (selectedRange === 'today') {
                start = new Date();
                start.setHours(0, 0, 0, 0);
            } else if (selectedRange === 'last_week') {
                start = new Date();
                start.setDate(now.getDate() - 7);
            } else if (selectedRange === 'this_month') {
                start = new Date(now.getFullYear(), now.getMonth(), 1);
            } else if (selectedRange === 'last_5_days') {
                start = new Date();
                start.setDate(now.getDate() - 5);
            } else if (selectedRange === 'custom') {
                if (startDate.value && endDate.value) {
                    start = new Date(startDate.value);
                    end = new Date(endDate.value);
                    end.setHours(23, 59, 59, 999);
                }
            }

            let visibleCount = 0;
            orderCards.forEach(card => {
                const cardDateStr = card.getAttribute('data-date');
                const cardDate = new Date(cardDateStr + 'T00:00:00');
                const matchesStatus = (currentStatus === 'all') || card.classList.contains(currentStatus);
                const matchesDate = !start || (cardDate >= start && cardDate <= end);
                const show = matchesStatus && matchesDate;
                card.style.display = show ? 'block' : 'none';
                if (show) visibleCount++;
            });

            if (noResultMessage) {
                noResultMessage.classList.toggle('d-none', visibleCount > 0);
            }
        }

        applyFilter();
    }

    // Bootstrap tooltip
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(el => new bootstrap.Tooltip(el));
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
