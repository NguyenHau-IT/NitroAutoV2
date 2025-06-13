<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
        <h2 class="text-center mb-4"><i class="bi bi-car-front me-2 text-primary"></i>Danh sách đăng ký lái thử</h2>

        <!-- Bộ lọc trạng thái -->
        <div class="btn-group mb-3 sticky-top bg-light py-2 shadow-sm rounded-3 px-3" role="group" style="z-index: 1020;">
            <button class="btn btn-outline-secondary" onclick="filterTestDrives('all')"><i class="bi bi-list-ul me-1"></i> Tất cả</button>
            <button class="btn btn-outline-warning" onclick="filterTestDrives('pending')"><i class="bi bi-hourglass me-1"></i> Đang chờ</button>
            <button class="btn btn-outline-info" onclick="filterTestDrives('confirmed')"><i class="bi bi-check2-circle me-1"></i> Đã xác nhận</button>
            <button class="btn btn-outline-success" onclick="filterTestDrives('completed')"><i class="bi bi-check-circle me-1"></i> Hoàn thành</button>
            <button class="btn btn-outline-danger" onclick="filterTestDrives('cancelled')"><i class="bi bi-x-circle me-1"></i> Đã hủy</button>
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

        <!-- Tùy chỉnh ngày -->
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

        <!-- Danh sách đăng ký -->
        <div id="testdrive-list" class="border rounded px-2 py-3" style="min-height: 600px; max-height: 1200px; overflow-y: auto;">
            <div id="no-result-message" class="alert alert-warning text-center d-none">
                <i class="bi bi-emoji-frown"></i> Không có đăng ký nào phù hợp với bộ lọc.
            </div>

            <?php foreach ($testDrives as $drive): ?>
                <?php
                $status = isset($drive['status']) ? strtolower($drive['status']) : 'unknown';
                $preferredDate = isset($drive['preferred_date']) ? $drive['preferred_date'] : '';
                ?>
                <div class="card mb-3 testdrive-card <?= $status ?>" data-date="<?= $preferredDate ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h2 class="card-title mb-0">Mã đăng ký #<?= $drive['id'] ?></h2>
                            </div>
                            <?php
                                $map = [
                                    'pending' => ['warning', 'bi-hourglass', 'Đang chờ'],
                                    'confirmed' => ['info', 'bi-check2-circle', 'Đã xác nhận'],
                                    'completed' => ['success', 'bi-check-circle', 'Hoàn thành'],
                                    'cancelled' => ['danger', 'bi-x-circle', 'Đã hủy'],
                                ];
                                $badge = $map[$status] ?? ['secondary', 'bi-question-circle', 'Không xác định'];
                                ?>
                                <span class="badge bg-<?= $badge[0] ?>">
                                    <i class="bi <?= $badge[1] ?> me-1"></i> <?= $badge[2] ?>
                                </span>
                        </div>

                        <div class="row">
                            <div class="col-md-6"><strong>Người đăng ký:</strong> <?= htmlspecialchars($drive['full_name']) ?></div>
                            <div class="col-md-6"><strong>Xe:</strong> <?= htmlspecialchars($drive['car_name']) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><strong>Ngày lái thử:</strong> <?= !empty($drive['preferred_date']) ? date('d/m/Y', strtotime($drive['preferred_date'])) : '---' ?></div>
                            <div class="col-md-6"><strong>Giờ:</strong> <?= !empty($drive['preferred_time']) ? date('H:i', strtotime($drive['preferred_time'])) : '---' ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><strong>Địa điểm:</strong> <?= htmlspecialchars($drive['location']) ?></div>
                            <div class="col-md-6">
                                <strong>Ngày đăng ký:</strong>
                                <span data-bs-toggle="tooltip" title="<?= date('H:i:s', strtotime($drive['created_at'])) ?>">
                                    <?= date('d/m/Y', strtotime($drive['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Script lọc -->
<script>
    const dateRange = document.getElementById('date-range');
    const customRange = document.getElementById('custom-date-range');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const cards = document.querySelectorAll('.testdrive-card');
    const noResultMessage = document.getElementById('no-result-message');

    let currentStatus = 'all';

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

        let visible = 0;
        cards.forEach(card => {
            const cardDate = new Date(card.dataset.date + 'T00:00:00');
            const matchesStatus = currentStatus === 'all' || card.classList.contains(currentStatus);
            const matchesDate = !start || (cardDate >= start && cardDate <= end);
            const show = matchesStatus && matchesDate;
            card.style.display = show ? 'block' : 'none';
            if (show) visible++;
        });

        if (noResultMessage) {
            noResultMessage.classList.toggle('d-none', visible > 0);
        }
    }

    window.filterTestDrives = function(status) {
        currentStatus = status;
        applyFilter();
    }

    dateRange.addEventListener('change', () => {
        customRange.style.display = dateRange.value === 'custom' ? 'flex' : 'none';
        if (dateRange.value !== 'custom') applyFilter();
    });
    startDate.addEventListener('change', () => startDate.value && endDate.value && applyFilter());
    endDate.addEventListener('change', () => startDate.value && endDate.value && applyFilter());

    // Bootstrap tooltip
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>