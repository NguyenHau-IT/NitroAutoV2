<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
        <h2 class="text-center mb-4"><i class="bi bi-calendar-check-fill text-primary me-2"></i>Danh sách lịch hẹn</h2>

        <!-- Bộ lọc trạng thái -->
        <div class="btn-group mb-3 sticky-top bg-light py-2 shadow-sm rounded-3 px-2" role="group" style="z-index: 1020;">
            <button class="btn btn-outline-secondary" onclick="filterOrders('all')" data-status="Tất cả">
                <i class="bi bi-list-check me-1"></i> Tất cả
            </button>
            <button class="btn btn-outline-warning" onclick="filterOrders('pending')" data-status="Đang chờ">
                <i class="bi bi-clock-history me-1"></i> Đang chờ
            </button>
            <button class="btn btn-outline-primary" onclick="filterOrders('approved')" data-status="Đã duyệt">
                <i class="bi bi-patch-check-fill me-1"></i> Đã duyệt
            </button>
            <button class="btn btn-outline-success" onclick="filterOrders('completed')" data-status="Hoàn thành">
                <i class="bi bi-check-circle-fill me-1"></i> Hoàn thành
            </button>
            <button class="btn btn-outline-danger" onclick="filterOrders('cancelled')" data-status="Đã hủy">
                <i class="bi bi-x-circle-fill me-1"></i> Đã hủy
            </button>
        </div>

        <!-- Hiển thị trạng thái đang lọc -->
        <div id="active-status-label" class="text-muted mb-3">
            <i class="bi bi-eye-fill me-1"></i> Đang hiển thị: <span class="fw-bold">Tất cả</span>
        </div>

        <!-- Bộ lọc thời gian -->
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

        <!-- Danh sách lịch hẹn -->
        <div id="order-list" class="border rounded px-2 py-3" style="min-height: 600px; max-height: 1200px; overflow-y: auto;">
            <div id="no-result-message" class="alert alert-warning text-center d-none">
                <i class="bi bi-emoji-frown"></i> Không có lịch hẹn nào phù hợp với bộ lọc.
            </div>

            <?php foreach ($orders as $order): ?>
                <div class="card mb-3 order-card <?= strtolower($order['status']) ?>" data-date="<?= date('Y-m-d', strtotime($order['order_date'])) ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-wrench-adjustable-circle me-2 text-success"></i>
                                <?= htmlspecialchars($order['car_name']) ?>
                            </h5>
                            <?php
                            $status = strtolower($order['status']);
                            $badge = [
                                'pending'   => '<span class="badge bg-warning text-dark">Đang chờ</span>',
                                'approved'  => '<span class="badge bg-primary">Đã duyệt</span>',
                                'completed' => '<span class="badge bg-success">Hoàn thành</span>',
                                'cancelled' => '<span class="badge bg-danger">Đã hủy</span>',
                            ];
                            echo $badge[$status] ?? '<span class="badge bg-secondary">Không rõ</span>';
                            ?>
                        </div>

                        <p class="mb-1"><strong>Giá dịch vụ:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VNĐ</p>
                        <?php if (!empty($order['note'])): ?>
                            <p class="mb-1"><strong>Ghi chú:</strong> <?= htmlspecialchars($order['note']) ?></p>
                        <?php endif; ?>
                        <p class="mb-0">
                            <strong>Ngày đặt:</strong>
                            <span data-bs-toggle="tooltip" title="<?= date('H:i:s', strtotime($order['order_date'])) ?>">
                                <?= date('d/m/Y', strtotime($order['order_date'])) ?>
                            </span>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    const dateRange = document.getElementById('date-range');
    const customRange = document.getElementById('custom-date-range');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const orderCards = document.querySelectorAll('.order-card');
    const noResultMessage = document.getElementById('no-result-message');
    const activeStatusLabel = document.getElementById('active-status-label').querySelector('span');
    const filterButtons = document.querySelectorAll('[onclick^="filterOrders"]');

    let currentStatus = 'all';

    function highlightActiveButton(status) {
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        const activeBtn = document.querySelector(`[onclick="filterOrders('${status}')"]`);
        if (activeBtn) activeBtn.classList.add('active');
    }

    window.filterOrders = function(status) {
        currentStatus = status;
        const btn = document.querySelector(`[onclick="filterOrders('${status}')"]`);
        if (btn) {
            activeStatusLabel.textContent = btn.getAttribute('data-status');
        }
        highlightActiveButton(status);
        applyFilter();
    };

    dateRange.addEventListener('change', function() {
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

        noResultMessage.classList.toggle('d-none', visibleCount > 0);
    }

    applyFilter();

    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(el => new bootstrap.Tooltip(el));
</script>

<?php require_once 'includes/footer.php'; ?>